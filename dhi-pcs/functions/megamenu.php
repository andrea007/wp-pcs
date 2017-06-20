<?php

/**
 * Backend Part
 */

class eventerra_Menu_Walker_Edit extends Walker_Nav_Menu {
	
	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker_Nav_Menu::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {}
	
	/**
	 * Start the element output.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		ob_start();
		$item_id_escaped = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = get_the_title( $original_object->ID );
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id_escaped == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( esc_html__( '%s (Invalid)', 'eventerra' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( esc_html__('%s (Pending)', 'eventerra'), $item->title );
		}

		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

		?>
		<li id="menu-item-<?php echo $item_id_escaped; ?>" class="<?php echo implode(' ', $classes ); ?>">
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu"<?php echo ( 0 == $depth ? ' style="display: none;"' : '' ) ; ?>><?php esc_html_e( 'sub item', 'eventerra' ); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id_escaped,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'eventerra'); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id_escaped,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'eventerra'); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo $item_id_escaped; ?>" title="<?php esc_attr_e('Edit Menu Item', 'eventerra'); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id_escaped == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id_escaped, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id_escaped ) ) );
						?>"><?php esc_html_e( 'Edit Menu Item', 'eventerra' ); ?></a>
					</span>
				</dt>
			</dl>

			<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo $item_id_escaped; ?>">
				<?php if( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo $item_id_escaped; ?>">
							<?php esc_html_e( 'URL', 'eventerra' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo $item_id_escaped; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id_escaped; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="edit-menu-item-title-<?php echo $item_id_escaped; ?>">
						<?php esc_html_e( 'Navigation Label', 'eventerra' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo $item_id_escaped; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id_escaped; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="description description-thin">
					<label for="edit-menu-item-attr-title-<?php echo $item_id_escaped; ?>">
						<?php esc_html_e( 'Title Attribute', 'eventerra' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id_escaped; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id_escaped; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo $item_id_escaped; ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id_escaped; ?>" value="_blank" name="menu-item-target[<?php echo $item_id_escaped; ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php esc_html_e( 'Open link in a new window/tab', 'eventerra' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo $item_id_escaped; ?>">
						<?php esc_html_e( 'CSS Classes (optional)', 'eventerra' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo $item_id_escaped; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id_escaped; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo $item_id_escaped; ?>">
						<?php esc_html_e( 'Link Relationship (XFN)', 'eventerra' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo $item_id_escaped; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id_escaped; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo $item_id_escaped; ?>">
						<?php esc_html_e( 'Description', 'eventerra' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo $item_id_escaped; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id_escaped; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'eventerra'); ?></span>
					</label>
				</p>
				
				<p class="field-om_icon hide-if-no-js description description-wide">
					<label for="edit-menu-item-om_icon-<?php echo $item_id_escaped; ?>">
						<?php esc_html_e( 'Icon', 'eventerra' ); ?><br />
						<select id="edit-menu-item-om_icon-<?php echo $item_id_escaped; ?>" class="widefat edit-menu-item-om_icon" name="menu-item-om_icon[<?php echo $item_id_escaped; ?>]">
							 <?php echo eventerra_get_icons_options_list($item->om_icon) ?>
						</select>
					</label>
				</p>
				
				<p class="field-megamenu description description-wide">
					<label for="edit-menu-item-megamenu-<?php echo $item_id_escaped; ?>">
						<input type="hidden" name="menu-item-megamenu[<?php echo $item_id_escaped; ?>]" value="0" />
						<input type="checkbox" id="edit-menu-item-megamenu-<?php echo $item_id_escaped; ?>" value="1" name="menu-item-megamenu[<?php echo $item_id_escaped; ?>]"<?php checked( $item->megamenu, '1' ); ?> />
						<?php esc_html_e( 'Enable MegaMenu for nested items', 'eventerra' ); ?>
						<script>
							jQuery(function($){
								var change=function(obj){
									if($(obj).is(':checked')) {
										$('#edit-menu-item-megamenu_hide_titles-<?php echo $item_id_escaped; ?>-wrapper').show();
									} else {
										$('#edit-menu-item-megamenu_hide_titles-<?php echo $item_id_escaped; ?>-wrapper').hide();
									}
								}
								$('#edit-menu-item-megamenu-<?php echo $item_id_escaped; ?>').change(function(){
									change(this);
								});
								change($('#edit-menu-item-megamenu-<?php echo $item_id_escaped; ?>'));
							});
						</script>
					</label>
				</p>

				<p class="field-megamenu_hide_titles description description-wide" id="edit-menu-item-megamenu_hide_titles-<?php echo $item_id_escaped; ?>-wrapper">
					<label for="edit-menu-item-megamenu_hide_titles-<?php echo $item_id_escaped; ?>">
						<input type="hidden" name="menu-item-megamenu_hide_titles[<?php echo $item_id_escaped; ?>]" value="0" />
						<input type="checkbox" id="edit-menu-item-megamenu_hide_titles-<?php echo $item_id_escaped; ?>" value="1" name="menu-item-megamenu_hide_titles[<?php echo $item_id_escaped; ?>]"<?php checked( $item->megamenu_hide_titles, '1' ); ?> />
						<?php esc_html_e( 'Hide MegaMenu column titles', 'eventerra' ); ?>
					</label>
				</p>
				
				<p class="field-move hide-if-no-js description description-wide">
					<label>
						<span><?php esc_html_e( 'Move', 'eventerra' ); ?></span>
						<a href="#" class="menus-move-up"><?php esc_html_e( 'Up one', 'eventerra' ); ?></a>
						<a href="#" class="menus-move-down"><?php esc_html_e( 'Down one', 'eventerra' ); ?></a>
						<a href="#" class="menus-move-left"></a>
						<a href="#" class="menus-move-right"></a>
						<a href="#" class="menus-move-top"><?php esc_html_e( 'To the top', 'eventerra' ); ?></a>
					</label>
				</p>

				<div class="menu-item-actions description-wide submitbox">
					<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( esc_html__('Original: %s', 'eventerra'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id_escaped; ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id_escaped,
							),
							admin_url( 'nav-menus.php' )
						),
						'delete-menu_item_' . $item_id_escaped
					); ?>"><?php esc_html_e( 'Remove', 'eventerra' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item_id_escaped; ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id_escaped, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
						?>#menu-item-settings-<?php echo $item_id_escaped; ?>"><?php esc_html_e('Cancel', 'eventerra'); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id_escaped; ?>]" value="<?php echo $item_id_escaped; ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id_escaped; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id_escaped; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id_escaped; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id_escaped; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id_escaped; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}

}

class eventerra_Mega_Menu {
	
	protected $fields=array(
		'megamenu',
		'megamenu_hide_titles',
		'om_icon',
	);

	function __construct() {
		
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'walker_class_name' ) );
		
		add_action( 'wp_update_nav_menu_item', array( $this, 'update_custom_fields' ), 10, 3); //, $menu_id, $menu_item_db_id, $args;
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'get_custom_fields' ) );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'custom_css' ) );
	}

	function walker_class_name( $className ){
		return 'eventerra_Menu_Walker_Edit';
	}
	
	/**
	 * Custom CSS
	 */
	 
	function custom_css($hook) {
		if ( 'nav-menus.php' != $hook ) {
			return;
		}
	  wp_enqueue_style( 'eventerra-megamenu', EVENTERRA_TEMPLATE_DIR_URI . '/admin/css/megamenu.css' );
	}

	/**
	 * Save fields in the database
	 */
	
	function update_custom_fields( $menu_id, $menu_item_db_id, $args ) {
		
		foreach($this->fields as $field) {
			if ( isset( $_REQUEST['menu-item-'.$field] ) && is_array( $_REQUEST['menu-item-'.$field] ) ) {
				update_post_meta( $menu_item_db_id, '_menu_item_'.$field, $_REQUEST['menu-item-'.$field][$menu_item_db_id] );
			}
		}
	}	

	/**
	 * Get fields from the database
	 */
	 
	function get_custom_fields( $menu_item ) {
		foreach($this->fields as $field) {
			$menu_item->$field = get_post_meta( $menu_item->ID, '_menu_item_'.$field, true );
		}
		return $menu_item;
	}
	
}

/**
 * FrontEnd Part
 */
 
function eventerra_megamenu_nav_menu ($items) {
	
	$hide_titles=array();
	
	if(is_array($items)) {
		foreach($items as $item) {
			if ($item->menu_item_parent == 0) {
				$megamenu = isset($item->megamenu) ? $item->megamenu : get_post_meta( $item->ID, '_menu_item_megamenu', true );
				if($megamenu) {
					$item->classes[] = 'megamenu-enable';
					
					$megamenu_hide_titles = isset($item->megamenu_hide_titles) ? $item->megamenu_hide_titles : get_post_meta( $item->ID, '_menu_item_megamenu_hide_titles', true );
					if($megamenu_hide_titles) {
						$item->classes[] = 'megamenu-hide-titles';
						$hide_titles[]=$item->ID;
					}
				}
			}
		}
	}
	
	if(!empty($hide_titles)) {
		foreach($items as $item) {
			if(in_array($item->menu_item_parent, $hide_titles))
				$item->hide_item=true;
		}
	}
	
	return $items;    
}

function eventerra_megamenu_nav_menu_link_attr ($atts, $item) {
	
	$icon = isset($item->om_icon) ? $item->om_icon : get_post_meta( $item->ID, '_menu_item_om_icon', true );
	
	if($icon) {
		if(isset($atts['class']))
			$atts['class'].=' ';
		else
			$atts['class']='';
			
		$atts['class'].=eventerra_icon_classes_before($icon);
	}
	
	return $atts;
}

function eventerra_megamenu_walker_nav_menu_start_el($item_output, $item, $depth, $args) {
	
	if(isset($item->hide_item) && $item->hide_item)
		$item_output='';
	return $item_output;
}
/**
 * Initialization
 */
 
if( get_option( 'eventerra_menu_megamenu_active') == 'true' ) {
	
	$GLOBALS['eventerra_Mega_Menu'] = new eventerra_Mega_Menu();
	
	add_filter('wp_nav_menu_objects', 'eventerra_megamenu_nav_menu');
	add_filter('nav_menu_link_attributes', 'eventerra_megamenu_nav_menu_link_attr', 10, 3);
	add_filter('walker_nav_menu_start_el', 'eventerra_megamenu_walker_nav_menu_start_el', 10, 4);
	
	
}
