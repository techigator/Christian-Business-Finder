@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-form-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-form">
                        <div id="search">

                            <form action="{{ route('front.business') }}" method="GET" autocomplete="off"
                                  enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" name="search_business" class="form-control"
                                                   placeholder="Search And Find Business"
                                                   id="search_input"
                                                   value="{{ !empty(request()->input('search')) ? request()->input('search') : '' }}">
                                            <button class="close" type="button">×</button>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-3">
                                        <button type="submit" class="btn themeBtn">Submit</button>
                                    </div>--}}
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="categ-sect blg-sect">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="categ-content">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <h2 class="sectionHeading text">Categories</h2>
                                <div class="blgBtn">
                                    <a href="{{ route('front.category') }}" class="themeBtn">See All</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @php $count = 0 @endphp
                            @foreach($processedCategories as $key => $categories)
                                @if($count < 4)
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="cate-cont">
                                            <a href="{{ route('front.category.detail', $categories['category']['slug'] ?? '') }}">
                                                <span><img
                                                        src="{{ asset($categories['category']['img'] ?? 'https://static.vecteezy.com/system/resources/thumbnails/004/141/669/small/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg') }}"
                                                        alt="category-img-{{ $key }}"></span>
                                                <h4>{{ $categories['category']['name'] ?? 'Car' }}</h4>
                                                <p><strong>{{ count($categories['business']) ?? '0' }}</strong> Result
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                    @php $count++ @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="categ-content">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <h2 class="sectionHeading text">Suggestions</h2>
                                <div class="blgBtn">
                                    <a href="{{ route('front.business') }}" class="themeBtn">See All</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($processedSuggestions as $key => $suggestion)
                                <div class="col-md-6">
                                    <div class="dine-cont">
                                        <a href="{{ route('front.business.detail', $suggestion['business']['id']) }}">
                                            <figure>
                                                <img
                                                    src="{{ asset('uploads/business/' . $suggestion['business']['thumbnail'] ?? 'https://static.vecteezy.com/system/resources/thumbnails/004/141/669/small/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg') }}"
                                                    alt="category-img-{{ $key }}" class="img-fluid">
                                            </figure>

                                            <div class="din-text">
                                                <h3>{{ $suggestion['business']['name'] ?? '' }}</h3>
                                                <ul>
                                                    <li><a href="javascript:;"><span><i
                                                                    class="fas fa-map-marker-alt"></i></span> {{ $suggestion['business']['location'] ?? 'street 11 new york' }}
                                                        </a></li>
                                                    <li><a href="javascript:;"><span class="category-img"><img
                                                                    class="colorize-img"
                                                                    src="{{ asset($suggestion['category']['img'] ?? 'https://static.vecteezy.com/system/resources/thumbnails/004/141/669/small/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg') }}"
                                                                    alt="category-img-{{ $key }}"
                                                                    width="7%"></span> {{ $suggestion['category']['name'] ?? 'Car' }}
                                                        </a></li>
                                                </ul>
                                            </div>
                                        </a>

                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.0" style="display:none;">
                                            <defs>
                                                <filter id="colorize">
                                                    <feColorMatrix type="matrix"
                                                                   values="0.8 0 0 0 0.5
                                                                           0.6 0 0 0 0.3
                                                                           0.3 0 0 0 0.1
                                                                           0 0 0 1 0"/>
                                                </filter>
                                            </defs>
                                        </svg>

                                        @if(!is_null($userId))
                                            @if($suggestion['business']['like'])
                                                <div
                                                    class="bookmark liked-business-{{ $suggestion['business']['id'] }}">
                                                    <i class="fa fa-bookmark liked-business liked-unliked-button"
                                                       aria-hidden="true"
                                                       data-business-id="{{ $suggestion['business']['id'] }}"></i>
                                                </div>
                                            @else
                                                <div
                                                    class="bookmark unliked-business-{{ $suggestion['business']['id'] }}">
                                                    <i class="fa fa-bookmark unliked-business liked-unliked-button"
                                                       aria-hidden="true"
                                                       data-business-id="{{ $suggestion['business']['id'] }}"></i>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script>
        $(document).ready(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            $('#search').on('click', function (e) {
                e.preventDefault();

                $('.search-box').toggleClass('open')
                $('.searchicon').toggleClass('flaticon-search flaticon-cancel')
            });

            $('#search, #search button.close').on('click keyup', function (e) {
                if (e.target == this || e.target.className == 'close' || e.keyCode == 27) {
                    $(this).removeClass('open');
                    $('#search_input').autocomplete('close');
                }
            });

            $('#search_input').on('input', function () {
                var query = $(this).val();

                $.ajax({
                    url: '{{ route("front.search.business") }}',
                    type: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (response) {
                        if (response.success === false) {
                            return toastr.error(response.message);
                        }

                        var suggestions = response.map(function (item) {
                            return {
                                label: item.name,
                                value: item.url
                            };
                        });

                        $('#search_input').autocomplete({
                            source: suggestions,
                            search: function (event, ui) {
                                $('button.close').show();
                            },
                            response: function (event, ui) {
                                if (ui.content.length === 0) {
                                    $('button.close').hide();
                                }
                            },
                            close: function (event, ui) {
                                $('button.close').hide();
                            },
                            select: function (event, ui) {
                                event.preventDefault();

                                $('#search_input').val(ui.item.label);
                                window.location.href = ui.item.value;
                            }
                        });
                    },
                    error: function (xhr, error) {
                        toastr.error('Please login first');
                    }
                });
            });

            $('button.close').hide();
        });
    </script>
@endsection
