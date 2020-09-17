<?php
/**
 * Content Widget: Static Content Widget
 *
 */
if ( !class_exists( 'Envo_Multipurpose_Content_Widget_Static_Content' ) ) :

	/**
	 * Class: Display static content from an specific page.
	 *
	 */
	class Envo_Multipurpose_Content_Widget_Static_Content extends Envo_Multipurpose_Widget {

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->widget_id			 = 'envo-multipurpose-widget-static-content';
			$this->widget_description	 = esc_html__( 'Displays content from a specified page on your widgetized page.', 'envo-multipurpose' );
			$this->widget_name			 = esc_html__( 'EM: Static content', 'envo-multipurpose' );
			$this->settings				 = array(
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
				'page'				 => array(
					'type'			 => 'page',
					'std'			 => $this->random_page(),
					'label'			 => esc_html__( 'Select page:', 'envo-multipurpose' ),
					'description'	 => esc_html__( 'The page content and featured image will be grabbed from the selected page. If no featured image is set the section will display only the selected background color.', 'envo-multipurpose' ),
					'sanitize'		 => 'text',
				),
				'background_size'	 => array(
					'type'		 => 'select',
					'std'		 => 'cover',
					'label'		 => esc_html__( 'Background size:', 'envo-multipurpose' ),
					'options'	 => $this->options_background_size(),
					'sanitize'	 => 'background_size',
				),
				'background_color'	 => array(
					'type'		 => 'colorpicker',
					'std'		 => '#ffffff',
					'label'		 => esc_html__( 'Background color:', 'envo-multipurpose' ),
					'sanitize'	 => 'color',
				),
				'background_overlay' => array(
					'type'		 => 'select',
					'std'		 => '',
					'label'		 => esc_html__( 'Background overlay:', 'envo-multipurpose' ),
					'options'	 => $this->image_overlay(),
					'sanitize'	 => 'text',
				),
				'youtube_id'		 => array(
					'type'		 => 'text',
					'std'		 => '',
					'label'		 => esc_html__( 'YouTube video ID (eg. Fk9EBOOAYiU)', 'envo-multipurpose' ),
					'sanitize'	 => 'text',
				),
				'text_color'		 => array(
					'type'		 => 'colorpicker',
					'std'		 => '',
					'label'		 => esc_html__( 'Text color:', 'envo-multipurpose' ),
					'sanitize'	 => 'color',
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
				'padding_top'		 => array(
					'type'		 => 'number',
					'std'		 => 60,
					'step'		 => 1,
					'min'		 => 0,
					'max'		 => 300,
					'label'		 => esc_html__( 'Top padding:', 'envo-multipurpose' ),
					'sanitize'	 => 'number',
				),
				'padding_bottom'	 => array(
					'type'		 => 'number',
					'std'		 => 60,
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
			);
			
			parent::__construct();
		}

		/**
		 * Widget function.
		 *
		 */
		function widget( $args, $instance ) {

			$o = $this->sanitize( $instance );

			extract( $args );
			if ( !empty( $o[ 'youtube_id' ] ) ) {
				wp_enqueue_script( 'youtube-backgrounds', get_template_directory_uri() . '/js/jquery.youtubebackground.js', array( 'jquery' ), ENVO_MULTIPURPOSE_VERSION, true );
			}
			$post				 = null; /* no default page is set for starter-content. */
			$featured_image_url	 = null;

			if ( !empty( $o[ 'page' ] ) ) {
				$post				 = new WP_Query( array( 'page_id' => $o[ 'page' ] ) );
				$featured_image_url	 = get_the_post_thumbnail_url( $o[ 'page' ], 'full' );
			}

			$style			 = array();
			$bg_style		 = array();
			$classes[]		 = '';
			$button_color	 = '';

			if ( !empty( $o[ 'padding_top' ] ) ) {
				$style[] = 'padding-top:' . $o[ 'padding_top' ] . 'px;';
			}

			if ( !empty( $o[ 'padding_bottom' ] ) ) {
				$style[] = 'padding-bottom:' . $o[ 'padding_bottom' ] . 'px;';
			}

			if ( !empty( $o[ 'margin_bottom' ] ) ) {
				$style[] = 'margin-bottom:' . $o[ 'margin_bottom' ] . 'px;';
			}

			if ( !empty( $o[ 'text_color' ] ) ) {
				$style[] = 'color:' . $o[ 'text_color' ] . ';';
			}
      
			if ( !empty( $featured_image_url ) ) {
				$bg_style[] = 'background-image:url(' . esc_url( $featured_image_url ) . ');';
			}
			if ( !empty( $o[ 'background_size' ] ) ) {
				$bg_style[] = 'background-size:' . $this->get_background_size( $o[ 'background_size' ] ) . ';';
			}
			if ( !empty( $o[ 'background_color' ] ) ) {
				$rgb		 = $this->hex2rgb( $o[ 'background_color' ] );
				$bg_style[]	 = 'background-color: ' . $o[ 'background_color' ];
				$classes[] .= ' background-color';
			} else {
				$classes[] = ' no-background-color';
			}
			if ( !empty( $o[ 'background_overlay' ] ) ) {
				$classes[] .= ' etem-background-overlay';
			}
			if ( !empty( $o[ 'heading_style' ] ) ) {
				$classes[] .= ' ' . $o[ 'heading_style' ];
			}
			if ( !empty( $o[ 'button_color' ] ) ) {
				$button_color = 'color:' . $o[ 'button_color' ] . ';';
			}

			echo $before_widget; /* WPCS: XSS OK. HTML output. */
			if ( envo_multipurpose_check_widget( $this->id ) || is_page_template() || is_customize_preview() ) {
				?>
				<?php if ( !empty( $o[ 'youtube_id' ] ) ) : ?>
					<div class="youtube-iframe-wrapper">
						<div id="yt-video-<?php echo esc_attr( $this->id ); ?>" class="yt-video" data-video="<?php echo esc_attr( $o[ 'youtube_id' ] ); ?>" data-ids="yt-video-<?php echo esc_attr( $this->id ); ?>"></div>
						<?php if ( !empty( $featured_image_url ) ) : ?>
							<div class="bg-image-cover" style="<?php echo esc_attr( implode( '', $bg_style ) ); ?>"></div>
						<?php endif; ?>	
					<?php elseif ( !empty( $bg_style ) ) : ?>
						<div class="bg-image-cover" style="<?php echo esc_attr( implode( '', $bg_style ) ); ?>">
						<?php endif; ?>	
						<?php if ( !empty( $o[ 'background_overlay' ] ) ) : ?>
							<div class="envo-background-overlay" style="<?php echo 'background-image:url(' . esc_url( get_template_directory_uri() . '/img/overlay/' . $o[ 'background_overlay' ] ) . '.png' . ');' ?>"></div>
						<?php endif; ?>			
						<div class="etem-static-content container<?php echo esc_attr( implode( '', $classes ) ); ?>" style="<?php echo esc_attr( implode( '', $style ) ); ?>">
							<?php if ( !empty( $o[ 'title' ] ) || !empty( $o[ 'subtitle' ] ) ) { ?>
								<div class="etem-heading text-center">
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
							<?php if ( $post && $post->have_posts() ) : ?>
								<?php while ( $post->have_posts() ) : ?>
									<?php $post->the_post(); ?>

									<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
										<div class="entry-content">
											<?php the_content(); ?>
										</div>
									</article>

								<?php endwhile; ?>

							<?php endif; ?>
							<?php if ( !empty( $o[ 'button_link' ] ) && !empty( $o[ 'button_text' ] ) ) : ?>
								<div class="button-text text-center">
									<a class="button etem-button <?php echo esc_attr( $o[ 'button_style' ] ); ?>" href="<?php echo esc_url( $o[ 'button_link' ] ); ?>" style="<?php echo esc_attr( $button_color ); ?>">
										<?php echo esc_html( $o[ 'button_text' ] ); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>

						<?php if ( !empty( $bg_style ) || !empty( $o[ 'youtube_id' ] ) ) : ?>
						</div>
					<?php endif; ?>
				<?php } elseif ( current_user_can( 'edit_theme_options' ) ) { ?>
					<div class="text-center h3">
						<?php
						/* translators: %1$s: widget name %1$s: sidebar name */
						printf( esc_html__( 'You can only display the %1$s widget in the %2$s sidebar.', 'envo-multipurpose' ), $this->name, __( 'Homepage Widgetized Area', 'envo-multipurpose' ) );
						?>
					</div>
				<?php } 
				echo $after_widget; /* WPCS: XSS OK. HTML output. */

				wp_reset_postdata();
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

add_action( 'widgets_init', array( 'Envo_Multipurpose_Content_Widget_Static_Content', 'register' ) );		