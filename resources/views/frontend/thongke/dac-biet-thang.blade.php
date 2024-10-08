<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app_full')

@section('title','Bảng đặc biệt tháng - Thống kê xổ số giải đặc biệt theo tháng Với Xổ Số Tài Lộc')
@section('decription','Bảng đặc biệt tháng Với Xổ Số Tài Lộc - Thống kê xổ số giải đặc biệt theo tháng - Thống kê XSMB - Thống kê MB theo tuần, tháng, năm.')
@section('h1','Bảng đặc biệt tháng - Thống kê xổ số giải đặc biệt theo tháng Với Xổ Số Tài Lộc')
@section('content')
    <div class="linkway">

        <div class="main">
            <div class="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span><meta itemprop="position" content="1"></a></li><li> »
                    </li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item" href="{{url()->current()}}" title="Thống kê giải đặc biệt miền Bắc theo tháng" class="last"><span itemprop="name">Thống kê giải đặc biệt miền Bắc theo tháng</span><meta itemprop="position" content="2"></a></li>
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
                    <li class="active"><a href="{{route('tk.dac-biet-thang')}}" title="TK đặc biệt theo tháng">Theo tháng</a></li>
                    <li><a href="{{route('tk.dac-biet-nam')}}" title="TK đặc biệt theo năm">Theo năm</a></li>
                </ul>
                <h2 class="tit-mien bold">Bảng đặc biệt miền Bắc theo tháng</h2>
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
                                @if($i==count($year_list)-1)
                                    <option selected value="{{$value}}">{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                                <?php $i++; ?>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group drp-container">
                        <label>Chọn tháng</label>
                        <select name="month" id="month" class="form-control">
                            @for($i=1;$i<=12;$i++)
                                <?php  if ($i < 10) $i = '0' . $i; ?>
                                @if($i==$month_now)
                                    <option selected value="{{$i}}">Tháng {{$i}}</option>
                                @else
                                    <option value="{{$i}}">Tháng {{$i}}</option>
                                @endif
                            @endfor
                        </select>
                    </div>
                    <div class="txt-center">
                        <button type="button" class="btn btn-danger" onclick="getThongKeLo()">Xem kết quả</button>
                    </div>
                </form>
            </div>
            <div class="box tbl-row-hover db-by-month" id="thongKeDBThang">
                <h3 class="tit-mien bold">Bảng Đặc Biệt Xổ Số miền Bắc Tháng {{$month_now}} từ
                    năm {{$year_list[count($year_list)-1]}}</h3>
                <div class="box tong" style="overflow: auto;" id="monthly-result">
                    <table>
                        <tbody>
                        <tr>
                            <th class="td-split">
                                <div><span class="bottom">Năm</span>
                                    <span class="top">Ngày</span>
                                    <div class="line"></div>
                                </div>
                            </th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                            <th>11</th>
                            <th>12</th>
                            <th>13</th>
                            <th>14</th>
                            <th>15</th>
                            <th>16</th>
                            <th>17</th>
                            <th>18</th>
                            <th>19</th>
                            <th>20</th>
                            <th>21</th>
                            <th>22</th>
                            <th>23</th>
                            <th>24</th>
                            <th>25</th>
                            <th>26</th>
                            <th>27</th>
                            <th>28</th>
                            <th>29</th>
                            <th>30</th>
                            <th>31</th>
                        </tr>
                        @foreach($year_list as $year)
                            <tr>
                                <td>{{$year}}</td>
                                @for($d=1;$d<=31;$d++)
                                    <?php  if ($d < 10) $day = '0' . $d; else $day = $d; ?>
                                    @if(isset($arrkq[$year][$day]))
                                        @php $kq = $arrkq[$year][$day]; @endphp
                                            @if($kq->day==8)
                                                <td class="light-yellow">
                                                    <div class="s16 bold">{{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span class="clred">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                                                </td>
                                            @else
                                                <td>
                                                    <div class="s16 bold">{{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span class="clred">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                                                </td>
                                            @endif
                                    @else
                                        <td></td>
                                    @endif
                                @endfor
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-content">

                <p dir="ltr">Thống Kê Giải Đặc Biệt Xổ Số theo tháng là bảng tổng hợp giải đặc biệt về từng tháng.❤️ Tham khảo bảng kết quả xổ số miền Bắc theo tháng giúp bạn theo dõi chu kỳ KQXSMB từng tháng hiệu quả</p>

                <p dir="ltr"><span style="font-size:14px"><strong><a href="{{route('tk.dac-biet-thang')}}" title="Thống kê XSMB theo tháng"><span style="color:#0000FF">Thống kê XSMB theo tháng</span></a></strong> tổng hợp thông tin về các giải đặc biệt đã về trong tháng này, tháng trước,....</span></p>

                <p dir="ltr"><span style="font-size:14px">- Cột 1: Năm thời gian được sắp xếp lùi từ gần nhất trở về.</span></p>

                <p dir="ltr"><span style="font-size:14px">- Hàng ngang: Ngày trong tháng được sắp xếp từ mùng 1 đến cuối tháng.</span></p>

                <h2 dir="ltr"><span style="font-size:14px"><strong>Cách xem <a href="#" title="TK XSMB"><span style="color:#0000FF">TK XSMB</span></a> theo tháng trên trang:</strong></span></h2>

                <p dir="ltr"><span style="font-size:14px">Bước 1: Chọn tháng từ 1 đến 12 mà bạn muốn xem.</span></p>

                <p dir="ltr"><span style="font-size:14px">Bước 2: Nhấn vào mục ‘<strong>Xem kết quả</strong>’</span></p>

                <h2 dir="ltr"><span style="font-size:14px"><strong>Lợi ích của xem bảng thống kê&nbsp;theo tháng:</strong></span></h2>

                <p dir="ltr"><span style="font-size:14px">- Theo dõi quy luật về giải đặc biệt trong tháng.</span></p>

                <p dir="ltr"><span style="font-size:14px">- Xem tổng hợp các giải đặc biệt theo ngày của từng tháng.</span></p>

                <p dir="ltr"><span style="font-size:14px">- Dự đoán quy luật về của GĐB hoặc 2 số cuối của ngày đó trong tháng mà bạn muốn đặt cược.</span></p>

                <p dir="ltr"><span style="font-size:14px">Thống kê theo tháng được hệ thống máy tính của chúng tôi cập nhật liên tục khi có kết quả, đảm bảo sự chính xác nhất cho bạn tham khảo.</span></p>

                <p><span style="font-size:14px"><strong>Lấy kết quả xổ số mới nhất hàng ngày, truy cập: <a href="{{route('home')}}" title="Xổ số 3 miền"><span style="color:#0000FF">Xổ số 3 miền</span></a></strong></span></p>
       
                <p><span style="font-weight: 400;">Bảng Đặc Biệt th&aacute;ng. Bảng TK DB th&aacute;ng. Bảng Thống K&ecirc; Đặc Biệt th&aacute;ng. Xem Bảng Đặc Biệt th&aacute;ng đầy đủ, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xosotailoc.vip</span></p>
                <p><span style="font-weight: 400;">xosotailoc.vip cập nhật Bảng Thống K&ecirc; Giải Đặc Biệt th&aacute;ng si&ecirc;u ch&iacute;nh x&aacute;c.</span></p>
                <h2><strong>Bảng Đặc Biệt th&aacute;ng l&agrave; g&igrave;?</strong></h2>
                <p><span style="font-weight: 400;">L&agrave; bảng tổng hợp Giải Đặc Biệt theo th&aacute;ng - XSMB v&agrave; c&aacute;c tỉnh th&agrave;nh kh&aacute;c đầy đủ v&agrave; hai số cuối ch&iacute;nh x&aacute;c nhất.&nbsp;</span></p>
                <p><span style="font-weight: 400;">Bảng giải đặc biệt theo th&aacute;ng thống k&ecirc; tất cả c&aacute;c th&ocirc;ng tin về c&aacute;c giải đặc biệt đ&atilde; về trong 1 khoảng thời gian nhất định.&nbsp;</span></p>
                <h2><strong>Nội dung trong bảng thống k&ecirc; đặc biệt th&aacute;ng</strong></h2>
                <p><span style="font-weight: 400;">- Cột dọc biểu thị th&ocirc;ng tin Năm: Được sắp xếp theo thứ tự năm hiện tại v&agrave; những năm trước.</span></p>
                <p><span style="font-weight: 400;">- H&agrave;ng ngang biểu thị dữ liệu c&aacute;c ng&agrave;y trong th&aacute;ng: Sắp xếp theo thứ tự từ ng&agrave;y 1 đến ng&agrave;y 31 của th&aacute;ng.</span></p>
                <p><span style="font-weight: 400;">- C&aacute;c &ocirc; ở giữa hiển thị kết quả giải đặc biệt.</span></p>
                <p><span style="font-weight: 400;">- 2 số cuối giải đặc biệt sẽ được t&ocirc; m&agrave;u để l&agrave;m nổi bật.</span></p>
                <h2><strong>Bảng đặc biệt theo th&aacute;ng được cập nhật l&uacute;c n&agrave;o?</strong></h2>
                <p><span style="font-weight: 400;">Bảng đặc biệt Miền Bắc theo th&aacute;ng được xosotailoc.vip cập nhật li&ecirc;n tục mỗi ng&agrave;y. Kết quả mới nhất được tường thuật trực tiếp từ trường quay v&agrave;o l&uacute;c 18h15' h&agrave;ng ng&agrave;y. Hệ thống của xosotailoc.vip sẽ gi&uacute;p bạn cập nhật, tổng hợp tất cả c&aacute;c giải Đặc biệt một c&aacute;ch nhanh ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c. V&igrave; vậy, bạn ho&agrave;n to&agrave;n c&oacute; thể y&ecirc;n t&acirc;m khi tham khảo bảng đặc biệt Miền Bắc theo th&aacute;ng tr&ecirc;n xosotailoc.vip.</span></p>
                <h2><strong>Lợi &iacute;ch của bảng đặc biệt miền Bắc theo th&aacute;ng</strong></h2>
                <p><span style="font-weight: 400;">Bảng đặc biệt miền Bắc theo th&aacute;ng l&agrave; c&ocirc;ng cụ hữu &iacute;ch cho việc soi số giải đặc biệt. Bảng dữ liệu kết quả theo th&aacute;ng được cập nhật đầy đủ n&ecirc;n người chơi thuận tiện trong việc nhận ra con số n&agrave;o c&oacute; tần suất tr&uacute;ng thưởng cao, con số n&agrave;o &iacute;t về, sự tương quan giữa c&aacute;c con số,...</span></p>
                <p><span style="font-weight: 400;">Từ đ&oacute;, người chơi thoải m&aacute;i đ&aacute;nh gi&aacute;, t&iacute;nh to&aacute;n v&agrave; dự đo&aacute;n con số c&oacute; khả năng cao sẽ xuất hiện trong giải đặc biệt tiếp theo.&nbsp;</span></p>
                <p><span style="font-weight: 400;">Thay v&igrave; trước kia, việc dự đo&aacute;n kh&ocirc;ng c&oacute; căn cứ, cơ sở th&igrave; giờ đ&acirc;y bạn c&oacute; thể dựa v&agrave;o bảng đặc biệt th&aacute;ng để thử vận may.</span></p>
                <h2><strong>Hướng dẫn c&aacute;ch xem Bảng Đặc Biệt theo th&aacute;ng</strong></h2>
                <p><span style="font-weight: 400;">&nbsp;Để c&oacute; thể xem bảng thống k&ecirc; kết quả xổ số giải đặc biệt theo th&aacute;ng, bạn thực hiện theo c&aacute;c bước sau:</span></p>
                <p><span style="font-weight: 400;">- Bước 1: Tại trang web của xosotailoc.vip, chọn mục Thống k&ecirc; tr&ecirc;n thanh menu, tiếp theo nhấn v&agrave;o mục Bảng đặc biệt th&aacute;ng.</span></p>
                <p><span style="font-weight: 400;">- Bước 2: Lựa chọn khu vực Miền Bắc/tỉnh th&agrave;nh v&agrave; khoảng thời gian bạn muốn xem kết quả giải Đặc Biệt theo th&aacute;ng.</span></p>
                <p><span style="font-weight: 400;">Bảng TK giải Đặc Biệt theo th&aacute;ng. Xem thống k&ecirc; giải đặc biệt th&aacute;ng nhanh ch&oacute;ng, ch&iacute;nh x&aacute;c v&agrave; ho&agrave;n to&agrave;n miễn ph&iacute; tại xosotailoc.vip</span></p>
                 </div>
        </div>
    </div>
@endsection

@section('afterJS')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        function getThongKeLo() {
            $("#thongKeDBThang").html('<div class="row justify-content-center "><div class="col-md-12" style="text-align: center;padding: 50px 0px"><i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...</div></div>');
            var province_id = $('#province').val();
            var nam = $('#year').val();
            var thang = $('#month').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.post("{{route('tk.dac-biet-thang-ajax')}}", {
                _token: CSRF_TOKEN,
                province_id: province_id,
                nam: nam,
                thang: thang,
            }, function (result) {
                var data = $.parseJSON(result);
                $("#thongKeDBThang").html(data.template);
            });
        }
    </script>
    <div id="zoom-tbl"></div>
@endsection