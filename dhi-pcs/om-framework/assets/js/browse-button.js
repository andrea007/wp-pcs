jQuery(function($) {
	"use strict";
	
	jQuery('.om-input-browse-button').click(function(event) {
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
	
	jQuery('.om-input-browse-button-remove').click(function(event){
		event.preventDefault();

		jQuery('#'+jQuery(this).data('base-id')+'_image').html('');
		jQuery('#'+jQuery(this).data('base-id')).val('').change();
		
	});
	
});