@extends('web.layouts.main')
@section('content')
    <?php
    use App\Models\logo;
    $logo = logo::find(1);
    ?>
<section class="dash1">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 dash2" data-aos="zoom-in" data-aos-duration="1500">
                <h2>Account Setting</h2>
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

                    <div class="content-container setting1">
                        <div class="setting2">
                            <a  href="{{url('/')}}" style="color: #ffffff!important;background-color: transparent!important;border: none!important;">
                                <img src="{{asset($logo->img)}}" class="img-fluid" alt="img">
                            </a>
                            <h2>Account Setting</h2>
                            <div class="mt-4">
                            <a href="{{route('user_account_info')}}" class="mb-5" style="padding: 10px 23px;">Account Information</a>
                            </div>
                             <div class="mt-5">
                            <a href="{{route('user_change_password')}}" class="mt-5 mb-5">Change Password</a>
                             </div>
                             {{--
                             <div class="mt-5">
                            <a href="Change.php" class="mt-5 mb-5">Change Password</a>
                             </div>
                             --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@section('css')
@endsection
@section('js')
@endsection
