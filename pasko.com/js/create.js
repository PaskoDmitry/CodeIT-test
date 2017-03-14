$(document).ready(function() {
    
    $('#createForm').on('click', 'input[name=create]', function(e){
        e.preventDefault();
       
        $.post(
            '/authorize/createUser',
            { 
                password:    $('input[name=createPassword]').val(),
                password1:   $('input[name=createPassword1]').val(), 
                email:       $('input[name=createEmail]').val(), 
                first_name:  $('input[name=first_name]').val(),
                last_name:   $('input[name=last_name]').val(),
                year:        $('input[name=year]').val(),
                skills:      $('input[name=skills]').val(),
                role_id:     $('input[name=role_id]').val()
                
            },
            function(data){
                
                if(data.error !== undefined) {
                    $('#error').html(data.error);
                }
                else {
                    $('#error').empty();
                    alert('New user was created');
                    window.location = 'http://pasko.com/admin/user';
                }
            },
           'json'
        );
        
    });
});
