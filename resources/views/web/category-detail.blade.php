@extends('web.layouts.main')
@section('content')
@endsection
@section('css')
    <main>

        @php
            // dd($product->id);
            $pd = DB::table('products')
                ->where('id', $product->id)
                ->get();
            // dd($pd);
        @endphp



        <section class="home-sec-main" style="padding: 150px 0px;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-11">
                        @foreach ($pd as $item)
                            <div class="row py-5">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 p-0 panel">
                                    <div class="card-text h-100">
                                        <div>
                                            <h1 class="secndory-txt mb-5">{{ $item->name }}</h1>
                                            <p class="">{!! $item->details !!}</p>
                                        </div>
                                        <div class="col-12 mt-5">
                                            <div class="row d-flex align-items-center">
                                                <div class="col-3">
                                                    <h6 class="P-G">€ {{ $item->price }} <span class="ea">er</span>
                                                    </h6>
                                                </div>
                                                <div class="col-3">
                                                    {{-- <h6 class="P-S">€ {{ $item->price }} <span class="ea">er</span> </h6> --}}
                                                </div>

                                            </div>
                                            <form action="{{ route('save_cart', $item->id) }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="d-flex my-4 justify-content-between align-items-center">
                                                    <div class="col-6" style="width:90px;">
                                                        <input type="number" value="1" name="quantity" class="form-control"
                                                            id="" placeholder="QTY..">
                                                    </div>
                                                    <div>
                                                        <button class="btn butto">Add <i
                                                                class="fa fa-shopping-cart"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 p-0 panel">
                                    <div class="card-image h-100 bg-light">
                                        <img class="c-img img-fluid" src="{{ asset($item->img) }}" alt="">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>



    </main>



    <style type="text/css">
    </style>
@endsection
@section('js')
@endsection
