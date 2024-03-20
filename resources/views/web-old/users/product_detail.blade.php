@extends('web.layouts.main')
@section('content')

<section>
    <div class="container">
        <div class="row pro1">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="pro9">
                    <img src="{{asset('assets/uploads/product/'.$details->image1)}}" width="50%" class="img-fluid zoom" alt="img">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                {{--<div class="pro4">
                    <div class="myac2">
                        <nav aria-label="bre`ad`crumb">
                            <ol class="breadcrumb pro3">
                                <li class="breadcrumb-item pro2"><a href="https://customdemo.website/dev/MLB-Corp/v7-update/dashboard-user">Home</a></li>
                                <li class="breadcrumb-item pro2"><a href="https://customdemo.website/dev/MLB-Corp/v7-update/for-sharing?cat=accessories">Accessories</a></li>
                                <li class="breadcrumb-item pro2 active" aria-current="page">Ipsamtempor eaqued</li>
                            </ol>
                        </nav>
                    </div>
                   
                </div>--}}
                <div class="pro5">
                    <h2>{{$details->name}}</h2>
                    <p style="font-weight: 700;font-family: inherit;">${{$details->price}}/<span style="font-weight: 600;">{{$details->price_type}}</span></p>
                </div>
                
                <div class="pro6">
                    <div>
                        <p class="text-dark"><b>Condition {{$details->condition}}/10</b></p>
                    </div>
                </div>
                {{--<div class="pro7">
                
                    <p><a href="https://customdemo.website/dev/MLB-Corp/v7-update/for-sharing?cat=accessories"><i class="fa-thin fa-code-compare"></i>&nbsp; Compare</a></p>
                    <!-- <p><i class="fa-thin fa-heart"></i>&nbsp; Add to wishlist</p> -->
                                                            <a href="javascript:void(0)" title="Favourite" class="heart-unfilled addtowishlist" rel2="1" rel="3"><i class="fa-regular fa-heart" aria-hidden="true"></i></a>
                                    </div>
                <hr class="hr1">--}}
                <div class="a">
                    <p>Category: <a href="">{{$details->category}}</a></p>
                    <label class="form-label"><b>Tags</b></label><br>
                    <input type="text" class="form-control" value="{{$details->tag}}" readonly>
                    
                    {{--<div class="pro8">
                        <p>Share:</p>
                        <ul class="d-flex social-box1">
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=https://yourwebdemo.pro/MLB-Corp/about-us/" target="_blank" class="fab fa-facebook-f"></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/share?url=https://yourwebdemo.pro/MLB-Corp/about-us/" target="_blank" class="fab fa-twitter"></a>
                            </li>
                            <li>
                                <a href="https://pinterest.com/pin/create/button/?url=https://yourwebdemo.pro/MLB-Corp/about-us/&amp;amp;media=https://yourwebdemo.pro/MLB-Corp/wp-includes/images/media/default.png&amp;amp;description=About+us" target="_blank" class="fa-brands fa-pinterest"></a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&amp;amp;url=https://yourwebdemo.pro/MLB-Corp/about-us/" target="_blank" class="fa-brands fa-linkedin"></a>
                            </li>
                            <li>
                                <a href="https://telegram.me/share/url?url=https://yourwebdemo.pro/MLB-Corp/about-us/" target="_blank" class="fa-brands fa-telegram"></a>
                            </li>
                        </ul>
                    </div>--}}
                </div>
                <div class="acc3">
                <label class="form-label"><b>Item Details</b></label><br>
                    <input type="text" class="form-control" value="{{$details->description}}" readonly>
                </div>
                <div class="mt-4">
                     <label class="form-label"><b>Locations</b></label><br>
                     <div id="map"></div>
                     </div>

            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<style>
    #map{
        height: 250px;
        width:100%;
    }
    .pro9 {
    overflow: hidden;
}
    label {
    display: inline-block;
}
    .form-label {
    margin-bottom: 0.5rem;
}
    .acc3 {
    position: relative;
    margin-top: 30px;
}
.acc3   input {
    background-color: transparent;
    padding: 10px;
    border: 1px solid #d2d2d2;
}
.form-control {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
    section {
    display: block;
    padding-top: 20vh;
}
    .zoom {
    transition: transform .2s;
    margin: 0 auto;
    cursor: pointer;
}
.img-fluid {
    max-width: 100%;
    height: auto;
}
img, svg {
    vertical-align: middle;
}
  .pro1 {
    padding: 50px;
    overflow: hidden;
}
.row {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 0;
    display: flex;
    flex-wrap: wrap;
    margin-top: calc(-1 * var(--bs-gutter-y));
    margin-right: calc(-0.5 * var(--bs-gutter-x));
    margin-left: calc(-0.5 * var(--bs-gutter-x));
}
.pro4 {
    display: flex;
    justify-content: space-between;
}
.pro6 {
    display: flex;
    gap: 10px;
    align-items: center;
}
.pro7 {
    display: flex;
    margin-top: 30px;
    gap: 20px;
}
.hr1 {
    color: #777;
    margin: 20px 0px;
}
p {
    margin-top: 0;
    margin-bottom: 1rem;
}
.a p a {
    color: black;
    text-decoration: none;
}
.pro8 {
    display: flex;
    margin-top: 30px;
    gap: 10px;
}
.pro8 p {
    color: #333;
}
.d-flex {
    display: flex !important;
}
ul, ol {
    list-style: none;
    margin: 0;
    padding: 0;
}
.container {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
@media (min-width: 1400px){
.col-xxl-6 {
    flex: 0 0 auto;
    width: 50%;
}
}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6-hKVloVBk042lNLNyaBEVgOe7Dou_kk&callback=initMap" async defer></script>
<script>
        // Function to initialize the map
        function initMap() {
            var product = @json($details);

            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: parseFloat(product.latitude), lng: parseFloat(product.longitude) },
                zoom: 10
            });

            var marker = new google.maps.Marker({
                position: { lat: parseFloat(product.latitude), lng: parseFloat(product.longitude) },
                map: map,
                title: product.name // Replace 'name' with the appropriate field from your product table
            });
        }
    </script>
@if($details->price_type == "per day")
  <script>
    function calculateDays() {
      var startDate = new Date($('#start').val());
      var endDate = new Date($('#end').val());
      var pickDate = new Date($('#pickDate').val());
      var currentDate = new Date();

      if (startDate > endDate) {
        toastr.error("Start datetime should be before end datetime");
        // $('#result').text("Start datetime should be before end datetime");
      }
      else if (startDate < currentDate || endDate < currentDate) {
        toastr.error("Start and end datetime should be after the current date and time");
        // $('#result').text("Start and end datetime should be after the current date and time");
      }
      else if (startDate > pickDate || endDate < pickDate) {
        toastr.error("Pickup Time Should Be Correct.");
        // $('#result').text("Start and end datetime should be after the current date and time");
      }
      else {
        var diffInMilliseconds = endDate - startDate;
        var diffInDays = Math.floor(diffInMilliseconds / (1000 * 60 * 60 * 24));

        $('#final_price').text("Total Days: " + diffInDays);
        $('#total_days').val(diffInDays);
      }
    }
    $('#pickDate').on('change', calculateDays);
  </script>
  @else
  <script>
    function calculateDays(startDate, endDate) {
      const startTimestamp = new Date($('#start').val());
      const endTimestamp = new Date($('#end').val());
      const hourDifference = Math.abs(endTimestamp - startTimestamp) / (1000 * 60 * 60);
      // alert(hourDifference);
      // return hourDifference;
      $('#final_price').text("Total Time: " + hourDifference);
      // var myVariable = hourDifference;
      // alert(myVariable);
      // var mySpan = document.getElementById("time");
      // mySpan.textContent = myVariable;
    }
    $('#pickDate').on('change', calculateDays);
  </script>
  @endif
@endsection