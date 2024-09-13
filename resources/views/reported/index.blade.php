@extends('admin/layouts/app')
@section('title', 'Reports')
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
                                    <h4 class="mb-0">Reports Listing Report</h4>
                                </div>
                                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/') }}" class="text-dark">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('report.index') }}" class="text-dark">
                                            Report Listing
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
                                    <h4 class="card-title">Reports Listing</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table id="example"
                                               class="display table dataTable table-striped table-bordered"
                                               style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Sr.no</th>
                                                <th>Reported By</th>
                                                <th>Reported To</th>
                                                <th>Report Content</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($reports as $report)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $report->reportedBy->name ?? '' }}</td>
                                                    <td>{{ $report->reportedTo->name ?? '' }}</td>
                                                    <td>{{ Str::limit($report->content, 50, '...') ?? '' }}</td>
                                                    <td>
                                                        <form class="form-delete">

                                                            <a class="btn btn-info showModalBtn" href="javascript:;"
                                                               data-toggle="modal" data-target="#showModal"
                                                               data-show-id="{!! $report->id !!}"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i></a>

                                                            <button type="submit" class="btn btn-danger delete-button"
                                                                    data-id="{{ $report->id }}">
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
                                                <th>Reported By</th>
                                                <th>Reported To</th>
                                                <th>Report Content</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>

                                        @if ($reports->isEmpty())
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

    <!-- Show Modal Start -->
    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #1e1e2d; color: #fff;">
                    <h5 class="modal-title" id="exampleModal">Show Reports</h5>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.0/tinymce.min.js"
            integrity="sha512-hMjDyb/4G3SapFEM71rK+Gea0+ZEr9vDlhBTyjSmRjuEgza0Ytsb67GE0aSpRMYW++z6kZPPcnddwlUG6VKm9w=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.delete-button').click(function (e) {
                e.preventDefault();

                var row = $(this).closest('tr');
                var report_id = $(this).data('id');
                var url = "{{ route('report.delete') }}" + '/' + report_id;

                swal({
                    title: `Are you sure?`,
                    text: "If you delete this report, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                row.fadeOut(400, function () {
                                    row.remove();
                                });

                                var alertBox = $('<div class="alert alert-success alert-block">');
                                var closeButton = $('<button type="button" class="close" data-dismiss="alert">×</button>');
                                var strongTag = $('<strong>').text(response.message);

                                alertBox.append(closeButton, strongTag);
                                $('.alert-container').empty().append(alertBox);
                            },
                            error: function (xhr, status, error) {
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
    </script>

    <script>
        $(document).ready(function () {
            let counter = 0;

            $(".showModalBtn").click(function () {

                var id = $(this).data("show-id");
                var url = '{{ route('report.show') }}/' + id;
                counter++;

                $.ajax({
                    type: "get",
                    url: url,
                    success: function (response) {

                        var documentContent = $('.document-content-show').empty();
                        var htmlContent = $('<div class="col-xs-12 col-sm-12 col-md-12">');

                        // report detail
                        let reporting_by = response.data.report[0] || 'Empty';
                        let reporting_to = response.data.report[1] || 'Empty';
                        let content = response.data.report[2] || 'Empty';

                        // reported by user detail
                        let reported_by_business_name = response.data.reported_by_user.buisness_name || 'Empty';
                        let reported_by_email = response.data.reported_by_user.email || 'Empty';
                        let reported_by_number = response.data.reported_by_user.number || 'Empty';

                        // reported to user detail
                        let reported_to_business_name = response.data.reported_to_user.buisness_name || 'Empty';
                        let reported_to_email = response.data.reported_to_user.email || 'Empty';
                        let reported_to_number = response.data.reported_to_user.number || 'Empty';

                        htmlContent.empty().append(
                            "<h4><strong>Report Detail:</strong></h4>" +
                            "<strong>Reported By:</strong>" +
                            "<input class='form-control mt-2 mb-2' type='text' value='" + reporting_by + "' readonly/>" +
                            "<strong>Reported To:</strong>" +
                            "<input class='form-control mt-2 mb-2' type='text' value='" + reporting_to + "' readonly/>" +
                            "<strong>Reported Content:</strong>" +
                            "<textarea id='myDynamicTextarea-" + counter + "' name='review' rows='3' class='form-control mb-3'></textarea>" +
                            "<br/>" +
                            "<h4><strong>Reported By User Detail:</strong></h4>" +
                            "<strong>Reported By User Business Name:</strong>" +
                            "<input class='form-control mt-2 mb-2' type='text' value='" + reported_by_business_name + "' readonly/>" +
                            "<strong>Reported By User Email:</strong>" +
                            "<input class='form-control mt-2 mb-2' type='email' value='" + reported_by_email + "' readonly/>" +
                            "<strong>Reported By User Number:</strong>" +
                            "<input class='form-control mt-2 mb-2' type='tel' value='" + reported_by_number + "' readonly/>" +
                            "<br/>" +
                            "<h4><strong>Reported To User Detail:</strong></h4>" +
                            "<strong>Reported To User Business Name:</strong>" +
                            "<input class='form-control mt-2 mb-2' type='text' value='" + reported_to_business_name + "' readonly/>" +
                            "<strong>Reported To User Email:</strong>" +
                            "<input class='form-control mt-2 mb-2' type='email' value='" + reported_to_email + "' readonly/>" +
                            "<strong>Reported To User Number:</strong>" +
                            "<input class='form-control mt-2 mb-2' type='tel' value='" + reported_to_number + "' readonly/>"
                        );

                        documentContent.empty().append(htmlContent);

                        // Initialize or update TinyMCE instance for the current textarea
                        var textareaId = 'myDynamicTextarea-' + counter;
                        var charCountId = 'charCount-' + counter;

                        if (tinymce.get(textareaId)) {
                            tinymce.get(textareaId).setContent(content);
                        } else {
                            tinymce.init({
                                selector: '#' + textareaId,
                                readonly: true,
                                setup: function (editor) {
                                    editor.on('init', function () {
                                        editor.setContent(content);
                                        // Update character count initially
                                        updateCharacterCount(editor, charCountId);
                                    });

                                    // Update character count on keyup or change events
                                    editor.on('keyup change', function () {
                                        updateCharacterCount(editor, charCountId);
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

            function updateCharacterCount(editor, charCountId) {
                let charCount = editor.getContent().length;
                $('#' + charCountId).text(charCount);
            }
        });
    </script>
@endsection
