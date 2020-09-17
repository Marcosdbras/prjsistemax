var thwepof_public = (function($, window, document) {
	'use strict';

	function initialize_thwepof(){
		var extra_options_wrapper = $('.thwepo-extra-options');
		//if(extra_options_wrapper){
			setup_date_picker(extra_options_wrapper, 'thwepof-date-picker', thwepof_public_var);
		//}
	}

	function setup_date_picker(form, class_selector, data){
		//form.find('.'+class_selector).each(function(){
		$('.'+class_selector).each(function(){
			var readonly = $(this).data("readonly");
			readonly = readonly === 'yes' ? true : false;
			
			$(this).datepicker({
				showButtonPanel: true,
				changeMonth: true,
				changeYear: true
			});
			$(this).prop('readonly', readonly);
		});
	}
	
	/***----- INIT -----***/
	initialize_thwepof();
	
	if(thwepof_public_var.is_quick_view == 'flatsome'){
		$(document).on('mfpOpen', function() {
			initialize_thwepof();
		});
	}else if(thwepof_public_var.is_quick_view == 'yith'){
		$(document).on("qv_loader_stop", function() {
			initialize_thwepof();
		});
	}else if(thwepof_public_var.is_quick_view == 'astra'){
		$(document).on("ast_quick_view_loader_stop", function() {
			initialize_thwepof();
		});
	}

	return {
		initialize_thwepof : initialize_thwepof,
	};

}(window.jQuery, window, document));
