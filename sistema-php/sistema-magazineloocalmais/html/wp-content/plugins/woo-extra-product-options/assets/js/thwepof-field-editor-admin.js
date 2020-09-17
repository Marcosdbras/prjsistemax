var thwepof_settings = (function($, window, document) {
	var MSG_INVALID_NAME = 'NAME/ID must begin with a lowercase letter ([a-z]) and may be followed by any number of lowercase letters, digits ([0-9]) and underscores ("_")';

	var OP_AND_HTML  = '<label class="thwepof_logic_label">AND</label>';
		OP_AND_HTML += '<a href="javascript:void(0)" onclick="thwepoRemoveRuleRow(this)" class="thwepof_delete_icon dashicons dashicons-no" title="Remove"></a>';
	var OP_OR_HTML   = '<tr class="thwepo_rule_or"><td colspan="4" align="center">OR</td></tr>';
	
	var OP_HTML  = '<a href="javascript:void(0)" class="thwepof_logic_link" onclick="thwepoAddNewConditionRow(this, 1)" title="">AND</a>';
		OP_HTML += '<a href="javascript:void(0)" class="thwepof_logic_link" onclick="thwepoAddNewConditionRow(this, 2)" title="">OR</a>';
		OP_HTML += '<a href="javascript:void(0)" onclick="thwepoRemoveRuleRow(this)" class="thwepof_delete_icon dashicons dashicons-no" title="Remove"></a>';
				
	var CONDITION_HTML  = '<tr class="thwepo_condition">';
		CONDITION_HTML += '<td width="25%"><select name="i_rule_subject" style="width:200px;" onchange="thwepoRuleSubjectChangeListner(this)">';
		CONDITION_HTML += '<option value=""></option><option value="product">Product</option>';
		CONDITION_HTML += '<option value="category">Category</option>';
		CONDITION_HTML += '<option value="tag">Tag</option>';
		CONDITION_HTML += '</select></td>';		
		CONDITION_HTML += '<td width="25%"><select name="i_rule_comparison" style="width:200px;">';
		CONDITION_HTML += '<option value=""></option> <option value="equals">Equals to/ In</option><option value="not_equals">Not Equals to/ Not in</option>';
		CONDITION_HTML += '</select></td>';
		CONDITION_HTML += '<td width="25%" class="thwepo_condition_value"><input type="text" name="i_rule_value" style="width:200px;"/></td>';
		CONDITION_HTML += '<td>'+ OP_HTML +'</td></tr>';
		
	var CONDITION_SET_HTML  = '<tr class="thwepo_condition_set_row"><td>';
		CONDITION_SET_HTML += '<table class="thwepo_condition_set" width="100%" style=""><tbody>'+CONDITION_HTML+'</tbody></table>';
		CONDITION_SET_HTML += '</td></tr>';
		
	var CONDITION_SET_HTML_WITH_OR = '<tr class="thwepo_condition_set_row"><td>';
		CONDITION_SET_HTML_WITH_OR += '<table class="thwepo_condition_set" width="100%" style=""><thead>'+OP_OR_HTML+'</thead><tbody>'+CONDITION_HTML+'</tbody></table>';
		CONDITION_SET_HTML_WITH_OR += '</td></tr>';
	
	var RULE_HTML  = '<tr class="thwepo_rule_row"><td>';
		RULE_HTML += '<table class="thwepo_rule" width="100%" style=""><tbody>'+CONDITION_SET_HTML+'</tbody></table>';
		RULE_HTML += '</td></tr>';	
		
	var RULE_SET_HTML  = '<tr class="thwepo_rule_set_row"><td>';
		RULE_SET_HTML += '<table class="thwepo_rule_set" width="100%"><tbody>'+RULE_HTML+'</tbody></table>';
		RULE_SET_HTML += '</td></tr>';		

   /*------------------------------------
	*---- ON-LOAD FUNCTIONS - SATRT -----
	*------------------------------------*/	 
	$(function() {
		$( "#thwepof_new_section_form_pp" ).dialog({
			modal: true,
			width: 900,
			resizable: false,
			autoOpen: false,
			buttons: [
				{
					text: "Cancel",
					click: function() { $( this ).dialog( "close" ); }	
				},
				{
					text: "Save",
					click: function() {
						var form = $("#thwepof_new_section_form");
						var tab_content = $("#thwepof_section_editor_form_new");
						var result = validate_section_form( form );
						if(result){
							prepare_section_form(tab_content);
							form.submit(); 
						}
					}
				}
			]
		});	
		$( "#thwepof_edit_section_form_pp" ).dialog({
			modal: true,
			width: 900,
			resizable: false,
			autoOpen: false,
			buttons: [
				{
					text: "Cancel",
					click: function() { $( this ).dialog( "close" ); }	
				},
				{
					text: "Save",
					click: function() {
						var form = $("#thwepof_edit_section_form");
						var tab_content = $("#thwepof_section_editor_form_edit");
						var result = validate_section_form( form );
						if(result){
							prepare_section_form(tab_content);
							form.submit();
						}
					}
				}
			]
		});

		$( "#thwepof_new_field_form_pp" ).dialog({
		  	modal: true,
			width: 900,
			resizable: false,
			autoOpen: false,
			buttons: [
				{
					text: "Cancel",
					click: function() { $( this ).dialog( "close" ); }	
				},
				{
					text: "Save Field",
					click: function() {
						var form = $("#thwepof_new_field_form");
						var result = validate_field_form( form );
						if(result){ 
							prepare_field_form(form);
							form.submit(); 
						}
						/*var result = wcpf_add_new_row( this );
						if(result){
							$( this ).dialog( "close" );
						}*/
					}
				}
			]
		});	

		$( "#thwepof_edit_field_form_pp" ).dialog({
		  	modal: true,
			width: 900,
			resizable: false,
			autoOpen: false,
			buttons: [
				{
					text: "Cancel",
					click: function() { $( this ).dialog( "close" ); }	
				},
				{
					text: "Save Field",
					click: function() {
						var form = $("#thwepof_edit_field_form");
						var result = validate_field_form( form );
						if(result){ 
							prepare_field_form(form);
							form.submit(); 
						}
						/*var result = wcpf_update_row( this );
						if(result){
							$( this ).dialog( "close" );
						}*/
					}
				}
			]
		});

		$('#thwepof_product_fields tbody').sortable({
			items:'tr',
			cursor:'move',
			axis:'y',
			handle: 'td.sort',
			scrollSensitivity:40,
			helper:function(e,ui){
				ui.children().each(function(){
					$(this).width($(this).width());
				});
				ui.css('left', '0');
				return ui;
			}		
		});	

		$("#thwepof_product_fields tbody").on("sortstart", function( event, ui ){
			ui.item.css('background-color','#f6f6f6');										
		});

		$("#thwepof_product_fields tbody").on("sortstop", function( event, ui ){
			ui.item.removeAttr('style');
			thwepof_prepare_field_order_indexes();
		});	

		setup_tiptip_tooltips();
	});
   /*------------------------------------
	*---- ON-LOAD FUNCTIONS - END -------
	*------------------------------------*/

   /*------------------------------------
	*---- COMMON FUNCTIONS - START ------
	*------------------------------------*/
	function setup_tiptip_tooltips(){
		var tiptip_args = {
			'attribute': 'data-tip',
			'fadeIn': 50,
			'fadeOut': 50,
			'delay': 200
		};

		$('.tips').tipTip( tiptip_args );
	}

	function setupColorPicker(form){
		form.find('.thpladmin-colorpick').iris({
			change: function( event, ui ) {
				$( this ).parent().find( '.thpladmin-colorpickpreview' ).css({ backgroundColor: ui.color.toString() });
			},
			hide: true,
			border: true
		}).click( function() {
			$('.iris-picker').hide();
			$(this ).closest('td').find('.iris-picker').show();
		});
	
		$('body').click( function() {
			$('.iris-picker').hide();
		});
	
		$('.thpladmin-colorpick').click( function( event ) {
			event.stopPropagation();
		});
	}
	
	function setup_enhanced_multi_select(form){
		form.find('select.thwepof-enhanced-multi-select').each(function(){
			if(!$(this).hasClass('enhanced')){
				$(this).select2({
					minimumResultsForSearch: 10,
					allowClear : true,
					placeholder: $(this).data('placeholder')
				}).addClass('enhanced');
			}
		});
	}

	function thwepof_prepare_field_order_indexes() {
		$('#thwepof_product_fields tbody tr').each(function(index, el){
			$('input.f_order', el).val( parseInt( $(el).index('#thwepof_product_fields tbody tr') ) );
		});
	};

	function isHtmlIdValid(id) {
		/*var re = /^[A-Za-z]+[\w\-\:\.]*$/;
		return re.test(id)*/
		var re = /^[a-z\_]+[a-z0-9\_]*$/;
		return re.test(id.trim());
	}

	function decodeHtml(str) {
		if(str && typeof(str) === 'string'){
		   	var map = {
	        	'&amp;': '&',
	        	'&lt;': '<',
	        	'&gt;': '>',
	        	'&quot;': '"',
	        	'&#039;': "'"
	    	};
	    	return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function(m) {return map[m];});
	    }
	    return str;
	}

	_selectAllFields = function selectAllFields(elm){
		var checkAll = $(elm).prop('checked');
		$('#thwepof_product_fields tbody input:checkbox[name=select_field]').prop('checked', checkAll);
	}

	function get_property_field_value(form, type, name){
		var value = '';
		
		switch(type) {
			case 'select':
				value = form.find("select[name=i_"+name+"]").val();
				value = value == null ? '' : value;
				break;
				
			case 'checkbox':
				value = form.find("input[name=i_"+name+"]").prop('checked');
				value = value ? 1 : 0;
				break;

			case 'textarea':
				value = form.find("textarea[name=i_"+name+"]").val();
				value = value == null ? '' : value;
				break;
				
			default:
				value = form.find("input[name=i_"+name+"]").val();
				value = value == null ? '' : value;
		}	
		
		return value;
	}

	function set_property_field_value(form, type, name, value, multiple){
		switch(type) {
			case 'select':
				if(multiple == 1 && typeof(value) === 'string'){
					value = value.split(",");
					name = name+"[]";
				}
				form.find('select[name="i_'+name+'"]').val(value);
				break;
				
			case 'checkbox':
				value = value == 1 ? true : false;
				form.find("input[name=i_"+name+"]").prop('checked', value);
				break;

			case 'textarea':
				value = value ? decodeHtml(value) : value;
				form.find("textarea[name=i_"+name+"]").val(value);
				break;
				
			default:
				value = value ? decodeHtml(value) : value;
				form.find("input[name=i_"+name+"]").val(value);
		}	
	}

	function _open_form_tab(elm, tab_id, form_type){
		var tabs_container = $(elm).closest("#thwepof-tabs-container_"+form_type);
		
		$(elm).parent().addClass("current");
		$(elm).parent().siblings().removeClass("current");
		var tab = $("#"+tab_id+"_"+form_type);
		tabs_container.find(".thpladmin-tab-content").not(tab).css("display", "none");
		$(tab).fadeIn();
	}
   /*------------------------------------
	*---- COMMON FUNCTIONS - END --------
	*------------------------------------*/

   /*------------------------------------
	*---- SECTION FUNCTIONS - START ------
	*------------------------------------*/
	var SECTION_FORM_FIELDS = {
		name 	   : {name : 'name', label : 'Name/ID', type : 'text', required : 1},
		position   : {name : 'position', label : 'Display Position', type : 'select', value : 'woo_before_add_to_cart_button', required : 1},
		order      : {name : 'order', label : 'Display Order', type : 'text'},
		cssclass   : {name : 'cssclass', label : 'CSS Class', type : 'text'},
		show_title : {name : 'show_title', label : 'Show section title in product page.', type : 'checkbox', value : 'yes', checked : true},
		
		title_cell_with : {name : 'title_cell_with', label : 'Col-1 Width', type : 'text', value : ''},
		field_cell_with : {name : 'field_cell_with', label : 'Col-2 Width', type : 'text', value : ''},
		
		title 		: {name : 'title', label : 'Title', type : 'text'},
		title_type 	: {name : 'title_type', label : 'Title Type', type : 'select', value : 'h3'},
		title_color : {name : 'title_color', label : 'Title Color', type : 'colorpicker'},
		title_class : {name : 'title_class', label : 'Title Class', type : 'text'}
	};

	function _open_new_section_form(){
		var form = $("#thwepof_new_section_form");
		var popup = $("#thwepof_new_section_form_pp");
		
		clear_section_form(form);
		popup.find('.thwepof_tab_general_link').click();
		popup.dialog( "open" );
		setupColorPicker(form);
		setup_enhanced_multi_select(form);
	}
	
	function _open_edit_section_form(sectionJson){
		var form = $("#thwepof_edit_section_form");
		var popup = $("#thwepof_edit_section_form_pp");
		
		populate_section_form(form, sectionJson, "edit");				
		popup.find('.thwepof_tab_general_link').click();
		popup.dialog( "open" );
		setupColorPicker(form);
		setup_enhanced_multi_select(form);
	}
	
	function _open_copy_section_form(sectionJson){
		var form = $("#thwepof_new_section_form");
		var popup = $("#thwepof_new_section_form_pp");
		
		populate_section_form(form, sectionJson, "copy");				
		popup.find('.thwepof_tab_general_link').click();
		popup.dialog( "open" );
		setupColorPicker(form);
		setup_enhanced_multi_select(form);
	}

	function _remove_section(elm){
		var _confirm = confirm('Are you sure you want to delete this section?.');
		if(_confirm){
			var form = $(elm).closest('form');
			if(form){ form.submit(); }
		}
	}

	function set_form_field_values(form, fields, valuesJson){
		var sname = valuesJson ? valuesJson['name'] : '';
		
		$.each( fields, function( fname, field ) {
			var ftype = field['type'];								  
			var fvalue = valuesJson ? valuesJson[fname] : field['value'];
			
			switch(ftype) {
				case 'select':
					form.find("select[name=i_"+fname+"]").val(fvalue);
					break;
					
				case 'checkbox':
					var checked = false;
					if(valuesJson){
						checked = fvalue == 1 ? true : false;
					}else{
						checked = field['checked'] ? true : false;
					}
					form.find("input[name=i_"+fname+"]").prop('checked', checked);
					break;
					
				case 'colorpicker':
					var bg_color = fvalue ? { backgroundColor: fvalue } : { backgroundColor: '' }; 
					form.find("input[name=i_"+fname+"]").val(fvalue);
					form.find("."+fname+"_preview").css(bg_color);
					break;
					
				default:
					form.find("input[name=i_"+fname+"]").val(fvalue);
			}
		});
		
		var prop_form = $('#section_prop_form_'+sname);
		
		var rulesAction = valuesJson['rules_action'];
		var conditionalRules = prop_form.find(".f_rules").val();
		
		rulesAction = rulesAction != '' ? rulesAction : 'show';
		form.find("select[name=i_rules_action]").val(rulesAction);
		
		populate_conditional_rules(form, conditionalRules, false);	
	}

	function clear_section_form(form){
		form.find('.err_msgs').html('');
		set_form_field_values(form, SECTION_FORM_FIELDS, false);
	}

	function populate_section_form(form, sectionJson, formType){
		form.find('.err_msgs').html('');
		set_form_field_values(form, SECTION_FORM_FIELDS, sectionJson);
		
		if(formType === 'copy'){
			var sNameCopy = sectionJson ? sectionJson['name'] : '';
			form.find("input[name=i_name]").val("");
			form.find("input[name=s_name_copy]").val(sNameCopy);
		}else{
			form.find("input[name=i_name]").prop("readonly", true);
		}
		form.find("select[name=i_position_old]").val(sectionJson.position);
		
		setTimeout(function(){form.find("select[name=i_position]").focus();}, 1);
	}

	function validate_section_form(form){
		var name  = get_property_field_value(form, 'text', 'name');
		var title = get_property_field_value(form, 'text', 'title');
		var position = get_property_field_value(form, 'select', 'position');
		
		var err_msgs = '';
		if(name.trim() == ''){
			err_msgs = 'Name/ID is required';
		}else if(!isHtmlIdValid(name)){
			err_msgs = MSG_INVALID_NAME;
		}else if(title.trim() == ''){
			err_msgs = 'Title is required';
		}else if(position == ''){
			err_msgs = 'Please select a position';
		}		
		
		if(err_msgs != ''){
			form.find('.err_msgs').html(err_msgs);
			form.find('.thwepof_tab_general_link').click();
			return false;
		}		
		return true;
	}

	function prepare_section_form(form){
		var rules_json = get_conditional_rules(form);	
		rules_json = rules_json.replace(/"/g, "'");

		set_property_field_value(form, 'hidden', 'rules', rules_json, 0);
	}
	/*------------------------------------
	*---- SECTION FUNCTIONS - END --------
	*------------------------------------*/

   /*------------------------------------
	*---- PRODUCT FIELDS - SATRT --------
	*------------------------------------*/
	var FIELD_FORM_PROPS = {
		name  : {name : 'name', type : 'text'},
		type  : {name : 'type', type : 'select'},
		
		value : {name : 'value', type : 'text'},
		options     : {name : 'options', type : 'text'},
		placeholder : {name : 'placeholder', type : 'text'},
		validator   : {name : 'validator', type : 'select'},
		input_class : {name : 'input_class', type : 'text'},
		cssclass    : {name : 'cssclass', type : 'text'},
		maxlength   : {name : 'maxlength', type : 'text'},
		
		title          : {name : 'title', type : 'text'},
		title_position : {name : 'title_position', type : 'select'},
		title_class    : {name : 'title_class', type : 'text'},
		
		checked  : {name : 'checked', type : 'checkbox'},
		required : {name : 'required', type : 'checkbox'},
		enabled  : {name : 'enabled', type : 'checkbox'},
		readonly : {name : 'readonly', type : 'checkbox'},
		
		maxsize : {name : 'maxsize', type : 'text'},
		accept  : {name : 'accept', type : 'text'},

		cols : {name : 'cols', type : 'text'},
		rows : {name : 'rows', type : 'text'},
	};

	_openNewFieldForm = function openNewFieldForm(){
		var popup = $("#thwepof_new_field_form_pp");
		var form = $("#thwepof_field_editor_form_new");
		
		clear_field_form_general(form);
		form.find("select[name=i_type]").change();	
		clear_field_form(form);
		
		popup.find('.thwepof_tab_general_link').click();
	  	popup.dialog("open");
	}
	
	_openEditFieldForm = function openEditFieldForm(elm, rowId){
		var popup = $("#thwepof_edit_field_form_pp");
		var form = $("#thwepof_field_editor_form_edit");

		var row = $(elm).closest('tr');
		var props_json = row.find(".f_props").val();
		var props = JSON.parse(props_json);

		populate_field_form_general(form, props, rowId);					
		form.find("select[name=i_type]").change();		
		populate_field_form(row, form, props, rowId);	
		
		popup.find('.thwepof_tab_general_link').click();
		popup.dialog("open");
	}

	_open_copy_field_form = function openCopyFieldForm(elm, rowId){
		var popup = $("#thwepof_new_field_form_pp");
		var form = $("#thwepof_field_editor_form_new");

		var row = $(elm).closest('tr');
		var props_json = row.find(".f_props").val();
		var props = JSON.parse(props_json);
				
		var name = '';
		set_property_field_value(form, 'text', 'name', name, 0);
		set_property_field_value(form, 'select', 'type', props.type, 0);
		
		form.find("select[name=i_type]").change();			
		populate_field_form(row, form, props, rowId);	
		
		popup.find('.thwepof_tab_general_link').click();
		popup.dialog("open");
	}

	_fieldTypeChangeListner = function fieldTypeChangeListner(elm){
		var type = $(elm).val();
		var form = $(elm).closest('form');

		type = type == null ? 'default' : type;
		form.find('.thwepof_field_form_tab_general_placeholder').html($('#thwepof_field_form_id_'+type).html());
		setup_enhanced_multi_select(form);				
	}

	function clear_field_form_general( form ){
		form.find('.err_msgs').html('');
		form.find("input[name=i_name]").val('');
		form.find("select[name=i_type]").prop('selectedIndex',0);
	}

	function clear_field_form(form){
		form.find("input[name=i_value]").val('');
		form.find("textarea[name=i_value]").val('');
		form.find("input[name=i_placeholder]").val('');
		form.find("input[name=i_options]").val('');

		form.find("select[name=i_validator] option:selected").removeProp('selected');
		form.find("input[name=i_cssclass]").val('');

		form.find("input[name=i_title]").val('');
		form.find("input[name=i_title_class]").val('');
		form.find("select[name=i_title_position]").prop('selectedIndex',0);

		form.find("input[name=i_cols]").val('');
		form.find("input[name=i_rows]").val('');

		form.find("input[name=i_checked]").prop('checked', false);
		form.find("input[name=i_required]").prop('checked', false);
		form.find("input[name=i_enabled]").prop('checked', true);
		form.find("input[name=i_readonly]").prop('checked', false);
		
		var conditionalRulesTable = form.find("#thwepo_conditional_rules tbody");
		conditionalRulesTable.html(RULE_SET_HTML);
		setup_enhanced_multi_select(conditionalRulesTable);
	}

	function populate_field_form_general(form, props, rowId){
		var name = props.name;
		var type = props.type;
		
		set_property_field_value(form, 'text', 'rowid', rowId, 0);
		set_property_field_value(form, 'text', 'name', name, 0);
		set_property_field_value(form, 'select', 'type', type, 0);
		set_property_field_value(form, 'hidden', 'name_old', name, 0);
		/*
		var name = row.find(".f_name").val();
		var type = row.find(".f_type").val();

		form.find("input[name=i_rowid]").val(rowId);
		form.find("input[name=i_name]").val(name);
		form.find("input[name=i_name_old]").val(name);
		form.find("select[name=i_type]").val(type);	*/
	}

	function populate_field_form(row, form, props, rowId){
		var ftype = props['type'];

		$.each( FIELD_FORM_PROPS, function( name, field ) {
			if(name == 'name' || name == 'type') {
				return true;
			}
	
			var type  = field['type'];
			var value = props[name];
			
			set_property_field_value(form, type, name, value, field['multiple']);
			
			if(type == 'select'){
				name = field['multiple'] == 1 ? name+"[]" : name;
				
				if(field['multiple'] == 1 || field['change'] == 1){
					form.find('select[name="i_'+field[name]+'"]').trigger("change");
				}
			}
		});

		if(ftype === 'paragraph'){
			set_property_field_value(form, 'textarea', 'value', props['value'], 0);
		}

		var conditionalRules = row.find(".f_rules").val();
		populate_conditional_rules(form, conditionalRules);	
	}

	function validate_field_form(form){
		var err_msgs = '';
		
		var fname  = get_property_field_value(form, 'text', 'name');
		var ftype  = get_property_field_value(form, 'select', 'type');
		var ftitle = get_property_field_value(form, 'text', 'title');
		//var foriginalType  = thwepo_base.get_property_field_value(form, 'hidden', 'original_type');
		
		if(ftype == 'html'){
			if(fname == ''){
				err_msgs = 'Name is required';
			}else if(!isHtmlIdValid(fname)){
				err_msgs = MSG_INVALID_NAME;
			}else if(ftitle == ''){
				err_msgs = 'Title is required';
			}		
		}else{
			if(ftype == '' ){
				err_msgs = 'Type is required';
			}else if(fname == ''){
				err_msgs = 'Name is required';
			}else if(!isHtmlIdValid(fname)){
				err_msgs = MSG_INVALID_NAME;
			}
		}	
		
		if(err_msgs != ''){
			form.find('.err_msgs').html(err_msgs);
			form.find('.thwepof_tab_general_link').click();
			return false;
		}
		return true;
	}

	function prepare_field_form(form){
		var rules_json = get_conditional_rules(form);	
		rules_json = rules_json.replace(/"/g, "'");

		set_property_field_value(form, 'text', 'rules', rules_json);
	}

	
	/* Conditional rules */
	
	this.ruleSubjectChangeListner = function(elm){
		$(elm).closest("tr.thwepo_condition").find("td.thwepo_condition_value").html();
		
		var subject = $(elm).val();
		var condition_row = $(elm).closest("tr.thwepo_condition");
		var target  = condition_row.find("td.thwepo_condition_value");
		
		if(subject === 'category'){
			target.html( $("#thwepo_product_cat_select").html() );
		}else if(subject === 'tag'){
			target.html( $("#thwepo_product_tag_select").html() );
		}else{
			target.html( $("#thwepo_product_select").html() );
		}	
		setup_enhanced_multi_select(condition_row);
		setup_product_dropdown(condition_row, false);	
	}
	
	_add_new_rule_row = function add_new_rule_row(elm, op){
		var condition_row = $(elm).closest('tr');
		condition = {};
		condition["subject"] = condition_row.find("select[name=i_rule_subject]").val();
		condition["comparison"] = condition_row.find("select[name=i_rule_comparison]").val();
		condition["cvalue"] = condition_row.find("select[name=i_rule_value]").val();
		if(!is_valid_condition(condition)){
			alert('Please provide a valid condition.');
			return;
		}
		
		if(op == 1){
			var conditionSetTable = $(elm).closest('.thwepo_condition_set');
			var conditionSetSize  = conditionSetTable.find('tbody tr.thwepo_condition').size();
			
			if(conditionSetSize > 0){
				$(elm).closest('td').html(OP_AND_HTML);
				conditionSetTable.find('tbody tr.thwepo_condition:last').after(CONDITION_HTML);
			}else{
				conditionSetTable.find('tbody').append(CONDITION_HTML);
			}
		}else if(op == 2){
			var ruleTable = $(elm).closest('.thwepo_rule');
			var ruleSize  = ruleTable.find('tbody tr.thwepo_condition_set_row').size();
			
			if(ruleSize > 0){
				ruleTable.find('tbody tr.thwepo_condition_set_row:last').after(CONDITION_SET_HTML_WITH_OR);
			}else{
				ruleTable.find('tbody').append(CONDITION_SET_HTML);
			}
		}	
	}
	
	_remove_rule_row = function remove_rule_row(elm){
		var ctable = $(elm).closest('table.thwepo_condition_set');
		var rtable = $(elm).closest('table.thwepo_rule');
		
		$(elm).closest('tr.thwepo_condition').remove();
		
		var cSize = ctable.find('tbody tr.thwepo_condition').size();
		if(cSize == 0){
			ctable.closest('tr.thwepo_condition_set_row').remove();
		}
		
		rSize = rtable.find('tbody tr.thwepo_condition_set_row').size();
		if(cSize == 0 && rSize == 0){
			rtable.find('tbody').append(CONDITION_SET_HTML);
		}
	}
		
	function is_valid_condition(condition){
		if(condition["subject"] && condition["comparison"]){
			return true;
		}
		return false;
	}
	
	function get_conditional_rules(elm){
		var conditionalRules = [];
		$(elm).find("#thwepo_conditional_rules tbody tr.thwepo_rule_set_row").each(function() {
			var ruleSet = [];
			$(this).find("table.thwepo_rule_set tbody tr.thwepo_rule_row").each(function() {
				var rule = [];															 
				$(this).find("table.thwepo_rule tbody tr.thwepo_condition_set_row").each(function() {
					var conditions = [];
					$(this).find("table.thwepo_condition_set tbody tr.thwepo_condition").each(function() {
						condition = {};
						condition["subject"] = $(this).find("select[name=i_rule_subject]").val();
						condition["comparison"] = $(this).find("select[name=i_rule_comparison]").val();
						condition["cvalue"] = $(this).find("select[name=i_rule_value]").val();
						//rule["op"] = $(this).find("input[name=i_rule_op]").val();
						if(is_valid_condition(condition)){
							conditions.push(condition);
						}
					});
					if(conditions.length > 0){
						rule.push(conditions);
					}
				});
				if(rule.length > 0){
					ruleSet.push(rule);
				}
			});
			if(ruleSet.length > 0){
				conditionalRules.push(ruleSet);
			}
		});
		
		var conditionalRulesJson = conditionalRules.length > 0 ? JSON.stringify(conditionalRules) : '';
		conditionalRulesJson = encodeURIComponent(conditionalRulesJson);
		return conditionalRulesJson;
	}
		
	function populate_conditional_rules(form, conditionalRulesJson){
		var conditionalRulesHtml = "";
		if(conditionalRulesJson){
			try{
				conditionalRulesJson = decodeURIComponent(conditionalRulesJson);
				var conditionalRules = $.parseJSON(conditionalRulesJson);

				if(conditionalRules){
					jQuery.each(conditionalRules, function() {
						var ruleSet = this;	
						var rulesHtml = '';
						
						jQuery.each(ruleSet, function() {
							var rule = this;
							var conditionSetsHtml = '';
							
							var y=0;
							var ruleSize = rule.length;
							jQuery.each(rule, function() {
								var conditions = this;								   	
								var conditionsHtml = '';
								
								var x=1;
								var size = conditions.length;
								jQuery.each(conditions, function() {
									var lastRow = (x==size) ? true : false;
									var conditionHtml = populate_condition_html(this, lastRow);
									if(conditionHtml){
										conditionsHtml += conditionHtml;
									}
									x++;
								});
								
								var firstRule = (y==0) ? true : false;
								var conditionSetHtml = populate_condition_set_html(conditionsHtml, firstRule);
								if(conditionSetHtml){
									conditionSetsHtml += conditionSetHtml;
								}
								y++;
							});
							
							var ruleHtml = populate_rule_html(conditionSetsHtml);
							if(ruleHtml){
								rulesHtml += ruleHtml;
							}
						});
						
						var ruleSetHtml = populate_rule_set_html(rulesHtml);
						if(ruleSetHtml){
							conditionalRulesHtml += ruleSetHtml;
						}
					});
				}
			}catch(err) {
				alert(err);
			}
		}
		
		if(conditionalRulesHtml){
			var conditionalRulesTable = form.find("#thwepo_conditional_rules tbody");
			conditionalRulesTable.html(conditionalRulesHtml);
			setup_enhanced_multi_select(conditionalRulesTable);
			setup_product_dropdown(conditionalRulesTable, true);
			
			conditionalRulesTable.find('tr.thwepo_condition').each(function(){
				$ruleVal = $(this).find("input[name=i_rule_value_hidden]").val();	
				$ruleVal = $ruleVal.split(",");													
				$(this).find("select[name=i_rule_value]").val($ruleVal).trigger("change");
			});
		}else{
			var conditionalRulesTable = form.find("#thwepo_conditional_rules tbody");
			conditionalRulesTable.html(RULE_SET_HTML);
			setup_enhanced_multi_select(conditionalRulesTable);
			setup_product_dropdown(conditionalRulesTable, false);
		}
	}
	
	function populate_rule_set_html(ruleHtml){
		var html = '';
		if(ruleHtml){
			html += '<tr class="thwepo_rule_set_row"><td><table class="thwepo_rule_set" width="100%"><tbody>';
			html += ruleHtml;
			html += '</tbody></table></td></tr>';
		}
		return html;
	}
	
	function populate_rule_html(conditionSetHtml){
		var html = '';
		if(conditionSetHtml){
			html += '<tr class="thwepo_rule_row"><td><table class="thwepo_rule" width="100%" style=""><tbody>';
			html += conditionSetHtml;
			html += '</tbody></table></td></tr>';
		}
		return html;
	}
	
	function populate_condition_set_html(conditionsHtml, firstRule){
		var html = '';
		if(conditionsHtml){
			if(firstRule){
				html += '<tr class="thwepo_condition_set_row"><td><table class="thwepo_condition_set" width="100%" style=""><tbody>';
				html += conditionsHtml;
				html += '</tbody></table></td></tr>';
			}else{
				html += '<tr class="thwepo_condition_set_row"><td><table class="thwepo_condition_set" width="100%" style=""><thead>'+OP_OR_HTML+'</thead><tbody>';
				html += conditionsHtml;
				html += '</tbody></table></td></tr>';
			}
		}
		return html;
	}
	
	function populate_condition_html(condition, lastRow){
		var html = '';
		if(condition){
			var selectedSubjProd = condition.subject === "product" ? "selected" : "";
			var selectedSubjCat = condition.subject === "category" ? "selected" : "";
			var selectedSubjTag = condition.subject === "tag" ? "selected" : "";
			
			var selectedCompjE = condition.comparison === "equals" ? "selected" : "";
			var selectedCompjNE = condition.comparison === "not_equals" ? "selected" : "";
			
			var valueHtml = '<input type="hidden" name="i_rule_value_hidden" value="'+condition.cvalue+'"/>';
			if(condition.subject === "product"){
				valueHtml += $("#thwepo_product_select").html();
			}else if(condition.subject === "category"){
				valueHtml += $("#thwepo_product_cat_select").html();
			}else if(condition.subject === "tag"){
				valueHtml += $("#thwepo_product_tag_select").html();
			}else{
				valueHtml += '<input type="text" name="i_rule_value" style="width:200px;" value="'+condition.cvalue+'"/>';
			}
			
			var actionsHtml = lastRow ? OP_HTML : OP_AND_HTML;
			
			html += '<tr class="thwepo_condition">';
			html += '<td width="25%"><select name="i_rule_subject" style="width:200px;" onchange="thwepoRuleSubjectChangeListner(this)" value="'+condition.subject+'">';
			html += '<option value=""></option><option value="product" '+selectedSubjProd+'>Product</option>';
			html += '<option value="category" '+selectedSubjCat+'>Category</option>';
			html += '<option value="tag" '+selectedSubjTag+'>Tag</option>';
			html += '</select></td>';		
			html += '<td width="25%"><select name="i_rule_comparison" style="width:200px;" value="'+condition.comparison+'">';
			html += '<option value=""></option><option value="equals" '+selectedCompjE+'>Equals to/ In</option>';
			html += '<option value="not_equals" '+selectedCompjNE+'>Not Equals to/ Not in</option>';
			html += '</select></td>';
			html += '<td width="25%" class="thwepo_condition_value">'+ valueHtml +'</td>';
			html += '<td>'+ actionsHtml+'</td></tr>';							
		}
		return html;
	}

	function setup_product_dropdown(parent, set_dv){
		parent.find('select.thwepof-product-select').each(function(){
			if(!$(this).hasClass('enhanced')){
				if(set_dv){
					prepare_selected_options($(this));
				}

				var elm = $(this).select2({
					minimumResultsForSearch: 10,
					allowClear : true,
					placeholder: $(this).data('placeholder'),
					ajax: {
						type: 'POST',
				        url: ajaxurl,
				        dataType: 'json',
				        data: function(params) {
				            return {
				            	action: 'thwepof_load_products',
				                term: params.term || '',
				                page: params.page || 1,
				            }
				        },
				        processResults: function (result, params) {
		                    return result.data;
						},
				        cache: true
				    },
				}).addClass('enhanced');
			}
		});
	}

	function prepare_selected_options(elm){
		var value = elm.siblings("input[name=i_rule_value_hidden]").val();
				
		if(value){
			var data = {
	            action: 'thwepof_load_products',
	            value: value,
	        };

			$.ajax({
	            type: 'POST',
	            url : ajaxurl,
	            data: data,
	            success: function(result){
	            	$.each(result.data.results, function( key, value ) {
						var newOption = new Option(value.text, value.id, true, true);
						elm.append(newOption);
					});
	            }
	        });
	        elm.trigger('change');
		}		
	}
   /*------------------------------------
	*---- PRODUCT FIELDS - END -----------
	*------------------------------------*/

   /*---------------------------------------
	* Remove fields functions - START
	*----------------------------------------*/
	_removeSelectedFields = function removeSelectedFields(){
		$('#thwepof_product_fields tbody tr').removeClass('strikeout');
		$('#thwepof_product_fields tbody input:checkbox[name=select_field]:checked').each(function () {
			var row = $(this).closest('tr');
			if(!row.hasClass("strikeout")){
				row.addClass("strikeout");
			}
			row.find(".f_deleted").val(1);
			row.find(".f_edit_btn").prop('disabled', true);
	  	});	
	}
   /*---------------------------------------
	* Remove fields functions - END
	*----------------------------------------*/

   /*---------------------------------------
	* Enable or Disable fields functions - START
	*----------------------------------------*/
	_enableDisableSelectedFields = function enableDisableSelectedFields(enabled){
		$('#thwepof_product_fields tbody input:checkbox[name=select_field]:checked').each(function(){
			var row = $(this).closest('tr');

			if(enabled == 0){
				if(!row.hasClass("thwepof-disabled")){
					row.addClass("thwepof-disabled");
				}
			}else{
				row.removeClass("thwepof-disabled");				
			}

			row.find(".f_edit_btn").prop('disabled', enabled == 1 ? false : true);
			row.find(".td_enabled").html(enabled == 1 ? '<span class="status-enabled tips">Yes</span>' : '-');
			row.find(".f_enabled").val(enabled);
	  	});	
	}
   /*---------------------------------------
	* Enable or Disable fields functions - END
	*----------------------------------------*/

	return {
		openFormTab : _open_form_tab,
		openNewSectionForm : _open_new_section_form,
		openEditSectionForm : _open_edit_section_form,
		openCopySectionForm : _open_copy_section_form,
		removeSection : _remove_section,
		openNewFieldForm : _openNewFieldForm,
		openEditFieldForm : _openEditFieldForm,
		openCopyFieldForm : _open_copy_field_form,
		removeSelectedFields : _removeSelectedFields,
		enableDisableSelectedFields : _enableDisableSelectedFields,
		fieldTypeChangeListner : _fieldTypeChangeListner,
		selectAllFields : _selectAllFields,
		ruleSubjectChangeListner : ruleSubjectChangeListner,
		add_new_rule_row : _add_new_rule_row,
		remove_rule_row : _remove_rule_row,
   	};
}(window.jQuery, window, document));	

function thwepofOpenFormTab(elm, tab_id, form_type){
	thwepof_settings.openFormTab(elm, tab_id, form_type);
}

function thwepofOpenNewSectionForm(){
	thwepof_settings.openNewSectionForm();		
}

function thwepofOpenEditSectionForm(section){
	thwepof_settings.openEditSectionForm(section);		
}

function thwepofOpenCopySectionForm(section){
	thwepof_settings.openCopySectionForm(section);		
}

function thwepofRemoveSection(elm){
	thwepof_settings.removeSection(elm);	
}

function thwepofOpenNewFieldForm(){
	thwepof_settings.openNewFieldForm();		
}

function thwepofOpenEditFieldForm(elm, rowId){
	thwepof_settings.openEditFieldForm(elm, rowId);		
}

function thwepofOpenCopyFieldForm(elm, rowId){
	thwepof_settings.openCopyFieldForm(elm, rowId);		
}
	
function thwepofRemoveSelectedFields(){
	thwepof_settings.removeSelectedFields();
}

function thwepofEnableSelectedFields(){
	thwepof_settings.enableDisableSelectedFields(1);
}

function thwepofDisableSelectedFields(){
	thwepof_settings.enableDisableSelectedFields(0);
}

function thwepofFieldTypeChangeListner(elm){	
	thwepof_settings.fieldTypeChangeListner(elm);
}

function thwepofSelectAllProductFields(elm){
	thwepof_settings.selectAllFields(elm);
}

function thwepoRuleSubjectChangeListner(elm){
	thwepof_settings.ruleSubjectChangeListner(elm);
}

function thwepoAddNewConditionRow(elm, op){
	thwepof_settings.add_new_rule_row(elm, op);
}

function thwepoRemoveRuleRow(elm){
	thwepof_settings.remove_rule_row(elm);
}
