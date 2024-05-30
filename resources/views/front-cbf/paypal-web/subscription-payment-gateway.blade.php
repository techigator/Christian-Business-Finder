<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PayPal Transaction</title>
    <script
        src="https://www.paypal.com/sdk/js?client-id=AQosDam3xY-0pqhBdIFsTAGWK32_hpJTRf4KLyuoskKV0GG8rYkK9b__JUD0Xp2o0zX9qVaOIliiK78P&currency=USD"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
          integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $('.button_1').click(function () {
        console.log('Working');
    });

    var requestData = <?php echo json_encode($requestData ?? ''); ?>;
    var user_id = requestData.user_id || '';
    var amount = requestData.amount || '';
    var coupon_code = requestData.coupon_code || '';
    var referral_code = requestData.referral_code || '';

    setTimeout(() => {
        var formData = {
            amount: amount || '',
        };

        $.ajax({
            type: "GET",
            url: "{{ route('subscription.payment.gateway') }}/" + (user_id || '') +'/' + (amount || ''),
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
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                var params = {
                    user_id: user_id || '',
                    amount: amount || '',
                    coupon_code: coupon_code || '',
                    referral_code: referral_code || '',
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('user.subscription.update') }}",
                    data: params,
                    success: function (response) {
                        if (response.success === true) {
                            toastr.success(response.message);
                            window.location.href = '{{ route('front.index') }}';
                        } else {
                            toastr.error(response.message);
                            window.location.href = '{{ route('front.index') }}';
                        }
                    }
                });
            });
        }
    }).render('#paypal-button-container');
</script>
</body>
</html>
