<?php
$user = Auth::user();
?>

    <div class="sidebar">
        <div class="site-width">
            <!-- START: Menu-->
            <ul id="side-menu" class="sidebar-menu">
                <li class="dropdown active">
                    <a href="#"><i class="icon-home mr-1"></i> Dashboard</a>
                    <ul>
                        <li><a href="{{ url('dashboard') }}"><i class="fa fa-desktop"></i> Dashboard</a></li>
                        <li><a href="{{ route('logo_index') }}"><i class="fa fa-image"></i> Logo</a></li>
                        <li><a href="{{ route('banner_index') }}"><i class="fa fa-image"></i> Banner</a></li>
                        {{--
                        <li><a href="{{ route('inner_banner_index') }}"><i class="fa fa-image"></i> Inner Banner</a>
                        </li>
                        <li><a href="{{ route('cms_index') }}"><i class="fa fa-newspaper"></i> CMS</a></li>
                        <li><a href="{{ route('blogs_index') }}"><i class="fa fa-newspaper"></i> Blogs</a></li>
                        --}}
                        <li class="dropdown">
                            <a href="#"><i class="fa fa-image"></i>Services </a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('service_category_index') }}"><i class="fa fa-list"></i> Categories</a>
                                </li>
                                <li><a href="{{ route('services_index') }}"><i class="fa fa-image"></i> Services</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#"><i class="fa fa-image"></i>Shop </a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('category_index') }}"><i class="fa fa-list"></i> Categories</a>
                                </li>
                                <li><a href="{{ route('products_index') }}"><i class="fa fa-image"></i> Products</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{ route('testimonials_index') }}"><i class="fa fa-users"></i> Testimonials</a>
                        </li>
                        <li><a href="{{ route('setting_index') }}"><i class="fa fa-wrench"></i> Setting</a></li>
                    </ul>
                </li>
            </ul>
            <!-- END: Menu-->
            
        </div>
    </div>
