<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title>Mã nhúng</title>
    <link rel="canonical" href="{{route('mega645')}}">
    <link rel="alternate" href="{{route('mega645')}}" hreflang="vi-vn">
    <link rel="alternate" href="{{route('mega645')}}" hreflang="x-default">
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
@if(!empty($kq_mega645))
    @if(!empty($date))
<div class="kqsx-today text-center v-card mb-3 vietlott-block bg-vl-mega"  id='mega645_{{getNgayID($kq_mega645->date)}}'>
    @else
<div class="kqsx-today text-center v-card mb-3 vietlott-block bg-vl-mega"  id='mega645_{{date('dmY',time())}}'>
    @endif
    <h2 class="bg-mega645 list-group-title fw-medium txt-sub-title text-center mb-0 lh-base">
        <a class="text-white" href="{{route('mega645')}}">Xổ số Mega 6/45</a> {{getThu($kq_mega645->day)}} ngày {{getNgay($kq_mega645->date)}}
    </h2>
    <table class="table-lotto w-100 text-center overflow-hidden bblr-1 bbrr-1">
        <tbody>
        <tr>
            <th colspan="28" class="fw-normal">
                Kỳ quay thưởng: <span class="color-highlight">#{{$kq_mega645->ky}}</span>
            </th>
        </tr>
        <tr>
            <th colspan="28">
                <div class="d-flex flex-column align-items-center padding-10">
                    <span class="fw-medium d-block m-b-5">Giá trị Jackpot Mega 6/45 ước tính</span>

                    <div class="p-t-15 p-b-15 p-l-30 p-r-30 bg-mega645 br-10 text-white txt-normal-prize text-nowrap">
                        {{number_format($kq_mega645->jackpot_gt)}} đồng
                    </div>
                </div>
                @php $daySo = explode('-', $kq_mega645->day_so); $d=1; @endphp
                <div class="d-flex justify-content-center p-t-5 p-b-5">
                    @foreach($daySo as $value)
                        <div class="mega645-ball bg-ball-{{$d++}} txt-normal-prize fw-medium">{{$value}}</div>
                    @endforeach
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
            <td colspan="5">Jackpot</td>
            <td colspan="9">
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="fas fa-circle color-highlight"></i>
            </td>
            <td colspan="5">{{$kq_mega645->jackpot_sl}}</td>
            <td class="color-highlight fw-medium" colspan="9">{{number_format($kq_mega645->jackpot_gt)}}</td>
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
            <td colspan="5">{{number_format($kq_mega645->g1_sl)}}</td>
            <td colspan="9">10,000,000</td>
        </tr>
        <tr class="txt-sub-content text-start">
            <td colspan="5">Giải nhì</td>
            <td colspan="9">
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
            </td>
            <td colspan="5">{{number_format($kq_mega645->g2_sl)}}</td>
            <td colspan="9">300,000</td>
        </tr>
        <tr class="txt-sub-content text-start">
            <td colspan="5">Giải ba</td>
            <td colspan="9">
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
                <i class="far fa-circle"></i>
            </td>
            <td colspan="5">{{number_format($kq_mega645->g3_sl)}}</td>
            <td colspan="9">30,000</td>
        </tr>
        </tbody>
    </table>
</div>
@else
    <div class="kqsx-today text-center v-card mb-3 vietlott-block bg-vl-mega"  id='mega645_{{date('dmY',time())}}'>
        <h2 class="bg-mega645 list-group-title fw-medium txt-sub-title text-center mb-0 lh-base">
            <a class="text-white" href="{{route('mega645')}}">Xổ số Mega 6/45</a> {{getThu(getThuNumber($date))}} ngày {{getNgay($date)}}
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
                        <span class="fw-medium d-block m-b-5">Giá trị Jackpot Mega 6/45 ước tính</span>

                        <div class="p-t-15 p-b-15 p-l-30 p-r-30 bg-mega645 br-10 text-white txt-normal-prize text-nowrap">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center p-t-5 p-b-5">
                        @for($d=1;$d<=6;$d++)
                            <div class="mega645-ball bg-ball-{{$d}} txt-normal-prize fw-medium"><i class="fas fa-spinner fa-spin"></i></div>
                        @endfor
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
                <td colspan="5">Jackpot</td>
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
                <td colspan="9">10,000,000</td>
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
                <td colspan="9">300,000</td>
            </tr>
            <tr class="txt-sub-content text-start">
                <td colspan="5">Giải ba</td>
                <td colspan="9">
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                    <i class="far fa-circle"></i>
                </td>
                <td colspan="5"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="9">30,000</td>
            </tr>
            </tbody>
        </table>
    </div>
@endif

@php $day = getThuNumber(date('Y-m-d', time())); @endphp
@if($day==4 || $day==6 || $day==8)
    <script>
        loadfile_mega645();
        function loadfile_mega645() {
            var d = new Date();
            var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
            var currentdate = new Date(utc + (3600000 * +7));
            var hour = currentdate.getHours();
            var minute = currentdate.getMinutes();

            if ((hour == 18) && minute >= 0 && minute <= 50) {
                var url = '{{route('mega645_ajax')}}';
                $('#mega645_'+'{{date('dmY',time())}}').show();
                $('#mega645_'+'{{date('dmY',time())}}').load(url);
            }
        }

        $(document).ready(function () {
            setInterval('loadfile_mega645()', 30000);
        });
    </script>
@endif
</body>
</html>