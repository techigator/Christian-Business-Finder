@extends('web.layouts.main')
@section('content')
     <section class="add-to-cart about_section">
      <div class="container">
        <div class="row">
          <div class="col-md-9 col-sm-9 col-xs-12">
          <div class="table-responsive">
            <form method="post" action="{{ route('remove_cart') }}" id="remove-cart">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" id="product_id" value="">
                    </form>
            <table class="table">
              <thead>
                <tr>
                  <th>Item</th>
                  <th class="">Quantity</th>
                  <th>Unit Price</th>
                  <th>Sub Price</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <form method="post" action="{{ route('update_cart') }}" id="update-cart">
                                        {{ csrf_field() }}  
                 <input type="hidden" name="type" id="type" value="">
                 <?php
                 // dd($cart);
                 $subtotal=0;
                 ?>
                @foreach($cart as $key=>$value)
                <input type="hidden" name="product_id[]" id="" value="<?php echo $value['id']; ?>">
                <tr class="space">
                  <td class="col-md-4">
                    <div class="row">
                      <div class="table-space">
                        <div class="row">
                          <div class="col-md-5 no-padding ">
                          <div class="product-img">
                            <img src="{{$value['img']}}" alt="" class="img-responsive">
                          </div>
                        </div>
                        <div class="col-md-7 no-space">
                          <h3>{{ $value['name'] }}</h3>
                          <!-- <span>26 Reviews</span> -->
                        </div>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="col-md-3">
                    <div class="number-item">
                      <input class="quant qtystyle" name="qty[]" type="number" value="{{ $value['qty'] }}" min="2" max="9999"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "4" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
                      <a  href="javascript:void(0)"  class="update updateCart" >Update Cart</a>
                      
                    </div>
                  </td>
                  <td class="col-md-3">
                    <h4>${{ $value['baseprice']}}</h4>
                  </td>
                  <td class="col-md-2">
                    <h4>${{ $value['baseprice'] * $value['qty'] }}</h4>
                  </td>
                  <td><a class="remove" href="javascript:void(0)" data-prod-id="<?php echo $value['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">x</a></td>
                </tr>

                @php $subtotal+= $value['baseprice'] * $value['qty']; @endphp 
                @endforeach

              </form>
                
              </tbody>
            </table>
          </div>

          <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
              <div class="proceed">
                <div class="row">
                  <div class="col-md-5 col-sm-12">
                  <a href="{{ route('shop')}}"> <span><</span> Continue Shopping</a>
                </div>
                <div class="col-md-7 col-sm-12 text-center">
                  <a href="{{ route('checkout')}}" class="checkout-btn">Proceed To Checkout</a>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
          <div class="total-section">
            <ul>
              <?php
              // $shipping=Helper::returnFlag(1964);
              // $discount=Helper::returnFlag(1977);
              ?>
              {{--
              <li>Shipping <span>${{$shipping}}</span></li>
              <li>Discount <span>${{$discount}}</span></li>
              <li class="color-change">Total <span>${{$subtotal+$shipping-$discount}}</span></li>
              --}}
              <li>Total <span>${{$subtotal}}</span></li>
            </ul>
          </div>
          <div class="ship-estimate">
            <ul>
              <li>Need Help?</li>
              <li class="grey-style"><a href="tel:<?=str_replace(array(')','(','-',' '),array('','','',''),$setting['company']);?>"><i class="fa fa-phone" aria-hidden="true"></i> <?=$setting['company']?></a></li>
              <li class="grey-style"><a href="mailto:<?=$setting['email']?>"><i class="fa fa-envelope" aria-hidden="true"></i> <?=$setting['email']?></a></li>
            </ul>
          </div>
        </div>
        </div>
      </div>
    </section>


@endsection 
@section('css')
<style type="text/css">
.grey-style a {
    text-align: left;
}
</style>
@endsection 
@section('js')
<script type="text/javascript">
$(document).ready(function (){
    
    $(document).on('click', ".remove", function(e){
     //$(.val($(this).attr('data-prod-id')); 
     //$('#add-cart').submit();
     $('#product_id').val( $(this).attr('data-prod-id') );
     $('#remove-cart').submit();
    });
    
     $(document).on('click', ".updateCart", function(e){
  
     $('#type').val($(this).attr('data-attr'));
     $('#update-cart').submit();
    
     });
   
}); 
</script>
@endsection
