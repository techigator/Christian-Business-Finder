@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>Contact Us</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="categ-content">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="cnt-content">
                                    <h2 class="sectionHeading">Get in Touch with us</h2>
                                    <ul>
                                        <li>
                                            <a>
                                                <span>
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </span>
                                                <span>
                                                    <h4>Address</h4>
                                                    <p>{{ $setting->address ?? '' }}</p>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="tel:{{ $setting->phone ?? '' }}">
                                                <span>
                                                    <i class="fas fa-phone-alt"></i>
                                                </span>
                                                <span>
                                                    <h4>Phone</h4>
                                                    <p>{{ $setting->phone ?? '' }}</p>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="mailto:{{ $setting->email ?? '' }}">
                                                <span>
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                                <span>
                                                    <h4>Email</h4>
                                                    <p>{{ $setting->email ?? '' }}</p>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="check-form">

                                    <form action="{{ route('front.contact.submit') }}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md">
                                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="First name">
                                                @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-md">
                                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Last name">
                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter Your Email">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" placeholder="Phone Number">
                                                @error('phone_number')
                                                <span class="invalid-feedback my-2" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <textarea class="form-control @error('message') is-invalid @enderror" id="exampleFormControlTextarea1" name="message" placeholder="Message" rows="3"></textarea>
                                                @error('message')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="formBtn">
                                                    <button type="submit" class="themeBtn">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
