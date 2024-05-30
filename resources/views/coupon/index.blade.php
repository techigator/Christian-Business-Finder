@extends('admin/layouts/app')
@section('title', 'Coupons')
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
                                    <h4 class="mb-0">Coupons Listing</h4>
                                </div>
                                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-dark">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('admin.coupon') }}"
                                                                       class="text-dark">Coupons Listing</a>
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
                                    <h4 class="card-title">Coupons Listing</h4>
                                    <a class="btn btn-secondary mr-2" href="" data-toggle="modal"
                                       data-target="#add-modal"
                                       style="background: #1e1e2d; border-color: #1e1e2d; float: right;">
                                        Create Coupon
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table id="example"
                                               class="display table dataTable table-striped table-bordered"
                                               style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Sr.no</th>
                                                <th>Created For</th>
                                                <th>Code</th>
                                                <th>Discount Amount</th>
                                                <th>Percentage</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($coupons as $coupon)
                                                @php
                                                    $type = str_replace('_', ' ', ucwords($coupon->user_type ?? 'users'))
                                                @endphp

                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $type ?? '' }}</td>
                                                    <td>{{ $coupon->code ?? '' }}</td>
                                                    <td>{{ $coupon->discount_amount ?? '' }}</td>
                                                    @if($coupon->is_percentage == 1)
                                                        <td>{{ '%' }}</td>
                                                    @else
                                                        <td>{{ 'Fixed Amount' }}</td>
                                                    @endif
                                                    <td>
                                                        <form class="form-delete">
                                                            <a class="btn btn-primary edit-modal-btn"
                                                               href="javascript:;"
                                                               data-toggle="modal"
                                                               data-id="{{ $coupon->id }}">
                                                                <i class="fas fa-solid fa-edit"></i>
                                                            </a>
                                                            <button type="submit" class="btn btn-danger delete_button" data-id="{{ $coupon->id }}">
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
                                                <th>Created For</th>
                                                <th>Code</th>
                                                <th>Discount Amount</th>
                                                <th>Percentage</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        @if ($coupons->isEmpty())
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
                                                            @if ($coupons->onFirstPage())
                                                                <li class="page-item disabled">
                                                                    <span class="page-link"
                                                                          aria-hidden="true">&laquo;</span>
                                                                </li>
                                                            @else
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                       href="{{ $coupons->previousPageUrl() }}"
                                                                       rel="prev" aria-label="Previous">&laquo;</a>
                                                                </li>
                                                            @endif

                                                            @foreach ($coupons->getUrlRange(1, $coupons->lastPage()) as $page => $url)
                                                                <li class="page-item{{ $page == $coupons->currentPage() ? ' active' : '' }}">
                                                                    <a class="page-link"
                                                                       href="{{ $url }}">{{ $page }}</a>
                                                                </li>
                                                            @endforeach

                                                            @if ($coupons->hasMorePages())
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                       href="{{ $coupons->nextPageUrl() }}"
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

<!-- Add Modal start -->

<!-- Add Modal Start -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #1e1e2d; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Coupon</h5>
                <button type="button" class="close" style="color: #fff;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="document-content">
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
                        <script type="text/javascript">
                            $("#add-modal").modal("show");
                        </script>
                    @endif
                    <form action="{{ route('coupon.store') }}" class="add-form" method="POST"
                          enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                        <input type="hidden" value="{{ Auth::user()->type }}" name="user_type"/>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <!--<strong>Created by</strong>-->

                                    <strong>Created to</strong>
                                    <select name="user_type" class="form-control mt-2 mb-2" onchange="toggleSalesPerson(this)">
                                        <option value="">Select for Type</option>
                                        <option value="admin">Admin Users</option>
                                        <option value="sales_person">Sales Person Users</option>
                                    </select>

                                    <div class="sales-person d-none">
                                        <strong>Select Sales Person</strong>
                                        <select name="sales_person_id" class="form-control mt-2 mb-2">
                                            <option value="">Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <strong>Code</strong>
                                    <div id="business-error" class="error-message"></div>
                                    <input type="text" name="code" id="code" class="form-control mt-2 mb-2"
                                           placeholder="Code" value=""/>

                                    <strong>Discount Amount</strong>
                                    <div id="state-error" class="error-message"></div>
                                    <input type="text" name="discount_amount" id="discount-amount" class="form-control mt-2 mb-2"
                                           placeholder="Discount Amount" value=""/>

                                    <br>
                                    <strong>Discount Type</strong>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="discount_type" value="percentage" id="percentage" checked>
                                        <label class="form-check-label" for="percentage">
                                            Percentage
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="discount_type" value="fixed" id="fixed">
                                        <label class="form-check-label" for="fixed">
                                            Fixed Amount
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn" style="background: #1e1e2d; color: #fff;">Save
                                changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal End -->

<!-- Edit Modal Start -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #1e1e2d; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Business</h5>
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
                    <form action="{{ route('business.update') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
                        <input type="hidden" name="id" id="edit-id" value=""/>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token"/>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Created by</strong>
                                    <input type="text" id="edit-type" name="user_type" value=""
                                           class="form-control mt-2 mb-2" placeholder="Name" readonly>

                                    <strong>Edit Business Name</strong>
                                    <input type="text" id="edit-name" name="name" value=""
                                           class="form-control mt-2 mb-2" placeholder="Name" required>
                                    <strong>Edit State</strong>
                                    <input type="text" id="edit-state" name="state" value=""
                                           class="form-control mt-2 mb-2" placeholder="State" required>
                                    <strong>Edit Rating</strong>
                                    <input type="text" name="ratings" value=""
                                           class="form-control mt-2 mb-2" placeholder="Rating" id="edit-ratings"
                                           required/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn" style="background: #1e1e2d; color: #fff;">Save
                                changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Modal End -->

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

    <script>
        function toggleSalesPerson(select) {
            let salesPersonDiv = document.querySelector('.sales-person');
            if (select.value === 'sales_person') {
                salesPersonDiv.classList.remove('d-none');
            } else {
                salesPersonDiv.classList.add('d-none');
            }
        }

        $(document).ready(function () {
            $('.delete_button').click(function (e) {
                e.preventDefault();

                var row = $(this).closest('tr');
                var coupon_id = $(this).data('id');
                var url = "{{ route('coupon.delete') }}" +'/'+ coupon_id;

                swal({
                    title: `Are you sure?`,
                    text: "If you delete this coupon, it will be gone forever.",
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
                                var strongTag = $('<strong>').text(response.success);

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
