<?php

/*
Plugin Name: Omnis Demo Importer
Description: One click demo importer for Omnis Theme.
Version: 1.0
Author: ProteusThemes & Leopard Themes
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: pt-ocdi
*/

// MODIFIED 2.5.2
// line 55
// New-folder omnis-data
// Modified assets/js/main.js
// Modified views/plugin-page.php

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Main plugin class with initialization tasks.
 */
class Omnis_OCDI_Plugin {
	/**
	 * Constructor for this class.
	 */
	public function __construct() {
		/**
		 * Display admin error message if PHP version is older than 5.3.2.
		 * Otherwise execute the main plugin class.
		 */
		if ( version_compare( phpversion(), '5.3.2', '<' ) ) {
			add_action( 'admin_notices', array( $this, 'old_php_admin_error_notice' ) );
		}
		else {
			// Set plugin constants.
			$this->set_plugin_constants();

			// Composer autoloader.
			require_once PT_OCDI_PATH . 'vendor/autoload.php';

			// Instantiate the main plugin class *Singleton*.
			$pt_one_click_demo_import = OCDI\OneClickDemoImport::get_instance();

			// Register WP CLI commands
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				WP_CLI::add_command( 'ocdi list', array( 'OCDI\WPCLICommands', 'list_predefined' ) );
				WP_CLI::add_command( 'ocdi import', array( 'OCDI\WPCLICommands', 'import' ) );
			}

			require_once  plugin_dir_path( __FILE__ )  . 'omnis-data/omnis-import.php';
			require_once  plugin_dir_path( __FILE__ )  . 'omnis-data/data/omnis-import-data.php';
		}
	}


	/**
	 * Display an admin error notice when PHP is older the version 5.3.2.
	 * Hook it to the 'admin_notices' action.
	 */
	public function old_php_admin_error_notice() {
		$message = sprintf( esc_html__( 'The %2$sOne Click Demo Import%3$s plugin requires %2$sPHP 5.3.2+%3$s to run properly. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.3.2.%4$s Your current version of PHP: %2$s%1$s%3$s', 'pt-ocdi' ), phpversion(), '<strong>', '</strong>', '<br>' );

		printf( '<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}


	/**
	 * Set plugin constants.
	 *
	 * Path/URL to root of this plugin, with trailing slash and plugin version.
	 */
	private function set_plugin_constants() {
		// Path/URL to root of this plugin, with trailing slash.
		if ( ! defined( 'PT_OCDI_PATH' ) ) {
			define( 'PT_OCDI_PATH', plugin_dir_path( __FILE__ ) );
		}
		if ( ! defined( 'PT_OCDI_URL' ) ) {
			define( 'PT_OCDI_URL', plugin_dir_url( __FILE__ ) );
		}

		// Action hook to set the plugin version constant.
		add_action( 'admin_init', array( $this, 'set_plugin_version_constant' ) );
	}


	/**
	 * Set plugin version constant -> PT_OCDI_VERSION.
	 */
	public function set_plugin_version_constant() {
		if ( ! defined( 'PT_OCDI_VERSION' ) ) {
			$plugin_data = get_plugin_data( __FILE__ );
			define( 'PT_OCDI_VERSION', $plugin_data['Version'] );
		}
	}
}

// Instantiate the plugin class.
$ocdi_plugin = new Omnis_OCDI_Plugin();
