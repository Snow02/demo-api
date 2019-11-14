$(document).ready(function(){
    $('#btn-login').click(function(e){

        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var data = {
          username : $('#username').val(),
          password : $('#password').val(),
          device_token : 'chyHLnqSKdo:APA91bGyuDlRhM7LWJJKfDakx_LeGPFYOAodSPLr4PP30BvXzAW331cP4tNSsPCdtnuhoNzMIf8l5CHv2F9jELeoCW9jyKkiELb21QwNllc-yxMp0i49aGV0_FxL4LNt5ZQprShx4oh-',
          mac_address : '2:0:0:44:55:66',
        };
        $.ajax({
            url: `api/v1/login`,
            method: 'post',
            data: data,
            // contentType: false,
            // processData: false,
            error: function(error){
                console.log(error.responseJSON);
            },
            success: function(result){
                console.log(result.message);
                window.location.href = 'http://laravel-sandbox/admin/index';

            }
        });
    });
});