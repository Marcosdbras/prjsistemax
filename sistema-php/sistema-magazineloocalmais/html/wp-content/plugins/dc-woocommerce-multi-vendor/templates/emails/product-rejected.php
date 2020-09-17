<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails/product-rejected.php
 *
 * @author 		WC Marketplace
 * @package 	dc-product-vendor/Templates
 * @version   0.0.1
 */


if ( !defined( 'ABSPATH' ) ) exit; 
global  $WCMp;

$title = __( 'Product', 'dc-woocommerce-multi-vendor' );
	
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

	<p><?php printf( __( "Hi there! This is a notification about a %s rejection on %s.",  'dc-woocommerce-multi-vendor' ), $title, get_option( 'blogname' ) ); ?></p>

	<p>
		<?php printf( __( "%s title: %s",  'dc-woocommerce-multi-vendor' ), $title, $product_name ); ?><br/>
		<?php printf( __( "Submitted by: %s",  'dc-woocommerce-multi-vendor' ), $vendor_name ); ?><br/>
		<?php printf( __( "Rejection Note: %s",  'dc-woocommerce-multi-vendor' ), $reason ); ?><br/>
		<?php 
                $product_link = apply_filters( 'wcmp_email_vendor_rejected_product_link', esc_url(wcmp_get_vendor_dashboard_endpoint_url(get_wcmp_vendor_settings('wcmp_edit_product_endpoint', 'vendor', 'general', 'edit-product'), $post_id)));
                printf( __( "Edit %s: %s",  'dc-woocommerce-multi-vendor' ), $title, $product_link ); ?>
		<br/>
	</p>

<?php do_action( 'wcmp_email_footer' ); ?>