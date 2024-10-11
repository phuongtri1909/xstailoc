<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Cầu trượt XS' . strtoupper($province->short_name) . ' - Soi cau xổ số ' . $province->name . ' - Soi cau ' . $province->name)
@section('decription','Cầu trượt XS' . strtoupper($province->short_name) .' - Danh sách Lô tô hôm nay có khả năng về tính theo Cầu xổ số ' . $province->name . '.Cầu bạch thủ XS' . strtoupper($province->short_name))
@section('h1','Cầu trượt XS' . strtoupper($province->short_name) . ' - Soi cau xổ số ' . $province->name . ' - Soi cau ' . $province->name)

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{url()->current()}}" title="Cầu trượt {{$province->name}}" class="last"><span itemprop="name">Cầu trượt {{$province->name}}</span><meta itemprop="position" content="2"></a></li>
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
                <li class="active"><a href="{{route('scmb.cau-truot')}}" title="Cầu lô tô trượt">Cầu trượt</a></li>
                <li><a href="{{route('scmb.cau-loto-2nhay')}}" title="Cầu lô tô 2 nháy">2 nháy</a>
                </li>
                <li><a href="{{route('scmb.cau-thu')}}" title="Cầu lô tô theo thứ">Cầu thứ</a>
                </li>
            </ul>
            <h2 class="tit-mien">
                <strong>Cầu trượt {{$province->name}} - Cầu XS{{strtoupper($province->short_name)}} chuẩn xác nhất</strong>
            </h2>

            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label" for="statisticform-provinceid">Chọn tỉnh</label>
                    <select name="province" id="province" class="form-control">
                        <option value="{{route('scmb.cau-truot')}}">Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option
                                    value="{{route('sctn.cau-truot',$pro->short_name)}}" @if($pro->short_name==$province->short_name) selected @endif>{{$pro->name}}</option>
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

        <div class="box-content" style="height: auto !important;">

            <h2 dir="ltr"><strong>Lô trượt xổ số {{$province->name}} là gì?</strong></h2>

            <p dir="ltr">Tên như ý nghĩa, đây là loại lô trượt không về trong bảng kết quả xổ số {{$province->name}} truyền thống trong ngày hôm đó.&nbsp;</p>

            <p dir="ltr">Đánh lô trượt tức là bạn phải đặt cược những lô chắc chắn sẽ không về trong kết quả xổ số KQXS
                truyền thống.</p>

            <h2 dir="ltr"><strong>Giới thiệu về soi cầu lô trượt xổ số {{$province->name}}</strong></h2>

            <p><strong><a href="{{route('sctn.cau-truot',$province->short_name)}}" title="Soi cầu lô trượt"><span style="color:#0000FF">Soi cầu lô trượt</span></a></strong>  
                là một trong những thủ thuật , phương pháp giúp cho người chơi có thể tránh được những cặp số không về hoặc có xác
                suất về cực thấp.</p>

            <p dir="ltr"> Cầu lô trượt cũng là một trong những loại hình trò chơi rất được ưa chuộng hiện nay, so với việc
                đoán cặp số nào sắp về với tỷ lệ trúng là 27% thì hiển nhiên việc đoán các cặp không về với xác suất là 73% hoàn
                toàn cao hơn nhiều.</p>

            <h2 dir="ltr"><strong>Đánh lô trượt được bao nhiêu? tại xosotailoc.vip</strong></h2>

            <p dir="ltr">Có 7  hình thức đánh ăn lô trượt hiện nay:</p>

            <p dir="ltr">- Đánh lô trượt 4 con: tỷ lệ trúng ăn 1:2 hoặc 1:3.</p>

            <p dir="ltr">- Đánh lô trượt 6 con: tỷ lệ trúng ăn 1:2,63</p>

            <p dir="ltr">- Đánh lô trượt 7 con: tỷ lệ trúng ăn 1:3,1</p>

            <p dir="ltr">- Đánh lô trượt 8 con: tỷ lệ trúng ăn 1:3,76 hoặc 1 ăn 8</p>

            <p dir="ltr">- Đánh lô trượt 9 con: tỷ lệ trúng ăn 1:4,54.</p>

            <p dir="ltr">- Đánh lô trượt 10 con: tỷ lệ trúng ăn 1:12 cũng có nơi chỉ có 1 ăn 5,5..</p>

            <p dir="ltr">1 điểm lô trượt là 27.000 vnđ, trúng sẽ được ăn 99.000 vnđ.</p>

            <h2 dir="ltr"><strong>Hướng dẫn cách bắt lô trượt {{$province->name}} theo bảng:</strong></h2>

            <p dir="ltr">Việc dự đoán <strong><a href="{{route('sctn.cau-bach-thu',$province->short_name)}}" title="soi cầu lô tô bạch thủ"><span
                                style="color:#0000FF">soi cầu lô tô {{$province->name}}  bạch thủ</span></a></strong> trượt sẽ là công cụ hỗ trợ
                tốt nhất cho người chơi, cách xem như sau:</p>

            <p dir="ltr">- Chọn miền hoặc tỉnh mà bạn muốn xem lô trượt</p>

            <p dir="ltr"><strong>- Chọn loại cầu:</strong> lô tô {{$province->name}}  hoặc bạch thủ trong đó lô tô ra cả xuôi và lộn, bạch
                thủ về duy nhất chính nó.</p>

            <p dir="ltr"><strong>- Chọn biên cầu chạy lô trượt:</strong> Từ ngày nào đổ lại.</p>

            <p dir="ltr"><strong>- Chọn biên độ lô trượt: </strong>từ 1 cho đến 20 kỳ mở thưởng liên tiếp.</p>

            <p dir="ltr">- Nhấp vào mục '<strong>Xem kết quả</strong>', các cặp lô tô LT  gợi ý sẽ được hiện ra.</p>

            <p dir="ltr">- Để xem vị trí cầu lô trượt, người chơi chỉ cần Click vào các cặp số trong <strong>Bảng cầu
                    tính</strong> để theo dõi.</p>

            <p dir="ltr">Từ bảng, người xem có thể theo dõi được quy luật và số lần xuất hiện của lô {{$province->name}} trong thời gian
                gần đây.</p>

            <h2 dir="ltr"><strong>Kinh nghiệm chơi lô trượt {{$province->name}} với xosotailoc.vip :</strong></h2>

            <p dir="ltr">- Chọn ghi số lô trượt ở bảng soi cầu đã có khi phân tích kết quả {{$province->name}} .</p>

            <p dir="ltr">- Đánh theo các lô đang gan {{$province->name}}  nhiều ngày chưa.</p>

            <p dir="ltr">- Xem lô {{$province->name}}  nào có tần suất về nhiều, nhưng gãy trong 3-4 ngày gần đây thì lấy nó nuôi loto
                trượt.</p>

            <p dir="ltr">Từ những gợi ý này, bạn có thể bắt lô trượt xổ số {{$province->name}} hôm nay miễn phí từ những gợi ý tốt
                nhất.</p>

            <div><span style="color:#FF0000"><em>Mọi thông tin trên đây chỉ mang tính chất tham khảo, chúc bạn may
                        mắn!</em></span></div>

            <p><strong>Xem kết quả xổ số KQXS hàng ngày trực tiếp mới nhất, truy cập:</strong></p>

            <p style="text-align:center"><strong><a href="{{route('home')}}" title="XS"><span
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
                var short_name = '{{$province->short_name}}';

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url_type = '{{route('sctn.cau-truot-ajax')}}';
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
            var url_type = '{{route('sctn.cau-truot-ajax')}}';
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