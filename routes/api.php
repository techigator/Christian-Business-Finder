<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ShopController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize');
    Artisan::call('route:clear');
    dd("Cache is cleared");
});

// Route::post('add-notifications', [UserController::class, 'addNotifications']);
// Route::get('get-suggestion', [UserController::class, 'getSuggestion']);

// google-map
Route::post('search-places', [UserController::class, 'searchPlaces']);

// category
Route::get('get-category', [UserController::class, 'getCategory']);

// Business
Route::post('add-buisness', [UserController::class, 'addBusiness']);
Route::get('get-business-by-category/{id}', [UserController::class, 'getBusiness']);
//Route::get('get-business-by-category/{id}', [UserController::class, 'getBusinessByCategory']);

// comment by adil
// Route::get('get-buisness-by-id/{id?}', [UserController::class, 'getBuisnessById']);

Route::post('register', [UserController::class, 'register']);
Route::post('social-media-register', [UserController::class, 'SocialMediaRegister']);
Route::post('login', [UserController::class, 'authenticate']);
Route::post('forget-password-email', [UserController::class, 'ForgetPasswordEmail']);
Route::post('valid-email', [UserController::class, 'ValidEmail']);
Route::post('check-valid-email-code', [UserController::class, 'CheckValidEmailCodeVerification']);
Route::post('check-forget-password-code', [UserController::class, 'checkForgetPasswordCodeVerification']);
Route::post('update-forget-password', [UserController::class, 'updateForgetPassword']);


Route::middleware(['auth:api'])->group(function () {

// User
    Route::post('update-info', [UserController::class, 'updateProfileInfo']);
    Route::get('user/{user_id}', [UserController::class, 'GetUser']);
    Route::post('change-password', [UserController::class, 'changePassword']);
    Route::get('user-type-change/{user_type}', [UserController::class, 'UserTypeChange']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::post('update-profile', [UserController::class, 'updateProfileImage']);

// business get with rating or user flag
    Route::get('get-buisness-by-id/{id?}', [UserController::class, 'getBusinessById']);

// Church
    Route::post('add-church', [UserController::class, 'addChurch']);
    Route::get('get-church', [UserController::class, 'getChurch']);

// Suggestion
    Route::post('add-suggestion', [UserController::class, 'addSuggestion']);
    Route::get('get-suggestion', [UserController::class, 'getSuggestion']);

// Find by church
    Route::post('find-by-church', [UserController::class, 'findByChurch']);

// Likes
    Route::post('add-likes', [UserController::class, 'addLikes']);
    Route::get('get-likes', [UserController::class, 'getLikes']);
    Route::post('delete-like', [UserController::class, 'deleteLike']);

// Product
    Route::post('create-product', [ShopController::class, 'CreateProduct']);
    Route::post('update-product', [ShopController::class, 'UpdateProduct']);
    Route::get('my-product/{user_id}', [ShopController::class, 'MyProduct']);
    Route::get('latest-products', [ShopController::class, 'LatestProducts']);
    Route::get('categories', [ShopController::class, 'Categories']);
    Route::get('category/{slug}', [ShopController::class, 'CategoryProducts']);
    Route::post('search-products', [ShopController::class, 'SearchProducts']);
    Route::get('tag-search-products', [ShopController::class, 'TagSearchProducts']);
    Route::get('product-details/{product_id}', [ShopController::class, 'Product_Details']);
    Route::post('product-status-change', [ShopController::class, 'ProductStatusChange']);
    Route::get('product-delete/{product_id}', [ShopController::class, 'ProductDelete']);

// Reviews
    Route::post('review', [ShopController::class, 'CreateReview']);
    Route::get('review/{post_id}', [ShopController::class, 'GetAllReview']);
    Route::post('product-review', [ShopController::class, 'CreateProductReview']);
    Route::get('product-review/{post_id}', [ShopController::class, 'GetAllProductReview']);

// Product Request
    Route::post('product-request', [ShopController::class, 'ProductRequest']);
    Route::get('product-request/{product_request_id}/{productaction}', [ShopController::class, 'ProductAction']);
    Route::get('my-product-requests', [ShopController::class, 'MyProductRequest']);
    Route::post('product-request-pickup-time-edit', [ShopController::class, 'ProductRequestPickupTimeChange']);
    Route::get('my-product-requests-notifications', [ShopController::class, 'MyProductRequestNotifications']);
    Route::get('my-order-product-requests', [ShopController::class, 'MyOrderProductRequest']);
    Route::get('my-product-requests-notifications/{notification_id}/{notificationaction}', [ShopController::class, 'NotificationAction']);
    Route::get('product-request-delete/{product_request_id}', [ShopController::class, 'ProductRequestDelete']);
    Route::get('notification-delete/{notifications_id}', [ShopController::class, 'NotificationDelete']);
    Route::post('product-received', [ShopController::class, 'ProductRequestReceived']);
    Route::post('product-return', [ShopController::class, 'ProductRequestReturn']);

// add images
    Route::post('add-images', [ShopController::class, 'addImages']);

// Rating Give To Business
    Route::post('rate-business', [ShopController::class, 'rateBusiness']);

// strip responds
    Route::post('strip-intent-responds', [ShopController::class, 'StripIntentResponds']);
});
