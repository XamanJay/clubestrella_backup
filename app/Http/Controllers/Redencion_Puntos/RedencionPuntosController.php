<?php

namespace App\Http\Controllers\Redencion_Puntos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Traits\ApiMessages;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Puntos;
use App\Regalo;
use App\Header;
use App\Rendencion_Puntos;
use App\Puntos_Tracker;
use App\Puntos_Dobles;

use DateTime;

use App\Mail\NotifyReward;
use App\Mail\recepcionNotify;
use App\Mail\NotifyAllotment;
use Mail;


class RedencionPuntosController extends Controller
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
            $cliente = User::with('puntosRedimidos')->findorFail($id);
            return $this->successResponse('success',$cliente,200);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }

    public function store(Request $request)
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
            $canjes = array();
            $cont = 0;
            $apuntador = 1;
            $status = "success";
            $puntos_dobles = Puntos_Dobles::first();
            
            foreach ($request->product['id'] as $id) {

                $reward = Regalo::findorFail($id);
                $user = User::with('cliente')->findorFail($request->user_id);
                $qty = $request->product['qty'][$cont];
                $tags = json_decode($reward->tag);
                $noches =  NULL;
                $cuartos = NULL;
                $checkIn = NULL;
                $checkOut = NULL;
                
                if(in_array("room", $tags)){
                    
                    $cuartos = 1;
                    /*$startDate= explode("-", $request->startDate[$apuntador-1]);
                    $endDate= explode("-", $request->endDate[$apuntador-1]);
                    $startDate_custom = $startDate[1]."-".$startDate[0]."-".$startDate[2];
                    $endDate_custom = $endDate[1]."-".$endDate[0]."-".$endDate[2];*/

                    
                    $checkIn = new DateTime($request->startDate[0]);
                    $checkOut = new DateTime($request->endDate[0]);
                    $interval = $checkIn->diff($checkOut);
                    $noches = (int)$interval->format('%a');//now do whatever you like with $days
                    if($noches > $qty){
                        return $this->errorResponse('error','El numero de noches excede la cantidad seleccionada',300);
                    }

                    $verify_startDate = DB::table('stop_sale_clubestrella')
                            ->whereDate('endDate','>=', $checkIn)
                            ->whereDate('startDate','<=', $checkOut)
                            ->where('deleted_at',NULL)
                            ->get();
                    if(!$verify_startDate->isEmpty()){
                        return $this->errorResponse('error','No se puede reservar en esta fecha ya que se encuentra en un StopSale',301);
                    }


                    $habitacion_ep = DB::connection('mysql3')->table('rooms')->where('id', 1)->first();
                    if($habitacion_ep->quantity == 0){
                        return $this->errorResponse('error','Lo sentimos no hay habitaciones disponibles en este momento, intente mas tarde o comuniquese a reservaciones',305);
                    }

                    $canje = new Rendencion_Puntos();
                    $canje->comentarios = "Canje de puntos ClubEstrella";
                    $canje->puntos = ($puntos_dobles->puntos_dobles) ? ($reward->puntos * (int)$qty)*2 : ($reward->puntos * (int)$qty);
                    $canje->fecha_redencion = now();
                    $canje->comentarios = "Reward canjeada el dia ".now()." por medio de puntos Club Estrella";
                    $canje->fecha_inicio = $checkIn;
                    $canje->fecha_salida = $checkOut;
                    $canje->cuartos = $cuartos;
                    $canje->noches =$qty;
                    $canje->representante = $request->representante;
                    $canje->user_id = $user->id;
                    $canje->regalo_id = $reward->id;
                    $canje->cantidad = $qty;


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

                    $puntos_totales = intval($puntos_disponibles[0]->puntos) - (intval($puntos_gastados[0]->puntos) + $canje->puntos);
                    if($puntos_totales < 0){
                        $status = "error";
                        break;
                    }else{

                        $puntos_track = new Puntos_Tracker();
                        $puntos_track->puntos_cargados = $canje->puntos;
                        $puntos_track->puntos_old = intval($puntos_totales);
                        $puntos_track->user_id = $user->id;
                        $puntos_track->save();

                        $puntos = Puntos::where('user_id','=',$user->id)->get();
                        $puntos[0]->puntos_acumulados = intval($puntos_disponibles[0]->puntos);
                        $puntos[0]->puntos_totales = intval($puntos_totales);
                        $puntos[0]->puntos_gastados = (intval($puntos_gastados[0]->puntos) + $canje->puntos);
                        $puntos[0]->save();

                        $canje->save();
                        array_push($canjes,$canje);
                    }
                    $detalle = "<strong>Hotel: </strong>Adhara Cancun <br/>
                    <strong>Tipo de Habitación: </strong> Habitación Estandar<br/>
                    <strong>Plan de Alimentos: </strong> Solo Habitación<br/>
                    <strong>Fecha de LLegada: </strong> ".$request->startDate[0]."<br/>
                    <strong>Fecha de Salida: </strong> ".$request->endDate[0]."<br/>
                    <strong>Adultos: </strong> 1<br/>
                    <strong>Niños: </strong> 0<br/>";
                    DB::connection('mysql3')->table('huespedes')->insert([
                        'nombre' => $user->nombre,
                        'apellido' => $user->apellidos,
                        'correo' => $user->email,
                        'telefono' => $user->cliente->celular,
                        'pais' => $user->cliente->pais,
                        'ciudad' => $user->cliente->ciudad,
                        'comments' => 'Reserva valida solo para una habitacion pagada con puntos Club Estrella',
                        'isClub' => 1
                    ]);
                    $huesped = DB::connection('mysql3')->table('huespedes')->orderBy('id', 'desc')->first();
                    DB::connection('mysql3')->table('transactions')->insert([
                        'price' => $canje->puntos,
                        'costoProv' => 0,
                        'currency' => 'PTS',
                        'formaPago' => 'Club Estrella',
                        'cardType' => 'Club Estrella',
                        'estatus' => 3,
                        'dateTransaction' => now()
                    ]);
                    $transaction = DB::connection('mysql3')->table('transactions')->orderBy('id', 'desc')->first();
                    DB::connection('mysql3')->table('reservations')->insert([
                        'idClient' => $huesped->id,
                        'idTransaction' => $transaction->id,
                        'dateFrom' => $checkIn,
                        'dateTo' => $checkOut,
                        'idRoom' => 1,
                        'detalles' => $detalle,
                        'responsable' => $request->representante,
                        'notas' => 'Valido solo para 1 Hab y maximo 2 adultos, persona mayo a esta cantidad se cobra el extra',
                        'servicio' => 'Hotel',
                        'hotel' => 'Adhara Cancún',
                        'service_type' => 1,
                        'idOpera' => "#00-00",
                        'response_email' => 'no_errores',
                        'isDeleted' => 0,
                        'club_id' => $canje->id

                    ]);
                    $reservation = DB::connection('mysql3')->table('reservations')->orderBy('id', 'desc')->first();
                    DB::connection('mysql3')->table('roomreserva')->insert([
                        'room_reserva' => $reservation->id,
                        'idRoom' => 1,
                    ]);

                    $update_allotment = DB::connection('mysql3')->table('rooms')
                        ->where('id', 1)
                        ->update(['quantity' => ($habitacion_ep->quantity-1)]);
                    
                    $check_allotment = DB::connection('mysql3')->table('rooms')->where('id', 1)->first();
                    if($check_allotment->quantity == 0){
                        Mail::to('reservaciones@gphoteles.com')
                        ->bcc(['programacionweb@gphoteles.com','fabiola@oktravel.mx','ventas@gphoteles.com','ecommerce@gphoteles.com'])
                        ->send(new NotifyAllotment($canje->id,$user));
                    } 

                    Mail::to($user->email)->send(new NotifyReward($canje->id));

                    Mail::to('reservaciones@gphoteles.com')
                        ->bcc(['programacionweb@gphoteles.com','fabiola@oktravel.mx','ventas@gphoteles.com','ecommerce@gphoteles.com','recepcion.adhara@gphoteles.com'])
                        ->send(new recepcionNotify($canje->id,$user));
                
                    
                }else
                {
                    $puntos = 0;
                    if($request->has('puntos')){
                        $puntos = $request->puntos;
                    }else{
                        $puntos = ($puntos_dobles->puntos_dobles) ? ($reward->puntos * (int)$qty)*2 : ($reward->puntos * (int)$qty);
                    }
                        
                    $canje = new Rendencion_Puntos();
                    $canje->comentarios = "Canje de puntos ClubEstrella";
                    $canje->puntos = $puntos;
                    $canje->fecha_redencion = now();
                    $canje->comentarios = "Reward canjeada el dia ".now()." por medio de puntos Club Estrella";
                    $canje->fecha_inicio = $checkIn;
                    $canje->fecha_salida = $checkOut;
                    $canje->cuartos = $cuartos;
                    $canje->noches =$noches;
                    $canje->representante = $request->representante;
                    $canje->user_id = $user->id;
                    $canje->regalo_id = $reward->id;
                    $canje->cantidad = $qty;
    
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

                    $puntos_totales = intval($puntos_disponibles[0]->puntos) - (intval($puntos_gastados[0]->puntos) + $canje->puntos);
                    if($puntos_totales < 0){
                        $status = "error";
                        break;
                    }else{

                        $puntos_track = new Puntos_Tracker();
                        $puntos_track->puntos_cargados = $canje->puntos;
                        $puntos_track->puntos_old = intval($puntos_totales);
                        $puntos_track->user_id = $user->id;
                        $puntos_track->save();

                        $puntos = Puntos::where('user_id','=',$user->id)->get();
                        $puntos[0]->puntos_acumulados = intval($puntos_disponibles[0]->puntos);
                        $puntos[0]->puntos_totales = intval($puntos_totales);
                        $puntos[0]->puntos_gastados = (intval($puntos_gastados[0]->puntos) + $canje->puntos);
                        $puntos[0]->save();

                        $canje->save();
                        array_push($canjes,$canje);
                    }
                    Mail::to($user->email)->send(new NotifyReward($canje->id));

                    Mail::to('recepcion.adhara@gphoteles.com')
                        ->bcc(['programacionweb@gphoteles.com','fabiola@oktravel.mx','ventas@gphoteles.com','ecommerce@gphoteles.com',])
                        ->send(new recepcionNotify($canje->id,$user));
                }   
            }
            
            if($status == "error"){
                return $this->errorResponse('error','No cuentas con puntos suficientes para esta acción',302);
            }else{
                return $this->successResponse('success',$canjes,200);
            }

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        } 
    }
}
