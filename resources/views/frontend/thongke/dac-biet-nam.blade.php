<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app_full')

@section('title','Bảng đặc biệt năm - Thống kê giải đặc biệt theo năm Với Xổ Số Tài Lộc')
@section('decription','Bảng đặc biệt năm  VỚi Xổ Số Tài Lộc - Thống kê giải đặc biệt theo năm - Thống kê XSMB - Thống kê MB theo tuần, tháng, năm.')
@section('h1','Bảng đặc biệt năm - Thống kê giải đặc biệt theo năm Với Xổ Số Tài Lộc')

@section('content')
    <div class="linkway">

        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{url()->current()}}" title="Thống kê giải đặc biệt miền Bắc theo năm" class="last"><span itemprop="name">Thống kê giải đặc biệt miền Bắc theo năm</span><meta itemprop="position" content="2"></a></li>
                </ol></div>
        </div>
    </div>
    <div class="content">
        <div class="main clearfix">
            <div class="box">
                <ul class="tab-panel tab-auto">
                    <li><a href="#" title="TK GĐB">TK GĐB</a></li>
                    <li><a href="{{route('tk.dac-biet-tuan')}}" title="TK đặc biệt theo tuần">Theo tuần</a>
                    </li>
                    <li><a href="{{route('tk.dac-biet-thang')}}" title="TK đặc biệt theo tháng">Theo tháng</a></li>
                    <li class="active"><a href="{{route('tk.dac-biet-nam')}}" title="TK đặc biệt theo năm">Theo năm</a></li>
                </ul>
                <h2 class="tit-mien bold">Bảng đặc biệt miền Bắc theo năm</h2>
                <form id="statistic-form" class="form-horizontal">
                    <div class="form-group drp-container">
                        <label>Chọn tỉnh</label>
                        <select id="province" name="province" class="form-control">
                            <option value="mb" selected>Miền Bắc</option>
                            @foreach($provinces as $pro)
                                <option value="{{$pro->id}}">{{$pro->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group drp-container">
                        <label>Chọn năm</label>
                        <select name="year" id="year" class="form-control">
                            <?php $i = 0; ?>
                            @foreach($year_list as $value)
                                @if($i==0)
                                    <option selected value="{{$value}}">{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                                <?php $i++; ?>
                            @endforeach
                        </select>
                    </div>
                    <div class="txt-center">
                        <button type="button" class="btn btn-danger" onclick="getThongKeLo()">Xem kết quả</button>

                    </div>
                </form>
            </div>
            <div class="box tbl-row-hover db-by-month" id="thongKeDBNam">
                <h3 class="tit-mien bold">Bảng đặc biệt Xổ Số miền Bắc năm {{$year}}</h3>
                <div class="box tong" style="overflow: auto;" id="monthly-result">
                    <table>
                        <tbody>
                        <tr>
                            <th class="td-split">
                                <div>
                                    <span class="top">Tháng</span>
                                    <span class="bottom">Ngày</span>
                                    <div class="line"></div>
                                </div>
                            </th>
                            <th width="70px">1/{{$year}}</th>
                            <th width="70px">2/{{$year}}</th>
                            <th width="70px">3/{{$year}}</th>
                            <th width="70px">4/{{$year}}</th>
                            <th width="70px">5/{{$year}}</th>
                            <th width="70px">6/{{$year}}</th>
                            <th width="70px">7/{{$year}}</th>
                            <th width="70px">8/{{$year}}</th>
                            <th width="70px">9/{{$year}}</th>
                            <th width="70px">10/{{$year}}</th>
                            <th width="70px">11/{{$year}}</th>
                            <th width="70px">12/{{$year}}</th>
                        </tr>
                        @for($d=1;$d<=31;$d++)
                            <tr>
                                <?php  if ($d < 10) $day = '0' . $d; else $day = $d; ?>
                                <td>{{$day}}</td>
                                @for($t=1;$t<=12;$t++)
                                    <?php if ($t < 10) $th = '0' . $t; else $th = $t;?>
                                    @if(isset($arrkq[$th][$day]))
                                        @php $kq = $arrkq[$th][$day]; @endphp
                                        @if($kq->day==8)
                                            <td class="light-yellow">
                                                <div class="s14 bold">{{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span class="clred">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                                            </td>
                                        @else
                                            <td class="">
                                                <div class="s14 bold">{{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span class="clred">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                                            </td>
                                        @endif
                                    @else
                                        <td></td>
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
                <div class="sticky-bottom-header">

                    <div class="dsp-mobile" id="zoom-box">
                        <div class="zoom-box zb-minus" data-value="-0.25" style="bottom: 80px">
                            <img width="20px" src="/frontend/images/zoom_out_1.png" alt="Thu nhỏ">
                        </div>
                        <div class="zoom-box zb-plus" data-value="0.25" style="bottom: 130px">
                            <img width="20px" src="/frontend/images/zoom_in_1.png" alt="Phóng to">
                        </div>
                    </div>
                </div>
            </div>


            {{--<div class="box tbl-row-hover">--}}
                {{--<h3 class="tit-mien bold">Thảo luận</h3>--}}
                {{--<div id="comment" class="fb-comments  fb_iframe_widget fb_iframe_widget_fluid_desktop" data-href="{{url()->current()}}" data-lazy="true" data-numposts="5" data-colorscheme="light" data-width="100%" data-order-by="reverse_time" fb-xfbml-state="rendered" fb-iframe-plugin-query="app_id=224529274568575&amp;color_scheme=light&amp;container_width=1190&amp;height=100&amp;href=https%3A%2F%2Fxoso.mobi%2Fthong-ke-giai-dac-biet-xo-so-mien-bac-xsmb.html&amp;lazy=true&amp;locale=vi_VN&amp;numposts=5&amp;order_by=reverse_time&amp;sdk=joey&amp;version=v7.0&amp;width=" style="width: 100%;"><span style="vertical-align: bottom; width: 100%; height: 658px;"><iframe name="f9cfc7bf6295ec" width="1000px" height="100px" data-testid="fb:comments Facebook Social Plugin" title="fb:comments Facebook Social Plugin" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" loading="lazy" src="https://www.facebook.com/v7.0/plugins/comments.php?app_id=224529274568575&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df3b8ef8d561c4fc%26domain%3Dxoso.mobi%26is_canvas%3Dfalse%26origin%3Dhttps%253A%252F%252Fxoso.mobi%252Ff32677e8b8f8388%26relation%3Dparent.parent&amp;color_scheme=light&amp;container_width=1190&amp;height=100&amp;href=https%3A%2F%2Fxoso.mobi%2Fthong-ke-giai-dac-biet-xo-so-mien-bac-xsmb.html&amp;lazy=true&amp;locale=vi_VN&amp;numposts=5&amp;order_by=reverse_time&amp;sdk=joey&amp;version=v7.0&amp;width=" style="border: none; width: 100%; height: 658px; visibility: visible;" class=""></iframe></span></div>--}}
                {{--<script>--}}
                {{--</script>--}}
            {{--</div>--}}

            <div class="box-content">

                <p dir="ltr"><a href="{{url()->current()}}" title="Thống kê XSMB theo năm"><span style="color:#0000FF"><strong>Thống kê XSMB theo năm</strong></span></a> tổng hợp thông tin về các giải đặc biệt đã về trong năm này, năm trước (2020, 2019, 2018, 2017, 2016, 2015,....)</p>

                <p dir="ltr">- Cột 1: Ngày về trong tháng được sắp xếp từ mùng 1 đến 31.</p>

                <p dir="ltr">- Cột ngang: 12 tháng trong năm được sắp xếp từ tháng 1 đến tháng 12.</p>

                <p dir="ltr">- Các cột giữa: kết quả giải đặc biệt từ đầu năm cho đến ngày gần đây nhất có kỳ quay số.</p>

                <h2 dir="ltr"><strong>Cách xem bảng thống kê&nbsp;giải đặc biệt theo năm</strong></h2>

                <p dir="ltr">Bước 1: Chọn năm mà bạn muốn xem, hiện nay, trang cung cấp <a href="#" title="thống kê giải đặc biệt"><span style="color:#0000FF"><strong>thống kê giải đặc biệt</strong></span></a> từ năm 2002 đến nay, người chơi có thể chọn các năm cũ, hoặc xem các năm gần đây như 2017, 2018, 2019, 2020..</p>

                <p dir="ltr">Bước 2: Nhấn vào mục ‘<strong>Xem kết quả</strong>’</p>

                <h2 dir="ltr"><strong>Lợi ích của xem bảng thống kê giải đặc biệt trong 1 năm:</strong></h2>

                <p dir="ltr">- Theo dõi quy luật về giải đặc biệt trong mỗi ngày trong của các tháng liên tiếp theo năm.</p>

                <p dir="ltr">- Xem nhanh kết quả 2 số cuối GĐB đã về của tuần tương ứng mỗi tháng trong năm đó.</p>

                <p dir="ltr">- Theo dõi các dấu hiệu về từ giải đặc biệt để dự đoán 2 số cuối sẽ về trong các kỳ tiếp theo.</p>

                <p dir="ltr">Thống kê KQXSMB theo năm được hệ thống máy tính của chúng tôi cập nhật liên tục khi có kết quả, đảm bảo sự chính xác nhất cho bạn tham khảo.</p>

                <p><strong>Lấy kết quả xổ số mới nhất hàng ngày, truy cập: <a href="{{route('home')}}" title="XS 3 miền"><span style="color:#0000FF">XS 3 miền</span></a></strong></p>
                <p><span style="font-weight: 400;">Bảng Đặc Biệt năm. Bảng TK DB năm. Bảng Thống K&ecirc; Đặc Biệt năm. Xem Bảng Đặc Biệt năm đầy đủ, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xosotailoc.live</span></p>
            <p><span style="font-weight: 400;">xosotailoc.live cập nhật Bảng Thống K&ecirc; Giải Đặc Biệt năm si&ecirc;u ch&iacute;nh x&aacute;c.</span></p>
            <h2><strong>Bảng Đặc Biệt năm l&agrave; g&igrave;?</strong></h2>
            <p><span style="font-weight: 400;">L&agrave; bảng tổng hợp Giải Đặc Biệt theo năm - XSMB v&agrave; c&aacute;c tỉnh th&agrave;nh kh&aacute;c đầy đủ v&agrave; hai số cuối ch&iacute;nh x&aacute;c nhất.&nbsp;</span></p>
            <p><span style="font-weight: 400;">Bảng giải đặc biệt theo năm thống k&ecirc; tất cả c&aacute;c th&ocirc;ng tin về c&aacute;c giải đặc biệt đ&atilde; về trong 1 khoảng thời gian nhất định.&nbsp;</span></p>
            <h2><strong>Nội dung trong bảng thống k&ecirc; đặc biệt năm</strong></h2>
            <p><span style="font-weight: 400;">- Cột dọc biểu thị th&ocirc;ng tin ng&agrave;y: Sắp xếp theo thứ tự từ ng&agrave;y 1 đến ng&agrave;y 31</span></p>
            <p><span style="font-weight: 400;">- H&agrave;ng ngang biểu thị dữ liệu c&aacute;c th&aacute;ng trong năm: Theo thứ tự từ th&aacute;ng 1 đến th&aacute;ng 12.</span></p>
            <p><span style="font-weight: 400;">- C&aacute;c &ocirc; ở giữa hiển thị kết quả giải đặc biệt từ đầu năm đến cuối năm.</span></p>
            <p><span style="font-weight: 400;">- C&aacute;c &ocirc; m&agrave;u v&agrave;ng nhạt tương ứng với ng&agrave;y Chủ nhật.</span></p>
            <p><span style="font-weight: 400;">- 2 số cuối giải đặc biệt sẽ được t&ocirc; m&agrave;u để l&agrave;m nổi bật.</span></p>
            <h2><strong>Bảng đặc biệt theo năm được cập nhật l&uacute;c n&agrave;o?</strong></h2>
            <p><span style="font-weight: 400;">Bảng đặc biệt Miền Bắc theo năm được xosotailoc.live cập nhật li&ecirc;n tục mỗi ng&agrave;y. Kết quả mới nhất được tường thuật trực tiếp từ trường quay v&agrave;o l&uacute;c 18h15' h&agrave;ng ng&agrave;y. Hệ thống của xosotailoc.live sẽ gi&uacute;p bạn cập nhật, tổng hợp tất cả c&aacute;c giải Đặc biệt một c&aacute;ch nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c. V&igrave; vậy, bạn ho&agrave;n to&agrave;n c&oacute; thể y&ecirc;n t&acirc;m khi tham khảo bảng đặc biệt Miền Bắc theo năm tr&ecirc;n xosotailoc.live.</span></p>
            <h2><strong>Lợi &iacute;ch của bảng đặc biệt miền Bắc theo năm</strong></h2>
            <p><span style="font-weight: 400;">Bảng đặc biệt miền Bắc theo năm l&agrave; c&ocirc;ng cụ hữu &iacute;ch cho việc soi số giải đặc biệt. Bảng dữ liệu kết quả theo năm được cập nhật đầy đủ n&ecirc;n người chơi thuận tiện trong việc nhận ra con số n&agrave;o c&oacute; tần suất tr&uacute;ng thưởng cao, con số n&agrave;o &iacute;t về, sự tương quan giữa c&aacute;c con số,...</span></p>
            <p><span style="font-weight: 400;">Từ đ&oacute;, người chơi thoải m&aacute;i đ&aacute;nh gi&aacute;, t&iacute;nh to&aacute;n v&agrave; dự đo&aacute;n con số c&oacute; khả năng cao sẽ xuất hiện trong giải đặc biệt tiếp theo.&nbsp;</span></p>
            <p><span style="font-weight: 400;">Thay v&igrave; trước kia, việc dự đo&aacute;n kh&ocirc;ng c&oacute; căn cứ, cơ sở th&igrave; giờ đ&acirc;y bạn c&oacute; thể dựa v&agrave;o bảng đặc biệt năm để thử vận may.</span></p>
            <h2><strong>Hướng dẫn c&aacute;ch xem Bảng Đặc Biệt theo năm</strong></h2>
            <p><strong>&nbsp;Để c&oacute; thể xem bảng thống k&ecirc; kết quả xổ số giải đặc biệt theo năm, bạn thực hiện theo c&aacute;c bước sau:</strong></p>
            <p><span style="font-weight: 400;">- Bước 1: Tại trang web của xosotailoc.live, chọn mục Thống k&ecirc; tr&ecirc;n thanh menu, tiếp theo nhấn v&agrave;o mục Bảng đặc biệt năm.</span></p>
            <p><span style="font-weight: 400;">- Bước 2: Lựa chọn khu vực Miền Bắc/tỉnh th&agrave;nh v&agrave; khoảng thời gian bạn muốn xem kết quả giải Đặc Biệt theo năm.</span></p>
            <p><span style="font-weight: 400;">Bảng TK giải Đặc Biệt theo năm. Xem thống k&ecirc; giải đặc biệt năm nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xosotailoc.live</span><br />
            </div>
            <script>
            </script>

        </div>
    </div>
@endsection

@section('afterJS')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        function getThongKeLo() {
            $("#thongKeDBNam").html('<div class="row justify-content-center "><div class="col-md-12" style="text-align: center;padding: 50px 0px"><i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...</div></div>');
            var nam = $('#year').val();
            var province_id = $('#province').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.post("{{route('tk.dac-biet-nam-ajax')}}", {
                _token: CSRF_TOKEN,
                nam: nam,
                province_id: province_id,
            }, function (result) {
                var data = $.parseJSON(result);
                $("#thongKeDBNam").html(data.template);
            });

        }

        let tableIds = ["monthly-result", "result-box-content"];
        let defaultZoom = 1;
        function _zoom(elementIds, zoomValue) {
            let currentZoom = localStorage.getItem("selectedRange") || defaultZoom;
            let newZoom = parseFloat(currentZoom) + parseFloat(zoomValue);
            if (newZoom >= 0.25 && newZoom <= 1) {
                elementIds.forEach(function(tableId) {
                    $("#" + tableId).attr("style", "transform-origin: left top; width: " + (100 / newZoom) + "%; transform: scale(" + newZoom + "); overflow: auto");
                });
                localStorage.setItem("selectedRange", newZoom);

                if (newZoom >= 1) {
                    $(".zb-plus").css("opacity", "0.3");
                } else {
                    $(".zb-plus").css("opacity", "1");
                }
                if (newZoom <= 0.25) {
                    $(".zb-minus").css("opacity", "0.3");
                } else {
                    $(".zb-minus").css("opacity", "1");
                }
            }
        }
        function zoomFunction() {
            let zoomBoxId = "zoom-box";
            $("#" + zoomBoxId + " div").on("click", function () {
                let zoomValue = parseFloat($(this).attr('data-value'));
                _zoom(tableIds, zoomValue);
            });
        }
        $(document).ready(function() {
            let savedZoom = localStorage.getItem("selectedRange");
            if (savedZoom) {
                _zoom(tableIds, 0);
                _zoom(tableIds, savedZoom);
            } else {
                _zoom(tableIds, defaultZoom);
            }
        });
        zoomFunction();
    </script>
@endsection