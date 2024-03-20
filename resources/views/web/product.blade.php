@extends('web.layouts.main')
@section('content')
  <div class="banner innerBanner">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="bannerCaption">
              @php $cat_id=isset($_GET["cat"])?$_GET["cat"]:'';@endphp
              @php use App\Models\category @endphp
              @php $category_data=category::where('id', $cat_id)->first();@endphp    
              @if ($category_data)
                  <h2>{{$category_data->name}}</h2>
              @else  
                    <h1>{{$inner_banner->name}}</h1>
              @endif 

              @if(isset($_GET['search']))
              <h2> Search: {{$_GET["search"]}} </h2>
              @endif 

                </div>
            </div>
        </div>
    </div>
</div>
<style>
.innerBanner {
    background-image: url('{{asset($inner_banner->img)}}');
}   
</style>

                    
<main class="newArrivalPg">
   <div class="newArrivalSec">
      <div class="container">
         <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="arrivalNav">
               <div class="byBrand sec">
                  <h4>Category</h4>


@if(!empty($category))
@foreach($category as $cat)
                  <div class="form-group">
                        <input type="checkbox" {{ $cat_id == $cat->id ? "checked" : "" }} id="html{{$cat->id}}" onclick="location.href='{{ url('products?cat='.$cat->id) }}'">
                        <label for="html{{$cat->id}}">{{$cat->name }}</label>
                  </div>
@endforeach
@endif
               </div>
               {{--

               <div class="delayType sec">
                  <h4>Deal Type</h4>
                  <ul>
                     <li><a href="#">Lorem Ipsum</a></li>
                     <li><a href="#">Is simply dummy</a></li>
                     <li><a href="#">Text of the printing</a></li>
                     <li><a href="#">And typesetting</a></li>
                  </ul>
               </div>
               <div class="availibilty sec">
                  <h4>Availability</h4>
                  <div class="form-group">
                        <input type="checkbox" id="html">
                        <label for="html">Lorem Ipsum</label>
                   </div>
                   <div class="form-group">
                        <input type="checkbox" id="html">
                        <label for="html">Is simply dummy</label>
                   </div>
                   <div class="form-group">
                        <input type="checkbox" id="html">
                        <label for="html">Text of the printing</label>
                   </div>
                   <div class="form-group">
                        <input type="checkbox" id="html">
                        <label for="html">And typesetting</label>
                   </div>
                   <div class="form-group">
                        <input type="checkbox" id="html">
                        <label for="html">Industry lorem</label>
                   </div>
               </div>
               --}}
               <div class="price sec">
                  <h4>Price</h4>
              <ul class="list22">
                <li><a href="{{ url('products?price=25')}}">Under $25</a></li>
                <li><a href="{{ url('products?price=50')}}">$25 to $50</a></li>
                <li><a href="{{ url('products?price=100')}}">$50 to $100</a></li>
                <li><a href="{{ url('products?price=200')}}">$100 to $200</a></li>
                <li><a href="{{ url('products?price=above-200')}}">$200 & Above</a></li>
              </ul>
               </div>
               {{--
               <div class="discount sec">
                  <h4>Discount</h4>
                  <ul>
                     <li><a href="#">10% Off or More</a></li>
                     <li><a href="#">25% Off or More</a></li>
                     <li><a href="#">50% Off or More</a></li>
                     <li><a href="#">70% Off or More</a></li>
                  </ul>
               </div>
                --}}
               <div class="reviews sec">
                  <h4>Customer Review</h4>
                  <ul class="list-inline">
                     <li ><a href="{{ url('products?star=5')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=5')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=5')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=5')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=5')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=5')}}">& Up</a></li>
                  </ul>
                  <ul class="list-inline">
                     <li ><a href="{{ url('products?star=4')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=4')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=4')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=4')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=4')}}"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=4')}}">& Up</a></li>
                  </ul>
                  <ul class="list-inline">
                     <li ><a href="{{ url('products?star=3')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=3')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=3')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=3')}}"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=3')}}"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=3')}}">& Up</a></li>
                  </ul>
                  <ul class="list-inline">
                     <li ><a href="{{ url('products?star=2')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=2')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=2')}}"><i class="fa fa-star " aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=2')}}"><i class="fa fa-star " aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=2')}}"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=2')}}">& Up</a></li>
                  </ul>
                  <ul class="list-inline">
                     <li ><a href="{{ url('products?star=1')}}"><i class="fa fa-star goldClr" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=1')}}"><i class="fa fa-star " aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=1')}}"><i class="fa fa-star " aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=1')}}"><i class="fa fa-star " aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=1')}}"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                     <li><a href="{{ url('products?star=1')}}">& Up</a></li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="productsSec">
               <div class="row">
               @if(!$products->isEmpty())
@foreach($products as $product)
  <div class="col-md-4 col-sm-4 col-xs-12">
                     <div class="newArrivalCntnt">
              @if($product->img)
              <img src="{{ asset($product->img) }}" class="img-responsive" alt="newArrivalImg">
              @else
                  <img src="{{ asset('/images/no-img.png') }}" class="img-responsive" alt="newArrivalImg" />
              @endif
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                        <div class="cntntdetail">
                           <h6>{{ $product->name }}</h6>
                           {{--
                           <p>Lorem Ipsum is simply dummy text of the printing typesetting.</p>
                            --}}
                           <h5>
                           @if ($product->price)
                           $ {{number_format($product->price, 2, '.', ',')}}                          
                           @else
                           Price is not set.                         
                           @endif
                         </h5>
                           <a href="{{route('product_details',$product->slug)}}" class="webBtn">Add TO Cart</a>
                        </div>
                     </div>
                  </div>
@endforeach
@else
<div class="col-md-12">
<div class='alert alert-warning' style='margin:10% 0;text-align: center;'>
                    <strong>No Records Found</strong>
</div>
</div>
@endif   
               </div>
            </div>
         </div>
         {!! $products->links('pagination::bootstrap-4') !!}
         <!-- <div class="pagination">
            <ul class="list-inline">
               <li><a href="#">1</a></li>
               <li class="active"><a href="#">2</a></li>
               <li><a href="#">3</a></li>
               <li><a href="#">4</a></li>
               <li><a href="#">5</a></li>
            </ul>    
         </div> -->
      </div>
   </div>
</main>
@endsection
@section('css')
<style type="text/css">
</style>
@endsection
@section('js')
@endsection
