<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Route::get('/', [IndexController::class, 'index'])->name('welcome');
Route::get('/rent', [IndexController::class, 'shop'])->name('rent');
Route::get('/category/{slug}', [IndexController::class, 'category'])->name('category');
Route::get('/category/{id}/detail', [IndexController::class, 'categoryDetails'])->name('category.detail');
Route::get('/reviews', [IndexController::class, 'reviews'])->name('reviews');
Route::get('/about-us', [IndexController::class, 'about_us'])->name('about_us');
Route::get('/products', [IndexController::class, 'product'])->name('product');
Route::get('/product-details/{id?}', [IndexController::class, 'product_details'])->name('product_details');
Route::get('/product-request/{id?}', [IndexController::class, 'product_request'])->name('product_request');
Route::post('/product-request', [IndexController::class, 'ProductRequest'])->name('ProductRequest');
Route::get('/date', [IndexController::class, 'date'])->name('date');
Route::get('/contact-us', [IndexController::class, 'contact'])->name('contact_us');
Route::post('/contact-us-submit', [IndexController::class, 'contactusSubmit'])->name('contactusSubmit');
Route::post('/newslettersubmit', [IndexController::class, 'newslettersubmit'])->name('newslettersubmit');
Route::get('/privacy-policy', [IndexController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/terms-and-condition', [IndexController::class, 'termsCondition'])->name('termsCondition');
Route::get('/checkout', [IndexController::class, 'checkout'])->name('checkout');
Route::get('/thankyou', [IndexController::class, 'thankyou'])->name('thankyou');
Route::get('/thank-you/{oid?}', [IndexController::class, 'thank_you'])->name('thank_you');
Route::get('/payout/{id}', [IndexController::class, 'payout'])->name('payout');
Route::post('/user-photo-update', [IndexController::class, 'upload_image'])->name('upload_image');
Route::post('/user-cover-image-update', [IndexController::class, 'upload_cover_image'])->name('upload_cover_image');
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
Route::get('/user-account', [CustomAuthController::class, 'user_account'])->name('user_account');
Route::get('/user-account_info', [CustomAuthController::class, 'user_account_info'])->name('user_account_info');
Route::get('/user-change-password', [CustomAuthController::class, 'user_change_password'])->name('user_change_password');
Route::get('/login', [CustomAuthController::class, 'signin'])->name('login');
// Route::get('/register', [CustomAuthController::class, 'signup'])->name('register');
Route::get('/register/{id?}/{businessTypeId?}/{businessType?}', [CustomAuthController::class, 'signup'])->name('register');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::post('/custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::any('/user-add-custom-business/{id?}', [CustomAuthController::class, 'userAddBusinessBehalfBusinessType'])->name('user.add.custom.business');
Route::get('/signout', [CustomAuthController::class, 'signout'])->name('signout');
// web cms
Route::get('/edit_web_cms/{id?}', [IndexController::class, 'web_cms_edit'])->name('web_cms_edit');
Route::post('/update_web_cms', [IndexController::class, 'web_cms_update'])->name('web_cms_update');

Route::get('admin/login', function(){ return view('admin.login'); })->name('admin.login');
Route::post('admin/loginsubmit', [AuthenticationController::class, 'admin_authentication']);

Route::middleware(['web', 'auth'])->group(function () {
    Route::group(['prefix' => '/dashboard', 'middleware' => ['customer']], function () {
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
        Route::get('/business-listing', [BusinessController::class, 'businessIndex'])->name('business.index');
        Route::post('/store-business/{id?}', [BusinessController::class, 'businessStore'])->name('business.store');
        Route::get('/show-business/{id?}', [BusinessController::class, 'businessShow'])->name('business.show');
        Route::get('/edit-business/{id?}', [BusinessController::class, 'businessEdit'])->name('business.edit');
        Route::post('/update-business', [BusinessController::class, 'businessUpdate'])->name('business.update');
        Route::any('/destroy-business/{id?}', [BusinessController::class, 'businessDestroy'])->name('business.destroy');
        Route::get('/status-business', [BusinessController::class, 'businessStatus'])->name('business.status');
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
        Route::get('/user-listing', [UserController::class, 'userIndex'])->name('user.index');
        // Route::post('/store-user/{id?}', [UserController::class, 'userStore'])->name('user.store');
        Route::post('/add-user', [UserController::class, 'userAddByAdmin'])->name('add.user');
        Route::get('/show-user/{id?}', [UserController::class, 'show'])->name('user.show');
        Route::get('/edit-user/{id?}', [UserController::class, 'userEdit'])->name('user.edit');
        Route::post('/update_user', [UserController::class, 'userUpdate'])->name('user.update');
        Route::any('/destroy_user/{id?}', [UserController::class, 'userDestroy'])->name('user.destroy');
        Route::any('/export-user-report', [UserController::class, 'exportUsers'])->name('export.user.report');
        Route::get('/status-user}', [UserController::class, 'userStatus'])->name('user.tatus');
        Route::get('/is_pro_plus-user}', [UserController::class, 'users_is_pro_plus'])->name('users_is_pro_plus');
    });

    Route::group(['prefix' => '/sale-person', 'middleware' => ['checkRole:sales_person']], function () {
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
        Route::post('/add-user', [UserController::class, 'userAddByAdmin'])->name('add.user');
        Route::get('/show-detail/{id?}', [UserController::class, 'show'])->name('user.show');
        Route::get('/edit-user/{id?}', [UserController::class, 'userEdit'])->name('user.edit');
        Route::post('/update-user', [UserController::class, 'userUpdate'])->name('user.update');
        Route::any('/destroy-user/{id?}', [UserController::class, 'userDestroy'])->name('user.destroy');
        Route::any('/export-user-report', [UserController::class, 'exportUsers'])->name('export.user.report');
        Route::get('/status-user}', [UserController::class, 'userStatus'])->name('user.tatus');
        Route::get('/is_pro_plus-user}', [UserController::class, 'users_is_pro_plus'])->name('users_is_pro_plus');
    });
});

Route::middleware(['auth'])->group(function () {
	Route::get('dashboard', [AdminHomeController::class, 'dashboard'])->name('dashboard');
    // Route::get('category', [AdminHomeController::class, 'category_index'])->name('category');
    /**** Banner routes /*****/
    Route::get('banner', [AdminBannerController::class, 'index']);
    Route::post('banner', [AdminBannerController::class, 'store']);
    Route::get('banner/{id}/delete', [AdminBannerController::class, 'delete']);
    Route::post('banner/status/{id}', [AdminBannerController::class, 'update_status']);
    /**** Banner routes /*****/
    // Route::get('logout', [AdminHomeController::class, 'logout']);
    // logo
});
Route::get('get-messages', [MessageController::class, 'index']);
Route::post('send-message', [MessageController::class, 'sendMessage'])->name('send.message');
Route::post('pusher/send-message', [MessageController::class, 'sendMessage'])->name('pusher.send.message');

Route::get('message-index', [MessageController::class, 'index']);
Route::post('broadcast', [MessageController::class, 'broadcast'])->name('broadcast.message');
Route::post('receive', [MessageController::class, 'receive'])->name('receive.message');
