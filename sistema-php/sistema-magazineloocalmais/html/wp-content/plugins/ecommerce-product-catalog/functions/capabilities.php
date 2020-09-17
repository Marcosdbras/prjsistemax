<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages capabilities
 *
 * Here all capabilities are defined and managed.
 *
 * @version		1.0.0
 * @package		ecommerce-product-catalog/includes
 * @author 		impleCode
 */
add_action( 'admin_init', 'ic_restore_product_caps' );

/**
 * Restores product capabilities if admin doesn't have proper rights
 *
 */
function ic_restore_product_caps() {
	if ( !current_user_can( 'manage_product_settings' ) && current_user_can( 'administrator' ) ) {
		add_product_caps( false );
	}
}

function add_product_caps( $additional = true ) {
	if ( is_user_logged_in() && current_user_can( 'activate_plugins' ) ) {

		$role = get_role( 'administrator' );

		$role->add_cap( 'publish_products' );
		$role->add_cap( 'edit_products' );
		$role->add_cap( 'edit_others_products' );
		$role->add_cap( 'edit_private_products' );
		$role->add_cap( 'delete_products' );
		$role->add_cap( 'delete_others_products' );
		$role->add_cap( 'read_private_products' );
		$role->add_cap( 'delete_private_products' );
		$role->add_cap( 'delete_published_products' );
		$role->add_cap( 'edit_published_products' );
		$role->add_cap( 'manage_product_categories' );
		$role->add_cap( 'edit_product_categories' );
		$role->add_cap( 'delete_product_categories' );
		$role->add_cap( 'assign_product_categories' );
		$role->add_cap( 'manage_product_settings' );

		if ( $additional ) {
			$current_user = wp_get_current_user();
			if ( !empty( $current_user->roles ) && is_array( $current_user->roles ) ) {
				foreach ( $current_user->roles as $current_role ) {
					if ( $current_role == 'administrator' ) {
						break;
					}
					$role			 = get_role( $current_role );
					$capabilities	 = $role->capabilities;
					if ( !empty( $capabilities[ 'activate_plugins' ] ) ) {
						$role->add_cap( 'publish_products' );
						$role->add_cap( 'edit_products' );
						$role->add_cap( 'edit_others_products' );
						$role->add_cap( 'edit_private_products' );
						$role->add_cap( 'delete_products' );
						$role->add_cap( 'delete_others_products' );
						$role->add_cap( 'read_private_products' );
						$role->add_cap( 'delete_private_products' );
						$role->add_cap( 'delete_published_products' );
						$role->add_cap( 'edit_published_products' );
						$role->add_cap( 'manage_product_categories' );
						$role->add_cap( 'edit_product_categories' );
						$role->add_cap( 'delete_product_categories' );
						$role->add_cap( 'assign_product_categories' );
						$role->add_cap( 'manage_product_settings' );
					}
				}
			}
			ic_add_catalog_manager_role();
		}
	}
}

function ic_add_catalog_manager_role() {
	$manager_role = get_role( 'catalog_manager' );
	if ( !empty( $manager_role ) ) {
		return;
	}
	$role = get_role( 'editor' );
	if ( !empty( $role ) ) {
		$capabilities = $role->capabilities;
	} else {
		$capabilities = array();
	}
	$manager_role = add_role( 'catalog_manager', __( 'Catalog Manager', 'ecommerce-product-catalog' ), $capabilities );
	if ( is_object( $manager_role ) ) {
		if ( empty( $capabilities ) ) {
			$manager_role->add_cap( 'moderate_comments' );
			//$manager_role->add_cap( 'manage_categories' );
			$manager_role->add_cap( 'manage_links' );
			$manager_role->add_cap( 'upload_files' );
			$manager_role->add_cap( 'unfiltered_html' );
			$manager_role->add_cap( 'edit_posts' );
			//$manager_role->add_cap( 'edit_others_posts' );
			$manager_role->add_cap( 'edit_published_posts' );
			$manager_role->add_cap( 'publish_posts' );
			$manager_role->add_cap( 'edit_pages' );
			$manager_role->add_cap( 'read' );
			$manager_role->add_cap( 'level_7' );
			$manager_role->add_cap( 'level_6' );
			$manager_role->add_cap( 'level_5' );
			$manager_role->add_cap( 'level_4' );
			$manager_role->add_cap( 'level_3' );
			$manager_role->add_cap( 'level_2' );
			$manager_role->add_cap( 'level_1' );
			$manager_role->add_cap( 'level_0' );
		}

		$manager_role->add_cap( 'publish_products' );
		$manager_role->add_cap( 'edit_products' );
		$manager_role->add_cap( 'edit_others_products' );
		$manager_role->add_cap( 'edit_private_products' );
		$manager_role->add_cap( 'delete_products' );
		$manager_role->add_cap( 'delete_others_products' );
		$manager_role->add_cap( 'read_private_products' );
		$manager_role->add_cap( 'delete_private_products' );
		$manager_role->add_cap( 'delete_published_products' );
		$manager_role->add_cap( 'edit_published_products' );
		$manager_role->add_cap( 'manage_product_categories' );
		$manager_role->add_cap( 'edit_product_categories' );
		$manager_role->add_cap( 'delete_product_categories' );
		$manager_role->add_cap( 'assign_product_categories' );
	}
}

add_filter( 'map_meta_cap', 'ic_products_map_meta_cap', 10, 4 );

function ic_products_map_meta_cap( $caps, $cap, $user_id, $args ) {
	if ( empty( $args[ 0 ] ) ) {
		return $caps;
	}
	/* If editing, deleting, or reading a product, get the post and post type object. */
	if ( 'edit_product' == $cap || 'delete_product' == $cap || 'read_product' == $cap ) {
		$post		 = get_post( $args[ 0 ] );
		$post_type	 = get_post_type_object( $post->post_type );

		/* Set an empty array for the caps. */
		$caps = array();
	}

	/* If editing a product, assign the required capability. */
	if ( 'edit_product' == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[]	 = $post_type->cap->edit_posts;
		else
			$caps[]	 = $post_type->cap->edit_others_posts;
	}

	/* If deleting a product, assign the required capability. */ elseif ( 'delete_product' == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[]	 = $post_type->cap->delete_posts;
		else
			$caps[]	 = $post_type->cap->delete_others_posts;
	}

	/* If reading a private product, assign the required capability. */ elseif ( 'read_product' == $cap ) {

		if ( 'private' != $post->post_status )
			$caps[]	 = 'read';
		elseif ( $user_id == $post->post_author )
			$caps[]	 = 'read';
		else
			$caps[]	 = $post_type->cap->read_private_posts;
	}

	/* Return the capabilities required by the user. */
	return $caps;
}
