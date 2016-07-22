<?php
/**
 * affiliates-buddypress.php
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
 *
 * Plugin Name: Affiliates Buddypress
 * Plugin URI: http://www.itthinx.com
 * Description: Integrates Affiliates plugin with BuddyPress
 * Version: 1.0
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 * Donate-Link: http://www.itthinx.com
 * Text Domain: affiliates-buddypress
 * Domain Path: /languages
 * License: GPLv3
 */

define( 'AFFILIATES_BUDDYPRESS_PLUGIN_NAME', 'affiliates-buddypress' );

define( 'AFFILIATES_BUDDYPRESS_FILE', __FILE__ );

if ( !defined( 'AFFILIATES_BUDDYPRESS_CORE_DIR' ) ) {
	define( 'AFFILIATES_BUDDYPRESS_CORE_DIR', WP_PLUGIN_DIR . '/affiliates-buddypress/core' );
}

define( 'AFFILIATES_BUDDYPRESS_PLUGIN_URL', plugin_dir_url( AFFILIATES_BUDDYPRESS_FILE ) );

class AffiliatesBuddypress_Plugin {

	private static $notices = array();

	public static function init() {

		load_plugin_textdomain( 'affiliates-buddypress', null, AFFILIATES_BUDDYPRESS_PLUGIN_NAME . '/languages' );

		add_action( 'init', array( __CLASS__, 'wp_init' ) );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );

		add_action('admin_head', array( __CLASS__, 'enqueue_scripts' ) );

	}

	public static function wp_init() {

			add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ), 40 );

			if ( !class_exists( "AffiliatesBuddypress" ) ) {
				include_once 'core/class-affiliates-buddypress.php';
			}
	}

	/**
	 * Load scripts.
	 */
	public static function enqueue_scripts() {
		wp_register_style( 'affbp-admin-styles', AFFILIATES_BUDDYPRESS_PLUGIN_URL . 'css/admin-styles.css' );
		wp_enqueue_style ('affbp-admin-styles');
	}

	public static function admin_notices() { 
		if ( !empty( self::$notices ) ) {
			foreach ( self::$notices as $notice ) {
				echo $notice;
			}
		}
	}

	/**
	 * Adds the admin section.
	 */
	public static function admin_menu() {
		$admin_page = add_submenu_page(
				'affiliates-admin',
				__( 'Buddypress', 'affiliates-buddypress' ),
				__( 'Buddypress', 'affiliates-buddypress' ),
				AFFILIATES_ADMINISTER_AFFILIATES,
				'affiliates-admin-buddypress',
				array( __CLASS__, 'buddypress_admin_page' )
		);
	}

	public static function buddypress_admin_page () {
		global $wpdb;

		$output = '';
		$output .= '<div class="wrap">';
		$output .= '<h2>';
		$output .= __( 'Buddypress Integration', 'affiliates-buddypress' );
		$output .= '</h2>';
		
		$alert = "";
		if ( isset( $_POST['submit'] ) ) {
			$alert = __("Settings saved", 'affiliates-buddypress');
	
			delete_option( 'affiliates-buddypress-page' );
			if ( !empty( $_POST['affiliates-buddypress-page'] ) ) {
				add_option( "affiliates-buddypress-page",$_POST[ "affiliates-buddypress-page" ] );
			}
		}
	
		if ($alert != "") {
			$output .= '<div style="background-color: #ffffe0;border: 1px solid #993;padding: 1em;margin-right: 1em;">' . $alert . '</div>';
		}
		
		$output .= '<div class="wrap" style="border: 1px solid #ccc; padding:10px;">';
		$output .= '<form method="post" action="">';
		$output .= '<table class="form-table">';
		$output .= '<tr valign="top">';
		$output .= '<th scope="row"><strong>' . __( 'Select your Affiliate Area page:', 'affiliates-buddypress' ) . '</strong></th>';
		$output .= '<td>';
		
		$post_ids = array();
		$posts = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_content LIKE '%[affiliates\_%' AND post_status = 'publish'" );

		if ( count( $posts ) == 0 ) {
			$output .= '<p>';
			$output .= __( 'It seems that you do not have any pages set up for your affiliates yet.', 'affiliates-buddypress' );
			$output .= '</p>';
			$output .= '<p>';
			$output .= __( 'You can use the page generation option to create the default affiliate area for your affiliates.', 'affiliates-buddypress' );
			$output .= '</p>';
		} else {
			foreach( $posts as $post ) {
				$post_ids[] = $post->ID;
			}
			$selected_page_id = get_option( 'affiliates-buddypress-page', null );

			$post_select_options = '<select name="affiliates-buddypress-page">';
			foreach( $post_ids as $post_id ) {
				$selected = '';
				if ( $post_id == $selected_page_id ) {
					$selected = ' selected ';
				}
				$post_title = get_the_title( $post_id );
				$post_select_options .= sprintf(
						'<option value="%d" %s >%s</option>',
						intval( $post_id ),
						$selected,
						esc_html( $post_title )
				);
			}
			$post_select_options .= '</select>';
			$output .= $post_select_options;
		}
		$output .= '</td>';
		$output .= '</tr>';
		$output .= '</table>';

		submit_button( __( "Save", 'affiliates-buddypress' ) );
		settings_fields( 'affiliates-buddypress' );

		$output .= '</form>';
		$output .= '</div>';
		$output .= '</div>';
	}

}
AffiliatesBuddypress_Plugin::init();
