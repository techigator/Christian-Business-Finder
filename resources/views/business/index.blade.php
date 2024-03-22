@extends('admin/layouts/app')
@section('title', 'Business')
@section('content')
    <style>
        .error-message {
            color: #d13d3d;
            font-weight: 600;
            font-size: 14px;
        }
    </style>
    <!-- =============== Left side End ================-->
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <!-- ============ Body content start ============= -->
        <div class="main-content">
            {{--
        <div class="breadcrumb">
            <h1 class="mr-2">{{Auth::user()->name}}</h1>
            <ul>
                <li><a href="javascript:void(0)"> Category Listing Dashboard</a></li>
            </ul>
        </div>
            --}}
            <div class="separator-breadcrumb border-top"></div>
            <!-- category listing Start   -->
            <main>
                <div class="container-fluid site-width">
                    <!-- START: Breadcrumbs-->
                    <div class="row">
                        <div class="col-12 align-self-center">
                            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                                <div class="w-sm-100 mr-auto">
                                    <h4 class="mb-0">Business Listing Report</h4>
                                </div>
                                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-dark">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('business.index') }}"
                                                                   class="text-dark">Business Listing</a>
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
                                <div class="card-header justify-content-between align-items-center flex-btn">
                                    <h4 class="card-title">Business Listing</h4>
                                    <a class="btn btn-success" href="{{ route('export.business.report') }}"
                                       style="float: right;"> Export Excel File
                                    </a>
                                    <a class="btn btn-secondary mr-2" href="" data-toggle="modal"
                                       data-target="#AddModal"
                                       style="background: #1e1e2d; border-color: #1e1e2d; float: right;"> Create New
                                        Business</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table id="example"
                                               class="display table dataTable table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Sr.no</th>
                                                <th width="120px">Category Name</th>
                                                <th>Name</th>
                                                <th>State</th>
                                                <th>Rating</th>
                                                <th width="120px">Opening Hour</th>
                                                <th>Detail</th>
                                                <th>Location</th>
                                                <th>Longitude</th>
                                                <th>Latitude</th>
                                                <th width="180px">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($businesses as $business)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $business->category->name ?? 'Business' }}</td>
                                                    <td>{{ $business->name ?? 'Koelpin, Hahn and Fay' }}</td>
                                                    <td>{{ $business->state ?? 'Colorado' }}</td>
                                                    <td>{{ $business->ratings ?? '0' }}</td>
                                                    <td>{{ $business->opening_hours ?? '00:00' }}</td>
                                                    <td>{{ strip_tags($business->details ?? 'Upgradable Uniform Securedline') }}</td>
                                                    <td>{{ $business->location ?? '65579 Marley Neck' }}</td>
                                                    <td>{{ $business->longitude ?? '39.169680' }}</td>
                                                    <td>{{ $business->latitude ?? '-76.574990' }}</td>
                                                    <td>
                                                        <form action="{{ route('business.destroy', $business->id) }}"
                                                              method="DELETE" class="form-delete">
                                                            <!-- <a class="btn btn-info showModalBtn" href="#" data-toggle="modal" data-showid="{!! $business->id !!}">Show</a> -->
                                                            <a title="send-mail" class="btn btn-success" href="{{ route('customized.members.send.mail', $business->id) }}">
                                                            <i class="fas fa-solid fa-share"></i>
                                                            </a>
                                                            <a class="btn btn-primary edit-modal-btn" href="javascript:;"
                                                               data-toggle="modal"
                                                               data-id="{!! $business->id !!}"><i
                                                                    class="fas fa-solid fa-edit"></i></a>
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger delete_button"
                                                                    onclick="return confirm('Are you sure you want to delete this business?');">
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
                                                <th width="120px">Category Name</th>
                                                <th>Name</th>
                                                <th>State</th>
                                                <th>Rating</th>
                                                <th width="120px">Opening Hour</th>
                                                <th>Detail</th>
                                                <th>Location</th>
                                                <th>Longitude</th>
                                                <th>Latitude</th>
                                                <th width="180px">Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        @if ($businesses->isEmpty())
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
                                                            @if ($businesses->onFirstPage())
                                                                <li class="page-item disabled">
                                                                    <span class="page-link"
                                                                          aria-hidden="true">&laquo;</span>
                                                                </li>
                                                            @else
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                       href="{{ $businesses->previousPageUrl() }}"
                                                                       rel="prev" aria-label="Previous">&laquo;</a>
                                                                </li>
                                                            @endif

                                                            @foreach ($businesses->getUrlRange(1, $businesses->lastPage()) as $page => $url)
                                                                <li class="page-item{{ $page == $businesses->currentPage() ? ' active' : '' }}">
                                                                    <a class="page-link"
                                                                       href="{{ $url }}">{{ $page }}</a>
                                                                </li>
                                                            @endforeach

                                                            @if ($businesses->hasMorePages())
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                       href="{{ $businesses->nextPageUrl() }}"
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

<style>

</style>
<!-- Add Modal start -->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #1e1e2d; color: #fff;">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Business</h5>
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
                    <form action="{{ route('business.store') }}" class="add-form" method="POST"
                          enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                        <input type="hidden" value="{{ Auth::user()->type }}" name="user_type"/>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <!--<strong>Created by</strong>-->
                                    @if(Auth::user()->type === 'sales_person')
                                        <input type="hidden" id="name-text" name="user_type" value="Sale Person"
                                               class="form-control mt-2 mb-2" placeholder="Name" disabled>
                                    @else
                                        <input type="hidden" id="name-text" name="user_type" value="Admin"
                                               class="form-control mt-2 mb-2" placeholder="Name" disabled>
                                    @endif
                                    <strong>Members</strong>
                                    <select class="js-example-basic-multiple form-control" name="customized_users[]"
                                        multiple="multiple">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <strong>Categories</strong>
                                    <select class="form-control mt-2 mb-2" name="category">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                    <strong>Business Name</strong>
                                    <div id="business-error" class="error-message"></div>
                                    <input type="text" id="name-text" name="name" value="{{ old('name') }}"
                                           class="form-control mt-2 mb-2 business-text" placeholder="Name">

                                    <strong>State</strong>
                                    <div id="state-error" class="error-message"></div>
                                    <input type="text" name="state" value="{{ old('state') }}"
                                           class="form-control mt-2 mb-2" placeholder="State" id="state-text">

                                    <strong>Rating</strong>
                                    <div id="rating-error" class="error-message"></div>
                                    <input type="number" name="ratings" value="{{ old('ratings') }}" step="0.01" max="5"
                                           class="form-control mt-2 mb-2" placeholder="Rating" id="ratings-text"
                                    />

                                    <strong>Select Image to upload</strong>
                                    <div id="image-error" class="error-message"></div>
                                    <figure>
                                        <img
                                            src="https://t4.ftcdn.net/jpg/04/70/29/97/360_F_470299797_UD0eoVMMSUbHCcNJCdv2t8B2g1GVqYgs.jpg"
                                            id="preview-image" style="height: 120px; width: 200px"
                                            class="img-fluid" alt="Preview Image">
                                        <input type="file" name="image" id="picture-input" class="form-control my-4">
                                    </figure>


                                    <strong>Opening Hours</strong>
                                    <div id="hour-error" class="error-message"></div>
                                    <input type="time" name="opening_hours" value="{{ old('opening_hours') }}"
                                           class="form-control mt-2 mb-2" placeholder="Opening Hours" id="hour-text"
                                    />

                                    <strong>Detail</strong>
                                    <div id="detail-error" class="error-message"></div>
                                    <textarea class="form-control" name="details"
                                              id="myTextarea1" placeholder="Details"></textarea>

                                    <strong>Location</strong>
                                    <div id="location-error" class="error-message"></div>
                                    <input class="form-control mt-2 mb-2" id="search-input" type="text"
                                           placeholder="Enter a location" name="location" value="">
                                    <div id="suggestions"></div>

                                    <strong>Longitude</strong>
                                    <div id="longitude-error" class="error-message"></div>
                                    <input type="text" name="longitude" value=""
                                           class="form-control mt-2 mb-2" placeholder="Longitude" id="longitude-text"
                                           readonly>

                                    <strong>Latitude</strong>
                                    <div id="latitude-error" class="error-message"></div>
                                    <input type="text" name="latitude" value=""
                                           class="form-control mt-2 mb-2" placeholder="Latitude" id="latitude-text"
                                           readonly>
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
<!-- Add Modal end -->

<!-- Edit Modal start -->
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
                                    <!--<strong>Created by</strong>-->
                                    <input type="hidden" id="edit-type" name="user_type" value=""
                                           class="form-control mt-2 mb-2" placeholder="Name" disabled>
                                    <strong>Edit Members</strong>
                                    <select class="js-example-basic-multiple form-control" id="edit-customized-users"
                                            name="customized_users[]" multiple="multiple">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <strong>Edit Categories</strong>
                                    <select class="form-control mt-2 mb-2" id="edit-category" name="category" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
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
                                    <div class="form-group">
                                        <strong>Edit Image:</strong>
                                        <br/>
                                        <img src="{{ asset('images/no-img-avalible.png') }}" width="150px"
                                             id="edit-image"
                                             alt="business"/>
                                        <input type="file" name="image" value="" id="images"
                                               class="form-control mt-2 mb-2"/>
                                        <br/>
                                    </div>
                                    <strong>Edit Opening Hours</strong>
                                    <input type="time" name="opening_hours" value=""
                                           class="form-control mt-2 mb-2" placeholder="Opening Hours" id="edit-hour"
                                           required/>
                                    <strong>Edit Detail</strong>
                                    <textarea class="form-control my-2" name="details"
                                              id="myTextarea2"></textarea>
                                    <strong>Edit Location</strong>
                                    <input type="text" name="location" value="" id="edit-search-input"
                                           class="form-control mt-2 mb-2" placeholder="Location" required>
                                    <div id="edit-suggestions"></div>
                                    <strong>Edit Longitude</strong>
                                    <input type="text" name="longitude" value=""
                                           class="form-control mt-2 mb-2" placeholder="Longitude" id="edit-longitude"
                                           required readonly>
                                    <strong>Edit Latitude</strong>
                                    <input type="text" name="latitude" value=""
                                           class="form-control mt-2 mb-2" placeholder="Latitude" id="edit-latitude"
                                           required readonly>
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
<!-- Edit Modal end -->

@section('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYvOXB3SFyyeR0usVOgnLyoDiAd2XDunU&callback=initMap&libraries=places"
        async defer></script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
            // $(".js-example-basic-multiple").select2({
            //     maximumSelectionLength: 2
            // });

            $('.add-form').submit(function (e) {
                var hasError = false;
                if ($('#myTextarea1').val().trim() === '') {
                    e.preventDefault();
                    hasError = true;
                    $('#detail-error').text("Please provide details.");
                } else {
                    $('#detail-error').text("");
                }

                if ($('.business-text').val().trim() === '') {
                    e.preventDefault();
                    hasError = true;
                    $('#business-error').text("Please provide business name.");
                } else {
                    $('#business-error').text("");
                }

                if ($('#state-text').val().trim() === '') {
                    e.preventDefault();
                    hasError = true;
                    $('#state-error').text("Please provide state.");
                } else {
                    $('#state-error').text("");
                }

                if ($('#ratings-text').val().trim() === '') {
                    e.preventDefault();
                    hasError = true;
                    $('#rating-error').text("Please provide rating.");
                } else {
                    $('#rating-error').text("");
                }

                if ($('#picture-input').val().trim() === '') {
                    e.preventDefault();
                    hasError = true;
                    $('#image-error').text("Please provide image.");
                } else {
                    $('#image-error').text("");
                }

                if ($('#hour-text').val().trim() === '') {
                    e.preventDefault();
                    hasError = true;
                    $('#hour-error').text("Please provide opening hour.");
                } else {
                    $('#hour-error').text("");
                }

                if ($('#search-input').val().trim() === '') {
                    e.preventDefault();
                    hasError = true;
                    $('#location-error').text("Please provide location.");
                } else {
                    $('#location-error').text("");
                }

                if ($('#longitude-text').val().trim() === '') {
                    e.preventDefault();
                    hasError = true;
                    $('#longitude-error').text("Please provide longitude.");
                } else {
                    $('#longitude-error').text("");
                }

                if ($('#latitude-text').val().trim() === '') {
                    e.preventDefault();
                    hasError = true;
                    $('#latitude-error').text("Please provide latitude.");
                } else {
                    $('#latitude-error').text("");
                }

                $(this).find('[required]').each(function () {
                    if (!$(this).val()) {
                        hasError = true;
                    }
                });
            });
        });

        function initMap(isEditing) {

            let searchInput, longitudeInput, latitudeInput, suggestionsContainer, autocompleteService;

            if (isEditing) {
                // Edit Business Modal
                searchInput = document.getElementById('edit-search-input');
                longitudeInput = document.getElementById('edit-longitude');
                latitudeInput = document.getElementById('edit-latitude');
                suggestionsContainer = document.getElementById('edit-suggestions');
                autocompleteService = new google.maps.places.AutocompleteService();
            } else {
                // Add Business Modal
                searchInput = document.getElementById('search-input');
                longitudeInput = document.getElementById('longitude-text');
                latitudeInput = document.getElementById('latitude-text');
                suggestionsContainer = document.getElementById('suggestions');
                autocompleteService = new google.maps.places.AutocompleteService();
            }

            searchInput.addEventListener('input', function () {
                const query = this.value;
                suggestionsContainer.innerHTML = '';

                if (query) {
                    autocompleteService.getPlacePredictions({input: query}, function (predictions, status) {
                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                            predictions.forEach(function (prediction) {
                                const suggestionElement = document.createElement('div');
                                suggestionElement.classList.add('suggestion');
                                suggestionElement.textContent = prediction.description;

                                suggestionElement.addEventListener('click', function () {
                                    searchInput.value = prediction.description;
                                    suggestionsContainer.innerHTML = '';

                                    // Fetch additional details for the selected place
                                    const placeService = new google.maps.places.PlacesService(document.createElement('div'));
                                    placeService.getDetails({placeId: prediction.place_id}, function (place, status) {
                                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                                            const selectedLatitude = place.geometry.location.lat();
                                            const selectedLongitude = place.geometry.location.lng();
                                            latitudeInput.value = selectedLatitude;
                                            longitudeInput.value = selectedLongitude;
                                        }
                                    });
                                });

                                suggestionsContainer.appendChild(suggestionElement);
                            });
                        }
                    });
                }
            });
        }

        initMap(false);
    </script>


    <script>
        ClassicEditor
            .create(document.querySelector('#myTextarea1'))
            .then(myTextarea1 => {
                console.log(myTextarea1);
            })
            .catch(error => {
                console.error(error);
            });

        $('#picture-input').on('change', function (event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function () {
                var dataURL = reader.result;
                $('#preview-image').attr('src', dataURL);
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
    </script>
    <script>
        const isEditing = true;
        $.noConflict()

        $(document).ready(function() {

        });

        $(document).ready(function () {
            var ckeditorInitialized = false;

            $(".edit-modal-btn").on("click", function () {
                var id = $(this).data("id");
                var url = '{{ route('business.edit') }}/' + id;
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        id: id
                    },
                    success: function (data) {
                        console.log('data', data)
                        initMap(true);

                        const selectedUserIds = data.customized_users;
                        const user_detail = data.details;
                        var user_type = data.type;
                        user_type = user_type.replace(/_/g, ' ');
                        user_type = user_type.charAt(0).toUpperCase() + user_type.slice(1);
                        $("#edit-id").val(data.id);
                        $("#edit-type").val(user_type);
                        $("#edit-name").val(data.name ?? 'Koelpin, Hahn and Fay');
                        selectedUserIds.forEach(function(userId) {
                            $("#edit-customized-users option[value='" + userId + "']").prop("selected", true);
                        });
                        $("#edit-customized-users").trigger("change");
                        $("#edit-category").val(data.category_id);
                        $("#edit-state").val(data.state ?? 'Colorado');
                        $("#edit-ratings").val(data.ratings ?? '0');
                        // $("#images").val(data.images);
                        $("#edit-hour").val(data.opening_hours ?? '00:00');
                        $("#edit-search-input").val(data.location ?? '65579 Marley Neck');
                        $("#edit-longitude").val(data.longitude ?? '39.169680');
                        $("#edit-latitude").val(data.latitude ?? '-76.574990');

                        if (!ckeditorInitialized) {
                            ClassicEditor
                                .create(document.querySelector('#myTextarea2'))
                                .then(editor => {
                                    editor.setData(user_detail);
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                            // Set the flag to true to indicate CKEditor is initialized
                            ckeditorInitialized = true;
                        }

                        // Set the image source
                        var imageUrlBase  = '{{ asset('') }}/uploads/business/';
                        if (data.images && data.images.length > 0) {
                            var imageUrl = imageUrlBase + data.images;

                            $("#edit-image").attr("src", imageUrl);
                        } else {
                            var emptyImageUrl = 'https://t4.ftcdn.net/jpg/04/70/29/97/360_F_470299797_UD0eoVMMSUbHCcNJCdv2t8B2g1GVqYgs.jpg';

                            $("#edit-image").attr("src", emptyImageUrl);
                        }

                        $("#edit-modal").modal("show");
                    },
                });
            });

            $(".send-mail").on("click", function () {
                var id = $(this).data("id");
                var url = '{{ route('customized.members.send.mail') }}/' + id;
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        id: id
                    },
                    success: function (data) {
                        console.log('data', data)
                    },
                    error: function (data) {
                        console.log('data', data)
                    },
                });
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
