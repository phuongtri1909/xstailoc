<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table='provinces';
    protected $fillable=['name','short_name','slug_sc','slug','title','ngay_quay','mien','meta_title','meta_description','meta_keyword'];

    public function lotteries()
    {
        return $this->hasMany('App\Models\Lottery');
    }
}
