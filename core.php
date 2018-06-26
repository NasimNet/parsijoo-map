<?php
/**
 * Plugin Core
 * @author NasimNet
 * @see https://nasimnet.ir
 * @since  1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class NasimnetParsijooMap {

 	function __construct() {
 		add_action( 'admin_menu', array( $this, 'add_management_page' ) );
 	}

 	public function add_management_page() {
 		add_management_page(
 			__( 'نقشه پارسی جو' , NP_MAP ),
 			__( 'نقشه پارسی جو' , NP_MAP ),
 			'manage_options',
 			'nasimnet_parsijoo_map',
 			array( $this, 'settings_page' )
 		);
 	}

    public function settings_page() { ?>

        <?php $this->process_form_data(); ?>

		<div class="postbox" style="margin: 20px">
			<h2 class="hndle ui-sortable-handle pad10 margin-0" style="padding:0 10px 10px">
				<span><?php _e( 'تنظیمات افزونه', NP_MAP ); ?></span>
			</h2>

			<div class="inside">
				<div class="main">
                    <?php $this->form(); ?>
                    <?php $this->lerning(); ?>
                    <?php $this->admin_map(); ?>
				</div>
			</div>
            <div class="copyright">
                <?php printf(
                    '<p>طراحی شده توسط %s - نسخه %s</p>',
                    '<a href="https://nasimnet.ir" target="_blank">نسیم نت</a>',
                    NP_MAP_VERSION
                ); ?>
            </div>
		</div>

        <?php
	}

    private function form() { ?>
        <form class="" method="post">
            <table class="form-table">
                <tbody>
                    <tr class="user-user-login-wrap">
                        <th><label for="user_login">API پارسی جو</label></th>
                        <td>
                            <input name="parsijoo_api_map" id="parsijoo_api_map" value="<?php echo get_option( 'parsijoo_api_map'); ?>" class="regular-text" type="text">
                            <div class="description" style="margin-top:10px">API خود را وارد نمایید. <a href="http://addmap.parsijoo.ir/addmap/بلاگ/306-راهنمای-دریافت-api-key-نقشه-پارسی-جو" target="_blank">راهنمای دریافت API Key نقشه پارسی جو </a></div>
                        </td>
                   </tr>
                </tbody>
            </table>
            <?php wp_nonce_field( 'parsijoo_settings_action', 'parsijoo_settings_nonce_field' ); ?>
            <input name="submit" id="submit" class="button button-primary" value="ذخیره اطلاعات" type="submit">
        </form><?php
    }

    private function lerning() { ?>
        <hr style="margin:20px 0;">
        <p>برای استفاده از نقشه در سایت خود می توانید از شورت کد زیر استفاده نمایید.</p>
        <p><code>[parsijoo_map latlng="" zoom="" height=""]</code></p>
        <p>
            پارامتر <b>latlng</b> : طول و عرض جغرافیایی ، مانند : 31.879897, 54.317292<br>
            پارامتر <b>zoom</b> : زوم نقشه ، تنها یک مقدار عددی برای این پارامتر مجاز است ، استفاده از این پارامتر اختیاری است.<br>
            پارامتر <b>height</b> : ارتفاع نقشه ، تنها یک مقدار عددی برای این پارامتر مجاز است ، استفاده از این پارامتر اختیاری است.
        </p>
        <p> نمونه مانند زیر می شود.</p>
        <p><code>[parsijoo_map latlng="31.879897, 54.317292" zoom="20" height="300"]</code></p>
        <p>بعد از وارد کردن API پارسی جو می توانید از طریق نقشه زیر مکان مورد نظر خود را انتخاب کرده و شورتکد مکان مورد نظر را دریافت نمایید.
        </p>
        <hr>
        <?php
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
            echo '<p class="danger">جهت مشاهده نقشه و ساخت خودکار شورتکد ، لطفا API نقشه پارسی جو را وارد نمایید.</p>';
            return;
        } ?>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>

        <div id="leaflet" style="height: 450px"></div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {

                var map = L.map('leaflet').setView([<?php echo $location; ?>], 5);

                L.tileLayer('https://developers.parsijoo.ir/web-service/v1/map/?type=tile&x={x}&y={y}&z={z}&apikey=<?php echo $api_map; ?>', {
                    maxZoom: 20,
                }).addTo(map);

                var marker = L.marker([<?php echo $location; ?>], {
                    draggable:true
                }).addTo(map);

                marker.on('drag', function (e) {
                    marker.setLatLng(e.latlng);
                    var shortcode = '[parsijoo_map latlng="'+ e.latlng.lat + ',' + e.latlng.lng +'" zoom="15" height="300"]';
                    $('#parsijoo-shortcode').val( shortcode );
                });

                map.on('click', function (e) {
                    marker.setLatLng(e.latlng);
                    var shortcode = '[parsijoo_map latlng="'+ e.latlng.lat + ',' + e.latlng.lng +'" zoom="15" height="300"]';
                    $('#parsijoo-shortcode').val( shortcode );
                });

            });
        </script>

        <br>
        <p>ابتدا مکان مورد نظر خود را انتخاب کرده و سپس شورتکد زیر را کپی کنید و در مکان دلخواه خود قرار دهید.</p>
        <div class="nasimnet-shortcode">
            <input id="parsijoo-shortcode" type="text" value="" style="direction:ltr;width:450px">
        </div><?php
    }

}

if ( is_admin() )
	$nasimnet_parsijoo_map = new NasimnetParsijooMap;

/**
 * shortcode
 *
 * @author  NasimNet
 * @param  array    $atts
 * @return string   html
 */
function nasimnet_parsijoo_map( $atts ) {
    $api_map = get_option( 'parsijoo_api_map');
    $location = $atts['latlng'];
    $zoom = ( isset( $atts['zoom'] ) ) ? $atts['zoom'] : '15' ;
    $height = ( isset( $atts['height'] ) ) ? $atts['height'] : '300' ;
    ob_start(); ?>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>

    <div id="leaflet" style="height: <?php echo $height; ?>px"></div>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            var map = L.map('leaflet').setView([<?php echo $location; ?>], <?php echo $zoom ?>);
            L.tileLayer('https://developers.parsijoo.ir/web-service/v1/map/?type=tile&x={x}&y={y}&z={z}&apikey=<?php echo $api_map; ?>', {
            maxZoom: 20,
            }).addTo(map);
            L.marker([<?php echo $location; ?>]).addTo(map);
        });
    </script><?php

    return ob_get_clean();
}
add_shortcode( 'parsijoo_map', 'nasimnet_parsijoo_map' );
