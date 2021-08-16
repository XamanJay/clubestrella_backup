<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuenta_Comercial extends Model
{
    use SoftDeletes;
    protected $table = 'cuenta_comercial';

    protected $hidden =[
        'created_at',
        'updated_at',
        'deleted_at',
        'numero_cuenta',
        'ar'
    ];
}
