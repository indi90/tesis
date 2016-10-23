<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'                  => 'required',
            'email'                 => 'required|unique:users|email',
            'password'              => 'required|min:3|confirmed',
            'password_confirmation' => 'required|min:3'
        ]);

        $request->merge(['password' => bcrypt($request->password)]);

        User::create($request->all());

        flash()->success('Success add new user.');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'                  => 'required',
            'email'                 => 'required|unique:users,email,'.$id.',id|email',
            'password'              => 'min:3|confirmed',
            'password_confirmation' => 'min:3'
        ]);

        $user = User::find($id);
        if (!isset($request->is_admin)){
            $request->merge(['is_admin' => false]);
        }
        if (empty($request->password)){
            $input = $request->except(['password']);
            $user->fill($input);
        } else {
            $request->merge(['password' => bcrypt($request->password)]);
            $user->fill($request->all());
        }
        $user->save();

        flash()->success('Success update user.');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        flash()->success('Success delete user.');
        return redirect()->route('users.index');
    }
}
