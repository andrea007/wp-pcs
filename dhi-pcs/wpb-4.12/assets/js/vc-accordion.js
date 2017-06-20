jQuery(function($){
	
	if(typeof($.fn.vcAccordion) != 'function') {
		return;
	}
	
	var Accordion = $.fn.vcAccordion.Constructor;

	if(typeof($.fn.vcAccordion.Constructor) != 'function') {
		return;
	}

	/**
	 * Show accordion panel
	 */
	Accordion.prototype.show = function () {
		var $target, that, $targetContent;

		that = this;
		$target = that.getTarget();
		$targetContent = that.getTargetContent();

		// if showed no need to do anything
		if ( that.isActive() ) {
			return;
		}

		if ( that.isAnimated() ) {
			
			var $container=that.getContainer();
			var $tta=that.getContainer().find('.vc_tta');
			
			if($tta.hasClass('vc_tta-tabs') && $tta.hasClass('vc_tta-tabs-position-top') && $container.data('vc_delayed_hide')) {
				
				var data=$container.data('vc_delayed_hide');
				$container.data('vc_delayed_hide', false);
				var $panels=$('.vc_tta-panels',$tta);
				$panels.css('height',$panels.height());

				data.target.addClass( that.animatingClass );
				data.target.removeClass( that.activeClass );
				
				that.triggerEvent( 'beforeShow.vc.accordion' );		
				$target.addClass( that.animatingClass );
				$target.addClass( that.activeClass );
				that.changeLocationHash();
				that.triggerEvent( 'show.vc.accordion' );
				
				$targetContent.css( {
					position: 'absolute', // Optional if #myDiv is already absolute
					visibility: 'hidden',
					display: 'block'
				} );
				var newHeight = $targetContent.outerHeight();

				data.targetContent.css( {
					position: 'absolute',
					display: 'block',
					transform: 'translateX(0)'
				} );
				
				if(data.index < that.getIndex()) {

					$targetContent.attr( 'style', '' ).css( {
						display: 'block',
						position: 'absolute',
						transform: 'translateX(100%)'
					} );
					setTimeout(function(){
						data.targetContent.addClass( 'om_vc_animating' );
						$targetContent.addClass( 'om_vc_animating' );
	
						setTimeout(function(){
							data.targetContent.css( {
								transform: 'translateX(-100%)'
							} );
							$targetContent.css( {
								transform: 'translateX(0)'
							} );
						}, 10);						
						
					}, 10);
				} else {
					$targetContent.attr( 'style', '' ).css( {
						display: 'block',
						position: 'absolute',
						transform: 'translateX(-100%)'
					} );
					setTimeout(function(){
						data.targetContent.addClass( 'om_vc_animating' );
						$targetContent.addClass( 'om_vc_animating' );
	
						setTimeout(function(){
							data.targetContent.css( {
								transform: 'translateX(100%)'
							} );
							$targetContent.css( {
								transform: 'translateX(0)'
							} );
						}, 10);						
						
					}, 10);
				}

				$panels.animate({height: newHeight+'px'}, that.getAnimationDurationMilliseconds()+100, function(){
					data.target.removeClass( that.animatingClass );

					$target.removeClass( that.animatingClass );
					that.triggerEvent( 'afterShow.vc.accordion' );					
					
					data.targetContent.attr( 'style', '' ).removeClass( 'om_vc_animating' );
					$targetContent.attr( 'style', '' ).removeClass( 'om_vc_animating' );
					
					$panels.css('height','auto');
				});
				
			} else {
				
				that.triggerEvent( 'beforeShow.vc.accordion' );
				$target
					.queue( function ( next ) {
						$targetContent.css( {
							position: 'absolute', // Optional if #myDiv is already absolute
							visibility: 'hidden',
							display: 'block'
						} );
						var height = $targetContent.height();
						$targetContent.data( 'vcHeight', height );
						$targetContent.attr( 'style', '' );
						next();
					} )
					.queue( function ( next ) {
						$targetContent.height( 0 );
						$targetContent.css( {
							'padding-top': 0,
							'padding-bottom': 0
						} );
						next();
					} )
					.queue( function ( next ) {
						$target.addClass( that.animatingClass );
						$target.addClass( that.activeClass );
						that.changeLocationHash();
						that.triggerEvent( 'show.vc.accordion' );
						next();
					} )
					.queue( function ( next ) {
						var height = $targetContent.data( 'vcHeight' );
						$targetContent.animate( { 'height': height }, that.getAnimationDurationMilliseconds(), function(){
							$target.removeClass( that.animatingClass );
							$targetContent.attr( 'style', '' );
							that.triggerEvent( 'afterShow.vc.accordion' );
						} );
						$targetContent.css( {
							'padding-top': '',
							'padding-bottom': ''
						} );
						next();
					} );
					
			}
			
		} else {
			$target.addClass( that.activeClass );
			that.triggerEvent( 'show.vc.accordion' );
		}
	};

	/**
	 * Hide accordion panel
	 */
	Accordion.prototype.hide = function () {
		var $target, that, $targetContent;

		that = this;
		$target = that.getTarget();
		$targetContent = that.getTargetContent();

		// if hidden no need to do anything
		if ( ! that.isActive() ) {
			return;
		}

		if ( that.isAnimated() ) {
			
			var $tta=that.getContainer().find('.vc_tta');
			
			if($tta.hasClass('vc_tta-tabs') && ( ( $tta.hasClass('vc_tta-tabs-position-top') && $tta.find('.vc_tta-tabs-container').is(':visible') ) || $tta.hasClass('vc_tta-pageable') ) ) {
				
				that.triggerEvent( 'hide.vc.accordion' );
				
				that.getContainer().data('vc_delayed_hide', {
					index: that.getIndex(),
					target: $target,
					targetContent: $targetContent
				});
				
			} else {
				that.triggerEvent( 'beforeHide.vc.accordion' );
				$target
					.queue( function ( next ) {
						$target.addClass( that.animatingClass );
						$target.removeClass( that.activeClass );
						that.triggerEvent( 'hide.vc.accordion' );
						next();
					} )
					.queue( function ( next ) {
						var height = $targetContent.height();
						$targetContent.height( height );
						next();
					} )
					.queue( function ( next ) {
						$targetContent.animate( { 'height': 0 }, that.getAnimationDurationMilliseconds(), function(){
							$target.removeClass( that.animatingClass );
							$targetContent.attr( 'style', '' );
							that.triggerEvent( 'afterHide.vc.accordion' );
						} );
						$targetContent.css( {
							'padding-top': 0,
							'padding-bottom': 0
						} );
						next();
					} );
			}
		} else {
			$target.removeClass( that.activeClass );
			that.triggerEvent( 'hide.vc.accordion' );
		}
	};
});