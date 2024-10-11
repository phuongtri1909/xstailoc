@extends('frontend.layouts.app')



@section('title', $meta_title)

@section('decription', $meta_decription)

@section('keyword', $meta_keyword)

@php $day_now = getThuNumber(date('Y-m-d', time())); @endphp
@section('h1', $meta_title)
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
            <li><a href="{{ route('xsmb') }}">Miền
                    bắc</a></li>
            <li @if ($day == 2) class="active" @endif><a href="{{ route('xsmb.thu_2') }}"
                    title="XSMB Thứ 2">Thứ 2</a>
            </li>
            <li @if ($day == 3) class="active" @endif><a href="{{ route('xsmb.thu_3') }}"
                    title="XSMB Thứ 3">Thứ 3</a>
            </li>
            <li @if ($day == 4) class="active" @endif><a href="{{ route('xsmb.thu_4') }}"
                    title="XSMB Thứ 4">Thứ 4</a>
            </li>
            <li @if ($day == 5) class="active" @endif><a href="{{ route('xsmb.thu_5') }}"
                    title="XSMB Thứ 5">Thứ 5</a>
            </li>
            <li @if ($day == 6) class="active" @endif><a href="{{ route('xsmb.thu_6') }}"
                    title="XSMB Thứ 6">Thứ 6</a>
            </li>
            <li @if ($day == 7) class="active" @endif><a href="{{ route('xsmb.thu_7') }}"
                    title="XSMB Thứ 7">Thứ 7</a>
            </li>
            <li @if ($day == 8) class="active" @endif><a href="{{ route('xsmb.cn') }}"
                    title="XSMB Chủ nhật">CN</a></li>
        </ul>
        @if (!$kqToDay && $day_now == $day)
            <div class="block" id='kqngay_{{ date('dmY', time()) }}' style="display: none;"></div>
        @endif
        @include('frontend.xsmb.include_xsmb_thu')
        <div class="lotteryMbResult"></div>
        <input type="hidden" value="2" id="page">
        <input type="hidden" value="{{ $lastPage }}" id="last_page">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <div class="loadmoreimg"><i class="fas fa-spinner fa-spin"></i></div>
        <button class="btn-see-more magb10 btn-viewmore" id="xem_them" value="Xem thêm" data-page="2"
            data-province="mb">Xem
            thêm
        </button>
        {{-- <button class="btn-see-more magb10" id="result-more" value="Xem thêm" data-wday="2" data-page="2" --}}
        {{-- data-province="mb-wday">Xem thêm --}}
        {{-- </button> --}}
        <div class="box-content">
            <p dir="ltr"><a style="text-decoration: underline" href="{{ url()->full() }}"
                    title="XSMB {{ $str_day }}">XSMB
                    {{ $str_day }}</a> - Kết quả xổ số miền Bắc {{ $str_day }} hàng tuần được phát trực tiếp vào
                lúc 18:15, xem
                lại các kết quả <a style="text-decoration: underline" href="{{ route('xsmb') }}" title="XSMB">XSMB</a>
                {{ $str_day }} những tuần trước nhanh chóng và chính xác miễn phí tại xosotailoc.live</p>

            @switch($str_day)
                @case('Thứ 2')
                    <p>Tỉnh mở thưởng SXMB {{ $str_day }} là xổ số Hà Nội (XSHN - XSTD)</p>
                @break

                @case('Thứ 3')
                    <p>Tỉnh mở thưởng SXMB {{ $str_day }} là xổ số Quảng Ninh (XSQN)</p>
                @break

                @case('Thứ 4')
                    <p>Tỉnh mở thưởng SXMB {{ $str_day }} là xổ số Bắc Ninh (XSBN)</p>
                @break

                @case('Thứ 5')
                    <p>Tỉnh mở thưởng SXMB {{ $str_day }} là xổ số Hà Nội (XSHN)</p>
                @break

                @case('Thứ 6')
                    <p>Tỉnh mở thưởng SXMB {{ $str_day }} là xổ số Hải Phòng (XSHP)</p>
                @break

                @case('Thứ 7')
                    <p>Tỉnh mở thưởng SXMB {{ $str_day }} là xổ số Nam Định (XSND)</p>
                @break

                @case('Chủ nhật')
                    <p>Tỉnh mở thưởng SXMB {{ $str_day }} là xổ số Thái Bình (XSTB)</p>
                @break
            @endswitch

            <h2><strong>Cơ cấu giải thưởng xổ số miền Bắc</strong></h2>
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

                    $.post("{{ route('xsmb.xem_them_theo_thu') }}", {

                        page: page,

                        day: {{ $day }},

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

    @if ($day_now == $day)
        <script src="{{ url('frontend/js/lotteryLive.js') }}?v={{ rand(1000, 100000) }}"></script>

        <script type="text/javascript">
            var d = new Date();

            var utc = d.getTime() + (d.getTimezoneOffset() * 60000);

            var currentdate = new Date(utc + (3600000 * +7));

            var rootPath = '';

            var appKey = '';

            var headingTag = 'h1';

            var interval;

            var timeInter = 1357 * 4; //thoi gian refresh

            //            var currentdate = new Date();

            var hours = currentdate.getHours();

            var minute = currentdate.getMinutes();

            try {

                if ((hours == 18) && minute >= 10 && minute <= 40) {

                    LiveMB(appKey, rootPath, headingTag);

                    interval = setInterval("LiveMB('" + appKey + "', '" + rootPath + "', '" + headingTag + "')", timeInter);

                    intervalVariable = setInterval('getRandomTextMB()', 100);

                }

            } catch (e) {

                console.log(e.message);

            }
        </script>
    @endif

@endsection
