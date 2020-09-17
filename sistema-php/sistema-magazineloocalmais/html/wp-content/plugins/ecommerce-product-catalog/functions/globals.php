<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages implecode global variable functions
 *
 * @version        1.0.0
 * @package        ecommerce-product-catalog/functions
 * @author        impleCode
 */
if ( !function_exists( 'ic_get_global' ) ) {

	/**
	 * Returns implecode global
	 *
	 * @global type $implecode
	 * @param type $name
	 * @return string
	 */
	function ic_get_global( $name = null ) {
		global $implecode;
		if ( !empty( $name ) ) {
			//return wp_cache_get( $name, 'implecode' );
			if ( isset( $implecode[ $name ] ) ) {
				return $implecode[ $name ];
			} else {
				return false;
			}
		} else {
			return $implecode;
		}
	}

}

if ( !function_exists( 'ic_delete_global' ) ) {

	/**
	 * Deletes implecode global
	 *
	 * @global type $implecode
	 * @param type $name
	 * @return string
	 */
	function ic_delete_global( $name = null ) {
		global $implecode;
		if ( !empty( $name ) ) {
			unset( $implecode[ $name ] );
		} else {
			unset( $implecode );
		}
	}

}

if ( !function_exists( 'ic_save_global' ) ) {

	/**
	 * Saves implecode global
	 *
	 * @global array $implecode
	 * @param string $name
	 * @param type $value
	 * @return boolean
	 */
	function ic_save_global( $name, $value, $product_listing_globals = false ) {
		global $implecode;
		if ( !empty( $name ) ) {
			//wp_cache_set( $name, $value, 'implecode' );
			if ( $value === null ) {
				$value = '';
			}
			$implecode[ $name ] = $value;
			if ( $product_listing_globals ) {
				if ( empty( $implecode[ 'product_listing_globals' ] ) ) {
					$implecode[ 'product_listing_globals' ] = array();
				}
				if ( !in_array( $name, $implecode[ 'product_listing_globals' ] ) ) {
					$implecode[ 'product_listing_globals' ][] = $name;
				}
			}
			return true;
		}
		return false;
	}

}

if ( !function_exists( 'ic_reset_listing_globals' ) ) {

	function ic_reset_listing_globals() {
		global $implecode;
		if ( empty( $implecode[ 'product_listing_globals' ] ) ) {
			$implecode[ 'product_listing_globals' ] = array();
		}
		foreach ( $implecode[ 'product_listing_globals' ] as $global_name ) {
			ic_delete_global( $global_name );
		}
		$implecode[ 'product_listing_globals' ] = array();
	}

}