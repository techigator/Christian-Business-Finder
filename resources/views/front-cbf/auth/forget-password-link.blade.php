@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>Reset Password</h2>
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
                                    <div class="check-form forgot-form">
                                        <h2 class="sectionHeading">Password Reset</h2>
                                        <form action="{{ route('front.reset.submit') }}" method="POST"
                                              class="formStyle form-row"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="token" value="{{ $token }}">
                                            <div class="input-group email-input">
                                                <label>Email Address<em>*</em></label>
                                                <input type="text" class="form-control" name="email"
                                                       placeholder="Enter your Email or Mobile"
                                                       required>
                                                @if($errors->has('email'))
                                                    <p class="text-danger small">{{ $errors->first('email') }}</p>
                                                @endif
                                            </div>
                                            {{--<div class="input-group email-input">
                                                <label>Verification Code<em>*</em></label>
                                                <input type="number" class="form-control" name="token"
                                                       placeholder="******"
                                                       required>
                                                @if($errors->has('email'))
                                                    <p class="text-danger small">{{ $errors->first('email') }}</p>
                                                @endif
                                            </div>--}}
                                            <div class="input-group  password-input">
                                                <label>New password<em>*</em></label>
                                                <input
                                                    id="password"
                                                    :type="showNewResetPassword ? 'text' : 'password'"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password"
                                                    required
                                                    autocomplete="new-password"
                                                    placeholder="New Password"
                                                />
                                                <button
                                                    type="button"
                                                    class="reset-password inset-y-0 right-0 items-center pr-3"
                                                    @click="togglePasswordVisibility"
                                                >
                                                    <i aria-hidden="true" class="fa fa-eye"
                                                       v-if="showNewResetPassword"></i>
                                                    <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                </button>
                                                @if($errors->has('password'))
                                                    <p class="text-danger small">{{ $errors->first('password') }}</p>
                                                @endif
                                            </div>
                                            <div class="input-group confirm-input">
                                                <label>Password Confirmation<em>*</em></label>
                                                <input
                                                    id="password-confirm"
                                                    :type="showResetConfirmPassword ? 'text' : 'password'"
                                                    class="form-control"
                                                    name="password_confirmation"
                                                    required
                                                    autocomplete="new-password"
                                                    placeholder="Confirm Password"
                                                />
                                                <button
                                                    type="button"
                                                    class="reset-password inset-y-0 right-0 items-center pr-3"
                                                    @click="confirmTogglePasswordVisibility"
                                                >
                                                    <i aria-hidden="true" class="fa fa-eye"
                                                       v-if="showResetConfirmPassword"></i>
                                                    <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                </button>
                                            </div>
                                            <div class="input-group justify-content-sm-between align-items-sm-center">
                                                <button class="themeBtn rounded" type="submit">Submit</button>
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
                showNewResetPassword: false,
                showResetConfirmPassword: false,
            },
            methods: {
                togglePasswordVisibility() {
                    this.showNewResetPassword = !this.showNewResetPassword;
                },
                confirmTogglePasswordVisibility() {
                    this.showResetConfirmPassword = !this.showResetConfirmPassword;
                },
            },
        });
    </script>
@endsection
