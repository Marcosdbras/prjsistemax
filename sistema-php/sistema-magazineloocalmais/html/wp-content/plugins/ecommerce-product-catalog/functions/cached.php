<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages wordpress core fields
 *
 * Here all wordpress fields are redefined.
 *
 * @version        1.0.0
 * @package        ecommerce-product-catalog/functions
 * @author        impleCode
 */
function ic_catalog_get_categories( $parent = 0, $taxonomy = '', $number = '', $include = array(), $exclude = array(),
									$order = 'ASC', $orderby = 'name', $args = array() ) {
	if ( empty( $taxonomy ) ) {
		$taxonomy = get_current_screen_tax();
	}
	$key	 = 'get_product_categories' . $parent . $taxonomy . $number . implode( '_', $include ) . implode( '_', $exclude ) . $order . $orderby;
	$cached	 = ic_get_global( $key );
	if ( false !== $cached ) {
		return $cached;
	}
	$terms = ic_get_terms( array_merge( $args, array( 'taxonomy' => $taxonomy, 'parent' => $parent, 'number' => $number, 'include' => $include, 'exclude' => $exclude, 'order' => $order, 'orderby' => $orderby ) ) );
	if ( is_wp_error( $terms ) ) {
		return array();
	} else {
		//$terms = array_values( $terms );
	}
	if ( !empty( $key ) ) {
		ic_save_global( $key, $terms );
	}
	return $terms;
}

function ic_catalog_get_current_categories( $taxonomy = '', $args = null, $excluded_meta = array() ) {
	if ( empty( $taxonomy ) ) {
		$taxonomy = get_current_screen_tax();
	}
	$key_taxonomy	 = is_array( $taxonomy ) ? implode( '_', $taxonomy ) : $taxonomy;
	$key			 = 'get_current_product_categories' . $key_taxonomy;
	$cached			 = ic_get_global( $key );
	if ( false !== $cached ) {
		return $cached;
	}
	$post_ids = ic_get_current_products( array(), array( $taxonomy ), $excluded_meta );
	if ( $post_ids === 'all' ) {
		$all_term_args = array( 'taxonomy' => $taxonomy, 'parent' => 0 );
		if ( !empty( $args ) ) {
			$all_term_args = array_merge( $args, $all_term_args );
		}
		if ( !empty( $args[ 'all' ] ) ) {
			unset( $all_term_args[ 'parent' ] );
		}
		$terms = ic_get_terms( $all_term_args );
	} else {
		$args[ 'update_term_meta_cache' ]	 = false;
		$terms								 = wp_get_object_terms( $post_ids, $taxonomy, $args );
	}
	if ( is_wp_error( $terms ) ) {
		$terms = array();
	}
	if ( !empty( $key ) ) {
		ic_save_global( $key, $terms );
	}
	return array_values( $terms );
}

/**
 * Returns category product count with product in child categories
 *
 * @param type $cat_id
 * @return type
 */
function total_product_category_count( $cat_id, $taxonomy = null, $post_in = null ) {
	if ( empty( $taxonomy ) ) {
		$taxonomy = get_current_screen_tax();
	}
	if ( $post_in === 'all' ) {
		$post_in = null;
	}
	$cache_key = 'category_count' . $cat_id . $taxonomy;
	if ( !empty( $post_in ) ) {
		$cache_key .= array_sum( $post_in );
	}
	$cached = ic_get_global( $cache_key );
	if ( false !== $cached ) {
		return $cached;
	}
	if ( empty( $post_in ) ) {
		$post_in = ic_get_current_products( array(), array( $taxonomy ) );
		if ( is_array( $post_in ) ) {
			$count_post_in = count( $post_in );
			if ( $count_post_in > 3000 ) {
				$post_in = null;
			}
		} else {
			$count_post_in = 0;
		}
	}
	if ( $post_in === 'all' ) {
		$post_in = null;
	}
	if ( empty( $count_post_in ) && is_array( $post_in ) ) {
		$count_post_in = count( $post_in );
	} else if ( !is_array( $post_in ) ) {
		$count_post_in = 0;
	}
	if ( !empty( $post_in ) && $count_post_in < 3000 ) {
		global $wpdb;
		ini_set( 'memory_limit', WP_MAX_MEMORY_LIMIT );
		$cache_meta			 = 'term_ids_count' . array_sum( $post_in );
		$term_ids_count		 = ic_get_global( $cache_meta );
		$terms_cache_meta	 = 'terms_count' . array_sum( $post_in );
		$terms				 = ic_get_global( $terms_cache_meta );
		if ( $term_ids_count === false ) {
			$ids			 = join( "','", $post_in );
			$querystr		 = "
		  SELECT *
		  FROM $wpdb->term_relationships
		  WHERE $wpdb->term_relationships.object_id IN('$ids')
		  ";
			$query_results	 = $wpdb->get_results( $querystr, ARRAY_A );
			$term_ids_count	 = array_count_values( array_column( $query_results, 'term_taxonomy_id' ) );
			$terms			 = array();
			foreach ( $query_results as $result ) {
				if ( isset( $terms[ $result[ 'term_taxonomy_id' ] ] ) ) {
					$terms[ $result[ 'term_taxonomy_id' ] ][] = $result[ 'object_id' ];
				} else {
					$terms[ $result[ 'term_taxonomy_id' ] ] = array( $result[ 'object_id' ] );
				}
			}
			//$term_ids_count	 = array_count_values( wp_list_pluck( $query_results, 'term_taxonomy_id' ) );
			ic_save_global( $cache_meta, $term_ids_count );
			ic_save_global( $terms_cache_meta, $terms );
		}
		if ( !isset( $term_ids_count[ $cat_id ] ) ) {
			$term_ids_count[ $cat_id ] = 0;
		}
		if ( !empty( $taxonomy ) ) {
			$children = get_term_children( $cat_id, $taxonomy );
			if ( !is_wp_error( $children ) ) {
				$products_counted	 = array();
				$terms[ $cat_id ]	 = isset( $terms[ $cat_id ] ) ? $terms[ $cat_id ] : array();
				foreach ( $children as $child_id ) {
					if ( !empty( $term_ids_count[ $child_id ] ) ) {
						$diff						 = array_diff( $terms[ $child_id ], $products_counted, $terms[ $cat_id ] );
						$term_ids_count[ $cat_id ]	 += count( $diff );
						$products_counted			 = array_unique( $products_counted + $terms[ $child_id ] );
					}
				}
			}
		}
		ic_save_global( $cache_key, $term_ids_count[ $cat_id ] );
		return $term_ids_count[ $cat_id ];
	}

	if ( empty( $post_in ) ) {
		if ( empty( $_GET[ 's' ] ) ) {
			$term = get_term( $cat_id, $taxonomy );
			if ( !is_wp_error( $term ) && !empty( $term->count ) ) {
				if ( !empty( $cache_key ) ) {
					ic_save_global( $cache_key, $term->count );
				}
				return $term->count;
			}
		}
	}
	$query_args = apply_filters( 'category_count_query', array(
		//'nopaging'	 => true,
		'posts_per_page' => 1,
		'post_status'	 => ic_visible_product_status(),
		'tax_query'		 => array(
			array(
				'taxonomy'			 => $taxonomy,
				'terms'				 => $cat_id,
				'include_children'	 => true,
			),
		),
		'fields'		 => 'ids',
	), $taxonomy );
	if ( $post_in ) {
		$query_args[ 'post__in' ] = $post_in;
	}
	if ( isset( $_GET[ 's' ] ) && empty( $post_in ) ) {
		$query_args[ 's' ] = $_GET[ 's' ];
	}
	//$query_args[ 'cache_results' ]			 = false;
	$query_args[ 'update_post_meta_cache' ]	 = false;
	$query_args[ 'update_post_term_cache' ]	 = false;
	remove_action( 'pre_get_posts', 'ic_pre_get_products', 99 );
	$q										 = apply_filters( 'ic_catalog_category_count_query', '', $query_args );
	if ( empty( $q ) ) {
		$q = new WP_Query( $query_args );
	}
	add_action( 'pre_get_posts', 'ic_pre_get_products', 99 );
	$count = $q->found_posts;
	if ( !empty( $cache_key ) ) {
		ic_save_global( $cache_key, $count );
	}
	return $count;
}

if ( !function_exists( 'ic_get_current_products' ) ) {

	/**
	 * Returns current query product IDs
	 *
	 * @global type $shortcode_query
	 * @global type $wp_query
	 * @return type
	 */
	function ic_get_current_products( $exclude = array(), $exclude_tax = array(), $exclude_meta = array(),
								   $exclude_tax_val = array() ) {
		if ( is_ic_shortcode_query() ) {
			global $shortcode_query, $wp_query;
			if ( is_ic_product_listing( $shortcode_query ) && !is_product_filters_active() ) {
				return 'all';
			}
			$pre_shortcode_query = $wp_query;
			$wp_query			 = $shortcode_query;
		}

		if ( !empty( $pre_shortcode_query ) || ic_ic_catalog_archive() || is_ic_ajax() ) {
			$return = ic_process_current_products( $exclude, $exclude_tax, $exclude_meta, $exclude_tax_val );
			if ( !empty( $pre_shortcode_query ) ) {
				$wp_query = $pre_shortcode_query;
			}
			return $return;
		} else {
			global $wp_query;
			if ( !empty( $pre_shortcode_query ) ) {
				$wp_query = $pre_shortcode_query;
			}
			$product_ids = apply_filters( 'ic_current_products', '' );
			if ( is_array( $product_ids ) ) {
				return $product_ids;
			}
			return array();
		}
	}

}

function ic_process_current_products( $exclude = array(), $exclude_tax = array(), $exclude_meta = array(),
									  $exclude_tax_val = array() ) {

	global $wp_query;
	if ( empty( $wp_query->max_num_pages ) ) {
		//return array();
	}
	if ( $wp_query->max_num_pages <= 1 && is_array( $wp_query->posts ) && empty( $exclude ) && empty( $exclude_tax ) && empty( $exclude_meta ) ) {
		return wp_list_pluck( $wp_query->posts, 'ID' );
	}
	$product_ids = apply_filters( 'ic_current_products', '' );
	if ( is_array( $product_ids ) ) {
		return $product_ids;
	}
	if ( is_ic_product_listing() && !is_product_filters_active() ) {
		return 'all';
	} else if ( is_ic_taxonomy_page() ) {
		ini_set( 'memory_limit', WP_MAX_MEMORY_LIMIT );
	}
	$cache_key			 = 'current_products' . implode( '_', $exclude ) . json_encode( $exclude_tax ) . implode( '_', $exclude_meta );
	$cached_product_ids	 = ic_get_global( $cache_key );
	if ( false !== $cached_product_ids ) {
		return $cached_product_ids;
	}
	//global $wp_query;
	$catalog_query = ic_get_catalog_query( true );

	if ( empty( $catalog_query->query_vars ) ) {
		return array();
	}
	$args						 = array_filter( $catalog_query->query_vars, 'ic_filter_objects' );
	$args[ 'nopaging' ]			 = true;
	$args[ 'posts_per_page' ]	 = -1;
	$args[ 'fields' ]			 = 'ids';
	//$args[ 'suppress_filters' ]	 = true;
	$excluded_arg				 = false;
	foreach ( $exclude as $key ) {
		if ( isset( $args[ $key ] ) ) {
			unset( $args[ $key ] );
			$excluded_arg = true;
		}
	}
	if ( !$excluded_arg ) {
		$exclude = array();
	}

	if ( !empty( $args[ 'tax_query' ] ) && !empty( $exclude_tax ) ) {
		foreach ( $args[ 'tax_query' ] as $tax_key => $tax_query ) {
			if ( isset( $tax_query[ 0 ] ) ) {
				foreach ( $tax_query as $deeper_key => $deeper_query ) {
					if ( !empty( $deeper_query[ 'taxonomy' ] ) && in_array( $deeper_query[ 'taxonomy' ], $exclude_tax ) ) {
						if ( empty( $exclude_tax_val ) ) {
							unset( $args[ 'tax_query' ][ $tax_key ][ $deeper_key ] );
						} else if ( is_array( $deeper_query[ 'terms' ] ) ) {
							foreach ( $deeper_query[ 'terms' ] as $term_key => $term ) {
								if ( in_array( $term, $exclude_tax_val ) ) {
									unset( $args[ 'tax_query' ][ $tax_key ][ $deeper_key ][ 'terms' ][ $term_key ] );
								}
							}
						} else if ( in_array( $deeper_query[ 'terms' ], $exclude_tax_val ) ) {
							$term_key = array_search( $deeper_query[ 'terms' ], $exclude_tax_val );
							unset( $args[ 'tax_query' ][ $tax_key ][ $deeper_key ][ 'terms' ][ $term_key ] );
						}
						if ( !empty( $exclude_tax_val ) && empty( $args[ 'tax_query' ][ $tax_key ][ $deeper_key ][ 'terms' ] ) ) {
							unset( $args[ 'tax_query' ][ $tax_key ][ $deeper_key ] );
						}
						if ( count( $args[ 'tax_query' ][ $tax_key ] ) === 1 ) {
							unset( $args[ 'tax_query' ][ $tax_key ] );
						}
					}
				}
			} else {
				if ( !empty( $tax_query[ 'taxonomy' ] ) && in_array( $tax_query[ 'taxonomy' ], $exclude_tax ) ) {
					unset( $args[ 'tax_query' ][ $tax_key ] );
				}
			}
		}
	} else {
		$exclude_tax = array();
	}
	if ( !empty( $args[ 'meta_query' ] ) && !empty( $exclude_meta ) ) {
		foreach ( $args[ 'meta_query' ] as $meta_key => $meta_query ) {
			$string_meta_query = json_encode( $meta_query );
			foreach ( $exclude_meta as $excluded_meta ) {
				if ( ic_string_contains( $string_meta_query, '"key":"' . $excluded_meta . '"' ) ) {
					unset( $args[ 'meta_query' ][ $meta_key ] );
				}
			}
		}
	} else {
		$exclude_meta = array();
	}
	if ( $wp_query->max_num_pages <= 1 && empty( $exclude ) && empty( $exclude_tax ) && empty( $exclude_meta ) ) {
		return wp_list_pluck( $wp_query->posts, 'ID' );
	}

	$cache_key			 = 'current_products' . implode( '_', $exclude ) . implode( '_', $exclude_tax ) . implode( '_', $exclude_meta );
	$cached_product_ids	 = ic_get_global( $cache_key );
	if ( false !== $cached_product_ids ) {
		return $cached_product_ids;
	}
	$args[ 'ic_exclude_tax' ]	 = $exclude_tax;
	$args[ 'ic_exclude_meta' ]	 = $exclude_meta;
	if ( empty( $_GET[ 's' ] ) && empty( $args[ 'al_product-cat' ] ) && empty( $args[ 'tax_query' ] ) && empty( $args[ 'meta_query' ] ) ) {
		return 'all';
	}
	if ( empty( $args[ 's' ] ) && !empty( $_GET[ 's' ] ) ) {
		$args[ 's' ] = sanitize_text_field( $_GET[ 's' ] );
	}
	$current_query = apply_filters( 'ic_catalog_current_products', '', $args );
	if ( empty( $current_query ) ) {
		$args[ 'update_post_term_cache' ]	 = false;
		$args[ 'update_post_meta_cache' ]	 = false;
		$current_query						 = new WP_Query( $args );
	}
	$product_ids = $current_query->posts;
	if ( !empty( $cache_key ) ) {
		ic_save_global( $cache_key, $product_ids, true );
	}
	return $product_ids;
}

add_filter( 'ic_categories_ready_to_show', 'ic_cache_product_images_meta' );

function ic_cache_product_images_meta( $terms ) {
	global $wp_query;
	$ids = wp_list_pluck( $wp_query->posts, 'ID' );

	if ( isset( $terms[ 0 ] ) && !is_numeric( $terms[ 0 ] ) ) {
		$term_ids = wp_list_pluck( $terms, 'term_id' );
	} else {
		$term_ids = $terms;
	}
	if ( !empty( $ids ) ) {
		$to_cache = array();
		foreach ( $ids as $id ) {
			$image_id = get_post_meta( $id, '_thumbnail_id', true );
			if ( !empty( $image_id ) ) {
				$to_cache[] = $image_id;
			}
		}
	}
	if ( !empty( $term_ids ) ) {
		if ( empty( $to_cache ) ) {
			$to_cache = array();
		}
		foreach ( $term_ids as $id ) {
			$image_id = get_term_meta( $id, 'thumbnail_id', true );
			if ( !empty( $image_id ) ) {
				$to_cache[] = $image_id;
			}
		}
	}
	if ( !empty( $to_cache ) ) {
		update_meta_cache( 'post', $to_cache );
	}
	return $terms;
}
