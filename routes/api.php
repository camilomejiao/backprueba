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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
  //return $request->user();
//});

Route::get('folders/allFolders', 'FoldersControllers@allFolders');
Route::post('register', 'UsersControllers@register');
Route::post('login', 'UsersControllers@login');
Route::post('logingoogle', 'UsersControllers@logingoogle');

Route::middleware('auth:api')->group( function () {

});

Route::resource('users','UsersControllers', [ 'only' => ['index', 'store', 'show', 'update', 'destroy'] ]);
Route::resource('folders','FoldersControllers', [ 'only' => ['index', 'store', 'show', 'update', 'destroy'] ]);

