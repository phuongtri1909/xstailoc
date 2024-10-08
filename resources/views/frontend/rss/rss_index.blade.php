<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','RSS')
@section('decription','RSS (Really Simple Syndication) là một chuẩn tựa XML được rút gọn dành cho việc phân tán và khai thác nội dung thông tin Web (ví dụ như các tiêu đề tin tức). Sử dụng RSS, các nhà cung cấp nội dung Web có thể dễ dàng tạo và phổ biến các nguồn dữ liệu ví dụ như các liên kết tin tức, tiêu đề, ảnh và tóm tắt')
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
                                title="Tin tức Xổ số" class="last"><span itemprop="name">rss</span>
                            <meta itemprop="position" content="2">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="content-rss col-l">
        <div class="title-rss">xosotailoc.vip - RSS</div>
        <div class="q-rss">RSS là gì ?</div>
        <div class="a-rss">RSS (Really Simple Syndication) là một chuẩn tựa XML được rút gọn dành cho việc phân tán và khai thác nội dung thông tin Web (ví dụ như các tiêu đề tin tức). Sử dụng RSS, các nhà cung cấp nội dung Web có thể dễ dàng tạo và phổ biến các nguồn dữ liệu ví dụ như các liên kết tin tức, tiêu đề, ảnh và tóm tắt</div>
        <div class="q-rss">xosotailoc.vip cung cấp những kênh thông tin RSS sau:</div>
        <div class="list-tk">
            <div class="one-item">
                <a href="{{route('rss.dudoanxsmb')}}" class="left">Dự đoán XSMB</a>
                <div class="right">
                    <img src="{{url('frontend/images/rss.gif')}}" alt="">
                </div>
            </div>
            <div class="one-item">
                <a href="{{route('rss.dudoanxsmn')}}" class="left">Dự đoán XSMN</a>
                <div class="right">
                    <img src="{{url('frontend/images/rss.gif')}}" alt="">
                </div>
            </div>
            <div class="one-item">
                <a href="{{route('rss.dudoanxsmt')}}" class="left">Dự đoán XSMT</a>
                <div class="right">
                    <img src="{{url('frontend/images/rss.gif')}}" alt="">
                </div>
            </div>
            <div class="one-item">
                <a href="{{route('rss.rssnew')}}" class="left">Tin tức xổ số </a>
                <div class="right">
                    <img src="{{url('frontend/images/rss.gif')}}" alt="">
                </div>
            </div>
        </div>
        <div class="q-rss">
            <strong>Các giới hạn sử dụng</strong>
        </div>
        <div class="a-rss">Các nguồn kênh tin được cung cấp miễn phí cho các cá nhân và các tổ chức phi lợi nhuận. Chúng tôi yêu cầu bạn cung cấp rõ các thông tin cần thiết khi bạn sử dụng các nguồn kênh tin này từ xosotailoc.vip</div>
        <div class="a-rss">xosotailoc.vip hoàn toàn có quyền yêu cầu bạn ngừng cung cấp và phân tán thông tin dưới dạng này ở bất kỳ thời điểm nào và với bất kỳ lý do nào.</div>
    </div>
@endsection

<style>
.content-rss {
    width: 100%;
    position: relative;
    padding: 16px;
    margin-bottom: 16px;
    box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
    background-color: #fff;
}
.title-rss {
    font-size: 36px;
    text-align: center;
    line-height: 1.4;
    padding-bottom: 5px;
    width: 100%;
    font-weight: 700;
}
.q-rss {
    font-weight: 500;
    color: #222;
    line-height: 1.4;
    padding: 5px 0;
}
.a-rss {
    padding: 5px 0;
    color: #222;
    line-height: 1.4;
}
.list-tk {
    margin-top: 16px;
}
.list-tk .one-item {
    display: flex;
}
.list-tk .one-item:not(:last-child) {
    border-bottom: solid 1px #eaeaea;
}
.list-tk .one-item .right {
    flex: 0 0 auto;
    max-width: 150px;
    width: 100%;
    padding: 12px 3px;
    text-align: center;
    width: 100%;
}
.list-tk .one-item .left {
    flex: 0 0 auto;
    max-width: calc(100% - 150px);
    width: 100%;
    text-align: center;
    padding: 12px 3px;
    color: #0029ad;
    text-decoration: none;
    font-size: 14px;
}
.list-tk .one-item .left:hover {
    color: #f00000;
}
</style>
