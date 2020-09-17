<?php
/**
 * Envo Multipurpose Theme Customizer
 *
 * @package Envo Multipurpose
 */

$envo_multipurpose_sections = array( 'info', 'demo' );

foreach( $envo_multipurpose_sections as $sections ){
    require get_template_directory() . '/lib/customizer/' . $sections . '.php';
}

function envo_multipurpose_customizer_scripts() {
    wp_enqueue_style( 'envo-multipurpose-customize',get_template_directory_uri().'/lib/customizer/css/customize.css', '', 'screen' );
    wp_enqueue_script( 'envo-multipurpose-customize', get_template_directory_uri() . '/lib/customizer/js/customize.js', array( 'jquery' ), '20170404', true );
}
add_action( 'customize_controls_enqueue_scripts', 'envo_multipurpose_customizer_scripts' );
