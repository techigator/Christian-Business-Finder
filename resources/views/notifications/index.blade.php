@extends('admin/layouts/app')
@section('title', 'Business')
@section('content')
    <style>
        .error-message {
            color: #d13d3d;
            font-weight: 600;
            font-size: 14px;
        }

        .tox-promotion {
            display: none;
        }

        .tox-statusbar__branding {
            display: none;
        }

        .remove-image {
            margin-bottom: 5rem;
            margin-left: 0.4rem;
            cursor: pointer;
            position: absolute;
        }

        .img-fluid {
            cursor: pointer;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #000000;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: default;
            float: left;
            margin-right: 5px;
            margin-top: 5px;
            padding: 0 5px;
        }
    </style>
    <!-- =============== Left side End ================-->
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <!-- ============ Body content start ============= -->

        <div class="main-content">
            <div class="separator-breadcrumb border-top"></div>
            <main>
                <div class="container-fluid site-width">
                    <!-- START: Breadcrumbs-->
                    <div class="row">
                        <div class="col-12 align-self-center">
                            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                                <div class="w-sm-100 mr-auto">
                                    <h4 class="mb-0">Notifications Listing Report</h4>
                                </div>
                                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/') }}" class="text-dark">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('notification.index') }}" class="text-dark">
                                            Notification Listing
                                        </a>
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

                    <div class="alert-container">
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close"
                                    data-dismiss="alert">×
                            </button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
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
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="card">
                                <div class="card-header justify-content-between align-items-center flex-btn">
                                    <h4 class="card-title">Notifications Listing</h4>
                                    <a class="btn btn-secondary mr-2" href="javascript:;" data-toggle="modal"
                                       data-target="#addModal"
                                       style="background: #1e1e2d; border-color: #1e1e2d; float: right;">
                                        Create New Notifications
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table id="example"
                                               class="display table dataTable table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Sr.no</th>
                                                <th>Users</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th width="180px">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($notifications as $notification)
                                                <tr data-notification-id="{{ $notification->id }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ ucwords(str_replace('_', ' ', implode(', ', explode(',', $notification->user_type ?? '')))) }}</td>
                                                    <td><img
                                                            src="{{ asset('uploads/notification/' . $notification->image ?? '') }}"
                                                            alt="{{ $notification->image ?? '' }}"
                                                            style="max-width: 50%; height: 5rem;"></td>
                                                    <td>{{ $notification->notification_title ?? '' }}</td>
                                                    <td>{{ strip_tags($notification->notification_description) ?? '' }}</td>
                                                    <td>
                                                        <form class="form-delete">
                                                            <a class="btn btn-info showModalBtn" href="javascript:;"
                                                               data-toggle="modal" data-target="#showModal"
                                                               data-show-id="{!! $notification->id !!}"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i></a>
                                                            {{--<a class="btn btn-primary edit-modal-btn"
                                                               href="javascript:;"
                                                               data-toggle="modal"
                                                               data-id="{!! $notification->id !!}"><i
                                                                    class="fas fa-solid fa-edit"></i></a>--}}

                                                            <button type="submit" class="btn btn-danger delete_button">
                                                                <i class="fas fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Sr.no</th>
                                                <th>Users</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th width="180px">Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>

                                        @if ($notifications->isEmpty())
                                            <div class="col-md-12">
                                                <div class="alert alert-warning"
                                                     style="margin: 10% 0; text-align: center;">
                                                    <strong>No Records Found</strong>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div class="flex-grow-1 mb-5"></div>
    </div>

    </div>
    <br>
    <br>

    <!-- Add Modal Start -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #1e1e2d; color: #fff;">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Notifications</h5>
                    <button type="button" class="close" style="color: #fff;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="document-content-add">
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
                        <form action="{{ route('notification.store') }}" class="add-form" method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
                            <input type="hidden" name="user_type" value="{{ Auth::user()->type }}"/>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">

                                        <strong>Select Users</strong>
                                        <div id="user-type-error" class="error-message"></div>
                                        <select class="js-example-basic-multiple form-control"
                                                id="membersSelect"
                                                name="user_type[]"
                                                multiple="multiple">
                                            <option value="all">All</option>
                                            <option value="consumer">Consumer</option>
                                            <option value="business">Business</option>
                                            <option value="paid_member">Paid Member</option>
                                            <option value="sales_person">Sales Person</option>
                                            <option value="user">User</option>
                                        </select>

                                        <div class="image-div my-4">
                                            <strong>Select Image to upload</strong>
                                            <div id="image-error" class="error-message"></div>
                                            <figure>
                                                <img
                                                    src="https://t4.ftcdn.net/jpg/04/70/29/97/360_F_470299797_UD0eoVMMSUbHCcNJCdv2t8B2g1GVqYgs.jpg"
                                                    id="preview-image" style="height: 120px; width: 200px"
                                                    class="img-fluid" alt="Preview Image">
                                                <input type="file" name="image" id="picture-input"
                                                       style="display: none;" accept="image/*">
                                                <i class="remove-image fa fa-times" aria-hidden="true"
                                                   onclick="removeImage()"></i>
                                            </figure>
                                        </div>
                                        <br>

                                        <strong>Title</strong>
                                        <div id="title-error" class="error-message"></div>
                                        <input type="text" id="title" class="form-control" name="notification_title"
                                               placeholder="Notification Title">
                                        <br>

                                        <strong>Description</strong>
                                        <div id="description-error" class="error-message"></div>
                                        <textarea class="form-control" name="notification_description"
                                                  id="myTextarea1" placeholder="Notification Description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn" style="background: #1e1e2d; color: #fff;">
                                    Send notification
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal End -->

    <!-- Show Modal Start -->
    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #1e1e2d; color: #fff;">
                    <h5 class="modal-title" id="exampleModal">Show Notifications</h5>
                    <button type="button" class="close" style="color: #fff;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="document-content-show">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Show Modal End -->
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.0/tinymce.min.js"
            integrity="sha512-hMjDyb/4G3SapFEM71rK+Gea0+ZEr9vDlhBTyjSmRjuEgza0Ytsb67GE0aSpRMYW++z6kZPPcnddwlUG6VKm9w=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();

            /*$('.add-form').submit(function (e) {
                e.preventDefault();

                var hasError = false;

                // Validate user type
                var userTypeValue = $('#membersSelect').val();
                if (!userTypeValue || userTypeValue.length === 0) {
                    hasError = true;
                    $('#user-type-error').text("Please provide user type.");
                } else {
                    $('#user-type-error').text("");
                }

                // Validate image
                var imageValue = $('#picture-input').val();
                if (!imageValue || imageValue.trim() === '') {
                    hasError = true;
                    $('#image-error').text("Please provide image.");
                } else {
                    $('#image-error').text("");
                }

                // Validate title
                var titleValue = $('#title').val();
                if (!titleValue || titleValue.trim() === '') {
                    hasError = true;
                    $('#title-error').text("Please provide title.");
                } else {
                    $('#title-error').text("");
                }

                // Validate description
                var descriptionValue = $('#myTextarea1').val();
                if (!descriptionValue || descriptionValue.trim() === '') {
                    hasError = true;
                    $('#description-error').text("Please provide description.");
                } else {
                    $('#description-error').text("");
                }

                // If any error exists, prevent form submission
                if (hasError) {
                    return false;
                }
            });*/

            $('.delete_button').click(function(event) {
                event.preventDefault();

                var row = $(this).closest('tr');
                var notificationId = row.data('notification-id');
                var url = "{{ route('notification.destroy') }}";

                swal({
                    title: `Are you sure?`,
                    text: "If you delete this notification, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: url + '/' + notificationId ,
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function(response) {
                                row.fadeOut(400, function() {
                                    row.remove();
                                });

                                var alertBox = $('<div class="alert alert-success alert-block">');
                                var closeButton = $('<button type="button" class="close" data-dismiss="alert">×</button>');
                                var strongTag = $('<strong>').text(response.success);

                                alertBox.append(closeButton, strongTag);
                                $('.alert-container').empty().append(alertBox);
                            },
                            error: function(xhr, status, error) {
                                var alertBox = $('<div class="alert alert-danger alert-block">');
                                var closeButton = $('<button type="button" class="close" data-dismiss="alert">×</button>');
                                var strongTag = $('<strong>').text(error);

                                alertBox.append(closeButton, strongTag);
                                $('.alert-container').empty().append(alertBox);
                            }
                        });
                    }
                });
            });
        });

        $('#membersSelect').change(function () {
            if ($(this).val() && $(this).val().includes('all')) {
                $(this).val(['consumer', 'business', 'paid_member', 'sales_person', 'user']).trigger('change.select2');
            }
        });

        tinymce.init({
            selector: '#myTextarea1',
            readonly: false
        });

        document.querySelector('#preview-image').addEventListener('click', function () {
            document.querySelector('#picture-input').click();
        });

        document.querySelector('#picture-input').addEventListener('change', function () {
            previewImage(this);
        });

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.querySelector('#preview-image').src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function showRemoveButton(input) {
            var image = document.getElementById('preview-image');
            var removeButton = document.getElementById('remove-button');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    image.src = e.target.result;
                    removeButton.style.display = 'inline-block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            var image = document.getElementById('preview-image');
            var removeButton = document.getElementById('remove-button');

            // Remove image
            image.src = 'https://t4.ftcdn.net/jpg/04/70/29/97/360_F_470299797_UD0eoVMMSUbHCcNJCdv2t8B2g1GVqYgs.jpg';
            // Hide remove button
            removeButton.style.display = 'none';
            // Clear file input
            document.getElementById('picture-input').value = '';
        }
    </script>

    <script>
        $(document).ready(function () {
            $(".showModalBtn").click(function () {
                var id = $(this).data("show-id");
                var url = '{{ route('notification.show') }}/' + id;
                $.ajax({
                    type: "get",
                    url: url,
                    success: function (data) {
                        var userTypes = data.user_type;

                        var documentContent = $('.document-content-show').empty();
                        var htmlContent = $('<div class="col-xs-12 col-sm-12 col-md-12">');

                        var selectElement = $('<div class="form-group">' +
                            '<label><strong>Select Users</strong></label>' +
                            '<select class="js-example-basic-multiple-1 form-control" name="user_type[]" multiple="multiple" disabled></select>' +
                            '</div>');

                        htmlContent.append(selectElement);

                        var selectOptions = '';
                        userTypes.forEach(function (userType) {
                            var capitalizedUserType = userType.replace(/_/g, ' ').replace(/\b\w/g, function (char) {
                                return char.toUpperCase();
                            });
                            selectOptions += '<option value="' + userType.toLowerCase() + '">' + capitalizedUserType + '</option>';
                        });

                        htmlContent.append('<div class="image-div my-4">' +
                            '<label><strong>Image</strong></label>' +
                            '<figure>' +
                            '<img src="' + data.image + '" id="preview-image" style="height: 120px; width: 200px" class="img-fluid" alt="Preview Image">' +
                            '</figure>' +
                            '</div>' +
                            '<br>' +
                            '<div class="form-group">' +
                            '<label><strong>Title</strong></label>' +
                            '<input type="text" class="form-control" name="notification_title" placeholder="Notification Title" value="' + data.notification_title + '" readonly>' +
                            '</div>' +
                            '<br>' +
                            '<div class="form-group">' +
                            '<label><strong>Description</strong></label>' +
                            '<textarea class="form-control" name="notification_description" id="myTextarea2" placeholder="Notification Description" >' + data.notification_description + '</textarea>' +
                            '</div>');


                        documentContent.append(htmlContent);
                        $('.js-example-basic-multiple-1').html(selectOptions);
                        $('.js-example-basic-multiple-1').val(userTypes).trigger('change').select2();


                        if (tinymce.get('myTextarea2')) {
                            tinymce.get('myTextarea2').setContent(data.notification_description);
                        } else {
                            tinymce.init({
                                selector: '#myTextarea2',
                                readonly: true,
                                setup: function (editor) {
                                    editor.on('init', function () {
                                        editor.setContent(data.notification_description);
                                    });
                                }
                            });
                        }

                        $("#showModal").modal("show");
                    },
                    error: function (error) {
                        console.log('error', error)
                    }
                });
            });
        });
    </script>
@endsection
