@extends('admin/layouts/app')  @section('content')

    <!-- =============== Left side End ================-->
    <div class="main-content-wrap sidenav-open d-flex flex-column pb-0">
        <!-- ============ Body content start ============= -->
        <div class="main-content">
            {{--
            <div class="breadcrumb">
                <h1 class="mr-2">{{Auth::user()->name}}</h1>
                <ul>
                    <li><a href="javascript:void(0)"> CMS Listing Dashboard</a></li>
                </ul>
            </div>
                --}}
            <div class="separator-breadcrumb border-top"></div>
            <!-- CMS listing Start   -->
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
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong></div>
                    @endif
                    <div class="card-header justify-content-between align-items-center">
                        <h4 class="card-title"><strong>CMS Management</strong></h4>

                        <a class="btn btn-success" href="" data-toggle="modal" data-target="#AddModal"
                           style="background: #28a745; border-color: #28a745;float:right;"> Create New CMS</a>

                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <th>Page</th>
                            <th>Title</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($cmss as $cms)
                            <tr>
                                <td>{{ $cms->id }}</td>
                                <td>{{ $cms->page }}</td>
                                <td>{{ $cms->name }}</td>
                                <td>
                                    <form action="{{ route('cms_destroy',$cms->id) }}" method="DELETE"
                                          class="form-delete">
                                        {{--
                                        <a class="btn btn-info showModalBtn" href="#" data-toggle="modal" data-showid="{!! $cms->id !!}">Show</a>
                                        --}}
                                        <a class="btn btn-primary edit-modal-btn" href="javascript:;" data-toggle="modal"
                                           data-id="{!! $cms->id !!}">Edit</a>
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete_button"
                                                onclick="return confirm('Are you sure you want to delete this cms?');">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Page</th>
                            <th>Title</th>
                            <th width="280px">Action</th>
                        </tr>
                        </tfoot>
                    </table>
                    @if($cmss->isEmpty())
                        <div class="col-md-12">
                            <div class="alert alert-warning" style="margin: 10% 0; text-align: center;">
                                <strong>No Records Found</strong>
                            </div>
                        </div>
                    @endif
                    <div class="row mt-3">
                        <div class="col-lg-6 offset-lg-6">
                            {!! $cmss->links('pagination::bootstrap-4') !!}
                        </div>
                    </div>
                    <!-- END: Card DATA-->
                </div>
            </main>
            <!-- CMS listing end   -->
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
@endsection


<!-- Add Modal start -->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #218838; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle">Add CMS</h5>
                <button type="button" class="close" style="color: #fff;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="document-content">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br/>
                            <br/>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <script type="text/javascript">
                            $("#AddModal").modal("show");
                        </script>
                    @endif
                    <form action="{{ route('cms_store') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Page</strong>
                                    <input type="text" name="page" value="{{ old('page') }}"
                                           class="form-control mt-2 mb-2" placeholder="page"
                                           id="page-text"/>
                                    <strong>Title</strong>
                                    <input type="text" id="name-text" name="name" value="{{ old('name') }}"
                                           class="form-control mt-2 mb-2" placeholder="Name"
                                    />
                                    <strong>Details:</strong>
                                    <textarea name="details" class="form-control mt-2 mb-2" id="details"
                                              placeholder="Details">{{ old('details') }}</textarea>
                                    <br/>
                                    <div class="ImgSection">
                                        <strong>Select Image to upload</strong>
                                        <input type="file" name="img" value="{{ old('img') }}" id="img"
                                               class="form-control mt-2 mb-2"/>
                                        <br/>
                                    </div>
                                    <!-- <strong>Select cms to upload</strong>
                                    <br /> -->
                                    <!-- <input type="file" name="file" value="{{ old('file') }}" id="file" class="form-control mt-2 mb-2" /> -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn" style="background: #218838; color: #fff;">Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal end -->


<!-- Edit Modal start -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #1e3d73; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit CMS</h5>
                <button type="button" class="close" style="color: #fff;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="document-content">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br/>
                            <br/>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('cms_update') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                        <input type="hidden" name="id" id="editId" value=""/>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Page:</strong>
                                    <input type="text" id="editpage" name="page" value="" class="form-control mt-2"
                                           placeholder="page" required/>
                                </div>
                                <div class="form-group">
                                    <strong>Title:</strong>
                                    <input type="text" id="editName" name="name" value="" class="form-control mt-2"
                                           placeholder="Name" required/>
                                </div>
                                <div class="form-group">
                                    <strong>Details:</strong>
                                    <textarea id="editDetails" name="details" class="form-control mt-2 mb-2"
                                              placeholder="Details"></textarea>
                                </div>
                                <div class="form-group ImgSection">
                                    <strong>Image:</strong>
                                    <br/>
                                    <img style="width:150px;height:150px" src="{{asset('images/no-img-avalible.png')}}"
                                         id="editImg" alt="cms"/>
                                    <input type="file" name="img" value="{{ old('img') }}" id="img"
                                           class="form-control mt-2 mb-2"/>
                                    <br/>
                                </div>
                                <!-- <div class="form-group">
                                    <strong>CMS</strong>
                                    <br />
                                    <cms width="320" height="240" controls id="showFile"></cms>
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
    <style>
        .app-footer {
            position: relative;
        }

        .modal-title {
            color: #fff;
        }

        .sub-header {
            /*        background-color: #eee;*/
            padding: 0 5px;
        }

        .breadcrumb-item a {
            /*        color: #000;*/
            padding: 0 5px;
        }

        .form-delete {
            margin: 0;
        }
    </style>
@endsection

@section('js')
    <script src="{{asset('admin/vendors/ckeditor/ckeditor/ckeditor.js')}}"></script>

    <script>
        // ClassicEditor
        //     .create(document.querySelector('#myTextarea1'))
        //     .then(myTextarea1 => {
        //         console.log(myTextarea1);
        //     })
        //     .catch(error => {
        //         console.error(error);
        //     });

        $(document).ready(function () {
            $(document).on('click', '.edit-modal-btn', function () {
                var id = $(this).data("id");
                var url = '{{ route("cms_edit") }}/' + id;

                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        id: id
                    },
                    success: function (data) {
                        $("#editId").val(data.id);
                        // document.getElementById("editType").value = data.type;
                        $("#editName").attr("value", data.name);
                        $("#editpage").attr("value", data.page);
                        CKEDITOR.instances.editDetails.setData(data.details);
                        // $("#editDetails").val(data.details);
                        @if (env('APP_ENV')=='local')
                        $("#editImg").attr("src", '{{asset("")}}' + data.img);
                        @else
                        $("#editImg").attr("src", '{{asset("")}}/' + data.img);
                        @endif
                        if (data.img == '') {
                            $(".ImgSection").hide();
                        }
                        // $("#editImg").attr("src", '{{asset("/")}}' + data.img);
                        // var cms = document.getElementById("editFile");
                        // var source = document.createElement("source");
                        // source.setAttribute("src", '{{asset("/")}}' + data.file);
                        // cms.appendChild(source);
                        // cms.play();
                        // $('#editid').attr('action', '{{route("cms_update")}}/'+id);
                        $("#edit-modal").modal('show');
                    },
                });
            });
        });
    </script>

    {{-- CKEditor --}}
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
    {{-- CKEditor --}}

@endsection
