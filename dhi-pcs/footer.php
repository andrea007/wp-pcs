			<?php
				$subfooter = get_option( 'eventerra_subfooter_text' );
				$footer_columns_layout = get_option( 'eventerra_footer_layout' );
				$footer_social_icons = ( get_option( 'eventerra_social_icons_footer' ) == 'true' ) ? eventerra_are_social_icons_set() : false;
				
				if( $footer_columns_layout == '1v4-1v4-1v4-1v4')
					$footer_columns=array(
						'footer-column-1'=>'om-one-fourth',
						'footer-column-2'=>'om-one-fourth',
						'footer-column-3'=>'om-one-fourth',
						'footer-column-4'=>'om-one-fourth',
					);
				elseif( $footer_columns_layout == '2v4-1v4-1v4')
					$footer_columns=array(
						'footer-column-1'=>'om-one-half',
						'footer-column-2'=>'om-one-fourth',
						'footer-column-3'=>'om-one-fourth',
					);
				elseif( $footer_columns_layout == '1v4-1v4-2v4')
					$footer_columns=array(
						'footer-column-1'=>'om-one-fourth',
						'footer-column-2'=>'om-one-fourth',
						'footer-column-3'=>'om-one-half',
					);
				elseif( $footer_columns_layout == '1v3-1v3-1v3')
					$footer_columns=array(
						'footer-column-1'=>'om-one-third',
						'footer-column-2'=>'om-one-third',
						'footer-column-3'=>'om-one-third',
					);
				elseif( $footer_columns_layout == '2v3-1v3')
					$footer_columns=array(
						'footer-column-1'=>'om-two-third',
						'footer-column-2'=>'om-one-third',
					);
				elseif( $footer_columns_layout == '1v3-2v3')
					$footer_columns=array(
						'footer-column-1'=>'om-one-third',
						'footer-column-2'=>'om-two-third',
					);
				elseif( $footer_columns_layout == '1v2-1v2')
					$footer_columns=array(
						'footer-column-1'=>'om-one-half',
						'footer-column-2'=>'om-one-half',
					);
				else
					$footer_columns=array(
						'footer-column-1'=>'om-full',
					);
				$is_footer_sidebars=false;
				foreach($footer_columns as $id=>$class) {
					if ( is_active_sidebar($id) ) {
						$is_footer_sidebars=true;
						break;
					}
				}
				
				if($is_footer_sidebars || $subfooter || $footer_social_icons) { ?>
				
					<footer>
						<div class="footer">

							<?php if($is_footer_sidebars) { ?>
								<div class="footer-widgets clearfix">
									<div class="om-columns">
										<?php
											foreach($footer_columns as $id=>$class) {
												echo '<div class="footer-widgets-column om-column '.$class.'">';
												dynamic_sidebar( $id );
												echo '</div>';
											}
										?>
									</div>
								</div>
							<?php } ?>
	
							
						</div>
					</footer>
					
				<?php } ?>
			</div><?php /* div.content-footer */ ?>

			<?php if($subfooter || $footer_social_icons) { ?>
				<div class="sub-footer<?php echo (($subfooter!='')?' with-sub-footer-text':' no-sub-footer-text'); ?>">
					<?php if($subfooter!='') { echo '<div class="sub-footer-text">'.wp_kses_post($subfooter).'</div>'; } ?>
					<?php	if($footer_social_icons) { echo '<div class="footer-social-icons">'; eventerra_the_social_icons(); echo '</div>'; } ?>
				</div>
			<?php } ?>

		</div>
	</div>
<?php wp_footer(); ?>
</body>
</html>