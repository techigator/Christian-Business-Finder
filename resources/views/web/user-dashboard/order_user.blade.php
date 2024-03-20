@extends('web.layouts.main')
@section('content')
<section class="dash1">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 dash2" data-aos="zoom-in" data-aos-duration="1500">
                <h2>Order History</h2>
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
                        <div class="history1">
                            <div>
                                <img src="{{asset('web/images/pic17.jpg')}}" class="img-fluid" alt="img">
                            </div>
                            <div class="history2">
                                <h2>Purpal Iphone</h2>
                                <p>$10 Per Hour</p>
                                <p>Need For 48 Hour</p>
                                <h6>Total Rent: $480.00</h6>
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

