(function ($) {
    'use strict';
    jQuery(document).ready(function (jQuery) {
        var readyCheckAttr = jQuery.trim(jQuery('#auto_display_banner').attr('checked'));
        var catSelectImageType = jQuery.trim(jQuery('#cat_select_image_type').val());
        if ('undefined' == readyCheckAttr || '' == readyCheckAttr) {
            jQuery('#select_banner').hide();
            jQuery('#hide_cat_banner_start_date').hide();
            jQuery('#hide_cat_banner_end_date').hide();
            jQuery('.hide_random_images_banner').hide();
            jQuery('.hide_cat_slider_setting').hide();

            jQuery('.hide_mdwbm_banner_url_form_field').hide();
            jQuery('.hide_mdwbm_banner_image_form_field').hide();

            jQuery('.hide_cat_single_banner_upload').hide();
            jQuery('.hide_cat_single_banner_image').hide();
            jQuery('.hide_banner_link_form_field').hide();
            jQuery('.top_display_banner').hide();
        } else {
            if ('cat-single-image' === catSelectImageType || '' === catSelectImageType ) {
                jQuery('.hide_random_images_banner').hide();
                jQuery('.hide_cat_slider_setting').hide();
                jQuery('.hide_mdwbm_banner_url_form_field').hide();
                jQuery('.hide_mdwbm_banner_image_form_field').hide();

                jQuery('.hide_cat_single_banner_upload').show();
                jQuery('.hide_cat_single_banner_image').show();
                jQuery('.hide_banner_link_form_field').show();
            } else {
                jQuery('.hide_cat_single_banner_upload').hide();
                jQuery('.hide_cat_single_banner_image').hide();
                jQuery('.hide_banner_link_form_field').hide();

                jQuery('.hide_random_images_banner').show();
                jQuery('.hide_cat_slider_setting').show();
                jQuery('.hide_mdwbm_banner_url_form_field').show();
                jQuery('.hide_mdwbm_banner_image_form_field').show();
            }
            jQuery('.top_display_banner').show();
        }

        jQuery('#auto_display_banner').click(function () {
            var chkAttr = jQuery.trim(jQuery(this).attr('checked'));
            if ('undefined' == chkAttr || '' == chkAttr) {
                jQuery('#select_banner').hide();
                jQuery('#hide_cat_banner_start_date').hide();
                jQuery('#hide_cat_banner_end_date').hide();
                jQuery('.hide_random_images_banner').hide();
                jQuery('.hide_cat_slider_setting').hide();

                jQuery('.hide_mdwbm_banner_url_form_field').hide();
                jQuery('.hide_mdwbm_banner_image_form_field').hide();

                jQuery('.hide_cat_single_banner_upload').hide();
                jQuery('.hide_cat_single_banner_image').hide();
                jQuery('.hide_banner_link_form_field').hide();
                jQuery('.top_display_banner').hide();
            } else {
                jQuery('#select_banner').show();
                jQuery('#hide_cat_banner_start_date').show();
                jQuery('#hide_cat_banner_end_date').show();
                if ('cat-single-image' === catSelectImageType || '' === catSelectImageType) {
                    jQuery('.hide_random_images_banner').hide();
                    jQuery('.hide_cat_slider_setting').hide();
                    jQuery('.hide_mdwbm_banner_url_form_field').hide();
                    jQuery('.hide_mdwbm_banner_image_form_field').hide();

                    jQuery('.hide_cat_single_banner_upload').show();
                    jQuery('.hide_cat_single_banner_image').show();
                    jQuery('.hide_banner_link_form_field').show();
                } else {
                    jQuery('.hide_cat_single_banner_upload').hide();
                    jQuery('.hide_cat_single_banner_image').hide();
                    jQuery('.hide_banner_link_form_field').hide();

                    jQuery('.hide_random_images_banner').show();
                    jQuery('.hide_cat_slider_setting').show();
                    jQuery('.hide_mdwbm_banner_url_form_field').show();
                    jQuery('.hide_mdwbm_banner_image_form_field').show();
                }
                jQuery('.top_display_banner').show();
            }
        });

        jQuery('#mdwbm_remove_file_id').click(function () {
            jQuery('#cat_banner_single_img_admin_id').attr('src', '');
            jQuery('#mdwbm_image_id').val('');
            jQuery('#display_image_id').hide();
        });

        jQuery('#mdwbm_upload_single_file_button').click(function () {
            jQuery('#display_image_id').show();
        });
    });
    $(window).load(function () {

        $('body').on('click', '#wbm_shop_setting_enable', function () {
            var ele = $(this).find(':checkbox');
            var checked = $('input[id="wbm_shop_setting_enable"][type="checkbox"]:checked').val();
            if ('on' === checked) {
                $('.wbm_shop_page_enable_open_div').css('display', 'block');
            } else {
                $('.wbm_shop_page_enable_open_div').css('display', 'none');
            }

        });

        //script for cart page setting script
        $('body').on('click', '#wbm_shop_setting_cart_enable', function () {
            var checked = $('input[id="wbm_shop_setting_cart_enable"][type="checkbox"]:checked').val();
            var ele = $(this).find(':checkbox');
            if ('on' === checked) {
                $('.wbm-cart-upload-image-html').css('display', 'block');
            } else {
                $('.wbm-cart-upload-image-html').css('display', 'none');
            }
        });

        //script for check out page setting script
        $('body').on('click', '#wbm_shop_setting_checkout_enable', function () {
            var checked = $('input[id="wbm_shop_setting_checkout_enable"][type="checkbox"]:checked').val();
            var ele = $(this).find(':checkbox');
            if ('on' === checked) {
                $('.wbm-checkout-upload-image-html').css('display', 'block');
            } else {
                $('.wbm-checkout-upload-image-html').css('display', 'none');
            }
        });

        //script for tahnk you page
        $('body').on('click', '#wbm_shop_setting_thank_you_page_enable', function () {
            var checked = $('input[id="wbm_shop_setting_thank_you_page_enable"][type="checkbox"]:checked').val();
            var ele = $(this).find(':checkbox');
            if ('on' === checked) {
                $('.wbm-thank-you-page-upload-image-html').css('display', 'block');
            } else {
                $('.wbm-thank-you-page-upload-image-html').css('display', 'none');
            }
        });

        //script for save the setting data
        $('body').on('click', '#save_top_wbm_shop_page_setting', function () {
            saveBannerSettingPage();
        });

        $('body').on('click', '#save_wbm_shop_page_setting', function () {
            saveBannerSettingPage();
            $('html, body').animate({scrollTop: 0}, 2000);
            return false;
        });

        //accrodian jquery script

        jQuery('.custom-accordian .aco-title').click(function () {
            jQuery(this).siblings().slideToggle(400);
            jQuery(this).toggleClass('open');
        });

        function closeAccordionSection() {
            jQuery('.accordion .accordion-section-title').removeClass('active');
            jQuery('.accordion .accordion-section-content').slideUp(300).removeClass('open');
        }

        function closeAccordionPreviewSection() {
            jQuery('.accordion_preview .accordion_preview-section-title').removeClass('active');
            jQuery('.accordion_preview .accordion_preview-section-content').slideUp(300).removeClass('open');
        }

        //function for crea setting form
        function createSettingCloseAccordionSection() {
            jQuery('.accordion-crea-setting .accordion-crea-setting-sections-titles').removeClass('active');
            jQuery('.accordion-crea-setting .accordion-section-content').slideUp(300).removeClass('open');
        }

        jQuery('.accordion-section-title').click(function (e) {

            // Grab current anchor value
            var currentAttrValue = jQuery(this).attr('href');

            if (jQuery(e.target).is('.active')) {
                closeAccordionSection();
            } else {
                closeAccordionSection();

                // Add active class to section title
                jQuery(this).addClass('active');

                // Open up the hidden content panel
                jQuery('.accordion ' + currentAttrValue).slideDown(300).addClass('open');
            }

            e.preventDefault();
        });

        jQuery('.accordion_preview-section-title').click(function (e) {

            // Grab current anchor value
            var currentAttrValue = jQuery(this).attr('href');

            if (jQuery(e.target).is('.active')) {
                closeAccordionPreviewSection();
            } else {
                closeAccordionPreviewSection();

                // Add active class to section title
                jQuery(this).addClass('active');

                // Open up the hidden content panel
                jQuery('.accordion_preview ' + currentAttrValue).slideDown(300).addClass('open');
            }

            e.preventDefault();
        });

    });

    function saveBannerSettingPage() {
        var shopPageBannerSelectImageResults = '';
        var shopPageBannerImageResults = '';
        var shopPageBannerLinkResults = '';
        var shopPageBannerEnableOrNotResults = '';
        var shopPageBannerEnableRandomImagesResults = '';
        var shopPageBannerStartDateResults = '';
        var shopPageBannerEndDateResults = '';
        var shopPageBannerTopOrNotResults = '';
        var shopPageBannerEnableRandomImagesDotsResults = '';
        var shopPageBannerSingleImageLinkResults = '';
        var shopPageBannerSingleImageResult = '';
        var shopPageBannerSelectImage;
        var shopPageBannerSingleImage;
        var shopPageBannerImage;
        var shopPageBannerLink;
        var shopPageBannerSingleImageLink;
        var shopPageBannerEnableOrNot;
        var shopPageBannerEnableRandomImages;
        var shopPageBannerStartDate;
        var shopPageBannerEndDate;
        var shopPageBannerTopOrNot;
        var shopPageBannerEnableRandomImagesDots;
        var shop = [];
        var shopPageUrl;
        var shopPageContent;
        var cartPageBannerSelectImageResults = '';
        var cartPageBannerImageResults = '';
        var cartPageBannerLinkResults = '';
        var cartPageBannerEnableOrNotResults = '';
        var cartPageBannerEnableRandomImagesResults = '';
        var cartPageBannerStartDateResults = '';
        var cartPageBannerEndDateResults = '';
        var cartPageBannerTopOrNotResults = '';
        var cartPageBannerEnableRandomImagesDotsResults = '';
        var cartPageBannerSingleImageLinkResults = '';
        var cartPageBannerSingleImageResults = '';
        var cartPageBannerSelectImage;
        var cartPageBannerImage;
        var cartPageBannerSingleImage;
        var cartPageBannerLink;
        var cartPageBannerSingleImageLink;
        var cartPageBannerEnableOrNot;
        var cartPageBannerEnableRandomImages;
        var cartPageBannerStartDate;
        var cartPageBannerEndDate;
        var cartPageBannerTopOrNot;
        var cartPageBannerEnableRandomImagesDots;
        var cart = [];
        var cartUrl;
        var cartPreviewContent;
        var checkoutPageBannerImageResults = '';
        var checkoutPageBannerLinkResults = '';
        var checkoutPageBannerEnableOrNotResults = '';
        var checkoutPageBannerEnableRandomImagesResults = '';
        var checkoutPageBannerStartDateResults = '';
        var checkoutPageBannerEndDateResults = '';
        var checkoutPageBannerTopOrNotResults = '';
        var checkoutPageBannerEnableRandomImagesDotsResults = '';
        var checkoutPageBannerSelectImageResults = '';
        var checkoutPageBannerSingleImageLinkResults = '';
        var checkoutPageBannerSingleImageResults = '';
        var checkoutPageBannerSelectImage;
        var checkoutPageBannerSingleImage;
        var checkoutPageBannerSingleImageLink;
        var checkoutPageBannerImage;
        var checkoutPageBannerLink;
        var checkoutPageBannerEnableOrNot;
        var checkoutPageBannerEnableRandomImages;
        var checkoutPageBannerStartDate;
        var checkoutPageBannerEndDate;
        var checkoutPageBannerTopOrNot;
        var checkoutPageBannerEnableRandomImagesDots;
        var checkout = [];
        var chekoutUrl;
        var checkoutcontent;
        var thankyouPageBannerImageResults = '';
        var thankyouPageBannerLinkResults = '';
        var thankyouPageBannerEnableOrNotResults = '';
        var thankyouPageBannerStartDateResults = '';
        var thankyouPageBannerEndDateResults = '';
        var thankyouPageBannerTopOrNotResults = '';
        var thankyouPageBannerEnableRandomImagesDotsResults = '';
        var thankyouPageBannerSelectImageResults = '';
        var thankyouPageBannerSingleImageLinkResults = '';
        var thankyouPageBannerSingleImageResult = '';
        var thankyouPageBannerSelectImage;
        var thankyouPageBannerSingleImage;
        var thankyouPageBannerSingleImageLink;
        var thankyouPageBannerImage;
        var thankyouPageBannerLink;
        var thankyouPageBannerEnableOrNot;
        var thankyouPageBannerEnableRandomImages;
        var thankyouPageBannerEnableRandomImagesResults;
        var thankyouPageBannerStartDate;
        var thankyouPageBannerEndDate;
        var thankyouPageBannerTopOrNot;
        var thankyouPageBannerEnableRandomImagesDots;
        var thankyou = [];
        var strongTag;


        $('.banner-setting-loader').css('display', 'inline-block');

        //get the value by shop page setting section


        shopPageBannerSelectImage = $('.shop-select-image-type option:selected').val();
        if ('' !== shopPageBannerSelectImage) {
            shopPageBannerSelectImageResults = shopPageBannerSelectImage;
        }

        shopPageBannerSingleImage = $('.wbm_shop_page_cat_banner_img_admin_single').attr('src');
        if ('' !== shopPageBannerSingleImage) {
            shopPageBannerSingleImageResult = shopPageBannerSingleImage;
        }

        shopPageBannerImage = $('.wbm_shop_page_cat_banner_img_admin').attr('src');
        if ('' !== shopPageBannerImage) {
            shopPageBannerImageResults = shopPageBannerImage;
        }

        shopPageBannerLink = $('#shop_page_banner_image_link').val();
        if ('' !== shopPageBannerLink) {
            shopPageBannerLinkResults = shopPageBannerLink;
        }

        shopPageBannerSingleImageLink = $('#shop_page_banner_single_image_link').val();
        if ('' !== shopPageBannerSingleImageLink) {
            shopPageBannerSingleImageLinkResults = shopPageBannerSingleImageLink;
        }

        shopPageBannerEnableOrNot = $('input[id="wbm_shop_setting_enable"][type="checkbox"]:checked').val();
        if ('' !== shopPageBannerEnableOrNot) {
            shopPageBannerEnableOrNotResults = shopPageBannerEnableOrNot;
        }

        shopPageBannerEnableRandomImages = $('input[id="wbm_shop_setting_enable_random_images"][type="radio"]:checked').val();
        if ('' !== shopPageBannerEnableRandomImages) {
            shopPageBannerEnableRandomImagesResults = shopPageBannerEnableRandomImages;
        }

        shopPageBannerStartDate = $('#shop_start_date').val();
        if ('' !== shopPageBannerStartDate) {
            shopPageBannerStartDateResults = shopPageBannerStartDate;
        }

        shopPageBannerEndDate = $('#shop_end_date').val();
        if ('' !== shopPageBannerEndDate) {
            shopPageBannerEndDateResults = shopPageBannerEndDate;
        }

        shopPageBannerTopOrNot = $('input[id="wbm_set_top_setting_enable"][type="checkbox"]:checked').val();
        if ('' !== shopPageBannerTopOrNot) {
            shopPageBannerTopOrNotResults = shopPageBannerTopOrNot;
        }

        shopPageBannerEnableRandomImagesDots = $('input[id="wbm_shop_setting_enable_random_images_dots"][type="checkbox"]:checked').val();
        if ('' !== shopPageBannerEnableRandomImagesDots) {
            shopPageBannerEnableRandomImagesDotsResults = shopPageBannerEnableRandomImagesDots;
        }

        $.each($('.banner_shop_dynamic_div'), function () {
            var divId;
            var arr;
            var imageId;
            var imageLink;
            var imageSrc;
            var item = {};

            divId = $(this).attr('id');
            arr = divId.split('_');
            imageId = arr[2];

            if ('' !== imageId && null !== imageId && imageId !== undefined) {

                //shop[imageId] = new Array();
                imageLink = $('.banner_shop_input_' + imageId).val();

                //console.log(imageLink);

                imageSrc = $('.banner_shop_image_' + imageId).attr('src');

                //console.log(imageSrc);

                item['image_id'] = imageId;
                item['image_src'] = imageSrc;
                item['image_link'] = imageLink;
                shop.push(item);
            }
        });

        //var myJsonString = JSON.stringify(shop);

        if ('on' === shopPageBannerEnableOrNot) {
            $('span#shop_page_status_enable_or_disable').html('');
            $('span.Preview_link_for_shop_page').html('');
            shopPageUrl = $('#shop_page_hidden_url').val();
            $('<strong />', {'text': wbmAdminVars.preview + ': '}).appendTo('span.Preview_link_for_shop_page');
            $('<a />', {
                'href': shopPageUrl,
                'text': wbmAdminVars.click,
                'target': '_blank'
            }).appendTo('span.Preview_link_for_shop_page');
            $('span#shop_page_status_enable_or_disable').text('( Enable )');
            $('span#shop_page_status_enable_or_disable').css('color', 'green');
        } else {
            $('span.Preview_link_for_shop_page').html('');
            $('span#shop_page_status_enable_or_disable').html('');
            $('span#shop_page_status_enable_or_disable').html('( Disable )');
            $('span#shop_page_status_enable_or_disable').css('color', 'red');
        }

        //get the value by cart setting section

        cartPageBannerSelectImage = $('.cart-select-image-type option:selected').val();
        if ('' !== cartPageBannerSelectImage) {
            cartPageBannerSelectImageResults = cartPageBannerSelectImage;
        }

        cartPageBannerImage = $('.wbm_cart_page_cat_banner_img_admin').attr('src');
        if ('' !== cartPageBannerImage) {
            cartPageBannerImageResults = cartPageBannerImage;
        }

        cartPageBannerSingleImage = $('.wbm_cart_page_cat_banner_img_admin_single').attr('src');
        if ('' !== cartPageBannerSingleImage) {
            cartPageBannerSingleImageResults = cartPageBannerSingleImage;
        }

        cartPageBannerLink = $('#shop_cart_banner_image_link').val();
        if ('' !== cartPageBannerLink) {
            cartPageBannerLinkResults = cartPageBannerLink;
        }

        cartPageBannerSingleImageLink = $('#cart_page_banner_single_image_link').val();
        if ('' !== cartPageBannerSingleImageLink) {
            cartPageBannerSingleImageLinkResults = cartPageBannerSingleImageLink;
        }

        cartPageBannerEnableOrNot = $('input[id="wbm_shop_setting_cart_enable"][type="checkbox"]:checked').val();
        if ('' !== cartPageBannerEnableOrNot) {
            cartPageBannerEnableOrNotResults = cartPageBannerEnableOrNot;
        }

        cartPageBannerEnableRandomImages = $('input[id="wbm_cart_setting_enable_random_images"][type="radio"]:checked').val();
        if ('' !== cartPageBannerEnableRandomImages) {
            cartPageBannerEnableRandomImagesResults = cartPageBannerEnableRandomImages;
        }

        cartPageBannerStartDate = $('#cart_start_date').val();
        if ('' !== cartPageBannerStartDate) {
            cartPageBannerStartDateResults = cartPageBannerStartDate;
        }

        cartPageBannerEndDate = $('#cart_end_date').val();
        if ('' !== cartPageBannerEndDate) {
            cartPageBannerEndDateResults = cartPageBannerEndDate;
        }

        cartPageBannerTopOrNot = $('input[id="wbm_cart_setting_top_enable"][type="checkbox"]:checked').val();
        if ('' !== cartPageBannerTopOrNot) {
            cartPageBannerTopOrNotResults = cartPageBannerTopOrNot;
        }

        cartPageBannerEnableRandomImagesDots = $('input[id="wbm_cart_setting_enable_random_images_dots"][type="checkbox"]:checked').val();
        if ('' !== cartPageBannerEnableRandomImagesDots) {
            cartPageBannerEnableRandomImagesDotsResults = cartPageBannerEnableRandomImagesDots;
        }

        $.each($('.banner_cart_dynamic_div'), function () {
            var divId;
            var item = {};
            var arr;
            var imageId;
            var imageLink;
            var imageSrc;

            divId = $(this).attr('id');
            arr = divId.split('_');
            imageId = arr[2];
            if ('' != imageId && null !== imageId && imageId !== undefined) {

                imageLink = $('.banner_cart_input_' + imageId).val();

                imageSrc = $('.banner_cart_image_' + imageId).attr('src');

                item['image_id'] = imageId;
                item['image_src'] = imageSrc;
                item['image_link'] = imageLink;
                cart.push(item);
            }
        });

        if ('on' === cartPageBannerEnableOrNot) {

            $('span.Preview_link_for_cart_page').text('');
            cartUrl = $('#cart_page_hidden_url').val();
            $('<strong />', {'text': wbmAdminVars.preview + ': '}).appendTo('span.Preview_link_for_cart_page');
            $('<a />', {
                'href': cartUrl,
                'text': wbmAdminVars.click,
                'target': '_blank'
            }).appendTo('span.Preview_link_for_cart_page');
            $('span#cart_page_status_enable_or_disable').text('');
            $('span#cart_page_status_enable_or_disable').text('( Enable )');
            $('span#cart_page_status_enable_or_disable').css('color', 'green');
        } else {
            $('span#cart_page_status_enable_or_disable').text('');
            $('span.Preview_link_for_cart_page').text('');
            $('span#cart_page_status_enable_or_disable').text('( Disable )');
            $('span#cart_page_status_enable_or_disable').css('color', 'red');
        }

        //get the value by cart setting section

        checkoutPageBannerSelectImage = $('.checkout-select-image-type option:selected').val();
        if ('' !== checkoutPageBannerSelectImage) {
            checkoutPageBannerSelectImageResults = checkoutPageBannerSelectImage;
        }

        checkoutPageBannerSingleImage = $('.wbm_checkout_page_cat_banner_img_admin_single').attr('src');
        if ('' !== checkoutPageBannerSingleImage) {
            checkoutPageBannerSingleImageResults = checkoutPageBannerSingleImage;
        }

        checkoutPageBannerSingleImageLink = $('#checkout_page_banner_single_image_link').val();
        if ('' !== checkoutPageBannerSingleImageLink) {
            checkoutPageBannerSingleImageLinkResults = checkoutPageBannerSingleImageLink;
        }

        checkoutPageBannerImage = $('.wbm_checkout_page_cat_banner_img_admin').attr('src');
        if ('' !== checkoutPageBannerImage) {
            checkoutPageBannerImageResults = checkoutPageBannerImage;
        }

        checkoutPageBannerLink = $('#shop_checkout_banner_image_link').val();
        if ('' !== checkoutPageBannerLink) {
            checkoutPageBannerLinkResults = checkoutPageBannerLink;
        }

        checkoutPageBannerEnableOrNot = $('input[id="wbm_shop_setting_checkout_enable"][type="checkbox"]:checked').val();
        if ('' !== checkoutPageBannerEnableOrNot) {
            checkoutPageBannerEnableOrNotResults = checkoutPageBannerEnableOrNot;
        }

        checkoutPageBannerEnableRandomImages = $('input[id="wbm_checkout_setting_enable_random_images"][type="radio"]:checked').val();
        if ('' !== checkoutPageBannerEnableRandomImages) {
            checkoutPageBannerEnableRandomImagesResults = checkoutPageBannerEnableRandomImages;
        }

        checkoutPageBannerStartDate = $('#checkout_start_date').val();
        if ('' !== checkoutPageBannerStartDate) {
            checkoutPageBannerStartDateResults = checkoutPageBannerStartDate;
        }

        checkoutPageBannerEndDate = $('#checkout_end_date').val();
        if ('' !== checkoutPageBannerEndDate) {
            checkoutPageBannerEndDateResults = checkoutPageBannerEndDate;
        }

        checkoutPageBannerTopOrNot = $('input[id="wbm_checkout_setting_top_enable"][type="checkbox"]:checked').val();
        if ('' !== checkoutPageBannerTopOrNot) {
            checkoutPageBannerTopOrNotResults = checkoutPageBannerTopOrNot;
        }

        checkoutPageBannerEnableRandomImagesDots = $('input[id="wbm_checkout_setting_enable_random_images_dots"][type="checkbox"]:checked').val();
        if ('' !== checkoutPageBannerEnableRandomImagesDots) {
            checkoutPageBannerEnableRandomImagesDotsResults = checkoutPageBannerEnableRandomImagesDots;
        }

        $.each($('.banner_checkout_dynamic_div'), function () {
            var divId;
            var arr;
            var imageId;
            var imageLink;
            var imageSrc;
            var item = {};

            divId = $(this).attr('id');
            arr = divId.split('_');
            imageId = arr[2];

            if ('' != imageId && null !== imageId && imageId !== undefined) {

                imageLink = $('.banner_checkout_input_' + imageId).val();

                imageSrc = $('.banner_checkout_image_' + imageId).attr('src');

                item['image_id'] = imageId;
                item['image_src'] = imageSrc;
                item['image_link'] = imageLink;
                checkout.push(item);
            }
        });

        if ('on' === checkoutPageBannerEnableOrNot) {

            $('span.Preview_link_for_checkout_page').text('');
            chekoutUrl = $('#checkout_page_hidden_url').val();
            $('<strong />', {'text': wbmAdminVars.preview + ': '}).appendTo('span.Preview_link_for_checkout_page');
            $('<a />', {
                'href': chekoutUrl,
                'text': wbmAdminVars.click,
                'target': '_blank'
            }).appendTo('span.Preview_link_for_checkout_page');
            $('span#checkout_page_status_enable_or_disable').text('( Enable )');
            $('span#checkout_page_status_enable_or_disable').css('color', 'green');
        } else {
            $('span#checkout_page_status_enable_or_disable').text('');

            $('span.Preview_link_for_checkout_page').text('');
            $('span#checkout_page_status_enable_or_disable').text('( Disable )');
            $('span#checkout_page_status_enable_or_disable').css('color', 'red');
        }

        //get the value by cart setting section

        thankyouPageBannerSelectImage = $('.thankyou-select-image-type option:selected').val();
        if ('' !== thankyouPageBannerSelectImage) {
            thankyouPageBannerSelectImageResults = thankyouPageBannerSelectImage;
        }

        thankyouPageBannerSingleImage = $('.wbm_thankyou_page_cat_banner_img_admin_single').attr('src');
        if ('' !== thankyouPageBannerSingleImage) {
            thankyouPageBannerSingleImageResult = thankyouPageBannerSingleImage;
        }

        thankyouPageBannerSingleImageLink = $('#thankyou_page_banner_single_image_link').val();
        if ('' !== thankyouPageBannerSingleImageLink) {
            thankyouPageBannerSingleImageLinkResults = thankyouPageBannerSingleImageLink;
        }

        thankyouPageBannerImage = $('.wbm_thankyou_page_cat_banner_img_admin').attr('src');
        if ('' !== thankyouPageBannerImage) {
            thankyouPageBannerImageResults = thankyouPageBannerImage;
        }

        thankyouPageBannerLink = $('#shop_thank_you_page_banner_image_link').val();
        if ('' !== thankyouPageBannerLink) {
            thankyouPageBannerLinkResults = thankyouPageBannerLink;
        }

        thankyouPageBannerEnableOrNot = $('input[id="wbm_shop_setting_thank_you_page_enable"][type="checkbox"]:checked').val();
        if ('' !== thankyouPageBannerEnableOrNot) {
            thankyouPageBannerEnableOrNotResults = thankyouPageBannerEnableOrNot;
        }

        thankyouPageBannerEnableRandomImages = $('input[id="wbm_thankyou_setting_enable_random_images"][type="radio"]:checked').val();
        if ('' !== thankyouPageBannerEnableRandomImages) {
            thankyouPageBannerEnableRandomImagesResults = thankyouPageBannerEnableRandomImages;
        } else {
            thankyouPageBannerEnableRandomImagesResults = '';
        }

        thankyouPageBannerStartDate = $('#thankyou_start_date').val();
        if ('' !== thankyouPageBannerStartDate) {
            thankyouPageBannerStartDateResults = thankyouPageBannerStartDate;
        }

        thankyouPageBannerEndDate = $('#thankyou_end_date').val();
        if ('' !== thankyouPageBannerEndDate) {
            thankyouPageBannerEndDateResults = thankyouPageBannerEndDate;
        }

        thankyouPageBannerTopOrNot = $('input[id="wbm_thankyou_setting_top_enable"][type="checkbox"]:checked').val();
        if ('' !== thankyouPageBannerTopOrNot) {
            thankyouPageBannerTopOrNotResults = thankyouPageBannerTopOrNot;
        }

        thankyouPageBannerEnableRandomImagesDots = $('input[id="wbm_thankyou_setting_enable_random_images_dots"][type="checkbox"]:checked').val();
        if ('' !== thankyouPageBannerEnableRandomImagesDots) {
            thankyouPageBannerEnableRandomImagesDotsResults = thankyouPageBannerEnableRandomImagesDots;
        }

        $.each($('.banner_thankyou_dynamic_div'), function () {
            var divId;
            var arr;
            var imageId;
            var imageLink;
            var imageSrc;
            var item = {};

            divId = $(this).attr('id');
            arr = divId.split('_');
            imageId = arr[2];

            if ('' !== imageId && null !== imageId && imageId !== undefined) {

                imageLink = $('.banner_thankyou_input_' + imageId).val();

                imageSrc = $('.banner_thankyou_image_' + imageId).attr('src');

                item['image_id'] = imageId;
                item['image_src'] = imageSrc;
                item['image_link'] = imageLink;
                thankyou.push(item);
            }
        });

        if ('on' === thankyouPageBannerEnableOrNot) {
            $('span#thankyou_page_status_enable_or_disable').html('');
            $('span#thankyou_page_status_enable_or_disable').html('( Enable )');
            $('span#thankyou_page_status_enable_or_disable').css('color', 'green');
        } else {
            $('span#thankyou_page_status_enable_or_disable').html('');
            $('span#thankyou_page_status_enable_or_disable').html('( Disable )');
            $('span#thankyou_page_status_enable_or_disable').css('color', 'red');
        }
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: ({
                action: 'wbm_save_shop_page_banner_data',
                'shop_page_banner_image_results_arr': shop,
                'shop_page_banner_select_image_results': shopPageBannerSelectImageResults,
                'shop_page_banner_image_results': shopPageBannerSingleImageResult,
                'shop_page_banner_link_results': shopPageBannerSingleImageLinkResults,
                'shop_page_banner_enable_or_not_results': shopPageBannerEnableOrNotResults,
                'shop_page_banner_enable_random_images_results': shopPageBannerEnableRandomImagesResults,
                'shop_page_banner_start_date_results': shopPageBannerStartDateResults,
                'shop_page_banner_end_date_results': shopPageBannerEndDateResults,
                'shop_page_banner_top_or_not_results': shopPageBannerTopOrNotResults,
                'shop_page_banner_enable_random_images_dots_results': shopPageBannerEnableRandomImagesDotsResults,
                'cart_page_banner_image_results_arr': cart,
                'cart_page_banner_select_image_results': cartPageBannerSelectImageResults,
                'cart_page_banner_image_results': cartPageBannerSingleImageResults,
                'cart_page_banner_link_results': cartPageBannerSingleImageLinkResults,
                'cart_page_banner_enable_or_not_results': cartPageBannerEnableOrNotResults,
                'cart_page_banner_enable_random_images_results': cartPageBannerEnableRandomImagesResults,
                'cart_page_banner_start_date_results': cartPageBannerStartDateResults,
                'cart_page_banner_end_date_results': cartPageBannerEndDateResults,
                'cart_page_banner_top_or_not_results': cartPageBannerTopOrNotResults,
                'cart_page_banner_enable_random_images_dots_results': cartPageBannerEnableRandomImagesDotsResults,
                'checkout_page_banner_image_results_arr': checkout,
                'checkout_page_banner_select_image_results': checkoutPageBannerSelectImageResults,
                'checkout_page_banner_image_results': checkoutPageBannerSingleImageResults,
                'checkout_page_banner_link_results': checkoutPageBannerSingleImageLinkResults,
                'checkout_page_banner_enable_or_not_results': checkoutPageBannerEnableOrNotResults,
                'checkout_page_banner_enable_random_images_results': checkoutPageBannerEnableRandomImagesResults,
                'checkout_page_banner_start_date_results': checkoutPageBannerStartDateResults,
                'checkout_page_banner_end_date_results': checkoutPageBannerEndDateResults,
                'checkout_page_banner_top_or_not_results': checkoutPageBannerTopOrNotResults,
                'checkout_page_banner_enable_random_images_dots_results': checkoutPageBannerEnableRandomImagesDotsResults,
                'thankyou_page_banner_image_results_arr': thankyou,
                'thankyou_page_banner_select_image_results': thankyouPageBannerSelectImageResults,
                'thankyou_page_banner_image_results': thankyouPageBannerSingleImageResult,
                'thankyou_page_banner_link_results': thankyouPageBannerSingleImageLinkResults,
                'thankyou_page_banner_enable_or_not_results': thankyouPageBannerEnableOrNotResults,
                'thankyou_page_banner_enable_random_images_results': thankyouPageBannerEnableRandomImagesResults,
                'thankyou_page_banner_start_date_results': thankyouPageBannerStartDateResults,
                'thankyou_page_banner_end_date_results': thankyouPageBannerEndDateResults,
                'thankyou_page_banner_top_or_not_results': thankyouPageBannerTopOrNotResults,
                'thankyou_page_banner_enable_random_images_dots_results': thankyouPageBannerEnableRandomImagesDotsResults

            }),
            success: function (response) {
                $('.banner-setting-loader').css('display', 'none');
                $('#succesful_message_wbm').css('display', 'block');
            }
        });
    }
})(jQuery);

