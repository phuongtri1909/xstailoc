<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

?>

@extends('frontend.layouts.app')

@section('h1', $meta_title)
@section('title', $meta_title)
@section('decription', $meta_description)
@section('keyword', $meta_keyword)

@section('content')
    <div class="col-l" style="height: auto !important;">
        @if (!$checkKQMNToday)
            <div class="block" id='kqngay_{{ date('dmY') }}' style="display: none;">
                <div class="block-main-heading" id="provinceLiveTitle"></div>
            </div>
        @endif
        @include('frontend.xstinh.include_xsmn')

        <div class="lotteryMnResult"></div>

        <input type="hidden" value="2" id="page">

        <input type="hidden" value="{{ $lastPage }}" id="last_page">

        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <div class="loadmoreimg"><i class="fas fa-spinner fa-spin"></i></div>
        <button class="btn-see-more magb10 btn-viewmore" id="xem_them" value="Xem thêm" data-page="2"
            data-province="mn">Xem
            thêm
        </button>


        <div class="box-content">

            <p><span style="font-size:14px">SX{{ strtoupper($province->short_name) }} - Trực tiếp kết quả <a style="text-decoration: underline" title="xổ số {{ $province->name }}"
                        href="{{ route('xstinh.tinh', $province->slug) }}">xổ số {{ $province->name }}</a> hôm nay nhanh
                    nhất và chính xác nhất. Kết quả XS{{ strtoupper($province->short_name) }} được công bố vào lúc 16:15
                    {{ $thu }} hàng tuần trên website xosotailoc.vip cập nhật mới nhất. Ngoài ra còn có các tiện ích
                    giúp bạn xem lại kết quả XS{{ strtoupper($province->short_name) }} 30 ngày, XS{{ strtoupper($province->short_name) }} hàng tuần, quay thử xổ số {{ $province->name }}, dự đoán XS{{ strtoupper($province->short_name) }} chính xác</span></p>


            <p>
                <span style="font-size:14px">
                    KQXS{{ strtoupper($province->short_name) }} được Công ty Xổ số kiến thiết {{ $province->name }} công khai quay thưởng tại {{ $location }}.
                </span>
            </p>

            <p>
                <span style="font-size:14px">
                    Theo dõi xosotailoc.vip để xem <a style="text-decoration: underline" title="KQXS" href="{{ route('home') }}">KQXS</a> nhanh nhất và chính xác nhất hàng ngày miễn phí.
                </span>
            </p>
        </div>
    </div>

@endsection

@php
    $day = getThuNumber(date('Y-m-d', time()));
@endphp
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

                    $.post("{{ route('xstinh.xsmn.xem_them') }}", {

                        page: page,

                        province_id: {{ $province->id }},

                        _token: CSRF_TOKEN

                    }, function(result) {

                        var data = $.parseJSON(result);

                        $(".lotteryMnResult").append(data.template);



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

    @if (strpos($province->ngay_quay, $day) !== false)
        <script src="{{ url('frontend/js/lotteryLive.js') }}?v={{ rand(1000, 100000) }}"></script>
        <script type="text/javascript">
            var rootPath = '';

            l_root = rootPath.split(";");

            if (root == null)

                root = l_root[0];

            var appKey = '';

            var groupId = 2;

            var lotId = {{ $province->id }};

            var fromPageView = 'KQD';

            var headingTag = 'h1';

            var interval;

            var timeInter = 1357 * 4; //thoi gian refresh

            LiveProvince(groupId, lotId, appKey, root, headingTag);

            interval = setInterval("LiveProvince(" + groupId + ", " + lotId + ", '" + appKey + "', '" + root + "', '" +
                headingTag + "')", timeInter);

            intervalVariable = setInterval('getRandomTextProvince()', 100);
        </script>
    @endif
@endsection
