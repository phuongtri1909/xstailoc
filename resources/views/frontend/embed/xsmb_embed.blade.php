<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <meta charset="utf-8">
    <title>Mã nhúng</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(empty($date))
        <link rel="canonical" href="{{route('xsmb')}}">
        <link rel="alternate" href="{{route('xsmb')}}" hreflang="vi-vn">
        <link rel="alternate" href="{{route('xsmb')}}" hreflang="x-default">
    @else
        <link rel="canonical" href="{{route('xsmb.date',$date)}}">
        <link rel="alternate" href="{{route('xsmb.date',$date)}}" hreflang="vi-vn">
        <link rel="alternate" href="{{route('xsmb.date',$date)}}" hreflang="x-default">
    @endif
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
<?php
$gdb = $xsmb->gdb;
$g1 = $xsmb->g1;
$g2 = explode('-', $xsmb->g2);
$g3 = explode('-', $xsmb->g3);
$g4 = explode('-', $xsmb->g4);
$g5 = explode('-', $xsmb->g5);
$g6 = explode('-', $xsmb->g6);
$g7 = explode('-', $xsmb->g7);

$xsmbStr = $xsmb->gdb . '-' . $xsmb->g1 . '-' . $xsmb->g2 . '-' . $xsmb->g3 . '-' . $xsmb->g4 . '-' . $xsmb->g5 . '-' . $xsmb->g6 . '-' . $xsmb->g7;
$xsmbLoto = getLoto($xsmbStr);
$xsmbDau = getDau($xsmbLoto, substr($xsmb->gdb, strlen($xsmb->gdb) - 2, 2));
$xsmbDuoi = getDuoi($xsmbLoto, substr($xsmb->gdb, strlen($xsmb->gdb) - 2, 2));
?>
<div class="box bg-white rd shadow" @if(empty($date)) id='kqngay_{{date('dmY',time())}}'  onclick="window.open('{{route('xsmb')}}','_blank');return;" @else id='kqngay_{{getNgayID($xsmb->date)}}'  onclick="window.open('{{route('xsmb.date',$date)}}','_blank');return;" @endif>
    <div class="kqmb shadow kqsx mb">
        <table class="table-kqsx">
            <thead>
            <tr>
                <th colspan="27" class="header-kqsx">
                    <h2 class="h-kqsx">Kết quả xổ số Miền Bắc {{getNgay($xsmb->date)}}</h2>
                    <h3 class="breadcrumb-link"  id="MbListLink">
                        <a href="{{route('xsmb')}}">XSMB</a> /
                        <a href="{{route(getRouteDay($xsmb->day,'xsmb'))}}">XSMB {{getThu($xsmb->day)}}</a> /
                        <a href="{{route('xsmb.date',getNgayLink($xsmb->date))}}">XSMB {{getNgay($xsmb->date)}}</a>
                    </h3>
                </th>
            </tr>
            <tr>
                <td colspan="27" class="txt-db" id="mb_prizeCode_item">{{str_replace('-',' - ',$xsmb->madb)}}</td>
            </tr>
            </thead>
            <tbody>
            <tr class="db">
                <td colspan="3" class="color-highlight font-20">ĐB</td>
                <td colspan="24" class="txt-special-prize txt-giai" id="mb_prize_DB_item_0" data-id="@if(!empty($gdb)){{$gdb}}@endif">@if(!empty($gdb)){{$gdb}}@endif</td>
            </tr>
            <tr class="odd-bg g1">
                <td colspan="3" class="fw-medium">G1</td>
                <td colspan="24" class="txt-normal-prize txt-giai txt-giai"  id="mb_prize_1_item_0" data-id="@if(!empty($g1)){{$g1}}@endif">@if(!empty($g1)){{$g1}}@endif</td>
            </tr>
            <tr>
                <td colspan="3" class="fw-medium g2">G2</td>
                <td colspan="12" class="txt-normal-prize txt-giai" id="mb_prize_2_item_0" data-id="@if(!empty($g2[0])){{$g2[0]}}@endif">@if(!empty($g2[0])){{$g2[0]}}@endif</td>
                <td colspan="12" class="txt-normal-prize txt-giai" id="mb_prize_2_item_1" data-id="@if(!empty($g2[1])){{$g2[1]}}@endif">@if(!empty($g2[1])){{$g2[1]}}@endif</td>
            </tr>
            <tr class="odd-bg g3">
                <td colspan="3" rowspan="2" class="fw-medium">G3</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_0" data-id="@if(!empty($g3[0])){{$g3[0]}}@endif">@if(!empty($g3[0])){{$g3[0]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_1" data-id="@if(!empty($g3[1])){{$g3[1]}}@endif">@if(!empty($g3[1])){{$g3[1]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_2" data-id="@if(!empty($g3[2])){{$g3[2]}}@endif">@if(!empty($g3[2])){{$g3[2]}}@endif</td>
            </tr>
            <tr class="odd-bg">
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_3" data-id="@if(!empty($g3[3])){{$g3[3]}}@endif">@if(!empty($g3[3])){{$g3[3]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_4" data-id="@if(!empty($g3[4])){{$g3[4]}}@endif">@if(!empty($g3[4])){{$g3[4]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_5" data-id="@if(!empty($g3[5])){{$g3[5]}}@endif">@if(!empty($g3[5])){{$g3[5]}}@endif</td>
            </tr>
            <tr>
                <td colspan="3" class="fw-medium">G4</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_4_item_0" data-id="@if(!empty($g4[0])){{$g4[0]}}@endif" l="4">@if(!empty($g4[0])){{$g4[0]}}@endif</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_4_item_1" data-id="@if(!empty($g4[1])){{$g4[1]}}@endif" l="4">@if(!empty($g4[1])){{$g4[1]}}@endif</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_4_item_2" data-id="@if(!empty($g4[2])){{$g4[2]}}@endif" l="4">@if(!empty($g4[2])){{$g4[2]}}@endif</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_4_item_3" data-id="@if(!empty($g4[3])){{$g4[3]}}@endif" l="4">@if(!empty($g4[3])){{$g4[3]}}@endif</td>
            </tr>
            <tr class="odd-bg g5">
                <td colspan="3" rowspan="2" class="fw-medium">G5</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_0" data-id="@if(!empty($g5[0])){{$g5[0]}}@endif" l="4">@if(!empty($g5[0])){{$g5[0]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_1" data-id="@if(!empty($g5[1])){{$g5[1]}}@endif" l="4">@if(!empty($g5[1])){{$g5[1]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_2" data-id="@if(!empty($g5[2])){{$g5[2]}}@endif" l="4">@if(!empty($g5[2])){{$g5[2]}}@endif</td>
            </tr>
            <tr class="odd-bg g5">
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_3" data-id="@if(!empty($g5[3])){{$g5[3]}}@endif" l="4">@if(!empty($g5[3])){{$g5[3]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_4" data-id="@if(!empty($g5[4])){{$g5[4]}}@endif" l="4">@if(!empty($g5[4])){{$g5[4]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_5" data-id="@if(!empty($g5[5])){{$g5[5]}}@endif" l="4">@if(!empty($g5[5])){{$g5[5]}}@endif</td>
            </tr>
            <tr>
                <td colspan="3" class="fw-medium g6">G6</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_6_item_0" data-id="@if(!empty($g6[0])){{$g6[0]}}@endif" l="3">@if(!empty($g6[0])){{$g6[0]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_6_item_1" data-id="@if(!empty($g6[1])){{$g6[1]}}@endif" l="3">@if(!empty($g6[1])){{$g6[1]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_6_item_2" data-id="@if(!empty($g6[2])){{$g6[2]}}@endif" l="3">@if(!empty($g6[2])){{$g6[2]}}@endif</td>
            </tr>
            <tr class="odd-bg g7">
                <td colspan="3" class="fw-medium">G7</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_7_item_0" data-id="@if(!empty($g7[0])){{$g7[0]}}@endif">@if(!empty($g7[0])){{$g7[0]}}@endif</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_7_item_1" data-id="@if(!empty($g7[1])){{$g7[1]}}@endif" l="2">@if(!empty($g7[1])){{$g7[1]}}@endif</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_7_item_2" data-id="@if(!empty($g7[2])){{$g7[2]}}@endif" l="2">@if(!empty($g7[2])){{$g7[2]}}@endif</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_7_item_3" data-id="@if(!empty($g7[3])){{$g7[3]}}@endif" l="2">@if(!empty($g7[3])){{$g7[3]}}@endif</td>
            </tr>
            </tbody>
        </table>
        <div class="digital-num">
            <label class="radio-button-container" disabled="disabled" data-val="0">Tất cả <input type="radio" checked="checked" name="radio_{{$xsmb->id}}">
                <span class="checkmark"></span>
            </label>
            <label class="radio-button-container" data-val="2">2 Số cuối <input type="radio" name="radio_{{$xsmb->id}}">
                <span class="checkmark"></span>
            </label>
            <label class="radio-button-container" data-val="3">3 Số cuối <input type="radio" name="radio_{{$xsmb->id}}">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
    <div class="thongke-dauduoi bg-white rd shadow">
        <div class="tk-dau-duoi" id="livebangkqlotomb">
            <table class="tbl-fixed">
                <tbody>
                <tr>
                    <th colspan="3" class="p-0 fw-medium">Đầu</th>
                    <th colspan="10" class="p-0 fw-medium">Lô tô</th>
                    <th colspan="3" class="p-0 fw-medium">Đuôi</th>
                    <th colspan="10" class="p-0 fw-medium">Lô tô</th>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">0</td>
                    <td colspan="10" class="dd-kq mb_dau_0">{!! $xsmbDau[0] !!}</td>
                    <td colspan="3" class="text-center">0</td>
                    <td colspan="10" class="dd-kq mb_duoi_0">{!! $xsmbDuoi[0] !!}</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">1</td>
                    <td colspan="10" class="dd-kq mb_dau_1">{!! $xsmbDau[1] !!}</td>
                    <td colspan="3" class="text-center">1</td>
                    <td colspan="10" class="dd-kq mb_duoi_1">{!! $xsmbDuoi[1] !!}</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">2</td>
                    <td colspan="10" class="dd-kq mb_dau_2">{!! $xsmbDau[2] !!}
                    </td>
                    <td colspan="3" class="text-center">2</td>
                    <td colspan="10" class="dd-kq mb_duoi_2">{!! $xsmbDuoi[2] !!}</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">3</td>
                    <td colspan="10" class="dd-kq mb_dau_3">{!! $xsmbDau[3] !!}</td>
                    <td colspan="3" class="text-center">3</td>
                    <td colspan="10" class="dd-kq mb_duoi_3">{!! $xsmbDuoi[3] !!}</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">4</td>
                    <td colspan="10" class="dd-kq mb_dau_4">{!! $xsmbDau[4] !!}</td>
                    <td colspan="3" class="text-center">4</td>
                    <td colspan="10" class="dd-kq mb_duoi_4">{!! $xsmbDuoi[4] !!}</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">5</td>
                    <td colspan="10" class="dd-kq mb_dau_5">{!! $xsmbDau[5] !!}</td>
                    <td colspan="3" class="text-center">5</td>
                    <td colspan="10" class="dd-kq mb_duoi_5">{!! $xsmbDuoi[5] !!}</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">6</td>
                    <td colspan="10" class="dd-kq mb_dau_6">{!! $xsmbDau[6] !!}</td>
                    <td colspan="3" class="text-center">6</td>
                    <td colspan="10" class="dd-kq mb_duoi_6">{!! $xsmbDuoi[6] !!}</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">7</td>
                    <td colspan="10" class="dd-kq mb_dau_7">{!! $xsmbDau[7] !!}</td>
                    <td colspan="3" class="text-center">7</td>
                    <td colspan="10" class="dd-kq mb_duoi_7">{!! $xsmbDuoi[7] !!}</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">8</td>
                    <td colspan="10" class="dd-kq mb_dau_8">{!! $xsmbDau[8] !!}</td>
                    <td colspan="3" class="text-center">8</td>
                    <td colspan="10" class="dd-kq mb_duoi_8">{!! $xsmbDuoi[8] !!}</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">9</td>
                    <td colspan="10" class="dd-kq mb_dau_9">{!! $xsmbDau[9] !!}</td>
                    <td colspan="3" class="text-center">9</td>
                    <td colspan="10" class="dd-kq mb_duoi_9">{!! $xsmbDuoi[9] !!}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


    <script src="{{url('frontend/emb/js/lotteryLive.js')}}?v={{rand(1000,100000)}}"></script>
    <script type="text/javascript">

        var d = new Date();

        var utc = d.getTime() + (d.getTimezoneOffset() * 60000);

        var currentdate = new Date(utc + (3600000 * +7));



        var rootPath = '';

        var appKey = '';

        var headingTag = 'h1';

        var interval;

        var timeInter = 1357 * 8;

        //        var currentdate = new Date();

        var hours = currentdate.getHours();

        var minute = currentdate.getMinutes();

        try {

//            if ((hours == 18) && minute >= 10 && minute <= 40) {

            LiveMB(appKey, rootPath, headingTag);

            interval = setInterval("LiveMB('" + appKey + "', '" + rootPath + "', '" + headingTag + "')", timeInter);

            intervalVariable = setInterval('getRandomTextMB()', 100);

//            }

        } catch (e) {

            console.log(e.message);

        }

    </script>

<script>
    $("a").click(function(ev) {
        ev.preventDefault();
        window.open($(this).attr('href'),'_blank');
    });
</script>
</body>
</html>