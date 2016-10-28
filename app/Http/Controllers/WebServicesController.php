<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;
use App\Company;
use App\ProductCat;
use App\CustomerCompanyVisitor;
use App\User ;
use App\Order ;
use DB;
use Hash;
use Auth;
/**
 * all pages of this controller use basic authentication
 */
class WebServicesController extends Controller
{
    /**
     * if basic auth authenticate user then it return ok
     * @return json
     */
    public function authenticate(Request $request)
    {
        
     //    $user = User::where([
     //        'username' => $request->username ,
     //        'password' => Hash::make($request->password),
     //        ])->first();

     //    // return [bcrypt($request->password) , $request->username , $request->password , Hash::make($request->password)] ;
     //    return dd($user) ;
    	// if(empty($user))
        $credentials = $request->only('username', 'password');
        if(Auth::once($credentials)) {
            $user = Auth::getUser();
        } else {
            return json_encode(['error' => 'user not found']);
        }
            
        return json_encode(['success' => $user->api]) ;



    }

    public function getProducts(Request $request)
    {
        $customer = $request->customer ;
        $company = Company::find();

        $pcatRows = ProductCat::where(['company_id' => $request->cid])->get();
        $products = [];
        $pcats = [];
        $answre = [];

        foreach ($pcatRows as $pcatRow) 
        {
            $pcats[$pcatRow->id] = $pcatRow->name;
            $productRows = Product::where('category_id',$pcatRow->id)->get();
            foreach ($productRows as $productRow) 
            {
                $products[$pcatRow->id][$productRow->id] = [
                        'name' => $productRow->name ,
                        'unit' => $productRow->unit ,
                        'description' => $productRow->description ,
                        'price' => $productRow->price ,
                        'pic' => $productRow->pic ,
                        // 'n' => $productRow->name ,
                        // 'u' => $productRow->unit ,
                        // 'd' => $productRow->description ,
                        // 'p' => $productRow->price ,
                        // 'g' => $productRow->pic ,
                ];
            }
        }

        $answer['cats'] = $pcats ;
        $answer['products'] = $products ;

    	return $answer;	
    }

    public function order(Request $request)
    {
        $customer = $request->customer ;
        $companies = $customer->companies ;
        $company_id = null;
        foreach ($companies as $company) {
            $company_id = $company->id ;
        }

        $cvc = CustomerCompanyVisitor::where(['user_id' => $customer->id , 'company_id' => $company_id])->first();

        $visitor_id = $cvc->visitor_id ;
    	$productIds = json_decode($request->products);
        $products = [] ;
        foreach ($productIds as $p) {
            $productId = $p[0];
            $productNum = $p[1];
            $product = Product::find($p[0]);
            if($product == null || $product->company_id !== $company_id)
                return json_encode(['error' => 'product id is invalid']);
            $products[$product->id] = ['num' => $productNum , 'price' => $product->price];
        }

        DB::beginTransaction();
        try{

            $order = new Order ;
            $order->visitor_id = $visitor_id;
            $order->customer_id = $customer->id ;
            $order->company_id = $company_id ;
            $order->status = Order::STATUS_REQUEST_V ;
            $order->save() ;

            $order->products()->attach($products);

            DB::commit();

            return ['success' => 'Order add successfully'] ;
        }
        catch(\Exception $e){

            DB::rollback();
            return ['error' => 'Error in transaction'];
        }

    }

    public function companies(Request $request)
    {
        
        $customer = $request->customer ;


        $companies_obj = $customer->companies;
        // return json_encode($companies_obj , JSON_UNESCAPED_UNICODE);
        $companies = array();
        foreach ($companies_obj as $key => $company) {
            $visitor = User::findOrFail($company->pivot->visitor_id) ;
            array_push($companies,array(
                    'ci' => $company->id ,
                    'cn' => $company->name ,
                    'vi' => $visitor->id ,
                    'vn' => $visitor->name ,
                ));
            
        }

        return json_encode($companies, JSON_UNESCAPED_UNICODE);
    }

    public function addCompany(Request $request)
    {
        // $user_company_id = $request->visitor_id ;
        // $customer_id = $request->customer_id;
        $customer = $request->customer ;
        $visitorCid = $request->vid ; // visitorCompanyId
        // $customer_id = 13;
        // $user_company_id = 3;



        $visitor_company = CustomerCompanyVisitor::find($visitorCid);
        if($visitor_company == null)
        {
            return json_encode(array(501,'Visitor not found'));
        }

        $company = Company::find($visitor_company->company_id);
        if($company == null)
        {
            return json_encode(array(502,'Company not found'));
        }

        // $customer_company = CustomerCompanyVisitor::where('company_id' , $company->id)
        //                                             ->where('user_id' , $customer->id)
        //                                             ->first() ;

        if($customer->isInCompanye($company->id))
        {
            return json_encode(array(503,'Company allready exists'));   
        }

        // $visitor = User::find($visitor_company->user_id);

        $customer_company = new CustomerCompanyVisitor;
        $customer_company->user_id = $customer->id ;
        $customer_company->company_id = $company->id ;
        $customer_company->visitor_id = $visitor_company->user_id ;
        $customer_company->save();


        return json_encode(array(
                'ci' => $company->id ,
                'cn' => $company->name ,
                'vi' => $visitor->id ,
                'vn' => $visitor->name ,
            ), JSON_UNESCAPED_UNICODE);

        // $visitor = User::find($visitor_company->id);
        // if($visitor == null)
        // {
        //     return json_encode(array(501,'Visitor not found'));
        // }


    }




}
