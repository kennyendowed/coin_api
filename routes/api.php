<?php


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

// Route::get('/clear', function() {
//
//     Artisan::call('cache:clear');
//     Artisan::call('config:clear');
//     Artisan::call('view:clear');
//    Artisan::call('route:clear');
//    Artisan::call('config:cache');
//   Artisan::call('optimize');
//    return "Cleared!";
//
// })->middleware('auth.apikey');
Route::get('/clear', 'TokenController@clearRoute');
Route::group(['middleware' => 'auth.apikey'], function () {
//POST REQUEST
Route::post('/signUp', 'AuthController@signUp');
Route::post('/signin', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
Route::post('/refresh', 'TokenController@refresh');
Route::post('/rate', 'BlockchainController@getrate');
Route::post('/convert', 'BlockchainController@contobtc');
Route::post('/me', 'TokenController@me');
Route::post('/payload', 'TokenController@payload');
Route::post('/invalidate', 'TokenController@invalidate');

//GET REQUEST
Route::get('/Authorization/{id?}', 'AuthController@Authorization')->name('Authorization');





//jwt authentication
Route::group(['middleware' => 'jwt.verify'], function () {
Route::group(['middleware'=>'check-permission:customer'], function () {


Route::get('/customer/wallets/{type?}', 'WalletsController@show');
Route::get('/customer/profile', 'CustomerController@show');
Route::get('/customer/cards', 'CustomerController@showcards');
Route::get('/transactions/recentTransactions', 'TransactionsController@index');

    //POST REQUEST
    Route::post('/customer/sendmoney', 'BlockchainController@sendbitcoin');



    Route::patch('/customer/profile', 'CustomerController@update');
    Route::post('/customer/cards/add/{customerId?}', 'CustomerController@store');
    Route::patch('/customer/authorization', 'CustomerController@authupdate');
    Route::post('/customer/authorization', 'CustomerController@createt');
    Route::delete('/articles/{article}', 'ArticleController@delete');




  });

});


});
