jQuery(document).ready(function(e){e(".hasmenu > a").click(function(a){"#"==e(this).attr("href")&&a.preventDefault(),e(this).hasClass("active")?(e(this).removeClass("active"),e(".hasmenu").find("ul").slideUp()):(e(".hasmenu").find("a").removeClass("active"),e(this).addClass("active"),e(this).closest("ul").hasClass("submenu")||e(".hasmenu").find("ul").slideUp(),e(this).next("ul").slideDown())}),e(".wcmp_stat_start_dt").datepicker({dateFormat:"yy-mm-dd",onClose:function(a){e(".wcmp_stat_end_dt").datepicker("option","minDate",a)}}),e(".wcmp_stat_end_dt").datepicker({dateFormat:"yy-mm-dd",onClose:function(a){e(".wcmp_stat_start_dt").datepicker("option","maxDate",a)}}),e(".wcmp_start_date_order").datepicker({dateFormat:"yy-mm-dd",onClose:function(a){e(".wcmp_end_date_order").datepicker("option","minDate",a)}}),e(".wcmp_end_date_order").datepicker({dateFormat:"yy-mm-dd",onClose:function(a){e(".wcmp_start_date_order").datepicker("option","maxDate",a)}}),e(".wcmp_tab").tabs();var a=e("[data-toggle=collapse-side]"),t=a.attr("data-target"),i=a.attr("data-target-2");a.click(function(a){e(t).toggleClass("in"),e(i).toggleClass("out"),e(".side-collapse-container").toggleClass("large"),e(window).width()<768&&e("#page-wrapper").toggleClass("overlay")}),sibdebarToggle(),mapNavWrap(),e(document).on("change","#wcmp_visitor_stats_date_filter",function(){mapNavWrap()}),e(".responsive-table").each(function(a){for(var t=e(this).find("thead th"),i=e(this).find("tbody tr"),r=e(this).find("tbody td"),n=0;n<i.length;n++)for(var s=0;s<t.length;s++)e(r[s+n*t.length]).attr("data-th",e(t[s]).html())}),e(".img_tip").each(function(){e(this).qtip({content:e(this).attr("data-desc"),position:{my:"top center",at:"bottom center",viewport:e(window)},show:{event:"mouseover",solo:!0},hide:{inactive:6e3,fixed:!0},style:{classes:"qtip-dark qtip-shadow qtip-rounded qtip-dc-css",width:200}})}),e(".wcmp-product-cat-level, .wcmpCustomScroller").mCustomScrollbar()});var isMobile={Android:function(){return navigator.userAgent.match(/Android/i)},BlackBerry:function(){return navigator.userAgent.match(/BlackBerry/i)},iOS:function(){return navigator.userAgent.match(/iPhone|iPad|iPod/i)},Opera:function(){return navigator.userAgent.match(/Opera Mini/i)},Windows:function(){return navigator.userAgent.match(/IEMobile/i)},any:function(){return isMobile.Android()||isMobile.BlackBerry()||isMobile.iOS()||isMobile.Opera()||isMobile.Windows()}};function mapNavWrap(){jQuery(".jqvmap-zoomin, .jqvmap-zoomout").wrapAll('<div class="map-nav"></div>')}function sibdebarToggle(){jQuery("#page-wrapper").on("click",function(e){!jQuery(".navbar-default.sidebar").hasClass("in")&&jQuery(window).width()<=768&&(jQuery(".side-collapse-container").toggleClass("large"),jQuery(".navbar-default.sidebar").addClass("in"),jQuery("#page-wrapper").removeClass("overlay"))}),jQuery(window).width()<=768?(jQuery(".sidebar").addClass("in"),jQuery("#page-wrapper").removeClass("overlay"),jQuery(".side-collapse-container").removeClass("large")):(jQuery(".sidebar").removeClass("in"),jQuery("#page-wrapper").removeClass("overlay"),jQuery(".side-collapse-container").removeClass("large"))}function toggleAllCheckBox(e,a){jQuery(e).is(":checked")?jQuery("#"+a).find("tbody tr td input[type=checkbox]").not(":disabled").prop("checked",!0):jQuery("#"+a).find("tbody tr td input[type=checkbox]").prop("checked",!1)}jQuery(document).ready(function(e){if(e(window).width()<=640){var a=e(".wcmp_main_menu ul li.hasmenu>a.active");a.parent().find("ul.submenu").hide(),a.removeClass("active"),a.hasClass("responsive_active")||a.addClass("responsive_active")}}),jQuery(window).resize(function(){var e;jQuery.noConflict();jQuery(window).width()<=640?((e=jQuery(".wcmp_main_menu ul li.hasmenu>a.active")).parent().find("ul.submenu").hide(),e.removeClass("active"),e.hasClass("responsive_active")||e.addClass("responsive_active")):((e=jQuery(".wcmp_main_menu ul li.hasmenu>a.responsive_active")).parent().find("ul.submenu").show(),e.removeClass("responsive_active"),e.hasClass("active")||e.addClass("active"));jQuery(function(e){isMobile.any()||sibdebarToggle()})});