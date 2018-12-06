( function( $, wpData, wpEditor ) {
    $(window).load(function() {
        var $button = $( '<button>' ).text( 'Switch to Make' );

        $( '.edit-post-header-toolbar' ).append( $button );
    });

    var subscriber = wpData.subscribe( function()  {
        var newTemplate = wpData.select('core/editor').getEditedPostAttribute('template');

        return newTemplate;
    } );

    console.log( subscriber );
})(jQuery, window.wp.data, window.wp.editor );