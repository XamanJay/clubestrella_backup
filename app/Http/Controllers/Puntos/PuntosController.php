<?php

namespace App\Http\Controllers\Puntos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;

use App\Traits\ApiMessages;
use Illuminate\Support\Facades\Hash;


use App\User;
use App\Puntos;
use App\Header;
use App\Carga_Puntos;
use App\Redencion_Puntos;
use App\Puntos_Tracker;

class PuntosController extends Controller
{
    use ApiMessages; 

    public function showPuntos(Request $request,$id)
    {
        $header_user = $request->header('x-user');
        $header_secret = $request->header('x-secret');
        if($header_user == NULL){
            return $this->errorResponse('Header User missing',NULL,500);
        }
        if($header_secret == NULL){
            return $this->errorResponse('Header Secret missing',NULL,500);
        }

        $header = Header::where('header_user',$header_user)->get();
        if(Hash::check($header_secret, $header[0]->header_secret))
        {
            $user = User::findOrFail($id);
            $cliente = Puntos::where('user_id',$user->id)->first();
            return $this->successResponse('success',$cliente,200);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
        
    }

    public function show(Request $request,$id)
    {
        $header_user = $request->header('x-user');
        $header_secret = $request->header('x-secret');
        if($header_user == NULL){
            return $this->errorResponse('Header User missing',NULL,500);
        }
        if($header_secret == NULL){
            return $this->errorResponse('Header Secret missing',NULL,500);
        }

        $header = Header::where('header_user',$header_user)->get();
        if(Hash::check($header_secret, $header[0]->header_secret))
        {
            $cliente = User::with('puntos')->findorFail($id);
            return $this->successResponse('success',$cliente,200);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
        
    }

    public function puntosCargados(Request $request,$id)
    {
        $header_user = $request->header('x-user');
        $header_secret = $request->header('x-secret');
        if($header_user == NULL){
            return $this->errorResponse('Header User missing',NULL,500);
        }
        if($header_secret == NULL){
            return $this->errorResponse('Header Secret missing',NULL,500);
        }

        $header = Header::where('header_user',$header_user)->get();
        if(Hash::check($header_secret, $header[0]->header_secret))
        {
            $cliente = User::with('puntosCargados')->findorFail($id);
            return $this->successResponse('success',$cliente,200);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }   
    }

    public function puntosVencidos(Request $request,$id)
    {
        $header_user = $request->header('x-user');
        $header_secret = $request->header('x-secret');
        if($header_user == NULL){
            return $this->errorResponse('Header User missing',NULL,500);
        }
        if($header_secret == NULL){
            return $this->errorResponse('Header Secret missing',NULL,500);
        }

        $header = Header::where('header_user',$header_user)->get();
        if(Hash::check($header_secret, $header[0]->header_secret))
        {
            $cliente = User::with('puntosVencidos')->findorFail($id);
            return $this->successResponse('success',$cliente,200);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
        
    }

    public function store(Request $request,$id)
    {
        $header_user = $request->header('x-user');
        $header_secret = $request->header('x-secret');
        if($header_user == NULL){
            return $this->errorResponse('Header User missing',NULL,500);
        }
        if($header_secret == NULL){
            return $this->errorResponse('Header Secret missing',NULL,500);
        }

        $header = Header::where('header_user',$header_user)->get();
        if(Hash::check($header_secret, $header[0]->header_secret))
        {
            $rules = [
                'folio_fiscal' => 'required',
                'rfc' => 'required',
                'puntos' => 'required',

            ];
            $messages =[
                'folio_fiscal.required' => 'Es necesario asignar el folio fiscal de la factura.',
                'rfc.required' => 'Es necesario asignar el RFC de la persona o empresa que factura.',
                'puntos.required' => 'Es necesario asignar los puntos de la factura.',
            ];
            $this->validate($request,$rules,$messages);

            $date = date('Y-m-d', strtotime('+1 year'));
            $user = User::find($id);
            $carga_puntos = new Carga_Puntos();

            if($user == NULL){
                return response()->json(['data'=>NULL,'message'=>'Usuario/contraseña Inválidas.','code'=>404],404);
            }else{

                $folio_fiscal = trim($request->folio_fiscal);
                $folio = DB::table('carga_puntos')->where('factura_folio','=',$folio_fiscal)->get();
                //dd($folio);
                if(!$folio->isEmpty()){
                    return response()->json(['data'=>NULL,'message'=>'Este folio ya se encuentra registrado.','code'=>303],303);
                }
    
                $carga_puntos->factura_folio = $folio_fiscal;
                $carga_puntos->rfc = trim($request->rfc);
                $carga_puntos->referencia = 'PHO8803074X4';
                $carga_puntos->fecha_carga = now();
                $carga_puntos->puntos = trim($request->puntos);
                $carga_puntos->comentarios = $request->comentarios;
                $carga_puntos->user_id = $user->id;
                ($user->rol_id == 4) ? $carga_puntos->puntos_expira = NULL : $carga_puntos->puntos_expira = $date;
                $carga_puntos->save();

                $puntos_disponibles = DB::table('carga_puntos')
                    ->selectRaw('sum(puntos) as puntos')
                    ->where('user_id', $user->id)
                    ->where('deleted_at', NULL)
                    ->get('puntos');

                $puntos_gastados = DB::table('redencion_puntos')
                    ->selectRaw('sum(puntos) as puntos')
                    ->where('user_id', $user->id)
                    ->where('deleted_at', NULL)
                    ->get();

                $puntos_devueltos = DB::table('devoluciones')
                    ->selectRaw('sum(puntos) as puntos')
                    ->where('user_id', $user->id)
                    ->where('deleted_at', NULL)
                    ->get();
                
                $puntos_restore = 0;
                if(!$puntos_devueltos->isEmpty()){
                    $puntos_restore = $puntos_devueltos[0]->puntos;
                }
                if($puntos_devueltos[0]->puntos == NULL){
                    $puntos_restore = 0;
                }

                $puntos = Puntos::where('user_id','=',$user->id)->get();

                $puntos_track = new Puntos_Tracker();
                $puntos_track->puntos_cargados = $request->puntos;
                $puntos_track->puntos_old = intval($puntos_disponibles[0]->puntos);
                $puntos_track->user_id = $user->id;
                $puntos_track->save();

                $puntos_totales = intval($puntos_disponibles[0]->puntos) - intval($puntos_gastados[0]->puntos);

                $puntos[0]->puntos_acumulados = intval($puntos_disponibles[0]->puntos);
                $puntos[0]->puntos_totales = intval($puntos_totales);
                $puntos[0]->puntos_gastados = intval($puntos_gastados[0]->puntos);
                $puntos[0]->save();

                //dd(intval($puntos_disponibles[0]->puntos).' - '.intval($puntos_redimidos[0]->puntos).' = '.$puntos_totales);
                return response()->json(['data'=>$carga_puntos,'message'=>'La factura se cargó correctamente.','code'=>200],200);
            }

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }

    public function update(Request $request,$id)
    {
        $header_user = $request->header('x-user');
        $header_secret = $request->header('x-secret');
        if($header_user == NULL){
            return $this->errorResponse('Header User missing',NULL,500);
        }
        if($header_secret == NULL){
            return $this->errorResponse('Header Secret missing',NULL,500);
        }

        $header = Header::where('header_user',$header_user)->get();
        if(Hash::check($header_secret, $header[0]->header_secret))
        {
            $rules = [
                'folio_fiscal' => 'required',
                'rfc' => 'required',
                'referencia' => 'required',
                'fecha' => 'required',
                'puntos' => 'required',

            ];
            $messages =[
                'folio_fiscal.required' => 'Es necesario asignar el folio fiscal de la factura.',
                'rfc.required' => 'Es necesario asignar el RFC de la persona o empresa que factura.',
                'referencia.required' => 'Es necesario asignar el RFC de la empresa que expide la factura.',
                'fecha.required' => 'Es necesario asignar la fecha en que se realizó la factura',
                'puntos.required' => 'Es necesario asignar los puntos de la factura.',
            ];
            $this->validate($request,$rules,$messages);

            
            $carga_puntos = Carga_Puntos::find($id);
            $user = User::find($carga_puntos->user_id);

            if($user == NULL){
                return response()->json(['data' => NULL,'message'=>'Usuario Inválido.','code'=>404],404);
            }else{
    
                $carga_puntos->factura_folio = trim($request->folio_fiscal);
                $carga_puntos->rfc = trim($request->rfc);
                $carga_puntos->referencia = trim($request->referencia);
                $carga_puntos->fecha_carga = $request->fecha;
                $carga_puntos->puntos = trim($request->puntos);
                $carga_puntos->comentarios = $request->comentarios;
                $carga_puntos->user_id = $user->id;
                ($user->rol == 4) ? $carga_puntos->puntos_expira = NULL : $carga_puntos->puntos_expira = $date;
                $carga_puntos->save();

                $puntos_disponibles = DB::table('carga_puntos')
                    ->selectRaw('sum(puntos) as puntos')
                    ->where('user_id', $user->id)
                    ->where('deleted_at', NULL)
                    ->get('puntos');

                $puntos_gastados = DB::table('redencion_puntos')
                    ->selectRaw('sum(puntos) as puntos')
                    ->where('user_id', $user->id)
                    ->where('deleted_at', NULL)
                    ->get();

                $puntos_devueltos = DB::table('devoluciones')
                    ->selectRaw('sum(puntos) as puntos')
                    ->where('user_id', $user->id)
                    ->where('deleted_at', NULL)
                    ->get();
                
                $puntos_restore = 0;
                if(!$puntos_devueltos->isEmpty()){
                    $puntos_restore = $puntos_devueltos[0]->puntos;
                }
                if($puntos_devueltos[0]->puntos == NULL){
                    $puntos_restore = 0;
                }

                $puntos = Puntos::where('user_id','=',$user->id)->get();
        
                $puntos_track = new Puntos_Tracker();
                $puntos_track->puntos_cargados = $request->puntos;
                $puntos_track->puntos_old = $puntos_disponibles;
                $puntos_track->user_id = $user->id;
                $puntos_track->save();


                $puntos_totales = intval($puntos_disponibles[0]->puntos) - intval($puntos_redimidos[0]->puntos);

                $puntos[0]->puntos_acumulados = intval($puntos_disponibles[0]->puntos);
                $puntos[0]->puntos_totales = intval($puntos_totales);
                $puntos[0]->puntos_gastados = intval($puntos_redimidos[0]->puntos);
                $puntos[0]->save();
                return response()->json(['data'=>$carga_puntos,'message'=>'La factura se actualizó correcto.','code'=>200],200);
                
            }

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
        
    }

    public function sumPuntos(Request $request,$id)
    {
        $header_user = $request->header('x-user');
        $header_secret = $request->header('x-secret');
        if($header_user == NULL){
            return $this->errorResponse('Header User missing',NULL,500);
        }
        if($header_secret == NULL){
            return $this->errorResponse('Header Secret missing',NULL,500);
        }

        $header = Header::where('header_user',$header_user)->get();
        if(Hash::check($header_secret, $header[0]->header_secret))
        {
            $puntos_disponibles = DB::table('carga_puntos')
                ->selectRaw('sum(puntos) as puntos')
                ->where('user_id', $id)
                ->where('deleted_at', NULL)
                ->get('puntos');

            $puntos_gastados = DB::table('redencion_puntos')
                ->selectRaw('sum(puntos) as puntos')
                ->where('user_id', $id)
                ->where('deleted_at', NULL)
                ->get();

            $puntos_devueltos = DB::table('devoluciones')
                ->selectRaw('sum(puntos) as puntos')
                ->where('user_id', $id)
                ->where('deleted_at', NULL)
                ->get();

            $puntos =[
                'puntos_cargados' => $puntos_disponibles,
                'canjes' => $puntos_gastados,
                'devoluciones' => $puntos_devueltos
            ];

            $puntos = Puntos::where('user_id',$id)->get();

            $puntos_track = new Puntos_Tracker();
            $puntos_track->puntos_cargados = $puntos_disponibles[0]->puntos - $puntos_gastados[0]->puntos;
            $puntos_track->puntos_old = $puntos[0]->puntos_acumulados;
            $puntos_track->user_id = $id;
            $puntos_track->save();

            $puntos[0]->puntos_acumulados = $puntos_disponibles[0]->puntos;
            $puntos[0]->puntos_gastados = $puntos_gastados[0]->puntos;
            $puntos[0]->puntos_totales = $puntos_disponibles[0]->puntos - $puntos_gastados[0]->puntos;
            $puntos[0]->save();

            $user = User::with('cliente','puntos')->findorFail($id);

            return $this->successResponse('Exito en la sumatoria de puntos',$user,200);

        }else {
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }
}
