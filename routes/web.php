<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\Inner_bannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TestimonialsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth Front Cbf View

// Register
Route::post('apply-coupon-web', [AuthController::class, 'applyCouponWeb'])->name('apply.coupon.web');
Route::get('payment', [AuthController::class, 'paypalPaymentGateway'])->name('payment');
Route::post('user-web-create', [AuthController::class, 'userWebCreate'])->name('user.web.create');

Route::get('/signup', [AuthController::class, 'register'])->name('front.signup');
Route::post('/front-signup', [AuthController::class, 'registerSubmit'])->name('front.signup.submit');

// Login
Route::get('/login', [AuthController::class, 'login'])->name('front.login');
Route::post('front-login', [AuthController::class, 'loginSubmit'])->name('front.login.submit');

// change password
Route::get('/change-password', [AuthController::class, 'changePassword'])->name('front.change.password');
Route::post('/change-password-submit', [AuthController::class, 'changePasswordSubmit'])->name('front.change.password.submit');

// forget password
Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('front.forget.password');
Route::post('/forget-form', [AuthController::class, 'resetPassword'])->name('front.forget.submit');
Route::get('/reset-token/{otp?}', [AuthController::class, 'showResetPasswordForm'])->name('front.reset.password');
Route::post('/reset-form', [AuthController::class, 'submitResetPasswordForm'])->name('front.reset.submit');
// Auth Front Cbf View


// Front Cbf View
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/contact-us', [FrontController::class, 'contact'])->name('front.contact');
Route::post('/contact-us-submit', [FrontController::class, 'contactusSubmit'])->name('front.contact.submit');
Route::post('/subscribe-newsletter', [FrontController::class, 'newsLetterSubmit'])->name('front.news.letter');

Route::middleware(['authUser'])->group(function () {

    Route::get('/category', [FrontController::class, 'category'])->name('front.category');
    Route::get('/category-detail/{slug?}', [FrontController::class, 'categoryDetails'])->name('front.category.detail');

    Route::get('/business/{id?}', [FrontController::class, 'business'])->name('front.business');
    Route::get('/business-detail/{id?}', [FrontController::class, 'businessDetails'])->name('front.business.detail');
    Route::post('/rate-business/{id?}', [FrontController::class, 'ratedUnratedBusiness'])->name('front.rating.business');
    Route::post('/resume-send/{id?}', [FrontController::class, 'resumeSend'])->name('front.resume.send');
    Route::get('/search-business', [FrontController::class, 'searchBusiness'])->name('front.search.business');

    Route::get('/edit-profile', [FrontController::class, 'editProfile'])->name('front.edit.profile');
    Route::post('/update-profile/{id?}', [FrontController::class, 'updateProfile'])->name('front.update.profile');
    Route::post('/update-profile-image/{id?}', [FrontController::class, 'updateProfileImage'])->name('front.update.profile.image');

    // Apply subscription validation middleware only to manage business routes
    Route::get('/manage-business/{id?}', [FrontController::class, 'manageBusiness'])->name('front.manage.business');
    Route::middleware(['check.subscription'])->group(function () {
        Route::post('/update-manage-business/{id?}', [FrontController::class, 'updateManageBusiness'])->name('front.update.manage.business');
        Route::post('/update-manage-business-thumbnail/{id?}', [FrontController::class, 'updateManageBusinessThumbnail'])->name('front.update.manage.business.thumbnail');
    });

    // subscription update
    Route::post('/user-subscription', [FrontController::class, 'subscription'])->name('subscription');
    Route::get('/subscription-payment-gateway', [FrontController::class, 'subscriptionPaymentGateway'])->name('subscription.payment.gateway');
    Route::post('/subscription-update', [FrontController::class, 'userSubscriptionUpdate'])->name('user.subscription.update');

    Route::get('/about-us', [FrontController::class, 'aboutUs'])->name('front.about');
    Route::get('/favourite', [FrontController::class, 'favourite'])->name('front.favourite');
    Route::get('/privacy-policy', [FrontController::class, 'privacyPolicy'])->name('front.privacy');
    Route::get('/terms-condition', [FrontController::class, 'termsCondition'])->name('front.terms.condition');
    Route::get('/business-finder', [FrontController::class, 'businessFinder'])->name('front.business.finder');

    Route::post('/likes-unlikes/{id?}', [FrontController::class, 'likeUnlikeBusiness'])->name('front.likes.unlikes');
    Route::get('/get-likes', [FrontController::class, 'getLikes'])->name('front.get.likes');

    Route::get('/checkout', [IndexController::class, 'checkout'])->name('front.checkout');
    Route::get('/thank-you', [IndexController::class, 'thankyou'])->name('front.thankyou');

    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('front.logout');
});
// Auth Front Cbf View

// map show
Route::get('/products/map/{id?}', [ProductController::class, 'showMap']);

Route::get('/api', [ProductController::class, 'api']);
// Chat Room
Route::get('chat/{id?}', [ChatController::class, 'chat'])->name('chat');
Route::post('save-msg', [ChatController::class, 'save_msg'])->name('save_msg');
Route::post('fetch_msg', [ChatController::class, 'fetch_msg'])->name('fetch_msg');
// Index
Route::post('change-password', [App\Http\Controllers\API\UserController::class, 'changePassword']);
Route::post('update-info', [App\Http\Controllers\API\UserController::class, 'updateInfo']);
//Route::get('/', [IndexController::class, 'index'])->name('welcome');
Route::get('/rent', [IndexController::class, 'shop'])->name('rent');
Route::get('/reviews', [IndexController::class, 'reviews'])->name('reviews');
Route::get('/products', [IndexController::class, 'product'])->name('product');
Route::get('/product-details/{id?}', [IndexController::class, 'product_details'])->name('product_details');
Route::get('/product-request/{id?}', [IndexController::class, 'product_request'])->name('product_request');
Route::post('/product-request', [IndexController::class, 'ProductRequest'])->name('ProductRequest');
Route::get('/date', [IndexController::class, 'date'])->name('date');
Route::post('/newslettersubmit', [IndexController::class, 'newslettersubmit'])->name('newslettersubmit');
Route::get('/thank-you/{oid?}', [IndexController::class, 'thank_you'])->name('thank_you');
Route::get('/payout/{id}', [IndexController::class, 'payout'])->name('payout');
Route::get('/consumers', [IndexController::class, 'consumers'])->name('consumers');
Route::get('/businesses', [IndexController::class, 'businesses'])->name('businesses');
Route::get('/sales-professionals', [IndexController::class, 'salesProfessionals'])->name('sales.professionals');
// Custom
Route::get('facebook', [CustomAuthController::class, 'redirectToFacebook']);
Route::post('/crt-prd', [CustomAuthController::class, 'CreateProduct'])->name('CreateProduct');
Route::get('facebook/callback', [CustomAuthController::class, 'handleFacebookCallback']);
Route::get('/user-dashboard', [CustomAuthController::class, 'user_dashboard'])->name('user_dashboard');
Route::get('/user-order', [CustomAuthController::class, 'user_order'])->name('user_order');
Route::get('/incoming-request', [CustomAuthController::class, 'incoming_request'])->name('incoming_request');
Route::get('product-request/{product_request_id}/{productaction}', [CustomAuthController::class, 'Product_Action'])->name('ProductAction');
Route::get('req-notify/{product_request_id}/{reqnotify}', [CustomAuthController::class, 'req_notify'])->name('reqnotify');
Route::get('req-return/{product_request_id}/{reqreturn}', [CustomAuthController::class, 'req_return'])->name('reqreturn');
Route::get('/post-request', [CustomAuthController::class, 'post_request'])->name('user_store');
Route::get('/user-form', [CustomAuthController::class, 'user_form'])->name('user_form');
// Route::get('/register', [CustomAuthController::class, 'signup'])->name('register');
Route::any('/user-add-custom-business/{id?}', [CustomAuthController::class, 'userAddBusinessBehalfBusinessType'])->name('user.add.custom.business');
// web cms
Route::get('/edit_web_cms/{id?}', [IndexController::class, 'web_cms_edit'])->name('web_cms_edit');
Route::post('/update_web_cms', [IndexController::class, 'web_cms_update'])->name('web_cms_update');

Route::get('admin/login', function () {
    return view('admin.login');
})->name('admin.login');
Route::post('admin/loginsubmit', [AuthenticationController::class, 'admin_authentication']);


Route::group(['prefix' => '/admin', 'middleware' => ['customer']], function () {

    Route::get('dashboard', [AdminHomeController::class, 'dashboard'])->name('dashboard');

    /**** Banner routes /*****/
    Route::get('banner', [AdminBannerController::class, 'index'])->name('banner.index');
    Route::post('banner-store', [AdminBannerController::class, 'store'])->name('banner.store');
    Route::post('banner-status/{id?}', [AdminBannerController::class, 'status'])->name('banner.status');
    Route::get('banner-edit/{id?}', [AdminBannerController::class, 'edit'])->name('banner.edit');
    Route::get('banner-update/{id?}', [AdminBannerController::class, 'update'])->name('banner.update');
    Route::get('banner-delete/{id?}', [AdminBannerController::class, 'delete'])->name('banner.delete');
    /**** Banner routes /*****/

    Route::get('/signout', [CustomAuthController::class, 'signout'])->name('signout');

    // notification
    Route::get('/notification', [UserController::class, 'notificationIndex'])->name('notification.index');
    Route::post('/notification-store', [UserController::class, 'notificationStore'])->name('notification.store');
    Route::get('/notification-show/{id?}', [UserController::class, 'notificationShow'])->name('notification.show');
    Route::post('/notification-destroy/{id?}', [UserController::class, 'notificationDestroy'])->name('notification.destroy');
//        Route::get('/notification', [UserController::class, 'notificationIndex'])->name('notification.index');

    // coupon
    Route::get('/coupon', [CouponController::class, 'coupon'])->name('admin.coupon');
    Route::post('/coupon-store', [CouponController::class, 'store'])->name('coupon.store');
    Route::post('/coupon-delete/{id?}', [CouponController::class, 'delete'])->name('coupon.delete');

    // payment
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('/payment-user-detail/{id?}', [PaymentController::class, 'show'])->name('payment.user.detail.show');
    Route::post('/payment-user-delete/{id?}', [PaymentController::class, 'delete'])->name('payment.user.delete');

    // subscription
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/subscription-store', [SubscriptionController::class, 'store'])->name('subscription.store');
    Route::post('/subscription-delete/{id?}', [SubscriptionController::class, 'delete'])->name('subscription.delete');


    Route::get('/logo-listing', [LogoController::class, 'logo_index'])->name('logo_index');
    Route::post('/update_logo', [LogoController::class, 'logo_update'])->name('logo_update');
    // banner
    Route::get('/banner-listing', [BannerController::class, 'banner_index'])->name('banner_index');
    Route::post('/store-banner/{id?}', [BannerController::class, 'banner_store'])->name('banner_store');
    Route::get('/show-banner/{id?}', [BannerController::class, 'banner_show'])->name('banner_show');
    Route::get('/edit-banner/{id?}', [BannerController::class, 'banner_edit'])->name('banner_edit');
    Route::post('/update_banner', [BannerController::class, 'banner_update'])->name('banner_update');
    Route::any('/destroy_banner/{id?}', [BannerController::class, 'banner_destroy'])->name('banner_destroy');
    Route::get('/status-banner}', [BannerController::class, 'banner_status'])->name('banner_status');
    // product_imgs
    Route::get('/product_imgs-listing/{id?}', [Product_imgsController::class, 'product_imgs_index'])->name('product_imgs_index');
    Route::post('/store-product_imgs/{id?}', [Product_imgsController::class, 'product_imgs_store'])->name('product_imgs_store');
    Route::get('/show-product_imgs/{id?}', [Product_imgsController::class, 'product_imgs_show'])->name('product_imgs_show');
    Route::get('/edit-product_imgs/{id?}', [Product_imgsController::class, 'product_imgs_edit'])->name('product_imgs_edit');
    Route::post('/update_product_imgs', [Product_imgsController::class, 'product_imgs_update'])->name('product_imgs_update');
    Route::any('/destroy_product_imgs/{id?}', [Product_imgsController::class, 'product_imgs_destroy'])->name('product_imgs_destroy');
    Route::get('/status-product_imgs', [Product_imgsController::class, 'product_imgs_status'])->name('product_imgs_status');
    // Inner Banner
    Route::get('/inner_banner-listing', [Inner_bannerController::class, 'inner_banner_index'])->name('inner_banner_index');
    Route::post('/store-inner_banner/{id?}', [Inner_bannerController::class, 'inner_banner_store'])->name('inner_banner_store');
    Route::get('/show-inner_banner/{id?}', [Inner_bannerController::class, 'inner_banner_show'])->name('inner_banner_show');
    Route::get('/edit-inner_banner/{id?}', [Inner_bannerController::class, 'inner_banner_edit'])->name('inner_banner_edit');
    Route::post('/update_inner_banner', [Inner_bannerController::class, 'inner_banner_update'])->name('inner_banner_update');
    Route::any('/destroy_inner_banner/{id?}', [Inner_bannerController::class, 'inner_banner_destroy'])->name('inner_banner_destroy');
    Route::get('/status-inner_banner}', [Inner_bannerController::class, 'inner_banner_status'])->name('inner_banner_status');
    // cms
    Route::get('/cms-listing', [CmsController::class, 'cms_index'])->name('cms_index');
    Route::post('/store-cms/{id?}', [CmsController::class, 'cms_store'])->name('cms_store');
    Route::get('/show-cms/{id?}', [CmsController::class, 'cms_show'])->name('cms_show');
    Route::get('/edit-cms/{id?}', [CmsController::class, 'cms_edit'])->name('cms_edit');
    Route::post('/update_cms', [CmsController::class, 'cms_update'])->name('cms_update');
    Route::any('/destroy_cms/{id?}', [CmsController::class, 'cms_destroy'])->name('cms_destroy');
    // testimonials
    Route::get('/testimonials-listing', [TestimonialsController::class, 'testimonials_index'])->name('testimonials_index');
    Route::post('/store-testimonials/{id?}', [TestimonialsController::class, 'testimonials_store'])->name('testimonials_store');
    Route::get('/show-testimonials/{id?}', [TestimonialsController::class, 'testimonials_show'])->name('testimonials_show');
    Route::get('/edit-testimonials/{id?}', [TestimonialsController::class, 'testimonials_edit'])->name('testimonials_edit');
    Route::post('/update_testimonials', [TestimonialsController::class, 'testimonials_update'])->name('testimonials_update');
    Route::any('/destroy_testimonials/{id?}', [TestimonialsController::class, 'testimonials_destroy'])->name('testimonials_destroy');
    Route::get('/status-testimonials}', [TestimonialsController::class, 'testimonials_status'])->name('testimonials_status');
    // technology
    Route::get('/technology-listing', [TechnologyController::class, 'technology_index'])->name('technology_index');
    Route::post('/store-technology/{id?}', [TechnologyController::class, 'technology_store'])->name('technology_store');
    Route::get('/show-technology/{id?}', [TechnologyController::class, 'technology_show'])->name('technology_show');
    Route::get('/edit-technology/{id?}', [TechnologyController::class, 'technology_edit'])->name('technology_edit');
    Route::post('/update_technology', [TechnologyController::class, 'technology_update'])->name('technology_update');
    Route::any('/destroy_technology/{id?}', [TechnologyController::class, 'technology_destroy'])->name('technology_destroy');
    // client
    Route::get('/client-listing', [ClientController::class, 'client_index'])->name('client_index');
    Route::post('/store-client/{id?}', [ClientController::class, 'client_store'])->name('client_store');
    Route::get('/show-client/{id?}', [ClientController::class, 'client_show'])->name('client_show');
    Route::get('/edit-client/{id?}', [ClientController::class, 'client_edit'])->name('client_edit');
    Route::post('/update_client', [ClientController::class, 'client_update'])->name('client_update');
    Route::any('/destroy_client/{id?}', [ClientController::class, 'client_destroy'])->name('client_destroy');
    // setting
    Route::get('/setting-listing', [SettingController::class, 'setting_index'])->name('setting_index');
    Route::post('/update_setting', [SettingController::class, 'setting_update'])->name('setting_update');
    // product
    Route::get('/product-listing', [ProductController::class, 'products_index'])->name('products_index');
    Route::post('/store-product/{id?}', [ProductController::class, 'products_store'])->name('products_store');
    Route::get('/show-product/{id?}', [ProductController::class, 'products_show'])->name('products_show');
    Route::get('/show-draft/{id?}', [ProductController::class, 'drafts_show'])->name('drafts_show');
    Route::get('/edit-product/{id?}', [ProductController::class, 'products_edit'])->name('products_edit');
    Route::post('/update_product', [ProductController::class, 'products_update'])->name('products_update');
    Route::get('/product-list/{id}', [ProductController::class, 'productImgs'])->name('product.images');
    Route::post('/product/{id}/images', [ProductController::class, 'images_store'])->name('images_store');
    Route::any('/destroy_product/{id?}', [ProductController::class, 'products_destroy'])->name('products_destroy');
    Route::get('/status-product', [ProductController::class, 'products_status'])->name('products_status');
    Route::get('/is_feature-product', [ProductController::class, 'products_is_feature'])->name('products_is_feature');
    // category
    Route::get('/category-listing', [CategoryController::class, 'category_index'])->name('category_index');
    Route::post('/store-category/{id?}', [CategoryController::class, 'category_store'])->name('category_store');
    Route::get('/show-category/{id?}', [CategoryController::class, 'category_show'])->name('category_show');
    Route::get('/edit-category/{id?}', [CategoryController::class, 'category_edit'])->name('category_edit');
    Route::post('/update_category', [CategoryController::class, 'category_update'])->name('category_update');
    Route::any('/destroy_category/{id?}', [CategoryController::class, 'category_destroy'])->name('category_destroy');
    Route::get('/status-category', [CategoryController::class, 'category_status'])->name('category_status');
    // business
    Route::get('/business-listing/{slug?}', [BusinessController::class, 'businessIndex'])->name('business.index');
    Route::post('/store-business/{id?}', [BusinessController::class, 'businessStore'])->name('business.store');
    Route::get('/show-business/{id?}', [BusinessController::class, 'businessShow'])->name('business.show');
    Route::get('/edit-business/{id?}', [BusinessController::class, 'businessEdit'])->name('business.edit');
    Route::post('/update-business', [BusinessController::class, 'businessUpdate'])->name('business.update');
    Route::any('/destroy-business/{id?}', [BusinessController::class, 'businessDestroy'])->name('business.destroy');
    Route::get('/status-business/{id?}', [BusinessController::class, 'businessStatus'])->name('business.status');
    // Service Category
    Route::get('/service-category-listing', [Service_CategoryController::class, 'service_category_index'])->name('service_category_index');
    Route::post('/store-service-category/{id?}', [Service_CategoryController::class, 'service_category_store'])->name('service_category_store');
    Route::get('/show-service-category/{id?}', [Service_CategoryController::class, 'service_category_show'])->name('service_category_show');
    Route::get('/edit-service-category/{id?}', [Service_CategoryController::class, 'service_category_edit'])->name('service_category_edit');
    Route::post('/update_service-category', [Service_CategoryController::class, 'service_category_update'])->name('service_category_update');
    Route::any('/destroy_service-category/{id?}', [Service_CategoryController::class, 'service_category_destroy'])->name('service_category_destroy');
    Route::get('/status-service_category}', [Service_CategoryController::class, 'service_category_status'])->name('service_category_status');
    // service
    Route::get('/service-listing', [ServiceController::class, 'services_index'])->name('services_index');
    Route::post('/store-service/{id?}', [ServiceController::class, 'services_store'])->name('services_store');
    Route::get('/show-service/{id?}', [ServiceController::class, 'services_show'])->name('services_show');
    Route::get('/edit-service/{id?}', [ServiceController::class, 'services_edit'])->name('services_edit');
    Route::post('/update_service', [ServiceController::class, 'services_update'])->name('services_update');
    Route::any('/destroy_service/{id?}', [ServiceController::class, 'services_destroy'])->name('services_destroy');
    Route::get('/status-service', [ServiceController::class, 'services_status'])->name('services_status');
    Route::get('/is_feature-service', [ServiceController::class, 'services_is_feature'])->name('services_is_feature');
    // user
    Route::get('/user-listing/{slug?}', [UserController::class, 'userIndex'])->name('user.index');
    // Route::post('/store-user/{id?}', [UserController::class, 'userStore'])->name('user.store');
    Route::post('/add-user', [UserController::class, 'addUser'])->name('add.user');
    Route::get('/show-user/{id?}', [UserController::class, 'show'])->name('user.show');
    Route::get('/edit-user/{id?}', [UserController::class, 'userEdit'])->name('user.edit');
    Route::post('/update_user', [UserController::class, 'userUpdate'])->name('user.update');
    Route::any('/destroy_user/{id?}', [UserController::class, 'userDestroy'])->name('user.destroy');
    Route::any('/export-user-report', [UserController::class, 'exportUsers'])->name('export.user.report');
    Route::get('/user-status/{id?}', [UserController::class, 'userStatus'])->name('user.status');
    Route::get('/is_pro_plus-user}', [UserController::class, 'users_is_pro_plus'])->name('users_is_pro_plus');

    Route::get('/user-account', [CustomAuthController::class, 'user_account'])->name('user_account');
    Route::get('/user-account_info', [CustomAuthController::class, 'user_account_info'])->name('user_account_info');
    Route::get('/user-change-password', [CustomAuthController::class, 'user_change_password'])->name('user_change_password');
    Route::post('/user-photo-update', [IndexController::class, 'upload_image'])->name('upload_image');
    Route::post('/user-cover-image-update', [IndexController::class, 'upload_cover_image'])->name('upload_cover_image');
});

Route::group(['prefix' => '/sale-person', 'middleware' => ['checkRole:sales_person']], function () {

    /**** Banner routes /*****/
//    Route::get('banner', [AdminBannerController::class, 'index']);
//    Route::post('banner', [AdminBannerController::class, 'store']);
//    Route::get('banner/{id}/delete', [AdminBannerController::class, 'delete']);
//    Route::post('banner/status/{id}', [AdminBannerController::class, 'update_status']);
    /**** Banner routes /*****/

    Route::get('/signout', [CustomAuthController::class, 'signout'])->name('signout');
    Route::get('dashboard', [AdminHomeController::class, 'dashboard'])->name('dashboard');
    // Business routes
    Route::get('/business-listing', [BusinessController::class, 'businessIndex'])->name('business.sales.index');
    Route::post('/store-business/{id?}', [BusinessController::class, 'businessStore'])->name('business.store');
    Route::get('/show-business/{id?}', [BusinessController::class, 'businessShow'])->name('business.show');
    Route::get('/edit-business/{id?}', [BusinessController::class, 'businessEdit'])->name('business.edit');
    Route::post('/update-business', [BusinessController::class, 'businessUpdate'])->name('business.update');
    Route::any('/destroy-business/{id?}', [BusinessController::class, 'businessDestroy'])->name('business.destroy');
    Route::any('/export-business-file', [BusinessController::class, 'exportBusinesses'])->name('export.business.report');
    Route::get('/status-business', [BusinessController::class, 'businessStatus'])->name('business.status');
    Route::any('/customized-members-send-mail/{id?}', [BusinessController::class, 'customizedMembersSendMail'])->name('customized.members.send.mail');

    // user
    Route::get('/user-listing', [UserController::class, 'userIndex'])->name('user.sales.index');
    // Route::post('/store-user/{id?}', [UserController::class, 'userStore'])->name('user.store');
    Route::post('/add-user', [UserController::class, 'addUser'])->name('add.user');
    Route::get('/show-detail/{id?}', [UserController::class, 'show'])->name('user.show');
    Route::get('/edit-user/{id?}', [UserController::class, 'userEdit'])->name('user.edit');
    Route::post('/update-user', [UserController::class, 'userUpdate'])->name('user.update');
    Route::any('/destroy-user/{id?}', [UserController::class, 'userDestroy'])->name('user.destroy');
    Route::any('/export-user-report', [UserController::class, 'exportUsers'])->name('export.user.report');
    Route::get('/status-user}', [UserController::class, 'userStatus'])->name('user.tatus');
    Route::get('/is_pro_plus-user}', [UserController::class, 'users_is_pro_plus'])->name('users_is_pro_plus');

    Route::get('/user-account', [CustomAuthController::class, 'user_account'])->name('user_account');
    Route::get('/user-account_info', [CustomAuthController::class, 'user_account_info'])->name('user_account_info');
    Route::get('/user-change-password', [CustomAuthController::class, 'user_change_password'])->name('user_change_password');
    Route::post('/user-photo-update', [IndexController::class, 'upload_image'])->name('upload_image');
    Route::post('/user-cover-image-update', [IndexController::class, 'upload_cover_image'])->name('upload_cover_image');
});

Route::get('get-messages', [MessageController::class, 'index']);
Route::post('send-message', [MessageController::class, 'sendMessage'])->name('send.message');
Route::post('pusher/send-message', [MessageController::class, 'sendMessage'])->name('pusher.send.message');

Route::get('message-index', [MessageController::class, 'index']);
Route::post('broadcast', [MessageController::class, 'broadcast'])->name('broadcast.message');
Route::post('receive', [MessageController::class, 'receive'])->name('receive.message');
