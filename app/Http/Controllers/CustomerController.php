<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use DB;
use Session;
use App\User ;
use Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()->isOperator())
            $customers = Auth::user()->getCompany()->customers ;
        elseif(Auth::user()->isVisitor())
            $customers = Auth::user()->getCompany()->visitorCustomers ;

        return view('index.customer' , compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $visitors = [];
        foreach (Auth::user()->getCompany()->visitors as $visitor) {
            $visitors[$visitor->id] = $visitor->name ;
        }

        return view('create.customer' , compact('visitors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /// badan bayad free beshe
        $company = Auth::user()->getCompany() ;

        $this->validate($request , [
            'name' => 'required' ,
            'username' => 'required|unique:users' ,
            'password' => 'required|min:5',
            'visitor_id' => 'required',
        ]);

            
        DB::beginTransaction();
        try{


            $user = new User ;
            $user->name = $request->name ;
            $user->username = $request->username ;
            $user->password = bcrypt($request->password) ;
            $user->tel = $request->tel ;
            $user->description = nl2br($request->description);
            $user->address = $request->address ;
            $user->type = User::TYPE_CUSTOMER ;

            if ($request->hasFile('pic')) {
                
                $destinationPath = "pic/avatars";
                $fileName = $user->company_id . str_random(10) . "." . pathinfo($request->file("pic")->getClientOriginalName(), PATHINFO_EXTENSION) ;

                $img = Image::make($request->file('pic')->getPathName() )->resize(250, 250);
                $img->save($destinationPath . '/' . $fileName , 85 );


                // $request->file('pic')->move($destinationPath, $fileName);
                $user->pic = $fileName ;
            }

            $user->save() ;
            $companies[$company->id] = ['visitor_id' => $request->visitor_id] ;
            $user->companies()->attach($companies);

            DB::commit();
            Session::flash('message' , 'Customer Created Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        catch(\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            Session::flash('message' , 'Customer Can`t Save ');
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
        $company = $user->getCompany();
        $visitor = $user->getVisitor($company);
        return view('show.customer' , compact('user' , 'company' , 'visitor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        $visitors = [];
        foreach (Auth::user()->getCompany()->visitors as $visitor) {
            $visitors[$visitor->id] = $visitor->name ;
        }
        return view('edit.customer' , compact('customer' , 'visitors'));
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
            'password' => 'min:5',
        ]);

        DB::beginTransaction();
        try{

            $user->name = $request->name ;
            // $user->username = $request->username ;
            if(!empty($request->password))
                $user->password = bcrypt($request->password);
            $user->tel = $request->tel ;
            $user->description = nl2br($request->description);
            $user->address = $request->address ;
            // $user->type = User::TYPE_CUSTOMER ;
            if ($request->hasFile('pic')) {
                $user->deletePic();
                $destinationPath = "pic/avatars";
                $fileName = $user->company_id . str_random(10) . "." . pathinfo($request->file("pic")->getClientOriginalName(), PATHINFO_EXTENSION) ;

                $img = Image::make($request->file('pic')->getPathName() )->resize(250, 250);
                $img->save($destinationPath . '/' . $fileName , 85 );


                // $request->file('pic')->move($destinationPath, $fileName);
                $user->pic = $fileName ;
            }
            $user->save() ;
            // $user->companies()->sync($companies[0]->id);

            DB::commit();
            Session::flash('message' , 'Customer Created Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        catch(\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            Session::flash('message' , 'Customer Can`t Save ');
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
        //
    }
}
