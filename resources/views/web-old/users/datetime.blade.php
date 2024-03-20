@extends('web.layouts.main')
@section('content')

  <div class="container">
    <h1>Calculate Days Between Datetime Inputs with Current Date Validation</h1>
    <form>
      <div class="form-group">
        <label for="start">Start Datetime:</label>
        <input type="datetime-local" class="form-control" id="start">
      </div>
      <div class="form-group">
        <label for="end">End Datetime:</label>
        <input type="datetime-local" class="form-control" id="end">
      </div>
      <!-- <div class="result" id="result"></div> -->
      <!-- <button id="myButton">Click Me</button>  -->
    </form>
  </div>

  <div class="container">
    <h1>Calculate Hourly Rate from Daily Rate</h1>
    <form>
      <div class="form-group">
        <label for="daily-rate">Daily Rate:</label>
        <input type="number" class="form-control" id="daily-rate" min="0" step="0.01">
      </div>
      <button type="button" class="btn btn-primary" onclick="calculateHourlyRate()">Calculate</button>
      <div class="result" id="result"></div>
    </form>
  </div>
  <div>
    <form>
    <input type="number" class="form-control" id="check">
    <button onclick="calculateHourlyRate()">check it</button>
    </form>
    <form>
    <input type="datetime-local" class="form-control" id="start1">
    <input type="datetime-local" class="form-control" id="end1">
    <p id="time"></p>
    </form>
  </div>

  





@endsection

@section('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function calculateDays() {
      var startDate = new Date($('#start').val());
      var endDate = new Date($('#end').val());
      var currentDate = new Date();

      if (startDate > endDate) {
        $('#result').text("Start datetime should be before end datetime");
      } else if (startDate < currentDate || endDate < currentDate) {
        toastr.error("Start and end datetime should be after the current date and time");
        // $('#result').text("Start and end datetime should be after the current date and time");
      } else {
        var diffInMilliseconds = endDate - startDate;
        var diffInDays = Math.floor(diffInMilliseconds / (1000 * 60 * 60 * 24));

        $('#result').text("Number of days: " + diffInDays);
      }
    }
    $('#end').on('change', calculateDays);
  </script>
  <script>
    function calculateHourDifference(startDate, endDate) {
      const startTimestamp = new Date($('#start1').val());
      const endTimestamp = new Date($('#end1').val());
      const hourDifference = Math.abs(endTimestamp - startTimestamp) / (1000 * 60 * 60);
      // alert(hourDifference);
      // return hourDifference;
      var myVariable = hourDifference;
      // alert(myVariable);
      var mySpan = document.getElementById("time");
      mySpan.textContent = myVariable;
    }
    $('#end1').on('change', calculateHourDifference);
  </script>
@endsection
<!-- <script>
    function calculateHourlyRate() {
      var dailyRate = parseFloat(document.getElementById('daily-rate').value);
      
      if (isNaN(dailyRate) || dailyRate < 0) {
        document.getElementById('result').innerHTML = "Please enter a valid daily rate.";
        return;
      }

      var hourlyRate = dailyRate / 24;

      document.getElementById('result').innerHTML = "Hourly Rate: $" + hourlyRate.toFixed(2);
    }
  </script> -->
  <!-- <script>
    function calculatePricePerHour() {
      // var pricePerDay = parseFloat(document.getElementById('check').value);
      const hoursInADay = 24; // Number of hours in a day
      const pricePerHour = pricePerDay / hoursInADay;
      return pricePerHour;
    }

    // Usage example
    const pricePerDay = 24; // Price per day
    const pricePerHour = calculatePricePerHour(pricePerDay);
    console.log("Price per hour:", pricePerHour);

  </script> -->