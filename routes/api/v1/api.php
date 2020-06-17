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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'api\v1\UserController@login');
Route::post('register', 'api\v1\UserController@register');
Route::get('search/{slug}', 'api\v1\UserController@searchByName');




Route::group(['middleware' => 'auth:api'], function () {
    Route::get('details', 'api\v1\UserController@details');

    Route::post('logout', 'api\v1\UserController@logout');
});
