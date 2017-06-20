jQuery(function($){
	
	var $context=$('#vc_properties-panel, #vc_ui-panel-edit-element'); // #vc_properties-panel before 4.7 version; #vc_ui-panel-edit-element - 4.7+
	
	browse_button_init();
	
	get_code_button_init();
	
	multiple_categories_init();

	/***/
		
	function browse_button_init() {
		
		jQuery('.om-wpb-browse-button', $context).not('.om-wpb-browse-button-bind').addClass('om-wpb-browse-button-bind').click(function(event) {
			
			event.preventDefault();
	
			var $button=jQuery(this);		 
			var input_id=jQuery(this).attr('rel');
			var custom_file_frame;
	
		  // If the media frame already exists, reopen it.
		  if ( jQuery(this).data('custom_file_frame') ) {
		  	custom_file_frame=jQuery(this).data('custom_file_frame');
		    custom_file_frame.open();
		    return;
		  }
		  
		  jQuery(this).data('custom_file_frame', null);
		  
		  var args={
	        // Set the title of the modal.
	        title: jQuery(this).data("choose"),
	
	        // Customize the submit button.
	        button: {
	            // Set the text of the button.
	            text: jQuery(this).data("select")
	        },
	        multiple: false
	    };
	    if(jQuery(this).data('library')) {
	    	args.library={
	    		type: jQuery(this).data('library')
	    	};
	    }
			custom_file_frame = wp.media.frames.customHeader = wp.media(args);
			jQuery(this).data('custom_file_frame', custom_file_frame);
	
	    custom_file_frame.on( "select", function() {
				var attachment = custom_file_frame.state().get("selection").first();
				jQuery('#'+input_id).val(attachment.attributes.url).change();
				
				if($button.data('mode') == 'preview') {
					jQuery('#'+$button.data('base-id')+'_image').html('<a href="'+attachment.attributes.url+'" target="_blank"><img src="'+attachment.attributes.url+'" /></a>');
				}
			});
			
			custom_file_frame.open();
			
			return;
			
		});
		
	}
	
	function get_code_button_init() {
		$('.om_get_code_button').click(function(){
			var params=vc.edit_element_block_view.model.get('params');
			vc.edit_element_block_view.model.save({params: vc.edit_element_block_view.getParams()});
			$('#'+$(this).data('output-id')).val(vc.builder.toString(vc.edit_element_block_view.model)).slideDown(300).focus();
			vc.edit_element_block_view.model.save({params: params});
			return false;
		}).each(function(){
			$('#'+$(this).data('output-id')).focus(function(){
				$(this).select();
			}).mouseup(function (e) {
				e.preventDefault();
			});
		});
	}
	
	function multiple_categories_init() {
		if ( vc.edit_element_block_view.model ) {
			for(i=0; i < vc.edit_element_block_view.model.settings.params.length; i++ ) {
				if(vc.edit_element_block_view.model.settings.params[i].type == 'om_categories_multiple') {
					var param_name = vc.edit_element_block_view.model.settings.params[i].param_name;
					if(param_name in vc.edit_element_block_view.model.attributes.params ) {
						var val = vc.edit_element_block_view.model.attributes.params[param_name];
						var $select=jQuery('#wpb_'+param_name+'_value', $context);
						for(j=0;j<val.length;j++) {
							jQuery('option[value='+val[j]+']').attr('selected','selected');
						}
					}
				}
			}
		}
	}
	
});