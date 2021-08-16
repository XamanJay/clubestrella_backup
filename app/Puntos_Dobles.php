<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Puntos_Dobles extends Model
{
    use SoftDeletes;
    protected $table = 'puntos_dobles';
}
