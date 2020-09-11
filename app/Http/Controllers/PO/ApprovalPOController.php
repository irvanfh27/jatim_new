<?php

namespace App\Http\Controllers\PO;

use App\Http\Controllers\Controller;
use App\PO\POHDR as PO;
use Illuminate\Http\Request;

class ApprovalPOController extends Controller
{
    public function index()
    {
        $config = [
            'title' => 'Approval PO',
            'route-add' => '',
            'route-delete' => 'po.approval.destroy',
            'route-custom' => [
                'class' => 'badge-info',
                'route-name' => 'po.approval.print',
                'parameter' => 'uuid',
                'title' => 'Print',
                'icon' => 'fa-print',
                'target' => 'blank'
            ]
        ];

        $columns = [
            array('title' => 'Stockpile', 'field' => 'stockpile_name'),
            array('title' => 'Nomor PO', 'field' => 'no_po'),
            array('title' => 'Tanggal', 'field' => 'tanggal'),
            array('title' => 'Vendor', 'field' => 'general_vendor_name'),
            array('title' => 'No Penawaran', 'field' => 'no_penawaran'),
            array('title' => 'Grand Total', 'field' => 'grandtotal', 'type' => 'number'),
            array('title' => 'Status', 'field' => 'status_po'),
        ];

        $data = PO::orderBy('idpo_hdr', 'desc')->get();

        return view('layouts.datatable', compact(['config', 'columns', 'data']));
    }

    public function printApprovalPO(Request $request)
    {
        return PO::findOrfail($request->id);
    }
}
