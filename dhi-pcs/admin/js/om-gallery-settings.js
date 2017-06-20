jQuery(function($){
	"use strict";

	if('gallery' in wp.media) {
	  _.extend(wp.media.gallery.defaults, {
	    layout: 'default'
	  });
	}

  wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
    template: function(view){
      return wp.media.template('om-gallery-settings')(view)
           + wp.media.template('gallery-settings')(view);
    },
    render: function() {
      wp.media.View.prototype.render.apply( this, arguments );
      
      var $obj=this.$el;
      
			var $header=$obj.find('h2').detach();
			$obj.prepend($header);
			
			var changefn=function(obj){
				var val=$(obj).val();
				
				$obj.find('select.ratio').parents('label').hide();
				$obj.find('select.columns').parents('label').hide();
				
				if(val != 'slider' && val != 'sliced') {
					$obj.find('select.columns').parents('label').show();
				}
				if(val == '' || val == 'default') {
					$obj.find('select.ratio').parents('label').show();
				}
			};
			
			$obj.find('select.layout').change(function(){
				changefn(this);
			});
			
			setTimeout(function(){ // doesn't work instantly
				$obj.find('select.layout').each(function(){
					changefn(this);
				});
			}, 100);
			
      // Select the correct values.
      _( this.model.attributes ).chain().keys().each( this.update, this );
      return this;
    }
  });

});