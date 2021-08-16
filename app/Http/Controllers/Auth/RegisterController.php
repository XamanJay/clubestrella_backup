<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App;
use App\User;
use App\Header;
use App\Pais;
use Illuminate\Http\Request;
//Para conexiones a la API
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;

//use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        $paises = Pais::all();
        return view('auth.register')->with([
            'paises' => $paises
        ]);
    }

    public function register(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email',
            'celular' => 'numeric|min:8',
            'password' => 'required|confirmed'
        ];
        $messages = [
            'nombre.required' => trans('messages.nameRule'),
            'apellidos.required' => trans('messages.lastnameRule'),
            'email.required' => trans('messages.emailRule'),
            'email.mail' => trans('messages.emailSintaxis'),
            'celular.required' => trans('messages.phoneRule'),
            'celular.min' => trans('messages.phoneMin'),
            'password.required' => trans('messages.passwordRule'),
            'password.confirmed' => trans('messages.passwordConfirm'),
        ];
        $this->validate($request,$rules,$messages);
        
        $url = url('/');
 
        $response = Http::withHeaders([
            'X-User' => 'clubestrella',
            'X-Secret' => 'S0port*2020'
        ])->asForm()->post($url.'/api/clientes',[
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => $request->password,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'estado' => $request->estado,
            'ciudad' => $request->ciudad,
            'pais' => $request->pais,
            'password_confirmation' => $request->password_confirmation,
            'cp' => $request->cp,
            'empresa' => $request->empresa,
            'rfc_companny' => $request->rfc_company
        ]);
        
        $data = $response->json();
        //dd($data);
        if($data['code'] == 422){
            return back()->with('warnings','Error con los inputs');
        }
        if($data['code'] == 300){
            return back()->with('user_error',trans('auth.userExist'));
        }

        Auth::loginUsingId($data['data']['id']);

        return redirect('/'.App::getLocale().'/home');


    }
}
