<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')
@section('title', 'XSMB - Kết quả xổ số Miền Bắc hôm nay - KQXSMB - SXMB - XSTD.')
@section('decription', 'KQXSMB - SXMB - Trực tiếp kết quả xổ số miền Bắc - XSTD hôm nay nhanh nhất, chính xác nhất từ
    trường quay XSKTMB Hà Nội vào lúc 18:15.')
@section('keyword', 'xsmb, sxmb, kqxsmb, xstd, xsmb hom nay, sxmb hom nay, xs mien bac, kqxs mien bac, xsmb 30 ngay, xổ
    số miền bắc,kq mb, kq xsmb, ket qua xsmb, xo so mien bac, sxmb hom nay, ket qua mien bac, kết quả xổ số miền bắc,xo so
    thu do,xo so mien bac hom nay')
@section('h1', 'XSMB - Kết quả xổ số Miền Bắc hôm nay - KQXSMB - SXMB - XSTD.')
@section('content')
    <div class="col-l">
        {{-- <div class="box"> --}}
        {{-- <div class="bg_gray"> --}}
        {{-- <div class=" opt_date_full clearfix"> --}}
        {{-- <label><strong>{{getThu(getThuNumber(date('Y-m-d')))}}</strong> - <input --}}
        {{-- type="text" class="nobor" value="{{date('d/m/Y')}}" id="searchDateMB"/><span --}}
        {{-- class='ic ic-calendar'></span></label> --}}
        {{-- </div> --}}
        {{-- </div> --}}
        {{-- </div> --}}
        <ul class="tab-panel">
            <li class='active'><a href="{{ route('xsmb') }}">Miền
                    bắc</a></li>
            <li><a href="{{ route('xsmb.thu_2') }}" title="XSMB Thứ 2">Thứ 2</a>
            </li>
            <li><a href="{{ route('xsmb.thu_3') }}" title="XSMB Thứ 3">Thứ 3</a>
            </li>
            <li><a href="{{ route('xsmb.thu_4') }}" title="XSMB Thứ 4">Thứ 4</a>
            </li>
            <li><a href="{{ route('xsmb.thu_5') }}" title="XSMB Thứ 5">Thứ 5</a>
            </li>
            <li><a href="{{ route('xsmb.thu_6') }}" title="XSMB Thứ 6">Thứ 6</a>
            </li>
            <li><a href="{{ route('xsmb.thu_7') }}" title="XSMB Thứ 7">Thứ 7</a>
            </li>
            <li><a href="{{ route('xsmb.cn') }}" title="XSMB Chủ nhật">CN</a></li>
        </ul>
        @if (!$kqToDay)
            <div class="box" id='kqngay_{{ date('dmY', time()) }}' style="display: none;"></div>
        @endif
        @include('frontend.xsmb.include_xsmb')
        <div class="lotteryMbResult"></div>
        <input type="hidden" value="2" id="page">
        <input type="hidden" value="{{ $lastPage }}" id="last_page">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <div class="loadmoreimg"><i class="fas fa-spinner fa-spin"></i></div>
        <button class="btn-see-more magb10 btn-viewmore" id="xem_them" value="Xem thêm" data-page="2"
            data-province="mb">Xem
            thêm
        </button>
        <div class="box-content">
            <p>Xem trực tiếp xổ số kiến thiết miền Bắc nhanh chóng và chính xác hàng ngày. Dò XSMB - SXMB - KQXSMB vào lúc
                18:10 tường thuật trực tuyến từ trường quay Công ty TNHH Một thành viên Xổ số kiến thiết Thủ đô tại địa chỉ
                53E Hàng Bài, Quận Hoàn Kiếm, Hà Nội, Việt Nam.</p>

            <h2><strong>Lịch mở thưởng <a href="{{ route('xsmb') }}"> xổ số miền Bắc </a>trong tuần:</strong></h2>
            <p style="margin: 0;margin-top: 20px">Thứ Hai: Xổ số Hà Nội </p>
            <p style="margin: 0">Thứ Ba: Xổ số Quảng Ninh </p>
            <p style="margin: 0">Thứ Tư: Xổ số Bắc Ninh </p>
            <p style="margin: 0">Thứ Năm: XSTD Hà Nội</p>
            <p style="margin: 0">Thứ Sáu: Xổ số Hải Phòng</p>
            <p style="margin: 0">Thứ Bảy: Xổ số Nam Định</p>
            <p style="margin: 0;margin-bottom: 15px">Chủ Nhật: Xổ số Thái Bình</p>

            <h2><strong>Cơ cấu giải thưởng vé số kiến thiết miền Bắc</strong></h2>
            <p style="margin: 0;margin-top: 20px">Loại vé: 10.000 Đồng</p>
            <p style="margin: 0">Số lượng giải thưởng: 108.200</p>
            <p style="margin: 0">Số lần quay: 27 lần</p>

            <div>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <td>Hạng giải</td>
                        <td>Giá trị giải thưởng</td>
                        <td>Số lượng giải thưởng</td>
                        <td>Tổng giá trị giải thưởng</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Giải đặc biệt</td>
                        <td>500.000.000</td>
                        <td>8</td>
                        <td>4.000.000.000</td>
                    </tr>
                    <tr>
                        <td>Giải phục giải đặc biệt</td>
                        <td>25.000.000</td>
                        <td>12</td>
                        <td>300.000.000</td>
                    </tr>
                    <tr>
                        <td>Giải nhất</td>
                        <td>10.000.000</td>
                        <td>20</td>
                        <td>200.000.000</td>
                    </tr>
                    <tr>
                        <td>Giải nhì</td>
                        <td>5.000.000</td>
                        <td>40</td>
                        <td>200.000.000</td>
                    </tr>
                    <tr>
                        <td>Giải ba</td>
                        <td>1.000.000</td>
                        <td>120</td>
                        <td>120.000.000</td>
                    </tr>
                    <tr>
                        <td>Giải tư</td>
                        <td>400.000</td>
                        <td>800</td>
                        <td>320.000.000</td>
                    </tr>
                    <tr>
                        <td>Giải năm</td>
                        <td>200.000</td>
                        <td>1.200</td>
                        <td>240.000.000</td>
                    </tr>
                    <tr>
                        <td>Giải sáu</td>
                        <td>100.000</td>
                        <td>6000</td>
                        <td>600.000.000</td>
                    </tr>
                    <tr>
                        <td>Giải bảy</td>
                        <td>40.000</td>
                        <td>80000</td>
                        <td>3.200.000.000</td>
                    </tr>
                    <tr>
                        <td>Giải khuyến khích</td>
                        <td>40.000</td>
                        <td>20000</td>
                        <td>800.000.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
            <h2><strong>Hướng dẫn đổi vé số trúng thưởng đài miền Bắc</strong></h2>
            <p style="margin-bottom:0">Thời gian: Từ thứ Hai đến thứ Sáu trong giờ hành chính và vào các buổi sáng thứ Bảy, Chủ Nhật, cũng như các ngày lễ.</p>
            <p style="margin: 0">Địa điểm: Số 53E, phố Hàng Bài, quận Hoàn Kiếm, thành phố Hà Nội và các đại lý xổ số kiến thiết trên địa bàn thành phố Hà Nội.</p>
            <strong>Khách hàng cần mang theo:</strong>
            <p style="margin: 0">Thẻ căn cước công dân</p>
            <p style="margin: 0">Vé trúng thưởng phải còn nguyên vẹn, không rách rời, không chắp vá, và không bị tẩy xóa.</p>

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
                var page = parseInt($('#page').val());
                var last_page = parseInt($('#last_page').val());
                if (page <= last_page) {
                    $('.loadmoreimg').css('display', 'block');
                    $('.btn-viewmore').css('display', 'none');
                    $.post("{{ route('xsmb.xem_them') }}", {
                        page: page,
                        _token: CSRF_TOKEN
                    }, function(result) {
                        var data = $.parseJSON(result);
                        $(".lotteryMbResult").append(data.template);

                        // cập nhật các tham số

                        $('.loadmoreimg').css('display', 'none');
                        $('.btn-viewmore').css('display', 'block');
                        $('#page').val(page + 1);
                        if (page == last_page) {
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
        var d = new Date();
        var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
        var currentdate = new Date(utc + (3600000 * +7));
        var rootPath = '';
        var appKey = '';
        var headingTag = 'h1';
        var interval;
        var timeInter = 1357 * 4;
        var hours = currentdate.getHours();
        var minute = currentdate.getMinutes();

        //        try {
        LiveMB(appKey, rootPath, headingTag);
        interval = setInterval("LiveMB('" + appKey + "', '" + rootPath + "', '" + headingTag + "')", timeInter);
        intervalVariable = setInterval('getRandomTextMB()', 100);

        //        } catch (e) {
        //            console.log(e.message);
        //        }
    </script>
@endsection
