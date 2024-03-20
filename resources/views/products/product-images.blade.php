@extends('layouts.main')
@section('content')

    <!-- =============== Left side End ================-->
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <!-- ============ Body content start ============= -->
        <div class="main-content">
            {{--
        <div class="breadcrumb">
            <h1 class="mr-2">{{Auth::user()->name}}</h1>
            <ul>
                <li><a href="javascript:void(0)">  Product Listing Dashboard</a></li>
            </ul>
        </div>
            --}}
            <div class="separator-breadcrumb border-top"></div>
            <!-- product listing Start   -->
            <main>
                <div class="container-fluid site-width">
                    <!-- START: Breadcrumbs-->
                    <div class="row">
                        <div class="col-12 align-self-center">
                            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                                <div class="w-sm-100 mr-auto">
                                    <h4 class="mb-0"> Product Listing</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Breadcrumbs-->
                    <!-- START: Card Data-->
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <!-- <h2>Laravel 8 CRUD Example from scratch - ItSolutionStuff.com</h2> -->
                            </div>
                            <div class="pull-right text-right p-2">

                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block"><button type="button" class="close"
                                data-dismiss="alert">×</button><strong>{{ $message }}</strong></div>
                    @endif


                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="row justify-content-center">
                                <div class="col-lg-6">
                                    <div class="form-box p-4 bg-dark" style="border-radius:30px;">
                                        <h6 class="py-4 text-center text-info">Add Images</h6>
                                        <form action="{{ route('images_store', $product->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <input type="text" name="name" value="{{ $product->name }}"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="file" name="img1" class="form-control">
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="file" name="img2" class="form-control">
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="file" name="img3" class="form-control">
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-success w-25 text-dark">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped">
                                <thead>
                                    <th>id</th>
                                    <th>Product title</th>
                                    <th>img1</th>
                                    <th>img2</th>
                                    <th>img3</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- END: Card DATA-->
                </div>
            </main>
            <!-- product listing end   -->
            <!-- end of row-->
            <!-- end of main-content -->
        </div>
        <!-- Footer Start -->
        <div class="flex-grow-1 mb-5"></div>
        {{--
    <div class="app-footer">
        <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
            <span class="flex-grow-1"></span>
            <div class="d-flex align-items-center">
                <img class="logo" src="{{asset($logo)}}" alt="" />
                <div>
                    <p class="m-0">
                        Copyrights © {{date('Y')}}
                        <?= $config['COMPANY'] ?>
                    </p>
                    <p class="m-0">All rights reserved</p>
                </div>
            </div>
        </div>
                    --}}
    </div>

    <!-- fotter end -->
    </div>
    <br>
    <br>
@endsection






@section('css')
    <script src="{{ asset('vendors/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script>
    <link href="{{ asset('vendors/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <style>
        .dropdown-item.active,
        .dropdown-item:active {
            color: #fff !important;
            text-decoration: none;
            background-color: #17b2a2;
        }

        .flex-btn {
            display: flex;
        }

        .btn-group span {
            text-transform: capitalize;
        }

        div#example_filter {
            float: right;
        }

        .form-delete {
            margin: 0;

        }

        .toggle-group .btn-success {
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
    <style>
        .dropdown-item.active,
        .dropdown-item:active {
            color: #fff !important;
            text-decoration: none;
            background-color: #17b2a2;
        }

        .flex-btn {
            display: flex;
        }

        .btn-group span {
            text-transform: capitalize;
        }

        div#example_filter {
            float: right;
        }

        .form-delete {
            margin: 0;

        }

        .toggle-group .btn-success {
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
        }

        body {
            background-color: gray;
        }

        * {
            font-family: Arial, Helvetica, san-serif;
        }

        .row:after,
        .row:before {
            content: " ";
            display: table;
            clear: both;
        }

        .span6 {
            float: left;
            width: 48%;
            padding: 1%;
        }

        .emojionearea-standalone {
            float: right;
        }

        .divOutside {
            height: 20px;
            width: 20px;
            background-position: -1px -26px;
            background-repeat: no-repeat;
            background-image: url(data:image/png;base64,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);
        }

        .emojionearea-button {
            opacity: 1 !important;
        }
    </style>

@section('link')
    <link rel="stylesheet" href="{{ asset('vendors/datatable/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/datatable/buttons/css/buttons.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/x-editable/css/bootstrap-editable.css') }}" />
    <link rel="stylesheet" href="{{ asset('web/css/emojionearea.min.css') }}" />

@endsection


@section('script')
    <!-- END: Template JS-->
    <script src="{{ asset('vendors/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatable/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/datatable/buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendors/x-editable/js/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('js/xeditable.script.js') }}"></script>
    <script src="{{ asset('vendors/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendors/datatable/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('vendors/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendors/datatable/buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('vendors/datatable/buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendors/datatable/buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/datatable/buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/datatable.script.js') }}"></script>
    <script src="{{ asset('web/js/emojionearea.js') }}"></script>
@endsection


@section('js')

    <script src="{{ asset('admin/vendors/ckeditor/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/vendors/js/lazyload-min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var lazyloadImages = document.querySelectorAll("img.lazy");
            var lazyloadThrottleTimeout;

            function lazyload() {
                if (lazyloadThrottleTimeout) {
                    clearTimeout(lazyloadThrottleTimeout);
                }
                lazyloadThrottleTimeout = setTimeout(function() {
                    var scrollTop = window.pageYOffset;
                    lazyloadImages.forEach(function(img) {
                        if (img.offsetTop < (window.innerHeight + scrollTop)) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                        }
                    });
                    if (lazyloadImages.length == 0) {
                        document.removeEventListener("scroll", lazyload);
                        window.removeEventListener("resize", lazyload);
                        window.removeEventListener("orientationChange", lazyload);
                    }
                }, 20);
            }
            document.addEventListener("scroll", lazyload);
            window.addEventListener("resize", lazyload);
            window.addEventListener("orientationChange", lazyload);
        });
    </script>

@endsection
