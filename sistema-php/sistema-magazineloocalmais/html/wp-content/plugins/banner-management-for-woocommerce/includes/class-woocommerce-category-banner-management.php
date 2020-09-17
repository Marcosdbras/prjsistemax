<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    woocommerce_category_banner_management
 * @subpackage woocommerce_category_banner_management/includes
 */
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    woocommerce_category_banner_management
 * @subpackage woocommerce_category_banner_management/includes
 * @author     Multidots <inquiry@multidots.in>
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
class woocommerce_category_banner_management
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      woocommerce_category_banner_management_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected  $loader ;
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected  $plugin_name ;
    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected  $version ;
    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->plugin_name = 'banner-management-for-woocommerce';
        $this->version = '2.0.4';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $prefix = ( is_network_admin() ? 'network_admin_' : '' );
        add_filter(
            "{$prefix}plugin_action_links_" . plugin_basename( dirname( dirname( __FILE__ ) ) . '/woocommerce-category-banner-management.php' ),
            array( $this, 'plugin_action_links' ),
            10,
            4
        );
    }
    
    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - woocommerce_category_banner_management_Loader. Orchestrates the hooks of the plugin.
     * - woocommerce_category_banner_management_i18n. Defines internationalization functionality.
     * - woocommerce_category_banner_management_Admin. Defines all hooks for the admin area.
     * - woocommerce_category_banner_management_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-category-banner-management-loader.php';
        /**
         * The file contains the general functions of the plugins.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wcbm-update-functions.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-category-banner-management-i18n.php';
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-category-banner-management-admin.php';
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-category-banner-management-public.php';
        $this->loader = new woocommerce_category_banner_management_Loader();
    }
    
    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the woocommerce_category_banner_management_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new woocommerce_category_banner_management_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }
    
    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new woocommerce_category_banner_management_Admin( $this->get_plugin_name(), $this->get_version() );
        //enqueue stylesheets & JavaScripts.
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles_scripts' );
        //Add admin menu.
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'wcbm_menu_page' );
        //edit product cat
        $this->loader->add_action(
            'product_cat_edit_form_fields',
            $plugin_admin,
            'wcbm_product_cat_taxonomy_custom_fields',
            10,
            2
        );
        $this->loader->add_action(
            'edited_product_cat',
            $plugin_admin,
            'wcbm_product_cat_save_taxonomy_custom_fields',
            10,
            2
        );
        $this->loader->add_action(
            'woocommerce_before_main_content',
            $plugin_admin,
            'wcbm_show_category_banner',
            5
        );
        $this->loader->add_action(
            'woocommerce_before_main_content',
            $plugin_admin,
            'wcbm_show_shop_page_banner',
            5
        );
        $this->loader->add_action(
            'woocommerce_before_cart',
            $plugin_admin,
            'wcbm_show_cart_page_banner',
            30
        );
        $this->loader->add_action(
            'woocommerce_before_checkout_form',
            $plugin_admin,
            'wcbm_show_checkout_page_banner',
            30
        );
        $this->loader->add_action( 'wp_ajax_wbm_save_shop_page_banner_data', $plugin_admin, 'wcbm_save_shop_page_banner_data' );
        $this->loader->add_action( 'wp_ajax_nopriv_wbm_save_shop_page_banner_data', $plugin_admin, 'wcbm_save_shop_page_banner_data' );
        // Welcome Screen
        $this->loader->add_action( 'admin_init', $plugin_admin, 'welcome_screen_do_activation_redirect' );
    }
    
    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new woocommerce_category_banner_management_Public( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles_scripts' );
        $this->loader->add_filter(
            'woocommerce_locate_template',
            $plugin_public,
            'wbm_woocommerce_locate_template',
            10,
            3
        );
        $this->loader->add_filter(
            'woocommerce_paypal_args',
            $plugin_public,
            'paypal_bn_code_filter',
            99,
            1
        );
    }
    
    /**
     * Return the plugin action links.  This will only be called if the plugin
     * is active.
     *
     * @since 1.0.0
     * @param array $actions associative array of action names to anchor tags
     * @return array associative array of plugin action links
     */
    public function plugin_action_links(
        $actions,
        $plugin_file,
        $plugin_data,
        $context
    )
    {
        $custom_actions = array(
            'configure' => sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=banner-setting' ), __( 'Settings', 'woocommerce-category-banner-management' ) ),
            'docs'      => sprintf( '<a href="%s" target="_blank">%s</a>', 'https://store.multidots.com/wp-content/uploads/2017/02/Banner-Management-for-WooCommerce-help-document-.pdf', __( 'Docs', 'woocommerce-category-banner-management' ) ),
            'support'   => sprintf( '<a href="%s" target="_blank">%s</a>', 'https://store.multidots.com/dotstore-support-panel/', __( 'Support', 'woocommerce-category-banner-management' ) ),
        );
        // add the links to the front of the actions list
        return array_merge( $custom_actions, $actions );
    }
    
    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }
    
    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }
    
    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    woocommerce_category_banner_management_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }
    
    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

}