<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Cầu trượt miền Bắc - Soi cau XSMB - Soi cau MB Xổ Số Tài Lộc')
@section('decription','Cầu trượt miền Bắc Xổ Số Tài Lộc ✅ - Soi cau XSMB - Soi cau MB hàng ngày cực chuẩn, phân tích và thống kê các cặp số có khả năng về tính  theo CAU Mien Bac, CAU MB, SOI CAU MB.')
@section('h1','Cầu trượt miền Bắc - Soi cau XSMB - Soi cau MB Xổ Số Tài Lộc')

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
                                itemprop="item" href="{{url()->current()}}" title="Cầu trượt miền Bắc"
                                class="last"><span itemprop="name">Cầu trượt miền Bắc</span>
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
                <li class="active"><a href="{{route('scmb.cau-truot')}}" title="Cầu lô tô trượt">Cầu trượt</a></li>
                <li><a href="{{route('scmb.cau-loto-2nhay')}}" title="Cầu lô tô 2 nháy">2 nháy</a>
                </li>
                <li><a href="{{route('scmb.cau-thu')}}" title="Cầu lô tô theo thứ">Cầu thứ</a>
                </li>
            </ul>
            <h2 class="tit-mien">
                <strong>Cầu trượt XSMB hôm nay</strong>
            </h2>

            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                    <select name="province" id="province" class="form-control">
                        <option value="{{route('scmb.cau-truot')}}">Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option value="{{route('sctn.cau-truot',$pro->short_name)}}">{{$pro->name}}</option>
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
        <div class="box-content" style="height: auto !important;">

            <p><span style="font-weight: 400;">Cầu L&ocirc; T&ocirc; Trượt. Cầu Loto Trượt. L&ocirc; Trượt. Xem Cầu L&ocirc; t&ocirc; trượt nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xstailoc.com</span></p>
                <p><span style="font-weight: 400;">xstailoc.com nơi cập nhật Cầu L&ocirc; T&ocirc; Trượt, L&ocirc; Trượt li&ecirc;n tục, nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c.</span></p>
                <h2><strong>L&ocirc; trượt l&agrave; g&igrave;?</strong></h2>
                <p><span style="font-weight: 400;">L&ocirc; trượt l&agrave; những con l&ocirc; kh&ocirc;ng về trong bảng KQXS. Cụ thể, những con l&ocirc; n&agrave;y kh&ocirc;ng tr&uacute;ng giải thưởng trong bảng KQXS.</span></p>
                <p><span style="font-weight: 400;">Được biết, miền Bắc c&oacute; 27 giải mở thưởng. Ch&iacute;nh v&igrave; vậy, người chơi sẽ c&oacute; tối thiểu l&agrave; 73 số trượt nếu kh&ocirc;ng xuất hiện trường hợp l&ocirc; về nhiều nh&aacute;y.</span></p>
                <p><span style="font-weight: 400;">Khi người chơi tiến h&agrave;nh đ&aacute;nh l&ocirc; trượt c&oacute; nghĩa rằng: Người chơi sẽ tham gia dự đo&aacute;n những con số sẽ về như th&ocirc;ng thường. Thay v&agrave;o đ&oacute;, người chơi tiến h&agrave;nh dự đo&aacute;n những con l&ocirc; kh&ocirc;ng về. Nhờ đ&oacute;, x&aacute;c suất soi cầu l&ocirc; trượt c&oacute; độ ch&iacute;nh x&aacute;c cao v&agrave; dễ ăn k&egrave;o hơn.</span></p>
                <h2><strong>L&ocirc; trượt gồm c&oacute; những loại n&agrave;o?</strong></h2>
                <p><span style="font-weight: 400;">Hiện nay, l&ocirc; trượt c&oacute; rất nhiều h&igrave;nh thức v&agrave; c&aacute;ch đ&aacute;nh. Dưới đ&acirc;y l&agrave; một số loại l&ocirc; trượt thường được &aacute;p dụng:</span></p>
                <p><span style="font-weight: 400;">L&ocirc; trượt 4: L&agrave; c&aacute;ch người chơi sẽ tiến h&agrave;nh đặt cược 4 con số, m&agrave; c&oacute; 2 chữ số sẽ kh&ocirc;ng quay về trong kỳ quay thưởng kế tiếp. Trong trường hợp, cả 4 số người chơi đặt cược m&agrave; kh&ocirc;ng về th&igrave; người chơi tr&uacute;ng thưởng. Đồng thời, chỉ cần 1 số về th&igrave; người chơi kh&ocirc;ng tr&uacute;ng.</span></p>
                <p><span style="font-weight: 400;">L&ocirc; trượt 6: Người chơi sẽ tiến h&agrave;nh chọn cho m&igrave;nh 6 cặp số từ 00 đến 99 m&agrave; ch&uacute;ng c&oacute; khả năng kh&ocirc;ng về cao nhất. Trường hợp, cả 6 con l&ocirc; n&agrave;y kh&ocirc;ng xuất hiện trong bảng kết quả kỳ quay th&igrave; người chơi sẽ thắng. C&ograve;n nếu c&oacute; 1 con xuất hiện th&igrave; c&aacute;c bạn đ&atilde; thua cuộc.</span></p>
                <p><span style="font-weight: 400;">L&ocirc; trượt 8: Cũng tương tự như tr&ecirc;n, người chơi sẽ tham gia cược 8 số m&agrave; khả năng sẽ kh&ocirc;ng về trong kỳ quay mở thưởng.</span></p>
                <p><span style="font-weight: 400;">L&ocirc; trượt 10: Người chơi sẽ tham gia đặt cược 10 số từ 00 đến 99 m&agrave; được nhận định sẽ kh&ocirc;ng về trong ỳ mở thưởng sắp tới.</span></p>
                <p><span style="font-weight: 400;">L&ocirc; trượt 12: Người chơi tiến h&agrave;nh tương tự như những c&aacute;ch chơi tr&ecirc;n. Người chơi đặt cược 12 số kh&ocirc;ng về. Nếu như, người chơi đo&aacute;n tr&uacute;ng hết th&igrave; giải thưởng nhận về cực kỳ cao.</span></p>
                <h2><strong>Hướng dẫn c&aacute;ch bắt l&ocirc; trượt theo bảng:</strong></h2>
                <p><span style="font-weight: 400;">Việc dự đo&aacute;n soi Cầu L&ocirc; Trượt sẽ l&agrave; c&ocirc;ng cụ hỗ trợ tốt nhất cho người chơi, c&aacute;ch xem như sau:</span></p>
                <p><span style="font-weight: 400;">- Chọn miền hoặc tỉnh bạn m&agrave; muốn xem</span></p>
                <p><span style="font-weight: 400;">- Chọn loại cầu: l&ocirc; t&ocirc; hoặc bạch thủ trong đ&oacute; l&ocirc; t&ocirc; ra cả xu&ocirc;i v&agrave; lộn, bạch thủ về duy nhất ch&iacute;nh n&oacute;.</span></p>
                <p><span style="font-weight: 400;">- Chọn bi&ecirc;n cầu chạy: Từ ng&agrave;y n&agrave;o trở lại.</span></p>
                <p><span style="font-weight: 400;">- Chọn bi&ecirc;n độ: Từ 1 cho đến 20 kỳ quay mở thưởng li&ecirc;n tiếp.</span></p>
                <p><span style="font-weight: 400;">- Nhấp v&agrave;o mục 'Xem kết quả', c&aacute;c cặp l&ocirc; t&ocirc; gợi &yacute; sẽ xuất hiện.</span></p>
                <p><span style="font-weight: 400;">- Để xem vị tr&iacute; cầu, người chơi chỉ cần nhấn v&agrave;o c&aacute;c cặp số trong Bảng cầu t&iacute;nh để theo d&otilde;i.</span></p>
                <p><span style="font-weight: 400;">Từ bảng, người chơi c&oacute; thể theo d&otilde;i được quy luật v&agrave; số lần xuất hiện của l&ocirc; đ&oacute; trong thời gian gần đ&acirc;y.</span></p>
                <h2><strong>Kinh nghiệm chơi l&ocirc; trượt:</strong></h2>
                <p><span style="font-weight: 400;">- Chọn ghi số l&ocirc; trượt ở bảng soi cầu c&oacute; được khi ph&acirc;n t&iacute;ch kết quả H&agrave; Nội.</span></p>
                <p><span style="font-weight: 400;">- Đ&aacute;nh theo c&aacute;c l&ocirc; đang gan nhiều ng&agrave;y chưa về.</span></p>
                <p><span style="font-weight: 400;">- Xem l&ocirc; n&agrave;o c&oacute; tần suất về nhiều, nhưng g&atilde;y trong 3-4 ng&agrave;y gần đ&acirc;y th&igrave; lấy n&oacute; nu&ocirc;i loto trượt.</span></p>
                <p><span style="font-weight: 400;">Từ những gợi &yacute; n&agrave;y, bạn c&oacute; thể bắt l&ocirc; trượt miền Bắc h&ocirc;m nay miễn ph&iacute; với những gợi &yacute; tốt nhất.</span></p>
                <p><span style="font-weight: 400;">Lưu &yacute;: Mọi th&ocirc;ng tin ở tr&ecirc;n chỉ mang t&iacute;nh chất tham khảo, ch&uacute;c bạn may mắn!</span></p>
                <p><span style="font-weight: 400;">Xem Cầu Trượt, Cầu Bạch Thủ, Cầu ĐB v&agrave; KQXS 3 Miền được cập nhật li&ecirc;n tục mỗi ng&agrave;y nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c tại xstailoc.com</span></p>
               

            <p style="text-align:center"><strong><a href="{{route('xsmb')}}" title="XS"><span
                                style="color:#0000FF">XS</span></a></strong></p>
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
                var url_type = '{{route('scmb.cau-truot-ajax')}}';
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
            var url_type = '{{route('scmb.cau-truot-ajax')}}';
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