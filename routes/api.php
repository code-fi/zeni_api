<?php

use Illuminate\Http\Request;

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
Route::get('use', function(Request $request) {
    return  bcrypt("12345678");
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('test', 'Api\Admin\AdminLoginController@index');

Route::post('/login','Api\User\UserLoginController@index');
Route::post('/register','Api\User\UserRegistrationController@index');


Route::get('/logout','Api\User\UserProfileController@logout');
Route::get('/profile','Api\User\UserProfileController@show');
Route::put('/profile','Api\User\UserProfileController@edit');
Route::get('/sync-user','Api\User\UserProfileController@sync');

Route::get('/my-products','Api\User\UserProductsController@show');
Route::get('/my-product/{id}','Api\User\UserProductsController@get');

Route::post('/create-order', 'Api\ProductController@create_product_order');
Route::get('/my-orders','Api\User\UserOrdersController@show');
Route::get('/my-order/{id}','Api\User\UserOrdersController@get');


Route::post('/create-ad','Api\User\UserProductsController@create');
Route::post('/up-images/{id}','Api\User\UserProductsController@upload');

Route::get('/products/{action}','Api\ProductController@get');
Route::get('/product/{id}','Api\ProductController@detail');
Route::get('/similar/{id}/{category_id}','Api\ProductController@getSimilar');

Route::get('/market-components','Api\ProductController@load_market_components');
Route::get('/categories','Api\ProductCategoryController@index');
Route::get('/products-by-category','Api\ProductController@get_products_by_category');

Route::get('/feeds','Api\GeneralAppController@getFeeds');
Route::get('cities/{region_name}','Api\GeneralAppController@getCities');