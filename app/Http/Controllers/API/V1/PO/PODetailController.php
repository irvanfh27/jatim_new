<?php

namespace App\Http\Controllers\API\V1\PO;

use App\Http\Controllers\Controller;
use App\Http\Resources\PODetailResource;
use App\Model\Configuration\GeneralVendor;
use App\Model\PO\PODetail;
use App\PO\POHDR;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PODetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $poDetail = new PODetail();

        if ($request->noPO) {
            $poDetail = $poDetail->where('no_po', $request->noPO);
        }
        $poDetail = $poDetail->get();

        return PODetailResource::collection($poDetail);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ppnStatus) {
            $pph = 0;
            $pphStatus = 0;
            $pph_id = 0;
        } else {
            $generalVendor = GeneralVendor::where('general_vendor_id', $request->vendorId)->first();
            $tax = DB::table('tax')->where('tax_id', $request->pph)->first();
            $pph = $request->amount / 100 * $tax->tax_value;
            $pphStatus = 1;
            $pph_id = $generalVendor->ppn_tax_id;
        }
        $input = $request->all();
        $input['entry_by'] = auth('api')->user()->id;
        $input['entry_date'] = date('Y-m-d h:i:s');
        $input['ppn_id'] = $pph_id;
        $input['pph'] = $pph;
        $input['uuid'] = Str::uuid();
        $input['pphStatus'] = $pphStatus;

        PODetail::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PODetail::where('uuid', $id)->delete();
    }

    public function ConfirmReceivePO(Request $request)
    {
        $po_details = $request->po_details;

        if ($request->checked) {
            POHDR::where('uuid', $request->uuid)->update([
                'status' => 5
            ]);
        }
        foreach ($po_details as $i => $detail) {
            PODetail::where('idpo_detail', $detail['id'])->update([
                'qty_confirm' => $detail['qty_confirm'],
                'receive_date' => $detail['receive_date'],
                'receiver' => $detail['receiver'],
            ]);
        }
    }
}
