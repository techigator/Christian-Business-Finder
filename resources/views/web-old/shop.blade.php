@extends('web.layouts.main')
@section('content')

@if(isset($_GET) && isset($_GET['cat']))
<?php
    $_GET['cat'];
?>
@else
<?php
    $_GET['cat']='';
?>
@endif

<section class="rent2">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 rent3" data-aos="zoom-in-down" data-aos-duration="1500">
                <h2>Nearby Search</h2>
                <p>search products for rent near you</p>
                <div class="row">

                    <form class="rent4">
                        <div class="col-md-4 mb-3 rent5">
                            <input type="text" class="form-control" placeholder="search product or item" id="exampleInputPassword1">
                            <div class="rent7">
                                <a href="#">Use My Current Location</a>
                            </div>
                        </div>

                        <div class="col-md-2 mb-3 rent5">
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="enter zip code" aria-describedby="emailHelp">
                            <div class="rent8">
                                <a href="#">Search</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="product1">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <h2 class="product2" data-aos="zoom-in">Find Your Needs</h2>
                <div class="row">
                <div class="owl-carousel owl-theme">
                    @foreach($cat as $key=> $cats)
                    
                    @if($key==0||$key==3||$key==6||$key==9||$key==12||$key==15||$key==18||$key==21||$key==24)
                    @php 
                    $classsrent="rent10";
                    @endphp
                    @elseif($key==1||$key==4||$key==7||$key==10||$key==13||$key==16||$key==19||$key==22||$key==25)
                    @php 
                    $classsrent="rent11";
                    @endphp 
                    @elseif($key==2||$key==5||$key==8||$key==11||$key==14||$key==17||$key==20||$key==23||$key==26)
                    @php 
                    $classsrent="rent9";
                    @endphp 
                    @else
                    @php 
                    $classsrent="rent9";
                    @endphp 
                    @endif
                    <div class="item" @if($_GET['cat'] == $cats->name) style="border:2px solid gray;border-radius:10px;" @endif>
                        <div class="{{$classsrent}}">
                            <a href={{route('rent')}}?cat={{$cats->name}}><img src="{{asset($cats->img)}}" class="img-fluid" alt="img"></a>
                            <p class="text-center">{{$cats->name}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                </div>
                <div class="row row-cols-1 row-cols-md-5 row-cols-lg-5 row-cols-xl-5 row-cols-xxl-5 g-2 g-lg-3 mt-5 mb-5">
                    @foreach($all_prd as $prd)
                    <div class="col product7">
                        <img src="{{asset('assets/uploads/product/'.$prd->image1)}}" class="img-fluid" alt="img">

                        <div class="product6">
                            <div class="product3">
                                <h6>{{$prd->name}}</h6>
                                <p>${{$prd->price}}{{--<span class="span1">.25</span>--}}</p>
                            </div>
                            @if($prd->availability == 1)
                            <p class="product4">Available for Rent</p>
                            @else
                            <p class="product4">Not Available for Rent</p>
                            @endif

                            <div class="product5">
                               <span class="nav_glass2">
                                    <a href="{{route('product_request',$prd->id)}}">Request</a>
                                </span>
                                <span class="nav_user2">
                                    <a href="{{route('product_details',$prd->id)}}">View</a>
                                </span>
                            </div>
                        </div>
                    </div>

                    @endforeach

            </div>
        </div>
    </div>
</section>
<!-- Testimonials Section Start -->
@include('web.layouts.testimonials')
<!-- Testimonials Section End -->
@endsection
@section('css')
<style>
.rent9 {
  background-color: #D4CEFF;
  padding: 40px;
  border-radius: 10px;
  /* box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; */
}
.rent9 p {
  margin-top: 10px;
  font-size: 17px;
  font-weight: 400;
  color: #000000;
  font-family: 'Poppins', sans-serif;
}
.rent10 {
  background-color: #FFF3C9;
  padding: 40px;
  border-radius: 10px;
  /* box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; */
}
.rent10 p {
  margin-top: 10px;
  font-size: 17px;
  font-weight: 400;
  color: #000000;
  font-family: 'Poppins', sans-serif;
}
.rent11 {
  background-color: #FEC3C3;
  padding: 40px;
  border-radius: 10px;
  /* box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; */
}
.rent11 p {
  margin-top: 10px;
  font-size: 17px;
  font-weight: 400;
  color: #000000;
  font-family: 'Poppins', sans-serif;
}
</style>
@endsection
@section('js')
<script>
  $('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: false,
    dots: false,
    autoplay: true,
    autoplayTimeout: 3000,
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 4
      },
      1000: {
        items: 6
      }
    }
  })
</script>
@endsection