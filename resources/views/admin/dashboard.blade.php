@extends('admin/layouts/app')
@section('title', 'Dashboard')
@section('content')

    <?php

    use App\Models\logo;
    use App\Models\setting;

    $logo = logo::find(1);
    $setting = setting::find(1);
    ?>

    <div class="card-box">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <img src="{{ asset($logo->img) }}" alt="">
                <h4 class="welcome-text">Welcome back</h4>
                <div class="dashboard-title">Christian Business Finder</div>
                <p class="dashboard-description text-center">
                    Welcome to the admin dashboard of Christian Business Finder. Here you can manage various aspects of
                    the application.
                </p>
            </div>
        </div>
        <hr>

        @if($user)
            @php
                $type = str_replace('_', ' ', ucwords($user->type ?? ''))
            @endphp
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-xl-stretch">
                        <div class="card-header border-0">
                            <div class="card-toolbar"
                                 style="display: flex; justify-content: center; text-align: center; padding-top: 15px;">
                                @if($user->name)
                                    <p class="mr-4">Name: <strong>{{ $user->name ?? '' }}</strong></p>
                                @endif
                                @if($user->email)
                                    <p class="mr-4">Email: <strong>{{ $user->email ?? '' }}</strong></p>
                                @endif
                                @if($type)
                                    <p class="mr-4">Type: <strong>{{ $type ?? '' }}</strong></p>
                                @endif
                                @if($couponCode)
                                    <p class="mr-4">Coupon Code: <strong>{{ $couponCode ?? '' }}</strong></p>
                                @endif
                                @if($user->referral_code)
                                    <p class="mr-4">Referral Code:
                                        <strong>{{ $user->referral_code ?? '' }}</strong></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="app-content">
            <div class="dashboard-title">
                This week sales and purchase
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <div class="card-header border-0 pt-5">
                            <div class="card-toolbar" data-kt-buttons="true" data-kt-initialized="1">
                                <a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1"
                                   id="kt_charts_widget_6_sales_btn">Sales</a>
                                <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1"
                                   id="kt_charts_widget_6_expenses_btn">Expenses</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" style="height: 350px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var barChartData = {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            datasets: [{
                label: 'Sales',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                data: [12, 19, 3, 5, 2]
            }]
        };

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        $('.inquiry_update').click(function () {

            var id = $(this).data("id");
            var name = $(this).data("name");
            var email = $(this).data("email");
            var phonenumber = $(this).data("phonenumber");
            var url = $(this).data("url");
            var message = $(this).data("message");

            var dataupdate = $(this).data("dataupdate");
            var datadelete = $(this).data("datadelete");
            var datacreate = $(this).data("datacreate");

            $('.inquiryForm').show();
            $('.inquiryProjectForm').hide();


            $('.inquiryForm #editId').val(id);
            $('#exampleModalLongTitle').html('<span>Inquiry # ' + id + '<span>');
            $('.inquiryForm #editName').val(name);
            $('.inquiryForm #editEmail').val(email);
            $('.inquiryForm #editPhoneNumber').val(phonenumber);
            $('.inquiryForm #editUrl').val(url);
            $('.inquiryForm #editMessage').val(message);

            $('.inquiryForm #dataupdate').val(dataupdate);
            $('.inquiryForm #datadelete').val(datadelete);
            $('.inquiryForm #datacreate').val(datacreate);

            $("#editModal").modal("show");

        });
    </script>
@endsection
