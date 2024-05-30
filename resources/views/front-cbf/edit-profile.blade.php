@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>Edit Profile</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="profile-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="categ-content">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="check-form">
                                    <figure style="background: #cfbda5; border-radius: 20px; height: auto;">
                                        <input type="file" name="profileFile" id="profileFile" data-user-id="{{ $user->id }}"
                                               class="form-control my-4" accept="image/*" style="display: none;"/>
                                        <i class="fas fa-camera camera-icon" onclick="uploadProfile()"></i>
                                        <img
                                            src="{{ asset('uploads/user/' . $user->profile_image) ?? 'https://media.istockphoto.com/id/1147544806/vector/no-thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=Ni8CpW8dNAV0NrS6Odo5csGcWUySFydNki9FYi1XHYo=' }}"
                                            class="img-fluid"
                                            style="width: 100%!important; border-radius: inherit; padding: 1rem;"
                                            id="profilePreview"
                                            alt="user-profile"/>
                                    </figure>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="check-form">
                                    <h2 class="sectionHeading">Profile</h2>
                                    <form action="{{ route('front.update.profile', $user->id ?? '') }}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md">
                                                <input type="text" name="name" value="{{ $user->name ?? '' }}"
                                                       class="form-control" placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="input-group">
                                                    <input type="email" name="" value="{{ $user->email ?? '' }}"
                                                           class="form-control"
                                                           placeholder="Forexample@gmail.com" readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2"><i
                                                                class="fal fa-envelope"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <select name="gender" value="{{ $user->gender ?? '' }}"
                                                            class="form-control" id="exampleFormControlSelect1">
                                                        <option
                                                            value="Male" {{ ($user->gender ?? '') == 'Male' ? 'selected' : '' }}>
                                                            Male
                                                        </option>
                                                        <option
                                                            value="Female" {{ ($user->gender ?? '') == 'Female' ? 'selected' : '' }}>
                                                            Female
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <input type="date" name="date_of_birth"
                                                       value="{{ $user->date_of_birth ?? '' }}" class="form-control"
                                                       placeholder="Enter Your Email">
                                            </div>
                                            <div class="col-md">
                                                <input type="tel" class="form-control phoneNumber" name="number"
                                                       placeholder="Phone Number" value="{{ $user->number ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <input type="text" name="denomination"
                                                       value="{{ $user->denomination ?? '' }}" class="form-control"
                                                       placeholder="Denomination">
                                            </div>
                                            <div class="col-md">
                                                <input type="text" name="home_church_name"
                                                       value="{{ $user->home_church_name ?? '' }}" class="form-control"
                                                       placeholder="Home Church Name">
                                            </div>
                                            <div class="col-md">
                                                <input type="text" name="home_church_address"
                                                       value="{{ $user->home_church_address ?? '' }}"
                                                       class="form-control" placeholder="Home Church Address">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <input type="text" name="city" value="{{ $user->city ?? '' }}"
                                                       class="form-control" placeholder="City">
                                            </div>
                                            <div class="col-md">
                                                <input type="text" name="state" value="{{ $user->state ?? '' }}"
                                                       class="form-control" placeholder="State">
                                            </div>
                                            <div class="col-md">
                                                <input type="text" name="country" value="{{ $user->country ?? '' }}"
                                                       class="form-control" placeholder="Country">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="formBtn">
                                                    <button type="submit" class="themeBtn">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <div class="row text-center mt-5">
                            <div class="col-md-12">
                                @if(empty($ownBusiness->id))
                                    <a href="javascript:;" style="color: var(--primary);">You Don't Have Any
                                        Business</a>
                                @else
                                    <a href="{{ route('front.manage.business', $ownBusiness->id ?? '') }}"
                                       class="manage-business">Manage Business</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection
@section('js')
    <script>
        function uploadProfile() {
            var fileInput = document.getElementById('profileFile');
            fileInput.click();
        }

        document.getElementById('profileFile').addEventListener('change', function(e) {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            var file = e.target.files[0];
            let profilePreview = document.getElementById('profilePreview');

            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    profilePreview.src = reader.result;
                };
                reader.readAsDataURL(file);
            }

            var user_id = $(this).data('user-id');
            var url = '{{ route('front.update.profile.image') }}' + '/' + user_id;

            var formData = new FormData();
            formData.append('profile', file);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                    }
                },
                error: function (xhr, error) {
                    console.log('error', error)
                    toastr.error('An error occurred.');
                }
            });
        });
    </script>
@endsection
