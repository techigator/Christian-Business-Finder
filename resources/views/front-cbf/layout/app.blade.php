<!DOCTYPE html>
<html lang="en">

@php
    $logo = App\Models\logo::find(1);
@endphp
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset($logo->img) }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <link rel="stylesheet" href="{{ asset('assets-cbf-front/css/lightbox.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-cbf-front/css/animate.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css"
          rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.6/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ asset('assets-cbf-front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-cbf-front/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
          integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <title>Christian Business Finder</title>
</head>

<header class="header" id="myHeader">
    <div class="Headpart-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="navigation">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <div class="logo-div">
                                <img class="logo" src="{{ asset($logo->img) }}" alt="Logo">
                            </div>

                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav align-items-center mx-auto" id="menu-wrapper">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="{{ route('front.index') }}">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('front.category') }}">Category</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('front.favourite') }}">Favourite</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('front.about') }}">About Us</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('front.contact') }}">Contact Us</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="dropdown">
                                <div class="select">
                                    <span class="selected"><i class="fas fa-user-circle"></i></span>
                                    <div class="caret"></div>
                                </div>
                                <ul class="menu">
                                    @if(!Auth::check() && !Auth::user())
                                        <li>
                                            <a class="text-dark" href="{{ route('front.login') }}">Login</a>
                                        </li>
                                    @else
                                        <li>
                                            <a class="text-dark" href="{{ route('front.edit.profile') }}">Edit
                                                Profile</a>
                                        </li>
                                        <li>
                                            <a class="text-dark" href="{{ route('front.change.password') }}">ChangePassword</a>
                                        </li>
                                        <li>
                                            <form class="logout-form" action="{{ route('front.logout') }}"
                                                  method="POST">
                                                @csrf

                                                <button type="submit" class="text-dark">Logout</button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="flex-Head">
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#navbarNav"
                                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('content')

<footer>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="foot-cnt">
                    <ul>
                        <li>
                            <a href="{{ route('front.index') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('front.category') }}">Category</a>
                        </li>
                        <li>
                            <a href="{{ route('front.about') }}">About Us</a>
                        </li>
                        <li>
                            <a href="{{ route('front.contact') }}">Contact Us</a>
                        </li>
                        <li>
                            <a href="{{ route('front.privacy') }}">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="{{ route('front.terms.condition') }}">Terms & Conditions</a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="foot-logo">
                    <a href="{{ route('front.index') }}">
                        <figure>
                            <img src="{{ asset($logo->img) }}" class="img-fluid logo" alt="">
                        </figure>
                    </a>
                </div>
            </div>

            <div class="col-md-2">
                <div class="foot-logo">
                    <h3>Find us on</h3>
                    <figure>
                        <img src="{{ asset('assets-cbf-front/images/app-logo.png') }}" class="img-fluid" alt="">
                    </figure>
                </div>
            </div>
            <div class="col-md-4">
                <div class="foot-logo">
                    <h3>Keep you self up to date</h3>
                    <form class="form-inline" action="{{ route('front.news.letter') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <input type="email" name="subscribe_email"
                                   class="form-control @error('subscribe_email') is-invalid @enderror"
                                   id="inputPassword2"
                                   placeholder="Enter your email">
                            @error('subscribe_email')
                            <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="themeBtn">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</footer>

<a class="scroll-up" href="javascript:;" style="">
    <i class="fas fa-angle-up"></i>
</a>

<script src="{{ asset('assets-cbf-front/js/app.min.js') }}"></script>
<script src="{{ asset('assets-cbf-front/js/wow.min.js') }}"></script>
<script src="{{ asset('assets-cbf-front/js/aos.js') }}"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplex-noise/2.4.0/simplex-noise.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.5/waypoints.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.0.3/js/intlTelInput.js"></script>
<script src="{{ asset('assets-cbf-front/js/language.js?cb=loadGoogleTranslate') }}"></script>
<script src="{{ asset('assets-cbf-front/js/lightbox.js') }}"></script>
<script src="{{ asset('assets-cbf-front/js/function.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.0/tinymce.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYvOXB3SFyyeR0usVOgnLyoDiAd2XDunU&libraries=places"></script>

<script>
    const dropdown = document.querySelector(".dropdown");
    const selectElement = dropdown.querySelector(".select");
    const caret = dropdown.querySelector(".caret");
    const menu = dropdown.querySelector(".menu");
    const options = dropdown.querySelectorAll(".menu li");
    const selected = dropdown.querySelector(".selected");
    selectElement.addEventListener("click", () => {
        selectElement.classList.toggle("select-clicked");
        caret.classList.toggle("caret-rotate");
        menu.classList.toggle("menu-open")
    })
    options.forEach(option => {
        option.addEventListener("click", () => {
            // selected.innerText = option.innerText;
            selectElement.classList.remove("select-clicked");
            caret.classList.remove("caret-rotate");
            menu.classList.remove("menu-open");
            options.forEach(option => {
                option.classList.remove("active")
            })
            option.classList.add("active")
        })
    })

    $(document).ready(function () {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $(document).on('click', '.liked-unliked-button', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            var business_id = $(this).data('business-id');
            var url = '{{ route('front.likes.unlikes') }}' + '/' + business_id;
            var unliked_business = $(`.unliked-business-${business_id}`);
            var liked_business = $(`.liked-business-${business_id}`);

            $.ajax({
                url: url,
                type: 'POST',
                success: function (response) {
                    if (response.success) {
                        if (response.likedBusiness) {
                            unliked_business.empty();
                            unliked_business.html('<i class="fa fa-bookmark liked-business liked-unliked-button" aria-hidden="true" data-business-id="' + business_id + '"></i>');
                            toastr.success(response.msg);

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }

                        if (response.unLikedBusiness) {
                            liked_business.empty();
                            liked_business.html('<i class="fa fa-bookmark unliked-business liked-unliked-button" aria-hidden="true" data-business-id="' + business_id + '"></i>');
                            toastr.success(response.msg);

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    }
                },
                error: function (xhr, error) {
                    console.log('error', error)
                    toastr.error('An error occurred.');
                }
            });
        });

        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('.scroll-up').fadeIn();
            } else {
                $('.scroll-up').fadeOut();
            }
        });

        $('.scroll-up').on('click', function () {
            $("html, body").animate({scrollTop: 3}, 500);
            return false;
        });
    });
</script>

@if(session()->has('success'))
    <script type="text/javascript">  toastr.success('{{ session('success')}}');</script>
    @php session()->remove('success'); @endphp
@endif
@if(session()->has('error'))
    <script type="text/javascript"> toastr.error('{{ session('error')}}');</script>
    @endif

    @yield('js')

    </body>
</html>
