<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Manages scheduled_disc settings
 *
 * Here all scheduled_disc settings are defined and managed.
 *
 * @version		1.0.0
 * @package		implecode-scheduled_disc-getaway/includes
 * @author 		Norbert Dreszer
 */
add_action( 'admin_menu', 'ic_woocat_settings_menu', 99 );

function ic_woocat_settings_menu() {
	add_submenu_page( 'woocommerce', __( 'Catalog Booster', 'catalog-booster-for-woocommerce' ), __( 'Catalog Booster', 'catalog-booster-for-woocommerce' ), 'manage_woocommerce', 'ic-catalog-mode', 'ic_woocat_settings_page' );
}

add_action( 'admin_init', 'ic_woocat_settings_register' );

function ic_woocat_settings_register() {
	register_setting( 'ic_woocat', 'ic_woocat' );
}

function ic_woocat_settings_page() {
	?>
	<div id="implecode_settings" class="wrap">
		<h2><?php _e( 'Settings', 'catalog-booster-for-woocommerce' ) ?> - <?php _e( 'WooCommerce Catalog Booster', 'catalog-booster-for-woocommerce' ) ?></h2>
		<nav class="nav-tab-wrapper">
			<?php do_action( 'woocat-settings-menu' ); ?>
		</nav>
		<div class="settings-wrapper" style="clear:both;">
			<?php
			$tab		 = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : '';
			$ic_woocat	 = ic_woocat_settings();
			?>
			<form method = "post" action = "options.php">
				<?php
				settings_fields( 'ic_woocat' );
				foreach ( $ic_woocat as $tab_key => $settings_cat ) {
					if ( $tab_key != $tab ) {
						foreach ( $settings_cat as $key => $value ) {
							echo '<input type="hidden" name="ic_woocat[' . $tab_key . '][' . $key . ']" value="' . $value . '">';
						}
					}
				}
				?>
				<?php
				if ( empty( $tab ) || $tab == 'general' ) {
					?>
					<h2><?php _e( 'General Options', 'catalog-booster-for-woocommerce' ) ?></h2>

					<?php
					echo '<table>';
					implecode_settings_checkbox( __( 'Disable Shopping Cart', 'catalog-booster-for-woocommerce' ), 'ic_woocat[general][disable_cart]', $ic_woocat[ 'general' ][ 'disable_cart' ] );
					implecode_settings_checkbox( __( 'Disable Price', 'catalog-booster-for-woocommerce' ), 'ic_woocat[general][disable_price]', $ic_woocat[ 'general' ][ 'disable_price' ] );
					implecode_settings_checkbox( __( 'Disable Rating', 'catalog-booster-for-woocommerce' ), 'ic_woocat[general][disable_rating]', $ic_woocat[ 'general' ][ 'disable_rating' ] );
					implecode_settings_checkbox( __( 'Disable Reviews', 'catalog-booster-for-woocommerce' ), 'ic_woocat[general][disable_reviews]', $ic_woocat[ 'general' ][ 'disable_reviews' ] );
					implecode_settings_checkbox( __( 'Apply also in dashboard', 'catalog-booster-for-woocommerce' ), 'ic_woocat[general][in_dashboard]', $ic_woocat[ 'general' ][ 'in_dashboard' ] );
					echo '</table>';
				}
				?>
				<?php
				do_action( 'ic_woocat_settings_content', $tab, $ic_woocat );
				?>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save changes', 'catalog-booster-for-woocommerce' ); ?>" />
				</p>
			</form>
		</div>
	</div>

	<?php
}

function ic_woocat_settings() {
	$ic_woocat = get_option( 'ic_woocat', array() );

	$ic_woocat[ 'general' ][ 'disable_cart' ]	 = isset( $ic_woocat[ 'general' ][ 'disable_cart' ] ) ? $ic_woocat[ 'general' ][ 'disable_cart' ] : '';
	$ic_woocat[ 'general' ][ 'disable_price' ]	 = isset( $ic_woocat[ 'general' ][ 'disable_price' ] ) ? $ic_woocat[ 'general' ][ 'disable_price' ] : '';
	$ic_woocat[ 'general' ][ 'disable_rating' ]	 = isset( $ic_woocat[ 'general' ][ 'disable_rating' ] ) ? $ic_woocat[ 'general' ][ 'disable_rating' ] : '';
	$ic_woocat[ 'general' ][ 'disable_reviews' ] = isset( $ic_woocat[ 'general' ][ 'disable_reviews' ] ) ? $ic_woocat[ 'general' ][ 'disable_reviews' ] : '';
	$ic_woocat[ 'general' ][ 'in_dashboard' ]	 = isset( $ic_woocat[ 'general' ][ 'in_dashboard' ] ) ? $ic_woocat[ 'general' ][ 'in_dashboard' ] : '';

	$ic_woocat[ 'button' ][ 'enable' ]		 = isset( $ic_woocat[ 'button' ][ 'enable' ] ) ? $ic_woocat[ 'button' ][ 'enable' ] : '';
	$ic_woocat[ 'button' ][ 'url' ]			 = isset( $ic_woocat[ 'button' ][ 'url' ] ) ? $ic_woocat[ 'button' ][ 'url' ] : '';
	$ic_woocat[ 'button' ][ 'individual' ]	 = isset( $ic_woocat[ 'button' ][ 'individual' ] ) ? $ic_woocat[ 'button' ][ 'individual' ] : '';
	$ic_woocat[ 'button' ][ 'use_default' ]	 = isset( $ic_woocat[ 'button' ][ 'use_default' ] ) ? $ic_woocat[ 'button' ][ 'use_default' ] : '';
	$ic_woocat[ 'button' ][ 'label' ]		 = !empty( $ic_woocat[ 'button' ][ 'label' ] ) ? $ic_woocat[ 'button' ][ 'label' ] : __( 'Read More', 'catalog-booster-for-woocommerce' );

	$ic_woocat[ 'catalog' ][ 'enable' ] = !empty( $ic_woocat[ 'catalog' ][ 'enable' ] ) ? $ic_woocat[ 'catalog' ][ 'enable' ] : '';

	return $ic_woocat;
}

add_action( 'woocat-settings-menu', 'ic_woocat_general_menu' );

function ic_woocat_general_menu() {
	$tab	 = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : '';
	$general = '';
	$listing = '';
	$button	 = '';
	$page	 = '';
	$catalog = '';
	if ( empty( $tab ) || $tab == 'general' ) {
		$general = 'nav-tab-active';
	} else if ( $tab == 'button' ) {
		$button = 'nav-tab-active';
	} else if ( $tab == 'product_page' ) {
		$page = 'nav-tab-active';
	} else if ( $tab == 'listing' ) {
		$listing = 'nav-tab-active';
	} else {
		$catalog = 'nav-tab-active';
	}
	?>
	<a id="general-settings" class="nav-tab <?php echo $general ?>" href="<?php echo admin_url( 'admin.php?page=ic-catalog-mode&tab=general' ) ?>"><?php _e( 'General', 'catalog-booster-for-woocommerce' ); ?></a>
	<a id="general-settings" class="nav-tab <?php echo $button ?>" href="<?php echo admin_url( 'admin.php?page=ic-catalog-mode&tab=button' ) ?>"><?php _e( 'Button', 'catalog-booster-for-woocommerce' ); ?></a>
	<a id="general-settings" class="nav-tab <?php echo $listing ?>" href="<?php echo admin_url( 'admin.php?page=ic-catalog-mode&tab=listing&submenu=archive-design' ) ?>"><?php _e( 'Product Listing', 'catalog-booster-for-woocommerce' ); ?></a>
	<a id="general-settings" class="nav-tab <?php echo $page ?>" href="<?php echo admin_url( 'admin.php?page=ic-catalog-mode&tab=product_page' ) ?>"><?php _e( 'Product Page', 'catalog-booster-for-woocommerce' ); ?></a>
	<a id="general-settings" class="nav-tab <?php echo $catalog ?>" href="<?php echo admin_url( 'admin.php?page=ic-catalog-mode&tab=catalog' ) ?>"><?php _e( 'Additional Catalog', 'catalog-booster-for-woocommerce' ); ?></a>
	<?php
}

add_action( 'ic_woocat_settings_content', 'ic_woocat_product_listing_settings' );

function ic_woocat_product_listing_settings( $tab ) {
	if ( $tab == 'listing' ) {
		if ( !function_exists( 'impleCode_EPC' ) ) {
			?>
			<h2><?php _e( 'Product Listing Templates', 'catalog-booster-for-woocommerce' ) ?></h2>
			<?php
			implecode_info( sprintf( __( '%1$seCommerce Product Catalog%2$s is required in order to activate enhanced product listing views. %1$sInstall it for free%2$s from WordPress repository.', 'catalog-booster-for-woocommerce' ), '<a href="' . admin_url( 'plugin-install.php?s=ecommerce+product+catalog+by+implecode&tab=search&type=term' ) . '">', '</a>' ) );
			?>
			<h2>Here is what you will be able to enable for all or selected WooCommerce products:</h2>
			<h3>Modern Grid</h3>
			<img src="https://ps.w.org/ecommerce-product-catalog/assets/screenshot-1.png" />
			<h3>Classic Grid</h3>
			<img src="https://ps.w.org/ecommerce-product-catalog/assets/screenshot-4.png" />
			<h3>Classic List</h3>
			<img src="https://ps.w.org/ecommerce-product-catalog/assets/screenshot-5.png" />
			<p>and many more.</p>
			<?php
		} else {
			settings_fields( 'product_design' );
			ic_listing_design_settings();
		}
	}
}

add_action( 'ic_woocat_settings_content', 'ic_woocat_product_page_settings' );

function ic_woocat_product_page_settings( $tab ) {
	if ( $tab == 'product_page' ) {
		if ( !function_exists( 'impleCode_EPC' ) ) {
			?>
			<h2><?php _e( 'Product Page Templates', 'catalog-booster-for-woocommerce' ) ?></h2>
			<?php
			implecode_info( sprintf( __( '%1$seCommerce Product Catalog%2$s is required in order to activate enhanced product page templates. %1$sInstall it for free%2$s from WordPress repository.', 'catalog-booster-for-woocommerce' ), '<a href="' . admin_url( 'plugin-install.php?s=ecommerce+product+catalog+by+implecode&tab=search&type=term' ) . '">', '</a>' ) );
			?>
			<h2>Here is what you will be able to enable for all WooCommerce products:</h2>
			<h3>Tabbed Page</h3>
			<img src="https://ps.w.org/ecommerce-product-catalog/assets/screenshot-2.png" />
			<h3>Simple Page</h3>
			<img src="https://ps.w.org/ecommerce-product-catalog/assets/screenshot-3.png" />
			<?php
		} else {
			settings_fields( 'single_design' );
			ic_product_page_design_settings();
		}
	}
}

add_action( 'ic_product_gallery_settings', 'ic_woocat_gallery_settings' );

function ic_woocat_gallery_settings( $single_options ) {
	implecode_settings_checkbox( __( 'Use WooCommerce Gallery', 'catalog-booster-for-woocommerce' ), 'ic_woocat_woo_gallery', ic_woocat_woo_gallery_enabled(), 1, __( 'It will replace the catalog gallery with default WooCommerce gallery. Lightbox gallery should be disabled with this enabled.', 'catalog-booster-for-woocommerce' ) );
}

function ic_woocat_woo_gallery_enabled() {
	$enabled = get_option( 'ic_woocat_woo_gallery', 0 );
	return $enabled;
}

add_action( 'ic_woocat_settings_content', 'ic_woocat_button_settings', 10, 2 );

function ic_woocat_button_settings( $tab, $ic_woocat ) {
	if ( $tab == 'button' ) {
		?>
		<h2><?php _e( 'Product Button Options', 'catalog-booster-for-woocommerce' ) ?></h2>
		<?php
		echo '<table>';
		implecode_settings_checkbox( __( 'Enable catalog button', 'catalog-booster-for-woocommerce' ), 'ic_woocat[button][enable]', $ic_woocat[ 'button' ][ 'enable' ] );
		implecode_settings_text( __( 'Button Label', 'catalog-booster-for-woocommerce' ), 'ic_woocat[button][label]', $ic_woocat[ 'button' ][ 'label' ] );
		implecode_settings_text( __( 'Default button URL', 'catalog-booster-for-woocommerce' ), 'ic_woocat[button][url]', $ic_woocat[ 'button' ][ 'url' ] );
		implecode_settings_checkbox( __( 'Unique URL for each Product', 'catalog-booster-for-woocommerce' ), 'ic_woocat[button][individual]', $ic_woocat[ 'button' ][ 'individual' ] );
		implecode_settings_checkbox( __( 'Use default if empty', 'catalog-booster-for-woocommerce' ), 'ic_woocat[button][use_default]', $ic_woocat[ 'button' ][ 'use_default' ] );
		echo '</table>';
	}
}

add_action( 'ic_woocat_settings_content', 'ic_woocat_product_catalog_settings', 10, 2 );

function ic_woocat_product_catalog_settings( $tab, $ic_woocat ) {
	if ( $tab == 'catalog' ) {
		if ( !function_exists( 'impleCode_EPC' ) ) {
			?>
			<h2><?php _e( 'Additional Catalog', 'catalog-booster-for-woocommerce' ) ?></h2>
			<?php
			implecode_info( sprintf( __( '%1$seCommerce Product Catalog%2$s is required in order to activate additional catalog. %1$sInstall it for free%2$s from WordPress repository.', 'catalog-booster-for-woocommerce' ), '<a href="' . admin_url( 'plugin-install.php?s=ecommerce+product+catalog+by+implecode&tab=search&type=term' ) . '">', '</a>' ) );
			?>
			<p><?php _e( 'You will be able to create a separate catalog outside of WooCommerce.', 'catalog-booster-for-woocommerce' ) ?></p>
			<?php
		} else {
			if ( empty( $ic_woocat[ 'catalog' ][ 'enable' ] ) ) {
				implecode_info( __( 'If you enable this option you will be able to create a separate catalog outside of WooCommerce. This will also enable more catalog settings.', 'catalog-booster-for-woocommerce' ) );
			}
			echo '<table>';
			implecode_settings_checkbox( __( 'Enable Additional Catalog', 'catalog-booster-for-woocommerce' ), 'ic_woocat[catalog][enable]', $ic_woocat[ 'catalog' ][ 'enable' ] );
			if ( !empty( $ic_woocat[ 'catalog' ][ 'enable' ] ) ) {
				echo '<tr>';
				echo '<td colspan="2" style="text-align:center"><a class="button" href="' . admin_url( 'edit.php?post_type=al_product&page=product-settings.php' ) . '">' . __( 'Catalog Settings', 'catalog-booster-for-woocommerce' ) . '</a></td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	}
}

add_action( 'product-settings-list', 'ic_woo_cat_epc_register_settings' );

function ic_woo_cat_epc_register_settings() {
	register_setting( 'product_design', 'ic_enable_listing_for_woo' );
	register_setting( 'single_design', 'ic_enable_page_for_woo' );
	register_setting( 'single_design', 'ic_woocat_woo_gallery' );
}

add_action( 'listing_design_settings_start', 'ic_woo_cat_epc_listing_settings' );

function ic_woo_cat_epc_listing_settings() {
	$woo_listing_enabled = ic_is_listing_for_woo_enabled();
	echo '<table>';
	implecode_settings_checkbox( __( 'Enable for WooCommerce', 'catalog-booster-for-woocommerce' ), 'ic_enable_listing_for_woo', $woo_listing_enabled );
	echo '</table>';
}

add_action( 'page_design_settings_start', 'ic_woo_cat_epc_page_settings' );

function ic_woo_cat_epc_page_settings() {
	$woo_page_enabled = ic_is_page_for_woo_enabled();
	echo '<table>';
	implecode_settings_checkbox( __( 'Enable for WooCommerce', 'catalog-booster-for-woocommerce' ), 'ic_enable_page_for_woo', $woo_page_enabled );
	echo '</table>';
}

function ic_is_listing_for_woo_enabled() {
	$enabled = get_option( 'ic_enable_listing_for_woo', 0 );
	return $enabled;
}

function ic_is_page_for_woo_enabled() {
	$enabled = get_option( 'ic_enable_page_for_woo', 0 );
	return $enabled;
}

add_filter( 'is_ic_catalog_admin_page', 'ic_woo_settings_admin_page' );

function ic_woo_settings_admin_page( $return ) {
	if ( is_admin() && isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] === 'ic-catalog-mode' ) {
		return true;
	}
	return $return;
}

add_filter( 'plugin_action_links_' . plugin_basename( IC_WOOCAT_MAIN_FILE ), 'ic_woo_cat_links' );

/**
 * Shows settings link on plugin list
 *
 * @param array $links
 * @return type
 */
function ic_woo_cat_links( $links ) {
	$links[] = '<a href="' . get_admin_url( null, 'admin.php?page=ic-catalog-mode' ) . '">Settings</a>';
	return array_reverse( $links );
}
