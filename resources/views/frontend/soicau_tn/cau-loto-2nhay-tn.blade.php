<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Soi cau Loto 2 nháy XS' . strtoupper($province->short_name) . ' - Soi cau xổ số ' . $province->name . ' - Soi cau ' . $province->name)
@section('decription','Soi cau Loto 2 nháy XS' . strtoupper($province->short_name) .' - Danh sách Lô tô hôm nay có khả năng về tính theo Cầu xổ số ' . $province->name . '.Cầu Loto XS' . strtoupper($province->short_name))
@section('h1','Soi cau Loto 2 nháy XS' . strtoupper($province->short_name) . ' - Soi cau xổ số ' . $province->name . ' - Soi cau ' . $province->name)

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{url()->current()}}" title="Soi cau Loto 2 nháy {{$province->name}}" class="last"><span itemprop="name">Soi cau Loto 2 nháy {{$province->name}}</span><meta itemprop="position" content="2"></a></li>
                </ol></div>
        </div>
    </div>
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{url('frontend/css/bachthu.css')}}?v={{rand(1000,100000)}}" media="all">
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
                <strong>Cầu Loto ăn 2 nháy, cả cặp {{$province->name}} - Cầu XS{{strtoupper($province->short_name)}} chuẩn xác nhất</strong>
            </h2>

            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                    <select name="province" id="province" class="form-control">
                        <option value="{{route('scmb.cau-loto-2nhay')}}">Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option value="{{route('sctn.cau-loto-2nhay',$pro->short_name)}}" @if($pro->short_name==$province->short_name) selected @endif>{{$pro->name}}</option>
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
                    <input type="number" id="cauloto" class="form-control" name="cauloto" placeholder="Số ngày: 1 - 20" value="2">

                    <div class="help-block"></div>
                </div>
                <div class="txt-center">
                    <button type="button" class="btn btn-danger" onclick="getContentCau()">Xem kết quả</button>
                </div>
            </form>
        </div>
        <div class="box"  id="contentCau">
        </div>
        <div class=" box-content" style="height: auto !important;">

            <h2 dir="ltr"><strong>Lô 2 nháy {{$province->name}} là gì?</strong></h2>

            <p dir="ltr">Đây là loại lô tô 2 nháy về liên tục 2 lần trong bảng kết quả xổ số. VD: Hôm nay bạn thấy có lô 23 về 2 lần
                thì có nghĩa là nó ra 2 nháy trong bản lôt 2 nháy.</p>

            <p dir="ltr">Tương tự lô tô 3 nháy và 4 nháy tức là xuất hiện 3 hoặc 4 lần trong bảng kết quả xổ số truyền thống.</p>

            <h2 dir="ltr"><strong>Giới thiệu về soi cầu lô tô 2 nháy của đài {{$province->name}} miễn phí</strong></h2>

            <p><strong><a href="{{route('sctn.cau-loto-2nhay',$province->short_name)}}" title="Soi cầu 2 nháy XS {{$province->name}}"><span
                                style="color:#0000FF">Soi cầu lô tô 2 nháy XS {{$province->name}}</span></a></strong> thống kê các vị trí ghép lại với nhau tạo thành cặp lô tô loto xuất hiện 2 lần hoặc xuất hiện cặp xuôi và lộn của nó trong bảng kết quả lô tô 2 nháy ngày tiếp theo trong khoảng thời gian gần đây.</p>

            <p dir="ltr">- Chọn biên cầu chạy lô tô 2 nháy : từ ngày nào đổ về trước, thông thường mặc định ngày quay số mới nhất.</p>

            <p dir="ltr">- Chọn biên độ {{$province->name}}: bạn sẽ chọn biên độ từ 1 cho đến 20 kỳ mở thưởng.</p>

            <p dir="ltr">- Nhấp vào mục '<strong>Xem kết quả</strong>', các cặp lô tô 2 nháy gợi ý sẽ được hiện ra.</p>

            <p dir="ltr">- Để xem vị trí cầu loto hai nháy nhanh nhất tại đài {{$province->name}} đẹp nhất hôm nay, người chơi chỉ cần Click vào các
                cặp số trong bảng <strong>Soi cầu lô tô SCLT 2 nháy</strong> để theo dõi.</p>

            <h2 dir="ltr"><strong>Xem quy luật soi cầu lô tô hai nháy {{$province->name}}:</strong></h2>

            <p dir="ltr">- Quy ước chung của cầu loto 2 nháy: số đầu tiên của giải đặc biệt mặc định là 0, sắp xếp theo số tự nhiên, đến số
                cuối giải 7 sẽ có thứ tự là 106 của đài xổ số truyền thống.</p>

            <p dir="ltr">- Click chuột vào ô số mà bạn muốn kiểm tra, màn hình sẽ hiển thị ‘vị trí tạo cầu’ lô tô 2 nháy của nó trong
                thời gian này, từ đó có thể thấy được vị trí đó trong mấy ngày gấn nhất có cho ra lô dạng 2 nháy hoặc một cặp
                xuôi và lộn.</p>

            <h2 dir="ltr"><strong>Trúng loto 2 nháy được bao nhiêu tiền? tại đài {{$province->name}}</strong></h2>

            <p dir="ltr">- Nếu như bạn nuôi 1 loto mà nó về 2 nháy thì coi như ăn 2 lô liên tiếp trong lô, số tiền sẽ được gấp đôi,
                tương tự như vậy với 3 nháy và 4 nháy.</p>

            <p dir="ltr">Mọi thông tin soi cầu lo to {{$province->name}} theo thứ trên đây chỉ mang tính chất tham khảo, chúc bạn may
                mắn!</p>

            <p><strong>Tham khảo thêm các cặp số lô tô  {{$province->name}} đẹp tại các vị trí thưởng về&nbsp;trong thời gian gần đây
                    tại:</strong></p>

            <p style="text-align:center"><strong><a href="{{route('sctn.cau-bach-thu',$province->short_name)}}" title="Soi cầu bạch thủ hôm nay"><span
                                style="color:#0000FF">Soi cầu bạch thủ hôm nay</span></a></strong></p>
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
                var short_name = '{{$province->short_name}}';

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url_type = '{{route('sctn.cau-loto-2nhay-ajax')}}';
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
            var url_type = '{{route('sctn.cau-loto-2nhay-ajax')}}';
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