<?php

namespace App\Http\Controllers\Devoluciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Traits\ApiMessages;

use App\Mail\DevolucionNotify;
use App\Mail\DevolucionGPHoteles;
use Mail;

use App\User;
use App\Puntos;
use App\Header;
use App\Regalo;
use App\Devolucion;
use App\Puntos_Tracker;
use App\Rendencion_Puntos;

class DevolucionController extends Controller
{
    use ApiMessages; 

    public function index(Request $request,$id)
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
            $code = 200;
            $message = "El cliente no cuenta con devoluciones.";
            $data = NULL;
            $user = User::findorFail($id);
            $devoluciones = Devolucion::where('user_id','=',$id)->get();
    
            if(!$devoluciones->isEmpty()){
                $message = "El cliente cuenta con devoluciones.";
                $data = $devoluciones;
            }
            return $this->successResponse($message,$data,$code);

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
            $devolucion = Devolucion::findorFail($id);
            return $this->successResponse("Devolución encontrada.",$devolucion,200);
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
                'puntos_id' => 'required',

            ];
            $messages =[
                'puntos_id.required' => 'Error con el id del cargo que se quiere devolver.',
            ];
            $this->validate($request,$rules,$messages);

            $code = 404;
            $message = "Error al generar la devolución.";
            $data = NULL;
            $reservation = [
                '0' => NULL
            ];
            $user = User::findorFail($id);
            $back_cargo = Devolucion::where('puntos_id','=',$request->puntos_id)->get();
            if(!$back_cargo->isEmpty()){
                $message = "Este cargo ya se devolvió.";
                $code = 300;
            }else{

                $puntos_redimidos = Rendencion_Puntos::where('id','=',(int)$request->puntos_id)->where('user_id','=',$user->id)->get();
    
                if($puntos_redimidos->isEmpty()){
                    $message = "El cargo que se quiere devolver no existe o no pertenece a este usuario.";
                }else{

                    $regalo = Regalo::find($puntos_redimidos[0]->regalo_id);
                    $tags = json_decode($regalo->tag);
                    
                    $devolucion = new Devolucion();
                    $devolucion->user_id = $user->id;
                    $devolucion->puntos_id = $puntos_redimidos[0]->id;
                    $devolucion->puntos = $puntos_redimidos[0]->puntos;
                    $devolucion->representante = $request->representante ?? "Admin Club";
                    $devolucion->save();
                    /* EN CASO DE QUE LA DEVOLUCION SEA UNA HABITACION SE PROCEDE A CAMBIAR EL ESTATUS EN LA BD DE ADHARA */
                    if(in_array("room", $tags)){
                        $reservation = DB::connection('mysql3')->table('reservations')->where('club_id', $puntos_redimidos[0]->id)->get();
                        DB::connection('mysql3')->table('transactions')
                            ->where('id', $reservation[0]->idTransaction)
                            ->update(['estatus' => 5]);
                    }
                    /* FIN DEL PROCESO */
                    $puntos_redimidos[0]->delete();

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
                    $puntos = Puntos::where('user_id','=',$user->id)->get();

                    $puntos_totales = intval($puntos_disponibles[0]->puntos) - intval($puntos_gastados[0]->puntos);

                    $puntos_track = new Puntos_Tracker();
                    $puntos_track->puntos_cargados = $puntos_totales;
                    $puntos_track->puntos_old = $puntos[0]->puntos_totales;
                    $puntos_track->user_id = $user->id;
                    $puntos_track->save();

                    
                    $puntos[0]->puntos_acumulados = intval($puntos_disponibles[0]->puntos);
                    $puntos[0]->puntos_totales = $puntos_totales;
                    $puntos[0]->puntos_gastados = intval($puntos_gastados[0]->puntos);
                    $puntos[0]->save();
                    
                    $code = 200;
                    $message = "Devolución generada con éxito.";
                    $data = $devolucion;

                    Mail::to($user->email)->send(new DevolucionNotify($puntos_redimidos[0],$user,$regalo,$reservation[0]));
                    
                    Mail::to('reservaciones@gphoteles.com')
                        ->bcc(['programacionweb@gphoteles.com','fabiola@oktravel.mx','ventas@gphoteles.com','ecommerce@gphoteles.com'])
                        ->send(new DevolucionGPHoteles($puntos_redimidos[0],$user,$regalo,$reservation[0]));
                }
                
            }
            return response()->json(["message"=>$message,'data'=>$data,'code'=>$code],$code);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }

    public function restore(Request $request,$id)
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
                'puntos_id' => 'required',

            ];
            $messages =[
                'puntos_id.required' => 'Error con el id del cargo que se quiere devolver.',
            ];
            $this->validate($request,$rules,$messages);

            $user = User::findorFail($id);
            
            $puntos = Puntos::where('user_id',$user->id)->get();
            $devolucion = Devolucion::findorFail($request->puntos_id);
            $restore_canje = Rendencion_Puntos::onlyTrashed()->findorFail($devolucion->puntos_id);
            $result = $puntos[0]->puntos_totales - $devolucion->puntos;
            if($result < 0){
                return $this->errorResponse('error','No cuentas con los puntos suficientes para realizar esta acción',305);
            }
            $devolucion->delete();
            $restore_canje->restore();

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

            $puntos = Puntos::where('user_id','=',$user->id)->get();

            $puntos_totales = intval($puntos_disponibles[0]->puntos) - intval($puntos_gastados[0]->puntos);

            $puntos_track = new Puntos_Tracker();
            $puntos_track->puntos_cargados = $puntos_totales;
            $puntos_track->puntos_old = $puntos[0]->puntos_totales;
            $puntos_track->user_id = $user->id;
            $puntos_track->save();

            
            $puntos[0]->puntos_acumulados = intval($puntos_disponibles[0]->puntos);
            $puntos[0]->puntos_totales = $puntos_totales;
            $puntos[0]->puntos_gastados = intval($puntos_gastados[0]->puntos);
            $puntos[0]->save();

            return $this->successResponse('El canje se restauro exitosamente',$puntos_totales,200);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }
}
