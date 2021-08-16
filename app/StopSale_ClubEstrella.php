<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StopSale_ClubEstrella extends Model
{
    use SoftDeletes;
    protected $table = 'stop_sale_clubestrella';
}
