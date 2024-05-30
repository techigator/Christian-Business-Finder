@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>Category Detail ({{ $categoryName ?? 'Car' }})</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="categ-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="categ-content">
                        <div class="row">
                            @forelse($processedBusinesses as $key => $business)
                                <div class="col-md-6">
                                    <div class="dine-cont">
                                        <a href="{{ route('front.business.detail', $business['business']['id']) }}">
                                            <figure>
                                                <img
                                                    src="{{ asset('uploads/business/' . $business['business']['thumbnail'] ?? 'https://static.vecteezy.com/system/resources/thumbnails/004/141/669/small/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg') }}"
                                                    alt="category-img-{{ $key }}" class="img-fluid">
                                            </figure>

                                            <div class="din-text">
                                                <h3>{{ $business['business']['name'] ?? '' }}</h3>
                                                <ul>
                                                    <li><a href="javascript:;"><span><i
                                                                    class="fas fa-map-marker-alt"></i></span> {{ $business['business']['location'] ?? 'street 11 new york' }}
                                                        </a></li>
                                                    <li><a href="javascript:;"><span class="category-img"><img
                                                                    class="colorize-img"
                                                                    src="{{ asset($business['category']['img'] ?? 'https://static.vecteezy.com/system/resources/thumbnails/004/141/669/small/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg') }}"
                                                                    alt="category-img-{{ $key }}"
                                                                    width="7%"></span> {{ $business['category']['name'] ?? 'Car' }}
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

                                        @if($business['business']['like'])
                                            <div class="bookmark liked-business-{{ $business['business']['id'] }}">
                                                <i class="fa fa-bookmark liked-business liked-unliked-button" aria-hidden="true" data-business-id="{{ $business['business']['id'] }}"></i>
                                            </div>
                                        @else
                                            <div class="bookmark unliked-business-{{ $business['business']['id'] }}">
                                                <i class="fa fa-bookmark unliked-business liked-unliked-button" aria-hidden="true" data-business-id="{{ $business['business']['id'] }}"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <div class="dine-cont">
                                        <h3 class="text-dark">Category Businesses Not Found.</h3>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
