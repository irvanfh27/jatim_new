<?php

namespace App\Http\Controllers\API\V1\PO;

use App\Http\Controllers\Controller;
use App\Model\Configuration\GeneralVendor;
use App\Model\PO\PODetail;
use App\PO\POHDR;
use Illuminate\Http\Request;
use App\PO\POHDR as PO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class POController extends Controller
{
    protected $forms;
    protected $rules;

    public function __construct()
    {

        $this->forms = [
            array('type' => 'text', 'label' => '', 'name' => '', 'place_holder' => '', 'mandatory' => true),
            array('type' => 'textarea', 'label' => '', 'name' => '', 'place_holder' => '', 'mandatory' => false),
            array('type' => 'select_option', 'label' => '', 'name' => '', 'variable' => '', 'option_value' => 'value', '' => 'label', 'mandatory' => true),
        ];

        $this->rules = [
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PO::all();
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
        $totalAll = 0;

        $poDetails = DB::select("SELECT pd.qty,pd.harga,pd.amount,(CASE WHEN pd.pphstatus = 1 THEN pd.pph ELSE 0 END) AS pph,(CASE WHEN pd.ppnstatus = 1 THEN pd.ppn ELSE 0 END) AS ppn,
    (pd.amount+(CASE WHEN pd.ppnstatus = 1 THEN pd.ppn ELSE 0 END)-(CASE WHEN pd.pphstatus = 1 THEN pd.pph ELSE 0 END)) AS grandtotal,idpo_detail
			FROM po_detail pd
			where no_po = '{$request->no_po}' ORDER BY idpo_detail ASC");

        foreach ($poDetails as $po) {
            $totalPPN += $po->ppn;
            $totalPPH += $po->pph;
            $totalAll += $po->grandtotal;
        }

        $input = $request->all();
        $input['no_po'] = $noPO;
        $input['uuid'] = Str::uuid();
        $input['entry_by'] = auth('api')->user()->id;
        $input['stockpile_id'] = auth('api')->user()->stockpile_id;
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
    public function show(PO $po)
    {
        return $po;
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
        $request->validate($this->rules);
        $input = $request->all();
        $input['updated_by'] = auth()->user()->id;
        PO::update($input);
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

}
