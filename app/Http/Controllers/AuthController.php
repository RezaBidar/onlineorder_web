<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth ;
use Session;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
        else{
            Session::flash('error' , 'نام کاربری یا کلمه ی عبور اشتباه است');
            return redirect('login') ;
        }
    }

    /**
     * Show sing in page
     */
    public function login()
    {
    	return view('auth.login');
    }

    /**
     * Logout user and redirect it to login page
     */
    public function logout()
    {
    	Auth::logout();
    	return redirect('login');
    }
}
