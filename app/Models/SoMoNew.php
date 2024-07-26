<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoMoNew extends Model
{
    protected $table = 'so_mo_new';
    protected $fillable = ['title', 'slug', 'des', 'content', 'img', 'link', 'meta_title', 'meta_description', 'meta_keyword'];

}
