<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

class omfw_Demo_Import {

	protected $settings = array(
		array(
			'demo_content_path'            => '',
			'wordpress_xml'                => false,
			'theme_options_dat'            => false,
			'widgets_dat'                  => false,
			'layer_slider_dat'             => false,
			'layer_slider_uploads_replace' => array(
				//'http://demo.olevmedia.net/amax/wp-content/uploads' => 'upload',
				//'http://demo.olevmedia.net/amax/wp-content/plugins/LayerSlider' => 'LS',
			),
			'rev_slider_dat'               => array( //'demo_content/home-slider.zip',
			),
			'uploads_replace_dir'          => false, // 'http://demo.olevmedia.net/mdwp/wp-content/uploads'
			'widgets_var_to_replace'       => array(), // array( array('sidebar' => '', 'widget_key' => '', 'widget_field' => ''), ... )
			'menus'                        => array( // pair "Menu Name" => "Location"
				//'Main' => 'primary-menu',
				//'Secondary' => 'secondary-menu',
			),
			'reading'                      => array( // Insert page title
				'front_page_title' => '',
				'posts_page_title' => '',
			),
			'menu_add_meta'                => array( // list of additional meta fields of the menu
				//'_menu_item_megamenu',
				//'_menu_item_megamenu_hide_titles',
				//'_menu_item_om_icon',
			),
		),
	);

	protected $current_settings; // current processing settings

	/**
	 * Constructor
	 */
	public function __construct( $settings ) {

		$new_settings = array();
		foreach ( $settings as $v ) {
			$new_settings[] = wp_parse_args( $v, $this->settings[0] );
		}
		$this->settings = $new_settings;

		add_action( 'admin_menu', array( $this, 'add_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'page_scripts' ) );
		add_action( 'wp_ajax_omfw_demo_import', array( $this, 'demo_import_ajax' ) );

	}

	public function add_page() {
		add_theme_page( esc_html__( 'Demo Content', 'om-theme-framework' ), esc_html__( 'Demo Content', 'om-theme-framework' ), 'manage_options', omfw_Framework::$demo_import_slug, array(
			$this,
			'page'
		) );
	}

	public function page() {

		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'One Click Demo Content Import', 'om-theme-framework' ); ?></h2>
			<?php if ( isset( $_GET['import_completed'] ) ) { ?>
				<br/>
				<div class="updated"><p style="font-size:130%">
						<em><b><?php esc_html_e( 'Import of demo content completed! Enjoy!', 'om-theme-framework' ) ?></b></em>
					</p></div>
			<?php } else { ?>
				<div class="updated">
					<div style="font-size:110%">
						<p><em style="font-size:120%"><?php esc_html_e( 'Please, note:', 'om-theme-framework' ) ?></em>
						</p>
						<ol>
							<li><?php echo wp_kses( __( 'Please, make sure that you have <b>installed all recommended for the Theme plugins</b> before importing demo content to get correctly working demo.', 'om-theme-framework' ), array( 'b' => array() ) ); ?></li>
							<li><?php printf( esc_html__( 'All settings which were made under "Theme Options" will be replaced with the "Demo". If you have already made any changes under "Theme Options" and want to save them, navigate to %s and export current settings.', 'om-theme-framework' ), '<a href="' . esc_url( omfw_Framework::theme_options_url() ) . '">' . esc_html__( 'Theme Options', 'om-theme-framework' ) . '</a>' ); ?></li>
							<li><?php echo wp_kses( __( '<b>All demo images are only for demo purpose.</b> A license requeried for some images from demo content in case you want to use it on the final website.', 'om-theme-framework' ), array( 'b' => array() ) ); ?></li>
							<li><?php printf( esc_html__( 'In case you want to remove all demo content and bring WordPress to the clean state you can use %s.', 'om-theme-framework' ), '<a href="https://wordpress.org/plugins/wordpress-reset/" target="_blank">' . esc_html__( 'WordPress Reset plugin', 'om-theme-framework' ) . '</a>' ); ?></li>
						</ol>
					</div>
				</div>
				<?php
				if ( count( $this->settings ) > 1 ) {
					echo '<h2 class="nav-tab-wrapper om-demo-import-sets-control">';
					foreach ( $this->settings as $id => $settings ) {
						echo '<a href="#om-demo-import-set-' . $id . '" class="nav-tab' . ( $id == 0 ? ' nav-tab-active' : '' ) . '">' . $settings['name'] . '</a>';
					}
					echo '</h2>';
				}

				foreach ( $this->settings as $id => $settings ) {
					?>
					<div class="om-demo-import-set"
					     id="om-demo-import-set-<?php echo esc_attr( $id ) ?>"<?php echo( $id > 0 ? ' style="display:none"' : '' ) ?>>
						<table class="form-table">
							<col width="1%"/>
							<col/>
							<tbody>
							<tr>
								<td><input type="button" class="button button-primary om_import_tool_start"
								           data-import-attachments="1" data-import-set="<?php echo esc_attr( $id ) ?>"
								           value="<?php esc_html_e( 'Import demo content WITH media files', 'om-theme-framework' ) ?>"/>
								</td>
								<td><?php esc_html_e( 'This will import all demo images, but it can take much time to complete an import.', 'om-theme-framework' ) ?></td>
							</tr>
							<tr>
								<td><input type="button" class="button button-primary om_import_tool_start"
								           data-import-attachments="0" data-import-set="<?php echo esc_attr( $id ) ?>"
								           value="<?php esc_html_e( 'Import demo content WITHOUT media files', 'om-theme-framework' ) ?>"/>
								</td>
								<td><?php esc_html_e( 'This is a quick import, which will import all pages, posts, menus, etc. without demo images.', 'om-theme-framework' ) ?></td>
							</tr>
							</tbody>
						</table>
					</div>
					<?php
				}
				?>

				<div id="om_import_status" style="margin:20px 0;display:none"><span class="spinner is-active"
				                                                                    id="om_import_spinner"
				                                                                    style="display:inline-block;float:none;margin-top:0;position:relative;top:-2px"></span><span
						id="om_import_status_text"></span></div>
				<div id="om_import_progress"
				     style="margin:20px 0;display:none;height:30px;line-height:30px;text-align:center;color:#fff;background:#aaa;position:relative;">
					<div id="om_import_progress_bar"
					     style="width:0;position:absolute;top:0;left:0;bottom:0;background:#2fc600"></div>
					<div id="om_import_progress_text" style="position:relative"></div>
				</div>
			<?php } ?>
		</div>
		<?php

		echo '<div id="om_status"></div>';

	}

	/*******************************************************/

	public function page_scripts( $hook ) {
		if ( 'appearance_page_' . omfw_Framework::$demo_import_slug != $hook ) {
			return;
		}
		wp_enqueue_script( 'omfw_demo_import', OMFW_URL . 'assets/js/demo-import.js' );
	}

	/*******************************************************/

	public function demo_import_ajax() {

		if ( ! current_user_can( 'manage_options' ) ) {
			die();
		}

		if ( get_magic_quotes_gpc() ) {
			$_POST = stripslashes_deep( $_POST );
		}

		if ( ! isset( $_POST['om_action'] ) ) {
			die();
		}

		if ( ! isset( $_POST['set'] ) ) {
			die();
		}

		if ( ini_get( 'max_execution_time' ) < 180 ) {
			set_time_limit( 180 );
		}

		$this->current_settings = $this->settings[ $_POST['set'] ];

		switch ( $_POST['om_action'] ) {

			case 'start':

				$data = array( 'error' => 0 );

				if ( ! file_exists( $this->current_settings['demo_content_path'] . $this->current_settings['wordpress_xml'] ) ) {
					$data['error'] = 1;
					wp_send_json( $data );
				}

				if ( ! class_exists( 'WXR_Parser' ) ) {
					require OMFW_PATH . '/libraries/wordpress-importer/parsers.php';
				}

				$parser      = new WXR_Parser();
				$import_data = $parser->parse( $this->current_settings['demo_content_path'] . $this->current_settings['wordpress_xml'] );
				unset( $parser );

				if ( is_wp_error( $import_data ) ) {
					$data['error'] = 1;
					wp_send_json( $data );
				}

				$data['common']      = array(
					'base_url' => esc_url( $import_data['base_url'] ),
				);
				$data['attachments'] = array();

				$author = (int) get_current_user_id();

				foreach ( $import_data['posts'] as $post ) {
					if ( 'attachment' == $post['post_type'] ) {

						$post_parent = (int) $post['post_parent'];

						$postdata = array(
							'import_id'      => $post['post_id'],
							'post_author'    => $author,
							'post_date'      => $post['post_date'],
							'post_date_gmt'  => $post['post_date_gmt'],
							'post_content'   => $post['post_content'],
							'post_excerpt'   => $post['post_excerpt'],
							'post_title'     => $post['post_title'],
							'post_status'    => $post['status'],
							'post_name'      => $post['post_name'],
							'comment_status' => $post['comment_status'],
							'ping_status'    => $post['ping_status'],
							'guid'           => $post['guid'],
							'post_parent'    => $post_parent,
							'menu_order'     => $post['menu_order'],
							'post_type'      => $post['post_type'],
							'post_password'  => $post['post_password']
						);

						$remote_url = ! empty( $post['attachment_url'] ) ? $post['attachment_url'] : $post['guid'];

						// try to use _wp_attached file for upload folder placement to ensure the same location as the export site
						// e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
						$postdata['upload_date'] = $post['post_date'];
						if ( isset( $post['postmeta'] ) ) {
							foreach ( $post['postmeta'] as $meta ) {
								if ( $meta['key'] == '_wp_attached_file' ) {
									if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta['value'], $matches ) ) {
										$postdata['upload_date'] = $matches[0];
									}
									break;
								}
							}
						}

						$postdata['postmeta'] = $post['postmeta'];

						$data['attachments'][] = array(
							'data'       => $postdata,
							'remote_url' => $remote_url,
						);

					}
				}

				$data['last_attachment_index'] = - 1;
				$variables_dump                = get_option( omfw_Framework::$theme_prefix . 'import_process_data_' . $this->current_settings['slug'] );
				if ( ! empty( $variables_dump ) && is_array( $variables_dump ) ) {
					if ( isset( $variables_dump['last_attachment_index'] ) ) {
						$data['last_attachment_index'] = $variables_dump['last_attachment_index'];
					}
				}

				wp_send_json( $data );

				break;

			case 'process_attachments':

				$ret = array( 'error' => 0 );

				if ( isset( $_POST['data']['attachments'] ) ) {

					if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
						define( 'WP_LOAD_IMPORTERS', true );
					}

					include_once OMFW_PATH . '/libraries/wordpress-importer/wordpress-importer.php';

					if ( class_exists( 'WP_Importer' ) && class_exists( 'omfw_WP_Import' ) ) { // check for main import class and wp import class

						$importer                    = new omfw_WP_Import();
						$importer->base_url          = $_POST['data']['common']['base_url'];
						$importer->fetch_attachments = true;

						$variables_dump = get_option( omfw_Framework::$theme_prefix . 'import_process_data_' . $this->current_settings['slug'] );
						if ( ! empty( $variables_dump ) && is_array( $variables_dump ) ) {
							$importer->post_orphans    = $variables_dump['post_orphans'];
							$importer->processed_posts = $variables_dump['processed_posts'];
							$importer->url_remap       = $variables_dump['url_remap'];
						}

						$last_attachment_index = $_POST['data']['first_attachment_index'];

						foreach ( $_POST['data']['attachments'] as $attachment ) {

							$post = $attachment['data'];

							$importer->post_orphans[ intval( $post['import_id'] ) ] = (int) $post['post_parent'];
							$post['post_parent']                                    = 0;

							$post_id = $importer->process_attachment( $post, $attachment['remote_url'] );

							if ( is_wp_error( $post_id ) ) {
								continue;
							}

							$importer->processed_posts[ intval( $post['import_id'] ) ] = (int) $post_id;

							// add/update post meta
							if ( ! empty( $post['postmeta'] ) ) {
								foreach ( $post['postmeta'] as $meta ) {
									$key   = $meta['key'];
									$value = false;

									if ( '_edit_last' == $key ) {
										continue;
									}

									if ( $key ) {
										// export gets meta straight from the DB so could have a serialized string
										if ( ! $value ) {
											$value = maybe_unserialize( $meta['value'] );
										}

										add_post_meta( $post_id, $key, $value );
									}
								}
							}

							$variables_dump['last_attachment_index'] = $last_attachment_index;
							$last_attachment_index ++;

						}

						$variables_dump['post_orphans']    = $importer->post_orphans;
						$variables_dump['processed_posts'] = $importer->processed_posts;
						$variables_dump['url_remap']       = $importer->url_remap;
						update_option( omfw_Framework::$theme_prefix . 'import_process_data_' . $this->current_settings['slug'], $variables_dump );


					}
				}

				wp_send_json( $ret );

				break;

			case 'process_other':

				$ret = array( 'error' => 0 );

				if ( ! file_exists( $this->current_settings['demo_content_path'] . $this->current_settings['wordpress_xml'] ) ) {
					$ret['error'] = 1;
					wp_send_json( $ret );
				}

				if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
					define( 'WP_LOAD_IMPORTERS', true );
				}

				include_once OMFW_PATH . '/libraries/wordpress-importer/wordpress-importer.php';

				if ( class_exists( 'WP_Importer' ) && class_exists( 'omfw_WP_Import' ) ) { // check for main import class and wp import class

					// Content

					$importer                    = new omfw_WP_Import();
					$importer->fetch_attachments = false;

					$variables_dump = get_option( omfw_Framework::$theme_prefix . 'import_process_data_' . $this->current_settings['slug'] );
					if ( ! empty( $variables_dump ) && is_array( $variables_dump ) ) {
						$importer->post_orphans    = $variables_dump['post_orphans'];
						$importer->processed_posts = $variables_dump['processed_posts'];
						$importer->url_remap       = $variables_dump['url_remap'];
					}

					add_filter( 'wp_import_post_meta', array( $this, 'modify_meta' ) );

					ob_start();
					$importer->import( $this->current_settings['demo_content_path'] . $this->current_settings['wordpress_xml'] );
					ob_end_clean();

					$this->import_menu_meta( $importer->processed_menu_items );

					update_option( omfw_Framework::$theme_prefix . 'import_process_data_' . $this->current_settings['slug'], false );


					// Menus to locations
					$locations = get_theme_mod( 'nav_menu_locations' );
					$menus     = wp_get_nav_menus();
					if ( $menus ) {
						foreach ( $menus as $menu ) {
							if ( isset( $this->current_settings['menus'][ $menu->name ] ) ) {
								$locations[ $this->current_settings['menus'][ $menu->name ] ] = $menu->term_id;
							}
						}
					}
					set_theme_mod( 'nav_menu_locations', $locations ); // set menus to locations


					// Import Theme Options
					if ( $this->current_settings['theme_options_dat'] && file_exists( $this->current_settings['demo_content_path'] . $this->current_settings['theme_options_dat'] ) ) {
						$s       = trim( omfw_Framework::read_file( $this->current_settings['demo_content_path'] . $this->current_settings['theme_options_dat'] ) );
						$options = json_decode( $s, true );
						if ( is_array( $options ) ) {

							/*							
							$wp_upload_dir=wp_upload_dir();
							if(isset($options['options'][omfw_Framework::$theme_prefix."default_title_bg_img"])) {
								$options['options'][omfw_Framework::$theme_prefix.'default_title_bg_img']=str_replace($this->current_settings['uploads_replace_dir'],$wp_upload_dir['baseurl'],$options['options'][omfw_Framework::$theme_prefix.'default_title_bg_img']);
							}
							*/

							if ( class_exists( 'omfw_Theme_Options' ) ) {
								omfw_Theme_Options::options_do_import_data( $options );
							}
						}
					}

					// Widgets
					if ( $this->current_settings['widgets_dat'] && file_exists( $this->current_settings['demo_content_path'] . $this->current_settings['widgets_dat'] ) ) {

						if ( ! function_exists( 'wie_available_widgets' ) ) {
							require OMFW_PATH . '/libraries/widgets-importer/widgets-widgets.php';
						}
						if ( ! function_exists( 'wie_import_data' ) ) {
							require OMFW_PATH . '/libraries/widgets-importer/widgets-import.php';
						}

						$data = json_decode( omfw_Framework::read_file( $this->current_settings['demo_content_path'] . $this->current_settings['widgets_dat'] ) );
						if ( ! empty( $this->current_settings['widgets_var_to_replace'] ) && ! empty( $this->current_settings['uploads_replace_dir'] ) ) {
							$wp_upload_dir = wp_upload_dir();

							foreach ( $this->current_settings['widgets_var_to_replace'] as $v ) {
								if ( property_exists( $data, $v['sidebar'] ) && property_exists( $data->{$v['sidebar']}, $v['widget_key'] ) && property_exists( $data->{$v['sidebar']}->{$v['widget_key']}, $v['widget_field'] ) ) {
									$data->{$v['sidebar']}->{$v['widget_key']}->{$v['widget_field']} = str_replace( $this->current_settings['uploads_replace_dir'], $wp_upload_dir['baseurl'], $data->{$v['sidebar']}->{$v['widget_key']}->{$v['widget_field']} );
								}
							}
						}
						wie_import_data( $data );

					}

					// Layer Slider
					if ( isset( $GLOBALS['lsPluginVersion'] ) || defined( 'LS_PLUGIN_VERSION' ) ) {
						if ( $this->current_settings['layer_slider_dat'] ) {
							$this->ls_import_sliders( $this->current_settings['demo_content_path'] . $this->current_settings['layer_slider_dat'] );
						}
					}

					// RevSlider
					if ( class_exists( 'RevSlider' ) ) {
						if ( ! empty( $this->current_settings['rev_slider_dat'] ) ) {
							foreach ( $this->current_settings['rev_slider_dat'] as $file ) {
								if ( $file ) {
									$this->rev_import_slider( $this->current_settings['demo_content_path'] . $file );
								}
							}
						}
					}


					// Set reading options
					$front_page = $this->current_settings['reading']['front_page_title'] ? get_page_by_title( $this->current_settings['reading']['front_page_title'] ) : false;
					$posts_page = $this->current_settings['reading']['posts_page_title'] ? get_page_by_title( $this->current_settings['reading']['posts_page_title'] ) : false;
					if ( $front_page || $posts_page ) {
						update_option( 'show_on_front', 'page' );
						if ( $front_page ) {
							update_option( 'page_on_front', $front_page->ID );
						}
						if ( $posts_page ) {
							update_option( 'page_for_posts', $posts_page->ID );
						}
					}

				}

				do_action( 'omfw_demo_import_' . $this->current_settings['slug'] . '_completed' );

				wp_send_json( $ret );

				break;


		}
	}


	/*********************************/

	public function modify_meta( $postmeta ) {

		foreach ( $postmeta as $k => $meta ) {

			if ( $meta['key'] == omfw_Framework::$theme_prefix . 'gallery' || $meta['key'] == 'ompf_gallery' ) {
				$value = maybe_unserialize( $meta['value'] );
				if ( isset( $value['images'] ) && $value['images'] ) {

					$variables_dump = get_option( omfw_Framework::$theme_prefix . 'import_process_data_' . $this->current_settings['slug'] );

					$ids  = explode( ',', $value['images'] );
					$ids_ = array();
					foreach ( $ids as $id ) {
						$id = intval( $id );
						if ( isset( $variables_dump['processed_posts'][ $id ] ) ) {
							$ids_[] = $variables_dump['processed_posts'][ $id ];
						}
					}
					$value['images'] = implode( ',', $ids_ );

				}
				$postmeta[ $k ]['value'] = $value;
			}

		}

		return $postmeta;

	}

	/**********************************/

	public function ls_import_sliders( $file ) {

		if ( ! file_exists( $file ) ) {
			return false;
		}

		// Get decoded file data
		$data = omfw_Framework::str_decode( omfw_Framework::read_file( $file ) );

		// Parsing JSON or PHP object
		if ( ! $parsed = json_decode( $data, true ) ) {
			$parsed = unserialize( $data );
		}

		// Iterate over imported sliders
		if ( is_array( $parsed ) ) {

			$wp_upload_dir = wp_upload_dir();

			// Iterate over the sliders
			foreach ( $parsed as $sliderkey => $slider ) {

				// Iterate over the layers
				foreach ( $parsed[ $sliderkey ]['layers'] as $layerkey => $layer ) {

					// Change background images if any
					$parsed[ $sliderkey ]['layers'][ $layerkey ]['properties']['backgroundId'] = '';
					if ( ! empty( $parsed[ $sliderkey ]['layers'][ $layerkey ]['properties']['background'] ) ) {
						foreach ( $this->current_settings['layer_slider_uploads_replace'] as $str => $r ) {
							if ( $r == 'LS' ) {
								$r = LS_ROOT_URL;
							} else {
								$r = $wp_upload_dir['baseurl'];
							}
							$layer['properties']['background'] = str_replace( $str, $r, $layer['properties']['background'] );
						}
						$parsed[ $sliderkey ]['layers'][ $layerkey ]['properties']['background'] = $layer['properties']['background'];
					}

					// Change thumbnail images if any
					$parsed[ $sliderkey ]['layers'][ $layerkey ]['properties']['thumbnailId'] = '';
					if ( ! empty( $parsed[ $sliderkey ]['layers'][ $layerkey ]['properties']['thumbnail'] ) ) {
						foreach ( $this->current_settings['layer_slider_uploads_replace'] as $str => $r ) {
							if ( $r == 'LS' ) {
								$r = LS_ROOT_URL;
							} else {
								$r = $wp_upload_dir['baseurl'];
							}
							$layer['properties']['thumbnail'] = str_replace( $str, $r, $layer['properties']['thumbnail'] );
						}
						$parsed[ $sliderkey ]['layers'][ $layerkey ]['properties']['thumbnail'] = $layer['properties']['thumbnail'];
					}

					// Iterate over the sublayers
					if ( isset( $layer['sublayers'] ) && ! empty( $layer['sublayers'] ) ) {
						foreach ( $layer['sublayers'] as $sublayerkey => $sublayer ) {

							// Only IMG sublayers
							$parsed[ $sliderkey ]['layers'][ $layerkey ]['sublayers'][ $sublayerkey ]['imageId'] = '';
							if ( $sublayer['type'] == 'img' || ( isset( $sublayer['media'] ) && $sublayer['media'] == 'img' ) ) {
								foreach ( $this->current_settings['layer_slider_uploads_replace'] as $str => $r ) {
									if ( $r == 'LS' ) {
										$r = LS_ROOT_URL;
									} else {
										$r = $wp_upload_dir['baseurl'];
									}
									$sublayer['image'] = str_replace( $str, $r, $sublayer['image'] );
								}
								$parsed[ $sliderkey ]['layers'][ $layerkey ]['sublayers'][ $sublayerkey ]['image'] = $sublayer['image'];
							}
						}
					}
				}
			}

			//  DB stuff
			global $wpdb;
			$table_name = $wpdb->prefix . "layerslider";

			// Import sliders
			foreach ( $parsed as $item ) {

				// Fix for export issue in v4.6.4
				if ( is_string( $item ) ) {
					$item = json_decode( $item, true );
				}

				// Add to DB
				$wpdb->query(
					$wpdb->prepare( "INSERT INTO $table_name (name, data, date_c, date_m)
									VALUES (%s, %s, %d, %d)",
						$item['properties']['title'], json_encode( $item ), time(), time()
					)
				);
			}

		}

	}

	/****************************************/

	public function rev_import_slider( $file ) {

		if ( ! file_exists( $file ) || ! class_exists( 'RevSlider' ) ) {
			return false;
		}

		ob_start();
		$slider   = new RevSlider();
		$response = $slider->importSliderFromPost( true, true, $file );
		ob_end_clean();

	}

	/****************************************/

	public function import_menu_meta( $processed_menu_items ) {

		if ( empty( $this->current_settings['menu_add_meta'] ) ) {
			return false;
		}

		$add_meta_list = $this->current_settings['menu_add_meta'];

		if ( ! class_exists( 'WXR_Parser' ) ) {
			require OMFW_PATH . '/libraries/wordpress-importer/parsers.php';
		}

		$parser      = new WXR_Parser();
		$import_data = $parser->parse( $this->current_settings['demo_content_path'] . $this->current_settings['wordpress_xml'] );
		unset( $parser );

		if ( is_wp_error( $import_data ) ) {
			return false;
		}

		foreach ( $import_data['posts'] as $post ) {
			if ( 'nav_menu_item' == $post['post_type'] ) {
				$post_id = $post['post_id'];
				if ( isset( $processed_menu_items[ $post_id ] ) ) {

					foreach ( $add_meta_list as $meta_name ) {
						foreach ( $post['postmeta'] as $postmeta ) {
							if ( $postmeta['key'] == $meta_name ) {
								update_post_meta( $processed_menu_items[ $post_id ], $meta_name, $postmeta['value'] );
								break;
							}
						}
					}

				}
			}
		}

	}

}