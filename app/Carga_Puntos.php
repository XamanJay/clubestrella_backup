<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carga_Puntos extends Model
{
    use SoftDeletes;
    protected $table = 'carga_puntos';
}
