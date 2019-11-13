$(document).ready(function(){
    $('#form-add').on('submit',(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var images = new FormData(this);
        var data = {
            name: $('#name').val(),
            username: $('#username').val(),
            email: $('#email').val(),
            address: $('#address').val(),
            phone: $('#phone').val(),
        }
        Object.keys(data).forEach(key=>{
            images.append(key,data[key]);
        })

        // console.log(images);

        $.ajax({
            url: `api/v1/register`,
            method: 'post',
            data: images,
            contentType: false,
            processData: false,
            error: function(error){
                console.log(error.responseJSON);
            },
            success: function(result){
                console.log(result);
                    if(result.result == 200){
                        window.open('http://laravel-sandbox/admin/index');
                    }
            }
        });
    }));
});