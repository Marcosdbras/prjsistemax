<?php

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WEPOF_Product_Options_Frontend')):
class WEPOF_Product_Options_Frontend {
	public $options_extra = array();

	public function __construct(){
		//add_action('after_setup_theme', array($this, 'define_public_hooks'));
		$this->define_public_hooks();
	}

	public function enqueue_scripts(){
		global $wp_scripts;
		$is_quick_view = THWEPOF_Utils::is_quick_view_plugin_active();
		if(is_product()|| ( $is_quick_view && (is_shop() || is_product_category()) )  || apply_filters('thwepof_enqueue_public_scripts', false)){
			$jquery_version = isset($wp_scripts->registered['jquery-ui-core']->ver) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.9.2';

			wp_enqueue_style('thwepof-frontend-style', THWEPOF_ASSETS_URL.'css/thwepof-field-editor-frontend.css', THWEPOF_VERSION);
			wp_enqueue_style('jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/'. $jquery_version .'/themes/smoothness/jquery-ui.css');

			wp_register_script('thwepof-public-script', THWEPOF_ASSETS_URL.'js/thwepof-public.js', array('jquery', 'jquery-ui-datepicker'), THWEPOF_VERSION, true);
			wp_enqueue_script('thwepof-public-script');

			$wepof_var = array(
				'is_quick_view' => $is_quick_view,
			);
			wp_localize_script('thwepof-public-script', 'thwepof_public_var', $wepof_var);
		}
	}

	public function define_public_hooks(){
		$hp_add_to_cart_link = apply_filters('thwepof_loop_add_to_cart_link_hook_priority', 10);
		$hp_display_before = apply_filters('thwepof_display_hook_priority_before_add_to_cart_button', 10);
		$hp_display_after = apply_filters('thwepof_display_hook_priority_after_add_to_cart_button', 10);
		$hp_validation = apply_filters('thwepof_add_to_cart_validation_hook_priority', 99);
		$hp_add_item_data = apply_filters('thwepo_add_cart_item_data_hook_priority', 10);

		$hn_before_single_product = apply_filters('thwepof_hook_name_before_single_product', 'woocommerce_before_single_product');
		$hn_before_add_to_cart_button = apply_filters('thwepof_hook_name_before_add_to_cart_button', 'woocommerce_before_add_to_cart_button');
		$hn_after_add_to_cart_button = apply_filters('thwepof_hook_name_after_add_to_cart_button', 'woocommerce_after_add_to_cart_button');

		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

		if(THWEPOF_Utils::woo_version_check('3.3')){
			add_filter('woocommerce_loop_add_to_cart_link', array($this, 'woo_loop_add_to_cart_link'), $hp_add_to_cart_link, 3);
		}else{
			add_filter('woocommerce_loop_add_to_cart_link', array($this, 'woo_loop_add_to_cart_link'), $hp_add_to_cart_link, 2);
		}
		add_filter('woocommerce_loop_add_to_cart_args', array($this, 'woo_loop_add_to_cart_args'), $hp_add_to_cart_link, 2);
		add_filter('woocommerce_product_add_to_cart_url', array($this, 'woo_product_add_to_cart_url'), $hp_add_to_cart_link, 2);
		add_filter('woocommerce_product_add_to_cart_text', array($this, 'woo_product_add_to_cart_text'), $hp_add_to_cart_link, 2);

		add_action($hn_before_single_product, array($this, 'woo_before_single_product'));
		add_action($hn_before_add_to_cart_button, array($this, 'woo_before_add_to_cart_button'), $hp_display_before);
		add_action($hn_after_add_to_cart_button, array($this, 'woo_after_add_to_cart_button'), $hp_display_after);

		add_filter('woocommerce_add_to_cart_validation', array($this, 'woo_add_to_cart_validation'), $hp_validation, 6 );
		add_filter('woocommerce_add_cart_item_data', array($this, 'woo_add_cart_item_data'), $hp_add_item_data, 3 );
		add_filter('woocommerce_get_item_data', array($this, 'woo_get_item_data'), 10, 2 );

		if(THWEPOF_Utils::woo_version_check()){
			add_action('woocommerce_new_order_item', array($this, 'woo_new_order_item'), 10, 3);
		}else{
			add_action('woocommerce_add_order_item_meta', array($this, 'woo_add_order_item_meta'), 1, 3);
		}

		add_filter('woocommerce_order_item_get_formatted_meta_data', array($this, 'woo_order_item_get_formatted_meta_data'), 10, 2);

		add_filter('woocommerce_order_again_cart_item_data', array($this, 'woo_order_again_cart_item_data'), 10, 3);

		$hns_before_single_product = apply_filters('thwepof_hook_names_before_single_product', array());

		if(THWEPOF_Utils::is_yith_quick_view_enabled()){
			array_push($hns_before_single_product, "yith_wcqv_product_summary");
		}
		if(THWEPOF_Utils::is_flatsome_quick_view_enabled()){
			array_push($hns_before_single_product, "woocommerce_single_product_lightbox_summary");
		}
		if(THWEPOF_Utils::is_astra_quick_view_enabled()){
			array_push($hns_before_single_product, "astra_woo_quick_view_product_summary");
		}

		if(is_array($hns_before_single_product)){
			foreach($hns_before_single_product as $hook_name){
				add_action($hook_name, array($this, 'woo_before_single_product'));
			}
		}
	}

   /***************************************************
	**** PREPARE CUSTOM SECTIONS & OPTIONS - START ****
	***************************************************/
	public function woo_loop_add_to_cart_args($args, $product){
		if($this->is_modify_product_add_to_cart_link($product)){
			if(THWEPOF_Utils::woo_version_check('3.3')){
				if(isset($args['class'])){
					$args['class'] = str_replace("ajax_add_to_cart", "", $args['class']);
				}
			}
		}
		return $args;
	}
	public function woo_product_add_to_cart_url($url, $product){
		if($this->is_modify_product_add_to_cart_link($product)){
			$url = $product->get_permalink();
		}
		return $url;
	}
	public function woo_product_add_to_cart_text($text, $product){
		$modify = apply_filters('thwepof_modify_loop_add_to_cart_text', true);
		$product_type = THWEPOF_Utils::get_product_type($product);

		if($modify && THWEPOF_Utils_Section::has_extra_options($product)){
			$text_override = THWEPOF_Utils::get_settings('add_to_cart_text_addon');
			$text = !empty($text_override) ? esc_html(THWEPOF_Utils::t($text_override)) : __( 'Select options', 'woocommerce' );
		}else{
			if($product->is_in_stock() && ($product_type === 'simple' || $product_type === 'bundle')){
				$text_override = THWEPOF_Utils::get_settings('add_to_cart_text_simple');
				$text = !empty($text_override) ? esc_html(THWEPOF_Utils::t($text_override)) : $text;

			}else if($product->is_purchasable() && $product_type === 'variable'){
				$text_override = THWEPOF_Utils::get_settings('add_to_cart_text_variable');
				$text = !empty($text_override) ? esc_html(THWEPOF_Utils::t($text_override)) : $text;
			}
		}

		$text = apply_filters('thwepof_loop_add_to_cart_link_text', $text);
		return $text;

		/*if($this->is_modify_product_add_to_cart_link($product)){
			$text = apply_filters('thwepof_loop_add_to_cart_link_text', THWEPOF_Utils::get_settings('add_to_cart_link_text'));
			$text = $text ? esc_html(THWEPOF_Utils::t($text)) : __( 'Select options', 'woocommerce' );
		}
		return $text;*/
	}

	public function is_modify_product_add_to_cart_link($product){
		$modify = apply_filters('thwepof_modify_loop_add_to_cart_link', true);
		$product_type = THWEPOF_Utils::get_product_type($product);

		if($modify && THWEPOF_Utils_Section::has_extra_options($product) && $product->is_in_stock() && ($product_type === 'simple' || $product_type === 'bundle')){
			return true;
		}
		return false;
	}

	public function woo_loop_add_to_cart_link($link, $product, $args=false){
		if($this->is_modify_product_add_to_cart_link($product)){
			$class = '';
			if($args && isset($args['class'])){
				$args['class'] = str_replace("ajax_add_to_cart", "", $args['class']);
				$class = $args['class'];
				$class = $class ? $class : 'button';
			}

			if(THWEPOF_Utils::is_active_theme('flatsome')){
				$product_type = THWEPOF_Utils::get_product_type($product);

				$flatsome_classes = array(
					'add_to_cart_button',
					'product_type_'.$product_type,
					'button',
					'primary',
					'mb-0',
					'is-'.get_theme_mod( 'add_to_cart_style', 'outline' ),
					'is-small'
				);

				$class  = str_replace($flatsome_classes, "", $class);
				$class .= ' '.implode(" ", $flatsome_classes);

				$args['class'] = $class;
			}

			if(THWEPOF_Utils::woo_version_check('3.3')){
				$link = sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
					esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
					isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
					esc_html( $product->add_to_cart_text() )
				);
			}else{
				$product_id = false;
				$product_sku = false;
	    		if(THWEPOF_Utils::woo_version_check()){
	    			$product_id = $product->get_id();
	    			$product_sku = $product->get_sku();
	    		}else{
	    			$product_id = $product->id;
	    			$product_sku = $product->sku;
	    		}

				$link = sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( isset( $quantity ) ? $quantity : 1 ),
					esc_attr( $product_id ),
					esc_attr( $product_sku ),
					esc_attr( isset( $class ) ? $class : 'button' ),
					esc_html( $product->add_to_cart_text() )
				);
			}
		}
		return $link;
	}

	/*public function woo_loop_add_to_cart_link($link, $product, $args = array()){
		$modify = apply_filters('thwepof_modify_loop_add_to_cart_link', true);
		$product_type = THWEPOF_Utils::get_product_type($product);
		$has_extra_options = THWEPOF_Utils_Section::has_extra_options($product);

		if($modify && $has_extra_options && $product->is_in_stock() && ($product_type === 'simple' || $product_type === 'bundle')){
			$link_text = apply_filters('thwepof_loop_add_to_cart_link_text', 'Select options');

			$product_id = false;
			$product_sku = false;
    		if(THWEPOF_Utils::woo_version_check()){
    			$product_id = $product->get_id();
    			$product_sku = $product->get_sku();
    		}else{
    			$product_id = $product->id;
    			$product_sku = $product->sku;
    		}

			if(THWEPOF_Utils::woo_version_check('3.3')){
				if(isset($args['class'])){
					$args['class'] = str_replace("ajax_add_to_cart", "", $args['class']);
				}

				$link = sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
					esc_url( $product->get_permalink() ),
					esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
					esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
					isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
					esc_html( THWEPOF_Utils::t($link_text) )
				);
			}else{
				$link = sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
					esc_url( $product->get_permalink() ),
					esc_attr( isset( $quantity ) ? $quantity : 1 ),
					esc_attr( $product_id ),
					esc_attr( $product_sku ),
					esc_attr( isset( $class ) ? $class : 'button' ),
					esc_html( THWEPOF_Utils::t($link_text) )
				);
			}
		}
		return $link;
	}*/

	public function woo_before_single_product(){
		global $product;

		$product_id = THWEPOF_Utils::get_product_id($product);
		$categories = THWEPOF_Utils::get_product_categories($product_id);
		$tags       = THWEPOF_Utils::get_product_tags($product_id);
		$sections   = THWEPOF_Utils::get_sections();
		$section_hook_map = array();

		if($sections && is_array($sections) && !empty($sections)){
			foreach($sections as $section_name => $section){
				$section = THWEPOF_Utils_Section::prepare_section_and_fields($section, $product_id, $categories, $tags);

				if($section){
					$hook_name = $section->get_property('position');
					if(array_key_exists($hook_name, $section_hook_map) && is_array($section_hook_map[$hook_name])) {
						$section_hook_map[$hook_name][$section_name] = $section;
					}else{
						$section_hook_map[$hook_name] = array();
						$section_hook_map[$hook_name][$section_name] = $section;
					}
				}
			}
		}

		$this->options_extra = $section_hook_map;
	}
   /***************************************************
	**** PREPARE CUSTOM SECTIONS & OPTIONS - END ******
	***************************************************/

   /***********************************************
	**** DISPLAY CUSTOM PRODUCT FIELDS - START ****
	***********************************************/
	/*private function render_sections($hook_name){
		$fields = $this->get_fields_by_hook($this->options_extra, $hook_name);
		if($fields){
			foreach($fields as $name => $field){
				THWEPOF_Utils_Field::render_field($field);
			}
		}
	}*/
	private function render_sections($hook_name){
		global $product;
		$sections = THWEPOF_Utils::get_sections_by_hook($hook_name, $this->options_extra);

		if($sections){
			foreach($sections as $section_name => $section){
				$section_html = THWEPOF_Utils_Section::prepare_section_html($section, $product);
				echo $section_html;
			}
		}
	}

	private function render_product_field_names_hidden_field(){
		global $product;
		$prod_field_names = THWEPOF_Utils_Section::get_product_fields($product, true);
		$prod_field_names = is_array($prod_field_names) ? implode(",", $prod_field_names) : '';
		echo '<input type="hidden" id="thwepof_product_fields" name="thwepof_product_fields" value="'.$prod_field_names.'"/>';
	}

	public function woo_before_add_to_cart_button(){
		$this->render_product_field_names_hidden_field();
		$this->render_sections('woo_before_add_to_cart_button');
	}

	public function woo_after_add_to_cart_button(){
		$this->render_sections('woo_after_add_to_cart_button');
	}
   /***********************************************
	**** DISPLAY CUSTOM PRODUCT FIELDS - END ******
	***********************************************/


   /***************************************************
	**** CUSTOM PRODUCT OPTIONS VALIDATION - START ****
	***************************************************/
	private function prepare_product_options($names_only = true){
		$final_fields = array();
		$product_fields = '';
		$allow_get_method = THWEPOF_Utils::get_settings('allow_get_method');
		//$product_fields = isset( $_POST['thwepof_product_fields'] ) ? wc_clean( $_POST['thwepof_product_fields'] ) : '';

		if($allow_get_method){
			$product_fields = isset($_REQUEST['thwepof_product_fields']) ? wc_clean($_REQUEST['thwepof_product_fields']) : '';
		}else{
			$product_fields = isset($_POST['thwepof_product_fields']) ? wc_clean($_POST['thwepof_product_fields']) : '';
		}

		$prod_fields = $product_fields ? explode(",", $product_fields) : array();

		if($names_only){
			$final_fields = $prod_fields;
		}else{
			$extra_options = THWEPOF_Utils::get_product_fields_full();
			foreach($prod_fields as $name) {
				if(isset($extra_options[$name])){
					$final_fields[$name] = $extra_options[$name];
				}
			}
		}
		return $final_fields;
	}

	public function get_posted_value($name, $type = false){
		$is_posted = isset($_POST[$name]) || isset($_REQUEST[$name]) ? true : false;
		$value = false;

		if($is_posted){
			$value = isset($_POST[$name]) && $_POST[$name] ? $_POST[$name] : false;
			$value = empty($value) && isset($_REQUEST[$name]) ? $_REQUEST[$name] : $value;
		}
		return $value;
	}

	/*public function woo_add_to_cart_validation($passed, $product_id, $quantity, $variation_id=false, $variations=false, $cart_item_data=false) {
		$extra_options = $this->prepare_product_options(false);
		if($extra_options){
			foreach($extra_options as $field_name => $field){
				$value  = $this->get_posted_value($field_name);
				$passed = $this->validate_field($passed, $field, $value);
			}
		}
		return $passed;
	}*/

	public function woo_add_to_cart_validation($passed, $product_id, $quantity, $variation_id=false, $variations=false, $cart_item_data=false){
		$extra_options = $this->prepare_product_options(false);
		$ignore_unposted = apply_filters( 'thwepof_ignore_unposted_fields', false );

		if($extra_options){
			foreach($extra_options as $field_name => $field){
				$type = $field->get_property('type');
				$is_posted = isset($_POST[$field_name]) || isset($_REQUEST[$field_name]) ? true : false;
				$posted_value = $this->get_posted_value($field_name, $type);

				$passed = $this->validate_field($passed, $field, $posted_value);

				/*if(($type === 'radio' || $type === 'checkboxgroup') && (!$is_posted || !$posted_value) && !$ignore_unposted){
					$passed = $this->validate_field($passed, $field, $posted_value);

				}else if($is_posted){
					$passed = $this->validate_field($passed, $field, $posted_value);
				}*/
			}
		}
		return $passed;
	}

	private function validate_field($valid, $field, $value){
		$field_label = $field->get_property('title');

		if($field->is_required() && empty($value)) {
			//THWEPOF_Utils::wcpf_add_error(sprintf(THWEPOF_Utils::t( 'Please enter a value for %s'), '<strong>'.esc_html($field_label).'</strong>'));

			THWEPOF_Utils::wcpf_add_error(apply_filters('thwepof_required_field_notice', sprintf(THWEPOF_Utils::t('%s is a required field.'), '<strong>'.esc_html($field_label).'</strong>')));
			$valid = false;
		}else{
			$validators = $field->get_property('validator');
			$validators = !empty($validators) ? explode("|", $validators) : false;

			if($validators && !empty($value)){
				foreach($validators as $validator){
					switch($validator) {
						case 'number' :
							if(!is_numeric($value)){
								THWEPOF_Utils::wcpf_add_error('<strong>'.wc_clean($field_label).'</strong> '. sprintf(THWEPOF_Utils::t('%s is not a valid number.'), $value));
								$valid = false;
							}
							break;

						case 'email' :
							if(!is_email($value)){
								THWEPOF_Utils::wcpf_add_error('<strong>'.wc_clean($field_label).'</strong> '. sprintf(THWEPOF_Utils::t('%s is not a valid email address.'), $value));
								$valid = false;
							}
							break;
					}
				}
			}
		}
		return $valid;
	}
	/************************************************
	**** CUSTOM PRODUCT OPTIONS VALIDATION - END ****
	*************************************************/


   /*********************************************************
	**** ADD CUSTOM OPTIONS & PRICE to CART ITEM - START ****
	*********************************************************/
	private function prepare_extra_cart_item_data(){
		$extra_data = array();
		$extra_options = $this->prepare_product_options(false);

		if($extra_options && is_array($extra_options)){
			foreach($extra_options as $name => $field){
				$posted_value = $this->get_posted_value($name);
				if($posted_value) {
					if(is_array($posted_value)){
						$posted_value = implode(',', $posted_value);
					}

					$data_arr = array();
					$data_arr['name']  	 = $name;
					$data_arr['value'] 	 = $posted_value;
					$data_arr['type']    = $field->get_property('type');
					$data_arr['label']   = $field->get_property('title');
					$data_arr['options'] = $field->get_property('options');

					$extra_data[$name] = $data_arr;
				}
			}
		}
		return $extra_data;
	}

	// Load cart item data - may be added by other plugins.
	public function woo_add_cart_item_data($cart_item_data, $product_id = 0, $variation_id = 0) {
		$skip = (isset($cart_item_data['bundled_by']) && apply_filters('thwepof_skip_extra_options_for_bundled_items', true)) ? true : false;
		$skip = apply_filters('thwepof_skip_extra_options_for_cart_item', $skip, $cart_item_data, $product_id, $variation_id);

		if(!$skip){
			$extra_cart_item_data = $this->prepare_extra_cart_item_data();

			if($extra_cart_item_data){
				if(apply_filters('thwepof_set_unique_key_for_cart_item', false, $cart_item_data, $product_id, $variation_id)){
					$cart_item_data['unique_key'] = md5( microtime().rand() );
				}
				$cart_item_data['thwepof_options'] = $extra_cart_item_data;
			}
		}
		return $cart_item_data;
	}

	// Filter item data to allow 3rd parties to add more to the array.
	public function woo_get_item_data($item_data, $cart_item = null) {
		$show_fields = true;		

		if(is_checkout()){
			$hide_in_checkout = THWEPOF_Utils::get_settings('hide_in_checkout');
			$show_fields = $hide_in_checkout === 'yes' ? false : true;
			$show_fields = apply_filters('thwepof_display_custom_checkout_item_meta', $show_fields);

		}else if(is_cart()){
			$hide_in_cart = THWEPOF_Utils::get_settings('hide_in_cart');
			$show_fields = $hide_in_cart === 'yes' ? false : true;
			$show_fields = apply_filters('thwepof_display_custom_cart_item_meta', $show_fields);

		}else{ //To handle mini cart view. This is same as cart page behaviour.
			$hide_in_cart = THWEPOF_Utils::get_settings('hide_in_cart');
			$show_fields = $hide_in_cart === 'yes' ? false : true;
			$show_fields = apply_filters('thwepof_display_custom_cart_item_meta', $show_fields);
		}

		if($show_fields){
			$item_data = is_array($item_data) ? $item_data : array();
			$extra_options = $cart_item && isset($cart_item['thwepof_options']) ? $cart_item['thwepof_options'] : false;
			$display_option_text = apply_filters('thwepof_order_item_meta_display_option_text', true);

			if($extra_options){
				foreach($extra_options as $name => $data){
					if(isset($data['value']) && isset($data['label'])) {
						$value = isset($data['value']) ? $data['value'] : '';
						$value = is_array($value) ? implode(",", $value) : trim(stripslashes($value));
						//$value = $display_option_text ? THWEPOF_Utils::get_option_display_value($name, $value, $data) : $value;
						$item_data[] = array("name" => $data['label'], "value" => $value);
					}
				}
			}
		}
		return $item_data;
	}

	public function woo_new_order_item($item_id, $item, $order_id){
		$legacy_values = is_object($item) && isset($item->legacy_values) ? $item->legacy_values : false;
		if($legacy_values){
			$extra_options = isset($legacy_values['thwepof_options']) ? $legacy_values['thwepof_options'] : false;
			if($extra_options){
				foreach($extra_options as $name => $data){
					$value = isset($data['value']) ? $data['value'] : '';
					$value = is_array($value) ? implode(",", $value) : trim(stripslashes($value));

					wc_add_order_item_meta( $item_id, $name, $value );
				}
			}
		}
	}

	public function woo_add_order_item_meta($item_id, $values, $cart_item_key) {
		if(is_array($values)){
			$extra_options = isset($values['thwepof_options']) ? $values['thwepof_options'] : false;
			if($extra_options){
				foreach($extra_options as $name => $data){
					$value = isset($data['value']) ? $data['value'] : '';
					$value = is_array($value) ? implode(",", $value) : trim(stripslashes($value));

					wc_add_order_item_meta( $item_id, $name, $value );
				}
			}
		}
	}

	public function woo_order_items_meta_get_formatted( $formatted_meta, $item_meta ) {
		if(is_array($formatted_meta) && !empty($formatted_meta)){
			$options_extra = THWEPOF_Utils::get_product_fields_full();
			if(is_array($options_extra)){
				foreach($formatted_meta as &$meta){
					$meta_key = isset($meta['key']) ? $meta['key'] : false;
					if($meta_key && array_key_exists($meta_key, $options_extra)) {
						$meta['label'] = $options_extra[$meta_key]->get_property('title');
					}
				}
			}
		}
		return $formatted_meta;
	}

	public function woo_order_item_get_formatted_meta_data( $formatted_meta, $order_item){
		$hide_in_order = THWEPOF_Utils::get_settings('hide_in_order');
		$show_in_order = $hide_in_order === 'yes' ? false : true;
		$show_in_order = apply_filters('thwepof_show_order_item_custom_meta', $show_in_order);

		if(is_array($formatted_meta) && !empty($formatted_meta)){
			$options_extra = THWEPOF_Utils::get_product_fields_full();
			if(is_array($options_extra)){
				foreach($formatted_meta as $key => $meta){
					if(array_key_exists($meta->key, $options_extra)) {
						if($show_in_order){
							$formatted_meta[$key] = (object) array(
								'key'           => $meta->key,
								'value'         => $meta->value,
								'display_key'   => apply_filters( 'thwepof_order_item_display_meta_key', $options_extra[$meta->key]->get_property('title'), $meta, $order_item ),
								'display_value' => wpautop( make_clickable( apply_filters( 'thwepof_order_item_display_meta_value', $meta->value, $meta, $order_item ) ) ),
							);
						}else{
							unset($formatted_meta[$key]);
						}
					}
				}
			}
		}
		return $formatted_meta;
	}

   /*********************************************************
	**** ADD CUSTOM OPTIONS & PRICE to CART ITEM - END ******
	*********************************************************/


   /************************************
	**** ORDER AGAIN DATA - START ******
	************************************/
   	public function woo_order_again_cart_item_data($cart_item_data, $item, $order){
		$extra_cart_item_data = $this->prepare_order_again_extra_cart_item_data($item, $order);

		if($extra_cart_item_data){
			$cart_item_data['thwepof_options'] = $extra_cart_item_data;
		}
		return $cart_item_data;
	}

	private function prepare_order_again_extra_cart_item_data($item, $order){
		$extra_data = array();

		if($item){
			$meta_data = $item->get_meta_data();
			if(is_array($meta_data)){
				$options_extra = THWEPOF_Utils::get_product_fields_full();

				foreach($meta_data as $key => $meta){
					if(array_key_exists($meta->key, $options_extra)) {
						$field = $options_extra[$meta->key];

						$data_arr = array();
						$data_arr['name']  	 = $meta->key;
						$data_arr['value'] 	 = $meta->value;
						$data_arr['type']    = $field->get_property('type');
						$data_arr['label']   = $field->get_property('title');
						$data_arr['options'] = $field->get_property('options');

						$extra_data[$meta->key] = $data_arr;
					}
				}
			}
		}

		return $extra_data;
	}
   /************************************
	**** ORDER AGAIN DATA - END ********
	************************************/
}
endif;
