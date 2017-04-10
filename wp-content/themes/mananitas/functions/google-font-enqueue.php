<?php
/*
Register Fonts
*/

function ravis_google_fonts_url() {
    $font_url = '';
    
    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'pinar' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Source Sans Pro:400,100,300,700|PT Sans:400,700&subset=latin,cyrillic,cyrillic-ext|Lora:400,400italic,700,700italic' ), "https://fonts.googleapis.com/css" );
    }
    return $font_url;
}
/*
Enqueue scripts and styles.
*/
function ravis_google_font_scripts() {
    wp_enqueue_style( 'google-fonts', ravis_google_fonts_url(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'ravis_google_font_scripts' );