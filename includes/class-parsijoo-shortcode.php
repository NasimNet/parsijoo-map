<?php
/**
 * Shortcodes
 *
 * @package parsijoo-map
 * @author  NasimNet
 * @since 3.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * ParsiJoo_Shortcode
 *
 * @package parsijoo-map
 * @version  3.0.0
 */
class ParsiJoo_Shortcode {

	/**
	 * Load Shortcodes
	 */
	public static function load_shortcodes() {
		add_shortcode( 'parsijoo_map', array( __CLASS__, 'standard_shortcode' ) );
		add_shortcode( 'parsijoo_map_circle', array( __CLASS__, 'circle_shortoce' ) );
		add_shortcode( 'parsijoo_map_polygon', array( __CLASS__, 'polygon_shortcode' ) );
	}

	/**
	 * Standard shortcode
	 * create maker and pop up
	 *
	 * @param  array $atts atts array.
	 * @return string html
	 */
	public static function standard_shortcode( $atts ) {
		$api_map = get_option( 'parsijoo_api_map' );
		$rand_id = 'leaflet_' . uniqid();

		// default shortcode atts .
		$a = shortcode_atts(
			array(
				'latlng'  => '31.879897, 54.317292',
				'zoom'    => '15',
				'height'  => '300',
				'image'   => '',
				'title'   => '',
				'text'    => '',
				'details' => '',
			),
			$atts
		);

		$popup = ParsiJoo_Builder::popup( $a );

		// enqueue css and js leaflet .
		if ( ! wp_style_is( 'leaflet' ) ) {
			wp_enqueue_style( 'leaflet' );
		}

		if ( ! wp_script_is( 'leaflet' ) ) {
			wp_enqueue_script( 'leaflet' );
		}

		ob_start(); ?>
		<div id="<?php echo esc_attr( $rand_id ); ?>" style="height: <?php echo esc_attr( $a['height'] ); ?>px"></div>

		<script type="text/javascript">
			jQuery(document).ready(function() {
				var map = L.map('<?php echo esc_attr( $rand_id ); ?>').setView([<?php echo esc_attr( $a['latlng'] ); ?>], <?php echo esc_attr( $a['zoom'] ); ?>);
				L.tileLayer('https://developers.parsijoo.ir/web-service/v1/map/?type=tile&x={x}&y={y}&z={z}&apikey=<?php echo esc_attr( $api_map ); ?>', { maxZoom: 19, }).addTo(map);
				marker = L.marker([<?php echo esc_attr( $a['latlng'] ); ?>]).addTo(map);

				<?php if ( $popup ) : ?>
					map.on('popupopen', function(e) {
					var px = map.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
						px.y -= e.popup._container.clientHeight/2 // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
						map.panTo(map.unproject(px),{animate: true}); // pan to new center
					});
					marker.bindPopup('<?php echo wp_kses_post( $popup ); ?>').openPopup();
				<?php endif; ?>
			});
		</script>
		<?php
		return ob_get_clean();
	}

	/**
	 * Circle shortcode
	 *
	 * @param  array $atts .
	 * @return string html
	 */
	public static function circle_shortoce( $atts ) {
		$api_map = get_option( 'parsijoo_api_map' );
		$rand_id = 'leaflet_' . uniqid();

		// default shortcode atts .
		$a = shortcode_atts(
			array(
				'latlng'  => '31.879897, 54.317292',
				'zoom'    => 15,
				'height'  => 300,
				'image'   => '',
				'title'   => '',
				'text'    => '',
				'details' => '',
				'radius'  => 2000,
			),
			$atts
		);

		$popup = ParsiJoo_Builder::popup( $a );

		// enqueue css and js leaflet .
		if ( ! wp_style_is( 'leaflet' ) ) {
			wp_enqueue_style( 'leaflet' );
		}

		if ( ! wp_script_is( 'leaflet' ) ) {
			wp_enqueue_script( 'leaflet' );
		}

		ob_start();
		?>
		<div id="<?php echo esc_attr( $rand_id ); ?>" style="height: <?php echo esc_attr( $a['height'] ); ?>px"></div>

		<script type="text/javascript">
			jQuery(document).ready(function() {
				var map = L.map('<?php echo esc_attr( $rand_id ); ?>').setView([<?php echo esc_attr( $a['latlng'] ); ?>], <?php echo esc_attr( $a['zoom'] ); ?>);
				L.tileLayer('https://developers.parsijoo.ir/web-service/v1/map/?type=tile&x={x}&y={y}&z={z}&apikey=<?php echo esc_attr( $api_map ); ?>', { maxZoom: 20, }).addTo(map);
				circle = L.circle([<?php echo esc_attr( $a['latlng'] ); ?>], <?php echo esc_attr( $a['radius'] ); ?>,{
					color: '#3388ff',
					fillColor: '#3388ff',
					fillOpacity: 0.5
				}).addTo(map);

				<?php if ( $popup ) : ?>
					map.on('popupopen', function(e) {
					var px = map.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
						px.y -= e.popup._container.clientHeight/2 // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
						map.panTo(map.unproject(px),{animate: true}); // pan to new center
					});
					circle.bindPopup('<?php echo wp_kses_post( $popup ); ?>').openPopup();
				<?php endif; ?>
			});
		</script>
		<?php
		return ob_get_clean();
	}

	/**
	 * Polygon shortcode
	 *
	 * @param  array $atts .
	 * @return string html
	 */
	public static function polygon_shortcode( $atts ) {
		$api_map = get_option( 'parsijoo_api_map' );
		$rand_id = 'leaflet_' . uniqid();

		// default shortcode atts .
		$a = shortcode_atts(
			array(
				'latlng'  => '31.879897, 54.317292',
				'zoom'    => 15,
				'height'  => 300,
				'image'   => '',
				'title'   => '',
				'text'    => '',
				'details' => '',
				'polygon' => '31.881134, 54.319148-31.879512, 54.311713-31.877325, 54.314320-31.879630, 54.321187',
			),
			$atts
		);

		$popup   = ParsiJoo_Builder::popup( $a );
		$polygon = ParsiJoo_Builder::polygon( $a['polygon'] );

		// enqueue css and js leaflet .
		if ( ! wp_style_is( 'leaflet' ) ) {
			wp_enqueue_style( 'leaflet' );
		}

		if ( ! wp_script_is( 'leaflet' ) ) {
			wp_enqueue_script( 'leaflet' );
		}

		if ( ! wp_script_is( 'jquery' ) ) {
			wp_enqueue_script( 'jquery' );
		}

		ob_start();
		?>
		<div id="<?php echo esc_attr( $rand_id ); ?>" style="height: <?php echo esc_attr( $a['height'] ); ?>px"></div>

		<script type="text/javascript">
			jQuery(document).ready(function() {
				var map = L.map('<?php echo esc_attr( $rand_id ); ?>').setView([<?php echo esc_attr( $a['latlng'] ); ?>], <?php echo esc_attr( $a['zoom'] ); ?>);
				L.tileLayer('https://developers.parsijoo.ir/web-service/v1/map/?type=tile&x={x}&y={y}&z={z}&apikey=<?php echo esc_attr( $api_map ); ?>', { maxZoom: 20, }).addTo(map);
				polygon = L.polygon([ <?php echo esc_attr( $polygon ); ?> ]).addTo(map);

				<?php if ( $popup ) : ?>
					map.on('popupopen', function(e) {
					var px = map.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
						px.y -= e.popup._container.clientHeight/2 // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
						map.panTo(map.unproject(px),{animate: true}); // pan to new center
					});
					polygon.bindPopup('<?php echo wp_kses_post( $popup ); ?>').openPopup();
				<?php endif; ?>
			});
		</script>
		<?php
		return ob_get_clean();
	}

}

ParsiJoo_Shortcode::load_shortcodes();
