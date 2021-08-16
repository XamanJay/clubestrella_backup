<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App;
use App\User;

class AdminController extends Controller
{
    public function login($locale){
        return view('admin.login');
    }


    public function postLogin(Request $request,$locale)
    {
        //dd('here');
        $email = trim($request->email);
        $password =Hash::make($request->password);
        $credentials =array(
            'email' => $email,
            'password' => $password
        );

        $user = User::where('email','=',$request->email)->get();
        if(!$user->isEmpty()){
            
            if (Hash::check($request->password, $user[0]->password)) {
                //dd($user[0]->rol->nombre);
                if($user[0]->rol->nombre != 'Cliente'){

                    Auth::loginUsingId($user[0]->id, true);
                    return redirect()->intended(App::getLocale().'/dashboard');
                }else{
                    return back()->with('error',trans('messages.privilege'));
                }
                
            }else{
                return back()->with('error', trans('messages.loginFail'));
            }
        }else{
            return back()->with('error', trans('messages.userNotFound'));
        }
    }
}
