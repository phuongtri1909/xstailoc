<!DOCTYPE html>
<html lang="vi-VN">
@php
$xsmnTinh = $xsmns[0];
$count = count($xsmns);
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title>Mã nhúng</title>
    @if(empty($date))
        <link rel='canonical' href="{{route('xsmn')}}"/>
        <link rel="alternate" href="{{route('xsmn')}}" hreflang="vi-vn">
        <link rel="alternate" href="{{route('xsmn')}}" hreflang="x-default">
    @else
        <link rel="canonical" href="{{route('xsmn.date',$ngay)}}">
        <link rel="alternate" href="{{route('xsmn.date',$ngay)}}" hreflang="vi-vn">
        <link rel="alternate" href="{{route('xsmn.date',$ngay)}}" hreflang="x-default">
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="{{url('frontend/emb/css/style.css')}}?v={{rand(1000,100000)}}" media="all">
    <link rel="stylesheet" href="{{url('frontend/emb/css/main.css')}}?v={{rand(1000,100000)}}" media="all">
    <script src="{{url('frontend/emb/js/jquery.min.js')}}"></script>
    <script src="{{url('frontend/emb/js/theme_emb.js')}}?v={{rand(1000,100000)}}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap"
          rel="stylesheet">
</head>
<body>
@php
$xsmnTinh = $xsmns[0];
$count = count($xsmns);
@endphp
<div class="rd bg-white" @if(empty($ngay)) id='mn_kqngay_{{date('dmY',time())}}' onclick="window.open('{{route('xsmn')}}','_blank');return;" @else id='mn_kqngay_{{getNgayID($xsmnTinh->date)}}' onclick="window.open('{{route('xsmn.date',$ngay)}}','_blank');return;" @endif>
    <div class="kqsx-old-mn">
        <div class="kqsx-tinh kqsx mb">
            <table class="tbl-kqsx text-center">
                <tbody>
                <tr>
                    <th @if($count==4) colspan="35" @else colspan="27" @endif>
                        <h2 class="h-kqsx" id="mnLiveTitle">XSMN - Kết quả xổ số Miền Nam</h2>

                        <h3 class="breadcrumb-link" id="tnListLink">
                            <a href="{{route('xsmn')}}">XSMN</a> / <a href="{{route(getRouteDay($xsmnTinh->day,'xsmn'))}}">XSMN {{getThu($xsmnTinh->day)}}</a> / <a
                                    href="{{route('xsmn.date',getNgayLink($xsmnTinh->date))}}">XSMN {{getNgay($xsmnTinh->date)}}</a>
                        </h3>
                    </th>
                </tr>
                <tr class="odd-bg">
                    <th colspan="3" class="color-sub-brand txt-content fw-medium p-0">Tỉnh</th>
                    @foreach ($xsmns as $xsmn)
                        <th colspan="8" class="color-sub-brand txt-content fw-medium">
                            <a href="{{route('xstinh.tinh',$xsmn->province->slug)}}">{{$xsmn->province->name}}</a>
                        </th>
                    @endforeach
                </tr>
                <tr>
                    <td colspan="3" class="" data-id="G8">G8</td>
                    @foreach ($xsmns as $xsmn)
                        <td l="2" colspan="8" class="txt-normal-prize txt-giai"  id="{{strtoupper($xsmn->province->short_name)}}_prize_8_item_0" data-id="{{$xsmn->g8}}">{{$xsmn->g8}}</td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="" data-id="G7">G7</td>
                    @foreach ($xsmns as $xsmn)
                        <td l="3" colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmn->province->short_name)}}_prize_7_item_0" data-id="{{$xsmn->g7}}">{{$xsmn->g7}}</td>
                    @endforeach
                </tr>
                @for($i=0;$i<3;$i++)
                    <tr>
                        @if($i==0) <td colspan="3" rowspan="3" class="" data-id="G6">G6</td> @endif
                        @foreach ($xsmns as $xsmn)
                            <?php $g6 = explode('-', $xsmn->g6) ?>
                            <td colspan="8" l="4" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmn->province->short_name)}}_prize_6_item_{{$i}}" data-id="@if(!empty($g6[$i])){{$g6[$i]}}@endif">@if(!empty($g6[$i])){{$g6[$i]}}@endif</td>
                        @endforeach
                    </tr>
                @endfor
                <tr class="odd-bg">
                    <td colspan="3" class="" data-id="G5">G5</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" l="4" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmn->province->short_name)}}_prize_5_item_0" data-id="{{$xsmn->g5}}">{{$xsmn->g5}}</td>
                    @endforeach
                </tr>
                @for($i=0;$i<7;$i++)
                    <tr>
                        @if($i==0) <td colspan="3" rowspan="7" class="" data-id="G4">G4</td> @endif
                        @foreach ($xsmns as $xsmn)
                            <?php $g4 = explode('-', $xsmn->g4) ?>
                            <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmn->province->short_name)}}_prize_4_item_{{$i}}" data-id="@if(!empty($g4[$i])){{$g4[$i]}}@endif">@if(!empty($g4[$i])){{$g4[$i]}}@endif</td>
                        @endforeach
                    </tr>
                @endfor

                @for($i=0;$i<2;$i++)
                    <tr class="odd-bg">
                        @if($i==0) <td colspan="3" rowspan="2" class="" data-id="G3">G3</td> @endif
                        @foreach ($xsmns as $xsmn)
                            <?php $g3 = explode('-', $xsmn->g3) ?>
                            <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmn->province->short_name)}}_prize_3_item_{{$i}}" data-id="@if(!empty($g3[$i])){{$g3[$i]}}@endif">@if(!empty($g3[$i])){{$g3[$i]}}@endif</td>
                        @endforeach
                    </tr>
                @endfor
                <tr>
                    <td colspan="3" class="" data-id="G2">G2</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmn->province->short_name)}}_prize_2_item_0" data-id="{{$xsmn->g2}}">{{$xsmn->g2}}</td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="" data-id="G1">G1</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" class="txt-normal-prize txt-giai"  id="{{strtoupper($xsmn->province->short_name)}}_prize_1_item_0" data-id="{{$xsmn->g1}}">{{$xsmn->g1}}</td>
                    @endforeach
                </tr>
                <tr>
                    <td colspan="3" class="txt-special-prize" data-id="ĐB">ĐB</td>
                    @foreach ($xsmns as $xsmn)
                        <td l="6" colspan="8" class="txt-special-prize txt-giai" id="{{strtoupper($xsmn->province->short_name)}}_prize_Db_item_0" data-id="{{$xsmn->gdb}}">{{$xsmn->gdb}}</td>
                    @endforeach
                </tr>
                </tbody>
            </table>
            <div class="digital-num">
                <label class="radio-button-container" disabled="disabled" data-val="0">Tất cả <input
                            type="radio" checked="checked" name="radio_1">
                    <span class="checkmark"></span>
                </label>
                <label class="radio-button-container" data-val="2">2 Số cuối <input type="radio" name="radio_1">
                    <span class="checkmark"></span>
                </label>
                <label class="radio-button-container" data-val="3">3 Số cuối <input type="radio" name="radio_1">
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>

        @foreach ($xsmns as $xsmn)
            <?php
            $xsmnStr = $xsmn->gdb . '-' . $xsmn->g1 . '-' . $xsmn->g2 . '-' . $xsmn->g3 . '-' . $xsmn->g4 . '-' . $xsmn->g5 . '-' . $xsmn->g6 . '-' . $xsmn->g7 . '-' . $xsmn->g8;
            $xsmnLoto = getLoto($xsmnStr);
            $xsmnDau[$xsmn->province->short_name] = getDau($xsmnLoto, substr($xsmn->gdb, strlen($xsmn->gdb) - 2, 2));
            ?>
        @endforeach
        <div class="sec-tkmiennam rd shadow">
            <table class="tbl-thongkemn">
                <tbody>
                <tr class="text-center">
                    <th colspan="3" class="fw-medium">Đầu</th>
                    @foreach ($xsmns as $xsmn)
                        <th colspan="8" class="fw-medium"  id="livebangkqloto_{{strtoupper($xsmn->province->short_name)}}"><a href="{{route('xstinh.tinh',$xsmn->province->slug)}}">{{$xsmn->province->name}}</a></th>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">0</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" id="mnloto_{{strtoupper($xsmn->province->short_name)}}_0">
                            {!! $xsmnDau[$xsmn->province->short_name][0] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">1</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" id="mnloto_{{strtoupper($xsmn->province->short_name)}}_1">
                            {!! $xsmnDau[$xsmn->province->short_name][1] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">2</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" id="mnloto_{{strtoupper($xsmn->province->short_name)}}_2">
                            {!! $xsmnDau[$xsmn->province->short_name][2] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">3</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" id="mnloto_{{strtoupper($xsmn->province->short_name)}}_3">
                            {!! $xsmnDau[$xsmn->province->short_name][3] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">4</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" id="mnloto_{{strtoupper($xsmn->province->short_name)}}_4">
                            {!! $xsmnDau[$xsmn->province->short_name][4] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">5</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" id="mnloto_{{strtoupper($xsmn->province->short_name)}}_5">
                            {!! $xsmnDau[$xsmn->province->short_name][5] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">6</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" id="mnloto_{{strtoupper($xsmn->province->short_name)}}_6">
                            {!! $xsmnDau[$xsmn->province->short_name][6] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">7</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" id="mnloto_{{strtoupper($xsmn->province->short_name)}}_7">
                            {!! $xsmnDau[$xsmn->province->short_name][7] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">8</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" id="mnloto_{{strtoupper($xsmn->province->short_name)}}_8">
                            {!! $xsmnDau[$xsmn->province->short_name][8] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">9</td>
                    @foreach ($xsmns as $xsmn)
                        <td colspan="8" id="mnloto_{{strtoupper($xsmn->province->short_name)}}_9">
                            {!! $xsmnDau[$xsmn->province->short_name][9] !!}
                        </td>
                    @endforeach
                </tr>
                </tbody>
            </table> 
        </div>
    </div>
</div>
    <script src="{{url('frontend/emb/js/lotteryLive.js')}}?v={{rand(1000,100000)}}"></script>
    <script type="text/javascript">

        var rootPath = '';

        var appKey = '';

        var groupId = 2;

        var headingTag = 'h1';

        var interval;

        var timeInter = 1357 * 8; //thoi gian refresh

        LiveMN(groupId, appKey, rootPath, headingTag);

        interval = setInterval("LiveMN(" + groupId + ", '" + appKey + "', '" + rootPath + "', '" + headingTag + "')", timeInter);

        intervalVariable = setInterval('getRandomTextTN()', 100);

    </script>
<script>
    $("a").click(function (ev) {
        ev.preventDefault();
        window.open($(this).attr('href'), '_blank');
    });
</script>
</body>
</html>