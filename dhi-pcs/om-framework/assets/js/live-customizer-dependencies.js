jQuery(function($){
	"use strict";
	
	setTimeout(function(){
		if(typeof om_theme_live_customizer_dependency !== undefined) {
	
			var showOptionNode=function(id){
				var $obj=$('#customize-control-'+id);
				$obj.removeClass('om-lcd-option-hidden');
				$obj.find('select, input, textarea').first().trigger('change.dependencies');
			}
			
			var hideOptionNode=function(id){
				var $obj=$('#customize-control-'+id);
				$obj.addClass('om-lcd-option-hidden');
				if(om_theme_live_customizer_dependency.hasOwnProperty(id)) {
					for(var i=0; i<om_theme_live_customizer_dependency[id].length; i++) {
						hideOptionNode(om_theme_live_customizer_dependency[id][i].target);
					}
				}
			}
			
			for(var id in om_theme_live_customizer_dependency) {
				if(om_theme_live_customizer_dependency.hasOwnProperty(id)) {
					
					var events='change.dependencies';
					var $obj=$('#customize-control-'+id).find('select, input, textarea').first();
					if($obj.is('input[type=text]') || $obj.is('textarea')) {
						events+=' keyup.dependencies';
					}
					$obj.bind(events, function(){
						var this_id=$(this).parents('.customize-control').attr('id').replace('customize-control-','');
	
						if(! $(this).parents('.customize-control').hasClass('om-lcd-option-hidden')) {
							for(var i=0; i<om_theme_live_customizer_dependency[this_id].length; i++) {
								var visible=false;
								var val;
								if($(this).is('input[type=radio]')) {
									val=$("input[name="+$(this).attr('name')+"]:checked").val();
								} else if($(this).is('input[type=checkbox]')) {
									val=$("input[name="+$(this).attr('name')+"]").is(':checked') ? $("input[name="+$(this).attr('name')+"]").val() : '';
								} else {
									val=$(this).val();
								}
								
								if(om_theme_live_customizer_dependency[this_id][i].mode == 'value') {
									for(var j=0;j<om_theme_live_customizer_dependency[this_id][i].value.length;j++) {
										if(val == om_theme_live_customizer_dependency[this_id][i].value[j]) {
											visible=true;
											break;
										}
									}
								} else if(om_theme_live_customizer_dependency[this_id][i].mode == 'not_empty') {
									visible=(val != '');
								}
								
								if(visible) {
									showOptionNode(om_theme_live_customizer_dependency[this_id][i].target);
								} else {
									hideOptionNode(om_theme_live_customizer_dependency[this_id][i].target);
								}
							}
						}
					}).trigger('change.dependencies');
					
				}
			}			
		}	
	}, 1000);
	
});