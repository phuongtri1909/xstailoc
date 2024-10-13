<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Thống kê nhanh tần suất bộ số với Xổ Số Tài Lộc')
@section('decription','Thống kê nhanh với Xổ Số Tài Lộc: thống kê ngày về gần nhất, tổng số lần suất hiện, số ngày chưa về cho đến nay một cách trực quan nhanh nhất')
@section('h1','Thống kê nhanh tần suất bộ số Xổ Số Tài Lộc')

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb">
                <ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a
                                itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span>
                            <meta itemprop="position" content="1">
                        </a></li>
                    <li> »
                    </li>
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a
                                itemprop="item" href="{{url()->current()}}" title="Thống kê nhanh" class="last"><span
                                    itemprop="name">Thống kê nhanh</span>
                            <meta itemprop="position" content="2">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l">
        <div class="box tbl-row-hover">
            <h2 class="tit-mien mag0"><strong>Thống kê nhanh</strong></h2>
            <form id="statistic-form" class="form-horizontal">
                <div class="form-group drp-container">
                    <label>Chọn tỉnh</label>
                    <select name="selectProvince" id="selectProvince" class="form-control">
                        <option class="text-selected" value="mb">Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option class="text-selected" value="{{$pro->short_name}}">{{$pro->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group field-statisticform-fromdate">
                    <label class="control-label" for="statisticform-fromdate">Từ ngày</label>
                    <input class="form-control" type="text" id="start_date" name="start_date" placeholder="Ngày bắt đầu" value="{{date('d/m/Y',strtotime('-365 days'))}}">
                    <div class="help-block"></div>
                </div>
                <div class="form-group field-statisticform-todate">
                    <label class="control-label" for="statisticform-todate">Đến ngày</label>
                    <input class="form-control" type="text" id="end_date" name="end_date" placeholder="Ngày kết thúc" value="{{date('d/m/Y')}}">
                    <div class="help-block"></div>
                </div>
                <div class="form-group">
                    <label class="control-label"><strong>Hiển thị</strong></label>
                    <span class="form-control" class="percent-50"><input type="checkbox" value="1" id="vedb" name="vedb"> Giải đặc biệt</span>
                </div>
                <div class="form-group txt-center">
                    <button type="button" class="btn btn-danger" onclick="getThongKeLo()">Xem kết quả</button>
                </div>
            </form>
        </div>
        <div class="box tbl-row-hover tknhanh" id="thongKe">
            <h2 class="bg_red pad10-5">Thống kê nhanh xổ số {{$province_name}} từ ngày {{date('d/m/Y',strtotime('-365 days'))}} đến ngày {{date('d/m/Y')}}</h2>
            <div class="scoll">
                <textarea class="textarea mb-2 mt-2" rows="2" id="numbers" name="numbers"
                          placeholder="Điền các bộ số bạn muốn xem (ngăn cách bằng dấu phẩy hoặc cách). Để trống để xem mọi bộ số"
                          onkeyup="thong_ke_nhanh_show_hide()"></textarea>

                <select id="quick_show" onchange="thong_ke_nhanh_quick_show()"
                        class=" form-select mb-2">
                    <option value="0">Tất Cả</option>
                    <option value="1">Chẵn</option>
                    <option value="2">Lẻ</option>
                    <option value="3">Tổng Chẵn</option>
                    <option value="4">Tổng Lẻ</option>
                    <option value="5">Chẵn Chẵn</option>
                    <option value="6">Lẻ Lẻ</option>
                    <option value="7">Chẵn Lẻ</option>
                    <option value="8">Lẻ Chẵn</option>
                    <option value="9">Bộ Kép</option>
                    <option value="10">Sát Kép</option>
                </select>
                <table class="tbl-chuky" id="tknhanhdata">
                    <tbody>
                    <tr>
                        <th style="width:10%">Bộ số</th>
                        <th style="width:30%">Số ngày chưa về</th>
                        <th style="width:30%">Ngày về gần nhất</th>
                        <th style="width:30%"><p class="mag0">Tổng số lần xuất hiện</p></th>
                    </tr>
                    @for($t = 0; $t< count($ArrayCollect); $t++)
                        <tr data-n="{{intval($ArrayCollect[$t][0])}}">
                            <td><strong class="clred s18">{{$ArrayCollect[$t][0]}}</strong></td>
                            @if($ArrayCollect[$t][2]==-1)
                                <td>
                                    <p>Không xuất hiện</p>
                                </td>
                            @else
                                <td>
                                    <p class="mag0"><strong class="s18">{{$ArrayCollect[$t][2]}}</strong></p>
                                </td>
                            @endif
                            @if($short_name=='mb')
                                <td class="text-center"><a target="_blank" href="{{route('xsmb.date',str_replace('/','-',$ArrayCollect[$t][1]))}}">{{$ArrayCollect[$t][1]}}</a></td>
                            @else
                                <td class="text-center"><a target="_blank" href="{{route('xstinh.date',[$short_name,str_replace('/','-',$ArrayCollect[$t][1])])}}">{{$ArrayCollect[$t][1]}}</a></td>
                            @endif
                            <td><strong class="s18">{{$ArrayCollect[$t][3]}}</strong></td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
        {{--<div class="box tbl-row-hover">--}}
            {{--<h3 class="tit-mien"><strong>Thảo luận</strong></h3>  --}}
        {{--</div>--}}
        <div class="box-content">
           <p style="text-align: justify;"><span style="font-weight: 400;">Thống K&ecirc; nhanh. <a title="Thống K&ecirc; nhanh XSMB" href="/thong-ke-nhanh"><strong>Thống K&ecirc; nhanh XSMB</strong></a>. Xem Bảng Thống K&ecirc; nhanh Xổ Số Miền Bắc được cập nhật li&ecirc;n tục h&agrave;ng ng&agrave;y tại xosotailoc.vip</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">xosotailoc.vip nơi cập nhật Thống k&ecirc; nhanh XSMB nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute;.</span></p>
            <p style="text-align: justify;"><strong>Giới thiệu về thống k&ecirc; nhanh</strong></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Thống k&ecirc; nhanh Xổ Số Miền Bắc được cập nhật li&ecirc;n tục mỗi ng&agrave;y sau khi c&oacute; kết quả mở thưởng v&agrave;o 18h30p.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Bảng thống k&ecirc; nhanh cung cấp cho người xem th&ocirc;ng tin của c&aacute;c bộ số từ 00 tới 99 trong khoảng thời gian gần đ&acirc;y.</span></p>
            <p style="text-align: justify;"><strong>Hướng dẫn xem bảng thống k&ecirc; nhanh <a title="kết quả xổ số miền Bắc" href="/xsmb-xo-so-mien-bac">kết quả xổ số miền Bắc</a>:</strong></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">- Chọn miền Bắc trong mục chọn tỉnh.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">- Bạn c&oacute; thể chọn số m&igrave;nh muốn xem:</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">+ Chọn 1 số hoặc nhiều số th&igrave; v&agrave;o &ocirc; &ldquo;Chọn số&rdquo;, với trường hợp nhiều số th&igrave; mỗi số c&aacute;ch nhau một dấu phẩy, VD: 01, 02, 03,..</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">+ Nếu bạn muốn xem tất cả c&aacute;c cặp số th&igrave; click chọn &lsquo;Tất cả c&aacute;c giải&rsquo;.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">+ Nếu muốn xem nhanh 2 số cuối giải đặc biệt th&igrave; chọn &ocirc; &lsquo;Giải đặc biệt&rsquo;</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">- Chọn khoảng thời gian muốn xem, rồi nhấp v&agrave;o &ocirc; &lsquo;Xem kết quả&rsquo;</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">- Bảng kết quả thống k&ecirc; nhanh sẽ cho bạn th&ocirc;ng tin của số đ&oacute; về bao nhi&ecirc;u lần, ng&agrave;y về gần nhất l&agrave; ng&agrave;y n&agrave;o v&agrave; đ&atilde; bao nhi&ecirc;u ng&agrave;y chưa xuất hiện.</span></p>
            <p style="text-align: justify;"><strong>Những th&ocirc;ng tin tr&ecirc;n bảng Thống k&ecirc; nhanh <a title="KQXSMB&nbsp;" href="/xsmb-xo-so-mien-bac">KQXSMB&nbsp;</a></strong></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">- T&iacute;nh năng n&agrave;y gi&uacute;p bạn thống k&ecirc; nhanh 1 hay nhiều bộ số của Mb theo khoảng thời gian bạn lựa chọn.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">- Xem nhanh bộ số của tất c&aacute;c giải theo khoảng thời gian t&ugrave;y chọn.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">- TK nhanh bộ số giải đặc biệt.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Sử dụng thống k&ecirc; nhanh kết hợp c&ugrave;ng với thống k&ecirc; giải đặc biệt để t&igrave;m ra l&ocirc; rơi c&oacute; tỷ lệ tr&uacute;ng cao nhất sẽ về trong c&aacute;c kỳ liền kề tiếp theo.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Thống k&ecirc; nhanh. Tk nhanh. Thống k&ecirc; nhanh Xổ Số Miền Bắc. Xem thống k&ecirc; nhanh h&ocirc;m nay ch&iacute;nh x&aacute;c v&agrave; miễn ph&iacute; tại <a title="xosotailoc.vip" href="/">xosotailoc.vip</a></span></p>
        </div>
        <script>
        </script>
    </div>
@endsection

@section('afterJS')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        function getThongKeLo() {
            $("#thongKe").html('<div class="row justify-content-center"><div class="col-md-12" style="text-align: center;padding: 50px 0px"><i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...</div></div>');
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var giaidb = $('#vedb:checked').val();
            var short_name = $('#selectProvince').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.post("{{route('tk.thong-ke-nhanh-ajax')}}", {
                _token: CSRF_TOKEN,
                start_date: start_date,
                end_date: end_date,
                giaidb: giaidb,
                short_name: short_name,
            }, function (result) {
                var data = $.parseJSON(result);
                console.log(data);
                $("#thongKe").html(data.template);
            });

            $('html, body').animate({
                scrollTop: $("#thongKe").offset().top
            }, 100);
        }
    </script>
@endsection
