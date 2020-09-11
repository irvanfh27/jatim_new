<?php

namespace App\Http\Controllers\API\V1\PO;

use App\Http\Controllers\Controller;
use App\PO\POHDR;
use Illuminate\Http\Request;
use App\PO\POHDR as PO;
use Illuminate\Support\Facades\DB;


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
        $request->validate($this->rules);
        $input = $request->all();
        $input['created_by'] = auth()->user()->id;
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
        $stockpileName = auth('api')->user()->stockpile_code;

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

    public function insertPODetail(Request $request)
    {
        $input = $request->all();
        $input['entry_by'] = auth('api')->user()->id;
        $input['entry_date'] = date('Y-m-d h:i:s');

        DB::table('po_detail')->insert($input);
    }
}
