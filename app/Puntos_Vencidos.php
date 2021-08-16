<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Puntos_Vencidos extends Model
{
    use SoftDeletes;
    protected $table = 'puntos_vencidos';

    public function premios(){
        return $this->hasMany(Regalo::class);
    }
}
