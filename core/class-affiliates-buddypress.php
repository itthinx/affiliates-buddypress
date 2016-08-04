<?php
/**
 * class-affiliates-buddypress.php
 *
 * Copyright (c) 2010-2016 "kento" Karim Rahimpur www.itthinx.com
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
 * @author Karim Rahimpur
 * @package affiliates-buddypress
 * @since affiliates-buddypress 1.0.0
 */

/**
 * Affiliates_BuddyPress class
 */
class Affiliates_BuddyPress {

	public static function init() {
		add_action( 'bp_setup_nav', array( __CLASS__, 'bp_setup_nav' ), 100 );
	}

	public static function bp_setup_nav() {
		global $bp;
		 
		bp_core_new_nav_item( array(
				'name'              => __( 'Affiliate Area', 'affiliates-buddypress' ),
				'slug'              => 'affiliate-area',
				'parent_url'        => trailingslashit( bp_displayed_user_domain() . $bp->profile->slug ),
				'parent_slug'       => $bp->profile->slug,
				'screen_function'   => array( __CLASS__, 'add_tab_screen' ),
				'position'          => intval( apply_filters( 'affiliates_buddypress_nav_item_position', 30 ) ),
				'user_has_access'   => bp_is_my_profile(),
				'default_subnav_slug' => 'affiliate-area'
			) 
		);
	}

	public static function add_tab_screen() {
		add_action( 'bp_template_title', array( __CLASS__, 'bp_template_title' ) );
		add_action( 'bp_template_content', array( __CLASS__, 'bp_template_content' ) );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	public static function bp_template_title() {
		echo __( 'Affiliate Area', 'affiliates-buddypress' );
	}

	public static function bp_template_content() {
		$page_id = get_option( 'affiliates-buddypress-page', null );
		if ( $page_id ) {
			$post = get_post( $page_id );
			echo $post->post_content;
		} else {
			echo __( 'It seems that there are not any pages set up for the affiliates yet.', 'affiliates-buddypress' );
		}
	}

}
Affiliates_BuddyPress::init();
