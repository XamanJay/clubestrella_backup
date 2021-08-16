<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hoteles extends Model
{
    use SoftDeletes;
    protected $table = 'hoteles_gph';
}
