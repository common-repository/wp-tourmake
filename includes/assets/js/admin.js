( function( $ ) {
    $('#wptm_form input[type="submit"]').on('click', function () {
        $('#wptm_form').validate({
            errorClass: 'wptm-form-error',
            errorPlacement: function(error, element) {
                if (element.next("span").length > 0){
                    error.appendTo( element.next("span") );
                }else {
                    error.insertAfter(element);
                }
            }
        });
    });
} )( jQuery );