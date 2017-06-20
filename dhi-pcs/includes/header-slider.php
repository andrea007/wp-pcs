<?php

	if($slider) {
		$slider_html_safe=eventerra_display_page_slider($slider, false);
		if($slider_html_safe) {
			?>
			<div class="header-slider layout-<?php echo esc_attr($slider['layout']) ?> clearfix">
				<?php echo $slider_html_safe; ?>
			</div>
			<?php
		}
	}