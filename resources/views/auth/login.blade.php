@extends('web.layouts.main')
@section('content')
<section class="contact1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-8 col-lg-5 col-xxl-5 disc4 mt-3 mb-5">
                <div class="sign2" >
                    <h2>CUSTOMER ACCOUNT LOGIN</h2>
                </div>
                <form method="POST" action="{{ route('login') }}" class="row row-eq-height lockscreen  mt-5 mb-5">                        
                        @csrf
                            <div class="mb-3 form3 cont2">
                                <label for="emailaddress">{{ __('E-Mail Address') }}</label>
                                <input id="emailaddress" placeholder="Enter your email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form3 cont2">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
{{--
                            <div class="mb-3 form3 cont2">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="checkbox-signin">{{ __('Remember Me') }}</label>
                                </div>
                            </div>
--}}
                     <div class="mb-3 form3 cont2">
                     <div class="sign1">
                        <a href="{{ url('register') }}"> Don't have an account? Create an Account</a>
                    </div>
                                <button class="btn cont5 mt-3" type="submit"> Log In </button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</section>
@endsection