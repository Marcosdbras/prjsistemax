<?php if ( is_active_sidebar( 'envo-multipurpose-homepage-area' ) ) { ?>
	<div class="homepage-main-content-page">
		<div class="homepage-area"> 
			<?php
			if ( is_active_sidebar( 'envo-multipurpose-homepage-area' ) ) {
				dynamic_sidebar( 'envo-multipurpose-homepage-area' );
			}
			?>
		</div>
	</div>
<?php } ?>
