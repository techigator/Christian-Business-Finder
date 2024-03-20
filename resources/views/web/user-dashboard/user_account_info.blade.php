@extends('web.layouts.main')
@section('content')
<?php
$user = Auth::user();
?>
<section class="dash1">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 dash2" data-aos="zoom-in" data-aos-duration="1500">
                <h2>Account Information</h2>
            </div>
        </div>
    </div>
</section>    
<main>
            <div class="container-fluid site-width">
                <!-- START: Card Data-->
                <div class="row">
                    <div class="col-3 mt-5">
                    @include('web.user-dashboard.sidebar')
                    </div>
                    <div class="col-9 mt-5">
                    <div class="">
                         <i class="fa fa-edit" style="font-size:24px;color:#98cf2c;float:right;cursor: pointer;margin-top: -29px;" id="blah0"></i>
                    </div>
                        <div class="position-relative">
                            <div class="background-image-maker py-5">
                            </div>
                            <div class="holder-image">
                                <img src="{{asset('images/portfolio13.jpg')}}" alt="" class="img-fluid d-none">
                            </div>
                            <div class="position-relative px-3 py-5">

                                <div class="media d-md-flex d-block">
                                    @if($user->profile_image != "")
                                    @php $path = 'assets/uploads/user/'.$user->profile_image; @endphp
                                    @else
                                    @php $path = "web/images/no-img.png"; @endphp
                                    @endif
                                    <a href="javascript:void(0);">

                                        <img src="{{asset($path)}}" width="100" alt="{{$user->name}}" class="img-fluid rounded-circle" >
                            <i class="fa fa-edit" style="font-size:24px;color:#fff"; id="blah"></i>
                                    </a>
                                    <form method="POST" action="{{route('upload_image')}}" enctype="multipart/form-data" id="form-image-upload">
                                    @csrf
                                    <input type="file" id="upload-img" name="profile_image" style="display:none"/> 
                                    </form>
                                    <form method="POST" action="{{route('upload_cover_image')}}" enctype="multipart/form-data" id="form-image-upload0">
                                                 @csrf
                                        <input type="file" id="upload-img0" name="cover_image" style="display: none;">
                                    </form>

                                    <div class="media-body z-index-1">
                                        <div class="pl-4">
                                            <h1 class="display-4 text-uppercase text-white mb-0">{{$user->name}}</h1>
                                            <h6 class="text-uppercase text-white mb-0">Created at: {{$user->created_at->diffForHumans()}}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                                <div class="card-body">
                                    <div class="row">                                           
                                        <div class="col-12">
                                            <form class="needs-validation" novalidate method="POST" action="{{url('update-info')}}" enctype="multipart/form-data" id="form-image-upload">
                                            @csrf
                                                <div class="form-row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustom01">Full Name</label>
                                                        <input type="text" class="form-control" name="name" id="validationCustom01" placeholder="Full name" value="{{$user->name}}" required>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="validationCustom03">Personnel Email</label>
                                                        <input type="email" class="form-control" readonly="" disabled="" value="{{$user->email}}" id="validationCustom03" placeholder="Email" required>
                                                        <div class="invalid-feedback">
                                                            Please enter your email.
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <button class="btn btn-primary nav_glass" type="submit">Submit form</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                
                <div class="row mt-3"></div>
                <!-- END: Card DATA-->
            </div>
</main>
@endsection

@section('css')
@if($user->cover_image != "")
@php $path_cover_image = 'assets/uploads/user/'.$user->cover_image; @endphp
<style>
.background-image-maker {
    position: absolute;
    height: 100%;
    top: 0;
    left: 0;
    width: 100%;
    background-size: cover;
    background-position: center;
    background-image:url('{{asset($path_cover_image)}}');
/*    background-color: #e75c5b;*/
    z-index: -1;
}
</style>
@else
<style>
.background-image-maker {
    position: absolute;
    height: 100%;
    top: 0;
    left: 0;
    width: 100%;
    background-size: cover;
    background-position: center;
    background-color: #e75c5b;
    z-index: -1;
}
</style>
@endif

<style>
 /* Info Card */
.nav_glass{
     background-color: #98CF2C;
    color: #ffffff;
    padding: 15px 35px;
    font-size: 15px;
    border-radius: 10px;
    font-family: 'Heebo', sans-serif;
    margin: 0px 10px;
    border: none;   
 }.nav_glass:hover {
    background-color: transparent;
    color: #98CF2C;
    border: 1px solid #98CF2C;
} 
 .menu-container {
    width: 100%;
}
.rounded-circle {
    border: white 1px solid;
}
.holder-image img {
    opacity: 0;
}

.info-card {
    position: relative;
    overflow: hidden;
}

.info-card .date {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 30px;
    background: #ff880d;
    width: 60px;
    text-align: center;
    border-radius: 5px;
    padding: 10px;
    line-height: 30px;
}

.info-card .date span {
    display: block;
    font-size: 17px;
}

.info-card .like {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 13px;
    background: rgba(0, 0, 0, 0.6);
    width: 124px;
    color: #fff;
    border-radius: 10px;
    padding: 2px 10px;
}

.info-card .title {
    position: absolute;
    bottom: 0px;
}
   
</style>
@endsection

@section('js')
<script>

    $('document').ready(function(){
        $('#blah').click(function(){ 
            $('#upload-img').trigger('click'); 
        });    
    });
    
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          $('#blah').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }
    $("#upload-img").change(function() {
      $("#heading_upload").hide();
      readURL(this);
    });
    
    $("#upload-img").change(function(e) {
        var val = $(this).val();
        if (val.match(/(?:gif|jpg|png|bmp)$/)) {
            if (confirm('Do you really want to change your profile image?')) {
                $("#form-image-upload").submit();
            } else {
                alert('No image has been updated');
            }
        }
    });
    $("document").ready(function () {
        $("#blah0").click(function () {
            $("#upload-img0").trigger("click");
        });
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#blah0").attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
    $("#upload-img0").change(function () {
        $("#heading_upload0").hide();
        readURL(this);
    });
    $("#upload-img0").change(function (e) {
        var val = $(this).val();
        if (val.match(/(?:gif|jpg|png|bmp)$/)) {
            if (confirm("Do you really want to change your profile image?")) {
                $("#form-image-upload0").submit();
            } else {
                alert("No image has been updated");
            }
        }
    });
</script>

@endsection