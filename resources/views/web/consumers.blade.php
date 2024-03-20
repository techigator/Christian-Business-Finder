@extends('web.layouts.main')

@section('content')
    <section class="useful1">
        <div class="container mt-5">
            <div class="row align-items-center mt-5">
                <div class="consumer">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6" data-aos="fade-down-right"
                         data-aos-duration="1500"
                         style="display: flex;
                                margin: auto;
                                justify-content: center;">
                        <img src="https://consumer.gov.au/sites/consumer/files/inline-images/home-page-nov23_2.jpg"
                             alt="Consumer Image" class="img-fluid">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 useful2"
                         data-aos="fade-down-left" data-aos-duration="1500">
                        <h1>Consumers</h1>
                        <strong>Benefits of signing up with Christian Business Finder:</strong>

                        <div class="bannar5">
                            {{--                    <span class="nav_glass1">--}}
                            {{--                        <a href="#">Login</a>--}}
                            {{--                    </span>--}}
                            <span class="nav_user1">
                        <ul>
                            <li>Connect with trusted businesses</li>
                            <li>Receive exclusive offers</li>
                            <li>Access to Christian community events</li>
                        </ul>
                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
