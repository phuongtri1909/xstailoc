<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Dự đoán XSMB '.getNgayThang($dudoan->date).' - Soi cầu xổ số miền Bắc ' .getNgay($dudoan->date))
@section('decription','Dự đoán XSMB '.getNgay($dudoan->date).' chính xác từ cao thủ soi cầu số 1 hiện nay. Soi cầu xổ số miền Bắc chính xác 100, hoàn toàn miễn phí trên xosotailoc.vip')
@section('keyword','DDXSMB, Dự đoán XSMB Hôm Nay '.getNgay($dudoan->date).', Dự đoán xổ số miền Bắc '.getNgay($dudoan->date).', DDXSMB '.getNgay($dudoan->date).'')
@section('h1','Dự đoán XSMB '.getNgayThang($dudoan->date).' - Soi cầu xổ số miền Bắc ' .getNgay($dudoan->date))

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
                                title="Dự đoán XSMB {{getNgay($dudoan->date)}}" class="last"><span itemprop="name">Dự đoán XSMB {{getNgay($dudoan->date)}}</span>
                            <meta itemprop="position" content="3">
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
        <div class="box box-detail pad10" style="height: auto !important;">
            <h2 class="s20"><strong> {!! $dudoan->title !!}</strong></h2>

            <div class="txt-center magb10"></div>
            <div class="cont-detail paragraph" id="article-content" style="height: auto !important;">
                {!! $dudoan->content !!}
                <p><span style="font-family:Arial,Helvetica,sans-serif"><strong>⇒&nbsp;Xem thêm số
                            đẹp&nbsp;tại:&nbsp;</strong></span></p>

                @foreach($dudoanthem as $item)
                    <p><a data-model-type="Article"
                          href="{{$item->link}}"
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

