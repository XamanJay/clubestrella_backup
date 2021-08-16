<?php

namespace App\Http\Controllers\QR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class QRController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
     
    }

    public function index()
    {
        return view('cliente.qr_factura');
    }

    public function store(Request $request)
    {
        $rules = [
            'factura' => 'required'
        ];

        $messages = [
            'factura.required' => 'Error al escanear su factura, intente de nuevo'
        ];

        $gph = 'PHO8803074X4';

        $this->validate($request,$rules,$messages);

        $id = Auth::id();

        $collection = Str::of($request->factura)->explode('¿');
        $str_folio_fiscal = Str::of($collection[1])->explode('/');
        $collection_folio_fiscal = Str::of($str_folio_fiscal[0])->explode("'");
        $folio_fiscal = "";
        foreach ($collection_folio_fiscal as $item) {
            $folio_fiscal = $folio_fiscal.$item;
        }
        $gph_str = Str::of($collection[2])->explode('/');
        $gph_rfc = $gph_str[0];
        if($gph_rfc != $gph)
        {
            return back()->with('error','Lo sentimos pero esta factura no pertenece a la familia de Club Estrella');
        }
        $cliente_str = Str::of($collection[3])->explode('/');
        $cliente_rfc = $cliente_str[0];
        $puntos_str = Str::of($collection[4])->explode('/');
        $puntos = (int)$puntos_str[0];

        
        $url_server = url('/');

        $response = Http::withHeaders([
            'X-User' => 'clubestrella',
            'X-Secret' => 'S0port*2020'
        ])->asForm()->post($url_server.'/api/puntos/'.$id,[
            'folio_fiscal' => $folio_fiscal,
            'rfc' => $cliente_rfc,
            'puntos' => $puntos
        ]);

        $data = $response->json();

        if($data['code'] == 200)
        {
            return response()->json([
                'message' => 'El alta de puntos se realizó exitosamente',
                'code' => 200
            ]);
        }

        if($data['code'] == 303)
        {
            return response()->json([
                'message' => 'Esta factura ya se encuentra registrada',
                'code' => 303
            ]);
        }

        if($data['code'] == 500)
        {
            return response()->json([
                'message' => 'Error inesperado intentarlo mas tarde o contactar con recepción',
                'code' => 500
            ]);
        }
    }
}
