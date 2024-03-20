<?php 
$logo1 = App\Models\logo::find(1); 
?>
  <link rel="shortcut icon" href="{{asset('web/images/fav-icon.png')}}">    
    <link href="{{asset('web/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
  <!-- <link href="{{asset('web/css/bootstrap.min.css.map')}}" rel="stylesheet" type="text/css"> -->
  <link href="{{asset('web/css/custom.css')}}" rel="stylesheet" type="text/css">
  <!-- link owl carasoul  -->
  <link href="{{asset('web/css/owl.carousel.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('web/css/owl.theme.default.min.css')}}" rel="stylesheet" type="text/css">
  <!-- link slick carasoul  -->
  <link href="{{asset('web/css/slick.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('web/css/slick-theme.css')}}" rel="stylesheet" type="text/css">

  <link href="https://site-assets.fontawesome.com/releases/v6.0.0/css/all.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

  <!-- font link add -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <!-- 2nd font link add -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('web/css/toastr.min.css')}}"> 
  <script src="{{asset('web/js/jquery-3.6.0.min.js')}}"></script>
@yield('link')
