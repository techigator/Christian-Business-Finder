<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- START: Head-->
    <head>
        <meta charset="UTF-8" />
        <title>{{isset($title)?$title:env('APP_NAME')}}</title>
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="description" content="{{isset($description)?$description:''}}" />
        <meta name="keywords" content="{{isset($keywords)?$keywords:''}}" />
        <!-- START: Template CSS-->
        @include('web.layouts.links') @yield('css')
        @stack('payment-links')
        <!-- END: Custom CSS-->
    </head>
    <!-- END Head-->

    <!-- START: Body-->
    <body>
        @include('web.layouts.header')
        <input type="hidden" id="web_url" value="{{url('/')}}" />
        <!-- START: Main Content-->
        @yield('content')
        <!-- END: Content-->
        @include('web.layouts.footer')
        <!-- START: Template JS-->
        @include('web.layouts.scripts') 
        @yield('js')
    </body>
    <!-- END: Body-->
</html>
