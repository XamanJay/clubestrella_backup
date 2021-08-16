<?php

namespace App\Http\Controllers\Premios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Para conexion a la base de datos
use Illuminate\Support\Facades\DB;

use App\Traits\ApiMessages;
use Illuminate\Support\Facades\Hash;

//para el manejo de archivos
use File;
use Illuminate\Support\Facades\Storage;

use App\Regalo;
use App\Header;

class PremiosController extends Controller
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
            $premios = Regalo::where('custom','=',true)->get();
            return $this->successResponse('success',$premios,200);
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
                'puntos' => 'required',
                'categoria_id' => 'required',
                'tags' => 'required'

            ];
            $messages =[
                'nombre.required' => 'Es necesario asignar un nombre.',
                'puntos.required' => 'Es necesario asignar los puntos correspondientes..',
                'categoria_id.required' => 'Es necesario asignar la categoria a la que pertenece el producto.',
                'tags.required' => 'Es necesario asignar una tag a la cual pertenecera el Premio'
            ];
            $this->validate($request,$rules,$messages);

            $regalo = new Regalo();
            $regalo->nombre = trim($request->nombre);
            $regalo->descripcion = trim($request->descripcion);
            $regalo->puntos = trim($request->puntos);
            $regalo->categoria_id = $request->categoria_id;
            $regalo->tag = json_encode($request->tags);
            $regalo->custom = 2;

            if($request->imgs){

                $file = $request->file('imgs');
                $array_img = array();
                $fileName = "";
                //foreach ($files as $file) {
                    $fileName = uniqid().$file->getClientOriginalName();  
                    $path_logo = $file->storeAs(
                        'regalos',
                        $fileName,
                        'public'
                    );
                    array_push($array_img,$path_logo);   
                //}
                $imgs = json_encode($array_img);
                

                if(Storage::disk('regalos')->exists($fileName))
                {  
                    $regalo->imgs = $imgs;
                    $regalo->save();
                    return $this->successResponse('El premio se guardó exitosamente',$regalo,200);
                }
                else{
                    $regalo->save();
                    return $this->successResponse('El Premio se guardó pero hubo un error al subir la imágen',$regalo,204);
                }
            }else{
                $regalo->save();
                return $this->successResponse('El premio se guardó exitosamente',$regalo,200);
            }

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
            $premio = Regalo::findorFail($id);
            return $this->successResponse('success',$premio,200);
        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }

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
                'puntos' => 'required',
                'categoria_id' => 'required',

            ];
            $messages =[
                'nombre.required' => 'Es necesario asignar un nombre.',
                'puntos.required' => 'Es necesario asignar los puntos correspondientes..',
                'categoria_id.required' => 'Es necesario asignar la categoria a la que pertenece el producto.',
            ];
            $this->validate($request,$rules,$messages);

            $regalo = Regalo::findorFail($id);
            $regalo->nombre = trim($request->nombre);
            $regalo->descripcion = trim($request->descripcion);
            $regalo->puntos = $request->puntos;
            $regalo->categoria_id = $request->categoria_id;
            $regalo->tag = json_encode($request->tags);
            $img = json_decode($regalo->imgs);

            if($request->imgs){
                if($regalo->imgs != NULL){

                    if(Storage::disk('regalos')->exists($img[0]))
                        Storage::disk('regalos')->delete($img[0]);
                }

                $file = $request->file('imgs');
                $array_img = array();
                $fileName = "";
                //foreach ($files as $file) {
                    $fileName = uniqid().$file->getClientOriginalName();  
                    $path_logo = $file->storeAs(
                        'regalos',
                        $fileName,
                        'public'
                    );

                    array_push($array_img,$fileName);   
                //}
                $imgs = json_encode($array_img);
                
                
                if(Storage::disk('regalos')->exists($fileName))
                {  
                    $regalo->imgs = $imgs;
                    $regalo->save();
                    return $this->successResponse('El premio se actualizó correctamente',$regalo,200);
                }
                else{
                    $regalo->save();
                    return $this->successResponse('El Premio se actualizó pero hubo un error al subir la imágen',$regalo,204);
                }
            }else{
                $regalo->save();
                return $this->successResponse('El premio se actualizó correctamente',$regalo,200);
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
            $premio = Regalo::findorFail($id);
            $premio->delete();
            return $this->successResponse('El premio se eliminó correctamente',$premio,200);
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
            $premio = Regalo::onlyTrashed()->findorFail($id);
            $premio->restore();
            return $this->successResponse('El premio se restauró correctamente',$premio,200);
        }else{
            return $this->errorResponse('Error de Autenticacion (Headers)',NULL,500);
        }
    }
}
