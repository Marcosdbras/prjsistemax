/**
 * A repeater and sort script for inc/class-widget.php
 *
 */

( function ( $ ) {
    "use strict";

    window.widgetPanelDeleteNo = function ( el ) {
        var $this = $( el );
        var $panel = $this.closest( '.widget-panel' );

        $panel.removeClass( 'panel-delete-confirm' );
    }

    window.widgetPanelDeleteYes = function ( el ) {
        var $this = $( el );
        var $panel = $this.closest( '.widget-panel' );
        var $container = $this.closest( '.panel-repeater-container' );
        var $panels = $container.find( '.widget-panel' );

        if ( $panels.length <= 1 ) {
            return;
        }

        if ( $panel.remove() ) {
            $panels = $container.find( '.widget-panel' );

            if ( $panels.length <= 1 ) {
                $container.removeClass( 'show-panel-buttons' );
            }

            widgetPanelMoveRefresh( $container );
        }
    }

    function swapElements( obj1, obj2 ) {
        // create marker element and insert it where obj1 is.
        var temp = document.createElement( "div" );
        obj1.parentNode.insertBefore( temp, obj1 );

        // move obj1 to right before obj2.
        obj2.parentNode.insertBefore( obj1, obj2 );

        // move obj2 to right before where obj1 used to be.
        temp.parentNode.insertBefore( obj2, temp );

        // remove temporary marker node.
        temp.parentNode.removeChild( temp );
    }

    window.widgetPanelMoveRefresh = function ( $container ) {
        var $move = $container.find( '.panel-move' );
        $move.removeClass( 'panel-move-hide' );

        $move = $container.find( '.widget-panel:first .panel-move-up' );
        $move.addClass( 'panel-move-hide' );

        $move = $container.find( '.widget-panel:last .panel-move-down' );
        $move.addClass( 'panel-move-hide' );
    }

    window.widgetPanelMoveUp = function ( el ) {
        var $this = $( el );
        var $panel = $this.closest( '.widget-panel' );
        var $container = $this.closest( '.panel-repeater-container' );
        var $panels = $container.find( '.widget-panel' );

        if ( $panels.length <= 1 ) {
            return;
        }

        if ( !$panel.is( ':first-child' ) ) {
            var $prevPanel = $panel.prev();
            swapElements( $prevPanel[0], $panel[0] );
            $container.accordion( "refresh" );
            $this.focus();
            widgetPanelMoveRefresh( $container );
        }
    }

    window.widgetPanelMoveDown = function ( el ) {
        var $this = $( el );
        var $panel = $this.closest( '.widget-panel' );
        var $container = $this.closest( '.panel-repeater-container' );
        var $panels = $container.find( '.widget-panel' );

        if ( $panels.length <= 1 ) {
            return;
        }

        if ( !$panel.is( ':last-child' ) ) {
            var $nextPanel = $panel.next();
            swapElements( $panel[0], $nextPanel[0] );
            $container.accordion( "refresh" );
            $this.focus();
            widgetPanelMoveRefresh( $container );
        }
    }

    window.widgetPanelDelete = function ( el ) {
        var $this = $( el );
        var $panel = $this.closest( '.widget-panel' );
        var $container = $this.closest( '.panel-repeater-container' );
        var $panels = $container.find( '.widget-panel' );
        /* $container.accordion({active:false}); */

        if ( $panels.length <= 1 ) {
            return;
        }

        $panel.addClass( 'panel-delete-confirm' );
    }

    window.widgetPanelRepeaterButtons = function ( $container ) {
        var $panels = $container.find( '.widget-panel' );

        if ( $panels.length > 1 ) {
            $container.addClass( 'show-panel-buttons' );
        } else {
            $container.removeClass( 'show-panel-buttons' );
        }
    }

    window.widgetPanelRepeater = function ( id ) {
        var $widget = $( '#' + id );
        var $container = $widget.find( '.panel-repeater-container' );
        var $panel = $container.find( '.widget-panel:last' );
        var $panelCount = $widget.find( '#widget-panel-repeater-count' );
        var panelCount = parseInt( $panelCount.val() );
        var nextPanelCount = panelCount + 1;

        if ( $panel.length ) {
            var $copy = $panel.clone();
            $copy.find( '.widget-panel-title' ).removeClass( 'ui-accordion-header-active ui-state-active' );
            $copy.find( '.widget-panel-body' ).removeClass( 'ui-accordion-content-active' );

            var $names = $copy.find( '[name]' );
            if ( $names.length ) {
                $names.each(
                    function () {
                        var $this = $( this );

                        var name = $this.attr( 'name' );
                        name = name.replace( /\[repeater\]\[\d+\]/, '[repeater][' + nextPanelCount + ']' );
                        $this.attr( 'name', name );

                        var id = $this.attr( 'id' );
                        id = id.replace( /repeater\-\d+\-/, 'repeater-' + nextPanelCount + '-' );
                        $this.attr( 'id', id );
                    }
                );
            }

            var $fors = $copy.find( '[for]' );
            if ( $fors.length ) {
                $fors.each(
                    function () {
                        var $this = $( this );

                        var id = $this.attr( 'for' );
                        id = id.replace( /repeater\-\d+\-/, 'repeater-' + nextPanelCount + '-' );
                        $this.attr( 'for', id );
                    }
                );
            }

            $copy.appendTo( $container );
            $panelCount.val( nextPanelCount );

            if ( $copy.hasClass( 'panel-delete-confirm' ) ) {
                $copy.removeClass( 'panel-delete-confirm' );
            }

            $copy.find( '.color-picker' ).each(
                function () {
                    var $inputElement = $( this );
                    if ( $inputElement.is( '.wp-color-picker' ) ) {
                        var $wpPickerContainer = $inputElement.closest( '.wp-picker-container' );
                        var $wrapper = $inputElement.closest( '.color-picker-wrapper' );
                        $wrapper.append( $inputElement.remove() );
                        $wrapper.find( 'script' ).remove();
                        $wpPickerContainer.remove();
                        $inputElement.wpColorPicker();
                    }
                }
            );
        }

        $container.accordion( "refresh" );

        widgetPanelRepeaterButtons( $container );
        widgetPanelMoveRefresh( $container );
    }

    function initColorPicker( widget ) {
        widget.find( '.color-picker' ).wpColorPicker(
            {
                change: _.throttle(
                    function () { /* For Customizer */
                        $( this ).trigger( 'change' );
                    }, 3000
                    )
            }
        );
    }

    function onFormUpdate( event, widget ) {
        initColorPicker( widget );
    }

    /* $( document ).on( 'widget-added widget-updated', onFormUpdate ); */

} )( jQuery );
