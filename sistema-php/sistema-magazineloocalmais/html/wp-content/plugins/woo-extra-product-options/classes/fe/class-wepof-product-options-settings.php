<?php
/**
 * Woo Extra Product Options - Field Editor
 *
 * @author    ThemeHiGH
 * @category  Admin
 */

if(!defined('ABSPATH')){ exit; }

if(!class_exists('WEPOF_Product_Options_Settings')):
class WEPOF_Product_Options_Settings extends WEPOF_Settings_Page {
	protected static $_instance = null;
	private $field_props = array();

	public function __construct() {
		parent::__construct('general_settings');
		$this->page_id = 'general_settings';
		$this->field_props = $this->get_field_form_props();

		add_filter( 'woocommerce_attribute_label', array($this, 'woo_attribute_label'), 10, 2 );
		
		//add_filter('thwepof_load_products', array($this, 'load_products'));
		add_filter('thwepof_load_products_cat', array($this, 'load_products_cat'));
	}

	public static function instance() {
		if(is_null(self::$_instance)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}	
	
	public function load_products(){
		$args = array( 'post_type' => 'product', 'order' => 'ASC', 'posts_per_page' => -1, 'fields' => 'ids' );
		if(!apply_filters("thwepof_conditions_show_only_active_products", true)){
			$args['post_status'] = 'any';
		}
		$products = get_posts( $args );
		$productsList = array();
		
		if(count($products) > 0){
			foreach($products as $pid){				
				$productsList[] = array("id" => $pid, "title" => get_the_title($pid));
			}
		}		
		return $productsList;
	}
	
	/*public function load_products_cat(){
		$product_cat = array();
		$pcat_terms = get_terms('product_cat', 'orderby=count&hide_empty=0');
		
		foreach($pcat_terms as $pterm){
			$product_cat[] = array("id" => $pterm->slug, "title" => $pterm->name);
		}		
		return $product_cat;
	}*/
	public function load_products_cat(){
		$ignore_translation = apply_filters('thwepof_ignore_wpml_translation_for_product_category', true);
		//$is_wpml_active = function_exists('icl_object_id');
		$is_wpml_active = THWEPOF_Utils::is_wpml_active();
		
		$product_cat = array();
		$pcat_terms = get_terms('product_cat', 'orderby=count&hide_empty=0');
		
		foreach($pcat_terms as $pterm){
			$pcat_slug = $pterm->slug;
			$pcat_slug = THWEPOF_Utils::check_for_wpml_traslation($pcat_slug, $pterm, $is_wpml_active, $ignore_translation);
							
			$product_cat[] = array("id" => $pcat_slug, "title" => $pterm->name);
		}		
		return $product_cat;
	}

	public function get_html_text_tags(){
		return array( 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6', 'p'  => 'p', 'div' => 'div', 'span' => 'span', 'label' => 'label');
	}
	
	public function get_field_types(){
		/*return array(
			'inputtext' => 'Text', 'hidden' => 'Hidden', 'number' => 'Number', 'tel' => 'Telephone', 'password' => 'Password', 
			'textarea' => 'Textarea', 'select' => 'Select', 'checkbox' => 'Checkbox', 'checkboxgroup' => 'Checkbox Group', 
			'radio' => 'Radio Button', 'datepicker' => 'Date Picker', 'colorpicker' => 'Color Picker', 'heading' => 'Heading', 
			'paragraph' => 'Paragraph'
		);*/
		return array(
			'inputtext' => 'Text', 'hidden' => 'Hidden', 'number' => 'Number', 'tel' => 'Telephone', 'password' => 'Password', 
			'textarea' => 'Textarea', 'select' => 'Select', 'checkbox' => 'Checkbox', 'checkboxgroup' => 'Checkbox Group', 
			'radio' => 'Radio Button', 'datepicker' => 'Date Picker', 'heading' => 'Heading', 
			'paragraph' => 'Paragraph'
		);
	}

	public function get_available_positions(){
		return array(
			'woo_before_add_to_cart_button'	=> 'Before Add To Cart Button',
			'woo_after_add_to_cart_button' 	=> 'After Add To Cart Button',
		);
	}

	public function get_section_form_props(){
		$positions = $this->get_available_positions();
		$html_text_tags = $this->get_html_text_tags();
		
		return array(
			'name' 		 => array('name'=>'name', 'label'=>'Name/ID', 'type'=>'text', 'required'=>1),
			'position' 	 => array('name'=>'position', 'label'=>'Display Position', 'type'=>'select', 'options'=>$positions, 'required'=>1),
			//'box_type' 	 => array('name'=>'box_type', 'label'=>'Box Type', 'type'=>'select', 'options'=>$box_types),
			'order' 	 => array('name'=>'order', 'label'=>'Display Order', 'type'=>'text'),
			'cssclass' 	 => array('name'=>'cssclass', 'label'=>'CSS Class', 'type'=>'text'),
			'show_title' => array('name'=>'show_title', 'label'=>'Show section title in product page.', 'type'=>'checkbox', 'value'=>'yes', 'checked'=>1),
			
			'title_cell_with' => array('name'=>'title_cell_with', 'label'=>'Col-1 Width', 'type'=>'text', 'value'=>''),
			'field_cell_with' => array('name'=>'field_cell_with', 'label'=>'Col-2 Width', 'type'=>'text', 'value'=>''),
			
			'title' 		   => array('name'=>'title', 'label'=>'Title', 'type'=>'text', 'required'=>1),
			'title_type' 	   => array('name'=>'title_type', 'label'=>'Title Type', 'type'=>'select', 'value'=>'h3', 'options'=>$html_text_tags),
			'title_class' 	   => array('name'=>'title_class', 'label'=>'Title Class', 'type'=>'text'),
			'title_color' 	   => array('name'=>'title_color', 'label'=>'Title Color', 'type'=>'colorpicker'),
		);
	}

	public function get_field_form_props(){
		$field_types = $this->get_field_types();
		$positions = $this->get_available_positions();
		
		$validators = array(
			'' => 'Select validation',
			'email' => 'Email',
			'number' => 'Number',
		);

		$title_positions = array(
			'left' => 'Left of the field',
			'above' => 'Above field',
		);
		
		return array(
			'name' 		  => array('type'=>'text', 'name'=>'name', 'label'=>'Name', 'required'=>1),
			'type' 		  => array('type'=>'select', 'name'=>'type', 'label'=>'Field Type', 'required'=>1, 'options'=>$field_types, 'onchange'=>'thwepoFieldTypeChangeListner(this)'),
			'value' 	  => array('type'=>'text', 'name'=>'value', 'label'=>'Default Value'),
			'options' 	  => array('type'=>'text', 'name'=>'options', 'label'=>'Options', 'placeholder'=>'Seperate options with pipe(|)'),
			'placeholder' => array('type'=>'text', 'name'=>'placeholder', 'label'=>'Placeholder'),
			'validator'   => array('type'=>'select', 'name'=>'validator', 'label'=>'Validation', 'placeholder'=>'Select validation', 'options'=>$validators),
			'cssclass'    => array('type'=>'text', 'name'=>'cssclass', 'label'=>'Wrapper Class', 'placeholder'=>'Seperate classes with comma'),
			'input_class'    => array('type'=>'text', 'name'=>'input_class', 'label'=>'Input Class', 'placeholder'=>'Seperate classes with comma'),
			'position' 	  => array('type'=>'select', 'name'=>'position', 'label'=>'Position', 'options'=>$positions),
			
			'minlength'   => array('type'=>'text', 'name'=>'minlength', 'label'=>'Min. Length', 'hint_text'=>'The minimum number of characters allowed'),
			'maxlength'   => array('type'=>'text', 'name'=>'maxlength', 'label'=>'Max. Length', 'hint_text'=>'The maximum number of characters allowed'),

			'cols' => array('type'=>'text', 'name'=>'cols', 'label'=>'Cols', 'hint_text'=>'The visible width of a text area'),
			'rows' => array('type'=>'text', 'name'=>'rows', 'label'=>'Rows', 'hint_text'=>'The visible height of a text area'),
			
			'checked'  => array('type'=>'checkbox', 'name'=>'checked', 'label'=>'Checked by default', 'value'=>'yes', 'checked'=>0),
			'required' => array('type'=>'checkbox', 'name'=>'required', 'label'=>'Required', 'value'=>'yes', 'checked'=>0, 'status'=>1),
			'enabled'  => array('type'=>'checkbox', 'name'=>'enabled', 'label'=>'Enabled', 'value'=>'yes', 'checked'=>1, 'status'=>1),
			'readonly'  => array('type'=>'checkbox', 'name'=>'readonly', 'label'=>'Readonly', 'value'=>'yes', 'checked'=>0, 'status'=>1),
			
			'title'          => array('type'=>'text', 'name'=>'title', 'label'=>'Label'),
			'title_position' => array('type'=>'select', 'name'=>'title_position', 'label'=>'Label Position', 'options'=>$title_positions),
			'title_class'    => array('type'=>'text', 'name'=>'title_class', 'label'=>'Label Class', 'placeholder'=>'Seperate classes with comma'),
		);
	}

	private function sort_field_set($fieldset){
		foreach($fieldset as $hook => &$hooked_fields){
			uasort( $hooked_fields, array( $this, 'sort_fields_by_order' ) );
		}
		return $fieldset;
	}

	public function sort_fields_by_order($a, $b){
	    if($a->get_property('order') == $b->get_property('order')){
	        return 0;
	    }
	    return ($a->get_property('order') < $b->get_property('order')) ? -1 : 1;
	}
	
	public function render_page(){
		$this->render_tabs();
		$this->render_sections();
		$this->render_content();
	}

	public function render_sections() {
		$result = false;
		if(isset($_POST['reset_fields']))
			$result = $this->reset_to_default();
			
		if(isset($_POST['s_action']) && $_POST['s_action'] == 'new')
			$result = $this->create_section();	
			
		if(isset($_POST['s_action']) && $_POST['s_action'] == 'edit')
			$result = $this->edit_section();
			
		if(isset($_POST['s_action']) && $_POST['s_action'] == 'remove')
			$result = $this->remove_section();
			
		$sections = THWEPOF_Utils::get_sections_admin();
		if(empty($sections)){
			return;
		}
		THWEPOF_Utils::sort_sections($sections);
		
		$array_keys = array_keys($sections);
		$current_section = $this->get_current_section();
				
		echo '<ul class="thpladmin-sections">';
		$i=0; 
		foreach( $sections as $name => $section ){
			$url = $this->get_admin_url($this->page_id, sanitize_title($name));
			$props_json = THWEPOF_Utils_Section::get_property_json($section);
			$rules_json = htmlspecialchars($section->get_property('conditional_rules_json'));
			$s_class = $current_section == $name ? 'current' : '';
			
			?>
			<li><a href="<?php echo $url; ?>" class="<?php echo $s_class; ?>"><?php _e($section->get_property('title'), 'woo-extra-product-options'); ?></a></li>
            <li>
            	<form id="section_prop_form_<?php echo $name; ?>" method="post" action="">
                    <input type="hidden" name="f_rules[<?php echo $i; ?>]" class="f_rules" value="<?php echo $rules_json; ?>" />
                </form>
				<span class='s_edit_btn dashicons dashicons-edit tips' data-tip='<?php _e('Edit Section', 'woo-extra-product-options'); ?>'  
				onclick='thwepofOpenEditSectionForm(<?php echo $props_json; ?>)'></span>
            </li>
			<li>
				<span class="s_copy_btn dashicons dashicons-admin-page tips" data-tip="<?php _e('Duplicate Section', 'woo-extra-product-options'); ?>"  
				onclick='thwepofOpenCopySectionForm(<?php echo $props_json; ?>)'></span>
			</li>
			<li>
                <form method="post" action="">
                    <input type="hidden" name="s_action" value="remove" />
                    <input type="hidden" name="i_name" value="<?php echo $name; ?>" />
					<span class='s_delete_btn dashicons dashicons-no tips' data-tip='<?php _e('Delete Section', 'woo-extra-product-options'); ?>'  
					onclick='thwepofRemoveSection(this)'></span>
				</form>
            </li>
            <?php
            if(end($array_keys) != $name){
            	echo '<li style="margin-right: 5px;">|</li>';
            }
			
			$i++;
		}
		echo '<li><a href="javascript:void(0)" onclick="thwepofOpenNewSectionForm()" class="add_link">+ '. __( 'Add new section', 'woo-extra-product-options') .'</a></li>';
		echo '</ul>';		
		
		if($result){
			echo $result;
		}
	}

	private function render_content(){
    	$action = isset($_POST['i_action']) ? $_POST['i_action'] : false;
    	$section_name = $this->get_current_section();
		$section = THWEPOF_Utils::get_section_admin($section_name);
		
		if(!$section){
			$section = THWEPOF_Utils_Section::prepare_default_section();
		}

		if($action === 'new')
			echo $this->save_or_update_field($section, $action);	
			
		if($action === 'edit')
			echo $this->save_or_update_field($section, $action);
		
		if(isset($_POST['save_fields']))
			echo $this->save_fields($section);

		$section = THWEPOF_Utils::get_section_admin($section_name);
		if(!$section){
			$section = THWEPOF_Utils_Section::prepare_default_section();
		}
		?> 

        <div class="wrap woocommerce"><div class="icon32 icon32-attributes" id="icon-woocommerce"><br/></div>                
		    <form method="post" id="thwepof_product_fields_form" action="">
            <table id="thwepof_product_fields" class="wc_gateways widefat thpladmin_fields_table" cellspacing="0">
                <thead>
                    <tr><?php $this->output_actions_row(); ?></tr>
                    <tr><?php $this->output_fields_table_heading(); ?></tr>						
                </thead>
                <tfoot>
                    <tr><?php $this->output_fields_table_heading(); ?></tr>
                    <tr><?php $this->output_actions_row(); ?></tr>
                </tfoot>

                <tbody class="ui-sortable">
                <?php 
                if(THWEPOF_Utils_Section::is_valid_section($section) && THWEPOF_Utils_Section::has_fields($section)){
					$i=0;												
					foreach( $section->get_property('fields') as $field ) :	
						$name = $field->get_property('name');
						$type = $field->get_property('type');
						$is_checked = $field->get_property('checked') ? 1 : 0; 		
						$is_required = $field->is_required() ? 1 : 0; 
						$is_enabled = $field->is_enabled() ? 1 : 0;
						$is_readonly = $field->is_readonly() ? 1 : 0;

						$props_json = htmlspecialchars(THWEPOF_Utils_Field::get_property_set_json($field, $this->field_props));
						$rules_json = htmlspecialchars($field->get_property('conditional_rules_json'));

						$title = '';
						if($type === 'paragraph'){
							$title = $field->get_property('value');
						}else{
							$title = $field->get_property('title');
						}
						$title = esc_attr($title);
						$title = stripslashes($title);
					?>
						<tr class="row_<?php echo $i; echo($is_enabled == 1 ? '' : ' thwepof-disabled') ?>">
							<td width="1%" class="sort ui-sortable-handle">
								<input type="hidden" name="f_name[<?php echo $i; ?>]" class="f_name" value="<?php echo $name; ?>" />
								<input type="hidden" name="f_order[<?php echo $i; ?>]" class="f_order" value="<?php echo $i; ?>" />
								<input type="hidden" name="f_deleted[<?php echo $i; ?>]" class="f_deleted" value="0" />
								<input type="hidden" name="f_enabled[<?php echo $i; ?>]" class="f_enabled" value="<?php echo $is_enabled; ?>" />

								<input type="hidden" name="f_props[<?php echo $i; ?>]" class="f_props" value='<?php echo $props_json; ?>' />
								<input type="hidden" name="f_rules[<?php echo $i; ?>]" class="f_rules" value="<?php echo $rules_json; ?>" />
							</td>
							<td class="td_select"><input type="checkbox" name="select_field"/></td>
							<td class="td_name"><?php echo esc_attr($name); ?></td>
							<td class="td_type"><?php _e($type, 'woo-extra-product-options'); ?></td>
							<td class="td_title"><?php _e($title, 'woo-extra-product-options'); ?></td>
							<td class="td_placeholder"><?php _e($field->get_property('placeholder'), 'woo-extra-product-options'); ?></td>
							<td class="td_validate"><?php echo $field->get_property('validator'); ?></td>
							<td class="td_required status">
								<?php echo($is_required == 1 ? '<span class="dashicons dashicons-yes tips" data-tip="'.__('Yes', 'woo-extra-product-options').'"></span>' : '-' ) ?>
							</td>
							<td class="td_enabled status">
								<?php echo($is_enabled == 1 ? '<span class="dashicons dashicons-yes tips" data-tip="'.__('Yes', 'woo-extra-product-options').'"></span>' : '-' ) ?>
							</td>

							<td class="td_actions" align="center">
								<?php if($is_enabled){ ?>
									<span class="f_edit_btn dashicons dashicons-edit tips" data-tip="<?php _e('Edit Field', 'woo-extra-product-options'); ?>" onclick="thwepofOpenEditFieldForm(this, <?php echo $i; ?>)"></span>
								<?php }else{ ?>
									<span class="f_edit_btn dashicons dashicons-edit disabled"></span>
								<?php } ?>
	
								<span class="f_copy_btn dashicons dashicons-admin-page tips" data-tip="<?php _e('Duplicate Field', 'woo-extra-product-options'); ?>" onclick="thwepofOpenCopyFieldForm(this, <?php echo $i; ?>)"></span>
							</td>
						</tr>						
                <?php 
					$i++; 
					endforeach; 
				}else{
					echo '<tr><td colspan="10" align="center" class="empty-msg-row">'.__("No custom fields found. Click on <b>Add field</b> button to create new fields.", "woo-extra-product-options").'</td></tr>';
				}
				?>
                </tbody>
            </table> 
            </form>
            <?php
            $this->output_add_section_form_pp();
			$this->output_edit_section_form_pp();
            $this->output_add_field_form_pp();
			$this->output_edit_field_form_pp();
			$this->output_popup_form_fragments();
			?>
    	</div>
    <?php
    }

    private function output_fields_table_heading(){
		?>
		<th class="sort"></th>
		<th class="check-column"><input type="checkbox" style="margin:0px 4px -1px -1px;" onclick="thwepofSelectAllProductFields(this)"/></th>
		<th class="name"><?php _e('Name', 'woo-extra-product-options'); ?></th>
		<th class="id"><?php _e('Type', 'woo-extra-product-options'); ?></th>
		<th><?php _e('Label', 'woo-extra-product-options'); ?></th>
		<th><?php _e('Placeholder', 'woo-extra-product-options'); ?></th>
		<th><?php _e('Validation Rules', 'woo-extra-product-options'); ?></th>
        <th class="status"><?php _e('Required', 'woo-extra-product-options'); ?></th>
		<th class="status"><?php _e('Enabled', 'woo-extra-product-options'); ?></th>	
        <th class="status"><?php _e('Actions', 'woo-extra-product-options'); ?></th>	
        <?php
	}

	private function output_actions_row(){
		?>
        <th colspan="5">
            <button type="button" onclick="thwepofOpenNewFieldForm()" class="button button-primary"><?php _e('+ Add field', 'woo-extra-product-options'); ?></button>
            <button type="button" onclick="thwepofRemoveSelectedFields()" class="button"><?php _e('Remove', 'woo-extra-product-options'); ?></button>
            <button type="button" onclick="thwepofEnableSelectedFields()" class="button"><?php _e('Enable', 'woo-extra-product-options'); ?></button>
            <button type="button" onclick="thwepofDisableSelectedFields()" class="button"><?php _e('Disable', 'woo-extra-product-options'); ?></button>
        </th>
        <th colspan="5">
        	<input type="submit" name="save_fields" class="button-primary" value="<?php _e('Save changes', 'woo-extra-product-options') ?>" style="float:right" />
            <input type="submit" name="reset_fields" class="button" value="<?php _e('Reset to default options', 'woo-extra-product-options') ?>" style="float:right; margin-right: 5px;" 
			onclick="return confirm('Are you sure you want to reset to default fields? all your changes will be deleted.');"/>
        </th>  
    	<?php 
	}

	public function reset_to_default() {
		delete_option(THWEPOF_Utils::OPTION_KEY_CUSTOM_SECTIONS);
		delete_option(THWEPOF_Utils::OPTION_KEY_SECTION_HOOK_MAP);
		delete_option(THWEPOF_Utils::OPTION_KEY_NAME_TITLE_MAP);

		echo '<div class="updated"><p>'. __('Product fields successfully reset', 'woo-extra-product-options') .'</p></div>';
	}

	public function woo_attribute_label( $label, $key ) {
		if(!empty($label)){
			$options_extra = THWEPOF_Utils::get_product_fields_full();
			if($options_extra){
				if(array_key_exists($label, $options_extra)) {
					$label = $options_extra[$label]->get_property('title');
				}
			}
		}
		return $label;
	}
	
   /*------------------------------------*
	*----- SECTION FUNCTIONS - START ----*
	*------------------------------------*/
	public function create_section(){
		$section = THWEPOF_Utils_Section::prepare_section_from_posted_data($_POST);
		$section = $this->prepare_copy_section($section, $_POST);

		$result1 = THWEPOF_Utils::update_section($section);
		$result2 = $this->update_options_name_title_map();
		
		if($result1 == true){
			return '<div class="updated"><p>'. __('New section added successfully.', 'woo-extra-product-options') .'</p></div>';
		}else{
			return '<div class="error"><p> '. __('New section not added due to an error.', 'woo-extra-product-options') .'</p></div>';
		}		
	}
	
	public function edit_section(){
		$section  = THWEPOF_Utils_Section::prepare_section_from_posted_data($_POST, 'edit');
		$name 	  = $section->get_property('name');
		$position = $section->get_property('position');
		$old_position = !empty($_POST['i_position_old']) ? $_POST['i_position_old'] : '';
		
		if($old_position && $position && ($old_position != $position)){			
			$this->remove_section_from_hook($position_old, $name);
		}
		
		$result = THWEPOF_Utils::update_section($section);
		
		if($result == true){
			return '<div class="updated"><p>'. __('Section details updated successfully.', 'woo-extra-product-options') .'</p></div>';
		}else{
			return '<div class="error"><p> '. __('Section details not updated due to an error.', 'woo-extra-product-options') .'</p></div>';
		}		
	}

	public function remove_section(){
		$section_name = !empty($_POST['i_name']) ? $_POST['i_name'] : false;		
		if($section_name){	
			$result = $this->delete_section($section_name);			
										
			if ($result == true) {
				return '<div class="updated"><p>'. __('Section removed successfully.', 'woo-extra-product-options') .'</p></div>';
			} else {
				return '<div class="error"><p> '. __('Section not removed due to an error.', 'woo-extra-product-options') .'</p></div>';
			}
		}
	}

	public function prepare_copy_section($section, $posted){
		$s_name_copy = isset($posted['s_name_copy']) ? $posted['s_name_copy'] : '';
		if($s_name_copy){
			$section_copy = THWEPOF_Utils::get_section_admin($s_name_copy);
			if(THWEPOF_Utils_Section::is_valid_section($section_copy)){
				$field_set = $section_copy->get_property('fields');
				if(is_array($field_set) && !empty($field_set)){
					$section->set_property('fields', $field_set);
				}
			}
		}
		return $section;
	}

	/*public function update_section($section){
	 	if(THWEPOF_Utils_Section::is_valid_section($section)){
			$sections = THWEPOF_Utils::get_sections_admin();
			$sections = (isset($sections) && is_array($sections)) ? $sections : array();
			
			$sections[$section->name] = $section;
			THWEPOF_Utils::sort_sections($sections);
			
			$result1 = THWEPOF_Utils::save_sections($sections);
			$result2 = $this->update_section_hook_map($section);
	
			return $result1;
		}
		return false;
	}
	
	private function update_section_hook_map($section){
		$section_name  = $section->name;
		$display_order = $section->get_property('order');
		$hook_name 	   = $section->position;
				
	 	if($hook_name && $section_name){	
			$hook_map = THWEPOF_Utils::get_section_hook_map();
			
			//Remove from hook if already hooked
			if($hook_map && is_array($hook_map)){
				foreach($hook_map as $hname => $hsections){
					if($hsections && is_array($hsections)){
						if(($key = array_search($section_name, $hsections)) !== false) {
							unset($hsections[$key]);
							$hook_map[$hname] = $hsections;
						}
					}
					
					if(empty($hsections)){
						unset($hook_map[$hname]);
					}
				}
			}
			
			if(isset($hook_map[$hook_name])){
				$hooked_sections = $hook_map[$hook_name];
				if(!in_array($section_name, $hooked_sections)){
					$hooked_sections[] = $section_name;
					$hooked_sections = THWEPOF_Utils::sort_hooked_sections($hooked_sections);
					
					$hook_map[$hook_name] = $hooked_sections;
					THWEPOF_Utils::save_section_hook_map($hook_map);
				}
			}else{
				$hooked_sections = array();
				$hooked_sections[] = $section_name;
				$hooked_sections = THWEPOF_Utils::sort_hooked_sections($hooked_sections);
				
				$hook_map[$hook_name] = $hooked_sections;
				THWEPOF_Utils::save_section_hook_map($hook_map);
			}					
		}
	}*/

	private function update_options_name_title_map(){
	 	$name_title_map = array();
	 	$sections = THWEPOF_Utils::get_sections_admin();
		if($sections && is_array($sections)){
			foreach($sections as $section_name => $section){
				if(THWEPOF_Utils_Section::is_valid_section($section)){					
					$fields = $section->get_property('fields');					
					if($fields && is_array($fields)){
						foreach($fields as $field_name => $field){
							if(THWEPOF_Utils_Field::is_valid_field($field) && THWEPOF_Utils_Field::is_enabled($field)){
								//$name_title_map[$field_name] = $field->get_display_label();
								$name_title_map[$field_name] = $field->get_property('title');
							}
						}
					}
				}
			}
		}
	 
		$result = THWEPOF_Utils::save_name_title_map($name_title_map);
		return $result;
	}

	public function delete_section($section_name){
		if($section_name){	
			$sections = THWEPOF_Utils::get_sections_admin();
			if(is_array($sections) && isset($sections[$section_name])){
				$section = $sections[$section_name];
				
				if(THWEPOF_Utils_Section::is_valid_section($section)){
					$hook_name = $section->get_property('position');
					
					$this->remove_section_from_hook($hook_name, $section_name);
					unset($sections[$section_name]);
								
					$result = THWEPOF_Utils::save_sections($sections);		
					return $result;
				}
			}
		}
		return false;
	}
	
	private function remove_section_from_hook($hook_name, $section_name){
		if(isset($hook_name) && isset($section_name) && !empty($hook_name) && !empty($section_name)){	
			$hook_map = THWEPOF_Utils::get_section_hook_map();
			
			if(is_array($hook_map) && isset($hook_map[$hook_name])){
				$hooked_sections = $hook_map[$hook_name];
				if(is_array($hooked_sections) && !in_array($section_name, $hooked_sections)){
					unset($hooked_sections[$section_name]);				
					$hook_map[$hook_name] = $hooked_sections;
					THWEPOF_Utils::save_section_hook_map($hook_map);
				}
			}				
		}
	}
   /*-----------------------------------*
	*----- SECTION FUNCTIONS - END -----*
	*-----------------------------------*/

   /*-----------------------------------*
	*----- FIELD FUNCTIONS - START -----*
	*-----------------------------------*/
	private function save_or_update_field($section, $action) {
		try {
			$field = THWEPOF_Utils_Field::prepare_field_from_posted_data($_POST, $this->field_props);
			
			if($action === 'edit'){
				$section = THWEPOF_Utils_Section::update_field($section, $field);
			}else{
				$section = THWEPOF_Utils_Section::add_field($section, $field);
			}
			
			$result1 = THWEPOF_Utils::update_section($section);
			$result2 = $this->update_options_name_title_map();

			if($result1 == true) {
				echo '<div class="updated"><p>'. __('Your changes were saved.', 'woo-extra-product-options') .'</p></div>';
			}else {
				echo '<div class="error"><p>'. __('Your changes were not saved due to an error (or you made none!).', 'woo-extra-product-options') .'</p></div>';
			}
		} catch (Exception $e) {
			echo '<div class="error"><p>'. __('Your changes were not saved due to an error.', 'woo-extra-product-options') .'</p></div>';
		}
	}

	private function save_fields($section) {
		try {
			$f_names = !empty( $_POST['f_name'] ) ? $_POST['f_name'] : array();	
			if(empty($f_names)){
				echo '<div class="error"><p> '. __('Your changes were not saved due to no fields found.', 'woo-extra-product-options') .'</p></div>';
				return;
			}
			
			$f_order   = !empty( $_POST['f_order'] ) ? $_POST['f_order'] : array();	
			$f_deleted = !empty( $_POST['f_deleted'] ) ? $_POST['f_deleted'] : array();
			$f_enabled = !empty( $_POST['f_enabled'] ) ? $_POST['f_enabled'] : array();
						
			$sname = $section->get_property('name');
			$field_set = THWEPOF_Utils_Section::get_fields($section);
						
			$max = max( array_map( 'absint', array_keys( $f_names ) ) );
			for($i = 0; $i <= $max; $i++) {
				$name = $f_names[$i];
				
				if(isset($field_set[$name])){
					if(isset($f_deleted[$i]) && $f_deleted[$i] == 1){
						unset($field_set[$name]);
						continue;
					}
					
					$field = $field_set[$name];
					$field->set_property('order', isset($f_order[$i]) ? trim(stripslashes($f_order[$i])) : 0);
					$field->set_property('enabled', isset($f_enabled[$i]) ? trim(stripslashes($f_enabled[$i])) : 0);
					
					$field_set[$name] = $field;
				}
			}
			$section->set_property('fields', $field_set);
			$section = THWEPOF_Utils_Section::sort_fields($section);
			
			$result = THWEPOF_Utils::update_section($section);
			
			if ($result == true) {
				echo '<div class="updated"><p>'. __('Your changes were saved.', 'woo-extra-product-options') .'</p></div>';
			} else {
				echo '<div class="error"><p>'. __('Your changes were not saved due to an error (or you made none!).', 'woo-extra-product-options') .'</p></div>';
			}
		} catch (Exception $e) {
			echo '<div class="error"><p>'. __('Your changes were not saved due to an error.', 'woo-extra-product-options') .'</p></div>';
		}
	}
   /*-----------------------------------*
	*----- FIELD FUNCTIONS - END -------*
	*-----------------------------------*/


   /*-----------------------------------
	*------ SECTION FORMS - START ------
	*-----------------------------------*/
	private function output_add_section_form_pp(){
		?>
        <div id="thwepof_new_section_form_pp" title="Create New Section" class="thwepo_popup_wrapper">
          <?php $this->output_popup_form_section('new'); ?>
        </div>
        <?php
	}
	
	private function output_edit_section_form_pp(){
		?>
        <div id="thwepof_edit_section_form_pp" title="Edit Section" class="thwepo_popup_wrapper">
          <?php $this->output_popup_form_section('edit'); ?>
        </div>
        <?php
	}
	
	private function output_popup_form_section($form_type){
		$fields = $this->get_section_form_props();	
		?>
        <form method="post" id="thwepof_<?php echo $form_type ?>_section_form" action="">
            <input type="hidden" name="s_action" value="<?php echo $form_type ?>" />
            <div id="thwepof-tabs-container_<?php echo $form_type ?>">
                <ul class="thpladmin-tabs-menu">
                    <li class="first current"><a class="thwepof_tab_general_link" href="javascript:void(0)" 
                    onclick="thwepofOpenFormTab(this, 'thwepof-section-tab-general', '<?php echo $form_type ?>')">General Properties</a></li>
                    <li><a class="thwepof_tab_rules_link" href="javascript:void(0)" 
                    onclick="thwepofOpenFormTab(this, 'thwepof-section-tab-rules', '<?php echo $form_type ?>')">Display Rules</a></li>
                </ul>
                <div id="thwepof_section_editor_form_<?php echo $form_type ?>" class="thpladmin-tab thwepo_popup_wrapper">
                    <div id="thwepof-section-tab-general_<?php echo $form_type ?>" class="thpladmin-tab-content">
                        <?php if($form_type === 'edit'){ ?>
                            <input type="hidden" name="s_name" value="" />
                            <input type="hidden" name="i_position_old" value="" />
                        <?php }else{ ?>
                            <input type="hidden" name="s_name_copy" value="" />
                        <?php } ?>
                        <input type="hidden" name="i_rules" value="" />
                         
                        <table width="100%" border="0">
                            <?php
                            $this->output_section_info_form($fields);
                            $this->render_form_fragment_h_separator();
                            $this->output_title_form($fields, true);
                            $this->render_form_fragment_h_separator();
                            ?> 
                        </table>
                    </div>
                    <div id="thwepof-section-tab-rules_<?php echo $form_type ?>" class="thpladmin-tab-content">
                        <table width="100%" style="margin-top: 10px;">
                        <?php 
                        $this->render_field_form_fragment_rules($form_type); 
                        ?>
                        </table>
                    </div>
                </div>
            </div>    
        </form>
        <?php
	}
	
	private function output_section_info_form($fields){
		$available_positions = $this->get_available_positions();
		
		$args_L = $this->cell_props_L;
		$args_R = $this->cell_props_R;
		
		?>
        <tr>                
            <td colspan="6" class="err_msgs"></td>
        </tr>            	
        <tr>                
            <?php
			$this->render_form_field_element($fields['name'], $args_L);
			$this->render_form_field_element($fields['position'], $args_R);
			?>
        </tr>  
        <tr>                
            <?php 
			$this->render_form_field_element($fields['cssclass'], $args_L);
			$this->render_form_field_element($fields['order'], $args_R);
			?>
        </tr> 
		<tr>                
            <?php 
			$this->render_form_field_element($fields['title_cell_with'], $args_L);
			$this->render_form_field_element($fields['field_cell_with'], $args_R);
			?>
        </tr>
        <?php
	}
	
	private function output_title_form($fields, $show_subtitle = false){
		?>
        <tr>  
        	<?php $this->render_form_field_element($fields['show_title'], array( 'input_cell_props' => 'colspan="4"' )); ?>
        </tr>
        <?php $this->render_field_form_fragment_h_spacing(); ?>
        <tr>                
        	<?php
			$this->render_form_field_element($fields['title'], $this->cell_props_L);
			$this->render_form_field_element($fields['title_type'], $this->cell_props_R);
			?>
        </tr>
        <tr>                
        	<?php
			$this->render_form_field_element($fields['title_class'], $this->cell_props_L);
			$this->render_form_field_element($fields['title_color'], $this->cell_props_CP);
			?>
        </tr>
        <?php
	}
   /*-------------------------------*
	*----- SECTION FORMS - END -----*
	*-------------------------------*/


   /*---------------------------------------
	*----- PRODUCT FIELDS FORMS - START ----
	*--------------------------------------*/
	private function output_add_field_form_pp(){
		?>
        <div id="thwepof_new_field_form_pp" title="New Product Field" class="thwepof_popup_wrapper">
          <?php $this->output_popup_form_fields('new'); ?>
        </div>
        <?php
	}

	private function output_edit_field_form_pp(){		
		?>
        <div id="thwepof_edit_field_form_pp" title="Edit Product Field" class="thwepof_popup_wrapper">
          <?php $this->output_popup_form_fields('edit'); ?>
        </div>
        <?php
	}
   
	private function output_popup_form_fields($form_type){
		?>
		<form method="post" id="thwepof_<?php echo $form_type ?>_field_form" action="">
			<!--<div class="container-fluid">
				<div class="row">
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      	<p>Text</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Hidden</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Number</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Telephone</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Password</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Textarea</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      	<p>Text</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Hidden</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Number</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Telephone</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Password</p>
				    </div>
				    <div class="col-sm-1">
				    	<img src="http://localhost/thpro/wp-content/plugins/woocommerce-email-customizer/admin/assets/images/header.svg" alt="Header">
				      <p>Textarea</p>
				    </div>
				</div>
			</div>
			-->
			<input type="hidden" name="i_action" value="<?php echo $form_type ?>" />
        	<div id="thwepof-tabs-container_<?php echo $form_type ?>">
				<ul class="thpladmin-tabs-menu">
	                <li class="first current"><a class="thwepof_tab_general_link" href="javascript:void(0)" 
	                onclick="thwepofOpenFormTab(this, 'thwepof-tab-general', '<?php echo $form_type ?>')">General Properties</a></li>
	                <li><a class="thwepof_tab_rules_link" href="javascript:void(0)" 
	                onclick="thwepofOpenFormTab(this, 'thwepof-tab-rules', '<?php echo $form_type ?>')">Display Rules</a></li>
	            </ul>
	            <div id="thwepof_field_editor_form_<?php echo $form_type ?>" class="thpladmin-tab thwepof_popup_wrapper">
                    <div id="thwepof-tab-general_<?php echo $form_type ?>" class="thpladmin-tab-content">
                    	<input type="hidden" name="i_name_old" value="" />
	        			<input type="hidden" name="i_rules" value="" />
						
						<?php $this->render_field_form_fragment_general($form_type); ?>
                        <table class="thwepof_field_form_tab_general_placeholder" width="100%"></table>
                    </div>
                    <div id="thwepof-tab-rules_<?php echo $form_type ?>" class="thpladmin-tab-content">
                    	<table class="thwepof_field_form_tab_rules_placeholder" width="100%" style="margin-top: 10px;">
                    	<?php 
						$this->render_field_form_fragment_rules($form_type);
						?>
                        </table>
                    </div>
                </div>



	        	<!-- <div id="thwepof_field_editor_form_<?php echo $form_type ?>">
	        		<input type="hidden" name="i_name_old" value="" />
	        		<input type="hidden" name="i_rules" value="" />
					<?php $this->render_field_form_fragment_general($form_type); ?>
	                <table class="thwepof_field_form_placeholder" width="100%"></table>
	                
	                <h4 style="margin: 15px 0 0 0; color:#5c5c5c;">Field Display Rules</h4>
	                <table id="thwepo-tab-rules_<?php echo $form_type ?>" width="100%" style="border-top: 1px dashed #a1a1a1; margin-top: 0px;">
	                <?php $this->render_field_form_fragment_rules($form_type); ?>
	                </table>
	            </div>-->
	        </div>
        </form>
        <?php
	}
	
	private function output_popup_form_fragments(){
		$this->render_field_form_inputtext();
		$this->render_field_form_hidden();
		$this->render_field_form_number();
		$this->render_field_form_tel();
		$this->render_field_form_password();
		$this->render_field_form_textarea();
		$this->render_field_form_select();
		$this->render_field_form_checkbox();
		$this->render_field_form_radio();

		$this->render_field_form_checkboxgroup();
		$this->render_field_form_datepicker();
		$this->render_field_form_colorpicker();
		$this->render_field_form_heading();
		$this->render_field_form_paragraph();
		
		$this->render_field_form_fragment_product_list();
		$this->render_field_form_fragment_category_list();
		$this->render_field_form_fragment_tag_list();
	}		

	private function render_field_form_inputtext(){
		?>
        <table id="thwepof_field_form_id_inputtext" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_position'], $this->cell_props_R);
            	//$this->render_field_form_fragment_title();
            	//$this->render_field_form_fragment_title_position();
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['value'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['placeholder'], $this->cell_props_R);
            	//$this->render_field_form_fragment_value();
            	//$this->render_field_form_fragment_placeholder();
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_class'], $this->cell_props_R);
            	//$this->render_field_form_fragment_class();
            	//$this->render_field_form_fragment_title_class();
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['validator'], $this->cell_props_L);
            	$this->render_form_field_blank();
            	//$this->render_field_form_fragment_validate();
            	//$this->render_field_form_fragment_empty_cell();
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_hidden(){
		?>
        <table id="thwepof_field_form_id_hidden" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['value'], $this->cell_props_R);
            	//$this->render_field_form_fragment_title();
            	//$this->render_field_form_fragment_value();
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_number(){
		?>
        <table id="thwepof_field_form_id_number" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_position'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['value'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['placeholder'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_class'], $this->cell_props_R);
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_tel(){
		?>
        <table id="thwepof_field_form_id_tel" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_position'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['value'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['placeholder'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_class'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['validator'], $this->cell_props_L);
            	$this->render_form_field_blank();
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_password(){
		?>
        <table id="thwepof_field_form_id_password" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_position'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['value'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['placeholder'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_class'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['validator'], $this->cell_props_L);
            	$this->render_form_field_blank();
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_textarea(){
		?>
        <table id="thwepof_field_form_id_textarea" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_position'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['value'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['placeholder'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_class'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cols'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['rows'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['validator'], $this->cell_props_L);
            	$this->render_form_field_blank();
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_select(){
		$prop_value = $this->field_props['value'];
		$prop_value['label'] = 'Default Options';
		?>
        <table id="thwepof_field_form_id_select" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['placeholder'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['options'], $this->cell_props_L);
            	$this->render_form_field_element($prop_value, $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_class'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title_position'], $this->cell_props_L);
            	$this->render_form_field_blank();
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>  
        </table>
        <?php   
	}

	private function render_field_form_radio(){
		$prop_value = $this->field_props['value'];
		$prop_value['label'] = 'Default Options';
		?>
        <table id="thwepof_field_form_id_radio" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_position'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['options'], $this->cell_props_L);
            	$this->render_form_field_element($prop_value, $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_class'], $this->cell_props_R);
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_checkbox(){
		$prop_value = $this->field_props['value'];
		$prop_value['label'] = 'Value';
		?>
        <table id="thwepof_field_form_id_checkbox" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($prop_value, $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_class'], $this->cell_props_R);
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['checked'], $this->cell_props_CB, false);
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_checkboxgroup(){
		$prop_value = $this->field_props['value'];
		$prop_value['label'] = 'Default Options';
		?>
        <table id="thwepof_field_form_id_checkboxgroup" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_position'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['options'], $this->cell_props_L);
            	$this->render_form_field_element($prop_value, $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_class'], $this->cell_props_R);
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_datepicker(){
		//$hint_default_date = "Specify a date in the current date format, or number of days from today (e.g. +7) or a string of values and periods ('y' for years, 'm' for months, 'w' for weeks, 'd' for days, e.g. '+1m +7d'), or leave empty for today.";

		$prop_value = $this->field_props['value'];
		$prop_value['label'] = 'Default Date';
		//$prop_value['hint_text'] = $hint_default_date;
		?>
        <table id="thwepof_field_form_id_datepicker" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_position'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($prop_value, $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['placeholder'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_class'], $this->cell_props_R);
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['readonly'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_colorpicker(){
		$prop_value = $this->field_props['value'];
		$prop_value['label'] = 'Default Color 111';
		?>
        <table id="thwepof_field_form_id_colorpicker" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title'], $this->cell_props_L);
            	$this->render_form_field_element($prop_value, $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['title_class'], $this->cell_props_R);
				?>
            </tr>
            <tr>
            	<?php
            	$this->render_form_field_element($this->field_props['title_position'], $this->cell_props_L);
            	$this->render_form_field_blank();
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
            	$this->render_form_field_element($this->field_props['required'], $this->cell_props_CB, false);
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_heading(){
		$prop_value = $this->field_props['value'];
		$prop_value['label'] = 'Heading Text';
		?>
        <table id="thwepof_field_form_id_heading" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr>
            	<?php
            	$this->render_form_field_element($prop_value, $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_R);
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_paragraph(){
		$prop_value = $this->field_props['value'];
		$prop_value['type'] = 'textarea';
		$prop_value['label'] = 'Content';
		?>
        <table id="thwepof_field_form_id_paragraph" class="thwepof_field_form_table" width="100%" style="display:none;">
            <tr valign="top">
            	<?php
            	$this->render_form_field_element($prop_value, $this->cell_props_L);
            	$this->render_form_field_element($this->field_props['cssclass'], $this->cell_props_R);
				?>
            </tr>
            <?php $this->render_field_form_fragment_h_spacing(); ?>
            <tr>
            	<td colspan="2">&nbsp;</td>
            	<td colspan="4">
            	<?php
				$this->render_form_field_element($this->field_props['enabled'], $this->cell_props_CB, false);
				?>
                </td>
            </tr>     
        </table>
        <?php   
	}

	private function render_field_form_fragment_general($form_type){
		$field_types = $this->get_field_types();
		?>
        <table width="100%">
            <tr>                
                <td colspan="6" class="err_msgs"></td>
            </tr>            	         
            <tr>
                <td width="13%"><?php _e('Name', 'woo-extra-product-options') ?><abbr class="required" title="required">*</abbr></td>
                <?php $this->render_form_fragment_tooltip(); ?>
                <td width="34%">
                	<input type="text" name="i_name" style="width:250px;"/>
                    <?php if($form_type === 'edit'){ ?>
                        <input type="hidden" name="i_rowid" value="" />
                    <?php } ?>
                </td>
                <td width="14%"><?php _e('Field Type', 'woo-extra-product-options'); ?><abbr class="required" title="required">*</abbr></td>
            	<?php $this->render_form_fragment_tooltip(); ?>
                <td width="33%">
                    <select name="i_type" style="width:250px;" onchange="thwepofFieldTypeChangeListner(this)">
                    <?php foreach($field_types as $value=>$label){ ?>
                        <option value="<?php echo trim($value); ?>"><?php echo $label; ?></option>
                    <?php } ?>
                    </select>
                </td>
            </tr> 
        </table>  
        <?php
	}

	private function render_field_form_fragment_position(){
		$positions = $this->get_available_positions();
		?>
        <td width="15%"><?php _e('Position', 'woo-extra-product-options'); ?></td>
        <td width="34%">
            <select name="i_position" style="width:250px;">
			<?php foreach($positions as $value => $label){ ?>
                <option value="<?php echo trim($value); ?>"><?php echo $label; ?></option>
            <?php } ?>
            </select>
        </td>
        <?php
	}

	private function render_field_form_fragment_title(){
		?>
        <td width="15%"><?php _e('Label', 'woo-extra-product-options'); ?></td>
        <?php $this->render_form_fragment_tooltip(); ?>
        <td width="34%"><input type="text" name="i_title" style="width:250px;"/></td>
        <?php
	}

	private function render_field_form_fragment_title_class(){
		?>
        <td width="15%"><?php _e('Label Class', 'woo-extra-product-options'); ?></td>
        <?php $this->render_form_fragment_tooltip(); ?>
        <td width="34%"><input type="text" name="i_title_class" placeholder="Seperate classes with comma" style="width:250px;"/></td>
        <?php
	}

	private function render_field_form_fragment_title_position(){
		?>
        <td width="15%"><?php _e('Label Position', 'woo-extra-product-options'); ?></td>
        <?php $this->render_form_fragment_tooltip(); ?>
        <td width="34%">
            <select name="i_title_position" style="width:250px;">
                <option value="left">Left of the field</option>
                <option value="above">Above field</option>             
            </select>
        </td>        
        <?php
	}

	private function render_field_form_fragment_value($label=''){
		$label = $label ? $label : 'Default Value';
		?>
        <td width="15%"><?php _e($label, 'woo-extra-product-options'); ?></td>
        <?php $this->render_form_fragment_tooltip(); ?>
        <td width="34%"><input type="text" name="i_value" style="width:250px;"/></td>
        <?php
	}

	private function render_field_form_fragment_content($type=false, $label=false){
		$label = $label ? $label : 'Content';
		?>
        <td width="15%"><?php _e($label, 'woo-extra-product-options'); ?></td>
        <?php $this->render_form_fragment_tooltip(); ?>
        <td width="34%">
        	<?php if($type === 'textarea'){ ?>
        		<textarea name="i_value" style="width:250px;"></textarea>
        	<?php }else{ ?>
        		<input type="text" name="i_value" style="width:250px;"/>
        	<?php } ?>
        </td>
        <?php
	}

	private function render_field_form_fragment_placeholder(){
		?>
        <td width="15%"><?php _e('Placeholder', 'woo-extra-product-options'); ?></td>
        <?php $this->render_form_fragment_tooltip(); ?>
        <td width="34%"><input type="text" name="i_placeholder" style="width:250px;"/></td>
        <?php
	}

	private function render_field_form_fragment_options(){
		?>
        <td width="5%"><?php _e('Options', 'woo-extra-product-options'); ?></td>
        <?php $this->render_form_fragment_tooltip(); ?>
        <td width="34%"><input type="text" name="i_options" placeholder="Seperate options with pipe(|)" style="width:250px;"/></td>
        <?php
	}

	private function render_field_form_fragment_validate(){
		?>
        <td width="15%"><?php _e('Validation', 'woo-extra-product-options'); ?></td>
        <?php $this->render_form_fragment_tooltip(); ?>
        <td width="34%">
            <select name="i_validator" style="width: 250px; height:30px;">
            	<option value=""><?php _e('Select validation', 'woo-extra-product-options'); ?></option>
                <option value="email"><?php _e('Email', 'woo-extra-product-options'); ?></option>
                <option value="number"><?php _e('Number', 'woo-extra-product-options'); ?></option>
            </select>
        </td>
        <?php
	}

	private function render_field_form_fragment_class(){
		?>
        <td width="15%"><?php _e('Wrapper Class', 'woo-extra-product-options'); ?></td>
        <?php $this->render_form_fragment_tooltip(); ?>
        <td width="34%"><input type="text" name="i_cssclass" placeholder="Seperate classes with comma" style="width:250px;"/></td>
        <?php
	}

	private function render_field_form_fragment_cols(){
		?>
        <td width="15%"><?php _e('Cols', 'woo-extra-product-options'); ?></td>
        <?php $this->render_form_fragment_tooltip(); ?>
        <td width="34%"><input type="text" name="i_cols" style="width:250px;"/></td>
        <?php
	}

	private function render_field_form_fragment_rows(){
		?>
        <td width="15%"><?php _e('Rows', 'woo-extra-product-options'); ?></td>
        <?php $this->render_form_fragment_tooltip(); ?>
        <td width="34%"><input type="text" name="i_rows" style="width:250px;"/></td>
        <?php
	}

	private function render_field_form_fragment_checked(){
		?>
        <input type="checkbox" id="a_fchecked" name="i_checked" value="yes" />
        <label for="a_fchecked" style="margin-right: 40px;" ><?php _e('Checked by default', 'woo-extra-product-options'); ?></label>
        <?php
	}

	private function render_field_form_fragment_required(){
		?>
        <input type="checkbox" id="a_frequired" name="i_required" value="yes" checked />
        <label for="a_frequired" style="margin-right: 40px;" ><?php _e('Required', 'woo-extra-product-options'); ?></label>
        <?php
	}

	private function render_field_form_fragment_enabled(){
		?>                              
        <input type="checkbox" id="a_fenabled" name="i_enabled" value="yes" checked />
        <label for="a_fenabled" style="margin-right: 40px;" ><?php _e('Enabled', 'woo-extra-product-options'); ?></label>
        <?php
	}

	private function render_field_form_fragment_readonly(){
		?>                              
        <input type="checkbox" id="a_freadonly" name="i_readonly" value="yes" />
        <label for="a_readonly" style="margin-right: 40px;" ><?php _e('Readonly', 'woo-extra-product-options'); ?></label>
        <?php
	}

	private function render_field_form_fragment_empty_cell(){
		?>
		<td colspan="3">&nbsp;</td>
        <?php
	}	
	
	private function render_field_form_fragment_rules($form_type){
		?>
        <tr>                
            <td colspan="6">
            	<table id="thwepo_conditional_rules" width="100%"><tbody>
                    <tr class="thwepo_rule_set_row">                
                        <td>
                            <table class="thwepo_rule_set" width="100%"><tbody>
                                <tr class="thwepo_rule_row">
                                    <td>
                                        <table class="thwepo_rule" width="100%" style=""><tbody>
                                            <tr class="thwepo_condition_set_row">
                                                <td>
                                                    <table class="thwepo_condition_set" width="100%" style=""><tbody>
                                                        <tr class="thwepo_condition">
                                                            <td width="25%">
                                                                <select name="i_rule_subject" style="width:200px;" onchange="thwepoRuleSubjectChangeListner(this)">
                                                                    <option value=""></option>
                                                                    <option value="product">Product</option>
                                                                    <option value="category">Category</option>
                                                                    <option value="tag">Tag</option>
                                                                </select>
                                                            </td>
                                                            <td width="25%">
                                                                <select name="i_rule_comparison" style="width:200px;">
                                                                    <option value=""></option>
                                                                    <option value="equals">Equals to/ In</option>
                                                                    <option value="not_equals">Not Equals to/ Not in</option>
                                                                </select>
                                                            </td>
                                                            <td width="25%" class="thwepo_condition_value"><input type="text" name="i_rule_value" style="width:200px;"/></td>
                                                            <td>
                                                                <a href="javascript:void(0)" class="thwepof_logic_link" onclick="thwepoAddNewConditionRow(this, 1)" title="">AND</a>
                                                                <a href="javascript:void(0)" class="thwepof_logic_link" onclick="thwepoAddNewConditionRow(this, 2)" title="">OR</a>
                                                                <a href="javascript:void(0)" class="thwepof_delete_icon dashicons dashicons-no" onclick="thwepoRemoveRuleRow(this)" title="Remove"></a>
                                                            </td>
                                                        </tr>
                                                    </tbody></table>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                            </tbody></table>            	
                        </td>            
                    </tr> 
        		</tbody></table>
        	</td>
        </tr>
        <?php
	}
	
	/*private function render_field_form_fragment_product_list(){
		$products = apply_filters( "thwepof_load_products", array() );
		array_unshift( $products , array( "id" => "-1", "title" => "All Products" ));
		?>
        <div id="thwepo_product_select" style="display:none;">
        <select multiple="multiple" name="i_rule_value" class="thwepof-enhanced-multi-select" style="width:200px;" value="">
			<?php 	
                foreach($products as $product){
                    echo '<option value="'. $product["id"] .'" >'. $product["title"] .'</option>';
                }
            ?>
        </select>
        </div>
        <?php
	}*/
	private function render_field_form_fragment_product_list(){
		?>
        <div id="thwepo_product_select" style="display:none;">
        <select multiple="multiple" name="i_rule_value" data-placeholder="Click to select products" class="thwepof-enhanced-multi-select1 thwepof-operand thwepof-product-select" style="width:200px;" value="">
        </select>
        </div>
        <?php
	}

	private function render_field_form_fragment_category_list(){		
		$categories = apply_filters( "thwepof_load_products_cat", array() );
		array_unshift( $categories , array( "id" => "-1", "title" => "All Categories" ));
		?>
        <div id="thwepo_product_cat_select" style="display:none;">
        <select multiple="multiple" name="i_rule_value" data-placeholder="Click to select categories" class="thwepof-enhanced-multi-select" style="width:200px;" value="">
			<?php 	
                foreach($categories as $category){
                    echo '<option value="'. $category["id"] .'" >'. $category["title"] .'</option>';
                }
            ?>
        </select>
        </div>
        <?php
	}

	private function render_field_form_fragment_tag_list(){		
		$tags = $this->load_product_tags();
		array_unshift( $tags , array( "id" => "-1", "title" => "All Tags" ));
		?>
        <div id="thwepo_product_tag_select" style="display:none;">
        <select multiple="multiple" name="i_rule_value" data-placeholder="Click to select tags" class="thwepof-enhanced-multi-select" style="width:200px;" value="">
			<?php 	
                foreach($tags as $tag){
                    echo '<option value="'. $tag["id"] .'" >'. $tag["title"] .'</option>';
                }
            ?>
        </select>
        </div>
        <?php
	}

	public function load_product_tags($only_slug = false){
		$product_tags = $this->load_product_terms('product_tag', $only_slug);
		return $product_tags;
	}

	/*public function load_product_terms($taxonomy, $only_slug = false){
		$product_terms = array();
		$pterms = get_terms($taxonomy, 'orderby=count&hide_empty=0');
		
		if($only_slug){
			foreach($pterms as $pterm){
				$product_terms[] = $pterm->slug;
			}	
		}else{
			foreach($pterms as $pterm){
				$product_terms[] = array("id" => $pterm->slug, "title" => $pterm->name);
			}	
		}
		return $product_terms;
	}*/

	public function load_product_terms($taxonomy, $only_slug = false){
		$product_terms = array();
		$pterms = get_terms($taxonomy, 'orderby=count&hide_empty=0');

		$ignore_translation = true;
		$is_wpml_active = THWEPOF_Utils::is_wpml_active();
		if($is_wpml_active && $ignore_translation){
			$default_lang = THWEPOF_Utils::off_wpml_translation();
		}

		if(is_array($pterms)){
			foreach($pterms as $term){
				$dterm = $term;

				if($is_wpml_active && $ignore_translation){
					$dterm = THWEPOF_Utils::get_default_lang_term($term, $taxonomy, $default_lang);
				}

				if($only_slug){
					$product_terms[] = $dterm->slug;
				}else{
					$product_terms[] = array("id" => $dterm->slug, "title" => $dterm->name);
				}
			}
		}

		if($is_wpml_active && $ignore_translation){
			THWEPOF_Utils::may_on_wpml_translation($default_lang);
		}

		return $product_terms;
	}
   /*----------------------------------------
	*----- PRODUCT FIELDS FORMS - END -------
	*---------------------------------------*/

 	/* function update_fields($custom_fields){
	 	if(is_array($custom_fields)){	
			$result = update_option('thwepof_custom_product_fields', $custom_fields);
			return $result;
		}
		return false;
	}*/	
}
endif;