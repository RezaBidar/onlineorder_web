<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{

    const TYPE_ADMIN = 'admin' ;
    const TYPE_OPERATOR = 'operator' ;
    const TYPE_VISITOR = 'visitor' ;
    const TYPE_CUSTOMER = 'customer' ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'type', 'pic', 'tel'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function companies()
    {
        return $this->belongsToMany('App\Company' , 'user_company' , 'user_id' , 'company_id')->withPivot('id', 'visitor_id','score','customer_status');
    }

    public function categories()
    {
        return $this->belongsToMany('App\CustomerCat' , 'user_category' , 'user_id' , 'category_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order' , 'customer_id') ;
    }



    /**
     * check this user is admin or not
     * @return boolean 
     */
    public function isAdmin()
    {
        return $this->type == self::TYPE_ADMIN ;
    }

    public function isVisitor()
    {
        return $this->type == self::TYPE_VISITOR ;
    }

    public function isOperator()
    {
        return $this->type == self::TYPE_OPERATOR ;
    }

    public function isInCompany($companyId)
    {
        $companies = $this->companies ;
        foreach ($companies as $company) {
            if($company->id == $companyId)
                return true;
        }
        return false ;
    }

    public function getCompany()
    {
        $companies = $this->companies ;
        foreach ($companies as $company) {
            return $company ;
        }
        return null ;   
    }

    public function getVisitor($company = '')
    {
        $company = ($company) ? $company : $this->getCompany() ;

        return User::findOrFail($company->pivot->visitor_id);
    }

    public function customers()
    {
        return $this->belongsToMany('App\User' , 'user_company' , 'visitor_id' , 'user_id')->withPivot('id', 'company_id','score','customer_status');
    }

    public function deletePic()
    {
        if($this->pic != null && is_file('pic/avatars/' . $this->pic ))        
            unlink('pic/avatars/' . $this->pic);
    }


}
