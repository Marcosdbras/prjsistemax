jQuery(document).ready(function ($) {

    var fixHelperModified = function (e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function (index) {
            $(this).width($originals.eq(index).width());
        });
        return $helper;
    };

    if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    //Make diagnosis table sortable
    $('#image-conatent-table tbody').sortable({
        helper: fixHelperModified,
        stop: function (event, ui) {
            renumberTable('#image-conatent-table');
        }
    });
}


    /*
     * Woocommerce-banner-managment edit  uploading script
     */
    //Set the category page banner upload script Single Banner
    $('.mdwbm_upload_single_file_button').live('click', function (event) {
        var fileFrame, attachment;
        event.preventDefault();


        // If the media frame already exists, reopen it.
        if (fileFrame) {
            fileFrame.open();
            return;
        }

        // Create the media frame.
        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: false
        });

        // When an file is selected, run a callback.
        fileFrame.on('select', function () {

            attachment = fileFrame.state().get('selection').first().toJSON();

            // Update front end
            $('.cat_banner_single_img_admin').attr('src', attachment.url);
            $('.mdwbm_image').attr('value', attachment.url);
            $('.cat_banner_single_img_admin').css('display', 'block');
        });

        // Open the Modal
        fileFrame.open();
    });

    if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    //set the custom field script for add category page
    $('.mdwbm_upload_file_button').live('click', function (event) {
        var fileFrame;
        var attachment;
        var htmlAddCategory = '';
        var imageId = '';
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (fileFrame) {
            fileFrame.open();
            return;
        }

        // Create the media frame.
        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: true
        });

        // When an file is selected, run a callback.
        fileFrame.on('select', function () {
            attachment = fileFrame.state().get('selection').toJSON();

            $.each(attachment, function (key, value) {
                var trTag;
                var td1;
                var td2;
                var td3;

                // Update front end
                imageId = $.now() + '' + key + '-' + value.id;
                td1 = $('<td />');
                td2 = $('<td />');
                td3 = $('<td />');

                $('<img />', {
                    'style': '',
                    'class': 'wbm_add_cat_banner_img banner_add_cat_image_' + imageId,
                    'src': value.url
                }).appendTo(td1);
                $('<input />', {
                    'type': 'hidden',
                    'name': 'term_meta[images][' + imageId + '][image_id]',
                    'class': 'wbm_add_cat_banner_img_admin banner_cat_image_' + imageId,
                    'value': imageId
                }).appendTo(td2);
                $('<input />', {
                    'type': 'text',
                    'placeholder': 'Enter banner image link',
                    'title': 'Example: https://multidots.com',
                    'name': 'term_meta[images][' + imageId + '][image_link]',
                    'class': 'wbm_cat_page_cat_banner_link_admin add_category_input_' + imageId,
                }).appendTo(td2);
                $('<input />', {
                    'type': 'hidden',
                    'name': 'term_meta[images][' + imageId + '][image_url]',
                    'value': value.url
                }).appendTo(td2);
                $('<a />', {
                    'class': 'cat-single-image-delete single-image-delete',
                    'id': imageId,
                    'text': 'Delete'
                }).appendTo(td3);

                trTag = $('<tr />', {'id': 'add_category_' + imageId, 'class': 'add_category_dynamic_div'});
                $(td1).appendTo(trTag);
                $(td2).appendTo(trTag);
                $(td3).appendTo(trTag);
                $(trTag).appendTo('#cat-multiple-banner-image table');
            });

        });

        // Open the Modal
        fileFrame.open();
    });
    }

    //Set the shop page banner upload script Single Banner
    $('.wbm_shop_page_single_upload_file_button').live('click', function (event) {
        var fileFrame;
        var attachment;
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (fileFrame) {
            fileFrame.open();
            return;
        }

        // Create the media frame.
        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: false
        });

        // When an file is selected, run a callback.
        fileFrame.on('select', function () {

            attachment = fileFrame.state().get('selection').first().toJSON();

            // Update front end
            $('.wbm_shop_page_cat_banner_img_admin_single').attr('src', attachment.url);
            $('.wbm_shop_page_cat_banner_img_admin_single').css('display', 'block');
        });

        // Open the Modal
        fileFrame.open();
    });

    if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    //Set the shop page banner upload script Multiple Banner
    $('.wbm_shop_page_multi_upload_file_button').live('click', function (event) {
        var fileFrame;
        var attachment;
        var htmlshopimg = '';
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (fileFrame) {
            fileFrame.open();
            return;
        }

        // Create the media frame.
        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: true
        });

        // When an file is selected, run a callback.
        fileFrame.on('select', function () {
            attachment = fileFrame.state().get('selection').toJSON();

            $.each(attachment, function (key, value) {

                // Update front end
                var imageId = $.now() + '' + key + '-' + value.id;
                var td1;
                var td2;
                var td3;
                var trTag;

                // Update front end
                imageId = $.now() + '' + key + '-' + value.id;
                td1 = $('<td />');
                td2 = $('<td />');
                td3 = $('<td />');

                $('<img />', {
                    'class': 'wbm_shop_page_cat_banner_img_admin banner_shop_image_' + imageId,
                    'src': value.url
                }).appendTo(td1);
                $('<input />', {
                    'type': 'text',
                    'placeholder': 'Enter banner image link',
                    'title': 'Example: https://multidots.com',
                    'class': 'banner_shop_input_' + imageId
                }).appendTo(td2);
                $('<a />', {
                    'class': 'shop-single-image-delete single-image-delete',
                    'id': imageId,
                    'text': 'Delete'
                }).appendTo(td3);

                trTag = $('<tr />', {
                    'id': 'banner_shop_' + imageId,
                    'class': 'banner_shop_dynamic_div ui-sortable-handle'
                });
                $(td1).appendTo(trTag);
                $(td2).appendTo(trTag);
                $(td3).appendTo(trTag);
                $(trTag).appendTo('.shop_banner_images table');
            });
        });

        // Open the Modal
        fileFrame.open();
    });
    }

    //Set the cart page banner upload script Single Banner
    $('.wbm_cart_page_single_upload_file_button').live('click', function (event) {
        var fileFrame;
        var attachment;
        event.preventDefault();


        // If the media frame already exists, reopen it.
        if (fileFrame) {
            fileFrame.open();
            return;
        }

        // Create the media frame.
        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: false
        });

        // When an file is selected, run a callback.
        fileFrame.on('select', function () {

            attachment = fileFrame.state().get('selection').first().toJSON();

            // Update front end
            $('.wbm_cart_page_cat_banner_img_admin_single').attr('src', attachment.url);
            $('.wbm_cart_page_cat_banner_img_admin_single').css('display', 'block');
        });

        // Open the Modal
        fileFrame.open();
    });

    if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    //Set the cart page banner upload script
    $('.wbm_cart_page_upload_file_button').live('click', function (event) {
        var fileFrame;
        var imageId;
        var attachment;
        var htmlcartimg = '';
        event.preventDefault();


        // If the media frame already exists, reopen it.
        if (fileFrame) {
            fileFrame.open();
            return;
        }

        // Create the media frame.
        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: true
        });

        // When an file is selected, run a callback.
        fileFrame.on('select', function () {
            attachment = fileFrame.state().get('selection').toJSON();

            $.each(attachment, function (key, value) {
                var td1;
                var td2;
                var td3;
                var trTag;

                // Update front end
                imageId = $.now() + '' + key + '-' + value.id;

                td1 = $('<td />');
                td2 = $('<td />');
                td3 = $('<td />');

                $('<img />', {
                    'class': 'wbm_cart_page_cat_banner_img_admin banner_cart_image_' + imageId,
                    'src': value.url
                }).appendTo(td1);
                $('<input />', {
                    'type': 'text',
                    'placeholder': 'Enter banner image link',
                    'title': 'Example: https://multidots.com',
                    'class': 'banner_cart_input_' + imageId
                }).appendTo(td2);
                $('<a />', {
                    'class': 'cart-single-image-delete single-image-delete',
                    'id': imageId,
                    'text': 'Delete'
                }).appendTo(td3);

                trTag = $('<tr />', {'id': 'banner_cart_' + imageId, 'class': 'banner_cart_dynamic_div'});
                $(td1).appendTo(trTag);
                $(td2).appendTo(trTag);
                $(td3).appendTo(trTag);
                $(trTag).appendTo('.cart_banner_images table');
            });
        });

        // Open the Modal
        fileFrame.open();
    });
    }

    //Set the checkout page banner upload script Single Banner
    $('.wbm_checkout_page_single_upload_file_button').live('click', function (event) {
        var fileFrame;
        var attachment;
        event.preventDefault();


        // If the media frame already exists, reopen it.
        if (fileFrame) {
            fileFrame.open();
            return;
        }

        // Create the media frame.
        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: false
        });

        // When an file is selected, run a callback.
        fileFrame.on('select', function () {

            attachment = fileFrame.state().get('selection').first().toJSON();

            // Update front end
            $('.wbm_checkout_page_cat_banner_img_admin_single').attr('src', attachment.url);
            $('.wbm_checkout_page_cat_banner_img_admin_single').css('display', 'block');
        });

        // Open the Modal
        fileFrame.open();
    });

    if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    //set the check out page banner upload script
    $('.wbm_checkout_page_upload_file_button').live('click', function (event) {
        var fileFrame;
        var attachment;
        var imageId;
        var htmlcheckouttimg = '';
        event.preventDefault();


        // If the media frame already exists, reopen it.
        if (fileFrame) {
            fileFrame.open();
            return;
        }

        // Create the media frame.
        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: true
        });

        // When an file is selected, run a callback.
        fileFrame.on('select', function () {
            attachment = fileFrame.state().get('selection').toJSON();

            $.each(attachment, function (key, value) {
                var td1;
                var td2;
                var td3;
                var trTag;

                // Update front end
                imageId = $.now() + '' + key + '-' + value.id;

                // Update front end
                imageId = $.now() + '' + key + '-' + value.id;
                td1 = $('<td />');
                td2 = $('<td />');
                td3 = $('<td />');

                $('<img />', {
                    'class': 'wbm_checkout_page_cat_banner_img_admin banner_checkout_image_' + imageId,
                    'src': value.url
                }).appendTo(td1);
                $('<input />', {
                    'type': 'text',
                    'placeholder': 'Enter banner image link',
                    'title': 'Example: https://multidots.com',
                    'class': 'banner_checkout_input_' + imageId
                }).appendTo(td2);
                $('<a />', {
                    'class': 'checkout-single-image-delete single-image-delete',
                    'id': imageId,
                    'text': 'Delete'
                }).appendTo(td3);

                trTag = $('<tr />', {
                    'id': 'banner_checkout_' + imageId,
                    'class': 'banner_checkout_dynamic_div ui-sortable-handle'
                });
                $(td1).appendTo(trTag);
                $(td2).appendTo(trTag);
                $(td3).appendTo(trTag);
                $(trTag).appendTo('.checkout_banner_images table');
            });
        });

        // Open the Modal
        fileFrame.open();
    });
    }

    //Set the thankyou page banner upload script Single Banner
    $('.wbm_thankyou_page_single_upload_file_button').live('click', function (event) {
        var fileFrame;
        var attachment;
        event.preventDefault();


        // If the media frame already exists, reopen it.
        if (fileFrame) {
            fileFrame.open();
            return;
        }

        // Create the media frame.
        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: false
        });

        // When an file is selected, run a callback.
        fileFrame.on('select', function () {

            attachment = fileFrame.state().get('selection').first().toJSON();

            // Update front end
            $('.wbm_thankyou_page_cat_banner_img_admin_single').attr('src', attachment.url);
            $('.wbm_thankyou_page_cat_banner_img_admin_single').css('display', 'block');
        });

        // Open the Modal
        fileFrame.open();
    });

    if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    //set the thank you  page banner upload script
    $('.wbm_thank_you_page_upload_file_button').live('click', function (event) {
        var fileFrame;
        var attachment;
        var htmlthankyouimg = '';
        var imageId;
        event.preventDefault();


        // If the media frame already exists, reopen it.
        if (fileFrame) {
            fileFrame.open();
            return;
        }

        // Create the media frame.
        fileFrame = wp.media.frames.fileFrame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: true
        });

        // When an file is selected, run a callback.
        fileFrame.on('select', function () {
            attachment = fileFrame.state().get('selection').toJSON();

            $.each(attachment, function (key, value) {
                var td1;
                var td2;
                var td3;
                var trTag;

                // Update front end
                imageId = $.now() + '' + key + '-' + value.id;
                td1 = $('<td />');
                td2 = $('<td />');
                td3 = $('<td />');

                $('<img />', {
                    'class': 'wbm_thankyou_page_cat_banner_img_admin banner_thankyou_image_' + imageId,
                    'src': value.url
                }).appendTo(td1);
                $('<input />', {
                    'type': 'text',
                    'placeholder': 'Enter banner image link',
                    'title': 'Example: https://multidots.com',
                    'class': 'banner_thankyou_input_' + imageId
                }).appendTo(td2);
                $('<a />', {
                    'class': 'thankyou-single-image-delete single-image-delete',
                    'id': imageId,
                    'text': 'Delete'
                }).appendTo(td3);

                trTag = $('<tr />', {'id': 'banner_thankyou_' + imageId, 'class': 'banner_thankyou_dynamic_div'});
                $(td1).appendTo(trTag);
                $(td2).appendTo(trTag);
                $(td3).appendTo(trTag);
                $(trTag).appendTo('.thankyou_banner_images table');
            });
        });

        // Open the Modal
        fileFrame.open();
    });
    }
    
    if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    //Remove file when selected in add category page
    $('.mdwbm_remove_file').live('click', function (event) {
        $('.wbm_add_cat_banner_img_admin').attr('value', '');
        $('.wbm_cat_page_cat_banner_link_admin').attr('value', '');
        $('.wbm_add_cat_banner_img_admin').css('display', 'none');
        $('.wbm_cat_page_cat_banner_link_admin').css('display', 'none');
        $('.add_category_dynamic_div').css('display', 'none');
    });
    }

    //remove the shop single banner image script
    $('.wbm_shop_page_remove_single_file').live('click', function (event) {
        $('.wbm_shop_page_cat_banner_img_admin_single').attr('src', '');
        $('.wbm_shop_page_cat_banner_img_admin_single').css('display', 'none');
        $('#shop_page_banner_single_image_link').attr('value', '');

    });

if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    //remove the shop banner image script
    $('.wbm_shop_page_remove_file').live('click', function (event) {
        $('.wbm_shop_page_cat_banner_img_admin').attr('src', '');
        $('.wbm_shop_page_cat_banner_img_admin').css('display', 'none');
        $('.banner_shop_dynamic_div').css('display', 'none');
    });
}

    //remove the cart single banner image script
    $('.wbm_cart_page_remove_single_file').live('click', function (event) {
        $('.wbm_cart_page_cat_banner_img_admin_single').attr('src', '');
        $('.wbm_cart_page_cat_banner_img_admin_single').css('display', 'none');
        $('#cart_page_banner_single_image_link').attr('value', '');

    });

if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    //remove the cart page banner image script
    $('.wbm_cart_page_remove_file').live('click', function (event) {
        $('.wbm_cart_page_cat_banner_img_admin').attr('src', '');
        $('.wbm_cart_page_cat_banner_img_admin').css('display', 'none');
        $('.banner_cart_dynamic_div').css('display', 'none');
    });
}
    //remove the checkout single banner image script
    $('.wbm_checkout_page_remove_single_file').live('click', function (event) {
        $('.wbm_checkout_page_cat_banner_img_admin_single').attr('src', '');
        $('.wbm_checkout_page_cat_banner_img_admin_single').css('display', 'none');
        $('#checkout_page_banner_single_image_link').attr('value', '');
    });

if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    //remove checkout page banner image script
    $('.wbm_checkout_page_remove_file').live('click', function (event) {
        $('.wbm_checkout_page_cat_banner_img_admin').attr('src', '');
        $('.wbm_checkout_page_cat_banner_img_admin').css('display', 'none');
        $('.banner_checkout_dynamic_div').css('display', 'none');
    });
}
    //remove the thankyou single banner image script
    $('.wbm_thankyou_page_remove_single_file').live('click', function (event) {
        $('.wbm_thankyou_page_cat_banner_img_admin_single').attr('src', '');
        $('.wbm_thankyou_page_cat_banner_img_admin_single').css('display', 'none');
        $('#thankyou_page_banner_single_image_link').attr('value', '');
    });

if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    //remove thank you page banner image script
    $('.wbm_checkout_page_remove_file').live('click', function (event) {
        $('.wbm_thankyou_page_cat_banner_img_admin').attr('src', '');
        $('.wbm_thankyou_page_cat_banner_img_admin').css('display', 'none');
        $('.banner_thankyou_dynamic_div').css('display', 'none');
    });
}

    if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    jQuery('#shop_start_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: '0',
        onSelect: function () {
            var dt;
            dt = jQuery(this).datepicker('getDate');
            dt.setDate(dt.getDate() + 1);
            jQuery('#shop_end_date').datepicker('option', 'minDate', dt);
        }
    });

    jQuery('#shop_end_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: '0'
    });

    jQuery('#cart_start_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: '0',
        onSelect: function () {
            var dt;
            dt = jQuery(this).datepicker('getDate');
            dt.setDate(dt.getDate() + 1);
            jQuery('#cart_end_date').datepicker('option', 'minDate', dt);
        }
    });

    jQuery('#cart_end_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: '0'
    });

    jQuery('#checkout_start_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: '0',
        onSelect: function () {
            var dt;
            dt = jQuery(this).datepicker('getDate');
            dt.setDate(dt.getDate() + 1);
            jQuery('#checkout_end_date').datepicker('option', 'minDate', dt);
        }
    });

    jQuery('#checkout_end_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: '0'
    });

    jQuery('#thankyou_start_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: '0',
        onSelect: function () {
            var dt;
            dt = jQuery(this).datepicker('getDate');
            dt.setDate(dt.getDate() + 1);
            jQuery('#thankyou_end_date').datepicker('option', 'minDate', dt);
        }
    });

    jQuery('#thankyou_end_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: '0'
    });

    jQuery('#cat_banner_start_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: '0',
        onSelect: function () {
            var dt;
            dt = jQuery(this).datepicker('getDate');
            dt.setDate(dt.getDate() + 1);
            jQuery('#cat_banner_end_date').datepicker('option', 'minDate', dt);
        }
    });

    jQuery('#cat_banner_end_date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: '0'
    });
    }

    $('.cat-single-image-delete').live('click', function (event) {
        var imageId;
        if (confirm(wbmAdminVars.alert)) {
            imageId = $(this).attr('id');
            $('.banner_cat_image_' + imageId).attr('value', '');
            $('.banner_cat_image_' + imageId).css('display', 'none');
            $('.wbm_add_cat_banner_img_' + imageId).attr('src', '');
            $('.wbm_add_cat_banner_img_' + imageId).css('display', 'none');
            $('.add_category_input_' + imageId).attr('value', '');
            $('.add_category_input_' + imageId).css('display', 'none');
            $('#add_category_' + imageId).css('display', 'none');
            $('#' + imageId).css('display', 'none');
        }
    });


    $('.shop-single-image-delete').live('click', function (event) {
        var imageId;
        if (confirm(wbmAdminVars.alert)) {
            imageId = $(this).attr('id');
            $('.banner_shop_image_' + imageId).attr('src', '');
            $('.banner_shop_image_' + imageId).css('display', 'none');
            $('.banner_shop_input_' + imageId).attr('value', '');
            $('.banner_shop_input_' + imageId).css('display', 'none');
            $('#' + imageId).css('display', 'none');
            $('#banner_shop_' + imageId).css('display', 'none');
        }
    });

    $('.cart-single-image-delete').live('click', function (event) {
        var imageId;
        if (confirm(wbmAdminVars.alert)) {
            imageId = $(this).attr('id');
            $('.banner_cart_image_' + imageId).attr('src', '');
            $('.banner_cart_image_' + imageId).css('display', 'none');
            $('.banner_cart_input_' + imageId).attr('value', '');
            $('.banner_cart_input_' + imageId).css('display', 'none');
            $('#' + imageId).css('display', 'none');
            $('#banner_cart_' + imageId).css('display', 'none');
        }
    });

    $('.checkout-single-image-delete').live('click', function (event) {
        var imageId;
        if (confirm(wbmAdminVars.alert)) {
            imageId = $(this).attr('id');
            $('.banner_checkout_image_' + imageId).attr('src', '');
            $('.banner_checkout_image_' + imageId).css('display', 'none');
            $('.banner_checkout_input_' + imageId).attr('value', '');
            $('.banner_checkout_input_' + imageId).css('display', 'none');
            $('#' + imageId).css('display', 'none');
            $('#banner_checkout_' + imageId).css('display', 'none');
        }
    });

    $('.thankyou-single-image-delete').live('click', function (event) {
        var imageId;
        if (confirm(wbmAdminVars.alert)) {
            imageId = $(this).attr('id');
            $('.banner_thankyou_image_' + imageId).attr('src', '');
            $('.banner_thankyou_image_' + imageId).css('display', 'none');
            $('.banner_thankyou_input_' + imageId).attr('value', '');
            $('.banner_thankyou_input_' + imageId).css('display', 'none');
            $('#' + imageId).css('display', 'none');
            $('#banner_thankyou_' + imageId).css('display', 'none');
        }
    });
    if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
    $('input[name=\'term_meta[cat_banner_image_type]\']').click(function () {
        var value = $(this).val();
        if ('cat_slider' === value) {
            $('#cat-slider-setting').show();
        } else {
            $('#cat-slider-setting').hide();
        }
    });
    $('input[name=\'wbm_shop_setting_enable_random_images\']').click(function () {
        var value = $(this).val();
        if ('shop_slider' === value) {
            $('#shop-slider-setting').show();
        } else {
            $('#shop-slider-setting').hide();
        }
    });

    $('input[name=\'wbm_cart_setting_enable_random_images\']').click(function () {
        var value = $(this).val();
        if ('cart_slider' === value) {
            $('#cart-slider-setting').show();
        } else {
            $('#cart-slider-setting').hide();
        }
    });

    $('input[name=\'wbm_checkout_setting_enable_random_images\']').click(function () {
        var value = $(this).val();
        if ('checkout_slider' === value) {
            $('#checkout-slider-setting').show();
        } else {
            $('#checkout-slider-setting').hide();
        }
    });

    $('input[name=\'wbm_thankyou_setting_enable_random_images\']').click(function () {
        var value = $(this).val();
        if ('thankyou_slider' === value) {
            $('#thankyou-slider-setting').show();
        } else {
            $('#thankyou-slider-setting').hide();
        }
    });

    $('select.cat-select-image-type').change(function () {
        var selectValue;
        $('#cat-multiple-banner-type,#cat-multiple-banner-image,#cat-slider-setting,#cat-single-banner-upload,#cat-single-banner-image,#cat-single-image-link').hide();
        selectValue = $(this).attr('value');
        if ('cat-multiple-images' == selectValue) {
            $('#cat-multiple-banner-type').show();
            $('#cat-multiple-banner-image').show();
        } else {
            $('#cat-single-banner-upload').show();
            $('#cat-single-banner-image').show();
            $('#cat-single-image-link').show();
        }
    });

    $('select.shop-select-image-type').change(function () {
        var selectValue;
        $('#shop-single-image,#shop-multiple-images').hide();
        selectValue = $(this).attr('value');
        $('#' + selectValue).show();
    });

    $('select.cart-select-image-type').change(function () {
        var selectValue;
        $('#cart-single-image,#cart-multiple-images').hide();
        selectValue = $(this).attr('value');
        $('#' + selectValue).show();
    });

    $('select.checkout-select-image-type').change(function () {
        var selectValue;
        $('#checkout-single-image,#checkout-multiple-images').hide();
        selectValue = $(this).attr('value');
        $('#' + selectValue).show();
    });

    $('select.thankyou-select-image-type').change(function () {
        var selectValue;
        $('#thankyou-single-image,#thankyou-multiple-images').hide();
        selectValue = $(this).attr('value');
        $('#' + selectValue).show();
    });
    }
});

if ( "true" === wbmAdminVars.can_use_premium_code || true === wbmAdminVars.can_use_premium_code ) {
//Renumber table rows
function renumberTable(tableID) {
    var count;
    jQuery(tableID + ' tr').each(function () {
        count = jQuery(this).parent().children().index(jQuery(this)) + 1;
        jQuery(this).find('.priority').text(count);
    });
}
}
