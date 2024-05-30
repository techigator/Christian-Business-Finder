@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>Forget Password</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="signup-sect">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="categ-content">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-md-12">
                                <div class="check-form forgot-form">
                                    <h2 class="sectionHeading">Password Reset</h2>
                                    <p>
                                        You will receive email for resetting your password
                                    </p>
                                    <form action="{{ route('front.forget.submit') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md">
                                                <input type="email" name="email" class="form-control" placeholder="Enter Your Email">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="formBtn">
                                                    <button type="submit" class="themeBtn"><i class="fas fa-envelope"></i> Send</button>
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
