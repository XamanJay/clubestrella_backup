<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\User;
use App\Pais;
use App\Regalo;
use App\Rol;
use App\Puntos_Dobles;
use App\Categoria;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
     
    }
    public function index($locale)
    {
        return view('dashboard.index');
    }

    public function cliente($locale,$id)
    {
        $user =User::with('cliente')->find($id);
        $paises = Pais::all();
        return view('dashboard.update-cliente')->with([
            'user' => $user ,
            'paises' => $paises
        ]);
    }

    public function update(Request $request,$locale,$id)
    {
        $rules = [
            'nombre' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email',
            'celular' => 'required|min:8',
            'pais' => 'required'

        ];

        $messages = [
            'nombre.required' => 'Nombre Inválido',
            'apellidos.required' => 'Apellidos Inválidos',
            'email.required' => 'Es necesario agregar un email',
            'email.email' => 'Formato invalido de email',
            'celular.required' => 'Celular Inválido',
            'celular.max' => 'Celular minimo 8 dígitos',
            'pais.required' => 'País Inválido'
        ];

        $this->validate($request,$rules,$messages);

        $url_server = url('/');

        $response = Http::withHeaders([
            'X-User' => 'clubestrella',
            'X-Secret' => 'S0port*2020'
        ])->asForm()->post($url_server.'/api/clientes/'.$id,[
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'celular' => $request->celular,
            'pais' => $request->pais,
            'estado' => $request->estado,
            'ciudad' => $request->ciudad,
            'cp' => $request->cp,
            'empresa' => $request->empresa,
            'rfc_company' => $request->rfc_company,
            'direccion' => $request->direccion
        ]);

        $data = $response->json();
        $message = "error";
        $response_msg = array();
        if($data['code'] == 200){
            $message = "success";
            array_push($response_msg,'Los datos se actualizaron exitosamente');
        }

        if($data['code'] == 422){
            $response_msg = $data['error']['nombre'];
        }

        if($data['code'] == 404){
            array_push($response_msg,$data['error']);
        }

        return back()->with($message,$response_msg);
    }

    public function puntos($locale,$id){

        $user =User::with('cliente','puntos')->find($id);

        return view('dashboard.puntos')->with([
            'user' => $user
        ]);
    }

    public function updateDevolucion(Request $request,$locale,$id)
    {
        $url_server = url('/');
        $response = Http::withHeaders([
            'X-User' => 'clubestrella',
            'X-Secret' => 'S0port*2020'
        ])->asForm()->post($url_server.'/api/devolucion/'.$id,[
            'puntos_id' => $request->puntos_id,
            'representante' => $request->representante
        ]);

        $data = $response->json();
        return response()->json($data);
    }

    public function restoreCanje(Request $request,$locale,$id)
    {
        $url_server = url('/');
        $response = Http::withHeaders([
            'X-User' => 'clubestrella',
            'X-Secret' => 'S0port*2020'
        ])->asForm()->post($url_server.'/api/restore-canje/'.$id,[
            'puntos_id' => $request->puntos_id,
        ]);

        $data = $response->json();
        return response()->json($data);
    }

    public function cargaPuntos($locale, $id)
    {
        $user = User::find($id);

        return view('dashboard.carga_puntos')->with([
            'user' => $user
        ]);
    }

    public function storePuntos(Request $request,$locale,$id)
    {
        $rules = [
            'factura_folio' => 'required',
            'rfc' => 'required',
            'puntos' => 'required'
        ];

        $messages = [
            'factura_folio.required' => 'Es necesario asignar el FOLIO de la factura',
            'rfc.required' => 'Es necesario asignar el RFC del cliente/empresa',
            'puntos.required' => 'Es necesario asignar el monto de puntos de la factura'
        ];

        $this->validate($request,$rules,$messages);

        $user = User::find($id);
        $url_server = url('/');

        $response = Http::withHeaders([
            'X-User' => 'clubestrella',
            'X-Secret' => 'S0port*2020'
        ])->asForm()->post($url_server.'/api/puntos/'.$user->id,[
            'folio_fiscal' => $request->factura_folio,
            'rfc' => $request->rfc,
            'puntos' => $request->puntos
        ]);

        $data = $response->json();

        if($data['code'] == 200)
        {
            return back()->with('success','El alta de puntos se realizó exitosamente');
        }

        if($data['code'] == 500)
        {
            return back()->with('error','Error inesperado intentarlo mas tarde o contactar al encargado de la página');
        }

        if($data['code'] == 303)
        {
            return back()->with('error','Esta factura ya se registró previamente');
        }
    }

    public function canje($locale,$id)
    {
        $user = User::find($id);
        $premios = Regalo::where('custom','=',true)->get();

        return view('dashboard.canje_premio')->with([
            'user' => $user,
            'premios' => $premios
        ]);
    }

    public function storeCanje(Request $request,$locale,$id)
    {
        $url_server = url('/');
        $startDate = NULL;
        $endDate = NULL;
        $user = User::find($id);
        if ($request->has('startDate')) {
            $startDate = $request->startDate;
        }
        if($request->has('endDate')){
            $endDate = $request->endDate;
        }
        $representante = Auth::user()->nombre." ".Auth::user()->apellidos;
        

        $response = Http::withHeaders([
            'X-User' => 'clubestrella',
            'X-Secret' => 'S0port*2020'
        ])->asForm()->post($url_server.'/api/redencion_puntos',[
            'product' => $request->product,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'user_id' => $user->id,
            'representante' => $representante
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
        if($data['code'] == 302){
            $message = trans('checkout.noPoints');
        }
        if($data['code'] == 200){
            $status = "success";
            $message = trans('checkout.success');
        }
        if($data['code'] == 301)
        {
            $message = trans('checkout.stopSale');
        }
        if($data['code'] == 500){
            $message = $data['error'];
        }

        return back()->with($status,$message);
    }

    public function editRol($locale,$id)
    {
        $user = User::find($id);
        $roles = Rol::all();
        return view('dashboard.update_rol')->with([
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function updateRol(Request $request,$locale,$id)
    {
        $rules = [
            'rol_id' => 'required'
        ];

        $messages = [
            'rol_id.required' => 'Es necesario que selecciones un rol'
        ];

        $this->validate($request,$rules,$messages);

        $user = User::find($id);
        $user->rol_id = $request->rol_id;
        $user->save();

        return back()->with('success','El Rol se actualizo correctamente!!');
    }

    public function puntosDobles()
    {
        $puntos_dobles = Puntos_Dobles::first();

        return view('dashboard.puntos_dobles')->with([
            'puntos_dobles' => $puntos_dobles
        ]);
    }

    public function updatePuntosDobles(Request $request)
    {
        $rules = [
            'puntos_dobles' => 'required'
        ];

        $messages = [
            'puntos_dobles.required' => 'Es necesario que habilites/deshabilites los Puntos Dobles'
        ];

        $this->validate($request,$rules,$messages);

        $puntos_dobles = Puntos_Dobles::first();
        $puntos_dobles->puntos_dobles = $request->puntos_dobles;
        $puntos_dobles->save();

        return back()->with('success','Puntos Dobles actualizados!!');
    }

    public function premiosClub()
    {
        $recompensas = Regalo::where('custom','!=',NULL)->get();

        return view('dashboard.premios_club')->with([
            'recompensas' => $recompensas
        ]);
    }

    public function editPremioClub($locale,$id)
    {
        $regalo = Regalo::find($id);
        $categorias = Categoria::all();
        $tags_custom = [
            'clubestrella',
            'eventos',
            'adhara',
            'room'
        ];

        return view('dashboard.update_premio')->with([
            'regalo' => $regalo,
            'tags_custom' => $tags_custom,
            'categorias' => $categorias
        ]);
    }

    public function updatePremioClub(Request $request,$locale,$id)
    {
        $rules = [
            'nombre' => 'required',
            'puntos' => 'required|numeric',
            'categoria_id' => 'required',
            'tag' => 'required'
        ];

        $messages = [
            'nombre.required' => 'Es necesario asignar un nombre el Premio',
            'puntos.required' => 'Es necesario asignar una cantidad de puntos al Premio',
            'puntos.numeric' => 'Formato Invalido de puntos',
            'categoria_id.required' => 'Es necesario asignar la categoria a la que pertenece el Premio',
            'tag.required' => 'Es necesario asignarle una etiqueta al Premio'
        ];

        $this->validate($request,$rules,$messages);

        $url = url('/');
        $response = Http::withHeaders([
            'X-User' => 'clubestrella',
            'X-Secret' => 'S0port*2020'
        ])->asForm()->post($url.'/api/premios/'.$id,[
            'nombre' => $request->nombre,
            'puntos' => $request->puntos,
            'categoria_id' => $request->categoria_id,
            'descripcion' => $request->descripcion,
            'tags' => $request->tag
        ]);

        $data = $response->json();
        if($data['code'] == 200)
        {
            return back()->with('success',$data['message']);
        }
        if($data['code'] == 204)
        {
            return back()->with('success',$data['message']);
        }
        if($data['code'] = 404)
        {
            return back()->with('error',$data['message']);
        }
    }

    public function destroyRegalo(Request $request)
    {
        $url = url('/');
        $response = Http::withHeaders([
            'X-User' => 'clubestrella',
            'X-Secret' => 'S0port*2020'
        ])->delete($url.'/api/premios/'.$request->regalo_id);

        return $response->json();
    }

    public function tarjetasClub(){
        return view('dashboard.tarjetas_clientes');
    }
}
