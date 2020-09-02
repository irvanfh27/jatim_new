<?php

namespace App\Http\Controllers\PO;

use App\Http\Controllers\Controller;
use App\Model\PO\MasterGroupItem;
use App\Model\PO\MasterItem;
use App\Model\PO\Uom;
use Illuminate\Http\Request;

class MasterItemController extends Controller
{
    protected $forms;
    protected $rules;
    protected $groupItems;
    protected $uoms;

    public function __construct()
    {
        $this->groupItems = MasterGroupItem::select('idmaster_groupitem', 'name')->get();
        $this->uoms = Uom::select('id_uom', 'uom_type')->get();

        $this->forms = [
            array('type' => 'select_option', 'label' => 'Group Item', 'name' => 'group_item_id', 'variable' => 'groupItems', 'option_value' => 'idmaster_groupitem', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Item Name', 'name' => 'name', 'place_holder' => '', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Uom', 'name' => 'uom_id', 'variable' => 'uoms', 'option_value' => 'id_uom', 'option_text' => 'uom_type', 'mandatory' => true),
        ];

        $this->rules = [
            'group_item_id' => 'required',
            'name' => 'required',
            'uom_id' => 'required',
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
            'title' => 'Items',
            'route-add' => 'po.items.create',
            'route-edit' => 'po.items.edit',
            'route-delete' => 'po.items.destroy'
        ];

        $columns = [
            array('title' => 'Name', 'field' => 'name'),
            array('title' => 'Code', 'field' => 'code'),
            array('title' => 'Uom', 'field' => 'uom_name'),
            array('title' => 'Group Item', 'field' => 'group_item_name'),

        ];

        $data = MasterItem::all();

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
            'title' => 'Create Item',
            'size' => 8,
            'route' => route('po.items.store'),
            'method' => 'POST'
        ];

        return view('layouts.create-edit', [
            'config' => $config,
            'forms' => $this->forms,
            'groupItems' => $this->groupItems,
            'uoms' => $this->uoms
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
        $groupItemId = $request->group_item_id;
        $groupItem = MasterGroupItem::where('idmaster_groupitem', $groupItemId)->first();
        $accountNo = $groupItem->account_no;

        $latestMasterItem = MasterItem::where('group_item_id', $groupItemId)->latest()->first();
        if (isset($latestMasterItem)) {
            $lastCode = explode('/', $latestMasterItem->code);
            $newNumber = $lastCode[1] + 1;
            $input['code'] = $accountNo . '/' . $newNumber;
        } else {
            $input['code'] = $accountNo . '/1';
        }
        $input['created_by'] = auth()->user()->id;
        MasterItem::create($input);

        return redirect()->route('po.items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\MasterItem $item
     * @return \Illuminate\Http\Response
     */
    public function show(MasterItem $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\MasterItem $item
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterItem $item)
    {
        $config = [
            'title' => 'Edit Item',
            'size' => 8,
            'route' => route('po.items.update', $item),
            'method' => 'PATCH'
        ];

        $data = $item;

        return view('layouts.create-edit', [
            'config' => $config,
            'forms' => $this->forms,
            'data' => $data,
            'groupItems' => $this->groupItems,
            'uoms' => $this->uoms
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\MasterItem $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterItem $item)
    {
        $request->validate($this->rules);
        $input = $request->all();
        $input['created_by'] = auth()->user()->id;
        $item->update($input);
        return redirect()->route('po.items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\MasterItem $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterItem $item)
    {
        MasterItem::where('', $item)->delete();
        return redirect()->route('po.items.index');
    }
}
