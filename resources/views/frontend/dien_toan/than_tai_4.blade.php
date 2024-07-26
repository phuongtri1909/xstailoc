@extends('frontend.layouts.app')
@section('title','Xổ số thần tài - KQXS điện toán thần tài')
@section('decription','Kết quả xổ số thần tài cập nhật mới nhất, Theo dõi kết quả xs thần tài hàng ngày nhanh và chính xác.')
@section('h1','Xổ số thần tài - KQXS điện toán thần tài')

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{url()->current()}}" title="Xổ số thần tài" class="last"><span itemprop="name">Xổ số thần tài</span><meta itemprop="position" content="2"></a></li>
                </ol></div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l">
        <ul class="tab-panel tab-3">
            <li><a href="{{route('dientoan6x36')}}">Điện toán 6x36</a></li>
            <li><a href="{{route('dientoan123')}}">Điện toán 123</a></li>
            <li class="active"><a href="{{route('xsthantai')}}">XS Thần Tài</a></li>
        </ul>
        <ul class="dientoan-ball clearfix thantai">
            @foreach($kqs as $kq_XsThanTai)
                <div class="box">
                    <h2 class="tit-mien"><strong>Kết quả xổ số thần tài {{getThu($kq_XsThanTai->day)}} ngày {{getNgay($kq_XsThanTai->date)}}</strong></h2>
                    <li>
                        <div><span>{{$kq_XsThanTai->day_so}}</span></div>
                    </li>
                </div>
            @endforeach
        <!--</div>-->
        <script>
        </script>
    </div>
@endsection