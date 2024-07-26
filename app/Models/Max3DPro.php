<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Max3DPro extends Model
{
    protected $table='max_3d_pro';
    protected $fillable = ['gdb','g1', 'g2', 'g3', 'gdb_sl', 'gdb_phu_sl', 'g1_sl', 'g2_sl', 'g3_sl', 'g4_sl', 'g5_sl', 'g6_sl', 'date', 'day', 'status', 'ky'];
}
