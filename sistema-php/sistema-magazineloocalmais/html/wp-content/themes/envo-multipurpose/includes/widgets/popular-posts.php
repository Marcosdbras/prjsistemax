<?php
/**
 * Custom widgets.
 *
 */
if ( !class_exists( 'Envo_Multipurpose_Popular_Posts' ) ) :

	/**
	 * Popular posts widget class.
	 *
	 * @since 1.0.0
	 */
	class Envo_Multipurpose_Popular_Posts extends WP_Widget {

		function __construct() {
			$opts = array(
				'classname'		 => 'popular-posts widget_popular_posts',
				'description'	 => esc_html__( 'Widget to display popular posts with thumbnail and date. Recommended to be used in sidebar or footer.', 'envo-multipurpose' ),
			);

			parent::__construct( 'envo-multipurpose-popular-posts', esc_html__( 'EM: Popular posts', 'envo-multipurpose' ), $opts );
		}

		function widget( $args, $instance ) {

			$title = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? '' : $instance[ 'title' ], $instance, $this->id_base );

			$post_number = !empty( $instance[ 'post_number' ] ) ? $instance[ 'post_number' ] : 4;

			extract( $args );
			
			echo $before_widget;
			?>

			<div class="popular-news-section">

				<?php
				if ( !empty( $title ) ) {
					echo $before_title . esc_html( $title ) . $after_title;
				}
				?>


				<?php
				$popular_args = array(
					'posts_per_page'		 => absint( $post_number ),
					'no_found_rows'			 => true,
					'post__not_in'			 => get_option( 'sticky_posts' ),
					'ignore_sticky_posts'	 => true,
					'post_status'			 => 'publish',
					'orderby'				 => 'comment_count',
					'order'					 => 'desc',
				);

				$popular_posts = new WP_Query( $popular_args );

				if ( $popular_posts->have_posts() ) :


					while ( $popular_posts->have_posts() ) :

						$popular_posts->the_post();
						?>

						<div class="news-item layout-two">
							<?php envo_multipurpose_thumb_img( 'envo-multipurpose-thumbnail' ); ?>
							<div class="news-text-wrap">
								<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
								<?php envo_multipurpose_widget_date_comments(); ?>
							</div><!-- .news-text-wrap -->
						</div><!-- .news-item -->

						<?php
					endwhile;

					wp_reset_postdata();
					?>

				<?php endif; ?>

			</div>

			<?php
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance					 = $old_instance;
			$instance[ 'title' ]		 = sanitize_text_field( $new_instance[ 'title' ] );
			$instance[ 'post_number' ]	 = absint( $new_instance[ 'post_number' ] );

			return $instance;
		}

		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, array(
				'title'			 => esc_html__( 'Popular posts', 'envo-multipurpose' ),
				'post_number'	 => 5,
			) );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'envo-multipurpose' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'title' ] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name( 'post_number' ) ); ?>">
					<?php esc_html_e( 'Number of posts:', 'envo-multipurpose' ); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_number' ) ); ?>" type="number" value="<?php echo absint( $instance[ 'post_number' ] ); ?>" />
			</p>

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

add_action( 'widgets_init', array( 'Envo_Multipurpose_Popular_Posts', 'register' ) );	