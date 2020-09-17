<?php
/**
 * Custom widgets.
 *
 */
if ( !class_exists( 'Envo_Multipurpose_Extended_Recent_Posts' ) ) :

	/**
	 * Extended recent posts widget class.
	 *
	 * @since 1.0.0
	 */
	class Envo_Multipurpose_Extended_Recent_Posts extends WP_Widget {

		function __construct() {
			$opts = array(
				'classname'		 => 'extended-recent-posts',
				'description'	 => esc_html__( 'Widget to display recent posts with thumbnail and date. Recommended to be used in sidebar or footer.', 'envo-multipurpose' ),
			);

			parent::__construct( 'envo-multipurpose-extended-recent-posts', esc_html__( 'EM: Recent posts', 'envo-multipurpose' ), $opts );
		}

		function widget( $args, $instance ) {

			$title = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? '' : $instance[ 'title' ], $instance, $this->id_base );

			$post_number = !empty( $instance[ 'post_number' ] ) ? $instance[ 'post_number' ] : 4;

			extract( $args );
			
			echo $before_widget;
			?>

			<div class="recent-news-section">

				<?php
				if ( !empty( $title ) ) {
					echo $before_title . esc_html( $title ) . $after_title;
				}
				?>


				<?php
				$recent_args = array(
					'posts_per_page'		 => absint( $post_number ),
					'no_found_rows'			 => true,
					'post__not_in'			 => get_option( 'sticky_posts' ),
					'ignore_sticky_posts'	 => true,
					'post_status'			 => 'publish',
				);

				$recent_posts = new WP_Query( $recent_args );

				if ( $recent_posts->have_posts() ) :


					while ( $recent_posts->have_posts() ) :

						$recent_posts->the_post();
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
				'title'			 => esc_html__( 'Recent posts', 'envo-multipurpose' ),
				'post_number'	 => 4,
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

add_action( 'widgets_init', array( 'Envo_Multipurpose_Extended_Recent_Posts', 'register' ) );
