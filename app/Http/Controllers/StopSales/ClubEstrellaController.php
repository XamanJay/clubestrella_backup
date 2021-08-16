<?php

namespace App\Http\Controllers\StopSales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;
use App\Traits\ApiMessages;
use Illuminate\Support\Facades\Hash;

use DateTime;
use App\Header;

class ClubEstrellaController extends Controller
{
    use ApiMessages;

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

            $verify_startDate = DB::table('stop_sale_clubestrella')
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
}
