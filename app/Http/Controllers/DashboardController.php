<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\CustomerCompanyVisitor;
use App\Product;
use App\Order;
use Auth;

class DashboardController extends Controller
{
 	public function index()
 	{
 		if(Auth::user()->isAdmin())
 			return view('admindash');
 		
 		// if(Auth::user()->type == User::TYPE_VISITOR )
 		// {
 		// 	$orders = Order::where(['visitor_id'=> Auth::user()->id , 'status' => Order::STATUS_REQUEST_V])->get();  
 		// 	return view('index.order' , compact('orders'));
 		// }
 		// elseif(Auth::user()->type == User::TYPE_OPERATOR )
 		// {
 		// 	$companies = Auth::user()->companies ;
 		// 	$companyId = -1 ;
 		// 	foreach ($companies as $company) {
 		// 		$companyId = $company->id ;
 		// 	}

 		// 	$orders = Order::where(['company_id'=> $companyId , 'status' => Order::STATUS_REQUEST_O])->get();  ;
 		// 	return view('index.order' , compact('orders'));
 		// }
 		
 		// if(Auth::user()->isOperator()){
	 		$company = Auth::user()->getCompany();
	 		$customers = sizeof($company->customers) ;
	 		// $visitors = sizeof($company->visitors) ;
	 		$products = sizeof($company->products);
	 		$requests = Order::where(['company_id'=> $company->id , 'status' => Order::STATUS_REQUEST_O])
	 						->count();
	 		$accepted = Order::where(['company_id'=> $company->id , 'status' => Order::STATUS_ACCEPT_O])
	 						->count();
 		// }
	 	if(Auth::user()->isVisitor())
	 	{
			$company = Auth::user()->getCompany();
	 		$customers = sizeof($company->visitorCustomers);
	 		// $visitors = sizeof($company->visitors) ;
	 		// $products = sizeof($company->products);
	 		$requests = Order::where(['company_id'=> $company->id , 'status' => Order::STATUS_REQUEST_V])
	 						->count();
	 		$requestO = Order::where(['company_id'=> $company->id , 'status' => Order::STATUS_ACCEPT_V])
	 						->count();
	 		$accepted = Order::where(['company_id'=> $company->id , 'status' => Order::STATUS_ACCEPT_O])
	 						->count();
	 	}
 		return view('dashboard' , compact('customers', 'products', 'requests', 'accepted'));
 	}

 	public function dummy()
 	{
 	// 	$customer = new User();
		// $customer->type = User::TYPE_CUSTOMER ;
		// $customer->username = "reza";
		// $customer->password = bcrypt("reza");
		// $customer->name = "رضا مشتری";
		// $customer->save();

		// $visitor_id = 11;
		// $company_id = 10;
		// $pivot = new CustomerCompanyVisitor();	
		// $pivot->user_id = $customer->id ;
		// $pivot->company_id = $company_id;
		// $pivot->visitor_id = $visitor_id;
		// $pivot->save();

		// dd($customer,$pivot);

 	// 	$order = new Order();
 	// 	$order->customer_id = 12;
 	// 	$order->visitor_id = 11 ;
 	// 	$order->company_id = 10 ;
 	// 	$order->status = Order::STATUS_REQUEST_V ;
 	// 	$order->save();
		// $products = Product::all();
		// for($i = 0 ; $i < 10 ; $i++)
		// {
		// 	$order->products()->attach($products[$i]->id);
		// }

		for($i = 0 ; $i < 20 ; $i++)
		{
			$order = new Order ;
			$order->customer_id = 12;
	 		$order->visitor_id = 11 ;
	 		$order->company_id = 10 ;
	 		$order->status = Order::STATUS_REQUEST_V ;
	 		$order->save();
			$products = Product::all();
			for($j = 0 ; $j < 10 ; $j++)
			{
				$order->products()->attach($products[$j]->id);
			}
		}
		return "inserted" ;
 	}
}
