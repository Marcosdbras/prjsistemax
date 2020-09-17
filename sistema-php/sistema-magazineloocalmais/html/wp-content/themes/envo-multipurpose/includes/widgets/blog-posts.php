<?php
/**
 * Content Widget: Blog Posts
 */
if ( !class_exists( 'Envo_Multipurpose_Content_Widget_Blog_Posts' ) ) :

	/**
	 * Class: Display blog posts.
	 */
	class Envo_Multipurpose_Content_Widget_Blog_Posts extends Envo_Multipurpose_Widget {

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->widget_id			 = 'envo-multipurpose-widget-blog-posts';
			$this->widget_description	 = esc_html__( 'Displays content from a specified page on your widgetized page.', 'envo-multipurpose' );
			$this->widget_name			 = esc_html__( 'EM: Blog posts', 'envo-multipurpose' );
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
				'category'			 => array(
					'type'		 => 'category',
					'std'		 => 0,
					'label'		 => esc_html__( 'Category:', 'envo-multipurpose' ),
					'sanitize'	 => 'number',
				),
				'post_count'		 => array(
					'type'		 => 'number',
					'std'		 => 3,
					'step'		 => 1,
					'min'		 => 1,
					'max'		 => 60,
					'label'		 => esc_html__( 'Number of posts:', 'envo-multipurpose' ),
					'sanitize'	 => 'number',
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
			$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

			$post_args = array(
				'posts_per_page'		 => $o[ 'post_count' ],
				'ignore_sticky_posts'	 => 1,
				'paged'					 => $paged,
			);

			if ( !empty( $o[ 'category' ] ) ) {
				$post_args[ 'category__in' ] = $o[ 'category' ];
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

			if ( !empty( $o[ 'background_color' ] ) ) {
				$style[] = 'background-color: ' . $o[ 'background_color' ] . ';';
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
			
			$post = new WP_Query( $post_args );
			echo $before_widget; /* WPCS: XSS OK. HTML output. */
			
			if ( envo_multipurpose_check_widget( $this->id ) || is_page_template() || is_customize_preview() ) {
			?>
			<div class="etem-blog-posts<?php echo esc_attr( implode( '', $classes ) ); ?>" style="<?php echo esc_attr( implode( '', $style ) ); ?>">
			<?php if ( !empty( $o[ 'background_overlay' ] ) ) : ?>
				<div class="envo-background-overlay" style="<?php echo 'background-image:url(' . esc_url( get_template_directory_uri() . '/img/overlay/' . $o[ 'background_overlay' ] ) . '.png' . ');' ?>"></div>
			<?php endif; ?>			
			<div class="container" >
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
				<?php if ( $post->have_posts() ) : ?>
					<div class="row">
					<?php while ( $post->have_posts() ) : ?>
						<?php $post->the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4'); ?>>
							<div class="news-item">
								<?php envo_multipurpose_thumb_img( 'envo-multipurpose-med' ); ?>
								<div class="news-text-wrap">
									<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" style="color: ' . esc_attr( $o[ 'text_color' ] ) . '">', '</a></h2>' ); ?>
									<div class="post-excerpt">
										<?php the_excerpt(); ?>
									</div><!-- .post-excerpt -->
								</div><!-- .news-text-wrap -->

							</div><!-- .news-item -->
						</article>

					<?php endwhile; ?>
					</div><!-- .row -->
				<?php endif; ?>
				<?php if ( !empty( $o[ 'button_link' ] ) && !empty( $o[ 'button_text' ] ) ) : ?>
					<div class="button-text text-center">
						<a class="button etem-button <?php echo esc_attr( $o[ 'button_style' ] ); ?>" href="<?php echo esc_url( $o[ 'button_link' ] ); ?>" style="<?php echo esc_attr( $button_color ); ?>">
							<?php echo esc_html( $o[ 'button_text' ] ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
			</div>
			<?php } elseif ( current_user_can( 'edit_theme_options' ) ) { ?>
				<div class="text-center h3">
					<?php
					/* translators: %1$s: widget name %1$s: sidebar name */
					printf( esc_html__( 'You can only display the %1$s widget in the %2$s sidebar.', 'envo-multipurpose' ), $this->name, __( 'Homepage Widgetized Area', 'envo-multipurpose' ) ); 
					?>
				</div>
			<?php } ?>
			<?php echo $after_widget; /* WPCS: XSS OK. HTML output. */ ?>

			<?php
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
	
add_action( 'widgets_init', array( 'Envo_Multipurpose_Content_Widget_Blog_Posts', 'register' ) );
