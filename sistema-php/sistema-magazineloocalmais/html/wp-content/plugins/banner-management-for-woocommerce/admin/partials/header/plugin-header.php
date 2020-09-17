<?php

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
global  $wcbm_fs ;
$plugin_version = WCBM_PLUGIN_VERSION;
?>
<div id="dotsstoremain">
    <div class="all-pad">
        <header class="dots-header">
            <div class="dots-logo-main">
                <img src="<?php 
echo  esc_url( plugins_url( 'images/wcbm-logo.png', dirname( dirname( __FILE__ ) ) ) ) ;
?>">
            </div>
            <div class="dots-header-right">
                <?php 
?>
                    <div class="logo-detail">
                    <strong><?php 
esc_html_e( 'Category Banner Management for Woocommerce', 'woo-banner-management' );
?></strong>
                    <span><?php 
esc_html_e( 'Free Version', 'woo-banner-management' );
?> <?php 
echo  esc_html( $plugin_version ) ;
?></span>
                     </div>
                    <?php 
?>

                <div class="button-group">
                    <?php 
?>    
                        <div class="button-dots-left">
                            <span class="support_dotstore_image">
                                <a target="_blank" href="<?php 
echo  esc_url( $wcbm_fs->get_upgrade_url() ) ;
?>">
                                    <img src="<?php 
echo  esc_url( plugins_url( 'images/upgrade_new.png', dirname( dirname( __FILE__ ) ) ) ) ;
?>">    
                                </a>
                            </span>
                        </div>
                    <?php 
?>
                    <div class="button-dots">
                        <?php 
?>
                        <span class="support_dotstore_image">
                            <a target="_blank" href="<?php 
echo  esc_url( 'https://wordpress.org/support/plugin/banner-management-for-woocommerce/' ) ;
?>">
                                <img src="<?php 
echo  esc_url( plugins_url( 'images/support_new.png', dirname( dirname( __FILE__ ) ) ) ) ;
?>"></a>
                        </span>
                    <?php 
?>
                    </div>
                </div>
            </div>

            <?php 
$wcbm_setting = '';
$active_tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
$active_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
$wcbm_getting_started = ( !empty($active_tab) && 'wcbm-plugin-get-started' === $active_tab ? 'active' : '' );
$wcbm_information = ( !empty($active_tab) && 'wcbm-plugin-information' === $active_tab ? 'active' : '' );
if ( empty($active_tab) && 'banner-setting' === $active_page ) {
    $wcbm_setting = 'active';
}

if ( !empty($active_tab) && 'wcbm-plugin-get-started' === $active_tab || !empty($active_tab) && 'wcbm-plugin-information' === $active_tab ) {
    $fee_about = 'active';
} else {
    $fee_about = '';
}

?>
            <div class="dots-menu-main">
                <nav>
                    <ul>
                        <li>
                            
                            <a class="dotstore_plugin <?php 
echo  esc_attr( $wcbm_setting ) ;
?>" href="<?php 
echo  esc_url( admin_url( '/admin.php?page=banner-setting' ) ) ;
?>"><?php 
esc_html_e( 'Banner Settings', 'woo-banner-management' );
?></a>
                        
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php 
echo  esc_attr( $fee_about ) ;
?>" href="<?php 
echo  esc_url( admin_url( '/admin.php?page=banner-setting&tab=wcbm-plugin-get-started' ) ) ;
?>"><?php 
esc_html_e( 'About Plugin', 'woo-banner-management' );
?></a>
                            <ul class="sub-menu">
                                <li><a class="dotstore_plugin <?php 
echo  esc_attr( $wcbm_getting_started ) ;
?>" href="<?php 
echo  esc_url( admin_url( '/admin.php?page=banner-setting&tab=wcbm-plugin-get-started' ) ) ;
?>"><?php 
esc_html_e( 'Getting Started', 'woo-banner-management' );
?></a></li>
                                <li><a class="dotstore_plugin <?php 
echo  esc_attr( $wcbm_information ) ;
?>" href="<?php 
echo  esc_url( admin_url( '/admin.php?page=banner-setting&tab=wcbm-plugin-information' ) ) ;
?>"><?php 
esc_html_e( 'Quick info', 'woo-banner-management' );
?></a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dotstore_plugin"><?php 
esc_html_e( 'Dotstore', 'woo-banner-management' );
?></a>
                            <ul class="sub-menu">
                                <li><a target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/woocommerce-plugins/' ) ;
?>"><?php 
esc_html_e( 'WooCommerce Plugins', 'woo-banner-management' );
?></a></li>
                                <li><a target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/wordpress-plugins/' ) ;
?>"><?php 
esc_html_e( 'Wordpress Plugins', 'woo-banner-management' );
?></a></li><br>
                                <li><a target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/support/' ) ;
?>"><?php 
esc_html_e( 'Contact Support', 'woo-banner-management' );
?></a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>


