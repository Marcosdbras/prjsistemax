<?php
/**
 * Widget base class.
 */

/**
 * Class: Widget base.
 */
class Envo_Multipurpose_Widget extends WP_Widget {

	public $widget_description;
	public $widget_id;
	public $widget_name;
	public $settings;
	public $control_ops;
	public $selective_refresh = true;

	/**
	 * __construct
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => $this->widget_id,
			'description'                 => $this->widget_description,
			'customize_selective_refresh' => $this->selective_refresh,
		);

		parent::__construct( $this->widget_id, $this->widget_name, $widget_ops, $this->control_ops );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_envo_multipurpose_post_lookup', array( &$this, 'post_lookup_callback' ) );
		add_action( 'elementor/editor/before_enqueue_scripts', array( &$this, 'enqueue_scripts_builders' ) );
	}

	/**
	 * Echo post title and id for ajax request. Used in widget for searching
	 * for post by title.
	 */
	public function post_lookup_callback() {
		global $wpdb; /* get access to the WordPress database object variable. */

		// get names of all businesses.
		$request   = '%' . $wpdb->esc_like( sanitize_text_field( wp_unslash( $_POST['request'] ) ) ) . '%'; /* escape for use in LIKE statement. */
		$post_type = sanitize_text_field( wp_unslash( $_POST['post_type'] ) );

		$sql = "
			select
				ID,
				post_title
			from
				$wpdb->posts
			where
				post_title like %s
				and post_type='%s'
				and post_status='publish'
			order by
				post_title ASC
			limit
				0,30
		";

		$sql = $wpdb->prepare( $sql, $request, $post_type );

		$results = $wpdb->get_results( $sql );

		// copy the business titles to a simple array.
		$titles = array();
		$i      = 0;
		foreach ( $results as $r ) {
			$titles[ $i ]['label'] = $r->post_title . ' (' . $r->ID . ')';
			$titles[ $i ]['value'] = $r->ID;
			$i++;
		}

		if ( empty( $titles ) ) {
			$titles[0]['label'] = 'No results found in post type "' . $post_type . '."';
			$titles[0]['value'] = '0';
		}

		echo json_encode( $titles ); /* encode into JSON format and output. */

		die(); /* stop "0" from being output. */
	}

	/**
	 * Enqueue Scripts
	 */
	public function enqueue_scripts( $hook_suffix ) {


		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'envo-multipurpose-admin-widgets', get_parent_theme_file_uri() . '/css/admin/admin-widgets.css', array(), ENVO_MULTIPURPOSE_VERSION );

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-accordion' );

		wp_enqueue_script( 'envo-multipurpose-admin-widgets', get_template_directory_uri() . '/js/admin/admin-widgets.js', array(), ENVO_MULTIPURPOSE_VERSION, true );
		wp_enqueue_script( 'envo-multipurpose-post-select', get_template_directory_uri() . '/js/admin/admin-post-select.js', array(), ENVO_MULTIPURPOSE_VERSION, true );
	}
	
	/**
	 * Enqueue Scripts for page builders
	 */
	public function enqueue_scripts_builders( ) {

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'envo-multipurpose-admin-widgets', get_parent_theme_file_uri() . '/css/admin/admin-widgets.css', array(), ENVO_MULTIPURPOSE_VERSION );
		
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		
		wp_enqueue_script( 'youtube-backgrounds', get_template_directory_uri() . '/js/jquery.youtubebackground.js', array(), ENVO_MULTIPURPOSE_VERSION, true );
		wp_enqueue_script( 'envo-multipurpose-admin-widgets', get_template_directory_uri() . '/js/admin/admin-widgets.js', array(), ENVO_MULTIPURPOSE_VERSION, true );
		wp_enqueue_script( 'envo-multipurpose-post-select', get_template_directory_uri() . '/js/admin/admin-post-select.js', array(), ENVO_MULTIPURPOSE_VERSION, true );
	}

	/**
	 * Sanitize options.
	 */
	function sanitize( $instance ) {
		if ( ! $this->settings ) {
			return $instance;
		}

		if ( isset( $instance['repeater'] ) && is_array( $instance['repeater'] ) ) {
			$repeater_instances = $instance['repeater'];
			unset( $instance['repeater'] );
			// turn on to test default widget settings.
			/* $repeater_instances = $this->settings['repeater']['default']; */
		} else {
			if ( isset( $this->settings['repeater']['default'] ) ) {
				$repeater_instances = $this->settings['repeater']['default'];
			} else {
				$repeater_instances[1] = array();
			}
		}

		foreach ( $this->settings as $key => $setting ) {
			if ( $key == 'panels' ) {
				foreach ( $setting as $panel ) {
					foreach ( $panel['fields'] as $panel_field_key => $panel_field_setting ) {
						$value                        = $this->default_sanitize_value( $panel_field_key, $instance, $panel_field_setting );
						$instance[ $panel_field_key ] = $this->sanitize_instance( $panel_field_setting, $value, 'display' );
					}
				}
			} elseif ( $key == 'repeater' ) {
				foreach ( $repeater_instances as $repeater_count => $repeater_instance ) {
					foreach ( $setting['fields'] as $repeater_field_key => $repeater_field_setting ) {
						$value = $this->default_sanitize_value( $repeater_field_key, $repeater_instance, $repeater_field_setting );
						$instance['repeater'][ $repeater_count ][ $repeater_field_key ] = $this->sanitize_instance( $repeater_field_setting, $value, 'display' );
					}
				}
			} else {
				$value = $this->default_sanitize_value( $key, $instance, $setting );
				// turn on to test default widget settings.
				/* $value = $setting['std']; */
				$instance[ $key ] = $this->sanitize_instance( $setting, $value, 'display' );
			}
		}

		return $instance;
	}

	/**
	 * Check if default value needs to be returned.
	 */
	function default_sanitize_value( $key, $instance, $setting ) {
		if ( array_key_exists( $key, $instance ) ) {
			return $instance[ $key ];
		} else {
			return $setting['std'];
		}
	}

	/**
	 * Properly save user input.
	 */
	function default_update_value( $key, $instance, $setting ) {
		if ( array_key_exists( $key, $instance ) ) {
			return $instance[ $key ];
		} else {
			if ( $setting['type'] == 'checkbox' ) {
				return 0;
			} else {
				return $setting['std'];
			}
		}
	}

	/**
	 * Update
	 */
	function update( $new_instance, $old_instance ) {
		$instance       = array();
		$repeater_count = 0;

		if ( ! $this->settings ) {
			return $instance;
		}

		if ( isset( $new_instance['repeater'] ) && is_array( $new_instance['repeater'] ) ) {
			$repeater_instances = $new_instance['repeater'];
			unset( $new_instance['repeater'] );
		} else {
			if ( isset( $this->settings['repeater']['default'] ) ) {
				$repeater_instances = $this->settings['repeater']['default'];
			} else {
				$repeater_instances[1] = array();
			}
		}

		foreach ( $this->settings as $key => $setting ) {
			if ( $key == 'panels' ) {
				foreach ( $setting as $panel ) {
					foreach ( $panel['fields'] as $panel_field_key => $panel_field_setting ) {
						$value                        = $this->default_update_value( $panel_field_key, $new_instance, $panel_field_setting );
						$instance[ $panel_field_key ] = $this->sanitize_instance( $panel_field_setting, $value );
					}
				}
			} elseif ( $key == 'repeater' ) {
				foreach ( $repeater_instances as $repeater_instance ) {
					$repeater_count++;
					foreach ( $setting['fields'] as $repeater_field_key => $repeater_field_setting ) {
						$value = $this->default_update_value( $repeater_field_key, $repeater_instance, $repeater_field_setting );
						$instance['repeater'][ $repeater_count ][ $repeater_field_key ] = $this->sanitize_instance( $repeater_field_setting, $value );
					}
				}
			} else {
				$value            = $this->default_update_value( $key, $new_instance, $setting );
				$instance[ $key ] = $this->sanitize_instance( $setting, $value );
			}
		}

		return $instance;
	}

	/**
	 * Sanitize Instance
	 */
	function sanitize_instance( $setting, $new_value, $action = 'update' ) {
		if ( ! isset( $setting['sanitize'] ) ) {
			return $new_value;
		}

		$value = '';

		switch ( $setting['sanitize'] ) {
			case 'html':
				$value = wp_kses_post( $new_value );
				break;

			case 'multicheck':
				$value = maybe_serialize( $new_value );
				break;

			case 'checkbox':
				$value = $new_value == 1 ? 1 : 0;
				break;

			case 'text':
				$value = sanitize_text_field( $new_value );
				break;

			case 'absint':
				$value = absint( $new_value );
				break;

			case 'number':
				$value = intval( $new_value );
				break;

			case 'number_blank':
				if ( $new_value === '' ) {
					$value = '';
				} else {
					$value = intval( $new_value );
				}
				break;

			case 'color':
				$value = sanitize_hex_color( $new_value );
				break;

			case 'url':
				$value = esc_url_raw( $new_value );

				if ( $action == 'display' ) {
					$value = $this->sanitize_url_for_customizer( $new_value );
				}
				break;

			case 'background_size':
				$value = $this->sanitize_background_size( $new_value );
				break;

			case 'ids':
			case 'post_ids':
				$value = $this->sanitize_ids( $new_value );
				break;

			case 'slugs':
				$value = $this->sanitize_slugs( $new_value );
				break;

			default:
				$value = $new_value;
				break;
		}

		return $value;
	}

	/**
	 * This functions provides the big picture logic
	 * for displaying each type of user input field.
	 */
	function form( $instance ) {

		if ( ! $this->settings ) {
			return;
		}
		$display_panels   = false;
		$display_repeater = false;
		$panel_count      = 0;

		if ( isset( $instance['repeater'] ) && is_array( $instance['repeater'] ) ) {
			$repeater_instances = $instance['repeater'];
			unset( $instance['repeater'] );
		} else {
			if ( isset( $this->settings['repeater']['default'] ) ) {
				$repeater_instances = $this->settings['repeater']['default'];
			} else {
				$repeater_instances[1] = array();
			}
		}
		?>

		<div id="<?php echo esc_attr( $this->id ); ?>" class="widget-inner-container ui-theme-override">
			<?php

			foreach ( $this->settings as $key => $setting ) {

				if ( 'repeater' == $key ) {
					$display_repeater = true;

					$this->display_before_panel_repeater();

					foreach ( $repeater_instances as $repeater_instance ) {

						$this->display_before_panel( $setting['title'] );

						$panel_count++;
						foreach ( $setting['fields'] as $key => $repeater_setting ) {
							$this->display_settings( $repeater_instance, $key, $repeater_setting, $display_repeater, $panel_count );
						}

						$this->display_after_panel( $display_repeater );
					}

					$this->display_after_panel_repeater( $panel_count );
				} elseif ( 'panels' == $key ) {
					$display_panels = true;

					$this->display_before_panels();

					foreach ( $setting as $s ) {

						$this->display_before_panel( $s['title'] );

						foreach ( $s['fields'] as $key => $panel_setting ) {
							$this->display_settings( $instance, $key, $panel_setting );
						}

						$this->display_after_panel();
					}

					$this->display_after_panels();
				} else {
					$this->display_settings( $instance, $key, $setting );
				}
			}

			?>
		</div>

		<?php if ( $display_repeater ) : ?>
				<?php $selector = '#' . esc_attr( $this->id ) . ' .panel-repeater-container'; ?>
				<script type="text/javascript">
					/* <![CDATA[ */
					( function( $ ) {
						"use strict";
						$(document).ready(function($){
							$('#widgets-right <?php echo esc_attr( $selector ); ?>').accordion({
								header: '.widget-panel-title',
								heightStyle: 'content',
								collapsible: true,
								active: false
							});

							widgetPanelRepeaterButtons( $('<?php echo esc_attr( $selector ); ?>') );
							widgetPanelMoveRefresh( $('<?php echo esc_attr( $selector ); ?>') );
						});
					} )( jQuery );
					/* ]]> */
				</script>
		<?php endif; ?>

		<?php if ( $display_panels ) : ?>
				<?php $selector = '#' . esc_attr( $this->id ) . ' .panel-container'; ?>
				<script type="text/javascript">
					/* <![CDATA[ */
					( function( $ ) {
						"use strict";
						$(document).ready(function($){
							$('#widgets-right <?php echo esc_attr( $selector ); ?>').accordion({
								header: '.widget-panel-title',
								heightStyle: 'content',
								collapsible: true,
								active: false
							});
						});
					} )( jQuery );
					/* ]]> */
				</script>
		<?php endif; ?>

		<?php
	}

	/**
	 * Display HTML before panels start
	 */
	public function display_before_panels() {
		?>
		<div class="panel-container">
		<?php
	}

	/**
	 * Display HTML after panels start
	 */
	public function display_after_panels() {
		?>
		</div>
		<?php
	}

	/**
	 * Display HTML before panel repeater start
	 */
	public function display_before_panel_repeater() {
		?>
		<div class="panel-repeater-container">
		<?php
	}

	/**
	 * Display HTML after panel repeater start
	 */
	public function display_after_panel_repeater( $panel_count ) {
		?>
		</div>
		<input type="hidden" id="widget-panel-repeater-count" value="<?php echo esc_attr( $panel_count ); ?>" />
		<a href="#" class="button-secondary widget-panel-repeater" onclick="widgetPanelRepeater( '<?php echo esc_attr( $this->id ); ?>' ); return false;"><?php esc_html_e( 'Add New Item', 'envo-multipurpose' ); ?></a>
		<?php
	}

	/**
	 * Display HTML before panel start
	 */
	public function display_before_panel( $title ) {
		?>
		<div class="widget-panel">
			<h3 class="widget-panel-title"><?php echo esc_html( $title ); ?></h3>
			<div class="widget-panel-body">
		<?php
	}

	/**
	 * Display HTML after panel start
	 */
	public function display_after_panel( $display_repeater = false ) {
		?>
			</div>

			<?php if ( $display_repeater ) : ?>

			<a onclick="widgetPanelMoveUp( this ); return false;" href="#" class="dashicons-before dashicons-arrow-up-alt2 panel-move panel-move-up panel-button"></a>
			<a onclick="widgetPanelMoveDown( this ); return false;" href="#" class="dashicons-before dashicons-arrow-down-alt2 panel-move panel-move-down panel-button"></a>
			<a onclick="widgetPanelDelete( this ); return false;" href="#" class="dashicons-before dashicons-no panel-delete panel-button"></a>
			<span class="panel-delete-final">
				<?php echo esc_html__( 'Delete Slide', 'envo-multipurpose' ); ?>
				<a href="#" onclick="widgetPanelDeleteYes( this ); return false;"><?php echo esc_html__( 'Yes', 'envo-multipurpose' ); ?></a>
				<a href="#" onclick="widgetPanelDeleteNo( this ); return false;"><?php echo esc_html__( 'No', 'envo-multipurpose' ); ?></a>
			</span>

			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Display Setting
	 */
	public function display_settings( $instance, $key, $setting, $display_repeater = false, $count = 1 ) {
		$value = array_key_exists( $key, $instance ) ? $instance[ $key ] : $setting['std'];

		if ( $display_repeater ) {
			$field_id   = $this->get_field_id( 'repeater' ) . '-' . $count . '-' . $key;
			$field_name = $this->get_field_name( 'repeater' ) . '[' . $count . ']' . '[' . $key . ']';
		} else {
			$field_id   = $this->get_field_id( $key );
			$field_name = $this->get_field_name( $key );
		}

		switch ( $setting['type'] ) {
			case 'description':
				?>
				<p class="description"><?php echo $value; /* WPCS: XSS OK. HTML output */ ?></p>
				<?php
				break;

			case 'text':
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'image':
				wp_enqueue_media();
				wp_enqueue_script( 'envo-multipurpose-widget-image', get_template_directory_uri() . '/js/admin/admin-image.js', array( 'jquery' ), '', true );
				$id_prefix = $this->get_field_id( '' );
			?>
				<p style="margin-bottom: 0;">
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
				</p>

				<div class="image-sel-container" style="margin-top: 3px;">
					<div class="image-sel-preview">
						<style type="text/css">
							.image-sel-preview img { max-width: 100%; border: 1px solid #e5e5e5; padding: 2px; margin-bottom: 5px; height: auto; }
						</style>
						<?php if ( ! empty( $value ) ) : ?>
						<img src="<?php echo esc_url( $value ); ?>" alt="">
						<?php endif; ?>
					</div>

					<input type="text" class="widefat image-sel-value" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>"value="<?php echo esc_attr( $value ); ?>" placeholder="http://" style="margin-bottom:5px;" />
					<a href="#" class="button-secondary image-sel-add" onclick="imageWidget.uploader( this ); return false;"><?php esc_html_e( 'Choose Image', 'envo-multipurpose' ); ?></a>
					<?php
					$a_style = '';
					if ( empty( $value ) ) {
						$a_style = 'display:none;';
					}
					?>
					<a href="#" style="display:inline-block;margin:5px 0 0 3px;<?php echo esc_attr( $a_style ); ?>" class="image-sel-remove" onclick="imageWidget.remove( this ); return false;"><?php esc_html_e( 'Remove', 'envo-multipurpose' ); ?></a>
				</div>
				<?php if ( isset( $setting['description'] ) ) : ?>
					<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
				<?php endif; ?>
			<?php
				break;

			case 'checkbox':
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>">
						<input type="checkbox" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" type="text" value="1" <?php checked( 1, esc_attr( $value ) ); ?>/>
						<?php echo esc_html( $setting['label'] ); ?>
					</label>
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'multicheck':
				$value = maybe_unserialize( $value );

				if ( ! is_array( $value ) ) {
					$value = array();
				}
				?>
				<p><?php echo esc_attr( $setting['label'] ); ?></p>
				<p>
					<?php foreach ( $setting['options'] as $id => $label ) : ?>
						<label for="<?php echo esc_attr( sanitize_title( $label ) ); ?>-<?php echo esc_attr( $id ); ?>">
							<input type="checkbox" id="<?php echo esc_attr( sanitize_title( $label ) ); ?>-<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $field_name ); ?>[]" value="<?php echo esc_attr( $id ); ?>" 
																	<?php
																	if ( in_array( $id, $value ) ) :
										?>
										checked="checked"<?php endif; ?>/>
							<?php echo esc_attr( $label ); ?><br />
						</label>
					<?php endforeach; ?>
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'select':
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<select class="widefat" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>">
						<?php foreach ( $setting['options'] as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $value ); ?>><?php echo esc_attr( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'page':
				$pages = get_pages( 'sort_order=ASC&sort_column=post_title&post_status=publish' );
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<select class="widefat" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>">
						<option value="" <?php selected( '', $value ); ?>><?php echo esc_html__( 'No Page', 'envo-multipurpose' ); ?></option>
						<?php foreach ( $pages as $page ) : ?>
							<option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $page->ID, $value ); ?>><?php echo esc_attr( $page->post_title ); ?></option>
						<?php endforeach; ?>
					</select>
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'post':
				$post_type = 'post';
				if ( isset( $setting['post_type'] ) && ! empty( $setting['post_type'] ) && post_type_exists( $setting['post_type'] ) ) {
					$post_type = $setting['post_type'];
				}
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<input class="widefat post-autocomplete-select" id="<?php echo esc_attr( $field_id ); ?>" data-autocomplete-type="multi" data-autocomplete-taxonomy="" data-autocomplete-lookup="post" data-autocomplete-post-type="<?php echo esc_attr( $post_type ); ?>" name="<?php echo esc_attr( $field_name ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<script type="text/javascript">
					/* <![CDATA[ */
					jQuery(document).ready(function($){
						$('#<?php echo esc_attr( $field_id ); ?>').postAutoCompleteSelect();
					});
					/* ]]> */
				</script>
				<?php
				break;

			case 'number':
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" type="number" step="<?php echo esc_attr( $setting['step'] ); ?>" 
															<?php
															if ( isset( $setting['min'] ) ) :
										?>
										 min="<?php echo esc_attr( $setting['min'] ); ?>" <?php endif; ?> <?php
											if ( isset( $setting['max'] ) ) :
											?>
											 max="<?php echo esc_attr( $setting['max'] ); ?>" <?php endif; ?> value="<?php echo esc_attr( $value ); ?>" />
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'textarea':
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<?php $rows = isset( $setting['rows'] ) ? $setting['rows'] : 3; ?>
					<textarea class="widefat" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" rows="<?php echo esc_attr( $rows ); ?>"><?php echo esc_html( $value ); ?></textarea>
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'colorpicker':
					wp_enqueue_script( 'wp-color-picker' );
					wp_enqueue_style( 'wp-color-picker' );
				?>
				<p style="margin-bottom: 0;">
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
				</p>
				<div class="color-picker-wrapper">
					<input type="text" class="widefat color-picker" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" data-default-color="<?php echo esc_attr( $setting['std'] ); ?>" value="<?php echo esc_attr( $value ); ?>" />
					<script type="text/javascript">
						/* <![CDATA[ */
						( function( $ ){
							$( document ).ready( function() {
								$('#widgets-right #<?php echo esc_attr( $field_id ); ?>').wpColorPicker({
									change: _.throttle( function() { /* For Customizer */
										$(this).trigger( 'change' );
									}, 3000 )
								});
							} );
						}( jQuery ) );
						/* ]]> */
					</script>
				</div>
				<?php if ( isset( $setting['description'] ) ) : ?>
					<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
				<?php endif; ?>
				<p></p>
				<?php
				break;

			case 'category':
				$categories_dropdown = wp_dropdown_categories(
					array(
						'name'            => $this->get_field_name( 'category' ),
						'selected'        => $value,
						'show_option_all' => esc_html__( 'All Categories', 'envo-multipurpose' ),
						'show_count'      => true,
						'orderby'         => 'slug',
						'hierarchical'    => true,
						'class'           => 'widefat',
						'echo'            => false,
					)
				);
				?>

				<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
				<?php echo $categories_dropdown; /* WPCS: XSS OK. HTML output. */ ?>

				<?php
				break;

			default:
				do_action( 'envo_multipurpose_widget_type_' . $setting['type'], $this, $key, $setting, $instance );
				break;
		}
	}

	/**
	 * Helper method to go from hex to rgb color.
	 */
	function hex2rgb( $colour ) {
		if ( $colour[0] == '#' ) {
				$colour = substr( $colour, 1 );
		}
		if ( strlen( $colour ) == 6 ) {
				list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
				list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
				return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );
		return array(
			'red'   => $r,
			'green' => $g,
			'blue'  => $b,
		);
	}

	/**
	 * Convert post_ids string to array of ints.
	 */
	private function sanitize_ids_array( $post_ids ) {
		$post_ids = explode( ',', $post_ids );

		if ( is_array( $post_ids ) && ! empty( $post_ids ) ) {
			$post_ids_array = array();
			foreach ( $post_ids as $key => $value ) {
				$value = absint( $value );

				if ( ! empty( $value ) ) {
					$post_ids_array[] = $value;
				}
			}

			if ( ! empty( $post_ids_array ) ) {
				return $post_ids_array;
			}
		}

		return array();
	}

	/**
	 * Wrapper function to sanitize string of comma delimited ids.
	 */
	private function sanitize_ids( $post_ids ) {
		$post_ids_array = $this->sanitize_ids_array( $post_ids );

		$post_ids = implode( ',', $post_ids_array );

		if ( ! empty( $post_ids ) ) {
			return $post_ids;
		}

		return '';
	}

	/**
	 * Comma delimited post slugs string to array
	 */
	private function sanitize_slugs_array( $post_ids ) {
		$post_ids = explode( ',', $post_ids );

		if ( is_array( $post_ids ) && ! empty( $post_ids ) ) {
			$post_ids_array = array();
			foreach ( $post_ids as $key => $value ) {
				$value = sanitize_title( $value );

				if ( ! empty( $value ) ) {
					$post_ids_array[] = $value;
				}
			}

			if ( ! empty( $post_ids_array ) ) {
				return $post_ids_array;
			}
		}

		return array();
	}

	/**
	 * Wrapper function to sanitize post slugs in comma delimited string.
	 */
	private function sanitize_slugs( $post_ids ) {
		$post_ids_array = $this->sanitize_slugs_array( $post_ids );

		$post_ids = implode( ',', $post_ids_array );

		if ( ! empty( $post_ids ) ) {
			return $post_ids;
		}

		return '';
	}

	/**
	 * Sanitize URL. This fixes a link bug in the Customizer.
	 */
	function sanitize_url_for_customizer( $value ) {
		if ( is_customize_preview() || is_preview() ) {
			// fixes obscure bug when admin panel is ssl and front end is not ssl.
			$value = preg_replace( '/^https?:/', '', $value );
		}

		return $value;
	}

	/**
	 * Sanitize background size
	 */
	function sanitize_background_size( $value ) {
		$whitelist = $this->options_background_size();

		if ( array_key_exists( $value, $whitelist ) ) {
			return $value;
		}

		return '';
	}

	/**
	 * Background size CSS options
	 */
	function options_background_size() {
		return array(
			'cover'      => esc_html__( 'Cover', 'envo-multipurpose' ),
			'contain'    => esc_html__( 'Contain', 'envo-multipurpose' ),
			'stretch'    => esc_html__( 'Stretch', 'envo-multipurpose' ),
			'fit-width'  => esc_html__( 'Fit Width', 'envo-multipurpose' ),
			'fit-height' => esc_html__( 'Fit Height', 'envo-multipurpose' ),
			'auto'       => esc_html__( 'Auto', 'envo-multipurpose' ),
		);
	}
	
	/**
	 * Background size CSS options
	 */
	function options_title_style() {
		return array(
			'title-default'      => esc_html__( 'Default', 'envo-multipurpose' ),
			'title-style-1'    => esc_html__( 'Style #1', 'envo-multipurpose' ),
			'title-style-2'    => esc_html__( 'Style #2', 'envo-multipurpose' ),
			'title-style-3'    => esc_html__( 'Style #3', 'envo-multipurpose' ),
			'title-style-4'    => esc_html__( 'Style #4', 'envo-multipurpose' ),
		);
	}
	
	/**
	 * Background size CSS options
	 */
	function image_overlay() {
		return array(
			''      => esc_html__( 'None', 'envo-multipurpose' ),
			'01'      => esc_html__( 'Overlay #1', 'envo-multipurpose' ),
			'02'      => esc_html__( 'Overlay #2', 'envo-multipurpose' ),
			'03'      => esc_html__( 'Overlay #3', 'envo-multipurpose' ),
			'04'      => esc_html__( 'Overlay #4', 'envo-multipurpose' ),
			'05'      => esc_html__( 'Overlay #5', 'envo-multipurpose' ),
			'06'      => esc_html__( 'Overlay #6', 'envo-multipurpose' ),
			'07'      => esc_html__( 'Overlay #7', 'envo-multipurpose' ),
			'08'      => esc_html__( 'Overlay #8', 'envo-multipurpose' ),
		);
	}

	/**
	 * Get CSS background size options
	 */
	function get_background_size( $value ) {
		switch ( $value ) {
			case 'stretch':
				$value = '100% 100%';
				break;
			case 'fit-width':
				$value = '100% auto';
				break;
			case 'fit-height':
				$value = 'auto 100%';
				break;
		}

		return $value;
	}
	
	/**
	 * Get fontawesome icons
	 */
	function fontawesome_icons() {
		return array(''=>'','500px'=>'500px','adjust'=>'adjust','adn'=>'adn','align-center'=>'align-center','align-justify'=>'align-justify','align-left'=>'align-left','align-right'=>'align-right','amazon'=>'amazon','ambulance'=>'ambulance','anchor'=>'anchor','android'=>'android','angellist'=>'angellist','angle-double-down'=>'angle-double-down','angle-double-left'=>'angle-double-left','angle-double-right'=>'angle-double-right','angle-double-up'=>'angle-double-up','angle-down'=>'angle-down','angle-left'=>'angle-left','angle-right'=>'angle-right','angle-up'=>'angle-up','apple'=>'apple','archive'=>'archive','area-chart'=>'area-chart','arrow-circle-down'=>'arrow-circle-down','arrow-circle-left'=>'arrow-circle-left','arrow-circle-o-down'=>'arrow-circle-o-down','arrow-circle-o-left'=>'arrow-circle-o-left','arrow-circle-o-right'=>'arrow-circle-o-right','arrow-circle-o-up'=>'arrow-circle-o-up','arrow-circle-right'=>'arrow-circle-right','arrow-circle-up'=>'arrow-circle-up','arrow-down'=>'arrow-down','arrow-left'=>'arrow-left','arrow-right'=>'arrow-right','arrow-up'=>'arrow-up','arrows'=>'arrows','arrows-alt'=>'arrows-alt','arrows-h'=>'arrows-h','arrows-v'=>'arrows-v','asterisk'=>'asterisk','at'=>'at','automobile'=>'automobile','backward'=>'backward','balance-scale'=>'balance-scale','ban'=>'ban','bar-chart-o'=>'bar-chart-o','barcode'=>'barcode','battery-0'=>'battery-0','battery-1'=>'battery-1','battery-2'=>'battery-2','battery-3'=>'battery-3','battery-4'=>'battery-4','beer'=>'beer','behance'=>'behance','behance-square'=>'behance-square','bell'=>'bell','bell-o'=>'bell-o','bell-slash'=>'bell-slash','bell-slash-o'=>'bell-slash-o','bicycle'=>'bicycle','binoculars'=>'binoculars','birthday-cake'=>'birthday-cake','bitbucket'=>'bitbucket','bitbucket-square'=>'bitbucket-square','bitcoin'=>'bitcoin','black-tie'=>'black-tie','bold'=>'bold','bomb'=>'bomb','book'=>'book','bookmark'=>'bookmark','bookmark-o'=>'bookmark-o','briefcase'=>'briefcase','bug'=>'bug','building'=>'building','building-o'=>'building-o','bullhorn'=>'bullhorn','bullseye'=>'bullseye','bus'=>'bus','buysellads'=>'buysellads','cab'=>'cab','calculator'=>'calculator','calendar'=>'calendar','calendar-check-o'=>'calendar-check-o','calendar-minus-o'=>'calendar-minus-o','calendar-o'=>'calendar-o','calendar-plus-o'=>'calendar-plus-o','calendar-times-o'=>'calendar-times-o','camera'=>'camera','camera-retro'=>'camera-retro','caret-down'=>'caret-down','caret-left'=>'caret-left','caret-right'=>'caret-right','caret-up'=>'caret-up','cart-arrow-down'=>'cart-arrow-down','cart-plus'=>'cart-plus','cc'=>'cc','cc-amex'=>'cc-amex','cc-diners-club'=>'cc-diners-club','cc-discover'=>'cc-discover','cc-jcb'=>'cc-jcb','cc-mastercard'=>'cc-mastercard','cc-paypal'=>'cc-paypal','cc-stripe'=>'cc-stripe','cc-visa'=>'cc-visa','certificate'=>'certificate','chain'=>'chain','check'=>'check','check-circle'=>'check-circle','check-circle-o'=>'check-circle-o','check-square'=>'check-square','check-square-o'=>'check-square-o','chevron-circle-down'=>'chevron-circle-down','chevron-circle-left'=>'chevron-circle-left','chevron-circle-right'=>'chevron-circle-right','chevron-circle-up'=>'chevron-circle-up','chevron-down'=>'chevron-down','chevron-left'=>'chevron-left','chevron-right'=>'chevron-right','chevron-up'=>'chevron-up','child'=>'child','chrome'=>'chrome','circle'=>'circle','circle-o'=>'circle-o','circle-o-notch'=>'circle-o-notch','circle-thin'=>'circle-thin','clock-o'=>'clock-o','clone'=>'clone','cloud'=>'cloud','cloud-download'=>'cloud-download','cloud-upload'=>'cloud-upload','cny'=>'cny','code'=>'code','code-fork'=>'code-fork','codepen'=>'codepen','coffee'=>'coffee','columns'=>'columns','comment'=>'comment','comment-o'=>'comment-o','commenting'=>'commenting','commenting-o'=>'commenting-o','comments'=>'comments','comments-o'=>'comments-o','compass'=>'compass','compress'=>'compress','connectdevelop'=>'connectdevelop','contao'=>'contao','copy'=>'copy','copyright'=>'copyright','creative-commons'=>'creative-commons','credit-card'=>'credit-card','crop'=>'crop','crosshairs'=>'crosshairs','css3'=>'css3','cube'=>'cube','cubes'=>'cubes','cut'=>'cut','cutlery'=>'cutlery','dashboard'=>'dashboard','dashcube'=>'dashcube','database'=>'database','dedent'=>'dedent','delicious'=>'delicious','desktop'=>'desktop','deviantart'=>'deviantart','diamond'=>'diamond','digg'=>'digg','dollar'=>'dollar','dot-circle-o'=>'dot-circle-o','download'=>'download','dribbble'=>'dribbble','dropbox'=>'dropbox','drupal'=>'drupal','edit'=>'edit','eject'=>'eject','ellipsis-h'=>'ellipsis-h','ellipsis-v'=>'ellipsis-v','envelope'=>'envelope','envelope-o'=>'envelope-o','envelope-square'=>'envelope-square','eraser'=>'eraser','euro'=>'euro','exchange'=>'exchange','exclamation'=>'exclamation','exclamation-circle'=>'exclamation-circle','expand'=>'expand','expeditedssl'=>'expeditedssl','external-link'=>'external-link','external-link-square'=>'external-link-square','eye'=>'eye','eye-slash'=>'eye-slash','eyedropper'=>'eyedropper','facebook-f'=>'facebook-f','facebook-official'=>'facebook-official','facebook-square'=>'facebook-square','fast-backward'=>'fast-backward','fast-forward'=>'fast-forward','fax'=>'fax','feed'=>'feed','female'=>'female','fighter-jet'=>'fighter-jet','file'=>'file','file-code-o'=>'file-code-o','file-excel-o'=>'file-excel-o','file-movie-o'=>'file-movie-o','file-o'=>'file-o','file-pdf-o'=>'file-pdf-o','file-photo-o'=>'file-photo-o','file-powerpoint-o'=>'file-powerpoint-o','file-sound-o'=>'file-sound-o','file-text'=>'file-text','file-text-o'=>'file-text-o','file-word-o'=>'file-word-o','file-zip-o'=>'file-zip-o','film'=>'film','filter'=>'filter','fire'=>'fire','fire-extinguisher'=>'fire-extinguisher','firefox'=>'firefox','flag'=>'flag','flag-checkered'=>'flag-checkered','flag-o'=>'flag-o','flash'=>'flash','flask'=>'flask','flickr'=>'flickr','folder'=>'folder','folder-o'=>'folder-o','folder-open'=>'folder-open','folder-open-o'=>'folder-open-o','font'=>'font','fonticons'=>'fonticons','forumbee'=>'forumbee','forward'=>'forward','foursquare'=>'foursquare','frown-o'=>'frown-o','gamepad'=>'gamepad','gbp'=>'gbp','ge'=>'ge','gear'=>'gear','gears'=>'gears','genderless'=>'genderless','get-pocket'=>'get-pocket','gg'=>'gg','gg-circle'=>'gg-circle','gift'=>'gift','git'=>'git','git-square'=>'git-square','github'=>'github','github-alt'=>'github-alt','github-square'=>'github-square','gittip'=>'gittip','globe'=>'globe','google'=>'google','google-plus'=>'google-plus','google-plus-square'=>'google-plus-square','google-wallet'=>'google-wallet','group'=>'group','h-square'=>'h-square','hand-grab-o'=>'hand-grab-o','hand-lizard-o'=>'hand-lizard-o','hand-o-down'=>'hand-o-down','hand-o-left'=>'hand-o-left','hand-o-right'=>'hand-o-right','hand-o-up'=>'hand-o-up','hand-peace-o'=>'hand-peace-o','hand-pointer-o'=>'hand-pointer-o','hand-scissors-o'=>'hand-scissors-o','hand-spock-o'=>'hand-spock-o','hand-stop-o'=>'hand-stop-o','hdd-o'=>'hdd-o','header'=>'header','headphones'=>'headphones','heart'=>'heart','heart-o'=>'heart-o','heartbeat'=>'heartbeat','history'=>'history','home'=>'home','hospital-o'=>'hospital-o','hotel'=>'hotel','hourglass'=>'hourglass','hourglass-1'=>'hourglass-1','hourglass-2'=>'hourglass-2','hourglass-3'=>'hourglass-3','hourglass-o'=>'hourglass-o','houzz'=>'houzz','html5'=>'html5','i-cursor'=>'i-cursor','inbox'=>'inbox','indent'=>'indent','industry'=>'industry','info'=>'info','info-circle'=>'info-circle','instagram'=>'instagram','institution'=>'institution','internet-explorer'=>'internet-explorer','intersex'=>'intersex','ioxhost'=>'ioxhost','italic'=>'italic','joomla'=>'joomla','jsfiddle'=>'jsfiddle','key'=>'key','keyboard-o'=>'keyboard-o','language'=>'language','laptop'=>'laptop','lastfm'=>'lastfm','lastfm-square'=>'lastfm-square','leaf'=>'leaf','leanpub'=>'leanpub','legal'=>'legal','lemon-o'=>'lemon-o','level-down'=>'level-down','level-up'=>'level-up','lg{font-size'=>'lg{font-size','life-bouy'=>'life-bouy','lightbulb-o'=>'lightbulb-o','line-chart'=>'line-chart','linkedin'=>'linkedin','linkedin-square'=>'linkedin-square','linux'=>'linux','list'=>'list','list-alt'=>'list-alt','list-ol'=>'list-ol','list-ul'=>'list-ul','location-arrow'=>'location-arrow','lock'=>'lock','long-arrow-down'=>'long-arrow-down','long-arrow-left'=>'long-arrow-left','long-arrow-right'=>'long-arrow-right','long-arrow-up'=>'long-arrow-up','magic'=>'magic','magnet'=>'magnet','mail-forward'=>'mail-forward','mail-reply'=>'mail-reply','mail-reply-all'=>'mail-reply-all','male'=>'male','map'=>'map','map-marker'=>'map-marker','map-o'=>'map-o','map-pin'=>'map-pin','map-signs'=>'map-signs','mars'=>'mars','mars-double'=>'mars-double','mars-stroke'=>'mars-stroke','mars-stroke-h'=>'mars-stroke-h','mars-stroke-v'=>'mars-stroke-v','maxcdn'=>'maxcdn','meanpath'=>'meanpath','medium'=>'medium','medkit'=>'medkit','meh-o'=>'meh-o','mercury'=>'mercury','microphone'=>'microphone','microphone-slash'=>'microphone-slash','minus'=>'minus','minus-circle'=>'minus-circle','minus-square'=>'minus-square','minus-square-o'=>'minus-square-o','mobile-phone'=>'mobile-phone','money'=>'money','moon-o'=>'moon-o','mortar-board'=>'mortar-board','motorcycle'=>'motorcycle','mouse-pointer'=>'mouse-pointer','music'=>'music','navicon'=>'navicon','neuter'=>'neuter','newspaper-o'=>'newspaper-o','object-group'=>'object-group','object-ungroup'=>'object-ungroup','odnoklassniki'=>'odnoklassniki','odnoklassniki-square'=>'odnoklassniki-square','opencart'=>'opencart','openid'=>'openid','opera'=>'opera','optin-monster'=>'optin-monster','pagelines'=>'pagelines','paint-brush'=>'paint-brush','paperclip'=>'paperclip','paragraph'=>'paragraph','paste'=>'paste','pause'=>'pause','paw'=>'paw','paypal'=>'paypal','pencil'=>'pencil','pencil-square'=>'pencil-square','phone'=>'phone','phone-square'=>'phone-square','photo'=>'photo','pie-chart'=>'pie-chart','pied-piper'=>'pied-piper','pied-piper-alt'=>'pied-piper-alt','pinterest'=>'pinterest','pinterest-p'=>'pinterest-p','pinterest-square'=>'pinterest-square','plane'=>'plane','play'=>'play','play-circle'=>'play-circle','play-circle-o'=>'play-circle-o','plug'=>'plug','plus'=>'plus','plus-circle'=>'plus-circle','plus-square'=>'plus-square','plus-square-o'=>'plus-square-o','power-off'=>'power-off','print'=>'print','puzzle-piece'=>'puzzle-piece','qq'=>'qq','qrcode'=>'qrcode','question'=>'question','question-circle'=>'question-circle','quote-left'=>'quote-left','quote-right'=>'quote-right','ra'=>'ra','random'=>'random','recycle'=>'recycle','reddit'=>'reddit','reddit-square'=>'reddit-square','refresh'=>'refresh','registered'=>'registered','remove'=>'remove','renren'=>'renren','retweet'=>'retweet','road'=>'road','rocket'=>'rocket','rotate-left'=>'rotate-left','rotate-right'=>'rotate-right','rss-square'=>'rss-square','ruble'=>'ruble','rupee'=>'rupee','safari'=>'safari','save'=>'save','search'=>'search','search-minus'=>'search-minus','search-plus'=>'search-plus','sellsy'=>'sellsy','send'=>'send','send-o'=>'send-o','server'=>'server','share-alt'=>'share-alt','share-alt-square'=>'share-alt-square','share-square'=>'share-square','share-square-o'=>'share-square-o','shekel'=>'shekel','shield'=>'shield','ship'=>'ship','shirtsinbulk'=>'shirtsinbulk','shopping-cart'=>'shopping-cart','sign-in'=>'sign-in','sign-out'=>'sign-out','signal'=>'signal','simplybuilt'=>'simplybuilt','sitemap'=>'sitemap','skyatlas'=>'skyatlas','skype'=>'skype','slack'=>'slack','sliders'=>'sliders','slideshare'=>'slideshare','smile-o'=>'smile-o','soccer-ball-o'=>'soccer-ball-o','sort-alpha-asc'=>'sort-alpha-asc','sort-alpha-desc'=>'sort-alpha-desc','sort-amount-asc'=>'sort-amount-asc','sort-amount-desc'=>'sort-amount-desc','sort-down'=>'sort-down','sort-numeric-asc'=>'sort-numeric-asc','sort-numeric-desc'=>'sort-numeric-desc','sort-up'=>'sort-up','soundcloud'=>'soundcloud','space-shuttle'=>'space-shuttle','spinner'=>'spinner','spoon'=>'spoon','spotify'=>'spotify','square'=>'square','square-o'=>'square-o','stack-exchange'=>'stack-exchange','stack-overflow'=>'stack-overflow','star'=>'star','star-half'=>'star-half','star-half-empty'=>'star-half-empty','star-o'=>'star-o','steam'=>'steam','steam-square'=>'steam-square','step-backward'=>'step-backward','step-forward'=>'step-forward','stethoscope'=>'stethoscope','sticky-note'=>'sticky-note','sticky-note-o'=>'sticky-note-o','stop'=>'stop','street-view'=>'street-view','strikethrough'=>'strikethrough','stumbleupon'=>'stumbleupon','stumbleupon-circle'=>'stumbleupon-circle','subscript'=>'subscript','subway'=>'subway','suitcase'=>'suitcase','sun-o'=>'sun-o','superscript'=>'superscript','table'=>'table','tablet'=>'tablet','tag'=>'tag','tags'=>'tags','tasks'=>'tasks','tencent-weibo'=>'tencent-weibo','terminal'=>'terminal','text-height'=>'text-height','text-width'=>'text-width','th'=>'th','th-large'=>'th-large','th-list'=>'th-list','thumb-tack'=>'thumb-tack','thumbs-down'=>'thumbs-down','thumbs-o-down'=>'thumbs-o-down','thumbs-o-up'=>'thumbs-o-up','thumbs-up'=>'thumbs-up','ticket'=>'ticket','times-circle'=>'times-circle','times-circle-o'=>'times-circle-o','tint'=>'tint','toggle-down'=>'toggle-down','toggle-left'=>'toggle-left','toggle-off'=>'toggle-off','toggle-on'=>'toggle-on','toggle-right'=>'toggle-right','toggle-up'=>'toggle-up','trademark'=>'trademark','train'=>'train','transgender-alt'=>'transgender-alt','trash'=>'trash','trash-o'=>'trash-o','tree'=>'tree','trello'=>'trello','tripadvisor'=>'tripadvisor','trophy'=>'trophy','truck'=>'truck','tty'=>'tty','tumblr'=>'tumblr','tumblr-square'=>'tumblr-square','turkish-lira'=>'turkish-lira','tv'=>'tv','twitch'=>'twitch','twitter'=>'twitter','twitter-square'=>'twitter-square','umbrella'=>'umbrella','underline'=>'underline','unlink'=>'unlink','unlock'=>'unlock','unlock-alt'=>'unlock-alt','unsorted'=>'unsorted','upload'=>'upload','user'=>'user','user-md'=>'user-md','user-plus'=>'user-plus','user-secret'=>'user-secret','user-times'=>'user-times','venus'=>'venus','venus-double'=>'venus-double','venus-mars'=>'venus-mars','viacoin'=>'viacoin','video-camera'=>'video-camera','vimeo'=>'vimeo','vimeo-square'=>'vimeo-square','vine'=>'vine','vk'=>'vk','volume-down'=>'volume-down','volume-off'=>'volume-off','volume-up'=>'volume-up','warning'=>'warning','wechat'=>'wechat','weibo'=>'weibo','whatsapp'=>'whatsapp','wheelchair'=>'wheelchair','wifi'=>'wifi','wikipedia-w'=>'wikipedia-w','windows'=>'windows','won'=>'won','wordpress'=>'wordpress','wrench'=>'wrench','xing'=>'xing','xing-square'=>'xing-square','y-combinator-square'=>'y-combinator-square','yahoo'=>'yahoo','yc'=>'yc','yelp'=>'yelp','youtube'=>'youtube','youtube-play'=>'youtube-play','youtube-square'=>'youtube-square',);
	}
	
	/**
	 * Get random page id
	 */
	function random_page() {
		$pages = get_pages(); //grab list of pages array - Cf. http://codex.wordpress.org/Function_Reference/get_pages 
		if ($pages) {
			shuffle($pages); //random it

			return absint( $pages[0]->ID );
		} else {
			return;
		}
		

	}
}
