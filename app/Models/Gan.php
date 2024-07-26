<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gan extends Model
{
    protected $table='gan';
    protected $fillable=['loto','cap_loto','province_id','max','mien','type','date','date_end'];
}
