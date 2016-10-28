<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth ;

class Company extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

	/**
	 * get list of this company product category
	 * 
	 */
	public function productCats()
	{
		return $this->hasMany('App\ProductCat');
	}

	/**
	 * get list of this company customer category 
	 * 
	 */
	public function customerCats()
	{
		return $this->hasMany('App\CustomerCat');
	}

	public function orders()
	{
		return $this->hasMany('App\Order');
	}

	public function products()
	{
		return $this->hasMany('App\Product');
	}

	public function users()
	{
		return $this->belongsToMany('App\user' , 'user_company' , 'company_id' , 'user_id');
	}

	public function customers()
	{
		return $this->belongsToMany('App\user' , 'user_company' , 'company_id' , 'user_id')
					->where('type' , '=' , User::TYPE_CUSTOMER ) ;
	}

	public function visitors()
	{
		return $this->belongsToMany('App\user' , 'user_company' , 'company_id' , 'user_id')
					->where('type' , '=' , User::TYPE_VISITOR ) ;
	}

	public function visitorCustomers()
	{
		if(!Auth::user()->isVisitor())
			return null ;
		return $this->belongsToMany('App\user' , 'user_company' , 'company_id' , 'user_id')
					->where(['type' => User::TYPE_CUSTOMER , 'visitor_id' => Auth::user()->id ]) ;
	}

}
