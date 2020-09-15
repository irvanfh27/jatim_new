<?php

namespace App\Http\Controllers\API\V1\Configuration;

use App\Http\Controllers\Controller;
use App\Model\Configuration\FreightGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FreightGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $data = FreightGroup::all();
        return $data;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['entry_by'] = 1;
        $insert = FreightGroup::create($data);

        if ($insert) {
            $status = 'sukses';
        } else {
            $status = 'fail';
        }
        return response()->json([
            'status' => $status
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return FreightGroup::where('freight_group_id', $id)->first();
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
        $data = request()->all();

        $fg = FreightGroup::findOrFail($id);
        $fg->update($data);

        if ($fg) {
            $status = 'sukses';
        } else {
            $status = 'fail';
        }

        return response()->json([
            'status' => $status
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fg = FreightGroup::findOrFail($id)->delete();
        if ($fg) {
            $status = 'sukses';
        } else {
            $status = 'fail';
        }

        return response()->json([
            'status' => $status
        ]);
    }
}
