@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>About Us</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-sect">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="aboutCont">
                        <figure>
                            <img src="{{ asset('assets-cbf-front/images/abImg.jpg') }}" class="img-fluid w-100" alt="">
                        </figure>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="aboutCont">
                        <h2 class="sectionHeading">About Us</h2>
                        <p>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed pariatur et optio facere, non eveniet quidem sapiente velit? Odit consequatur tenetur harum laboriosam nihil fugiat aliquid accusantium deleniti commodi ratione. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed pariatur et optio facere, non eveniet quidem sapiente velit? Odit consequatur tenetur harum laboriosam nihil fugiat aliquid accusantium deleniti commodi ratione. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed pariatur et optio facere, non eveniet quidem sapiente velit? Odit consequatur tenetur harum laboriosam nihil fugiat aliquid accusantium deleniti commodi ratione.
                        </p>
                        <p>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed pariatur et optio facere, non eveniet quidem sapiente velit? Odit consequatur tenetur harum laboriosam nihil fugiat aliquid accusantium deleniti commodi ratione.
                        </p>
                        <a href="javascript:;" class="themeBtn">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
