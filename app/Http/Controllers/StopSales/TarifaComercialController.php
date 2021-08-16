<?php

namespace App\Http\Controllers\StopSales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;
use App\Traits\ApiMessages;
use Illuminate\Support\Facades\Hash;
use App\Temporada;


use DateTime;
use App\Header;

class TarifaComercialController extends Controller
{
    use ApiMessages;

    public function show(Request $request)
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
                'startDate' => 'required',
                'endDate' => 'required',
            ];

            $messages = [
                'startDate.required' => 'Es necesario asignar una fecha de inicio',
                'endDate.required' => 'Es necesario asignar una fecha de termino',
            ];

            $this->validate($request,$rules,$messages);

            $startDate = new DateTime($request->startDate);
            $endDate = new DateTime($request->endDate);

            $verify_dates = DB::table('temporada_comercial')
                    ->whereDate('fecha_inicio', '<=',$startDate)
                    ->whereDate('fecha_termino', '>=',$endDate)
                    ->where('deleted_at',NULL)
                    ->get();
    
            if(!$verify_dates->isEmpty()){
                return $this->successResponse('success',$verify_dates,200);
            }
            else{
                return $this->errorResponse('error','No existe una temporada para clientes comerciales para esta fecha',300);
            }

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
        
    }

    public function verify(Request $request)
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
                'startDate' => 'required'
            ];

            $messages = [
                'startDate.required' => 'Es necesario asignar una fecha de inicio'
            ];

            $this->validate($request,$rules,$messages);

            $startDate = new DateTime($request->startDate);

            $verify_startDate = DB::table('stop_tarifa_comercial')
                    ->whereDate('endDate','>=', $startDate)
                    ->where('deleted_at',NULL)
                    ->get();
            if(!$verify_startDate->isEmpty()){
                return $this->errorResponse('error','No se puede reservar en esta fecha ya que se encuentra en un StopSale',300);
            }
            else{
                return $this->successResponse('success','Se puede reservar en estas fechas',200);
            }

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
            $rules = [
                'startDate' => 'required',
                'endDate' => 'required',
                'tarifa_base' => 'required',
                'tarifa_pax' => 'required',
                'tarifa_alimentos' => 'required',
                'tarifa_upgrade_habitacion' => 'required',
                'hotel_id' => 'required'
            ];

            $messages = [
                'startDate.required' => 'Asigna una fecha de inicio',
                'endDate.required' => 'Asigna una fecha de termino',
                'tarifa_base.required' => 'Asigna una tarifa base',
                'tarifa_pax.required' => 'Asigna una tarifa para persona',
                'tarifa_alimentos.required' => 'Asigna una tarifa para alimentos',
                'tarifa_upgrade_habitacion.required' => 'Asigna una tarifa para hacer upgrade en habitacion',
                'hotel_id.required' => 'Asigna un hotel a la temporada',
            ];

            $this->validate($request,$rules,$messages);

            $startDate = new DateTime($request->startDate);
            $endDate = new DateTime($request->endDate);

            $verify_startDate = DB::table('temporada_comercial')
                    ->whereDate('fecha_inicio','<', $endDate)
                    ->where('deleted_at',NULL)
                    ->get();


            if($verify_startDate->isEmpty())
            {
                $temporada = new Temporada();
                $temporada->fecha_inicio = $startDate;
                $temporada->fecha_termino = $endDate;
                $temporada->tarifa_base = floatval($request->tarifa_base);
                $temporada->tarifa_pax = floatval($request->tarifa_pax);
                $temporada->tarifa_alimentos = floatval($request->tarifa_alimentos);
                $temporada->tarifa_upgrade_habitacion = floatval($request->tarifa_upgrade_habitacion);
                $temporada->hotel_id = $request->hotel_id;
                
                $temporada->save();

                return $this->successResponse('success','La temporada se cargó con exito!!',200);
            }
            else{
                //return back()->with('error','La fechas ya se encuentran registradas o se traslapan con otra Temporada');
                return $this->errorResponse('La fechas ya se encuentran registradas o se traslapan con otra Temporada',NULL,500);
            }
        }
        

    }
}
