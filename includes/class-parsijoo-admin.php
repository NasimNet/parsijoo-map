<?php
/**
 * Admin Page Class
 *
 * @package parsijoo-map
 * @author NasimNet
 * @since 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * ParsiJoo_Admin
 *
 * @package parsijoo-map
 * @version  3.0.0
 */
class ParsiJoo_Admin {

	/**
	 * Action
	 *
	 * @return void
	 */
	public static function action() {
		add_action( 'admin_menu', array( __CLASS__, 'add_management_page' ) );
	}

	/**
	 * Add Management Page
	 *
	 * @return void
	 */
	public static function add_management_page() {
		add_management_page(
			__( 'Parsijoo MAP', 'parsijoo-map' ),
			__( 'Parsijoo MAP', 'parsijoo-map' ),
			'manage_options',
			'parsijoo',
			array( __CLASS__, 'content_page' )
		);
	}

	/**
	 * Settings Page
	 *
	 * @return void
	 */
	public static function content_page() {
		self::process_form_data();
		include NASIMNET_PMAP_PATH . 'includes/admin-page.php';
	}

	/**
	 * Process from data
	 *
	 * @return void
	 */
	private static function process_form_data() {
		if ( ! empty( $_POST ) && isset( $_POST['parsijoo_api_map'] ) && check_admin_referer( 'parsijoo_settings_action', 'parsijoo_settings_nonce_field' ) ) {
			update_option( 'parsijoo_api_map', sanitize_text_field( wp_unslash( $_POST['parsijoo_api_map'] ) ) );
		}
	}

}

if ( is_admin() ) {
	ParsiJoo_Admin::action();
}
