<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<body>
<div class="app">
    <div class="container text-center">
        <div class="col-lg-12">
            <h3 class="text-primary">Thanks and Congratulations!</h3>
            <p>You are on your way to big savings on your home improvement project.</p>
        </div>
        <div class="clearfix"><hr></div>
        <div class="col-lg-12 centered">
            <p>Our trusted partners have received your request and will contact you within 24 hours.</p>
            <p>They may ask a few additional questions, but don't worry, this is just to make sure they've fully understood your project requirements and are compiling estimates which adequately meet the requirements.</p>
            <p>With your free no obligation estimates in hand you can then more accurately compare companies and systems and decide which represents the best value for the money.</p>
            {{--<img src="{{asset('/public/images/thank-you.jpg')}}" class="hidden-xs thankyouimg"> <p class="visible-xs thankyouimg">&nbsp;</p>--}}
            <img src="{{ $message->embed(asset( '/images/thank-you.jpg') ) }}" />
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>