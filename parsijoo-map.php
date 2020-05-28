<?php //phpcs:ignore
/**
 * PARSIJOO MAP
 *
 * @package    parsijoo-map
 * @author     M.Motahari
 * @copyright  2020 NasimNet
 * @license    GPL-2.0-or-later
 *
 * Plugin Name: PARSIJOO MAP
 * Description: With this plugin you can display your location on the Parsijoo MAP
 * Version: 3.0.0
 * Author: NasimNet
 * Author URI: https://nasimnet.ir
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: parsijoo-map
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || exit;

/**
 * NASIMNET_ParsiJoo_MAP
 *
 * @package parsijoo-map
 * @version  3.0.0
 */
class NASIMNET_ParsiJoo_MAP {

	/**
	 * Instance
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Construct
	 *
	 * @access private
	 */
	private function __construct() {
		$this->plugins_loaded();
		$this->define_constants();
		$this->load_files();
	}

	/**
	 * Create an instance from this class.
	 *
	 * @access public
	 * @return Class
	 */
	public static function instance() {
		if ( is_null( ( self::$instance ) ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Define Constans
	 */
	private function define_constants() {
		$this->define( 'NASIMNET_PMAP_VERSION', '3.0.0' );
		$this->define( 'NASIMNET_PMAP_PATH', plugin_dir_path( __FILE__ ) );
		$this->define( 'NASIMNET_PMAP_URL', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Load Files
	 *
	 * @return void
	 */
	private function load_files() {
		require_once NASIMNET_PMAP_PATH . 'includes/class-parsijoo-enqueue.php';
		require_once NASIMNET_PMAP_PATH . 'includes/class-parsijoo-admin.php';
		require_once NASIMNET_PMAP_PATH . 'includes/class-parsijoo-shortcode.php';
		require_once NASIMNET_PMAP_PATH . 'includes/class-parsijoo-builder.php';
	}

	/**
	 * Load Hooks
	 *
	 * @return void
	 */
	private function plugins_loaded() {
		add_action( 'plugins_loaded', array( $this, 'textdomain' ) );
	}

	/**
	 * Textdomain
	 *
	 * @return void
	 */
	public function textdomain() {
		load_plugin_textdomain( 'parsijoo-map', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

}

NASIMNET_ParsiJoo_MAP::instance();
