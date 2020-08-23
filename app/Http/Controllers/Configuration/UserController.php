<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Model\Configuration\Stockpile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected $status;
    protected $forms;
    protected $rules;
    protected $stockpiles;

    public function __construct()
    {

        $this->status = [
            array('id' => 1, 'label' => 'Active', 'value' => 1),
            array('id' => 2, 'label' => 'Inactive', 'value' => 0),
        ];

        $this->forms = [
            array('type' => 'text', 'label' => 'Name', 'name' => 'name', 'place_holder' => 'Name', 'mandatory' => true),
            array('type' => 'email', 'label' => 'Email', 'name' => 'email', 'place_holder' => 'Email', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Phone', 'name' => 'phone', 'place_holder' => 'Phone', 'mandatory' => false),
            array('type' => 'password', 'label' => 'Password', 'name' => 'password', 'place_holder' => 'Password', 'mandatory' => true),
            array('type' => 'password', 'label' => 'Confirm Password', 'name' => 'password_confirmation', 'place_holder' => 'Confirm Password', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Stockpile', 'name' => 'stockpile_id', 'variable' => 'stockpiles', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Status', 'name' => 'active', 'variable' => 'status', 'option_value' => 'value', 'option_text' => 'label', 'mandatory' => true),
        ];

        $this->stockpiles = Stockpile::active()->get();

        $this->rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'stockpile_id' => 'required',
            'active' => 'required'
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
            'title' => 'Users',
            'route-add' => 'configuration.users.create',
            'route-edit' => 'configuration.users.edit',
            'route-delete' => 'configuration.users.destroy'
        ];

        $columns = [
            array('title' => 'Name', 'field' => 'name'),
            array('title' => 'Email', 'field' => 'email'),
            array('title' => 'Mobile Phone', 'field' => 'phone'),
            array('title' => 'Status', 'field' => 'status'),
        ];

        $data = User::all();

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
            'title' => 'Create User',
            'size' => 8,
            'route' => route('configuration.users.store'),
            'method' => 'POST'
        ];

        return view('layouts.create-edit', [
            'config' => $config,
            'forms' => $this->forms,
            'stockpiles' => $this->stockpiles,
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
        $input['created_by'] = auth()->user()->id;
        $input['password'] = Hash::make($input['password']);
        User::create($input);

        return redirect()->route('configuration.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $config = [
            'title' => 'Edit User',
            'size' => 8,
            'route' => route('configuration.users.update', $user),
            'route-index' => route('configuration.users.index'),
            'method' => 'PATCH'
        ];

        $data = $user;

        return view('layouts.create-edit', [
            'config' => $config,
            'forms' => $this->forms,
            'stockpiles' => $this->stockpiles,
            'status' => $this->status,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'stockpile_id' => 'required',
            'active' => 'required'
        ];
        if (isset($request->password)) {
            $rules = array_merge($rules, ['password' => 'required|min:6|confirmed']);
        }
        $request->validate($rules);
        if (isset($request->password)) {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = $request->except('password');
        }

        $input['updated_by'] = auth()->user()->id;
        $user->update($input);
        return redirect()->route('configuration.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('configuration.users.index');
    }
}
