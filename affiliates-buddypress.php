<?php
/**
 * affiliates-buddypress.php
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
 *
 * Plugin Name: Affiliates BuddyPress
 * Plugin URI: http://www.itthinx.com/plugins/affiliates-buddypress
 * Description: Affiliates integration with BuddyPress that allows to display affiliate content in the BuddyPress user profile.
 * Version: 1.0.1
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 * Donate-Link: http://www.itthinx.com
 * Text Domain: affiliates-buddypress
 * Domain Path: /languages
 * License: GPLv3
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AFFILIATES_BUDDYPRESS_PLUGIN_NAME', 'affiliates-buddypress' );
define( 'AFFILIATES_BUDDYPRESS_FILE', __FILE__ );
define( 'AFFILIATES_BUDDYPRESS_PLUGIN_URL', plugins_url( 'affiliates-buddypress' ) );

/**
 * Plugin class.
 */
class Affiliates_BuddyPress_Plugin {

	/**
	 * Holds admin notices if any.
	 * @var array of string
	 */
	private static $notices = array();

	/**
	 * Loads translations and adds actions.
	 */
	public static function init() {

		load_plugin_textdomain( 'affiliates-buddypress', null, AFFILIATES_BUDDYPRESS_PLUGIN_NAME . '/languages' );

		add_action( 'init', array( __CLASS__, 'wp_init' ) );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );

		add_action( 'admin_head', array( __CLASS__, 'enqueue_scripts' ) );

	}

	/**
	 * Hooked on the init action. Checks required plugins are active and boots the
	 * integration class.
	 */
	public static function wp_init() {

		$result = true;

		$active_plugins = get_option( 'active_plugins', array() );
		if ( is_multisite() ) {
			$active_sitewide_plugins = get_site_option( 'active_sitewide_plugins', array() );
			$active_sitewide_plugins = array_keys( $active_sitewide_plugins );
			$active_plugins = array_merge( $active_plugins, $active_sitewide_plugins );
		}

		// required plugins
		$affiliates_is_active =
		in_array( 'affiliates/affiliates.php', $active_plugins ) ||
		in_array( 'affiliates-pro/affiliates-pro.php', $active_plugins ) ||
		in_array( 'affiliates-enterprise/affiliates-enterprise.php', $active_plugins );
		if ( !$affiliates_is_active ) {
			self::$notices[] =
			'<div class="error">' .
			__( 'The <strong>Affiliates BuddyPress Integration</strong> plugin requires an appropriate Affiliates plugin: <a href="http://www.itthinx.com/plugins/affiliates" target="_blank">Affiliates</a>, <a href="http://www.itthinx.com/plugins/affiliates-pro" target="_blank">Affiliates Pro</a> or <a href="http://www.itthinx.com/plugins/affiliates-enterprise" target="_blank">Affiliates Enterprise</a>.', 'affiliates-buddypress' ) .
			'</div>';
		}
		if ( !$affiliates_is_active ) {
			$result = false;
		}
		if ( $result ) {
			add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ), 40 );

			if ( !class_exists( 'Affiliates_BuddyPress' ) ) {
				require_once 'lib/class-affiliates-buddypress.php';
			}
		}
	}

	/**
	 * Load scripts.
	 */
	public static function enqueue_scripts() {
		wp_register_style( 'affbp-admin-styles', AFFILIATES_BUDDYPRESS_PLUGIN_URL . '/css/admin-styles.css' );
		wp_enqueue_style( 'affbp-admin-styles' );
	}

	/**
	 * Hooked on admin_notices and prints admin notices if any.
	 */
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
			__( 'BuddyPress', 'affiliates-buddypress' ),
			__( 'BuddyPress', 'affiliates-buddypress' ),
			AFFILIATES_ADMINISTER_AFFILIATES,
			'affiliates-admin-buddypress',
			array( __CLASS__, 'buddypress_admin_page' )
		);
	}

	public static function buddypress_admin_page () {
		global $wpdb;

		if ( !current_user_can( AFFILIATES_ADMINISTER_AFFILIATES ) ) {
			wp_die( __( 'Access denied.', 'affiliates' ) );
		}

		$output = '';
		$output .= '<div class="wrap">';
		$output .= '<h1>';
		$output .= __( 'BuddyPress Integration', 'affiliates-buddypress' );
		$output .= '</h1>';

		$output .= '<p class="description">';
		$output .= __( 'Here you can select the page that should be displayed in the BuddyPress user profiles under an additional <em>Affiliates</em> section.', 'affiliates-buddypress' );
		$output .= ' ';
		$output .= __( 'If you have already generated an affiliate area, you can choose that page.', 'affiliates-buddypress' );
		$output .= ' ';
		$output .= __( 'Alternatively, you can use any customized page that is using at least one <em>Affiliates</em> shortcode.', 'affiliates-buddypress' );
		$output .= '</p>';

		if ( isset( $_POST['submit'] ) ) {
			if ( wp_verify_nonce( $_POST['affiliates-buddypress-nonce'], 'save' ) ) { 

				delete_option( 'affiliates-buddypress-page' );
				if ( !empty( $_POST['affiliates-buddypress-page'] ) ) {
					add_option( 'affiliates-buddypress-page', $_POST[ 'affiliates-buddypress-page' ] );
				}

				$position = !empty( $_POST['affiliates-buddypress-page-position'] ) ? intval( $_POST['affiliates-buddypress-page-position'] ) : Affiliates_BuddyPress::NAV_ITEM_POSITION;
				delete_option( 'affiliates-buddypress-page-position' );
				add_option( 'affiliates-buddypress-page-position', $position );

				$output .= '<div style="background-color: #ffffe0;border: 1px solid #993;padding: 1em;margin-right: 1em;">';
				$output .= __( 'Settings saved', 'affiliates-buddypress' );
				$output .= '</div>';
			}
		}

		$output .= '<div class="wrap" style="border: 1px solid #ccc; padding:10px;">';
		$output .= '<form method="post" action="">';
		$output .= '<table class="form-table">';
		$output .= '<tr valign="top">';
		$output .= '<th scope="row"><strong>' . __( 'Page', 'affiliates-buddypress' ) . '</strong></th>';
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

			$output .= '<label>';
			$output .= __( 'The page that provides the content for the Affiliates BuddyPress profile section.', 'affiliates-buddypress' );
			$output .= ' ';
			$output .= '<select name="affiliates-buddypress-page">';
			$post_select_options = '<option value="">--</option>';
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
			$output .= $post_select_options;
			$output .= '</select>';
			$output .= '</label>';
		}
		$output .= '</td>';
		$output .= '</tr>';
		$output .= '<tr>';
		$output .= '<th scope="row"><strong>' . __( 'Position', 'affiliates-buddypress' ) . '</strong></th>';
		$output .= '<td>';
		$output .= '<label>';
		$output .= __( 'Profile item position', 'affiliates-buddypress' );
		$output .= ' ';
		$output .= sprintf(
			'<input name="affiliates-buddypress-page-position" type="text" value="%d" />',
			intval( get_option( 'affiliates-buddypress-page-position', Affiliates_BuddyPress::NAV_ITEM_POSITION ) )
		);
		$output .= '</label>';
		$output .= '</td>';
		$output .= '</tr>';
		$output .= '</table>';

		$output .= get_submit_button( __( 'Save', 'affiliates-buddypress' ) );

		$output .= wp_nonce_field( 'save', 'affiliates-buddypress-nonce', true, false );

		$output .= '</form>';
		$output .= '</div>';
		$output .= '</div>';

		echo $output;
	}

}
Affiliates_BuddyPress_Plugin::init();
