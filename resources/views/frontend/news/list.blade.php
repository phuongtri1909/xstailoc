<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Tin tức Xổ số - Những tin tức xổ số hot nhất trong ngày')
@section('decription','Tin tức Xổ số - Những tin tức xổ số hot nhất được cập nhật liên tục trong ngày')
@section('h1','Tin tức Xổ số')

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb">
                <ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a
                                itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span>
                            <meta itemprop="position" content="1">
                        </a></li>
                    <li> »</li>
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a
                                itemprop="item" href="{{url()->current()}}"
                                title="Tin tức Xổ số" class="last"><span itemprop="name">Tin tức Xổ số</span>
                            <meta itemprop="position" content="2">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l" style="height: auto !important;">
        <div class="box cate-news" style="height: auto !important;">
            <h2 class="tit-mien"><strong>Tin tức Xổ số - Những tin tức xổ số hot nhất</strong></h2>
            <ul id="article-list" style="height: auto !important;">
                @foreach($news as $item)
                    <li class="clearfix">
                        <h3><a href="{{route('news.post',$item->slug)}}"
                               title="{{$item->title}}"><strong>{{$item->title}}</strong></a></h3><a
                                href="{{route('news.post',$item->slug)}}"
                                title="{{$item->title}}"><img
                                    class="mag-r5 fl" width="120" height="67"
                                    src="{{$item->img}}"
                                    data-src="{{$item->img}}"
                                    title="{{$item->title}}"
                                    alt="{{$item->title}}"> </a>
                        <p class="mag0 sapo">{{$item->des}}</p>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="txt-center phantrang">
            {!! $news->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endsection

