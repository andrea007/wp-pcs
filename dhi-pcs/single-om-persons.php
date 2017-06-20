<?php
$page_slider=eventerra_get_page_slider($post->ID);
eventerra_custom_sidebar_setup($post->ID);
eventerra_wpb_detect($post);
get_header();

the_post();
$has_post_thumbnail=has_post_thumbnail();

?>
	<div class="content">
		<div class="content-columns-wrapper clearfix-a">
			<div class="content-column-content">
				<div class="content-columns-inner">
					<article>		
						<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
							<div class="om-speaker-single-card clearfix-a">
								<?php
									if($has_post_thumbnail){
										$img=eventerra_get_post_thumbnail(array(
											'srcset' => array(
												'media-one-third-square',
												'media-mobile-square',
											),
											'sizes'=>'(max-width: 768px) 728px, {media-one-third-square}px',
										));
										echo '<div class="om-speaker-single-photo">'.$img.'</div>';
									} else {
										echo '<div class="om-speaker-single-photo om-empty"></div>';
									}
								?>
								<div class="om-speaker-single-info">
									<?php
										echo '<div class="om-speaker-single-name-post">';
											echo '<h1 class="om-speaker-single-name">' . the_title('','',false) . '</h1>';
											$speaker_post=get_post_meta($post->ID, 'om_persons_post', true);
											if($speaker_post != '') {
												echo '<div class="om-speakers-post">'.esc_html($speaker_post).'</div>';
											}
										echo '</div>';
										
										$contact_icons=function_exists('ompn_persons_contact_icons') ? ompn_persons_contact_icons() : array();
										$contacts=array();
										foreach($contact_icons as $k=>$v) {
											$icon=get_post_meta($post->ID, $v, true);
											if($icon != '') {
												$contacts[$k]=$icon;
											}
										}
										if(!empty($contacts)) {
											echo '<div class="om-speaker-single-contacts clearfix-a">';
											foreach($contacts as $k=>$v) {
												echo '<div class="om-item"><a href="'.esc_url(($k == 'envelope' ? 'mailto:' : '').($k == 'skype' ? 'skype:' : '').$v, array_merge(wp_allowed_protocols(),array('skype'))).'" class="om-speakers-contact-icon om-'.$k.'" target="_blank"><i class="omfi omfi-'.$k.'"></i></a></div>';
											}
											echo '</div>';
										}
									?>
								</div>
							</div>
							<?php
							if(get_option('eventerra_other_speakers_hide') != 'true') {
								$all_speakers=get_posts( array(
									'posts_per_page'   => -1,
									'orderby'          => 'menu_order',
									'order'            => 'ASC',
									'exclude'          => $post->ID,
									'post_type'        => 'om-persons',
								) );
							} else {
								$all_speakers=false;
							}
							?>
							<div class="om-speaker-single-content clearfix-a<?php echo ( empty($all_speakers) ? ' no-other-speakers' : '' ) ?>">
								<div class="om-speaker-single-desc">
									<?php the_content(); ?>
								</div>
								<?php if(!empty($all_speakers)) { ?>
									<div class="om-speaker-single-sidebar clearfix-a">
									<h3 class="om-speaker-single-sidebar-title"><?php echo ( get_option('eventerra_other_speakers_title') === false ? esc_html_e('Other Speakers', 'eventerra') : esc_html(get_option('eventerra_other_speakers_title')) ) ?></h3>
									<?php
										foreach($all_speakers as $speaker) {
											if ( has_post_thumbnail($speaker->ID) ) {
												$img=eventerra_get_post_thumbnail('media-one-fourth-square', array('post_id' => $speaker->ID));
												echo '<div class="om-item"><a href="'.esc_url(get_permalink($speaker->ID)).'">'.$img.'<span class="om-item-title">'.get_the_title($speaker->ID).'</span></a></div>';
											}
										}
									?>
									</div>
								<?php } ?>
							</div>
						</div>
					</article>

					<?php eventerra_wp_link_pages();	?>
					
					<?php get_template_part( 'includes/comments' ); ?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>