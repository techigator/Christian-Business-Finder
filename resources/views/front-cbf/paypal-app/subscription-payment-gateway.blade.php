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

        .paypal-user-body {
            margin: 0;
            overflow: hidden;
        }
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

    var user_id = '{{ $userId ?? '' }}';
    var amount = '{{ $amount ?? '' }}';

    setTimeout(() => {
        var formData = {
            amount: amount || '',
        };

        $.ajax({
            type: "GET",
            url: "{{ url('/api/subscription-payment-gateway') }}/" + (user_id || '') +'/' + (amount || ''),
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
                        // currency_code: 'GBP', // Set the currency code to GBP
                        value: amount || '',
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
                    user_id: user_id || '',
                    amount: amount || '',
                }

                $.ajax({
                    type: "POST",
                    url: "{{ url('/api/user-update') }}",
                    data: params,
                    success: function (response) {
                        console.log('response', response)
                        if (response.success === true) {
                            console.log('onApprove', response)
                            // window.flutter_inappwebview.callHandler('onApprove', response);
                        } else {
                            console.log('onError', response.message)
                            // window.flutter_inappwebview.callHandler('onError', response.message);
                        }
                    }
                });
            });
        },

        onAuthorize: function (data, actions) {
            console.log('onAuthorize');
            return actions.payment.execute().then(function () {
                var EXECUTE_URL = "{{ url('/api/subscription-payment-gateway') }}/" + (amount || '');
                var params = {
                    payment_status: 'Completed',
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
