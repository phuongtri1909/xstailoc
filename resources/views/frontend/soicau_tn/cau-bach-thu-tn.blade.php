<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Soi cau Bạch Thủ XS' . strtoupper($province->short_name) . ' - Soi cau xổ số ' . $province->name . ' - Soi cau ' . $province->name)
@section('decription','Soi cau Bạch Thủ XS' . strtoupper($province->short_name) .' - Danh sách Lô tô hôm nay có khả năng về tính theo Cầu xổ số ' . $province->name . '.Cầu bạch thủ XS' . strtoupper($province->short_name))
@section('h1','Soi cau Bạch Thủ XS' . strtoupper($province->short_name) . ' - Soi cau xổ số ' . $province->name . ' - Soi cau ' . $province->name)

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{url()->current()}}" title="Soi cau bạch thủ {{$province->name}}" class="last"><span itemprop="name">Soi cau bạch thủ {{$province->name}}</span><meta itemprop="position" content="2"></a></li>
                </ol></div>
        </div>
    </div>
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{url('frontend/css/bachthu.css')}}?v={{rand(1000,100000)}}" media="all">
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
                <strong>Cầu Bạch thủ {{$province->name}} - Cầu XS{{strtoupper($province->short_name)}} chuẩn xác nhất</strong>
            </h2>

            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                    <select name="province" id="province" class="form-control">
                        <option value="{{route('scmb.cau-bach-thu')}}">Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option
                                    value="{{route('sctn.cau-bach-thu',$pro->short_name)}}" @if($pro->short_name==$province->short_name) selected @endif>{{$pro->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group field-statisticform-fromdate">
                    <label class="control-label" for="statisticform-fromdate">Biên ngày cầu chạy</label>
                    <input type="text" id="end_date" class="form-control" name="end_date" placeholder="Chọn ngày" value="{{date('d/m/Y')}}">

                    <div class="help-block"></div>
                </div>
                <div class="form-group field-statisticform-numofday">
                    <label class="control-label" for="statisticform-numofday">Chọn biên độ</label>
                    <input type="number" id="cauloto" class="form-control" name="cauloto" placeholder="Số ngày: 1 - 20" value="3">

                    <div class="help-block"></div>
                </div>
                <div class="txt-center">
                    <button type="button" class="btn btn-danger" onclick="getContentCau()">Xem kết quả</button>
                </div>
            </form>
        </div>
        <div class="box"  id="contentCau">
        </div>

        <div class="box-content">

            <h2 dir="ltr"><strong>Lô bạch thủ đài {{$province->name}} là gì?</strong></h2>

            <p dir="ltr">Đánh bạch thủ lô đề đài {{$province->name}}  có nghĩa là bạn đang đặt cược vào một ván duy nhất mà không lựa chọn thêm những số nào nữa để có cơ hội chiến thắng được số tiền lớn hơn.</p>

            <h2 dir="ltr"><strong>Soi cầu bạch thủ lô đài {{$province->name}} là gì?</strong></h2>

            <p dir="ltr">Đây là hình thức lựa chọn ra cặp số cầu bạch thủ có xác suất trúng cực cao, thường chỉ áp dụng tính toán một
                số cho một lần dự thưởng của người chơi nhanh nhất.</p>

            <p><strong><a href="{{url()->current()}}"><span
                                style="color:#0000FF">Soi cầu bạch thủ lô SCBTL tại đài {{$province->name}}</span></a></strong> vip miễn phí tổng
                hợp các cặp lô đẹp nhất tại {{$province->name}} có xác suất về cao trong ngày hôm nay, ngày mai dựa theo hệ thống phân tích cho
                độc giả tham khảo.</p>

            <p dir="ltr">Phương pháp soi kèo xổ số đài {{$province->name}} này dựa theo các vị trí của các con số trong các giải truyền thống được
                quay số mở thưởng của đài {{$province->name}} trong các ngày trước đó, xem những vị trí nào ghép lại với nhau sẽ có ra lô về cho
                ngày tiếp theo xổ số{{$province->name}}, từ đó chúng ta sẽ tìm ra các cầu lô đẹp nhất hôm nay dễ trúng nhất – cách này còn được
                gọi là soi cầu&nbsp;động.</p>

            <h2 dir="ltr"><strong>Cách soi cầu lô bạch thủ XS{{strtoupper($province->short_name)}} theo bảng như sau:</strong></h2>

            <p dir="ltr"><strong>- Nhấp vào loại cầu {{$province->name}}:</strong> Chọn cách xem thống kê bạch thủ miền bắc trong 2 dạng
                tại:</p>

            <p dir="ltr">+ Lô tô {{$province->name}}: Hệ thống máy tính cập nhật tổng hợp tất cả lô rơi từ các vị trí trong bảng kết quả hôm
                trước ra hôm sau, bao gồm cả về bằng hoặc về lộn của lô tô trước đó.</p>

            <p dir="ltr">+ Cầu bạch thủ {{$province->name}}: chỉ cập nhật những cặp lô BT đẹp nhất miền bắc về bằng được ghép từ các vị trí
                kết quả trong các kỳ quay gần nhất.</p>

            <p dir="ltr"><strong>- Chọn biên ngày cầu chạy {{$province->name}}: </strong>trang mặc định cho cầu số ngày hôm nay để tính lô
                bạch thủ miền bắc. Tuy nhiên, bạn có thể chọn xem mốc của các ngày trước trở về của đài {{$province->name}}.</p>

            <p dir="ltr"><strong>- Chọn biên độ {{$province->name}}:</strong> trang mặc định biên độ từ 1 cho đến 20 ngày, người chơi sẽ xem
                được chi tiết cầu cầu lô xổ số {{strtoupper($province->short_name)}} tại các vị trí nào đang về liên tục trong khoảng thời gian đó.</p>

            <p dir="ltr">- Nhấp chọn '<strong>Xem kết quả xổ số {{$province->name}}</strong>'</p>

            <p dir="ltr">VD: Bạn chọn xem biên độ trong 3 ngày, bạn có thể thấy bảng cầu bạch thủ sẽ hiện ra một bảng tính soi cầu bạch
                thủ lô tô&nbsp;chạy trong 3 ngày và 3 bảng kết quả xổ số truyền thống bên dưới.</p>

            <p dir="ltr">Người xem di chuyển chuột vào các số trong bảng tính cầu bạch thủ hoặc nhấp vào đó, bạn có thể thấy được cầu bạch thủ {{$province->name}} sẽ hiển thị các vị trí của lô cầu bạch thủ trước đó trong bảng kết quả KQ, tính từ số đầu đuôi của giải đặc biệt là 0 cho đến số
                cuối giải 7 là vị trí thứ 106.</p>

            <h2 dir="ltr"><strong>Hướng dẫn chọn hôm nay bạch thủ lô của đài {{$province->name}} đánh con gì?</strong></h2>

            <p dir="ltr">Có hai cách chọn số đánh hôm nay cầu bạch thủ lô là:</p>

            <p dir="ltr">- Từ những con số bôi đỏ chính là cặp lô bạch thủ Miên bắc hôm nay mà bạn cần chọn, bạn có thể chọn
                một trong đó.</p>

            <p dir="ltr">- Theo phương pháp khác đó là bạn có thể quan sát các cầu lật lô tô liên tục trong bảng <strong><a
                            href="{{route('home')}}" title="kết quả xổ số"><span
                                style="color:#0000FF">kết quả xổ số</span></a></strong> KQXS  miền bắc bên dưới, chọn biên độ
                là khoảng 2 đến 4 ngày.</p>

            <p dir="ltr">Theo những phân tích của các chuyên gia soi cầu miền bắc SCMB thì tỷ lệ lô rơi trong 2 ngày thường
                sẽ ra tiếp vào ngày thứ 3, về 3 ngày liên tiếp của đài xổ số {{$province->name}} thì sẽ có khả năng rơi tiếp vào ngày thứ 4,... Có nghĩa là xác suất cầu bạch thủ  {{$province->name}} chạy liên tục trong 3-5 ngày là cao nhất.</p>

            <p dir="ltr">Vì thế lựa chọn các cầu lật bạch thủ liên tục trong khoảng thời gian trên là có tỷ lệ ăn bạch thu lô đề
                cao hơn.</p>
            <p dir="ltr"><strong>* Lưu ý: </strong>Mọi thông tin trên đây chỉ mang tính chất tham khảo, chúc bạn may
                mắn!</p> 
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
                var short_name = '{{$province->short_name}}';

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url_type = '{{route('sctn.cau-bach-thu-ajax')}}';
                $.post(url_type, {
                    _token: CSRF_TOKEN,
                    date: date,
                    count: count,
                    short_name: short_name
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
            var short_name = '{{$province->short_name}}';
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url_type = '{{route('sctn.cau-bach-thu-ajax')}}';
            $.post(url_type, {
                _token: CSRF_TOKEN,
                date: date,
                count: count,
                short_name: short_name
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