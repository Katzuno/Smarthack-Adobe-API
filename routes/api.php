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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/generateToken', 'SiteIdentificationController@generateToken');
Route::post('/updateSite', 'SiteIdentificationController@updateSite');

Route::post('/getSiteInfo/{token}', 'SiteIdentificationController@getSiteInfo');
Route::post('/getAllVersions/{token}', 'SiteIdentificationController@getAllVersions');
Route::get('/getVersionById/{versionId}', 'SiteIdentificationController@getVersionById');


Route::post('/extractImageData', 'ImageProcessingController@extractImageLabel');
