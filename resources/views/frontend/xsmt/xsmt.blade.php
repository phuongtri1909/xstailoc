<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>

@extends('frontend.layouts.app')

@section('title', 'XSMT - Kết quả xổ số miền Trung hôm nay - SXMT - KQXSMT')
@section('decription',
    'KQXSMT - SXMT - Trực tiếp kết quả xổ số miền Trung - XSMT hôm nay nhanh nhất, chính xác nhất từ
    trường quay XSKTMT vào lúc 17:15.')
@section('keyword',
    'xsmt, SXMT, kqxsmt, xổ số miền Trung, xs mien Trung, kq mien Trung, kqxs mien Trung, ket qua xsmt,
    xo so mien Trung, xsmt hom nay, ket qua mien Trung, kết quả xổ số miền Trung, xo so mien Trung hom nay')
@section('h1', 'XSMT - Kết quả xổ số miền Trung hôm nay - SXMT - KQXSMT')
@section('content')
    <div class="col-l" style="height: auto !important;">
        {{-- <div class="box"> --}}
        {{-- <div class="bg_gray"> --}}
        {{-- <div class=" opt_date_full clearfix"> --}}
        {{-- <label> --}}
        {{-- <strong>{{getThu(getThuNumber(date('Y-m-d')))}}</strong> - --}}
        {{-- <input type="text" class="nobor" value="{{date('d/m/Y')}}" id="searchDateMT"/> --}}
        {{-- <span class='ic ic-calendar'></span> --}}
        {{-- </label> --}}
        {{-- </div> --}}
        {{-- </div> --}}
        {{-- </div> --}}
        <ul class="tab-panel">
            <li class="active"><a href="{{ route('xsmt') }}">miền Trung</a>
            </li>
            <li><a href="{{ route('xsmt.thu_2') }}" title="XSMT Thứ 2">Thứ
                    2</a></li>
            <li><a href="{{ route('xsmt.thu_3') }}" title="XSMT Thứ 3">Thứ
                    3</a></li>
            <li><a href="{{ route('xsmt.thu_4') }}" title="XSMT Thứ 4">Thứ
                    4</a></li>
            <li><a href="{{ route('xsmt.thu_5') }}" title="XSMT Thứ 5">Thứ
                    5</a></li>
            <li><a href="{{ route('xsmt.thu_6') }}" title="XSMT Thứ 6">Thứ
                    6</a></li>
            <li><a href="{{ route('xsmt.thu_7') }}" title="XSMT Thứ 7">Thứ
                    7</a></li>
            <li><a href="{{ route('xsmt.cn') }}" title="XSMT Chủ nhật">CN</a></li>
        </ul>
        @if (!$kqToDay)
            <div class="box" id="mt_kqngay_{{ date('dmY', time()) }}" style="display: none;">
                <div class="block-main-heading" id="mtLiveTitle"></div>
            </div>
        @endif

        @include('frontend.xsmt.xsmt_include')

        <div class="lotteryMnResult" id="result-more"></div>

        <input type="hidden" value="7" id="skip">

        <input type="hidden" value="{{ $lastPage * 7 }}" id="last_page">

        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <div class="loadmoreimg"><i class="fas fa-spinner fa-spin"></i></div>
        <button class="btn-see-more magb10 btn-viewmore" id="xem_them" value="Xem thêm" data-page="2"
            data-province="mt">Xem
            thêm
        </button>


        <div class="box-content">
            <p>XSMT hôm nay - SXMT - XSMTR - <a style="text-decoration: underline" href="{{ route('xsmt') }}">xổ số miền Trung</a> hôm nay cập nhật mới nhất. xosotailoc.vip trực tiếp kết quả xổ
                số miền Trung nhanh nhất và chính xác nhất hàng ngày, KQXSMT được quay số vào lúc 17:15 tất cả các ngày
                trong tuần.</p>

            <h2><strong>Lịch mở thưởng xổ số miền Trung trong tuần:</strong></h2>
            <p style="margin: 0;margin-top: 20px">XSMT thứ 2: XS Huế - XS Phú Yên</p>
            <p style="margin: 0">XSMT thứ 3: XS Quảng Nam - XS Đắk Lắk</p>
            <p style="margin: 0">XSMT thứ 4: XS Đà Nẵng - XS Khánh Hòa</p>
            <p style="margin: 0">XSMT thứ 5: XS Bình Định - XS Quảng Bình - XS Quảng Trị</p>
            <p style="margin: 0">XSMT thứ 6:XS Gia Lai - XS Ninh Thuận</p>
            <p style="margin: 0">XSMT thứ 7: XS Đà Nẵng - XS Quảng Ngãi - XS Đắk Nông</p>
            <p style="margin: 0;margin-bottom: 15px">XSMT chủ nhật: XS Khánh Hòa - XS Kon Tum</p>

            <h2><strong>Cơ cấu giải thưởng vé số kiến thiết miền Trung</strong></h2>
            <p style="margin: 0;margin-top: 20px">Loại vé: 10.000 Đồng</p>
            <p style="margin: 0">Số lượng giải thưởng: 11.565</p>
            <p style="margin: 0">Số lần quay: 18 lần</p>

            <div>
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <td>Giải thưởng</td>
                            <td>Giá trị giải thưởng</td>
                            <td>Số chữ số trúng thưởng</td>
                            <td>Số lượng giải thưởng</td>
                            <td>Tổng giá trị giải thưởng</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Giải đặc biệt</td>
                            <td>2.000.000.000</td>
                            <td>6 số</td>
                            <td>1</td>
                            <td>2.000.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải phục giải đặc biệt</td>
                            <td>50.000.000</td>
                            <td>5 số (sai 1 số đầu của giải đặc biệt)</td>
                            <td>9</td>
                            <td>450.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải nhất</td>
                            <td>30.000.000</td>
                            <td>5 số</td>
                            <td>10</td>
                            <td>200.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải nhì</td>
                            <td>15.000.000</td>
                            <td>5 số</td>
                            <td>10</td>
                            <td>150.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải ba</td>
                            <td>10.000.000</td>
                            <td>5 số</td>
                            <td>20</td>
                            <td>200.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải tư</td>
                            <td>3.000.000</td>
                            <td>5 số</td>
                            <td>70</td>
                            <td>210.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải năm</td>
                            <td>1.000.000</td>
                            <td>4 số</td>
                            <td>100</td>
                            <td>100.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải sáu</td>
                            <td>400.000</td>
                            <td>4 số</td>
                            <td>300</td>
                            <td>120.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải bảy</td>
                            <td>200.000</td>
                            <td>3 số</td>
                            <td>1.000</td>
                            <td>200.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải tám</td>
                            <td>100.000</td>
                            <td>2 số</td>
                            <td>10.000</td>
                            <td>1.000.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải khuyến khích</td>
                            <td>6.000.000</td>
                            <td>Sai 1 số bất kỳ ở giải đặc biệt</td>
                            <td>45</td>
                            <td>270.000.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h2><strong>Hướng dẫn đổi vé số trúng thưởng đài miền Trung</strong></h2>
            
            <li style="margin-top:22px">Thời gian: 30 ngày kể từ lần công bố KQXSMT của vé trúng thưởng.</li>
            <li>Địa điểm: Trung tâm công ty xổ số các tỉnh miền Trung theo vé trúng thưởng hoặc liên hệ các đại lý dò số gần nhất để đổi số trúng.</li>
            
            <strong>Khách hàng cần mang theo:</strong>
           <li>Thẻ căn cước công dân</li>
           <li>Vé trúng thưởng phải còn nguyên vẹn, không rách rời, không chắp vá, và không bị tẩy xóa.
            </li>
           <li>Vé số trúng thưởng trên 10 triệu đồng phải thực hiện nghĩa vụ nộp thuế TNCN là 10%.</li>
        </div>
        <script></script>
    </div>

@endsection

@section('afterJS')
    <script>
        $(document).ready(function() {

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $('#xem_them').click(function(event) {

                event.preventDefault();

                var skip = parseInt($('#skip').val());

                var last_page = parseInt($('#last_page').val());

                if (skip <= last_page) {

                    $('.loadmoreimg').css('display', 'block');

                    $('.btn-viewmore').css('display', 'none');

                    $.post("{{ route('xsmt.xem_them') }}", {

                        skip: skip,

                        _token: CSRF_TOKEN

                    }, function(result) {

                        var data = $.parseJSON(result);

                        $(".lotteryMnResult").append(data.template);


                        // cập nhật các tham số

                        $('.loadmoreimg').css('display', 'none');

                        $('.btn-viewmore').css('display', 'block');

                        $('#skip').val(skip + 7);

                        if (skip == last_page) {

                            $("#xem_them").hide();

                        }
                        xsdp.init();
                        xsdp.addTableCtrlPanel(function() {
                            var t = document.querySelectorAll("table.extendable");
                            return [].forEach.call(t, (function(t) {
                                t.showedDigits = 0
                            })), t
                        }(), xsdp._getNumberInTable);
                    });

                }

            });

        });
    </script>

    <script src="{{ url('frontend/js/lotteryLive.js') }}?v={{ rand(1000, 100000) }}"></script>

    <script type="text/javascript">
        var rootPath = '';

        var appKey = '';

        var groupId = 3;

        var headingTag = 'h1';

        var interval;

        var timeInter = 1357 * 4; //thoi gian refresh

        LiveMT(groupId, appKey, rootPath, headingTag);

        interval = setInterval("LiveMT(" + groupId + ", '" + appKey + "', '" + rootPath + "', '" + headingTag + "')",
            timeInter);

        intervalVariable = setInterval('getRandomTextTN()', 100);
    </script>

@endsection
