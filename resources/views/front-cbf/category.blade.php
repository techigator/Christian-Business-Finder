@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>Categories</h2>
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
                            @forelse($processedCategories as $categories)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="cate-cont">
                                        <a href="{{ route('front.category.detail', $categories['category']['slug'] ?? '') }}">
                                            <span>
                                                <img src="{{ asset($categories['category']['img'] ?? 'https://static.vecteezy.com/system/resources/thumbnails/004/141/669/small/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg') }}" alt="">
                                            </span>
                                            <h4>{{ $categories['category']['name'] ?? 'Car' }}</h4>
                                            <p>{{ count($categories['business']) ?? '0' }} Result</p>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="cate-cont">
                                        <h3 class="text-dark">Category Not Found.</h3>
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
