<?php
if (!isset($menu)) {
    $menu = 'home';
}
$user = Auth::user();

use App\Models\logo;
use App\Models\setting;
use App\Models\category;

$logo = logo::find(1);
$setting = setting::find(1);
$category = category::where('is_active', 1)->get();
$segment2 = "$_SERVER[REQUEST_URI]";
// dd($segment2);
// dd($category);
?>
    <!-- Header Startssdas -->
@if (Auth::check())
    @if (Auth::user()->type == 'admin')
        <style type="text/css">
            /*Cookie Consent Begin*/
            #adminLogged {
                background-color: rgba(20, 20, 20, 0.8);
                min-height: 26px;
                font-size: 14px;
                color: #fff;
                line-height: 26px;
                padding: 8px 0 8px 30px;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                /*position: fixed;*/
                position: unset;
                /*bottom: 0;*/
                left: 0;
                right: 0;
                /*display: none;*/
                z-index: 9999;
                text-align: center;
            }

            #adminLogged a {
                text-decoration: none;
            }

            #closeadminLogged {
                float: right;
                display: inline-block;
                cursor: pointer;
                height: 20px;
                width: 20px;
                margin: -15px 0 0 0;
                font-weight: bold;
            }

            #closeadminLogged:hover {
                color: #FFF;
            }

            #adminLogged a.adminLoggedOK {
                background-color: #F1D600;
                color: #000;
                display: inline-block;
                border-radius: 5px;
                padding: 0 20px;
                cursor: pointer;
                float: right;
                margin: 0 60px 0 10px;
            }

            #adminLogged a.adminLoggedOK:hover {
                background-color: #E0C91F;
            }

            .skeye_btn_login,
            .skeye_btn {
                height: 56px;
            }

            .gotoAdminButton {
                background: #4fa8dc;
                color: #fff;
                padding: 9px 10px;
                font-weight: 600;
                border: 1px solid #4fa8dc;
                border-radius: 5px;
                margin-right: 2px;
                font-size: 12px;
            }

            .btn-danger:not(:disabled):not(.disabled).active,
            .btn-danger:not(:disabled):not(.disabled):active,
            .show > .btn-danger.dropdown-toggle {
                color: #000 !important;
                background-color: #7e967e !important;
                border-color: #000 !important;
                box-shadow: none !important;
            }

            /*Cookie Consent End*/
        </style>
        <div id="adminLogged">
            You are logged in as <strong>Website admin</strong>. <a
                style="background-color: #98CF2C;border-color: #fff;" class="btn btn-sm btn-danger"
                href="{{ route('dashboard') }}">Click Here For Admin Dashboard</a>
        </div>
    @endif
@endif
<div class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}"><img src="{{ asset($logo->img) }}" alt="img"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i class="fa-solid fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('consumers') }}">Consumers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('businesses') }}">Businesses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('sales.professionals') }}">Sales-professionals</a>
                    </li>
                    {{--            <li class="nav-item">--}}
                    {{--              <a class="nav-link active" aria-current="page" href="{{url('/')}}">HOME</a>--}}
                    {{--            </li>--}}
                    {{--            <li class="nav-item">--}}
                    {{--              <a class="nav-link" href="{{route('about_us')}}">ABOUT US</a>--}}
                    {{--            </li>--}}
                    {{--            <li class="nav-item">--}}
                    {{--              <a class="nav-link" href="{{route('rent')}}">RENT</a>--}}
                    {{--            </li>--}}
                    {{--            <li class="nav-item">--}}
                    {{--              <a class="nav-link" href="{{route('reviews')}}">REVIEWS</a>--}}
                    {{--            </li>--}}
                </ul>
                <span class="nav_flex">
@if(Auth::check())
                        <span class="nav_glass">
              <a href="{{route('signout')}}">Logout</a>
</span>
                    @else
                        <span class="nav_glass">
{{--              <a href="{{route('login')}}">Login</a>--}}

              <a href="{{route('register')}}">Register</a>

</span>
                    @endif
            <span class="nav_user">
              <a href="#">Contact Us</a>
            </span>
          </span>

            </div>
        </div>
    </nav>
</div>
