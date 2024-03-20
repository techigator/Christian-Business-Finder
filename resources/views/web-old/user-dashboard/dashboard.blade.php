@extends('web.layouts.main')
@section('content')
<section class="dash1">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 dash2" data-aos="zoom-in" data-aos-duration="1500">
                <h2>Dashboard</h2>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xxl-12 dashboard2">
                <div class="dashboard-container">
                    @include('web.user-dashboard.sidebar')
                    <div class="content-container">
                        <h2>Hello {{Auth::user()->name}}</h2>
                        <p>From your account dashboard you can view your <strong>Personalized Your store,</strong> Order History <strong>Account Setting,</strong> and <strong>Privacy Setting.</strong> </p>
                        <div class="wd-my-account-links">
                            <div class="dashboard-link">
                                <a href="{{route('user_dashboard')}}">Dashboard</a>
                            </div>
                            <div class="orders-link">
                                <a href="{{route('user_form')}}"><i class="fa-sharp fa-solid fa-house-chimney" style="color: #98CF2C;"></i> <br> <br> Personalized Your Product</a>
                            </div>
                            <div class="downloads-link">
                                <a href="{{route('user_order')}}"><i class="fa-sharp fa-solid fa-clock-rotate-left" style="color: #98CF2C;"></i> <br> <br> Order History </a>
                            </div>
                            <div class="edit-address-link">
                                <a href="{{route('user_account')}}"><i class="fa-sharp fa-regular fa-house-user" style="color: #98CF2C;"></i> <br> <br> Account Setting </a>
                            </div>
                            <div class="edit-account-link">
                                <a href="#"><i class="fa-solid fa-shield-check" style="color: #98CF2C;"></i> <br> <br> Privacy Setting</a>
                            </div>
                            <div class="customer-logout-link">
                                <a href="{{route('signout')}}"><i class="fa-solid fa-right-from-bracket" style="color: #98CF2C;"></i> <br> <br> Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div>
    <a id="button" class="my-button"></a>
</div>

@endsection
@section('css')
@endsection
@section('js')
@endsection
