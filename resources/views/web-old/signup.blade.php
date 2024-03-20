@extends('web.layouts.main') @section('content')
<section class="login-sign-up-sec">
  <div class="container">
    <div class="row">
            <div class="col-md-4 offset-md-4">
              <form class="needs-validation" novalidate method="POST" action="{{ route('register.custom') }}" >
                @csrf
              <div class="form-blk">
            <div class="row">
                <div class="col-md-12">
                  <h4>Register Now</h4>
                </div>
                <div class="col-md-12">
                  <input type="text" required name="name" placeholder="Full name" value="{{ old('name') }}">
                </div>
                @if ($errors->has('name'))
                <div class="text-left">
                                      <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                @endif
                <div class="col-md-12">
                  <input type="email" name="email" id="email" required="" placeholder="Email Address" value="{{ old('email') }}">
                </div>
                @if ($errors->has('email'))
                <div class="text-left">
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                @endif
                <div class="col-md-12">
                  <input type="number" id="number" name="phonenumber" placeholder="Phone Number" value="{{ old('phonenumber') }}">
                </div>
                @if ($errors->has('phonenumber'))
                <div class="text-left">
                                      <span class="text-danger">{{ $errors->first('phonenumber') }}</span>
                </div>
                @endif
                
                <div class="col-md-12">
                  <input type="password" name="password" required="" placeholder="Password" value="{{ old('password') }}">
                </div>
                @if ($errors->has('password'))
                <div class="text-left">
                 <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>
                @endif
                <div class="col-md-12">
                  <div class="modal-button">
                <button type="submit" class="from-btn">Continue</button>
            </div>
                </form>
            </div>
                </div>
                <div class="col-md-12 p-blk">
                <a href="{{route('login')}}">Already a member? <span> Login Now</span></a>
              </div>
                </div>
            </div>
      </div>
    </div>
 </section>
@endsection 
@section('css')
<style>
section.login-sign-up-sec form input {
    width: 100%;
    margin: 10px 0px;
    background: transparent;
    border-radius: 10px;
    outline: none;
    /* color: #fff; */
    color: #35265E;
    padding: 12px 15px;
    border: 1px solid #83957D;
    font-size: 13px;
    font-family: 'Poppins', sans-serif;
}
section.login-sign-up-sec form select {
    width: 100%;
    margin: 10px 0px;
    /* padding: 10px 10px; */
    border: 2px solid #35265e;
    background: transparent;
    border-radius: 10px;
    outline: none;
    /* color: #fff; */
    color: #35265E;
}
section.login-sign-up-sec form input::placeholder {
    color: #35265e;
    font-size: 14px;
}
section.login-sign-up-sec h4 {
    font-size: 36px;
    font-weight: 600;
    font-family: 'Heebo', sans-serif;
    color: #E75C5B;
    margin-bottom: 30px;
    text-align: center;
}
section.login-sign-up-sec button {
    width: 100%;
    padding: 10px 0px;
    margin: 10px 0px;
    border: 1px solid #98CF2C;
    background-color: #98CF2C;
    color: #fff;
    border-radius: 10px;
    outline: none;
    display: inline-block;
    font-size: 25px;
    cursor: pointer;
}section.login-sign-up-sec button:hover {
background-color: transparent;
color: #98CF2C;
}
section.login-sign-up-sec a {
    color: #35265e;
    font-size: 17px;
    text-align: center;
    padding-top: 10px;
    display: inline-block;
}
section.login-sign-up-sec a span {
    text-decoration: underline;
}
section.login-sign-up-sec {
    background-color: #fff;
    padding: 200px 0 100px 0;
}
.form-blk h4 {
    float: right;
    width: 100%;
}
.form-blk a {
    float: right;
    width: 100%;
}
.form-blk input,
.form-blk button {
    float: right;
}
</style>
@endsection 
@section('js') 
<script>
    // Select your input element.
    var number = document.getElementById('number');
    // Listen for input event on numInput.
    number.onkeydown = function(e) {
        if(!((e.keyCode > 95 && e.keyCode < 106)
          || (e.keyCode > 47 && e.keyCode < 58) 
          || e.keyCode == 8)) {
            return false;
        }
    }
</script>
@endsection