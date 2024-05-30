@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>Business Detail</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="categ-sect rest-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="categ-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="review-cont">
                                    <h2 class="sectionHeading">{{ $business['name'] ?? '' }}</h2>
                                    <h3>
                                        <span>
                                            <img
                                                src="{{ asset($business['category']['img'] ?? 'https://static.vecteezy.com/system/resources/thumbnails/004/141/669/small/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg') }}"
                                                alt="category-img" width="20%" class="img-fluid">

                                        {{ $business['category']['name'] ?? 'Car' }}
                                        </span>
                                    </h3>
                                    <h4>
                                        {{ number_format($formatted_average ?? 4.1, 2) }}%
                                        <span>
                                            @php
                                                $full_stars = min(floor($formatted_average), 4);
                                                $half_star = ($formatted_average - $full_stars) >= 0.5;
                                                $empty_stars = max(5 - $full_stars - ($half_star ? 1 : 0), 0);
                                            @endphp

                                            @for ($i = 0; $i < $full_stars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor

                                            @if ($half_star)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif

                                            @for ($i = 0; $i < $empty_stars; $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                        </span>
                                        ({{ $ratingCount ?? '23' }}) Ratings
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>

    <section class="prod-serv-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="prod-heading">Product & Services</h3>
                    <h5>{{ $business['service'] ?? 'Common Law , Law Point' }}</h5>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <figure>
                        <img src="assets/images/ser-1.jpg" class="img-fluid w-100" alt="">
                    </figure>
                </div>
                <div class="col-md-4">
                    <figure>
                        <img src="assets/images/ser-2.jpg" class="img-fluid w-100" alt="">
                    </figure>
                </div>
                <div class="col-md-4">
                    <figure>
                        <img src="assets/images/ser-3.jpg" class="img-fluid w-100" alt="">
                    </figure>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="servForm">
                        <h3 class="prod-heading">Availability</h3>
                        <div class="dropdown">
                            <button class="btn btn-secondary" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h3>{{ $business['days'][0] }}
                                    <span>{{ $business['opening_hours'][0] ?? '' }} - {{ $business['closing_hours'][0] ?? '' }}</span>
                                </h3><i class="far fa-angle-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @foreach($business['days'] as $key => $days)
                                    <a class="dropdown-item" href="javascript:;">
                                        <h3>{{ $days }}
                                            <span
                                                class="text-dark">{{ $business['opening_hours'][$key] ?? '' }} - {{ $business['closing_hours'][$key] ?? '' }} </span>
                                            {{--<input type="checkbox" name="accent-group" style="color: var(--primary)" class="accent accent-color" id="accent-blue" {{ $business['availability'][$key] == '1' ? 'checked' : '' }} />--}}
                                        </h3>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="servForm">
                        <form>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group newGroup">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1" onclick="openFileInput()">
                                                <i class="fas fa-book"></i>
                                            </span>
                                        </div>
                                        <h6 id="uploadedFileName" onclick="openFileInput()">Upload Resume</h6>
                                        <i class="fas fa-times ml-3 remove-attachment-icon" style="display: none;"
                                           onclick="removeDocument()"></i>

                                        {{--<form action="{{ route('front.resume.send', $business['id']) }}"
                                              enctype="multipart/form-data" method="POST">
                                            @csrf

                                            <input type="file" class="form-control" placeholder="Upload Resume"
                                                   data-business-id="{{ $business['id'] }}"
                                                   id="resumeInput" name="attachment" accept="application/pdf">
                                            <button type="submit" class="resume-send" style="display: none;">Send
                                            </button>
                                        </form>--}}
                                        <input type="file" class="form-control" placeholder="Upload Resume"
                                               id="resumeInput" name="attachment" accept="application/pdf">
                                        <button type="button" class="resume-send" style="display: none;"
                                                data-business-id="{{ $business['id'] }}">Send
                                        </button>
                                    </div>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            @if(empty($rating->flag))
                                                <span class="input-group-text unrated-business-{{ $business['id'] }}">
                                                    <i class="fas fa-thumbs-up thumbs-up-place not-rated"
                                                       data-business-id="{{ $business['id'] }}"></i>
                                                </span>
                                            @else
                                                <span class="input-group-text rated-business-{{ $business['id'] }}">
                                                    <i class="fas fa-thumbs-up thumbs-up-place rated"
                                                       data-business-id="{{ $business['id'] }}"></i>
                                                </span>
                                            @endif
                                        </div>
                                        <h6 class="rate-thumb">Rate This Place</h6>
                                        <!--<input class="form-control fa-border-none" placeholder="Rate This Place">-->
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="serv-content">
                        <h3 class="prod-heading">Description</h3>
                        <textarea id="businessDetails"
                                  value="{{ $business['details'] ?? "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                            galley of type and scrambled it to make a type specimen book. It has survived not only five
                            centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                            passages, and more recently with desktop publishing software like Aldus PageMaker including
                            versions of Lorem Ipsum" }}"
                                  placeholder="Business Description (Optional)" rows="3" class="form-control mb-3"
                                  aria-hidden="true">
                            {{ $business['details'] ?? "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                            galley of type and scrambled it to make a type specimen book. It has survived not only five
                            centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                            passages, and more recently with desktop publishing software like Aldus PageMaker including
                            versions of Lorem Ipsum" }}
                        </textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="serv-list">
                        <h3 class="prod-heading">Location</h3>
                        <ul id="location-list">
                            @foreach($business['location'] ?? [] as $key => $location)
                                <li>
                                    <a href="javascript:;" class="location-link"
                                       data-latitude="{{ $business['latitude'][$key] ?? '' }}"
                                       data-longitude="{{ $business['longitude'][$key] ?? '' }}"
                                       data-location="{{ $location }}">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $location }}
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <a href="javascript:;" class="themeBtn text-white"
                                   id="highlight-location-btn">Direction</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="map" style="height: 400px; position: relative;">
                <div id="spinner" class="spinner-border" role="status"
                     style="position: absolute; top: 50%; left: 50%; display: none;">
                    <span class="visually-hidden"></span>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script>
        tinymce.init({
            selector: '#businessDetails',
            readonly: true
        });
    </script>

    {{-- Google Map Directions --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYvOXB3SFyyeR0usVOgnLyoDiAd2XDunU"></script>
    <script>
        var selectedLocation = null;

        $(document).ready(function () {
            $('.location-link').click(function () {
                $('.location-link').removeClass('selected-location');
                $(this).addClass('selected-location');

                var latitude = $(this).data('latitude');
                var longitude = $(this).data('longitude');
                var locationName = $(this).data('location');

                selectedLocation = {
                    latitude: latitude,
                    longitude: longitude,
                    locationName: locationName
                };
            });

            $('#highlight-location-btn').click(function () {
                if (selectedLocation) {
                    $('.spinner-border').show();
                    highlightLocation(selectedLocation);
                } else {
                    toastr.error('Please select a location first.');
                }
            });
        });

        function highlightLocation(location) {
            // Show spinner
            $('.spinner-border').show();

            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: location.latitude, lng: location.longitude},
                zoom: 15

                // center: {lat: 37.0902, lng: -95.7129}, // Center of the United States
            });

            var marker = new google.maps.Marker({
                position: {lat: location.latitude, lng: location.longitude},
                map: map,
                title: location.locationName

                // position: {lat: 37.0902, lng: -95.7129}, // Center of the United States
            });

            // Hide spinner when map is fully loaded
            google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
                $('.spinner-border').hide();
            });
        }

    </script>
    {{-- Google Map Directions --}}

    {{-- Rate This Place --}}
    <script>
        $(document).ready(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $(document).on('click', '.thumbs-up-place', function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                var business_id = $(this).data('business-id');
                var url = '{{ route('front.rating.business') }}' + '/' + business_id;

                $.ajax({
                    url: url,
                    type: 'POST',
                    success: function (response) {
                        if (response.success) {
                            if (response.flag === 1) {
                                toastr.success(response.message);

                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else {
                                toastr.success(response.message);

                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            }
                        }
                    },
                    error: function (xhr, error) {
                        console.log('error', error)
                        toastr.error('An error occurred.');
                    }
                });
            });
        });
    </script>
    {{-- Rate This Place --}}

    {{-- Resume Work --}}
    <script>
        function openFileInput() {
            $('#resumeInput').click();
        }

        $('#resumeInput').change(function () {
            var fileName = $(this).val().split('\\').pop();
            console.log($('input[name="attachment"]').val())
            $('#uploadedFileName').text(fileName);
            $('.remove-attachment-icon').show();
            $('.resume-send').show();
        });

        function removeDocument() {
            $('#resumeInput').val('');
            $('#uploadedFileName').text('Upload Resume');
            $('.remove-attachment-icon').hide();
            $('.resume-send').hide();
        }

        $(document).ready(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $(document).on('click', '.resume-send', function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                var business_id = $(this).data('business-id');
                var url = '{{ route('front.resume.send') }}' + '/' + business_id;
                var attachment = $('#resumeInput')[0].files[0];

                var formData = new FormData();
                formData.append('attachment', attachment);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function (xhr, error) {
                        console.log('error', error)
                        toastr.error('An error occurred.');
                    }
                });
            });
        });
    </script>
    {{-- Resume Work --}}
@endsection
