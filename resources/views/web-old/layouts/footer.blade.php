<?php
use App\Models\logo;
use App\Models\video;
use App\Models\setting;
$footer_logo = logo::find(1);
$setting = setting::find(1);
// dd($setting );
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// dd($actual_link);
$web_cms_24 = App\Models\web_cms::find(24);
$web_cms_25 = App\Models\web_cms::find(25);
?>
<section class="footer">
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 footer3 mt-5">
        <a href="index.php"> <img src="{{asset('web/images/logo.png')}}"  class="img-fluid" alt="img"> </a>
        <div class="footer1">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <!-- Social Box -->
        <ul class="d-flex social-box">
          <li>
            <a href="{{$setting->facebook}}" class="fab fa-facebook-f"></a>
          </li>
          <li>
            <a href="{{$setting->instagram}}" class="fa-brands fa-instagram"></a>
          </li>
          <li>
            <a href="{{$setting->twitter}}" class="fab fa-twitter"></a>
          </li>
        </ul>
      </div>
      <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3  mt-5 ">
        <h4 class="mb-4">QUICK LINKS</h4>
        <ul class="footer2">
          <li><a href="{{url('/')}}">HOME</a></li>
          <li><a href="{{route('about_us')}}">ABOUT US</a></li>
          <li><a href="{{route('rent')}}">PRODUCTS</a></li>
          <li><a href="{{route('reviews')}}">CUSTOMERS</a></li>
          <li><a href="{{route('contact_us')}}">CONTACT US</a></li>
        </ul>
      </div>
      <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3  mt-5">
        <h4 class="mb-4">CONTACT US</h4>
        <div class="footer3">
          <h6>Address</h6>
          <p>{{$setting->address}}</p>
          <h6>Email Address</h6>
          <p>{{$setting->email}}</p>
          <h6>Phone Number</h6>
          <p>{{$setting->phone}}</p>
        </div>
      </div>
      <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 text-center  mb-3">
        <div class="footer-bottom">
          <div class="clearfix">
            <div class="pull-left">
              <div class="copyright mt-3">
                {{$setting->copyright}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
