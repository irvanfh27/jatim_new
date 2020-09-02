<?php

namespace App\Http\Controllers\API\V1\Configuration;

use App\Http\Controllers\Controller;
use App\Http\Resources\StockpileResource;
use App\Model\Configuration\Stockpile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StockpileController extends Controller
{
    protected $weightRule;
    protected $status;
    protected $forms;
    protected $rules;

    public function __construct()
    {
        $this->weightRule = [
            array('id' => 1, 'label' => 'Lowest', 'value' => 0),
            array('id' => 2, 'label' => 'Send Weight', 'value' => 1),
            array('id' => 3, 'label' => 'Netto Weight', 'value' => 2),
        ];

        $this->status = [
            array('id' => 1, 'label' => 'Active', 'value' => 1),
            array('id' => 2, 'label' => 'Inactive', 'value' => 0),
        ];

        $this->forms = [
            array('type' => 'text', 'label' => 'Code', 'name' => 'code', 'place_holder' => 'Code', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Name', 'name' => 'name', 'place_holder' => 'Name', 'mandatory' => true),
            array('type' => 'textarea', 'label' => 'Address', 'name' => 'address', 'place_holder' => 'Address', 'mandatory' => false),
            array('type' => 'select_option', 'label' => 'Freight Weight Rule', 'name' => 'freight_weight_rule', 'variable' => 'weightRule', 'option_value' => 'value', 'option_text' => 'label', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Curah Weight Rule', 'name' => 'curah_weight_rule', 'variable' => 'weightRule', 'option_value' => 'value', 'option_text' => 'label', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Status', 'name' => 'active', 'variable' => 'status', 'option_value' => 'value', 'option_text' => 'label', 'mandatory' => true),
        ];

        $this->rules = [
            'code' => 'required',
            'name' => 'required',
            'freight_weight_rule' => 'required',
            'curah_weight_rule' => 'required'
        ];

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = Stockpile::searchQuery($searchValue);

        if ($perPage) {
            $query = $query->take(20)->paginate(20);
        } else {
            $query = $query->paginate($perPage);
        }
        return StockpileResource::collection($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $config = [
            'title' => 'Create Stockpile',
            'size' => 8,
            'route' => route('configuration.stockpiles.store'),
            'method' => 'POST'
        ];

        return view('layouts.create-edit', [
            'config' => $config,
            'forms' => $this->forms,
            'weightRule' => $this->weightRule,
            'status' => $this->status
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
        $input['uuid'] = Str::uuid();
        $input['created_by'] = auth('api')->user()->id;
        Stockpile::insert($input);
//
//        return redirect()->route('configuration.stockpiles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Stockpile $stockpile
     * @return \Illuminate\Http\Response
     */
    public function show(Stockpile $stockpile)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Stockpile $stockpile
     * @return \Illuminate\Http\Response
     */
    public function edit(Stockpile $stockpile)
    {
        $config = [
            'title' => 'Edit Stockpile',
            'size' => 8,
            'route' => route('configuration.stockpiles.update', $stockpile),
            'method' => 'PATCH'
        ];

        $data = $stockpile;

        return view('layouts.create-edit', [
            'config' => $config,
            'forms' => $this->forms,
            'weightRule' => $this->weightRule,
            'status' => $this->status,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Stockpile $stockpile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stockpile $stockpile)
    {
        $request->validate($this->rules);
        $input = $request->all();
        $input['updated_by'] = auth()->user()->id;
        $stockpile->update($input);
        return redirect()->route('configuration.stockpiles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Stockpile $stockpile
     * @return \Illuminate\Http\Response
     */
    public function destroy($stockpile)
    {
        Stockpile::where('uuid', $stockpile)->delete();
        return redirect()->route('configuration.stockpiles.index');
    }
}
