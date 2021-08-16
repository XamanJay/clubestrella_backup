<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;
//Para Hashear las contraseñas
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiMessages;
use Illuminate\Support\Str;
use App\Mail\resetPassword;
use Illuminate\Support\Carbon;

use App\Mail\WelcomeClient;

//Modelos
use App\User;
use App\Pais;
use Mail;
use App\Cliente;
use App\Header;
use App\Repetido;
use App\Puntos;
use App\Categoria;
use App\Carga_Puntos;
use App\Rendencion_Puntos;



class ClientesController extends Controller
{
    use ApiMessages;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
            $clientes = User::with('cliente','puntos')->get();
            return $this->successResponse('success',$clientes,200);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                'nombre' => 'required',
                'apellidos' => 'required',
                'email' => 'required|email',
                'celular' => 'required|digits:10',
                'pais' => 'required',
                'password' => 'required|confirmed'

            ];
            $messages =[
                'nombre.required' => 'Es necesario asignar un nombre.',
                'apellidos.required' => 'Es necesario asignar apellidos.',
                'email.required' => 'Es necesario asignar un email.',
                'email.email' => 'Email invalido.',
                'celular.required' => 'Es necesario asignar un Celular.',
                'celular.min' => 'Celular invalido solo 10 digitos.',
                'pais.required' => 'Indicar de que pais proviene.',
                'password.required' => 'Ingresa una password',
                'password.confirmed' => 'Las contraseñas no concuerdan'
            ];
            $this->validate($request,$rules,$messages);

            $data = Cliente::orderBy('numero_socio', 'desc')->first();
            $verify = User::where('email','=',trim($request->email))->get();
            if($verify->isEmpty()){

                $user = new User();
                $user->nombre = trim($request->nombre);
                $user->apellidos = trim($request->apellidos);
                $user->email = trim($request->email);
                $user->user_token = uniqid("user_",true);
                $user->password = Hash::make($request->password);
                $user->rol_id = 4;
                $user->save();

                $puntos = new Puntos();
                $puntos->user_id = $user->id;
                $puntos->puntos_acumulados = 0;
                $puntos->puntos_gastados = 0;
                $puntos->puntos_totales = 0;
                $puntos->save();


                $cliente = new Cliente();
                $cliente->numero_socio = ($data == NULL) ? 1 : $data->numero_socio +1;
                $cliente->empresa = $request->empresa ?? 'Por definir';
                $cliente->direccion = $request->direccion ?? 'Por definir';
                $cliente->ciudad = $request->ciudad ?? 'Por definir';
                $cliente->pais = $request->pais ?? "Por definir";
                $cliente->estado = $request->estado ?? 'Por definir';
                $cliente->celular = $request->celular;
                $cliente->cp = $request->cp ?? 0000;
                $cliente->qr_code = $user->user_token.'?';
                $cliente->categoria_id = 1;
                $cliente->user_id = $user->id;
                $cliente->puntos_id = $puntos->id;
                $cliente->rfc_company = $request->rfc_company ?? 'XXXXX-XX';
                $cliente->save();

                $user =User::with('cliente')->findorFail($user->id);

                Mail::to($user->email)->send(new WelcomeClient($user));

                return $this->successResponse('El usuario se creó exitosamente.',$user,200);

            }else{
                return $this->errorResponse('El correo ya existe en la base de datos',NULL,300);
            }
        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            $cliente = User::with('cliente','puntos')->findorFail($id);
            return $this->successResponse('success',$cliente,200);
        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
                'nombre' => 'required',
                'apellidos' => 'required',
                'email' => 'required|email',
                'celular' => 'required|digits:10',
                'estado' => 'required',
                'pais' => 'required',

            ];
            $messages =[
                'nombre.required' => 'Es necesario asignar un nombre.',
                'apellidos.required' => 'Es necesario asignar apellidos.',
                'email.required' => 'Es necesario asignar un email.',
                'email.email' => 'Email invalido.',
                'celular.required' => 'Es necesario asignar un Celular.',
                'celular.min' => 'Celular invalido solo 10 digitos.',
                'estado.required' => 'Proporciona el Estado donde vives.',
                'pais.required' => 'Indicar de que pais proviene.',
            ];
            $this->validate($request,$rules,$messages);

            $user =User::with('cliente')->findorFail($id);
            $user->nombre = trim($request->nombre);
            $user->apellidos = trim($request->apellidos);
            $user->email = trim($request->email);
            $user->cliente->empresa = trim($request->empresa);
            $user->cliente->direccion = $request->direccion;
            $user->cliente->ciudad = trim($request->ciudad);
            $user->cliente->pais = trim($request->pais);
            $user->cliente->estado = trim($request->estado);
            $user->cliente->celular = trim($request->celular);
            $user->cliente->cp = trim($request->cp);
            $user->cliente->rfc_company = trim($request->rfc_company);
            $user->push();
            
            $user =User::with('cliente')->findorFail($id);
            return $this->successResponse('El cliente se actualizó correctamente',$user,200);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
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
            $user = User::findorFail($id);
            $user->delete();
            return $this->successResponse('El cliente se eliminó correctamente',$user,200);

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
            $user = User::onlyTrashed()->findorFail($id);
            $user->restore();
            return $this->successResponse('El cliente se restauró correctamente',$user,200);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
        
    }


    public function login(Request $request)
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
            if($request->has('email')){
                $email = trim($request->email);
                $user = User::where('email','=',$email)->get();
                if(!$user->isEmpty()){   
                    return $this->successResponse('success',$user,200);
                }else{
                    return $this->errorResponse('error','El correo no esta registrado',404);
                }
            }else{
                return $this->errorResponse('error','Input no soportado',500);
            }

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        } 
    }


    public function loginAdhara(Request $request)
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
            if($request->has('email')){
                $email = trim($request->email);
                $user = User::with('cliente','puntos')->where('email','=',$email)->get();
                if(!$user->isEmpty()){  
                    if(Hash::check($request->password, $user[0]->password)){
                        return $this->successResponse('success',$user[0],200);
                    }else{
                        return $this->errorResponse('error','Password incorrecta',403);
                    }
                }else{
                    return $this->errorResponse('error','El correo no esta registrado',404);
                }
            }else{
                return $this->errorResponse('error','Input no soportado',500);
            }

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        } 
    }

    public function verify(Request $request)
    {

            if($request->has('email')){
                $email = trim($request->email);
                $user = User::with('cliente','puntos')->where('email','=',$email)->get();
                if(!$user->isEmpty()){   
                    return $this->successResponse('success',$user,200);
                }else{
                    return $this->errorResponse('error','El correo no esta registrado',404);
                }
            }else{
                return $this->errorResponse('error','Input no soportado',500);
            }   
    }

    public function requestToken(Request $request)
    {
        $rules = [
            'email' => 'required|email'
        ];

        $message = [
            'email.required' => 'Es necesario ingresar tu email',
            'email.email' => 'Formato de correo invalido'
        ];

        $this->validate($request,$rules,$message);

        $user = User::where('email',$request->email)->get();
        if($user->isEmpty()){
            return $this->errorResponse('error','Este correo no esta registrado',404);
        }
        $token = Str::random(60);
        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);
        $url = "https://oktrip-site.azurewebsites.net/recover-password";
        Mail::to($user[0]->email)->send(new resetPassword($user[0],$token,$url));

        $data=[
            'message' => 'El correo se envio exitosamente, verifica tu bandeja de entrada',
            'token' => $token
        ];
        return $this->successResponse('success',$data,200);

    }

    //POST para resetear el password
    public function resetEmail(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = User::where('email',$request->email)->get();
        if(!$user->isEmpty())
        {
            $token_db = DB::table('password_resets')->where('token', $request->token)->where('email',$user[0]->email)->get();
            //dd(Carbon::parse($token_db->created_at)->addSeconds(60));
            if(!$token_db->isEmpty()){
                if(Carbon::parse($token_db[0]->created_at)->addSeconds(3600)->isPast())
                {
                    return $this->errorResponse('error','El token expiró',404);
                }
                DB::update('update users set password = ?, remember_token = ? where email = ?', [Hash::make($request->password),Str::random(60),$user[0]->email]);
                return $this->successResponse('success','Tu password se reseteó exitosamente!!',200);
            }
            return $this->errorResponse('error','Token invalido',404);
        }
        return $this->errorResponse('error','Correo invalido',404);
    }


    public function userBackUp(){
     
        ini_set('max_execution_time', 1200); //600 seconds = 20 minutes
        $cont = 0;
        $users = DB::connection('mysql2')->table('users')->selectRaw('Id,Email,AES_DECRYPT(Password,"test") as Secret')->get();
        foreach ($users as $userPrev) {
            # code...
            $verifyUser = DB::table('users')->where('email', '=', trim($userPrev->Email))->get();
            if($verifyUser->isEmpty()){
                $user = new User();
                $user->nombre = "Por definir";
                $user->apellidos = "Por definir";
                $user->email = trim($userPrev->Email);
                $user->user_token = $userPrev->Id;
                $user->password =  Hash::make($userPrev->Secret);
                $user->rol_id = ($userPrev == "juan.alucard.02@gmail.com") ? 1 : 4;
                print_r($user);
                $user->save();
            }else{
                //dd("here");
                $token = new Repetido();
                $token->token_user = $userPrev->Id;
                $token->save();
            }

            $cont++;
        }
        print_r("Task Custom finished, saved ".$cont." records");
    }

    public function ClienteBackUp(){

        ini_set('max_execution_time', 2400); //600 seconds = 20 minutes
        $users = DB::connection('mysql2')->table('clientes')->get();
        $cont = 0;
        //dd($users);
        foreach ($users as $user) {
            $verifyUser = DB::table('users')->where('user_token', '=', $user->Id)->get();
            print_r('<br>Id checado en la BD:<br>'.$user->Id."<br>");
            if(!$verifyUser->isEmpty()){
                print_r('Usuario verificado:<br>'.$verifyUser."<br>");
                $puntos = new Puntos();
                $puntos->puntos_totales = $user->Puntos;
                $puntos->puntos_gastados = $user->puntos_gastados;
                $puntos->puntos_acumulados = $user->Puntos + $user->puntos_gastados;
                $puntos->user_id = $verifyUser[0]->id;
                $puntos->save();

                $cliente = new Cliente();
                $cliente->empresa = trim($user->Empresa);
                $cliente->direccion = trim($user->Direccion);
                $cliente->pais = trim($user->Pais);
                $cliente->ciudad = trim($user->Ciudad);
                $cliente->estado = trim($user->Estado);
                $cliente->celular = trim($user->Telefono);
                $cliente->numero_socio = trim((int)$user->NumeroSocio);
                $cliente->cp = $user->CodigoPostal;
                $cliente->created_at = $user->Fecha;
                $cliente->user_id = $verifyUser[0]->id;
                $cliente->puntos_id = $puntos->id;
                ($user->puntos_gastados >= 150000) ? $cliente->categoria_id = 2 : $cliente->categoria_id = 1;
                $cliente->save();
                print_r("Cliente agregado:<br>".$cliente."<br>");
            }

            $cont++;

        }
        print_r("Task BackUp Finished, saved ".$cont." records");

    }

    public function CargaPuntos(){

        ini_set('max_execution_time', 2400); //600 seconds = 20 minutes
        $puntos_cargados = DB::connection('mysql2')->table('registro_puntos')->get();
        foreach ($puntos_cargados as $puntos) {

            $user = DB::table('users')->where('user_token', '=', $puntos->idCliente)->get();
            if(!$user->isEmpty()){

                $carga_puntos = new Carga_Puntos();
                $carga_puntos->factura_folio = $puntos->registro_fiscal;
                $carga_puntos->rfc = $puntos->rfc;
                $carga_puntos->referencia = $puntos->referencia;
                $carga_puntos->fecha_carga = $puntos->fecha;
                $carga_puntos->puntos = $puntos->puntos;
                $carga_puntos->puntos_expira = NULL;
                $carga_puntos->user_id = $user[0]->id;
                $carga_puntos->save();

            }
        }

        print_r("Task CargaPuntos finished");


    }

    public function RedimirPuntos(){

        ini_set('max_execution_time', 1200); //600 seconds = 20 minutes
        $puntos_redimidos = DB::connection('mysql2')->table('canjes')->get();
        foreach ($puntos_redimidos as $puntos) {

            $premio =  DB::connection('mysql2')->table('canje_premio')->where('canje_id', '=', $puntos->id)->get();

            $user = DB::table('users')->where('user_token', '=', $puntos->idCliente)->get();
            if(!$user->isEmpty()){

                if(!$premio->isEmpty()){
                    $redencion_puntos = new Rendencion_Puntos();

                    $redencion_puntos->fecha_redencion = $puntos->fecha;
                    $redencion_puntos->representante = $puntos->representante;
                    $redencion_puntos->puntos = $puntos->puntos;
                    $redencion_puntos->comentarios = $puntos->nota;
                    $redencion_puntos->user_id = $user[0]->id;
                    $redencion_puntos->regalo_id = $premio[0]->premio_id;
                    $redencion_puntos->save();
                }
            }

        }

        print_r("Task RedimirPuntos finished");

    }

    public function LastName(){

        ini_set('max_execution_time', 1200); //600 seconds = 20 minutes
        $personas = DB::connection('mysql2')->table('personas')->get();
        foreach ($personas as $persona) {


            $user = DB::table('users')
            ->where('user_token', $persona->Id)
            ->update(['nombre' => trim($persona->Nombre),'apellidos' => trim($persona->Apellido_paterno)." ".trim($persona->Apellido_materno)]);
                     
        }  

        print_r("Task LastName finished.");
    }

    public function okCloud(){

        ini_set('max_execution_time', 1200); //600 seconds = 20 minutes
        $reservas = DB::connection('mysql3')->table('huespedes')->orderBy('id', 'desc')->first();
        dd($reservas->id);
        foreach ($reservas as $reserva) {
            dd($reserva);
        }

        print_r("Task LastName finished.");
    }


    public function paises(){
        $response = Http::get('https://restcountries.eu/rest/v2/all');
        $data = $response->json();
        foreach ($data as $country) {
            $pais = new Pais();
            $pais->nombre = $country['name'];
            $pais->save();
        }

        return "Ok todo se completo";
    }

    public function setQR(){
        ini_set('max_execution_time', 2000); //600 seconds = 20 minutes
        $users = User::with('cliente')->get();
        foreach ($users as $user) {

            $affected = DB::table('clientes')
              ->where('user_id', $user->id)
              ->update(['qr_code' => $user->user_token."?"]);
        }

        echo "Se actualizaron los QR de los clientes";
    }


}
