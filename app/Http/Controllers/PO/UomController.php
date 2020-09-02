<?php

namespace App\Http\Controllers\PO;

use App\Http\Controllers\Controller;
use App\Model\PO\Uom;
use Illuminate\Http\Request;

class UomController extends Controller
{
    protected $forms;
    protected $rules;

    public function __construct()
    {
        $this->forms = [
            array('type' => 'text', 'label' => 'Uom', 'name' => 'uom_type', 'place_holder' => '', 'mandatory' => true),
        ];

        $this->rules = [
            'uom_type' => 'required'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = [
            'title' => 'Uom',
            'route-add' => 'po.uoms.create',
            'route-edit' => 'po.uoms.edit',
            'route-delete' => 'po.uoms.destroy'
        ];

        $columns = [
            array('title' => 'Uom', 'field' => 'uom_type'),
        ];

        $data = Uom::all();

        return view('layouts.datatable', compact(['config', 'columns', 'data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $config = [
            'title' => 'Create ',
            'size' => 8,
            'route' => route('po.uoms.store'),
            'method' => 'POST'
        ];

        return view('layouts.create-edit', [
            'config' => $config,
            'forms' => $this->forms,
        ]);
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
        Uom::create($input);

        return redirect()->route('po.uoms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Uom $uom
     * @return \Illuminate\Http\Response
     */
    public function show(Uom $uom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Uom $uom
     * @return \Illuminate\Http\Response
     */
    public function edit(Uom $uom)
    {
        $config = [
            'title' => 'Edit Uom',
            'size' => 8,
            'route' => route('po.uoms.update', $uom),
            'method' => 'PATCH'
        ];

        $data = $uom;

        return view('layouts.create-edit', [
            'config' => $config,
            'forms' => $this->forms,
            'data' => $data
        ]);
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
        $uom->update($input);
        return redirect()->route('po.uoms.index');
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
        $uom->delete();
        return redirect()->route('po.uoms.index');
    }
}
