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
Route::post('upload', 'IngestCSVController@upload');
Route::get('status', 'IngestCSVController@index');
Route::get('download/{status}', 'IngestCSVController@show'); // either success or failure
    
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
