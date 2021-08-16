<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        
        $email = $request->email;
        $password =Hash::make($request->password);
        $credentials =array(
            'email' => $email,
            'password' => $password
        );
        //dd(Auth::attempt($credentials));

        $user = User::where('email','=',$request->email)->get();
        if(!$user->isEmpty()){
            
            if (Hash::check($request->password, $user[0]->password)) {
                //dd($user);
                Auth::loginUsingId($user[0]->id, true);
                //dd(Auth::loginUsingId($user[0]->id, true));
                return redirect()->intended(App::getLocale().'/home');
            }else{
                return back()->with('error', trans('messages.loginFail'));
                //return back()->with('error','Email o password incorrectos');
            }
        }else{
            return back()->with('error', trans('messages.loginFail'));
        }
    }

    public function qr(){
        return view('auth.qr');
    }

    public function qrLogin(Request $request)
    {
        $rules = [
            'qr_card' => 'required'
        ];

        $messages = [
            'qr_card.required' => 'Error al escanear tu tarjeta, intenta de nuevo'
        ];

        $this->validate($request,$rules,$messages);

        $collection = Str::of($request->qr_card)->explode('_');
        $user_token = Str::of($collection[0])->replace('?', '_');
        //dd($user_token);

        $user = User::where('user_token',$user_token)->get();
        if(!$user->isEmpty())
        {
            Auth::loginUsingId($user[0]->id);
            return response()->json(['success' => 'Login exitoso','code' => 200]);
        }else{
            return response()->json(['error' => 'Error al escanear su tarjeta, si el problema persiste favor de iniciar sesion manualmente', 'code' => 500]);
        }
    }
    public function logout(Request $request,$locale)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/'.App::getLocale());
    }
}
