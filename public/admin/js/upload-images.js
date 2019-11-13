$(document).ready(function(){
    $('#form-upload').on('submit',(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var images = new FormData(this);

        // console.log(images);


        $.ajax({
            url: `api/v1/upload-images-user/63`,
            method: 'post',
            data: images,
            contentType: false,
            processData: false,
            error: function(error){
                console.log(error.responseJSON);
            },
            success: function(result){
                console.log(result);
                $('.success').text('Upload file success');
            }
        });
    }));
});

