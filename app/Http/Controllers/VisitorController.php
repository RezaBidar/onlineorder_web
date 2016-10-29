<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Company;
use Auth;
use DB;
use Session;


class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $companies = Auth::user()->companies ;
        // if(sizeof($companies) == 0)
        //     abort(404) ;
        // $co_id = $companies[0]->id ;
        // $visitors = User::join('user_company' , 'user_company.user_id' , '=' , 'users.id')
        //             ->where(['company_id' => $co_id ,'type' => User::TYPE_VISITOR])->get();
        $visitors = Auth::user()->getCompany()->visitors ;
        
        return view('index.visitor' , compact('visitors'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create.visitor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $companies = Auth::user()->companies ;
        if(sizeof($companies) == 0)
            abort(404) ;

        $this->validate($request , [
            'name' => 'required' ,
            'username' => 'required|unique:users' ,
            'password' => 'required|min:5',
        ]);

        DB::beginTransaction();
        try{


            $user = new User ;
            $user->name = $request->name ;
            $user->username = $request->username ;
            $user->password = bcrypt($request->password) ;
            $user->description = nl2br($request->description);
            $user->tel = $request->tel ;
            $user->type = User::TYPE_VISITOR ;

            if ($request->hasFile('pic')) {
                
                $destinationPath = "pic/avatars";
                $fileName = $visitor->company_id . str_random(10) . "." . pathinfo($request->file("pic")->getClientOriginalName(), PATHINFO_EXTENSION) ;

                $img = Image::make($request->file('pic')->getPathName() )->resize(250, 250);
                $img->save($destinationPath . '/' . $fileName , 85 );


                // $request->file('pic')->move($destinationPath, $fileName);
                $visitor->pic = $fileName ;
            }

            $user->save() ;
            $user->companies()->attach($companies[0]->id);

            DB::commit();
            Session::flash('message' , 'Visitor Created Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        catch(\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            Session::flash('message' , 'Visitor Can`t Save ');
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
        $visitor = User::findOrFail($id);
        return view('show.visitor' , compact('visitor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitor = User::findOrFail($id);
        return view('edit.visitor' , compact('visitor'));
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
        $visitor = User::findOrFail($id);

        $companies = Auth::user()->companies ;
        if(sizeof($companies) == 0)
            abort(404) ;

        $this->validate($request , [
            'name' => 'required' ,
            'password' => 'min:5',
        ]);

        DB::beginTransaction();
        try{


            $visitor->name = $request->name ;
            // $visitor->username = $request->username ;
            $visitor->password = bcrypt($request->password) ;
            $visitor->tel = $request->tel ;
            $visitor->description = nl2br($request->description);
            if ($request->hasFile('pic')) {
                $visitor->deletePic();
                $destinationPath = "pic/avatars";
                $fileName = $visitor->company_id . str_random(10) . "." . pathinfo($request->file("pic")->getClientOriginalName(), PATHINFO_EXTENSION) ;

                $img = Image::make($request->file('pic')->getPathName() )->resize(250, 250);
                $img->save($destinationPath . '/' . $fileName , 85 );


                // $request->file('pic')->move($destinationPath, $fileName);
                $visitor->pic = $fileName ;
            }
            $visitor->save();
            $visitor->companies()->sync($companies[0]->id);

            DB::commit();
            Session::flash('message' , 'Visitor Update Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        catch(\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            Session::flash('message' , 'Visitor Can`t Update ');
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
        $visitor = User::findOrFail($id);
        $visitior->delete();
        return redirect()->back();
    }
}
