<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- START: Head-->
    <head>
        <meta charset="UTF-8" />
        <?php
use App\Models\products;
use App\Models\product_draft;
if(isset($_GET) && $_GET != []){
            if (isset($_GET['graphics-library'])){
                $graphics = products::where("is_active" , 1)->
        where('id' , $_GET['graphics-library'])->first(); $og_url=url('login').'?graphics-library='.$graphics->id; $og_type='Graphics Library'; $og_title=$graphics->name; $og_description=$graphics->details; $og_image=asset($graphics->img);
        }elseif (isset($_GET['draft-library'])) { $product_draft = product_draft::where('id' , $_GET['draft-library'])->first(); $graphics = products::where("is_active" , 1)->where('id' , $product_draft->product_id)->first();
        $og_url=url('login').'?draft-library='.$graphics->id; $og_type='Draft Library'; $og_title=$graphics->name; $og_description=$product_draft->caption; $og_image=asset($graphics->img); } else{ } } ?>
        <title>{{isset($title)?$title:'Taskboard'}}</title>
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="{{isset($og_url)?$og_url:''}}" />
        <meta name="twitter:creator" content="{{isset($og_title)?$og_title:''}}" />
        <meta property="og:url" content="{{isset($og_url)?$og_url:''}}" />
        <meta property="og:type" content="{{isset($og_type)?$og_type:''}}" />
        <meta property="og:title" content="{{isset($og_title)?$og_title:''}}" />
        <meta property="og:description" content="{{isset($og_description)?$og_description:''}}" />
        <meta property="og:image" content="{{isset($og_image)?$og_image:''}}" />
        <!-- START: Template CSS-->
        @include('layouts.links') @yield('css')
        <!-- END: Custom CSS-->
    </head>
    <!-- END Head-->
    @auth
    @if(Auth::user()->type == 1)
    <body id="main-container" class="default dark compact-menu">
        @auth @if(Auth::user()->role_id == 1) @include('layouts.popup') @endif @endauth
        <div class="main-body">
            <input type="hidden" id="web_url" value="{{url('/')}}" />
            <!-- START: Pre Loader-->
            <div class="se-pre-con">
                <div class="loader"></div>
            </div>
            <!-- END: Pre Loader-->
            @auth
            <!-- START: Header-->
            @include('layouts.header')
            <!-- END: Header-->
            <!-- START: Main Menu-->
            @include('layouts.sidebar')
            <!-- END: Main Menu-->
            @endauth
            <!-- START: Main Content-->
            @yield('content')
            <!-- END: Content-->
            <!-- START: Footer-->
            @auth
            <footer class="site-footer">
                {{-- 2021 &copy; HRM - {{Helper::get_project(Session::get("project_id"))->name}} --}}
            </footer>
            @endauth
            <!-- END: Footer-->
            <!-- START: Back to top-->
            <a href="#" class="scrollup text-center">
                <i class="icon-arrow-up"></i>
            </a>
            <!-- END: Back to top-->
            <!-- START: Template JS-->
            @include('layouts.scripts') @yield('js')
        </div>
    </body>
    @endauth @endif @if (Request::segment(1)=="login"||Request::segment(1)=="register")
    <!-- START: Body-->
    <body id="main-container" class="default dark compact-menu">
        @auth @if(Auth::user()->role_id == 1) @include('layouts.popup') @endif @endauth
        <div class="main-body">
            <input type="hidden" id="web_url" value="{{url('/')}}" />
            <!-- START: Pre Loader-->
            <div class="se-pre-con">
                <div class="loader"></div>
            </div>
            <!-- END: Pre Loader-->
            @auth
            <!-- START: Header-->
            @include('layouts.header')
            <!-- END: Header-->
            <!-- START: Main Menu-->
            @include('layouts.sidebar')
            <!-- END: Main Menu-->
            @endauth
            <!-- START: Main Content-->
            @yield('content')
            <!-- END: Content-->
            <!-- START: Footer-->
            @auth
            <footer class="site-footer">
                {{-- 2021 &copy; HRM - {{Helper::get_project(Session::get("project_id"))->name}} --}}
            </footer>
            @endauth
            <!-- END: Footer-->
            <!-- START: Back to top-->
            <a href="#" class="scrollup text-center">
                <i class="icon-arrow-up"></i>
            </a>
            <!-- END: Back to top-->
            <!-- START: Template JS-->
            @include('layouts.scripts') @yield('js')
        </div>
    </body>
    <!-- END: Body-->
    @else
   @auth
    @if(Auth::user()->type != 1)
    <body id="main-container" class="default dark compact-menu">
        @auth @if(Auth::user()->role_id == 1) @include('layouts.popup') @endif @endauth
        <div class="main-body">
            <input type="hidden" id="web_url" value="{{url('/')}}" />
            <!-- START: Pre Loader-->
            <div class="se-pre-con">
                <div class="loader"></div>
            </div>
            <!-- END: Pre Loader-->
            @auth
            <!-- START: Header-->
            @include('layouts.header')
            <!-- END: Header-->
            <!-- START: Main Menu-->
            @include('layouts.sidebar')
            <!-- END: Main Menu-->
            @endauth
            <!-- START: Main Content-->
            <div class="col-md-12">
                <main class="aboutPg">
                    <div class="saleSec">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-warning col-md-12 d-inline-block" style="margin: 25% 0; text-align: center; display: block !important;">
                                        <strong>You do not have Administrator access</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <!-- END: Content-->
            <!-- START: Footer-->
            @auth
            <footer class="site-footer">
                {{-- 2021 &copy; HRM - {{Helper::get_project(Session::get("project_id"))->name}} --}}
            </footer>
            @endauth
            <!-- END: Footer-->
            <!-- START: Back to top-->
            <a href="#" class="scrollup text-center">
                <i class="icon-arrow-up"></i>
            </a>
            <!-- END: Back to top-->
            <!-- START: Template JS-->
            @include('layouts.scripts') @yield('js')
        </div>
    </body>
    @endif
    @endauth
    @endif
</html>
