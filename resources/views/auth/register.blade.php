@extends('web.layouts.main')
@section('content')
<section class="contact1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-8 col-lg-5 col-xxl-5 disc4 mt-3 mb-5">
                <div class="sign2" >
                    <h2>CUSTOMER ACCOUNT LOGIN</h2>
                </div>
              <form method="POST" action="{{ route('register') }}" class="row row-eq-height lockscreen  mt-5 mb-5">
                        @csrf
                        <div class="mb-3 form3 cont2">
                            <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="mb-3 form3 cont2">
                            <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="mb-3 form3 cont2">
                            <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="mb-3 form3 cont2">
                            <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        <div class="mb-3 form3 cont2">
                                <div class="sign1">
                        <a href="{{ url('login') }}">
                                        {{ __('Already have an account? Sign In') }}</a>
                    </div>
                                <button class="btn cont5 mt-3" type="submit">{{ __('Register') }}</button>
                        </div>
                    </form>  
            </div>
        </div>
    </div>
</section>
@endsection
@extends('web.layouts.main')
@section('content')
<section class="contact1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-8 col-lg-5 col-xxl-5 disc4 mt-3 mb-5">
                <div class="sign2" >
                    <h2>CUSTOMER ACCOUNT LOGIN</h2>
                </div>
              <form method="POST" action="{{ route('register') }}" class="row row-eq-height lockscreen  mt-5 mb-5">
                        @csrf
                        <div class="mb-3 form3 cont2">
                            <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="mb-3 form3 cont2">
                            <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="mb-3 form3 cont2">
                            <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="mb-3 form3 cont2">
                            <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        <div class="mb-3 form3 cont2">
                                <div class="sign1">
                        <a href="{{ url('login') }}">
                                        {{ __('Already have an account? Sign In') }}</a>
                    </div>
                                <button class="btn cont5 mt-3" type="submit">{{ __('Register') }}</button>
                        </div>
                    </form>  
            </div>
        </div>
    </div>
</section>
@endsection