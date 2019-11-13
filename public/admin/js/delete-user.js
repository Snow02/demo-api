$(document).ready(function(){
    $('#btn-delete').click(function(e){
        var id = $('#user-id').val();
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: `api/v1/delete-user/${id}`,
            method: 'delete',
            data: {
            },
            error: function(error){
                console.log(error.responseJSON);
            },
            success: function(result){
                console.log(result);
                    if(result.result == 200){
                        // window.open('http://laravel-sandbox/admin/index');
                        window.location.href = "http://laravel-sandbox/admin/index";
                    }
            }
        });
    });
});