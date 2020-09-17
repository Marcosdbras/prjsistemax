<?php
/**
 * Plugin Name: YITH WooCommerce Catalog Mode
 * Plugin URI: https://yithemes.com/themes/plugins/yith-woocommerce-catalog-mode/
 * Description: <code><strong>YITH WooCommerce Catalog Mode</strong></code> allows hiding product prices, cart and checkout from your store and turning it into a performing product catalogue. You will be able to adjust your catalogue settings as you prefer based on your requirements. <a href="https://yithemes.com/" target="_blank">Get more plugins for your e-commerce shop on <strong>YITH</strong></a>
 * Author: YITH
 * Text Domain: yith-woocommerce-catalog-mode
 * Version: 2.0.1
 * Author URI: https://yithemes.com/
 * WC requires at least: 3.9.0
 * WC tested up to: 4.1.x
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function ywctm_install_woocommerce_admin_notice() {
	?>
	<div class="error">
		<p>
			<?php
			/* translators: %s name of the plugin */
			echo sprintf( esc_html__( '%s is enabled but not effective. In order to work, it requires WooCommerce.', 'yith-woocommerce-catalog-mode' ), 'YITH WooCommerce Catalog Mode' );
			?>
		</p>
	</div>
	<?php
}

function ywctm_install_free_admin_notice() {
	?>
	<div class="error">
		<p>
			<?php
			/* translators: %s name of the plugin */
			echo sprintf( esc_html__( 'You can\'t activate the free version of %s while you are using the premium one.', 'yith-woocommerce-catalog-mode' ), 'YITH WooCommerce Catalog Mode' );
			?>
		</p>
	</div>
	<?php
}

! defined( 'YWCTM_VERSION' ) && define( 'YWCTM_VERSION', '2.0.0' );
! defined( 'YWCTM_FREE_INIT' ) && define( 'YWCTM_FREE_INIT', plugin_basename( __FILE__ ) );
! defined( 'YWCTM_SLUG' ) && define( 'YWCTM_SLUG', 'yith-woocommerce-catalog-mode' );
! defined( 'YWCTM_FILE' ) && define( 'YWCTM_FILE', __FILE__ );
! defined( 'YWCTM_DIR' ) && define( 'YWCTM_DIR', plugin_dir_path( __FILE__ ) );
! defined( 'YWCTM_URL' ) && define( 'YWCTM_URL', plugins_url( '/', __FILE__ ) );
! defined( 'YWCTM_ASSETS_URL' ) && define( 'YWCTM_ASSETS_URL', YWCTM_URL . 'assets/' );
! defined( 'YWCTM_ASSETS_PATH' ) && define( 'YWCTM_ASSETS_PATH', YWCTM_DIR . 'assets/' );
! defined( 'YWCTM_TEMPLATE_PATH' ) && define( 'YWCTM_TEMPLATE_PATH', YWCTM_DIR . 'templates/' );

/* Plugin Framework Version Check */
if ( ! function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( YWCTM_DIR . 'plugin-fw/init.php' ) ) {
	require_once( YWCTM_DIR . 'plugin-fw/init.php' );
}
yit_maybe_plugin_fw_loader( YWCTM_DIR );

function ywctm_init() {

	/* Load YWCTM text domain */
	load_plugin_textdomain( 'yith-woocommerce-catalog-mode', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	$GLOBALS['YITH_WC_Catalog_Mode'] = YITH_WCTM();
}

add_action( 'ywctm_init', 'ywctm_init' );

function ywctm_install() {

	if ( ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'ywctm_install_woocommerce_admin_notice' );
	} elseif ( defined( 'YWCTM_PREMIUM' ) ) {
		add_action( 'admin_notices', 'ywctm_install_free_admin_notice' );
		deactivate_plugins( plugin_basename( __FILE__ ) );
	} else {
		do_action( 'ywctm_init' );
	}
}

add_action( 'plugins_loaded', 'ywctm_install', 11 );

/**
 * Init default plugin settings
 */
if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}

register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

if ( ! function_exists( 'YITH_WCTM' ) ) {

	/**
	 * Unique access to instance of YITH_WC_Catalog_Mode
	 *
	 * @return  YITH_WooCommerce_Catalog_Mode
	 * @since   1.1.5
	 * @author  Alberto Ruggiero <alberto.ruggiero@yithemes.com>
	 */
	function YITH_WCTM() { //phpcs:ignore

		// Load required classes and functions
		require_once( YWCTM_DIR . 'class-yith-woocommerce-catalog-mode.php' );

		return YITH_WooCommerce_Catalog_Mode::get_instance();

	}
}
