<?php
eventerra_custom_sidebar_setup(false);
get_header();
?>
	<div class="content">
		<?php eventerra_tpl_page_title(false, esc_html__( 'Oops, something went wrong&hellip;', 'eventerra' )) ?>
		<div class="content-columns-wrapper clearfix-a">
			<div class="content-column-content">
				<div class="content-columns-inner">

					<div class="page-404-content">
						<div class="om-columns">
							<div class="om-column om-one-third">
								<p><img src="<?php echo EVENTERRA_TEMPLATE_DIR_URI . '/img/404.png'; ?>" style="padding-top:0.6em" /></p>
								<p>&nbsp;</p>
							</div>
							<div class="om-column om-one-third">
								<h3><?php esc_html_e('Here are some useful links', 'eventerra') ?></h3>
								<div class="sitemap small">
									<?php wp_nav_menu( array(
										'theme_location' => 'menu-404',
									) ) ?>
								</div>
							</div>
							<div class="om-column om-one-third">
								<h3><?php esc_html_e('Try to search', 'eventerra') ?></h3>
								<?php get_search_form(); ?>
							</div>
						</div>
					</div>
					
				</div>
			</div>
							
		</div>
	</div>
<?php get_footer(); ?>