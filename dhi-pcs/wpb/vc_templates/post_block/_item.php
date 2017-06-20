<?php
$block = $block_data[0];
$settings = $block_data[1];
$link_setting = empty($settings[0]) ? '' : $settings[0];
?>
<?php if($block === 'title'): ?>
<h4 class="post-title">
    <?php echo empty($link_setting) || $link_setting!='no_link' ? $this->getLinked($post, $post->title, $link_setting, 'link_title') : $post->title ?>
</h4>
<?php elseif($block === 'image' && !empty($post->thumbnail)): ?>
<div class="post-thumb">
<?php
	if( empty($link_setting) || $link_setting!='no_link' ) {
		if ( $link_setting === 'link_post' || empty($link_setting) ) {
			echo eventerra_hover_extras($post->thumbnail, false, get_permalink( $post->id ), '', $this->link_target);
		} elseif ( $link_setting === 'link_image' && isset( $post->image_link ) && ! empty( $post->image_link ) ) {
			echo eventerra_hover_extras($post->thumbnail, $post->image_link, false, $this->link_target);
		} else {
			echo $post->thumbnail;
		}
	} else {
		echo $post->thumbnail;
	}
?>
</div>
<?php elseif($block === 'text'): ?>
<div class="entry-content">
    <?php echo empty($link_setting) || $link_setting==='excerpt' ?  $post->excerpt : $post->content; ?>
</div>
<?php elseif($block === 'link'): ?>
<div class="post-readmore">
<?php echo eventerra_more_link_tpl(array('href' => $post->link, 'class' => 'vc_read_more', 'attr' => $this->link_target)); ?>
</div>
<?php endif; ?>