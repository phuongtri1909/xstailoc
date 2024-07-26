<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Max3D extends Model
{
    protected $table='max_3d';
    protected $fillable = ['gdb','g1', 'g2', 'g3', 'gdb_sl', 'g1_sl', 'g2_sl', 'g3_sl', 'gdb_pl_sl', 'g1_pl_sl', 'g2_pl_sl', 'g3_pl_sl', 'g4_pl_sl', 'g5_pl_sl', 'g6_pl_sl', 'date', 'day', 'status', 'ky'];
}
