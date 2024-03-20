@extends('web.layouts.main')
@section('content')
    <section class="login-sign-up-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    @if($user)
                        <form class="needs-validation add-form" novalidate method="POST" enctype="multipart/form-data"
                              action="{{ route('user.add.custom.business', $user->id) }}">
                            @csrf

                            <input type="hidden" name="business_user_id" value="{{ $businessTypeId }}">
                            <input type="hidden" name="business_type" value="{{ $businessType }}">
                            <div class="form-blk">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
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
                                            <input type="number" name="ratings" value="{{ old('ratings') }}" step="0.01"
                                                   max="5"
                                                   class="form-control mt-2 mb-2" placeholder="Rating" id="ratings-text"
                                            />

                                            <strong>Select Image to upload</strong>
                                            <div id="image-error" class="error-message"></div>
                                            <figure>
                                                <img
                                                    src="https://t4.ftcdn.net/jpg/04/70/29/97/360_F_470299797_UD0eoVMMSUbHCcNJCdv2t8B2g1GVqYgs.jpg"
                                                    id="preview-image" style="height: 120px; width: 200px"
                                                    class="img-fluid" alt="Preview Image">
                                                <input type="file" name="image" id="picture-input"
                                                       class="form-control my-4">
                                            </figure>

                                            <strong>Opening Hours</strong>
                                            <div id="hour-error" class="error-message"></div>
                                            <input type="time" name="opening_hours" value="{{ old('opening_hours') }}"
                                                   class="form-control mt-2 mb-2" placeholder="Opening Hours"
                                                   id="hour-text"
                                            />

                                            <strong>Detail</strong>
                                            <div id="detail-error" class="error-message"></div>
                                            <textarea class="form-control" name="details"
                                                      id="myTextarea2" placeholder="Details"></textarea>

                                            <strong>Location</strong>
                                            <div id="location-error" class="error-message"></div>
                                            <input class="form-control mt-2 mb-2" id="search-input" type="text"
                                                   placeholder="Enter a location" name="location" value="">
                                            <div id="suggestions"></div>

                                            <strong>Longitude</strong>
                                            <div id="longitude-error" class="error-message"></div>
                                            <input type="text" name="longitude" value=""
                                                   class="form-control mt-2 mb-2" placeholder="Longitude"
                                                   id="longitude-text"
                                                   readonly>

                                            <strong>Latitude</strong>
                                            <div id="latitude-error" class="error-message"></div>
                                            <input type="text" name="latitude" value=""
                                                   class="form-control mt-2 mb-2" placeholder="Latitude"
                                                   id="latitude-text"
                                                   readonly>

                                            <div class="col-md-12">
                                                <div class="modal-button">
                                                    <button type="submit" class="from-btn">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <form class="needs-validation" novalidate method="POST" action="{{ route('register.custom') }}">
                            @csrf
                            <div class="form-blk">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Register Now</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="text" required name="name" placeholder="Full name"
                                               value="">
                                    </div>
                                    @if ($errors->has('name'))
                                        <div class="text-left">
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <input type="email" name="email" id="email" required=""
                                               placeholder="Email Address"
                                               value="">
                                    </div>
                                    @if ($errors->has('email'))
                                        <div class="text-left">
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <input type="number" id="number" name="number" placeholder="Phone Number"
                                               value="">
                                    </div>
                                    @if ($errors->has('number'))
                                        <div class="text-left">
                                            <span class="text-danger">{{ $errors->first('number') }}</span>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <input type="text" id="home_church_address" name="home_church_address"
                                               placeholder="Home church address"
                                               value="">
                                    </div>
                                    @if ($errors->has('home_church_address'))
                                        <div class="text-left">
                                            <span class="text-danger">{{ $errors->first('home_church_address') }}</span>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <input type="text" id="denomination" name="denomination"
                                               placeholder="Denomination"
                                               value="">
                                    </div>
                                    @if ($errors->has('denomination'))
                                        <div class="text-left">
                                            <span class="text-danger">{{ $errors->first('denomination') }}</span>
                                        </div>
                                    @endif

                                    <div class="col-md-12">
                                        <input type="password" name="password" required="" placeholder="Password"
                                               value="">
                                    </div>
                                    @if ($errors->has('password'))
                                        <div class="text-left">
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <div class="modal-button">
                                            <button type="submit" class="from-btn">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@section('css')
    <style>
        .ck.ck-powered-by {
            display: none;
        }

        .ck-rounded-corners .ck.ck-editor__main > .ck-editor__editable, .ck.ck-editor__main > .ck-editor__editable.ck-rounded-corners {
            border-radius: var(--ck-border-radius);
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            height: 100px;
            min-height: calc(1.5em + 0.75rem + 2px) !important;
        }

        .error-message {
            color: #d13d3d;
            font-weight: 600;
            font-size: 14px;
        }

        section.login-sign-up-sec form input {
            width: 100%;
            margin: 10px 0px;
            background: transparent;
            border-radius: 10px;
            outline: none;
            /* color: #fff; */
            color: #35265E;
            padding: 12px 15px;
            border: 1px solid #9f8553;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
        }

        /*section.login-sign-up-sec form select {*/
        /*    width: 100%;*/
        /*    margin: 10px 0px;*/
        /*    !* padding: 10px 10px; *!*/
        /*    border: 2px solid #35265e;*/
        /*    background: transparent;*/
        /*    border-radius: 10px;*/
        /*    outline: none;*/
        /*    !* color: #fff; *!*/
        /*    color: #35265E;*/
        /*}*/

        section.login-sign-up-sec form select {
            width: 100%;
            margin: 10px 0px;
            padding: 10px 15px;
            border: 1px solid #9f8553;
            background: transparent;
            border-radius: 10px;
            outline: none;
            color: #35265E;
        }

        .form-control:focus {
            color: #212529;
            background-color: #fff;
            border-color: #9f8553;
            outline: 0;
            box-shadow: 0 0 0 0.25rem #9f855352;
        }

        section.login-sign-up-sec form input::placeholder {
            color: #35265e;
            font-size: 14px;
        }

        section.login-sign-up-sec h4 {
            font-size: 36px;
            font-weight: 600;
            font-family: 'Heebo', sans-serif;
            color: #1e1e2d;
            margin-bottom: 30px;
            text-align: center;
        }

        section.login-sign-up-sec button {
            width: 100%;
            padding: 10px 0px;
            margin: 10px 0px;
            border: 1px solid #594b30;
            background-color: #594b30;
            color: #fff;
            border-radius: 10px;
            outline: none;
            display: inline-block;
            font-size: 25px;
            cursor: pointer;
        }

        section.login-sign-up-sec button:hover {
            background-color: transparent;
            color: #594b30;
        }

        section.login-sign-up-sec a {
            color: #35265e;
            font-size: 17px;
            text-align: center;
            padding-top: 10px;
            display: inline-block;
        }

        section.login-sign-up-sec a span {
            text-decoration: underline;
        }

        section.login-sign-up-sec {
            background-color: #fff;
            padding: 200px 0 100px 0;
        }

        .form-blk h4 {
            float: right;
            width: 100%;
        }

        .form-blk a {
            float: right;
            width: 100%;
        }

        .form-blk input,
        .form-blk button {
            float: right;
        }
    </style>
@endsection
@section('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYvOXB3SFyyeR0usVOgnLyoDiAd2XDunU&callback=initMap&libraries=places"
        async defer></script>

    <script>
        $(document).ready(function () {
            $('.add-form').submit(function (e) {
                var hasError = false;
                if ($('#myTextarea2').val().trim() === '') {
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
            .create(document.querySelector('#myTextarea2'))
            .then(myTextarea2 => {
                myTextarea2.ui.view.editable.element.style.height = '100px';
                console.log(myTextarea2);
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
@endsection