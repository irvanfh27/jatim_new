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

Route::get('/home', function () {
//    return view('welcome');
    return redirect('/dashboard');
});
Route::get('/', function () {
//    return view('welcome');
    return redirect('/login');
});
Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/dashboard/{any}', 'HomeController@index')->where('any', '.*');

Route::name('po.')->prefix('po')->namespace('PO\\')->group(function () {
    Route::get('approval/print', 'ApprovalPOController@printApprovalPO')->name('approval.print');
    Route::resources([
        'uoms' => 'UomController',
        'group-items' => 'MasterGroupItemController',
        'items' => 'MasterItemController',
        'signs' => 'MasterSignController',
    ]);
});


Route::name('js.')->group(function () {
    Route::get('dynamic.js', 'JsController@dynamic')->name('dynamic');
});
