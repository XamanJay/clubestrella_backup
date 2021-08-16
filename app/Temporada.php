<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Temporada extends Model
{
    use SoftDeletes;
    protected $table = 'temporada_comercial';
}
