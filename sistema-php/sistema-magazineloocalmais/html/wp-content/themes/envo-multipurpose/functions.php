<?php
/**
 * The current version of the theme.
 */
define( 'ENVO_MULTIPURPOSE_VERSION', '1.1.6' );

add_action( 'after_setup_theme', 'envo_multipurpose_setup' );

if ( !function_exists( 'envo_multipurpose_setup' ) ) :

	/**
	 * Global functions
	 */
	function envo_multipurpose_setup() {

		// Theme lang.
		load_theme_textdomain( 'envo-multipurpose', get_template_directory() . '/languages' );

		// Add Title Tag Support.
		add_theme_support( 'title-tag' );

		// Register Menus.
		register_nav_menus(
		array(
			'main_menu'		 => esc_html__( 'Main Menu', 'envo-multipurpose' ),
			'top_menu_left'	 => esc_html__( 'Top Menu left', 'envo-multipurpose' ),
			'top_menu_right' => esc_html__( 'Top Menu right', 'envo-multipurpose' ),
		)
		);

		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 300, 300, true );
		add_image_size( 'envo-multipurpose-single', 1140, 641, true );
		add_image_size( 'envo-multipurpose-med', 720, 405, true );
		add_image_size( 'envo-multipurpose-thumbnail', 160, 120, true );

		// Add Custom Background Support.
		$args = array(
			'default-color' => 'ffffff',
		);
		add_theme_support( 'custom-background', $args );

		add_theme_support( 'custom-logo', array(
			'height'		 => 60,
			'width'			 => 200,
			'flex-height'	 => true,
			'flex-width'	 => true,
			'header-text'	 => array( 'site-title', 'site-description' ),
		) );

		// Adds RSS feed links to for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Set the default content width.
		$GLOBALS[ 'content_width' ] = 1140;

		add_theme_support( 'custom-header', apply_filters( 'envo_multipurpose_custom_header_args', array(
			'width'				 => 2000,
			'height'			 => 200,
			'wp-head-callback'	 => 'envo_multipurpose_header_style',
		) ) );

		// WooCommerce support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'html5', array( 'search-form' ) );
		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'css/bootstrap.css', envo_multipurpose_fonts_url(), 'css/editor-style.css' ) );
		// Recommend plugins.
		add_theme_support( 'recommend-plugins', array(
				'woocommerce'	 => array(
				'name'				 => 'WooCommerce',
				'active_filename'	 => 'woocommerce/woocommerce.php',
				/* translators: %1$s plugin name string */
				'description'		 => sprintf( esc_attr__( 'To enable shop features, please install and activate the %s plugin.', 'envo-multipurpose' ), '<strong>WooCommerce</strong>' ),
			),
			'envothemes-importer-kingcomposer' => array(
				'name'				 => 'One Click Demo Import',
				'active_filename'	 => 'one-click-demo-import/one-click-demo-import.php',
				'description' => esc_html__( 'Save time by importing our demo data: your website will be set up and ready to be customized in minutes.', 'envo-multipurpose' ),
			),
		) );
	}

endif;

if ( !function_exists( 'envo_multipurpose_header_style' ) ) :

	/**
	 * Styles the header image and text displayed on the blog.
	 */
	function envo_multipurpose_header_style() {
		$header_image		 = get_header_image();
		$header_text_color	 = get_header_textcolor();
		// If no custom options for text are set, let's bail.
		if ( empty( $header_image ) && display_header_text() == true ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css" id="envo-multipurpose-header-css">
		<?php
		// Has a Custom Header been added?
		if ( !empty( $header_image ) ) :
			?>
				.site-header {
					background-image: url(<?php header_image(); ?>);
					background-repeat: no-repeat;
					background-position: 50% 50%;
					-webkit-background-size: cover;
					-moz-background-size:    cover;
					-o-background-size:      cover;
					background-size:         cover;
				}
				.site-title a, 
				.site-title, 
				.site-description,
				.header-login a,
				a.cart-contents i {
					color: #<?php echo esc_attr( $header_text_color ); ?>;
				}
				.site-description:before, 
				.site-description:after {
					background-color: #<?php echo esc_attr( $header_text_color ); ?>;
				}
		<?php endif; ?>
		<?php
		// Has the text been hidden?
		if ( display_header_text() !== true ) :
			?>
				.site-title,
				.site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
		endif;
		?>	
		</style>
		<?php
	}

endif; // envo_multipurpose_header_style

/**
 * Set Content Width
 */
function envo_multipurpose_content_width() {

	$content_width = $GLOBALS[ 'content_width' ];

	if ( is_active_sidebar( 'envo-multipurpose-right-sidebar' ) ) {
		$content_width = 750;
	} else {
		$content_width = 1040;
	}

	/**
	 * Filter content width of the theme.
	 */
	$GLOBALS[ 'content_width' ] = apply_filters( 'envo_multipurpose_content_width', $content_width );
}

add_action( 'template_redirect', 'envo_multipurpose_content_width', 0 );

/**
 * Register custom fonts.
 */
function envo_multipurpose_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Open Sans Condensed, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$font = _x( 'on', 'Open Sans Condensed font: on or off', 'envo-multipurpose' );

	if ( 'off' !== $font ) {
		$font_families = array();

		$font_families[] = 'Open Sans Condensed:300,500,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue Styles (normal style.css and bootstrap.css)
 */
function envo_multipurpose_theme_stylesheets() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'envo-multipurpose-fonts', envo_multipurpose_fonts_url(), array(), null );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.7' );
	// Theme stylesheet.
	wp_enqueue_style( 'envo-multipurpose-stylesheet', get_stylesheet_uri(), array( 'bootstrap' ), ENVO_MULTIPURPOSE_VERSION );
	// Load Font Awesome css.
	wp_enqueue_style( 'font-awesome-4-7', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.7.0' );
}

add_action( 'wp_enqueue_scripts', 'envo_multipurpose_theme_stylesheets' );

/**
 * Register Bootstrap JS with jquery
 */
function envo_multipurpose_theme_js() {
	wp_enqueue_script( 'bootstrap-3-3-7', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );
	wp_enqueue_script( 'envo-multipurpose-theme-js', get_template_directory_uri() . '/js/customscript.js', array( 'jquery' ), ENVO_MULTIPURPOSE_VERSION, true );
}

add_action( 'wp_enqueue_scripts', 'envo_multipurpose_theme_js' );


/**
 * Register Custom Navigation Walker include custom menu widget to use walkerclass
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/wp_bootstrap_navwalker.php' );
/**
 * Widgets helper
 */
require_once( trailingslashit( get_template_directory() ) . 'includes/class-widget.php' );
/**
 * Widgets
 */
require_once( trailingslashit( get_template_directory() ) . 'includes/widgets.php' );

/**
 * Register theme notification
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/new-theme-notice.php' );

/**
 * Register Theme Info Page
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/dashboard.php' );

/**
 * Register PRO notify
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/customizer.php' );

/**
 * Register demo import
 */
require_once( trailingslashit( get_template_directory() ) . 'lib/demo-import.php' );

add_action( 'widgets_init', 'envo_multipurpose_widgets_init' );

/**
 * Register the Sidebar(s)
 */
function envo_multipurpose_widgets_init() {
	register_sidebar(
	array(
		'name'			 => esc_html__( 'Right Sidebar', 'envo-multipurpose' ),
		'id'			 => 'envo-multipurpose-right-sidebar',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<div class="widget-title"><h3>',
		'after_title'	 => '</h3></div>',
	)
	);
	register_sidebar(
	array(
		'name'			 => esc_html__( 'Header Section', 'envo-multipurpose' ),
		'id'			 => 'envo-multipurpose-header-area',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<div class="widget-title"><h3>',
		'after_title'	 => '</h3></div>',
	)
	);
	register_sidebar(
	array(
		'name'			 => esc_html__( 'Menu Section', 'envo-multipurpose' ),
		'id'			 => 'envo-multipurpose-menu-area',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<div class="widget-title"><h3>',
		'after_title'	 => '</h3></div>',
	)
	);
	register_sidebar(
	array(
		'name'			 => esc_html__( 'Footer Section', 'envo-multipurpose' ),
		'id'			 => 'envo-multipurpose-footer-area',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s col-md-3">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<div class="widget-title"><h3>',
		'after_title'	 => '</h3></div>',
	)
	);
	register_sidebar(
	array(
		'name'			 => esc_html__( 'Homepage Widgetized Area', 'envo-multipurpose' ),
		'id'			 => 'envo-multipurpose-homepage-area',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<div class="widget-title"><h3>',
		'after_title'	 => '</h3></div>',
	)
	);
}

function envo_multipurpose_main_content_width_columns() {

	$columns = '12';

	if ( is_active_sidebar( 'envo-multipurpose-right-sidebar' ) ) {
		$columns = $columns - 4;
	}

	echo absint( $columns );
}

if ( !function_exists( 'envo_multipurpose_entry_footer' ) ) :

	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function envo_multipurpose_entry_footer() {

		// Get Categories for posts.
		$categories_list = get_the_category_list( ' ' );

		// Get Tags for posts.
		$tags_list = get_the_tag_list( '', ' ' );

		// We don't want to output .entry-footer if it will be empty, so make sure its not.
		if ( $categories_list || $tags_list || get_edit_post_link() ) {

			echo '<div class="entry-footer">';

			if ( 'post' === get_post_type() ) {
				if ( $categories_list || $tags_list ) {

					// Make sure there's more than one category before displaying.
					if ( $categories_list ) {
						echo '<div class="cat-links"><span class="space-right">' . esc_html__( 'Category', 'envo-multipurpose' ) . '</span>' . wp_kses_data( $categories_list ) . '</div>';
					}

					if ( $tags_list ) {
						echo '<div class="tags-links"><span class="space-right">' . esc_html__( 'Tags', 'envo-multipurpose' ) . '</span>' . wp_kses_data( $tags_list ) . '</div>';
					}
				}
			}

			edit_post_link();

			echo '</div>';
		}
	}

endif;

if ( !function_exists( 'envo_multipurpose_generate_construct_footer' ) ) :
	/**
	 * Build footer
	 */
	add_action( 'envo_multipurpose_generate_footer', 'envo_multipurpose_generate_construct_footer' );

	function envo_multipurpose_generate_construct_footer() {
		?>
		<div class="footer-credits-text text-center">
			<?php
			/* translators: %s: WordPress name with wordpress.org URL */
			printf( __( 'Proudly powered by %s', 'envo-multipurpose' ), '<a href="' . esc_url( __( 'https://wordpress.org/', 'envo-multipurpose' ) ) . '">WordPress</a>' );
			?>
			<span class="sep"> | </span>
			<?php
			/* translators: %1$s: Envo Multipurpose name with envothemes.com URL */
			printf( esc_html__( 'Theme: %1$s', 'envo-multipurpose' ), '<a href="' . esc_url( 'https://envothemes.com/' ) . '">Envo Multipurpose</a>' );
			?>
		</div> 
		<?php
	}

endif;

if ( !function_exists( 'envo_multipurpose_get_the_excerpt' ) ) :

	/**
	 * Returns post excerpt.
	 */
	function envo_multipurpose_get_the_excerpt( $length = 0, $post_object = null ) {
		global $post;

		if ( is_null( $post_object ) ) {
			$post_object = $post;
		}

		$length = absint( $length );
		if ( 0 === $length ) {
			return;
		}

		$source_content = $post_object->post_content;

		if ( !empty( $post_object->post_excerpt ) ) {
			$source_content = $post_object->post_excerpt;
		}

		$source_content	 = strip_shortcodes( $source_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '...' );
		return $trimmed_content;
	}

endif;

if ( !function_exists( 'envo_multipurpose_widget_date_comments' ) ) :

	/**
	 * Returns date for widgets.
	 */
	function envo_multipurpose_widget_date_comments() {
		?>
		<span class="posted-date">
			<?php echo esc_html( get_the_date() ); ?>
		</span>
		<span class="comments-meta">
			<?php
			if ( !comments_open() ) {
				esc_html_e( 'Off', 'envo-multipurpose' );
			} else {
				?>
				<a href="<?php the_permalink(); ?>#comments" rel="nofollow" title="<?php esc_attr_e( 'Comment on ', 'envo-multipurpose' ) . the_title_attribute(); ?>">
					<?php echo absint( get_comments_number() ); ?>
				</a>
			<?php } ?>
			<i class="fa fa-comments-o"></i>
		</span>
		<?php
	}

endif;

if ( !function_exists( 'envo_multipurpose_excerpt_length' ) ) :

	/**
	 * Excerpt limit.
	 */
	function envo_multipurpose_excerpt_length( $length ) {
		return 20;
	}

	add_filter( 'excerpt_length', 'envo_multipurpose_excerpt_length', 999 );

endif;

if ( !function_exists( 'envo_multipurpose_excerpt_more' ) ) :

	/**
	 * Excerpt more.
	 */
	function envo_multipurpose_excerpt_more( $more ) {
		return '&hellip;';
	}

	add_filter( 'excerpt_more', 'envo_multipurpose_excerpt_more' );

endif;

if ( !function_exists( 'envo_multipurpose_thumb_img' ) ) :

	/**
	 * Returns widget thumbnail.
	 */
	function envo_multipurpose_thumb_img( $img = 'full', $col = '', $link = true, $single = false ) {
		if ( function_exists( 'envo_multipurpose_pro_thumb_img' ) ) {
			envo_multipurpose_pro_thumb_img( $img, $col, $link, $single );
		} elseif ( ( has_post_thumbnail() && $link == true ) ) { ?>
			<div class="news-thumb <?php echo esc_attr( $col ); ?>">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<img src="<?php the_post_thumbnail_url( $img ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
				</a>
			</div><!-- .news-thumb -->
		<?php } elseif ( has_post_thumbnail() ) { ?>
			<div class="news-thumb <?php echo esc_attr( $col ); ?>">
				<img src="<?php the_post_thumbnail_url( $img ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
			</div><!-- .news-thumb -->	
			<?php
		}
	}

endif;

/**
 * Check if the category ID exists. If not return default category
 */
if ( !function_exists( 'envo_multipurpose_check_cat' ) ) :

	function envo_multipurpose_check_cat( $catid ) {
		$cat_to_check = get_term_by( 'id', $catid, 'category' );
		if ( $cat_to_check ) {
			return $catid;
		} else {
			return '0';
		}
	}

endif;
/**
 * Single previous next links
 */
if ( !function_exists( 'envo_multipurpose_prev_next_links' ) ) :

	function envo_multipurpose_prev_next_links() {
		the_post_navigation(
			array(
				'prev_text'	 => '<span class="screen-reader-text">' . __( 'Previous Post', 'envo-multipurpose' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'envo-multipurpose' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>%title</span>',
				'next_text'	 => '<span class="screen-reader-text">' . __( 'Next Post', 'envo-multipurpose' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'envo-multipurpose' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span></span>',
			)
		);
	}

endif;

/**
 * Post author meta funciton
 */
if ( !function_exists( 'envo_multipurpose_author_meta' ) ) :

	function envo_multipurpose_author_meta() {
		?>
		<span class="author-meta">
			<span class="author-meta-by"><?php esc_html_e( 'By', 'envo-multipurpose' ); ?></span>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>">
		<?php the_author(); ?>
			</a>
		</span>
		<?php
	}

endif;

if ( class_exists( 'WooCommerce' ) ) {

	if ( !function_exists( 'envo_multipurpose_cart_link' ) ) {

		function envo_multipurpose_cart_link() {
			?>	
			<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_html_e( 'View your shopping cart', 'envo-multipurpose' ); ?>">
				<i class="fa fa-shopping-bag"><span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span></i>
			</a>
			<?php
		}

	}

	if ( !function_exists( 'envo_multipurpose_header_cart' ) ) {

		function envo_multipurpose_header_cart() {
			if ( get_theme_mod( 'woo_header_cart', 1 ) == 1 ) {
				?>
				<div class="header-cart">
					<div class="header-cart-block">
						<div class="header-cart-inner">
							<?php envo_multipurpose_cart_link(); ?>
							<ul class="site-header-cart menu list-unstyled text-center">
								<li>
									<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<?php
			}
		}

	}

	if ( !function_exists( 'envo_multipurpose_header_add_to_cart_fragment' ) ) {
		add_filter( 'woocommerce_add_to_cart_fragments', 'envo_multipurpose_header_add_to_cart_fragment' );

		function envo_multipurpose_header_add_to_cart_fragment( $fragments ) {
			ob_start();

			envo_multipurpose_cart_link();

			$fragments[ 'a.cart-contents' ] = ob_get_clean();

			return $fragments;
		}

	}

	if ( !function_exists( 'envo_multipurpose_my_account' ) ) {

		function envo_multipurpose_my_account() {
			if ( get_theme_mod( 'woo_account', 1 ) == 1 ) {
				?>
				<div class="header-my-account">
					<div class="header-login"> 
						<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" title="<?php esc_attr_e( 'My Account', 'envo-multipurpose' ); ?>">
					   <?php esc_html_e( 'My Account', 'envo-multipurpose' ); ?>
						</a>
					</div>
				</div>
				<?php
			}
		}

	}
	if ( !function_exists( 'envo_multipurpose_generate_float_product' ) ) :
	
	/**
	 * Floating bar for add to cart and product info
	 */
	add_action( 'envo_multipurpose_after_footer', 'envo_multipurpose_generate_float_product' );

	function envo_multipurpose_generate_float_product() {
		global $product;
		if ( is_product() ){
		?>
		<div class="woo-float-info container-fluid">
			<div class="close-me"></div>
			<div class="container">
			<?php
			envo_multipurpose_thumb_img( 'envo-multipurpose-thumbnail', '', false, true );
			the_title( '<div class="product_title entry-title">', '</div>' );
			woocommerce_template_single_price();
			if ( $product->is_in_stock() ) {
				if ( ! $product->is_type( 'variable' ) ) {
					woocommerce_template_loop_add_to_cart();
				} else {
					?>
					<a href="#product-<?php echo get_the_ID() ?>" class="button product_type_variable add_to_cart_button" rel="nofollow">
						<?php esc_html_e( 'Select options', 'envo-multipurpose' ) ?>
					</a>
					<?php
				}
			}
			?>
			</div>
		</div> 
		<?php
		}
	}

endif;
}

if ( !function_exists( 'envo_multipurpose_check_widget' ) ) {

	function envo_multipurpose_check_widget( $custom_widget = '' ) {
		global $sidebars_widgets;

		$sidebars = array( 'envo-multipurpose-right-sidebar', 'envo-multipurpose-header-area', 'envo-multipurpose-menu-area', 'envo-multipurpose-footer-area' );
		
		// See if our custom content widget exists is any sidebar, if so, get the array index
		foreach ( $sidebars_widgets as $sidebars_key => $sidebars_widget ) {
			// Skip the wp_inactive_widgets set, we do not need them
			if ( $sidebars_key == 'wp_inactive_widgets' )
				continue;

			// Only continue our operation if $sidebars_widget are not an empty array
			if ( $sidebars_widget ) {
				foreach ( $sidebars_widget as $k => $v ) {

					/**
					 * Look for our custom widget
					 * @see stripos()
					 */
					if ( stripos( $v, $custom_widget ) !== false ) {
						// Skip displaying sidebar on theme generated sidebars except homepage. 
						if ( in_array( $sidebars_key, $sidebars )  ) {
							return false;
						} else {
							return true;
						}
					}
				} // endforeach $sidebars_widget
			} // endif $sidebars_widget
		} // endforeach $sidebars_widgets
	}

}

if ( ! function_exists( 'wp_body_open' ) ) :
    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
     *
     */
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         *
         */
        do_action( 'wp_body_open' );
    }
endif;
