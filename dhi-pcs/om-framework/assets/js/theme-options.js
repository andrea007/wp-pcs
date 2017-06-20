jQuery(function($){
	"use strict";
	
	// Overall Functionality
	jQuery('.om-group').hide();
	
	if(window.location.hash) {
		var $current=jQuery(window.location.hash+'.om-group');
		if($current.length) {
			jQuery('#om-options-sections li a[href="'+window.location.hash+'"]').parent().addClass('om-current');
			$current.show();
		} else {
			jQuery('.om-group:first').show();
			jQuery('#om-options-sections li:first').addClass('om-current');
		}
	}
	else {
		jQuery('.om-group:first').show();
		jQuery('#om-options-sections li:first').addClass('om-current');
	}
	
	jQuery('#om-options-sections li a').click(function(evt){
	
		jQuery('#om-options-sections li').removeClass('om-current');
		jQuery(this).parent().addClass('om-current');
		
		var clicked_group = jQuery(this).attr('href');

		jQuery('.om-group').hide();
		
		jQuery(clicked_group).fadeIn();

		evt.preventDefault();
	});
	
	// Image Radio
	jQuery('.om-radio-img-img').click(function(){
		jQuery(this).parent().parent().find('.om-radio-img-img').removeClass('om-radio-img-selected');
		jQuery(this).addClass('om-radio-img-selected');
	});
	
	jQuery('.om-radio-img-label').hide();
	jQuery('.om-radio-img-img').show();
	jQuery('.om-radio-img-radio').hide();


	//Color Picker

	jQuery('.om-wp-color-picker-field').wpColorPicker({
		clear: function(){
			jQuery(this).parents('.wp-picker-container').find('.wp-color-result').addClass('wp-picked-cleared');
		},
		change: function(){
			jQuery(this).parents('.wp-picker-container').find('.wp-color-result').removeClass('wp-picked-cleared');
		},
		'show_opacity': true
	});
	
	//Color Picker

	jQuery('.om-wp-color-picker-alpha-field').om_wpColorPickerAlpha({
		clear: function(){
			jQuery(this).parents('.wp-picker-container').find('.wp-color-result').addClass('wp-picked-cleared');
		},
		change: function(){
			jQuery(this).parents('.wp-picker-container').find('.wp-color-result').removeClass('wp-picked-cleared');
		},
		'show_opacity': true
	});

	//Save Options
	jQuery('#om-options-form').submit(function(){
	
		jQuery('.ajax-loading-img').fadeIn();
		var serializedReturn = jQuery("#om-options-form").serialize();
		 
		var args = {
			type: 'options',
			action: 'omfw_theme_options_ajax',
			data: serializedReturn
		};
		
		jQuery.post(ajaxurl, args, function(response) {
			jQuery('.ajax-loading-img').fadeOut();
			var success = jQuery('#om-popup-save').fadeIn();
			window.setTimeout(function(){
			   success.fadeOut(); 
			}, 2000);
		});
		
		return false; 
		
	});
	
	// styling presets save
	jQuery('#om-styling-button-save').click(function(){
		
		jQuery(this).unbind('click'); // once clicked document will be reloaded
	
		jQuery('.ajax-loading-img').fadeIn();
		var serializedReturn = jQuery("#om-options-form").serialize();
		 
		var args = {
			type: 'options',
			action: 'omfw_theme_options_ajax',
			data: serializedReturn
		};
		
		jQuery.post(ajaxurl, args, function(response) {
			jQuery('.ajax-loading-img').fadeOut();
			var success = jQuery('#om-popup-save').fadeIn();
			window.setTimeout(function(){
			   window.location.hash='#om-option-section-styling';
				 window.location.reload();
			}, 1000);
		});
		
		return false; 
		
	});
	
	// styling presets remove
	jQuery('.om-style-remove-button').click(function(){
		
		if(!confirm('Remove this style preset?'))
			return;
		
		var $this=jQuery(this);
		$this.unbind('click'); // once clicked document will be reloaded
	
		jQuery('.ajax-loading-img').fadeIn();
		 
		var data = {
			id: jQuery(this).data('optionid'),
			name: jQuery(this).data('optionname')
		}
	
		var args = {
			type: 'style_preset_remove',
			action: 'omfw_theme_options_ajax',
			data: data
		};
		
		jQuery.post(ajaxurl, args, function(response) {
			jQuery('.ajax-loading-img').fadeOut();
			$this.parents('tr').remove();
		});
		
		return false; 
		
	});
	
	// styling presets apply
	jQuery('.om-style-apply-button').click(function(){
		
		var $this=jQuery(this);
		$this.unbind('click'); // once clicked document will be reloaded
	
		jQuery('.ajax-loading-img').fadeIn();
		 
		var data = {
			id: jQuery(this).data('optionid'),
			name: jQuery(this).data('optionname')
		}
	
		var args = {
			type: 'style_preset_apply',
			action: 'omfw_theme_options_ajax',
			data: data
		};
		
		jQuery.post(ajaxurl, args, function(response) {
			jQuery('.ajax-loading-img').fadeOut();
			var success = jQuery('#om-popup-save').fadeIn();
			window.setTimeout(function(){
				if($this.data('redirect-url')) {
					window.location.href=$this.data('redirect-url');
				} else {
					window.location.reload();
				}
			}, 1000);
		});
		
		return false; 
		
	});
	
	// dependency
	
	if(typeof om_theme_options_dependency !== undefined) {

		var showOptionNode=function(id){
			var $obj=$('#'+id);
			if(!$obj.length) {
				$obj=$('input[name="'+id+'"]:first');
			}
			$obj.parents(".om-options-section").removeClass('om-option-hidden');
			$obj.change();
		}
		
		var hideOptionNode=function(id){
			var $obj=$('#'+id);
			if(!$obj.length) {
				$obj=$('input[name="'+id+'"]:first');
			}
			$obj.parents(".om-options-section").addClass('om-option-hidden');
			if(om_theme_options_dependency.hasOwnProperty(id)) {
				for(var i=0; i<om_theme_options_dependency[id].length; i++) {
					hideOptionNode(om_theme_options_dependency[id][i].target);
				}
			}
		}
		
		for(var id in om_theme_options_dependency) {
			if(om_theme_options_dependency.hasOwnProperty(id)) {
				
				var events='change';
				var $obj=$('#'+id);
				if(!$obj.length) {
					$obj=$('input[name="'+id+'"]');
				}
				if($obj.is('input[type=text]')) {
					events+=' keyup';
				}
				$obj.bind(events, function(){
					var this_id=$(this).attr('id');
					if(!this_id) {
						this_id=$(this).attr('name');
					}

					if(! $(this).parents(".om-options-section").hasClass('om-option-hidden')) {
						for(var i=0; i<om_theme_options_dependency[this_id].length; i++) {
							var visible=false;
							var val;
							if($(this).is('input[type=radio]')) {
								val=$("input[name="+$(this).attr('name')+"]:checked").val();
							} else if($(this).is('input[type=checkbox]')) {
								val=$("input[name="+$(this).attr('name')+"]").is(':checked') ? $("input[name="+$(this).attr('name')+"]").val() : '';
							} else {
								val=$(this).val();
							}
							
							if(om_theme_options_dependency[this_id][i].mode == 'value') {
								for(var j=0;j<om_theme_options_dependency[this_id][i].value.length;j++) {
									if(val == om_theme_options_dependency[this_id][i].value[j]) {
										visible=true;
										break;
									}
								}
							} else if(om_theme_options_dependency[this_id][i].mode == 'not_empty') {
								visible=(val != '');
							}
							
							if(visible) {
								showOptionNode(om_theme_options_dependency[this_id][i].target);
							} else {
								hideOptionNode(om_theme_options_dependency[this_id][i].target);
							}
						}
					}
				}).change();
				
			}
		}			
	}
});