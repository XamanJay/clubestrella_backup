<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Password;
use App\Mail\resetPassword;
//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use App\User;
use App;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;



    public function requestToken(Request $request)
    {
        $rules = [
            'email' => 'required|email'
        ];

        $message = [
            'email.required' => 'Es necesario ingresar tu email',
            'email.email' => 'Formato de correo invalido'
        ];

        $this->validate($request,$rules,$message);

        $user = User::where('email',$request->email)->get();
        if($user->isEmpty()){
            return back()->with('error','Este correo no se encuentra registrado');
        }
        $token = Str::random(60);
        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);
        $url = url('es/reset-password');
        Mail::to($user[0]->email)->send(new resetPassword($user[0],$token,$url));

        return back()->with('status','El correo se envio exitosamente, verifica tu bandeja de entrada!!');

    }
        
    
    //GET para mostrar el formulario despues de dar click en el mail
    public function showResetForm(Request $request,$locale,$token)
    {
        return view('auth.reset_mail')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    //POST para resetear el password
    public function resetEmail(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $user = User::where('email',$request->email)->get();
        if(!$user->isEmpty())
        {
            $token_db = DB::table('password_resets')->where('token', $request->token)->get();
            //dd(Carbon::parse($token_db->created_at)->addSeconds(60));
            if(!$token_db->isEmpty()){
                if(Carbon::parse($token_db[0]->created_at)->addSeconds(3600)->isPast())
                {
                    return back()->withErrors([
                        'email' => 'El token expiró'
                    ]);
                }
                DB::update('update users set password = ?, remember_token = ? where email = ?', [Hash::make($request->password),Str::random(60),$user[0]->email]);
                return redirect()->route('welcome',App::getLocale())->with('status','Tu password se reseteó exitosamente!!');
            }
            return back()->withErrors([
                'email' => 'Token Invalido'
            ]);
        }
        return back()->withErrors([
            'email' => 'Email Invalido'
        ]);
    }

   
}
