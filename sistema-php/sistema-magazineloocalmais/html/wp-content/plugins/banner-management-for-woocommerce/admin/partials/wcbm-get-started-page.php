<?php

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
?>
    <div class="wcbm-section-left">
        <div class="wcbm-main-table res-cl">
        <h2><?php 
esc_html_e( 'Thanks For Installing Category Banner Management for Woocommerce', 'woo-banner-management' );
?>
        </h2>
        <table class="table-outer">
            <tbody>
            <tr>
                <td class="fr-2">
                    <p class="block gettingstarted"><strong><?php 
esc_html_e( 'Getting Started', 'woo-banner-management' );
?> </strong></p>
                    <p class="block textgetting">
                        <?php 
esc_html_e( 'Category Banner Management for Woocommerce plugin that allows you to manage page and category wise banners in your WooCommerce store.You can easily add banner in WooCommerce stores and you can upload the banner specific for page and category. You can easily add banner in WooCommerce stores and you can upload the banner specific for page,category and welcome page.', 'woo-banner-management' );
?>

                    </p>
                    <p class="block textgetting">
                        <?php 
esc_html_e( 'Add banner on Shop,Cart,Checkout,Product Category and Thankyou page.', 'woo-banner-management' );
?>
                    </p>
                    <span class="gettingstarted">
                        <?php 
?>
                            <img src="<?php 
echo  esc_url( plugins_url( '/images/Getting_Started_01.png', dirname( __FILE__ ) ) ) ;
?>">
                        <?php 
?>
                    </span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    </div>
<?php 
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php';