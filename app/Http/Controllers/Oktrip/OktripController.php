<?php

namespace App\Http\Controllers\Oktrip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class OktripController extends Controller
{
    public function index()
    {
        
        $response = Http::get('http://oktrip-api.azurewebsites.net/api/Reservations');
        $data = $response->json();
        if($data['code'] != 200){
            return response()->json([
                'status' => 'error',
                'message' => 'Error del API',
                'data' => NULL,
                'code' => 500
            ],500);
        }else{
            $admins = DB::connection('mysql4')->table('admins')->get();
            dd($admins);
        }
    }

    public function store(Request $request)
    {
        
    }
}
