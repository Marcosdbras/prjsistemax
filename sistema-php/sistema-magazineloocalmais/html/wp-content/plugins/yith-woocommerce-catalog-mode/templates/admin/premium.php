<style>

	img {
		width: 90%;
	}

	.landing {
		margin-right: 15px;
		border: 1px solid #d8d8d8;
		border-top: 0;
	}

	.section {
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
		background: #fafafa;
	}

	.section h1 {
		text-align: center;
		text-transform: uppercase;
		color: #445674;
		font-size: 35px;
		font-weight: 700;
		line-height: normal;
		display: inline-block;
		width: 100%;
		margin: 50px 0 0;
	}

	.section .section-title h2 {
		vertical-align: middle;
		padding: 0;
		line-height: 1.3;
		font-size: 20px;
		font-weight: 700;
		color: #445674;
		text-transform: none;
		background: none;
		border: none;
		text-align: left;
	}

	.section p {
		margin: 15px 0;
		font-size: 17px;
		line-height: 32px;
		font-weight: 300;
		text-align: left;
	}

	.section ul li {
		margin-bottom: 4px;
	}

	.section.section-cta {
		background: #fff;
	}

	.cta-container,
	.landing-container {
		display: flex;
		max-width: 1200px;
		margin-left: auto;
		margin-right: auto;
		padding: 30px 0;
		align-items: center;
	}

	.landing-container-wide {
		flex-direction: column;
	}

	.cta-container {
		display: block;
		max-width: 860px;
	}

	.landing-container:after {
		display: block;
		clear: both;
		content: '';
	}

	.landing-container .col-1,
	.landing-container .col-2 {
		float: left;
		box-sizing: border-box;
		padding: 0 15px;
	}

	.landing-container .col-1 {
		width: 58.33333333%;
	}

	.landing-container .col-2 {
		width: 41.66666667%;
	}

	.landing-container .col-1 img,
	.landing-container .col-2 img,
	.landing-container .col-wide img {
		max-width: 100%;
	}

	.premium-cta {
		color: #4b4b4b;
		border-radius: 10px;
		padding: 30px 25px;
		display: flex;
		align-items: center;
		justify-content: space-between;
		width: 100%;
		box-sizing: border-box;
	}

	.premium-cta:after {
		content: '';
		display: block;
		clear: both;
	}

	.premium-cta p {
		margin: 10px 0;
		line-height: 1.5em;
		display: inline-block;
		text-align: left;
	}

	.premium-cta a.button {
		border-radius: 25px;
		float: right;
		background: #e09004;
		box-shadow: none;
		outline: none;
		color: #fff;
		position: relative;
		padding: 10px 50px 8px;
		text-align: center;
		text-transform: uppercase;
		font-weight: 600;
		font-size: 20px;
		line-height: normal;
		border: none;
	}

	.premium-cta a.button:hover,
	.premium-cta a.button:active,
	.wp-core-ui .yith-plugin-ui .premium-cta a.button:focus {
		color: #fff;
		background: #d28704;
		box-shadow: none;
		outline: none;
	}

	.premium-cta .highlight {
		text-transform: uppercase;
		background: none;
		font-weight: 500;
	}

	@media (max-width: 991px) {
		.landing-container {
			display: block;
			padding: 50px 0 30px;
		}

		.landing-container .col-1,
		.landing-container .col-2 {
			float: none;
			width: 100%;
		}

		.premium-cta {
			display: block;
			text-align: center;
		}

		.premium-cta p {
			text-align: center;
			display: block;
			margin-bottom: 30px;
		}

		.premium-cta a.button {
			float: none;
			display: inline-block;
		}
	}
</style>
<div class="landing">
	<div class="section section-cta section-odd">
		<div class="cta-container">
			<div class="premium-cta">
				<p>
					<?php
					/* translators: %1$s opening span, %2$s closing span, %3$s BR tag*/
					echo sprintf( esc_html__( 'Upgrade to %1$spremium version%2$s%3$s of %1$sYITH WooCommerce Catalog Mode%2$s to benefit from all features!', 'yith-woocommerce-catalog-mode' ), '<span class="highlight">', '</span>', '<br />' );
					?>
				</p>
				<a href="<?php echo $this->get_premium_landing_uri(); ?>" target="_blank" class="premium-cta-button button btn">
					<?php esc_html_e( 'Upgrade', 'yith-woocommerce-catalog-mode' ); ?>
				</a>
			</div>
		</div>
	</div>
	<div class="one section section-even clear">
		<h1><?php esc_html_e( 'Premium Features', 'yith-woocommerce-catalog-mode' ); ?></h1>
		<div class="landing-container">
			<div class="col-1">
				<img src="<?php echo YWCTM_ASSETS_URL; ?>/images/premium-01.jpg" alt="" />
			</div>
			<div class="col-2">
				<div class="section-title">
					<h2><?php esc_html_e( 'Build up a catalogue of products and online services and encourage your customers to contact you to get a dedicated price estimate or additional information.', 'yith-woocommerce-catalog-mode' ); ?></h2>
				</div>
				<p>
					<?php esc_html_e( 'Are you starting an e-commerce website, but still it is not ready for automatic sales? Your store might be temporarily closed due to holidays or prepare for a sales period and you need to temporarily suspend sales. YITH WooCommerce Catalog Mode is a plugin designed for those who need to turn their shop into an online catalog.', 'yith-woocommerce-catalog-mode' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'Are you interested in displaying a catalogue with products without making them immediately available for sale? Or do you want to filter buyers and let only registered users see all the details? Are you taking inventory but would like to leave products online?', 'yith-woocommerce-catalog-mode' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'YITH WooCommerce Catalog Mode allows you to turn your online shop into a catalogue, by removing Add to Cart buttons and any access to checkout pages, by hiding product prices and replacing it with customizable buttons, text labels and inquiry forms.', 'yith-woocommerce-catalog-mode' ); ?>
				</p>
			</div>
		</div>
	</div>
	<div class="two section section-odd clear">
		<div class="landing-container">
			<div class="col-2">
				<div class="section-title">
					<h2><?php esc_html_e( 'Enable ‘Massive catalog mode’ with one click and disable the Cart, the Checkout and all add to cart buttons of your shop in a few quick moves.', 'yith-woocommerce-catalog-mode' ); ?></h2>
				</div>
				<p>
					<?php esc_html_e( 'If you have a catalogue with many products and you want to quickly hide the Cart button and the Cart page, you will be able to do that with one click. Whenever you’re ready to sell, just one more click and your catalogue can be immediately converted into an e-commerce shop in full swing.', 'yith-woocommerce-catalog-mode' ); ?>
				</p>
			</div>
			<div class="col-1">
				<img src="<?php echo YWCTM_ASSETS_URL; ?>/images/premium-02.jpg" alt="" />
			</div>
		</div>
	</div>
	<div class="three section section-even clear">
		<div class="landing-container">
			<div class="col-1">
				<img src="<?php echo YWCTM_ASSETS_URL; ?>/images/premium-03.jpg" alt="" />
			</div>
			<div class="col-2">
				<div class="section-title">
					<h2><?php esc_html_e( 'Hide prices and Cart buttons from all products or only from selected products, tags or categories.', 'yith-woocommerce-catalog-mode' ); ?></h2>
				</div>
				<p>
					<?php esc_html_e( 'Do you want to make only some products purchasable and set up the catalog mode for others that cannot be purchased straight away? You’ll be able to create an unlimited number of rules and apply them to products of your choice.', 'yith-woocommerce-catalog-mode' ); ?>
				</p>
			</div>
		</div>
	</div>
	<div class="four section section-odd clear">
		<div class="landing-container">
			<div class="col-2">
				<div class="section-title">
					<h2><?php esc_html_e( 'Enable the catalog mode for unregistered users or only for users from specific countries.', 'yith-woocommerce-catalog-mode' ); ?></h2>
				</div>
				<p>
					<?php esc_html_e( 'Do you want to show your product prices only to users who have registered an account? Or maybe restrict purchases only to users from a specific geographical area? These are just some of the many scenarios that YITH Catalog Mode can help you deal with.', 'yith-woocommerce-catalog-mode' ); ?>
				</p>
			</div>
			<div class="col-1">
				<img src="<?php echo YWCTM_ASSETS_URL; ?>/images/premium-04.jpg" alt="" />
			</div>
		</div>
	</div>
	<div class="five section section-even clear">
		<div class="landing-container">
			<div class="col-1">
				<img src="<?php echo YWCTM_ASSETS_URL; ?>/images/premium-05.jpg" alt="" />
			</div>
			<div class="col-2">
				<div class="section-title">
					<h2><?php esc_html_e( 'Create custom calls to action and labels to replace the price and Cart buttons.', 'yith-woocommerce-catalog-mode' ); ?></h2>
				</div>
				<p>
					<?php esc_html_e( 'If your products cannot be purchased straight away, you probably need to push users to contact you and ask for a dedicated price estimate or simply for more details. Or you might want them to register an account in your shop or log in. With our button & label builder, you can create countless persuasive texts and calls to action for your products.', 'yith-woocommerce-catalog-mode' ); ?>
				</p>
			</div>
		</div>
	</div>
	<div class="six section section-odd clear">
		<div class="landing-container">
			<div class="col-2">
				<div class="section-title">
					<h2><?php esc_html_e( 'Enable an inquiry form on your product pages to help your customers contact you easily.', 'yith-woocommerce-catalog-mode' ); ?></h2>
				</div>
				<p>
					<?php esc_html_e( 'Choose whether you want to enable a contact form on your product pages to make it easier for your users to get in touch with you. The enquiry form is compatible with several email management plugins: Contact Form 7, Formidable Forms, Gravity Forms and Ninja Forms. In the email message that you receive, you can also see a reference to the page from where the request has been submitted.', 'yith-woocommerce-catalog-mode' ); ?>
				</p>
			</div>
			<div class="col-1">
				<img src="<?php echo YWCTM_ASSETS_URL; ?>/images/premium-06.jpg" alt="" />
			</div>
		</div>
	</div>
	<div class="seven section section-even clear">
		<div class="landing-container">
			<div class="col-1">
				<img src="<?php echo YWCTM_ASSETS_URL; ?>/images/premium-07.jpg" alt="" />
			</div>
			<div class="col-2">
				<div class="section-title">
					<h2><?php esc_html_e( 'Integrate the catalog mode with YITH WooCommerce Multi-vendor', 'yith-woocommerce-catalog-mode' ); ?></h2>
				</div>
				<p>
					<?php esc_html_e( 'If you use YITH Multi Vendor, you can let every vendor set up and control the catalog mode for their own shop.', 'yith-woocommerce-catalog-mode' ); ?>
				</p>
			</div>
		</div>
	</div>
	<div class="section section-cta section-odd">
		<div class="cta-container">
			<div class="premium-cta">
				<p>
					<?php
					/* translators: %1$s opening span, %2$s closing span, %3$s BR tag*/
					echo sprintf( esc_html__( 'Upgrade to %1$spremium version%2$s%3$s of %1$sYITH WooCommerce Catalog Mode%2$s to benefit from all features!', 'yith-woocommerce-catalog-mode' ), '<span class="highlight">', '</span>', '<br />' );
					?>
				</p>
				<a href="<?php echo $this->get_premium_landing_uri(); ?>" target="_blank" class="premium-cta-button button btn">
					<?php esc_html_e( 'Upgrade', 'yith-woocommerce-catalog-mode' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
