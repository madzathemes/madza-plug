<?php


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Include Class Files
 *
 * Loads required classes for this plugin to function.
 *
 * @since 1.2
 * @version 1.4.1
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'class-easy-google-fonts.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-egf-font-utilities.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-egf-register-options.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/customizer/class-egf-customize-manager.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-egf-frontend.php' );

/**
 * Load Plugin Text Domain
 *
 * Required in order to make this plugin translatable.
 *
 * @since 1.2
 * @version 1.4.1
 *
 */
function easy_google_fonts_text_domain() {
	load_plugin_textdomain( 'easy-google-fonts', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'easy_google_fonts_text_domain' );

/**
 * Create Easy_Google_Fonts Instance
 *
 * Creates a new Easy_Google_Fonts class instance when
 * the 'plugins_loaded' action is fired.
 *
 * @since 1.2
 * @version 1.4.1
 *
 */
add_action( 'plugins_loaded', array( 'Easy_Google_Fonts', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'EGF_Font_Utilities', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'EGF_Register_Options', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'EGF_Customize_Manager', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'EGF_Frontend', 'get_instance' ) );

/**
 * Register Activation/Deactivation Hooks
 *
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @since 1.2
 * @version 1.4.1
 *
 */
register_activation_hook( __FILE__, array( 'Easy_Google_Fonts', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Easy_Google_Fonts', 'deactivate' ) );
