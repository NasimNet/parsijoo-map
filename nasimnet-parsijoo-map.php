<?php
/**
 * Plugin Name: نقشه پارسی جو
 * Plugin URI: https://nasimnet.ir
 * Description: با استفاده از این افزونه می توانید موقعیت مکانی خود را بر روی نقشه پارسی جو نمایش دهید.
 * Version: 1.1
 * Author: NasimNet
 * Author URI: https://nasimnet.ir
 * License: GPLv3
 * License URI: https://nasimnet.ir/copyright-balck-list-nasimnet/
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'NP_MAP', 'nasimnet-parsijoo-map');
define( 'NP_MAP_VERSION', '1.1' );

add_action( 'admin_enqueue_scripts', 'nasimnet_parsijoo_admin_style' );
function nasimnet_parsijoo_admin_style($hook) {
    if( $hook != 'tools_page_nasimnet_parsijoo_map' ) return;
    wp_enqueue_style( NP_MAP, plugins_url('assets/css/admin-style.css', __FILE__) );
}

register_deactivation_hook( __FILE__, 'deactivation_nasimnet_parsijoo_map' );
function deactivation_nasimnet_parsijoo_map() {
	delete_option( 'parsijoo_api_map' );
}

// require file's
require_once ( plugin_dir_path( __FILE__ ) . 'core.php' );
