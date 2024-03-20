@extends('web.layouts.main')
@section('content')
<section class="dash1">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 dash2" data-aos="zoom-in" data-aos-duration="1500">
                <h2>Personalized Your store</h2>
            </div>
        </div>
    </div>
</section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xxl-12 dashboard2">
                    <div class="dashboard-container">
                    @include('web.user-dashboard.sidebar')
                    @if(!$reqdetail->isEmpty())
                        <div class="content-container store1">
                            <div class="wd-my-account-links">
                                
                           
                               
                                @foreach($reqdetail as $rd)
                                
                                @php $rqd = App\Models\products::where('id',$rd->product_id)->first();@endphp
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                <img src="{{asset('assets/uploads/product/'.$rqd->image1)}}" width="100%" class="img-fluid" alt="img"></div>
                                        

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                    <div class="now6">
                                        <h6>{{$rqd->name}}</h6>
                                        <p class="text-warning">Token {{$rqd->price}}</p>
                                        <p class="text-success">Service {{$rqd->name}}</p>
                                        <h6>Need for {{$rd->total_days}} day</h6>
                                        {{--<h4>Total Rent:&nbsp;{{$rd->total_rent}}</h4>--}}
                                        <h5><i class="fa-solid fa-circle"></i> {{$rd->start_date}} </h5>
                                        <i class="fa-solid fa-ellipsis-stroke-vertical"></i>
                                        <h5><i class="fa-solid fa-circle"></i> {{$rd->end_date}} </h5>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                  <div class="now7">
                    <div class="now10">
                    @php $rud = App\Models\User::where('id',$rd->user_request_id)->first();
                       if($rud['profile_image']){
                          $profile_image=asset('assets/uploads/user/'.$rud['profile_image']);
                       }else{
                          $avatar_img = strtoupper($rud['name'][0]) . '.svg'; 
                          $profile_image=asset('web/images/icons/avatars/'.$avatar_img);
                       }
                       @endphp
                          <img src="{{$profile_image}}" class="img-fluid" alt="img">
                      <div class="now8">
                        <h6>{{$rud->name}}</h6>
                        <a href="{{route('chat',$rd->id)}}"><i class="fa-solid fa-messages"></i>&nbsp;&nbsp; Chat</a>
                      </div>
                    </div>
                    <div class="now11 mt-5">
                    @php if($rd->product_action=='Accept'){
                        $class_btn="bg-success";
                    }else if($rd->product_action=='Reject'){
                        $class_btn="bg-danger";
                        
                    }else{
                        $class_btn="bg-warning";

                    }
                    @endphp
                    @if($rd->product_action=='Pending')

                    <a href="{{url('product-request/'.$rd->id.'/Accept')}}" class="bg-success mt-1">Accept</a>
                      <a href="{{url('product-request/'.$rd->id.'/Reject')}}" class="bg-danger mt-1">Reject</a>
                    @else
                    <a href="javascript:void(0)" class="{{$class_btn}} mt-1 disabled" style="pointer-events: none;">{{$rd->product_action}}</a>
                    @endif
                      
                    </div>
                    @php
                    if($rd->product_received==1 && $rd->product_action=='Accept'){
                        $class_btn="bg-success";
                        $title_btn="Recieved";
                    }
                    @endphp
                    @if($rd->product_received==1 && $rd->product_action=='Accept')
                    <div class="now11 mt-2 width">
                      <a href="javascript:void(0)" class="{{$class_btn}}" style="pointer-events: none;">{{$title_btn}}</a>
                    </div>
                    @endif
                    @if($rd->product_received==0 && $rd->product_action=='Accept')
                    <div class="now11 mt-2 width">
                      <a href="javascript:void(0)" class="bg-danger" style="pointer-events: none;">Not Recieved</a>
                    </div>
                    @endif
                   {{-- @if($rd->product_received==1)
                    <div class="now11 mt-2 width">
                      <a href="{{url('req-return/'.$rd->id.'/1')}}" class="bg-danger" style="pointer-events: none;">Returned</a>
                    </div>
                    @endif--}}
                    @if($rd->product_received==1 && $rd->product_return==0)
                    <div class="now11 mt-2">
                      <a href="{{url('req-return/'.$rd->id.'/1')}}" class="bg-danger">Customer Return Your Product</a>
                    </div>
                    @endif
                    @if($rd->product_received==1 && $rd->product_return==1)
                    <div class="now11 mt-2">
                      <a href="{{url('req-return/'.$rd->id.'/1')}}" class="bg-success" style="pointer-events: none;">Customer Has Been Returned Your Product</a>
                    </div>
                    @endif
                    {{-- <div class="now9">
                              <h5> May 25 2023, 10:50 AM </h5>
                              <p>Please pick it at the pickup time</p>
                          </div>--}}
                  </div>
                </div>
                                @endforeach
                                
                            </div>
                        </div>
                        @else
                    <div class="content-container">
                    <div class="alert alert-danger" style="margin: 25% 0 15% 0;text-align: center;">
                                    <strong>No Record Found.</strong>
                        </div>
                        </div>
                    @endif
                    </div>
                </div>

       
            </div>
        </div>

    </section>

<div>
    <a id="button" class="my-button"></a>
</div>

@endsection

@section('css')
<style>
    .main {
    background-image: url({{asset('web/images/home.jpg')}});
}
.store1 {
    background-image: url(../images/pic1.png);
    background-size: cover;
    background-repeat: no-repeat;
    height: fit-content;
}
.store2 {
    padding: 50px;
}
.now4 {
    justify-content: center;
    align-items: center;
}
.now6 h6 {
    color: rgb(0, 0, 0);
    font-size: 25px;
    font-weight: 600;
    font-family: Heebo, sans-serif;
}
.content-container p {
    font-size: 17px;
    font-weight: 400;
    color: rgb(174, 171, 171);
    font-family: Heebo, sans-serif;
}
.now6 h4 {
    color: rgb(152, 207, 44);
    font-size: 16px;
    font-weight: 600;
    font-family: Heebo, sans-serif;
}
.now6 h5 {
    color: rgb(0, 0, 0);
    font-size: 12px;
    font-weight: 600;
    font-family: Heebo, sans-serif;
    margin-top: 10px;
}
.now7 img {
    width: 15%;
}
.now8 a {
    color: rgb(255, 255, 255);
    background-color: rgb(152, 207, 44);
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 10px;
}
.now8 h6{
    text-transform: capitalize;
}
.now9 {
    margin-top: 40px;
}
.now10{
  display: flex;
  gap: 30px;
}
.now11 a {
  color: rgb(255, 255, 255);
  background-color: #E75C5B;
  padding: 8px 20px;
  border-radius: 20px;
  font-size: 10px;
}
.width{
    display : flex;
    justify-content: space-between;
    
}
</style>
@endsection
@section('js')
@endsection