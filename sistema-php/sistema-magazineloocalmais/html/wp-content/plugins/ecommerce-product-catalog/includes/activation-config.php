<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages product includes folder
 *
 * Here all plugin includes folder is defined and managed.
 *
 * @version		1.0.0
 * @package		ecommerce-product-catalog/includes
 * @author 		impleCode
 */
class ic_cat_activation_wizard extends ic_activation_wizard {

	function __construct() {
		$this->display_notice	 = false;
		$this->notices			 = '';
		add_action( 'in_admin_header', array( $this, 'notices' ) );
	}

	function notices() {
		ob_start();
		$this->activation_notices();
		$this->notices = ob_get_clean();
		if ( $this->display_notice ) {
			remove_all_actions( 'ic_catalog_admin_notices' );
		}
		add_action( 'ic_catalog_admin_priority_notices', array( $this, 'activation_notices' ), -1 );
	}

	function activation_notices() {
		if ( !empty( $this->notices ) ) {
			echo $this->notices;
			return;
		}
		$this->display_notice = false;
		if ( is_ic_activation_notice() && $this->get_notice_status( 'notice-ic-catalog-activation' ) ) {
			delete_option( 'IC_EPC_activation_message' );
		}
		$response = array();
		if ( is_ic_activation_notice() && !$this->get_notice_status( 'notice-ic-catalog-activation' ) ) {
			$this->display_notice	 = true;
			$not_complete			 = true;
			$response				 = $this->get_choice_response();
			$questions				 = $this->response_to_question( $response );
			if ( !empty( $questions ) ) {
				$this->box_header( sprintf( __( '%s is active now!', 'ecommerce-product-catalog' ), IC_CATALOG_PLUGIN_NAME ) );
				if ( empty( $response[ 'question' ] ) ) {
					$this->box_paragraph( __( 'Make a choice below to continue with 1 minute catalog setup.', 'ecommerce-product-catalog' ) );
				}
			}
			if ( !empty( $response[ 'question' ] ) ) {
				$this->box_paragraph( $response[ 'question' ] );
			}
			$form = false;
			if ( count( $questions ) === 1 ) {
				$form = $response[ 'next_one' ];
			}

			if ( empty( $questions ) ) {
				update_option( 'IC_EPC_activation_message_done', 1 );
				$not_complete = false;

				$complete = apply_filters( 'ic_cat_activation_wizard_complete', true, $questions, $response );
				if ( $complete ) {
					if ( $this->any_recommended_extensions() && !$this->get_notice_status( 'notice-ic-catalog-recommended' ) ) {
						if ( $this->show_woocommerce_notice() && $this->get_woo_choice() === 'woo-design' ) {
							remove_action( 'ic_cat_activation_wizard_bottom', array( 'ic_catalog_notices', 'getting_started_docs_info' ) );
						}
						$this->recommended_extensions_box( false );
					} else {
						delete_option( 'IC_EPC_activation_message' );
						delete_option( 'IC_EPC_activation_message_done' );
						$catalog_names = get_catalog_names();
						$this->box_header( sprintf( __( "Congratulations! Your're ready to add %s.", 'ecommerce-product-catalog' ), $catalog_names[ 'plural' ] ) );

						$questions = array(
							admin_url( 'post-new.php?post_type=al_product' )														 => sprintf( __( 'Add First %s', 'ecommerce-product-catalog' ), $catalog_names[ 'singular' ] ),
							admin_url( 'edit.php?post_type=al_product&page=product-settings.php&tab=product-settings&submenu=csv' )	 => sprintf( __( 'Import %s', 'ecommerce-product-catalog' ), $catalog_names[ 'plural' ] )
						);
					}
				}
			}
			if ( !empty( $questions ) ) {
				$this->box_choice( $questions, $form );
			}
			if ( !empty( $not_complete ) ) {
				$this->box_paragraph( __( 'You will be able to change your choice later in catalog settings or by reactivating the plugin.', 'ecommerce-product-catalog' ), true );
			}
			$this->wizard_box();
		} else if ( is_ic_catalog_admin_page() && $this->any_recommended_extensions() && !$this->get_notice_status( 'notice-ic-catalog-recommended' ) ) {
			$this->display_notice = true;
			$this->recommended_extensions_box();
		} else if ( is_ic_new_product_screen() ) {
			$count			 = ic_products_count();
			$sample_exists	 = ic_sample_page_exists();
			if ( ($sample_exists && $count === 1) || (!$sample_exists && empty( $count ) ) ) {
				$this->display_notice	 = true;
				$catalog_names			 = get_catalog_names();
				$this->box_header( sprintf( __( 'Add your first %s here.', 'ecommerce-product-catalog' ), $catalog_names[ 'singular' ] ) );
				$this->box_paragraph( __( 'By default you should see a two column layout here:', 'ecommerce-product-catalog' ) );
				$optional				 = '(' . __( 'optional', 'ecommerce-product-catalog' ) . ')';
				$left_side				 = __( 'on the left side', 'ecommerce-product-catalog' );
				$right_side				 = __( 'on the right side', 'ecommerce-product-catalog' );
				$strong_op				 = '<strong>';
				$strong_cl				 = '</strong>';
				$list					 = array(
					$strong_op . __( 'Name field', 'ecommerce-product-catalog' ) . $strong_cl . ' - ' . $left_side,
					$strong_op . __( 'Short description field', 'ecommerce-product-catalog' ) . $strong_cl . ' - ' . $left_side,
					$strong_op . __( 'Long Description field', 'ecommerce-product-catalog' ) . $strong_cl . ' - ' . $left_side,
					$strong_op . __( 'Attributes box', 'ecommerce-product-catalog' ) . $strong_cl . ' ' . $optional . ' - ' . $left_side . ' - ' . __( 'you can define their number in catalog settings.', 'ecommerce-product-catalog' ),
					$strong_op . __( 'Image box', 'ecommerce-product-catalog' ) . $strong_cl . ' - ' . $right_side,
					$strong_op . __( 'Publish box', 'ecommerce-product-catalog' ) . $strong_cl . ' - ' . $right_side,
					$strong_op . __( 'Categories box', 'ecommerce-product-catalog' ) . $strong_cl . ' - ' . $right_side,
					$strong_op . __( 'Price & SKU box', 'ecommerce-product-catalog' ) . $strong_cl . ' ' . $optional . ' - ' . $right_side
				);
				$this->box_list( $list );
				$this->box_paragraph( __( 'You can move all the boxes around to better suit your needs.', 'ecommerce-product-catalog' ) );
				$this->box_paragraph( __( 'This help box will disappear once you add your first product.', 'ecommerce-product-catalog' ), true );
				$this->wizard_box( '', 'style="text-align: left;"' );
			}
		} else if ( is_ic_edit_product_screen() && !$this->get_notice_status( 'notice-ic-catalog-activation' ) ) {
			$product_id = get_the_ID();
			if ( !empty( $product_id ) && is_ic_product( $product_id ) && ic_product_exists( $product_id ) ) {
				$product_url			 = get_permalink( $product_id );
				$url					 = admin_url( 'customize.php?autofocus[control]=ic_pc_integration_template&url=' . rawurldecode( $product_url ) . '&return=' . rawurldecode( admin_url( 'edit.php?post_type=al_product' ) ) );
				$this->display_notice	 = true;
				$catalog_names			 = get_catalog_names();
				$this->box_header( sprintf( __( "Let's customize your %s page layout.", 'ecommerce-product-catalog' ), $catalog_names[ 'singular' ] ) );
				$questions				 = array(
					$url => sprintf( __( 'Customize %s Page Layout', 'ecommerce-product-catalog' ), $catalog_names[ 'singular' ] )
				);
				$this->box_choice( $questions );
				$this->wizard_box( 'notice-ic-catalog-activation' );
			}
		} else if ( is_ic_product_list_admin_screen() && !$this->get_notice_status( 'notice-ic-catalog-activation' ) ) {
			$this->display_notice	 = true;
			$listing_id				 = intval( get_product_listing_id() );
			$catalog_names			 = get_catalog_names();

			if ( !empty( $listing_id ) ) {
				$listing_url		 = get_permalink( $listing_id );
				$url				 = admin_url( 'customize.php?autofocus[control]=ic_pc_archive_template&url=' . rawurlencode( $listing_url ) . '&return=' . rawurlencode( admin_url( 'edit.php?post_type=al_product&page=product-settings.php' ) ) );
				$message			 = sprintf( __( 'Your main %s listing page is defined.', 'ecommerce-product-catalog' ), $catalog_names[ 'singular' ] );
				$message			 .= ' ' . __( 'Template files will be used to display catalog pages.', 'ecommerce-product-catalog' );
				$button_label		 = __( 'Customize Listing Layout', 'ecommerce-product-catalog' );
				$url_two			 = admin_url( 'post.php?post=' . $listing_id . '&action=edit' );
				$button_label_two	 = __( 'Edit Main Listing', 'ecommerce-product-catalog' );
				$url_three			 = $listing_url;
				$button_label_three	 = __( 'Visit Main Listing', 'ecommerce-product-catalog' );
			} else {
				$message		 = sprintf( __( 'Your main %s listing page is not selected. You can use shortcodes to display your products but in most cases it will be more convienient to use the templates.', 'ecommerce-product-catalog' ), $catalog_names[ 'singular' ] );
				$url			 = admin_url( 'edit.php?post_type=al_product&page=product-settings.php' );
				$button_label	 = sprintf( __( 'Select Main %s Listing Page', 'ecommerce-product-catalog' ), $catalog_names[ 'singular' ] );
			}
			$this->box_paragraph( $message );
			$questions = array(
				$url => $button_label
			);
			if ( !empty( $button_label_two ) && !empty( $url_two ) ) {
				$questions[ $url_two ] = $button_label_two;
			}
			if ( !empty( $button_label_three ) && !empty( $url_three ) ) {
				$questions[ $url_three ] = $button_label_three;
			}
			$this->box_choice( $questions );
			$this->wizard_box( 'notice-ic-catalog-activation' );
		} else if ( is_ic_catalog_admin_page() && !$this->get_notice_status( 'notice-ic-catalog-activation' ) ) {
			$this->display_notice = true;

			$this->box_header( __( 'Great! It looks like you are good to go with your catalog adventure.', 'ecommerce-product-catalog' ) );
			$this->box_paragraph( sprintf( __( 'If you have any questions or issues feel free to post a %ssupport ticket%s.', 'ecommerce-product-catalog' ), '<a href="https://implecode.com/support/#cam=simple-mode&key=support-top">', '</a>' ) );
			$this->box_paragraph( sprintf( __( 'If you are looking for a customizable product theme the free %sCatalog Me! theme%s is the way to go.', 'ecommerce-product-catalog' ), '<a href="' . admin_url( 'theme-install.php?search=Catalog+me%21' ) . '">', '</a>' ) );
			$this->box_paragraph( __( 'Make sure to visit the documentation for more tweaks and tricks.', 'ecommerce-product-catalog' ) );
			$questions	 = array(
				'https://implecode.com/docs/ecommerce-product-catalog/getting-started/#cam=default-mode&key=getting-started' => __( 'Getting Started Guide', 'ecommerce-product-catalog' ),
				'https://implecode.com/docs/ecommerce-product-catalog/#cam=default-mode&key=docs'							 => __( 'Documentation', 'ecommerce-product-catalog' )
			);
			$listing_id	 = intval( get_product_listing_id() );
			if ( !empty( $listing_id ) ) {
				$listing_url				 = get_permalink( $listing_id );
				$questions[ $listing_url ]	 = __( 'Main Catalog Listing', 'ecommerce-product-catalog' );
			}
			$this->box_choice( apply_filters( 'ic_cat_activation_wizard_final_questions', $questions ) );

			$this->wizard_box( 'notice-ic-catalog-activation' );
		}
	}

	function activation_message_done() {
		$done = get_option( 'IC_EPC_activation_message_done', 0 );
		if ( !empty( $done ) ) {
			return true;
		}
		return false;
	}

	function get_choice_response( $answer = null ) {

		$response = array();
		if ( $this->activation_message_done() ) {
			$answer = 'complete';
		} else if ( empty( $answer ) && !empty( $_GET[ 'ic_catalog_activation_choice' ] ) ) {
			$answer = esc_attr( $_GET[ 'ic_catalog_activation_choice' ] );
		}
		switch ( $answer ) {
			case 'price-on':
				if ( function_exists( 'get_currency_settings' ) ) {
					$currency_settings = get_currency_settings();
				} else {
					$this->add_recommended_extension( 'price-field' );
				}
				if ( !empty( $_GET[ 'product_currency' ] ) ) {
					if ( function_exists( 'get_currency_settings' ) ) {
						$currency_code	 = esc_attr( $_GET[ 'product_currency' ] );
						update_option( 'product_currency', $currency_code );
						$symbol			 = ic_cat_get_currency_symbol( $currency_code );
						if ( !empty( $symbol ) ) {
							$currency_settings[ 'custom_symbol' ] = $symbol;
						}
					}
					$response = $this->shipping_choice_response();
				} else {
					if ( function_exists( 'get_currency_settings' ) ) {
						$currency_settings[ 'price_enable' ] = 'on';
						$response[ 'one' ]					 = ic_cat_get_currency_switcher();
						$response[ 'next_one' ]				 = 'price-on';
						$response[ 'question' ]				 = __( 'Select your currency. You can also set a custom currency in catalog settings later.', 'ecommerce-product-catalog' );
					} else {
						$response = $this->shipping_choice_response();
					}
				}
				if ( function_exists( 'get_currency_settings' ) ) {
					update_option( 'product_currency_settings', $currency_settings );
				}
				break;
			case 'price-off':
				if ( function_exists( 'get_currency_settings' ) ) {
					$currency_settings					 = get_currency_settings();
					$currency_settings[ 'price_enable' ] = 'off';
					update_option( 'product_currency_settings', $currency_settings );
				}
				$response = $this->shipping_choice_response();
				break;
			case 'shipping-on':
				if ( function_exists( 'is_ic_shipping_enabled' ) ) {
					update_option( 'product_shipping_options_number', 1 );
				}
				$response = $this->catalog_names_choice_response();
				$this->add_recommended_extension( 'shipping-options' );

				break;
			case 'woo-design':
				//$response = $this->price_choice_response();
				$this->add_recommended_extension( 'catalog-booster-for-woocommerce' );
				update_option( 'ic_cat_wizard_woo_choice', 'woo-design' );

				break;
			case 'woo-separate':
				$response = $this->price_choice_response();
				update_option( 'ic_cat_wizard_woo_choice', 'woo-separate' );

				break;
			case 'shipping-off':
				if ( function_exists( 'is_ic_shipping_enabled' ) ) {
					update_option( 'product_shipping_options_number', 0 );
				}
				$response = $this->catalog_names_choice_response();
				break;
			case 'complete':
				if ( !empty( $_GET[ 'catalog_singular' ] ) || !empty( $_GET[ 'catalog_plural' ] ) ) {
					$archive_multiple_settings = get_multiple_settings();
					if ( !empty( $_GET[ 'catalog_singular' ] ) ) {
						$archive_multiple_settings[ 'catalog_singular' ] = esc_attr( $_GET[ 'catalog_singular' ] );
					}
					if ( !empty( $_GET[ 'catalog_plural' ] ) ) {
						$archive_multiple_settings[ 'catalog_plural' ] = esc_attr( $_GET[ 'catalog_plural' ] );
					}
					update_option( 'archive_multiple_settings', $archive_multiple_settings );
				}
				break;
			default:
				$response = apply_filters( 'ic_cat_activation_wizard_default_response', false );
				if ( !$response ) {
					if ( $this->show_woocommerce_notice() ) {
						remove_action( 'ic_cat_activation_wizard_bottom', array( 'ic_catalog_notices', 'getting_started_docs_info' ) );
						$response = $this->woo_choice_response();
					} else {
						$response = $this->price_choice_response();
					}
				}
		}
		return $response;
	}

	function shipping_choice_response() {
		$response[ 'one' ]		 = __( 'Shipping enabled for all or some products', 'ecommerce-product-catalog' );
		$response[ 'next_one' ]	 = 'shipping-on';
		$response[ 'two' ]		 = __( 'Shipping disabled completely', 'ecommerce-product-catalog' );
		$response[ 'next_two' ]	 = 'shipping-off';
		return $response;
	}

	function price_choice_response() {
		$response[ 'one' ]		 = __( 'Price enabled for all or some products', 'ecommerce-product-catalog' );
		$response[ 'next_one' ]	 = 'price-on';
		$response[ 'two' ]		 = __( 'Price disabled completely', 'ecommerce-product-catalog' );
		$response[ 'next_two' ]	 = 'price-off';
		return $response;
	}

	function woo_choice_response() {
		$response[ 'one' ]		 = __( 'Create Separate Catalog', 'ecommerce-product-catalog' );
		$response[ 'next_one' ]	 = 'woo-separate';
		$response[ 'two' ]		 = sprintf( __( 'Modify %s Design', 'ecommerce-product-catalog' ), 'WooCommerce' );
		$response[ 'next_two' ]	 = 'woo-design';
		$response[ 'question' ]	 = sprintf( __( 'It looks like you have also %s active. Make a choice below for a correct setup.', 'ecommerce-product-catalog' ), 'WooCommerce' ) . '<br><br>' . sprintf( __( 'I would like to use %s to:', 'ecommerce-product-catalog' ), IC_CATALOG_PLUGIN_NAME );
		return $response;
	}

	function catalog_names_choice_response() {
		$archive_multiple_settings	 = get_multiple_settings();
		$one						 = '<table style="margin:0 auto;"><tr>';
		$one						 .= implecode_settings_text( __( 'Catalog Singular Name', 'ecommerce-product-catalog' ), 'catalog_singular', $archive_multiple_settings[ 'catalog_singular' ], null, 0, null, __( 'Admin panel customisation setting. Change it to what you sell.', 'ecommerce-product-catalog' ) . ' ' . __( 'Examples: Service, Part, Flower, Photo', 'ecommerce-product-catalog' ) );
		$one						 .= implecode_settings_text( __( 'Catalog Plural Name', 'ecommerce-product-catalog' ), 'catalog_plural', $archive_multiple_settings[ 'catalog_plural' ], null, 0, null, __( 'Admin panel customisation setting. Change it to what you sell.', 'ecommerce-product-catalog' ) . ' ' . __( 'Examples: Services, Parts, Flowers, Photos', 'ecommerce-product-catalog' ) );
		$one						 .= '</tr></table>';
		$response[ 'one' ]			 = $one;
		$response[ 'next_one' ]		 = 'complete';
		return $response;
	}

	static function get_woo_choice() {
		$choice = get_option( 'ic_cat_wizard_woo_choice' );
		return $choice;
	}

}

$ic_cat_activation_wizard = new ic_cat_activation_wizard;
