<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Company;
use App\User;
use Session;
use DB;
use Log;
use Image;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view('index.company', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create.company');
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

        DB::beginTransaction();
        try{
            $company = new Company ;
            $company->name = $request->name ;
            $company->save();

            $user = new User ;
            $user->name = $request->name ;
            $user->username = $request->username ;
            $user->password = bcrypt($request->password) ;
            $user->description = nl2br($request->description);
            $user->type = USER::TYPE_OPERATOR ;

            if ($request->hasFile('pic')) {

                $destinationPath = "pic/company";
                $fileName = str_random(10) . "." . pathinfo($request->file("pic")->getClientOriginalName(), PATHINFO_EXTENSION) ;

                $img = Image::make($request->file('pic')->getPathName() )->resize(200, 200);
                $img->save($thumbnailPath . '/' . $fileName , 70 );

                $user->pic = $fileName ;
            }

            $user->save() ;

            $company->users()->attach($user);

            DB::commit();

            Session::flash('message' , 'Company Created Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        catch(\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            Session::flash('message' , 'Company Can`t Save ' . $e->getMessage());
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
        $company = Company::findOrFail($id) ;
        return view('show.company' , compact('company')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id) ;
        return view('edit.company' , compact('company')) ;
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
        $company = Company::findOrFail($id) ;

        $this->validate($request , [
            'name' => 'required' ,
            'username' => 'required|unique:users' ,
            'password' => 'min:5',
        ]);

        DB::beginTransaction();
        try{

            $company->name = $request->name ;
            $company->save();

            $operators = $company->operators ;
            $operator = $operators[0] ;
            $operator->name = $request->name ;
            $operator->username = $request->username ;
            $operator->password = bcrypt($request->password) ;
            $operator->description = nl2br($request->description);
            $operator->type = USER::TYPE_OPERATOR ;
            $operator->save() ;


            DB::commit();

            Session::flash('message' , 'Company Updated Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        catch(\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            Session::flash('message' , 'Company Can`t Update ');
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
        $company = Company::findOrFail($id) ;
        $company->delete();
        return redirect()->back();   
    }

    public function name()
    {
        return "company" ;
    }
}
