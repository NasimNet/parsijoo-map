<?php
/**
 * options
 *
 * @author  NasimNet
 * @since 3.0
 */
class NASIMNET_ParsiJoo_MAP_OPTIONS {

    function __construct() {

    }

    public function get_popup( $atts = array() ) {
        $string = '';

        if ( $this->key_exists('image', $atts) ) {
            $string .= '<img src="'.esc_url_raw( $atts['image'] ).'">';
        }

        if ( $this->key_exists('title', $atts) ) {
            $string .= '<h4>'. esc_html( $atts['title'] ) .'</h4>';
        }

        if ( $this->key_exists('text', $atts) ) {
            $string .= wp_kses_post( $atts['text'] );
        }

        if ( $this->key_exists('details', $atts) ) {
            $string .= '<hr>' . wp_kses_post( $atts['details'] );
        }

        // $string = str_replace('<p>', '', $string);
        // $string = str_replace('</p>', '', $string);
        $string = str_replace(array("\n", "\r"), '', $string);

        return $string;
    }

    public function get_polygon( $latlangs ) {
        $latlangs = explode('-', $latlangs);
        $latlangs = array_filter($latlangs);

        $var = array();
        foreach ( $latlangs as $latlang ) {
            $var[] = "[$latlang]";
        }

        return implode( ',', $var );
    }

    private function key_exists( $key, $array ) {
        if ( isset($array[$key]) && !empty($array[$key]) ) {
            return true;
        }
        return false;
    }

}
