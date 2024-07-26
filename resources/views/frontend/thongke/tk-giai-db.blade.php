<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Lô gan '.$province_name.' - Thống kê lô gan')
@section('decription','Lô gan '.$province_name.' - Thống kê lô gan - Thống kê các cặp Lô tô gan lâu ngày chưa về. Thống kê Xổ số nhanh, chính xác')
@section('keyword','lo gan, lô gan, Lô gan '.$province_name.', Thống kê lô gan, thong ke lo gan')
@section('h1','Lô gan '.$province_name.' - Thống kê lô gan')

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{route('tk.dac-biet',$short_name)}}" title="Thống Kê Đặc Biệt Xổ Số {{$province_name}}" class="last"><span itemprop="name">Thống Kê Đặc Biệt Xổ Số {{$province_name}}</span><meta itemprop="position" content="2"></a></li>
                </ol></div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l">
        <ul class="tab-panel tab-auto">
            <li class="active"><a href="#"
                                  title="TK GĐB">TK GĐB</a></li>
            <li><a href="{{route('tk.dac-biet-tuan')}}" title="TK đặc biệt theo tuần">Theo
                    tuần</a></li>
            <li><a href="{{route('tk.dac-biet-thang')}}" title="TK đặc biệt theo tháng">Theo
                    tháng</a></li>
            <li><a href="{{route('tk.dac-biet-nam')}}" title="TK đặc biệt theo năm">Theo
                    năm</a></li>
        </ul>

        <div class="box tbl-row-hover">
            <h2 class="tit-mien">
                <strong>Thống Kê Đặc Biệt Xổ Số {{$province_name}}</strong>
            </h2>
            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                    <select id="selectProvince" class="form-control" name="selectProvince">
                        <option class="text-selected" value="#" @if($short_name=='mb') selected @endif>Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option class="text-selected" value="{{route('tk.dac-biet',$pro->short_name)}}" @if($pro->short_name==$short_name) selected @endif>{{$pro->name}}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>
            </form>
        </div>
        <div class="box tbl-row-hover">
            <h3 class="tit-mien bold">Các kết quả mà ngày trước đó cũng có ĐB về <span class="clnote">{{$lotoDB}}</span> (Ngày {{getNgay($dateDB)}}: <span class="clnote">{{$giaiDB}}</span>)</h3>

            <div class="clearfix">
                <table class="mag0 fl">
                    <tbody>
                    <tr>
                        <th>Ngày về</th>
                        <th>ĐB</th>
                        <th>ĐB hôm sau</th>
                        <th>Hôm sau</th>
                    </tr>
                    @for($i=0;$i<count($arr_like_db);$i++)
                        <tr>
                            @if($short_name=='mb')
                                <td><a class="sub-title" href="{{route('xsmb.date',getNgayLink($arr_like_db[$i][1]))}}" title="xổ số {{$province_name}} ngày {{getNgay($arr_like_db[$i][1])}}">{{getNgay($arr_like_db[$i][1])}}</a></td>
                            @else
                                <td><a class="sub-title" href="{{route('xstinh.date',[$short_name,getNgayLink($arr_like_db[$i][1])])}}" title="xổ số {{$province_name}} ngày {{getNgay($arr_like_db[$i][1])}}">{{getNgay($arr_like_db[$i][1])}}</a></td>
                            @endif

                            <td>
                                <div class="statistic_lo bold">{{substr($arr_like_db[$i][0],0,strlen($arr_like_db[$i][0])-2)}} <span class="clnote">{{substr($arr_like_db[$i][0],strlen($arr_like_db[$i][0])-2)}} </span> </div>
                            </td>
                            <td>
                                <div class="statistic_lo bold">{{substr($arr_sau_db[$i][0],0,strlen($arr_sau_db[$i][0])-2)}} <span class="clnote">{{substr($arr_sau_db[$i][0],strlen($arr_sau_db[$i][0])-2)}} </span> </div>
                            </td>
                                @if($short_name=='mb')
                                    <td><a class="sub-title" href="{{route('xsmb.date',getNgayLink($arr_sau_db[$i][1]))}}" title="xổ số {{$province_name}} ngày {{getNgay($arr_sau_db[$i][1])}}">{{getNgay($arr_sau_db[$i][1])}}</a></td>
                                @else
                                    <td><a class="sub-title" href="{{route('xstinh.date',[$short_name,getNgayLink($arr_sau_db[$i][1])])}}" title="xổ số {{$province_name}} ngày {{getNgay($arr_sau_db[$i][1])}}">{{getNgay($arr_sau_db[$i][1])}}</a></td>
                                @endif
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box tbl-row-hover">
            <h3 class="tit-mien bold">Thống kê tần suất 2 số cuối giải ĐB hôm sau khi GĐB hôm trước về <span
                        class="clnote bold">{{$lotoDB}}</span></h3>

            <div class="clearfix">
                <table class="mag0 fl">
                    <tbody>
                    <tr>
                        <th>Bộ số</th>
                        <th>Bộ số</th>
                        <th>Bộ số</th>
                        <th>Bộ số</th>
                        <th>Bộ số</th>
                    </tr>
                    <tr>
                    @for($i=0;$i<count($ArrayCollect_kq_sau_db);$i++)
                        <td><span class="clred bold">{{$ArrayCollect_kq_sau_db[$i][0]}}</span> - {{$ArrayCollect_kq_sau_db[$i][1]}} lần</td>
                        @if(($i+1)%5==0) </tr> <tr> @endif
                    @endfor
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box tbl-row-hover statistic-cham">
            <h3 class="tit-mien bold">Thống kê chạm những hôm về <span class="clnote bold">{{$lotoDB}}</span></h3>

            <div class="clearfix">
                <table class="mag0 fl">
                    <tbody>
                    <tr>
                        <th>Bộ số</th>
                        <th>Đã về - <span class="clred">Đầu</span></th>
                        <th>Đã về - <span class="clred">Đuôi</span></th>
                        <th>Đã về - <span class="clred">Tổng</span></th>
                    </tr>
                    @for($t = 0; $t< 10; $t++)
                        <tr>
                            <td>
                                {{$t}}
                            </td>
                            <td>
                                <span class="clred">{{$cham_dau[$t][1]}}</span> lần
                            </td>
                            <td>
                                <span class="clred">{{$cham_duoi[$t][1]}}</span> lần
                            </td>
                            <td>
                                <span class="clred">{{$cham_tong[$t][1]}}</span> lần
                            </td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box tbl-row-hover">

            <h2 class="tit-mien bold">Thống kê giải đặc biệt Miền Bắc ngày <span class="clnote bold">{{getNgayThang($dateDB_new)}}</span> hàng năm
            </h2>

            <div>
                <table class="mag0">
                    <tbody>
                    <tr>
                        <th>Năm</th>
                        <th>Ngày</th>
                        <th>Giải đặc biệt</th>
                    </tr>
                    @foreach($kq_db_cung_ngay as $kq)
                        <tr>
                            <td class="s18 bold">Năm {{getNam($kq->date)}}</td>
                            @if($short_name=='mb')
                                <td><a class="sub-title" href="{{route('xsmb.date',getNgayLink($kq->date))}}" title="xổ số {{$province_name}} ngày {{getNgay($kq->date)}}">{{getNgay($kq->date)}}</a></td>
                            @else
                                <td><a class="sub-title" href="{{route('xstinh.date',[$short_name,getNgayLink($kq->date)])}}" title="xổ số {{$province_name}} ngày {{getNgay($kq->date)}}">{{getNgay($kq->date)}}</a></td>
                            @endif
                            <td class="s18 clred bold">{{$kq->gdb}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box box-html">
                <p dir="ltr"><strong><a href="{{route('tk.dac-biet',$short_name)}}"
                                        title="Thống kê {{$province_name}}"><span style="color:#FF0000">Thống kê {{$province_name}}</span></a></strong>
                    thống kê tất cả 2 số cuối giải đặc biệt {{$province_name}} các ngày trước để cung cấp các số chính xác nhất vào
                    ngày hôm sau</p>

            <p dir="ltr">- <a href="{{route('tk.dac-biet-tuan')}}" rel="nofollow"
                              title="Thống kê XSMB giải đặc biệt theo tuần"><span style="color:#0000FF"><strong>Thống kê
                            giải đặc biệt theo tuần</strong></span></a></p>

            <p dir="ltr">- <a href="{{route('tk.dac-biet-thang')}}" rel="nofollow"
                              title="Thống kê XSMB giải đặc biệt theo tháng"><span style="color:#0000FF"><strong>Thống
                            kê giải đặc biệt theo tháng</strong></span></a></p>

            <p dir="ltr">-&nbsp;<a href="{{route('tk.dac-biet-nam')}}" rel="nofollow"
                                   title="Thống kê XSMB giải đặc biệt theo năm"><span style="color:#0000FF"><strong>Thống
                            kê giải đặc biệt theo năm</strong></span></a></p>

            <p dir="ltr"><strong>Bảng thống kê những ngày đề về cùng 1 số nào đó</strong></p>

            <p dir="ltr">Bảng thống kê những ngày mà 2 số cuối giải ĐB về cùng 1 con số nào đó và 2 số cuối GĐB ngày kế
                tiếp&nbsp;</p>

            <p dir="ltr"><strong>Bảng 2 số cuối giải đặc biệt lâu về nhất:</strong></p>

            <p dir="ltr">- Bảng thống kê 10 cặp 2 số cuối kết quả giải đặc biệt&nbsp;lâu chưa về nhất hôm nay.</p>

            <p dir="ltr"><strong>Bảng đầu đuôi giải đặc biệt miền bắc lâu chưa về:</strong></p>

            <p dir="ltr">- Thống kê cho người xem biết được các số hàng chục và hàng đơn vị&nbsp;chưa về trong thời gian
                gần đây.</p>

            <p dir="ltr"><strong>Bảng thống kê giải đặc biệt ngày này năm xưa</strong></p>

            <p dir="ltr">- Cung cấp thông tin cho người xem các giải đặc biệt về cùng ngày hôm đó trong các năm trước
                đó.</p>

            <p><strong>Xem thêm thông tin về các giải thưởng&nbsp;mới nhất hàng ngày, truy cập:&nbsp;</strong></p>
        </div>

        <script>
        </script>
    </div>
@endsection

@section('afterJS')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectProvince').change(function () {
                let urlChaneg = $('#selectProvince option:selected').val();
                window.location.href = urlChaneg;
            });
        });
    </script>
@endsection