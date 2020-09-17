<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages externa compatibility functions folder
 *
 *
 * @version		1.0.0
 * @package		ecommerce-product-catalog/ext-comp
 * @author 		impleCode
 */
class ic_catalog_builders_compat {

	function __construct() {
		add_filter( 'et_builder_post_types', array( $this, 'divi_builder_enable' ) );
	}

	function divi_builder_enable( $post_types ) {
		$post_types[] = 'al_product';
		return $post_types;
	}

}

$ic_catalog_builders_compat = new ic_catalog_builders_compat;
