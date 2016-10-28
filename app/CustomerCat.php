<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCat extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "categories";

    public function company()
    {
    	return $this->belongsTo('App\Company' , 'company_id') ;
    }

    public function customers()
    {
    	return $this->belongsToMany('App\user','user_category','category_id','user_id') ;
    }
}
