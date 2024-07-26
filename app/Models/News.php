<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news_xsdp';
    protected $fillable = ['title', 'slug', 'des', 'content', 'img', 'link', 'meta_title', 'meta_description', 'meta_keyword','created_at'];

}
