jQuery(function($) {
	"use strict";

	$('.om-metabox-gallery-select').change(function(){
		var gallery_id=$(this).data('field-id')+'-gallery-wrapper';
		var attached_id=$(this).data('field-id')+'-gallery-attached';
		if($(this).val() == 'custom') {
			$('#'+gallery_id).slideDown(300);
			$('#'+attached_id).slideUp(300);
			initialize_metabox_gallery(gallery_id);
		}	else {
			$('#'+gallery_id).slideUp(300);
			$('#'+attached_id).slideDown(300);
		}
	}).change();
	
	$('.om-metabox-gallery-library-refresh').click(function(){
		var gallery_id=$(this).data('field-id')+'-gallery-wrapper';
		initialize_metabox_gallery(gallery_id);
		return false;
	});
	
	$('.om-metabox-gallery-select').each(function(){
		var gallery_id=$(this).data('field-id')+'-gallery-wrapper';
		var $wrapper=$('#'+gallery_id);
		var images_input_id=$wrapper.data('images-input-id');
		var $chosen_images=$wrapper.find('.om-metabox-gallery-images');
		
		$chosen_images.sortable({
			update: function(event, ui) {
				$('#'+images_input_id).attr('value',$chosen_images.sortable('toArray',{attribute: 'data-attachment-id'}).toString());
			}
		});
	});

		
	function initialize_metabox_gallery(gallery_id){

			var ajaxRequest;
			
			var $wrapper=$('#'+gallery_id);
			var images_input_id=$wrapper.data('images-input-id');
			var current_page=$wrapper.data('current-page');
			if(!current_page)
				current_page=1;
			var $images_box=$wrapper.find('.om-metabox-gallery-library-images');
			var $controls=$wrapper.find('.om-metabox-gallery-library-controls').empty();
			var $chosen_images=$wrapper.find('.om-metabox-gallery-images');
			var $no_images_label=$wrapper.find('.om-metabox-gallery-images-no-images');
			

			
			jQuery.post(
			   ajaxurl, 
			   {
			      action: 'omfw_metabox_gallery',
			      page: current_page
			   }, 
			   function(data){
			   	fill_controls(data);
					fill_images(data);
			   }
			);
			
			/*******************************************/

			$chosen_images.find('.om-remove').unbind('click').each(function(){
				attach_remove(this);
			});
							
			/*******************************************/
			
			function fill_images(data) {
	   		$images_box.empty();
	      for(var i in data.images) {
	      	var $item=$('<div class="om-item"/>').attr('title',data.images[i].title);
	      	var $img=$('<img src="'+data.images[i].src+'" width="'+data.images[i].width+'" height="'+data.images[i].height+'" />').attr('title',data.images[i].title).appendTo($item);
	      	var $title=$('<div class="title">'+data.images[i].title+'</div>').appendTo($item);

	      	$item.data('attachment-id',data.images[i].ID);
					$item.click(function(){
						var $new_img=$(this).children('img').clone();
						var $img_wrapper=$('<div class="om-item" />').hide();
						$new_img.appendTo($img_wrapper);
						var $remove=$('<span class="om-remove" />');
						$img_wrapper.data('attachment-id',$(this).data('attachment-id')).attr('data-attachment-id',$(this).data('attachment-id'));
						$remove.appendTo($img_wrapper);
						attach_remove($remove);
						
						$img_wrapper.appendTo($chosen_images).show(200);

						var count=$chosen_images.data('count');
						if(!count)
							count=0;
						count++;

						if(count == 1)
							$no_images_label.slideUp(200);						
						
						$chosen_images.data('count',count);
						
						var $img_anim=$(this).clone();
						var pos=$(this).position();
						$img_anim.css({
							position: 'absolute',
							top: pos.top+'px',
							left: pos.left+'px',
							boxShadow: 'none'
						});
						$img_anim.insertAfter(this).animate({marginTop: '-100px', opacity: 0}, 200, function(){
							$(this).remove();
						});

						refresh_input();

						return false;
					});

	      	$item.appendTo($images_box);
	      	
	      }
	      $images_box.append('<div class="clear" />');
			}
			
			/*******************************************/
			
			function attach_remove(obj) {
				var $obj=$(obj);
				$obj.click(function(){
					$(this).parent().hide(100,function(){
						$(this).remove();
						refresh_input();
					});
					var count=$chosen_images.data('count');
					count--;
					$chosen_images.data('count',count);

					if(count == 0)
						$no_images_label.slideDown(200);
					return false;
				});
			}
			
			/*******************************************/
			
			function refresh_input() {
				var ids=[];

				$chosen_images.children('.om-item').each(function(){
					ids.push($(this).data('attachment-id'));
				});
				
				$('#'+images_input_id).attr('value',ids.join(','));
			}
			
			/*******************************************/
			
			function fill_controls(data) {
				if(data.max_num_pages > 1) {
					var $pager=$('<ul class="om-metabox-gallery-pager" />');
					var $prev_next=$('<div class="om-metabox-gallery-prevnext" />');
					var $prev=$('<span class="om-metabox-gallery-prevnext-prev button button-primary button-disabled">&larr;</span>');
					var $next=$('<span class="om-metabox-gallery-prevnext-next button button-primary">&rarr;</span>');
					
					for(var i=1;i<=data.max_num_pages;i++) {
						var $li=$('<li class="button">'+i+'</li>');
						$li.data('page',i);
						$li.addClass('glp-'+i);
						if(i == data.page)
							$li.addClass('active');
						
						$li.click(function(){
							if($(this).hasClass('active'))
								return false;
							if(ajaxRequest)
								ajaxRequest.abort();
							
							$images_box.addClass('loading');
							
							current_page=$(this).data('page');
							$pager.find('li.active').removeClass('active');
							$(this).addClass('active');
							
							if(current_page > 1)
								$prev.removeClass('button-disabled');
							if(current_page < data.max_num_pages)
								$next.removeClass('button-disabled');
							if(current_page == 1)
								$prev.addClass('button-disabled');
							else if( current_page == data.max_num_pages)
								$next.addClass('button-disabled');
							
							ajaxRequest=jQuery.post(
							   ajaxurl,
							   {
							      action: 'omfw_metabox_gallery',
							      page: current_page
							   }, 
							   function(data_){
									fill_images(data_);
							   }
							).always(function(){
								$images_box.removeClass('loading');
							});
							
							return false;
						});
							
						$li.appendTo($pager);
					}
					$pager.appendTo($controls);
					
					
					$prev.click(function(){
						if(current_page < 2)
							return false;
						if(ajaxRequest)
							ajaxRequest.abort();
						$images_box.addClass('loading');
							
						current_page--;
						$pager.find('li.active').removeClass('active');
						$pager.find('li.glp-'+current_page).addClass('active');

						$next.removeClass('button-disabled');
						if(current_page == 1)
							$prev.addClass('button-disabled');
						
						ajaxRequest=jQuery.post(
						   ajaxurl,
						   {
						      action: 'omfw_metabox_gallery',
						      page: current_page
						   }, 
						   function(data_){
								fill_images(data_);
						   }
						).always(function(){
							$images_box.removeClass('loading');
						});
						
					});
					$prev.appendTo($prev_next);
					

					$next.click(function(){
						if(current_page >= data.max_num_pages)
							return false;
						if(ajaxRequest)
							ajaxRequest.abort();
						$images_box.addClass('loading');
							
						current_page++;
						$pager.find('li.active').removeClass('active');
						$pager.find('li.glp-'+current_page).addClass('active');

						$prev.removeClass('button-disabled');
						if(current_page == data.max_num_pages)
							$next.addClass('button-disabled');
						
						ajaxRequest=jQuery.post(
						   ajaxurl,
						   {
						      action: 'omfw_metabox_gallery',
						      page: current_page
						   }, 
						   function(data_){
								fill_images(data_);
						   }
						).always(function(){
							$images_box.removeClass('loading');
						});
						
					});
					$next.appendTo($prev_next);
					
					$prev_next.appendTo($controls);
				}
			}
			
	}
	
	/***************************************************/
	
	jQuery('.om-metabox-media-add-button').click(function(event) {
		event.preventDefault();

		var $button=jQuery(this);		 
		var custom_file_frame;
		var post_id=jQuery(this).data('post-id');

	  // If the media frame already exists, reopen it.
	  if ( jQuery(this).data('custom_file_frame') ) {
	  	custom_file_frame=jQuery(this).data('custom_file_frame');
	  	custom_file_frame.uploader.uploader.param( 'post_id', post_id );
	    custom_file_frame.open();
	    return;
	  }
	  
	  wp.media.model.settings.post.id = post_id;
	  jQuery(this).data('custom_file_frame', null);
	  
	  var args={
        // Set the title of the modal.
        title: jQuery(this).data("choose"),

        // Customize the submit button.
        button: {
            // Set the text of the button.
            text: ''
        },
        multiple: false,
        library: {
        	type: 'image'
        }
    };

		var old_contentUserSetting = wp.media.controller.Library.prototype.defaults.contentUserSetting;
		wp.media.controller.Library.prototype.defaults.contentUserSetting = false;

		custom_file_frame = wp.media.frames.customHeader = wp.media(args);
		jQuery(this).data('custom_file_frame', custom_file_frame);

    custom_file_frame.on( "select", function() {
			return false;
		});
		
		custom_file_frame.open();
		
		wp.media.controller.Library.prototype.defaults.contentUserSetting = old_contentUserSetting;
		
		return;
	});
	
	/*******************************************************/
	
	jQuery('.om-metabox-manage-attached-button').click(function(event) {
		event.preventDefault();

		var $button=jQuery(this);		 
		var custom_file_frame;
		var post_id=jQuery(this).data('post-id');

	  // If the media frame already exists, reopen it.
	  if ( jQuery(this).data('custom_file_frame') ) {
	  	custom_file_frame=jQuery(this).data('custom_file_frame');
	  	custom_file_frame.uploader.uploader.param( 'post_id', post_id );
	    custom_file_frame.open();
	    return;
	  }
	  
	  wp.media.model.settings.post.id = post_id;
	  jQuery(this).data('custom_file_frame', null);
	  
	  var args={
        // Set the title of the modal.
        title: jQuery(this).data("choose"),

        // Customize the submit button.
        button: {
            // Set the text of the button.
            text: ''
        },
        multiple: false,
        library: {
        	type: 'image',
        	uploadedTo: post_id,
        	orderby: 'menuOrder',
        	order: 'ASC'
        }
    };

		custom_file_frame = wp.media.frames.customHeader = wp.media(args);
		jQuery(this).data('custom_file_frame', custom_file_frame);

    custom_file_frame.on( "select", function() {
			return false;
		});
		
		custom_file_frame.open();
		
		return;
	});
	
	/****************************************************************/
	
	jQuery('.om-metabox-input-browse-button').click(function(event) {
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
			jQuery('#'+input_id).val(attachment.attributes.url);
			
			if($button.data('mode') == 'preview') {
				jQuery('#'+$button.data('base-id')+'_image').html('<a href="'+attachment.attributes.url+'" target="_blank"><img src="'+attachment.attributes.url+'" /></a>');
			}
		});
		
		custom_file_frame.open();
		
		return;
	});
	
	/*************************************/
	
	
	//color picker
	jQuery('.om-metabox-color-picker-field').wpColorPicker({
		clear: function(){
			jQuery(this).parents('.wp-picker-container').find('.wp-color-result').addClass('wp-picked-cleared');
		},
		change: function(){
			jQuery(this).parents('.wp-picker-container').find('.wp-color-result').removeClass('wp-picked-cleared');
		}
	});
	
});