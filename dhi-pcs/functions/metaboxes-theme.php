<?php

function eventerra_metabox_sidebar($field, $meta, $post_id) {
	
	$output='';
	
	$output.= '
		<tr>
			<th style="width:25%">
				<label for="'.$field['id'].'"><strong>'.$field['name'].'</strong>
				<div class="howto">'. $field['desc'].'</div>
			</th>
			<td>
				<select name="'.$field['id'].'" id="'.$field['id'].'"/><option value="">'.esc_html__('Main Sidebar','eventerra').'</option>
	';
	$sidebars=get_option("eventerra_extra_sidebars");
	if(is_array($sidebars)) {
		foreach($sidebars as $k=>$v) {
			$output.='<option value="'.$k.'" '.($meta==$k?' selected="selected"':'').'>'.' '.esc_html($v).'</option>';
		}
	}
	$output .='			
				</select>
			</td>
		</tr>
	';
	
	return $output;
			
}
add_filter('omfw_metabox_sidebar', 'eventerra_metabox_sidebar', 10, 3);