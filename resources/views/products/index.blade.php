@extends('layouts.main')
@section('content')

    <!-- =============== Left side End ================-->
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <!-- ============ Body content start ============= -->
        <div class="main-content">
            {{--
        <div class="breadcrumb">
            <h1 class="mr-2">{{Auth::user()->name}}</h1>
            <ul>
                <li><a href="javascript:void(0)">  Product Listing Dashboard</a></li>
            </ul>
        </div>
            --}}
            <div class="separator-breadcrumb border-top"></div>
            <!-- product listing Start   -->
            <main>
                <div class="container-fluid site-width">
                    <!-- START: Breadcrumbs-->
                    <div class="row">
                        <div class="col-12 align-self-center">
                            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                                <div class="w-sm-100 mr-auto">
                                    <h4 class="mb-0"> Product Listing Report</h4>
                                </div>
                                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('products_index') }}"> Product Listing</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
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


                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="card">
                                <div class="card-header justify-content-between align-items-center flex-btn">
                                    <h4 class="card-title"> Product Listing</h4>
                                    <a class="btn btn-success" href="" data-toggle="modal" data-target="#AddModal"
                                        style="background: #28a745; border-color: #28a745;"> Create New Product</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table id="example" class="display table dataTable table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Title</th>
                                                    <th>Image</th>
                                                    <th>Category</th>
                                                    <th>Is Feature</th>
                                                    <th>Status</th>
                                                    <th width="280px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!$products->isEmpty())
                                                    @foreach ($products as $product)
                                                        <tr>
                                                            <td>{{ $product->id }}</td>
                                                            <td>{{ $product->name }}</td>
                                                            <td>
                                                                <?php $prod = App\Models\category::where('id', $product->category_id)->first(); ?>
                                                                {{ $prod->name }}

                                                            </td>
                                                            <td style="text-align: center;">
                                                                <img src="{{ asset('images/loading.gif') }}" class="lazy"
                                                                    data-src="{{ asset($product->img) }}"
                                                                    style="width: 50px;height: 50px" alt="" />
                                                            </td>
                                                            <td>
                                                                <input data-id="{{ $product->id }}"
                                                                    class="toggle-class is_feature" type="checkbox"
                                                                    data-onstyle="success" data-offstyle="danger"
                                                                    data-toggle="toggle" data-on="Yes" data-off="No"
                                                                    {{ $product->is_feature == 1 ? 'checked' : '' }}>
                                                            </td>
                                                            <td>
                                                                <input data-id="{{ $product->id }}"
                                                                    class="toggle-class is_active" type="checkbox"
                                                                    data-onstyle="success" data-offstyle="danger"
                                                                    data-toggle="toggle" data-on="Active"
                                                                    data-off="InActive"
                                                                    {{ $product->is_active ? 'checked' : '' }}>
                                                            </td>

                                                            <td class="d-flex ">
                                                                <div>
                                                                    <form
                                                                        action="{{ route('products_destroy', $product->id) }}"
                                                                        method="DELETE" class="form-delete">
                                                                        <a class="btn btn-primary editModalBtn"
                                                                            href="#" data-toggle="modal"
                                                                            data-id="{!! $product->id !!}"
                                                                            data-selected_cat="{{ $product->category_id }}">Edit</a>
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger delete_button"
                                                                            onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                                                    </form>
                                                                </div>
                                                                <div class="mx-2">
                                                                    <a href="{{ route('product_imgs_index', $product->id) }}"
                                                                        class="imagesModalBtn"><button
                                                                            class="btn btn-info">Add
                                                                            Images</button></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Category</th>
                                                    <th>Title</th>
                                                    <th>Image</th>
                                                    <th>Is Feature</th>
                                                    <th>Status</th>
                                                    <th width="280px">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    @else
                                        <div class="col-md-12">
                                            <div class="alert alert-warning" style="margin: 10% 0; text-align: center;">
                                                <strong>No Records Found</strong>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="mt-3">
                                            <div class="col-lg-6 offset-lg-6">
                                                {{--
                     {!! $products->links('pagination::bootstrap-4') !!}
                    --}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Card DATA-->
                </div>
            </main>
            <!-- product listing end   -->
            <!-- end of row-->
            <!-- end of main-content -->
        </div>
        <!-- Footer Start -->
        <div class="flex-grow-1 mb-5"></div>
        {{--
    <div class="app-footer">
        <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
            <span class="flex-grow-1"></span>
            <div class="d-flex align-items-center">
                <img class="logo" src="{{asset($logo)}}" alt="" />
                <div>
                    <p class="m-0">
                        Copyrights © {{date('Y')}}
                        <?= $config['COMPANY'] ?>
                    </p>
                    <p class="m-0">All rights reserved</p>
                </div>
            </div>
        </div>
                    --}}
    </div>

    <!-- fotter end -->
    </div>
    <br>
    <br>
@endsection
<!-- Edit Modal start -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #1e3d73; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit product</h5>
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
                    <form action="{{ route('products_update') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                        <input type="hidden" name="id" id="editId" value="" />
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                        <input type="hidden" value="keyword" name="keyword" />
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <!-- Category -->
                                <div class="form-group cap_category">
                                    <strong>Category</strong><br>
                                    @foreach ($categories as $category)
                                        <label class="">
                                            <input type="checkbox" name="category_id" class="cap_category{{ $category->id }} cat_select"
                                                value="{{ $category->id }}" />
                                            <span class="checkmark"></span>
                                            {{ $category->name }}
                                        </label>
                                    @endforeach
                                    <br>

                                </div>
                                <div class="form-group">
                                    <strong>Title:</strong>
                                    <input type="text" id="editName" name="name" value=""
                                        class="form-control mt-2" placeholder="Name" required />
                                </div>
                                <div class="form-group">
                                    <strong>Slug:</strong>
                                    <input type="text" id="editSlug" name="slug" value=""
                                        class="form-control mt-2" placeholder="Slug" required />
                                </div>
                                <div class="form-group mb-3">
                                    <strong>Price :</strong>
                                    <input type="text" id="editPrice" name="price" value=""
                                        class="form-control mt-2" placeholder="Price" required />
                                </div>
                                <div class="form-group">
                                    <strong>Details:</strong>
                                    <textarea id="editDetails" name="details" rows="8" class="form-control mt-2 mb-2" placeholder="Details"
                                        required></textarea>
                                </div>
                          

                                <div class="form-group">
                                    <strong>Image:</strong>
                                    <br />
                                    <img style="width:150px;height:150px"
                                        src="{{ asset('images/no-img-avalible.png') }}" width="100%"
                                        id="editImg" alt="product" />
                                    <input type="file" name="img" value="{{ old('img') }}" id="img"
                                        class="form-control mt-2 mb-2" />
                                    <br />
                                </div>
                              

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
<!-- Edit Modal end -->

<!-- Add Modal start -->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #218838; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle">Add product</h5>
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
                    <form action="{{ route('products_store') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                        <input type="hidden" value="keyword" name="keyword" />
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group browsers">
                                    <!-- Category -->
                                    <strong>Category</strong><br>
                                    @foreach ($categories as $category)
                                        <label class="">
                                            <input type="checkbox" class="cat_select" name="category_id"
                                                class="{{ $category->id }}" value="{{ $category->id }}" />
                                            <span class="checkmark"></span>
                                            {{ $category->name }}
                                        </label>
                                    @endforeach
                                    <br>
                                    {{--
                                    <select name="category_id" class="form-control mt-2 mb-2" id="category" required>
                                        <option value="">Select Category</option>
                                   @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected="" @endif>{{ $category->name }}</option>
                                      @endforeach
                                    </select>
                                    --}}
                                    <strong>Title</strong>
                                    <input type="text" id="name-text" required name="name"
                                        value="{{ old('name') }}" class="form-control mt-2 mb-2"
                                        placeholder="Name" />
                                    <strong>Slug</strong>
                                    <input type="text" required name="slug" value="{{ old('slug') }}"
                                        class="form-control mt-2 mb-2" placeholder="Slug" id="slug-text" />
                                        <strong>Price</strong>
                                    <input type="text" required name="price" value="{{ old('price') }}"
                                        class="form-control mt-2 mb-2" placeholder="price" id="price-text" />
                                    <strong>Details:</strong>
                                    <textarea name="details" rows="8" class="form-control mt-2 mb-2" id="details" placeholder="Details">{{ old('details') }}</textarea>
                                    {{--
                                    <strong>Keywords:</strong>
                                    <textarea required name="keywords" rows="8" class="form-control mt-2 mb-2" id="keywords"
                                        placeholder="Keywords">{{ old('keywords') }}</textarea>
                                    <br />
                                   

                                    <strong>Video Link</strong>
                                    <input type="text" name="video_link" value="{{ old('video_link') }}" class="form-control mt-2 mb-2" placeholder="Youtube Embed Link" /> 
                                    <strong>Price</strong>
                                    <input type="text" name="price" value="{{ old('price') }}" class="form-control mt-2 mb-2" placeholder="Price" 
                                    id="slug-text"/>
                                    <strong>Variations</strong>
                                    <input type="text" name="variations" value="{{ old('variations') }}" class="form-control mt-2 mb-2" placeholder="Variations" 
                                    id="slug-text"/>                                    
                                    --}}
                                    <strong>Select Image to upload</strong>
                                    <input type="file" name="img" value="{{ old('img') }}" id="img"
                                        class="form-control mt-2 mb-2" required />
                                    <br />
                                    {{--
                                    <strong>Select video to upload</strong>
                                    <br>
                                    <input type="file" name="file" value="{{ old('file') }}" id="file"
                                        class="form-control mt-2 mb-2">
                                    
                                     <strong>Capacity/Month</strong>
                                    <input type="text" name="post_by" value="{{ old('post_by') }}" class="form-control mt-2 mb-2" placeholder="Capacity/Month" 
                                    id="slug-text"/>
                                    <strong>Post Date</strong>
                                    <input type="date" name="created_at" value="{{ old('created_at') }}" class="form-control mt-2 mb-2" placeholder="Date" 
                                    id="slug-text"/>
                                    --}}
                                    <!-- <strong>Select product to upload</strong>
                                    <br /> -->
                                    <!-- <input type="file" name="file" value="{{ old('file') }}" id="file" class="form-control mt-2 mb-2" /> -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn" style="background: #218838; color: #fff;">Save
                                changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal end -->


@section('css')
    <!-- <script src="{{ asset('vendors/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script> -->
    <link href="{{ asset('vendors/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <style>
        .toggle-on.btn {
            padding-right: 0.75rem;

        }


        .dropdown-item.active,
        .dropdown-item:active {
            color: #fff !important;
            text-decoration: none;
            background-color: #17b2a2;
        }

        .flex-btn {
            display: flex;
        }

        .btn-group span {
            text-transform: capitalize;
        }

        div#example_filter {
            float: right;
        }

        .form-delete {
            margin: 0;

        }

        .toggle-group .btn-success {
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
    <style>
        .dropdown-item.active,
        .dropdown-item:active {
            color: #fff !important;
            text-decoration: none;
            background-color: #17b2a2;
        }

        .flex-btn {
            display: flex;
        }

        .btn-group span {
            text-transform: capitalize;
        }

        div#example_filter {
            float: right;
        }

        .form-delete {
            margin: 0;

        }

        .toggle-group .btn-success {
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
        }

        body {
            background-color: gray;
        }

        * {
            font-family: Arial, Helvetica, san-serif;
        }

        .row:after,
        .row:before {
            content: " ";
            display: table;
            clear: both;
        }

        .span6 {
            float: left;
            width: 48%;
            padding: 1%;
        }

        .emojionearea-standalone {
            float: right;
        }

        .divOutside {
            height: 20px;
            width: 20px;
            background-position: -1px -26px;
            background-repeat: no-repeat;
            background-image: url(data:image/png;base64,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);
        }

        .emojionearea-button {
            opacity: 1 !important;
        }
    </style>
@section('link')
    <link rel="stylesheet" href="{{ asset('vendors/datatable/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/datatable/buttons/css/buttons.bootstrap4.min.css') }}" />
<!--     <link rel="stylesheet" href="{{ asset('vendors/x-editable/css/bootstrap-editable.css') }}" />
    <link rel="stylesheet" href="{{ asset('web/css/emojionearea.min.css') }}" /> -->

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
    <!-- <script src="{{ asset('web/js/emojionearea.js') }}"></script> -->
@endsection
@section('js')

    <script src="{{ asset('admin/vendors/ckeditor/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/vendors/js/lazyload-min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var lazyloadImages = document.querySelectorAll("img.lazy");
            var lazyloadThrottleTimeout;

            function lazyload() {
                if (lazyloadThrottleTimeout) {
                    clearTimeout(lazyloadThrottleTimeout);
                }
                lazyloadThrottleTimeout = setTimeout(function() {
                    var scrollTop = window.pageYOffset;
                    lazyloadImages.forEach(function(img) {
                        if (img.offsetTop < (window.innerHeight + scrollTop)) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                        }
                    });
                    if (lazyloadImages.length == 0) {
                        document.removeEventListener("scroll", lazyload);
                        window.removeEventListener("resize", lazyload);
                        window.removeEventListener("orientationChange", lazyload);
                    }
                }, 20);
            }
            document.addEventListener("scroll", lazyload);
            window.addEventListener("resize", lazyload);
            window.addEventListener("orientationChange", lazyload);
        });
    </script>
   
    <script>
        $(document).ready(function() {
            $("body").on("click", ".editModalBtn", function(event) {
                var id = $(this).data("id");
                var action = '{{ route('products_edit') }}/' + id;
                var url = '{{ route('products_edit') }}/' + id;
                var trArray = $(this).data("selected_cat");
    
                console.log(trArray);
                $.ajax({
                    type: "get",
                    url: url,
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $("#editId").val(data.id);
                     
                            $(".cap_category" + trArray).attr("checked", true);
                 
                        // document.getElementById("editType").value = data.type;
                        // document.getElementById('editCategory').value = data.category_id;
                        $("#editName").attr("value", data.name);
                        $("#editSlug").attr("value", data.slug);
                        $("#editPrice").attr("value", data.price);
                        CKEDITOR.instances.editDetails.setData(data.details);
                        $("#editDetails").html(data.details);

                        $("#editkeywords").val(data.keywords);
                        // $("#editvideo_link").val(data.video_link);
                        @if (env('APP_ENV') == 'local')
                            $("#editImg").attr("src", '{{ asset('') }}' + data.img);
                            var src = '{{ asset('') }}' + data.file;
                        @else
                            $("#editImg").attr("src", '{{ asset('') }}' + '/' + data.img);
                            var src = '{{ asset('') }}' + '/' + data.file;
                        @endif
                        if (data.file !== null) {
                            $("#editFile").prop("src", src)
                            $("#video-box").show();
                        } else {
                            $("#video-box").hide();
                        }
                        $("#editModal").modal("show");
                    },
                });
            });
        });
        // slug
        $(document).ready(function() {
            $("#name-text").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#slug-text").val(Text);
            });
            $("#editName").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#editSlug").val(Text);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var details = CKEDITOR.replace("details");
            details.on("change", function(evt) {
                $("#details").text(evt.editor.getData());
            });

            var editDetails = CKEDITOR.replace("editDetails");
            editDetails.on("change", function(evt) {
                $("#editDetails").text(evt.editor.getData());
            });
        });
    </script>
    <script>
        $(function() {
            $("body").on("change", ".is_active", function() {
                var is_active = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('products_status') }}',
                    data: {
                        'is_active': is_active,
                        'id': id
                    },
                    success: function(data) {
                        console.log(data.success)
                    }
                });
            })
        })
        $(function() {
            $("body").on("change", ".is_feature", function() {
                var is_feature = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('products_is_feature') }}',
                    data: {
                        'is_feature': is_feature,
                        'id': id
                    },
                    success: function(data) {
                        console.log(data.success)
                    }
                });
            })
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('.cat_select').click(function() {

                $('.cat_select').not(this).prop('checked', false);

            });

        });
    </script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <!-- <script>
                toastr.error("{{ $error }}");
            </script> -->
        @endforeach

    @endif
@endsection
