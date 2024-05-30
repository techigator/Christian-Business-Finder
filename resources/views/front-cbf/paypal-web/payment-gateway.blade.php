<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PayPal Transaction</title>
    <!-- Include the PayPal JavaScript SDK -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=AQosDam3xY-0pqhBdIFsTAGWK32_hpJTRf4KLyuoskKV0GG8rYkK9b__JUD0Xp2o0zX9qVaOIliiK78P&currency=USD"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
          integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <style>
        #paypal-button-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            justify-content: center;
            margin: 20rem 0;
            align-items: center;
        }

        .categ-content {
            background: #F1E4D4;
            padding: 5rem;
            border-radius: 5px;
        }
    </style>
</head>
<body style="margin: 0 auto;padding: 20px 20px; ">
<section class="paypal-user-section">
    <div class="container categ-content">
        <div class="col-md-10">
            <div id="paypal-button-container"></div>
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $('.button_1').click(function () {
        console.log('Working');
    })

    var requestData = <?php echo json_encode($requestData ?? ''); ?>;
    var subscriptionAmount = requestData.amount || '';

    setTimeout(() => {
        var formData = {
            type: "credit",
            amount: subscriptionAmount || '',
        };

        $.ajax({
            type: "GET",
            url: "{{ route('payment', ['amount' => '']) }}/${subscriptionAmount}",
            data: formData,
            success: function (response) {
                $("#result").html(response);
            }
        });
        console.log('5sec passed');
    }, 5000)

    paypal.Buttons({
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        // currency_code: 'GBP',
                        value: subscriptionAmount || '',
                    }
                }]
            });
        },

        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                var params = {
                    type: requestData.type || '',
                    name: requestData.name || '',
                    email: requestData.email || '',
                    service: requestData.service || '',
                    number: requestData.number || '',
                    business_phone_number: requestData.business_phone_number || '',
                    password: requestData.password || '',
                    password_confirmation: requestData.password_confirmation || '',
                    business_type: requestData.business_type || '',
                    business_name: requestData.business_name || '',
                    business_description: requestData.business_description || '',
                    business_categories: requestData.business_categories || '',
                    location: requestData.location || '',
                    longitude: requestData.longitude || '',
                    latitude: requestData.latitude || '',
                    web_link: requestData.web_link || '',
                    home_church_name: requestData.home_church_name || '',
                    home_church_address: requestData.home_church_address || '',
                    view_as: requestData.view_as || '',
                    denomination: requestData.denomination || '',
                    referral_code:  requestData.referral_code || "",
                    coupon_code:  requestData.coupon_code || "",
                    amount:  subscriptionAmount || "",
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('user.web.create') }}",
                    data: params,
                    success: function (response) {
                        if (response.success === true) {
                            toastr.success(response.message);
                            window.location.href = '{{ route('front.index') }}';
                        } else {
                            toastr.error(response.message);
                            window.location.href = '{{ route('front.signup') }}';
                        }
                    }
                });
            });
        },

        onAuthorize: function (data, actions) {
            return actions.payment.execute().then(function () {
                var EXECUTE_URL = "{{ route('payment', ['amount' => '']) }}/${subscriptionAmount}";
                var params = {
                    payment_status: 'Completed',
                };

                if (paypal.request.post(EXECUTE_URL, params)) {
                    if (params.payment_status == 'Completed') {
                    } else {
                        createToast('error', 'Payment Failed.');
                    }
                }
            }).catch(function (error) {
                createToast('error', 'Payment Failed.');
            });
        },

        onCancel: function (data) {
            window.flutter_inappwebview.callHandler('onCancel');
        },

        onError: function (err) {
            console.error(err);
            window.flutter_inappwebview.callHandler('onError', 'Payment failed');
        }
    }).render('#paypal-button-container');
</script>
</body>
</html>
