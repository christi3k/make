( function( $, wpData, wpEditor ) {
    $(window).load(function() {
        var $button = $( '<button>' ).text( 'Switch to Make Builder' );

        $( '.edit-post-header-toolbar' ).append( $button );

        $button.on( 'click', handleClick );
    });

    function handleClick() {
        wpData.dispatch('core/editor').savePost();

        window.location.href = window.location.href + '&use-make';
    }
})(jQuery, window.wp.data, window.wp.editor );