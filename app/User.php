<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','apellidos', 'email', 'password','user_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function cliente(){
        return $this->hasOne(Cliente::class);
    }

    public function puntos(){
        return $this->hasOne(Puntos::class);
    }

    public function puntosCargados(){
        return $this->hasMany(Carga_Puntos::class);
    }

    public function puntosRedimidos(){
        return $this->hasMany(Rendencion_Puntos::class);
    }

    public function puntosVencidos(){
        return $this->hasMany(Puntos_Vencidos::class);
    }

    public function rol(){
        return $this->belongsTo(Rol::class);
    }
}
