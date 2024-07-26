<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoRoi extends Model
{
    protected $table='lo_roi';
    protected $fillable=['loto','cap_loto','province_id','max','mien','type','date','date_end'];
}
