<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages activation functions
 *
 * Created by Norbert Dreszer.
 * Date: 19-Feb-15
 * Time: 13:40
 * Package: functions/
 */
function ic_woocat_activation() {
	if ( function_exists( 'impleCode_EPC' ) ) {
		$ic_woocat							 = ic_woocat_settings();
		$ic_woocat[ 'catalog' ][ 'enable' ]	 = 1;
		update_option( 'ic_woocat', $ic_woocat );
	}
	delete_option( 'IC_WOOCAT_activation_message_done' );
}
