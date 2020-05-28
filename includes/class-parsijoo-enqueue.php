<?php
/**
 * Enqueue
 *
 * @package parsijoo-map
 * @author NasimNet
 * @since 3.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * ParsiJoo_Enqueue
 *
 * @package parsijoo-map
 * @version  3.0.0
 */
class ParsiJoo_Enqueue {

	/**
	 * Actions
	 *
	 * @return void
	 */
	public static function actions() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue' ) );
	}

	/**
	 * Enqueue Scripts and Styles
	 */
	public static function enqueue() {
		if ( ! wp_script_is( 'jquery' ) ) {
			wp_enqueue_script( 'jquery' );
		}
		wp_register_style( 'leaflet', NASIMNET_PMAP_URL . 'assets/css/leaflet.css', array(), '1.6.0' );
		wp_register_script( 'leaflet', NASIMNET_PMAP_URL . 'assets/js/leaflet.min.js', array( 'jquery' ), '1.6.0', true );
	}

	/**
	 * Enqueue Scripts and Styles
	 *
	 * @param  string $hook_suffix The current admin page.
	 */
	public static function admin_enqueue( $hook_suffix ) {
		if ( 'tools_page_parsijoo' !== $hook_suffix ) {
			return;
		}

		// Minimize prod or show expanded in dev.
		$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_style( 'leaflet', NASIMNET_PMAP_URL . "assets/css/leaflet{$min}.css", array(), '1.6.0' );
		wp_enqueue_script( 'leaflet', NASIMNET_PMAP_URL . 'assets/js/leaflet.min.js', array(), '1.6.0', true );

		wp_enqueue_style(
			'parsijoo-admin',
			NASIMNET_PMAP_URL . "assets/css/admin{$min}.css",
			array(),
			NASIMNET_PMAP_VERSION
		);

		wp_enqueue_script(
			'parsijoo-admin',
			NASIMNET_PMAP_URL . "assets/js/admin{$min}.js",
			array( 'leaflet' ),
			NASIMNET_PMAP_VERSION,
			true
		);
	}

}

ParsiJoo_Enqueue::actions();
