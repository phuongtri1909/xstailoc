@extends('frontend.layouts.app')

@section('title','Kqxs6x36 - Kết quả xổ số điện toán 6x36')
@section('decription','Kết quả xổ số điện toán 6x36 cập nhật mới nhất, Theo dõi kqxs điện toán 6x36 hàng ngày nhanh và chính xác.')
@section('h1','Kqxs6x36 - Kết quả xổ số điện toán 6x36')

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{url()->current()}}" title="Xổ số điện toán 6x36" class="last"><span itemprop="name">Xổ số điện toán 6x36</span><meta itemprop="position" content="2"></a></li>
                </ol></div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-l">
        <ul class="tab-panel tab-3">
            <li class="active"><a href="{{route('dientoan6x36')}}">Điện toán 6x36</a></li>
            <li><a href="{{route('dientoan123')}}">Điện toán 123</a></li>
            <li><a href="{{route('xsthantai')}}">XS Thần Tài</a></li>
        </ul>
        <ul class="dientoan-ball clearfix">
            @foreach($kqs as $kq_DienToan6x36)
                <div class="box">
                    <h2 class="tit-mien"><strong>Xổ số điện toán 6x36 {{getThu($kq_DienToan6x36->day)}} ngày {{getNgay($kq_DienToan6x36->date)}}</strong></h2>
                    <li>
                        <div>
                            @php $daySo = explode('-', $kq_DienToan6x36->day_so); $d=1; @endphp
                                @foreach($daySo as $value)
                                    <span>{{$value}}</span>
                                @endforeach
                        </div>
                    </li>
                </div>
            @endforeach
        </ul>
        <!--</div>-->
       
    </div>
@endsection