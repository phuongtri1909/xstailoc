<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Bảng đặc biệt tuần - Thống kê giải đặc biệt theo tuần, XSMB tuần Với Xổ Số Tài Lộc')
@section('decription','Thống kê giải đặc biệt Xổ số Miền Bắc Với  Xổ Số Tài Lộc- Thống kê Xổ số Miền Bắc theo tuần, tháng, năm.')
@section('keyword','Thống kê giải đặc biệt, Thống kê Miền Bắc, Thống kê giải đặc biệt Miền Bắc, Thong ke giai dac biet')
@section('h1','Bảng đặc biệt tuần - Thống kê giải đặc biệt theo tuần, XSMB tuần Với Xổ Số Tài Lộc')
@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{route('tk.dac-biet-tuan')}}" title="TK đặc biệt theo tuần" class="last"><span itemprop="name">TK đặc biệt theo tuần</span><meta itemprop="position" content="2"></a></li>
                </ol></div>
        </div>
    </div>
@endsection
@section('content')
    {{--<link href="{{url('frontend/css/daterangepicker.min.css')}}"rel="stylesheet">--}}
    {{--<link href="{{url('frontend/css/daterangepicker-kv.min.css')}}"rel="stylesheet">--}}
    {{--<link href="{{url('frontend/css/kv-widgets.min.css')}}"rel="stylesheet">--}}
    {{--<script src="{{url('frontend/js/moment.min.js')}}"></script>--}}
    {{--<script src="{{url('frontend/js/vi.js')}}"></script>--}}
    <div class="col-l">
        <div class="box tk-tong-db">
            <ul class="tab-panel tab-auto">
                <li><a href="#" title="TK GĐB">TK GĐB</a></li>
                <li class="active"><a href="{{route('tk.dac-biet-tuan')}}" title="TK đặc biệt theo tuần">Theo tuần</a>
                </li>
                <li><a href="{{route('tk.dac-biet-thang')}}" title="TK đặc biệt theo tháng">Theo tháng</a></li>
                <li><a href="{{route('tk.dac-biet-nam')}}" title="TK đặc biệt theo năm">Theo năm</a></li>
            </ul>

            <div class="clearfix">
                <h2 class="tit-mien magb10"><strong>Bảng đặc biệt tuần</strong></h2>

                <form id="statistic-form" class="clearfix form-horizontal">
                    <div class="form-group drp-container">
                        <label>Chọn tỉnh</label>
                        <select id="province" name="province" class="form-control">
                            <option value="mb" selected>Miền Bắc</option>
                            @foreach($provinces as $pro)
                                <option value="{{$pro->id}}">{{$pro->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group field-statisticform-fromdate">
                        <label class="control-label" for="statisticform-fromdate">Từ ngày</label>
                        <input type="text" id="start_date" class="form-control" name="StatisticForm[fromDate]"
                               value="{{getNgay($date_start_dbtuan)}}">

                        <div class="help-block"></div>
                    </div>
                    <div class="form-group field-statisticform-todate">
                        <label class="control-label" for="statisticform-todate">Đến ngày</label>
                        <input type="text" id="end_date" class="form-control" name="StatisticForm[toDate]"
                               value="{{getNgay($date_end_dbtuan)}}">

                        <div class="help-block"></div>
                    </div>
                    {{--<div class="form-group drp-container">--}}
                    {{--<label>Chọn ngày</label>--}}
                    {{--<input type="text" id="statisticform-fromdate" class="form-control"--}}
                    {{--name="StatisticForm[fromDate]" value="05-07-2023 - 13-10-2023"--}}
                    {{--data-krajee-daterangepicker="daterangepicker_4e249988"></div>--}}

                    <div class="form-group txt-center">
                        <button type="button" class="btn btn-danger" onclick="getThongKeLo()">Xem kết quả</button>
                    </div>

                </form>
            </div>
        </div>
        <div class="box" id="monthly-result">
            <h2 class="tit-mien bold">Bảng đặc biệt miền Bắc theo tuần</h2>

            <div class="title-c2 pad10 txt-center">
                <div class="toogle-buttons">
                        <span class="toggle-button">
                            <input type="checkbox" id="dau-toggle-input" data-class="dau" class="cbx dspnone">
                            <label class="lbl1" for="dau-toggle-input"></label><span>Đầu</span>
                        </span>
                        <span class="toggle-button">
                            <input type="checkbox" id="duoi-toggle-input" data-class="duoi" class="cbx dspnone">
                            <label class="lbl1" for="duoi-toggle-input"></label><span>Đuôi</span>
                        </span>
                        <span class="toggle-button">
                            <input type="checkbox" id="loto-toggle-input" data-class="loto" class="cbx dspnone">
                            <label class="lbl1" for="loto-toggle-input"></label><span>Loto</span>
                        </span>
                        <span class="toggle-button">
                            <input type="checkbox" id="tong-toggle-input" data-class="tong" class="cbx dspnone">
                            <label class="lbl1" for="tong-toggle-input"></label><span>Tổng</span>
                        </span>
                </div>

            </div>
            <div class="tk-tong-db tk-db">
                <table>
                    <tbody>
                    <tr>
                        <th>Thứ 2</th>
                        <th>Thứ 3</th>
                        <th>Thứ 4</th>
                        <th>Thứ 5</th>
                        <th>Thứ 6</th>
                        <th>Thứ 7</th>
                        <th>CN</th>
                    </tr>
                    <tr>
                        @for($i=2;$i<$kqs[0]->day;$i++)
                            <td>
                                <span></span>
                            </td>
                        @endfor
                        @php $d = $kqs[0]->day;@endphp
                        @foreach($kqs as $kq)
                            @if($d==$kq->day)
                                <td>
                                    <div> {{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span
                                                class="clblue">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                                    <div class="ngay-quay">{{getNgayThangNam2So($kq->date)}}</div>
                                    <div class="clnote dau ">{{Tong(substr($kq->gdb,strlen($kq->gdb)-2))}}</div>
                                    <div class="clnote duoi ">{{substr($kq->gdb,strlen($kq->gdb)-2,1)}}</div>
                                    <div class="clnote loto ">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</div>
                                    <div class="clnote tong ">{{substr($kq->gdb,strlen($kq->gdb)-1,1)}}</div>

                                    <span></span>
                                </td>
                            @else
                                @while ($d!=$kq->day)
                                    <td>
                                        <span></span>
                                    </td>
                                    @if($d%8==0) </tr>
                    <tr> @php $d=1; @endphp @endif
                        @php $d++; @endphp
                        @if($d==$kq->day)
                            <td>
                                <div> {{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span
                                            class="clblue">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                                <div class="ngay-quay">{{getNgayThangNam2So($kq->date)}}</div>
                                <div class="clnote dau ">{{Tong(substr($kq->gdb,strlen($kq->gdb)-2))}}</div>
                                <div class="clnote duoi ">{{substr($kq->gdb,strlen($kq->gdb)-2,1)}}</div>
                                <div class="clnote loto ">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</div>
                                <div class="clnote tong ">{{substr($kq->gdb,strlen($kq->gdb)-1,1)}}</div>

                                <span></span>
                            </td>
                        @endif
                        @endwhile
                        @endif
                        @if($d%8==0) </tr>
                    <tr> @php $d=1; @endphp @endif
                        @php $d++; @endphp
                        @endforeach
                        @for($j=$kqs[count($kqs)-1]->day + 1;$j<=8;$j++)
                            <td>
                                <span></span>
                            </td>
                        @endfor
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-content">

            <p dir="ltr">Thống kê giải đặc biệt theo tuần là bảng tổng hợp giải đặc biệt miền Bắc theo từng tuần. Thống
                kê kết quả xổ số miền Bắc XSMB theo tuần thống kê&nbsp;giải đầy đủ và 2 số cuối CHÍNH XÁC NHẤT</p>

            <p dir="ltr"><a href="{{route('tk.dac-biet-tuan')}}" title="Thống kê XSMB theo tuần"><span
                            style="color:#0000FF"><strong>Thống kê XSMB theo tuần</strong></span></a> tổng hợp thông tin
                về các giải đặc biệt đã về trong 3 tuần quay mới nhất.</p>

            <p dir="ltr">- Kết quả được sắp xếp theo thời gian từ tuần trước nữa, tuần trước, tuần này từ trên xuống
                dưới.</p>

            <p dir="ltr">- Kết quả xổ số miền bắc XSMB GĐB được sắp xếp theo thứ 2,3,4,5,6,7, chủ nhật theo tuần.</p>

            <p dir="ltr">- 2 số cuối GĐB theo tuần của các kỳ quay mới nhất được bôi đỏ.</p>

            <p dir="ltr">- Bên dưới của mỗi kết quả đều có hiển thị thời gian mở thưởng chi tiết.</p>

            <h2 dir="ltr"><strong>Lợi ích của xem <a href="#"
                                                     title="thống kê 2 số cuối giải đặc biệt"><span
                                style="color:#0000FF">thống kê xổ số 2 số cuối giải đặc biệt</span></a> miền bắc theo
                    tuần:</strong></h2>

            <p dir="ltr">- Theo dõi quy luật xổ số về 2 số cuối GĐB trong tuần gần đây, chạm đầu, đuôi.</p>

            <p dir="ltr">- Xem các giải đặc biệt xổ số  theo thứ đã về trong vài tuần gần nhất.</p>

            <p><strong>Xem kết quả hàng ngày truy cập: <a href="{{route('home')}}" title="Xổ số kiến thiết 3 miền"><span
                                style="color:#0000FF">Xổ số kiến thiết 3 miền</span></a></strong></p>
                                
            <p><span style="font-weight: 400;">Bảng Đặc Biệt tuần. Bảng TK DB tuần. Bảng Thống K&ecirc; Đặc Biệt tuần. Xem Bảng Đặc Biệt tuần đầy đủ, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xstailoc.com</span></p>
            <p><span style="font-weight: 400;">xstailoc.com cập nhật Bảng Thống K&ecirc; Giải Đặc Biệt tuần si&ecirc;u ch&iacute;nh x&aacute;c.</span></p>
            <h2><strong>Bảng Đặc Biệt tuần l&agrave; g&igrave;?</strong></h2>
            <p><span style="font-weight: 400;">L&agrave; bảng tổng hợp Giải Đặc Biệt theo tuần - XSMB v&agrave; c&aacute;c tỉnh th&agrave;nh kh&aacute;c đầy đủ v&agrave; hai số cuối ch&iacute;nh x&aacute;c nhất.&nbsp;</span></p>
            <p><span style="font-weight: 400;">Bảng giải đặc biệt theo tuần thống k&ecirc; tất cả c&aacute;c th&ocirc;ng tin về c&aacute;c giải đặc biệt đ&atilde; về trong 1 khoảng thời gian nhất định.&nbsp;</span></p>
            <p><span style="font-weight: 400;">- Kết quả được sắp xếp theo c&aacute;c tuần v&agrave; được sắp xếp lần lượt từ tr&ecirc;n xuống dưới.</span></p>
            <p><span style="font-weight: 400;">- Kết quả xổ số miền Bắc GĐB được sắp xếp theo c&aacute;c thứ trong tuần.</span></p>
            <p><span style="font-weight: 400;">- 2 con số cuối của giải đặc biệt được t&ocirc; m&agrave;u xanh để l&agrave;m nổi bật.</span></p>
            <p><span style="font-weight: 400;">- B&ecirc;n dưới của mỗi kết quả đều c&oacute; hiển thị th&ocirc;ng tin thời gian mở thưởng rất chi tiết.</span></p>
            <h2><strong>Bảng đặc biệt theo tuần được cập nhật l&uacute;c n&agrave;o?</strong></h2>
            <p><span style="font-weight: 400;">Bảng đặc biệt Miền Bắc theo tuần được xstailoc.com cập nhật li&ecirc;n tục mỗi ng&agrave;y. Kết quả mới nhất được tường thuật trực tiếp từ trường quay v&agrave;o l&uacute;c 18h15' h&agrave;ng ng&agrave;y. Hệ thống của xstailoc.com sẽ gi&uacute;p bạn cập nhật, tổng hợp tất cả c&aacute;c giải Đặc biệt một c&aacute;ch nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c. V&igrave; vậy, bạn ho&agrave;n to&agrave;n c&oacute; thể y&ecirc;n t&acirc;m khi tham khảo bảng đặc biệt Miền Bắc theo tuần tr&ecirc;n xstailoc.com.</span></p>
            <h2><strong>Lợi &iacute;ch của bảng đặc biệt miền Bắc theo tuần</strong></h2>
            <p><span style="font-weight: 400;">Bảng đặc biệt miền Bắc theo tuần l&agrave; c&ocirc;ng cụ hữu &iacute;ch cho việc soi số giải đặc biệt. Bảng dữ liệu kết quả theo tuần được cập nhật đầy đủ n&ecirc;n người chơi thuận tiện trong việc nhận ra con số n&agrave;o c&oacute; tần suất tr&uacute;ng thưởng cao, con số n&agrave;o &iacute;t về, sự tương quan giữa c&aacute;c con số,...</span></p>
            <p><span style="font-weight: 400;">Từ đ&oacute;, bạn dễ d&agrave;ng theo d&otilde;i quy luật về 2 số cuối giải ĐB trong tuần gần đ&acirc;y, chạm đầu, đu&ocirc;i v&agrave; dự đo&aacute;n con số c&oacute; khả năng cao sẽ xuất hiện trong giải đặc biệt tiếp theo.&nbsp;</span></p>
            <h2><strong>Hướng dẫn c&aacute;ch xem Bảng Đặc Biệt theo tuần</strong></h2>
            <p><span style="font-weight: 400;">Để c&oacute; thể xem bảng thống k&ecirc; kết quả xổ số giải đặc biệt theo tuần, bạn thực hiện theo c&aacute;c bước sau:</span></p>
            <p><span style="font-weight: 400;">- Bước 1: Tại trang web của xstailoc.com, chọn mục Thống k&ecirc; tr&ecirc;n thanh menu, tiếp theo nhấn v&agrave;o mục Bảng đặc biệt tuần.</span></p>
            <p><span style="font-weight: 400;">- Bước 2: Lựa chọn khu vực Miền Bắc/tỉnh th&agrave;nh v&agrave; khoảng thời gian bạn muốn xem kết quả giải Đặc Biệt theo tuần.</span></p>
            <p><span style="font-weight: 400;">Bảng TK giải Đặc Biệt theo tuần. Xem thống k&ecirc; giải đặc biệt tuần nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xstailoc.com</span></p>
        </div>
    </div>
@endsection


@section('afterJS')

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        function getThongKeLo() {
            $("#monthly-result").html('<div class="row justify-content-center "><div class="col-md-12" style="text-align: center;padding: 50px 0px"><i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...</div></div>');
            var province_id = $('#province').val();
            var startDateDBT = $('#start_date').val();
            var endDateDBT = $('#end_date').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.post("{{route('tk.dac-biet-tuan-ajax')}}", {
                _token: CSRF_TOKEN,
                province_id: province_id,
                startDateDBT: startDateDBT,
                endDateDBT: endDateDBT,
            }, function (result) {
                var data = $.parseJSON(result);
                $("#monthly-result").html(data.template);
                $("#monthly-result").removeClass().addClass('box');
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            $('body').on('click', '#monthly-result .toggle-button input', function () {
                $("#monthly-result").toggleClass($(this).attr("data-class"));
            });
            $(".tk-db").on("click", "td", function () {
                $(this).toggleClass("bg-yellow");
            });

            $(".text-link-ads").on("click", function () {
                ga('daily1.send', 'event', 'text-link-ads', 'click', $(this).text());
            });
        });
    </script>
    {{--<script>--}}
    {{--window.daterangepicker_886ecf5b = {--}}
    {{--"locale": {--}}
    {{--"format": "DD-MM-YYYY",--}}
    {{--"applyLabel": "Apply",--}}
    {{--"cancelLabel": "Cancel",--}}
    {{--"fromLabel": "From",--}}
    {{--"toLabel": "To",--}}
    {{--"weekLabel": "W",--}}
    {{--"customRangeLabel": "Custom Range",--}}
    {{--"daysOfWeek": moment.weekdaysMin(),--}}
    {{--"monthNames": moment.monthsShort(),--}}
    {{--"firstDay": moment.localeData()._week.dow--}}
    {{--},--}}
    {{--"ranges": {--}}
    {{--"7 ngày qua": [moment().startOf('day').subtract(6, 'days'), moment()],--}}
    {{--"30 ngày qua": [moment().startOf('day').subtract(29, 'days'), moment()],--}}
    {{--"Tháng này": [moment().startOf('month'), moment().endOf('month')],--}}
    {{--"Tháng trước": [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]--}}
    {{--},--}}
    {{--"cancelButtonClasses": "btn-default",--}}
    {{--"language": "vi",--}}
    {{--"startDate": "06-07-2023",--}}
    {{--"endDate": "14-10-2023",--}}
    {{--"autoUpdateInput": false--}}
    {{--};--}}

    {{--jQuery(function ($) {--}}
    {{--jQuery("#statisticform-fromdate").off('change.kvdrp').on('change.kvdrp', function (e) {--}}
    {{--var drp = jQuery("#statisticform-fromdate").data('daterangepicker'), fm, to;--}}
    {{--if ($(this).val() || !drp) {--}}
    {{--return;--}}
    {{--}--}}
    {{--fm = moment().startOf('day').format('DD-MM-YYYY') || '';--}}
    {{--to = moment().format('DD-MM-YYYY') || '';--}}
    {{--drp.setStartDate(fm);--}}
    {{--drp.setEndDate(to);--}}

    {{--});--}}
    {{--jQuery && jQuery.pjax && (jQuery.pjax.defaults.maxCacheLength = 0);--}}
    {{--if (jQuery('#statisticform-fromdate').data('daterangepicker')) {--}}
    {{--jQuery('#statisticform-fromdate').daterangepicker('destroy');--}}
    {{--}--}}
    {{--jQuery("#statisticform-fromdate").daterangepicker(daterangepicker_886ecf5b, function (start, end, label) {--}}
    {{--var val = start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY');--}}
    {{--jQuery("#statisticform-fromdate").val(val).trigger('change');--}}
    {{--});--}}

    {{--jQuery('#statistic-form').yiiActiveForm([], []);--}}
    {{--});</script>--}}
@endsection