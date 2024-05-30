@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"><i class="far fa-long-arrow-left"></i></a></span>Christian Business Finder</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="categ-sect rest-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="categ-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="review-cont">
                                    <h2 class="sectionHeading">Fine Dining</h2>
                                    <h3><span><img src="{{ asset('assets-cbf-front/images/settingImg.png') }}" class="img-fluid" alt=""></span> Services</h3>
                                    <h4>
                                        4.1
                                        <span>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </span>
                                        (23)
                                    </h4>
                                    <a href="javascript:;" class="themeBtn">Direction</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="map-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="mapCont">
                        <figure>
                            <img src="{{ asset('assets-cbf-front/images/map-1.jpg') }}" class="img-fluid" alt="">
                            <div class="overlay">
                                <div class="locationCont">
                                    <h6>Fine Dining</h6>
                                    <img src="{{ asset('assets-cbf-front/images/loc.png') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
