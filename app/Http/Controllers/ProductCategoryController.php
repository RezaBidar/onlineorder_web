<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session ;
use Auth;
use DB;
use App\ProductCat;
use App\Company;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Auth::user()->companies ;
        if(sizeof($companies) == 0)
            abort(404) ;
        $co_id = $companies[0]->id ;

        $pcats = ProductCat::where(['company_id' => $co_id])->get();
        return view('index.pcat' , compact('pcats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create.pcat');
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
        ]);


        DB::beginTransaction();
        try{

            $cat = new ProductCat;
            $cat->name = $request->name ;
            $cat->company_id = $companies[0]->id ;
            $cat->type = ProductCat::TYPE ;
            $cat->save();

            DB::commit();
            Session::flash('message' , 'Category Created Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        catch(\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            Session::flash('message' , 'Category Can`t Save ');
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
        $pcat = ProductCat::findOrFail($id);
        return redirect()->route('product.index', [$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pcat = ProductCat::findOrFail($id);
        return view('edit.pcat',compact('pcat'));
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
        $pcat = ProductCat::findOrFail($id);

        $companies = Auth::user()->companies ;
        if(sizeof($companies) == 0)
            abort(404) ;

        $this->validate($request , [
            'name' => 'required' ,
        ]);


        DB::beginTransaction();
        try{

            $pcat->name = $request->name ;
            $pcat->save();

            DB::commit();
            Session::flash('message' , 'Category Updated Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        catch(\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            Session::flash('message' , 'Category Can`t Update ');
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
        $pcat = ProductCat::findOrFail($id);
        $pcat->delete();
        return redirect()->back();
    }
}
