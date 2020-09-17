<?php
/**
 * Woo Extra Product Options Settings
 *
 * @author   ThemeHiGH
 * @category Admin
 */

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WEPOF_Settings')) :
class WEPOF_Settings {
	protected static $_instance = null;
	public $wepof_admin = null;
	public $wepof_public = null;

	public function __construct() {
		$required_classes = apply_filters('th_wepof_require_class', array(
			'common' => array(
				'classes/fe/rules/class-wepof-condition.php',
				'classes/fe/rules/class-wepof-condition-set.php',
				'classes/fe/rules/class-wepof-rule.php',
				'classes/fe/rules/class-wepof-rule-set.php',
				'classes/fe/fields/class-wepof-field.php',
				'classes/fe/fields/class-wepof-field-inputtext.php',
				'classes/fe/fields/class-wepof-field-hidden.php',
				'classes/fe/fields/class-wepof-field-number.php',
				'classes/fe/fields/class-wepof-field-tel.php',
				'classes/fe/fields/class-wepof-field-password.php',
				'classes/fe/fields/class-wepof-field-textarea.php',
				'classes/fe/fields/class-wepof-field-select.php',
				'classes/fe/fields/class-wepof-field-checkbox.php',
				'classes/fe/fields/class-wepof-field-checkboxgroup.php',
				'classes/fe/fields/class-wepof-field-radio.php',
				'classes/fe/fields/class-wepof-field-datepicker.php',
				'classes/fe/fields/class-wepof-field-colorpicker.php',
				'classes/fe/fields/class-wepof-field-heading.php',
				'classes/fe/fields/class-wepof-field-paragraph.php',
				'classes/fe/class-wepof-section.php',
				'classes/fe/class-wepof-utils.php',
				'classes/fe/class-wepof-utils-field.php',
				'classes/fe/class-wepof-utils-section.php',
				'classes/fe/class-wepof-data.php',
			),
			'admin' => array(
				'classes/class-wepof-settings-page.php',
				'classes/fe/class-wepof-product-options-settings.php',
				'classes/fe/class-thwepof-admin-settings-advanced.php',
			),
			'frontend' => array(
				'classes/fe/class-wepof-product-options-frontend.php',
			),
		));

		$this->include_required( $required_classes );
		$this->may_copy_older_version_settings();

		add_action('admin_menu', array($this, 'admin_menu'));
		add_filter('woocommerce_screen_ids', array($this, 'add_screen_id'));
		add_filter('plugin_action_links_'.THWEPOF_BASE_NAME, array($this, 'add_settings_link'));
		add_action('upgrader_process_complete', array($this, 'may_copy_older_version_settings'));

		$this->init();
	}

	public static function instance() {
		if(is_null(self::$_instance)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	protected function include_required( $required_classes ) {
		if(!function_exists('is_plugin_active')) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		foreach($required_classes as $section => $classes ) {
			foreach( $classes as $class ){
				if('common' == $section  || ('frontend' == $section && !is_admin() || ( defined('DOING_AJAX') && DOING_AJAX) )
					|| ('admin' == $section && is_admin()) && file_exists( THWEPOF_PATH . $class )){
					require_once( THWEPOF_PATH . $class );
				}
			}
		}
	}

	public function init() {
		$wepo_data = THWEPOF_Data::instance();
		add_action('wp_ajax_thwepof_load_products', array($wepo_data, 'load_products_ajax'));
    	add_action('wp_ajax_nopriv_thwepof_load_products', array($wepo_data, 'load_products_ajax'));

		if(!is_admin() || (defined( 'DOING_AJAX' ) && DOING_AJAX)){
			$this->wepof_public = new WEPOF_Product_Options_Frontend();
		}else if(is_admin()){
			$this->wepof_admin = WEPOF_Product_Options_Settings::instance();
		}

		//$this->may_copy_older_version_settings();
	}

	public function wepo_capability() {
		$allowed = array('manage_woocommerce', 'manage_options');
		$capability = apply_filters('thwepof_required_capability', 'manage_woocommerce');

		if(!in_array($capability, $allowed)){
			$capability = 'manage_woocommerce';
		}
		return $capability;
	}

	public function admin_menu() {
		$capability = $this->wepo_capability();
		$this->screen_id = add_submenu_page('edit.php?post_type=product', __('WooCommerce Extra Product Option', 'woo-extra-product-options'),
		__('Extra Product Option', 'woo-extra-product-options'), $capability, 'thwepof_extra_product_options', array($this, 'output_settings'));

		add_action('admin_print_scripts-'. $this->screen_id, array($this, 'enqueue_admin_scripts'));
	}

	public function add_screen_id($ids){
		$ids[] = 'product_page_thwepof_extra_product_options';
		$ids[] = strtolower(__('Product', 'woocommerce')) .'_page_thwepof_extra_product_options';
		return $ids;
	}

	public function add_settings_link($links) {
		$premium_link = '<a href="https://www.themehigh.com/product/woocommerce-extra-product-options">'. __('Premium plugin') .'</a>';
		$settings_link = '<a href="'.admin_url('edit.php?post_type=product&page=thwepof_extra_product_options').'">'. __('Settings') .'</a>';

		array_unshift($links, $premium_link);
		array_unshift($links, $settings_link);
		return $links;
	}

	public function output_settings() {
		//$this->output_old_settings_copy_message();
		$tab = isset( $_GET['tab'] ) ? esc_attr( $_GET['tab'] ) : 'general_settings';

		if($tab === 'advanced_settings'){			
			$advanced_settings = THWEPOF_Admin_Settings_Advanced::instance();	
			$advanced_settings->render_page();			
		}else{
			$general_settings = WEPOF_Product_Options_Settings::instance();
			$general_settings->render_page();
		}
	}

	public function enqueue_admin_scripts() {
		wp_enqueue_style (array('woocommerce_admin_styles', 'jquery-ui-style'));
		wp_enqueue_style ('thwepof-admin-style', plugins_url('/assets/css/thwepof-field-editor-admin.css', dirname(__FILE__)));
		wp_enqueue_script('thwepof-admin-script', plugins_url('/assets/js/thwepof-field-editor-admin.js', dirname(__FILE__)),
		array('jquery', 'jquery-ui-dialog', 'jquery-ui-sortable', 'jquery-tiptip', 'wc-enhanced-select', 'select2'), THWEPOF_VERSION, true);
	}

	public function output_old_settings_copy_message(){
		$new_settings = THWEPOF_Utils::get_sections();
		if($new_settings){
			return;
		}

		$custom_fields = get_option('thwepof_custom_product_fields');

		if(is_array($custom_fields) && !empty($custom_fields)){
			if(isset($_POST['may_copy_settings']))
				$result = $this->may_copy_older_version_settings();

			?>
			<form method="post" action="">
				<p>Copy older version settings <input type="submit" name="may_copy_settings" value="Copy Settings" /></p>
	        </form>
			<?php
		}
	}

	public function may_copy_older_version_settings(){
		$new_settings = THWEPOF_Utils::get_sections();
		if($new_settings){
			return;
		}

		$custom_fields = get_option('thwepof_custom_product_fields');
		if(is_array($custom_fields) && !empty($custom_fields)){
			$fields_before = isset($custom_fields['woo_before_add_to_cart_button']) ? $custom_fields['woo_before_add_to_cart_button'] : false;
			$fields_after = isset($custom_fields['woo_after_add_to_cart_button']) ? $custom_fields['woo_after_add_to_cart_button'] : false;

			$section_before = THWEPOF_Utils_Section::prepare_default_section();
			$section_after = THWEPOF_Utils_Section::prepare_default_section();

			if(is_array($fields_before)){
				foreach($fields_before as $key => $field){
					$section_before = THWEPOF_Utils_Section::add_field($section_before, $field);
				}
			}

			if(is_array($fields_after)){
				foreach($fields_after as $key => $field){
					$section_after = THWEPOF_Utils_Section::add_field($section_after, $field);
				}
			}

			$result1 = $result2 = false;

			if(THWEPOF_Utils_Section::has_fields($section_after)){
				if(THWEPOF_Utils_Section::has_fields($section_before)){
					$section_before->set_property('id', 'default');
					$section_before->set_property('name', 'default');
					$section_before->set_property('title', 'Section 1');

					$section_after->set_property('id', 'section_2');
					$section_after->set_property('name', 'section_2');
					$section_after->set_property('title', 'Section 2');

					$result1 = THWEPOF_Utils::update_section($section_before);
				}else{
					$result1 = true;
				}
				$section_after->set_property('position', 'woo_after_add_to_cart_button');
				$result2 = THWEPOF_Utils::update_section($section_after);

			}else if(THWEPOF_Utils_Section::has_fields($section_before)){
				$result1 = THWEPOF_Utils::update_section($section_before);
				$result2 = true;
			}

			if($result1 && $result2){
				update_option('thwepof_custom_product_fields_bkp', $custom_fields);
				delete_option('thwepof_custom_product_fields');
			}
		}
	}
}
endif;
