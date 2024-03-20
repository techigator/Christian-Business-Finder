@extends('web.layouts.main')
@section('content')
        <!-- START: Inner Banner-->
        @include('web.layouts.inner_banner')
        <!-- END: Inner Banner-->
<main class="checkoutPg">
   <section class="checkout">
          <div class="container">
            <div class="body-space">
<form method="POST" action="{{route('completeOrder')}}">
               @csrf                
              <div class="row">
                     <div class="col-md-8">
                <div class="car-form">
                        <div class="rightSec">
                           <h3 class="wow fadeInDown" data-wow-delay="1.4s" data-wow-duration="1.4s">Billing Address</h3>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label for="">First Name <span>*</span></label>
                              </div>
                              <div class="col-md-9">
                                <input class="form-control" type="text" value="{{old('billing_first_name',$checkout_data['billing_first_name'])}}"  required name="billing_first_name">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label for="">Last Name <span>*</span></label>
                              </div>
                              <div class="col-md-9">
                                <input class="form-control" type="text"  value="{{old('billing_last_name',$checkout_data['billing_last_name'])}}"  required name="billing_last_name">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label for="">Email Address <span>*</span></label>
                              </div>
                              <div class="col-md-9">
                                <input class="form-control"  type="email" value="{{old('billing_email',$checkout_data['billing_email'])}}"  required name="billing_email">
                              </div>
                            </div>
                          </div>
                  <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <label for="">Phone Number<span>*</span></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <input class="form-control" type="number" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" value="{{old('billing_phone',$checkout_data['billing_phone'])}}"  required name="billing_phone">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                      <label for="">Country <span>*</span></label>                      
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                      <select   required name="billing_country" class="form-control" id="country" value="{{old('billing_country',$checkout_data['billing_country'])}}">
                        <option value="" >Select Country</option>
                        @if(count($countries) > 0)
                          @foreach($countries as $cont)
 <!-- <option value="{{$cont->id}}" data-countryId="{{$cont->id}}" @if($checkout_data["billing_country"] == $cont->id) selected @endif >{{$cont->country}}</option> -->
 <option value="{{$cont->id}}" data-countryId="{{$cont->id}}" @if(223 == $cont->id) selected @endif >{{$cont->country}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <label for="">Town / City <span>*</span></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <input class="form-control"  type="text" value="{{old('billing_city',$checkout_data['billing_city'])}}"  required name="billing_city">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <label for="">State / Province<span>*</span></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <input class="form-control" type="text" value="{{old('billing_state',$checkout_data['billing_state'])}}"  required name="billing_state">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <label for="">Address<span>*</span></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <input class="form-control" type="text" value="{{old('billing_address',$checkout_data['billing_address'])}}"  required name="billing_address">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <label for="">Zip Code<span>*</span></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <input class="form-control" type="text" value="{{old('billing_zip',$checkout_data['billing_zip'])}}"  required name="billing_zip">
                    </div>
                  </div>
                </div>
                  <div class="checkout-chkk">
                  <div class="col-md-12">
                    <input type="checkbox" name="different_address" value="on" class="different_address" onchange="differentaddress()">
                    <label>Ship to a different address?</label>
                  </div>
                        </div>
                </div>
<!-- Shipping Address -->
<div class="rightSec shipping-info mt-4">
                           <!-- <h3 class="wow fadeInDown" data-wow-delay="1.4s" data-wow-duration="1.4s">Shipping Address</h3> -->
                           <h3>Shipping Address</h3>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label for="">First Name <span>*</span></label>
                              </div>
                              <div class="col-md-9">
                                <input class="form-control" type="text" value="{{old('shipping_first_name',$checkout_data['shipping_first_name'])}}" name="shipping_first_name">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label for="">Last Name <span>*</span></label>
                              </div>
                              <div class="col-md-9">
                                <input class="form-control" type="text"  value="{{old('shipping_last_name',$checkout_data['shipping_last_name'])}}" name="shipping_last_name">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label for="">Email Address <span>*</span></label>
                              </div>
                              <div class="col-md-9">
                                <input class="form-control"  type="email" value="{{old('shipping_email',$checkout_data['shipping_email'])}}" name="shipping_email">
                              </div>
                            </div>
                          </div>
                  <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <label for="">Phone Number<span>*</span></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <input class="form-control" type="number" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" value="{{old('shipping_phone',$checkout_data['shipping_phone'])}}" name="shipping_phone">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                      <label for="">Country <span>*</span></label>                      
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                      <select  name="shipping_country" class="form-control" id="country" value="{{old('shipping_country',$checkout_data['shipping_country'])}}">
                        <option value="" >Select Country</option>
                        @if(count($countries) > 0)
                          @foreach($countries as $cont)
 <!-- <option value="{{$cont->id}}" data-countryId="{{$cont->id}}" @if($checkout_data["shipping_country"] == $cont->id) selected @endif >{{$cont->country}}</option> -->
 <option value="{{$cont->id}}" data-countryId="{{$cont->id}}" @if(223 == $cont->id) selected @endif >{{$cont->country}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <label for="">Town / City <span>*</span></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <input class="form-control"  type="text" value="{{old('shipping_city',$checkout_data['shipping_city'])}}" name="shipping_city">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <label for="">State / Province<span>*</span></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <input class="form-control" type="text" value="{{old('shipping_state',$checkout_data['shipping_state'])}}" name="shipping_state">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <label for="">Address<span>*</span></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <input class="form-control" type="text" value="{{old('shipping_address',$checkout_data['shipping_address'])}}" name="shipping_address">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <label for="">Zip Code<span>*</span></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <input class="form-control" type="text" value="{{old('shipping_zip',$checkout_data['shipping_zip'])}}" name="billing_zip">
                    </div>
                  </div>
                </div>
                        </div>
                     </div>
                     </div>
                       <div class="col-md-4">
                     <div class="your-order">
                         <div class="cartRight">
                           <div class="crHead">
                             <h5>your order</h5>
                           </div>
                           <div class="crBody">
                             <ul class="list-unstyled">
<?php $subtotal =0; ?>
@foreach($cart as $key=>$value)
  <li>{{$value['name']}} x {{$value['qty']}} <span class="pull-right">${{$value['baseprice'] * $value['qty']}}</span></li>
<?php $subtotal+= $value['baseprice'] * $value['qty']; ?>
@endforeach
                      <li><strong>Sub Total</strong> <span class="pull-right">${{$subtotal}}</span></li>
                      <li><strong>Discount </strong><span class="pull-right">${{$coupondata['discount_amount']}}</span></li>
                      <li><strong>Shipping </strong><span class="pull-right">${{$shipdata['shippment_price']}}</span></li>
                      <li><strong>Order Total</strong> <span class="pull-right">${{$subtotal+$shipdata['shippment_price']-$coupondata['discount_amount']}}</span></li>
                             </ul>
                             <!-- <div class="pay">
                              <h5>Payment Method</h5>
                             <div class="line"></div>
                             </div> -->
                           </div>
                           <div class="crFoot">
                             <!-- <div class="checkbox">
                               <label class="checkbox-container">Credit Card</label><br>
                               <input type="radio" data-category="typeFilters" data-filter="Cheque Payment"><span class="clickable text"><img src="{{asset('/web/images/paypal.png')}}" class="img-responsive" alt="paypal"></span><span class="clickable checkmark"></span>
                             </div> -->
                             <!-- <div class="checkbox pull-left">
                               <label class="checkbox-container">American Express</label><br>
                               <input type="radio" data-category="typeFilters" data-filter="Cheque Payment"><span class="clickable text"><img src="{{asset('/web/images/amExp.png')}}" class="img-responsive" alt="paypal"></span><span class="clickable checkmark"></span>
                             </div> -->
                             <!-- <div class="checkbox pull-right">
                               <label class="checkbox-container">Pay Pal</label><br>
                               <input type="radio" data-category="typeFilters" data-filter="Cheque Payment"><span class="clickable text"><img src="{{asset('/web/images/paypal2.png')}}" class="img-responsive" alt="paypal"></span><span class="clickable checkmark"></span>
                             </div> -->
                             <div class="clearfix"></div>
                             <div class="place text-center">
                               <!-- <a href="#" class="btn">Place Order</a> -->
                                <button type="submit" class="btn">PLACE ORDER</button>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
              </div>
                  <div class="clearfix"></div>
</form>                 
              </div>
              </div>
        </section>
</main>
@endsection
@section('css')
<style type="text/css">
 .checkout-chkk {
    margin-bottom:35px;
  }
</style>
@endsection
@section('js')
<script>
  $(".shipping-info").hide();
    function differentaddress()
    {
        if($('.different_address').is(":checked"))   
            $(".shipping-info").show();
        else
            $(".shipping-info").hide();
    }
</script>
@endsection