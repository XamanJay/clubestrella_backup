<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stop_Tarifa_Comercial extends Model
{
    use SoftDeletes;
    protected $table = 'stop_tarifa_comercial';
}
