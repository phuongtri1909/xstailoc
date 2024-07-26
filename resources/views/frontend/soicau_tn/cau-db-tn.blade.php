<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Soi cau giải đặc biệt XS' . strtoupper($province->short_name) . ' - Soi cau xổ số ' . $province->name . ' - Soi cau ' . $province->name)
@section('decription','Soi cau giải đặc biệt XS' . strtoupper($province->short_name) .' - Danh sách Lô tô hôm nay có khả năng về tính theo Cầu xổ số ' . $province->name . '.Cầu Loto XS' . strtoupper($province->short_name))
@section('h1','Soi cau giải đặc biệt XS' . strtoupper($province->short_name) . ' - Soi cau xổ số ' . $province->name . ' - Soi cau ' . $province->name)

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{url()->current()}}" title="Soi cau giải đặc biệt {{$province->name}}" class="last"><span itemprop="name">Soi cau giải đặc biệt {{$province->name}}</span><meta itemprop="position" content="2"></a></li>
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
                {{--<li class="active"><a href="#" title="Cầu lô tô đặc biệt">Cầu ĐB</a>--}}
                {{--</li>--}}
                <li><a href="{{route('scmb.cau-truot')}}" title="Cầu lô tô trượt">Cầu trượt</a></li>
                <li><a href="{{route('scmb.cau-loto-2nhay')}}" title="Cầu lô tô 2 nháy">2 nháy</a>
                </li>
                <li><a href="{{route('scmb.cau-thu')}}" title="Cầu lô tô theo thứ">Cầu thứ</a>
                </li>
            </ul>
            <h2 class="tit-mien">
                <strong>Cầu giải đặc biệt {{$province->name}} - Cầu XS{{strtoupper($province->short_name)}} chuẩn xác nhất</strong>
            </h2>

            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                    <select name="province" id="province" class="form-control">
                        <option value="#">Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option
                                    value="{{route('sctn.cau-db',$pro->short_name)}}" @if($pro->short_name==$province->short_name) selected @endif>{{$pro->name}}</option>
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
                    <input type="number" id="cauloto" class="form-control" name="cauloto" placeholder="Số ngày: 1 - 20" value="1">

                    <div class="help-block"></div>
                </div>
                <div class="txt-center">
                    <button type="button" class="btn btn-danger" onclick="getContentCau()">Xem kết quả</button>
                </div>
            </form>
        </div>
        <div class="box"  id="contentCau">
        </div>
        <div class=" box box-html" style="height: auto !important;">

            <p><strong><a href="{{route('sctn.cau-db',$province->short_name)}}" title="Soi cầu giải đặc biệt {{$province->name}}"><span
                                style="color:#0000FF">Soi cầu giải đặc biệt {{$province->name}}</span></a></strong>&nbsp;thống kê
                các cặp lô tô xuất hiện được ghép từ các vị trí trong bảng kết quả truyền thống về liên tục trong khoảng
                một khoảng thời gian gần đây, bao gồm cả lô bằng và lộn của nó.</p>
            <p dir="ltr">- Chọn biên ngày cầu chạy: từ ngày nào đổ về trước</p>

            <p dir="ltr">- Chọn biên độ: bạn sẽ chọn biên độ từ 1 cho đến 20 kỳ mở thưởng liên tiếp gần đây.</p>

            <p dir="ltr">- Nhấp vào mục '<strong>Xem kết quả</strong>', các cặp lô tô gợi ý sẽ được hiện ra trong bảng
                ‘Soi cầu đặc biệt’.</p>

            <h2 dir="ltr"><strong>Cách theo dõi quy luật soi cầu đặc biệt chạy 3 ngày:</strong></h2>

            <p dir="ltr">- Quy ước chung, số đầu tiên của giải đặc biệt là 0, tiếp theo thứ tự số tự nhiên, ta có tổng
                cộng 107 vị trí từ 0 tới 106 (số cuối cùng của giải 7).</p>

            <p dir="ltr">- Khi bạn muốn theo dõi cầu nào thì click chuột vào nó, màn hình sẽ hiển thị ‘vị trí tạo cầu’
                của nó và trong thời gian này nó về hôm sau bao nhiêu lần, xuôi hay lộn.</p>

            <p><span style="color:#FF0000"><em>Mọi thông tin soi cầu&nbsp;lo to theo thứ&nbsp;trên đây chỉ mang tính
                        chất tham khảo, chúc bạn may mắn!</em></span></p>

            <p><strong>Tham khảo thêm các cặp số lô tô đẹp trong thời gian gần đây tại:</strong></p>

            <p style="text-align:center"><strong><a href="{{route('sctn.cau-bach-thu',$province->short_name)}}"
                                                    title="Soi cầu bạch thủ lô tô"><span style="color:#0000FF">Soi cầu bạch thủ lô tô</span></a></strong>
            </p>
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