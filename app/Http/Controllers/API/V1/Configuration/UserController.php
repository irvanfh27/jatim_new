<?php

namespace App\Http\Controllers\API\V1\Configuration;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
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
        $user = User::create($input);

        if ($user) {
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
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
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
        $user = $user->update($input);
        if ($user) {
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
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user = $user->delete();
        if ($user) {
            $status = true;
        } else {
            $status = false;
        }
        return response()->json([
            'success' => $status
        ]);
    }
}
