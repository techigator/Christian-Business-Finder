@extends('web.layouts.main')
@section('content')
<section class="shop">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="shop1 mb-5">
                    <h2>{{$cat->name}}</h2>
                </div>

                <!-- <div class="row justify-content-center"> -->
                <div class="row">
                <?php foreach ($product as $key => $pro): ?>
                  <div class="col-md-3 card shop3">
                        <div class="text-center">
                            <img src="{{ asset($pro->img) }}" class="card-img-top" alt="img">
                        </div>
                        <div class="card-body shop2">
                            <div class="shop5">
                                <span class="fa fa-star checked shop6"></span>
                                <span class="fa fa-star checked shop6"></span>
                                <span class="fa fa-star checked shop6"></span>
                                <span class="fa fa-star checked shop6"></span>
                                <span class="fa fa-star checked shop6"></span>
                                <h6>{{$pro->name}}</h6>
                            </div>
                            <div class="shop4">
                                <a href="{{route('product_details',$pro->slug)}}" class="btn">Buy Now</a>
                            </div>
                        </div>  
                    </div>
                <?php endforeach ?>
                @if($product->isEmpty())
                <div class="col-md-12">
                    <div class="alert alert-danger" style="margin: 10% 0; text-align: center;">
                        <strong>No Records Found</strong>
                    </div>
                </div>
                @endif  
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('css')
@endsection
@section('js')
@endsection