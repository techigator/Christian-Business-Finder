@extends('web.layouts.main')
@section('content')
        <!-- START: Inner Banner-->
        @include('web.layouts.inner_banner')
        <!-- END: Inner Banner-->
<main class="contactPg">
  <section class="login_main_txt">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12 wow zoomIn" data-wow-delay="0.4s" data-wow-duration="1.4s" style="visibility: visible; animation-duration: 1.4s; animation-delay: 0.4s; animation-name: zoomIn;"> 
        <div class="login_main_txt1 wow fadeInLeft" data-wow-delay="0.4s" data-wow-duration="1.4s" style="visibility: visible; animation-duration: 1.4s; animation-delay: 0.4s; animation-name: fadeInLeft;">
          <h4>SIGN IN</h4>
        </div>
        <form>
        <div class="login_main_txt1 wow fadeInLeft" data-wow-delay="0.6s" data-wow-duration="1.6s" style="visibility: visible; animation-duration: 1.6s; animation-delay: 0.6s; animation-name: fadeInLeft;">
          <input type="text" placeholder="Email">
        </div>
          <div class="login_main_txt1 wow fadeInLeft" data-wow-delay="0.8s" data-wow-duration="1.8s" style="visibility: visible; animation-duration: 1.8s; animation-delay: 0.8s; animation-name: fadeInLeft;">
          <input type="text" placeholder="Password">
        </div>
         <div class="login_main_txt1 wow fadeInLeft" data-wow-delay="0.9s" data-wow-duration="1.9s" style="visibility: visible; animation-duration: 1.9s; animation-delay: 0.9s; animation-name: fadeInLeft;">
          <a href="#">SEND</a><a href="#" class="pull-right forgot_link">Forgot your password <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="login_main_txt1 wow fadeInLeft" data-wow-delay="1s" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 1s; animation-name: fadeInLeft;">
        <p><strong>OR</strong> Sign up with your social media account</p>
        </div>
        <div class="login_main_txt1d">
        <ul>
          <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
        </ul>
        </div>
         </form>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12 wow zoomIn" data-wow-delay="0.4s" data-wow-duration="1.4s" style="visibility: visible; animation-duration: 1.4s; animation-delay: 0.4s; animation-name: zoomIn;"> 
        <div class="login_main_txt1 wow fadeInRight" data-wow-delay="0.3s" data-wow-duration="1.3s" style="visibility: visible; animation-duration: 1.3s; animation-delay: 0.3s; animation-name: fadeInRight;">
          <h4>REGISTER</h4>
        </div>
        <form>
        <div class="login_main_txt1 wow fadeInRight" data-wow-delay="0.5s" data-wow-duration="1.5s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.5s; animation-name: fadeInRight;">
          <input type="text" placeholder="Email">
        </div>
        <div class="login_main_txt1 wow fadeInRight" data-wow-delay="0.7s" data-wow-duration="1.7s" style="visibility: visible; animation-duration: 1.7s; animation-delay: 0.7s; animation-name: fadeInRight;">
          <input type="text" placeholder="Password">
        </div>
        <div class="login_main_txt1 wow fadeInRight" data-wow-delay="0.9s" data-wow-duration="1.9s" style="visibility: visible; animation-duration: 1.9s; animation-delay: 0.9s; animation-name: fadeInRight;">
          <input type="text" placeholder="Confirm Password">
        </div>
         <div class="login_main_txt112 wow fadeInRight" data-wow-delay="1s" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 1s; animation-name: fadeInRight;">
          <a href="#">CREATE A ACCOUNT</a>
        </div>
         <div class="login_main_txt112b wow fadeInRight" data-wow-delay="2s" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-delay: 2s; animation-name: fadeInRight;">
         <p>By clicking ‘Create Account’, you agree to our <a href="#"> Privacy Policy <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></p>
        </div>
        <div class="clearfix"></div>
        </form>
      </div>
    </div>
  </div>
</section>
</main>
@endsection
@section('css')
<style type="text/css">
</style>
@endsection
@section('js')
@endsection
