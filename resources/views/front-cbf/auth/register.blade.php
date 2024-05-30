@extends('front-cbf.layout.app')
@section('content')

    <section class="toppanel-sect">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="top-head">
                        <h2><span><a href="javascript:;"></a></span>Sign Up</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="signup-sects">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="categ-content">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="check-form">
                                    <h2 class="sectionHeading">Select Your Account Type</h2>

                                    <div class="signup-dropdown">
                                        <input type="radio" id="church" name="account" value="church" checked>
                                        <label for="church"><strong>Church</strong></label>
                                        <div class="signup-caret"></div>
                                        <div class="content">
                                            <p>
                                                Sign up here to be able to search for businesses by your preferences.
                                                You can search by your local Christian church, denomination,
                                                location, by name or all local businesses.
                                            </p>
                                            <a href="#church" class="consumer signup-link">Sign-up</a>
                                        </div>
                                    </div>

                                    <div class="signup-dropdown">
                                        <input type="radio" id="consumer" name="account" value="consumer">
                                        <label for="consumer"><strong>Consumer</strong></label>
                                        <div class="signup-caret"></div>
                                        <div class="content">
                                            <p>
                                                Sign up here to be able to search for businesses by your preferences.
                                                You can search by your local Christian church, denomination,
                                                location, by name or all local businesses.
                                            </p>
                                            <a href="#consumer" class="consumer signup-link">Sign-up</a>
                                        </div>
                                    </div>

                                    <div class="signup-dropdown">
                                        <input type="radio" id="free-membership" name="account"
                                               value="free-membership">
                                        <label for="free-membership">
                                            <strong>
                                                Business/Professional - Currently Free Membership
                                            </strong>
                                        </label>
                                        <div class="signup-caret"></div>
                                        <div class="content">
                                            <p>
                                                Sign up here if you are a business, sales or service professional
                                                looking to get your name out there. You can click here to (be listed
                                                in your category of business at one zip code. This is upgradable to
                                                Business Elite at any time. You can list with your local Christian
                                                church, denomination or as a local business to help our members
                                                quickly find you.
                                            </p>
                                            <a href="#business" class="free-membership signup-link">Sign-up</a>
                                        </div>
                                    </div>

                                    <div class="signup-dropdown">
                                        <input type="radio" id="paid-membership" name="account"
                                               value="paid-membership">
                                        <label for="paid-membership">
                                            <strong>
                                                Business/Professional - Paid for Membership (Business Elite)
                                            </strong>
                                        </label>
                                        <div class="signup-caret"></div>
                                        <div class="content">
                                            <p>
                                                Click here if you are a business, sales or service professional
                                                looking to not only get your name out there in more then one
                                                location but also be able to interact with the community of
                                                consumers (coupons, emails, and resumes when your business is
                                                looking to expand, including listing your website). Sign up
                                                today!
                                            </p>
                                            <a href="#paid-member" class="paid-member signup-link">Sign-up</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Forms --}}
    <div id="app">
        {{-- Church Form --}}
        <section class="signup-sect d-none" id="church-form">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="categ-content">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="check-form">
                                        <h2 class="sectionHeading">Sign Up (Church)</h2>
                                        <form action="{{ route('front.signup.submit') }}" method="POST" id="church"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="type" value="church">
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="name"
                                                           placeholder="Representative Name">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="email" class="form-control" name="email"
                                                           placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="tel" class="form-control phoneNumber" name="number"
                                                           placeholder="Phone">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input
                                                        id="church-password"
                                                        :type="showChurchPassword ? 'text' : 'password'"
                                                        class="form-control"
                                                        name="password"
                                                        required
                                                        autocomplete="password"
                                                        placeholder="Password"
                                                    />
                                                    <button
                                                        type="button"
                                                        class="church-password"
                                                        @click="togglePasswordVisibility('churchPassword')"
                                                    >
                                                        <i aria-hidden="true" class="fa fa-eye"
                                                           v-if="showChurchPassword"></i>
                                                        <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                    </button>
                                                </div>
                                                <div class="col-md">
                                                    <input
                                                        id="church-password-confirm"
                                                        :type="showChurchConfirmPassword ? 'text' : 'password'"
                                                        class="form-control"
                                                        name="password_confirmation"
                                                        required
                                                        autocomplete="password"
                                                        placeholder="Confirm Password"
                                                    />
                                                    <button
                                                        type="button"
                                                        class="consumer-password"
                                                        @click="togglePasswordVisibility('churchConfirmPassword')"
                                                    >
                                                        <i aria-hidden="true" class="fa fa-eye"
                                                           v-if="showChurchConfirmPassword"></i>
                                                        <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="country"
                                                           placeholder="Country">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="state"
                                                           placeholder="State">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="city"
                                                           placeholder="City">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="home_church_name"
                                                           placeholder="Home Church Name">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="home_church_address"
                                                           placeholder="Home Church Address">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="denomination"
                                                           placeholder="Denomination">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="referral_code"
                                                           placeholder="Referral Code (Optional)">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>Do You Have Account?
                                                        <a href="{{ route('front.login') }}" class="text-dark">
                                                            <strong>Login</strong>
                                                        </a>
                                                    </p>
                                                    <div class="formBtn">
                                                        <button type="submit" class="themeBtn">Sign Up</button>
                                                    </div>
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
        {{-- Church Form --}}

        {{-- Consumer Form --}}
        <section class="signup-sect d-none" id="consumer-form">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="categ-content">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="check-form">
                                        <h2 class="sectionHeading">Sign Up (Consumer)</h2>
                                        <form action="{{ route('front.signup.submit') }}" method="POST" id="consumer"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="type" value="consumer">
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="name"
                                                           placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="email" class="form-control" name="email"
                                                           placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="tel" class="form-control phoneNumber" name="number"
                                                           placeholder="Phone">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input
                                                        id="password"
                                                        :type="showConsumerPassword ? 'text' : 'password'"
                                                        class="form-control"
                                                        name="password"
                                                        required
                                                        autocomplete="password"
                                                        placeholder="Password"
                                                    />
                                                    <button
                                                        type="button"
                                                        class="consumer-password"
                                                        @click="togglePasswordVisibility('consumerPassword')"
                                                    >
                                                        <i aria-hidden="true" class="fa fa-eye"
                                                           v-if="showConsumerPassword"></i>
                                                        <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                    </button>
                                                </div>
                                                <div class="col-md">
                                                    <input
                                                        id="password-confirm"
                                                        :type="showConsumerConfirmPassword ? 'text' : 'password'"
                                                        class="form-control"
                                                        name="password_confirmation"
                                                        required
                                                        autocomplete="password"
                                                        placeholder="Confirm Password"
                                                    />
                                                    <button
                                                        type="button"
                                                        class="consumer-password"
                                                        @click="togglePasswordVisibility('consumerConfirmPassword')"
                                                    >
                                                        <i aria-hidden="true" class="fa fa-eye"
                                                           v-if="showConsumerConfirmPassword"></i>
                                                        <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="country"
                                                           placeholder="Country">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="state"
                                                           placeholder="State">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="city"
                                                           placeholder="City">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="home_church_name"
                                                           placeholder="Home Church Name (Optional)">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="home_church_address"
                                                           placeholder="Home Church Address (Optional)">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <select class="form-control" name="view_as"
                                                            id="exampleFormControlSelect1">
                                                        <option readonly>
                                                            I want to view businesses as
                                                        </option>
                                                        <option
                                                            value="Business Who Identifies As Christian">
                                                            Business Who Identifies As Christian
                                                        </option>
                                                        <option
                                                            value="Business Who Identifies As Non Christian">
                                                            Business Who Identifies As Non Christian
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="denomination"
                                                           placeholder="Denomination">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="referral_code"
                                                           placeholder="Referral Code (Optional)">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>Do You Have Account?
                                                        <a href="{{ route('front.login') }}" class="text-dark">
                                                            <strong>Login</strong>
                                                        </a>
                                                    </p>
                                                    <div class="formBtn">
                                                        <button type="submit" class="themeBtn">Sign Up</button>
                                                    </div>
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
        {{-- Consumer Form --}}

        {{-- Business Form --}}
        <section class="signup-sect d-none" id="business-form">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="categ-content">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="check-form">
                                        <h2 class="sectionHeading">Sign Up (Business Free Membership)</h2>
                                        <form action="{{ route('front.signup.submit') }}" method="POST" id="business"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="type" value="business">
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="name"
                                                           placeholder="Username">
                                                </div>
                                                <div class="col-md">
                                                    <input type="email" class="form-control" name="email"
                                                           placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="service"
                                                           placeholder="Business Service Provide">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="tel" class="form-control phoneNumber" name="number"
                                                           placeholder="Phone Number">
                                                </div>
                                                <div class="col-md">
                                                    <input type="tel" class="form-control phoneNumber" name="business_phone_number"
                                                           placeholder="Business Phone Number">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input
                                                        id="business-password"
                                                        :type="showBusinessPassword ? 'text' : 'password'"
                                                        class="form-control"
                                                        name="password"
                                                        required
                                                        autocomplete="password"
                                                        placeholder="Password"
                                                    />
                                                    <button
                                                        type="button"
                                                        id="business-password"
                                                        @click="togglePasswordVisibility('businessPassword')"
                                                    >
                                                        <i aria-hidden="true" class="fa fa-eye"
                                                           v-if="showBusinessPassword"></i>
                                                        <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                    </button>
                                                </div>
                                                <div class="col-md">
                                                    <input
                                                        id="business-password-confirm"
                                                        :type="showBusinessConfirmPassword ? 'text' : 'password'"
                                                        class="form-control"
                                                        name="password_confirmation"
                                                        autocomplete="password"
                                                        placeholder="Confirm Password"
                                                        required
                                                    />
                                                    <button
                                                        type="button"
                                                        id="business-password-confirm"
                                                        @click="togglePasswordVisibility('businessConfirmPassword')"
                                                    >
                                                        <i aria-hidden="true" class="fa fa-eye"
                                                           v-if="showBusinessConfirmPassword"></i>
                                                        <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="radio">
                                                        <input type="radio" id="businesses" name="business_type"
                                                               value="Business">
                                                        <label for="businesses" class="radio-label">
                                                            <strong>Business</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <div class="radio">
                                                        <input type="radio" id="self-professional" name="business_type"
                                                               value="self-professional">
                                                        <label for="self-professional" class="radio-label">
                                                            <strong>Self - Professional</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="business_name"
                                                           placeholder="Business Name / Rep Name">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                        <textarea class="form-control mb-3" name="business_description"
                                                                  value=""
                                                                  id="businessDescription"
                                                                  placeholder="Business Description (Optional)"
                                                                  rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="radio">
                                                        <input type="radio" id="locational" name="locational"
                                                               onclick="toggleLocationFields()">
                                                        <label for="locational" class="radio-label">
                                                            <strong>Locational</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <div class="radio">
                                                        <input type="radio" id="non-locational" name="locational"
                                                               onclick="toggleLocationFields()" checked>
                                                        <label for="non-locational" class="radio-label">
                                                            <strong>Non - Locational</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="show-location d-none">
                                                <div class="row">
                                                    <div class="col-md">
                                                        <input type="text" class="form-control" name="location[]"
                                                               placeholder="Location" id="business-search-input">
                                                        <div id="business-suggestions" style="display: none;"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <input type="text" class="form-control" name="longitude[]"
                                                               placeholder="Longitude" id="business-longitude-text"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md">
                                                        <input type="text" class="form-control" name="latitude[]"
                                                               placeholder="Latitude" id="business-latitude-text"
                                                               readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <select class="form-control" name="business_categories"
                                                            id="exampleFormControlSelect2">
                                                        <option readonly>
                                                            Business Categories
                                                        </option>
                                                        @foreach($categories as $category)
                                                            <option
                                                                value="{{ $category->id }}">
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="web_link[]"
                                                           placeholder="Web Link">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="home_church_name"
                                                           placeholder="Home Church Name (Optional)">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="home_church_address"
                                                           placeholder="Home Church Address (Optional)">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <select class="form-control" name="view_as"
                                                            id="exampleFormControlSelect3">
                                                        <option readonly>
                                                            I want to view businesses as
                                                        </option>
                                                        <option
                                                            value="Business Who Identifies As Christian">
                                                            Business Who Identifies As Christian
                                                        </option>
                                                        <option
                                                            value="Business Who Identifies As Non Christian">
                                                            Business Who Identifies As Non Christian
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="denomination"
                                                           placeholder="Denomination">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="referral_code"
                                                           placeholder="Referral Code (Optional)">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>Do You Have Account?
                                                        <a href="{{ route('front.login') }}" class="text-dark">
                                                            <strong>Login</strong>
                                                        </a>
                                                    </p>
                                                    <div class="formBtn">
                                                        <button type="submit" class="themeBtn">Sign Up</button>
                                                    </div>
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
        {{-- Business Form --}}

        {{-- Paid Member Form --}}
        <section class="signup-sect d-none" id="paid-member-form">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="categ-content">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="check-form">
                                        <h2 class="sectionHeading">Sign Up (Business Paid Membership)</h2>
                                        <form action="{{ route('front.signup.submit') }}" method="POST" id="paid-member"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="type" value="paid_member">
                                            <input type="hidden" id="subscription-amount" name="amount" value="">
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="name"
                                                           placeholder="Username">
                                                </div>
                                                <div class="col-md">
                                                    <input type="email" class="form-control" name="email"
                                                           placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="service"
                                                           placeholder="Business Service Provide">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="tel" class="form-control phoneNumber" name="number"
                                                           placeholder="Phone Number">
                                                </div>
                                                <div class="col-md">
                                                    <input type="tel" class="form-control phoneNumber" name="business_phone_number"
                                                           placeholder="Business Phone Number">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input
                                                        id="paid-member-password"
                                                        :type="showPaidMemberPassword ? 'text' : 'password'"
                                                        class="form-control"
                                                        name="password"
                                                        required
                                                        autocomplete="password"
                                                        placeholder="Password"
                                                    />
                                                    <button
                                                        type="button"
                                                        id="paid-member-password"
                                                        @click="togglePasswordVisibility('paidMemberPassword')"
                                                    >
                                                        <i aria-hidden="true" class="fa fa-eye"
                                                           v-if="showPaidMemberPassword"></i>
                                                        <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                    </button>
                                                </div>
                                                <div class="col-md">
                                                    <input
                                                        id="paid-member-password-confirm"
                                                        :type="showPaidMemberConfirmPassword ? 'text' : 'password'"
                                                        class="form-control"
                                                        name="password_confirmation"
                                                        autocomplete="password"
                                                        placeholder="Confirm Password"
                                                        required
                                                    />
                                                    <button
                                                        type="button"
                                                        id="paid-member-password-confirm"
                                                        @click="togglePasswordVisibility('paidMemberConfirmPassword')"
                                                    >
                                                        <i aria-hidden="true" class="fa fa-eye"
                                                           v-if="showPaidMemberConfirmPassword"></i>
                                                        <i aria-hidden="true" class="fa fa-eye-slash" v-else></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="radio">
                                                        <input type="radio" id="paid-member-business"
                                                               name="business_type"
                                                               value="Business">
                                                        <label for="paid-member-business" class="radio-label">
                                                            <strong>Business</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <div class="radio">
                                                        <input type="radio" id="paid-member-self-professional"
                                                               name="business_type"
                                                               value="self-professional">
                                                        <label for="paid-member-self-professional" class="radio-label">
                                                            <strong>Self - Professional</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="business_name"
                                                           placeholder="Business Name / Rep Name">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                        <textarea class="form-control mb-3" name="business_description"
                                                                  value=""
                                                                  id="paidMemberBusinessDescription"
                                                                  placeholder="Business Description (Optional)"
                                                                  rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="radio">
                                                        <input type="radio" id="paid-member-locational"
                                                               name="locational"
                                                               onclick="togglePaidMemberLocationFields()">
                                                        <label for="paid-member-locational" class="radio-label">
                                                            <strong>Locational</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <div class="radio">
                                                        <input type="radio" id="paid-member-non-locational"
                                                               name="locational"
                                                               onclick="togglePaidMemberLocationFields()" checked>
                                                        <label for="paid-member-non-locational" class="radio-label">
                                                            <strong>Non - Locational</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="show-paid-member-location d-none">
                                                <div class="row">
                                                    <div class="col-md">
                                                        <input type="text" class="form-control" name="location[]"
                                                               placeholder="Location"
                                                               id="paid-member-business-search-input">
                                                        <div id="paid-member-business-suggestions"
                                                             style="display: none;"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <input type="text" class="form-control" name="longitude[]"
                                                               placeholder="Longitude"
                                                               id="paid-member-business-longitude-text"
                                                               readonly>
                                                    </div>
                                                    <div class="col-md">
                                                        <input type="text" class="form-control" name="latitude[]"
                                                               placeholder="Latitude"
                                                               id="paid-member-business-latitude-text"
                                                               readonly>
                                                    </div>
                                                </div>
                                                <div class="paid-member-multi-locations" style="display: none;"></div>
                                                <div class="add-location-icon">
                                                    <i class="fas fa-plus location-icon"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <select class="form-control" name="business_categories"
                                                            id="exampleFormControlSelect4">
                                                        <option readonly>
                                                            Business Categories
                                                        </option>
                                                        @foreach($categories as $category)
                                                            <option
                                                                value="{{ $category->id }}">
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="web_link[]"
                                                           placeholder="Web Link">
                                                </div>
                                            </div>
                                            <div class="paid-member-multi-links" style="display: none;"></div>
                                            <div class="add-link-icon">
                                                <i class="fas fa-plus location-icon"></i>
                                            </div>

                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="home_church_name"
                                                           placeholder="Home Church Name (Optional)">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="home_church_address"
                                                           placeholder="Home Church Address (Optional)">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <select class="form-control" name="view_as"
                                                            id="exampleFormControlSelect5">
                                                        <option readonly>
                                                            I want to view businesses as
                                                        </option>
                                                        <option
                                                            value="Business Who Identifies As Christian">
                                                            Business Who Identifies As Christian
                                                        </option>
                                                        <option
                                                            value="Business Who Identifies As Non Christian">
                                                            Business Who Identifies As Non Christian
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="denomination"
                                                           placeholder="Denomination">
                                                </div>
                                                <div class="col-md">
                                                    <input type="text" class="form-control" name="referral_code"
                                                           placeholder="Referral Code (Optional)">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="text" class="form-control" id="coupon-code" name="coupon_code"
                                                           placeholder="Apply Coupon">
                                                </div>
                                                <div class="col-md">
                                                    <a href="javascript:;" class="themeBtn" id="apply-coupon">Apply</a>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>Do You Have Account?
                                                        <a href="{{ route('front.login') }}" class="text-dark">
                                                            <strong>Login</strong>
                                                        </a>
                                                    </p>
                                                    <div class="formBtn">
                                                        <button type="submit" class="themeBtn">Sign Up</button>
                                                    </div>
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
        {{--  Paid Member Form --}}
    </div>
    {{-- Forms --}}

@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#apply-coupon', function () {

                let coupon_code = $('#coupon-code').val();
                let csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

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
                                'background': '#f1e4d4',
                                'color': '#6a5536',
                                'border': '2px solid #6a5536',
                            });
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

    {{-- Simple Location Work --}}
    <script>
        function initBusinessMap() {
            let searchBusinessInput, longitudeBusinessInput, latitudeBusinessInput, suggestionsBusinessContainer,
                autocompleteBusinessService;

            searchBusinessInput = document.getElementById('business-search-input');
            longitudeBusinessInput = document.getElementById('business-longitude-text');
            latitudeBusinessInput = document.getElementById('business-latitude-text');
            suggestionsBusinessContainer = document.getElementById('business-suggestions');
            autocompleteBusinessService = new google.maps.places.AutocompleteService();

            searchBusinessInput.addEventListener('input', function () {
                const query = this.value;
                suggestionsBusinessContainer.innerHTML = '';

                if (query) {
                    autocompleteBusinessService.getPlacePredictions({input: query}, function (predictions, status) {
                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                            predictions.forEach(function (prediction) {
                                const suggestionElement = document.createElement('div');
                                suggestionElement.classList.add('business-suggestion');
                                suggestionElement.textContent = prediction.description;

                                suggestionElement.addEventListener('click', function () {
                                    searchBusinessInput.value = prediction.description;
                                    suggestionsBusinessContainer.style.display = 'none';

                                    // Fetch additional details for the selected place
                                    const placeService = new google.maps.places.PlacesService(document.createElement('div'));
                                    placeService.getDetails({placeId: prediction.place_id}, function (place, status) {
                                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                                            // Find latitude and longitude inputs relative to the search input
                                            const selectedLatitude = place.geometry.location.lat();
                                            const selectedLongitude = place.geometry.location.lng();

                                            latitudeBusinessInput.value = selectedLatitude;
                                            longitudeBusinessInput.value = selectedLongitude;

                                        }
                                    });
                                });

                                suggestionsBusinessContainer.appendChild(suggestionElement);
                            });

                            suggestionsBusinessContainer.style.display = 'block';
                        } else {
                            suggestionsBusinessContainer.style.display = 'none';
                        }
                    });
                } else {
                    suggestionsBusinessContainer.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', initBusinessMap);

        function initPaidMemberBusinessMap() {
            let searchPaidMemberBusinessInput, longitudePaidMemberBusinessInput, latitudePaidMemberBusinessInput, suggestionsPaidMemberBusinessContainer,
                autocompletePaidMemberBusinessService;

            searchPaidMemberBusinessInput = document.getElementById('paid-member-business-search-input');
            longitudePaidMemberBusinessInput = document.getElementById('paid-member-business-longitude-text');
            latitudePaidMemberBusinessInput = document.getElementById('paid-member-business-latitude-text');
            suggestionsPaidMemberBusinessContainer = document.getElementById('paid-member-business-suggestions');
            autocompletePaidMemberBusinessService = new google.maps.places.AutocompleteService();

            searchPaidMemberBusinessInput.addEventListener('input', function () {
                const query = this.value;
                suggestionsPaidMemberBusinessContainer.innerHTML = '';

                if (query) {
                    autocompletePaidMemberBusinessService.getPlacePredictions({input: query}, function (predictions, status) {
                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                            predictions.forEach(function (prediction) {
                                const suggestionElement = document.createElement('div');
                                suggestionElement.classList.add('paid-member-business-suggestion');
                                suggestionElement.textContent = prediction.description;

                                suggestionElement.addEventListener('click', function () {
                                    searchPaidMemberBusinessInput.value = prediction.description;
                                    suggestionsPaidMemberBusinessContainer.style.display = 'none';

                                    // Fetch additional details for the selected place
                                    const placeService = new google.maps.places.PlacesService(document.createElement('div'));
                                    placeService.getDetails({placeId: prediction.place_id}, function (place, status) {
                                        if (status === google.maps.places.PlacesServiceStatus.OK) {
                                            // Find latitude and longitude inputs relative to the search input
                                            const selectedLatitude = place.geometry.location.lat();
                                            const selectedLongitude = place.geometry.location.lng();

                                            latitudePaidMemberBusinessInput.value = selectedLatitude;
                                            longitudePaidMemberBusinessInput.value = selectedLongitude;

                                        }
                                    });
                                });

                                suggestionsPaidMemberBusinessContainer.appendChild(suggestionElement);
                            });

                            suggestionsPaidMemberBusinessContainer.style.display = 'block';
                        } else {
                            suggestionsPaidMemberBusinessContainer.style.display = 'none';
                        }
                    });
                } else {
                    suggestionsPaidMemberBusinessContainer.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', initPaidMemberBusinessMap);
    </script>
    {{-- Simple Location Work --}}

    {{-- Password Hide And Show Work --}}
    <script>
        new Vue({
            el: '#app',
            data: {
                showChurchPassword: false,
                showChurchConfirmPassword: false,
                showConsumerPassword: false,
                showConsumerConfirmPassword: false,
                showBusinessPassword: false,
                showBusinessConfirmPassword: false,
                showPaidMemberPassword: false,
                showPaidMemberConfirmPassword: false,
            },
            methods: {
                togglePasswordVisibility(field) {
                    switch (field) {
                        case 'churchPassword':
                            this.showChurchPassword = !this.showChurchPassword;
                            break;
                        case 'churchConfirmPassword':
                            this.showChurchConfirmPassword = !this.showChurchConfirmPassword;
                            break;
                        case 'consumerPassword':
                            this.showConsumerPassword = !this.showConsumerPassword;
                            break;
                        case 'consumerConfirmPassword':
                            this.showConsumerConfirmPassword = !this.showConsumerConfirmPassword;
                            break;
                        case 'businessPassword':
                            this.showBusinessPassword = !this.showBusinessPassword;
                            break;
                        case 'businessConfirmPassword':
                            this.showBusinessConfirmPassword = !this.showBusinessConfirmPassword;
                            break;
                        case 'paidMemberPassword':
                            this.showPaidMemberPassword = !this.showPaidMemberPassword;
                            break;
                        case 'paidMemberConfirmPassword':
                            this.showPaidMemberConfirmPassword = !this.showPaidMemberConfirmPassword;
                            break;
                    }
                }
            },
        });
    </script>
    {{-- Password Hide And Show Work --}}

    {{-- Account Type Selected Work --}}
    <script>
        document.querySelectorAll('.signup-dropdown').forEach(dropdown => {
            dropdown.addEventListener('click', () => {
                const radioInput = dropdown.querySelector('input[type="radio"]');
                radioInput.checked = true;

                document.querySelectorAll('.signup-dropdown .content').forEach(content => {
                    content.style.display = 'none';
                    content.style.opacity = '0';
                });

                const content = dropdown.querySelector('.content');
                content.style.display = 'block';

                setTimeout(() => {
                    content.style.opacity = '1';
                }, 30);
            });
        });

        document.querySelectorAll('.signup-link').forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();

                const targetId = link.getAttribute('href').substring(1);
                document.querySelectorAll('.signup-sect').forEach(section => {
                    section.classList.add('d-none');
                });

                document.getElementById(targetId + '-form').classList.remove('d-none');
            });
        });
    </script>
    {{-- Account Type Selected Work --}}

    {{-- Tinymce Editor, Remove Icon, Toggle And Validation Work --}}
    <script>
        tinymce.init({
            selector: '#businessDescription',
            readonly: false
        });

        tinymce.init({
            selector: '#paidMemberBusinessDescription',
            readonly: false
        });

        function removePaidMemberMultiLocation(icon) {
            // $(icon).parent().parent().hide();
            $(icon).closest('.row').next('.row').hide();
            $(icon).closest('.row').prev('.row').hide();
            $(icon).closest('.row').hide();
        }

        function removePaidMemberMutliLink(icon) {
            $(icon).parent().hide();
        }

        function toggleLocationFields() {
            var locationalRadio = document.getElementById("locational");
            var showLocationDiv = document.querySelector(".show-location");

            if (locationalRadio.checked) {
                showLocationDiv.classList.remove("d-none");
            } else {
                showLocationDiv.classList.add("d-none");
            }
        }

        function togglePaidMemberLocationFields() {
            var locationalPaidMemberRadio = document.getElementById("paid-member-locational");
            var showPaidMemberLocationDiv = document.querySelector(".show-paid-member-location");

            if (locationalPaidMemberRadio.checked) {
                showPaidMemberLocationDiv.classList.remove("d-none");
            } else {
                showPaidMemberLocationDiv.classList.add("d-none");
            }
        }

        // Validation Forms
        $(document).ready(function () {
            $("form#church").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    number: {
                        required: true,
                        minlength: 10
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "[name='password']"
                    },
                    country: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    home_church_name: {
                        required: true
                    },
                    home_church_address: {
                        required: true
                    },
                    denomination: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your username",
                        minlength: "Your username must consist of at least 3 characters"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    number: {
                        required: "Please enter your phone number",
                        minlength: "Your phone number must consist of at least 10 digits"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Password and confirmation do not match"
                    },
                    country: {
                        required: "Please enter your country"
                    },
                    state: {
                        required: "Please enter your state"
                    },
                    city: {
                        required: "Please enter your city"
                    },
                    home_church_name: {
                        required: "Please enter your home church name"
                    },
                    home_church_address: {
                        required: "Please enter your home church address"
                    },
                    denomination: {
                        required: "Please enter your denomination"
                    }
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    if (element.prop('type') === 'checkbox') {
                        error.insertAfter(element.siblings('label'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-valid').removeClass('is-invalid');
                }
            });

            $("form#consumer").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    number: {
                        required: true,
                        // digits: true,
                        // minlength: 10,
                        // maxlength: 15
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "[name='password']"
                    },
                    country: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    view_as: {
                        required: true
                    },
                    denomination: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your username",
                        minlength: "Your username must consist of at least 3 characters"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    number: {
                        required: "Please enter your phone number",
                        // digits: "Please enter only digits",
                        // minlength: "Your phone number must be at least 10 digits long",
                        // maxlength: "Your phone number must be no more than 15 digits long"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Password and confirmation do not match"
                    },
                    country: {
                        required: "Please enter your country"
                    },
                    state: {
                        required: "Please enter your state"
                    },
                    city: {
                        required: "Please enter your city"
                    },
                    view_as: {
                        required: "Please select an option"
                    },
                    denomination: {
                        required: "Please enter your denomination"
                    }
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    if (element.prop('type') === 'checkbox') {
                        error.insertAfter(element.siblings('label'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-valid').removeClass('is-invalid');
                }
            });

            $("form#business").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    number: {
                        required: true
                    },
                    service: {
                        required: true
                    },
                    business_phone_number: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#business-password"
                    },
                    business_type: {
                        required: true
                    },
                    business_name: {
                        required: true
                    },
                    business_categories: {
                        required: true
                    },
                    view_as: {
                        required: true
                    },
                    denomination: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your username",
                        minlength: "Your username must be at least 3 characters long"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    number: {
                        required: "Please enter your phone number"
                    },
                    service: {
                        required: "Please enter your business service"
                    },
                    business_phone_number: {
                        required: "Please enter your business phone number"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    },
                    business_type: {
                        required: "Please select your business type"
                    },
                    business_name: {
                        required: "Please enter your business name"
                    },
                    business_categories: {
                        required: "Please select a business category"
                    },
                    view_as: {
                        required: "Please select an option"
                    },
                    denomination: {
                        required: "Please enter your denomination"
                    }
                },
                errorElement: "div",
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback");
                    element.closest(".col-md").append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
            });

            $("form#paid-member").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    number: {
                        required: true,
                    },
                    service: {
                        required: true,
                    },
                    business_phone_number: {
                        required: true,
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#paid-member-password"
                    },
                    business_type: {
                        required: true
                    },
                    business_name: {
                        required: true
                    },
                    business_categories: {
                        required: true
                    },
                    view_as: {
                        required: true
                    },
                    denomination: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your username",
                        minlength: "Your username must be at least 3 characters long"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    number: {
                        required: "Please enter your phone number"
                    },
                    service: {
                        required: "Please enter your business service"
                    },
                    business_phone_number: {
                        required: "Please enter your business phone number"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    },
                    business_type: {
                        required: "Please select your business type"
                    },
                    business_name: {
                        required: "Please enter your business name"
                    },
                    business_categories: {
                        required: "Please select a business category"
                    },
                    view_as: {
                        required: "Please select an option"
                    },
                    denomination: {
                        required: "Please enter your denomination"
                    }
                },
                errorElement: "div",
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback");
                    element.closest(".col-md").append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
            });
        });
        // Validation Forms
    </script>
    {{-- Tinymce Editor, Remove Icon, Toggle And Validation Work --}}

    {{-- Paid Member Work --}}
    <script>
        $(document).ready(function () {
            // Location Work
            function paidMemberMultiLocation(isFirstLoad, counter) {
                let searchPaidMemberMultiInput, longitudePaidMemberMultiInput, latitudePaidMemberMultiInput, suggestionsPaidMemberMultiContainer,
                    autocompletePaidMemberMultiService;

                // Add Multiple Business Location


                searchPaidMemberMultiInput = document.getElementById(`paid-member-multi-search-input-${counter}`);
                latitudePaidMemberMultiInput = document.getElementById(`paid-member-multi-latitude-text-${counter}`);
                longitudePaidMemberMultiInput = document.getElementById(`paid-member-multi-longitude-text-${counter}`);
                suggestionsPaidMemberMultiContainer = document.getElementById(`paid-member-multi-suggestions-${counter}`);

                // Check if all necessary elements are found
                if (!searchPaidMemberMultiInput || !longitudePaidMemberMultiInput || !latitudePaidMemberMultiInput || !suggestionsPaidMemberMultiContainer) {
                    // console.error('One or more elements not found for counter:', counter);
                    return;
                }

                autocompletePaidMemberMultiService = new google.maps.places.AutocompleteService();

                searchPaidMemberMultiInput.addEventListener('input', function () {
                    const query = this.value;
                    suggestionsPaidMemberMultiContainer.innerHTML = '';

                    if (query) {
                        autocompletePaidMemberMultiService.getPlacePredictions({input: query}, function (predictions, status) {
                            if (status === google.maps.places.PlacesServiceStatus.OK) {
                                predictions.forEach(function (prediction) {
                                    const suggestionElement = document.createElement('div');
                                    suggestionElement.classList.add('paid-member-multi-suggestion');
                                    suggestionElement.textContent = prediction.description;

                                    suggestionElement.addEventListener('click', function () {
                                        searchPaidMemberMultiInput.value = prediction.description;
                                        suggestionsPaidMemberMultiContainer.innerHTML = '';

                                        // Fetch additional details for the selected place
                                        const placeService = new google.maps.places.PlacesService(document.createElement('div'));
                                        placeService.getDetails({placeId: prediction.place_id}, function (place, status) {
                                            if (status === google.maps.places.PlacesServiceStatus.OK) {
                                                const selectedMultiLatitude = place.geometry.location.lat();
                                                const selectedMultiLongitude = place.geometry.location.lng();
                                                latitudePaidMemberMultiInput.value = selectedMultiLatitude;
                                                longitudePaidMemberMultiInput.value = selectedMultiLongitude;

                                                // Hide suggestions container when latitude or longitude is selected
                                                suggestionsPaidMemberMultiContainer.style.display = 'none';
                                            }
                                        });
                                    });

                                    suggestionsPaidMemberMultiContainer.appendChild(suggestionElement);
                                });

                                suggestionsPaidMemberMultiContainer.style.display = 'block';
                            } else {
                                suggestionsPaidMemberMultiContainer.style.display = 'none';
                            }
                        });
                    } else {
                        suggestionsPaidMemberMultiContainer.style.display = 'none';
                    }
                });

                // Event listener for latitude and longitude input fields
                latitudePaidMemberMultiInput.addEventListener('input', function () {
                    suggestionsPaidMemberMultiContainer.style.display = 'none';
                });

                longitudePaidMemberMultiInput.addEventListener('input', function () {
                    suggestionsPaidMemberMultiContainer.style.display = 'none';
                });
            }

            let counter = 0;

            // Initialize map for the first location
            paidMemberMultiLocation(true, counter);

            $(document).on('click', '.add-location-icon', function () {
                let multi_locations = $('.paid-member-multi-locations');
                multi_locations.show();
                counter++;

                let locationElement = $(`
                    <div class="row">
                        <div class="col-md">
                            <input type="text" class="form-control" id="paid-member-multi-search-input-${counter}" name="location[]" value="" placeholder="Locations">
                            <div id="paid-member-multi-suggestions-${counter}" class="paid-member-multi-suggestions" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <input type="text" class="form-control" name="latitude[]" value="" id="paid-member-multi-latitude-text-${counter}" placeholder="Latitude" readonly>
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control" name="longitude[]" value="" id="paid-member-multi-longitude-text-${counter}" placeholder="Longitude" readonly>
                        </div>
                        <i class="fas fa-times remove-location-icon" onclick="removePaidMemberMultiLocation(this)"></i>
                    </div>
                `);

                multi_locations.append(locationElement);

                // Initialize map for the newly added location
                $('.add-location-icon').show();
                paidMemberMultiLocation(false, counter);
            });

            $(document).on('click', '.add-link-icon', function () {
                let multi_links = $('.paid-member-multi-links');
                multi_links.show();

                let locationElement = $(`
                    <div class="row">
                        <div class="col-md">
                            <input type="url" class="form-control" name="web_link[]" value="" placeholder="Web Link">
                        </div>
                        <i class="fas fa-times remove-location-icon" onclick="removePaidMemberMutliLink(this)"></i>
                    </div>
                `);

                multi_links.append(locationElement);
                $('.add-link-icon').show();
            });
        });
    </script>
    {{-- Paid Member Work --}}
@endsection
