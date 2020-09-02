<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('v1')->group(function () {
    Route::name('configuration.')->prefix('configuration')->namespace('API\\V1\\Configuration\\')->group(function () {
        Route::resources([
            'stockpiles' => 'StockpileController',
            'users' => 'UserController',
        ]);
    });

    Route::name('po.')->prefix('po')->namespace('PO\\')->group(function () {
        Route::resources([
            'uoms' => 'UomController',
        ]);
    });
});

