<?php
use App\Models\logo;
use App\Models\setting;
$logo = logo::find(1);
$setting = setting::find(1);
?>
<div id="header-fix" class="header fixed-top">
    <div class="site-width">
        <nav class="navbar navbar-expand-lg  p-0">
            <div class="navbar-header  h-100 h4 mb-0 align-self-center logo-bar text-left">
                <a href="{{ url('/') }}" class="horizontal-logo text-left">
                    <span class="h4 font-weight-bold align-self-center mb-0 ml-auto"><img src="{{ asset($logo->img) }}"
                            class="img-responsive" alt="logo" width="60px;" height="50px;"></span>
                </a>
            </div>
          
            <div class="navbar-right ml-auto h-100">
                <ul class="ml-auto p-0 m-0 list-unstyled d-flex top-icon h-100">
                    <li class="d-inline-block align-self-center  d-block d-lg-none">
                        <a href="#" class="nav-link mobilesearch" data-toggle="dropdown" aria-expanded="false"><i
                                class="icon-magnifier h4"></i>
                        </a>
                    </li>
                    
                    @if (Auth::check())
                        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 36)
                            <li class="dropdown user-profile align-self-center d-inline-block">
                                <a href="{{ route('steps') }}" class="nav-link py-0">
                                    <div class="media">
                                        <img src="{{ asset('images/switch-icon.png') }}"
                                            alt="{{ Auth::user()->name }} Profile" title="Switch Project"
                                            class="d-flex img-fluid rounded-circle" width="29">
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown user-profile align-self-center d-inline-block">
                                <a href="javascript:void(0)" class="" data-toggle="modal"
                                    data-target="#notificationModal" class="nav-link py-0">
                                    <div class="media">
                                        <img src="{{ asset('images/create-alert.png') }}"
                                            alt="{{ Auth::user()->name }} Profile" title="Generate Alert"
                                            class="d-flex img-fluid rounded-circle" width="29">
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endif

                    <li class="dropdown user-profile align-self-center d-inline-block">
                        <a href="#" class="nav-link py-0" data-toggle="dropdown" aria-expanded="false">
                            <div class="media">
                                @if (Auth::check())
                                    @php $user = Auth::user(); @endphp
                                    @if ($user->profile_pic != '')
                                        @php $path = $user->profile_pic; @endphp
                                    @else
                                        @php $path = "images/no-img.png"; @endphp
                                    @endif
                                @endif
                                <img src="{{ asset($path) }}" alt="{{ $user->name }} Profile"
                                    title="{{ Auth::user()->name }} Dashboard" class="d-flex img-fluid rounded-circle"
                                    width="29">
                            </div>
                        </a>

                        <div class="dropdown-menu border dropdown-menu-right p-0">
                            
                            <div class="dropdown-divider"></div>
                            <a href=""
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                class="dropdown-item px-2 align-self-center d-flex">
                                <span class="icon-logout mr-2 h6  mb-0"></span> Sign Out</a>
                            <form id="logout-form" action="" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>

                    </li>

                </ul>
                @if (Auth::check())
                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 36)
                        <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Modal body text goes here.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </nav>
    </div>
</div>
