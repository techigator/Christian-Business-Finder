@extends('admin/layouts/app') @section('content')
<div class="main-content-wrap sidenav-open d-flex flex-column">
    <div class="main-content">
        <div class="separator-breadcrumb border-top"></div>
        <main>
            <div class="container-fluid site-width">
                 @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">×</button><strong>{{ $message }}</strong></div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br />
                        <br />
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
<div class="row">
         <div class="col-12 mt-3">
            <div class="card">
               <div class="card-header justify-content-between align-items-center flex-btn">
                  <h4 class="card-title"><strong>Logo Management</strong></h4>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table id="example" class="display table dataTable table-striped table-bordered">    
                <div class="container animated bounce">
                    <form action="{{ route('logo_update') }}" method="POST" enctype="multipart/form-data" id="form1" runat="server">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
                        <input type="hidden" name="id" id="editId" value="1" />
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <!-- <div class="alert"></div> -->
                                <div id="img_container"><img id="editImg" style="width:250px;"  src="{{asset($logo->img)}}" alt="your image" title="" /></div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" id="img" name="file" class="imgInp custom-file-input" aria-describedby="inputGroupFileAddon01" />
                                        <label class="custom-file-label" for="img">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
                </table>
                  </div>
               </div>
            </div>
         </div>
      </div>

            </div>
        </main>
    </div>
</div>
<br />
<br />
@section('link') 
<link rel="stylesheet" href="{{asset('vendors/datatable/css/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{asset('vendors/datatable/buttons/css/buttons.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('vendors/x-editable/css/bootstrap-editable.css')}}" />
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> -->
@endsection 
@section('script') 
<!-- END: Template JS-->
<script src="{{asset('vendors/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/x-editable/js/bootstrap-editable.min.js')}}"></script>
<script src="{{asset('js/xeditable.script.js')}}"></script>
<script src="{{asset('vendors/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/datatable/jszip/jszip.min.js')}}"></script>
<script src="{{asset('vendors/datatable/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('vendors/datatable/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/buttons.print.min.js')}}"></script>
<!-- <script src="{{asset('js/datatable.script.js')}}"></script> -->
@endsection 
@endsection @section('css')
 <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css'> 
<style>
    .modal-footer {
    border: none;
}
    .container {
        margin-left: auto;
        margin-right: auto;
        margin-top: 30px;
    }
    #form1 {
        width: auto;
    }
    .alert {
        text-align: center;
    }
    #editImg {
        max-height: 256px;
        height: auto;
        width: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
        padding: 5px;
    }
    #img_container {
        border-radius: 5px;
        margin-top: 20px;
        width: auto;
    }
    .input-group {
        margin: 33px auto;
        margin-top: 40px;
        width: 320px;
    }
    .imgInp {
        width: 150px;
        margin-top: 10px;
        padding: 10px;
        background-color: #d3d3d3;
    }
    .loading {
        animation: blinkingText ease 2.5s infinite;
    }
    @keyframes blinkingText {
        0% {
            color: #000;
        }
        50% {
            color: #transparent;
        }
        99% {
            color: transparent;
        }
        100% {
            color: #000;
        }
    }
    .custom-file-label {
        cursor: pointer;
    }
    .app-footer {
        position: relative;
    }
    .modal-title {
        color: #fff;
    }
/*     .sub-header {
        background-color: #eee;
        padding: 0 5px;
    } */
    .breadcrumb-item a {
        color: #000;
        padding: 0 5px;
    }
    .form-delete {
        margin: 0;
    }
</style> 
@endsection @section('js')
<script>
    // Code By Webdevtrick ( https://webdevtrick.com )
    $("#img").change(function (event) {
        RecurFadeIn();
        readURL(this);
        var val = $(this).val();
        if (val.match(/(?:gif|jpg|png|bmp)$/)) {
            if (confirm("Do you really want to change your profile image?")) {
                $("#form1").submit();
            } else {
                alert("No image has been updated");
            }
        }
    });
    $("#img").on("click", function (event) {
        RecurFadeIn();
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var filename = $("#img").val();
            filename = filename.substring(filename.lastIndexOf("\\") + 1);
            reader.onload = function (e) {
                debugger;
                $("#editImg").attr("src", e.target.result);
                $("#editImg").hide();
                $("#editImg").fadeIn(500);
                $(".custom-file-label").text(filename);
            };
            reader.readAsDataURL(input.files[0]);
        }
        $(".alert").removeClass("loading").hide();
    }
    function RecurFadeIn() {
        console.log("ran");
        FadeInAlert("Wait for it...");
    }
    function FadeInAlert(text) {
        $(".alert").show();
        $(".alert").text(text).addClass("loading");
    }
</script>
@endsection
