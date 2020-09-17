jQuery( document ).ready( function ( $ ) {
    // Menu fixes
    $( function () {
        if ( $( window ).width() > 767 ) {
            $( ".dropdown" ).hover(
                function () {
                    $( this ).addClass( 'open' )
                },
                function () {
                    $( this ).removeClass( 'open' )
                }
            );
        }
    } );
    $( '.navbar .dropdown-toggle' ).hover( function () {
        $( this ).addClass( 'disabled' );
    } );
    $( window ).scroll( function () {
        var topmenu = $( '#top-navigation' ).outerHeight();
        var header = $( '.site-header' ).outerHeight();
        if ( $( document ).scrollTop() > ( topmenu + header + 50 ) ) {
            $( 'nav#site-navigation' ).addClass( 'shrink' );
            $( '.header-cart' ).addClass( 'float-cart' );
            $( '.header-my-account' ).addClass( 'float-login' );
        } else {
            $( 'nav#site-navigation' ).removeClass( 'shrink' );
            $( '.header-cart' ).removeClass( 'float-cart' );
            $( '.header-my-account' ).removeClass( 'float-login' );
        }
    } );

    $( '.open-panel' ).each( function () {
        var menu = $( this ).data( 'panel' );
        $( "#" + menu ).click( function () {
            $( "#blog" ).toggleClass( "openNav" );
            $( "#" + menu + ".open-panel" ).toggleClass( "open" );
        } );
    } );

    $( '.top-search-icon' ).click( function () {
        $( ".top-search-box" ).toggle( 'slow' );
        $( ".top-search-icon .fa" ).toggleClass( "fa-times fa-search" );
    } );

    $( '.offcanvas-sidebar-toggle' ).on( 'click', function () {
        $( 'body' ).toggleClass( 'offcanvas-sidebar-expanded' );
    } );
    $( '.offcanvas-sidebar-close' ).on( 'click', function () {
        $( 'body' ).toggleClass( 'offcanvas-sidebar-expanded' );
    } );

    $( '.slider-center' ).each( function ( index, element ) {
        var $myDiv = $( this );
        if ( $myDiv.length ) {
            // RTL
            if ( $( 'body.rtl' ).length !== 0 ) {
                var id = $( this ).data( 'id' );
                var slider = $( '#' + id + ' .slider-center' );
                var sliderauto = slider.data( 'sliderauto' );
                var slidermode = slider.data( 'slidermode' );
                var sliderpause = slider.data( 'sliderpause' );
                var sliderautohover = slider.data( 'sliderautohover' );
                var slidercontrols = slider.data( 'slidercontrols' );
                var sliderpager = slider.data( 'sliderpager' );

                slidermode = typeof slidermode === 'undefined' ? true : slidermode;
                sliderpause = typeof sliderpause === 'undefined' ? 9000 : ( 1000 * sliderpause );
                sliderauto = sliderauto == 1 ? true : false;
                sliderautohover = sliderautohover == 1 ? true : false;
                slidercontrols = slidercontrols == 1 ? true : false;
                sliderpager = sliderpager == 1 ? true : false;
                $( slider ).slick( {
                    infinite: true,
                    autoplay: sliderauto,
                    speed: 300,
                    rtl: true,
                    autoplaySpeed: sliderpause,
                    dots: sliderpager,
                    fade: slidermode,
                    pauseOnHover: sliderautohover,
                    arrows: slidercontrols,
                } );
            } else {
                var id = $( this ).data( 'id' );
                var slider = $( '#' + id + ' .slider-center' );
                var sliderauto = slider.data( 'sliderauto' );
                var slidermode = slider.data( 'slidermode' );
                var sliderpause = slider.data( 'sliderpause' );
                var sliderautohover = slider.data( 'sliderautohover' );
                var slidercontrols = slider.data( 'slidercontrols' );
                var sliderpager = slider.data( 'sliderpager' );

                slidermode = typeof slidermode === 'undefined' ? true : slidermode;
                sliderpause = typeof sliderpause === 'undefined' ? 9000 : ( 1000 * sliderpause );
                sliderauto = sliderauto == 1 ? true : false;
                sliderautohover = sliderautohover == 1 ? true : false;
                slidercontrols = slidercontrols == 1 ? true : false;
                sliderpager = sliderpager == 1 ? true : false;
                $( slider ).slick( {
                    infinite: true,
                    autoplay: sliderauto,
                    speed: 300,
                    autoplaySpeed: sliderpause,
                    dots: sliderpager,
                    fade: slidermode,
                    pauseOnHover: sliderautohover,
                    arrows: slidercontrols,
                } );
            }

        }
    } );

    $( '.services-center' ).each( function ( index, element ) {
        var $myDiv = $( this );
        if ( $myDiv.length ) {
            // RTL
            if ( $( 'body.rtl' ).length !== 0 ) {
                var id = $( this ).data( 'id' );
                var slider = $( '#' + id + ' .services-center' );
                var sliderauto = slider.data( 'sliderauto' );
                var sliderpause = slider.data( 'sliderpause' );
                var sliderautohover = slider.data( 'sliderautohover' );
                var slidercontrols = slider.data( 'slidercontrols' );
                var sliderpager = slider.data( 'sliderpager' );
                var slideritems = slider.data( 'slideritems' );
                var sliderpageresp = 2;

                sliderpause = typeof sliderpause === 'undefined' ? 9000 : ( 1000 * sliderpause );
                sliderauto = sliderauto == 1 ? true : false;
                sliderautohover = sliderautohover == 1 ? true : false;
                slidercontrols = slidercontrols == 1 ? true : false;
                sliderpager = sliderpager == 1 ? true : false;
                sliderpageresp = slideritems == 1 ? 1 : 2;
                $( slider ).slick( {
                    infinite: true,
                    autoplay: sliderauto,
                    speed: 300,
                    rtl: true,
                    autoplaySpeed: sliderpause,
                    dots: sliderpager,
                    pauseOnHover: sliderautohover,
                    arrows: slidercontrols,
                    slidesToShow: slideritems,
                    slidesToScroll: 1,
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: sliderpageresp,
                            }
                        },
                        {
                            breakpoint: 539,
                            settings: {
                                slidesToShow: 1,
                            }
                        }
                    ]
                } );
            } else {
                var id = $( this ).data( 'id' );
                var slider = $( '#' + id + ' .services-center' );
                var sliderauto = slider.data( 'sliderauto' );
                var sliderpause = slider.data( 'sliderpause' );
                var sliderautohover = slider.data( 'sliderautohover' );
                var slidercontrols = slider.data( 'slidercontrols' );
                var sliderpager = slider.data( 'sliderpager' );
                var slideritems = slider.data( 'slideritems' );
                var sliderpageresp = 2;

                sliderpause = typeof sliderpause === 'undefined' ? 9000 : ( 1000 * sliderpause );
                sliderauto = sliderauto == 1 ? true : false;
                sliderautohover = sliderautohover == 1 ? true : false;
                slidercontrols = slidercontrols == 1 ? true : false;
                sliderpager = sliderpager == 1 ? true : false;
                sliderpageresp = slideritems == 1 ? 1 : 2;
                $( slider ).slick( {
                    infinite: true,
                    autoplay: sliderauto,
                    speed: 300,
                    autoplaySpeed: sliderpause,
                    dots: sliderpager,
                    pauseOnHover: sliderautohover,
                    arrows: slidercontrols,
                    slidesToShow: slideritems,
                    slidesToScroll: 1,
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: sliderpageresp,
                            }
                        },
                        {
                            breakpoint: 539,
                            settings: {
                                slidesToShow: 1,
                            }
                        }
                    ]
                } );
            }

        }
    } );
    $( '.yt-video' ).each( function ( index, element ) {
        var ids = $( this ).data( 'ids' );
        var video = $( '#' + ids + '.yt-video' ).data( 'video' );
        $( '#' + ids + '.yt-video' ).YTPlayer( {
            fitToBackground: true,
            videoId: video,
            playerVars: {
                modestbranding: 0,
                autoplay: 1,
                controls: 0,
                showinfo: 0,
                branding: 0,
                rel: 0,
                autohide: 0,
                start: 0,
            },
            callback: function () {
                videoCallbackEvents();
            }
        } );
        var videoCallbackEvents = function () {
            var player = $( '#' + ids + '.yt-video' ).data( 'ytPlayer' ).player;

            player.addEventListener( 'onStateChange', function ( event ) {

                // OnStateChange Data
                if ( event.data === 1 ) {
                    $( '.youtube-iframe-wrapper .bg-image-cover' ).hide();
                }
            } );
        };
    } );
} );

// Content slider in single post
jQuery( document ).ready( function ( $ ) {
    var $myDiv = $( '.woo-float-info' );
    if ( $myDiv.length ) {
        $( window ).scroll( function () {
            var distanceTop = $( '.woocommerce-tabs' ).offset().top - 60;

            if ( $( window ).scrollTop() > distanceTop )
                $myDiv.animate( { 'bottom': '0' }, 200 );
            else
                $myDiv.stop( true ).animate( { 'bottom': '-400px' }, 100 );
        } );

        $( '.woo-float-info .close-me' ).bind( 'click', function () {
            $( this ).parent().remove();
        } );
    }
    ;
} );
