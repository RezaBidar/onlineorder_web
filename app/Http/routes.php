<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// Route::get('profile', ['middleware' => 'auth.basic', function() {
//     return "Hello Auth.Basic" ;
// }]);
Route::get('dummy' , 'DashboardController@dummy');

Route::post('login' , 'AuthController@authenticate');
Route::get('login' , 'AuthController@login');
Route::get('products' , 'WebServicesController@getProducts');

Route::get('addcompany' , 'WebServicesController@addCompany');
Route::get('companies' , 'WebServicesController@companies');
Route::get('addorder' , 'WebServicesController@order');

Route::get('orderstatus/{orderId}/{status}', [ 'as' => 'orderstatus' , 'uses' => 'OrderController@orderStatus']);



Route::group(['middleware' => 'auth'], function () {

	Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
	Route::resource('company' , 'CompanyController');
	Route::resource('user' , 'UserController');
	Route::resource('visitor' , 'VisitorController');
	Route::resource('pcat' , 'ProductCategoryController');
	// Route::resource('order' , 'OrderController');

	Route::get('order/submit'  , ['as' => 'order.submit', 'uses' => 'OrderController@submitOrder'] );
	Route::get('order/{id}/edit'  , ['as' => 'order.edit', 'uses' => 'OrderController@edit'] );
	Route::get('order'  , ['as' => 'order.index', 'uses' => 'OrderController@index'] );

	Route::get('productorder/{orderId}'  , ['as' => 'productorder', 'uses' => 'OrderController@getProductList'] );
	
	// Route::resource('product' , 'ProductController');
	Route::get('product/list/{pcatId?}' , ['as' => 'product.index', 'uses' => 'ProductController@index']);
	Route::get('product/{id}' , ['as' => 'product.show', 'uses' => 'ProductController@show']);
	Route::get('product/{pcatId}/create' , ['as' => 'product.create', 'uses' => 'ProductController@create']);
	Route::post('product' , ['as' => 'product.store', 'uses' => 'ProductController@store']);
	Route::get('product/{id}/edit' , ['as' => 'product.edit', 'uses' => 'ProductController@edit']);
	Route::put('product/{id}' , ['as' => 'product.update', 'uses' => 'ProductController@update']);
	Route::delete('product/{id}' , ['as' => 'product.destroy', 'uses' => 'ProductController@destroy']);

	Route::resource('customer' , 'CustomerController');
	// Route::controller('order', 'OrderController');
	Route::get('dashboard' , ['as' => 'dashboard' , 'uses' => 'DashboardController@index'] );
	Route::get('/' , function(){
		return redirect('dashboard');
	});
	Route::get('logout' , 'AuthController@logout');

	Route::get('order/create' , ['as' => 'order.create' , 'uses' => 'OrderController@newOrder']);
	Route::get('order/{id}/update' , ['as' => 'order.update' , 'uses' => 'OrderController@update']);

});

Route::group(['middleware' => 'auth'], function () {
	Route::get('api/getproducts', [ 'as' => 'api.getproducts' , 'uses' => 'WebServicesController@getProducts']);
	Route::get('api/order', [ 'as' => 'api.order' , 'uses' => 'WebServicesController@order']);
	Route::get('api/companies', [ 'as' => 'api.companies' , 'uses' => 'WebServicesController@companies']);
	Route::get('api/addcompany', [ 'as' => 'api.addcompany' , 'uses' => 'WebServicesController@addCompany']);
});

Route::get('api/authenticate', [ 'as' => 'api.authenticate' , 'uses' => 'WebServicesController@authenticate']);