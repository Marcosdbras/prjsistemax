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
add_action( 'single_names_table_start', 'ic_mpn_single_names' );

/**
 * Shows mpn product page labels settings
 *
 * @param type $single_names
 */
function ic_mpn_single_names( $single_names ) {
	?>
	<tr><td><?php _e( 'MPN Label', 'ecommerce-product-catalog' ); ?></td><td><input type="text" name="single_names[product_mpn]" value="<?php echo esc_html( $single_names[ 'product_mpn' ] ); ?>" /></td></tr>
	<?php
}

add_action( 'ic_epc_additional_settings', 'ic_mpn_settings' );

/**
 * Shows price settings
 *
 */
function ic_mpn_settings( $archive_multiple_settings ) {
	?>
	<table>
		<?php
		implecode_settings_checkbox( __( 'Disable MPN', 'ecommerce-product-catalog' ), 'archive_multiple_settings[disable_mpn]', $archive_multiple_settings[ 'disable_mpn' ] );
		?>
	</table>
	<?php
}
