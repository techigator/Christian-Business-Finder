@extends('web.layouts.main')
@section('content')
    <!-- START: Inner Banner-->

    {{-- @include('web.layouts.inner_banner') --}}

    {{-- <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> --}}

    <!-- END: Inner Banner-->


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



    <style type="text/css">
        h2 {
            margin: 80px auto;
        }
    </style>

    <main class="cartPg">

        @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                <p>{{ Session::get('success') }}</p>
            </div>
        @endif

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



        <div class="container">

            <div class="row" style="padding-top: 220px;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default credit-card-box">
                        <div class="panel-heading display-table" style="background:#8CC84F; color:white;">
                            <h3 class="panel-title">Payment Details</h3>
                        </div>
                        <div class="panel-body">

                            @if (Session::has('success'))
                                <div class="alert alert-success text-center">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                            @endif

                            <form role="form" action="{{ route('payment.page.post', $amn) }}" method="post"
                                class="require-validation" data-cc-on-file="false"
                                data-stripe-publishable-key="pk_test_51M8ALKAgW8OMwbeWlIQVZDIbJX1S9hMC8vtik17jjS2P04HQi2sbPcxyvKcN90nLJIuYJpeltBZzvT9uh0hfyTWN00r1AqtMkC"
                                id="payment-form">
                                @csrf

                                {{-- <div class="form-group mb-3 card required" hidden>
                                    <label class='form-label'>Amount</label>
                                    <input name="amount" type="number" value="{{ $amn }}"
                                        class="form-control card-number" placeholder="Enter card number..">
                                </div> --}}

                                <div class='form-row row'>
                                    <div class='col-xs-12 form-group card required'>
                                        <label class='control-label'>Card Number</label> <input autocomplete='off'
                                            class='form-control card-number' name="cc_number" size='20' type='text'>
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                                        <label class='control-label'>CVC</label> <input autocomplete='off'
                                            class='form-control card-cvc' name="cc_cvc" placeholder='ex. 311'
                                            size='4' type='text'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Month</label> <input
                                            class='form-control card-expiry-month' name="cc_mm" placeholder='MM'
                                            size='2' type='text'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Year</label> <input
                                            class='form-control card-expiry-year' name="cc_yy" placeholder='YYYY'
                                            size='4' type='text'>
                                    </div>
                                </div>

                                <div class='form-row row'>
                                    <div class='col-md-12 error form-group hide'>
                                        <div class='alert-danger alert'>Please correct the errors and try
                                            again.</div>
                                    </div>
                                </div>

                                <div class="row">
                                    @if ($amn == 0)
                                        <div class="col-xs-12">
                                            <button class="btn btn-lg btn-block" type="submit"
                                                style="background:#8CC84F; color:white;" disabled>Pay Now
                                                (${{ $amn }})</button>
                                        </div>
                                    @else
                                        <div class="col-xs-12">
                                            <button class="btn btn-lg btn-block" type="submit"
                                                style="background:#8CC84F; color:white;">Pay Now
                                                (${{ $amn }})</button>
                                        </div>
                                    @endif

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Custom stripe payment form -->
        {{-- <div class="container" style="padding-top: 230px;">

            <div class="row">
                <div class="col-md-7 col-md-offset-3 mx-auto my-3">
                    <div class="panel panel-default credit-card-box">
                        <div class="panel-heading display-table " style="background:#8CC84F;">
                            <h3 class="panel-title text-center py-2 "><strong>Payment Details</strong></h3>
                        </div>
                        <div class="panel-body p-2 bg-light">

                            <form role="form" action="{{ route('payment.page.post') }}" method="post"
                                class="require-validation" data-cc-on-file="false"
                                data-stripe-publishable-key="pk_test_51M8ALKAgW8OMwbeWlIQVZDIbJX1S9hMC8vtik17jjS2P04HQi2sbPcxyvKcN90nLJIuYJpeltBZzvT9uh0hfyTWN00r1AqtMkC"
                                id="payment-form">
                                @csrf
                                <div class="form-group mb-3 card required" hidden>
                                    <label class='form-label'>Amount</label>
                                    <input name="amount" type="number" value="{{ $amn }}"
                                        class="form-control card-number" placeholder="Enter card number..">
                                </div>
                                <div class="form-group mb-3 card required">
                                    <label class='form-label'>Card Number :</label>
                                    <input name="cc_number" type="number" class="form-control card-number"
                                        placeholder="Enter card number..">
                                </div>
                                <div class="form-group mb-3 cvc required">
                                    <label class='form-label'>CVC :</label>
                                    <input name="cc_cvc" type="number" class="form-control card-cvc"
                                        placeholder="Enter card cvc..">
                                </div>
                                <div class="form-group mb-3 expiration required">
                                    <label class='form-label'>Expiry Month :</label>
                                    <input name="cc_mm" type="number" class="form-control card-expiry-month"
                                        placeholder="Enter exp mm..">
                                </div>
                                <div class="form-group mb-3 expiration required">
                                    <label class='form-label'>Expiry Year :</label>
                                    <input name="cc_yy" type="number" class="form-control card-expiry-year"
                                        placeholder="Enter exp year..">
                                </div>

                                <div class='form-group row'>
                                    <div class='error form-group' hidden>
                                        <div class='alert-danger alert'>Please correct the errors and try again.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <button class="btn btn-success btn-lg btn-block" type="submit">Pay
                                            (${{ $amn }})</button>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>

        </div> --}}

    </main>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    {{-- <script type="text/javascript">
        $(function() {

            /*------------------------------------------
            --------------------------------------------
            Stripe Payment Code
            --------------------------------------------
            --------------------------------------------*/

            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            /*------------------------------------------
            --------------------------------------------
            Stripe Response Handler
            --------------------------------------------
            --------------------------------------------*/
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];

                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script> --}}


    <script type="text/javascript">
        $(function() {

            /*------------------------------------------
            --------------------------------------------
            Stripe Payment Code
            --------------------------------------------
            --------------------------------------------*/

            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=number]', 'input[type=number]',
                        'input[type=number]', 'input[type=number]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            /*------------------------------------------
            --------------------------------------------
            Stripe Response Handler
            --------------------------------------------
            --------------------------------------------*/
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];

                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        });
    </script>



@section('css')
    <style type="text/css">
    </style>
@endsection



@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', ".remove", function(e) {
                $('#product_id').val($(this).attr('data-prod-id'));
                $('#remove-cart').submit();
            });
            $(document).on('click', ".updateCart", function(e) {
                $('#type').val($(this).attr('data-attr'));
                $('#update-cart').submit();
            });
        });
    </script>
@endsection

@endsection
