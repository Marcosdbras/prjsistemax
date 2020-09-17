<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Manages catalog default theme
 *
 * Here default theme is defined and managed.
 *
 * @version        1.1.4
 * @package        ecommerce-product-catalog/templates/themes
 * @author        impleCode
 */

/**
 * Shows example modern grid in product settings
 *
 */
function example_default_archive_theme() {
	$modern_grid_settings = get_modern_grid_settings();
	?>
	<div id="content">
		<a href="#default-theme">
			<div class="al_archive"
				 style="background-image:url('<?php echo AL_PLUGIN_BASE_PATH . 'templates/themes/img/example-product.jpg'; ?>'); background-position:center; ">
				<div class="product-name">White Lamp</div>
				<?php if ( $modern_grid_settings[ 'attributes' ] == 1 ) { ?>
					<div class="product-attributes">
						<table class="attributes-table">
							<tbody>
								<tr>
									<td>Height</td>
									<td>20</td>
								</tr>
								<tr>
									<td>Color</td>
									<td>White</td>
								</tr>
							</tbody>
						</table>
					</div> <?php } ?>
				<div class="product-price">10 USD</div>
			</div>
		</a>
	</div>
	<?php
}

/**
 * Returns modern grid element for a given product
 *
 * @param object $post Product post object
 * @param string $archive_template
 * @return string
 */
function get_default_archive_theme( $post, $archive_template = null ) {
	$archive_template	 = isset( $archive_template ) ? $archive_template : get_product_listing_template();
	$return				 = '';
	if ( $archive_template == 'default' ) {
		remove_all_filters( 'ic_listing_image_html' );
		add_filter( 'ic_listing_image_html', 'ic_set_modern_grid_image_html', 10, 2 );
		if ( !has_filter( 'product-class', 'ic_modern_grid_size_class' ) ) {
			add_filter( 'product-class', 'ic_modern_grid_size_class', 10, 2 );
		}
		ob_start();
		ic_show_template_file( 'product-listing/modern-grid.php' );
		$return = ob_get_clean();
	}
	return $return;
}

function ic_modern_grid_size_class( $class, $product_id ) {
	$image_id = get_post_thumbnail_id( $product_id );
	if ( !empty( $image_id ) ) {
		$thumbnail_product	 = wp_get_attachment_image_src( $image_id, 'modern-grid-listing' );
		$class				 .= product_listing_size_class( $thumbnail_product );
	}
	return $class;
}

function ic_modern_grid_category_size_class( $class, $category_id ) {
	$image_id = get_product_category_image_id( $category_id );
	if ( !empty( $image_id ) ) {
		$thumbnail_product	 = wp_get_attachment_image_src( $image_id, 'modern-grid-listing' );
		$class				 .= product_listing_size_class( $thumbnail_product );
	}
	return $class;
}

function ic_set_modern_grid_image_html( $image_html, $product_id ) {
	$sizes				 = ic_get_catalog_image_sizes();
	$image_id			 = get_post_thumbnail_id( $product_id );
	$thumbnail_product	 = wp_get_attachment_image_src( $image_id, 'modern-grid-listing' );
	$product_name		 = wp_strip_all_tags( get_the_title() );
	if ( $thumbnail_product ) {
		$url					 = $thumbnail_product[ 0 ];
		$img_class[ 'alt' ]		 = $product_name;
		$img_class[ 'class' ]	 = "modern-grid-image";
		if ( !empty( $thumbnail_product[ 2 ] ) ) {
			$ratio = $thumbnail_product[ 1 ] / $thumbnail_product[ 2 ];
			if ( $ratio <= 1.35 && $ratio > 1.20 ) {
				$img_class[ 'class' ] .= " higher";
			} else if ( $ratio <= 1.15 && $sizes[ 'modern_grid_image_w' ] >= 600 ) {
				$img_class[ 'class' ] .= " higher rect";
			} else if ( $ratio > 2 && $sizes[ 'modern_grid_image_h' ] >= 384 ) {
				$img_class[ 'class' ] .= " wider rect";
			}
		}
		$image_html = wp_get_attachment_image( $image_id, 'modern-grid-listing', false, $img_class );
	} else {
		$url = default_product_thumbnail_url();
		if ( $sizes[ 'modern_grid_image_h' ] != 384 || $sizes[ 'modern_grid_image_w' ] != 600 && !ic_string_contains( $url, 'no-default-thumbnail' ) ) {
			$image_id = intval( get_product_image_id( $url ) );
		}
		if ( !empty( $image_id ) ) {
			$img_class[ 'alt' ]		 = $product_name;
			$img_class[ 'class' ]	 = "modern-grid-image";
			$image_html				 = wp_get_attachment_image( $image_id, 'modern-grid-listing', false, $img_class );
		} else {
			$image_html = '<img class="modern-grid-image" src="' . $url . '" alt="' . $product_name . '">';
		}
	}
	return $image_html;
}

function ic_set_modern_grid_category_image_html( $product_cat ) {
	$image_id			 = get_product_category_image_id( $product_cat->term_id );
	$thumbnail_product	 = wp_get_attachment_image_src( $image_id, 'modern-grid-listing' );
	if ( $thumbnail_product ) {
		$img_class[ 'alt' ]		 = $product_cat->name;
		$img_class[ 'class' ]	 = 'modern-grid-image';
		$url					 = $thumbnail_product[ 0 ];
		if ( !empty( $thumbnail_product[ 2 ] ) ) {
			$ratio = $thumbnail_product[ 1 ] / $thumbnail_product[ 2 ];
			if ( $ratio <= 1.35 ) {
				$img_class[ 'class' ] .= ' higher';
			}
		}
		$image = wp_get_attachment_image( $image_id, 'modern-grid-listing', false, $img_class );
	} else {
		$url	 = default_product_thumbnail_url();
		$image	 = '<img class="modern-grid-image" src="' . $url . '" alt="' . $product_cat->name . '">';
	}
	$product_cat->listing_image_html = $image;
	return $product_cat;
}

/**
 * Returns modern grid element for a given product category
 *
 * @param object $product_cat Product category object
 * @param string $archive_template
 * @return string
 */
function get_default_category_theme( $product_cat, $archive_template ) {
	if ( $archive_template == 'default' ) {
		$product_cat = ic_set_modern_grid_category_image_html( $product_cat );
		if ( !has_filter( 'product-category-class', 'ic_modern_grid_category_size_class' ) ) {
			add_filter( 'product-category-class', 'ic_modern_grid_category_size_class', 10, 2 );
		}
		ic_save_global( 'ic_current_product_cat', $product_cat );
		ob_start();
		ic_show_template_file( 'product-listing/modern-grid-category.php' );
		$return = ob_get_clean();
		return $return;
	}
}

/**
 * Returns modern grid element class based on size ratio
 *
 * @param array $image
 * @return string
 */
function product_listing_size_class( $image ) {
	$class = '';
	if ( is_array( $image ) && $image[ 1 ] > 1.7 * $image[ 2 ] ) {
		$class = 'wider-bg';
	}
	return $class;
}

add_filter( 'product-list-class', 'add_modern_lising_class', 10, 3 );

/**
 * Adds per row class to modern grid product listing container
 *
 * @param string $class
 * @return string
 */
function add_modern_lising_class( $class, $where = '', $archive_template = 'default' ) {
	if ( $archive_template == 'default' ) {
		$settings			 = get_modern_grid_settings();
		$shortcode_per_row	 = ic_get_global( 'shortcode_per_row' );
		if ( $shortcode_per_row ) {
			$settings[ 'per-row' ] = $shortcode_per_row;
		}
		$class .= ' per-row-' . $settings[ 'per-row' ];
	}
	ic_delete_global( 'shortcode_per_row' );
	return $class;
}

add_filter( 'product_listing_additional_styles', 'ic_cat_modern_grid_additional_styling', 10, 2 );

/**
 * Adds classic grid inline styling for element width
 *
 * @param string $styles
 * @return string
 */
function ic_cat_modern_grid_additional_styling( $styles, $archive_template ) {
	if ( $archive_template == 'default' ) {
		$sizes = ic_get_catalog_image_sizes();
		if ( !empty( $sizes[ 'modern_grid_image_h' ] ) && $sizes[ 'modern_grid_image_h' ] < 384 ) {
			$styles .= '.modern-grid-element { max-height: ' . $sizes[ 'modern_grid_image_h' ] . 'px; }';
		}
		if ( !empty( $sizes[ 'modern_grid_image_w' ] ) && $sizes[ 'modern_grid_image_w' ] < 600 ) {
			$styles .= '.modern-grid-element { max-width: ' . $sizes[ 'modern_grid_image_w' ] . 'px; }';
		}
	}
	return $styles;
}
