<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Soi cau theo thứ XS' . strtoupper($province->short_name) . ' - Soi cau xổ số ' . $province->name . ' - Soi cau ' . $province->name)
@section('decription','Soi cau theo thứ XS' . strtoupper($province->short_name) .' - Danh sách Lô tô hôm nay có khả năng về tính theo Cầu xổ số ' . $province->name . '.Cầu Loto XS' . strtoupper($province->short_name))
@section('h1','Soi cau theo thứ XS' . strtoupper($province->short_name) . ' - Soi cau xổ số ' . $province->name . ' - Soi cau ' . $province->name)

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{url()->current()}}" title="Soi cau theo thứ {{$province->name}}" class="last"><span itemprop="name">Soi cau theo thứ {{$province->name}}</span><meta itemprop="position" content="2"></a></li>
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
                <li><a href="{{route('scmb.cau-loto-2nhay')}}" title="Cầu lô tô 2 nháy">2 nháy</a>
                </li>
                <li class="active"><a href="{{route('scmb.cau-thu')}}" title="Cầu lô tô theo thứ">Cầu thứ</a>
                </li>
            </ul>
            <h2 class="tit-mien">
                <strong>Cầu theo thứ {{$province->name}} - Cầu XS{{strtoupper($province->short_name)}} chuẩn xác nhất</strong>
            </h2>

            <form id="statistic-form" class="form-horizontal">
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label">Chọn tỉnh</label>
                    <select name="province" id="province" class="form-control">
                        <option value="{{route('scmb.cau-thu')}}">Miền Bắc</option>
                        @foreach($provinces as $pro)
                            <option
                                    value="{{route('sctn.cau-thu',$pro->short_name)}}" @if($pro->short_name==$province->short_name) selected @endif>{{$pro->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group field-statisticform-provinceid">
                    <label class="control-label">Chọn thứ</label>
                    @php $day_now = getThuNumber(date('Y-m-d', time())); @endphp
                    <select name="thu" id="thu" class="form-control">
                        @for($i=2;$i<=8;$i++)
                            @if($i==8)
                                <option class="text-selected" value="8" @if($i==$day_now) selected @endif>Chủ nhật</option>
                            @else
                                <option class="text-selected" value="{{$i}}"  @if($i==$day_now) selected @endif>Thứ {{$i}}</option>
                            @endif
                        @endfor
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

            <h2 dir="ltr"><strong>Giới thiệu trang soi cầu lô tuần thứ tại {{$province->name}}</strong></h2>

            <p><strong><a href="{{route('sctn.cau-thu',$province->short_name)}}" title="Soi cầu lo to {{$province->name}} theo thứ trong tuần"><span
                                style="color:#0000FF">Soi cầu lô tô với đài {{$province->name}} theo các  thứ trong tuần</span></a></strong>
                thống kê kết quả xổ số của các cặp lô tô xuất hiện tại vị trí cầu ghép lại thường về&nbsp;trong biên độ mà
                người chơi lựa chọn.</p>

            <h2><strong>Cách soi cầu lô tô theo thứ của đài {{$province->name}}:</strong></h2>

            <p dir="ltr">- Chọn miền hoặc tỉnh mà bạn muốn xem kết quả lô tô </p>

            <p dir="ltr">- Chọn loại phương pháp soi cầu lô tô theo chu kỳ của 2 dạng:</p>

            <p>+ Soi cầu Lô tô đài {{$province->name}}: Bao gồm tất cả các cặp 2 số được ghép từ các vị trí trong bảng kết quả.</p>

            <p>+ Cầu đặc biệt của đài {{$province->name}}: chỉ các lô được ghép từ các số trong giải đặc biệt và các số tại vị trí khác trong bảng kết quả soi cầu thứ.</p>

            <p>- Chọn thứ mà bạn muốn <strong><a href="{{route('sctn.cau-bach-thu',$province->short_name)}}" title="soi cầu loto"><span
                                style="color:#0000FF">soi cầu loto</span></a></strong> SCLT:</p>

            <p dir="ltr">+ Bạn có thể chọn xem theo từng thứ 2, 3, 4, 5, 6, 7 và chủ nhật trong tuần, kết quả soi cầu KQSC lô đề truyền
                thống theo thứ sẽ được đưa ra là của các thứ trong tuần đó trong nhiều tuần liên tiếp.</p>

            <p dir="ltr">+ Để xem chế độ '<strong>Tất cả các ngày trong tuần</strong>’, kết quả lô về theo thứ sẽ được đưa
                ra cho cả tuần gần nhất của đài {{$province->name}}.</p>

            <p>- Chọn biên độ: bạn sẽ chọn biên độ cầu theo thứ từ 1 cho đến 20 kỳ mở thưởng.</p>

            <p>- Nhấp vào mục '<strong>Xem kết quả soi cầu thứ</strong>', các cặp lô tô gợi ý sẽ được hiện ra.</p>

            <p><strong>Lưu ý</strong>: Để xem vị trí cầu soi cầu thứ, người chơi chỉ cần <strong>Click</strong>&nbsp;vào các cặp số
                trong bảng&nbsp;<span style="color:#FF0000"><strong>Soi cầu lô tô cầu thứ {{$province->name}} theo thứ trong tuần - Soi cầu
                        theo chu kỳ</strong></span> để theo dõi.</p>

            <h2 dir="ltr"><strong>Tác dụng của xem thống kê loto TKLoto về theo thứ trong tuần:</strong></h2>

            <p>- Từ những cặp số này, người chơi có thể lựa chọn cho mình&nbsp;<strong><a href="{{route('home')}}"
                                                                                          title="kết quả xổ số"><span
                                style="color:#0000FF">kết quả xổ số</span></a></strong>&nbsp;lô tô đẹp có xác suất về
                cao trong tuần này hoặc tuần sau.</p>

            <p dir="ltr">- Có thể tìm con số đánh lô theo soi cầu thứ trong tuần dễ về nhất .</p>

            <p dir="ltr">Mọi thông tin bảng soi cầu lo to theo thứ trên đây chỉ mang tính chất tham khảo, chúc bạn may
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
                var short_name = '{{$province->short_name}}';

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url_type = '{{route('sctn.cau-thu-ajax')}}';
                $.post(url_type, {
                    _token: CSRF_TOKEN,
                    date: date,
                    thu: thu,
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
            var thu = $('#thu').val();
            var short_name = '{{$province->short_name}}';
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url_type = '{{route('sctn.cau-thu-ajax')}}';
            $.post(url_type, {
                _token: CSRF_TOKEN,
                date: date,
                thu: thu,
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