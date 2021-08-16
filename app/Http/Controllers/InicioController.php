<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App;
use App\Mail\Contacto;
use Mail;

class InicioController extends Controller
{
  public function index($locale)
  {
      if (Auth::check()) {
      return redirect(route('home',App::getLocale()));
  }
      return view('welcome');
  }

  public function contacto()
  {
      return view('cliente.contacto');
  }
  public function storeContacto(Request $request)
  {
      $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'issue' => 'required',
        'message' => 'required'
      ];
      $messages = [
        'name.required' => 'Es necesario asignar un nombre.',
        'email.required' => 'Es necesario un correo electronico valido',
        'issue.required' => 'Es necesario el asunto',
        'message.required' => 'Sera necesario que nos escribas tu mensaje'
      ];

      $this->validate($request, $rules, $messages);

      Mail::to('recepcion.adhara@gphoteles.com')
        ->bcc(['reservaciones@gphoteles.com','gerencia@gphoteles.com'])
        ->send(new Contacto($request->name, $request->email, $request->issue, $request->message));

      return back()->with('success', 'Hemos recibido tu correo, en breve te contactaremos!!');

  }

  public function notAuthorized($locale)
  {
      return view('not-authorized');
  }

  public function notFound($locale){
    return view('404');
  }

  public function maintenance($locale)
  {
      return view('maintenance');
  }
}



