<?php

namespace App\Http\Controllers\Categorias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;

use App\Traits\ApiMessages;

use App\Categoria;
use App\Header;

use Illuminate\Support\Facades\Hash;

class CategoriaController extends Controller
{
    use ApiMessages; 

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
            $categorias = Categoria::with('premios')->get();
            return $this->successResponse('success',$categorias,200);

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
                'nombre' => 'required',
                'puntos_limite' => 'required',

            ];
            $messages =[
                'nombre.required' => 'Es necesario asignar un nombre.',
                'puntos_limite.required' => 'Es necesario asignar los puntos limite de la categoria.',
            ];
            $this->validate($request,$rules,$messages);
            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->puntos_limite = $request->puntos_limite;
            $categoria->beneficios = $request->beneficios;
            $categoria->save();
            return $this->successResponse('La categoría se creó correctamente',200);

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }

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
            $categoria = Categoria::with('premios')->findorFail($id);
            return $this->successResponse('success',$categoria,200);
        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }

    public function update(Request $request,$id)
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
                'puntos_limite' => 'required',

            ];
            $messages =[
                'nombre.required' => 'Es necesario asignar un nombre.',
                'puntos_limite.required' => 'Es necesario asignar los puntos limite de la categoria.',
            ];
            $this->validate($request,$rules,$messages);
            $categoria = Categoria::findOrFail($id);
            if($categoria == NULL){
                return $this->errorResponse('Categoría inválida para hacer update',NULL,500);
            }else{

                $categoria->nombre = $request->nombre;
                $categoria->puntos_limite = $request->puntos_limite;
                $categoria->beneficios = $request->beneficios;
                $categoria->save();
                return $this->successResponse('La categoría se actualizó correctamente',$categoria,200);
            }

        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }     
    }

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
            $categoria = Categoria::findorFail($id);
            $categoria->delete();
            return $this->successResponse('La categoría se eliminó correctamente',$categoria,200);
        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }

    public function restore($id)
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
            $categoria = Categoria::onlyTrashed()->findorFail($id);
            $categoria->restore();
            return $this->successResponse('La categoría se restauró correctamente',$categoria,200);
        }else
        {
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }
}
