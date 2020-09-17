<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Manages product attributes
 *
 * Here all product attributes are defined and managed.
 *
 * @version		1.0.0
 * @package		ecommerce-product-catalog/includes
 * @author 		impleCode
 */
add_action( 'init', 'ic_create_product_attributes' );

/**
 * Registers attributes taxonomy
 *
 */
function ic_create_product_attributes() {
	$args		 = array(
		'label'			 => 'Attributes',
		'hierarchical'	 => true,
		'public'		 => false,
		'query_var'		 => false,
		'rewrite'		 => false,
	);
	$post_types	 = apply_filters( 'ic_attributes_register_post_types', product_post_type_array() );
	register_taxonomy( 'al_product-attributes', $post_types, $args );
}

/**
 * Adds product attribute label and returns attribute label ID
 *
 * @param type $label
 * @return type
 */
function ic_add_product_attribute_label( $label ) {
	if ( is_array( $label ) ) {
		foreach ( $label as $single_label ) {
			$term_id = ic_add_product_attribute_label( $single_label );
		}
		return $term_id;
	} else {
		$term_id = get_attribute_label_id( $label );
		if ( !empty( $term_id ) ) {
			return $term_id;
		}
		$term = wp_insert_term( $label, 'al_product-attributes' );
		if ( !is_wp_error( $term ) ) {
			return $term[ 'term_id' ];
		} else if ( !empty( $term->error_data[ 'term_exists' ] ) ) {
			return intval( $term->error_data[ 'term_exists' ] );
		}
	}
	return '';
}

/**
 * Adds product attribute value and returns attribute value ID
 *
 * @param type $label_id
 * @param type $value
 * @return type
 */
function ic_add_product_attribute_value( $label_id, $value ) {
	if ( empty( $label_id ) ) {
		return '';
	}
	if ( is_array( $value ) ) {
		foreach ( $value as $current_value ) {
			$term_id = ic_add_product_attribute_value( $label_id, $current_value );
		}
	} else {
		$term_id = get_attribute_value_id( $label_id, $value, true );

		if ( empty( $term_id ) ) {
			$term = wp_insert_term( strval( $value ), 'al_product-attributes', array( 'parent' => intval( $label_id ) ) );
			if ( !is_wp_error( $term ) ) {
				$term_id = $term[ 'term_id' ];
			} else if ( !empty( $term->error_data[ 'term_exists' ] ) ) {
				return intval( $term->error_data[ 'term_exists' ] );
			}
		}
	}
	return $term_id;
}

add_filter( 'product_meta_save', 'ic_assign_product_attributes', 2, 2 );

/**
 * Adds product attributes to the database
 *
 * @param type $product_meta
 * @param type $post
 * @return type
 */
function ic_assign_product_attributes( $product_meta, $post, $clear_empty = true ) {
	$max_attr = apply_filters( 'ic_max_indexed_attributes', product_attributes_number() );
	if ( $max_attr > 0 ) {
		$product_id = isset( $post->ID ) ? $post->ID : $post;
		if ( !isset( $post->ID ) && !empty( $product_id ) ) {
			$post = get_post( $product_id );
		}
		$attr_ids = array();
		if ( in_array( $post->post_status, ic_visible_product_status() ) ) {
			for ( $i = 1; $i <= $max_attr; $i++ ) {
				if ( empty( $product_meta[ '_attribute' . $i ] ) || (is_array( $product_meta[ '_attribute' . $i ] ) && isset( $product_meta[ '_attribute' . $i ][ 0 ] ) && empty( $product_meta[ '_attribute' . $i ][ 0 ] )) ) {
					continue;
				}
				$default_label = get_default_product_attribute_label( $i );

				if ( !empty( $product_meta[ '_attribute-label' . $i ] ) || !empty( $default_label ) ) {
					//$label = is_array( $product_meta[ '_attribute-label' . $i ] ) ? ic_sanitize_product_attribute( $product_meta[ '_attribute-label' . $i ][ 0 ] ) : ic_sanitize_product_attribute( $product_meta[ '_attribute-label' . $i ] );
					if ( !empty( $product_meta[ '_attribute-label' . $i ] ) ) {
						$label = ic_sanitize_product_attribute( $product_meta[ '_attribute-label' . $i ] );
					} else {
						$label = ic_sanitize_product_attribute( $default_label );
					}
					if ( !empty( $label ) ) {
						//$value = is_array( $product_meta[ '_attribute' . $i ] ) ? ic_sanitize_product_attribute( $product_meta[ '_attribute' . $i ][ 0 ] ) : ic_sanitize_product_attribute( $product_meta[ '_attribute' . $i ] );
						$value = ic_sanitize_product_attribute( $product_meta[ '_attribute' . $i ] );

						if ( !empty( $value ) ) {
							$label_id = ic_add_product_attribute_label( $label );
							if ( !empty( $label_id ) ) {
								$attr_ids[] = $label_id;
								if ( !is_array( $value ) ) {
									$value = array( $value );
								}

								foreach ( $value as $val ) {
									$value_id	 = ic_add_product_attribute_value( $label_id, $val );
									$attr_ids[]	 = $value_id;
								}
							}
						}
					}
				}
			}
		}

		if ( !empty( $attr_ids ) ) {
			$attr_ids = array_unique( array_map( 'intval', $attr_ids ) );
			wp_set_object_terms( $product_id, $attr_ids, 'al_product-attributes' );
			if ( $clear_empty ) {
				ic_clear_empty_attributes();
			}
		} else {
			wp_set_object_terms( $product_id, '', 'al_product-attributes' );
			if ( $clear_empty ) {
				ic_clear_empty_attributes();
			}
		}
	}
	return $product_meta;
}

add_action( 'ic_scheduled_attributes_clear', 'ic_clear_empty_attributes' );

/**
 * Clears empty product attributes
 *
 */
function ic_clear_empty_attributes() {
	$max_attr	 = product_attributes_number();
	$attributes	 = ic_get_terms( array(
		'taxonomy'	 => 'al_product-attributes',
		'orderby'	 => 'count',
		'hide_empty' => 0,
		'number'	 => $max_attr
	) );
	$schedule	 = false;
	if ( !empty( $attributes ) && is_array( $attributes ) && !is_wp_error( $attributes ) ) {
		$prev_suspend = wp_suspend_cache_invalidation();
		foreach ( $attributes as $attribute ) {
			if ( $attribute->count == 0 && !empty( $attribute->term_id ) ) {
				$schedule = true;
				wp_delete_term( $attribute->term_id, 'al_product-attributes' );
			} else {
				$schedule = false;
				break;
			}
		}
		wp_suspend_cache_invalidation( $prev_suspend );
		if ( /* !wp_get_schedule( 'ic_scheduled_attributes_clear' ) && */ $schedule ) {
			//wp_schedule_event( time(), 'hourly', 'ic_scheduled_attributes_clear' );
			wp_schedule_single_event( time(), 'ic_scheduled_attributes_clear' );
		} else {
			wp_clear_scheduled_hook( 'ic_scheduled_attributes_clear' );
		}
	} else {
		wp_clear_scheduled_hook( 'ic_scheduled_attributes_clear' );
	}
}

add_action( 'ic_scheduled_attributes_assignment', 'ic_reassign_all_products_attributes' );

/**
 * Scheduled even to reassign all products attributes
 *
 * @return string
 */
function ic_reassign_all_products_attributes() {
	$max_attr = product_attributes_number();
	if ( empty( $max_attr ) ) {
		return;
	}
	$done = get_option( 'ic_product_upgrade_done', 0 );
	if ( empty( $done ) ) {
		update_option( 'ic_product_upgrade_done', -1 );
		wp_schedule_single_event( time(), 'ic_scheduled_attributes_assignment' );
		return $done;
	}

	if ( $done < 0 ) {
		$done = 0;
	}

	$products	 = get_all_catalog_products( 'date', 'ASC', 200, $done );
	$max_round	 = intval( 300 / $max_attr );
	if ( $max_round > 100 ) {
		$max_round = 100;
	}
	if ( $done > 100 ) {
		$max_round = apply_filters( 'ic_database_upgrade_max_round', $max_round * 2 );
	}
	$rounds = 1;
	foreach ( $products as $post ) {
		if ( $rounds > $max_round ) {
			break;
		}
		ic_set_time_limit( 30 );
		$product_meta = get_post_meta( $post->ID );
		ic_assign_product_attributes( $product_meta, $post, false );
		$done++;
		$rounds++;
	}
	$products_count = ic_products_count();
	if ( $products_count > $done ) {
		update_option( 'ic_product_upgrade_done', $done );
		wp_schedule_single_event( time(), 'ic_scheduled_attributes_assignment' );
	} else {
		delete_option( 'ic_product_upgrade_done' );
		wp_clear_scheduled_hook( 'ic_scheduled_attributes_assignment' );
		ic_clear_empty_attributes();
	}
	return $done;
}

add_action( 'ic_system_tools', 'ic_system_tools_attributes_upgrade' );

/**
 * Shows database upgrade button in system tools
 *
 */
function ic_system_tools_attributes_upgrade() {
	$done			 = get_option( 'ic_product_upgrade_done', 0 );
	$products_count	 = ic_products_count();
	if ( !empty( $done ) || isset( $_GET[ 'reassign_all_products_attributes' ] ) ) {
		if ( empty( $done ) && isset( $_GET[ 'reassign_all_products_attributes' ] ) ) {
			$done = ic_reassign_all_products_attributes();
		}
		if ( !wp_next_scheduled( 'ic_scheduled_attributes_assignment' ) ) {
			wp_schedule_single_event( time(), 'ic_scheduled_attributes_assignment' );
		}
		echo '<tr>';
		echo '<td>Database Upgrade</td>';
		echo '<td><a class="button" href="' . admin_url( 'edit.php?post_type=al_product&page=system.php&reassign_all_products_attributes=1' ) . '">Speed UP Pending Database Upgrade</a>';
		if ( isset( $_GET[ 'reassign_all_products_attributes' ] ) ) {
			if ( $done < 0 ) {
				$done = 0;
			}
			echo '<p>' . $done . ' Items Done! Another round needed.</p>';
		}
		echo '</td></tr>';
	} else if ( empty( $done ) ) {
		echo '<tr>';
		echo '<td>Reassign Attributes</td>';
		echo '<td><a class="button" href="' . admin_url( 'edit.php?post_type=al_product&page=system.php&reassign_all_products_attributes=1' ) . '">Reassign attributes</a>';
		echo '</td></tr>';
	}
	if ( wp_get_schedule( 'ic_scheduled_attributes_clear' ) ) {
		if ( isset( $_GET[ 'clear_products_attributes' ] ) ) {
			ic_clear_empty_attributes();
		}
	}
	if ( wp_get_schedule( 'ic_scheduled_attributes_clear' ) ) {
		echo '<tr>';
		echo '<td>Clear Attributes</td>';
		echo '<td><a class="button" href="' . admin_url( 'edit.php?post_type=al_product&page=system.php&clear_products_attributes=1' ) . '">Speed UP Clearing Empty Attributes</a></td>';
		echo '</tr>';
	}
}

/**
 * Returns attribute ID by label
 * @param type $label
 * @return boolean
 */
function ic_get_attribute_id( $label ) {
	$cache_meta	 = 'attr_label_id' . $label;
	$label_id	 = ic_get_global( $cache_meta );
	if ( $label_id !== false ) {
		return $label_id;
	}
	$attribute = get_term_by( 'name', $label, 'al_product-attributes' );
	if ( $attribute ) {
		$label_id = intval( $attribute->term_id );
		if ( !empty( $label_id ) ) {
			ic_save_global( $cache_meta, $label_id );
			return $label_id;
		}
	}
	return false;
}

/**
 * Returns attribute name when ID is provided
 *
 * @param int $attribute_id
 * @return boolean|string
 */
function ic_get_attribute_name( $attribute_id ) {
	$cache_meta	 = 'attr_name' . $attribute_id;
	$attr_name	 = ic_get_global( $cache_meta );
	if ( $attr_name !== false ) {
		return $attr_name;
	}
	$attribute = get_term_by( 'id', $attribute_id, 'al_product-attributes' );
	if ( $attribute && $attribute->count > 0 ) {
		$attr_name = $attribute->name;
		if ( !empty( $attr_name ) ) {
			ic_save_global( $cache_meta, $attr_name );
			return $attr_name;
		}
	}
	return false;
}

/**
 * Returns available attribute values as array
 *
 * @param type $label
 * @return boolean
 */
function ic_get_attribute_values( $label, $format = 'names', $current = false, $product_ids = array() ) {
	$cache_key	 = 'attribute_values' . $label . $format . array_sum( $product_ids ) . count( $product_ids );
	$attributes	 = ic_get_global( $cache_key );
	if ( false === $attributes ) {
		$attribute_id = ic_get_attribute_id( $label );
		if ( $attribute_id === false ) {
			return false;
		}
		$pre_get_attribute_values = apply_filters( 'ic_pre_get_attribute_values', false, $attribute_id, $current, $product_ids );
		if ( $pre_get_attribute_values !== false ) {
			return $pre_get_attribute_values;
		}
		//$values			 = get_term_children( $attribute_id, 'al_product-attributes' );
		$args = array(
			'taxonomy'		 => 'al_product-attributes',
			'hide_empty'	 => true,
			'parent'		 => $attribute_id,
			'fields'		 => 'id=>name',
			'ic_post_type'	 => array( get_current_screen_post_type() )
		);
		if ( !empty( $product_ids ) && is_array( $product_ids ) ) {
			$args[ 'object_ids' ]	 = array_map( 'intval', $product_ids );
			$current				 = false;
		}
		if ( $current ) {
			$current_products = ic_get_current_products( array(), array( 'al_product-attributes' ) );
			if ( !empty( $current_products ) && $current_products !== 'all' ) {
				$args[ 'object_ids' ] = $current_products;
			} else if ( empty( $current_products ) ) {
				return false;
			}
		}
		if ( $current || (!empty( $current_products ) && $current_products === 'all') ) {
			$current_cache_meta	 = 'current_products_attributes' . intval( false ) . intval( true ) . intval( $attribute_id );
			$values				 = ic_get_global( $current_cache_meta );
			if ( $values !== false ) {
				return $values;
			}
		}

		$values = ic_get_terms( $args );
		if ( empty( $values ) || is_wp_error( $values ) || !is_array( $values ) ) {
			return false;
		}
		foreach ( $values as $term_id => $term_name ) {
			$cache_meta = 'attr_value_id' . $attribute_id . $term_name;
			ic_save_global( $cache_meta, $term_id );
		}
		if ( $format === 'names' ) {
			$values = array_values( $values );
			if ( !empty( $current_cache_meta ) ) {
				ic_save_global( $current_cache_meta, $values );
			}
		} else if ( $format === 'ids' ) {
			$values = array_keys( $values );
		}
		$attributes = $values;
		if ( !empty( $cache_key ) ) {
			ic_save_global( $cache_key, $attributes );
		}
	}
	return $attributes;
}

/**
 * Sanitize attribute before adding as taxonomy
 *
 * @param type $attribute
 * @return type
 */
function ic_sanitize_product_attribute( $attribute ) {
	if ( is_array( $attribute ) ) {
		$sanitized_attribute = array_map( 'ic_sanitize_product_attribute', $attribute );
		if ( !empty( $sanitized_attribute[ 0 ] ) && is_array( $sanitized_attribute[ 0 ] ) ) {
			return $sanitized_attribute[ 0 ];
		}
		return $sanitized_attribute;
	} else if ( ic_string_contains( $attribute, '{' ) ) {
		$unserialized = unserialize( $attribute );
		if ( !empty( $unserialized ) && is_array( $unserialized ) ) {
			return ic_sanitize_product_attribute( $unserialized );
		}
	}
	$sanitized_attribute = trim( wp_unslash( sanitize_term_field( 'name', $attribute, 0, 'al_product-attributes', 'db' ) ) );
	if ( strlen( $sanitized_attribute ) > 200 ) {
		return '';
	}
	return $sanitized_attribute;
}

function ic_delete_all_attribute_terms() {
	global $wpdb;
	$taxonomy	 = 'al_product-attributes';
	$terms		 = $wpdb->get_results( $wpdb->prepare( "SELECT t.*, tt.* FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ('%s') ORDER BY t.name ASC", $taxonomy ) );

	// Delete Terms
	if ( $terms ) {
		foreach ( $terms as $term ) {
			$wpdb->delete( $wpdb->term_taxonomy, array( 'term_taxonomy_id' => $term->term_taxonomy_id ) );
			$wpdb->delete( $wpdb->term_relationships, array( 'term_taxonomy_id' => $term->term_taxonomy_id ) );
			$wpdb->delete( $wpdb->terms, array( 'term_id' => $term->term_id ) );
		}
	}
}

if ( !function_exists( 'get_all_attribute_labels' ) ) {

	/**
	 * Returns all attrubutes labels
	 *
	 * @return type
	 */
	function get_all_attribute_labels() {
		$post_type			 = get_current_screen_post_type();
		$cache_key			 = 'all_attribute_labels_' . $post_type;
		$attributes_labels	 = ic_get_global( $cache_key );
		if ( false === $attributes_labels ) {
			$attributes_labels = ic_get_terms( array(
				'taxonomy'		 => 'al_product-attributes',
				'parent'		 => 0,
				'fields'		 => 'names',
				'hide_empty'	 => true,
				'ic_post_type'	 => array( $post_type )
			) );
			if ( !empty( $cache_key ) ) {
				ic_save_global( $cache_key, $attributes_labels );
			}
		}
		return $attributes_labels;
	}

}

if ( !function_exists( 'get_all_attribute_values' ) ) {

	/**
	 * Returns all attrubutes labels
	 *
	 * @return type
	 */
	function get_all_attribute_values( $product_id = null ) {
		if ( !empty( $product_id ) ) {
			$post_type = get_post_type( $product_id );
		} else {
			$post_type = get_current_screen_post_type();
		}
		$cache_key			 = 'all_attribute_values_' . $post_type . $product_id;
		$attributes_values	 = ic_get_global( $cache_key );
		if ( false === $attributes_values ) {
			$args = array(
				'taxonomy'	 => 'al_product-attributes',
				'fields'	 => 'names',
				'hide_empty' => true,
				'childless'	 => true
			);
			if ( !empty( $product_id ) ) {
				$args[ 'object_ids' ] = intval( $product_id );
			} else {
				$args[ 'ic_post_type' ] = array( $post_type );
			}

			$attributes_values = ic_get_terms( $args );
			if ( !empty( $cache_key ) ) {
				ic_save_global( $cache_key, $attributes_values );
			}
		}
		return $attributes_values;
	}

}

add_filter( 'wp_unique_term_slug', 'ic_wp_unique_slug_bug_fix', 10, 2 );

function ic_wp_unique_slug_bug_fix( $slug, $term ) {
	global $wpdb;
	if ( !empty( $term->term_id ) ) {
		$query = $wpdb->prepare( "SELECT slug FROM $wpdb->terms WHERE slug = %s AND term_id != %d", $slug, $term->term_id );
	} else {
		$query = $wpdb->prepare( "SELECT slug FROM $wpdb->terms WHERE slug = %s", $slug );
	}

	if ( $wpdb->get_var( $query ) ) {
		$num = 2;
		do {
			$alt_slug	 = $slug . "-$num";
			$num++;
			$slug_check	 = $wpdb->get_var( $wpdb->prepare( "SELECT slug FROM $wpdb->terms WHERE slug = %s", $alt_slug ) );
		} while ( $slug_check );
		$slug = $alt_slug;
	}
	return $slug;
}
