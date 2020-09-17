<?php
/**
 * Content Widget: WooCommerce Products
 *
 */
if ( !class_exists( 'Envo_Multipurpose_Content_Widget_WooCommerce_Products' ) ) :

	/**
	 * Class: WooCommerce Products
	 *
	 */
	class Envo_Multipurpose_Content_Widget_WooCommerce_Products extends Envo_Multipurpose_Widget {

		/**
		 * __construct
		 *
		 */
		public function __construct() {
			$this->widget_id			 = 'envo-multipurpose-content-widget-woocommerce-products';
			$this->widget_description	 = esc_html__( 'Displays WooCommerce products on your widgetized page.', 'envo-multipurpose' );
			$this->widget_name			 = esc_html__( 'EM: WooCommerce products', 'envo-multipurpose' );
			$this->settings				 = array(
				'title'				 => array(
					'type'		 => 'text',
					'std'		 => '',
					'label'		 => esc_html__( 'Title:', 'envo-multipurpose' ),
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
				'background_color'	 => array(
					'type'		 => 'colorpicker',
					'std'		 => '#ffffff',
					'label'		 => esc_html__( 'Background color:', 'envo-multipurpose' ),
					'sanitize'	 => 'color',
				),
				'text_color'		 => array(
					'type'		 => 'colorpicker',
					'std'		 => '',
					'label'		 => esc_html__( 'Text color:', 'envo-multipurpose' ),
					'sanitize'	 => 'color',
				),
				'limit'				 => array(
					'type'			 => 'number',
					'std'			 => 4,
					'step'			 => 1,
					'min'			 => -1,
					'label'			 => esc_html__( 'Limit:', 'envo-multipurpose' ),
					'description'	 => esc_html__( 'The number of items to be displayed. -1 to display all.', 'envo-multipurpose' ),
					'sanitize'		 => 'number',
				),
				'columns'			 => array(
					'type'		 => 'select',
					'std'		 => '4',
					'label'		 => esc_html__( 'Columns:', 'envo-multipurpose' ),
					'options'	 => array(
						'2'	 => esc_html__( '2', 'envo-multipurpose' ),
						'3'	 => esc_html__( '3', 'envo-multipurpose' ),
						'4'	 => esc_html__( '4', 'envo-multipurpose' ),
						'5'	 => esc_html__( '5', 'envo-multipurpose' ),
						'6'	 => esc_html__( '6', 'envo-multipurpose' ),
					),
					'sanitize'	 => 'text',
				),
				'orderby'			 => array(
					'type'		 => 'select',
					'std'		 => 'date',
					'label'		 => esc_html__( 'Order By:', 'envo-multipurpose' ),
					'options'	 => array(
						'title'		 => esc_html__( 'Title', 'envo-multipurpose' ),
						'date'		 => esc_html__( 'Date', 'envo-multipurpose' ),
						'id'		 => esc_html__( 'ID', 'envo-multipurpose' ),
						'menu_order' => esc_html__( 'Menu order', 'envo-multipurpose' ),
						'popularity' => esc_html__( 'Popularity', 'envo-multipurpose' ),
						'rand'		 => esc_html__( 'Random', 'envo-multipurpose' ),
						'rating'	 => esc_html__( 'Rating', 'envo-multipurpose' ),
					),
					'sanitize'	 => 'text',
				),
				'post_ids'			 => array(
					'type'		 => 'post',
					'post_type'	 => 'product',
					'std'		 => '',
					'label'		 => esc_html__( 'Product ID\'s:', 'envo-multipurpose' ),
					'sanitize'	 => 'post_ids',
				),
				'category'			 => array(
					'type'			 => 'text',
					'std'			 => '',
					'label'			 => esc_html__( 'Category:', 'envo-multipurpose' ),
					'description'	 => esc_html__( 'Comma separated list of category slugs.', 'envo-multipurpose' ),
					'sanitize'		 => 'slugs',
				),
				'order'				 => array(
					'type'		 => 'select',
					'std'		 => 'desc',
					'label'		 => esc_html__( 'Order:', 'envo-multipurpose' ),
					'options'	 => array(
						'asc'	 => esc_html__( 'ASC', 'envo-multipurpose' ),
						'desc'	 => esc_html__( 'DESC', 'envo-multipurpose' ),
					),
					'sanitize'	 => 'text',
				),
				'selling_type'		 => array(
					'type'		 => 'select',
					'std'		 => '',
					'label'		 => esc_html__( 'Product Type:', 'envo-multipurpose' ),
					'options'	 => array(
						''				 => esc_html__( 'Recent', 'envo-multipurpose' ),
						'best_selling'	 => esc_html__( 'Best selling', 'envo-multipurpose' ),
						'top_rated'		 => esc_html__( 'Top rated', 'envo-multipurpose' ),
						'on_sale'		 => esc_html__( 'On sale', 'envo-multipurpose' ),
						'featured'		 => esc_html__( 'Featured', 'envo-multipurpose' ),
					),
					'sanitize'	 => 'text',
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
					'std'		 => 40,
					'step'		 => 1,
					'min'		 => 0,
					'max'		 => 300,
					'label'		 => esc_html__( 'Top padding:', 'envo-multipurpose' ),
					'sanitize'	 => 'number',
				),
				'padding_bottom'	 => array(
					'type'		 => 'number',
					'std'		 => 40,
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
		 * Widget Function
		 *
		 */
		function widget( $args, $instance ) {
			extract( $args );

			$o = $this->sanitize( $instance );

			$style				 = array();
			$classes[]			 = 'content-woocommerce-products';
			$button_color	 = '';

			if ( !empty( $o[ 'background_color' ] ) ) {
				$style[] = 'background-color: ' . $o[ 'background_color' ] . ';';
				$classes[] .= ' background-color';
			} else {
				$classes[] = ' no-background-color';
			}
			if ( !empty( $o[ 'heading_style' ] ) ) {
				$classes[] = ' ' . $o[ 'heading_style' ];
			}
			if ( !empty( $o[ 'text_color' ] ) ) {
				$style[] = 'color:' . $o[ 'text_color' ] . ';';
			}
			if ( !empty( $o[ 'margin_bottom' ] ) ) {
				$style[] = 'margin-bottom:' . $o[ 'margin_bottom' ] . 'px;';
			}

			if ( !empty( $o[ 'padding_top' ] ) ) {
				$style[] = 'padding-top:' . $o[ 'padding_top' ] . 'px;';
			}

			if ( !empty( $o[ 'padding_bottom' ] ) ) {
				$style[] = 'padding-bottom:' . $o[ 'padding_bottom' ] . 'px;';
			}
			if ( !empty( $o[ 'limit' ] ) ) {
				$attr[] = 'limit="' . $o[ 'limit' ] . '"';
			}
			if ( !empty( $o[ 'columns' ] ) ) {
				$attr[] = 'columns="' . $o[ 'columns' ] . '"';
			}
			if ( !empty( $o[ 'orderby' ] ) ) {
				$attr[] = 'orderby="' . $o[ 'orderby' ] . '"';
			}
			if ( !empty( $o[ 'post_ids' ] ) ) {
				$attr[] = 'ids="' . $o[ 'post_ids' ] . '"';
			}
			if ( !empty( $o[ 'skus' ] ) ) {
				$attr[] = 'skus="' . $o[ 'skus' ] . '"';
			}
			if ( !empty( $o[ 'category' ] ) ) {
				$attr[] = 'category="' . $o[ 'category' ] . '"';
			}
			if ( !empty( $o[ 'order' ] ) ) {
				$attr[] = 'order="' . $o[ 'order' ] . '"';
			}

			if ( !empty( $o[ 'selling_type' ] ) ) {
				if ( $o[ 'selling_type' ] == 'best_selling' ) {
					$attr[] = 'best_selling="true"';
				} elseif ( $o[ 'selling_type' ] == 'on_sale' ) {
					$attr[] = 'on_sale="true"';
				} elseif ( $o[ 'selling_type' ] == 'top_rated' ) {
					$attr[] = 'top_rated="true"';
				} elseif ( $o[ 'selling_type' ] == 'featured' ) {
					$attr[] = 'visibility="featured"';
				}
			}
			if ( !empty( $o[ 'button_color' ] ) ) {
				$button_color = 'color:' . $o[ 'button_color' ] . ';';
			}

			$shortcode = '[products]';
			if ( !empty( $attr ) ) {
				$shortcode = '[products ' . implode( ' ', $attr ) . ']';
			}
			?>

			<?php
			echo $before_widget; /* WPCS: XSS OK. HTML output. */
			if ( envo_multipurpose_check_widget( $this->id ) || is_page_template() || is_customize_preview() ) {
				?>

				<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" style="<?php echo esc_attr( implode( '', $style ) ); ?>">
					<?php if ( !empty( $o[ 'title' ] ) || !empty( $o[ 'subtitle' ] ) ) { ?>
						<div class="etem-heading text-center container">
							<?php if ( !empty( $o[ 'title' ] ) ) { ?>
								<div class="etem-widget-title">
									<?php echo esc_html( $o[ 'title' ] ); ?>
								</div>
							<?php } ?>
							<?php if ( !empty( $o[ 'title' ] ) ) { ?>
								<div class="etem-widget-subtitle">
									<?php echo esc_html( $o[ 'subtitle' ] ); ?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>

					<?php if ( !class_exists( 'WooCommerce' ) ) : ?>
						<div class="text-center">
							<?php echo esc_html__( 'Activate WooCommerce and start adding products.', 'envo-multipurpose' ); ?>
						</div>
					<?php else : ?>
						<div class="container">
							<?php echo do_shortcode( $shortcode ); ?>
						</div>
					<?php endif; ?>
					<?php if ( !empty( $o[ 'button_link' ] ) && !empty( $o[ 'button_text' ] ) ) : ?>
						<div class="button-text text-center">
							<a class="button etem-button <?php echo esc_attr( $o[ 'button_style' ] ); ?>" href="<?php echo esc_url( $o[ 'button_link' ] ); ?>" style="<?php echo esc_attr( $button_color ); ?>">
								<?php echo esc_html( $o[ 'button_text' ] ); ?>
							</a>
						</div>
					<?php endif; ?>
				</div><!-- .content-woocommerce-products -->

			<?php } elseif ( current_user_can( 'edit_theme_options' ) ) { ?>
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
		 * Registers the widget with the WordPress Widget API.
		 *
		 */
		public static function register() {
			register_widget( __CLASS__ );
		}

	}

	endif;

add_action( 'widgets_init', array( 'Envo_Multipurpose_Content_Widget_WooCommerce_Products', 'register' ) );	