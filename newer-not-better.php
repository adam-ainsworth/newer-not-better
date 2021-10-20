<?php
/**
 * Newer Not Better
 *
 * Plugin Name:       Newer Not Better
 * Plugin URI:        https://adamainsworth.co.uk/plugins/
 * Description:       Prevents selected plugins bugging you about updates.
 * Version:           1.0.0
 * Author:            adam.ainsworth
 * Author URI:        https://adamainsworth.co.uk/
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       newer-not-better
 * Domain Path:       /languages
 * Requires at least: 4.0.4
 * Tested up to:      5.8.1
 */

if ( ! defined( 'WPINC' ) && ! defined( 'ABSPATH' ) ) {
	header('Location: /'); die;
}

if ( ! class_exists( 'Newer_Not_Better' ) ) {
	class Newer_Not_Better {
		private function __construct() {}

		public static function activate() {
	        if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			// any activation code here
		}

		public static function deactivate() {
	        if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			// any deactivation code here
		}

		public static function uninstall() {
	        if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			if ( __FILE__ !== WP_UNINSTALL_PLUGIN ) {
				return;
			}
			 
			/*
			$option_name = 'nnb_options';
			delete_option($option_name);
			delete_site_option($option_name);
			*/
		}

		public static function init() {
			// TODO - options
			// TODO - add disable to plugins page
			add_filter( 'site_transient_update_plugins', array( __CLASS__, 'disable_plugin_updates' ) );
		}
		
		function disable_plugin_updates( $value ) {
			// TODO - get from options
			$plugin_paths = [
				'wp-migrate-db/wp-migrate-db.php',
			];

			if ( isset($value) && is_object($value) ) {
				foreach( $plugin_paths as $plugin_path ) {
					if ( isset( $value->response[$plugin_path] ) ) {
						unset( $value->response[$plugin_path] );
					}
				}
			}

			return $value;
		}

	}

	register_activation_hook( __FILE__, [ 'Newer_Not_Better', 'activate' ] );
	register_deactivation_hook( __FILE__, [ 'Newer_Not_Better', 'deactivate' ] );
	register_uninstall_hook( __FILE__, [ 'Newer_Not_Better', 'uninstall' ] );
	add_action( 'plugins_loaded', [ 'Newer_Not_Better', 'init' ] );
}
