<?php
/**
 * class-affiliates-buddypress.php
 *
 * Copyright (c) 2016 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author itthinx
 * @author eggemplo
 * @author proaktion
 * @package affiliates-buddypress
 * @since affiliates-buddypress 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Affiliates-BuddyPress integration.
 */
class Affiliates_BuddyPress {

	/**
	 * Position of our item in the navigation menu.
	 * @var int
	 */
	const NAV_ITEM_POSITION = 30;

	/**
	 * Adds an action hook on bp_setup_nav to register our profile item.
	 */
	public static function init() {
		$page_id = get_option( 'affiliates-buddypress-page', null );
		if ( $page_id ) {
			add_action( 'bp_setup_nav', array( __CLASS__, 'bp_setup_nav' ), 100 );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wp_enqueue_scripts' ) );
		}
	}

	/**
	 * Registers our front end styles.
	 */
	public static function wp_enqueue_scripts() {
		wp_register_style( 'affiliates-buddypress', AFFILIATES_BUDDYPRESS_PLUGIN_URL . '/css/affiliates-buddypress.css', array(), AFFILIATES_BUDDYPRESS_VERSION );
	}

	/**
	 * Adds a BP navigation item for the Affiliate Area.
	 */
	public static function bp_setup_nav() {
		global $bp;

		$page_id = get_option( 'affiliates-buddypress-page', null );
		if ( $page_id ) {
			$title = get_the_title( $page_id );
			bp_core_new_nav_item(
				array(
					'name'                => $title,
					'slug'                => 'affiliates',
					'parent_url'          => trailingslashit( bp_displayed_user_domain() . $bp->profile->slug ),
					'parent_slug'         => $bp->profile->slug,
					'screen_function'     => array( __CLASS__, 'add_tab_screen' ),
					'position'            => intval( apply_filters( 'affiliates_buddypress_nav_item_position', get_option( 'affiliates-buddypress-page-position', self::NAV_ITEM_POSITION ) ) ),
					'user_has_access'     => bp_is_my_profile(),
					'default_subnav_slug' => 'affiliates'
				)
			);
		}
	}

	/**
	 * Hooks on BP template actions and loads core template.
	 */
	public static function add_tab_screen() {
		add_action( 'bp_template_title', array( __CLASS__, 'bp_template_title' ) );
		add_action( 'bp_template_content', array( __CLASS__, 'bp_template_content' ) );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	/**
	 * Prints the Affiliate Area's template title.
	 */
	public static function bp_template_title() {
		$page_id = get_option( 'affiliates-buddypress-page', null );
		if ( $page_id ) {
			echo get_the_title( $page_id );
		}
	}

	/**
	 * Prints the contents of the affiliate area page.
	 */
	public static function bp_template_content() {
		$page_id = get_option( 'affiliates-buddypress-page', null );
		if ( $page_id ) {
			wp_enqueue_style( 'affiliates-buddypress' );
			$post = get_post( $page_id );
			echo $post->post_content;
		}
	}

}
Affiliates_BuddyPress::init();
