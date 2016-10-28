<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
    const TYPE = 'product' ;

    
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

    public function products()
    {
    	return $this->hasMany('App\Product','category_id') ;
    }

    /**
     * override each query 
     * 
     * @return complex
     */
    public function newQuery()
    {
        $query = parent::newQuery();
        $query->where('type' , self::TYPE );
        return $query;

    }

    
}
