<?php

namespace App\Http\Controllers\Cuenta_Comercial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiMessages;

use App\Cuenta_Comercial;
use App\Header;

class CuentaComercialController extends Controller
{
    use ApiMessages;

    public function index($locale)
    {
        $empresas = Cuenta_Comercial::all();

        return view('dashboard.cuenta_comercial')->with([
            'empresas' => $empresas
        ]);
    }

    public function show($locale,$id)
    {
        $empresa = Cuenta_Comercial::find($id);

        return view('dashboard.update-empresa')->with([
            'empresa' => $empresa
        ]);
    }

    public function update(Request $request,$locale,$id)
    {
        $rules = [
            'numero_cuenta' => "required",
            'nombre_cuenta' => "required",
            'rfc_company' => "required"
        ];

        $messages = [
            'numero_cuenta.required' => "Es necesario asignar un numero de cuenta/contrato",
            'nombre_cuenta.required' => "Es necesario asignar el nombre de la empresa",
            'rfc_company.required' => "Es necesario asignar el RFC de la compañia"
        ];

        $this->validate($request,$rules,$messages);

        $empresa = Cuenta_Comercial::find($id);
        $empresa->numero_cuenta = $request->numero_cuenta;
        $empresa->nombre_cuenta = $request->nombre_cuenta;
        $empresa->ciudad = $request->ciudad;
        $empresa->limite_credito = $request->limite_credito;
        $empresa->company_rfc = $request->rfc_company;
        $empresa->razon_social = $request->razon_social;
        $empresa->credito_habitacion = $request->credito_habitacion;
        $empresa->credito_alimentos = $request->credito_alimentos;
        $empresa->save();

        return back()->with('success',"La Cuenta Comercial se actualizó exitosamente!");
    }

    public function create()
    {
        return view('dashboard.new-empresa');
    }

    public function store(Request $request)
    {
        $rules = [
            'numero_cuenta' => "required",
            'nombre_cuenta' => "required",
            'company_rfc' => "required"
        ];

        $messages = [
            'numero_cuenta.required' => "Es necesario asignar un numero de cuenta/contrato",
            'nombre_cuenta.required' => "Es necesario asignar el nombre de la empresa",
            'company_rfc.required' => "Es necesario asignar el RFC de la compañia"
        ];

        $this->validate($request,$rules,$messages);

        $empresa = new Cuenta_Comercial();
        $empresa->numero_cuenta = $request->numero_cuenta;
        $empresa->nombre_cuenta = $request->nombre_cuenta;
        $empresa->ciudad = $request->ciudad;
        $empresa->limite_credito = $request->limite_credito;
        $empresa->company_rfc = $request->company_rfc;
        $empresa->razon_social = $request->razon_social;
        $empresa->credito_habitacion = $request->credito_habitacion;
        $empresa->credito_alimentos = $request->credito_alimentos;
        $empresa->save();

        return back()->with('success',"La Cuenta Comercial se creó exitosamente!");
    }

    public function delete($locale,$id)
    {
        $cuenta = Cuenta_Comercial::find($id);
        if($cuenta == null){
            return back()->with('error','La cuenta que trata de eliminar no existe');
        }else
        {
            $cuenta->delete();
            return back()->with('success','La cuenta se elimino correctamente');
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
                'rfc' => 'required'
            ];

            $messages = [
                'rfc.required' => 'Es necesario asignar un RFC'
            ];

            $this->validate($request,$rules,$messages);

            $cuenta_comercial = Cuenta_Comercial::where('company_rfc','=',$request->rfc)->get();
            if($cuenta_comercial->isEmpty())
            {
                return $this->errorResponse('error',['rfc'=>'Este RFC no esta registrado'],404);
            }
            return $this->successResponse('success',$cuenta_comercial,200);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }

    public function importExcel($locale)
    {
        $targetPath = public_path('xls/empresa_clubestrella.xlsx');
        $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadSheet = $Reader->load($targetPath);
        $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        $count = 0;
        foreach ($spreadSheetAry as $cuenta_comercial) {
            
            if($count != 0){
                $prev = Cuenta_Comercial::where('company_rfc',$cuenta_comercial[4])->get();
                if(!$prev->isEmpty())
                {
                    foreach($prev as $item)
                    {
                        $item->codigo = $cuenta_comercial[0];
                        $item->razon_social = $cuenta_comercial[1];
                        $item->nombre_cuenta = $cuenta_comercial[2];
                        $item->srv = $cuenta_comercial[6];
                        $item->src = $cuenta_comercial[7];
                        $item->cro = $cuenta_comercial[8];
                        $item->save();
                    }
                }else
                {
                    $empresa = new Cuenta_Comercial();
                    $empresa->codigo = $cuenta_comercial[0];
                    $empresa->numero_cuenta = '000000';
                    $empresa->nombre_cuenta = ($cuenta_comercial[2] == NULL) ? 'Necesito Nombre' : $cuenta_comercial[2];
                    $empresa->ciudad = 'Cancun';
                    $empresa->ar = NULL;
                    $empresa->limite_credito = NULL;
                    $empresa->company_rfc = $cuenta_comercial[4];
                    $empresa->razon_social = $cuenta_comercial[1];
                    $empresa->credito_habitacion = FALSE;
                    $empresa->credito_alimentos = FALSE;
                    $empresa->save();
                }
                
            }else {
                # code...
                echo "<br>";
                print_r($cuenta_comercial);
                echo "<br><br>";
            }
            $count++;
        }
    }

    public function importArpon()
    {
        $targetPath = public_path('xls/cuenta_arpon.xlsx');
        $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadSheet = $Reader->load($targetPath);
        $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        $count = 0;
        foreach ($spreadSheetAry as $cuenta_comercial) {
            if($count >= 1){

                $empresa = new Cuenta_Comercial();
                $empresa->numero_cuenta = ($cuenta_comercial[0] == NULL) ? '000000' : $cuenta_comercial[0];
                $empresa->nombre_cuenta = ($cuenta_comercial[1] == NULL) ? 'Necesito Nombre' : $cuenta_comercial[1];
                $empresa->ciudad = ($cuenta_comercial[2] == NULL) ? NULL : 'Cancun';
                $empresa->ar = ($cuenta_comercial[3] == NULL) ? NULL : NULL;
                $empresa->limite_credito = ($cuenta_comercial[4] == NULL) ? NULL : 0;
                $empresa->company_rfc = ($cuenta_comercial[6] == NULL) ? NULL : $cuenta_comercial[4];
                $empresa->razon_social = ($cuenta_comercial[7] == NULL) ? NULL : $cuenta_comercial[2];
                $empresa->credito_habitacion = ($cuenta_comercial[4] == NULL) ? FALSE : FALSE;
                $empresa->credito_alimentos = ($cuenta_comercial[4] == NULL) ? FALSE : FALSE;
                $empresa->save();
            }else{
                # code...
                echo "<br>";
                print_r($cuenta_comercial);
                echo "<br><br>";
            }
            $count++;
        }
    }
}
