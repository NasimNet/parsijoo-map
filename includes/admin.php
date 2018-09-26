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

    public function settings_page() {

        $this->process_form_data();

        $this->create_postbox( array(
            'id'      => 'map-api-form',
            'icon'    => 'dashicons-admin-generic',
            'title'   => __( 'Parsijoo MAP Plugin Settings', 'parsijoo-map' ),
            'content' => $this->api_form()
        ));

        $api_map  = get_option( 'parsijoo_api_map');
        if ( !$api_map || $api_map == '' ) {
            printf(
                '<p class="danger"><span class="dashicons dashicons-warning"></span> %s</p>',
                __( 'To view the map and build the shotcode, please enter the Persian Maps API.', 'parsijoo-map' )
            );
            return;
        }

        $this->create_postbox( array(
            'id'      => 'create-shortcode',
            'icon'    => 'dashicons-sticky',
            'title'   => __( 'Create Shortcode', 'parsijoo-map' ),
            'content' => $this->create_shortcode()
        ));

        $this->create_postbox( array(
            'id'      => 'map-lerning',
            'icon'    => 'dashicons-admin-collapse',
            'title'   => __( 'MAP Lerning', 'parsijoo-map' ),
            'content' => $this->map_lerning()
        ));

        $this->create_postbox( array(
            'id'      => 'popup-parameters',
            'icon'    => 'dashicons-format-status',
            'title'   => __( 'POP-UP Parameters', 'parsijoo-map' ),
            'content' => $this->popup_parameters()
        ));

        $this->create_postbox( array(
            'id'      => 'circle-shortcode',
            'icon'    => 'dashicons-marker',
            'title'   => __( 'Circle Shortcode', 'parsijoo-map' ),
            'content' => $this->circle_shortcode()
        ));

        $this->create_postbox( array(
            'id'      => 'polygon-shortcode',
            'icon'    => 'dashicons-star-empty',
            'title'   => __( 'Polygon Shortcode', 'parsijoo-map' ),
            'content' => $this->polygon_shortcode()
        )); ?>

        <div class="copyright">
            <p>
                <?php printf(
                    __( 'Developed with %s - Version %s', 'parsijoo-map' ),
                    '<a href="https://nasimnet.ir" target="_blank">nasimnet</a>',
                    NASIMNET_PMAP_VERSION
                ); ?>
            </p>
        </div><?php
	}

    private function create_postbox( $items = array() ) { ?>
        <div id="<?php echo $items['id'] ?>" class="postbox">
            <h2 class="hndle ui-sortable-handle pad10 margin-0">
				<span>
                    <span class="nasimnet-map-icon dashicons <?php echo $items['icon'] ?>"></span>
                    <?php echo $items['title'] ?>
                </span>
			</h2>
            <div class="inside">
				<div class="main">
                    <?php echo $items['content']; ?>
				</div>
			</div>
        </div><?php
    }

    private function api_form() {
        ob_start(); ?>
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
        return ob_get_clean();
    }

    private function process_form_data() {
        if ( ! empty( $_POST ) && check_admin_referer( 'parsijoo_settings_action', 'parsijoo_settings_nonce_field' ) ) {
           update_option( 'parsijoo_api_map', sanitize_text_field( $_POST['parsijoo_api_map'] ) );
        }
    }

    private function map_lerning() {
        ob_start(); ?>
        <p>
            <?php _e( 'To use the map on your site, you can use the following shortcode.', 'parsijoo-map' ); ?>
        </p>
        <p><code>[parsijoo_map latlng="" zoom="" height=""]</code></p>
        <ul class="parametrs">
            <li>
                <?php printf( __( 'Parameter %s : Latitude and Longitude, Example: 31.879897, 54.317292', 'parsijoo-map' ), '<code>latlng</code>'); ?>
            </li>
            <li>
                <?php printf( __( 'Parameter %s : Map zoom, only a numeric value for this parameter is allowed, the use of this parameter is optional.', 'parsijoo-map' ), '<code>zoom</code>'); ?>
            </li>
            <li>
                <?php printf( __( 'Parameter %s : The height of the map, only a numeric value for this parameter is allowed, the use of this parameter is optional.', 'parsijoo-map' ), '<code>height</code>'); ?>
            </li>
        </ul>
        <p><?php _e( 'The sample is as follows', 'parsijoo-map' ) ?></p>
        <p><code>[parsijoo_map latlng="31.879897, 54.317292" zoom="20" height="300"]</code></p><?php
        return ob_get_clean();
    }



    private function create_shortcode() {
        ob_start() ?>
        <p class="help-map">
            <span class="dashicons dashicons-location-alt"></span>
            <?php _e( 'Select the place you want and copy your shortcode.', 'parsijoo-map') ?>
        </p>
        <div id="leaflet"></div>

        <div class="map-details">
            <div>
                <label><?php _e( 'Lat', 'parsijoo-map' ) ?></label>
                <input type="text" id="latMAP" class="input-example" value="">
            </div>
            <div>
                <label><?php _e( 'Lng', 'parsijoo-map' ) ?></label>
                <input type="text" id="lngMAP" class="input-example" value="">
            </div>
            <div>
                <label><?php _e( 'Zoom', 'parsijoo-map' ) ?></label>
                <input type="text" id="zoomMAP" class="input-example" value="">
            </div>
        </div>

        <div class="nasimnet-shortcode">
            <p>
                <?php _e( 'Copy and paste your shortcode into a post, page or custom widget', 'parsijoo-map' ) ?>
            </p>
            <input id="parsijoo-shortcode" type="text" value='[parsijoo_map latlng="31.879897, 54.317292" zoom="5" height="300"]'>
        </div><?php
        return ob_get_clean();
    }

    private function popup_parameters() {
        ob_start() ?>
        <div class="row-example">
            <div class="column">
                <?php echo do_shortcode( '[parsijoo_map latlng="31.879897, 54.317292" height="400" text="'.__( 'I am a pop-up', 'parsijoo-map' ).'"]' ) ?>
                <input type="text" class="input-example" value='[parsijoo_map latlng="31.879897, 54.317292" height="400" text="<?php _e( 'I am a pop-up', 'parsijoo-map' ); ?>"]'>
            </div>
            <div class="column">
                <?php echo do_shortcode( '[parsijoo_map latlng="31.879897, 54.317292" height="400" title="'.__( 'Title pop-up', 'parsijoo-map' ).'" text="'. __( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'parsijoo-map' ).'"]' ) ?>

                <input type="text" class="input-example" value='[parsijoo_map latlng="31.879897, 54.317292" height="400" title="<?php _e( 'Title pop-up', 'parsijoo-map'); ?>" text="<?php _e( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'parsijoo-map' ); ?>"]'>
            </div>
            <div class="column">
                <?php echo do_shortcode( '[parsijoo_map latlng="31.879897, 54.317292" height="400" title="گروه طراحی نسیم نت" text="نسیم نت در آبان سال ۱۳۸۶ با محوریت طراحی و برنامه نویسی وبسایت و نرم افزارهای تحت وب به صورت رسمی آغاز به کار کرد ." details="شماره تماس : 09197437752<br>آدرس سایت : https://nasimnet.ir" image="'.NASIMNET_PMAP_PLUGIN_URL. 'assets/css/images/image-popup.jpg"]' ) ?>

                <input type="text" class="input-example" value='[parsijoo_map latlng="31.879897, 54.317292" height="400" title="گروه طراحی نسیم نت" text="نسیم نت در آبان سال ۱۳۸۶ با محوریت طراحی و برنامه نویسی وبسایت و نرم افزارهای تحت وب به صورت رسمی آغاز به کار کرد ." details="شماره تماس : 09197437752<br>آدرس سایت : https://nasimnet.ir" image="<?php echo NASIMNET_PMAP_PLUGIN_URL; ?>assets/css/images/image-popup.jpg"]'>
            </div>
        </div>

        <ul class="parametrs">
            <li>
                <?php _e( 'Applicable in all shortcodes', 'parsijoo-map'  ) ?>
            </li>
            <li>
                <?php printf( __( 'Parameter %s : POPUP Image', 'parsijoo-map' ), '<code>image</code>'); ?>
            </li>
            <li>
                <?php printf( __( 'Parameter %s : POPUP Title', 'parsijoo-map' ), '<code>title</code>'); ?>
            </li>
            <li>
                <?php printf( __( 'Parameter %s : POPUP Text', 'parsijoo-map' ), '<code>text</code>'); ?>
            </li>
            <li>
                <?php printf( __( 'Parameter %s : POPUP Details', 'parsijoo-map' ), '<code>datails</code>'); ?>
            </li>
        </ul><?php
        return ob_get_clean();
    }

    private function circle_shortcode() {
        ob_start() ?>
        <div class="map-circle">
            <?php echo do_shortcode( '[parsijoo_map_circle latlng="34.627821624020775,50.866999626159675" zoom="13" height="400"  radius="1000"]' ) ?>
            <ul class="parametrs">
                <li>
                    <?php printf( __( 'ShortCode %s', 'parsijoo-map' ), '<code>[parsijoo_map_circle]</code>'); ?>
                </li>
                <li>
                    <?php printf( __( 'Parameter %s : Radius', 'parsijoo-map' ), '<code>radius</code>'); ?>
                </li>
                <li>
                    <?php printf( __( 'Parameter %s : Latitude and Longitude', 'parsijoo-map' ), '<code>latlng</code>'); ?>
                </li>
                <li>
                    <?php printf( __( 'Parameter %s : Map zoom', 'parsijoo-map' ), '<code>zoom</code>'); ?>
                </li>
                <li>
                    <?php printf( __( 'Parameter %s : The height of the map', 'parsijoo-map' ), '<code>height</code>'); ?>
                </li>
            </ul>
            <input type="text" class="input-example" value='[parsijoo_map_circle latlng="34.627821624020775,50.866999626159675" zoom="13" height="400"  radius="1000"]'>
        </div><?php
        return ob_get_clean();
    }

    private function polygon_shortcode() {
        ob_start() ?>
        <div class="map-polygon">
            <h3><?php _e( 'Polygon Shortcode', 'parsijoo-map' ) ?></h3>

            <?php echo do_shortcode( '[parsijoo_map_polygon  height="400" polygon="31.881134, 54.319148-31.879512, 54.311713-31.877325, 54.314320"]' ) ?>
            <ul class="parametrs">
                <li>
                    <?php printf( __( 'ShortCode %s', 'parsijoo-map' ), '<code>[parsijoo_map_polygon]</code>'); ?>
                </li>
                <li>
                    <?php printf( __( 'Parameter %s : To use the parameter polygon, the latitude and longitude must be separated by "-"', 'parsijoo-map' ), '<code>polygon</code>'); ?>
                </li>
                <li>
                    <?php printf( __( 'Parameter %s : Map zoom', 'parsijoo-map' ), '<code>zoom</code>'); ?>
                </li>
                <li>
                    <?php printf( __( 'Parameter %s : The height of the map', 'parsijoo-map' ), '<code>height</code>'); ?>
                </li>
            </ul>
            <input type="text" class="input-example" value='[parsijoo_map_polygon  height="400" polygon="31.881134, 54.319148-31.879512, 54.311713-31.877325, 54.314320"]'>
        </div><?php
        return ob_get_clean();
    }

}

if ( is_admin() )
	$nasimnet_parsijoo_map = new NASIMNET_Parsijoo_Map;
