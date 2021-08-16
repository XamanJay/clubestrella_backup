<?php

namespace App\Http\Controllers\Dashboard\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App;
use Redirect;
use App\User;
use App\Regalo;
use App\Pais;
use App\Devolucion;
use App\Carga_Puntos;
use App\Rendencion_Puntos;
use DateTime;


class ClienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
     
    }

    
    public function index()
    {
        $id = Auth::id();
        $data = getUser($id);

        $recompensas = Regalo::where('custom','!=',NULL)->where('nombre','!=','Oktrip')->get();

        return view('cliente.recompensas',[
            'recompensas' => $recompensas,
            'response' => $data
        ]);
    }

    public function postCheckOut(Request $request)
    {
        $rules = [
            'items_check' => 'required',

        ];
        $messages =[
            'items_check.required' => 'Es necesario agregar productos para proceder al canje.'
        ];

        $response = $this->validate($request,$rules,$messages);


        return redirect()->route('payment', ['locale' => App::getLocale()]);
    }

    public function payment()
    {
        $rewards = NULL;
        $list_rewards = array();
        $id_item = array();

        if(Cookie::get('products') != NULL){ 

            $rewards = json_decode(Cookie::get('products'));
                foreach ($rewards as $reward_id) {
                $reward = Regalo::find($reward_id->id);
                array_push($list_rewards,$reward);
                array_push($id_item,$reward->id);
            }

            json_encode($id_item);
        }

        return view('cliente.checkout',[
            'list_rewards' => $list_rewards,
            'rewards' => $rewards,
            'id_item' => $id_item
        ]);
    }

    public function postPayment(Request $request){
  
        $startDate = NULL;
        $endDate = NULL;
        $url = url('/');
        $id = Auth::id();
        if ($request->has('startDate')) {
            $startDate = $request->startDate;
        }
        if($request->has('endDate')){
            $endDate = $request->endDate;
        }
        $response = Http::withHeaders([
            'X-User' => 'clubestrella',
            'X-Secret' => 'S0port*2020'
        ])->asForm()->post($url.'/api/redencion_puntos',[
            'product[id]' => $request->product['id'],
            'product[qty]' => $request->product['qty'],
            'startDate' => $startDate,
            'endDate' => $endDate,
            'user_id' => $id,
            'representante' => 'Cliente'
        ]);

        $data = $response->json();
        $status = "error";
        $message = NULL;
        if($data['code'] == 404){
            $message = $data['error'];
        }
        if($data['code'] == 300){
            $message = trans('checkout.overNights');
        }
        if($data['code'] == 301){
            $message = trans('checkout.stopSale');
        }
        if($data['code'] == 305){
            $message = trans('checkout.stopSale');
        }
        if($data['code'] == 303){
            $message = trans('checkout.duplicated');
        }
        if($data['code'] == 200){
            $status = "success";
            $message = trans('checkout.success');
        }
        if($data['code'] == 500){
            $message = 'Error  de Autenticacion con headers';
        }

        Cookie::queue(Cookie::forget('products'));
        Cookie::queue(Cookie::forget('total-points'));
        Cookie::queue(Cookie::forget('minus-points'));
        return back()->with($status,$message);
    }

    public function estadoCuenta()
    {
        $id = Auth::id();
        $user = getUser($id);
        return view('cliente.estado_cuenta',[
            'user' => $user
        ]);
    }

    public function info(){
        $id = Auth::id();
        $user = getUser($id);

        return view('cliente.info',[
            'user' => $user,
        ]);
    }

    public function perfil()
    {
        $id = Auth::id();
        $data = getUser($id);
        $paises = Pais::all();

        return view('cliente.perfil',[
            'response' => $data,
            'paises' => $paises
        ]);
    }

    public function updatePerfil(Request $request)
    {
        $rules =[
            'nombre' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'phone' => 'required',
            'cp' => 'required'
        ];

        $messages = [
            'nombre.required' => trans('messages.nameRule'),
            'lastname.required' => trans('messages.lastnameRule'),
            'email.required' => trans('messages.emailRule'),
            'email.email' => trans('messages.emailSintaxis'),
            'country.required' => trans('messages.countryRule'),
            'city.required' => trans('messages.cityRule'),
            'state.required' => trans('messages.stateRule'),
            'phone.required' => trans('messages.phoneRule'),
            'cp.required' => trans('messages.cpRule')
        ];

        $this->validate($request,$rules,$messages);

        $user = User::with('cliente')->find(Auth::id());
        $user->nombre = trim($request->nombre);
        $user->apellidos = trim($request->lastname);
        $user->email = trim($request->email);
        $user->cliente->pais = $request->country;
        $user->cliente->ciudad = trim($request->city);
        $user->cliente->estado = trim($request->state);
        $user->cliente->direccion = trim($request->address);
        $user->cliente->celular = trim($request->phone);
        $user->cliente->empresa = trim($request->company);
        $user->cliente->rfc_company = trim($request->rfc_company);
        $user->push();
        
        return back()->with('success','Tus datos de actualizaron correctamente.');

    }


}
function getUser($id)
{
    $url = url('/');
    $response = Http::withHeaders([
        'X-User' => 'clubestrella',
        'X-Secret' => 'S0port*2020'
    ])->get($url.'/api/clientes/'.$id);
    return $response->json();
}




