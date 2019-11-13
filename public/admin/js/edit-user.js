$(document).ready(function(){
    $('#btn-edit').click(function(e){
        var id = $('#user-id').val();
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: `api/v1/edit-user/${id}`,
            method: 'put',
            data: {
                name: $('#name').val(),
                email: $('#email').val(),
                address: $('#address').val(),
                phone: $('#phone').val(),
            },
            error: function(error){
                console.log(error.responseJSON);
                if(error.responseJSON.result == 'false'){
                    $("#errorLogin").text("Please Login.");
                }
            },
            success: function(result){
                console.log(result);
                if(result.result == 200){
                    window.open('http://laravel-sandbox/admin/index');
                }
            }
        });
    });
});