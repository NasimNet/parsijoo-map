<?php
/**
 * Builder
 *
 * @package parsijoo-map
 * @author  NasimNet
 * @since 2.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * ParsiJoo_Builder
 *
 * @package parsijoo-map
 * @version  3.0.0
 */
class ParsiJoo_Builder {

	/**
	 * POP-UP
	 *
	 * @param array $atts .
	 * @return string
	 */
	public static function popup( $atts = array() ) {
		$string = '';

		if ( self::key_exists( 'image', $atts ) ) {
			$string .= '<img src="' . esc_url_raw( $atts['image'] ) . '">';
		}

		if ( self::key_exists( 'title', $atts ) ) {
			$string .= '<h4>' . esc_html( $atts['title'] ) . '</h4>';
		}

		if ( self::key_exists( 'text', $atts ) ) {
			$string .= wp_kses_post( $atts['text'] );
		}

		if ( self::key_exists( 'details', $atts ) ) {
			$string .= '<hr>' . wp_kses_post( $atts['details'] );
		}

		$string = str_replace( array( "\n", "\r" ), '', $string );

		return $string;
	}

	/**
	 * Polygon
	 *
	 * @param string $latlangs lat and lngs.
	 * @return string
	 */
	public static function polygon( $latlangs ) {
		$latlangs = explode( '-', $latlangs );
		$latlangs = array_filter( $latlangs );

		$var = array();
		foreach ( $latlangs as $latlang ) {
			$var[] = "[$latlang]";
		}

		return implode( ',', $var );
	}

	/**
	 * Key exists
	 *
	 * @param string $key Key array.
	 * @param array  $array Array.
	 * @return boolean
	 */
	private static function key_exists( $key, $array ) {
		if ( isset( $array[ $key ] ) && ! empty( $array[ $key ] ) ) {
			return true;
		}
		return false;
	}

}
