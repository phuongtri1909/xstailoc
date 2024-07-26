<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GanDB extends Model
{
    protected $table='gan_db';
    protected $fillable=['loto','cap_loto','province_id','max','mien','type','date','date_end'];
}
