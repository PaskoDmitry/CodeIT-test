$(document).ready(function() {
    $( function() {
        $( "#date" ).datepicker();
    } );

    $('#registerForm').on("click", 'input[name=register]', function( event ) {
        event.preventDefault();
    
        $("#registerForm").validate({
    
            rules: {

                email: {
                    required: true,
                },

                
                login: {
                    required: true,
                    minlength: 4,
                    maxlength: 16
                },

                name: {
                    required: true
                },
    
                date: {
                    required: true
                },

                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 16
                },

                country: {
                    required: true
                },

                agree: {
                    required: true
                }
            },

            messages : {
                // agree: {
                //     required: ' '
                // }
            }
        });
    });
});