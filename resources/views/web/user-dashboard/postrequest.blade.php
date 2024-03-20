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
                    <div class="content-container store1 test">
                        <div class="store2">
                            @foreach($reqdetail as $rd)
                            @php $rqd = App\Models\products::where('id',$rd->product_id)->first();@endphp
                            <div class="row now4 mb-3">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                    <img src="{{asset('assets/uploads/product/'.$rqd->image1)}}" width="100%" class="img-fluid" alt="img">
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                    <div class="now6">
                                        <h6>{{$rqd->name}}</h6>
                                        <p>${{$rqd->price}}</p>
                                        <h6>{{$rd->total_days}}</h6>
                                        <h4>Total Rent: &nbsp;&nbsp;&nbsp;${{$rd->total_rent}}</h4>
                                        <h5><i class="fa-solid fa-circle"></i> {{$rd->start_date}} </h5>
                                        <i class="fa-solid fa-ellipsis-stroke-vertical"></i>
                                        <h5><i class="fa-solid fa-circle"></i> {{$rd->end_date}} </h5>
                                    </div>
                                </div>
                               <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                    <div class="now7">
                                        <img src="{{asset('web/images/group7.png')}}" class="img-fluid" alt="img">
                                        <div class="now8">
                                            <h6>User 5</h6>
                                            <a href="{{route('chat',$rd->id)}}"><i class="fa-solid fa-messages"></i>&nbsp;&nbsp; Chat</a>
                                        </div>
                                        <div class="now11 mt-5">
                    @php if($rd->product_action=='Accept'){
                        $class_btn="bg-success";
                        $title_btn="Accept";
                    }else if($rd->product_action=='Reject'){
                        $class_btn="bg-danger";
                        $title_btn="Reject";
                    }else{
                        $class_btn="bg-warning";
                        $title_btn="Pending";
                    }
                    @endphp
                      <a href="javascript:void(0)" class="{{$class_btn}}">{{$title_btn}}</a>
                      <?php
                      if($rd->product_received==0 && $rd->product_action=='Accept' ){ ?>
                      <div class="width">
                        <a href="{{url('req-notify/'.$rd->id.'/1')}}" class="bg-success mt-1">Recieved</a>
                        <a href="{{url('req-notify/'.$rd->id.'/0')}}" class="bg-danger mt-1">Not Recieved</a>
                        </div>
                        <?php }
                      else if($rd->product_received==0 && $rd->product_action=='Reject' ){ ?>
                        <a href="javascript:void(0)" class="bg-danger mt-1" style="pointer-events: none;">Rejected</a>
                        <?php }
                        else if($rd->product_received==1 && $rd->product_action=='Accept' ){ ?>
                        <a href="javascript:void(0)" class="bg-success mt-1" style="pointer-events: none;">Recieved</a>
                       <?php }
                       else{ ?>
                        <a href="javascript:void(0)" class="bg-warning mt-1" style="pointer-events: none;">Waiting</a>
                        <?php }
                    ?>
                      @if($rd->product_received==1 && $rd->product_return==1)
                    <div class="now11 mt-3">
                      <a href="javascript:void(0)" class="bg-success" style="pointer-events: none;">You Return The Product</a>
                    </div>
                    @endif
                    </div>
                    {{-- <div class="now9">
                              <h5> May 25 2023, 10:50 AM </h5>
                              <p>Please pick it at the pickup time</p>
                          </div>--}}
                  </div>
                                        <div class="now9">
                                            <h5> {{$rd->pickup_time}} </h5>
                                            <p>Please pick it at the pickup time</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
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
    .img-fluid {
    max-width: 100%;
    height: auto;
}
    .now11 a {
    color: rgb(255, 255, 255);
    background-color: #E75C5B;
    padding: 8px 40px;
    border-radius: 20px;
    font-size: 10px;
}
.content-container {
    flex: 1;
    margin-left: 20px;
    position: relative;
}
.wd-my-account-links {
    display: flex;
    flex-wrap: wrap;
    margin-top: 30px;
    margin-left: -10px;
    margin-right: -10px;
}
.wd-my-account-links>div {
    flex: 1 1 33%;
    max-width: 33%;
    width: 33%;
    padding-left: 10px;
    padding-right: 10px;
    margin-bottom: 20px;
}
.now10 {
    display: flex;
    gap: 30px;
}
</style>
@endsection
@section('js')
@endsection