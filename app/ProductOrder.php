<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "product_order";

    public function product()
    {
    	return $this->belongsTo('App\Product' , 'product_id') ;
    }

    public function order()
    {
        return $this->belongsTo('App\Order' , 'order_id');
    }
}
