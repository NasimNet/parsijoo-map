<?php
/**
 * Plugin Core
 * @author NasimNet
 * @see https://nasimnet.ir
 * @since  1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class NASIMNET_Parsijoo_Map {

 	function __construct() {
 		add_action( 'admin_menu', array( $this, 'add_management_page' ) );
 	}

 	public function add_management_page() {
 		add_management_page(
 			__( 'Parsijoo MAP' , 'parsijoo-map' ),
 			__( 'Parsijoo MAP' , 'parsijoo-map' ),
 			'manage_options',
 			'nasimnet_parsijoo_map',
 			array( $this, 'settings_page' )
 		);
 	}

    public function settings_page() { ?>

        <?php $this->process_form_data(); ?>

		<div class="postbox">
			<h2 class="hndle ui-sortable-handle pad10 margin-0">
				<span>
                    <span class="dashicons dashicons-location"></span>
                    <?php _e( 'Parsijoo MAP Plugin Settings', 'parsijoo-map' ); ?>
                </span>
			</h2>

			<div class="inside">
				<div class="main">
                    <?php $this->form(); ?>
                    <?php $this->lerning(); ?>
                    <?php $this->admin_map(); ?>
				</div>
			</div>
            <div class="copyright">
                <p>
                    <?php printf(
                        __( 'Developed with %s - Version %s', 'parsijoo-map' ),
                        '<a href="https://nasimnet.ir" target="_blank">nasimnet</a>',
                        NASIMNET_PMAP_VERSION
                    ); ?>
                </p>
            </div>
		</div><?php
	}

    private function form() { ?>
        <form class="" method="post">
            <table class="form-table">
                <tbody>
                    <tr class="user-user-login-wrap">
                        <th><label for="user_login"><?php _e( 'Parsijoo API', 'parsijoo-map' ) ?></label></th>
                        <td>
                            <input name="parsijoo_api_map" id="parsijoo_api_map" value="<?php echo get_option( 'parsijoo_api_map'); ?>" class="regular-text" type="text">
                            <div class="description">
                                <?php _e( 'Enter the Parsijoo Map API Key,', 'parsijoo-map' ) ?>
                                <a href="http://addmap.parsijoo.ir/addmap/بلاگ/306-راهنمای-دریافت-api-key-نقشه-پارسی-جو" target="_blank"><?php _e( 'API Key Get Guide', 'parsijoo-map' ) ?></a>
                            </div>
                        </td>
                   </tr>
                </tbody>
            </table>
            <?php wp_nonce_field( 'parsijoo_settings_action', 'parsijoo_settings_nonce_field' ); ?>
            <input name="submit" id="submit" class="button button-primary" value="ذخیره اطلاعات" type="submit">
        </form><?php
    }

    private function lerning() { ?>
        <hr class="margin-20">
        <p>
            <?php _e( 'To use the map on your site, you can use the following shortcode.', 'parsijoo-map' ); ?>
        </p>
        <p><code>[parsijoo_map latlng="" zoom="" height=""]</code></p>
        <ul class="parametrs">
            <li>
                <?php
                    printf( __( 'Parameter %s : Latitude and Longitude, Example: 31.879897, 54.317292', 'parsijoo-map' ), '<code>latlng</code>');
                ?>
            </li>
            <li>
                <?php
                    printf( __( 'Parameter %s : Map zoom, only a numeric value for this parameter is allowed, the use of this parameter is optional.', 'parsijoo-map' ), '<code>zoom</code>');
                ?>
            </li>
            <li>
                <?php
                    printf( __( 'Parameter %s : The height of the map, only a numeric value for this parameter is allowed, the use of this parameter is optional.', 'parsijoo-map' ), '<code>height</code>');
                ?>
            </li>
        </ul>
        <p><?php _e( 'The sample is as follows', 'parsijoo-map' ) ?></p>
        <p><code>[parsijoo_map latlng="31.879897, 54.317292" zoom="20" height="300"]</code></p>
        <hr><?php
    }

    private function process_form_data() {
        if ( ! empty( $_POST ) && check_admin_referer( 'parsijoo_settings_action', 'parsijoo_settings_nonce_field' ) ) {
           update_option( 'parsijoo_api_map', sanitize_text_field( $_POST['parsijoo_api_map'] ) );
        }
    }

    private function admin_map() {
        $location = '31.879897, 54.317292';
        $api_map  = get_option( 'parsijoo_api_map');

        if ( !$api_map || $api_map == '' ) {
            printf(
                '<p class="danger"><span class="dashicons dashicons-warning"></span> %s</p>',
                __( 'To view the map and build the shotcode, please enter the Persian Maps API.', 'parsijoo-map' )
            );
            return;
        } ?>

        <p class="help-map">
            <span class="dashicons dashicons-location-alt"></span>
            <?php _e( 'Select the place you want and copy your shortcode.', 'parsijoo-map') ?>
        </p>
        <div id="leaflet"></div>

        <p>
            <?php _e( 'Copy and paste your shortcode into a post, page or custom widget', 'parsijoo-map' ) ?>
        </p>
        <div class="nasimnet-shortcode">
            <input id="parsijoo-shortcode" type="text" value='[parsijoo_map latlng="31.879897, 54.317292" zoom="5" height="300"]'>
        </div><?php
    }

}

if ( is_admin() )
	$nasimnet_parsijoo_map = new NASIMNET_Parsijoo_Map;
