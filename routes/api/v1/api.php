<?php

use App\Http\Controllers\CustomController;
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
// Route::get('file', 'FileController@fileDown');
// Route::get('photo', 'FileController@getPhoto');
// Route::resource('/photos', 'GalleryController');
// Route::get('/photos', 'GalleryController@getPhotos');
// Route::post('/photos', 'GalleryController@uploadPhotos');
// Route::delete('/photos', 'GalleryController@deletePhoto');
// Route::get('/logout', 'Auth\LoginController@logout');
// Route::get('{all?}', 'GalleryController@index')->where('all', '([A-z\d-\/_.]+)?');
// Route::get('search/{slug}', 'api\v1\UserController@searchByName');

Route::post('login', 'api\v1\UserController@login');
Route::post('register', 'api\v1\UserController@register');


// Route::resources([
//     'elements' => 'ElementController',

// ]);

//Get all default categories
Route::get('default-categories', 'DefaultCategoryController@index');


Route::group(['middleware' => 'auth:api'], function () {
    //user 

    Route::post('userAvatar', 'api\v1\UserController@uploadAvatar');
    Route::post('updateUser', 'api\v1\UserController@updateUser');
    Route::post('updatecategories', 'CategoryController@updateCategories');
    Route::post('singleCategories', 'CategoryController@singleCategories');




    Route::get('category', 'CategoryController@all');
    //custom
    Route::post('custom-category', 'CustomController@showByCategory');
    Route::post('custom-started', 'CustomController@firstCreate');
    //Category
    Route::resources([
        'customs' => 'CustomController',

    ]);
    Route::resources([
        'categorie' => 'CategoryController',

    ]);
    //Sub category
    Route::resources([
        'subcategories' => 'SubCategoryController',

    ]);
    //Elements
    Route::resources([
        'elements' => 'ElementController',

    ]);
    Route::post('elements/search', 'ElementController@showByTitle');




    // Route::resources([
    //     'customs' => 'ElementController',

    // ]);

    Route::post('upload', 'UploadController@uploadPhoto');
    Route::get('images', 'UploadController@getPhoto');
    Route::get('details', 'api\v1\UserController@details');

    Route::post('logout', 'api\v1\UserController@logout');
});
