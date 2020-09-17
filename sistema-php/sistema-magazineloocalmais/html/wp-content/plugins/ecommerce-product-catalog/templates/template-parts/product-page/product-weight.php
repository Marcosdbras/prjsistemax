<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * The template to display product weight on product page or with a shortcode
 *
 * Copy it to your theme implecode folder to edit the output: your-theme-folder-name/implecode/product-weight.php
 *
 * @version		1.1.2
 * @package		ecommerce-product-catalog/templates/template-parts/product-page
 * @author 		impleCode
 */
$product_id		 = ic_get_product_id();
$single_names	 = get_single_names();
$weight			 = ic_get_product_weight( $product_id );
if ( is_ic_attributes_weight_enabled() && !empty( $weight ) ) {
	?>

	<table class="weight-table">
		<tr>
			<td><?php echo $single_names[ 'product_weight' ] ?></td>
			<td class="weight-value"><?php echo $weight ?></td>
		</tr>
	</table>

	<?php
}