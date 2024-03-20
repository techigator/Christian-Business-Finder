@extends('web.layouts.main')
@section('content')

    {{--<div class="loader">--}}
    {{--    <div class="loader-inner"> <img src="{{asset($logo->img)}}" class="img-fluid" alt="img"></div>--}}
    {{--</div>--}}

    <section class="bannar1">
        <div class="container">
            <div class="row align-items-center bannar3">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 bannar2" data-aos="fade-down"
                     data-aos-duration="1500">
                    <?php echo html_entity_decode($banner['details']) ?>

                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                    <div class="bannar4">
                        <img src="https://fortmyers.floridaweekly.com/wp-content/uploads/images/2020-04-08/15p1.jpg" class="img-fluid tophover" alt="img">

                        <img src="https://guardian.ng/wp-content/uploads/2017/04/Good-Friday.jpg" class="img-fluid hoverbody" alt="img">

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="useful1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6" data-aos="fade-down-right"
                     data-aos-duration="1500">
                    <img src="https://consumer.gov.au/sites/consumer/files/inline-images/home-page-nov23_2.jpg"
                         class="img-fluid your-element" data-tilt alt="img">
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 useful2" data-aos="fade-down-left"
                     data-aos-duration="1500">
                    <h1>Consumers</h1>
                    <strong>Benefits of signing up with Christian Business Finder:</strong>

                    <div class="bannar5 mt-3">
                        {{--                    <span class="nav_glass1">--}}
                        {{--                        <a href="#">Login</a>--}}
                        {{--                    </span>--}}
                        <span class="nav_user1">
                        <a href="{{ route('register') }}">Register</a>
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mobile1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mobile2" data-aos="fade-right"
                     data-aos-duration="1500">
                    <h1>Businesses</h1>
                    <strong>Benefits of listing your business on Christian Business Finder:</strong>

                    <div class="bannar5 mt-3">
                        {{--                    <span class="nav_glass1">--}}
                        {{--                        <a href="#">Login</a>--}}
                        {{--                    </span>--}}
                        {{--                    <span class="nav_user1">--}}
                        {{--                        <a href="#">Contact Us</a>--}}
                        {{--                    </span>--}}
                        <span class="nav_user1">
                        <a href="{{ route('register') }}">Register</a>
                    </span>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6" data-aos="fade-left"
                     data-aos-duration="1500">
                    <img
                        src="https://media.istockphoto.com/id/1159740443/photo/business-and-communication-network-concept-business-partnership-concept.jpg?s=612x612&w=0&k=20&c=P8cSJRshDMLPUjK-IwpVkBStO-jKbfzXZycNbwWWDHs="
                        class="img-fluid your-element" data-tilt alt="img">
                </div>


            </div>
        </div>
    </section>

    <section class="every1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6" data-aos="fade-up-right"
                     data-aos-duration="1500">
                    <img
                        src="https://static.vecteezy.com/system/resources/thumbnails/005/442/700/small/sales-growth-man-clicks-inscription-on-virtual-3d-screen-photo.jpg"
                        class="img-fluid your-element" data-tilt alt="img">
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 every2" data-aos="fade-up-left"
                     data-aos-duration="1500">
                    <h1>Sales & Service Professionals</h1>
                    <strong>Benefits of joining Christian Business Finder as a sales or service professional:</strong>

                    <div class="bannar5 mt-3">
                        {{--                    <span class="nav_glass1">--}}
                        {{--                        <a href="#">Login</a>--}}
                        {{--                    </span>--}}
                        {{--                    <span class="nav_user1">--}}
                        {{--                        <a href="#">Contact Us</a>--}}
                        {{--                    </span>--}}
                        <span class="nav_user1">
                        <a href="{{ route('register') }}">Register</a>
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{--<section class="product1">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <h2 class="product2" data-aos="zoom-in">Find Your Needs</h2>
                    <div class="row row-cols-1 row-cols-md-5 row-cols-lg-5 row-cols-xl-5 row-cols-xxl-5 g-2 g-lg-3 mt-5 mb-5">
                        @foreach($prd_data as $prd_datas)
                        <div class="col product7 mt-5">
                            <img src="{{asset('assets/uploads/product/'.$prd_datas->image1)}}" class="img-fluid" alt="img">

                            <div class="product6">
                                <div class="product3">
                                    <h6>{{$prd_datas->name}}</h6>
                                    <p>${{$prd_datas->price}}</p>
                                </div>
                                @if($prd_datas->availability==1)
                                <p class="product4 text-success">Available for Rent</p>
                                @else
                                <p class="product4 text-danger">Not Available for Rent</p>
                                @endif

                                <div class="product5">
                                    <span class="nav_glass2">
                                        <a href="{{route('product_request',$prd_datas->id)}}">Rent Now</a>
                                    </span>
                                    <span class="nav_user2">
                                        <a href="{{route('product_details',$prd_datas->id)}}">View</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="car1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 car2" data-aos="flip-up" data-aos-duration="1500">
                    <h1>Make Your Things <br> Useful For Everyone!</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do <br> eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut <br> enim ad minim veniam</p>

                    <div class="bannar5">
                        <span class="nav_glass1">
                            <a href="#">Login</a>
                        </span>
                        <span class="nav_user1">
                            <a href="#">Contact Us</a>
                        </span>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6" data-aos="flip-down" data-aos-duration="1500">
                    <img src="{{asset('web/images/pic8.png')}}" class="img-fluid your-element" data-tilt alt="img">
                </div>


            </div>
        </div>
    </section>--}}
    <!-- Testimonials Section Start -->
    @include('web.layouts.testimonials')
    <!-- Testimonials Section End -->
    <div>
        <a id="button" class="my-button"></a>
    </div>
@endsection
@section('css')
@endsection
@section('js')
@endsection
