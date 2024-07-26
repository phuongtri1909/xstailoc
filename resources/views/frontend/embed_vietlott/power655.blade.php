<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title>Mã nhúng</title>
    <link rel="canonical" href="{{route('power655')}}">
    <link rel="alternate" href="{{route('power655')}}" hreflang="vi-vn">
    <link rel="alternate" href="{{route('power655')}}" hreflang="x-default">
	<meta name="robots" content="index, follow">
    <meta name="DC.title" content="Mã nhúng">
    <meta name="DC.Source" content="/">
    <meta name="DC.Coverage" content="Vietnam">
    <meta name="RATING" content="GENERAL">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Mã nhúng">
    <meta property="og:description" content="">
    <meta property="og:url" content="https://xstailoc.com">
    <meta property="og:image" content="">
    <meta property="og:site_name" content="xstailoc.com">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="xstailoc.com">
    <meta name="twitter:creator" content="xstailoc.com">
    <meta name="twitter:title" content="Mã nhúng">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="">
    <meta property="article:publisher" content="">
    <meta property="article:author" content="xstailoc.com">
    <meta property="article:section" content="Lottery">
    <meta property="article:tag" content="kết quả xổ số, kết quả vn">
    <meta name="AUTHOR" content="xstailoc.com">
    <meta name="COPYRIGHT" content="Copyright (C) 2023 xstailoc.com">
    <link rel="index" title="Kết quả xổ số" href="https://xstailoc.com">
    <link rel="image_src" type="image/jpeg" href="">
    <link rel="shortcut icon" href="{{url('frontend/images/favicon.png')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{url('frontend/emb/css/style.css')}}?v={{rand(1000,100000)}}" media="all">
    <link rel="stylesheet" href="{{url('frontend/emb/css/main.css')}}?v={{rand(1000,100000)}}" media="all">
    <script src="{{url('frontend/emb/js/jquery.min.js')}}"></script>
    <script src="{{url('frontend/emb/js/theme_emb.js')}}?v={{rand(1000,100000)}}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
@if(!empty($kq_power655))
    @if(!empty($date))
    <div class="kqsx-today text-center v-card mb-3 vietlott-block bg-vl-power" id='power655_{{getNgayID($kq_power655->date)}}'>
        @else
    <div class="kqsx-today text-center v-card mb-3 vietlott-block bg-vl-power" id='power655_{{date('dmY',time())}}'>
        @endif
    <h2 class="bg-power655 list-group-title fw-medium txt-sub-title text-center mb-0 lh-base">
        <a class="text-white" href="{{route('power655')}}">Xổ số Power 6/55</a> {{getThu($kq_power655->day)}} ngày {{getNgay($kq_power655->date)}}
    </h2>
    <table class="table-lotto w-100 text-center overflow-hidden bblr-1 bbrr-1">
        <tbody>
        <tr>
            <th colspan="28" class="fw-normal">
                Kỳ quay thưởng: <span class="color-highlight">#{{$kq_power655->ky}}</span>
            </th>
        </tr>
        <tr>
            <th colspan="28">
                <div class="d-flex flex-column align-items-center padding-10">
                                        <span class="fw-medium d-block m-b-5">Giá trị Jackpot 1 Power 6/55 ước
                                            tính</span>

                    <div class="p-t-15 p-b-15 p-l-30 p-r-30 bg-mega645 br-10 text-white txt-normal-prize text-nowrap m-b-15">
                        {{number_format($kq_power655->jackpot1_gt)}} đồng
                    </div>
                                        <span class="fw-medium d-block m-b-5">Giá trị Jackpot 2 Power 6/55 ước
                                            tính</span>

                    <div class="p-t-15 p-b-15 p-l-30 p-r-30 bg-mega645 br-10 text-white txt-normal-prize text-nowrap">
                        {{number_format($kq_power655->jackpot2_gt)}} đồng
                    </div>
                </div>
                @php $daySo = explode('-', $kq_power655->day_so); $d=1; @endphp
                <div class="d-flex justify-content-center align-items-center p-t-5 p-b-5">
                    <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium">{{$daySo[0]}}</div>
                    <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium">{{$daySo[1]}}</div>
                    <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium">{{$daySo[2]}}</div>
                    <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium">{{$daySo[3]}}</div>
                    <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium">{{$daySo[4]}}</div>
                    <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium">{{$daySo[5]}}</div>
                    <div class="line-power"></div>
                    <div class="power655-ball bg-ball-8 txt-normal-prize fw-medium text-white">{{$daySo[6]}}
                    </div>
                </div>
            </th>
        </tr>
        <tr class="bg-light-vl">
            <th class="fw-medium" colspan="5">Giải</th>
            <th class="fw-medium" colspan="9">Trùng khớp</th>
            <th class="fw-medium" colspan="5">Số lượng</th>
            <th class="fw-medium" colspan="9">Giá trị (đ)</th>
        </tr>
        <tr class="txt-sub-content text-start">
            <td colspan="5">Jackpot 1</td>
            <td colspan="9">
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
            </td>
            <td colspan="5">{{$kq_power655->jackpot1_sl}}</td>
            <td class="color-highlight fw-medium" colspan="9">{{number_format($kq_power655->jackpot1_gt)}}</td>
        </tr>
        <tr class="txt-sub-content text-start">
            <td colspan="5">Jackpot 2</td>
            <td colspan="9">
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="fas fa-circle color-highlight"></i>
            </td>
            <td colspan="5">{{$kq_power655->jackpot2_sl}}</td>
            <td class="color-highlight fw-medium" colspan="9">{{number_format($kq_power655->jackpot2_gt)}}</td>
        </tr>
        <tr class="txt-sub-content text-start">
            <td colspan="5">Giải nhất</td>
            <td colspan="9">
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
            </td>
            <td colspan="5">{{number_format($kq_power655->g1_sl)}}</td>
            <td colspan="9">40,000,000</td>
        </tr>
        <tr class="txt-sub-content text-start">
            <td colspan="5">Giải nhì</td>
            <td colspan="9">
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
            </td>
            <td colspan="5">{{number_format($kq_power655->g2_sl)}}</td>
            <td colspan="9">500,000</td>
        </tr>
        <tr class="txt-sub-content text-start">
            <td colspan="5">Giải ba</td>
            <td colspan="9">
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
            </td>
            <td colspan="5">{{number_format($kq_power655->g3_sl)}}</td>
            <td colspan="9">50,000</td>
        </tr>
        </tbody>
    </table>
</div>
@else
    <div class="kqsx-today text-center v-card mb-3 vietlott-block bg-vl-power" id='power655_{{date('dmY',time())}}'>
        <h2 class="bg-power655 list-group-title fw-medium txt-sub-title text-center mb-0 lh-base">
            <a class="text-white" href="{{route('power655')}}">Xổ số Power 6/55</a> {{getThu(getThuNumber($date))}} ngày {{getNgay($date)}}
        </h2>
        <table class="table-lotto w-100 text-center overflow-hidden bblr-1 bbrr-1">
            <tbody>
            <tr>
                <th colspan="28" class="fw-normal">
                    Kỳ quay thưởng: <span class="color-highlight">###</span>
                </th>
            </tr>
            <tr>
                <th colspan="28">
                    <div class="d-flex flex-column align-items-center padding-10">
                                        <span class="fw-medium d-block m-b-5">Giá trị Jackpot 1 Power 6/55 ước
                                            tính</span>

                        <div class="p-t-15 p-b-15 p-l-30 p-r-30 bg-mega645 br-10 text-white txt-normal-prize text-nowrap m-b-15">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                                        <span class="fw-medium d-block m-b-5">Giá trị Jackpot 2 Power 6/55 ước
                                            tính</span>

                        <div class="p-t-15 p-b-15 p-l-30 p-r-30 bg-mega645 br-10 text-white txt-normal-prize text-nowrap">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center p-t-5 p-b-5">
                        <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="power655-ball bg-ball-7 txt-normal-prize fw-medium"><i class="fas fa-spinner fa-spin"></i></div>
                        <div class="line-power"></div>
                        <div class="power655-ball bg-ball-8 txt-normal-prize fw-medium text-white"><i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </th>
            </tr>
            <tr class="bg-light-vl">
                <th class="fw-medium" colspan="5">Giải</th>
                <th class="fw-medium" colspan="9">Trùng khớp</th>
                <th class="fw-medium" colspan="5">Số lượng</th>
                <th class="fw-medium" colspan="9">Giá trị (đ)</th>
            </tr>
            <tr class="txt-sub-content text-start">
                <td colspan="5">Jackpot 1</td>
                <td colspan="9">
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                </td>
                <td colspan="5"><i class="fas fa-spinner fa-spin"></i></td>
                <td class="color-highlight fw-medium" colspan="9"><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="txt-sub-content text-start">
                <td colspan="5">Jackpot 2</td>
                <td colspan="9">
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="fas fa-circle color-highlight"></i>
                </td>
                <td colspan="5"><i class="fas fa-spinner fa-spin"></i></td>
                <td class="color-highlight fw-medium" colspan="9"><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="txt-sub-content text-start">
                <td colspan="5">Giải nhất</td>
                <td colspan="9">
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                </td>
                <td colspan="5"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="9">40,000,000</td>
            </tr>
            <tr class="txt-sub-content text-start">
                <td colspan="5">Giải nhì</td>
                <td colspan="9">
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                </td>
                <td colspan="5"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="9">500,000</td>
            </tr>
            <tr class="txt-sub-content text-start">
                <td colspan="5">Giải ba</td>
                <td colspan="9">
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                </td>
                <td colspan="5"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="9">50,000</td>
            </tr>
            </tbody>
        </table>
    </div>
@endif

@php $day = getThuNumber(date('Y-m-d', time())); @endphp
@if($day==3 || $day==5 || $day==7)
    <script>
        loadfile_power655();
        function loadfile_power655() {
            var d = new Date();
            var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
            var currentdate = new Date(utc + (3600000 * +7));
            var hour = currentdate.getHours();
            var minute = currentdate.getMinutes();

            if ((hour == 18) && minute >= 0 && minute <= 50) {
                var url = '{{route('power655_ajax')}}';
                $('#power655_'+'{{date('dmY',time())}}').show();
                $('#power655_'+'{{date('dmY',time())}}').load(url);
            }
        }

        $(document).ready(function () {
            setInterval('loadfile_power655()', 30000);
        });
    </script>
@endif
</body>
</html>