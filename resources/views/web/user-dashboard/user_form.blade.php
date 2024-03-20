@extends('web.layouts.main')
@section('content')
<section class="about1">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 about2" data-aos="zoom-in" data-aos-duration="1500">
                <h2>Make Your Things <br> Useful For Everyone!</h2>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row forms1">
            	<div class="dashboard-container">
            	@include('web.user-dashboard.sidebar')
            <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10 col-xxl-10">
                <div class="forms2">
                    <form class="form-container" action="{{route('CreateProduct')}}" method="post">
                        @csrf
                        <input type="hidden" id="lat" name="latitude" value="">
                        <input type="hidden" id="lng" name="longitude" value="">
                        <input type="hidden" id="postalCode" value="">
                        <input type="hidden" id="latDelta" name="latDelta" value="">
                        <input type="hidden" id="lngDelta" name="lngDelta" value="">
                    <div class="forms3">
                        <div class="forms4">
                            <h2>List Your Product</h2>
                                <div class="upload-files-container">
                                    <div class="drag-file-area">
                                        <span class="material-icons-outlined upload-icon"> File Upload </span>
                                        <h3 class="dynamic-message"> Drag & drop any file here </h3>
                                        <label class="label"> or <span class="browse-files"> <input type="file" class="default-file-input" name="image1" required/> <span class="browse-files-text">browse file</span> <span>from device</span> </span> </label>
                                    </div>
                                    <span class="cannot-upload-message"> <span class="material-icons-outlined">error</span> Please select a file first <span class="material-icons-outlined cancel-alert-button">cancel</span> </span>
                                    <div class="file-block">
                                        <div class="file-info"> <span class="material-icons-outlined file-icon">description</span> <span class="file-name"> </span> | <span class="file-size"> </span> </div>
                                        <span class="material-icons remove-file-icon">delete</span>
                                        <div class="progress-bar"> </div>
                                    </div>
                                    <!-- <button type="button" class="upload-button"> Upload </button> -->
                                </div>
                            
                        </div>

                        <div class="forms5">
                            <div class="form-group mb-3">
                                <label for="exampleFormControlSelect1">Category</label>
                                <select class="form-control control_change" id="exampleFormControlSelect1" name="category" required>
                                <option value="">Select Category</option>
                                @foreach($category_data as $category_lists)
                                    <option value="{{$category_lists}}">{{$category_lists}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleFormControlSelect1">Select tag</label>
                                <select class="form-control control_change" name="tag" id="exampleFormControlSelect1" required>
                                <option value="">Select Tag</option>
                                    @foreach($tag_data as $tag)
                                    <option value="{{$tag}}">{{$tag}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleFormControlSelect1">Select price tag</label>
                                <select class="form-control control_change" id="exampleFormControlSelect1" name="price_type" required>
                                <option value="">Select Tag</option>
                                    @foreach($tagprice_data as $tagprice)
                                    <option value="{{$tagprice}}">{{$tagprice}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleFormControlInput1">Price</label>
                                <input type="text" class="form-control" name="price" id="exampleFormControlInput1" placeholder="$10" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleFormControlSelect1">Select condition</label>
                                <select class="form-control control_change" id="exampleFormControlSelect1" name="condition" required>
                                <option value="">Select Condition</option>
                                    @foreach($condition_data as $condition)
                                    <option value="{{$condition}}">{{$condition}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- <div class="form-group mb-3">
                                <label for="exampleFormControlInput1">Location</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Choose a location" required>
                            </div> -->

                            <div class=" mb-3">
                                <p>Choose the time range in which the rental item will be available</p>
                                <div class="forms6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">From</label>
                                        <input type="time" class="form-control" id="exampleFormControlInput1" name="from" placeholder="From" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">To</label>
                                        <input type="time" class="form-control" name="to" id="exampleFormControlInput1" placeholder="To" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleFormControlInput1">Name of product</label>
                                <input type="text" class="form-control" name="product_name" id="exampleFormControlInput1" placeholder="Smart Watch" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="exampleFormControlInput1">Location</label>
                                <input type="text" id="address" class="form-control">
                                <!-- <input type="text" class="form-control" name="location" id="exampleFormControlInput1" placeholder="Location" required> -->
                            </div>

                            <div class="forms7">
                                <!-- <a href="product.php">Post Now</a> -->
                                <button type="submit">Post Now</button>
                            </div>

                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>
<div>
    <a id="button" class="my-button"></a>
</div>
@endsection
@section('css')
<style>
    .forms7 button {
    background-color: #98CF2C;
    color: #ffffff;
    padding: 10px 15px;
    border-radius: 5px;
}
</style>
@endsection
@section('link')
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet" />
@endsection
@section('js')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCab5ahH6KkodUavDwBCigXTL7ZbrkzS94&libraries=places&callback=initAutocomplete"
       async defer></script>
    <script type="text/javascript">
      function calculateDeltas(latitude, longitude) {
        // Earth's radius in kilometers
        const earthRadius = 6371;

        // Convert latitude and longitude from degrees to radians
        const lat1Rad = latitude * (Math.PI / 180);
        const lng1Rad = longitude * (Math.PI / 180);

        // Approximate distance per degree of latitude and longitude
        const latDelta = 1 / (earthRadius * Math.cos(lat1Rad)) * 360;
        const lngDelta = 1 / earthRadius * 360;

        return {
          latDelta,
          lngDelta,
        };
      }

      function initAutocomplete() {
        var address = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(address);
        autocomplete.addListener('place_changed', function() {
          var place = autocomplete.getPlace();
          var latitude = place.geometry.location.lat();
          var longitude = place.geometry.location.lng();
          var postalCode = "";

          // Extract postal code if available
          if (place.address_components) {
            for (var i = 0; i < place.address_components.length; i++) {
              var addressComponent = place.address_components[i];
              if (addressComponent.types.includes('postal_code')) {
                postalCode = addressComponent.long_name;
                break;
              }
            }
          }

          // Calculate latitude and longitude deltas
          var deltas = calculateDeltas(latitude, longitude);
          var latDelta = deltas.latDelta;
          var lngDelta = deltas.lngDelta;

          document.getElementById('lat').value = latitude;
          document.getElementById('lng').value = longitude;
          document.getElementById('postalCode').value = postalCode;
          document.getElementById('latDelta').value = latDelta;
          document.getElementById('lngDelta').value = lngDelta;
        });
      }
    </script>
@endsection
