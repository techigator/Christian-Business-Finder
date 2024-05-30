@extends('admin/layouts/app')
@section('title', 'Payments')
@section('content')
    <style>
        .error-message {
            color: #d13d3d;
            font-weight: 600;
            font-size: 14px;
        }

        .remove-thumbnail {
            margin-bottom: 5rem;
            margin-left: 0.4rem;
            cursor: pointer;
            position: absolute;
        }

        .remove-image {
            margin-bottom: 5rem;
            margin-left: 0.4rem;
            cursor: pointer;
            position: absolute;
        }

        .remove-preview-image {
            margin-bottom: 5rem;
            margin-left: 0.4rem;
            cursor: pointer;
            position: absolute;
        }

        table.dataTable {
            width: 125%;
            margin: 0 auto;
            clear: both;
            border-collapse: separate;
            border-spacing: 0;
        }

        .ck.ck-editor {
            position: relative;
            margin-bottom: 2rem !important;
        }

        .ck.ck-editor__main > .ck-editor__editable:not(.ck-focused) {
            border-color: var(--ck-color-base-border);
            height: 10rem !important;
            padding: 1rem !important;
        }

        .ck-rounded-corners .ck.ck-editor__main > .ck-editor__editable, .ck.ck-editor__main > .ck-editor__editable.ck-rounded-corners {
            border-radius: var(--ck-border-radius);
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            height: 10rem !important;
            padding: 1rem !important;
        }

        .ck.ck-editor__editable.ck-focused:not(.ck-editor__nested-editable) {
            border: var(--ck-focus-ring);
            box-shadow: var(--ck-inner-shadow), 0 0;
            outline: none;
            height: 10rem !important;
            padding: 1rem !important;
        }

        .multi-suggestions {
            background: white !important;
            padding: 1rem;
            margin-bottom: 1rem;
            height: 200px;
            overflow: auto;
            border-radius: 4px;
            border: 2px solid #00000070;
        }

        .suggestion {
            padding: 1rem;
            border-bottom: 1px solid #e9eef1;
            cursor: pointer;
        }

        .suggestion:hover {
            background: #f1e4d4;
        }

        .accent-color {
            transform: scale(1.5) !important;
        }

        .accent {
            accent-color: #7c6947 !important;
        }
    </style>
    <!-- =============== Left side End ================-->
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <!-- ============ Body content start ============= -->
        <div class="main-content">
            <div class="separator-breadcrumb border-top"></div>
            <!-- category listing Start   -->
            <main>
                <div class="container-fluid site-width">
                    <!-- START: Breadcrumbs-->
                    <div class="row">
                        <div class="col-12 align-self-center">
                            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                                <div class="w-sm-100 mr-auto">
                                    <h4 class="mb-0">User Payments Listing</h4>
                                </div>
                                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-dark">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('payment.index') }}"
                                                                   class="text-dark">User Payments Listing</a>
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

                    <div class="alert-container"></div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close"
                                    data-dismiss="alert">×
                            </button>
                            <strong>{{ $message }}</strong></div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> {{--There were some problems with your input.<br/>--}}
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
                                    <h4 class="card-title">User Payments Listing</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table id="example"
                                               class="display table dataTable table-striped table-bordered"
                                               style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Sr.no</th>
                                                <th>Username</th>
                                                <th>Amount</th>
                                                <th>Pay Method Name</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($payments as $payment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $payment->user->name ?? '' }}</td>
                                                    <td>{{ $payment->amount ?? '' }}</td>
                                                    <td>{{ $payment->pay_method_name ?? '' }}</td>
                                                    <td>
                                                        <form class="form-delete">
                                                            <a class="btn btn-secondary show-modal-btn"
                                                               href="javascript:;"
                                                               data-toggle="modal"
                                                               data-id="{{ $payment->user->id }}">
                                                                <i class="fas fa-solid fa-eye"></i>
                                                            </a>
                                                            <button type="submit" class="btn btn-danger delete-button" data-id="{{ $payment->id }}">
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
                                                <th>Username</th>
                                                <th>Amount</th>
                                                <th>Pay Method Name</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        @if ($payments->isEmpty())
                                            <div class="col-md-12">
                                                <div class="alert alert-warning"
                                                     style="margin: 10% 0; text-align: center;">
                                                    <strong>No Records Found</strong>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="container mt-3">
                                            <div class="row">
                                                <div class="col-lg-6 offset-lg-3">
                                                    <nav aria-label="Page navigation">
                                                        <ul class="pagination justify-content-center">
                                                            @if ($payments->onFirstPage())
                                                                <li class="page-item disabled">
                                                                    <span class="page-link"
                                                                          aria-hidden="true">&laquo;</span>
                                                                </li>
                                                            @else
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                       href="{{ $payments->previousPageUrl() }}"
                                                                       rel="prev" aria-label="Previous">&laquo;</a>
                                                                </li>
                                                            @endif

                                                            @foreach ($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                                                                <li class="page-item{{ $page == $payments->currentPage() ? ' active' : '' }}">
                                                                    <a class="page-link"
                                                                       href="{{ $url }}">{{ $page }}</a>
                                                                </li>
                                                            @endforeach

                                                            @if ($payments->hasMorePages())
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                       href="{{ $payments->nextPageUrl() }}"
                                                                       rel="next" aria-label="Next">&raquo;</a>
                                                                </li>
                                                            @else
                                                                <li class="page-item disabled">
                                                                    <span class="page-link"
                                                                          aria-hidden="true">&raquo;</span>
                                                                </li>
                                                            @endif

                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
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
@endsection

{{-- Show Modal Start --}}
<div class="modal fade" id="show-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #1e1e2d; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle1">Pertinent Information</h5>
                <button type="button" class="close" style="color: #fff;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body userModalBody" id="userModalBody">
            </div>
        </div>
    </div>
</div>
{{-- Show Modal End --}}

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(".show-modal-btn").on("click", function () {
            var id = $(this).data('id');
            var url = '{{ route('payment.user.detail.show') }}/' + id;

            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    function replaceUnderscores(inputString) {
                        if (typeof inputString === 'string') {
                            return inputString.replace(/_/g, ' ');
                        } else {
                            return '';
                        }
                    }

                    let Type = replaceUnderscores(response.data.type.toUpperCase());

                    // User Detail
                    let type = response.data.type;
                    let name = response.data.name || '';
                    let email = response.data.email || '';
                    let gender = response.data.gender || '';
                    let date_of_birth = response.data.date_of_birth || '';
                    let number = response.data.number || '';
                    let denomination = response.data.denomination || '';
                    let home_church_name = response.data.home_church_name || '';
                    let home_church_address = response.data.home_church_address || '';
                    let profile = response.data.profile || 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png';

                    $(".userModalBody").empty();

                    $(".userModalBody").append(
                        "<strong><h3>" + Type + " DETAILS:</h3></strong>" +
                        "<strong>Member:</strong>" +
                        "<input class='form-control mt-2 mb-2' type='text' value='" + type + "' readonly/>" +
                        "<strong>Name:</strong>" +
                        "<input class='form-control mt-2 mb-2' type='text' value='" + name + "' readonly/>" +
                        "<strong>Email:</strong>" +
                        "<input class='form-control mt-2 mb-2' type='text' value='" + email + "' readonly/>" +
                        "<strong>Gender:</strong>" +
                        "<input class='form-control mt-2 mb-2' type='text' value='" + gender + "' readonly/>" +
                        "<strong>Date of Birth:</strong>" +
                        "<input class='form-control mt-2 mb-2' type='text' value='" + date_of_birth + "' readonly/>" +
                        "<strong>Number:</strong>" +
                        "<input class='form-control mt-2 mb-2' type='text' value='" + number + "' readonly/>" +
                        "<strong>Denomination:</strong>" +
                        "<input class='form-control mt-2 mb-2' type='text' value='" + denomination + "' readonly/>" +
                        "<strong>Home Church Name:</strong>" +
                        "<input class='form-control mt-2 mb-2' type='text' value='" + home_church_name + "' readonly/>" +
                        "<strong>Home Church Address:</strong>" +
                        "<input class='form-control mt-2 mb-2' type='text' value='" + home_church_address + "' readonly/>" +
                        "<strong>Profile Image:</strong>" +
                        "<img style='height: 5rem; width: 5rem;' src='" + profile + "' alt='User Profile'>"
                    );

                    $("#show-modal").modal('show');
                },
                error: function (response) {
                    console.log('response', response)
                },
            });
        });

        $(document).ready(function () {
            $('.delete-button').click(function (e) {
                e.preventDefault();

                var row = $(this).closest('tr');
                var payment_id = $(this).data('id');
                var url = "{{ route('payment.user.delete') }}" +'/'+ payment_id;

                swal({
                    title: `Are you sure?`,
                    text: "If you delete this payment, it will be gone forever.",
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
@endsection
