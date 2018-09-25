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

    public function get_popup( $text = false, $image = false ) {

        if ( !$text && !$image ) return false;

        $html = '';
        if ( $image ) {
            $html .= '<img src="'.esc_url_raw( $image ).'">';
        }

        if ( $text ) {
            $html .= '<p>'. esc_attr( $text ).'</p>';
        }

        return $html;
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

}
