<?php
/**
 * shortcode
 *
 * @author  NasimNet
 * @since 3.0
 */
class NASIMNET_ParsiJoo_MAP_Shortcode {

    /**
     * standard shortcode
     *
     * create maker and pop up
     *
     * @param  array $atts
     * @return string html
     */
    public static function standard_shortoce( $atts ) {
        $api_map = esc_attr( get_option( 'parsijoo_api_map') );
        $rand_id = 'leaflet_' . uniqid();

        // default shortcode atts
        $a = shortcode_atts( array(
            'latlng' => '31.879897, 54.317292',
            'zoom'   => '15',
            'height' => '300',
            'text'   => '',
            'image'  => ''
        ), $atts );

        $option = new NASIMNET_ParsiJoo_MAP_OPTIONS();
        $popup = $option->get_popup( $a['text'], $a['image'] );

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
                marker = L.marker([<?php echo $a['latlng']; ?>]).addTo(map);

                <?php if ( $popup ) : ?>

                    map.on('popupopen', function(e) {
                    var px = map.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
                        px.y -= e.popup._container.clientHeight/2 // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
                        map.panTo(map.unproject(px),{animate: true}); // pan to new center
                    });
                    marker.bindPopup('<?php echo $popup; ?>').openPopup();
                <?php endif; ?>
            });
        </script><?php
        return ob_get_clean();
	}
}

add_shortcode( 'parsijoo_map', array( 'NASIMNET_ParsiJoo_MAP_Shortcode', 'standard_shortoce' ) );
