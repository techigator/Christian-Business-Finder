@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>Manage Business</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="signup-sect manage-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="categ-content">
                        <div class="premium-crown col-md-12 align-items-center">
                            <a class="subscription-btn" href="" data-toggle="modal"
                               data-target="#add-subscription-modal">
                                <img src="{{ asset('assets-cbf-front/images/crown.png') }}" alt="" width="4%"
                                     class="mr-4"> Buy Premium Subscription
                            </a>
                        </div>

                        <div class="row">
                            <div class="col-lg-5 col-md-5">
                                <div class="check-form">
                                    <figure style="background: #cfbda5; border-radius: 20px;">
                                        <input type="file" name="thumbnailFile" id="thumbnailFile"
                                               data-business-id="{{ $business->id }}"
                                               class="form-control my-4" accept="image/*" style="display: none;"/>
                                        <i class="fas fa-camera camera-icon" onclick="uploadThumbnail()"></i>
                                        <img
                                            src="{{ asset('uploads/business/' . $business->thumbnail) ?? 'https://media.istockphoto.com/id/1147544806/vector/no-thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=Ni8CpW8dNAV0NrS6Odo5csGcWUySFydNki9FYi1XHYo=' }}"
                                            class="img-fluid"
                                            style="padding: 2rem;border-radius: 3rem;"
                                            id="thumbnailPreview"
                                            alt="business-thumbnail"/>
                                    </figure>
                                    <div class="slider slider-for mt-5">
                                        @foreach($business->images as $image)
                                            <div>
                                                <figure>
                                                    <img src="{{ asset('uploads/business/' . $image) }}"
                                                         class="img-fluid" alt="">
                                                </figure>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="slider slider-nav"></div>
                                </div>
                            </div>

                            <div class="col-lg-7 col-md-7">
                                <div class="check-form">

                                    <form action="{{ route('front.update.manage.business', $business->id ?? '') }}"
                                          method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md">
                                                <input type="text" class="form-control" name="name"
                                                       value="{{ $business['name'] ?? '' }}"
                                                       placeholder="Business Name">
                                            </div>
                                            <div class="col-md">
                                                <input type="text" class="form-control" name="service"
                                                       value="{{ $business['service'] ?? '' }}"
                                                       placeholder="Enable Proactive Flexibility">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md">
                                                <input type="tel" class="form-control phoneNumber" name="phone_number"
                                                       placeholder="Business Phone Number"
                                                       value="{{ $business['phone_number'] ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md">
                                                <textarea class="form-control mb-3" name="details"
                                                          value="{{ $business['details'] ?? '' }}"
                                                          id="textareaForeground"
                                                          placeholder="Total Foreground Flexibility"
                                                          rows="3">{{ $business['details'] ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        @php
                                            if ($business->business_timing->isEmpty()) {
                                                $businessTiming = App\Models\BuisnessTiming::where('buisness_id', 0)->get();
                                                $days = explode(',', $businessTiming[0]['day']);
                                                $opening_hours = explode(',', $businessTiming[0]['opening_hours']);
                                                $closing_hours = explode(',', $businessTiming[0]['closing_hours']);
                                                $availability = explode(',', $businessTiming[0]['availability']);
                                            } else {
                                                $days = explode(',', $business->business_timing[0]['day']);
                                                $opening_hours = explode(',', $business->business_timing[0]['opening_hours']);
                                                $closing_hours = explode(',', $business->business_timing[0]['closing_hours']);
                                                $availability = explode(',', $business->business_timing[0]['availability']);
                                            }
                                        @endphp
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <div class="servManageForm">
                                                        <div class="dropdown">
                                                            <button class="btn btn-" type="button"
                                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                <span class="text-secondary">Availability</span><i
                                                                    class="far fa-angle-down text-secondary"></i>
                                                            </button>
                                                            <div class="dropdown-menu"
                                                                 aria-labelledby="dropdownMenuButton"
                                                                 style="height: 200px !important; overflow: auto !important;">
                                                                @foreach($days as $key => $day)
                                                                    <a class="dropdown-item">
                                                                        <input class="form-check-input input-day"
                                                                               type="hidden" value="{{ $day ?? '' }}"
                                                                               name="days[]">
                                                                        <h3>{{ $day ?? '' }} <span>
                                                                            <input type="time"
                                                                                   name="opening_hours[]"
                                                                                   value="{{ $opening_hours[$key] ?? '' }}"
                                                                                   class="opening-hour"/> -
                                                                            <input
                                                                                type="time" name="closing_hours[]"
                                                                                value="{{ $closing_hours[$key] ?? '' }}"
                                                                                class="closing-hour"/>
                                                                            </span>
                                                                            <input type="checkbox"
                                                                                   name="availability[{{ $day ?? '' }}]"
                                                                                   value="1"
                                                                                   class="accent accent-color"
                                                                                   id="accent-blue" {{ $availability[$key] ?? '0' == '1' ? 'checked' : '' }} />
                                                                        </h3>
                                                                    </a>
                                                                    <hr>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @foreach($business->location as $key => $location)
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control search-input"
                                                           name="location[]"
                                                           value="{{ $location ?? '' }}"
                                                           placeholder="Locations">
                                                    <div id="suggestions" style="display: none;"></div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="latitude[]"
                                                           value="{{ $business->latitude[$key] ?? '' }}"
                                                           id="latitude-text-{{ $key ?? '' }}"
                                                           placeholder="Latitude" readonly>
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="longitude[]"
                                                           value="{{ $business->longitude[$key] ?? '' }}"
                                                           id="longitude-text-{{ $key ?? '' }}"
                                                           placeholder="Longitude" readonly>
                                                </div>
                                                @if($key == 1)
                                                    <div class="remove-location">
                                                        <i class="fas fa-times location-icon"
                                                           onclick="removeLocation(this)"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                        @if(Auth::check() && Auth::user()->type === 'paid_member')
                                            <div class="multi-locations" style="display: none;"></div>
                                            <div class="add-location-icon">
                                                <i class="fas fa-plus location-icon"></i>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <select class="form-control" name="category_id"
                                                            value="{{ $business->category['name'] ?? '' }}"
                                                            id="exampleFormControlSelect1">
                                                        @foreach($categories as $category)
                                                            <option
                                                                value="{{ $category->id ?? '' }}" {{ ($business->category['name'] ?? '') == $category->name ?? '' ? 'selected' : '' }}>{{ $category->name ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        @foreach($business['web_link'] as $key => $web_link)
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="url" class="form-control" name="web_link[]"
                                                           value="{{ $web_link ?? '' }}"
                                                           placeholder="Web Link">
                                                </div>
                                                @if($key == 1)
                                                    <div class="remove-link">
                                                        <i class="fas fa-times link-icon"
                                                           onclick="removeLink(this)"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                        @if(Auth::check() && Auth::user()->type === 'paid_member')
                                            <div class="multi-links" style="display: none;"></div>
                                            <div class="add-link-icon">
                                                <i class="fas fa-plus link-icon"></i>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <select class="form-control" name="view_as"
                                                            id="exampleFormControlSelect1">
                                                        @foreach($business['view_as'] as $view_as)
                                                            <option
                                                                value="{{ $view_as ?? '' }}" {{ ($view_as ?? '') == 'Business Who Identifies As Christian' ? 'selected' : '' }}>
                                                                Business Who Identifies As Christian
                                                            </option>
                                                            <option
                                                                value="{{ $view_as ?? '' }}" {{ ($view_as ?? '') == 'Business Who Identifies As Non Christian' ? 'selected' : '' }}>
                                                                Business Who Identifies As Non Christian
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md">
                                                <button type="submit" class="update-manage">Update</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Buy Subscription --}}
    <div class="modal fade" id="add-subscription-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLongTitle"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #1e1e2d; color: #fff;">
                    <h5 class="modal-title" id="exampleModalLongTitle">Buy & Update Subscription</h5>
                    <button type="button" class="close" style="color: #fff;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #000000b5; color: white;">
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
                                $("#add-modal").modal("show");
                            </script>
                        @endif
                        <form class="subscription-form">
                            <input type="hidden" name="user_id" value="{{ $businessUser['id'] }}">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div class="row my-4">
                                            <div class="col-md-6">
                                                <strong>Subscription Amount</strong>
                                                <input type="text" class="form-control" name="amount"
                                                       value="{{ $subscriptionAmount }}" readonly>
                                            </div>
                                        </div>

                                        <div class="row my-4">
                                            <div class="col-md">
                                                <strong>Coupon Code</strong>
                                                <input type="text" class="form-control" id="coupon-code"
                                                       name="coupon_code"
                                                       placeholder="Apply Coupon">
                                            </div>

                                            <div class="col-md">
                                                <a href="javascript:;" class="btn" id="apply-coupon"
                                                   style="background: #1e1e2d; color: #fff; margin-top: 1.4rem;">Apply</a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Referral Code</strong>
                                                <input type="text" class="form-control" name="referral_code"
                                                       placeholder="Referral Code (Optional)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn" style="background: #1e1e2d; color: #fff;">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Buy Subscription --}}
@endsection
@section('js')

    <script>
        // Location Work
        $(document).ready(function () {
            function initLocationMap() {
                document.querySelectorAll('.search-input').forEach(function (searchInput, index) {

                    let latitudeInput = document.getElementById('latitude-text-' + index);
                    let longitudeInput = document.getElementById('longitude-text-' + index);

                    let suggestionsContainer = searchInput.nextElementSibling;
                    let autocompleteService = new google.maps.places.AutocompleteService();

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
                                            suggestionsContainer.style.display = 'none';

                                            // Fetch additional details for the selected place
                                            const placeService = new google.maps.places.PlacesService(document.createElement('div'));
                                            placeService.getDetails({placeId: prediction.place_id}, function (place, status) {
                                                if (status === google.maps.places.PlacesServiceStatus.OK) {
                                                    // Find latitude and longitude inputs relative to the search input
                                                    const selectedLatitude = place.geometry.location.lat();
                                                    const selectedLongitude = place.geometry.location.lng();

                                                    latitudeInput.value = selectedLatitude;
                                                    longitudeInput.value = selectedLongitude;

                                                }
                                            });
                                        });

                                        suggestionsContainer.appendChild(suggestionElement);
                                    });

                                    suggestionsContainer.style.display = 'block';
                                } else {
                                    suggestionsContainer.style.display = 'none';
                                }
                            });
                        } else {
                            suggestionsContainer.style.display = 'none';
                        }
                    });
                });
            }

            initLocationMap(true);
        });
    </script>
    <script>
        tinymce.init({
            selector: '#textareaForeground',
            readonly: false
        });

        function removeLocation(icon) {
            $(icon).parent().parent().hide();
        }

        function removeLink(icon) {
            $(icon).parent().hide();
        }

        function subscription() {
            $('.add-location-icon').show();
            $('.add-link-icon').show();
        }

        function convertTo24HourFormat(time) {
            let [hour, minute, meridiem] = time.split(/\s|:/); // Split the time string by space or colon
            hour = parseInt(hour, 10); // Convert hour to integer
            if (meridiem === "PM" && hour !== 12) { // If PM and not noon (12 PM)
                hour += 12; // Add 12 hours to convert to 24-hour format
            } else if (meridiem === "AM" && hour === 12) { // If AM and noon (12 AM)
                hour = 0; // Set hour to 0 to represent midnight
            }
            // Convert back to string and pad with zeros if necessary
            return hour.toString().padStart(2, "0") + ":" + minute.padStart(2, "0");
        }

        $(document).ready(function () {
            const openingHourInputs = document.querySelectorAll('.opening-hour');
            const closingHourInputs = document.querySelectorAll('.closing-hour');

            openingHourInputs.forEach(function (input, index) {
                const openingHours12 = input.getAttribute('value');
                input.value = convertTo24HourFormat(openingHours12);
            });

            closingHourInputs.forEach(function (input, index) {
                const closingHours12 = input.getAttribute('value');
                input.value = convertTo24HourFormat(closingHours12);
            });
        });

        function removeMultiLocation(icon) {
            $(icon).closest('.row').next('.row').hide();
            $(icon).closest('.row').prev('.row').hide();
            $(icon).closest('.row').hide();
        }

        function removeMultiLink(icon) {
            $(icon).parent().hide();
        }

        $(document).ready(function () {
            var checkSubscription = '{{ $checkSubscription }}';

            if (checkSubscription) {
                // Location Work
                function initMultiMap(isFirstLoad, counter) {
                    let searchMultiInput, longitudeMultiInput, latitudeMultiInput, suggestionsMultiContainer,
                        autocompleteMultiService;

                    // Add Multiple Business Location
                    searchMultiInput = document.getElementById(`multi-search-input-${counter}`);
                    longitudeMultiInput = document.getElementById(`multi-longitude-text-${counter}`);
                    latitudeMultiInput = document.getElementById(`multi-latitude-text-${counter}`);
                    suggestionsMultiContainer = document.getElementById(`multi-suggestions-${counter}`);

                    // Check if all necessary elements are found
                    if (!searchMultiInput || !longitudeMultiInput || !latitudeMultiInput || !suggestionsMultiContainer) {
                        // console.error('One or more elements not found for counter:', counter);
                        return;
                    }

                    autocompleteMultiService = new google.maps.places.AutocompleteService();

                    searchMultiInput.addEventListener('input', function () {
                        const query = this.value;
                        suggestionsMultiContainer.innerHTML = '';

                        if (query) {
                            autocompleteMultiService.getPlacePredictions({input: query}, function (predictions, status) {
                                if (status === google.maps.places.PlacesServiceStatus.OK) {
                                    predictions.forEach(function (prediction) {
                                        const suggestionElement = document.createElement('div');
                                        suggestionElement.classList.add('multi-suggestion');
                                        suggestionElement.textContent = prediction.description;

                                        suggestionElement.addEventListener('click', function () {
                                            searchMultiInput.value = prediction.description;
                                            suggestionsMultiContainer.innerHTML = '';

                                            // Fetch additional details for the selected place
                                            const placeService = new google.maps.places.PlacesService(document.createElement('div'));
                                            placeService.getDetails({placeId: prediction.place_id}, function (place, status) {
                                                if (status === google.maps.places.PlacesServiceStatus.OK) {
                                                    const selectedMultiLatitude = place.geometry.location.lat();
                                                    const selectedMultiLongitude = place.geometry.location.lng();
                                                    latitudeMultiInput.value = selectedMultiLatitude;
                                                    longitudeMultiInput.value = selectedMultiLongitude;

                                                    // Hide suggestions container when latitude or longitude is selected
                                                    suggestionsMultiContainer.style.display = 'none';
                                                }
                                            });
                                        });

                                        suggestionsMultiContainer.appendChild(suggestionElement);
                                    });

                                    suggestionsMultiContainer.style.display = 'block';
                                } else {
                                    suggestionsMultiContainer.style.display = 'none';
                                }
                            });
                        } else {
                            suggestionsMultiContainer.style.display = 'none';
                        }
                    });

                    // Event listener for latitude and longitude input fields
                    latitudeMultiInput.addEventListener('input', function () {
                        suggestionsMultiContainer.style.display = 'none';
                    });

                    longitudeMultiInput.addEventListener('input', function () {
                        suggestionsMultiContainer.style.display = 'none';
                    });
                }

                let counter = 0;

                // Initialize map for the first location
                initMultiMap(true, counter);

                $(document).on('click', '.add-location-icon', function () {
                    let multi_locations = $('.multi-locations');
                    multi_locations.show();
                    counter++;

                    let locationElement = $(`
                    <div class="row">
                        <div class="col-md">
                            <input type="text" class="form-control" id="multi-search-input-${counter}" name="location[]" value="" placeholder="Locations">
                            <div id="multi-suggestions-${counter}" class="multi-suggestions" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <input type="text" class="form-control" name="latitude[]" value="" id="multi-latitude-text-${counter}" placeholder="Latitude" readonly>
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control" name="latitude[]" value="" id="multi-longitude-text-${counter}" placeholder="Latitude" readonly>
                        </div>
                        <i class="fas fa-times remove-location-icon" onclick="removeMultiLocation(this)"></i>
                    </div>
                `);

                    multi_locations.append(locationElement);

                    // Initialize map for the newly added location
                    $('.add-location-icon').show();
                    initMultiMap(false, counter);
                });

                $(document).on('click', '.add-link-icon', function () {
                    let multi_links = $('.multi-links');
                    multi_links.show();

                    let locationElement = $(`
                    <div class="row">
                        <div class="col-md">
                            <input type="url" class="form-control" name="web_link[]" value="" placeholder="Web Link Url">
                        </div>
                        <i class="fas fa-times remove-location-icon" onclick="removeMultiLink(this)"></i>
                    </div>
                `);

                    multi_links.append(locationElement);
                    $('.add-link-icon').show();
                });
            } else {
                toastr.error('Subscription renewal first.');
            }
        });
    </script>
    <script>
        function uploadThumbnail() {
            var fileInput = document.getElementById('thumbnailFile');
            fileInput.click();
        }

        document.getElementById('thumbnailFile').addEventListener('change', function (e) {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            var file = e.target.files[0];
            let thumbnailPreview = document.getElementById('thumbnailPreview');

            if (file) {
                var reader = new FileReader();
                reader.onload = function () {
                    thumbnailPreview.src = reader.result;
                };
                reader.readAsDataURL(file);
            }

            var business_id = $(this).data('business-id');
            var url = '{{ route('front.update.manage.business.thumbnail') }}' + '/' + business_id;

            var formData = new FormData();
            formData.append('thumbnail', file);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success === true) {
                        toastr.success(response.message);
                    } else {
                        thumbnailPreview.src = 'https://media.istockphoto.com/id/1147544806/vector/no-thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=Ni8CpW8dNAV0NrS6Odo5csGcWUySFydNki9FYi1XHYo=';
                        toastr.error('Subscription renewal first.');
                    }
                },
                error: function (xhr, error) {
                    console.log('error', error)
                    toastr.error('An error occurred.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            $(document).on('submit', '.subscription-form', function (e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('subscription') }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success === true) {
                            toastr.success(response.message);
                            window.location.href = response.redirect_url;
                        }
                    },
                    error: function (error) {
                        // Handle error
                        console.log(error);
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            });

            $(document).on('click', '#apply-coupon', function () {

                let coupon_code = $('#coupon-code').val();

                $.ajax({
                    url: '{{ route('apply.coupon.web') }}',
                    method: 'POST',
                    data: {
                        coupon_code: coupon_code,
                    },
                    success: function (response) {
                        if (response.success === true) {
                            toastr.success(response.message);

                            $('input[name="amount"]').val(response.data.total);
                            $('#coupon-code').prop('readonly', true);
                            $('#apply-coupon').addClass('disabled').
                            css({
                                'background': '#fff',
                                'color': '#1e1e2d',
                                'border': '2px solid #1e1e2d',
                                'font-weight': '700',
                            });
                        } else {
                            toastr.error('Error applying coupon');
                        }
                    },
                    error: function (xhr, error) {
                        console.error('Error applying coupon:', error);
                        toastr.error(error);
                    },
                });
            });
        });
    </script>
@endsection
