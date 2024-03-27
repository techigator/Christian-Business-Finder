<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="shortcut icon" href="{{ asset('public/uploads/logo/_2027741229_549912809.Group 1091.png') }}">
    <link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend_assets/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend_assets/css/HoldOn.css')}}" media="screen">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
          integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/css/bootstrap.min.css"
          integrity="sha512-NZ19NrT58XPK5sXqXnnvtf9T5kLXSzGQlVZL9taZWeTBtXoN3xIfTdxbkQh6QSoJfJgpojRqMfhyqBAAEeiXcA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.0/css/select2.min.css">

    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>

    @stack('css')
    <!-- new css-->
    @include('layouts.links') @yield('css')

    <style>
        .select2-container {
            box-sizing: border-box;
            display: block;
            margin: 0;
            position: relative;
            vertical-align: middle;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            box-sizing: border-box;
            list-style: none;
            margin: 0;
            padding: 0 5px 0.4rem;
            width: 100%;
        }

        [class*=sidebar-dark-] {
            background-color: #1e1e2d;
        }

        .sidebar {
            padding-top: 20%;
        }

        .brand-link {
            display: block;
            font-size: 1.25rem;
            line-height: 1.5;
            padding: 0.8125rem 0.5rem;
            transition: width .3s ease-in-out;
            white-space: nowrap;
            padding-bottom: 3rem;
        }

        .brand-link .brand-image {
            float: left;
            line-height: .8;
            margin-left: 0.8rem;
            margin-right: 0.5rem;
            margin-top: -3px;
            max-height: 43px;
            width: 13rem;
        }

        .nav-sidebar .nav-item > .nav-link {
            margin-bottom: 1.2rem;
        }

        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: .75em;
            font-weight: 700;
            line-height: 1;
            color: #000000 !important;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }

        .pagination {
            display: flex;
            justify-content: center;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            background-color: #D2B48C;
            color: #fff;
            border: 1px solid #D2B48C;
        }

        .pagination .page-link:hover {
            background-color: #8B4513;
        }

        .pagination .page-link:focus {
            background-color: #8B4513;
        }

        .pagination .page-item.active .page-link {
            background-color: #8B4513;
            border: 1px solid #8B4513;
        }

        .pagination .page-item.disabled .page-link {
            background-color: #f3f3f3;
            color: #666;
            cursor: not-allowed;
        }

        .card-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .welcome-text {
            font-size: 24px;
            font-weight: 500;
            color: #333;
            margin-bottom: 10px;
        }

        .dashboard-title {
            font-size: 30px;
            font-weight: 600;
            color: #1e1e2d;
        }

        .dashboard-description {
            font-size: 18px;
            font-weight: 500;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
            text-align: center;
        }

        .app-container {
            padding: 20px;
        }

        .app-toolbar {
            background-color: #007bff;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .app-content {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        #chatBox {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            height: 400px;
            border: 1px solid #ccc;
            overflow-y: auto;
            display: none;
        }

        #chatMessages {
            padding: 10px;
        }

        #messageForm {
            position: fixed;
            bottom: 0;
            right: 20px;
            width: 300px;
            padding: 10px;
            background-color: #f1f1f1;
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
    <?php

    use App\Models\logo;
    use App\Models\setting;

    $logo = logo::find(1);
    $setting = setting::find(1);
    ?>
        <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset($logo->img)}}" alt="AdminLTELogo">
    </div>

    <!-- Navbar -->

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        {{--
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{url('admin/dashboard')}}" class="nav-link">Home</a>
          </li>
        </ul>
    --}}
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <!-- Navbar Search -->
            <li class="nav-item">
                {{--
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                  <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                  <form class="form-inline">
                    <div class="input-group input-group-sm">
                      <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                      <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                          <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                --}}
            </li>

            <li class="nav-item">
                {{--
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                  <i class="fas fa-expand-arrows-alt"></i>
                </a>
                --}}
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">

                    {{--
                      <i class="fas fa-th-large"></i>
                    --}}
                </a>

            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ url('dashboard') }}" class="brand-link">
            <img src="{{ asset($logo->img) }}" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light"></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- Sidebar user (optional) -->
            <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/backend_assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Administrator</a>
        </div>
      </div> -->

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                {{--
                  <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                      <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                      </button>
                    </div>
                  </div>
                --}}
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="{{ url('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>


                    @if(\Illuminate\Support\Facades\Auth::user()->type === 'admin')
                        {{--<li class="nav-item">
                          <a href="{{ url('/') }}" class="nav-link">
                            <i class="nav-icon fa fa-globe"></i>
                            <p>
                              Website
                            </p>
                          </a>
                        </li>--}}
                        <li class="nav-item">
                            <a href="{{ route('logo_index') }}" class="nav-link">
                                <i class="nav-icon far fa-image"></i>
                                <p>
                                    Logo
                                </p>
                            </a>
                        </li>
                        {{--<li class="nav-item">
                          <a href="{{ route('banner_index') }}" class="nav-link">
                            <i class="nav-icon far fa-image"></i>
                            <p>
                              Banner
                            </p>
                          </a>
                        </li>--}}
                        <li class="nav-item">
                            <a href="{{route('category_index')}}" class="nav-link">
                                <i class="nav-icon far fa-image"></i>
                                <p>
                                    Category
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('business.index')}}" class="nav-link">
                                <i class="nav-icon far fa-building"></i>
                                <p>
                                    Business
                                </p>
                            </a>
                        </li>

                        <!-- <li class="nav-item">
            <a href="{{ route('cms_index') }}" class="nav-link">
              <i class="nav-icon fa fa-newspaper"></i>
              <p>
                CMS
              </p>
            </a>
          </li> -->
                        <li class="nav-item">
                            <a href="{{ route('testimonials_index') }}" class="nav-link">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Testimonials
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('setting_index') }}" class="nav-link">
                                <i class="nav-icon fa fa-wrench"></i>
                                <p>
                                    Setting
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{route('business.sales.index')}}" class="nav-link">
                                <i class="nav-icon far fa-building"></i>
                                <p>
                                    Business
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.sales.index') }}" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a href="{{route('signout')}}" class="nav-link">
                            <i class="nav-icon fa fa-power-off fa-lg"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </li>
                    {{--
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="nav-icon fas fa-chart-pie"></i>
                                  <p>
                                    Charts
                                    <i class="right fas fa-angle-left"></i>
                                  </p>
                                </a>
                                <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                    <a href="../charts/chartjs.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>ChartJS</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../charts/flot.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Flot</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../charts/inline.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Inline</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../charts/uplot.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>uPlot</p>
                                    </a>
                                  </li>
                                </ul>
                              </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="nav-icon fas fa-tree"></i>
                                  <p>
                                    UI Elements
                                    <i class="fas fa-angle-left right"></i>
                                  </p>
                                </a>
                                <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                    <a href="../UI/general.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>General</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../UI/icons.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Icons</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../UI/buttons.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Buttons</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../UI/sliders.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Sliders</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../UI/modals.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Modals & Alerts</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../UI/navbar.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Navbar & Tabs</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../UI/timeline.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Timeline</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../UI/ribbons.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Ribbons</p>
                                    </a>
                                  </li>
                                </ul>
                              </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="nav-icon fas fa-edit"></i>
                                  <p>
                                    Forms
                                    <i class="fas fa-angle-left right"></i>
                                  </p>
                                </a>
                                <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                    <a href="../forms/general.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>General Elements</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../forms/advanced.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Advanced Elements</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../forms/editors.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Editors</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../forms/validation.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Validation</p>
                                    </a>
                                  </li>
                                </ul>
                              </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="nav-icon fas fa-table"></i>
                                  <p>
                                    Tables
                                    <i class="fas fa-angle-left right"></i>
                                  </p>
                                </a>
                                <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                    <a href="../tables/simple.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Simple Tables</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../tables/data.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>DataTables</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../tables/jsgrid.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>jsGrid</p>
                                    </a>
                                  </li>
                                </ul>
                              </li>
                              <li class="nav-header">EXAMPLES</li>
                              <li class="nav-item">
                                <a href="../calendar.html" class="nav-link">
                                  <i class="nav-icon far fa-calendar-alt"></i>
                                  <p>
                                    Calendar
                                    <span class="badge badge-info right">2</span>
                                  </p>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a href="../gallery.html" class="nav-link">
                                  <i class="nav-icon far fa-image"></i>
                                  <p>
                                    Gallery
                                  </p>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a href="../kanban.html" class="nav-link">
                                  <i class="nav-icon fas fa-columns"></i>
                                  <p>
                                    Kanban Board
                                  </p>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="nav-icon far fa-envelope"></i>
                                  <p>
                                    Mailbox
                                    <i class="fas fa-angle-left right"></i>
                                  </p>
                                </a>
                                <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                    <a href="../mailbox/mailbox.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Inbox</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../mailbox/compose.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Compose</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../mailbox/read-mail.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Read</p>
                                    </a>
                                  </li>
                                </ul>
                              </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="nav-icon fas fa-book"></i>
                                  <p>
                                    Pages
                                    <i class="fas fa-angle-left right"></i>
                                  </p>
                                </a>
                                <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                    <a href="../examples/invoice.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Invoice</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/profile.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Profile</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/e-commerce.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>E-commerce</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/projects.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Projects</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/project-add.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Project Add</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/project-edit.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Project Edit</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/project-detail.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Project Detail</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/contacts.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Contacts</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/faq.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>FAQ</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/contact-us.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Contact us</p>
                                    </a>
                                  </li>
                                </ul>
                              </li>
                              <li class="nav-item menu-open">
                                <a href="#" class="nav-link active">
                                  <i class="nav-icon far fa-plus-square"></i>
                                  <p>
                                    Extras
                                    <i class="fas fa-angle-left right"></i>
                                  </p>
                                </a>
                                <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                    <a href="#" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>
                                        Login & Register v1
                                        <i class="fas fa-angle-left right"></i>
                                      </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                        <a href="../examples/login.html" class="nav-link">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Login v1</p>
                                        </a>
                                      </li>
                                      <li class="nav-item">
                                        <a href="../examples/register.html" class="nav-link">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Register v1</p>
                                        </a>
                                      </li>
                                      <li class="nav-item">
                                        <a href="../examples/forgot-password.html" class="nav-link">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Forgot Password v1</p>
                                        </a>
                                      </li>
                                      <li class="nav-item">
                                        <a href="../examples/recover-password.html" class="nav-link">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Recover Password v1</p>
                                        </a>
                                      </li>
                                    </ul>
                                  </li>
                                  <li class="nav-item">
                                    <a href="#" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>
                                        Login & Register v2
                                        <i class="fas fa-angle-left right"></i>
                                      </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                        <a href="../examples/login-v2.html" class="nav-link">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Login v2</p>
                                        </a>
                                      </li>
                                      <li class="nav-item">
                                        <a href="../examples/register-v2.html" class="nav-link">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Register v2</p>
                                        </a>
                                      </li>
                                      <li class="nav-item">
                                        <a href="../examples/forgot-password-v2.html" class="nav-link">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Forgot Password v2</p>
                                        </a>
                                      </li>
                                      <li class="nav-item">
                                        <a href="../examples/recover-password-v2.html" class="nav-link">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Recover Password v2</p>
                                        </a>
                                      </li>
                                    </ul>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/lockscreen.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Lockscreen</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/legacy-user-menu.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Legacy User Menu</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/language-menu.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Language Menu</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/404.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Error 404</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/500.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Error 500</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/pace.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Pace</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../examples/blank.html" class="nav-link active">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Blank Page</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../../starter.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Starter Page</p>
                                    </a>
                                  </li>
                                </ul>
                              </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="nav-icon fas fa-search"></i>
                                  <p>
                                    Search
                                    <i class="fas fa-angle-left right"></i>
                                  </p>
                                </a>
                                <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                    <a href="../search/simple.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Simple Search</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="../search/enhanced.html" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Enhanced</p>
                                    </a>
                                  </li>
                                </ul>
                              </li>
                              <li class="nav-header">MISCELLANEOUS</li>
                              <li class="nav-item">
                                <a href="../../iframe.html" class="nav-link">
                                  <i class="nav-icon fas fa-ellipsis-h"></i>
                                  <p>Tabbed IFrame Plugin</p>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a href="https://adminlte.io/docs/3.1/" class="nav-link">
                                  <i class="nav-icon fas fa-file"></i>
                                  <p>Documentation</p>
                                </a>
                              </li>
                              <li class="nav-header">MULTI LEVEL EXAMPLE</li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="fas fa-circle nav-icon"></i>
                                  <p>Level 1</p>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="nav-icon fas fa-circle"></i>
                                  <p>
                                    Level 1
                                    <i class="right fas fa-angle-left"></i>
                                  </p>
                                </a>
                                <ul class="nav nav-treeview">
                                  <li class="nav-item">
                                    <a href="#" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Level 2</p>
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a href="#" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>
                                        Level 2
                                        <i class="right fas fa-angle-left"></i>
                                      </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                      <li class="nav-item">
                                        <a href="#" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Level 3</p>
                                        </a>
                                      </li>
                                      <li class="nav-item">
                                        <a href="#" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Level 3</p>
                                        </a>
                                      </li>
                                      <li class="nav-item">
                                        <a href="#" class="nav-link">
                                          <i class="far fa-dot-circle nav-icon"></i>
                                          <p>Level 3</p>
                                        </a>
                                      </li>
                                    </ul>
                                  </li>
                                  <li class="nav-item">
                                    <a href="#" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Level 2</p>
                                    </a>
                                  </li>
                                </ul>
                              </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="fas fa-circle nav-icon"></i>
                                  <p>Level 1</p>
                                </a>
                              </li>
                              <li class="nav-header">LABELS</li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="nav-icon far fa-circle text-danger"></i>
                                  <p class="text">Important</p>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="nav-icon far fa-circle text-warning"></i>
                                  <p>Warning</p>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a href="#" class="nav-link">
                                  <i class="nav-icon far fa-circle text-info"></i>
                                  <p>Informational</p>
                                </a>
                              </li>
                    --}}
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('page_heading')</h1>
                    </div>
                    <div class="col-sm-6">
                        @yield('breadcrumb')
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @section('content')
            @show
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer text-center">
        <!-- <div class="float-right d-none d-sm-block">
          <b>Version</b> 3.1.0
        </div> -->
        <strong>Copyright &copy; {{date('Y')}}
            <a href="" style="color: #869099;">{{$setting->company}}</a>.
        </strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>


<div id="chatBox">
    <div id="chatMessages"></div>
</div>

<div id="messageForm">
    <form id="sendMessageForm">
        <input type="hidden" name="sender_id" value="1">
        <input type="hidden" name="recipient_id" value="39">
        <input type="text" name="message" placeholder="Type your message...">
        <button type="submit">Send</button>
    </form>
</div>

<button id="chatToggle">Open Chat</button>

<script src="{{asset('assets/backend_assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/dist/js/demo.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.0/tinymce.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.0/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>


@include('layouts.scripts') @yield('js')
<script>
    $(document).ready(function () {
        $('#chatToggle').on('click', function () {
            $('#chatBox').toggle();
        });

        $('#sendMessageForm').submit(function (e) {
            e.preventDefault();

            var sender_id = $('input[name="sender_id"]').val();
            var recipient_id = $('input[name="recipient_id"]').val();
            var message = $('input[name="message"]').val();

            console.log(
                'sender_id', sender_id,
                'recipient_id', recipient_id,
                'message', message,
            )

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                cache: false,
                dataType: 'json',
                url: '{{ route("send.message") }}',
                data: {
                    message: message,
                    sender_id: sender_id,
                    recipient_id: recipient_id,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function (result) {
                    if (result.response_code == 1) {
                        alert("Message has been sent");
                    } else {
                        alert("Fail to send message");
                    }

                },
                error: function () {
                    alert("Something went wrong please try again later");
                }
            });
        });
    });
</script>
<script>
    var start = moment().subtract(29, "days");
    var end = moment();

    function cb(start, end) {
        $("#kt_daterangepicker_4").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
    }

    $("#kt_daterangepicker_4").daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            "Today": [moment(), moment()],
            "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
            "Last 7 Days": [moment().subtract(6, "days"), moment()],
            "Last 30 Days": [moment().subtract(29, "days"), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf(
                "month")]
        }
    }, cb);

    cb(start, end);
</script>
<script>
    @if(session('SUCCESS'))
    toastr.success("{{session('SUCCESS')}}");
    @endif
    @if(session('ERROR'))
    toastr.error("{{session('ERROR')}}")
    @endif

    $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
        // console.log("Main.js Prefilter: ", options);
        var token;
        if (!options.crossDomain) {
            token = $('meta[name="_token"]').attr('content');
            if (token) {
                jqXHR.setRequestHeader('X-CSRF-Token', token);
                jqXHR.setRequestHeader('Developed-By', "Shahzad Nawaz");
            }
        }
    });

</script>

@stack('scripts')
</body>
</html>
