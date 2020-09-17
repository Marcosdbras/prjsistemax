<?php if ( has_nav_menu( 'top_menu_left' ) || has_nav_menu( 'top_menu_right' ) ) : ?>
	<div class="top-menu" >
		<nav id="top-navigation" class="navbar navbar-default">     
			<div class="container">   
				<div class="navbar-header">
					<span class="navbar-brand visible-xs"><?php esc_html_e( 'Menu', 'envo-multipurpose' ); ?></span>
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-2-collapse">
						<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'envo-multipurpose' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse navbar-2-collapse">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'top_menu_left',
							'depth'			 => 5,
							'menu_class'	 => 'nav navbar-nav navbar-left',
							'fallback_cb'	 => 'wp_bootstrap_navwalker::fallback',
							'walker'		 => new wp_bootstrap_navwalker(),
						) );
						wp_nav_menu( array(
							'theme_location' => 'top_menu_right',
							'depth'			 => 5,
							'menu_class'	 => 'nav navbar-nav navbar-right',
							'fallback_cb'	 => 'wp_bootstrap_navwalker::fallback',
							'walker'		 => new wp_bootstrap_navwalker(),
						) );
					?>
				</div>
			</div>    
		</nav> 
	</div>
<?php endif; ?>
<div class="site-header container-fluid">
	<div class="container" >
		<div class="heading-row row" >
			<div class="site-heading text-center col-sm-8 col-sm-push-2" >
				<div class="site-branding-logo">
					<?php the_custom_logo(); ?>
				</div>
				<div class="site-branding-text">
					<?php if ( is_front_page() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif; ?>

					<?php
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) :
						?>
						<p class="site-description">
							<?php echo esc_html( $description ); ?>
						</p>
					<?php endif; ?>
				</div><!-- .site-branding-text -->
			</div>
			<?php if ( function_exists( 'envo_multipurpose_header_cart' ) && class_exists( 'WooCommerce' ) ) { ?>
				<div class="hidden-xs" >
					<?php envo_multipurpose_header_cart(); ?>
				</div>	
			<?php } ?>
			<?php if ( function_exists( 'envo_multipurpose_my_account' ) && class_exists( 'WooCommerce' ) ) { ?>
				<div class="hidden-xs" >
					<?php envo_multipurpose_my_account(); ?>
				</div>
			<?php } ?>
			<?php if ( is_active_sidebar( 'envo-multipurpose-header-area' ) ) { ?>
				<div class="site-heading-sidebar col-sm-8 col-sm-push-2" >
					<div id="content-header-section" class="text-center">
						<?php dynamic_sidebar( 'envo-multipurpose-header-area' ); ?>	
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php do_action( 'envo_multipurpose_before_menu' ); ?> 
<div class="main-menu">
	<nav id="site-navigation" class="navbar navbar-default">     
		<div class="container">   
			<div class="navbar-header">
				<?php if ( function_exists( 'max_mega_menu_is_enabled' ) && max_mega_menu_is_enabled( 'main_menu' ) ) : ?>
				<?php elseif ( has_nav_menu( 'main_menu' ) ) : ?>
					<?php if ( is_active_sidebar( 'envo-multipurpose-menu-area' ) ) { ?>
						<div class="offcanvas-sidebar-toggle mobile-canvas visible-xs">
							<i class="fa fa-bars"></i>
						</div>
					<?php } ?>
					<span class="navbar-brand brand-absolute visible-xs"><?php esc_html_e( 'Menu', 'envo-multipurpose' ); ?></span>
					<?php if ( function_exists( 'envo_multipurpose_header_cart' ) && class_exists( 'WooCommerce' ) ) { ?>
						<div class="mobile-cart visible-xs" >
							<?php envo_multipurpose_header_cart(); ?>
						</div>	
					<?php } ?>
					<?php if ( function_exists( 'envo_multipurpose_my_account' ) && class_exists( 'WooCommerce' ) ) { ?>
						<div class="mobile-account visible-xs" >
							<?php envo_multipurpose_my_account(); ?>
						</div>
					<?php } ?>
					<?php if ( get_theme_mod( 'menu-search', 1 ) == 1 ) { ?>
						<div class="top-search-icon visible-xs">
							<i class="fa fa-search"></i>
						</div>
					<?php } ?>
					<div id="main-menu-panel" class="open-panel" data-panel="main-menu-panel">
						<span></span>
						<span></span>
						<span></span>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( is_active_sidebar( 'envo-multipurpose-menu-area' ) ) { ?>
				<div class="offcanvas-sidebar-toggle hidden-xs">
					<i class="fa fa-bars"></i>
				</div>
			<?php } ?>
			<?php
				wp_nav_menu( array(
					'theme_location'	 => 'main_menu',
					'depth'				 => 5,
					'container'			 => 'div',
					'container_class'	 => 'menu-container',
					'menu_class'		 => 'nav navbar-nav navbar-center',
					'fallback_cb'		 => 'wp_bootstrap_navwalker::fallback',
					'walker'			 => new wp_bootstrap_navwalker(),
				) );
			?>
			<?php if ( get_theme_mod( 'menu-search', 1 ) == 1 ) { ?>
				<div class="top-search-icon hidden-xs">
					<i class="fa fa-search"></i>
				</div>
			<?php } ?>
			<?php if ( class_exists( 'DGWT_WC_Ajax_Search' ) && class_exists( 'WooCommerce' ) ) { ?>
				<div class="top-search-box">
					<?php echo do_shortcode( '[wcas-search-form]' ); ?>
				</div>
			<?php } else { ?>
				<div class="top-search-box">
					<?php get_search_form(); ?>
				</div>
			<?php } ?>
		</div>
		<?php do_action( 'envo_multipurpose_menu' ); ?>
	</nav> 
</div>
<?php do_action( 'envo_multipurpose_after_menu' ); ?>
