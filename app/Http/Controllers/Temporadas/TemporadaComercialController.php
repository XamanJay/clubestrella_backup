<?php

namespace App\Http\Controllers\Temporadas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;

use App\Temporada;
use App\Hoteles;
use DateTime;

class TemporadaComercialController extends Controller
{
    public function index()
    {
        return view('dashboard.temporadas');
    }

    public function create()
    {
        $hoteles = Hoteles::all();
        return view('dashboard.new-temporada')->with([
            'hoteles' => $hoteles
        ]);
    }

    public function store(Request $request)
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

            return back()->with('success','La temporada se cargó con exito!!');
        }
        else{
            return back()->with('error','La fechas ya se encuentran registradas o se traslapan con otra Temporada');
        }

    }

    public function destroy($locale,$id)
    {
        $temporada = Temporada::find($id);
        $temporada->delete();
        return back()->with('success','La temporada se eliminó correctamente!!');
    }
}
