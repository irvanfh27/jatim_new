<?php

namespace App\Http\Controllers\API\V1\PO;

use App\Http\Controllers\Controller;
use App\Model\PO\MasterSign;
use Illuminate\Http\Request;

class MasterSignController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MasterSign::all();
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
            'route' => route('.store'),
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

        return redirect()->route('.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\MasterSign $masterSign
     * @return \Illuminate\Http\Response
     */
    public function show(MasterSign $masterSign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\MasterSign $masterSign
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterSign $masterSign)
    {
        $config = [
            'title' => 'Edit MasterSign',
            'size' => 8,
            'route' => route('.update', $masterSign),
            'method' => 'PATCH'
        ];

        $data = $masterSign;

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
     * @param \App\MasterSign $masterSign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterSign $masterSign)
    {
        $request->validate($this->rules);
        $input = $request->all();
        $input['updated_by'] = auth()->user()->id;
        $masterSign->update($input);
        return redirect()->route('.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\MasterSign $masterSign
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterSign $masterSign)
    {
        MasterSign::where('', $masterSign)->delete();
        return redirect()->route('.index');
    }
}
