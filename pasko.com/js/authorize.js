$(document).ready(function() {
    
    $('#loginForm').on('click', 'input[name=register]', function(e){
        e.preventDefault();
       
        $.post(
            '/authorize/register',
            { 
                email:      $('input[name=email]').val(), 
                password:   $('input[name=password]').val(),
                save:       $('#save_checkbox').is(':checked')
            },
            function(data){
                
                if(data.error !== undefined) {
                    $('#error').html(data.error);
                }
                else {
                    $('#userEmail').html('Вы зашли как: ' + '<a href="/user/profile/id/'+ data.id + '">' + data.email + '</a>');
                    $('#userId').html('<a id="logout" href="#">Exit</a>');
                    $('#loginFormDiv').hide();
                    $('#error').empty();
                }
            },
           'json'
        );
    });
    
    $('#loginForm').on('click', 'input[name=login]', function(e){
        e.preventDefault();
        $.post(
            '/authorize/login', 
            { 
                email:      $('input[name=email]').val(), 
                password:   $('input[name=password]').val(),
                save:       $('#save_checkbox').is(':checked')
            },
            function(data){ 
                if(data.error !== undefined) {
                    $('#error').html(data.error);
                }
                else {
                    $('#userEmail').html('Вы зашли как: ' + '<a href="/user/profile/id/'+ data.id + '">' + data.email + '</a>');
                    $('#userId').html('<a id="logout" href="#">Exit</a>');
                    $('#loginFormDiv').hide();
                    $('#error').empty();
                   
                    if(data.role_id == 5) {
                         $('#admin_href').removeAttr('class');
                    }
                }
            },
            'json'
        );
    });
    
    $('body').on('click', '#logout', function(e) {
        e.preventDefault();
        $.post(
            '/authorize/exit/', 
            {
                
            },
            function(){ 
                $('#logout').empty();
                $('#loginFormDiv').show();
                $('#userEmail').empty();
                $('#admin_href').attr('class', 'hide');
                $('input[name=email]').empty(); 
                $('input[name=password]').empty();
                $('#save_checkbox').empty();
            }
        ); 
    });
});