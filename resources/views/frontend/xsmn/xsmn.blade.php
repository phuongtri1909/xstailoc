<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>

@extends('frontend.layouts.app')

@section('title', 'XSMN - Kết quả xổ số miền Nam hôm nay - SXMN - KQXSMN')
@section('decription',
    'KQXSMN - SXMN - Trực tiếp kết quả xổ số miền Nam - XSMN hôm nay nhanh nhất, chính xác nhất từ
    trường quay XSKTMN vào lúc 16:15.')
@section('keyword',
    'xsmn, sxmn, kqxsmn, xổ số miền nam, xs mien nam, kq mien nam, kqxs mien nam, ket qua xsmn, xo so
    mien nam, xsmn hom nay, ket qua mien nam, kết quả xổ số miền nam, xo so mien nam hom nay')
@section('h1', 'XSMN - Kết quả xổ số miền Nam hôm nay - SXMN - KQXSMN')
@section('content')
    <div class="col-l" style="height: auto !important;">
        {{-- <div class="box"> --}}
        {{-- <div class="bg_gray"> --}}
        {{-- <div class=" opt_date_full clearfix"> --}}
        {{-- <label> --}}
        {{-- <strong>{{getThu(getThuNumber(date('Y-m-d')))}}</strong> - --}}
        {{-- <input type="text" class="nobor" value="{{date('d/m/Y')}}" id="searchDateMN"/> --}}
        {{-- <span class='ic ic-calendar'></span> --}}
        {{-- </label> --}}
        {{-- </div> --}}
        {{-- </div> --}}
        {{-- </div> --}}
        <ul class="tab-panel">
            <li class="active"><a href="{{ route('xsmn') }}">Miền nam</a>
            </li>
            <li><a href="{{ route('xsmn.thu_2') }}" title="XSMN Thứ 2">Thứ
                    2</a></li>
            <li><a href="{{ route('xsmn.thu_3') }}" title="XSMN Thứ 3">Thứ
                    3</a></li>
            <li><a href="{{ route('xsmn.thu_4') }}" title="XSMN Thứ 4">Thứ
                    4</a></li>
            <li><a href="{{ route('xsmn.thu_5') }}" title="XSMN Thứ 5">Thứ
                    5</a></li>
            <li><a href="{{ route('xsmn.thu_6') }}" title="XSMN Thứ 6">Thứ
                    6</a></li>
            <li><a href="{{ route('xsmn.thu_7') }}" title="XSMN Thứ 7">Thứ
                    7</a></li>
            <li><a href="{{ route('xsmn.cn') }}" title="XSMN Chủ nhật">CN</a></li>
        </ul>
        @if (!$kqToDay)
            <div class="box" id="mn_kqngay_{{ date('dmY', time()) }}" style="display: none;">
                <div class="block-main-heading" id="mnLiveTitle"></div>
            </div>
        @endif

        @include('frontend.xsmn.xsmn_include')

        <div class="lotteryMnResult" id="result-more"></div>

        <input type="hidden" value="7" id="skip">

        <input type="hidden" value="{{ $lastPage * 7 }}" id="last_page">

        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <div class="loadmoreimg"><i class="fas fa-spinner fa-spin"></i></div>
        <button class="btn-see-more magb10 btn-viewmore" id="xem_them" value="Xem thêm" data-page="2"
            data-province="mn">Xem
            thêm
        </button>


        <div class="box-content">
            <p>Xem trực tiếp <a style="text-decoration: underline" href="{{ route('xsmn') }}">xổ số miền Nam</a> nhanh chóng và chính xác hàng ngày vào lúc 16:15 từ thứ 2 đến chủ nhật tại
                xstailoc.com miễn phí. KQSXMN sẽ quay số mở thưởng 3 tỉnh mỗi ngày và thứ bảy sẽ mở thưởng 4 tỉnh. Kết quả
                XSMN sẽ được tường thuật trực tiếp chính xác từ trường quay xổ số đảm bảo sự minh bạch.</p>

            <h2><strong>Lịch mở thưởng xổ số miền Nam trong tuần:</strong></h2>
            <p style="margin: 0;margin-top: 20px">XSMN Chủ Nhật: Tiền Giang - Kiên Giang - Đà Lạt</p>
            <p style="margin: 0">XSMN Thứ 2: TP Hồ Chí Minh - Đồng Tháp - Cà Mau</p>
            <p style="margin: 0">XSMN Thứ 3: Bến Tre - Vũng Tàu - Bạc Liêu</p>
            <p style="margin: 0">XSMN Thứ 4: Đồng Nai - Cần Thơ - Sóc Trăng</p>
            <p style="margin: 0">XSMN Thứ 5: Tây Ninh - An Giang - Bình Thuận</p>
            <p style="margin: 0">XSMN Thứ 6: Vĩnh Long - Bình Dương - Trà Vinh</p>
            <p style="margin: 0;margin-bottom: 15px">XSMN Thứ 7: TP.HCM - Long An - Bình Phước - Hậu Giang</p>

            <h2><strong>Cơ cấu giải thưởng vé số kiến thiết miền Nam</strong></h2>
            <p style="margin: 0;margin-top: 20px">Loại vé: 10.000 Đồng</p>
            <p style="margin: 0">Số lượng giải thưởng: 11.565</p>
            <p style="margin: 0">Số lần quay: 18 lần</p>

            <div>
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <td>Giải thưởng</td>
                            <td>Giá trị giải thưởng</td>
                            <td>Số lượng giải thưởng</td>
                            <td>Tổng giá trị giải thưởng</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Giải đặc biệt</td>
                            <td>2.000.000.000</td>
                            <td>1</td>
                            <td>2.000.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải phục giải đặc biệt</td>
                            <td>50.000.000</td>
                            <td>9</td>
                            <td>450.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải nhất</td>
                            <td>30.000.000</td>
                            <td>10</td>
                            <td>200.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải nhì</td>
                            <td>15.000.000</td>
                            <td>10</td>
                            <td>150.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải ba</td>
                            <td>10.000.000</td>
                            <td>20</td>
                            <td>200.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải tư</td>
                            <td>3.000.000</td>
                            <td>70</td>
                            <td>210.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải năm</td>
                            <td>1.000.000</td>
                            <td>100</td>
                            <td>100.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải sáu</td>
                            <td>400.000</td>
                            <td>300</td>
                            <td>120.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải bảy</td>
                            <td>200.000</td>
                            <td>1.000</td>
                            <td>200.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải tám</td>
                            <td>100.000</td>
                            <td>10.000</td>
                            <td>1.000.000.000</td>
                        </tr>
                        <tr>
                            <td>Giải khuyến khích</td>
                            <td>6.000.000</td>
                            <td>45</td>
                            <td>270.000.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h2><strong>Hướng dẫn đổi vé số trúng thưởng đài miền Nam</strong></h2>
            <p style="margin-bottom:0">Thời gian: Vé số trúng thưởng có thời gian lãnh thưởng theo quy định là 30 ngày kể từ ngày có kết quả xổ số.</p>
            <p style="margin: 0">Địa điểm: Vé số trúng thưởng có thể đổi ở trụ sở công ty xổ số ở nơi phát hành hoặc mang tới các đại lý bán vé số gần nhất.</p>
            <strong>Khách hàng cần mang theo:</strong>
            <p style="margin: 0">Thẻ căn cước công dân</p>
            <p style="margin: 0">Vé trúng thưởng phải còn nguyên vẹn, không rách rời, không chắp vá, và không bị tẩy xóa.
            </p>
            <p style="margin: 0">Vé số trúng thưởng trên 10 triệu đồng phải thực hiện nghĩa vụ nộp thuế TNCN là 10%.</p>
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

                    $.post("{{ route('xsmn.xem_them') }}", {

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

        var groupId = 2;

        var headingTag = 'h1';

        var interval;

        var timeInter = 1357 * 4; //thoi gian refresh

        LiveMN(groupId, appKey, rootPath, headingTag);

        interval = setInterval("LiveMN(" + groupId + ", '" + appKey + "', '" + rootPath + "', '" + headingTag + "')",
            timeInter);

        intervalVariable = setInterval('getRandomTextTN()', 100);
    </script>

@endsection
