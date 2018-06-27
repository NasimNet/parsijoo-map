<?php
/**
 * Plugin Name: PARSIJOO MAP
 * Description: With this plugin you can display your location on the Parsijoo MAP
 * Version: 1.3
 * Author: NasimNet
 * Author URI: https://nasimnet.ir
 * License: GPLv3
 * License URI: https://nasimnet.ir/copyright-balck-list-nasimnet/
 * Text Domain: parsijoo-map
 * Domain Path: /languages
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'NASIMNET_PMAP_VERSION', '1.3' );

// require file's
require_once ( plugin_dir_path( __FILE__ ) . 'includes/admin.php' );
require_once ( plugin_dir_path( __FILE__ ) . 'includes/shortcode.php' );

/**
 * load plugin textdomain
 *
 * @since 1.3
 */
function nasimnet_parsijoo_map_load_textdomain() {
  load_plugin_textdomain( 'parsijoo-map', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'nasimnet_parsijoo_map_load_textdomain' );

/**
 * admin enqueue scripts
 *
 * @since 1.3
 * @param  string $hook
 * @return void
 */
function nasimnet_parsijoo_admin_enqueue ($hook) {
    if( $hook != 'tools_page_nasimnet_parsijoo_map' ) return;

    wp_enqueue_style( 'npmap_admin_css', plugins_url('assets/css/admin.css', __FILE__), array() );
    wp_enqueue_script( 'npmap_admin_js', plugins_url('assets/js/admin.js', __FILE__), array('leaflet_js'), false, true );

    // load Leaflet
    wp_enqueue_style( 'leaflet_css', plugins_url('assets/css/leaflet.css', __FILE__), array(), '1.3.1' );
    wp_enqueue_script( 'leaflet_js', plugins_url('assets/js/leaflet.js', __FILE__), array(), '1.3.1', true );

    // Localize the script
    $map_api = array( 'mapapi' => esc_attr( get_option( 'parsijoo_api_map') ) );
    wp_localize_script( 'npmap_admin_js', 'object_map', $map_api );
}
add_action( 'admin_enqueue_scripts', 'nasimnet_parsijoo_admin_enqueue' );

/**
 * frontend enqueue scripts
 *
 * @since 1.3
 * @param  string $hook
 * @return void
 */
function nasimnet_parsijoo_frontend_enqueue() {
    wp_register_style( 'leaflet_css', plugins_url('assets/css/leaflet.css', __FILE__), array(), '1.3.1' );
    wp_register_script( 'leaflet_js', plugins_url('assets/js/leaflet.js', __FILE__), array(), '1.3.1', true );
}
add_action( 'wp_enqueue_scripts', 'nasimnet_parsijoo_frontend_enqueue' );

/**
 * register deactivation
 *
 * @since 1.0
 */
register_deactivation_hook( __FILE__, 'deactivation_nasimnet_parsijoo_map' );
function deactivation_nasimnet_parsijoo_map() {
	delete_option( 'parsijoo_api_map' );
}
