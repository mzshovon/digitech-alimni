<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{config('app.name') ?? "Alumni"}}</title>
    <link rel="icon" href="{{URL::to('/')}}/public/landing/img/favicon.png">
    <link rel="stylesheet" href="{{URL::to('/')}}/public/landing/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/public/landing/css/animate.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/public/landing/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/public/landing/css/themify-icons.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/public/landing/css/flaticon.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/public/landing/css/magnific-popup.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/public/landing/css/slick.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/public/landing/css/style.css">
</head>
<body>

@include('frontend.partials.header')
@yield('content')
@include('frontend.partials.footer')

<script src="{{URL::to('/')}}/public/landing/js/jquery-1.12.1.min.js"></script>
<script src="{{URL::to('/')}}/public/landing/js/popper.min.js"></script>
<script src="{{URL::to('/')}}/public/landing/js/bootstrap.min.js"></script>
<script src="{{URL::to('/')}}/public/landing/js/jquery.magnific-popup.js"></script>
<script src="{{URL::to('/')}}/public/landing/js/swiper.min.js"></script>
<script src="{{URL::to('/')}}/public/landing/js/masonry.pkgd.js"></script>
<script src="{{URL::to('/')}}/public/landing/js/owl.carousel.min.js"></script>
<script src="{{URL::to('/')}}/public/landing/js/jquery.nice-select.min.js"></script>
<script src="{{URL::to('/')}}/public/landing/js/slick.min.js"></script>
<script src="{{URL::to('/')}}/public/landing/js/jquery.counterup.min.js"></script>
<script src="{{URL::to('/')}}/public/landing/js/waypoints.min.js"></script>
<script src="{{URL::to('/')}}/public/landing/js/custom.js"></script>

@stack('script')
</body>
</html>
