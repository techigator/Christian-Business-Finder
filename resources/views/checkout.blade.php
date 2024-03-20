@extends('layouts/app')

@section('title', 'Checkout')

@section('content')

@php
$total=$search->grand_total;


@endphp

<div id="content">
  <section class="banner2" id="scrollhere"></section>
  <section class="main-vehicles-wrap">
     <div class="container">

        <div class="row">
           <!-- <div class="tab">
              <a class="tablinks active" href="#">Basic Information</a>
              <a class="tablinks" href="#">Payment</a>
              </div> -->
           <div class="booking-detail-from">
              <div class="airport-parking-list-form">
                 <div class="col-xs-12 col-sm-6 col-md-6">
                    <h4 style="padding: 5px 0px 5px 0px;color: #fff;">Booking Detail Form</h4>
                 </div>
                 <div class="col-xs-12 col-sm-6 col-md-6 text-right">
                    <span class="" style="padding: 8px; color: #fff;font-size: 15px;font-weight: 600;display: block;">* input fields are mandatory</span>
                 </div>
              </div>
              <div class="col-md-8 col-xs-12" style="border-right: 2px dotted #bfbfbf;">
                 <div class="row" id="affix-row">
                    <div class="left-side wow zoomIn" style="visibility: visible; animation-name: zoomIn;">
                       <form id="checkoutForm" class="checkoutForm" novalidate="novalidate"> @csrf
                          <!-- <input type="hidden" name="quoteToken" value="4639357">
                          <input type="hidden" name="quoteId" value="AQuote:202202031900O12O20220210O20220217O">
                          <input type="hidden" name="customerId" id="customerId" value="">
                          <input type="hidden" name="vehicleId" value="">
                          <input type="hidden" name="bookingId" value="">
                          <input type="hidden" name="paymentId" value="">
                          <input type="hidden" name="siteId" value="1">
                          <input type="hidden" name="airportId" value="12">
                          <input type="hidden" name="airportName" value="Birmingham">
                          <input type="hidden" name="departDate" value="Thu, 10 February 2022">
                          <input type="hidden" name="departTime" value="12:00">
                          <input type="hidden" name="returnDate" value="Thu, 17 February 2022">
                          <input type="hidden" name="returnTime" value="12:00">
                          <input type="hidden" name="noOfDays" value="8">
                          <input type="hidden" name="promoCode" value="">
                          <input type="hidden" name="discountAmount" value="0.00">
                          <input type="hidden" name="bookingAmount" value="55.50">
                          <input type="hidden" name="productId" value="379">
                          <input type="hidden" name="productName" value="Birmingham Bluecircle Meet &amp; Greet non flex">
                          <input type="hidden" name="serviceType" value="1">
                          <input type="hidden" name="productOffer" value="0">
                          <input type="hidden" name="valetService" value="0">
                          <input type="hidden" name="productNonFlex" value="1">
                          <input type="hidden" name="marketingCampaign" value="">
                          <input type="hidden" name="googleId" value="">
                          <input type="hidden" name="bookingFee" value="1.95">
                          <input type="hidden" name="cancelCharges" id="cancelCharges" value="0.00">
                          <input type="hidden" name="smsCharges" id="smsCharges" value="0.00">
                          <input type="hidden" name="postalCharges" id="postalCharges" value="0.00">
                          <input type="hidden" name="totalAmount" id="totalAmount" value="57.45">
                          <input type="hidden" name="paymentMethod" id="paymentMethod" value="CreditCard">
                          <input type="hidden" name="levyCharges" id="levyCharges" value="0.00"> -->
                          <div class="customer-detail">

                              

                              
                                <div id="payment-response">
                                  <div class="alert alert-info payment-alert m-bottom-no">
                                    <b>Returning customer? Click here to login</b>
                                    <!-- <a href="#loginModal" data-toggle="modal"><b>Login</b></a> -->

                                    <button href="#loginModal" data-toggle="modal" class="btn btn-sm btn-success btn-ask-question"><b>Login</b></button>

                                  </div>
                                </div>
                              
                              
                              <div class="col-md-12 form-group">
                                <h3 class="bookingDetailsFormHead3">Your Details</h3>
                             </div>
                             <div class="col-sm-2 col-md-2">
                                <div class="form-group icon-input">
                                   <label>Title <span class="required-field">*</span></label>
                                   <select class="form-control" name="title" required>
                                      <option value="Mr.">Mr.</option>
                                      <option value="Mrs.">Miss.</option>
                                      <option value="Miss.">Mrs.</option>
                                      <option value="Ms.">Ms.</option>
                                   </select>
                                   <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                </div>
                             </div>
                             <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="firstName">First Name <span class="required-field">*</span></label>
                                   <input type="text" id="first_name" name="first_name" class="form-control" required>
                                </div>
                             </div>
                             <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="lastName">Last Name <span class="required-field">*</span></label>
                                   <input type="text" id="last_name" name="last_name" class="form-control" required>
                                </div>
                             </div>
                             <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                   <label for="customerMobile">Mobile Number <span class="required-field">*</span></label>
                                   <input type="number" id="mobile" name="mobile" class="form-control" required>
                                </div>
                             </div>
                             <div class="clearfix"></div>
                             <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                   <label for="email">Email Address <span class="required-field">*</span> <span style="padding-left:5px;color: #28c2e4;"><i class="fa fa-question-circle-o" data-toggle="popover" data-placement="top" data-trigger="hover" title="" data-content="This is the email address you will recieve confirmation which includes booking reference and parking procedures." data-container="body" data-original-title="Bookig Confirmation"></i></span></label>
                                   <input type="email" id="email_address" name="email_address" class="form-control" required>
                                </div>
                             </div>
                             <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                   <label for="email">Confirm Email Address <span class="required-field">*</span></label>
                                   <input type="email" id="confirm_email" name="confirm_email" class="form-control" autocomplete="off" required>
                                </div>
                             </div>
                             <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                   <label for="customerMobile">Password <span class="required-field">*</span></label>
                                   <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                             </div>
                             <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                   <label for="customerMobile">Confirma Password <span class="required-field">*</span></label>
                                   <input type="password" id="conf_password" name="conf_password" class="form-control" required>
                                </div>
                             </div>
                          </div>
                          <div class="clearfix"></div>
                          <div class="col-md-12">
                             <h3 class="bookingDetailsFormHead3">Travel Details</h3>
                          </div>
                          <div class="col-md-12">
                             <div class="form-group">
                                <small style="font-size: 13px;">Do you know travel details?  &nbsp; </small>
                                <div class="radio radio-tap" style="display: inline-block;margin-right: 20px;">
                                   <input type="radio" name="travel_detail" id="td0" value="0">
                                   <label for="td0">No</label>
                                </div>
                                <div class="radio radio-tap" style="display: inline-block;">
                                   <input type="radio" name="travel_detail" id="td1" value="1" checked="checked">
                                   <label for="td1">Yes</label>
                                </div>
                             </div>
                          </div>
                          <div class="travel-detail d-block">
                             <div class="col-sm-3 col-md-3">
                                <div class="form-group icon-input">
                                   <label>Terminal Out <span class="required-field">*</span></label>
                                   <select class="form-control" name="terminal_out" id="terminal_out" required="">
                                      @foreach(json_decode($search->terminals) as $terminal)
                                      <option value="{{$terminal->id}}">{{$terminal->terminal_name}}</option>
                                      @endforeach
                                   </select>
                                   <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                </div>
                             </div>
                             <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="departFlight">Outbound Flight </label>
                                   <input type="text" id="outbound_flight" name="outbound_flight" class="form-control" placeholder="TBC" required>
                                </div>
                             </div>
                             <div class="col-sm-3 col-md-3">
                                <div class="form-group icon-input">
                                   <label>Terminal In<span class="required-field">*</span></label>
                                   <select class="form-control" name="terminal_in" id="terminal_in" required>
                                      @foreach(json_decode($search->terminals) as $terminal)
                                      <option value="{{$terminal->id}}">{{$terminal->terminal_name}}</option>
                                      @endforeach
                                   </select>
                                   <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                </div>
                             </div>
                             <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="departFlight">Return Flight </label>
                                   <input type="text" id="return_flight" name="return_flight" class="form-control" placeholder="TBC" required>
                                </div>
                             </div>
                          </div>
                          <div class="col-md-12">
                             <hr>
                          </div>
                          <div class="col-md-12">
                             <h3 class="bookingDetailsFormHead3">Vehicle Details</h3>
                          </div>
                          <div class="col-md-12">
                             <div class="form-group">
                                <small style="font-size: 13px;">Do you know vehicle details? &nbsp;</small>
                                <div class="radio radio-tap" style="display: inline-block;margin-right: 20px;">
                                   <input type="radio" name="vehicle_detail" id="vd0" value="0">
                                   <label for="vd0">No</label>
                                </div>
                                <div class="radio radio-tap" style="display: inline-block;">
                                   <input type="radio" name="vehicle_detail" id="vd1" value="1" checked="checked">
                                   <label for="vd1">Yes</label>
                                </div>
                             </div>
                          </div>
                          <!--? } ?-->
                          <input type="hidden" name="vehiclePassengers" id="vehiclePassengers" value="0" required="">
                          <div class="clearfix"></div>
                          <div class="vehicle-detail d-block">
                             <!--<div class="col-md-6">-->
                             <!--    <div class="form-group">-->
                             <!--        <label for="vehiclePassengers">No. of Passengers <span class="required-field">*</span></label>-->
                             <!--        <input type="number" class="form-control" name="vehiclePassengers" id="vehiclePassengers" value="" placeholder="Enter No of Passengers" required>-->
                             <!--    </div>-->
                             <!--</div>-->
                             <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="vehicleMake">Make <span class="required-field">*</span></label>
                                   <input type="text" id="make" name="make" class="form-control" required>
                                </div>
                             </div>
                             <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="vehicleModel">Model <span class="required-field">*</span></label>
                                   <input type="text" id="model" name="model" class="form-control" required>
                                </div>
                             </div>
                             <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="vehicleColour">Colour <span class="required-field">*</span></label>
                                   <input type="text" id="color" name="color" class="form-control" required>
                                </div>
                             </div>
                             <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                   <label for="vehicleRegno">Registration <span class="required-field">*</span></label>
                                   <input type="text" id="registration" name="registration" class="form-control" required>
                                </div>
                             </div>
                          </div>
                          
                          <div class="optional-services">
                             <div class="col-md-12 form-group m-bottom-20">
                                <h3 class="bookingDetailsFormHead3">Optional Extras</h3>
                             </div>
                             @php $total=$search->grand_total; @endphp
                             @foreach($vas as $vs)
                               
                              <!-- Add booking fee to total -->
                              @if($vs->id==1)
                                @php 
                                $booking_fee=$vs->rate;
                                $total+=$vs->rate;
                                /* continue; */
                                @endphp

                              @endif
                              <!-- Add booking fee to total -->

                              <div class="col-md-12 m-bottom-20 {{($vs->id==1)?'hide':''}} ">
                                <div class="a2z-checkbox checkbox-primary">
                                   <input type="checkbox" id="checkbox{{$vs->id}}" name="vas[]" class="styled" value="{{$vs->id}}" data-title="{{$vs->title}}" data-rate="{{$vs->rate}}" {{($vs->id==1)?'checked':''}}>
                                   <label for="checkbox{{$vs->id}}" style="font-weight:600;"> {{$vs->title}} - £<span>{{$vs->rate}}</span> </label>
                                   <!-- <p><small class="text-info text-fall" style="font-size: 13px;color: #114d5f;">You will receive your parking booking confirmation to your mobile for fast and easy check in.</small></p> -->
                                </div>
                              </div>
                             
                             @endforeach
                          </div>
                          
                          
                          <div class="payment-option payzone-form-section" style="float: left;margin-left: -15px;margin-right: -15px;background: #fdfcf3;padding: 20px 30px 10px 30px;margin-top:10px;">
                             <div class="row m-bottom-10">
                                <div class="col-md-4 form-group col-md-4 col-sm-12 col-xs-12">
                                   <h3 style="font-size: 20px;">Total: <em style="font-weight:600;">£</em><span id="total-bottom" style="font-weight:600;">{{$total}}</span></h3>
                                   <small style="font-size:11px;">£{{$booking_fee}} booking fee included.</small>
                                </div>
                                <div class="col-md-8 form-group col-md-8 col-sm-12 col-xs-12 text-center">
                                  <img src="{{asset('assets/frontend_assets/images/payment_image.png')}}" alt="payment" class="img-responsive">
                                   <!-- <img src="{{asset('assets/frontend_assets/images/paymenticons/payment_image_7.png')}}" class="img-responsive" style="display: inline-block;width: 52px;margin-right: 1px;">
                                   <img src="{{asset('assets/frontend_assets/images/paymenticons/payment_image_8.png')}}" class="img-responsive" style="display: inline-block;width: 52px;margin-right: 1px;">
                                   <img src="{{asset('assets/frontend_assets/images/paymenticons/payment_image_9.png')}}" class="img-responsive" style="display: inline-block;width: 52px;margin-right: 1px;">
                                   <img src="{{asset('assets/frontend_assets/images/paymenticons/payment_image_11.png')}}" class="img-responsive" style="display: inline-block;width: 52px;margin-right: 1px;">
                                   <img src="{{asset('assets/frontend_assets/images/paymenticons/payment_image_12.png')}}" class="img-responsive" style="display: inline-block;width: 52px;margin-right: 1px;">
                                   <img src="{{asset('assets/frontend_assets/images/paymenticons/payment_image_13.png')}}" class="img-responsive" style="display: inline-block;width: 52px;"> -->
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-sm-6 col-md-6">
                                   <div class="form-group">
                                      <label for="cardName">Name on Card <span class="required-field">*</span></label>
                                      <input type="text" class="form-control" name="cardName" id="cardName" value="" required="">
                                   </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                   <div class="form-group">
                                      <label for="cardNumber">Card Number <span class="required-field">*</span></label>
                                      <input type="number" class="form-control" name="cardNumber" id="cardnumber" value="" maxlength="19" required="">
                                   </div>
                                </div>
                             </div>
                             <div class="row m-bottom-10">
                                <div class="col-sm-3 col-md-3">
                                   <div class="form-group icon-input">
                                      <label for="expiryDateMonth">Expiry Month <span class="required-field">*</span></label>
                                      <select name="expiryDateMonth" class="form-control" required="">
                                         <option value="">Select Month</option>
                                         <option value="01">01</option>
                                         <option value="02">02</option>
                                         <option value="03">03</option>
                                         <option value="04">04</option>
                                         <option value="05">05</option>
                                         <option value="06">06</option>
                                         <option value="07">07</option>
                                         <option value="08">08</option>
                                         <option value="09">09</option>
                                         <option value="10">10</option>
                                         <option value="11">11</option>
                                         <option value="12">12</option>
                                      </select>
                                      <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                   </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                   <div class="form-group icon-input">
                                      <label for="expiryDateYear">Expiry Year <span class="required-field">*</span></label>
                                      <select name="expiryDateYear" class="form-control" required="">
                                         <option value="">Select Year</option>
                                         <option value="19">2019</option>
                                         <option value="20">2020</option>
                                         <option value="21">2021</option>
                                         <option value="22">2022</option>
                                         <option value="23">2023</option>
                                         <option value="24">2024</option>
                                         <option value="25">2025</option>
                                         <option value="26">2026</option>
                                         <option value="27">2027</option>
                                         <option value="28">2028</option>
                                         <option value="29">2029</option>
                                         <option value="30">2030</option>
                                         <option value="31">2031</option>
                                         <option value="32">2032</option>
                                         <option value="33">2033</option>
                                         <option value="34">2034</option>
                                      </select>
                                      <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                   </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                   <div class="form-group">
                                      <label for="cvvNumber">CV2 <span class="required-field">*</span></label>
                                      <input type="number" class="form-control" name="cvvNumber" value="" maxlength="4" required="">
                                   </div>
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-md-12 m-bottom-15">
                                   <div class="a2z-checkbox checkbox-primary">
                                      <input type="checkbox" id="terms" name="terms" class="styled" value="1" required="required">
                                      <label for="terms">On making payment you agree to Total Airport Parking Ltd. <a href="#termsconditions" data-toggle="modal"><b>Terms and Conditions</b></a> and <a href="#privacypolicy" data-toggle="modal"><b>Privacy Policy</b></a></label>
                                      <div id="termserror"></div>
                                   </div>
                                </div>
                                <input type="hidden" name="parking_detail" value="{{json_encode($search)}}">
                                <input type="hidden" name="customer_type" value="new">                                
                                <div class="col-md-12 form-group">
                                   <button type="submit" class="btn btn-success booknow btn-ask-question" style="font-size: 16px;">Confirm Booking <i class="fa fa-check"></i></button>
                                </div>
                             </div>
                          </div>
                          <div class="clear"></div>
                          <div class="row">
                             <div id="payment-response">
                                <div class="alert alert-info payment-alert m-bottom-no text-center"><b>We do not store Credit / Debit Card information, entered card information will be SSL Secure &amp; 256bit Encrypted.</b></div>
                             </div>
                          </div>
                       </form>
                    </div>
                 </div>
              </div>
              <div class="col-md-4 col-xs-12">
                 <div class="quote-block booking-page wow zoomIn" id="sidebar" style="visibility: visible; animation-name: zoomIn;">
                    <div class="col-sm-4 col-md-12 main-img" style="margin-bottom:15px;">
                       <img class="img-responsive booking-page-img booking-quote-block-img" src="{{$search->product_logo}}">
                    </div>
                    <div class="col-sm-8 col-md-12 info-block">
                       <div class="row">
                          <div class="col-md-12 form-group">
                             <h4 class="text-center" style="color: #006794;font-weight: 600;">
                                {{$search->airport_name.' '.$search->brand_name.' '.$search->parking_type }}  
                             </h4>
                             <!----- <div class="info-b pull-right" style="margin-top:5px;">
                                <a href="#" style="font-size:13px;margin-bottom:5px;" data-prodid="">More Info + </a>
                                </div> ------>
                          </div>
                          <div class="col-md-12">
                             <hr>
                          </div>
                          <div class="col-md-12 form-group">
                             <span style="font-size: 14px;">Location: <span class="pull-right" style="color: #7b7b7b;"><b>{{$search->airport_name}} Airport</b></span></span>
                          </div>
                          <div class="col-md-12 form-group">
                             <span style="font-size: 14px;">Drop-off: <span class="pull-right" style="color: #7b7b7b;"><b>{{$search->dropoff}}</b> at <b>{{$search->dropoff_time}}</b></span></span>
                          </div>
                          <div class="col-md-12 form-group">
                             <span style="font-size: 14px;">Pick-Up: <span class="pull-right" style="color: #7b7b7b;"><b>{{$search->pickup}}</b> at <b>{{$search->pickup_time}}</b></span></span>
                          </div>
                          <div class="col-md-12">
                             <hr>
                          </div>
                          <div class="col-md-12">
                             <div class="info-b">
                                <span style="font-size: 14px;">Booking Quote: <span class="pull-right" style="color: #7b7b7b;">£ <b>{{$search->grand_total}}</b></span></span>
                             </div>
                          </div>
                          <div class="col-md-12">
                             <hr>
                          </div>
                          <div class="col-md-12">
                             <span style="font-size: 14px;">
                                Booking Fee <span style="color: #28c2e4;"><i class="fa fa-question-circle-o" data-toggle="popover" data-placement="top" data-trigger="hover" title="" data-content="We want to provide the best and most convenient parking booking service for our customers. To make this possible it takes considerable resource, both in terms of staffing and investment. The booking fee enables us to ensure that you will enjoy the best possible customer experience when you book through us." data-container="body" data-original-title="Why We Charge Booking Fee ?"></i></span>
                                <span class="pull-right" style="color: #7b7b7b;font-size: 13px;">£ <b>{{$booking_fee}}</b></span><br>
                                <p>
                                   <small class="text-info text-fall" style="font-size: 13px;color: #114d5f;">
                                      No hidden charges 
                                   </small>
                                </p>
                             </span>
                          </div>
                          <div class="col-md-12">
                             <hr>
                          </div>

                          @if($search->exitfee_amount && ($search->exitfee_amount>0))
                          @php $total+=$search->exitfee_amount; @endphp
                          <div class="col-md-12">
                             <span style="font-size: 14px;">
                                Access Charges <span style="color: #28c2e4;"><i class="fa fa-question-circle-o" data-toggle="popover" data-placement="top" data-trigger="hover" title="" data-content="An airport access fee is a payment made by Meet and Greet companies to the airport's management for allowing them to operate their services there." data-container="body" data-original-title="Why We Charge Access Fee ?"></i></span>
                                <span class="pull-right" style="color: #7b7b7b;font-size: 13px;">£ <b>{{$search->exitfee_amount}}</b></span><br>
                                <!-- <p>
                                   <small class="text-info text-fall" style="font-size: 13px;color: #114d5f;">
                                      No hidden charges 
                                   </small>
                                </p> -->
                             </span>
                          </div>
                          <div class="col-md-12">
                             <hr>
                          </div>
                          @endif

                       </div>
                       <div class="row">
                          <div class="col-md-12">
                             <span style="font-size: 25px;">Total Payable: <span class="pull-right" style="color: #7b7b7b;">£ <b>
                              <span id="total-side">{{$total}}</span></b>
                             </span>
                             </span>
                          </div>
                       </div>
                    </div>
                 </div>
                 <div class="review-slider m-top-10 hidden-xs hidden-sm" style="display: none; opacity: 0;">
                 </div>
              </div>
           </div>
        </div>
     </div>
  </section>
</div>

<!-- Login Modal Window -->
<div id="loginModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog customer-login-modal">
    <div class="modal-content">
      <div class="modal-header text-center manage-modal-header">
        <button type="button" class="close manage-modal-btn" data-dismiss="modal">×</button>
        <h4 class="modal-title" style="font-size:19px;">Total Airport Parking Login</h4>
      </div>
      <div class="modal-body" style="padding: 0px;background: url(assets/images/bg-1.png);">
        <div class="row">
          <div class="managebookingoption">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-responsive-15">
              <div class="well m-bottom-no no-border">
                <div class="row">  
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <div class="login-detail">
                        <form id="bookingLoginForm">@csrf
                          <div class="col-xs-12 form-group">
                            <label for="username" class="m-bottom-5" style="display:block;">Email Address <span>*</span></label>
                            <input type="text" class="form-control" name="email" id="lgn_email" placeholder="Email Address" required="required">
                          </div>
                          <div class="col-xs-12 form-group">
                            <label for="password" class="m-bottom-5" style="display:block;">Password <span>*</span></label>
                            <input type="password" class="form-control" name="password" id="lgn_password" placeholder="Password" required="required">
                          </div>

                          <div class="col-xs-12 form-group">
                            <!--  -->
                            <div class="a2z-checkbox" style="display:inline; padding-bottom: 28px;">
                              <label style="line-height: 20px;">
                                <input type="checkbox" name="remember" id="remember"> Remember login
                              </label>
                            </div>
                            <!--  -->

                            <a href="javascript:;" class="pull-right" style="font-size: 13px;line-height: 22px;color: #0e5288;" target="_blank">Forgot Password ?</a>
                          </div>

                          <!-- <div class="col-xs-12">
                            <div class="a2z-checkbox" style="padding-bottom: 28px;">
                              <label style="line-height: 20px;">
                                <input type="checkbox" name="remember" id="remember"> Remember login
                              </label>

                            </div>
                          </div> -->
                          <div class="col-xs-12">
                            <button type="submit" class="btn btn-block btn-success btn-ask-question bookingLogin" style="font-weight:600; padding: 6px 30px;">Login</button>
                          </div>
                        </form>
                      </div>
                  </div>
                </div>
              </div>
            </div>
             
           
          </div>
            <div class="managebookingresult"></div>
              <div class="popup-error">
            <div class="col-xs-12">
              <hr style="margin: 0px;">
            </div>
                  <div class="col-xs-12 pop-up-messages">
                <div class="alert alert-info text-center" style="margin: 0px;">Info! Please Use <strong>Search Booking(s)</strong> Option to Retrieve a Booking.</div>
            </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Login Modal Window -->

@endsection

@push('scripts')
<script type="text/javascript">
   $("input[name=travel_detail]").change(function() {
      if ($("#td1").prop("checked")) {
         //$('#return_flight').val('');
         $('#terminal_out, #outbound_flight, #terminal_in, #return_flight').val('');
         $('.travel-detail').fadeIn('slow');
      }
      else if ($("#td0").prop("checked")){
         //$('#terminal_out, #terminal_in').append('<option value="TBC" selected="selected">TBC</option>');
         //$('#return_flight').val('TBC');
         $('#terminal_out, #outbound_flight, #terminal_in, #return_flight').val('TBC');
         $('.travel-detail').fadeOut('slow');
      }
   });

   $("input[name=vehicle_detail]").change(function() {
      if ($("#vd1").prop("checked")) {
         $('#make, #model, #color, #registration').val('');
         $('.vehicle-detail').fadeIn('slow');
      } else if ($("#vd0").prop("checked")) {
         $('#make, #model, #color, #registration').val('TBC');
         $('.vehicle-detail').fadeOut('slow');
      }
   });

  $(document).on("change", ".optional-services input[type=checkbox]", function () {
    
    var total = $("#total-side").html();
    
    if ($(this).is(':checked')){
      total = (Number(total) + Number($(this).data("rate"))).toFixed(2);
      toastr.success($(this).data('title')+" Added<br /> Total Amount Has Been Updated");
    }
    else{
      total = (Number(total) - Number($(this).data("rate"))).toFixed(2);
      toastr.info($(this).data('title')+" Removed<br /> Total Amount Has Been Updated");
    }
    
    $("#total-side").html(total);
    $("#total-bottom").html(total);

  });

  $("#checkoutForm").validate({
      /*rules: {
          registration: {
              required: {
                  depends:  function(element) { return $("#vd1").prop("checked"); }
              }
          }
      },*/

      rules: {

            first_name : {
                required: true,
                minlength: 3
            },
            last_name : {
                required: true,
                minlength: 3
            },
            email_address: {
                required: true,
                email: true,

                remote: {
                        url: '{{url("checkout/check-email")}}',
                        type: "post",
                        data: {
                            _token:"{{ csrf_token() }}"
                            },
                        dataFilter: function (data) {
                            var json = JSON.parse(data);
                            HoldOn.close();
                            if (json.msg) {
                                $('#loginModal').modal({show:true});
                                return "\"" + "Email address already in use" + "\"";
                                
                            } else {
                                return 'true';
                            }
                        }
                    }


            },
            confirm_email: {
                equalTo: "#email_address"
            },
            password: {
                required: true,
                minlength: 5
            },
            conf_password: {
                equalTo: "#password"
            },
            /*cc_number: {
                minlength: 13,
                maxlength: 16
            },
            cc_mm: {
                minlength: 2,
                maxlength: 2
            },
            cc_yy: {
                minlength: 4,
                maxlength: 4  
            },
            cc_cvv:{
                minlength: 3,
                maxlength: 3    
            }*/
      },
      messages: {            
          email: {
              required: "Email is required!",
              email: "Enter A Valid EMail!",
              remote: "Email address already in use!"
          }
      },

      submitHandler: function(form) {

        if(!$("#terms").is(':checked')){
          toastr.error('Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy');
          return false;
        }

        var url = '{!! URL("checkout/payment") !!}';
        $.ajax({
              url: url,
              type: 'post',
              data: $(form).serialize(),
              success: function (response) { 
                if(response.status)
                {
                  /*HoldOn.close();
                  toastr.success(response.booking_id);*/
                  window.location.replace(response.url);
                }
                else
                {
                  HoldOn.close();
                  toastr.error(response.msg);
                }

                overlay.addClass("d-none");

              }, error: function (error) {
                  HoldOn.close();
                  toastr.error("Some error occured!");
              }
        });

      }

  });

  

  $(document).on("click", ".bookingLogin", function (e) {
    e.preventDefault();

    if(!$("#bookingLoginForm").valid())
      return false;

    var url = '{!! URL("checkout/login") !!}';
    var form=$(this).closest('form').serialize();
    $.ajax({
              url: url,
              type: 'post',
              data: form,
              success: function (response) {
                if(response.status)
                {
                  toastr.success('Sign in');
                  location.reload();
                }
                else
                {
                  HoldOn.close();
                  toastr.error(response.msg);
                }
              }, error: function (error) {
                  HoldOn.close();
                  toastr.error("Some error occured!");
              }
          });

  });

</script>
@endpush

@push('css')
@endpush