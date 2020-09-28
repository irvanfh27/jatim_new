<?php

namespace App\Http\Controllers\API\V1\PO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupItemController extends Controller
{
    protected $forms;
    protected $rules;
    protected $accounts;

    public function __construct()
    {
        $this->accounts = Account::select('account_id', 'account_name')->get();
        $this->forms = [
            array('type' => 'select_option', 'label' => 'Account', 'name' => 'account_id', 'variable' => 'accounts', 'option_value' => 'account_id', 'option_text' => 'account_name', 'mandatory' => true),
        ];
        $this->rules = [
            'account_id' => 'required'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->type = 'option') {
            $data = MasterGroupItem::select('')->get();
        } else {
            $data = MasterGroupItem::all();
        }

        return $data;

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
            'route' => route('po.group-items.store'),
            'method' => 'POST'
        ];

        return view('layouts.create-edit', [
            'config' => $config,
            'forms' => $this->forms,
            'accounts' => $this->accounts
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
        $input['name'] = Account::findOrFail($request->account_id)->account_name;
        $input['created_by'] = auth()->user()->id;
        MasterGroupItem::create($input);

        return redirect()->route('po.group-items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\MasterGroupItem $masterGroupItem
     * @return \Illuminate\Http\Response
     */
    public function show(MasterGroupItem $groupItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\MasterGroupItem $groupItem
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterGroupItem $groupItem)
    {
        $config = [
            'title' => 'Edit MasterGroupItem',
            'size' => 8,
            'route' => route('po.group-items.update', $groupItem),
            'method' => 'PATCH'
        ];

        $data = $groupItem;

        return view('layouts.create-edit', [
            'config' => $config,
            'forms' => $this->forms,
            'data' => $data,
            'accounts' => $this->accounts
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\MasterGroupItem $groupItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterGroupItem $groupItem)
    {
        $request->validate($this->rules);
        $input = $request->all();
        $input['name'] = Account::findOrFail($request->account_id)->account_name;
        $input['updated_by'] = auth()->user()->id;
        $groupItem->update($input);
        return redirect()->route('po.group-items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\MasterGroupItem $groupItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterGroupItem $groupItem)
    {
        $groupItem->delete();
        return redirect()->route('.index');
    }
}
