<?php

namespace App\Http\Controllers\PO;

use App\Http\Controllers\Controller;
use App\Model\PO\MasterSign;
use Illuminate\Http\Request;

class MasterSignController extends Controller
{
    protected $forms;
    protected $rules;

    public function __construct()
    {
        $this->forms = [
            array('type' => 'text', 'label' => 'Name', 'name' => 'name', 'place_holder' => '', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Jabatan', 'name' => 'jabatan', 'place_holder' => '', 'mandatory' => true),
        ];

        $this->rules = [
            'name' => 'required',
            'jabatan' => 'required'
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
            'title' => 'Sign',
            'route-add' => 'po.signs.create',
            'route-edit' => 'po.signs.edit',
            'route-delete' => 'po.signs.destroy'
        ];

        $columns = [
            array('title' => 'Name', 'field' => 'name'),
            array('title' => 'Jabatan', 'field' => 'jabatan'),
        ];

        $data = MasterSign::all();

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
            'title' => 'Create Sign',
            'size' => 8,
            'route' => route('po.signs.store'),
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
        MasterSign::create($input);

        return redirect()->route('po.signs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\MasterSign $sign
     * @return \Illuminate\Http\Response
     */
    public function show(MasterSign $sign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\MasterSign $sign
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterSign $sign)
    {
        $config = [
            'title' => 'Edit Sign',
            'size' => 8,
            'route' => route('po.signs.update', $sign),
            'method' => 'PATCH'
        ];

        $data = $sign;

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
     * @param \App\MasterSign $sign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterSign $sign)
    {
        $request->validate($this->rules);
        $input = $request->all();
        $input['updated_by'] = auth()->user()->id;
        $sign->update($input);
        return redirect()->route('po.signs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\MasterSign $sign
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterSign $sign)
    {
        $sign->delete();
        return redirect()->route('po.signs.index');
    }
}
