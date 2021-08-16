<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RamadaController extends Controller
{
    public function index()
    {
        return view('ramada.index');
    }
}
