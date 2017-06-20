jQuery(function($){
	"use strict";
	
	$('.wpb_gallery_slides a.prettyphoto').add('.vc_images_carousel a.prettyphoto').removeClass('prettyphoto'); // Remove this class to abort prettyPhoto implementing by WPB Composer
	
	/*******************************/
	
	parallax_init();
	
	testimonials_init();
	
	logos_init();
	
	blog_posts_init();
	
	agenda_init();
	
	/*******************************/
	
	function parallax_init() {
		if(jQuery().omParallax) {
			$('.om-parallax').omParallax();
		}
	}
	
	/*******************************/
	
	function testimonials_init() 	{
		jQuery('.vc_om-testimonials.vc_om-mode-box').each(function(){
			
			var $items=jQuery(this).find('.vc_om-testimonials-items');
			if($items.find('.om-item').length > 1) {
	
				var args={
					speed: 200,
					next: jQuery(this).find('.vc_om-testimonials-controls .om-next'),
					prev: jQuery(this).find('.vc_om-testimonials-controls .om-prev'),
					fadePrev: true
				};
				if(jQuery(this).data('timeout') > 0)
					args.timeout = jQuery(this).data('timeout');
				if(jQuery(this).data('pause') == 1)
					args.pause = 1;
	
				$items.omSlider(args);
				
			}
			
		});
	}
	
	/*******************************/
	
	function logos_init() {
		var is_rtl=$('body').hasClass('rtl');
		$('.vc_om-logos.vc_om-logos-layout-carousel').each(function(){
			
			var $this=$(this);
			var $inner=$('.vc_om-logos-inner',$this);
			var $container=$('.vc_om-logos-container',$this);
			$this.data('first-item',0);
			var total=$container.children('.vc_om-logos-item').length;
			
			var $controls=$('<div class="vc_om-logos-controls" />');
			var $prev=$('<a href="#" class="om-prev" />').appendTo($controls);
			var $next=$('<a href="#" class="om-next" />').appendTo($controls);
			$controls.appendTo(this);

			$next.click(function(){
				$container.stop(true,true);
				var container_w=0;
				$container.children('.vc_om-logos-item').each(function(){container_w+=$(this).width()});
				var vport=$inner.width();
				var ml=parseInt( ( is_rtl ? $container.css('right') : $container.css('left') ) );
				if(isNaN(ml))
					ml=0;

				if((ml + container_w) < vport)
					return false;

				var first=$this.data('first-item');
				var n=1;
				var m=$container.children('.vc_om-logos-item:eq('+first+')').width();
				
				for(var i=first+1; i<total; i++) {
					if((ml - m + container_w) < vport)
						break;
					var w=$container.children('.vc_om-logos-item:eq('+i+')').width();
					if(w+m < vport) {
						m+=w;
						n++;
					} else {
						break;
					}
				}
				
				$this.data('first-item', first+n);

				ml-=m;
				var args;
				if(is_rtl) {
					args={right: ml+'px'};
				} else {
					args={left: ml+'px'};
				}
				$container.animate(args, 300);
				
				
				return false;
			});
			
			$prev.click(function(){
				$container.stop(true,true);
				var first=$this.data('first-item');
				if(first <= 0)
					return false;
					
				var ml=parseInt( ( is_rtl ? $container.css('right') : $container.css('left') ) );
				if(isNaN(ml))
					ml=0;

				var n=1;
				var m=$container.children('.vc_om-logos-item:eq('+(first-1)+')').width();
				var vport=$inner.width();

				for(var i=first-2; i>=0; i--) {
					var w=$container.children('.vc_om-logos-item:eq('+i+')').width();
					if(m+w < vport) {
						m+=w;
						n++;
					} else {
						break;
					}
				}
				
				$this.data('first-item', first-n);

				ml+=m;
				var args;
				if(is_rtl) {
					args={right: ml+'px'};
				} else {
					args={left: ml+'px'};
				}
				$container.animate(args, 300);
				
				
				return false;
			});
			
		});
	}

	/*******************************/

	function blog_posts_init() {
		if(jQuery().isotopeOm) {
			$('.blog-posts.layout-shortcode').each(function() {
				
				var $container=$(this).find('section');
				
		    var args={ 
			    itemSelector: '.blog-post',
			    layoutMode: 'masonry',
			    transitionDuration: 0
			  };
  
				$container.isotopeOm(args);
				
				$container.find('img').load(function(){
					$container.isotopeOm('layout');
				});
	
	    });
		}
	}
	
	/*******************************/
	
	function agenda_init() {
		$('.vc_om-agenda.om-speakers-display .om-agenda-item-speakers-inner').each(function(){
			var $popup=$('<div class="om-agenda-item-speaker-photo-popup" />').appendTo(this);
			var timer;
			$('.om-agenda-item-speaker', this).each(function(){
				var $speaker=$(this);
				var $img=$('.om-agenda-item-speaker-photo img',this);
				if($img.length) {
					$('<img/>')[0].src = $img.attr('src'); //preload image
					$speaker.mouseenter(function(){
						$popup.empty().append($img.clone());
						clearTimeout(timer);
						$popup.addClass('om-active');
					}).mouseleave(function(){
						$popup.removeClass('om-active');
						timer=setTimeout(function(){
							$popup.empty();
						},220);
					});
				}
			});
		});
		
		$('.vc_om-agenda.om-description-expand .om-agenda-item-link.om-agenda-item-expand').click(function(){
			var $container=$(this).parents('.om-agenda-inner');
			if($container.data('isotopeOm')) {
				$(this).parent().find('.om-agenda-item-description-more').stop(true).toggle();
				$container.isotopeOm('layout');
			} else {
				$(this).parent().find('.om-agenda-item-description-more').stop(true).slideToggle(200);
			}
		});
		
		if(jQuery().isotopeOm) {
			$('.vc_om-agenda.om-layout-grid').each(function() {
				var $container=$('.om-agenda-inner',this);
				if(
					($(this).hasClass('om-columns-2') && $container.find('.om-agenda-day').length <= 2) ||
					($(this).hasClass('om-columns-3') && $container.find('.om-agenda-day').length <= 3)
				) {
					return;
				}
		    var args={
			    itemSelector: '.om-agenda-day',
			    layoutMode: 'masonry',
			    transitionDuration: 0
			  };
				$container.isotopeOm(args);

	    });
		}
		
	}
		
});

/* Toggle/FAQ
 ---------------------------------------------------------- */
if ( typeof window[ 'vc_toggleBehaviour' ] !== 'function' ) {
	window.vc_toggleBehaviour = function ( $el ) {
		var event = function ( e ) {
			e && e.preventDefault && e.preventDefault();
			var title = jQuery( this );
			var element = title.closest( '.vc_toggle' );
			var content = element.find( '.vc_toggle_content' );
			if ( element.hasClass( 'vc_toggle_active' ) ) {
				content.slideUp( {
					duration: 200,
					complete: function () {
						element.removeClass( 'vc_toggle_active' );
					}
				} );
			} else {
				element.addClass( 'vc_toggle_active' );
				setTimeout(function(){
					content.slideDown( {
						duration: 200,
						complete: function () {
							
						}
					} );
				}, 210);
			}
		};
		if ( $el ) {
			if ( $el.hasClass( 'vc_toggle_title' ) ) {
				$el.unbind( 'click' ).click( event );
			} else {
				$el.find( ".vc_toggle_title" ).unbind( 'click' ).click( event );
			}
		} else {
			jQuery( ".vc_toggle_title" ).unbind( 'click' ).on( 'click', event );
		}
		
		jQuery('.vc_toggle.vc_toggle_active').each(function(){
			jQuery(this).find( '.vc_toggle_content').show();
		});

	}
}

/* Waypoints magic (animation)
 ---------------------------------------------------------- */
if (typeof window['vc_waypoints'] !== 'function') {
	window.vc_waypoints = function () {

		var animation_enabled=true;
		if(jQuery('html').hasClass('touch') && jQuery('body').hasClass('om-no-animation-on-touch')) {
			jQuery('.wpb_animate_when_almost_visible:not(.wpb_start_animation)').addClass('om-disable-wpb-animation').removeClass('wpb_animate_when_almost_visible');
		} else {
			if ("undefined" != typeof jQuery.fn.waypoint) {
				jQuery('.wpb_animate_when_almost_visible:not(.wpb_start_animation)').each(function () {
					var delay = parseInt(jQuery(this).data('animation-delay'));
					var $this = jQuery(this);
					jQuery(this).waypoint(function () {
						if (delay) {
							setTimeout(function () {
								$this.addClass('wpb_start_animation animated');
							}, delay);
						} else {
							$this.addClass('wpb_start_animation animated');
						}
					}, {
						/*offset: 'bottom-in-view',*/
						offset: '83%',
						triggerOnce: true
					});
				});
			}
		}
	}
}

/* vc_line_chart */
if ( 'function' !== typeof( window.vc_line_charts ) ) {
	window.vc_line_charts = function ( model_id ) {
		var selector = '.vc_line-chart';
		if ( 'undefined' !== typeof( model_id ) ) {
			selector = '[data-model-id="' + model_id + '"] ' + selector;
		}
		jQuery( selector ).vcLineChart();
		
		if(jQuery.waypoints) { 
			jQuery(selector).each(function(){
				var $this=jQuery(this);
				$this.waypoint(function(){
					$this.data('chart').render();
				},{
					offset: '100%',
					triggerOnce: true
				});
			});
		}
		
	};
}