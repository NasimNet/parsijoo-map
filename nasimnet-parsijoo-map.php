<?php
/**
 * Plugin Name: نقشه پارسی جو
 * Plugin URI: https://nasimnet.ir
 * Description: با استفاده از این افزونه می توانید موقعیت مکانی خود را بر روی نقشه پارسی جو نمایش دهید.
 * Version: 1.0
 * Author: NasimNet
 * Author URI: https://nasimnet.ir
 * License: GPLv3
 * License URI: https://nasimnet.ir/copyright-balck-list-nasimnet/
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'NP_MAP', 'nasimnet-parsijoo-map');
define( 'NP_MAP_VERSION', '1.0' );

// require file's
require_once ( plugin_dir_path( __FILE__ ) . 'core.php' );
