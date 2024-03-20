<?php
use App\Models\setting;
$setting = setting::find(1);
?>
@extends('web.layouts.main')
@section('content')
<section class="cont1">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-5 col-lg-4 col-xl-4 cont2" data-aos="fade-right" data-aos-duration="1500">
                <h4>CONTACT NOW</h4>
                <h2>Asked us Anything </h2>
                <p>Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.</p>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-7 col-xl-7 cont2" data-aos="fade-left" data-aos-duration="1500">
                <form method="POST" action="{{route('contactusSubmit')}}">
                    @csrf
                    <div class="d-flex cont3">
                        <div class="mb-3 form3">   
                            <input type="text" class="form-control" required name="name" placeholder="Enter your Name" >
                        </div>

                        <div class="mb-3 form3">
                            <input required name="phonenumber"
                                onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control" placeholder="Enter your Phone no">
                        </div>
                    </div>
                    <div class="mb-3 form3 cont5">
                       
                        <input type="email" required name="email"  class="form-control" placeholder="Enter your Email">
                    </div>
                    <div class="mb-3 cont7">
                       
                        <textarea class="form-control" placeholder="Type here.." required name="message" id="exampleFormControlTextarea1" rows="20"></textarea>
                    </div>
                    <button class="btn cont6">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('css')
@endsection
@section('js')
@endsection