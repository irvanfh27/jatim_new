<?php

namespace App\Http\Controllers\API\V1\PO;

use App\Http\Controllers\Controller;
use App\Http\Resources\POResource;
use App\Http\Resources\POWithDetailResource;
use App\Model\Configuration\GeneralVendor;
use App\Model\PO\PODetail;
use App\PO\POHDR;
use Illuminate\Http\Request;
use App\Model\PO\POHDR as PO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class POController extends Controller
{
    protected $forms;
    protected $rules;

    public function __construct()
    {
        $this->rules = [
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $po = new PO();
        if ($request->status) {
            $po = $po->where('status', $request->status);
        }
        $po = $po->orderBy('entry_date', 'desc')->get();
        return POResource::collection($po);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $noPO = $this->getPONo();
        if ($request->no_po != $noPO) {
            PODetail::where('no_po', $request->no_po)->update([
                'no_po' => $noPO
            ]);
        }

//        $request->validate($this->rules);
        $totalPPN = 0;
        $totalPPH = 0;
        $totalDPP = 0;

        $poDetails = PODetail::where('no_po', $noPO)->get();

        foreach ($poDetails as $po) {
            $totalDPP += $po->amount;
            $totalPPN += $po->ppn;
            $totalPPH += $po->pph;
        }
        $totalAll = $totalDPP + ($totalPPN - $totalPPH);
        $input = $request->all();
        $input['no_po'] = $noPO;
        $input['uuid'] = Str::uuid();
        $input['entry_by'] = auth('api')->user()->id;
        $input['stockpile_id'] = auth('api')->user()->stockpile_id;
        $input['grandtotal'] = $totalDPP;
        $input['totalppn'] = $totalPPN;
        $input['totalpph'] = $totalPPH;
        $input['totalall'] = $totalAll;

        PO::create($input);

    }

    /**
     * Display the specified resource.
     *
     * @param PO $po
     * @return void
     */
    public function show($uuid)
    {
        return new POWithDetailResource(PO::where('uuid', $uuid)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $po)
    {
        $input = $request->all();
        $input['updated_by'] = auth('api')->user()->id;
        $input['status'] = 0;
        PO::findOrFail($po)->update($input);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PO::where('uuid', $id)->delete();
    }

    public function getPONo()
    {
        $stockpileName = isset(auth('api')->user()->stockpile_code) ? auth('api')->user()->stockpile_code : 'JAM';

        $yearMonth = date('ym');

        $checkPONo = 'PO-' . $stockpileName . '/' . $yearMonth;
        $lastPO = POHDR::where('no_po', 'like', '%' . $checkPONo . '%')->orderBy('idpo_hdr', 'DESC')->first();
        if (isset($lastPO)) {
            $splitPONo = explode('/', $lastPO->no_po);
            $lastExplode = count($splitPONo) - 1;
            $nextPONo = ((float)$splitPONo[$lastExplode]) + 1;
            $PO_number = $checkPONo . '/' . $nextPONo;
        } else {
            $PO_number = $checkPONo . '/1';
        }
        return $PO_number;
    }

    public function listPODetail(Request $request)
    {
        $poDetail = DB::select("SELECT no_po,a.account_name,i.item_name,pd.qty,pd.harga,pd.amount,
	(CASE WHEN pd.pphstatus = 1 THEN pd.pph ELSE 0 END) AS pph,
	(CASE WHEN pd.ppnstatus = 1 THEN pd.ppn ELSE 0 END) AS ppn,
    (pd.amount+(CASE WHEN pd.ppnstatus = 1 THEN pd.ppn ELSE 0 END)-(CASE WHEN pd.pphstatus = 1 THEN pd.pph ELSE 0 END)) AS grandtotal,
		idpo_detail,s.`name` as stockpile, sh.`shipment_no`
			FROM po_detail pd
			LEFT JOIN master_item i ON i.idmaster_item = pd.item_id
            LEFT JOIN master_groupitem g ON g.idmaster_groupitem = i.group_itemid
            LEFT JOIN account a ON a.account_id = g.account_id
            LEFT JOIN stockpiles s ON s.`stockpile_id` = pd.`stockpile_id`
            LEFT JOIN shipment sh ON sh.`shipment_id` = pd.`shipment_id`
			where no_po = '{$request->noPO}' ORDER BY idpo_detail ASC");

        return $poDetail;
//        return PODetail::where('no_po', $request->noPO)
//            ->where('entry_by', auth('api')->user()->id)
//            ->get();
    }

    public function insertPODetail(Request $request)
    {
//        return $request->all();
        if ($request->pph === 0) {
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

    public function updateStatusPO(Request $request)
    {
        $po = PO::where('uuid', $request->uuid);
        if ($request->status == 1) {
            $po->update([
                'status' => $request->status,
                'approved_date' => now()
            ]);
        } else {
            $po->update([
                'status' => $request->status
            ]);
        }

        if ($po) {
            $status = true;
        } else {
            $status = false;
        }

        return response()->json([
            'success' => $status
        ]);
    }
}
