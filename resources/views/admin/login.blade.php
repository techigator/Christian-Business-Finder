<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php

    use App\Models\setting;

    $setting = setting::find(1);
    ?>
    <title>{{$setting->company}} | Log in</title>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/backend_assets/dist/css/adminlte.min.css')}}">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/toastr/toastr.min.css')}}">

    <style>
        .card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #1e1e2d;
            color: #fff;
        }

        .card-header a {
            text-decoration: none;
            color: #fff;
        }

        .card-body {
            padding: 20px;
        }

        .login-box-msg {
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control {
            border: 1px solid #d1d3e2;
            border-radius: 5px;
            padding: 10px;
        }

        .input-group-text {
            background-color: #f4f6f9;
            border: 2px solid #d1d3e2;
            border-radius: 5px;
            color: #333;
        }

        .btn-dark {
            background-color: #1e1e2d;
            color: #fff;
            border: 2px solid #1e1e2d;
            border-radius: 5px;
            padding: 10px;
            font-weight: bold;
            transition: background-color 0.2s;
        }

        .btn-dark:hover {
            color: #1e1e2d;
            background: none;
            border: 2px solid #1e1e2d;
        }

        .btn-dark:active {
            color: #1e1e2d;
            background-color: #fff;
            border-color: #fff;
        }

        .admin-user-password {
            outline: none;
            box-shadow: none;
            background: none;
            border: none;
            position: relative;
            top: -0.1rem;
        }
    </style>
</head>
<body class="hold-transition login-page" style="min-height: 336px;backdrop-filter: brightness(0.4);">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card">
        <div class="card-header text-center">
            <a href="javascript:;" class="h1"><b>Admin</b> Panel</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg"><b>Christian Business Finder</b></p>

            <div id="app">
                <form action="{{ url('admin/loginsubmit') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input name="email" type="email" class="form-control
                    @error('email') is-invalid @enderror" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            class="form-control mt-2 mb-2 @error('password') is-invalid @enderror"
                            name="password"
                            required
                            autocomplete="password"
                            placeholder="********"
                        />
                        <button
                            type="button"
                            class="admin-user-password"
                            @click="togglePasswordVisibility"
                        >
                            <i aria-hidden="true" class="fa fa-eye"
                               v-if="showPassword"></i>
                            <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                        </button>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-dark btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('assets/backend_assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/backend_assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/backend_assets/dist/js/adminlte.min.js')}}"></script>

<!-- Toastr -->
<script src="{{asset('assets/backend_assets/plugins/toastr/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

<script type="text/javascript">
    @if(session('SUCCESS'))
        toastr.success("{{session('SUCCESS')}}");
    @endif

    @if(session('ERROR'))
        toastr.error("{{session('ERROR')}}")
    @endif

    new Vue({
        el: '#app',
        data: {
            showPassword: false
        },
        methods: {
            togglePasswordVisibility() {
                this.showPassword = !this.showPassword;
            }
        },
    });
</script>

</body>
</html>
