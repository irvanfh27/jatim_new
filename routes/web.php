<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
//    return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
//    Configuration Route
    Route::name('configuration.')->prefix('configuration')->namespace('Configuration\\')->group(function () {
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


Route::name('js.')->group(function () {
    Route::get('dynamic.js', 'JsController@dynamic')->name('dynamic');
});
