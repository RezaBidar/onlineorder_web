<?php

namespace App\Http\Middleware;

use App\User ;
use Closure;

class AuthenticateWithApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(!$request->has('api'))
            return response(json_encode(['error' => 'api code is invalid']) , 200 );

        $customer = User::where(['api' => $request->input('api')])->first();
        

        if(sizeof($customer) == 0)
            return response(json_encode(['error' => 'api code is invalid']) , 200 );
        
        $request->customer = $customer ;

        return $next($request);
    }
}
