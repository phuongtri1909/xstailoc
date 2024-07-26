<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use Cache;

class NewsController extends Controller
{
    public function listNews()
    {
        $news = News::orderBy('id', 'DESC')->paginate(15);
        return view('frontend.news.list', compact('news'));
    }
    public function post($slug)
    {
        $post = News::where('slug', $slug)->first();
        if(empty($post)) return view('errors.404');
        $news_more_bottom = News::orderBy('id', 'DESC')->take(6)->get();
        return view('frontend.news.post', compact('post', 'news_more_bottom'));
    }
}
