<?php

namespace App\Http\Controllers\ConversionPuntos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;
//Para Hashear las contraseñas
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Traits\ApiMessages;

use App\Header;
use App\Divisa;

class ConversionPuntosController extends Controller
{
    use ApiMessages;

    public function index(Request $request,$currency,$amount)
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
            $result =  Str::of(Str::of($currency)->lower())->upper();

            $divisa = Divisa::where('currency',$result)->first();
            $item = Divisa::where('currency','!=',$result)->first();

            //dd($item);
            if($divisa != null)
            {
                $valor_puntos_request = 0;
                $valor_puntos = 0;
                $total_request = 0;
                $total = 0;
                $tasa_conversion = 0;

                if($divisa->currency == "MXN")
                {
                    $valor_puntos_request = round(($amount / 20),2); // Cuanto equivalen los puntos que se mandan en el request en MXN
                    $valor_puntos = round(($amount / 20) / $item->valor); // Cuanto equivalen los puntos que se mandan en el request en USD
                    $tasa_conversion = 20;
                }
                else if($divisa->currency == 'USD')
                {
                    $valor_puntos_request = round(($amount / 400) ,2); // Cuanto equivalen los puntos que se mandan en el request en USD
                    $valor_puntos = round($amount / 20); // Cuanto equivalen los puntos que se mandan en el request en MXN
                    $tasa_conversion = 400;
                }

                // $1 MXN - 20 puntos
                // $1 USD - 40 puntos

                $data = [
                    'puntos' => $amount,
                    'currency' => $divisa->currency,
                    'total' => $valor_puntos_request,
                    'puntos_x_'.$divisa->currency => $tasa_conversion,
                    //'valor_puntos_en_'.$item->currency => $valor_puntos

                ];
                return $this->successResponse('success',$data,200);

            }else{
                return $this->errorResponse('Divisa no encontrada',NULL,404);
            }

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        } 
    }

    public function moneyToPoints(Request $request,$currency,$amount)
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
            $result =  Str::of(Str::of($currency)->lower())->upper();

            $divisa = Divisa::where('currency',$result)->first();
            $item = Divisa::where('currency','!=',$result)->first();

            //dd($item);
            if($divisa != null)
            {
                $valor_puntos_request = 0;
                $valor_puntos = 0;
                $total_request = 0;
                $total = 0;
                $tasa_conversion = 0;

                if($divisa->currency == "MXN")
                {
                    $valor_puntos_request = round(($amount * 20),2); // Cuanto equivalen los puntos que se mandan en el request en MXN
                    //$valor_puntos = round(($amount / 20) / $item->valor); // Cuanto equivalen los puntos que se mandan en el request en USD
                    $tasa_conversion = 20;
                }
                else if($divisa->currency == 'USD')
                {
                    $valor_puntos_request = round(($amount * 400),2); // Cuanto equivalen los puntos que se mandan en el request en USD
                    //$valor_puntos = round($amount / 20); // Cuanto equivalen los puntos que se mandan en el request en MXN
                    $tasa_conversion = 400;
                }

                // $1 MXN - 20 puntos
                // $1 USD - 400 puntos

                $data = [
                    'total' => $amount,
                    'currency' => $divisa->currency,
                    'puntos' => $valor_puntos_request,
                    'puntos_x_'.$divisa->currency => $tasa_conversion,
                    //'valor_puntos_en_'.$item->currency => $valor_puntos

                ];
                return $this->successResponse('success',$data,200);

            }else{
                return $this->errorResponse('Divisa no encontrada',NULL,404);
            }

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        } 
    }
}
