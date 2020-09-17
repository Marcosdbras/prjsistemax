<?php
/**
 * Content Widget: Services Widget
 */
if ( !class_exists( 'Envo_Multipurpose_Content_Widget_Services' ) ) :

	/**
	 * Class: Display Services
	 *
	 */
	class Envo_Multipurpose_Content_Widget_Services extends Envo_Multipurpose_Widget {

		/**
		 * __construct
		 *
		 */
		public function __construct() {
			$this->widget_id			 = 'envo-multipurpose-content-widget-services';
			$this->widget_description	 = esc_html__( 'Displays services on your widgetized page.', 'envo-multipurpose' );
			$this->widget_name			 = esc_html__( 'EM: Services', 'envo-multipurpose' );
			$this->settings				 = array(
				'panels'	 => array(
					array(
						'title'	 => esc_html__( 'Services settings', 'envo-multipurpose' ),
						'fields' => array(
							'title'				 => array(
								'type'		 => 'text',
								'std'		 => '',
								'label'		 => esc_html__( 'Title', 'envo-multipurpose' ),
								'sanitize'	 => 'text',
							),
							'subtitle'			 => array(
								'type'		 => 'text',
								'std'		 => '',
								'label'		 => esc_html__( 'Subtitle', 'envo-multipurpose' ),
								'sanitize'	 => 'text',
							),
							'heading_style'		 => array(
								'type'		 => 'select',
								'std'		 => 'cover',
								'label'		 => esc_html__( 'Heading style:', 'envo-multipurpose' ),
								'options'	 => $this->options_title_style(),
								'sanitize'	 => 'text',
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
								'label'		 => esc_html__( 'Pause slideshow when hovering', 'envo-multipurpose' ),
								'sanitize'	 => 'checkbox',
							),
							'slider_controls'	 => array(
								'type'		 => 'checkbox',
								'std'		 => 1,
								'label'		 => esc_html__( 'Show slide arrows', 'envo-multipurpose' ),
								'sanitize'	 => 'checkbox',
							),
							'slider_pager'		 => array(
								'type'		 => 'checkbox',
								'std'		 => 0,
								'label'		 => esc_html__( 'Show slide pagination', 'envo-multipurpose' ),
								'sanitize'	 => 'checkbox',
							),
							'background_color'	 => array(
								'type'		 => 'colorpicker',
								'std'		 => '#4f4f4f',
								'label'		 => esc_html__( 'Background color:', 'envo-multipurpose' ),
								'sanitize'	 => 'color',
							),
							'text_color'		 => array(
								'type'		 => 'colorpicker',
								'std'		 => '#fff',
								'label'		 => esc_html__( 'Text color:', 'envo-multipurpose' ),
								'sanitize'	 => 'color',
							),
							'padding_top'		 => array(
								'type'		 => 'number',
								'std'		 => 0,
								'step'		 => 1,
								'min'		 => 0,
								'max'		 => 300,
								'label'		 => esc_html__( 'Top padding:', 'envo-multipurpose' ),
								'sanitize'	 => 'number',
							),
							'padding_bottom'	 => array(
								'type'		 => 'number',
								'std'		 => 0,
								'step'		 => 1,
								'min'		 => 0,
								'max'		 => 300,
								'label'		 => esc_html__( 'Bottom padding:', 'envo-multipurpose' ),
								'sanitize'	 => 'number',
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
						'page'				 => array(
							'type'			 => 'page',
							'std'			 => $this->random_page(),
							'label'			 => esc_html__( 'Select page:', 'envo-multipurpose' ),
							'description'	 => esc_html__( 'The post content will be grabbed from the selected post.', 'envo-multipurpose' ),
							'sanitize'		 => 'text',
						),
						'icon'				 => array(
							'type'		 => 'select',
							'std'		 => '',
							'label'		 => esc_html__( 'Icon:', 'envo-multipurpose' ),
							'options'	 => $this->fontawesome_icons(),
							'sanitize'	 => 'text',
						),
						'icon_color'		 => array(
							'type'			 => 'colorpicker',
							'std'			 => '',
							'label'			 => esc_html__( 'Icon color:', 'envo-multipurpose' ),
							'description'	 => esc_html__( 'Leave blank to use default theme color.', 'envo-multipurpose' ),
							'sanitize'		 => 'color',
						),
						'page_excerpt'		 => array(
							'type'		 => 'number',
							'std'		 => 20,
							'step'		 => 1,
							'min'		 => 0,
							'max'		 => 150,
							'label'		 => esc_html__( 'Content length:', 'envo-multipurpose' ),
							'sanitize'	 => 'number',
						),
						'text_color'		 => array(
							'type'			 => 'colorpicker',
							'std'			 => '',
							'label'			 => esc_html__( 'Text color:', 'envo-multipurpose' ),
							'description'	 => esc_html__( 'Leave blank to use default theme color.', 'envo-multipurpose' ),
							'sanitize'		 => 'color',
						),
						'background_color'	 => array(
							'type'			 => 'colorpicker',
							'std'			 => '',
							'label'			 => esc_html__( 'Background color:', 'envo-multipurpose' ),
							'description'	 => esc_html__( 'Leave blank to use default theme color.', 'envo-multipurpose' ),
							'sanitize'		 => 'color',
						),
						'button_text'		 => array(
							'type'		 => 'text',
							'std'		 => '',
							'label'		 => esc_html__( 'Button text:', 'envo-multipurpose' ),
							'sanitize'	 => 'text',
						),
						'button_link'		 => array(
							'type'		 => 'text',
							'std'		 => '',
							'label'		 => esc_html__( 'Button link:', 'envo-multipurpose' ),
							'sanitize'	 => 'url',
						),
						'button_style'		 => array(
							'type'		 => 'select',
							'std'		 => 'default',
							'label'		 => esc_html__( 'Button style:', 'envo-multipurpose' ),
							'options'	 => array(
								'default'	 => esc_html__( 'Default', 'envo-multipurpose' ),
								'button-1'	 => esc_html__( 'Rounded', 'envo-multipurpose' ),
							),
							'sanitize'	 => 'text',
						),
						'button_color'		 => array(
							'type'			 => 'colorpicker',
							'std'			 => '',
							'label'			 => esc_html__( 'Button color:', 'envo-multipurpose' ),
							'description'	 => esc_html__( 'Leave blank to use default theme color.', 'envo-multipurpose' ),
							'sanitize'		 => 'color',
						),
					),
					'default'	 => array(
						array(
							'page_excerpt'		 => '20',
							'text_color'		 => '#fff',
							'background_color'	 => '',
							'icon'				 => 'flash',
							'button_link'		 => home_url( '/' ),
							'button_text'		 => esc_html__( 'Read more', 'envo-multipurpose' ),
							'button_style'		 => 'default',
							'button_color'		 => '#fff',
						),
						array(
							'page_excerpt'		 => '20',
							'text_color'		 => '#fff',
							'background_color'	 => '#3abdff',
							'icon'				 => 'code',
							'button_link'		 => home_url( '/' ),
							'button_text'		 => esc_html__( 'Read more', 'envo-multipurpose' ),
							'button_color'		 => '#fff',
						),
						array(
							'page_excerpt'		 => '20',
							'text_color'		 => '#fff',
							'background_color'	 => '',
							'icon'				 => 'check',
							'button_link'		 => home_url( '/' ),
							'button_text'		 => esc_html__( 'Read more', 'envo-multipurpose' ),
							'button_color'		 => '#fff',
						),
						array(
							'page_excerpt'		 => '20',
							'text_color'		 => '#fff',
							'background_color'	 => '#3abdff',
							'icon'				 => 'shopping-cart',
							'button_link'		 => home_url( '/' ),
							'button_text'		 => esc_html__( 'Read more', 'envo-multipurpose' ),
							'button_color'		 => '#fff',
						),
					),
				),
			);

			parent::__construct();
		}

		/**
		 * Widget function.
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
			if ( !empty( $o[ 'background_color' ] ) ) {
				$style[] = 'background-color:' . $o[ 'background_color' ] . ';';
			}
			if ( !empty( $o[ 'text_color' ] ) ) {
				$style[] = 'color:' . $o[ 'text_color' ] . ';';
			}
			if ( !empty( $o[ 'padding_top' ] ) ) {
				$style[] = 'padding-top:' . $o[ 'padding_top' ] . 'px;';
			}

			if ( !empty( $o[ 'padding_bottom' ] ) ) {
				$style[] = 'padding-bottom:' . $o[ 'padding_bottom' ] . 'px;';
			}

			extract( $args );

			echo $before_widget; /* WPCS: XSS OK. HTML output. */

			if ( envo_multipurpose_check_widget( $this->id ) || is_page_template() || is_customize_preview() ) {
				?>

				<div id="etem-<?php echo esc_attr( $this->id ); ?>" class="etem-services <?php echo esc_attr( $o[ 'heading_style' ] ); ?>" style="<?php echo esc_attr( implode( '', $style ) ); ?>">
					<?php if ( !empty( $o[ 'title' ] ) || !empty( $o[ 'subtitle' ] ) ) { ?>
						<div class="etem-heading text-center container">
							<?php if ( !empty( $o[ 'title' ] ) ) { ?>
								<div class="etem-widget-title">
									<?php echo esc_html( $o[ 'title' ] ); ?>
								</div>
							<?php } ?>
							<?php if ( !empty( $o[ 'subtitle' ] ) ) { ?>
								<div class="etem-widget-subtitle">
									<?php echo esc_html( $o[ 'subtitle' ] ); ?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
					<div class="services-center container" data-id="etem-<?php echo esc_attr( $this->id ); ?>" data-sliderauto="<?php echo esc_attr( $o[ 'slider_auto' ] ); ?>" data-sliderpause="<?php echo esc_attr( $o[ 'slider_pause' ] ); ?>" data-sliderautohover="<?php echo esc_attr( $o[ 'slider_autohover' ] ); ?>" data-slidercontrols="<?php echo esc_attr( $o[ 'slider_controls' ] ); ?>" data-sliderpager="<?php echo esc_attr( $o[ 'slider_pager' ] ); ?>" data-slideritems="3">
						<?php foreach ( $o[ 'repeater' ] as $key => $slide_setting ) : ?>
							<div class="services-item">
								<?php $this->widget_get_slide( $slide_setting ); ?>
							</div>
							<?php unset( $repeater[ $key ] ); ?>
						<?php endforeach; ?>
					</div>
				</div>


			<?php } elseif ( current_user_can( 'edit_theme_options' ) ) {
				?>
				<div class="text-center h3">
					<?php
					/* translators: %1$s: widget name %1$s: sidebar name */
					printf( esc_html__( 'You can only display the %1$s widget in the %2$s sidebar.', 'envo-multipurpose' ), $this->name, __( 'Homepage Widgetized Area', 'envo-multipurpose' ) );
					?>
				</div>
				<?php
			}
			echo $after_widget; /* WPCS: XSS OK. HTML output. */
		}

		/**
		 * Generate slide HTML
		 */
		function widget_get_slide( $slide_setting ) {

			$p = null;

			if ( !empty( $slide_setting[ 'page' ] ) ) {
				$p = get_post( $slide_setting[ 'page' ] );
			}

			$tag			 = 'div';
			$classes[]		 = 'slide-inner';
			$attr			 = array();
			$style			 = array();
			$text_style		 = array();
			$button_color	 = '';
			$icon_color		 = '';
			$text_class		 = '';
			$excerpt		 = '';

			if ( !empty( $slide_setting[ 'page_excerpt' ] ) ) {
				$excerpt = $slide_setting[ 'page_excerpt' ];
			}
			if ( !empty( $slide_setting[ 'button_color' ] ) ) {
				$button_color = 'color:' . $slide_setting[ 'button_color' ] . ';';
			}
			if ( !empty( $slide_setting[ 'icon_color' ] ) ) {
				$icon_color = 'style="color:' . esc_attr( $slide_setting[ 'icon_color' ] ) . '"';
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

			if ( !empty( $style ) ) {
				$attr[] = 'style="' . esc_attr( implode( '', $style ) ) . '"';
			}

			if ( !empty( $classes ) ) {
				$attr[] = 'class="' . esc_attr( implode( ' ', $classes ) ) . '"';
			}
			?>

			<div <?php echo implode( ' ', $attr ); /* WPCS: XSS OK. Escaped above. */ ?>>

				<div class="services-wrapper text-center<?php echo esc_attr( $text_class ); ?>" style="<?php echo esc_attr( implode( '', $text_style ) ); ?>">
					<?php if ( !empty( $slide_setting[ 'icon' ] ) ) : ?>
						<div class="services-icon" <?php echo $icon_color; /* WPCS: XSS OK. Escaped above. */ ?>>
							<i class="fa fa-<?php echo esc_attr( $slide_setting[ 'icon' ] ); ?>" ></i>
						</div>
					<?php endif; ?>
					<?php if ( $p && isset( $p->post_title ) ) : ?>
						<?php if ( !empty( $p->post_title ) ) : ?>
							<div class="services-title h2">
								<?php echo esc_html( $p->post_title ); ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( $p && isset( $p->post_content ) ) : ?>
						<?php if ( !empty( $p->post_content ) ) : ?>
							<div class="services-text">
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
		 */
		public static function register() {
			register_widget( __CLASS__ );
		}

	}

	endif;

add_action( 'widgets_init', array( 'Envo_Multipurpose_Content_Widget_Services', 'register' ) );	