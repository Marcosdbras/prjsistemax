<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Banner_Management
 * @subpackage Woo_Banner_Management/admin
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Banner_Management
 * @subpackage Woo_Banner_Management/admin
 * @author     Multidots <inquiry@multidots.in>
 */
class woocommerce_category_banner_management_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private  $plugin_name ;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private  $version ;
    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     *
     * @since    1.0.0
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets & JavaScript for admin area.
     *
     * @since 2.0.0
     */
    public function enqueue_styles_scripts( $hook )
    {
        global  $typenow ;
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        
        if ( isset( $hook ) && !empty($hook) && "dotstore-plugins_page_banner-setting" === $hook || isset( $typenow ) && !empty($typenow) && 'product' === $typenow ) {
            //stylesheets.
            wp_enqueue_style(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'css/datepicker.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                'image-upload-category-css',
                plugin_dir_url( __FILE__ ) . 'css/woo-image-upload.css',
                array( 'wp-jquery-ui-dialog' ),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                'wcbm-css',
                plugin_dir_url( __FILE__ ) . 'css/style.css',
                array(),
                $this->version,
                'all'
            );
            //scripts.
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'js/woocommerce-category-banner-management-admin' . $suffix . '.js',
                array( 'jquery' ),
                $this->version,
                true
            );
            wp_enqueue_script(
                'wbm-admin',
                plugin_dir_url( __FILE__ ) . 'js/wbm-admin' . $suffix . '.js',
                array( 'jquery' ),
                $this->version,
                true
            );
            wp_localize_script( 'wbm-admin', 'wbmAdminVars', array(
                'alert'                => __( 'Are you sure you want to delete?', 'woo-banner-management' ),
                'placeholder'          => __( 'Enter banner image link', 'woo-banner-management' ),
                'click'                => __( 'Click here', 'woo-banner-management' ),
                'preview'              => __( 'Preview', 'woo-banner-management' ),
                'can_use_premium_code' => wp_json_encode( wcbm_fs()->can_use_premium_code() ),
            ) );
        }
    
    }
    
    /**
     *  Set custom menu in WooCommerce-banner-management plugin
     */
    public function wcbm_menu_page()
    {
        global  $GLOBALS ;
        if ( empty($GLOBALS['admin_page_hooks']['dots_store']) ) {
            add_menu_page(
                'DotStore Plugins',
                __( 'DotStore Plugins' ),
                'null',
                'dots_store',
                array( $this, 'dot_store_menu_page' ),
                plugin_dir_url( __FILE__ ) . 'images/menu-icon.png',
                25
            );
        }
        add_submenu_page(
            'dots_store',
            __( 'Banner Management', 'woo-banner-management' ),
            __( 'Banner Management', 'woo-banner-management' ),
            'manage_options',
            'banner-setting',
            array( $this, 'wcbm_options_page' )
        );
    }
    
    /**
     * WooCommerce Product Attachment Option Page HTML
     *
     */
    public function wcbm_options_page()
    {
        include_once plugin_dir_path( __FILE__ ) . 'partials/header/plugin-header.php';
        $wcpoa_attachment_tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
        $wcpoa_attachment_tab = ( !empty($wcpoa_attachment_tab) ? $wcpoa_attachment_tab : '' );
        
        if ( !empty($wcpoa_attachment_tab) ) {
            if ( "wcbm-plugin-get-started" === $wcpoa_attachment_tab ) {
                self::wcbm_plugin_get_started();
            }
            if ( "wcbm-plugin-information" === $wcpoa_attachment_tab ) {
                self::wcbm_plugin_quick_info();
            }
        } else {
            self::my_custom_submenu_page_callback();
        }
        
        include_once plugin_dir_path( __FILE__ ) . 'partials/header/plugin-sidebar.php';
    }
    
    /*
     * include get started page file.
     */
    public function wcbm_plugin_get_started()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wcbm-get-started-page.php';
    }
    
    /**
     * include get information page.
     */
    public function wcbm_plugin_quick_info()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wcbm-information-page.php';
    }
    
    /*
     * custom call wbm setting page.
     */
    public function my_custom_submenu_page_callback()
    {
        wp_enqueue_media();
        $wbm_shop_page_stored_results_serialize_banner_select_image = '';
        $wbm_shop_page_stored_results_serialize_banner_src = '';
        $wbm_shop_page_stored_results_serialize_banner_link = '';
        $wbm_shop_page_stored_results_serialize_banner_enable_status = '';
        $wbm_cart_page_stored_results_serialize_banner_select_image = '';
        $wbm_cart_page_stored_results_serialize_banner_src = '';
        $wbm_cart_page_stored_results_serialize_banner_arr = '';
        $wbm_cart_page_stored_results_serialize_banner_link = '';
        $wbm_cart_page_stored_results_serialize_banner_enable_status = '';
        $wbm_checkout_page_stored_results_serialize_banner_select_image = '';
        $wbm_checkout_page_stored_results_serialize_banner_src = '';
        $wbm_checkout_page_stored_results_serialize_banner_arr = '';
        $wbm_checkout_page_stored_results_serialize_banner_link = '';
        $wbm_checkout_page_stored_results_serialize_banner_enable_status = '';
        $wbm_thankyou_page_stored_results_serialize_banner_select_image = '';
        $wbm_thankyou_page_stored_results_serialize_banner_src = '';
        $wbm_thankyou_page_stored_results_serialize_banner_arr = '';
        $wbm_thankyou_page_stored_results_serialize_banner_link = '';
        $wbm_thankyou_page_stored_results_serialize_banner_enable_status = '';
        
        if ( function_exists( 'wcbm_get_page_banner_data' ) ) {
            $wbm_shop_page_stored_results = wcbm_get_page_banner_data( 'shop' );
            $wbm_cart_page_stored_results = wcbm_get_page_banner_data( 'cart' );
            $wbm_checkout_page_stored_results = wcbm_get_page_banner_data( 'checkout' );
            $wbm_thankyou_page_stored_results = wcbm_get_page_banner_data( 'thankyou' );
        }
        
        // get shop page stored data
        
        if ( isset( $wbm_shop_page_stored_results ) && !empty($wbm_shop_page_stored_results) ) {
            $wbm_shop_page_stored_results_serialize = $wbm_shop_page_stored_results;
            
            if ( !empty($wbm_shop_page_stored_results_serialize) ) {
                $wbm_shop_page_stored_results_serialize_banner_select_image = ( !empty($wbm_shop_page_stored_results_serialize['shop_page_banner_select_image']) ? $wbm_shop_page_stored_results_serialize['shop_page_banner_select_image'] : '' );
                $wbm_shop_page_stored_results_serialize_banner_src = ( !empty($wbm_shop_page_stored_results_serialize['shop_page_banner_image_src']) ? $wbm_shop_page_stored_results_serialize['shop_page_banner_image_src'] : '' );
                $wbm_shop_page_stored_results_serialize_banner_link = ( !empty($wbm_shop_page_stored_results_serialize['shop_page_banner_link_src']) ? $wbm_shop_page_stored_results_serialize['shop_page_banner_link_src'] : '' );
                $wbm_shop_page_stored_results_serialize_banner_enable_status = ( !empty($wbm_shop_page_stored_results_serialize['shop_page_banner_enable_status']) ? $wbm_shop_page_stored_results_serialize['shop_page_banner_enable_status'] : '' );
            }
        
        }
        
        //get cart setting page stored data
        
        if ( isset( $wbm_cart_page_stored_results ) && !empty($wbm_cart_page_stored_results) ) {
            $wbm_cart_page_stored_results_serialize = $wbm_cart_page_stored_results;
            
            if ( !empty($wbm_cart_page_stored_results_serialize) ) {
                $wbm_cart_page_stored_results_serialize_banner_select_image = ( !empty($wbm_cart_page_stored_results_serialize['cart_page_banner_select_image']) ? $wbm_cart_page_stored_results_serialize['cart_page_banner_select_image'] : '' );
                $wbm_cart_page_stored_results_serialize_banner_src = ( !empty($wbm_cart_page_stored_results_serialize['cart_page_banner_image_src']) ? $wbm_cart_page_stored_results_serialize['cart_page_banner_image_src'] : '' );
                $wbm_cart_page_stored_results_serialize_banner_link = ( !empty($wbm_cart_page_stored_results_serialize['cart_page_banner_link_src']) ? $wbm_cart_page_stored_results_serialize['cart_page_banner_link_src'] : '' );
                $wbm_cart_page_stored_results_serialize_banner_enable_status = ( !empty($wbm_cart_page_stored_results_serialize['cart_page_banner_enable_status']) ? $wbm_cart_page_stored_results_serialize['cart_page_banner_enable_status'] : '' );
            }
        
        }
        
        //get checkout setting page stored data
        
        if ( isset( $wbm_checkout_page_stored_results ) && !empty($wbm_checkout_page_stored_results) ) {
            $wbm_checkout_page_stored_results_serialize = $wbm_checkout_page_stored_results;
            
            if ( !empty($wbm_checkout_page_stored_results_serialize) ) {
                $wbm_checkout_page_stored_results_serialize_banner_select_image = ( !empty($wbm_checkout_page_stored_results_serialize['checkout_page_banner_select_image']) ? $wbm_checkout_page_stored_results_serialize['checkout_page_banner_select_image'] : '' );
                $wbm_checkout_page_stored_results_serialize_banner_src = ( !empty($wbm_checkout_page_stored_results_serialize['checkout_page_banner_image_src']) ? $wbm_checkout_page_stored_results_serialize['checkout_page_banner_image_src'] : '' );
                $wbm_checkout_page_stored_results_serialize_banner_link = ( !empty($wbm_checkout_page_stored_results_serialize['checkout_page_banner_link_src']) ? $wbm_checkout_page_stored_results_serialize['checkout_page_banner_link_src'] : '' );
                $wbm_checkout_page_stored_results_serialize_banner_enable_status = ( !empty($wbm_checkout_page_stored_results_serialize['checkout_page_banner_enable_status']) ? $wbm_checkout_page_stored_results_serialize['checkout_page_banner_enable_status'] : '' );
            }
        
        }
        
        //get thank you setting page stored data
        
        if ( isset( $wbm_thankyou_page_stored_results ) && !empty($wbm_thankyou_page_stored_results) ) {
            $wbm_thankyou_page_stored_results_serialize = $wbm_thankyou_page_stored_results;
            
            if ( !empty($wbm_thankyou_page_stored_results_serialize) ) {
                $wbm_thankyou_page_stored_results_serialize_banner_select_image = ( !empty($wbm_thankyou_page_stored_results_serialize['thankyou_page_banner_select_image']) ? $wbm_thankyou_page_stored_results_serialize['thankyou_page_banner_select_image'] : '' );
                $wbm_thankyou_page_stored_results_serialize_banner_src = ( !empty($wbm_thankyou_page_stored_results_serialize['thankyou_page_banner_image_src']) ? $wbm_thankyou_page_stored_results_serialize['thankyou_page_banner_image_src'] : '' );
                $wbm_thankyou_page_stored_results_serialize_banner_link = ( !empty($wbm_thankyou_page_stored_results_serialize['thankyou_page_banner_link_src']) ? $wbm_thankyou_page_stored_results_serialize['thankyou_page_banner_link_src'] : '' );
                $wbm_thankyou_page_stored_results_serialize_banner_enable_status = ( !empty($wbm_thankyou_page_stored_results_serialize['thankyou_page_banner_enable_status']) ? $wbm_thankyou_page_stored_results_serialize['thankyou_page_banner_enable_status'] : '' );
            }
        
        }
        
        ?>
		<div class="wcbm-section-left">
			<div class="notice notice-success is-dismissible" id="succesful_message_wbm">
				<p><?php 
        esc_html_e( 'Banner saved succesfully', 'woo-banner-management' );
        ?></p>
			</div>
			<div class="woocommerce-banner-managment-setting-content">
				<div class="top-save-button">
					<img class="banner-setting-loader"
						 src="<?php 
        echo  esc_url( plugin_dir_url( __FILE__ ) . 'images/ajax-loader.gif' ) ;
        ?>"
						 alt="ajax-loader"/>
					<input type="button" name="save_wbmshop" id="save_top_wbm_shop_page_setting"
						   class="button button-primary"
						   value="<?php 
        esc_attr_e( 'Save Changes', 'woo-banner-management' );
        ?>">

				</div>
				<div class="plugin_title_content">
					<h2><?php 
        esc_html_e( 'Banner Management Settings', 'woo-banner-management' );
        ?> </h2>
					<p><?php 
        esc_html_e( 'You can easily add banner in WooCommerce stores and you can upload the banner for page specific, category specific and welcome page specific.', 'woo-banner-management' );
        ?></p>
					<p><?php 
        esc_html_e( 'You can upload custom banner  at the top of your product category pages. Easily update the image through your product category edit page.You can upload custom banner  at the top of your product category pages. Easily update the image through your product category edit page.', 'woo-banner-management' );
        ?></p>
				</div>
				<fieldset class="wbm_global">
					<legend>
						<div class="wbm-setting-header">
							<h2><?php 
        esc_html_e( 'Page specific banner', 'woo-banner-management' );
        ?></h2>
						</div>
					</legend>
					<p><?php 
        esc_html_e( 'You can upload custom banner on page specific. Easily update the image and redirect page URL from below setting option.', 'woo-banner-management' );
        ?></p>
					<div class="accordion">
						<div class="accordion-section">
							<?php 
        
        if ( $wbm_shop_page_stored_results_serialize_banner_enable_status === 'on' ) {
            $setting_enable_or_not = " ( Enable ) ";
            $setting_enable_or_color = "green";
        } else {
            $setting_enable_or_not = " ( Disable ) ";
            $setting_enable_or_color = "red";
        }
        
        ?>
							<a class="accordion-section-title"
							   href="#wbm-enable-banner-for-shpe-page"> <?php 
        esc_html_e( 'Banner for shop page ', 'woo-banner-management' );
        ?>
								<span id="shop_page_status_enable_or_disable"
									  class="shop_page_status_enable_or_disable <?php 
        echo  esc_attr( $setting_enable_or_color ) ;
        ?>">
                                        <?php 
        esc_html_e( $setting_enable_or_not, 'woo-banner-management' );
        ?>
                                    </span>
							</a>
							<div id="wbm-enable-banner-for-shpe-page" class="accordion-section-content">

								<table class="form-table" id="form-table-wbm-shop-page">
									<tbody>
									<tr>
										<th scope="row"><label class="wbm_leble_setting_css"
															   for="wbm_shop_setting_enable"><?php 
        esc_html_e( 'Enable/Disable', 'woo-banner-management' );
        ?> </label>
										</th>
										<td><input type="checkbox" value="on" id="wbm_shop_setting_enable"
												   class="wbm_shop_setting_enable_or_not" <?php 
        checked( $wbm_shop_page_stored_results_serialize_banner_enable_status, 'on' );
        ?>></td>
										<?php 
        $shop_page_url_results = "#";
        $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
        if ( !empty($shop_page_url) ) {
            $shop_page_url_results = $shop_page_url;
        }
        
        if ( $wbm_shop_page_stored_results_serialize_banner_enable_status === 'on' ) {
            $shop_page_preview_content = '<strong>' . __( 'Preview', 'woo-banner-management' ) . ':</strong> <a href="' . $shop_page_url_results . '" target="_blank">' . __( 'Click here', 'woo-banner-management' ) . '</a>';
        } else {
            $shop_page_preview_content = '';
        }
        
        ?>
										<input type="hidden" id="shop_page_hidden_url"
											   value="<?php 
        echo  esc_url( $shop_page_url_results ) ;
        ?>">
										<td>
											<span
												class="Preview_link_for_shop_page"><?php 
        echo  wp_kses_post( $shop_page_preview_content ) ;
        ?></span>
										</td>
									</tr>
									</tbody>
								</table>
								<?php 
        $display_option = 'block';
        if ( 'on' !== $wbm_shop_page_stored_results_serialize_banner_enable_status ) {
            $display_option = 'none';
        }
        ?>

								<div class="wbm_shop_page_enable_open_div <?php 
        echo  esc_attr( $display_option ) ;
        ?>">
									<fieldset class="innerbanner">
										<legend><?php 
        esc_html_e( 'General Settings', 'woo-banner-management' );
        ?></legend>
										<?php 
        ?>
											<table class="form-table" id="form-table">
												<tbody>
												<tr>
													<th scope="row"><label class="wbm_leble_setting_css"
																		   for="wbm_shop_page_single_upload_file_button"><?php 
        esc_html_e( 'Banner Image', 'woo-banner-management' );
        ?></label>
													</th>
													<td><a class='wbm_shop_page_single_upload_file_button button'
														   id="wbm_shop_page_single_upload_file_button"
														   uploader_title='Select File'
														   uploader_button_text="<?php 
        esc_attr_e( 'Include File', 'woo-banner-management' );
        ?>"><?php 
        esc_html_e( 'Upload File', 'woo-banner-management' );
        ?></a>
														<a class='wbm_shop_page_remove_single_file button'><?php 
        esc_html_e( 'Remove File', 'woo-banner-management' );
        ?></a>
													</td>
												</tr>
												<tr>
													<th scope="row"></th>
													<?php 
        
        if ( '' === $wbm_shop_page_stored_results_serialize_banner_src ) {
            $shop_page_benner_css = "no-image";
        } else {
            $shop_page_benner_css = "yes-image";
        }
        
        ?>
													<td>
														<img
															class="wbm_shop_page_cat_banner_img_admin_single <?php 
        echo  esc_attr( $shop_page_benner_css ) ;
        ?>"
															src="<?php 
        echo  esc_url( $wbm_shop_page_stored_results_serialize_banner_src ) ;
        ?>"/>
													</td>
												</tr>
												<tr>
													<th scope="row"><label class="wbm_leble_setting_css"
																		   for="shop_page_banner_single_image_link"><?php 
        esc_html_e( 'Banner Image Link', 'woo-banner-management' );
        ?></label>
													</th>
													<td><input type="url" id="shop_page_banner_single_image_link"
															   title="Example: https://multidots.com"
															   name='term_meta[banner_link]'
															   value='<?php 
        echo  esc_attr( $wbm_shop_page_stored_results_serialize_banner_link ) ;
        ?>'/>
														<p><label class="banner_link_label"
																  for="shop_page_banner_single_image_link"><em><?php 
        esc_html_e( 'Where users will be directed if they click on the banner.', 'woo-banner-management' );
        ?></em></label>
														</p></td>
												</tr>
												</tbody>
											</table>
											<?php 
        ?>
									</fieldset>

								</div>
							</div><!--end .accordion-section-content-->
						</div><!--end .accordion-section-->
						<div class="accordion-section">
							<?php 
        
        if ( $wbm_cart_page_stored_results_serialize_banner_enable_status === 'on' ) {
            $setting_enable_or_not_cart = " ( Enable ) ";
            $setting_enable_or_color_cart = "green";
        } else {
            $setting_enable_or_not_cart = " ( Disable ) ";
            $setting_enable_or_color_cart = "red";
        }
        
        ?>
							<a class="accordion-section-title"
							   href="#wbm-enable-banner-for-cart-page"><?php 
        esc_html_e( 'Banner for cart page', 'woo-banner-management' );
        ?>
								<span id="cart_page_status_enable_or_disable"
									  class="cart_page_status_enable_or_disable <?php 
        echo  esc_attr( $setting_enable_or_color_cart ) ;
        ?>"> <?php 
        esc_html_e( $setting_enable_or_not_cart, 'woo-banner-management' );
        ?></span></a>
							<div id="wbm-enable-banner-for-cart-page" class="accordion-section-content">
								<div class="woocommerce-banner-managment-cart-setting-admin">

									<table class="form-table" id="form-table-wbm-cart-page">
										<tbody>
										<tr>
											<th scope="row"><label class="wbm_leble_setting_css"
																   for="wbm_shop_setting_cart_enable"><?php 
        esc_html_e( 'Enable/Disable', 'woo-banner-management' );
        ?></label>
											</th>
											<td><input type="checkbox" value="on" id="wbm_shop_setting_cart_enable"
													   class="wbm_shop_setting_cart_enable_or_not" <?php 
        checked( $wbm_cart_page_stored_results_serialize_banner_enable_status, 'on' );
        ?>></td>
											<?php 
        $cart_url_results = "#";
        $cart_url = wc_get_cart_url();
        if ( !empty($cart_url) ) {
            $cart_url_results = $cart_url;
        }
        
        if ( $wbm_cart_page_stored_results_serialize_banner_enable_status === 'on' ) {
            $cart_page_preview_url = '<strong>' . __( 'Preview', 'woo-banner-management' ) . ':</strong> <a href="' . $cart_url_results . '" target="_blank">' . __( 'Click here', 'woo-banner-management' ) . '</a>';
        } else {
            $cart_page_preview_url = "";
        }
        
        ?>
											<input type="hidden" id="cart_page_hidden_url"
												   value="<?php 
        echo  esc_url( $cart_url_results ) ;
        ?>">
											<td>
												<span
													class="Preview_link_for_cart_page"><?php 
        echo  wp_kses_post( $cart_page_preview_url ) ;
        ?></span>
											</td>
										</tr>

										</tbody>
									</table>

									<?php 
        $display_option_cart = 'block';
        if ( 'on' !== $wbm_cart_page_stored_results_serialize_banner_enable_status ) {
            $display_option_cart = 'none';
        }
        ?>
									<div
										class="wbm-cart-upload-image-html <?php 
        echo  esc_attr( $display_option_cart ) ;
        ?>">
										<fieldset class="innerbanner">
											<legend><?php 
        esc_html_e( 'General Settings', 'woo-banner-management' );
        ?></legend>
											<?php 
        ?>
												<table class="form-table" id="form-table">
													<tbody>
													<tr>
														<th scope="row"><label class="wbm_leble_setting_css"
																			   for="wbm_cart_page_single_upload_file_button"><?php 
        esc_html_e( 'Banner Image', 'woo-banner-management' );
        ?></label>
														</th>
														<td>
															<a class='wbm_cart_page_single_upload_file_button button'
															   id="wbm_cart_page_single_upload_file_button"
															   uploader_title="<?php 
        esc_attr_e( 'Select File', 'woo-banner-management' );
        ?>"
															   uploader_button_text="<?php 
        esc_attr_e( 'Include File', 'woo-banner-management' );
        ?>"><?php 
        esc_html_e( 'Upload File', 'woo-banner-management' );
        ?></a>
															<a class='wbm_cart_page_remove_single_file button'><?php 
        esc_html_e( 'Remove File', 'woo-banner-management' );
        ?></a>
														</td>
													</tr>
													<tr>
														<th scope="row"></th>
														<?php 
        
        if ( $wbm_cart_page_stored_results_serialize_banner_src === '' ) {
            $cart_page_benner_css = "no-image";
        } else {
            $cart_page_benner_css = "yes-image";
        }
        
        ?>
														<td>
															<img
																class="wbm_cart_page_cat_banner_img_admin_single <?php 
        echo  esc_attr( $cart_page_benner_css ) ;
        ?>"
																src="<?php 
        echo  esc_url( $wbm_cart_page_stored_results_serialize_banner_src ) ;
        ?>"/>
														</td>
													</tr>
													<tr>
														<th scope="row"><label class="wbm_leble_setting_css"
																			   for="cart_page_banner_single_image_link"><?php 
        esc_html_e( 'Banner Image Link', 'woo-banner-management' );
        ?></label>
														</th>
														<td><input type="url"
																   id="cart_page_banner_single_image_link"
																   title="<?php 
        esc_attr_e( 'Example: https://multidots.com', 'woo-banner-management' );
        ?>"
																   name='term_meta[banner_link]'
																   value='<?php 
        echo  esc_attr( $wbm_cart_page_stored_results_serialize_banner_link ) ;
        ?>'/>
															<p><label class="banner_link_label"
																	  for="cart_page_banner_single_image_link"><em><?php 
        esc_html_e( 'Where users will be directed if they click on the banner.', 'woo-banner-management' );
        ?></em></label>
															</p></td>
													</tr>

													</tbody>
												</table>
												<?php 
        ?>
										</fieldset>
									</div>
								</div>
							</div><!--end .accordion-section-content-->
						</div><!--end .accordion-section-->
						<div class="accordion-section">
							<?php 
        
        if ( $wbm_checkout_page_stored_results_serialize_banner_enable_status === 'on' ) {
            $setting_enable_or_not_checkout = " ( Enable ) ";
            $setting_enable_or_color_checkout = "green";
        } else {
            $setting_enable_or_not_checkout = " ( Disable ) ";
            $setting_enable_or_color_checkout = "red";
        }
        
        ?>
							<a class="accordion-section-title"
							   href="#wbm-enable-banner-for-checkout-page"><?php 
        esc_html_e( 'Banner for checkout page', 'woo-banner-management' );
        ?>
								<span id="checkout_page_status_enable_or_disable"
									  class="checkout_page_status_enable_or_disable <?php 
        echo  esc_attr( $setting_enable_or_color_checkout ) ;
        ?>">
                                        <?php 
        esc_html_e( $setting_enable_or_not_checkout, 'woo-banner-management' );
        ?>
                                    </span>
							</a>
							<div id="wbm-enable-banner-for-checkout-page" class="accordion-section-content">
								<div class="woocommerce-banner-managment-checkout-setting-admin">
									<table class="form-table" id="form-table-wbm-checkout-page">

										<tbody>
										<tr>
											<th scope="row"><label class="wbm_leble_setting_css"
																   for="wbm_shop_setting_checkout_enable"><?php 
        esc_html_e( 'Enable/Disable', 'woo-banner-management' );
        ?> </label>
											</th>
											<td><input type="checkbox" value="on"
													   id="wbm_shop_setting_checkout_enable"
													   class="wbm_shop_setting_checkout_enable_or_not" <?php 
        checked( $wbm_checkout_page_stored_results_serialize_banner_enable_status, 'on' );
        ?>></td>
											<?php 
        $CheckOut_url_real = "#";
        $CheckOut_url = wc_get_checkout_url();
        if ( !empty($CheckOut_url) ) {
            $CheckOut_url_real = $CheckOut_url;
        }
        
        if ( $wbm_checkout_page_stored_results_serialize_banner_enable_status === 'on' ) {
            $check_out_preview_content = '<strong>' . __( "Preview :", "woo-banner-management" ) . '</strong> <a href="' . $CheckOut_url_real . '" target="_blank">' . __( 'Click here', 'woo-banner-management' ) . '</a>';
        } else {
            $check_out_preview_content = "";
        }
        
        ?>

											<input type="hidden" id="checkout_page_hidden_url"
												   value="<?php 
        echo  esc_url( $CheckOut_url_real ) ;
        ?>">
											<td>
												<span
													class="Preview_link_for_checkout_page"><?php 
        echo  wp_kses_post( $check_out_preview_content ) ;
        ?></span>
											</td>
										</tr>
										</tbody>
									</table>
									<?php 
        $display_option_checkout = 'block';
        if ( 'on' !== $wbm_checkout_page_stored_results_serialize_banner_enable_status ) {
            $display_option_checkout = 'none';
        }
        ?>
									<div
										class="wbm-checkout-upload-image-html <?php 
        echo  esc_attr( $display_option_checkout ) ;
        ?>">
										<fieldset class="innerbanner">
											<legend><?php 
        esc_html_e( 'General Settings', 'woo-banner-management' );
        ?></legend>
											<?php 
        ?>
												<table class="form-table" id="form-table">
													<tbody>
													<tr>
														<th scope="row"><label class="wbm_leble_setting_css"
																			   for="wbm_checkout_page_single_upload_file_button"><?php 
        esc_html_e( 'Banner Image', 'woo-banner-management' );
        ?></label>
														</th>
														<td>
															<a class='wbm_checkout_page_single_upload_file_button button'
															   id="wbm_checkout_page_single_upload_file_button"
															   uploader_title="<?php 
        esc_attr_e( 'Select File', 'woo-banner-management' );
        ?>"
															   uploader_button_text="<?php 
        esc_attr_e( 'Include File', 'woo-banner-management' );
        ?>"><?php 
        esc_html_e( 'Upload File', 'woo-banner-management' );
        ?></a>
															<a class='wbm_checkout_page_remove_single_file button'><?php 
        esc_html_e( 'Remove File', 'woo-banner-management' );
        ?></a>
														</td>
													</tr>
													<tr>
														<th scope="row"></th>
														<?php 
        
        if ( $wbm_checkout_page_stored_results_serialize_banner_src === '' ) {
            $checkout_page_benner_css = "none";
        } else {
            $checkout_page_benner_css = "block";
        }
        
        ?>
														<td>
															<img
																class="wbm_checkout_page_cat_banner_img_admin_single <?php 
        echo  esc_attr( $checkout_page_benner_css ) ;
        ?>"
																src="<?php 
        echo  esc_url( $wbm_checkout_page_stored_results_serialize_banner_src ) ;
        ?>"/>
														</td>
													</tr>
													<tr>
														<th scope="row"><label class="wbm_leble_setting_css"
																			   for="checkout_page_banner_single_image_link"><?php 
        esc_html_e( 'Banner Image Link' );
        ?></label>
														</th>
														<td><input type="url"
																   id="checkout_page_banner_single_image_link"
																   title="<?php 
        esc_attr_e( 'Example: https://multidots.com', 'woo-banner-management' );
        ?>"
																   name='term_meta[banner_link]'
																   value='<?php 
        echo  esc_attr( $wbm_checkout_page_stored_results_serialize_banner_link ) ;
        ?>'/>
															<p><label class="banner_link_label"
																	  for="checkout_page_banner_single_image_link"><em><?php 
        esc_html_e( 'Where users will be directed if they click on the banner.', 'woo-banner-management' );
        ?></em></label>
															</p></td>
													</tr>

													</tbody>
												</table>
												<?php 
        ?>
										</fieldset>
									</div>
								</div>
							</div><!--end .accordion-section-content-->
						</div><!--end .accordion-section-->
						<div class="accordion-section">
							<?php 
        
        if ( $wbm_thankyou_page_stored_results_serialize_banner_enable_status === 'on' ) {
            $setting_enable_or_not_thankyou = " ( Enable ) ";
            $setting_enable_or_color_thankyou = "green";
        } else {
            $setting_enable_or_not_thankyou = " ( Disable ) ";
            $setting_enable_or_color_thankyou = "red";
        }
        
        ?>
							<a class="accordion-section-title"
							   href="#wbm-enable-banner-for-thankyou-page"><?php 
        esc_html_e( 'Banner for thank you page', 'woo-banner-management' );
        ?>
								<span id="thankyou_page_status_enable_or_disable"
									  class="thankyou_page_status_enable_or_disable <?php 
        echo  esc_attr( $setting_enable_or_color_thankyou ) ;
        ?>"><?php 
        esc_html_e( $setting_enable_or_not_thankyou, 'woo-banner-management' );
        ?></span></a>
							<div id="wbm-enable-banner-for-thankyou-page" class="accordion-section-content">
								<div class="woocommerce-banner-managment-thank-you-setting-admin">
									<table class="form-table" id="form-table-wbm-thankyou-page">
										<tbody>
										<tr>
											<th scope="row"><label class="wbm_leble_setting_css"
																   for="wbm_shop_setting_thank_you_page_enable"><?php 
        esc_html_e( 'Enable/Disable', 'woo-banner-management' );
        ?></label>
											</th>
											<td><input type="checkbox" value="on"
													   id="wbm_shop_setting_thank_you_page_enable"
													   class="wbm_shop_setting_thank_you_page_enable_or_not" <?php 
        checked( $wbm_thankyou_page_stored_results_serialize_banner_enable_status, 'on' );
        ?>></td>
										</tr>
										</tbody>
									</table>
									<?php 
        $display_option_checkout = 'block';
        if ( 'on' !== $wbm_thankyou_page_stored_results_serialize_banner_enable_status ) {
            $display_option_checkout = 'none';
        }
        ?>
									<div
										class="wbm-thank-you-page-upload-image-html <?php 
        echo  esc_attr( $display_option_checkout ) ;
        ?>">
										<fieldset class="innerbanner">
											<legend><?php 
        esc_html_e( 'General Settings', 'woo-banner-management' );
        ?></legend>
											<?php 
        ?>
												<table class="form-table" id="form-table">
													<tbody>
													<tr>
														<th scope="row"><label class="wbm_leble_setting_css"
																			   for="wbm_thankyou_page_single_upload_file_button"><?php 
        esc_html_e( 'Banner Image', 'woo-banner-management' );
        ?></label>
														</th>
														<td>
															<a class='wbm_thankyou_page_single_upload_file_button button'
															   id="wbm_thankyou_page_single_upload_file_button"
															   uploader_title="<?php 
        esc_attr_e( 'Select File', 'woo-banner-management' );
        ?>"
															   uploader_button_text="<?php 
        esc_attr_e( 'Include File', 'woo-banner-management' );
        ?>"><?php 
        esc_html_e( 'Upload File', 'woo-banner-management' );
        ?></a>
															<a class='wbm_thankyou_page_remove_single_file button'><?php 
        esc_html_e( 'Remove File', 'woo-banner-management' );
        ?></a>
														</td>
													</tr>
													<tr>
														<th scope="row"></th>
														<?php 
        
        if ( $wbm_thankyou_page_stored_results_serialize_banner_src === '' ) {
            $thankyou_page_benner_css = "no-image";
        } else {
            $thankyou_page_benner_css = "yes-image";
        }
        
        ?>
														<td>
															<img
																class="wbm_thankyou_page_cat_banner_img_admin_single <?php 
        echo  esc_attr( $thankyou_page_benner_css ) ;
        ?>"
																src="<?php 
        echo  esc_url( $wbm_thankyou_page_stored_results_serialize_banner_src ) ;
        ?>"/>
														</td>
													</tr>
													<tr>
														<th scope="row"><label class="wbm_leble_setting_css"
																			   for="thankyou_page_banner_single_image_link"><?php 
        esc_html_e( 'Banner Image Link', 'woo-banner-management' );
        ?></label>
														</th>
														<td><input type="url"
																   id="thankyou_page_banner_single_image_link"
																   title="<?php 
        esc_attr_e( 'Example: https://multidots.com', 'woo-banner-management' );
        ?>"
																   name='term_meta[banner_link]'
																   value='<?php 
        echo  esc_attr( $wbm_thankyou_page_stored_results_serialize_banner_link ) ;
        ?>'/>
															<p><label class="banner_link_label"
																	  for="thankyou_page_banner_single_image_link"><em><?php 
        esc_html_e( 'Where users will be directed if they click on the banner.', 'woo-banner-management' );
        ?></em></label>
															</p></td>
													</tr>
													</tbody>
												</table>
												<?php 
        ?>
									</div>
								</div>
							</div><!--end .accordion-section-content-->
						</div><!--end .accordion-section-->
					</div>
				</fieldset>
				<fieldset class="wbm_global">
					<legend>
						<div class="wbm-setting-header">
							<h2><?php 
        esc_html_e( 'Category specific banner', 'woo-banner-management' );
        ?></h2>
						</div>
					</legend>
					<div class="category_based_settings">
						<p><?php 
        esc_html_e( 'You can upload custom banner at the top of your product category pages. Easily update the image through your product category edit page.', 'woo-banner-management' );
        ?></p>
						<?php 
        ?>
								<img class="preview_category_page_image"
							 src="<?php 
        echo  esc_url( plugin_dir_url( __FILE__ ) . 'assets/images/category_setting_image.png' ) ;
        ?>">
							<?php 
        ?>
						<p>
							<strong><?php 
        esc_html_e( 'Go to category page', 'woo-banner-management' );
        ?></strong>
							<a
								target="_blank"
								href="<?php 
        echo  esc_url( site_url() . '/wp-admin/edit-tags.php?taxonomy=product_cat&post_type=product' ) ;
        ?>"><?php 
        esc_html_e( 'click here', 'woo-banner-management' );
        ?></a>
						</p>
					</div>
				</fieldset>
				<input type="button" name="save_wbmshop" id="save_wbm_shop_page_setting"
					   class="button button-primary"
					   value="<?php 
        esc_html_e( 'Save Changes', 'woo-banner-management' );
        ?>">
				<img class="banner-setting-loader"
					 src="<?php 
        echo  esc_url( plugin_dir_url( __FILE__ ) . 'images/ajax-loader.gif' ) ;
        ?>"
					 alt="ajax-loader"/>
			</div>
		</div>
		<?php 
    }
    
    /**
     *    Set the custom html for category edit field
     *
     */
    function wcbm_product_cat_taxonomy_custom_fields( $tag )
    {
        $t_id = $tag->term_id;
        $term_meta = ( function_exists( 'wcbm_get_category_banner_data' ) ? wcbm_get_category_banner_data( $t_id ) : '' );
        
        if ( isset( $term_meta['banner_url_id'] ) && '' !== $term_meta['banner_url_id'] ) {
            $banner_url = $term_meta['banner_url_id'];
        } else {
            $banner_url = '';
        }
        
        // Get banner link
        
        if ( isset( $term_meta['banner_link'] ) and '' !== $term_meta['banner_link'] ) {
            $banner_link = $term_meta['banner_link'];
        } else {
            $banner_link = '';
        }
        
        
        if ( isset( $term_meta['auto_display_banner'] ) && 'on' === $term_meta['auto_display_banner'] || !isset( $term_meta['auto_display_banner'] ) ) {
            $auto_display_banner = true;
        } else {
            $auto_display_banner = false;
        }
        
        
        if ( isset( $term_meta['cat_page_select_image'] ) && '' !== $term_meta['cat_page_select_image'] ) {
            $cat_page_select_image = $term_meta['cat_page_select_image'];
        } else {
            $cat_page_select_image = 'cat-single-image';
        }
        
        ?>
		<tr class="form-field auto_display_banner">
			<th scope="row" valign="top">
				<label
					for="auto_display_banner"><?php 
        esc_html_e( 'Enable/Disable', 'woo-banner-management' );
        ?></label>
			</th>
			<td class="auto_display">
				<fieldset>
					<input id="auto_display_banner" name="term_meta[auto_display_banner]" type="checkbox" value="on"
						   class="auto_display_banner" <?php 
        checked( $auto_display_banner, true );
        ?>/>
					<label class="auto_display_banner_label" for="auto_display_banner"><em></em></label>
				</fieldset>
			</td>
			<td><?php 
        
        if ( $auto_display_banner ) {
            esc_html_e( 'Preview', 'woo-banner-management' );
            ?>:
					<a
					href="<?php 
            echo  esc_url( get_category_link( $t_id ) ) ;
            ?>"
					target="_blank"><?php 
            esc_html_e( 'Click here', 'woo-banner-management' );
            ?></a><?php 
        }
        
        ?>
			</td>
		</tr>
		<?php 
        ?>
		<tr class="form-field mdwbm_banner_url_form_field hide_cat_single_banner_upload <?php 
        echo  ( '' === $cat_page_select_image || isset( $cat_page_select_image ) && 'cat-single-image' === $cat_page_select_image ? 'block' : 'none' ) ;
        ?>"
			id="cat-single-banner-upload">
			<th scope="row" valign="top">
				<label
					for="mdwbm_upload_single_file_button"><?php 
        esc_html_e( 'Banner Image', 'woo-banner-management' );
        ?></label>
			</th>
			<td>
				<a class='mdwbm_upload_single_file_button button' id="mdwbm_upload_single_file_button"
				   uploader_title="<?php 
        esc_attr_e( 'Select File', 'woo-banner-management' );
        ?>"
				   uploader_button_text="<?php 
        esc_attr_e( 'Include File', 'woo-banner-management' );
        ?>"><?php 
        esc_html_e( 'Upload File', 'woo-banner-management' );
        ?></a>
				<a class='mdwbm_remove_file button'
				   id="mdwbm_remove_file_id"><?php 
        esc_html_e( 'Remove File', 'woo-banner-management' );
        ?></a>
			</td>
		</tr>
		<tr class="form-field mdwbm_banner_image_form_field hide_cat_single_banner_image <?php 
        echo  ( '' === $cat_page_select_image || isset( $cat_page_select_image ) && 'cat-single-image' === $cat_page_select_image ? 'block' : 'none' ) ;
        ?>"
			id="cat-single-banner-image">
			<th scope="row"></th>
			<td id="display_image_id">
				<?php 
        if ( is_numeric( $banner_url ) ) {
            $banner_url = wp_get_attachment_url( $banner_url );
        }
        ?>
				<img class="cat_banner_single_img_admin <?php 
        echo  ( '' === $banner_url ? 'none' : 'block' ) ;
        ?>"
					 src="<?php 
        echo  esc_url( $banner_url ) ;
        ?>"
					 id="cat_banner_single_img_admin_id"/>
				<input type="hidden" class='mdwbm_image' name='term_meta[banner_url_id]'
					   value='<?php 
        echo  esc_attr( $banner_url ) ;
        ?>' id="mdwbm_image_id"/>
			</td>
		</tr>
		<tr class="form-field banner_link_form_field hide_banner_link_form_field <?php 
        echo  ( '' === $cat_page_select_image || isset( $cat_page_select_image ) && 'cat-single-image' === $cat_page_select_image ? 'block' : 'none' ) ;
        ?>"
			id="cat-single-image-link">
			<th scope="row" valign="top">
				<label
					for="cat-single-banner-link"><?php 
        esc_html_e( 'Banner image link', 'woo-banner-management' );
        ?></label>
			</th>
			<td>

				<input type="url" id="cat-single-banner-link" name='term_meta[banner_link]'
					   value='<?php 
        echo  esc_attr( $banner_link ) ;
        ?>'/>
				<label class="banner_link_label"
					   for="cat-single-banner-link"><em><?php 
        esc_html_e( 'Where users will be directed if they click on the banner.', 'woo-banner-management' );
        ?></em></label>
			</td>
		</tr>
		<?php 
        ?>
		</fieldset>
		<?php 
    }
    
    /**
     * Save the Woocommerce-Banner-Managment Category Data
     *
     * @param  $term_id
     */
    function wcbm_product_cat_save_taxonomy_custom_fields( $term_id )
    {
        $args = array(
            'term_meta' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_REQUIRE_ARRAY,
        ),
        );
        $post_term_meta = filter_input_array( INPUT_POST, $args );
        
        if ( isset( $post_term_meta['term_meta'] ) ) {
            $t_id = $term_id;
            $term_meta = wcbm_get_category_banner_data( $t_id );
            if ( empty($term_meta) || !is_array( $term_meta ) ) {
                $term_meta = array();
            }
            $posted_term_meta = $post_term_meta['term_meta'];
            if ( !isset( $posted_term_meta['auto_display_banner'] ) ) {
                $posted_term_meta['auto_display_banner'] = 'off';
            }
            $posted_term_meta['images'] = $posted_term_meta_image;
            $cat_keys = array_keys( $posted_term_meta );
            if ( !empty($cat_keys) && is_array( $cat_keys ) ) {
                foreach ( $cat_keys as $key ) {
                    if ( isset( $posted_term_meta[$key] ) ) {
                        $term_meta[$key] = $posted_term_meta[$key];
                    }
                }
            }
            //save the option array
            if ( function_exists( 'wcbm_save_cat_banner_data' ) ) {
                wcbm_save_cat_banner_data( $t_id, $term_meta );
            }
        }
    
    }
    
    /**
     * Save WCBM shop page setting
     *
     */
    public function wcbm_save_shop_page_banner_data()
    {
        $shop_page_banner_image_results = filter_input( INPUT_POST, 'shop_page_banner_image_results', FILTER_SANITIZE_STRING );
        $shop_page_banner_image_results = ( !empty($shop_page_banner_image_results) ? $shop_page_banner_image_results : '' );
        $shop_page_banner_link_results = filter_input( INPUT_POST, 'shop_page_banner_link_results', FILTER_SANITIZE_STRING );
        $shop_page_banner_link_results = ( !empty($shop_page_banner_link_results) ? $shop_page_banner_link_results : '' );
        $shop_page_banner_enable_or_not_results = filter_input( INPUT_POST, 'shop_page_banner_enable_or_not_results', FILTER_SANITIZE_STRING );
        $shop_page_banner_enable_or_not_results = ( !empty($shop_page_banner_enable_or_not_results) ? $shop_page_banner_enable_or_not_results : '' );
        $cart_page_banner_image_results = filter_input( INPUT_POST, 'cart_page_banner_image_results', FILTER_SANITIZE_STRING );
        $cart_page_banner_image_results = ( !empty($cart_page_banner_image_results) ? $cart_page_banner_image_results : '' );
        $cart_page_banner_link_results = filter_input( INPUT_POST, 'cart_page_banner_link_results', FILTER_SANITIZE_STRING );
        $cart_page_banner_link_results = ( !empty($cart_page_banner_link_results) ? $cart_page_banner_link_results : '' );
        $cart_page_banner_enable_or_not_results = filter_input( INPUT_POST, 'cart_page_banner_enable_or_not_results', FILTER_SANITIZE_STRING );
        $cart_page_banner_enable_or_not_results = ( !empty($cart_page_banner_enable_or_not_results) ? $cart_page_banner_enable_or_not_results : '' );
        $checkout_page_banner_image_results = filter_input( INPUT_POST, 'checkout_page_banner_image_results', FILTER_SANITIZE_STRING );
        $checkout_page_banner_image_results = ( !empty($checkout_page_banner_image_results) ? $checkout_page_banner_image_results : '' );
        $checkout_page_banner_link_results = filter_input( INPUT_POST, 'checkout_page_banner_link_results', FILTER_SANITIZE_STRING );
        $checkout_page_banner_link_results = ( !empty($checkout_page_banner_link_results) ? $checkout_page_banner_link_results : '' );
        $checkout_page_banner_enable_or_not_results = filter_input( INPUT_POST, 'checkout_page_banner_enable_or_not_results', FILTER_SANITIZE_STRING );
        $checkout_page_banner_enable_or_not_results = ( !empty($checkout_page_banner_enable_or_not_results) ? $checkout_page_banner_enable_or_not_results : '' );
        $thankyou_page_banner_image_results = filter_input( INPUT_POST, 'thankyou_page_banner_image_results', FILTER_SANITIZE_STRING );
        $thankyou_page_banner_image_results = ( !empty($thankyou_page_banner_image_results) ? $thankyou_page_banner_image_results : '' );
        $thankyou_page_banner_link_results = filter_input( INPUT_POST, 'thankyou_page_banner_link_results', FILTER_SANITIZE_STRING );
        $thankyou_page_banner_link_results = ( !empty($thankyou_page_banner_link_results) ? $thankyou_page_banner_link_results : '' );
        $thankyou_page_banner_enable_or_not_results = filter_input( INPUT_POST, 'thankyou_page_banner_enable_or_not_results', FILTER_SANITIZE_STRING );
        $thankyou_page_banner_enable_or_not_results = ( !empty($thankyou_page_banner_enable_or_not_results) ? $thankyou_page_banner_enable_or_not_results : '' );
        $shop_page_data_stored_array = array(
            'shop_page_banner_image_src'     => $shop_page_banner_image_results,
            'shop_page_banner_link_src'      => $shop_page_banner_link_results,
            'shop_page_banner_enable_status' => $shop_page_banner_enable_or_not_results,
        );
        $cart_page_data_stored_array = array(
            'cart_page_banner_image_src'     => $cart_page_banner_image_results,
            'cart_page_banner_link_src'      => $cart_page_banner_link_results,
            'cart_page_banner_enable_status' => $cart_page_banner_enable_or_not_results,
        );
        $checkout_page_data_stored_array = array(
            'checkout_page_banner_image_src'     => $checkout_page_banner_image_results,
            'checkout_page_banner_link_src'      => $checkout_page_banner_link_results,
            'checkout_page_banner_enable_status' => $checkout_page_banner_enable_or_not_results,
        );
        $thankyou_page_data_stored_array = array(
            'thankyou_page_banner_image_src'     => $thankyou_page_banner_image_results,
            'thankyou_page_banner_link_src'      => $thankyou_page_banner_link_results,
            'thankyou_page_banner_enable_status' => $thankyou_page_banner_enable_or_not_results,
        );
        
        if ( function_exists( 'wcbm_save_page_banner_data' ) ) {
            wcbm_save_page_banner_data( 'shop', $shop_page_data_stored_array );
            wcbm_save_page_banner_data( 'cart', $cart_page_data_stored_array );
            wcbm_save_page_banner_data( 'checkout', $checkout_page_data_stored_array );
            wcbm_save_page_banner_data( 'thankyou', $thankyou_page_data_stored_array );
        }
        
        die;
    }
    
    /**
     * Show Category Banner In Category Page
     *
     */
    public function wcbm_show_category_banner()
    {
        // Make sure this is a product category page
        
        if ( is_product_category() ) {
            $category = get_queried_object();
            $cat_id = $category->term_id;
            $term_options = ( function_exists( 'wcbm_get_category_banner_data' ) ? wcbm_get_category_banner_data( $cat_id ) : '' );
            $alt_tag_value = '';
            
            if ( isset( $term_options['auto_display_banner'] ) && 'on' === $term_options['auto_display_banner'] || !isset( $term_options['auto_display_banner'] ) ) {
                ?>
						<div class="wbm_banner_image">
						<?php 
                if ( '' !== $term_options['banner_url_id'] ) {
                    $url = $term_options['banner_url_id'];
                }
                // Exit if the image url doesn't exist
                if ( !isset( $url ) or false === $url ) {
                    return;
                }
                // Get the banner link if it exists
                if ( '' !== $term_options['banner_link'] ) {
                    $link = $term_options['banner_link'];
                }
                // Print Output
                if ( isset( $link ) ) {
                    
                    if ( '' === $link ) {
                        echo  "<a>" ;
                    } else {
                        
                        if ( !preg_match( "~^(?:f|ht)tps?://~i", $link ) ) {
                            $image_link = "http://" . $link;
                        } else {
                            $image_link = $link;
                        }
                        
                        echo  "<a href='" . esc_url( $image_link ) . "' target='_blank'>" ;
                    }
                
                }
                if ( is_numeric( $url ) ) {
                    $url = wp_get_attachment_url( $url );
                }
                if ( false !== $url ) {
                    echo  "<img src='" . esc_url( $url ) . "' class='category_banner_image' />" ;
                }
                if ( isset( $link ) ) {
                    echo  "</a>" ;
                }
                echo  '</div>' ;
            }
        
        }
    
    }
    
    /**
     * Function For display the banner image in shop page
     *
     *
     */
    public function wcbm_show_shop_page_banner()
    {
        $wbm_shop_page_stored_results_serialize_banner_src = '';
        $wbm_shop_page_stored_results_serialize_banner_link = '';
        $wbm_shop_page_stored_results_serialize_banner_enable_status = '';
        $alt_tag_value = '';
        $wbm_shop_page_stored_results = ( function_exists( 'wcbm_get_page_banner_data' ) ? wcbm_get_page_banner_data( 'shop' ) : '' );
        
        if ( isset( $wbm_shop_page_stored_results ) && !empty($wbm_shop_page_stored_results) ) {
            $wbm_shop_page_stored_results_serialize = $wbm_shop_page_stored_results;
            
            if ( !empty($wbm_shop_page_stored_results_serialize) ) {
                $wbm_shop_page_stored_results_serialize_banner_src = ( !empty($wbm_shop_page_stored_results_serialize['shop_page_banner_image_src']) ? $wbm_shop_page_stored_results_serialize['shop_page_banner_image_src'] : '' );
                $wbm_shop_page_stored_results_serialize_banner_link = ( !empty($wbm_shop_page_stored_results_serialize['shop_page_banner_link_src']) ? $wbm_shop_page_stored_results_serialize['shop_page_banner_link_src'] : '' );
                $wbm_shop_page_stored_results_serialize_banner_enable_status = ( !empty($wbm_shop_page_stored_results_serialize['shop_page_banner_enable_status']) ? $wbm_shop_page_stored_results_serialize['shop_page_banner_enable_status'] : '' );
            }
        
        }
        
        if ( is_shop() ) {
            
            if ( !empty($wbm_shop_page_stored_results_serialize_banner_enable_status) && $wbm_shop_page_stored_results_serialize_banner_enable_status === 'on' ) {
                ?>
						<div class="wbm_banner_image">
							<?php 
                
                if ( '' === $wbm_shop_page_stored_results_serialize_banner_link ) {
                    $alt_tag_css_shop_page_fornt = '';
                } else {
                    
                    if ( !preg_match( "~^(?:f|ht)tps?://~i", $wbm_shop_page_stored_results_serialize_banner_link ) ) {
                        $image_link = "http://" . $wbm_shop_page_stored_results_serialize_banner_link;
                    } else {
                        $image_link = $wbm_shop_page_stored_results_serialize_banner_link;
                    }
                    
                    $alt_tag_css_shop_page_fornt = 'href="' . esc_url( $image_link ) . '" target="_blank"';
                }
                
                ?>
							<a <?php 
                echo  wp_kses_post( $alt_tag_css_shop_page_fornt ) ;
                ?>>
								<p>
									<img
										src="<?php 
                echo  esc_url( $wbm_shop_page_stored_results_serialize_banner_src ) ;
                ?>"
										class="category_banner_image"
										title="<?php 
                echo  esc_attr( $alt_tag_value ) ;
                ?>"
										alt="<?php 
                echo  esc_attr( $alt_tag_value ) ;
                ?>">
								</p>
							</a>
						</div>
						<?php 
            }
        
        }
    }
    
    /**
     * Function For display banner image in cart page
     *
     */
    public function wcbm_show_cart_page_banner()
    {
        $wbm_cart_page_stored_results_serialize_banner_src = '';
        $wbm_cart_page_stored_results_serialize_banner_link = '';
        $wbm_cart_page_stored_results_serialize_banner_enable_status = '';
        $alt_tag_value = '';
        $wbm_cart_page_stored_results = ( function_exists( 'wcbm_get_page_banner_data' ) ? wcbm_get_page_banner_data( 'cart' ) : '' );
        
        if ( isset( $wbm_cart_page_stored_results ) && !empty($wbm_cart_page_stored_results) ) {
            $wbm_cart_page_stored_results_serialize = $wbm_cart_page_stored_results;
            
            if ( !empty($wbm_cart_page_stored_results_serialize) ) {
                $wbm_cart_page_stored_results_serialize_banner_src = ( !empty($wbm_cart_page_stored_results_serialize['cart_page_banner_image_src']) ? $wbm_cart_page_stored_results_serialize['cart_page_banner_image_src'] : '' );
                $wbm_cart_page_stored_results_serialize_banner_link = ( !empty($wbm_cart_page_stored_results_serialize['cart_page_banner_link_src']) ? $wbm_cart_page_stored_results_serialize['cart_page_banner_link_src'] : '' );
                $wbm_cart_page_stored_results_serialize_banner_enable_status = ( !empty($wbm_cart_page_stored_results_serialize['cart_page_banner_enable_status']) ? $wbm_cart_page_stored_results_serialize['cart_page_banner_enable_status'] : '' );
            }
        
        }
        
        
        if ( !empty($wbm_cart_page_stored_results_serialize_banner_enable_status) && $wbm_cart_page_stored_results_serialize_banner_enable_status === 'on' ) {
            ?>
					<div class="wbm_banner_image">
						<?php 
            
            if ( $wbm_cart_page_stored_results_serialize_banner_link === '' ) {
                $alt_tag_css_cart_page_fornt = '';
            } else {
                
                if ( !preg_match( "~^(?:f|ht)tps?://~i", $wbm_cart_page_stored_results_serialize_banner_link ) ) {
                    $image_link = "http://" . $wbm_cart_page_stored_results_serialize_banner_link;
                } else {
                    $image_link = $wbm_cart_page_stored_results_serialize_banner_link;
                }
                
                $alt_tag_css_cart_page_fornt = 'href="' . $image_link . '" target="_blank"';
            }
            
            ?>
						<a <?php 
            echo  wp_kses_post( $alt_tag_css_cart_page_fornt ) ;
            ?>>
							<p>
								<img src="<?php 
            echo  esc_url( $wbm_cart_page_stored_results_serialize_banner_src ) ;
            ?>"
									 class="category_banner_image" title="<?php 
            echo  esc_attr( $alt_tag_value ) ;
            ?>"
									 alt="<?php 
            echo  esc_attr( $alt_tag_value ) ;
            ?>">
							</p>
						</a>
					</div>
					<?php 
        }
    
    }
    
    /**
     * Function For display banner image in check out page
     *
     */
    public function wcbm_show_checkout_page_banner()
    {
        $wbm_checkout_page_stored_results_serialize_banner_src = '';
        $wbm_checkout_page_stored_results_serialize_banner_link = '';
        $wbm_checkout_page_stored_results_serialize_banner_enable_status = '';
        $alt_tag_value = '';
        $wbm_checkout_page_stored_results = ( function_exists( 'wcbm_get_page_banner_data' ) ? wcbm_get_page_banner_data( 'checkout' ) : '' );
        
        if ( isset( $wbm_checkout_page_stored_results ) && !empty($wbm_checkout_page_stored_results) ) {
            $wbm_checkout_page_stored_results_serialize = $wbm_checkout_page_stored_results;
            
            if ( !empty($wbm_checkout_page_stored_results_serialize) ) {
                $wbm_checkout_page_stored_results_serialize_banner_src = ( !empty($wbm_checkout_page_stored_results_serialize['checkout_page_banner_image_src']) ? $wbm_checkout_page_stored_results_serialize['checkout_page_banner_image_src'] : '' );
                $wbm_checkout_page_stored_results_serialize_banner_link = ( !empty($wbm_checkout_page_stored_results_serialize['checkout_page_banner_link_src']) ? $wbm_checkout_page_stored_results_serialize['checkout_page_banner_link_src'] : '' );
                $wbm_checkout_page_stored_results_serialize_banner_enable_status = ( !empty($wbm_checkout_page_stored_results_serialize['checkout_page_banner_enable_status']) ? $wbm_checkout_page_stored_results_serialize['checkout_page_banner_enable_status'] : '' );
            }
        
        }
        
        
        if ( !empty($wbm_checkout_page_stored_results_serialize_banner_enable_status) && $wbm_checkout_page_stored_results_serialize_banner_enable_status === 'on' ) {
            ?>
					<div class="wbm_banner_image">
						<?php 
            
            if ( $wbm_checkout_page_stored_results_serialize_banner_link === '' ) {
                $alt_tag_css_checkout_page_fornt = '';
            } else {
                
                if ( !preg_match( "~^(?:f|ht)tps?://~i", $wbm_checkout_page_stored_results_serialize_banner_link ) ) {
                    $url = "http://" . $wbm_checkout_page_stored_results_serialize_banner_link;
                } else {
                    $url = $wbm_checkout_page_stored_results_serialize_banner_link;
                }
                
                $alt_tag_css_checkout_page_fornt = 'href="' . esc_url( $url ) . '" target="_blank"';
            }
            
            ?>
						<a <?php 
            echo  wp_kses_post( $alt_tag_css_checkout_page_fornt ) ;
            ?>>
							<p>
								<img
									src="<?php 
            echo  esc_url( $wbm_checkout_page_stored_results_serialize_banner_src ) ;
            ?>"
									class="category_banner_image" title="<?php 
            echo  esc_attr( $alt_tag_value ) ;
            ?>"
									alt="<?php 
            echo  esc_attr( $alt_tag_value ) ;
            ?>">
							</p>
						</a>
					</div>
					<?php 
        }
    
    }
    
    /**
     * Save For Later welcome page
     *
     */
    public function welcome_screen_do_activation_redirect()
    {
        // if no activation redirect
        if ( !get_transient( '_welcome_screen_activation_redirect_banner_management' ) ) {
            return;
        }
        // Delete the redirect transient
        delete_transient( '_welcome_screen_activation_redirect_banner_management' );
        // if activating from network, or bulk
        $activate_multi = filter_input( INPUT_GET, 'activate-multi', FILTER_SANITIZE_STRING );
        if ( is_network_admin() || isset( $activate_multi ) && !empty($activate_multi) ) {
            return;
        }
        wp_safe_redirect( add_query_arg( array(
            'page' => 'banner-setting&tab=wcbm-plugin-get-started',
        ), admin_url( 'admin.php' ) ) );
        exit;
    }

}