<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.multidots.com/
 * @since             1.0.0
 * @package           Woo_Banner_Management
 *
 * @wordpress-plugin
 * Plugin Name: Category Banner Management for Woocommerce
 * Plugin URI:        https://wordpress.org/plugins/banner-management-for-woocommerce/
 * Description:       With this plugin, You can easily add banner in WooCommerce stores and you can upload the banner  specific for page,category  and welcome page.
 * Version:           2.0.4
 * Author:            theDotstore
 * Author URI:        https://www.thedotstore.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-banner-management
 * Domain Path:       /languages
 * WC tested up to: 3.9
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

if ( function_exists( 'wcbm_fs' ) ) {
    wcbm_fs()->set_basename( false, __FILE__ );
    return;
}


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) || function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) {
    
    if ( !function_exists( 'wcbm_fs' ) ) {
        // Create a helper function for easy SDK access.
        function wcbm_fs()
        {
            global  $wcbm_fs ;
            
            if ( !isset( $wcbm_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $wcbm_fs = fs_dynamic_init( array(
                    'id'               => '3494',
                    'slug'             => 'banner-management-for-woocommerce',
                    'type'             => 'plugin',
                    'public_key'       => 'pk_7b4f220ab6fb1f1b92d91f6f7f7b9',
                    'is_premium'       => false,
                    'has_addons'       => false,
                    'has_paid_plans'   => true,
                    'is_org_compliant' => false,
                    'menu'             => array(
                    'slug'       => 'banner-setting',
                    'first-path' => 'admin.php?page=banner-setting&tab=wcbm-plugin-get-started',
                    'contact'    => false,
                    'support'    => false,
                ),
                    'is_live'          => true,
                ) );
            }
            
            return $wcbm_fs;
        }
        
        // Init Freemius.
        wcbm_fs();
        // Signal that SDK was initiated.
        do_action( 'wcbm_fs_loaded' );
        wcbm_fs()->get_upgrade_url();
        // Not like register_uninstall_hook(), you do NOT have to use a static function.
        wcbm_fs()->add_action( 'after_uninstall', 'wcbm_fs_uninstall_cleanup' );
    }
    
    if ( !defined( 'WCBM_PLUGIN_VERSION' ) ) {
        define( 'WCBM_PLUGIN_VERSION', '2.0.4' );
    }
    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-woocommerce-category-banner-management-activator.php
     */
    function activate_woocommerce_category_banner_management()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-category-banner-management-activator.php';
        woocommerce_category_banner_management_Activator::activate();
    }
    
    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-woocommerce-category-banner-management-deactivator.php
     */
    function deactivate_woocommerce_category_banner_management()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-category-banner-management-deactivator.php';
        woocommerce_category_banner_management_Deactivator::deactivate();
    }
    
    register_activation_hook( __FILE__, 'activate_woocommerce_category_banner_management' );
    register_deactivation_hook( __FILE__, 'deactivate_woocommerce_category_banner_management' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-category-banner-management.php';
    /**
     * User feedback admin notice
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-category-banner-management-user-feedback.php';
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function run_category_banner_management_for_woocommerce()
    {
        $plugin = new woocommerce_category_banner_management();
        $plugin->run();
    }

}

// Check the plugin dependency.
function wcbm_validate_admin_init()
{
    
    if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) && (!function_exists( 'is_plugin_active_for_network' ) || !is_plugin_active_for_network( 'woocommerce/woocommerce.php' )) ) {
        add_action( 'admin_notices', 'wcbm_plugin_admin_notice' );
    } else {
        run_category_banner_management_for_woocommerce();
    }

}

add_action( 'plugins_loaded', 'wcbm_validate_admin_init' );
/**
 * Show admin notice in case of WooCommerce plugin is missing.
 *
 * @since    1.0.0
 */
function wcbm_plugin_admin_notice()
{
    $vpe_plugin = esc_html__( 'Category Banner Management for Woocommerce', 'woo-banner-management' );
    if ( function_exists( 'wcbm_fs' ) && wcbm_fs()->is__premium_only() ) {
        if ( wcbm_fs()->can_use_premium_code() ) {
            $vpe_plugin = esc_html__( 'Category Banner Management for Woocommerce Pro', 'woo-banner-management' );
        }
    }
    $wc_plugin = esc_html__( 'WooCommerce', 'woo-banner-management' );
    ?>
	<div class="error">
		<p>
			<?php 
    echo  sprintf( esc_html__( '%1$s requires %2$s to be installed & activated!', 'woocommerce-product-attachment' ), '<strong>' . esc_html( $vpe_plugin ) . '</strong>', '<a href="'. esc_url('https://wordpress.org/plugins/woocommerce/').'" target="_blank"><strong>' . esc_html( $wc_plugin ) . '</strong></a>' ) ;
    ?>
		</p>
	</div>
	<?php 
}
