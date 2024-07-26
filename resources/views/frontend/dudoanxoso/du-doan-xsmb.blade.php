<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Dự đoán XSMB - DD XSMB - Dự đoán xổ số Miền Bắc')
@section('decription','Dự đoán XSMB - DD XSMB - Dự đoán xổ số Miền Bắc chính xác nhất hôm nay - Tham khảo dự đoán MB miễn phí, xác suất về cực cao trong ngày')
@section('h1','Dự đoán XSMB - DD XSMB - Dự đoán xổ số Miền Bắc')

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
                                title="Dự đoán XSMB" class="last"><span itemprop="name">Dự đoán XSMB</span>
                            <meta itemprop="position" content="2">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l" style="height: auto !important;">
        <ul class="tab-panel tab-auto">
            <li class="active"><a href="{{route('dudoan.xsmb')}}">Dự đoán MB</a></li>
            <li><a href="{{route('dudoan.xsmt')}}">Dự đoán MT</a></li>
            <li><a href="{{route('dudoan.xsmn')}}">Dự đoán MN</a></li>
        </ul>
        <div class="box cate-news" style="height: auto !important;"> 
            <h2 class="tit-mien"><strong>Dự Đoán kết quả xổ số XSMB hôm nay</strong></h2>
            <ul id="article-list" style="height: auto !important;">
                @foreach($ddXsmb as $item)
                    <?php 
                    $link = $item->link;
                    $link = str_replace("xoso.site","xstailoc.com",$link);
                    ?>
                    <li class="clearfix">
                        <h3><a href="{{$link}}"
                                    title="{{$item->title}}"><strong>{{$item->title}}</strong></a></h3><a
                                href="{{$link}}"
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
            {!! $ddXsmb->links('pagination::bootstrap-4') !!}
        </div>
    </div>
@endsection

