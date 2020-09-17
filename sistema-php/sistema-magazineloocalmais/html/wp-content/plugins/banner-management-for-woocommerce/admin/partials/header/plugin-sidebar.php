<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$image_url = plugins_url( 'images/right_click.png', dirname( dirname( __FILE__ ) ) );
$review_url = '';
$plugin_at = '';
$review_url = esc_url( 'https://wordpress.org/plugins/banner-management-for-woocommerce/#reviews' );
$plugin_at = 'WP.org';
?>
<div class="dotstore_plugin_sidebar">
    <div class="dotstore-important-link">
		<div class="image_box">
			<img src="<?php 
echo  esc_url( esc_url( plugins_url( '/images/rate-us.png', dirname( dirname( __FILE__ ) ) ) ) ) ;
?>" alt="">
		</div>
		<div class="content_box">
			<h3>Like This Plugin?</h3>
			<p>Your Review is very important to us as it helps us to grow more.</p>
			<a class="btn_style" href="<?php 
echo  $review_url ;
?>" target="_blank">Review Us on <?php 
echo  $plugin_at ;
?></a>
		</div>
	</div>
    <div class="dotstore-important-link">
        <div class="video-detail important-link">
            <a href="https://www.youtube.com/watch?v=rTL2pyH16Eo" target="_blank">
                <img width="100%"
                     src="<?php 
echo  esc_url( plugins_url( 'images/plugin-videodemo.png', dirname( dirname( __FILE__ ) ) ) ) ;
?>"
                     alt="Advanced Flat Rate Shipping For WooCommerce">
            </a>
        </div>
    </div>

    <div class="dotstore-important-link">
        <h2>
            <span class="dotstore-important-link-title"><?php 
esc_html_e( 'Important link', 'woocommerce-category-banner-management' );
?></span>
        </h2>
        <div class="video-detail important-link">
            <ul>
                <li>
                    <img src="<?php 
echo  esc_url( $image_url ) ;
?>">
                    <a target="_blank"
                       href="<?php 
echo  esc_url( 'store.multidots.com/wp-content/uploads/2017/02/Banner-Management-for-WooCommerce-help-document-.pdf' ) ;
?>"><?php 
esc_html_e( 'Plugin documentation', 'woocommerce-category-banner-management' );
?></a>
                </li>
                <li>
                    <img src="<?php 
echo  esc_url( $image_url ) ;
?>">
                    <a target="_blank"
                       href="<?php 
echo  esc_url( 'https://www.thedotstore.com/support/' ) ;
?>"><?php 
esc_html_e( 'Support platform', 'woocommerce-category-banner-management' );
?></a>
                </li>
                <li>
                    <img src="<?php 
echo  esc_url( $image_url ) ;
?>">
                    <a target="_blank"
                       href="<?php 
echo  esc_url( 'https://www.thedotstore.com/suggest-a-feature/' ) ;
?>"><?php 
esc_html_e( 'Suggest A Feature', 'woocommerce-category-banner-management' );
?></a>
                </li>
                <li>
                    <img src="<?php 
echo  esc_url( $image_url ) ;
?>">
                    <a target="_blank"
                       href="<?php 
echo  esc_url( 'https://www.thedotstore.com/woocommerce-category-banner-management/' ) ;
?>"><?php 
esc_html_e( 'Changelog', 'woocommerce-category-banner-management' );
?></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="dotstore-important-link">
        <h2>
            <span class="dotstore-important-link-title"><?php 
esc_html_e( 'OUR POPULAR PLUGINS', 'woocommerce-category-banner-management' );
?></span>
        </h2>
        <div class="video-detail important-link">
            <ul>
                <li>
                    <img class="sidebar_plugin_icone"
                         src="<?php 
echo  esc_url( plugins_url( 'images/advance-flat-rate2.png', dirname( dirname( __FILE__ ) ) ) ) ;
?>">
                    <a target="_blank"
                       href="<?php 
echo  esc_url( 'https://www.thedotstore.com/advanced-flat-rate-shipping-method-for-woocommerce' ) ;
?>"><?php 
esc_html_e( 'Advanced Flat Rate Shipping Method', 'woocommerce-category-banner-management' );
?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone"
                         src="<?php 
echo  esc_url( plugins_url( 'images/wc-conditional-product-fees.png', dirname( dirname( __FILE__ ) ) ) ) ;
?>">
                    <a target="_blank"
                       href="<?php 
echo  esc_url( 'https://www.thedotstore.com/woocommerce-conditional-product-fees-checkout/' ) ;
?>"><?php 
esc_html_e( 'Conditional Product Fees For WooCommerce Checkout', 'woocommerce-category-banner-management' );
?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone"
                         src="<?php 
echo  esc_url( plugins_url( 'images/advance-menu-manager.png', dirname( dirname( __FILE__ ) ) ) ) ;
?>">
                    <a target="_blank"
                       href="<?php 
echo  esc_url( 'https://www.thedotstore.com/advance-menu-manager-wordpress/' ) ;
?>"><?php 
esc_html_e( 'Advance Menu Manager', 'woocommerce-category-banner-management' );
?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone"
                         src="<?php 
echo  esc_url( plugins_url( 'images/wc-enhanced-ecommerce-analytics-integration.png', dirname( dirname( __FILE__ ) ) ) ) ;
?>">
                    <a target="_blank"
                       href="<?php 
echo  esc_url( 'https://www.thedotstore.com/woocommerce-enhanced-ecommerce-analytics-integration-with-conversion-tracking' ) ;
?>"><?php 
esc_html_e( 'Enhanced Ecommerce Google Analytics For WooCommerce', 'woocommerce-category-banner-management' );
?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone"
                         src="<?php 
echo  esc_url( plugins_url( 'images/advanced-product-size-charts.png', dirname( dirname( __FILE__ ) ) ) ) ;
?>">
                    <a target="_blank"
                       href="<?php 
echo  esc_url( 'https://www.thedotstore.com/woocommerce-advanced-product-size-charts/' ) ;
?>"><?php 
esc_html_e( 'Advanced Product Size Charts For WooCommerce', 'woocommerce-category-banner-management' );
?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone"
                         src="<?php 
echo  esc_url( plugins_url( 'images/wc-blocker-prevent-fake-orders.png', dirname( dirname( __FILE__ ) ) ) ) ;
?>">
                    <a target="_blank"
                       href="<?php 
echo  esc_url( 'https://www.thedotstore.com/product/woocommerce-blocker-lite-prevent-fake-orders-blacklist-fraud-customers/' ) ;
?>"><?php 
esc_html_e( 'Blocker For WooCommerce – Prevent Fake Orders And Blacklist Fraud Customers', 'woocommerce-category-banner-management' );
?></a>
                </li>
            </ul>
        </div>
        <div class="view-button">
            <a class="view_button_dotstore" target="_blank"
               href="<?php 
echo  esc_url( 'https://www.thedotstore.com/plugins/' ) ;
?>"><?php 
esc_html_e( 'VIEW ALL', 'woocommerce-category-banner-management' );
?></a>
        </div>
    </div>

</div>
