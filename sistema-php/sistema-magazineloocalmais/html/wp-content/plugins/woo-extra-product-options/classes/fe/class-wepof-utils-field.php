<?php
/**
 * Woo Extra Product Options common functions
 *
 * @author    ThemeHiGH
 * @category  Admin
 */

if(!defined('ABSPATH')){ exit; }

if(!class_exists('THWEPOF_Utils_Field')) :
class THWEPOF_Utils_Field {
	static $OPTION_FIELD_TYPES = array("select", "radio", "checkboxgroup");

	public static function is_valid_field($field){
		if(isset($field) && $field instanceof WEPOF_Product_Field && self::is_valid($field)){
			return true;
		} 
		return false;
	}
	
	public static function is_enabled($field){
		if(self::is_valid_field($field) && $field->get_property('enabled')){
			return true;
		}
		return false;
	}
	
	public static function is_valid($field){
		if(empty($field->name) || empty($field->type)){
			return false;
		}
		return true;
	}

	public static function is_option_field($type){
		if($type){
			return in_array($type, self::$OPTION_FIELD_TYPES);
		}
		return false;
	}

	public static function create_field($type, $name = false, $field_args = false){
		$field = false;
		
		if(isset($type)){
			if($type === 'inputtext'){
				return new WEPOF_Product_Field_InputText();
			}else if($type === 'hidden'){
				return new WEPOF_Product_Field_Hidden();
			}else if($type === 'number'){
				return new WEPOF_Product_Field_Number();
			}else if($type === 'tel'){
				return new WEPOF_Product_Field_Tel();
			}else if($type === 'password'){
				return new WEPOF_Product_Field_Password();
			}else if($type === 'textarea'){
				return new WEPOF_Product_Field_Textarea();
			}else if($type === 'select'){
				return new WEPOF_Product_Field_Select();
			}else if($type === 'radio'){
				return new WEPOF_Product_Field_Radio();
			}else if($type === 'checkbox'){
				return new WEPOF_Product_Field_Checkbox();
			}else if($type === 'checkboxgroup'){
				return new WEPOF_Product_Field_CheckboxGroup();
			}else if($type === 'datepicker'){
				return new WEPOF_Product_Field_DatePicker();
			}else if($type === 'colorpicker'){
				return new WEPOF_Product_Field_ColorPicker();
			}else if($type === 'heading'){
				return new WEPOF_Product_Field_Heading();
			}else if($type === 'paragraph'){
				return new WEPOF_Product_Field_Paragraph();
			}
		}else{
			$field = new WEPOF_Product_Field_InputText();
		}
		return $field;
	}

	public static function prepare_properties($field){
		$field->set_property('id', $field->get_property('name'));
		$field->set_property('cssclass_str', THWEPOF_Utils::convert_cssclass_string($field->get_property('cssclass')));
		$field->set_property('title_class_str', THWEPOF_Utils::convert_cssclass_string($field->get_property('title_class')));

		$position = $field->get_property('position');
		$title_position = $field->get_property('title_position');
		
		if(empty($position)){
			$field->set_property('position', 'woo_before_add_to_cart_button');
		}

		if(empty($title_position)){
			$field->set_property('title_position', 'left');
		}
	}

	public static function prepare_field_from_posted_data($posted, $props){
		$type = isset($posted['i_type']) ? trim(stripslashes($posted['i_type'])) : '';
		//$type = empty($type) ? trim(stripslashes($posted['i_original_type'])) : $type;
			
		$field = self::create_field($type); 
		
		foreach( $props as $pname => $property ){
			$iname  = 'i_'.$pname;
			
			$pvalue = '';
			if($property['type'] === 'checkbox'){
				$pvalue = isset($posted[$iname]) ? $posted[$iname] : 0;
			}else if(isset($posted[$iname])){
				$pvalue = is_array($posted[$iname]) ? implode(',', $posted[$iname]) : trim(stripslashes($posted[$iname]));
			}
			
			$field->set_property($pname, $pvalue);
		}
		
		if($type === 'select' || $type === 'radio' || $type === 'checkboxgroup'){
			/*$options_json = isset($posted['i_options']) ? trim(stripslashes($posted['i_options'])) : '';
			$options_arr = self::prepare_options_array($options_json);
			
			$options_extra = apply_filters('thwepo_field_options', array(), $field->get_property('name'));
			if(is_array($options_extra) && !empty($options_extra)){
				$options_arr = array_merge($options_arr, $options_extra);
				$options_json = self::prepare_options_json($options_arr);
			}

			$field->set_property('options_json', $options_json);
			$field->set_property('options', $options_arr);*/
			$field->set_options_str(isset($posted['i_options']) ? trim(stripslashes($posted['i_options'])) : '');
		}
		
		$field->set_property('name_old', isset($posted['i_name_old']) ? trim(stripslashes($posted['i_name_old'])) : '');
		$field->set_property('position_old', isset($posted['i_position_old']) ? trim(stripslashes($posted['i_position_old'])) : '');

		$field->set_property('conditional_rules_json', isset($posted['i_rules']) ? trim(stripslashes($posted['i_rules'])) : '');
		$field->set_property('conditional_rules', THWEPOF_Utils::prepare_conditional_rules($posted));
		
		self::prepare_properties($field);
		return $field;
	}

	public static function is_show_field($field, $product, $categories, $tags=false){
		$show = true;
		$conditional_rules = $field->get_property('conditional_rules');
		
		if(!empty($conditional_rules)){
			foreach($conditional_rules as $conditional_rule){				
				if(!$conditional_rule->is_satisfied($product, $categories, $tags)){
					$show = false;
				}
			}
		}
		return $show;
	}

	public static function get_property_set_json($field, $field_props){
		if(self::is_valid_field($field)){
			$props_set = array();

			if($field->get_property('title_position') === 'default'){
				$field->set_property('title_position', 'left');
			}
			
			foreach( $field_props as $pname => $property ){
				$pvalue = $field->get_property($pname);
				$pvalue = is_array($pvalue) ? implode(',', $pvalue) : $pvalue;
				$pvalue = esc_attr($pvalue);
				
				if($property['type'] == 'checkbox'){
					$pvalue = $pvalue ? 1 : 0;
				}
				$props_set[$pname] = $pvalue;
			}
			
			$props_set['options'] = $field->get_options_str();
			$props_set['rules_action'] = $field->get_property('rules_action');
						
			//return json_encode($props_set);
			return json_encode($props_set, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		}else{
			return '';
		}
	}

	public static function prepare_field_html($field, $section){
		$field_html = '';
		$name = $field->get_property('name');
		$field_type = $field->get_property('type');

		$value = isset($_POST[$name]) ? $_POST[$name] : $field->get_property('value');
		if($value){
			$value = is_array($value) ? $value : trim(stripslashes($value));
		}
		
		if($field_type === 'inputtext'){
			$field_html = self::get_html_inputtext($name, $field, $section, $value);
			
		}if($field_type === 'hidden'){
			$field_html = self::get_html_hidden($name, $field, $section, $value);
			
		}else if($field_type === 'number'){
			$field_html = self::get_html_number($name, $field, $section, $value);
			
		}else if($field_type === 'tel'){
			$field_html = self::get_html_tel($name, $field, $section, $value);
			
		}else if($field_type === 'password'){
			$field_html = self::get_html_password($name, $field, $section, $value);
			
		}else if($field_type === 'textarea'){
			$field_html = self::get_html_textarea($name, $field, $section, $value);
			
		}else if($field_type === 'select'){
			$field_html = self::get_html_select($name, $field, $section, $value);
			
		}else if($field_type === 'checkbox'){
			$field_html = self::get_html_checkbox($name, $field, $section, $value);
			
		}else if($field_type === 'checkboxgroup'){
			$field_html = self::get_html_checkboxgroup($name, $field, $section, $value);
			
		}else if($field_type === 'radio'){
			$field_html = self::get_html_radio($name, $field, $section, $value);
			
		}else if($field_type === 'datepicker'){
			$field_html = self::get_html_datepicker($name, $field, $section, $value);
			
		}else if($field_type === 'colorpicker'){
			$field_html = self::get_html_colorpicker($name, $field, $section, $value);

		}else if($field_type === 'heading'){
			$field_html = self::get_html_heading($name, $field, $section, $value);

		}else if($field_type === 'paragraph'){
			$field_html = self::get_html_paragraph($name, $field, $section, $value);
		}
		
		return $field_html;
	}

	private static function prepare_field_html_input($field, $section, $input_html){
		$html = '';
		if($input_html){
			$field_type = $field->get_property('type');
			$title_position = $field->get_property('title_position');
			$wrapper_class  = THWEPOF_Utils::convert_cssclass_string($field->get_property('cssclass'));
			
			$title_cell_with = $section->get_property('title_cell_with');
			$field_cell_with = $section->get_property('field_cell_with');
			
			$title_cell_css = $title_cell_with ? 'width:'.$title_cell_with.';' : '';
			$field_cell_css = $field_cell_with ? 'width:'.$field_cell_with.';' : '';
			
			$title_cell_css = $title_cell_css ? 'style="'.$title_cell_css.'"' : '';
			$field_cell_css = $field_cell_css ? 'style="'.$field_cell_css.'"' : '';
			
			$title_html  = self::get_title_html($field);
			//$title_html .= self::get_required_html($field);
						
			if($field_type === 'hidden'){
				$html .= '<label class="'. $wrapper_class .'" >';
				$html .= $input_html;
				$html .= '</label>';

			}else{
				$html .= '<tr class="'. $wrapper_class .'" >';

				if($field_type === 'checkbox'){
					$html .= '<td class="value" colspan="2">'. $input_html .' '. $title_html .'</td>';

				}else if($field_type === 'heading' || $field_type === 'paragraph'){
					$html .= '<td colspan="2">'. $input_html .'</td>';

				}else{
					if($title_position === 'above'){
						$html .= '<td colspan="2" class="label abovefield">'. $title_html .'<br/>'. $input_html .'</td>';
					}else{
						$html .= '<td class="label leftside" '.$title_cell_css.'>'. $title_html .'</td>';
						$html .= '<td class="value leftside" '.$field_cell_css.'>'. $input_html .'</td>';
					}
				}

				$html .= '</tr>';
			}
		}	
		return $html;
	}

	public static function get_display_label($field){
		$label = !empty($field->title) ? $field->title : $field->placeholder;
		$label = !empty($label) ? $label : $field->name;
		return $label;
	}

	private static function get_required_html($field){
		$html = '';
		if($field->get_property('required')){
			$title_required = __('Required', 'woo-extra-product-options');
			$html = apply_filters( 'thwepof_required_html', ' <abbr class="required" title="'.$title_required.'">*</abbr>', $field->get_property('name') );
		}
		return $html;
	}
	
	private static function get_title_html($field, $skip_id = true){
		$title_html = '';
		if($field->get_property('title')){
			$title_class = THWEPOF_Utils::convert_cssclass_string($field->get_property('title_class'));
			$title_type  = $field->get_property('title_type') ? $field->get_property('title_type') : 'label';
			$title_style = $field->get_property('title_color') ? 'style="color:'.$field->get_property('title_color').';"' : '';
			
			$title_html .= '<'.$title_type.' class="label-tag '.$title_class.'" '.$title_style.'>';
			$title_html .= stripslashes(__($field->get_property('title'), 'woo-extra-product-options'));
			$title_html .= '</'.$title_type.'>';
		}
		
		$title_html .= self::get_required_html($field);
		return $title_html;
	}

	private static function prepare_field_props($field, $name, $value){
		$class = array();

		$type  = $field->get_property('type');
		$props = 'id="'.$name.'" name="'.$name.'"';

		$placeholder = $field->get_property('placeholder');
		if($placeholder){
			$props .= ' placeholder="'.$placeholder.'"';
		}

		if($type != 'textarea'){
			$props .= ' value="'.$value.'"';
		}

		if($type != 'heading' && $type != 'paragraph'){
			$class[] = 'thwepof-input-field';
		}

		if($type === 'datepicker'){
			$class[] = 'thwepof-date-picker';

		}else if($type === 'colorpicker'){
			$class[] = 'thwepof-colorpicker';
		}

		if($field->is_required()){
			$class[] = 'validate-required';
		}

		if(is_array($class) && !empty($class)){
			$props .= ' class="'.implode(" ", $class).'"';
		}

		return $props;
	}

	private static function get_html_inputtext($name, $field, $section, $value){
		$props = self::prepare_field_props($field, $name, $value);
		$input_html = '<input type="text" '.$props.' >';

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}

	private static function get_html_hidden($name, $field, $section, $value){
		$props = self::prepare_field_props($field, $name, $value);
		$input_html = '<input type="hidden" '.$props.' >';

		//$html = self::prepare_field_html_input($field, $section, $input_html);
		return $input_html;
	}

	private static function get_html_number($name, $field, $section, $value){
		$props = self::prepare_field_props($field, $name, $value);
		$input_html = '<input type="number" '.$props.' >';

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}

	private static function get_html_tel($name, $field, $section, $value){
		$props = self::prepare_field_props($field, $name, $value);
		$input_html = '<input type="tel" '.$props.' >';

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}

	private static function get_html_password($name, $field, $section, $value){
		$props = self::prepare_field_props($field, $name, $value);
		$input_html = '<input type="password" '.$props.' >';

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}

	private static function get_html_textarea($name, $field, $section, $value){
		$value = isset($_POST[$name]) ? $_POST[$name] : $field->get_property('value');

		$props  = self::prepare_field_props($field, $name, $value);
		$props .= is_numeric($field->get_property('cols')) ? ' cols="'.$field->get_property('cols').'"' : '';
		$props .= is_numeric($field->get_property('rows')) ? ' rows="'.$field->get_property('rows').'"' : '';

		$input_html = '<textarea '.$props.' >'.$value.'</textarea>';

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}
	
	private static function get_html_select($name, $field, $section, $value){
		$props = self::prepare_field_props($field, $name, $value);
		$placeholder = $field->get_property('placeholder');

		$input_html = '<select '.$props.' >';
		$input_html .= $placeholder ? '<option value="">'.$placeholder.'</option>' : '';
		foreach($field->get_property('options') as $option_key => $option_text){
			$selected = ($option_text === $value) ? 'selected' : '';
			$input_html .= '<option value="'.$option_text.'" '.$selected.'>'.$option_text.'</option>';
		}
		$input_html .= '</select>';

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}

	private static function get_html_checkbox($name, $field, $section, $value){
		$checked = $field->get_property('checked') ? 'checked' : '';
		$value = empty($value) ? '1' : $value;

		$props = self::prepare_field_props($field, $name, $value);		
		$input_html = '<input type="checkbox" '.$props.' '.$checked.'>';

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}

	private static function get_html_checkboxgroup($name, $field, $section, $value){
		$options = $field->get_property('options');
		$value = is_array($value) ? $value : explode(',', $value);
		$input_html = '';

		$cssclass = $field->get_property('cssclass');
		$cssclass = is_array($cssclass) ? $cssclass : explode(',', $cssclass);
		$is_valign = is_array($cssclass) && in_array("valign", $cssclass) ? true : false;

		foreach($options as $option_key => $option_text){
			$checked = '';
			if(is_array($value)){
				$checked = in_array($option_text, $value) ? 'checked' : '';
			}else{
				$checked = ($option_key === $value) ? 'checked' : '';
			}

			$option_id = esc_attr($name).'_'.esc_attr($option_key);
			$title_style = "display:inline; margin-right: 10px;";
			$title_class = $field->get_property('title_class_str');

			$field_props  = 'id="'.$option_id.'" name="'. esc_attr($name) .'[]" value="'.$option_text.'" '.$checked;
			
			$input_html .= '<label for="'. $option_id .'" style="'.$title_style.'" class="'. $title_class .'">';
			$input_html .= '<input type="checkbox" data-multiple="1" '. $field_props .' /> ';
			$input_html .= $option_text;
			$input_html .= '</label>';
			$input_html .= $is_valign ? '<br/>' : '';
		}
		
		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}

	private static function get_html_radio($name, $field, $section, $value){
		$input_html = '';

		$cssclass = $field->get_property('cssclass');
		$cssclass = is_array($cssclass) ? $cssclass : explode(',', $cssclass);
		$is_valign = is_array($cssclass) && in_array("valign", $cssclass) ? true : false;

		$i=0;
		foreach($field->get_property('options') as $option_key => $option_text){
			$id = $name.'_'.$option_key;
			$checked = ($option_text === $value) ? 'checked' : '';

			$style = '';
			if(!$is_valign && $i > 0){
				$style = 'margin-left:10px;';
			}

			$input_html .= '<label class="radio-wrapper" style="'.$style.'"><input type="radio" id="'.$id.'" name="'.$name.'" value="'.$option_text.'" '.$checked.'> '.$option_text.'</label>';
			$input_html .= $is_valign ? '<br/>' : '';
			$i++;
		}

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}

	private static function get_html_datepicker($name, $field, $section, $value){
		$props  = self::prepare_field_props($field, $name, $value);
		$props .= $field->is_readonly() ? ' data-readonly="yes"' : ' data-readonly="no"';
		$input_html = '<input type="text" autocomplete="off" '.$props.' >';

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}

	private static function get_html_colorpicker($name, $field, $section, $value){
		$props  = self::prepare_field_props($field, $name, $value);
		$input_html = '<input type="color" '.$props.' >';

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}

	private static function get_html_heading($name, $field, $section, $value){
		$elm_type = $field->get_property('title_type') ? $field->get_property('title_type') : 'h1';
		$props = self::prepare_field_props($field, $name, false);
		$input_html  = '<'.$elm_type.' '.$props.'>'.$value.'</'.$elm_type.'>';

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}

	private static function get_html_paragraph($name, $field, $section, $value){
		$elm_type = $field->get_property('title_type') ? $field->get_property('title_type') : 'p';
		$props = self::prepare_field_props($field, $name, false);
		$input_html  = '<'.$elm_type.' '.$props.'>'.$value.'</'.$elm_type.'>';

		$html = self::prepare_field_html_input($field, $section, $input_html);
		return $html;
	}
	
}
endif;