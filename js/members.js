/**
 * member functions
 */
( function( $ ) {
     $( window ).load( function() {
 
        // member filtering
        var $container = $( '.members' );
 
        $container.isotope( {
            filter: '*',
            layoutMode: 'fitRows',
            resizable: true, 
          } );
 
        // filter items when filter link is clicked
        $( '.member-filter li' ).click( function(){
            var selector = $( this ).attr( 'data-filter' );
                $container.isotope( { 
                    filter: selector,
                } );
          return false;
        } );
    } );
} )( jQuery );