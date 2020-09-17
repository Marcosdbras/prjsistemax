<?php
/**
 * Woo Extra Product Options Setting Page
 *
 * @author   ThemeHiGH
 * @category Admin
 */

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WEPOF_Settings_Page')) :
abstract class WEPOF_Settings_Page{
	protected $page_id = '';
	protected $section_id = '';
	protected $tabs = '';

	protected $cell_props_L = array();
	protected $cell_props_R = array();
	protected $cell_props_CB = array();
	protected $cell_props_CBS = array();
	protected $cell_props_CBL = array();
	protected $cell_props_CP = array();

	public function __construct($page, $section = '') {
		$this->page_id = $page;
		if($section){
			$this->section_id = $section;
		}else{
			$this->set_first_section_as_current();
		}
		$this->tabs = array( 
			'general_settings' => __('Product Options', 'woo-extra-product-options'),
			'advanced_settings' => __('Advanced Settings', 'woo-extra-product-options')
		);

		$this->init_constants();
	}

	public function get_tabs(){
		return $this->tabs;
	}
	
	public function get_current_tab(){
		return $this->page_id;
	}

	public function get_current_section(){
		return isset( $_GET['section'] ) ? esc_attr( $_GET['section'] ) : $this->section_id;
	}
	
	public function set_current_section($section_id){
		if($section_id){
			$this->section_id = $section_id;
		}
	}

	public function set_first_section_as_current(){
		$sections = THWEPOF_Utils::get_sections_admin();
		if($sections && is_array($sections)){
			$array_keys = array_keys( $sections );
			if($array_keys && is_array($array_keys) && isset($array_keys[0])){
				$this->set_current_section($array_keys[0]);
			}
		}
	}
		
	public function render_tabs(){
		$current_tab = $this->get_current_tab();
		$tabs = $this->get_tabs();

		if(empty($tabs)){
			return;
		}

		$this->output_premium_version_notice();
		$this->output_review_request_link();
		
		echo '<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">';
		foreach( $tabs as $id => $label ){
			$active = ($current_tab == $id) ? 'nav-tab-active' : '';
			$label  = __($label, 'woo-extra-product-options');
			$url    = $this->get_admin_url($id);

			echo '<a class="nav-tab '.$active.'" href="'.$url.'">'.$label.'</a>';
		}
		echo '</h2>';	
	}	
	
	public function output_premium_version_notice(){
		?>
        <div id="message" class="wc-connect updated thwcfd-notice">
            <div class="squeezer">
            	<table>
                	<tr>
                    	<td width="70%">
                        	<p><strong><i>WooCommerce Extra Product Options Pro</i></strong> premium version provides more features to customise product page.</p>
                            <ul>
                            	<li>16 field types available,<br/>(<i>Text, Hidden, Password, Number, Telephone, Textarea, Radio, Checkbox, Checkbox Group, Select, Multi-select, Date Picker, Time Picker, File Upload Heading, Label</i>).</li>
                                <li>Option to add price fields.</li>
                                <li>Option to display fields based on different rules.</li>
                                <li>Option to set RegEx based custom validations.</li>
                                <li>Option to add custom fields in different sections and positions.</li>
                            </ul>
                        </td>
                        <td>
                        	<a target="_blank" href="https://www.themehigh.com/product/woocommerce-extra-product-options/" class="">
                            	<img src="<?php echo THWEPOF_ASSETS_URL.'css/upgrade-btn.png'; ?>" />
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
	}

	private function output_review_request_link(){
		?>
		<p>If you like our <strong>Extra Product Options</strong> plugin please leave us a <a href="https://wordpress.org/support/plugin/woo-extra-product-options/reviews?rate=5#new-post" target="_blank" aria-label="five star" data-rated="Thanks :)">★★★★★</a> rating. A huge thanks in advance!</p>
		<?php 
	}

	public function get_admin_url($tab = false, $section = false){
		$url = 'edit.php?post_type=product&page=thwepof_extra_product_options';
		if($tab && !empty($tab)){
			$url .= '&tab='. $tab;
		}
		if($section && !empty($section)){
			$url .= '&section='. $section;
		}
		return admin_url($url);
	}

   /*--------------------------------------------
	*------ SECTION FORM FRAGMENTS - START ------
	*--------------------------------------------*/
	public function init_constants(){
		$this->cell_props_L = array( 
			'label_cell_props' => 'width="13%"', 
			'input_cell_props' => 'width="34%"', 
			'input_width' => '250px',  
		);
		
		$this->cell_props_R = array( 
			'label_cell_props' => 'width="14%"', 
			'input_cell_props' => 'width="33%"', 
			'input_width' => '250px', 
		);
		
		$this->cell_props_CB = array( 
			'label_props' => 'style="margin-right: 40px;"', 
		);
		$this->cell_props_CBS = array( 
			'label_props' => 'style="margin-right: 15px;"', 
		);
		$this->cell_props_CBL = array( 
			'label_props' => 'style="margin-right: 52px;"', 
		);
		
		$this->cell_props_CP = array(
			'label_cell_props' => 'width="13%"', 
			'input_cell_props' => 'width="34%"', 
			'input_width' => '218px',
		);
	} 

	public function render_form_field_element($field, $atts = array(), $render_cell = true){
		if($field && is_array($field)){
			$args = shortcode_atts( array(
				'label_cell_props' => '',
				'input_cell_props' => '',
				'label_cell_colspan' => '',
				'input_cell_colspan' => '',
			), $atts );
		
			$ftype     = isset($field['type']) ? $field['type'] : 'text';
			$flabel    = isset($field['label']) && !empty($field['label']) ? __($field['label'], 'woo-extra-product-options') : '';
			$sub_label = isset($field['sub_label']) && !empty($field['sub_label']) ? __($field['sub_label'], 'woo-extra-product-options') : '';
			$tooltip   = isset($field['hint_text']) && !empty($field['hint_text']) ? __($field['hint_text'], 'woo-extra-product-options') : '';
			
			$field_html = '';
			
			if($ftype == 'text'){
				$field_html = $this->render_form_field_element_inputtext($field, $atts);
				
			}else if($ftype == 'textarea'){
				$field_html = $this->render_form_field_element_textarea($field, $atts);
				   
			}else if($ftype == 'select'){
				$field_html = $this->render_form_field_element_select($field, $atts);     
				
			}else if($ftype == 'multiselect'){
				$field_html = $this->render_form_field_element_multiselect($field, $atts);     
				
			}else if($ftype == 'colorpicker'){
				$field_html = $this->render_form_field_element_colorpicker($field, $atts);              
            
			}else if($ftype == 'checkbox'){
				$field_html = $this->render_form_field_element_checkbox($field, $atts, $render_cell);   
				$flabel 	= '&nbsp;';  
			}
			
			if($render_cell){
				$required_html = isset($field['required']) && $field['required'] ? '<abbr class="required" title="required">*</abbr>' : '';
				
				$label_cell_props = !empty($args['label_cell_props']) ? $args['label_cell_props'] : '';
				$input_cell_props = !empty($args['input_cell_props']) ? $args['input_cell_props'] : '';
				
				?>
				<td <?php echo $label_cell_props ?> >
					<?php echo $flabel; echo $required_html; 
					if($sub_label){
						?>
						<br/><span class="thpladmin-subtitle"><?php echo $sub_label; ?></span>
						<?php
					}
					?>
				</td>
				<?php $this->render_form_fragment_tooltip($tooltip); ?>
				<td <?php echo $input_cell_props ?> ><?php echo $field_html; ?></td>
				<?php
			}else{
				echo $field_html;
			}
		}
	}

	private function prepare_form_field_props($field, $atts = array()){
		$field_props = '';
		$args = shortcode_atts( array(
			'input_width' => '',
			'input_name_prefix' => 'i_',
			'input_name_suffix' => '',
		), $atts );
		
		$ftype = isset($field['type']) ? $field['type'] : 'text';
		
		if($ftype == 'multiselect'){
			$args['input_name_suffix'] = $args['input_name_suffix'].'[]';
		}
		
		$fname  = $args['input_name_prefix'].$field['name'].$args['input_name_suffix'];
		$fvalue = isset($field['value']) ? esc_html($field['value']) : '';
		
		$input_width  = $args['input_width'] ? 'width:'.$args['input_width'].';' : '';
		$field_props  = 'name="'. $fname .'" value="'. $fvalue .'" style="'. $input_width .'"';
		$field_props .= ( isset($field['placeholder']) && !empty($field['placeholder']) ) ? ' placeholder="'.$field['placeholder'].'"' : '';
		$field_props .= ( isset($field['onchange']) && !empty($field['onchange']) ) ? ' onchange="'.$field['onchange'].'"' : '';
		
		return $field_props;
	}
	
	private function render_form_field_element_inputtext($field, $atts = array()){
		$field_html = '';
		if($field && is_array($field)){
			$field_props = $this->prepare_form_field_props($field, $atts);
			$field_html = '<input type="text" '. $field_props .' />';
		}
		return $field_html;
	}
	
	private function render_form_field_element_textarea($field, $atts = array()){
		$field_html = '';
		if($field && is_array($field)){
			$args = shortcode_atts( array(
				'rows' => '5',
				'cols' => '100',
			), $atts );
		
			$fvalue = isset($field['value']) ? $field['value'] : '';
			$field_props = $this->prepare_form_field_props($field, $atts);
			$field_html = '<textarea '. $field_props .' rows="'.$args['rows'].'" cols="'.$args['cols'].'" >'.$fvalue.'</textarea>';
		}
		return $field_html;
	}
	
	private function render_form_field_element_select($field, $atts = array()){
		$field_html = '';
		if($field && is_array($field)){
			$fvalue = isset($field['value']) ? $field['value'] : '';
			$field_props = $this->prepare_form_field_props($field, $atts);
			
			$field_html = '<select '. $field_props .' >';
			foreach($field['options'] as $value => $label){
				$selected = $value === $fvalue ? 'selected' : '';
				$field_html .= '<option value="'. trim($value) .'" '.$selected.'>'. __($label, 'woo-extra-product-options') .'</option>';
			}
			$field_html .= '</select>';
		}
		return $field_html;
	}
	
	private function render_form_field_element_multiselect($field, $atts = array()){
		$field_html = '';
		if($field && is_array($field)){
			$field_props = $this->prepare_form_field_props($field, $atts);
			
			$field_html = '<select multiple="multiple" '. $field_props .' class="thwepo-enhanced-multi-select" >';
			foreach($field['options'] as $value => $label){
				//$selected = $value === $fvalue ? 'selected' : '';
				$field_html .= '<option value="'. trim($value) .'" >'. __($label, 'woo-extra-product-options') .'</option>';
			}
			$field_html .= '</select>';
		}
		return $field_html;
	}
	
	private function render_form_field_element_radio($field, $atts = array()){
		$field_html = '';
		/*if($field && is_array($field)){
			$field_props = $this->prepare_form_field_props($field, $atts);
			
			$field_html = '<select '. $field_props .' >';
			foreach($field['options'] as $value => $label){
				$selected = $value === $fvalue ? 'selected' : '';
				$field_html .= '<option value="'. trim($value) .'" '.$selected.'>'. THWEPO_i18n::__t($label) .'</option>';
			}
			$field_html .= '</select>';
		}*/
		return $field_html;
	}
	
	private function render_form_field_element_checkbox($field, $atts = array(), $render_cell = true){
		$field_html = '';
		if($field && is_array($field)){
			$args = shortcode_atts( array(
				'label_props' => '',
				'cell_props'  => 3,
				'render_input_cell' => false,
			), $atts );
		
			$fid 	= 'a_f'. $field['name'];
			$flabel = isset($field['label']) && !empty($field['label']) ? __($field['label'], 'woo-extra-product-options') : '';
			
			$field_props  = $this->prepare_form_field_props($field, $atts);
			$field_props .= isset($field['checked']) && $field['checked'] === 1 ? ' checked' : '';
			
			$field_html  = '<input type="checkbox" id="'. $fid .'" '. $field_props .' />';
			$field_html .= '<label for="'. $fid .'" '. $args['label_props'] .' > '. $flabel .'</label>';
		}
		if(!$render_cell && $args['render_input_cell']){
			return '<td '. $args['cell_props'] .' >'. $field_html .'</td>';
		}else{
			return $field_html;
		}
	}
	
	private function render_form_field_element_colorpicker($field, $atts = array()){
		$field_html = '';
		if($field && is_array($field)){
			$field_props = $this->prepare_form_field_props($field, $atts);
			
			$field_html  = '<span class="thpladmin-colorpickpreview '.$field['name'].'_preview" style=""></span>';
            $field_html .= '<input type="text" '. $field_props .' class="thpladmin-colorpick"/>';
		}
		return $field_html;
	}
	
	public function render_form_fragment_tooltip($tooltip = false){
		$tooltip_html = '';

		if($tooltip){
			$tooltip_html = '<a href="javascript:void(0)" title="'. $tooltip .'" class="thwepof_tooltip"><img src="'. THWEPOF_ASSETS_URL .'/css/help.png" title=""/></a>';
		}
		?>
		<td style="width: 26px; padding:0px;"><?php echo $tooltip_html; ?></td>
		<?php
	}
	
	public function render_form_fragment_h_separator($atts = array()){
		$args = shortcode_atts( array(
			'colspan' 	   => 6,
			'padding-top'  => '5px',
			'border-style' => 'dashed',
    		'border-width' => '1px',
			'border-color' => '#e6e6e6',
			'content'	   => '',
		), $atts );
		
		$style  = $args['padding-top'] ? 'padding-top:'.$args['padding-top'].';' : '';
		$style .= $args['border-style'] ? ' border-bottom:'.$args['border-width'].' '.$args['border-style'].' '.$args['border-color'].';' : '';
		
		?>
        <tr><td colspan="<?php echo $args['colspan']; ?>" style="<?php echo $style; ?>"><?php echo $args['content']; ?></td></tr>
        <?php
	}
	
	public function render_field_form_fragment_h_spacing($padding = 5){
		$style = $padding ? 'padding-top:'.$padding.'px;' : '';
		?>
        <tr><td colspan="6" style="<?php echo $style ?>"></td></tr>
        <?php
	}
	
	public function render_form_field_blank($colspan = 3){
		?>
        <td colspan="<?php echo $colspan; ?>">&nbsp;</td>  
        <?php
	}
	
	public function render_form_section_separator($props, $atts=array()){
		?>
		<tr valign="top"><td colspan="<?php echo $props['colspan']; ?>" style="height:10px;"></td></tr>
		<tr valign="top"><td colspan="<?php echo $props['colspan']; ?>" class="thpladmin-form-section-title" ><?php echo $props['title']; ?></td></tr>
		<tr valign="top"><td colspan="<?php echo $props['colspan']; ?>" style="height:0px;"></td></tr>
		<?php
	}
}
endif;