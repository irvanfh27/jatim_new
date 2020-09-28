<?php

namespace App\Http\Controllers\API\V1\PO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->type == 'option') {
            $data = Uom::select('uom_id', 'uom_type')->get();

        } else {
            $data = Uom::all();
        }
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
        $request->validate($this->rules);
        $input = $request->all();
        $input['created_by'] = auth()->user()->id;
        $uom = Uom::create($input);

        if ($uom) {
            $status = true;
        } else {
            $status = false;
        }
        return response()->json([
            'success' => $status
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Uom $uom
     * @return \Illuminate\Http\Response
     */
    public function show(Uom $uom)
    {
        return $uom;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Uom $uom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Uom $uom)
    {
        $request->validate($this->rules);
        $input = $request->all();
        $input['updated_by'] = auth()->user()->id;
        $uom = $uom->update($input);

        if ($uom) {
            $status = true;
        } else {
            $status = false;
        }
        return response()->json([
            'success' => $status
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Uom $uom
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Uom $uom)
    {
        $uom = $uom->delete();
        
        if ($uom) {
            $status = true;
        } else {
            $status = false;
        }
        return response()->json([
            'success' => $status
        ]);
    }
}
