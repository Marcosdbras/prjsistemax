<?php
/**
 * Content Widget: Slider Widget
 */
if ( !class_exists( 'Envo_Multipurpose_Content_Widget_Slider' ) ) :

	/**
	 * Class: Display Slider
	 *
	 */
	class Envo_Multipurpose_Content_Widget_Slider extends Envo_Multipurpose_Widget {

		/**
		 * __construct
		 *
		 */
		public function __construct() {
			$this->widget_id			 = 'envo-multipurpose-content-widget-slider';
			$this->widget_description	 = esc_html__( 'Displays a slider on your widgetized page.', 'envo-multipurpose' );
			$this->widget_name			 = esc_html__( 'EM: Slider', 'envo-multipurpose' );
			$this->settings				 = array(
				'panels'	 => array(
					array(
						'title'	 => esc_html__( 'Slider settings', 'envo-multipurpose' ),
						'fields' => array(
							'slider_mode'		 => array(
								'type'		 => 'select',
								'std'		 => 'horizontal',
								'label'		 => esc_html__( 'Transition effect:', 'envo-multipurpose' ),
								'options'	 => array(
									'false'	 => esc_html__( 'Slide', 'envo-multipurpose' ),
									'true'	 => esc_html__( 'Fade', 'envo-multipurpose' ),
								),
								'sanitize'	 => 'text',
							),
							'slider_height'		 => array(
								'type'		 => 'number',
								'std'		 => 600,
								'step'		 => 10,
								'min'		 => 250,
								'max'		 => 1000,
								'label'		 => esc_html__( 'Slider height', 'envo-multipurpose' ),
								'sanitize'	 => 'number',
							),
							'slider_pause'		 => array(
								'type'		 => 'number',
								'std'		 => 9,
								'step'		 => 1,
								'min'		 => 1,
								'max'		 => 100,
								'label'		 => esc_html__( 'Slideshow speed in seconds:', 'envo-multipurpose' ),
								'sanitize'	 => 'number',
							),
							'slider_auto'		 => array(
								'type'		 => 'checkbox',
								'std'		 => 1,
								'label'		 => esc_html__( 'Auto start', 'envo-multipurpose' ),
								'sanitize'	 => 'checkbox',
							),
							'slider_autohover'	 => array(
								'type'		 => 'checkbox',
								'std'		 => 1,
								'label'		 => esc_html__( 'Pause when hovering', 'envo-multipurpose' ),
								'sanitize'	 => 'checkbox',
							),
							'slider_controls'	 => array(
								'type'		 => 'checkbox',
								'std'		 => 1,
								'label'		 => esc_html__( 'Show arrows?', 'envo-multipurpose' ),
								'sanitize'	 => 'checkbox',
							),
							'slider_pager'		 => array(
								'type'		 => 'checkbox',
								'std'		 => 1,
								'label'		 => esc_html__( 'Show pagination?', 'envo-multipurpose' ),
								'sanitize'	 => 'checkbox',
							),
							'margin_bottom'		 => array(
								'type'		 => 'number',
								'std'		 => 0,
								'step'		 => 1,
								'min'		 => 0,
								'max'		 => 300,
								'label'		 => esc_html__( 'Bottom margin:', 'envo-multipurpose' ),
								'sanitize'	 => 'number',
							),
						),
					),
				),
				'repeater'	 => array(
					'title'		 => esc_html__( 'Slide', 'envo-multipurpose' ),
					'fields'	 => array(
						'page'						 => array(
							'type'			 => 'page',
							'std'			 => $this->random_page(),
							'label'			 => esc_html__( 'Select page:', 'envo-multipurpose' ),
							'description'	 => esc_html__( 'The page content and featured image will be grabbed from the selected page. If no featured image is set the section will display only the selected background color.', 'envo-multipurpose' ),
							'sanitize'		 => 'text',
						),
						'page_excerpt'				 => array(
							'type'		 => 'number',
							'std'		 => 50,
							'step'		 => 1,
							'min'		 => 0,
							'max'		 => 150,
							'label'		 => esc_html__( 'Content length:', 'envo-multipurpose' ),
							'sanitize'	 => 'number',
						),
						'content_align'				 => array(
							'type'		 => 'select',
							'std'		 => 'default',
							'label'		 => esc_html__( 'Content align:', 'envo-multipurpose' ),
							'options'	 => array(
								'left'	 => esc_html__( 'Left', 'envo-multipurpose' ),
								'center' => esc_html__( 'Center', 'envo-multipurpose' ),
								'right'	 => esc_html__( 'Right', 'envo-multipurpose' ),
							),
							'sanitize'	 => 'text',
						),
						'background_color'			 => array(
							'type'		 => 'colorpicker',
							'std'		 => '',
							'label'		 => esc_html__( 'Background color:', 'envo-multipurpose' ),
							'sanitize'	 => 'color',
						),
						'background_size'			 => array(
							'type'		 => 'select',
							'std'		 => 'cover',
							'label'		 => esc_html__( 'Background size:', 'envo-multipurpose' ),
							'options'	 => $this->options_background_size(),
							'sanitize'	 => 'background_size',
						),
						'text_color'				 => array(
							'type'			 => 'colorpicker',
							'std'			 => '',
							'label'			 => esc_html__( 'Text color:', 'envo-multipurpose' ),
							'description'	 => esc_html__( 'Leave blank to use default theme color.', 'envo-multipurpose' ),
							'sanitize'		 => 'color',
						),
						'text_background_color'		 => array(
							'type'			 => 'colorpicker',
							'std'			 => '',
							'label'			 => esc_html__( 'Text background color:', 'envo-multipurpose' ),
							'description'	 => esc_html__( 'Leave blank to use default theme color.', 'envo-multipurpose' ),
							'sanitize'		 => 'color',
						),
						'text_background_opacity'	 => array(
							'type'		 => 'number',
							'std'		 => '80',
							'step'		 => '1',
							'min'		 => '0',
							'max'		 => '100',
							'label'		 => esc_html__( 'Text background color opacity:', 'envo-multipurpose' ),
							'sanitize'	 => 'absint',
						),
						'button_text'				 => array(
							'type'		 => 'text',
							'std'		 => esc_html__( 'Read more', 'envo-multipurpose' ),
							'label'		 => esc_html__( 'Button text:', 'envo-multipurpose' ),
							'sanitize'	 => 'text',
						),
						'button_link'				 => array(
							'type'		 => 'text',
							'std'		 => '#',
							'label'		 => esc_html__( 'Button link:', 'envo-multipurpose' ),
							'sanitize'	 => 'url',
						),
						'button_style'				 => array(
							'type'		 => 'select',
							'std'		 => 'default',
							'label'		 => esc_html__( 'Button style:', 'envo-multipurpose' ),
							'options'	 => array(
								'default'	 => esc_html__( 'Default', 'envo-multipurpose' ),
								'button-1'	 => esc_html__( 'Rounded', 'envo-multipurpose' ),
							),
							'sanitize'	 => 'text',
						),
						'button_color'				 => array(
							'type'			 => 'colorpicker',
							'std'			 => '',
							'label'			 => esc_html__( 'Button color:', 'envo-multipurpose' ),
							'description'	 => esc_html__( 'Leave blank to use default theme color.', 'envo-multipurpose' ),
							'sanitize'		 => 'color',
						),
					),
					'default'	 => array(
						array(
							'page_excerpt'				 => '50',
							'content_align'				 => 'center',
							'background_color'			 => '#ffffff',
							'background_size'			 => 'cover',
							'text_color'				 => '',
							'text_background_color'		 => '#ffffff',
							'text_background_opacity'	 => '70',
							'button_link'				 => home_url( '/' ),
							'button_style'				 => 'default',
							'button_color'				 => '',
						),
						array(
							'page_excerpt'				 => '50',
							'content_align'				 => 'left',
							'background_color'			 => '#ffffff',
							'background_size'			 => 'cover',
							'text_background_color'		 => '#ffffff',
							'text_background_opacity'	 => '70',
							'button_link'				 => home_url( '/' ),
						),
						array(
							'page_excerpt'				 => '50',
							'content_align'				 => 'right',
							'background_color'			 => '#ffffff',
							'background_size'			 => 'cover',
							'text_background_color'		 => '#ffffff',
							'text_background_opacity'	 => '70',
							'button_link'				 => home_url( '/' ),
						),
					),
				),
			);

			parent::__construct();
		}

		/**
		 * Widget function.
		 *
		 */
		function widget( $args, $instance ) {

				wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), ENVO_MULTIPURPOSE_VERSION, true );
				wp_enqueue_style( 'slick-stylesheet', get_template_directory_uri() . '/css/slick.css', array(), ENVO_MULTIPURPOSE_VERSION );

			$o = $this->sanitize( $instance );

			if ( (!isset( $o[ 'repeater' ] ) ) || !is_array( $o[ 'repeater' ] ) ) {
				return;
			}

			$repeater = $o[ 'repeater' ];

			$style = array();
			if ( !empty( $o[ 'margin_bottom' ] ) ) {
				$style[] = 'margin-bottom:' . $o[ 'margin_bottom' ] . 'px;';
			}

			$height_style = array();
			if ( !empty( $o[ 'slider_height' ] ) ) {
				$height_style[] = 'height:' . $o[ 'slider_height' ] . 'px;';
				$style[] = 'height:' . $o[ 'slider_height' ] . 'px;';
			}

			extract( $args );

			echo $before_widget; /* WPCS: XSS OK. HTML output. */
			if ( envo_multipurpose_check_widget( $this->id ) || is_page_template() || is_customize_preview() ) {
			?>

			<div id="etem-<?php echo esc_attr( $this->id ); ?>" class="etem-slider" style="<?php echo esc_attr( implode( '', $style ) ); ?>">
				<div class="slider-center" data-id="etem-<?php echo esc_attr( $this->id ); ?>" data-sliderauto="<?php echo esc_attr( $o[ 'slider_auto' ] ); ?>" data-slidermode="<?php echo esc_attr( $o[ 'slider_mode' ] ); ?>" data-sliderpause="<?php echo esc_attr( $o[ 'slider_pause' ] ); ?>" data-sliderautohover="<?php echo esc_attr( $o[ 'slider_autohover' ] ); ?>" data-slidercontrols="<?php echo esc_attr( $o[ 'slider_controls' ] ); ?>" data-sliderpager="<?php echo esc_attr( $o[ 'slider_pager' ] ); ?>">
					<?php foreach ( $o[ 'repeater' ] as $key => $slide_setting ) : ?>
						<div class="slider-item" style="<?php echo esc_attr( implode( '', $height_style ) ); ?>">
							<?php $this->widget_get_slide( $slide_setting ); ?>
						</div>
						<?php unset( $repeater[ $key ] ); ?>
					<?php endforeach; ?>
				</div>
			</div>


			<?php } elseif ( current_user_can( 'edit_theme_options' ) ) { ?>
				<div class="text-center h3">
					<?php
					/* translators: %1$s: widget name %1$s: sidebar name */
					printf( esc_html__( 'You can only display the %1$s widget in the %2$s sidebar.', 'envo-multipurpose' ), $this->name, __( 'Homepage Widgetized Area', 'envo-multipurpose' ) ); 
					?>
				</div>
			<?php } 
			
			echo $after_widget; /* WPCS: XSS OK. HTML output. */
		}

		/**
		 * Generate slide HTML
		 *
		 */
		function widget_get_slide( $slide_setting ) {

			$p					 = null;
			$featured_image_url	 = null;

			if ( !empty( $slide_setting[ 'page' ] ) ) {
				$p = get_post( $slide_setting[ 'page' ] );
			}
			$featured_image_url = get_the_post_thumbnail_url( $p->ID, 'full' );

			$tag			 = 'div';
			$classes[]		 = 'slide-inner';
			$attr			 = array();
			$style			 = array();
			$text_style		 = array();
			$button_color	 = '';
			$text_class		 = '';
			$excerpt		 = '';

			if ( !empty( $slide_setting[ 'page_excerpt' ] ) ) {
				$excerpt = $slide_setting[ 'page_excerpt' ];
			}
			if ( !empty( $slide_setting[ 'button_color' ] ) ) {
				$button_color = 'color:' . $slide_setting[ 'button_color' ] . ';';
			}
			if ( !empty( $featured_image_url ) ) {
				$style[] = 'background-image:url(\'' . esc_url( $featured_image_url ) . '\');';
			}

			if ( !empty( $slide_setting[ 'background_size' ] ) ) {
				$style[] = 'background-size:' . $this->get_background_size( $slide_setting[ 'background_size' ] ) . ';';
			}

			if ( !empty( $slide_setting[ 'background_color' ] ) ) {
				$style[] = 'background-color:' . $slide_setting[ 'background_color' ] . ';';
			}

			if ( !empty( $slide_setting[ 'text_color' ] ) ) {
				$text_style[] = 'color:' . $slide_setting[ 'text_color' ] . ';';
				$text_class .= ' custom-color';
			} else {
				$text_class .= ' no-custom-color';
			}

			if ( !empty( $slide_setting[ 'content_align' ] ) ) {
				$text_class .= ' text-' . $slide_setting[ 'content_align' ];
			}

			if ( !empty( $slide_setting[ 'text_background_color' ] ) ) {
				$rgb			 = $this->hex2rgb( $slide_setting[ 'text_background_color' ] );
				$opacity		 = absint( $slide_setting[ 'text_background_opacity' ] ) / 100;
				$text_style[]	 = 'background-color: rgb(' . $rgb[ 'red' ] . ',' . $rgb[ 'green' ] . ',' . $rgb[ 'blue' ] . ');';
				$text_style[]	 = 'background-color: rgba(' . $rgb[ 'red' ] . ',' . $rgb[ 'green' ] . ',' . $rgb[ 'blue' ] . ',' . $opacity . ');';
				$text_class .= ' text-background-color';
			} else {
				$text_class .= ' no-text-background-color';
			}

			if ( !empty( $style ) ) {
				$attr[] = 'style="' . esc_attr( implode( '', $style ) ) . '"';
			}

			if ( !empty( $classes ) ) {
				$attr[] = 'class="' . esc_attr( implode( ' ', $classes ) ) . '"';
			}
			?>

			<div <?php echo implode( ' ', $attr ); /* WPCS: XSS OK. Escaped above. */ ?>>

				<div class="slider-wrapper container<?php echo esc_attr( $text_class ); ?>" style="<?php echo esc_attr( implode( '', $text_style ) ); ?>">
					<?php if ( $p && isset( $p->post_title ) ) : ?>
						<?php if ( !empty( $p->post_title ) ) : ?>
							<div class="slider-title">
								<?php echo esc_html( $p->post_title ); ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( $p && isset( $p->post_content ) ) : ?>
						<?php if ( !empty( $p->post_content ) ) : ?>
							<div class="slider-text">
								<?php
								$content = envo_multipurpose_get_the_excerpt( absint( $excerpt ), $p );
								echo wp_kses_post( $content ) ? wp_kses_post( wpautop( $content ) ) : '';
								?>
							</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( !empty( $slide_setting[ 'button_link' ] ) && !empty( $slide_setting[ 'button_text' ] ) ) : ?>

						<div class="button-text">
							<a class="button etem-button <?php echo esc_attr( $slide_setting[ 'button_style' ] ); ?>" href="<?php echo esc_url( $slide_setting[ 'button_link' ] ); ?>" style="<?php echo esc_attr( $button_color ); ?>">
								<?php echo esc_html( $slide_setting[ 'button_text' ] ); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>

			</div>
			<?php
		}

		/**
		 * Registers the widget with the WordPress Widget API.
		 *
		 */
		public static function register() {
			register_widget( __CLASS__ );
		}

	}

	endif;

add_action( 'widgets_init', array( 'Envo_Multipurpose_Content_Widget_Slider', 'register' ) );	