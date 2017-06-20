<?php
add_filter('the_content', 'eventerra_content_remove_first_video', 99999);
get_template_part( 'includes/post-footer' );
remove_filter('the_content', 'eventerra_content_remove_first_video', 99999);