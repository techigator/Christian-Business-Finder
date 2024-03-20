@extends('admin/layouts/app') @section('content')
<!-- =============== Left side End ================-->
<div class="main-content-wrap sidenav-open d-flex flex-column">
    <!-- ============ Body content start ============= -->
    <div class="main-content">
        {{--
        <div class="breadcrumb">
            <h1 class="mr-2">{{Auth::user()->name}}</h1>
            <ul>
                <li><a href="javascript:void(0)"> Testimonials Listing Dashboard</a></li>
            </ul>
        </div>
            --}}
        <div class="separator-breadcrumb border-top"></div>
        <!-- Testimonials listing Start   -->
        <main>
            <div class="container-fluid site-width">
                <!-- START: Breadcrumbs-->
                <!-- END: Breadcrumbs-->
                <!-- START: Card Data-->
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <!-- <h2>Laravel 8 CRUD Example from scratch - ItSolutionStuff.com</h2> -->
                        </div>
                        <div class="pull-right text-right p-2">
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block"><button type="button" class="close"
                                data-dismiss="alert">×</button><strong>{{ $message }}</strong></div>
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
                <div class="card-header justify-content-between align-items-center">
                  <h4 class="card-title"><strong>Testimonials Management</strong></h4>
          
                  <a class="btn btn-success" href="" data-toggle="modal" data-target="#AddModal" style="background: #28a745; border-color: #28a745;float:right;"> Create New Testimonial</a>
                   
               </div>
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <!-- <th>Post By</th> -->
                        <!-- <th>Post Date</th> -->
                        <th width="280px">Action</th>
                    </tr>
                    @foreach ($testimonialss as $testimonials)
                    <tr>
                        <td>{{ $testimonials->id }}</td>
                        <td>{{ $testimonials->name }}</td>
                        <td style="text-align: center;">
                                                                <img src="{{ asset($testimonials->img) }}"
                                                                    style="width: 50px;height: 50px" alt="" />
                                                            </td>
                        <!-- <td>{{ $testimonials->post_by }}</td> -->
                        <!-- <td>{{date("d M y" ,strtotime($testimonials->created_at))}}</td> -->
                        <td>
                        <input data-id="{{$testimonials->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $testimonials->is_active ? 'checked' : '' }}>
                     </td>
                        <td>
                            <form action="{{ route('testimonials_destroy',$testimonials->id) }}" method="DELETE" class="form-delete">
                                <!-- <a class="btn btn-info showModalBtn" href="#" data-toggle="modal" data-showid="{!! $testimonials->id !!}">Show</a> -->
                                <a class="btn btn-primary editModalBtn" href="#" data-toggle="modal" data-id="{!! $testimonials->id !!}" data-selected_star="{{ $testimonials->star }}">Edit</a>
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete_button" onclick="return confirm('Are you sure you want to delete this testimonials?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                         <th>ID</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <!-- <th>Post By</th> -->
                        <!-- <th>Post Date</th> -->
                        <th width="280px">Action</th>
                                                </tr>
                                            </tfoot>
                </table>
                @if($testimonialss->isEmpty())
                <div class="col-md-12">
                    <div class="alert alert-warning" style="margin: 10% 0; text-align: center;">
                        <strong>No Records Found</strong>
                    </div>
                </div>
                @endif
                <div class="row mt-3">
                    <div class="col-lg-6 offset-lg-6">
                     {!! $testimonialss->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
                <!-- END: Card DATA-->
            </div>
        </main>
        <!-- Testimonials listing end   -->
        <!-- end of row-->
        <!-- end of main-content -->
    </div>
    <!-- Footer Start -->
    {{--
    <div class="flex-grow-1"></div>
    <div class="app-footer">
        <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
            <span class="flex-grow-1"></span>
            <div class="d-flex align-items-center">
                <img class="logo" src="{{asset($logo)}}" alt="" />
                <div>
                    <p class="m-0">
                        Copyrights © {{date('Y')}}
                        <?=$config['COMPANY']?>
                    </p>
                    <p class="m-0">All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
    --}}
    <!-- fotter end -->
</div>
<br>
<br>
@endsection
<!-- Add Modal start -->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #218838; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Testimonial</h5>
                <button type="button" class="close" style="color: #fff;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="document-content">
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
                    <form action="{{ route('testimonials_store') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Title</strong>
                                    <input type="text" id="name-text" required name="name" value="{{ old('name') }}" class="form-control mt-2 mb-2" placeholder="Name" 
                                    />
                                    <strong>Star Rating</strong><br>
                                     <?php
                                     $categories = array(1,2,3,4,5);
                                     ?>
                                    @foreach ($categories as $star)
                                        <label class="">
                                            <input type="radio" class="star_select" name="star"
                                                class="{{ $star }}" value="{{ $star }}" />
                                            <span class="checkmark"></span>
                                            {{ $star}}<span class="fa fa-star checked"></span>
                                        </label>
                                    @endforeach
                                    <br>
                                    <strong>Details:</strong>
                                    <textarea required name="details" class="form-control mt-2 mb-2" id="details" placeholder="Details">{{ old('details') }}</textarea>
                                    <br />
                                    <strong>Select Image to upload</strong>
                                    <input type="file" required name="img" value="{{ old('img') }}" id="img" class="form-control mt-2 mb-2" />
                                    <br />
                                    <!--  <strong>Post By</strong>
                                    <input type="text" name="post_by" value="{{ old('post_by') }}" class="form-control mt-2 mb-2" placeholder="Post By" 
                                    id="page-text"/>
                                    <strong>Post Date</strong>
                                    <input type="date" name="created_at" value="{{ old('created_at') }}" class="form-control mt-2 mb-2" placeholder="Date" 
                                    id="page-text"/> -->
                                    <!-- <strong>Select testimonials to upload</strong>
                                    <br /> -->
                                    <!-- <input type="file" name="file" value="{{ old('file') }}" id="file" class="form-control mt-2 mb-2" /> -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn" style="background: #218838; color: #fff;">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal end -->
<!-- Edit Modal start -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #1e3d73; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Testimonial</h5>
                <button type="button" class="close" style="color: #fff;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="document-content">
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
                    <form action="{{ route('testimonials_update') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
                        <input type="hidden" name="id" id="editId" value="" />
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Title:</strong>
                                <input type="text" id="editName" name="name" value="" class="form-control mt-2" placeholder="Name" required />
                            </div>
                            <div class="form-group cap_star">
                                    <strong>Star Rating</strong><br>
                                    <select name="star" id="editStar" style="width: 100%;">
                                    @foreach ($categories as $star)
                                    {{--
                                        <label class="">
                                            <input type="radio" name="star" class="cap_star{{ $star }} star_select"
                                                value="{{ $star }}" />
                                            <span class="checkmark"></span>
                                            {{ $star}}
                                        </label>
                                    --}}
                                        <option value="{{ $star}}"> {{ $star}} STAR</option>
                                    @endforeach
                                    </select>
                                    <br>
                            </div>
                            <div class="form-group">
                                <strong>Details:</strong>
                                <textarea id="editDetails"  name="details" class="form-control mt-2 mb-2" placeholder="Details"></textarea>
                            </div>
                            <div class="form-group">
                                <strong>Image:</strong>
                                <br />
                                <img  style="width:150px;height:150px" src="{{asset('images/no-img-avalible.png')}}" id="editImg" alt="testimonials" />
                                <input type="file" name="img" value="{{ old('img') }}" id="img" class="form-control mt-2 mb-2" />
                                <br />
                            </div>
                            <!-- <div class="form-group">
                                <strong>Post By:</strong>
                                <input type="text" id="editPost_by" name="post_by" value="" class="form-control mt-2" placeholder="Post By" required />
                            </div> -->
                            <!-- <div class="form-group">
                                <strong>Post Date:</strong>
                                <input type="date" id="editCreated_at" name="created_at" value="" class="form-control mt-2" placeholder="Post Date" required />
                            </div> -->
                            <!-- <div class="form-group">
                                <strong>Testimonial</strong>
                                <br />
                                <testimonials width="320" height="240" controls id="showFile"></testimonials>
                            </div> -->
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Modal start -->
@section('css')
<!-- <script src="{{asset('vendors/bootstrap4-toggle/js/bootstrap4-toggle.min.js')}}"></script> -->
<link href="{{asset('vendors/bootstrap4-toggle/css/bootstrap4-toggle.min.css')}}" rel="stylesheet">
 <style>
    .dropdown-item.active, .dropdown-item:active {
    color: #fff!important;
    text-decoration: none;
    background-color: #17b2a2;
}
.flex-btn {
    display: flex;
}
.btn-group span{
    text-transform: capitalize;
}
div#example_filter {
    float: right;
}
.form-delete {    
    margin: 0;

}
.toggle-group .btn-success{
    color: #fff;
    background-color: #218838;
    border-color: #1e7e34;
}
</style> 
@endsection 
@section('link') 
<link rel="stylesheet" href="{{asset('vendors/datatable/css/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{asset('vendors/datatable/buttons/css/buttons.bootstrap4.min.css')}}"/>
<!-- <link rel="stylesheet" href="{{asset('vendors/x-editable/css/bootstrap-editable.css')}}" /> -->

@endsection 
@section('script') 
<!-- END: Template JS-->
<script src="{{asset('vendors/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/buttons.bootstrap4.min.js')}}"></script>
<!-- <script src="{{asset('vendors/x-editable/js/bootstrap-editable.min.js')}}"></script> -->
<!-- <script src="{{asset('js/xeditable.script.js')}}"></script> -->
<script src="{{asset('vendors/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- <script src="{{asset('vendors/datatable/jszip/jszip.min.js')}}"></script>
<script src="{{asset('vendors/datatable/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('vendors/datatable/pdfmake/vfs_fonts.js')}}"></script> -->
<!-- <script src="{{asset('vendors/datatable/buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendors/datatable/buttons/js/buttons.print.min.js')}}"></script> -->
<script src="{{asset('js/datatable.script.js')}}"></script>
@endsection 
@section('js')
<script src="{{asset('admin/vendors/ckeditor/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".editModalBtn").click(function () {
            var id = $(this).data("id");
            var action = '{{route("testimonials_edit")}}/' + id;
            var url = '{{route("testimonials_edit")}}/' + id;
            // var trArray = $(this).data("selected_star");      
            $.ajax({
                type: "get",
                url: url,
                data: { id: id },
                success: function (data) {
                    $("#editId").val(data.id);
                    // document.getElementById("editStar").value = data.star;
                    $("#editName").attr("value", data.name);
                    $('#editStar').val(data.star);
                    // $(".cap_star" + data.star).attr("checked", true);

                    CKEDITOR.instances.editDetails.setData(data.details);
                    // $("#editDetails").val(data.details);
@if (env('APP_ENV')=='local')
                    $("#editImg").attr("src", '{{asset("")}}' + data.img);
@else
                    $("#editImg").attr("src", '{{asset("/")}}' + data.img);
@endif                  
                    // $("#editPost_by").val(data.post_by);
                    // $("#editCreated_at").val(data.created_at);
                    // $("#editImg").attr("src", '{{asset("/")}}' + data.img);
                    // var testimonials = document.getElementById("editFile");
                    // var source = document.createElement("source");
                    // source.setAttribute("src", '{{asset("/")}}' + data.file);
                    // testimonials.appendChild(source);
                    // testimonials.play();
                    // $('#editid').attr('action', '{{route("testimonials_update")}}/'+id);
                    $("#editModal").modal("show");
                },
            });
        });
    });
</script>
<script>
 $(document).ready(function () {     
    var details = CKEDITOR.replace("details");
    details.on("change", function (evt) {
        $("#details").text(evt.editor.getData());
    });
    var editDetails = CKEDITOR.replace("editDetails");
    editDetails.on("change", function (evt) {
        $("#editDetails").text(evt.editor.getData());
    });
});    
</script>
<script>
  $(function() {
         $("body").on("change", ".toggle-class", function(){ 
        var is_active = $(this).prop('checked') == true ? 1 : 0; 
        var id = $(this).data('id');          
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{route("testimonials_status")}}',
            data: {'is_active': is_active, 'id': id},
            success: function(data){
              console.log(data.success)
            }
        });
    })
  })
</script>
<script type="text/javascript">
        $(document).ready(function() {

            $('.star_select').click(function() {

                $('.star_select').not(this).prop('checked', false);

            });

        });
    </script>
@endsection
