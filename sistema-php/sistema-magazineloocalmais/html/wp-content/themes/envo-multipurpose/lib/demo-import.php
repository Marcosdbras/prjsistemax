<?php

/**
 * One click demo import
 */

/**
 * Set import files
 */
function envo_multipurpose_ocdi_import_files() {
	return array(
		array(
			'import_file_name'				 => 'Default demo',
			'local_import_file'				 => trailingslashit( get_template_directory() ) . 'includes/demo/default/default-content.xml',
			'local_import_widget_file'		 => trailingslashit( get_template_directory() ) . 'includes/demo/default/default-widgets.wie',
			'local_import_customizer_file'	 => trailingslashit( get_template_directory() ) . 'includes/demo/default/default-customizer.dat',
			'import_preview_image_url'		 => trailingslashit( get_template_directory_uri() ) . 'screenshot.jpg',
			'import_notice'					 => sprintf( __( 'Before importing, install and activate these plugins: %1$s, %2$s', 'envo-multipurpose' ), '<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/woocommerce/' ) . '">WooCommerce</a>', '<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/contact-form-7/' ) . '">Contact Form 7</a>' ),
			'preview_url'					 => esc_url( 'https://envothemes.com/envo-multipurpose/' ),
		),
		array(
			'import_file_name'				 => 'Portfolio demo',
			'local_import_file'				 => trailingslashit( get_template_directory() ) . 'includes/demo/portfolio/portfolio-content.xml',
			'local_import_widget_file'		 => trailingslashit( get_template_directory() ) . 'includes/demo/portfolio/portfolio-widgets.wie',
			'local_import_customizer_file'	 => trailingslashit( get_template_directory() ) . 'includes/demo/portfolio/portfolio-customizer.dat',
			'import_preview_image_url'		 => trailingslashit( get_template_directory_uri() ) . 'includes/demo/portfolio/screenshot.jpg',
			'import_notice'					 => sprintf( __( 'Before importing, install and activate this plugin: %1$s', 'envo-multipurpose' ), '<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/visual-portfolio/' ) . '">Visual Portfolio</a>' ),
			'preview_url'					 => esc_url( 'https://envothemes.com/envo-multipurpose-portfolio/' ),
		),
		array(
			'import_file_name'				 => 'WooCommerce demo',
			'local_import_file'				 => trailingslashit( get_template_directory() ) . 'includes/demo/woocommerce/woocommerce-content.xml',
			'local_import_widget_file'		 => trailingslashit( get_template_directory() ) . 'includes/demo/woocommerce/woocommerce-widgets.wie',
			'local_import_customizer_file'	 => trailingslashit( get_template_directory() ) . 'includes/demo/woocommerce/woocommerce-customizer.dat',
			'import_preview_image_url'		 => trailingslashit( get_template_directory_uri() ) . 'includes/demo/woocommerce/screenshot.jpg',
			'import_notice'					 => sprintf( __( 'Before importing, install and activate these plugins: %1$s, %2$s', 'envo-multipurpose' ), '<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/woocommerce/' ) . '">WooCommerce</a>', '<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/contact-form-7/' ) . '">Contact Form 7</a>' ),
			'preview_url'					 => esc_url( 'https://envothemes.com/envo-multipurpose-woocommerce/' ),
		),
		array(
			'import_file_name'				 => 'KingComposer demo',
			'local_import_file'				 => trailingslashit( get_template_directory() ) . 'includes/demo/kingcomposer/kingcomposer-content.xml',
			'local_import_widget_file'		 => trailingslashit( get_template_directory() ) . 'includes/demo/kingcomposer/kingcomposer-widgets.wie',
			'local_import_customizer_file'	 => trailingslashit( get_template_directory() ) . 'includes/demo/kingcomposer/kingcomposer-customizer.dat',
			'import_preview_image_url'		 => trailingslashit( get_template_directory_uri() ) . 'includes/demo/kingcomposer/screenshot.jpg',
			'import_notice'					 => sprintf( __( 'Before importing, install and activate these plugins: %1$s, %2$s', 'envo-multipurpose' ), '<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/kingcomposer/' ) . '">KingComposer</a>', '<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/contact-form-7/' ) . '">Contact Form 7</a>' ),
			'preview_url'					 => esc_url( 'https://envothemes.com/envo-multipurpose-kingcomposer/' ),
		),
		array(
			'import_file_name'				 => 'Brizy demo',
			'local_import_file'				 => trailingslashit( get_template_directory() ) . 'includes/demo/brizy/brizy-content.xml',
			'local_import_widget_file'		 => trailingslashit( get_template_directory() ) . 'includes/demo/brizy/brizy-widgets.wie',
			'local_import_customizer_file'	 => trailingslashit( get_template_directory() ) . 'includes/demo/brizy/brizy-customizer.dat',
			'import_preview_image_url'		 => trailingslashit( get_template_directory_uri() ) . 'includes/demo/brizy/screenshot.jpg',
			'import_notice'					 => sprintf( __( 'Before importing, install and activate this plugin: %1$s', 'envo-multipurpose' ), '<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/brizy/' ) . '">Brizy</a>' ),
			'preview_url'					 => esc_url( 'https://envothemes.com/envo-multipurpose-brizy/' ),
		),
		array(
			'import_file_name'				 => 'Elementor demo',
			'local_import_file'				 => trailingslashit( get_template_directory() ) . 'includes/demo/elementor/elementor-content.xml',
			'local_import_widget_file'		 => trailingslashit( get_template_directory() ) . 'includes/demo/elementor/elementor-widgets.wie',
			'local_import_customizer_file'	 => trailingslashit( get_template_directory() ) . 'includes/demo/elementor/elementor-customizer.dat',
			'import_preview_image_url'		 => trailingslashit( get_template_directory_uri() ) . 'includes/demo/elementor/screenshot.jpg',
			'import_notice'					 => sprintf( __( 'Before importing, install and activate this plugin: %1$s', 'envo-multipurpose' ), '<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/elementor/' ) . '">Elementor</a>' ),
			'preview_url'					 => esc_url( 'https://envothemes.com/envo-multipurpose-elementor/' ),
		),
	);
}

add_filter( 'pt-ocdi/import_files', 'envo_multipurpose_ocdi_import_files' );

/**
 * Clear sidebars during import
 */
function envo_multipurpose_ocdi_before_widgets_import( $selected_import ) {
	$clear_sidebars = array(
		'envo-multipurpose-right-sidebar',
		'envo-multipurpose-header-area',
		'envo-multipurpose-menu-area',
		'envo-multipurpose-footer-area',
		'envo-multipurpose-homepage-area',
	);

	/*
	 * if ( $selected_import['import_file_name'] == 'Full Demo Import' ) {
	 *     array_unshift( $clear_sidebars, 'sidebar-1' );
	 * }
	 */

	$sidebars_widgets = get_option( 'sidebars_widgets' );

	if ( is_array( $sidebars_widgets ) ) {
		foreach ( $sidebars_widgets as $sidebar_id => $widgets ) {
			if ( in_array( $sidebar_id, $clear_sidebars ) ) {
				if ( is_array( $widgets ) ) {
					foreach ( $widgets as $key => $widget_id ) {
						$pieces			 = explode( '-', $widget_id );
						$multi_number	 = array_pop( $pieces );
						$id_base		 = implode( '-', $pieces );
						$widget			 = get_option( 'widget_' . $id_base );
						unset( $widget[ $multi_number ] );
						update_option( 'widget_' . $id_base, $widget );
						unset( $sidebars_widgets[ $sidebar_id ][ $key ] );
					}
				}
			}
		}
	}

	wp_set_sidebars_widgets( $sidebars_widgets );
}

add_action( 'pt-ocdi/before_widgets_import', 'envo_multipurpose_ocdi_before_widgets_import' );

/**
 * Cleared problem with refreshing page after import.
 */
function envo_multipurpose_current_screen( $current_screen ) {
	if ( 'appearance_page_pt-one-click-demo-import' == $current_screen->base ) {
		delete_transient( 'ocdi_importer_data' );
	}
}

add_action( 'current_screen', 'envo_multipurpose_current_screen' );

/**
 * Automate common changes after import
 */
function envo_multipurpose_after_import_setup() {
	// Assign menus to their locations.
	$main_menu	 = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	$top_left	 = get_term_by( 'name', 'top left', 'nav_menu' );
	$top_right	 = get_term_by( 'name', 'top right', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
		'main_menu'		 => $main_menu->term_id,
		'top_menu_left'	 => $top_left->term_id,
		'top_menu_right' => $top_right->term_id,
	)
	);

	// Assign front page and posts page (blog page).
	$front_page_id	 = get_page_by_title( 'Homepage' );
	$blog_page_id	 = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );
}

add_action( 'pt-ocdi/after_import', 'envo_multipurpose_after_import_setup' );

/**
 * Disable branding
 */
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/**
 * Better support for slower internet connections
 */
function envo_multipurpose_ocdi_change_time_of_single_ajax_call() {
	return 10;
}

add_action( 'pt-ocdi/time_for_one_ajax_call', 'envo_multipurpose_ocdi_change_time_of_single_ajax_call' );

/**
 * KingComposer templates
 */
function envo_multipurpose_kingcomposer_templates() {

	if ( function_exists( 'kc_prebuilt_template' ) ) {
		$xml_path = trailingslashit( get_template_directory() ) . 'includes/demo/kingcomposer/envo-multipurpose-kc-templates.xml';
		kc_prebuilt_template( 'Envo Multipurpose', $xml_path );
	}
}

add_action( 'after_setup_theme', 'envo_multipurpose_kingcomposer_templates' );
