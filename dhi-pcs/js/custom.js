"use strict";

jQuery(function($){

	if(!!('ontouchstart' in window))
		jQuery('html').addClass('touch');
	else
		jQuery('html').addClass('no-touch');
		
	/***********************************/
	
	$(window).bind('resize load', function(){
		var timer=$(this).data('resize_delay_timer');
		if(timer)	{
			clearTimeout(timer);
			timer=false;
		}
		
		timer=setTimeout(function(){
			$(window).trigger('resize_delay');
		}, 200);
		$(this).data('resize_delay_timer', timer);
	});

	/***********************************/
		
	function responsiveListener_init(){
		var $win=$(window);
		if($('#eventerra-responsive-mobile-css').length) {
			var lastWindowSize=$win.width();
			$win.data('mobile-view',(lastWindowSize<768));
			
			$win.resize(function(){
				var w=$(this).width();
				if(
					(w>=768 && lastWindowSize < 768) ||
					(w<=767 && lastWindowSize > 767)
				){
					$win.data('mobile-view',(w<768));
				}
				lastWindowSize=w;
			});
		} else {
			$win.data('mobile-view', false);
		}
	}
		
	/***********************************/	
	
	responsiveListener_init();
	
	countdown_init();
	
	fix_placeholders();
		
	menu_init();
	
	sliced_gallery_init();
	
	masonry_gallery_init();
	
	responsive_embed_init();
	
	gallery_init(); // important to init after all isotope initializations
	
	video_bg_container_init();
	
	commentform_fast_validation_init();
	
	back_to_top_init();
	
	/***********************************/
	
	function countdown_init() {
		
		if($('#header-countdown').length) {
			var $obj=$('#header-countdown');
			var hideseconds=( $obj.data('hideseconds') ? true : false );
				
			var label_days=$obj.data('days');
			var label_hrs=$obj.data('hrs');
			var label_min=$obj.data('min');
			var label_sec=$obj.data('sec');
			
			var txt=$obj.text().replace( /^\s+/g, '').replace( /\s+$/g, '');
			var tmp=txt.split(' ');
			if(tmp.length == 2) {
				var tmp_d=tmp[0].split('-');
				var tmp_h=tmp[1].split(':');
				if(tmp_d.length == 3 && tmp_h.length == 3) {
					var monthNames = ["zero", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
					tmp_d[1]=parseInt(tmp_d[1]);
					if(isNaN(tmp_d[1])) {
						$obj.remove();
						return;
					}
					var timeGMT=$obj.data('gmt');
					if(typeof(timeGMT) == 'undefined' || timeGMT == '0') {
						timeGMT='';
					}
					var finaldate = new Date(monthNames[tmp_d[1]] + ' ' + tmp_d[2] + ', ' + tmp_d[0] + ' ' + tmp_h[0] + ':' + tmp_h[1] + ':' + tmp_h[2] + ' GMT'+timeGMT);
					$obj.html('').show();
					var $days=$('<div class="box-value" />');
					var $hrs=$('<div class="box-value" />');
					var $min=$('<div class="box-value" />');
					if(!hideseconds) {
						var $sec=$('<div class="box-value" />');
					}
					var $days_box=$('<div class="countdown-box box-days" />').append('<div class="box-bg" />').append($days).append('<div class="box-label">'+label_days+'</div>').appendTo($obj);
					var $hrs_box=$('<div class="countdown-box box-hrs" />').append($hrs).append('<div class="box-label">'+label_hrs+'</div>').appendTo($obj);
					var $min_box=$('<div class="countdown-box box-min" />').append($min).append('<div class="box-label">'+label_min+'</div>').appendTo($obj);
					if(!hideseconds) {
						var $sec_box=$('<div class="countdown-box box-sec" />').append($sec).append('<div class="box-label">'+label_sec+'</div>').appendTo($obj);
					}

					var now=new Date();
					if(finaldate > now) {
					
						$obj.countdown(finaldate);
	
						if(!jQuery('html').hasClass('touch') || !jQuery(window).data('mobile-view')) {
							
							var last_offset={
								totalDays: 0,
								hours: 0,
								minutes: 0,
								seconds: 0
							}
							var transformY=83; // %
							
							$obj.on('update.countdown', function(event) {
								$days.text(event.offset.totalDays);
								$hrs.text(event.offset.hours);
								$min.text(event.offset.minutes);
								if(!hideseconds) {
									$sec.text(event.offset.seconds);
								}
		
								if(last_offset.hours != event.offset.hours) {
									$hrs_box.find('.box-bg').remove();
									var k_hrs=(59-event.offset.minutes)/59;
									$('<div class="box-bg" />').css({
										opacity: k_hrs,
										transform: 'translateY('+(k_hrs*transformY)+'%)',
										animationDuration: (3600-k_hrs*3600)+'s'
									}).prependTo($hrs_box);
								}						
								if(last_offset.minutes != event.offset.minutes) {
									$min_box.find('.box-bg').remove();
									var k_min=(59-event.offset.seconds)/59;
									$('<div class="box-bg" />').css({
										opacity: k_min,
										transform: 'translateY('+(k_min*transformY)+'%)',
										animationDuration: (60-k_min*60)+'s'
									}).prependTo($min_box);
								}
								if(!hideseconds && last_offset.seconds != event.offset.seconds) {
									$sec_box.find('.box-bg').remove();
									$('<div class="box-bg" />').prependTo($sec_box);
								}
								
								last_offset=event.offset;
	   					});
	   				
	   				} else {
	   					// mobile view, no animation
	   					
	   					$('<div class="box-bg mobile-bg" />').prependTo($min_box);
	   					$('<div class="box-bg mobile-bg" />').prependTo($hrs_box);
							if(!hideseconds) {
								$('<div class="box-bg mobile-bg" />').prependTo($sec_box);
							}

							$obj.on('update.countdown', function(event) {
								$days.text(event.offset.totalDays);
								$hrs.text(event.offset.hours);
								$min.text(event.offset.minutes);
								if(!hideseconds) {
									$sec.text(event.offset.seconds);
								}
	   					});
	   					
	   				}
	   				
	   			} else {
   					$('<div class="box-bg mobile-bg" />').prependTo($min_box);
   					$('<div class="box-bg mobile-bg" />').prependTo($hrs_box);
						if(!hideseconds) {
							$('<div class="box-bg mobile-bg" />').prependTo($sec_box);
						}
						$days.text(0);
						$hrs.text(0);
						$min.text(0);
						if(!hideseconds) {
							$sec.text(0);
						}
   				}

				} else {
					$obj.remove();
				}
			}	else {
				$obj.remove();
			}
		}
	}
	
	/***********************************/
	
	function fix_placeholders() {
		
		var input = document.createElement("input");
	  if(('placeholder' in input)==false) { 
			jQuery('[placeholder]').focus(function() {
				var i = jQuery(this);
				if(i.val() == i.attr('placeholder')) {
					i.val('').removeClass('placeholder');
					if(i.hasClass('password')) {
						i.removeClass('password');
						this.type='password';
					}			
				}
			}).blur(function() {
				var i = jQuery(this);	
				if(i.val() == '' || i.val() == i.attr('placeholder')) {
					if(this.type=='password') {
						i.addClass('password');
						this.type='text';
					}
					i.addClass('placeholder').val(i.attr('placeholder'));
				}
			}).blur().parents('form').submit(function() {
				jQuery(this).find('[placeholder]').each(function() {
					var i = jQuery(this);
					i.addClass('placeholder-submitting');
					if(i.val() == i.attr('placeholder'))
						i.val('');
				})
			});
		}
	}
	
	/***********************************/
	
	function menu_init() {

		// Primary Menu
		
		$('ul.primary-menu a[href="#"]').removeAttr('href');
		
		$('ul.primary-menu-fallback.show-dropdown-symbol li').each(function(){
			if($(this).children('.sub-menu').length)
				$(this).addClass('menu-item-has-children');
		});
		
		$('.primary-menu li.megamenu-enable .sub-menu .sub-menu').addClass('megamenu-sub');
		
		$('.primary-menu > li.menu-item-has-children').mouseenter(function(){
			var $obj=$(this).children('.sub-menu');
			var timer=setTimeout(function(){
				$obj.css('overflow','visible');
			}, 200);
			$obj.data('timer',timer);
		}).mouseleave(function(){
			var $obj=$(this).children('.sub-menu');
			if($obj.data('timer'))
				clearTimeout($obj.data('timer'));
			$obj.css('overflow','hidden');
		});

		var args={
			popUpSelector: '.sub-menu:not(.megamenu-sub)',
			autoArrows: false,
			delay: 150,
			animation: {opacity: 'show', height: 'show'},
			animationOut: {},
			speed: 0,
			speedOut: 0,
			disableHI: true,
			onBeforeHide: function(){
				jQuery(this).parent().removeClass('omHover');
			},
			onShow: function(){
				jQuery(this).parent().addClass('omHover');
			}
		};
	
		$('ul.primary-menu').superfish(args);
		
		// Secondary Menu
		
		var $sec_menu_w=$('.header-extra-dropdown-menu-wrapper');
		var $sec_button_w=$('.header-extra-dropdown-button-wrapper');
		$('.header-extra-dropdown-button').click(function(){
			if($sec_button_w.hasClass('active')) {
				$sec_menu_w.hide();
				$sec_button_w.removeClass('active');
			} else {
				$sec_menu_w.show(0, function(){
					$sec_button_w.addClass('active');
				});
			}
		});
		$sec_button_w.mouseleave(function(){
			$sec_menu_w.hide();
			$sec_button_w.removeClass('active');
		});
		
		// Mobile menu		
		
		$('ul.primary-mobile-menu a[href="#"]').removeAttr('href');
		
		$('ul.primary-mobile-menu').superfish({
			autoArrows: false,
			delay: 500,
			animation: {opacity: 'show', height: 'show'},
			animationOut: {opacity: 'hide', height: 'hide'},
			speed: 150,
			speedOut: 200
		});
		
		$('.header-menu-mobile-control').click(function(){
			$(this).toggleClass('active');
			$('.primary-mobile-menu-container').slideToggle(200);
		});
		
		// Fit menu
		
		$(window).on('load', function(){
			$(window).on('resize_delay', function(){
				var $buttons=$('.header-buttons');
				var gap=($buttons.length ? $buttons.width() : 0);
				var w=$('.header-menu').width();
				var $menu=$('.header-menu-primary');
				if(!$menu.is(':visible')) {
					var mw=$menu.width();
				} else {
					var position=$menu.css('position');
					$menu.css({ visiblity: 'hidden', position:'absolute'});
					var mw=$menu.width();
					$menu.css({ visiblity: 'visible', position:position});
				}
				if((mw + gap) > w) {
					$('.header-menu').addClass('header-menu-trim');
				} else {
					$('.header-menu').removeClass('header-menu-trim');
				}
			});
		});
	}
	
	/*************************************/
	
	function gallery_init() {
		if(jQuery().omSlider) {
			jQuery('.custom-gallery').each(function(){
				var $items=jQuery(this).find('.items');
				var num=$items.find('.item').length;
				if(num > 1) {
					
					var active=0;
					var hash=document.location.hash.replace('#','');
					if(hash != '') {
						var $active=$items.find('.item[rel='+hash+']');
						if($active.length)
							active=$active.index();
					}
					jQuery(this).append('<div class="controls"><div class="control-prev"><a href="#" class="prev"></a></div><div class="control-next"><a href="#" class="next"></a></div><div class="control-progress"><div class="progress"></div></div></div>');
					var $controls=jQuery(this).find('.controls');
					$controls.find('.total').html(num);
					var args={
						speed: 400,
						next: $controls.find('.next'),
						prev: $controls.find('.prev'),
						active: active,
						before: function(currSlide, nextSlide, currSlideNum, nextSlideNum){
							$controls.find('.progress').css('width',Math.round(nextSlideNum/(num-1)*100)+'%');
						}
					};
					
					$('.prev, .next', $controls).mousedown(function(){
						$(this).addClass('mousedown');
					}).mouseup(function(){
						$(this).removeClass('mousedown');
					});
						
					/*
					var $blog=jQuery(this).parents('.blogroll.layout-grid');
					if($blog.length && jQuery().isotopeOm ) {
						var $iso=$blog.find('section');
						args.after=function(){
							$iso.isotopeOm('layout');
						};
					}
					*/
					$items.omSlider(args);
	
				}
			});
		}
	}
	
	
	/*************************************/
	
	function sliced_gallery_init() {
		
		jQuery(window).bind('resize load', function(){
			sliced_gallery_resize();
		});
		sliced_gallery_resize();
		
	}
	
	function sliced_gallery_resize(){
		
		$('.gallery-sliced').each(function(){
			var $cont=$(this);
			var w=$cont.width();
			
			//var mar=Math.floor(w*0.01);
			var mar=0;

			//2
			var $box=$cont.find('.gallery-sliced-box-2');
			if($box.length) {
				var h1=Math.floor(w*0.6666*0.66579634464751958224543080939948);
				$box.find('.img-1, .img-2').css('height',h1+'px');
			}
			
			//3
			var $box=$cont.find('.gallery-sliced-box-3');
			if($box.length) {
				$box.find('.img-2').css('margin-bottom',mar+'px');
				var h2=Math.floor(w*0.3333*0.65274151436031331592689295039164);
				var h1 = h2*2+mar;
				$box.find('.img-1').css('height',h1+'px');
				$box.find('.img-2, .img-3').css('height',h2+'px');
			}
						
			//4
			var $box=$cont.find('.gallery-sliced-box-4');
			if($box.length) {
				$box.find('.img-2, .img-3').css('margin-bottom',mar+'px');
				var h2=Math.floor(w*0.3333*0.56396866840731070496083550913838);
				var h1 = h2*3+mar*2;
				$box.find('.img-1').css('height',h1+'px');
				$box.find('.img-2, .img-3, .img-4').css('height',h2+'px');
			}
			
			//5
			var $box=$cont.find('.gallery-sliced-box-5');
			if($box.length) {
				var h1 = Math.floor(w*0.3333*0.6649076517150);
				var h2 = Math.floor(w*0.5*0.66550522648083);
				$box.find('.img-1, .img-2, .img-3').css('height',h1+'px');
				$box.find('.img-4, .img-5').css('height',h2+'px');
			}
		});
		
	}
	
	/******************************/
	
	function masonry_gallery_init() {

		if(jQuery().isotopeOm) {
			$('.gallery-masonry').each(function() {
				
				var $container=$(this).find('.items');
				
		    var args={ 
			    itemSelector: '.item',
			    layoutMode: 'masonry'
			  };
			  
				$container.isotopeOm(args);
				
				$container.find('img').load(function(){
					$container.isotopeOm('layout');
				});

	    });
		}
	}
	
	/********************************/
	
	function responsive_embed_init() {
		$('.responsive-embed').each(function(){
			var $obj=$(this).children(':first');
			if($obj.length) {
				var w=parseInt($obj.attr('width'));
				var h=parseInt($obj.attr('height'));
				if(!isNaN(w) && !isNaN(h) && w > 0 && h > 0) {
					var r=h/w;
					$(this).css('padding-bottom',(r*100)+'%');
				}
			}
		});
	}
	
	/*********************************/
	
	function video_bg_container_init() {
		
		function video_bg_container_fit($obj) {

			var $tmp;
			if($obj)
				$tmp=$obj;
			else
				$tmp=$('.om-video-bg-container');
			$tmp.each(function(){
				
				var $video=$(this).find('video');
				if($video.length) {
					var w = $(this).width();
					var h = $(this).height();

					var r = w/h;
					var vr = $video.data('wh-ratio');
	
					if (r < vr) {
						$video
							.width(h*vr)
							.height(h);
						$video
							.css('top',0)
							.css('left',-(h*vr-w)/2)
							.css('height',h);
	
					} else {
						$video
							.width(w)
							.height(w/vr);
						$video
							.css('top',-(w/vr-h)/2)
							.css('left',0)
							.css('height',w/vr);
					}
				}
				
			});
			
		}
		
		
		$('.om-video-bg-container').each(function(){
			
			var $container=$(this);
			var $video=$container.find('video');
			if($video.length) {
				
				$video.get(0).volume=0;
				
				$video.data('wh-ratio', 16/9 );

				$video.on('loadedmetadata', function(data) {

					var videoWidth =0;
					var videoHeight=0;
					
					if(this.videoWidth)
						videoWidth=this.videoWidth;
					if(this.videoHeight)
						videoHeight=this.videoHeight;

					if(videoWidth && videoHeight) {
						var ratio = videoWidth / videoHeight;
						$video.data('wh-ratio', ratio);
					}
					
					video_bg_container_fit($container);
					
				});

			}
			
		});
		
		$(window).on('resize_delay', function(){
			video_bg_container_fit();
		});
				
	}
	
	/*******************************/
	
	function commentform_fast_validation_init() {
		
		$('#commentform').submit(function(){
			var stop=false;
			$(this).find('input.required, textarea.required').each(function(){
				if($(this).val() == '') {
					$(this).addClass('error').on('keyup.validation', function(){
						$(this).removeClass('error').off('keyup.validation');
					});
					stop=true;
				}
			});
			if(stop)
				return false;
		});
		
	}

	/****************************************/
	
	function back_to_top_init() {
		
		var $button=$('.om-back-to-top');
		$button.click(function(){
			$('html, body').animate({scrollTop:0}, 500);
			return false;
		});
		
		
		var button_visible=false;
		var button_timer;
 		if($button.length) {
 			var fn=function(){
				var st=jQuery(window).scrollTop();
				if(st > 300 && !button_visible) {
					$button.addClass('active');
					button_visible=true;
				} else if(st < 300 && button_visible) {
					$button.removeClass('active');
					button_visible=false;
				}
 			}
			$(window).scroll(fn);
			fn();
		}
		
	}
	
});

/***********************************/

function lightbox_init(args_)
{
	var args={
		deeplinking: false,
		overlay_gallery: false,
		opacity: 1,
		theme: 'om_theme',
		horizontal_padding: 0,
		default_width: 1168,
		default_height: 657,
		markup: '<div class="pp_pic_holder">'+
						'<div class="pp_content_container">'+
							'<div class="pp_content">'+
								'<div class="pp_loaderIcon"></div>'+
								'<div class="pp_details">'+
									'<div class="pp_nav">'+
										'<a href="#" class="pp_arrow_previous">Previous</a>'+
										'<p class="currentTextHolder">0/0</p>'+
										'<a href="#" class="pp_arrow_next">Next</a>'+
									'</div>'+
									'{pp_social}'+
									'<a href="#" class="pp_expand" title="Expand the image">Expand</a>'+
									'<a class="pp_close" href="#">Close</a>'+
								'</div>'+
								'<div class="pp_fade">'+
									'<div class="pp_hoverContainer">'+
										'<a class="pp_next" href="#">next</a>'+
										'<a class="pp_previous" href="#">previous</a>'+
									'</div>'+
									'<div id="pp_full_res"></div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="ppt">&nbsp;</div>'+
					'</div>'+
					'<div class="pp_overlay"></div>'
	};
	if(args_)
		jQuery.extend(args, args_);
	
	//prettyPhoto
	if(jQuery().prettyPhoto) {
		jQuery('.om_video_popup_links a[href]').addClass('pp_worked_up').prettyPhoto(args);
		jQuery('a[rel^="prettyPhoto"]').addClass('pp_worked_up').prettyPhoto(args);
		jQuery('a[data-rel^="prettyPhoto"]').addClass('pp_worked_up').prettyPhoto(jQuery.extend(args, {hook: 'data-rel'}));
		var $tmp=jQuery('a').filter(function(){ return /\.(jpe?g|png|gif|bmp)$/i.test(jQuery(this).attr('href')); }).not('.pp_worked_up');
		$tmp.each(function(){
			if(typeof(jQuery(this).attr('title')) == 'undefined')
				jQuery(this).attr('title',''); 
		});
		$tmp.prettyPhoto(args); 
	}
}

/***********************************/

function om_local_scroll_init() {

	jQuery.extend(jQuery.easing,
	{
    easeInOutOM: function (x, t, b, c, d) {
      if (t==0) return b;
      if (t==d) return b+c;
      if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
      return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
 		}
	});
	
	jQuery('.wpb_text_column a, a.vc_btn3, .vc_om-click-icon-box a, .vc_om-click-icon-box2 a, .vc_om-teaser a, .vc_om-teaser2 a, .vc_call_to_action a, .vc_om-click-box').filter('[href*="#"]').click(function(e){
		var URI = location.href.replace(/#.*/, ''); // local url without hash
		if(this.href && this.hash && this.href.replace(this.hash,'') === URI) {
			var id=this.hash.slice(1);
			var $target=jQuery('#'+id);
			if(!$target.length) {
				$target=jQuery('a[name="'+id+'"]');
			}
				
			if($target.length) {
				e.preventDefault();
				
				var offset=$target.offset().top;
				var wh=jQuery(window).height();
				var dh=jQuery(document).height();
				if(offset > dh-wh)
					offset=dh-wh;
				if(offset < 0)
					offset=0;
				jQuery('html, body').animate({scrollTop:offset}, 1000, 'easeInOutOM');
			}
		}
		
	});
	
}

/***********************************/

function sidebar_slide_init() {
	jQuery(".content-column-sidebar aside").omStickSidebar({
		container: '.content-columns-wrapper',
		topGapEl: '#wpadminbar',
		minWidth: 768
	});
}

/********************************/

function page_out_init() {

	if(navigator.userAgent.toLowerCase().indexOf('safari') != -1 && navigator.userAgent.toLowerCase().indexOf('chrome') == -1) {
		return false;
	}
	
	var timer;
	
	jQuery(window).on('pageshow',function(event){
		if(event.originalEvent.persisted){
			if(timer) {
				clearTimeout(timer);
			}
			jQuery('.om-closing').remove();
			jQuery('.om-loading-circle').remove();
		}
	});
	
	jQuery(window).click(function(e){
		if(e.target && e.target.tagName == 'A' && e.target.href.toLowerCase().indexOf('mailto:') == 0) {
			jQuery(window).data('om-last-click',false);
		} else {
			var date=new Date();
			jQuery(window).data('om-last-click',{x: e.clientX, y: e.clientY, time: date.getTime()});
		}
	});

	jQuery(window).on('beforeunload', function(e) {
		var data=jQuery(window).data('om-last-click');
		if(data) {
			if(e.srcElement && e.srcElement.activeElement && e.srcElement.activeElement.tagName == 'A' && e.srcElement.activeElement.href.toLowerCase().indexOf('mailto:') == 0) {
				return;
			}
			
			var date=new Date();
			if( data.time + 100 > date.getTime() ) {
				timer=setTimeout(function(){
					var $closing=jQuery('<div class="om-closing"></div>');
					jQuery('body').append($closing);
					$closing.fadeTo(400, .8);
					timer=setTimeout(function(){
						jQuery('<div class="om-loading-circle"></div>').appendTo('body').css('z-index','100001').fadeIn(200);
					},200);
				},300);
			}
		}
	});

}