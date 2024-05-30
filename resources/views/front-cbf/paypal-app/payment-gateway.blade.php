<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PayPal Transaction</title>
    <script
        src="https://www.paypal.com/sdk/js?client-id=AQosDam3xY-0pqhBdIFsTAGWK32_hpJTRf4KLyuoskKV0GG8rYkK9b__JUD0Xp2o0zX9qVaOIliiK78P&currency=USD"></script>

    <style>
        .paypal-user-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            margin: 0;
        }

        .categ-content {
            background: #F1E4D4;
            padding: 5rem;
            border-radius: 5px;
        }
        .paypal-user-body{margin: 0; overflow: hidden;}
    </style>
</head>

<body class="paypal-user-body">

<section class="paypal-user-section">
    <div class="container categ-content">
        <div class="col-md-10">
            <div id="paypal-button-container"></div>
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $('.button_1').click(function () {
        console.log('Working');
    });

    var amount = '{{ $amount ?? '' }}';
    var requestData = '';

    function receiveDataFromApp (data) {
        console.log('Received data from Flutter:', true);
        requestData = data;
    }

    setTimeout(() => {
        var formData = {
            amount: amount || '0',
        };

        $.ajax({
            type: "GET",
            url: "{{ url('/api/paypal-payment-gateway') }}/" + (amount || '0'),
            headers: {
                'Content-Type': 'application/json',
            },
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
                        value: amount || '0',
                    }
                }]
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
                // window.flutter_inappwebview.callHandler('onRequest', true);

                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                var params = {
                    type: requestData.type || "",
                    name:  requestData.name || "",
                    email:  requestData.email || "",
                    service:  requestData.service || "",
                    number:  requestData.number || "",
                    buisness_phone_number:  requestData.number || "",
                    password:  requestData.password || "",
                    password_confirmation:  requestData.password || "",
                    buisness_type:  requestData.buisness_type || "",
                    buisness_name:  requestData.buisness_name || "",
                    buisness_description:  requestData.buisness_description || "",
                    buisness_categories:  requestData.buisness_categories || "",
                    location:  requestData.location || "",
                    longitude:  requestData.longitude || "",
                    latitude:  requestData.latitude || "",
                    web_link:  requestData.web_link || "",
                    home_church_name:  requestData.home_church_name || "",
                    home_church_address:  requestData.home_church_address || "",
                    view_as:  requestData.view_as || "",
                    denomination:  requestData.denomination || "",
                    fcm_token:  requestData.fcm_token || "",
                    referral_code:  requestData.referral_code || "",
                    coupon_code:  requestData.coupon_code || "",
                    amount:  amount || "",
                };

                $.ajax({
                    type: "POST",
                    url: "{{ url('/api/user-create') }}",
                    data: params,
                    success: function (response) {
                        console.log('response', response)
                        if (response.success === true) {
                            window.flutter_inappwebview.callHandler('onApprove', response);
                        } else {
                            window.flutter_inappwebview.callHandler('onError', response.message);
                        }
                    }
                });
            });
        },
        onAuthorize: function (data, actions) {
            console.log('onAuthorize');
            return actions.payment.execute().then(function () {
                var EXECUTE_URL = "{{ url('paypal-payment-gateway') }}/" + (amount || '');
                var params = {
                    payment_status: 'Completed'
                };

                if (paypal.request.post(EXECUTE_URL, params)) {
                    if (params.payment_status === 'Completed') {
                        // setInterval(function(){
                        //  createToast('success','Payment has been done Successfully.');
                        //    // window.location = './invoice/index.php?invoicekey='+params.invoice_id
                        // }, 3000);
                    } else {
                        createToast('error', 'Payment Failed.');
                    }
                }
            }).catch(function (error) {
                createToast('error', 'Payment Failed.');
            });
        }
    }).render('#paypal-button-container');
</script>
</body>
</html>
