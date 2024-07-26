<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $fillable=['gdb','g1','g2','g3','g4','g5','g6','g7','g8','madb','day','mien','slug','status','province_id','date'];

    public function province(){
        return $this->belongsTo('App\Models\Province','province_id');
    }
}
