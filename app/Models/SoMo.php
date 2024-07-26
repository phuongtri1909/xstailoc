<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoMo extends Model
{
    protected $table='so_mo';
    protected $fillable = ['title','mo', 'slug', 'so', 'content', 'link', 'img', 'meta_title', 'meta_description'];
}
