<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

Route::prefix('v1')->namespace('API\\V1\\')->group(function () {

    /*
     * Configuration Route
     */
    Route::name('configuration.')->prefix('configuration')->namespace('Configuration\\')->group(function () {

        Route::resources([
            'stockpiles' => 'StockpileController',
            'users' => 'UserController',
            'freight-group' => 'FreightGroupController'
        ]);

        Route::get('currency', function () {
            return DB::table('currency')->get();
        });

        Route::get('general-vendor', function () {
            return DB::table('general_vendor')
                ->select('general_vendor_id', 'general_vendor_name')
                ->orderBy('general_vendor_name')
                ->get();
        });

        Route::get('general-vendor-bank', function (Request $request) {
            return DB::table('general_vendor_bank')
                ->select('gv_bank_id', DB::raw("CONCAT(bank_name,' - ',account_no) as bank_name"))
                ->where('general_vendor_id', $request->generalVendorId)
                ->get();
        });

        Route::get('shipment', function () {
            return DB::table('shipment')
                ->select('shipment_id', 'shipment_no')
                ->get();
        });

    });

    /**
     * PO ROUTE
     */
    Route::name('po.')->prefix('po')->namespace('PO\\')->group(function () {

        Route::patch('po-detail/confirm-receive-po', 'PODetailController@ConfirmReceivePO');

        Route::post('updateStatusPO', 'POController@updateStatusPO');
        //Get PO NO
        Route::get('getPONo', 'POController@getPONo');
        Route::resources([
            'po' => 'POController',
            'po-detail' => 'PODetailController',
            'sign' => 'MasterSignController',
        ]);
        //Group Item
        Route::get('group-item', function () {
            return DB::table('master_groupitem')->get();
        });

        Route::get('items', function (Request $request) {
            return DB::table('master_item')
                ->select('idmaster_item', DB::raw("CONCAT(item_name, ' ', item_code) AS item_full "))
                ->where('group_itemid', $request->groupItemId)
                ->orderBy('item_name')->get();
        });
        Route::get('/uom', function () {
            return DB::table('uom')->get();
        });

    });

    Route::get('general-vendor-pph', function (Request $request) {
        return DB::table('general_vendor_pph as acc')
            ->select('acc.pph_tax_id', 'tax.tax_name')
            ->leftJoin('tax', 'tax.tax_id', '=', 'acc.pph_tax_id')
            ->where('acc.general_vendor_id', $request->generalVendorId)
            ->get();
    });

    Route::get('vendor-ppn', function (Request $request) {
        $vendor = DB::table('general_vendor')
            ->select('general_vendor_id', 'ppn_tax_id')
            ->where('general_vendor_id', $request->generalVendorId)
            ->first();
        $ppnId = $vendor->ppn_tax_id;
        $tax = DB::table('tax')->select('tax_id', 'tax_value')->where('tax_id', $ppnId)->first();
        if (isset($tax)) {
            $data = [
                'tax_id' => $tax->tax_id,
                'tax_value' => $tax->tax_value,
            ];
        } else {
            $data = [
                'tax_id' => 0,
                'tax_value' => 0,
            ];
        }
        return response()->json($data);
    });


});

