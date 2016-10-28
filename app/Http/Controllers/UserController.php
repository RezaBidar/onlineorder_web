<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User ;
use Session ;
use Hash ;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all() ;
        return view('index.user' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('create.user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'name' => 'required' ,
            'username' => 'required|unique:users' ,
            'password' => 'required|min:5',
        ]);

        // $request->level = User::TYPE_ADMIN ;
        // $request->password = Hash::make($request->password);
        //save user  ...
        $user = new User;

        $user->name = $request->name ;
        $user->username = $request->username ;
        $user->password = Hash::make($request->password);
        $user->type = User::TYPE_ADMIN ;
        $user->save() ;

        if(isset($user->id))
        {
            Session::flash('message' , 'User Created Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        else
        {
            Session::flash('message' , 'User Can`t Save ');
            Session::flash('alert_class' , 'alert-danger');   
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('show.user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('edit.user');   
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
        $user = User::findOrFail($id);
        $this->validate($request , [
            'name' => 'required' ,
            'username' => 'required|unique:users' ,
            'password' => 'min:5',
        ]);


        $user->name = $request->name ;
        $user->username = $request->username ;
        $user->password = Hash::make($request->password);
        $user->type = User::TYPE_ADMIN ;
        $user->save() ;

        if(isset($user->id))
        {
            Session::flash('message' , 'User Update Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        else
        {
            Session::flash('message' , 'User Can`t Update ');
            Session::flash('alert_class' , 'alert-danger');   
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back();
    }
}
