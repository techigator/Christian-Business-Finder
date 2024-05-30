@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>Change
                            Password</h2>
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
                                        <h2 class="sectionHeading">Make New Password</h2>
                                        <form action="{{ route('front.change.password.submit') }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="email" name="email" class="form-control"
                                                           placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input
                                                        id="password"
                                                        :type="showChangePassword ? 'text' : 'password'"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password"
                                                        required
                                                        autocomplete="new-password"
                                                        placeholder="New Password"
                                                    />
                                                    <button
                                                        type="button"
                                                        class="flex absolute inset-y-0 right-0 items-center pr-3"
                                                        @click="togglePasswordVisibility"
                                                    >
                                                        <i aria-hidden="true" class="fa fa-eye"
                                                           v-if="showChangePassword"></i>
                                                        <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input
                                                        id="password-confirm"
                                                        :type="showChangeConfirmPassword ? 'text' : 'password'"
                                                        class="form-control"
                                                        name="password_confirmation"
                                                        required
                                                        autocomplete="new-password"
                                                        placeholder="Confirm Password"
                                                    />
                                                    <button
                                                        type="button"
                                                        class="flex absolute inset-y-0 right-0 items-center pr-3"
                                                        @click="confirmTogglePasswordVisibility"
                                                    >
                                                        <i aria-hidden="true" class="fa fa-eye"
                                                           v-if="showChangeConfirmPassword"></i>
                                                        <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                    </button>
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
        </div>
    </section>

@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                showChangePassword: false,
                showChangeConfirmPassword: false,
            },
            methods: {
                togglePasswordVisibility() {
                    this.showChangePassword = !this.showChangePassword;
                },
                confirmTogglePasswordVisibility() {
                    this.showChangeConfirmPassword = !this.showChangeConfirmPassword;
                },
            },
        });
    </script>
@endsection
