$(document).ready(function() {
    
    $('#registerForm').on('click', 'input[name=register]', function(e){
        e.preventDefault();

        var registerdata = {};
        var parent = $(this).closest("form");
        if (parent.valid()) {

            parent.find('input, select').each(function () {
                registerdata[$(this).attr('name')] = $(this).val();
            });
            // console.log(registerdata);
            $.post(
                '/authorize/register',
                {
                    registerdata: registerdata
                },
                function (data) {
                    console.log(data);
                    if (data.error !== undefined) {
                        $('#error').html(data.error);
                    }
                    else {
                        $('#userEmail').html('You login as: ' + '<a href="/user/profile/id/' + data.id + '">' + data.email + '</a>');
                        $('#userId').html('<a id="logout" href="#">Exit</a>');
                        $('#loginFormDiv').hide();
                        $('#registerFormDiv').hide();
                        $('#error').empty();
                    }
                },
                'json'
            );
        }else {
            $('input[name=password]').val('');
        }
    });
    
    $('#loginForm').on('click', 'input[name=loginbut]', function(e){
        e.preventDefault();
        var logindata = {};
        var parent = $(this).closest("form");
        parent.find('input, textarea').each(function () {
            logindata[$(this).attr('name')] = $(this).val();
        });
        console.log(logindata);
        $.post(
            '/authorize/login',
            {
                logindata : logindata
            },
            function(data){
                if(data.error !== undefined) {
                    $('#error').html(data.error);
                }
                else {
                    $('#userEmail').html('You login as: ' + '<a href="/user/profile/id/'+ data.id + '">' + data.email + '</a>');
                    $('#userId').html('<a id="logout" href="#">Exit</a>');
                    $('#loginFormDiv').hide();
                    $('#registerFormDiv').hide()
                    $('#error').empty();

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
                $('#registerForm').find('input').each(function () {
                    $(this).val('');
                });
                $('input[name=register]').val('Register');
                $('#loginForm').find('input').each(function () {
                    $(this).val('');
                });
                $('input[name=loginbut]').val('Log in');
                $('#logout').empty();
                $('#loginFormDiv').show();
                $('#registerFormDiv').show();
                $('#userEmail').empty();
                $("#agree").removeAttr("checked");
                $("#select [value='Chouse country']").attr("selected", "selected");
            }
        );
    });
});