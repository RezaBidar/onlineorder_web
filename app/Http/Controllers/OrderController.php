<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ProductOrder;
use App\ProductCat;
use App\Product;
use App\Order;
use App\User;

use Auth;
use DB;

class OrderController extends Controller
{
    /**
     * show list of requested orders
     * @return [type] [description]
     */
    public function index(Request $request)
    {


        // $date = \Morilog\Jalali\jDateTime::convertNumbers(\Morilog\Jalali\jDateTime::strftime('Y-m-d H:i:s', strtotime('2016-10-25 06:46:17'))); // 1395-02-19
        // $date2 = \Morilog\Jalali\jDateTime::convertNumbers($date); // ۱۳۹۵-۰۲-۱۹
        // return dd($date) ;
        $sStatus = trim($request->status) ;
        $sCustomer = trim($request->customer) ;
        $sVisitor = trim($request->visitor) ;

        $company = Auth::user()->getCompany();
        $customers = [0 => 'همه'] ; 
        $visitors = [0 => 'همه'] ;

        if(Auth::user()->isVisitor() )
        {
            foreach (Auth::user()->customers as $customer) $customers[$customer->id] = $customer->name;
            $statuses = [0 => 'همه', 
                        Order::STATUS_REQUEST_V => 'لیست انتظار', 
                        Order::STATUS_ACCEPT_V => 'تایید شده ها', 
                        Order::STATUS_REJECT_V => 'رد شده ها'  ] ;
                        
            $query = Order::where(['visitor_id'=> Auth::user()->id]);  

            if(!empty($sStatus) && isset($statuses[$sStatus]))
                $query->where(['status' => $sStatus]) ;
            // else 
            //     $query->where(['status' => Order::STATUS_REQUEST_V]);

            if(!empty($sCustomer) && isset($customers[$sCustomer]))
                $query->where(['customer_id' => $sCustomer]) ;
            $orders = $query->paginate(10);

            return view('index.order' , compact(
                'orders' ,'customers' , 'statuses' , 'sStatus' , 'sCustomer'));
        }
        elseif(Auth::user()->isOperator() )
        {
            foreach ($company->visitors as $visitor) $visitors[$visitor->id] = $visitor->name ;
            foreach ($company->customers as $customer) $customers[$customer->id] = $customer->name;
            $statuses = [0 => 'همه', 
                        Order::STATUS_REQUEST_O => 'لیست انتظار', 
                        Order::STATUS_ACCEPT_O => 'تایید شده ها', 
                        Order::STATUS_REJECT_O => 'رد شده ها'  ] ;

            // DB::enableQueryLog();
            $query = Order::where(['company_id'=> $company->id ]);

            if(!empty($sStatus) && isset($statuses[$sStatus]))
                $query->where(['status' => $sStatus]) ;
            // else 
            //     $query->where(['status' => Order::STATUS_REQUEST_O]);
            
            if(!empty($sCustomer) && isset($customers[$sCustomer]))
                $query->where(['customer_id' => $sCustomer]) ;

            if(!empty($sVisitor) && isset($visitors[$sVisitor]))
                $query->where(['visitor_id' => $sVisitor]) ;

            // return var_dump($query);
            $orders = $query->paginate(10);
            
            // dd(DB::getQueryLog());


            return view('index.order' , compact(
                'orders' ,'customers' , 'visitors' , 'statuses', 'sStatus', 'sVisitor', 'sCustomer'));
        }
        else
            return json_encode('error' , 'page not found');
    }

    public function getOrderList()
    {

    }

    public function postSetOrderStatus()
    {

    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        if($order->closed() || !Auth::user()->isVisitor())
            return ['you cant edit this order'];
        $visitor = $order->visitor ;
        $customer = $order->customer ;
        $company = $order->company ;
        $orderProducts = $order->products ;
        $op = [] ;
        foreach ($orderProducts as $orderProduct) {
            $op[$orderProduct->id] = $orderProduct->pivot->num ;
        }
        $pcats = ProductCat::where('company_id' , $company->id)->get();
        $products = array();
        foreach ($pcats as $pcat) {
            $products[$pcat->id] = Product::where('category_id' , $pcat->id)->get();    
        }


        return view('edit.order' , compact('order' , 'visitor' , 'customer' , 'company' , 'op' , 'pcats' , 'products')) ;
    }

    public function update(Request $request)
    {
        if(!Auth::user()->isVisitor())
            return 'You dont have persmision to see this page';
        // return [$request->customerId , $request->products];
        
        $order = Order::find($request->orderId) ;
        if($order == null)
            return ['error'];

        $customer = $order->customer ;
        $productIds = json_decode($request->products) ;
        $visitor = $order->visitor;
        $company = $visitor->getCompany();

        if($order->visitor->id !== Auth::user()->id)
            return ['error'];


        $products = [] ;
        foreach ($productIds as $p) {
            $productId = $p->k;
            $productNum = $p->v;
            $product = Product::find($p->k);
            if(!($productNum == 0 || $product == null || $product->company_id !== $company->id))
                $products[$product->id] = ['num' => $productNum , 'price' => $product->price];
        }
        
        if(sizeof($products) == 0)
            return ['error'] ;

        DB::beginTransaction();
        try{

            $order->status = Order::STATUS_REQUEST_V ;
            $order->save();
            $order->products()->sync($products);

            DB::commit();

            return ['success' , $order->id];
        }
        catch(\Exception $e){

            DB::rollback();
            return ['error' => 'Error in transaction'];
        }
    }

    public function getProductList($orderId)
    {
    	$products = ProductOrder::where('order_id' , $orderId)->get();
    	$customerName = Order::find($orderId)->customer->name;
        $order = Order::findOrFail($orderId);
        $visitorName = $order->visitor->name ;
    	return view('index.orderview' , compact('products' , 'orderId' , 'customerName', 'order', 'visitorName'));
    }

    public function orderStatus($orderId,$status)
    {
        $order = Order::findOrFail($orderId);
        $userCompany = getCurrentUserCompany();
        $returnCode = 0 ;
        if(is_null($userCompany) || $userCompany->id != $order->company_id || !is_numeric($status))
            return $returnCode ;

        $userLevel = Auth::user()->type ;
        if($userLevel == User::TYPE_VISITOR)
            if($status == 1){
                $order->status = Order::STATUS_ACCEPT_V ;
                $returnCode = 2;
            }
            else{
                $order->status = Order::STATUS_REJECT_V ;
                $returnCode = 1;
            }
        elseif ($userLevel == User::TYPE_OPERATOR)
            if($status == 1){
                $order->status = Order::STATUS_ACCEPT_O ;
                $returnCode = 2;
            }
            else{
                $order->status = Order::STATUS_REJECT_O ;
                $returnCode = 1;
            }

        $order->save();
        return $returnCode ;


    }


    public function addProductToOrder(){
        
    }

    public function newOrder()
    {
        $user = Auth::user() ;
        $company = $user->getCompany();
        if(!$user->isVisitor())
            return abort(404);

        $customerModels = $user->customers ;
        $customers = [] ;
        foreach($customerModels as $customer)
        {
            $customers[$customer->id] = $customer->name ;
        }
        $pcats = ProductCat::where('company_id' , $company->id)->get();
        $products = array();
        foreach ($pcats as $pcat) {
            $products[$pcat->id] = Product::where('category_id' , $pcat->id)->get();    
        }

        
        return view('index.neworder' , compact('customers' , 'products' , 'pcats' ));
        

    }

    /*
    this will use for visitors
     */
    public function submitOrder(Request $request)
    {
        if(!Auth::user()->isVisitor())
            return 'You dont have persmision to see this page';
        // return [$request->customerId , $request->products];
        
        $customer = User::findOrFail($request->customerId) ;
        $productIds = json_decode($request->products) ;
        $visitor = Auth::user();
        $company = $visitor->getCompany();


        $products = [] ;
        foreach ($productIds as $p) {
            $productId = $p->k;
            $productNum = $p->v;
            $product = Product::find($p->k);
            if(!($productNum == 0 || $product == null || $product->company_id !== $company->id))
                $products[$product->id] = ['num' => $productNum , 'price' => $product->price];
        }
        
        if(sizeof($products) == 0)
            return ['error'] ;

        DB::beginTransaction();
        try{

            $order = new Order ;
            $order->visitor_id = $visitor->id;
            $order->customer_id = $customer->id ;
            $order->company_id = $company->id ;
            $order->status = Order::STATUS_REQUEST_V ;
            $order->save() ;

            $order->products()->attach($products);

            DB::commit();

            return ['success' , $order->id];
        }
        catch(\Exception $e){

            DB::rollback();
            return ['error' => 'Error in transaction'];
        }
    }
}
