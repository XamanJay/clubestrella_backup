<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Puntos_Tracker extends Model
{
     use SoftDeletes;
     protected $table = 'puntos_track';
}
