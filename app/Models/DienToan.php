<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DienToan extends Model
{
    protected $table='dien_toan';
    protected $fillable = ['day_so', 'date', 'day', 'status', 'type'];
}
