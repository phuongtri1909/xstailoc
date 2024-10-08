<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

?>
@extends('frontend.layouts.app')

@section('title','Soi cau loto ăn 2 nháy miền Bắc - Soi cau XSMB - Soi cau MB')
@section('decription','Soi cau loto ăn 2 nháy miền Bắc ✅ - Soi cau XSMB - Soi cau MB hàng ngày cực chuẩn, phân tích và thống kê các cặp số có khả năng về tính  theo CAU Mien Bac, CAU MB, SOI CAU MB.')
@section('keyword','loto mb, Soi cau XSMB,soi cau loto ăn 2 nháy, soi cau lo loto, soi cau xsmb, cau loto ăn 2 nháy xsmb, soi cau mb, cau xsmb, soi cau lo de mien bac, soi cau mien bac hom nay, loto lo, soi cau xsmb hom nay, cau lo loto, soi cau lo de mien bac hom nay, soi cau mien bac chinh xac nhat, lo loto, du doan xsmb chinh xac nhat, soi cau lo de chuan, soi cau lo de mb, soi cau mb hom nay, du doan ket qua xsmb toi nay, soi cau mb chinh xac, soi cau lo chinh xac nhat mien bac, Soi cau miền bắc, soi cau du doan ket qua xo so mien bac, du doan soi cau mien bac, soi cau du doan xsmb')
@section('h1','Soi cau loto ăn 2 nháy miền Bắc - Soi cau XSMB - Soi cau MB')

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
                                itemprop="item" href="{{url()->current()}}" title="Soi cau loto ăn 2 nháy miền Bắc"
                                class="last"><span itemprop="name">Soi cau loto ăn 2 nháy miền Bắc</span>
                            <meta itemprop="position" content="2">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{url('frontend/css/bachthu.css')}}?v={{rand(1000,100000)}}"
          media="all">

    <div class="col-l">
        <div class="box">
            <ul class="tab-panel tab-auto">
                <li><a href="{{route('scmb.cau-bach-thu')}}" title="Cầu bạch thủ">Bạch thủ</a></li>
                {{--<li><a href="#" title="Cầu lô tô đặc biệt">Cầu ĐB</a>--}}
                {{--</li>--}}
                <li><a href="{{route('scmb.cau-truot')}}" title="Cầu lô tô trượt">Cầu trượt</a></li>
                <li class="active"><a href="{{route('scmb.cau-loto-2nhay')}}" title="Cầu lô tô 2 nháy">2 nháy</a>
                </li>
                <li><a href="{{route('scmb.cau-thu')}}" title="Cầu lô tô theo thứ">Cầu thứ</a>
                </li>
            </ul>
            <h2 class="tit-mien">
                <strong>cau loto ăn 2 nháy, cả cặp miền Bắc - Cầu XSMB chuẩn xác nhất</strong>
            </h2>

            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                    <select name="province" id="province" class="form-control">
                        <option value="{{route('scmb.cau-loto-2nhay')}}">Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option value="{{route('sctn.cau-loto-2nhay',$pro->short_name)}}">{{$pro->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group field-statisticform-fromdate">
                    <label class="control-label" for="statisticform-fromdate">Biên ngày cầu chạy</label>
                    <input type="text" id="end_date" class="form-control" name="end_date" placeholder="Chọn ngày"
                           value="{{date('d/m/Y')}}">

                    <div class="help-block"></div>
                </div>
                <div class="form-group field-statisticform-numofday">
                    <label class="control-label" for="statisticform-numofday">Chọn biên độ</label>
                    <input type="number" id="cauloto" class="form-control" name="cauloto" placeholder="Số ngày: 1 - 20"
                           value="2">

                    <div class="help-block"></div>
                </div>
                <div class="txt-center">
                    <button type="button" class="btn btn-danger" onclick="getContentCau()">Xem kết quả</button>
                </div>
            </form>
        </div>
        <div class="box" id="contentCau">
        </div>
        <div class=" box-content" style="height: auto !important;">

           <p><span style="font-weight: 400;">Cầu L&ocirc; T&ocirc; 2 nh&aacute;y. Cầu Loto 2 nh&aacute;y. Soi Cầu L&ocirc; 2 Nh&aacute;y. Xem thống k&ecirc; Cầu L&ocirc; T&ocirc; 2 Nh&aacute;y nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xosotailoc.vip</span></p>
            <p><span style="font-weight: 400;">xosotailoc.vip nơi cập nhật Cầu L&ocirc; T&ocirc; 2 nh&aacute;y. Xem thống k&ecirc; Cầu L&ocirc; 2 nh&aacute;y li&ecirc;n tục, nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c.</span></p>
            <h2><strong>Soi Cầu L&ocirc; 2 Nh&aacute;y L&agrave; G&igrave;?</strong></h2>
            <p><span style="font-weight: 400;">Soi cầu l&ocirc; 2 nh&aacute;y l&agrave; một phương ph&aacute;p dự đo&aacute;n c&aacute;c con số c&oacute; khả năng xuất hiện trong kết quả xổ số. Phương ph&aacute;p n&agrave;y tập trung v&agrave;o việc t&igrave;m hiểu v&agrave; ph&acirc;n t&iacute;ch những yếu tố c&oacute; thể ảnh hưởng đến việc xuất hiện của c&aacute;c con số trong hai lượt quay liền kề.</span></p>
            <h2><strong>C&aacute;ch Thức Hoạt Động</strong></h2>
            <p><span style="font-weight: 400;">Phương ph&aacute;p soi cầu l&ocirc; 2 nh&aacute;y dựa tr&ecirc;n việc xem x&eacute;t những th&ocirc;ng tin thống k&ecirc; v&agrave; xu hướng trong c&aacute;c lượt quay thưởng gần đ&acirc;y. Điều n&agrave;y gồm việc ph&acirc;n t&iacute;ch c&aacute;c con số đ&atilde; xuất hiện, tỷ lệ xuất hiện của ch&uacute;ng v&agrave; mối quan hệ giữa những con số trong hai lượt quay.</span></p>
            <h2><strong>Giới thiệu về soi cầu l&ocirc; t&ocirc; 2 nh&aacute;y miễn ph&iacute;</strong></h2>
            <p><span style="font-weight: 400;">Soi cầu 2 nh&aacute;y XSMB thống k&ecirc; những vị tr&iacute; gh&eacute;p lại với nhau tạo th&agrave;nh cặp l&ocirc; t&ocirc; xuất hiện 2 lần hoặc xuất hiện cặp xu&ocirc;i v&agrave; lộn của n&oacute; trong bảng KQ l&ocirc; t&ocirc; ng&agrave;y tiếp theo trong khoảng thời gian gần đ&acirc;y.</span></p>
            <h2><strong>Hướng dẫn bắt cầu 2 nh&aacute;y xổ số miền bắc h&ocirc;m nay theo bảng:</strong></h2>
            <p><span style="font-weight: 400;">- Chọn bi&ecirc;n cầu chạy: từ ng&agrave;y n&agrave;o đổ về trước, thường mặc định ng&agrave;y quay số mới nhất.</span></p>
            <p><span style="font-weight: 400;">- Chọn bi&ecirc;n độ: người chơi sẽ chọn bi&ecirc;n độ từ 1 cho đến 20 kỳ mở thưởng.</span></p>
            <p><span style="font-weight: 400;">- Nhấp v&agrave;o mục 'Xem kết quả', c&aacute;c cặp l&ocirc; t&ocirc; gợi &yacute; sẽ xuất hiện.</span></p>
            <p><span style="font-weight: 400;">- Để xem vị tr&iacute; cầu loto hai nh&aacute;y Miền Bắc đẹp nhất ng&agrave;y h&ocirc;m nay, người chơi chỉ cần nhấn v&agrave;o c&aacute;c cặp số trong bảng Soi cầu l&ocirc; t&ocirc; 2 nh&aacute;y để theo d&otilde;i.</span></p>
            <h2><strong>Quy luật soi cầu loto hai nh&aacute;y Miền Bắc:</strong></h2>
            <p><span style="font-weight: 400;">- Quy ước chung: số đầu ti&ecirc;n của GĐB mặc định l&agrave; 0, sắp xếp theo số tự nhi&ecirc;n, đến số cuối giải 7 sẽ c&oacute; thứ tự l&agrave; 106.</span></p>
            <p><span style="font-weight: 400;">- Nhấn chuột v&agrave;o số m&agrave; bạn muốn kiểm tra, m&agrave;n h&igrave;nh sẽ hiển thị &lsquo;vị tr&iacute; tạo cầu&rsquo; của n&oacute; trong thời gian n&agrave;y, từ đ&oacute; sẽ thấy được vị tr&iacute; đ&oacute; trong mấy ng&agrave;y đ&oacute; c&oacute; cho ra l&ocirc; dạng 2 nh&aacute;y hoặc một cặp xu&ocirc;i v&agrave; lộn.</span></p>
            <h2><strong>Tr&uacute;ng l&ocirc; 2 nh&aacute;y được bao nhi&ecirc;u tiền thưởng?</strong></h2>
            <p><span style="font-weight: 400;">- Nếu như bạn nu&ocirc;i 1 l&ocirc; m&agrave; n&oacute; về 2 nh&aacute;y th&igrave; xem như ăn 2 l&ocirc; li&ecirc;n tiếp, số tiền sẽ được gấp đ&ocirc;i, tương tự như vậy với 3 nh&aacute;y v&agrave; 4 nh&aacute;y.</span></p>
            <p><span style="font-weight: 400;">Mọi th&ocirc;ng tin soi cầu lo to tr&ecirc;n đ&acirc;y chỉ mang t&iacute;nh chất tham khảo, ch&uacute;c bạn may mắn!</span></p>
            <p><span style="font-weight: 400;">Xem Cầu L&ocirc; T&ocirc; 2 nh&aacute;y, Cầu Trượt, Cầu Bạch Thủ, KQXS 3 Miền được cập nhật li&ecirc;n tục, mỗi ng&agrave;y tr&ecirc;n xosotailoc.vip</span></p>

            <p style="text-align:center"><strong><a href="{{route('scmb.cau-bach-thu')}}" title="Soi cầu lô Mb hôm nay"><span
                                style="color:#0000FF">Soi cầu lô Mb hôm nay</span></a></strong></p>
        </div>
        <div class="box pad10-5">
            <ul class="list-dot-red">
                <li><a href="{{route('scmb.cau-bach-thu')}}" title="Cầu bạch thủ">Cầu bạch thủ</a></li>
                <li><a href="#" title="Cầu lô tô đặc biệt">Cầu lô tô đặc biệt</a>
                </li>
                <li><a href="{{route('scmb.cau-truot')}}" title="Cầu lô tô trượt">Cầu lô tô trượt</a></li>
                <li><a href="{{route('scmb.cau-loto-2nhay')}}" title="Cầu lô tô 2 nháy">Cầu lô tô 2 nháy</a>
                </li>
                <li><a href="{{route('scmb.cau-thu')}}" title="Cầu lô tô theo thứ">Cầu lô tô theo thứ</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('afterJS')
    <script src="{{url('frontend/js/domarrow.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        $(document).ready(function () {
            getContentCau();
            $('body').on('click', '.btn-outline-primary', function () {
                $('.biendo-date .btn-outline-primary').removeClass("active");
                $(this).addClass("active");
                var date = $(this).attr('data-value');
                var count = $('#cauloto').val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url_type = '{{route('scmb.cau-loto-2nhay-ajax')}}';
                $.post(url_type, {
                    _token: CSRF_TOKEN,
                    date: date,
                    count: count
                }, function (result) {
                    var data = $.parseJSON(result);
                    $("#contentCau").html(data.template);
                });
            });


            $('#province').change(function () {
                let urlChaneg = $('#province option:selected').val();
                window.location.href = urlChaneg;
            });
        });

        function getContentCau() {
            $("#contentCau").html('<div class="row justify-content-center "><div class="col-md-12" style="text-align: center;padding: 50px 0px"><i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...</div></div>');
            var date = $('#end_date').val();
            var count = $('#cauloto').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url_type = '{{route('scmb.cau-loto-2nhay-ajax')}}';
            $.post(url_type, {
                _token: CSRF_TOKEN,
                date: date,
                count: count
            }, function (result) {
                var data = $.parseJSON(result);
                $("#contentCau").html(data.template);
            });
        }
    </script>
    <script>
        function scrollToElement(selector, callback) {
            var animation = {
                scrollTop: $(selector).offset().top
            };
            $('html,body').animate(animation, 'slow', 'swing', function () {
                if (typeof callback == 'function') {
                    callback();
                }
                callback = null;
            });
        }

        function clickScroll(kq_id) {
            window.setTimeout(function () {
                scrollToElement("#" + kq_id);
            }, 200);
        }
    </script>
@endsection