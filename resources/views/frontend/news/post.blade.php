<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title',$post->meta_title)
@section('decription',$post->meta_description)
@section('h1',$post->meta_title)

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
                        </a></li> »</li>
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a
                                itemprop="item" href="{{url()->current()}}"
                                title="{{$post->title}}" class="last"><span itemprop="name">{{$post->title}}</span>
                            <meta itemprop="position" content="3">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l" style="height: auto !important;">
        <div class="box box-detail pad10" style="height: auto !important;">
            <h2 class="s20"><strong>{{$post->title}}</strong></h2>

            <div class="magb10 mb-3 mt-2">
                    <div class="post-date">{{getThu(getThuNumber(substr($post->created_at,0,10)))}}, {{getNgay(substr($post->created_at,0,10))}}</div>
                </div>
            <div class="cont-detail paragraph" id="article-content" style="height: auto !important;">
                {!! $post->content !!}
                <p><span style="font-family:Arial,Helvetica,sans-serif"><strong>⇒&nbsp;Xem thêm tin tức&nbsp;tại:&nbsp;</strong></span></p>

                @foreach($news_more_bottom as $item)
                    <p><a data-model-type="Article"
                          href="{{route('news.post',$item->slug)}}"
                          title="{{$item->title}}">{{$item->title}}</a></p>
                @endforeach
            </div>
            <div class="box box-news">
                <h3 class="tit-mien"><strong>Tiện ích</strong></h3>
                <ul>
                    <li><span class="ic"></span><a href="{{route('tk.dac-biet-tuan')}}"
                                                   title="Bảng đặc biệt tuần">Bảng đặc biệt tuần</a></li>
                    <li><span class="ic"></span><a href="{{route('somo')}}"
                                                   title="Sổ mơ">Sổ mơ</a></li>
                    <li><span class="ic"></span><a href="{{route('tk.lo-gan','mb')}}"
                                                   title="Thống kê lô gan">Thống kê lô gan</a></li>
                    <li><span class="ic"></span><a href="#"
                                                   title="Thống kê giải đặc biệt">Thống kê giải đặc biệt</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection

