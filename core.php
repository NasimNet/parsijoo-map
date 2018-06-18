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
			<button type="button" class="handlediv button-link" aria-expanded="true">
				<span class="toggle-indicator" aria-hidden="true"></span>
			</button>
			<h2 class="hndle ui-sortable-handle pad10 margin-0" style="padding:0 10px 10px">
				<span><?php _e( 'تنظیمات افزونه', NP_MAP ); ?></span>
			</h2>
			<div class="inside">
				<div class="main">
                    <?php $this->form(); ?>
                    <?php $this->lerning(); ?>
				</div>
			</div>
		</div><?php
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
        <p><pre dir="ltr">[parsijoo_map latlng="" height=""]</pre></p>
        <p>
            <b>latlng</b> : طول و عرض جغرافیایی ، مانند : 31.879897, 54.317292<br>
            <b>height</b> : ارتفاع نقشه ، تنها یک عدد باید وارد کنید به صورت پیشفرض 300px است
        </p>
        <p>
            نمونه مانند زیر می شود.
            <pre dir="ltr">[parsijoo_map latlng="31.879897, 54.317292" height="300"]</pre>
        </p>

        <?php
    }

    private function process_form_data() {
        if ( ! empty( $_POST ) && check_admin_referer( 'parsijoo_settings_action', 'parsijoo_settings_nonce_field' ) ) {
           update_option( 'parsijoo_api_map', sanitize_text_field( $_POST['parsijoo_api_map'] ) );
        }
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
    $height = ( isset( $atts['height'] ) ) ? $atts['height'] : '300' ;
    ob_start(); ?>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>

    <div id="leaflet" style="height: <?php echo $height; ?>px"></div>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            var map = L.map('leaflet').setView([<?php echo $location; ?>], 15);
            L.tileLayer('https://developers.parsijoo.ir/web-service/v1/map/?type=tile&x={x}&y={y}&z={z}&apikey=<?php echo $api_map; ?>', {
            maxZoom: 21,
            }).addTo(map);
            L.marker([<?php echo $location; ?>]).addTo(map);
        });
    </script><?php

    return ob_get_clean();
}
add_shortcode( 'parsijoo_map', 'nasimnet_parsijoo_map' );
