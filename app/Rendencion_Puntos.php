<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rendencion_Puntos extends Model
{
    use SoftDeletes;
    protected $table = 'redencion_puntos';
}
