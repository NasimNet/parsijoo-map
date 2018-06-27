<?php
/**
 * shortcode
 *
 * @author  NasimNet
 * @param  array    $atts
 * @return string   html
 */
function nasimnet_parsijoo_map( $atts ) {
    $api_map = esc_attr( get_option( 'parsijoo_api_map') );

    // default shortcode atts
    $a = shortcode_atts( array(
        'latlng' => '31.879897, 54.317292',
        'zoom'   => '15',
        'height' => '300',
    ), $atts );

    // enqueue css and js leaflet
    wp_enqueue_style( 'leaflet_css' );
    wp_enqueue_script( 'leaflet_js' );

    ob_start(); ?>
    <div id="leaflet" style="height: <?php echo $a['height']; ?>px"></div>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            var map = L.map('leaflet').setView([<?php echo $a['latlng']; ?>], <?php echo $a['zoom'] ?>);
            L.tileLayer('https://developers.parsijoo.ir/web-service/v1/map/?type=tile&x={x}&y={y}&z={z}&apikey=<?php echo $api_map; ?>', { maxZoom: 20, }).addTo(map);
            L.marker([<?php echo $a['latlng']; ?>]).addTo(map);
        });
    </script><?php
    return ob_get_clean();
}
add_shortcode( 'parsijoo_map', 'nasimnet_parsijoo_map' );
