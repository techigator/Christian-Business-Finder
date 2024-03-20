@extends('web.layouts.main')
@section('content')
<section class="view1">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 view2" data-aos="zoom-in" data-aos-duration="1500">
                <h2>Make Your Things <br> Useful For Everyone!</h2>
            </div>
        </div>
    </div>
</section>
<section class="view3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5 ">
                <img src="{{asset('web/images/pic7.png')}}" width="100%" class="img-fluid" alt="img">
            </div>
            <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7">
                <div class="view6">
                    <h6>Ankle Support Brace</h6>
                    <p>$40.25 per day</p>
                    <div class="view7">
                        <a href="#">Select Start Date</a>
                        <h5> May 25 2023, 10:50 AM </h5>
                    </div>

                    <div class="view8">
                        <a href="#">Select End Date</a>
                        <h5> May 26 2023, 10:50 AM </h5>
                    </div>

                    <div class="view9">
                        <a href="#">Select Pick Up Time</a>
                        <h5> May 25 2023, 10:50 AM </h5>
                    </div>

                    <div class="view10">
                        <h5>Total Rent: $40</h5>
                        <a href="#">Send Rent Request</a>
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