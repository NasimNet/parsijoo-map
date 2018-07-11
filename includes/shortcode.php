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
    $rand_id = 'leaflet_' . uniqid();

    // default shortcode atts
    $a = shortcode_atts( array(
        'latlng' => '31.879897, 54.317292',
        'zoom'   => '15',
        'height' => '300',
    ), $atts );

    // enqueue css and js leaflet
    if ( ! wp_style_is( 'leaflet_css') ) {
        wp_enqueue_style( 'leaflet_css' );
    }
    
    if ( ! wp_script_is( 'leaflet_js' ) ) {
       wp_enqueue_script( 'leaflet_js' );
    }    

    ob_start(); ?>
    <div id="<?php echo $rand_id; ?>" style="height: <?php echo $a['height']; ?>px"></div>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            var map = L.map('<?php echo $rand_id; ?>').setView([<?php echo $a['latlng']; ?>], <?php echo $a['zoom'] ?>);
            L.tileLayer('https://developers.parsijoo.ir/web-service/v1/map/?type=tile&x={x}&y={y}&z={z}&apikey=<?php echo $api_map; ?>', { maxZoom: 20, }).addTo(map);
            L.marker([<?php echo $a['latlng']; ?>]).addTo(map);
        });
    </script><?php
    return ob_get_clean();
}
add_shortcode( 'parsijoo_map', 'nasimnet_parsijoo_map' );
