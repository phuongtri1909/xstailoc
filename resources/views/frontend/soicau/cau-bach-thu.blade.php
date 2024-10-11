<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

?>
@extends('frontend.layouts.app')

@section('title','Soi cau bạch thủ miền Bắc - Soi cau XSMB - Soi cau MB Xổ Số Tài Lộc')
@section('decription','Soi cau bạch thủ miền Bắc Xổ Số Tài Lộc  ✅ - Soi cau XSMB - Soi cau MB hàng ngày cực chuẩn, phân tích và thống kê các cặp số có khả năng về tính  theo CAU Mien Bac, CAU MB, SOI CAU MB.')
@section('keyword','bach thu mb, Soi cau XSMB,soi cau bach thu, soi cau lo bach thu, soi cau xsmb, cau bach thu xsmb, soi cau mb, cau xsmb, soi cau lo de mien bac, soi cau mien bac hom nay, bach thu lo, soi cau xsmb hom nay, cau lo bach thu, soi cau lo de mien bac hom nay, soi cau mien bac chinh xac nhat, lo bach thu, du doan xsmb chinh xac nhat, soi cau lo de chuan, soi cau lo de mb, soi cau mb hom nay, du doan ket qua xsmb toi nay, soi cau mb chinh xac, soi cau lo chinh xac nhat mien bac, Soi cau miền bắc, soi cau du doan ket qua xo so mien bac, du doan soi cau mien bac, soi cau du doan xsmb')
@section('h1','Soi cau bạch thủ miền Bắc - Soi cau XSMB - Soi cau MB Xổ Số Tài Lộc ')

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
                                itemprop="item" href="{{url()->current()}}" title="Soi cầu lô tô bạch thủ miền Bắc"
                                class="last"><span itemprop="name">Soi cầu lô tô bạch thủ miền Bắc</span>
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
                <li class="active"><a href="{{route('scmb.cau-bach-thu')}}" title="Cầu bạch thủ">Bạch thủ</a></li>
                {{--<li><a href="#" title="Cầu lô tô đặc biệt">Cầu ĐB</a>--}}
                {{--</li>--}}
                <li><a href="{{route('scmb.cau-truot')}}" title="Cầu lô tô trượt">Cầu trượt</a></li>
                <li><a href="{{route('scmb.cau-loto-2nhay')}}" title="Cầu lô tô 2 nháy">2 nháy</a>
                </li>
                <li><a href="{{route('scmb.cau-thu')}}" title="Cầu lô tô theo thứ">Cầu thứ</a>
                </li>
           </ul>
            <h2 class="tit-mien">
                <strong>Cầu lô bạch thủ XSMB hôm nay</strong>
            </h2>

            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                    <select name="province" id="province" class="form-control">
                        <option value="{{route('scmb.cau-bach-thu')}}">Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option value="{{route('sctn.cau-bach-thu',$pro->short_name)}}">{{$pro->name}}</option>
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
                           value="3">

                    <div class="help-block"></div>
                </div>
                <div class="txt-center">
                    <button type="button" class="btn btn-danger" onclick="getContentCau()">Xem kết quả</button>
                </div>
            </form>
        </div>
        <div class="box" id="contentCau">
        </div>
        <div class="box-content">

            <p style="text-align: justify;"><span style="font-weight: 400;">Cầu Bạch Thủ. Soi Cầu Bạch Thủ.&nbsp; Xem Thống k&ecirc; Cầu Bạch Thủ nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xosotailoc.live</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">xosotailoc.live nơi cập nhật Thống K&ecirc; Cầu Bạch Thủ. Soi Cầu Bạch Thủ li&ecirc;n tục, nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c.</span></p>
            <h2 style="text-align: justify;"><strong>L&ocirc; bạch thủ l&agrave; g&igrave;?</strong></h2>
            <p style="text-align: justify;"><span style="font-weight: 400;">Đ&aacute;nh bạch thủ l&ocirc; đề l&agrave; dạng đặt cược v&agrave;o một v&aacute;n duy nhất m&agrave; kh&ocirc;ng lựa chọn th&ecirc;m số n&agrave;o nữa để c&oacute; cơ hội chiến thắng được số tiền lớn hơn. B&ecirc;n cạnh đ&oacute;, việc chỉ đ&aacute;nh 1 con l&ocirc; như thế th&igrave; x&aacute;c suất chiến thắng rất thấp phải n&oacute;i l&agrave; rất may mắn mới c&oacute; thể tr&uacute;ng.</span></p>
            <h3 style="text-align: justify;"><strong>Soi cầu bạch thủ l&agrave; g&igrave;?</strong></h3>
            <p style="text-align: justify;"><span style="font-weight: 400;">Đ&uacute;ng với t&iacute;nh chất soi cầu bạch thủ th&igrave; bạn sẽ phải kết nối 2 vị tr&iacute; cầu bất kỳ tr&ecirc;n bảng v&agrave;ng để t&igrave;m ra con số may mắn. B&ecirc;n cạnh đ&oacute; vẫn c&ograve;n c&oacute; rất nhiều phương ph&aacute;p để t&igrave;m ra l&ocirc; bạch thủ, c&oacute; những phương ph&aacute;p dựa tr&ecirc;n quy luật c&oacute; sẵn gi&uacute;p người mới chơi dễ d&agrave;ng vận dụng.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Nhưng cũng c&oacute; những phương ph&aacute;p đ&ograve;i hỏi rất nhiều kinh nghiệm v&agrave; người chơi cần phải c&oacute; khả năng suy đo&aacute;n chuẩn. Nh&igrave;n chung, soi cầu bạch thủ c&oacute; cả mức độ dễ lẫn cực kỳ th&aacute;ch thức, t&ugrave;y v&agrave;o năng lực của m&igrave;nh m&agrave; người chơi sẽ chọn phương thức ph&ugrave; hợp.</span></p>
            <h3 style="text-align: justify;"><strong>Bạch thủ l&ocirc; k&eacute;p l&agrave; g&igrave;?</strong></h3>
            <p style="text-align: justify;"><span style="font-weight: 400;">Bạch thủ l&ocirc; kép thu&ocirc;̣c dạng bạch thủ nhưng được li&ecirc;n k&ecirc;́t bởi 2 s&ocirc;́ gi&ocirc;́ng nhau. Trong dãy s&ocirc;́ từ 00 - 99, sẽ có t&ocirc;̉ng c&ocirc;̣ng 10 con bạch thủ kép gồm: 00 - 11 - 22 - 33 - 44 - 55 - 66 - 77 - 88 - 99.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Những phương pháp bắt bạch thủ l&ocirc; chu&acirc;̉n cho l&ocirc; kép, bạch thủ l&ocirc; kép khung 3 ngày, bạch thủ l&ocirc; kép khung 5 ngày&hellip; thường được áp dụng từ trường hợp bảng thưởng có xu&acirc;́t hi&ecirc;̣n đ&acirc;̀u, đu&ocirc;i l&ocirc; c&acirc;m. Các bạn cũng có th&ecirc;̉ tham khảo những cách này đ&ecirc;̉ tìm ra những con s&ocirc;́ kép may mắn cho mình.</span></p>
            <h2 style="text-align: justify;"><strong>Ưu điểm khi chơi bạch thủ l&ocirc;</strong></h2>
            <p style="text-align: justify;"><span style="font-weight: 400;">- Tỷ lệ thua cực thấp v&igrave; người chơi chỉ được ph&eacute;p ghi 1 con l&ocirc; một ng&agrave;y</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">- Vốn chơi thấp, c&oacute; tỷ lệ ăn cao đ&ograve;i hỏi người chơi phải t&iacute;nh to&aacute;n được con l&ocirc; n&agrave;o ra trong bảng kết quả xổ số.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Những phương ph&aacute;p soi cầu bạch thủ l&agrave; vấn đề nhận được sự quan t&acirc;m lớn từ giới l&ocirc; đề. Để bắt được cầu bạch thủ chuẩn, bạn kh&ocirc;ng chỉ &aacute;p dụng 1 phương ph&aacute;p m&agrave; c&ograve;n phải kết hợp nhiều phương ph&aacute;p c&ugrave;ng l&uacute;c. Ch&iacute;nh v&igrave; l&yacute; do n&agrave;y m&agrave; người chơi cần phải cần phải th&ocirc;ng thạo nhiều phương ph&aacute;p th&igrave; sẽ đạt được hiệu quả cao hơn trong c&aacute;c quy tr&igrave;nh soi cầu.</span></p>
            <h2 style="text-align: justify;"><strong>Địa chỉ xem kết quả soi cầu bạch thủ miền Bắc miễn ph&iacute;&nbsp;</strong></h2>
            <p style="text-align: justify;"><span style="font-weight: 400;">Nếu thời gian kh&ocirc;ng cho ph&eacute;p bạn d&agrave;nh nhiều v&agrave;o những quy tr&igrave;nh soi cầu bạch thủ MB. Bạn c&oacute; thể truy cập xosotailoc.live để nhận số đẹp soi cầu XSMB ở bất kỳ phi&ecirc;n n&agrave;o. Chuy&ecirc;n mục n&agrave;y sẽ được cập nhật li&ecirc;n tục v&agrave; mang đến cho c&aacute;c bạn những bộ số v&agrave;ng trong ng&agrave;y.</span></p>
            <p style="text-align: justify;"><span style="font-weight: 400;">Xem Cầu Bạch Thủ. Cầu Trượt. Cầu 2 nh&aacute;y. KQXS Miền Bắc. KQXS Miền Nam. KQXS Miền Trung được cập nhật nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c tại xosotailoc.live</span></p>
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
    {{--    <script src="{{url('frontend/js/domarrow.js')}}"></script>--}}
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
                var url_type = '{{route('scmb.cau-bach-thu-ajax')}}';
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
            var url_type = '{{route('scmb.cau-bach-thu-ajax')}}';
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