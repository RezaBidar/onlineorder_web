<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product ;
use App\ProductCat ;
use Session ;
use Auth ;
use DB;
use Log;
use Image;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Auth::user()->getCompany() ;
        if($company == null)
            abort(404) ;

        //$pcat = ProductCat::findOrFail($catId);
        $pcats = ProductCat::where('company_id' , $company->id)->get();
        $products = array();
        foreach ($pcats as $pcat) {
            $products[$pcat->id] = Product::where('category_id' , $pcat->id)->get();    
        }
        
        if(Auth::user()->isOperator())
            return view('index.producttab' , compact('products' , 'pcats'));
        //if is visitor
        return view('index.producttabv' , compact('products' , 'pcats'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($catId)
    {
        $pcat = ProductCat::findOrFail($catId);
        return view('create.product' , compact('pcat'));
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

        $cat = ProductCat::findOrFail($request->category_id);
        if($cat->company_id != $companies[0]->id)
            abort(404) ;


        //dd($request->file("pic")->getClientOriginalName());
        $this->validate($request , [
            'name' => 'required' ,
            'unit' => 'required' ,
            'price' => 'required' ,
            'pic' => 'image|max:2000' ,
        ]);


        DB::beginTransaction();
        try{

            $product = new Product;
            $product->code = $request->code ;
            $product->name = $request->name ;
            $product->description = $request->description ;
            $product->unit = $request->unit ;
            $product->price = $request->price ;
            $product->category_id =  $request->category_id;
            $product->company_id = $companies[0]->id ;

            if ($request->hasFile('pic')) {

                $destinationPath = "pic/products";
                $thumbnailPath = "pic/products/thumbs";
                $fileName = $product->company_id . str_random(10) . "." . pathinfo($request->file("pic")->getClientOriginalName(), PATHINFO_EXTENSION) ;

                $img = Image::make($request->file('pic')->getPathName() )->resize(50, 50);
                $img->save($thumbnailPath . '/' . $fileName , 40 );

                $img = Image::make($request->file('pic')->getPathName() )->resize(400, 400);
                $img->save($destinationPath . '/' . $fileName , 70 );

                // $request->file('pic')->move($destinationPath, $fileName);
                $product->pic = $fileName ;
            }



            $product->save();
            

            DB::commit();
            Session::flash('message' , 'Product Created Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        catch(\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            Session::flash('message' , 'Product Can`t Save ' . $e->getMessage());
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
        $product = Product::findOrFail($id);
        return view('show.product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('edit.product', compact('product'));
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
        $companies = Auth::user()->companies ;
        if(sizeof($companies) == 0)
            abort(404) ;

        
        $product = Product::findOrFail($id);
        if($product->company_id != $companies[0]->id)
            abort(404) ;

        $this->validate($request , [
            'name' => 'required' ,
            'unit' => 'required' ,
            'price' => 'required' 
        ]);


        DB::beginTransaction();
        try{

            
            $product->code = $request->code ;
            $product->name = $request->name ;
            $product->unit = $request->unit ;
            $product->price = $request->price ;

            if ($request->hasFile('pic')) {
                $product->deletePic();
                $destinationPath = "pic/products";
                $thumbnailPath = "pic/products/thumbs";
                $fileName = $product->company_id . str_random(10) . "." . pathinfo($request->file("pic")->getClientOriginalName(), PATHINFO_EXTENSION) ;

                $img = Image::make($request->file('pic')->getPathName() )->resize(50, 50);
                $img->save($thumbnailPath . '/' . $fileName , 40 );

                $img = Image::make($request->file('pic')->getPathName() )->resize(400, 400);
                $img->save($destinationPath . '/' . $fileName , 70 );

                // $request->file('pic')->move($destinationPath, $fileName);
                $product->pic = $fileName ;
            }

            $product->save();

            DB::commit();
            Session::flash('message' , 'Product Updated Successfully');
            Session::flash('alert_class' , 'alert-success');
        }
        catch(\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            Session::flash('message' , 'Product Can`t Update ');
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
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back();   
    }
}
