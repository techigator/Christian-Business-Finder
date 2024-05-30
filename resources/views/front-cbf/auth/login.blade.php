@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>Login</h2>
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
                                <div id="app">
                                    <div class="check-form">
                                        <h2 class="sectionHeading">Log In</h2>
                                        <form action="{{ route('front.login.submit') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input
                                                        id="password"
                                                        :type="showLoginPassword ? 'text' : 'password'"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password"
                                                        required
                                                        autocomplete="password"
                                                        placeholder="Password"
                                                    />
                                                    <button
                                                        type="button"
                                                        class="flex absolute inset-y-0 right-0 items-center pr-3"
                                                        @click="togglePasswordVisibility"
                                                    >
                                                        <i aria-hidden="true" class="fa fa-eye"
                                                           v-if="showLoginPassword"></i>
                                                        <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>Don't have an account yet?
                                                        <a href="{{ route('front.signup') }}" class="text-dark">
                                                            <strong>Sign up</strong>
                                                        </a>
                                                    </p>
                                                    <div class="formBtn">
                                                        <button type="submit" class="themeBtn">Login</button>
                                                        <a href="{{ route('front.forget.password') }}" class="forgotBtn">Forgot
                                                            Password</a>
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
        </div>
    </section>

@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                showLoginPassword: false
            },
            methods: {
                togglePasswordVisibility() {
                    this.showLoginPassword = !this.showLoginPassword;
                }
            },
        });
    </script>
@endsection
