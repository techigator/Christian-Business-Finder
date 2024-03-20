@extends('web.layouts.main')
@section('content')



<section class="view3" style="margin:20px 30px">
    <div class="container"> <br>
       
        <div class="mt-5 row justify-content-center">
            <div class=" col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5 ">  
                <img src="{{asset('assets/uploads/product/'.$details->image1)}}" width="50%" class="img-fluid" alt="img" height="50%">
            </div>

            <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7">
                <div class="view6">
                    <h6>{{$details->name}}</h6>
                    <p>${{$details->price}} <span id="val">{{$details->price_type}}</span></p>
                    <form action="{{route('ProductRequest')}}" method="post">
                      @csrf
                    <input type="hidden" name="product_id" value="{{$details->id}}">
                    <input type="hidden" name="product_user_id" value="{{$details->user_id}}">
                    <input type="hidden" name="total_rent" value="{{$details->price}}" id="total_rent">
                    <input type="hidden" name="total_days" value="" id="total_days">
                    <div class="view7">
                      <!-- <label for="start">Start Date:</label> -->
                      <input type="text" required class="form-control" id="start" name="start_date" onfocusin="(this.type='datetime-local')" onfocusout="(this.type='text')" placeholder="Start Date:">
                      <!-- <input type="text" required class="form-control" id="start" name="start_date" placeholder="Start Date">  -->
                      <br>
                      <!-- <a href="#">Select Start Date</a>
                      <h5> May 25 2023, 10:50 AM </h5> -->
                    </div>
                    
                    <div class="view8 mb-4">
                      <!-- <label for="end">End Date:</label> -->
                      <input type="text" required class="form-control" onfocusin="(this.type='datetime-local')" onfocusout="(this.type='text')" name="end_date" id="end" placeholder="End Date:">
                      <!-- <input type="text"  class="form-control" id="end" name="end_date" placeholder="End Date:"> -->
                      <!-- <a href="#">Select End Date</a>
                      <h5> May 26 2023, 10:50 AM </h5> -->
                    </div>
                    <div class="view8 mb-4">
                      <!-- <label for="end">End Date:</label> -->
                      <input type="text" required class="form-control bg-secondary" onfocusin="(this.type='datetime-local')" onfocusout="(this.type='text')" name="pickup_time" id="pickDate" placeholder="pickup Date:">
                      <!-- <input type="text"  class="form-control" id="end" name="end_date" placeholder="End Date:"> -->
                      <!-- <a href="#">Select End Date</a>
                      <h5> May 26 2023, 10:50 AM </h5> -->
                    </div>
                    
                    
                    
                    <h5 id="final_price"></h5>
                    <div class="view10 text-center mt-3">
                      <button type="submit" class="btn myac7 mb-3 bg-success">Send Rent Request</button>
                    </div>
                  </form>

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
<style>.datepicker td, .datepicker th {
    width: 50px!important;
    height: 40px!important;
}
/* view css start */
.view1 {
  background-image: url(../images/pic10.png);
  background-size: cover;
  background-repeat: no-repeat;
  padding: 200px 50px 50px 50px;
}
.datepicker {
    padding: 15px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    direction: ltr;
}

.view2 h2 {
  font-size: 45px;
  font-weight: 600;
  color: #1A1A1A;
  text-align: center;
  font-family: 'Heebo', sans-serif;
}

.view3 {
  padding: 3.5rem;
  background-image: url(../images/pic1.png);
  background-size: cover;
  background-repeat: no-repeat;
}

/* .view4 {
  border-radius: 10px;
  margin: 50px;
} */

.view6 {
  margin-top: 35px;
}

.view6 p {
  color: rgb(231, 92, 91);
  font-size: 15px;
  font-weight: 600;
  font-family: Heebo, sans-serif;
  position: relative;
}

.view6 h6 {
  color: rgb(0, 0, 0);
  font-size: 30px;
  font-weight: 600;
  font-family: 'Heebo', sans-serif;
}

.view7 {
  display: flex;
  align-items: center;
}

.view7 input {
  color: #ffffff;
  background-color: #98CF2C;
  font-size: 15px;
  padding: 10px 20px;
  border-radius: 10px;
}


.view7 h5 {
  color: rgb(0, 0, 0);
  font-size: 15px;
  font-weight: 600;
  font-family: Heebo, sans-serif;
  margin-top: 10px;
}

.view8 {
  display: flex;
  align-items: center;
  gap: 40px;
  margin-top: 10px;
}

.view8 input {
  color: #ffffff;
  background-color: rgb(231, 92, 91);
  font-size: 15px;
  padding: 10px 25px;
  border-radius: 10px;
}
.inputcolor input {
  background-color: rgb(0, 0, 0);
}

.view8 h5 {
  color: rgb(0, 0, 0);
  font-size: 15px;
  font-weight: 600;
  font-family: Heebo, sans-serif;
  margin-top: 10px;
}

.view9 {
  display: flex;
  align-items: center;
  gap: 40px;
  margin-top: 10px;
}

.view9 a {
  color: rgb(255, 255, 255);
  background-color: rgb(0, 0, 0);
  font-size: 13px;
  padding: 10px 20px;
  border-radius: 10px;
}

.view9 h5 {
  color: rgb(0, 0, 0);
  font-size: 15px;
  font-weight: 600;
  font-family: Heebo, sans-serif;
  margin-top: 10px;
}


.view10 {
  display: flex;
  align-items: center;
  margin-top: 10px;
  justify-content: space-between;
}

.view10 a {
  color: rgb(255, 255, 255);
  background-color: rgb(0, 0, 0);
  font-size: 13px;
  padding: 10px 20px;
  border-radius: 10px;
}

.view10 h5 {
  color: rgb(0, 0, 0);
  font-size: 15px;
  font-weight: 600;
  font-family: Heebo, sans-serif;
  margin-top: 10px;
}
.img-fluid {
    max-width: 100%;
    height: auto;
    margin-top: 50px;
}
/* view css end */
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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