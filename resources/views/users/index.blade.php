@extends('admin/layouts/app')
@section('content')

    <style>
        .max-height-card {
            max-height: 500px; /* Adjust the value to your preference */
            overflow-y: auto; /* Add a vertical scrollbar if the content exceeds the maximum height */
        }

        td.assgine-role {
            width: 18rem;
        }

        .card-title {
            font-weight: 500;
        }

        .admin-user-password {
            outline: none;
            box-shadow: none;
            background: none;
            border: none;
            position: relative;
            top: -2.1rem;
            left: 45rem;
        }
    </style>

    <!-- =============== Left side End ================-->
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <!-- ============ Body content start ============= -->
        <div class="main-content">
            <div class="separator-breadcrumb border-top"></div>
            <div class="container-fluid site-width">
                <div class="row">
                    <div class="col-12 align-self-center">
                        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                            <div class="w-sm-100 mr-auto">
                                <h4 class="mb-0">Users Listing Report</h4>
                            </div>
                            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-dark">Home</a></li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('business.index') }}" class="text-dark">Users Listing</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                        </div>
                        <div class="pull-right text-right p-2">
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close"
                                data-dismiss="alert">×
                        </button>
                        <strong>{{ $message }}</strong></div>
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
                            <div class="row card-row">
                                <div class="card-header justify-content-between align-items-center flex-btn">
                                    <h4 class="card-title">Users Listing</h4>
                                    <a class="btn btn-success" href="{{ route('export.user.report') }}"
                                       style="float: right;"> Export Excel File
                                    </a>
                                    <a class="btn btn-info mr-2 add-users" href="javascript:;" data-toggle="modal"
                                       style="float: right;"> Add Users
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="example"
                                           class="display table dataTable table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sr.no</th>
                                            <th>User Type</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            @if ($users->contains('type', 'sales_person'))
                                                <th>Sales Person Users Count</th>
                                            @endif
                                            <th width="480px">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                            @php
                                                $type = str_replace('_', ' ', ucwords($user->type))
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $type }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td class="user-email">{{ $user->email }}</td>
                                                @if ($users->contains('type', 'sales_person'))
                                                    <td class="user-email">
                                                        ( {{ count($user['referral_person']) ?? '0' }} )
                                                    </td>
                                                @endif
                                                <td class="assgine-role">
                                                    <a class="btn btn-secondary show-modal-btn" href="javascript:;"
                                                       style="background: #1e1e2d; border-color: #1e1e2d;"
                                                       data-toggle="modal"
                                                       data-id="{!! $user->id !!}"> <i class="fas fa-solid fa-eye"></i></a>
                                                    @if(Auth()->user()->type === 'admin')
                                                        @if ($type !== 'Admin')
                                                            {{--@if (!in_array($user->type, ['admin', 'consumer', 'sales_person', 'user']))
                                                                <a class="btn btn-secondary edit-modal-btn"
                                                                   href="javascript:;"
                                                                   style="background: #1e1e2d; border-color: #1e1e2d;"
                                                                   data-toggle="modal"
                                                                   data-id="{!! $user->id !!}"> Assign Role
                                                                    To {{ $type }}
                                                                </a>
                                                            @endif--}}
                                                            @if (!in_array($user->type, ['admin', 'consumer', 'sales_person', 'user', 'church']))
                                                                <a
                                                                    href="javascript:;"
                                                                    style="color: #fff8f8;"
                                                                    class="btn paid-status {{ $user->type == 'paid_member' ? 'btn-success' : 'btn-danger' }}"
                                                                    data-user-id="{{ $user->id }}"
                                                                    data-is-paid="{{ $user->type == 'paid_member' ? 1 : 0 }}">
                                                                    {{ $user->type == 'paid_member' ? 'Paid' : 'Not Paid' }}
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>Sr.no</th>
                                            <th>User Type</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            @if ($users->contains('type', 'sales_person'))
                                                <th>Sales Person Users Count</th>
                                            @endif
                                            <th width="180px">Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    @if ($users->isEmpty())
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
                                                        @if ($users->onFirstPage())
                                                            <li class="page-item disabled">
                                                                    <span class="page-link"
                                                                          aria-hidden="true">&laquo;</span>
                                                            </li>
                                                        @else
                                                            <li class="page-item">
                                                                <a class="page-link"
                                                                   href="{{ $users->previousPageUrl() }}" rel="prev"
                                                                   aria-label="Previous">&laquo;</a>
                                                            </li>
                                                        @endif

                                                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                                            <li class="page-item{{ $page == $users->currentPage() ? ' active' : '' }}">
                                                                <a class="page-link"
                                                                   href="{{ $url }}">{{ $page }}</a>
                                                            </li>
                                                        @endforeach

                                                        @if ($users->hasMorePages())
                                                            <li class="page-item">
                                                                <a class="page-link"
                                                                   href="{{ $users->nextPageUrl() }}" rel="next"
                                                                   aria-label="Next">&raquo;</a>
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
        </div>
    </div>
@endsection

<!-- Add Users Modal Start -->
<div class="modal fade" id="add-users-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #1e1e2d; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle1">Add User</h5>
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
                    <div id="app">
                        <form action="{{ route('add.user') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="referred_id" value="{{ Auth::user()->id }}"/>
                            <input type="hidden" name="referral_code" value="{{ Auth::user()->referral_code }}"/>
                            <input type="hidden" value="{{ csrf_token() }}" name="_token"/>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>User Type</strong>
                                        <select class="form-control mt-2 mb-2" name="type">
                                            <option value="">Select User Type</option>
                                            @foreach($userTypes as $type)
                                                @php
                                                    $userType = str_replace('_', ' ', ucwords($type))
                                                @endphp
                                                <option value="{{ $type }}">{{ $userType }}</option>
                                            @endforeach
                                        </select>

                                        <strong>User Name:</strong>
                                        <input type="text" name="name" value=""
                                               class="form-control mt-2 mb-2" placeholder="User Name">

                                        <strong>User Email:</strong>
                                        <input type="text" name="email" value=""
                                               class="form-control mt-2 mb-2" placeholder="User Email">

                                        <strong>User Password:</strong>
                                        <input
                                            id="password"
                                            :type="showPassword ? 'text' : 'password'"
                                            class="form-control mt-2 mb-2 @error('password') is-invalid @enderror"
                                            name="password"
                                            required
                                            autocomplete="password"
                                            placeholder="********"
                                        />
                                        <button
                                            type="button"
                                            class="admin-user-password"
                                            @click="togglePasswordVisibility"
                                        >
                                            <i aria-hidden="true" class="fa fa-eye"
                                               v-if="showPassword"></i>
                                            <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                        </button>
                                        <br>

                                        <strong>User Number:</strong>
                                        <input type="tel" name="number" value=""
                                               class="form-control mt-2 mb-2 phoneNumber" placeholder="Number">

                                        <strong>User DOB:</strong>
                                        <input type="date" name="date_of_birth" value=""
                                               class="form-control mt-2 mb-2" placeholder="DOB">

                                        <strong>User Gender:</strong>
                                        <select name="gender" id="" class="form-control mt-2 mb-2">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>

                                        <strong>User Profile Image:</strong>
                                        <figure>
                                            <img
                                                src="https://t4.ftcdn.net/jpg/04/70/29/97/360_F_470299797_UD0eoVMMSUbHCcNJCdv2t8B2g1GVqYgs.jpg"
                                                width="150px"
                                                id="add-user-image"
                                                alt="add-user-profile-image"/>
                                            <input type="file" name="profile_image" value="" id="user-profile-image"
                                                   class="form-control mt-2 mb-2"/>
                                        </figure>
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
</div>
<!-- Add Users Modal End -->

<!-- Edit Modal start -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #1e1e2d; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle">Assigne Role To User</h5>
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
                    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
                        <input type="hidden" name="id" id="edit-id" value=""/>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token"/>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>User Type</strong>
                                    <select class="form-control mt-2 mb-2" id="edit-type" name="user_type" required>
                                        @foreach($userTypes as $type)
                                            @php
                                                $userType = str_replace('_', ' ', ucwords($type))
                                            @endphp
                                            <option value="{{ $type }}">{{ $userType }}</option>
                                        @endforeach
                                    </select>
                                    <strong>User Name</strong>
                                    <input type="text" id="edit-name" name="user_name" value=""
                                           class="form-control mt-2 mb-2" placeholder="Name" disabled>
                                    <strong>User Email</strong>
                                    <input type="text" id="edit-email" name="user_email" value=""
                                           class="form-control mt-2 mb-2" placeholder="State" disabled>
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
<!-- Edit Modal start -->

<!-- Show Modal start -->
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
<!-- Show Modal start -->

@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                showPassword: false
            },
            methods: {
                togglePasswordVisibility() {
                    this.showPassword = !this.showPassword;
                }
            },
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".paid-status").on("click", function () {
                var $this = $(this);
                var user_id = $this.data('user-id');
                var is_paid = $this.data('is-paid');
                var url = '{{ route('user.status') }}/' + user_id;

                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        is_paid: is_paid,
                    },
                    success: function (response) {
                        if (response.success === true) {
                            toastr.success(response.message);

                            setTimeout(function() {
                                $this.parents('tr').hide();
                            }, 3000);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Error updating status:', textStatus, errorThrown);
                    }
                });
            });
        });
    </script>

    <script>
        $.noConflict()
        $(document).ready(function () {
            $(".edit-modal-btn").on("click", function () {
                var id = $(this).data('id');
                var url = '{{ route('user.edit') }}/' + id;

                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        id: id
                    },
                    success: function (data) {
                        console.log('data', data)
                        var user_type = data.type;
                        $("#edit-id").val(data.id);
                        $("#edit-type").val(data.type);
                        $("#edit-name").val(data.name);
                        $("#edit-email").val(data.email);
                    },
                });
                $("#edit-modal").modal("show");
            });

            $(".show-modal-btn").on("click", function () {
                var id = $(this).data('id');
                var url = '{{ route('user.show') }}/' + id;

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

                        let Type = replaceUnderscores(response.user.type.toUpperCase());

                        // User Detail
                        let type = response.user.type;
                        let name = response.user.name || '';
                        let email = response.user.email || '';
                        let gender = response.user.gender || '';
                        let date_of_birth = response.user.date_of_birth || '';
                        let number = response.user.number || '';
                        let denomination = response.user.denomination || '';
                        let home_church_address = response.user.home_church_address || '';
                        let profile = response.user.profile || 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png';

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
                            "<strong>Home Church Address:</strong>" +
                            "<input class='form-control mt-2 mb-2' type='text' value='" + home_church_address + "' readonly/>" +
                            "<strong>Profile Image:</strong>" +
                            "<img style='height: 5rem; width: 5rem;' src='" + profile + "' alt='User Profile'>"
                        );

                        // Business Detail
                        if (Type.toLowerCase() === "sales person") {
                            $.each(response.business, function (index, business) {
                                console.log('business', business)
                                let business_category_name = business.category_name || '';
                                let business_name = business.name || '';
                                let business_state = business.state || '';
                                let business_rating = business.rating || '';
                                let business_image = business.image || 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png';
                                let business_opening_hour = business.opening_hour || '';
                                let business_detail = business.detail || '';
                                let business_location = business.location || '';
                                let business_longitude = business.longitude || '';
                                let business_latitude = business.latitude || '';

                                $(".userModalBody").append(
                                    "<hr>" +
                                    "<strong><h3>Business Detail:</h3></strong>" +
                                    "<strong>Business category name:</strong>" +
                                    "<input class='form-control mt-2 mb-2' type='text' value='" + business_category_name + "' readonly/>" +
                                    "<strong>Business name:</strong>" +
                                    "<input class='form-control mt-2 mb-2' type='text' value='" + business_name + "' readonly/>" +
                                    "<strong>Business state:</strong>" +
                                    "<input class='form-control mt-2 mb-2' type='text' value='" + business_state + "' readonly/>" +
                                    "<strong>Business ratings:</strong>" +
                                    "<input class='form-control mt-2 mb-2' type='text' value='" + business_rating + "' readonly/>" +
                                    "<strong>Business image:</strong>" +
                                    "<img style='height: 5rem; width: 5rem;' src='" + business_image + "' alt='User Profile'>" +
                                    "<br/>" +
                                    "<strong>Business opening hours:</strong>" +
                                    "<input class='form-control mt-2 mb-2' type='text' value='" + business_opening_hour + "' readonly/>" +
                                    "<strong>Business details:</strong>" +
                                    "<input class='form-control mt-2 mb-2' type='text' value='" + business_detail + "' readonly/>" +
                                    "<strong>Business location:</strong>" +
                                    "<input class='form-control mt-2 mb-2' type='text' value='" + business_location + "' readonly/>" +
                                    "<strong>Business longtitude:</strong>" +
                                    "<input class='form-control mt-2 mb-2' type='text' value='" + business_longitude + "' readonly/>" +
                                    "<strong>Business latitude:</strong>" +
                                    "<input class='form-control mt-2 mb-2' type='text' value='" + business_latitude + "' readonly/>"
                                );
                            });
                        }

                        $("#show-modal").modal("show");
                    },
                    error: function (response) {
                        console.log('response', response)
                    },
                });
                $("#show-modal").modal("show");
            });

            $(".add-users").on("click", function () {
                $("#add-users-modal").modal("show");
            });

            $('#user-profile-image').on('change', function (event) {
                var input = event.target;
                var reader = new FileReader();

                reader.onload = function () {
                    var dataURL = reader.result;
                    $('#add-user-image').attr('src', dataURL);
                };

                reader.readAsDataURL(input.files[0]);
            });
            $('#image').on('change', function (event) {
                var input = event.target;
                var reader = new FileReader();

                reader.onload = function () {
                    var dataURL = reader.result;
                    $('#edit-image').attr('src', dataURL);
                };

                reader.readAsDataURL(input.files[0]);
            });
        });

        // slug
        $(document).ready(function () {
            $("#name-text").keyup(function () {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#slug-text").val(Text);
            });
            $("#editName").keyup(function () {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#editSlug").val(Text);
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            $(".showModalBtn").click(function () {
                var id = $(this).data("showid");
                var url = '{{ route('business.show') }}/' + id;
                $.ajax({
                    type: "get",
                    url: url,
                    data: {
                        id: id
                    },
                    success: function (data) {
                        $("#showid").val(data.id);
                        // document.getElementById("showType").value = data.type;
                        $("#showName").attr("value", data.name);
                        $("#showSlug").attr("value", data.slug);
                        // CKEDITOR.instances.showDetails.setData(data.details);
                        // $("#showImg").attr("src", '{{ asset('') }}' + data.img);
                        // $("#showPost_by").val(data.post_by);
                        // $("#showCreated_at").val(data.created_at);
                        // var category = document.getElementById("showFile");
                        // var source = document.createElement("source");
                        // source.setAttribute("src", '{{ asset('/') }}' + data.file);
                        // category.appendChild(source);
                        // category.play();
                        $("#showid").attr("action", '{{ route('category_show') }}/' + id);
                        $("#showModal").modal("show");
                    },
                });
            });
        });
    </script>
    <script>
        $(function () {
            $("body").on("change", ".toggle-class", function () {
                var is_active = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('business.status') }}',
                    data: {
                        'is_active': is_active,
                        'id': id
                    },
                    success: function (data) {
                        console.log(data.success)
                    }
                });
            })
        })
    </script>
@endsection
