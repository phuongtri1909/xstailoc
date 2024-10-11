@extends('frontend.layouts.app')


@section('title', $meta_title)

@section('decription', $meta_decription)

@section('keyword', $meta_keyword)
@section('h1', $meta_title)

@php

    date_default_timezone_set('Asia/Ho_Chi_Minh');

    $day_now = getThuNumber(date('Y-m-d', time()));

@endphp

@section('content')
    <div class="col-l">
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
            <li><a href="{{ route('xsmn') }}">Miền nam</a>
            </li>
            <li @if ($day == 2) class="active" @endif><a href="{{ route('xsmn.thu_2') }}"
                    title="XSMN Thứ 2">Thứ
                    2</a></li>
            <li @if ($day == 3) class="active" @endif><a href="{{ route('xsmn.thu_3') }}"
                    title="XSMN Thứ 3">Thứ
                    3</a></li>
            <li @if ($day == 4) class="active" @endif><a href="{{ route('xsmn.thu_4') }}"
                    title="XSMN Thứ 4">Thứ
                    4</a></li>
            <li @if ($day == 5) class="active" @endif><a href="{{ route('xsmn.thu_5') }}"
                    title="XSMN Thứ 5">Thứ
                    5</a></li>
            <li @if ($day == 6) class="active" @endif><a href="{{ route('xsmn.thu_6') }}"
                    title="XSMN Thứ 6">Thứ
                    6</a></li>
            <li @if ($day == 7) class="active" @endif><a href="{{ route('xsmn.thu_7') }}"
                    title="XSMN Thứ 7">Thứ
                    7</a></li>
            <li @if ($day == 8) class="active" @endif><a href="{{ route('xsmn.cn') }}"
                    title="XSMN Chủ nhật">CN</a></li>
        </ul>
        @if (!$kqToDay && $day_now == $day)
            <div class="block" id="mn_kqngay_{{ date('dmY', time()) }}" style="display: none;">

                <div class="block-main-heading" id="mnLiveTitle"></div>

            </div>
        @endif

        @include('frontend.xsmn.xsmn_include_thu')

        <div class="lotteryMnResult"></div>

        <input type="hidden" value="7" id="skip">

        <input type="hidden" value="{{ $lastPage * 7 }}" id="last_page">

        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <div class="loadmoreimg"><i class="fas fa-spinner fa-spin"></i></div>
        <button class="btn-see-more magb10 btn-viewmore" id="xem_them" value="Xem thêm" data-wday="2" data-page="2"
            data-province="mn-wday">Xem thêm
        </button>

        <div class="box-content">
            <p dir="ltr"><span style="font-size:14px"><a title="XSMN {{ $str_day }}"
                        href="{{ url()->full() }}">XSMN {{ $str_day }} </a> - Kết quả xổ số miền Nam
                    {{ $str_day }} hàng tuần được phát trực tiếp vào lúc 16:15. xem lại các kết quả XSMN
                    {{ $str_day }} những tuần trước nhanh chóng và chính xác miễn phí lại
                    xosotailoc.live
                </span>
            </p>
            <h2><strong>Các tỉnh mở thưởng quay xổ số kiến thiết miền Nam {{ $str_day }}
                </strong><strong>&nbsp;</strong>
            </h2>
            @foreach ($province_mn as $pro)
                <span>
                    <li>
                        <a style="text-decoration: underline" href="{{ route('xstinh.tinh', $pro->slug) }}" title="Xổ số {{ $pro->name }}">
                            <span>
                                Xổ số {{ $pro->name }}
                            </span>
                        </a>
                    </li>


                </span>
            @endforeach

            <h2><strong>Cơ cấu giải thưởng <a style="text-decoration: underline" title="xổ số miền Nam"
                href="{{ url()->full() }}">xổ số miền Nam</a></strong>
            </h2>

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

                    $.post("{{ route('xsmn.xem_them_theo_thu') }}", {

                        skip: skip,

                        day: {{ $day }},

                        _token: CSRF_TOKEN

                    }, function(result) {

                        var data = $.parseJSON(result);

                        $(".lotteryMnResult").append(data.template);



                        // cập nhật các tham số

                        $('.loadmoreimg').css('display', 'none');

                        $('.btn-viewmore').css('display', 'block');

                        $('#skip').val(skip + 5);

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

    @if ($day_now == $day)
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
    @endif

@endsection
