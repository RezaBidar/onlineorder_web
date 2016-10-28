<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function category()
    {
    	return $this->belongsTo('App\ProductCat' , 'category_id');
    }

    public function orders()
    {
    	return $this->belongsToMany('App\Order' , 'product_order' , 'product_id' , 'order_id') ;
    }

    public function deletePic()
    {
        if($this->pic != null && is_file('pic/products/' . $this->pic ))        
            unlink('pic/products/' . $this->pic);
        if($this->pic != null && is_file('pic/products/thumbs/' . $this->pic ))        
            unlink('pic/products/thumbs/' . $this->pic);
        
    }
}
