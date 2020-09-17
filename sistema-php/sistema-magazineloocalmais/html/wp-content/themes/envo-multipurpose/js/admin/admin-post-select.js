/**
 * Used for ajax post selection by inc/class-widget.php
 */

( function ( $ ) {
    "use strict";

    $.fn.extend(
        {
            // change 'pluginname' to your plugin name (duh).
            postAutoCompleteSelect: function ( options ) {
                var split = function ( val ) {
                    return val.split( /,\s*/ );
                }
                var extractLast = function ( term ) {
                    return split( term ).pop();
                }

                return this.each(
                    function () {
                        var $this = $( this );

                        if ( $this.length ) {
                            var $parent = $this.parent();
                            $parent.css( { 'position': 'relative' } );
                            var type = $this.data( 'autocompleteType' );
                            var lookup = $this.data( 'autocompleteLookup' );
                            var taxonomy = $this.data( 'autocompleteTaxonomy' );
                            var post_type = $this.data( 'autocompletePostType' );
                            var options = '';

                            if ( 'multi' == type ) {
                                options = {
                                    minLength: 0,
                                    appendTo: $parent,
                                    source: function ( request, response ) {
                                        var term = extractLast( request.term );
                                        $.ajax(
                                            {
                                                type: 'POST',
                                                dataType: 'json',
                                                url: ajaxurl,
                                                data: 'action=envo_multipurpose_' + lookup + '_lookup&request=' + term + '&post_type=' + post_type + '&taxonomy=' + taxonomy,
                                                success: function ( data ) {
                                                    response( data );
                                                }
                                            }
                                        );
                                    },
                                    select: function ( event, ui ) {
                                        var terms = split( this.value );
                                        // remove the current input.
                                        terms.pop();
                                        // add the selected item.
                                        terms.push( ui.item.value );
                                        // add placeholder to get the comma-and-space at the end.
                                        terms.push( "" );

                                        $( this ).val( terms.join( "," ) );

                                        return false;
                                    },
                                    focus: function ( event, ui ) {
                                        return false; // Prevent comma delim value from being replace by single value..
                                    },
                                    close: function ( event, ui ) {
                                        var $t = $( this );
                                        $t.trigger( 'change' );
                                        /* setTimeout(function(){
                                         $t.blur();
                                         }, 0); */
                                    }
                                }
                            } else {
                                options = {
                                    minLength: 0,
                                    appendTo: $parent,
                                    source: function ( request, response ) {
                                        var term = request.term;
                                        if ( $post_type.length ) {
                                            post_type = $post_type.val();
                                        }
                                        if ( $taxonomy.length ) {
                                            taxonomy = $taxonomy.val();
                                        }
                                        $.ajax(
                                            {
                                                type: 'POST',
                                                dataType: 'json',
                                                url: ajaxurl,
                                                data: 'action=envo_multipurpose_' + lookup + '_lookup&request=' + term + '&post_type=' + post_type + '&taxonomy=' + taxonomy,
                                                success: function ( data ) {
                                                    response( data );
                                                }
                                            }
                                        );
                                    },
                                    close: function ( event, ui ) {
                                        var $t = $( this );
                                        $t.trigger( 'change' );
                                        /* setTimeout(function(){
                                         $t.blur();
                                         }, 0); */
                                    }
                                };
                            }

                            $this.autocomplete( options ).bind( 'focus', function () {
                                $( this ).autocomplete( "search" );
                            } );
                        }
                    }
                );
            }
        }
    );
} )( jQuery );
