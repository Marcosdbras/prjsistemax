var priceOptions = {"50_websites":{"1_year":{"price":79,"link":"https:\/\/go.premio.io\/?edd_action=add_to_cart&download_id=2199&edd_options[price_id]=3"},"2_year":{"price":125,"link":"https:\/\/go.premio.io\/?edd_action=add_to_cart&download_id=2199&edd_options[price_id]=15"},"lifetime":{"price":199,"link":"https:\/\/go.premio.io\/?edd_action=add_to_cart&download_id=2199&edd_options[price_id]=9"}},"500_websites":{"1_year":{"price":139,"link":"https:\/\/go.premio.io\/?edd_action=add_to_cart&download_id=2199&edd_options[price_id]=16"},"2_year":{"price":225,"link":"https:\/\/go.premio.io\/?edd_action=add_to_cart&download_id=2199&edd_options[price_id]=17"},"lifetime":{"price":359,"link":"https:\/\/go.premio.io\/?edd_action=add_to_cart&download_id=2199&edd_options[price_id]=18"}},"1000_websites":{"1_year":{"price":199,"link":"https:\/\/go.premio.io\/?edd_action=add_to_cart&download_id=2199&edd_options[price_id]=19"},"2_year":{"price":315,"link":"https:\/\/go.premio.io\/?edd_action=add_to_cart&download_id=2199&edd_options[price_id]=20"},"lifetime":{"price":499,"link":"https:\/\/go.premio.io\/?edd_action=add_to_cart&download_id=2199&edd_options[price_id]=21"}}};
jQuery(document).ready(function($){
    jQuery('.my-color-field').wpColorPicker();
    jQuery(document).on('click', '.sticky-header-upgrade-now', function(e){
        e.preventDefault();
        jQuery(".sticky-header-menu ul li a:last").trigger("click");
    });
    if(jQuery(".multiple-options").length) {
        jQuery(".multiple-options").select2({
            minimumResultsForSearch: -1
        });
    }
    if(jQuery(".multiple-web-options").length) {
        jQuery(".multiple-web-options").select2({
            minimumResultsForSearch: -1
        });
    }
//        priceOptions = jQuery.parseJSON(priceOptions);
    jQuery(document).on("change", ".multiple-options", function(){
        priceText = jQuery(this).find("option:selected").attr("data-header");
        thisValue = jQuery(this).val();
        thisPrice = jQuery(this).find("option:selected").attr("data-price");
        if(!jQuery(this).hasClass("has-multiple-websites")) {
            jQuery(this).closest(".rpt_plan").find("a.rpt_foot").attr("href", thisValue);
            jQuery(this).closest(".rpt_plan").find(".rpt_price").text("$" + thisPrice);
        } else {
            var webOption = jQuery(".multiple-web-options").val();
            var priceSettings = priceOptions[webOption];
            var yearPlan = jQuery(".multiple-options.has-multiple-websites option:selected").attr("data-option");
            if(priceSettings[yearPlan] != undefined) {
                priceSettings = priceSettings[yearPlan];
                thisValue = priceSettings.link;
                thisPrice = priceSettings.price;
            }
        }
        jQuery(this).closest(".rpt_plan").find("a.rpt_foot").attr("href", thisValue);
        jQuery(this).closest(".rpt_plan").find(".rpt_price").text("$" + thisPrice);
        jQuery(this).closest(".rpt_plan").find(".rpt_desc").text(priceText);
    });

    jQuery(document).on("change", ".multiple-web-options", function(){
        jQuery(".multiple-options.has-multiple-websites").trigger("change");
    });
});