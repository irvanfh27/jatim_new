<?php

namespace App\Http\Controllers\PO;

use App\Http\Controllers\Controller;
use App\PO\POHDR as PO;
use Illuminate\Http\Request;

class POController extends Controller
{
    protected $forms;
    protected $rules;

    public function __construct()
    {
        $this->forms = [
            array('type' => 'text', 'label' => '', 'name' => '', 'place_holder' => '', 'mandatory' => true),
            array('type' => 'textarea', 'label' => '', 'name' => '', 'place_holder' => '', 'mandatory' => false),
            array('type' => 'select_option', 'label' => '', 'name' => '', 'variable' => '', 'option_value' => 'value', 'option_text' => '', 'mandatory' => true),
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
        $config = [
            'title' => 'PO',
            'route-add' => 'po.po.create',
            'route-edit' => 'po.po.edit',
            'route-delete' => 'po.po.destroy'
        ];

        $columns = [
            array('title' => 'Stockpile', 'field' => 'stockpile_name'),
            array('title' => 'Nomor PO', 'field' => 'no_po'),
            array('title' => 'Tanggal', 'field' => 'tanggal'),
            array('title' => 'Vendor', 'field' => 'general_vendor_name'),
            array('title' => 'No Penawaran', 'field' => 'no_penawaran'),
            array('title' => 'DPP', 'field' => 'grandtotal', 'type' => 'number'),
            array('title' => 'PPN', 'field' => 'totalppn', 'type' => 'number'),
            array('title' => 'PPH', 'field' => 'totalpph', 'type' => 'number'),
            array('title' => 'Total', 'field' => 'totalall', 'type' => 'number'),
            array('title' => 'Status', 'field' => 'status_po'),
        ];

        $data = PO::all();

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
            'route' => route('po.po.store'),
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
        PO::create($input);

        return redirect()->route('po.po.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\PO $pO
     * @return \Illuminate\Http\Response
     */
    public function show(PO $po)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\PO $po
     * @return \Illuminate\Http\Response
     */
    public function edit(PO $po)
    {
        $config = [
            'title' => 'Edit PO',
            'size' => 8,
            'route' => route('po.po.update', $po),
            'method' => 'PATCH'
        ];

        $data = $po;

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
     * @param \App\PO $po
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PO $po)
    {
        $request->validate($this->rules);
        $input = $request->all();
        $input['updated_by'] = auth()->user()->id;
        $po->update($input);
        return redirect()->route('po.po.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PO $po
     * @return \Illuminate\Http\Response
     */
    public function destroy(PO $po)
    {
        PO::where('', $po)->delete();
        return redirect()->route('po.po.index');
    }
}
