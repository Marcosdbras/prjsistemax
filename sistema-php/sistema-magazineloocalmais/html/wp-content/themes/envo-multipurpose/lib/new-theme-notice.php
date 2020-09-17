<?php
/**
 * Theme Notice Class
 *
 */

// Exit if directly accessed.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Envo_Multipurpose_New_Theme_Notice
 */
class Envo_Multipurpose_New_Theme_Notice {

	/**
	 * Constructor function to include the required functionality for the class.
	 *
	 * Envo_Multipurpose_New_Theme_Notice constructor.
	 */
	public function __construct() {

		add_action( 'after_switch_theme', array( $this, 'envo_multipurpose_theme_notice' ) );

		// Display the new theme notice when transient is present.
		//if ( get_transient( 'envo_multipurpose_theme_switched' ) ) {
			add_action( 'admin_notices', array( $this, 'envo_multipurpose_new_theme_notice' ) );
			add_action( 'admin_init', array( $this, 'envo_multipurpose_ignore_new_theme_notice' ) );
		//}

	}

	/**
	 * Set the transient after switch theme..
	 */
	public function envo_multipurpose_theme_notice() {

		//set_transient( 'envo_multipurpose_theme_switched', 'envo_multipurpose_new_theme_notice', 3 * DAY_IN_SECONDS );
		add_action( 'admin_notices', array( $this, 'envo_multipurpose_new_theme_notice' ) );
		add_action( 'admin_init', array( $this, 'envo_multipurpose_ignore_new_theme_notice' ) );

	}

	/**
	 * Add a dismissible notice in the dashboard about new theme.
	 */
	public function envo_multipurpose_new_theme_notice() {
		global $current_user;
		$user_id        = $current_user->ID;
		$ignored_notice = get_user_meta( $user_id, 'envo_multipurpose_ignore_new_theme_notice' );
		if ( ! empty( $ignored_notice ) ) {
			return;
		}

		$dismiss_button = sprintf(
			'<a href="%s" class="notice-dismiss" style="text-decoration:none;"></a>',
			'?nag_ignore_new_theme=0'
		);

		$message = sprintf(
		/* translators: %1$s Envo eCommerce theme link %2$s Envo eCommerce theme demo link */
			__( 'Envo eCommerce - our new free WooCommerce theme. <a target="_blank" href="%1$s"><strong>Check it out!</strong></a> Envo eCommerce is fully compatible with Gutenberg, Elementor and other major page builders. Comes with <a target="_blank" href="%2$s"><strong>one click demo import</strong></a> to quickly setup your new website.', 'envo-multipurpose' ),
            esc_url( admin_url( 'theme-install.php?theme=envo-ecommerce' ) ),
            esc_url( 'https://envothemes.com/envo-ecommerce/' )
		);

		printf(
			'<div class="notice updated" style="position:relative;">%1$s<p>%2$s</p></div>',
			$dismiss_button,
			$message
		);
	}

	/**
	 * Update the envo_multipurpose_ignore_new_theme_notice option to true, to dismiss the notice from the dashboard
	 */
	public function envo_multipurpose_ignore_new_theme_notice() {
		global $current_user;
		$user_id = $current_user->ID;

		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['nag_ignore_new_theme'] ) && '0' == $_GET['nag_ignore_new_theme'] ) {
			add_user_meta( $user_id, 'envo_multipurpose_ignore_new_theme_notice', 'true', true );
		}
	}

}

new Envo_Multipurpose_New_Theme_Notice();
