<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;

use DateTime;
use App\StopSale_ClubEstrella;

class StopSaleClubEstrellaController extends Controller
{
    public function index()
    {
        $stopSales = StopSale_Clubestrella::all();

        return view('dashboard.stop_sale_clubestrella')->with([
            'stopSales' => $stopSales
        ]);
    }

    public function create()
    {
        return view('dashboard.new_stop_sale_clubestrella');
    }

    public function store(Request $request)
    {
        $rules = [
            'startDate' => 'required',
            'endDate' => 'required'
        ];

        $messages = [
            'startDate.required' => 'Asigna una fecha de inicio',
            'endDate.required' => 'Asigna una fecha de termino'
        ];

        $this->validate($request,$rules,$messages);
        $startDate = new DateTime($request->startDate);

        $verify_startDate = DB::table('stop_sale_clubestrella')
                ->whereDate('endDate','>=', $startDate)
                ->where('deleted_at',NULL)
                ->get();
        if(!$verify_startDate->isEmpty()){

            return back()->with('error','Esta fecha ya esta registrada o se traslapa con alguna otra StopSale');
        }

        $stopSale = new StopSale_Clubestrella();
        $stopSale->startDate = $startDate;
        $stopSale->endDate = new DateTime($request->endDate);
        $stopSale->save();

        return back()->with('success','El StopSale se guardó exitosamente');
    }

    public function destroy($locale,$id)
    {
        $stopSale = StopSale_Clubestrella::find($id);
        $stopSale->delete();
        return back()->with('success','El stopSale se borró con exito!!');
    }
}
