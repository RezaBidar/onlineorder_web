<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    const STATUS_REQUEST_V = 'request_v';
    const STATUS_ACCEPT_V = 'accept_v';
    const STATUS_REJECT_V = 'reject_v';
    const STATUS_REQUEST_O = 'accept_v';
    const STATUS_ACCEPT_O = 'accept_o';
    const STATUS_REJECT_O = 'reject_o';

    public function company()
    {
    	return $this->belongsTo('App\Company' , 'company_id');
    }

    public function visitor()
    {
        return $this->belongsTo('App\User' , 'visitor_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\User' , 'customer_id');
    }

    public function products()
    {
    	return $this->belongsToMany('App\Product' , 'product_order' , 'order_id' , 'product_id')
                ->withPivot('num' , 'price');
    }

    public function closed()
    {
        return $this->status == self::STATUS_ACCEPT_O ||
                $this->status == self::STATUS_REJECT_O ;
    }

    public function getStatusLabel($status)
    {
        $statuses = [
            self::STATUS_ACCEPT_O => '<span class="label label-accept-o">تایید مدیر</span>' ,
            self::STATUS_REJECT_O => '<span class="label label-reject-o">مدیر رد کرد' ,
            self::STATUS_REQUEST_O => '<span class="label label-request-o">تایید ویزیتور<' ,
            self::STATUS_ACCEPT_V => '<span class="label label-request-o">تایید ویزیتور</span>' ,
            self::STATUS_REQUEST_V => '<span class="label label-request-v">در انتظار ویزیتور</span>' ,
            self::STATUS_REJECT_V => '<span class="label label-reject-v">ویزیتور رد کرد' ,
        ];
        return $statuses[$status];
    }
}
