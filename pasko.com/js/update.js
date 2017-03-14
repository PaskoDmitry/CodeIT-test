$(document).ready(function() {
    
    $('#updateFormDiv').on('click', 'input[name=update]', function(e){
        e.preventDefault();
       
        $.post(
            '/authorize/update',
            { 
                userId:      $('input[name=userId]').val(), 
                email:       $('input[name=email]').val(), 
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
                    alert('Data was saved');
                }
            },
           'json'
        );
    });
    $('#passwordFormDiv').on('click', 'input[name=update]', function(e){
       e.preventDefault();
       
       $.post(
            '/authorize/changePassword',
            { 
                userId:      $('input[name=userId]').val(),
                password:    $('input[name=password1]').val(),
                newPassword: $('input[name=newPassword]').val()
            },
            function(data){
                
                if(data.error !== undefined) {
                    $('#error').html(data.error);
                }
                else {
                    $('#error').empty();
                    alert('Password was saved');
                }
            },
           'json'
        );
    });
    $('#tableUsers').on('click', '.delete', function(e){
       e.preventDefault();
       
       var isDelete = confirm('Вы уверены что хотите удалить юзера ?');
       
       if(isDelete){
           $.post(
            '/authorize/delete',
            { 
                userId:     $(this).attr('data-user_id')
            },
            function(){               
            }
            );
            window.location = 'http://pasko.com/admin/user';
       }
    });
    $('#showFilterForm').bind('click', function(e){
       e.preventDefault();
       $('#divFilterForm').show();
       $('#showFilterForm').hide();
    });
    $('#filterForm').on('click','#selectFilter', function(e){
       e.preventDefault();
       
       $('#divFilterForm').hide();
       $('#showFilterForm').show();
       if($('#email_cb').is(':checked')){
           $('th').eq(5).show();
           $('.email').show();
       }else{
           $('th').eq(5).hide();
           $('.email').hide();
       }
       if($('#first_name_cb').is(':checked')){
           $('th').eq(1).show();
           $('.first_name').show();
       }else{
           $('th').eq(1).hide();
           $('.first_name').hide();
       }
       if($('#last_name_cb').is(':checked')){
           $('th').eq(2).show();
           $('.last_name').show();
       }else{
           $('th').eq(2).hide();
           $('.last_name').hide();
       }
       if($('#year_cb').is(':checked')){
           $('th').eq(4).show();
           $('.year').show();
       }else{
           $('th').eq(4).hide();
           $('.year').hide();
       }
       if($('#skills_cb').is(':checked')){
           $('th').eq(3).show();
           $('.skills').show();
       }else{
           $('th').eq(3).hide();
           $('.skills').hide();
       }
       if($('#role_id').is(':checked')){
           $('th').eq(6).show();
           $('.role_id').show();
       }else{
           $('th').eq(6).hide();
           $('.role_id').hide();
       }
    });
//    $('#divFilterForm').on('click', 'input[name=selectFilter]', function(e){
//     alert($('#skills_cb').val());
//    });
       
});
