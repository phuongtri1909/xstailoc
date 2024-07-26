<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table='posts_xsdp';
    protected $fillable = ['title', 'link', 'content', 'date', 'des', 'img', 'category_id', 'meta_title', 'meta_description', 'meta_keyword'];
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }
}
