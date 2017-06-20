jQuery(function($) {
	"use strict";
	
	var hideAllMetaBox=function() {
		$('#om-post-meta-box-quote, #om-post-meta-box-link, #om-post-meta-box-video, #om-post-meta-box-audio, #om-post-meta-box-gallery').hide();
	}
	hideAllMetaBox();
	
	$('#post-formats-select input').change(function(){
		hideAllMetaBox();
		var type=$(this).val();
		$('#om-post-meta-box-'+type).show();
	});
	
	$('#post-formats-select input:checked').change();
	
});