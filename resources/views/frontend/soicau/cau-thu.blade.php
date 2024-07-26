<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

?>
@extends('frontend.layouts.app')

@section('title','Soi cau theo thứ miền Bắc - Soi cau XSMB - Soi cau MB Với Xổ Số Tài Lộc')
@section('decription','Soi cau theo thứ miền Bắc ✅ - Soi cau XSMB - Soi cau MB hàng ngày cực chuẩn, phân tích và thống kê các cặp số có khả năng về tính  theo CAU Mien Bac, CAU MB, SOI CAU MB.')
@section('keyword','bach thu mb, Soi cau XSMB,soi cau bach thu, soi cau lo bach thu, soi cau xsmb, cau bach thu xsmb, soi cau mb, cau xsmb, soi cau lo de mien bac, soi cau mien bac hom nay, bach thu lo, soi cau xsmb hom nay, cau lo bach thu, soi cau lo de mien bac hom nay, soi cau mien bac chinh xac nhat, lo bach thu, du doan xsmb chinh xac nhat, soi cau lo de chuan, soi cau lo de mb, soi cau mb hom nay, du doan ket qua xsmb toi nay, soi cau mb chinh xac, soi cau lo chinh xac nhat mien bac, Soi cau miền bắc, soi cau du doan ket qua xo so mien bac, du doan soi cau mien bac, soi cau du doan xsmb')
@section('h1','Soi cau theo thứ miền Bắc - Soi cau XSMB - Soi cau MB')

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
                                itemprop="item" href="{{url()->current()}}" title="Soi cau theo thứ miền Bắc"
                                class="last"><span itemprop="name">Soi cau theo thứ miền Bắc</span>
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
                <li><a href="{{route('scmb.cau-loto-2nhay')}}" title="Cầu lô tô 2 nháy">2 nháy</a>
                </li>
                <li class="active"><a href="{{route('scmb.cau-thu')}}" title="Cầu lô tô theo thứ">Cầu thứ</a>
                </li>
            </ul>
            <h2 class="tit-mien">
                <strong>Cầu theo thứ miền Bắc - Cầu XSMB chuẩn xác nhất</strong>
            </h2>

            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label">Chọn tỉnh</label>
                    <select name="province" id="province" class="form-control">
                        <option value="{{route('scmb.cau-thu')}}">Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option
                                    value="{{route('sctn.cau-thu',$pro->short_name)}}">{{$pro->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label">Chọn thứ</label>
                    @php $day_now = getThuNumber(date('Y-m-d', time())); @endphp
                    <select name="thu" id="thu" class="form-control">
                        @for($i=2;$i<=8;$i++)
                            @if($i==8)
                                <option class="text-selected" value="8" @if($i==$day_now) selected @endif>Chủ nhật
                                </option>
                            @else
                                <option class="text-selected" value="{{$i}}" @if($i==$day_now) selected @endif>
                                    Thứ {{$i}}</option>
                            @endif
                        @endfor
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
        <div class="box-content" style="height: auto !important;">

            <h2 dir="ltr"><strong>Giới thiệu trang soi cầu lô tuần thứ</strong></h2>

            <p><strong><a href="{{route('scmb.cau-thu')}}" title="Soi cầu lo to miền Bắc theo thứ trong tuần"><span
                                style="color:#0000FF">Soi cầu lo to miền Bắc theo thứ trong tuần</span></a></strong>
                thống kê kết quả của các cặp lô tô xuất hiện tại vị trí cầu ghép lại thường về&nbsp;trong biên độ mà
                người chơi lựa chọn.</p>

         <p><span style="font-weight: 400;">Cầu L&ocirc; T&ocirc; theo thứ. Cầu Loto Theo Thứ. Cầu Theo thứ Miền Bắc. Xem thống k&ecirc; Cầu L&ocirc; T&ocirc; theo thứ nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xstailoc.com</span></p>
            <p><span style="font-weight: 400;">xstailoc.com nơi cập nhật Cầu L&ocirc; T&ocirc; theo thứ. Bảng thống k&ecirc; Cầu L&ocirc; 2 nh&aacute;y li&ecirc;n tục, nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c nhất.</span></p>
            <h2><strong>Cầu L&ocirc; T&ocirc; theo thứ l&agrave; g&igrave;?</strong></h2>
            <p><span style="font-weight: 400;">Cầu L&ocirc; t&ocirc; theo thứ l&agrave; phương ph&aacute;p soi cầu hiệu quả được nhiều người chơi &aacute;p dụng. Mỗi thứ sẽ c&oacute; một cặp số đẹp để người chơi tham khảo, tăng tỷ lệ tr&uacute;ng thưởng. Với những người mới, kh&ocirc;ng nắm được phương ph&aacute;p đ&aacute;nh l&ocirc; theo thứ l&agrave; một thiệt th&ograve;i rất lớn.&nbsp;</span></p>
            <h2><strong>C&aacute;ch soi cầu l&ocirc; t&ocirc; theo thứ:</strong></h2>
            <p><span style="font-weight: 400;">- Chọn miền hoặc tỉnh bạn muốn xem</span></p>
            <p><span style="font-weight: 400;">- Chọn phương ph&aacute;p soi cầu theo chu kỳ của 2 dạng:</span></p>
            <p><span style="font-weight: 400;">+ L&ocirc; t&ocirc;: Gồm tất cả những cặp 2 số được gh&eacute;p từ c&aacute;c vị tr&iacute; trong bảng kết quả.</span></p>
            <p><span style="font-weight: 400;">+ Cầu đặc biệt: chỉ c&oacute; c&aacute;c l&ocirc; được gh&eacute;p từ những số trong giải đặc biệt v&agrave; c&aacute;c số tại vị tr&iacute; kh&aacute;c trong BXH.</span></p>
            <p><span style="font-weight: 400;">- Chọn thứ m&agrave; bạn muốn soi cầu L&ocirc; T&ocirc;:</span></p>
            <p><span style="font-weight: 400;">+ Bạn c&oacute; thể chọn xem từng thứ 2, 3, 4, 5, 6, 7 chủ nhật, kết quả soi cầu l&ocirc; đề truyền thống theo thứ sẽ được đưa ra của c&aacute;c thứ đ&oacute; trong nhiều tuần li&ecirc;n tiếp.</span></p>
            <p><span style="font-weight: 400;">+ Để chế độ &lsquo;Tất cả c&aacute;c ng&agrave;y trong tuần&rsquo;, kết quả l&ocirc; sẽ xuất hiện theo thứ sẽ được đưa ra cho cả tuần gần nhất.</span></p>
            <p><span style="font-weight: 400;">- Chọn bi&ecirc;n độ: bạn chọn bi&ecirc;n độ từ 1 cho đến 20 kỳ mở thưởng.</span></p>
            <p><span style="font-weight: 400;">- Nhấn v&agrave;o n&uacute;t 'Xem kết quả', c&aacute;c cặp l&ocirc; t&ocirc; gợi &yacute; sẽ được hiện ra.</span></p>
            <p><span style="font-weight: 400;">Lưu &yacute;: Để xem vị tr&iacute; cầu, người chơi chỉ cần nhấn v&agrave;o c&aacute;c cặp số trong bảng Soi cầu L&ocirc; T&ocirc; miền Bắc theo thứ trong tuần - Soi cầu theo chu kỳ để theo d&otilde;i.</span></p>
            <h2><strong>T&aacute;c dụng của xem thống k&ecirc; loto theo thứ trong tuần:</strong></h2>
            <p><span style="font-weight: 400;">- Từ những cặp số n&agrave;y, người chơi c&oacute; thể dễ d&agrave;ng lựa chọn cho m&igrave;nh kết quả xổ số l&ocirc; t&ocirc; đẹp c&oacute; x&aacute;c suất về cao trong tuần n&agrave;y hoặc tuần sau.</span></p>
            <p><span style="font-weight: 400;">- C&oacute; thể dễ d&agrave;ng t&igrave;m con số đ&aacute;nh l&ocirc; theo thứ trong tuần dễ về nhất.</span></p>
            <p><span style="font-weight: 400;">Mọi th&ocirc;ng tin bảng soi cầu L&ocirc; T&ocirc; theo thứ chỉ mang t&iacute;nh chất tham khảo, ch&uacute;c bạn may mắn!</span></p>
            <p><span style="font-weight: 400;">Xem Cầu L&ocirc; T&ocirc; Theo Thứ, Cầu Bạch Thủ, Cầu Trượt, Cầu 2 nh&aacute;y,.. nhanh ch&oacute;ng, kịp thời tại xstailoc.com</span></p>
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
                var thu = $('#thu').val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url_type = '{{route('scmb.cau-thu-ajax')}}';
                $.post(url_type, {
                    _token: CSRF_TOKEN,
                    date: date,
                    thu: thu,
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
            var thu = $('#thu').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url_type = '{{route('scmb.cau-thu-ajax')}}';
            $.post(url_type, {
                _token: CSRF_TOKEN,
                date: date,
                thu: thu,
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