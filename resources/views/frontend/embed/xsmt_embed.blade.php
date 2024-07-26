<!DOCTYPE html>
<html lang="vi-VN">
@php
$xsmtTinh = $xsmts[0];
$count = count($xsmts);
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title>Mã nhúng</title>
    @if(empty($date))
        <link rel='canonical' href="{{route('xsmt')}}"/>
        <link rel="alternate" href="{{route('xsmt')}}" hreflang="vi-vn">
        <link rel="alternate" href="{{route('xsmt')}}" hreflang="x-default">
    @else
        <link rel="canonical" href="{{route('xsmt.date',$ngay)}}">
        <link rel="alternate" href="{{route('xsmt.date',$ngay)}}" hreflang="vi-vn">
        <link rel="alternate" href="{{route('xsmt.date',$ngay)}}" hreflang="x-default">
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
$xsmtTinh = $xsmts[0];
$count = count($xsmts);
@endphp
<div class="rd bg-white" @if(empty($ngay)) id='mt_kqngay_{{date('dmY',time())}}' onclick="window.open('{{route('xsmt')}}','_blank');return;" @else id='mt_kqngay_{{getNgayID($xsmtTinh->date)}}' onclick="window.open('{{route('xsmt.date',$ngay)}}','_blank');return;" @endif>
    <div class="kqsx-old-mn">
        <div class="kqsx-tinh kqsx mb">
            <table class="tbl-kqsx text-center">
                <tbody>
                <tr>
                    <th @if($count==3) colspan="27" @else colspan="19" @endif>
                        <h2 class="h-kqsx" id="mnLiveTitle">XSMT - Kết quả xổ số Miền Trung</h2>

                        <h3 class="breadcrumb-link" id="tnListLink">
                            <a href="{{route('xsmt')}}">XSMT</a> / <a href="{{route(getRouteDay($xsmtTinh->day,'xsmt'))}}">XSMT {{getThu($xsmtTinh->day)}}</a> / <a
                                    href="{{route('xsmt.date',getNgayLink($xsmtTinh->date))}}">XSMT {{getNgay($xsmtTinh->date)}}</a>
                        </h3>
                    </th>
                </tr>
                <tr class="odd-bg">
                    <th colspan="3" class="color-sub-brand txt-content fw-medium p-0">Tỉnh</th>
                    @foreach ($xsmts as $xsmt)
                        <th colspan="8" class="color-sub-brand txt-content fw-medium">
                            <a href="{{route('xstinh.tinh',$xsmt->province->slug)}}">{{$xsmt->province->name}}</a>
                        </th>
                    @endforeach
                </tr>
                <tr>
                    <td colspan="3" class="" data-id="G8">G8</td>
                    @foreach ($xsmts as $xsmt)
                        <td l="2" colspan="8" class="txt-normal-prize txt-giai"  id="{{strtoupper($xsmt->province->short_name)}}_prize_8_item_0" data-id="{{$xsmt->g8}}">{{$xsmt->g8}}</td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="" data-id="G7">G7</td>
                    @foreach ($xsmts as $xsmt)
                        <td l="3" colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmt->province->short_name)}}_prize_7_item_0" data-id="{{$xsmt->g7}}">{{$xsmt->g7}}</td>
                    @endforeach
                </tr>
                @for($i=0;$i<3;$i++)
                    <tr>
                        @if($i==0) <td colspan="3" rowspan="3" class="" data-id="G6">G6</td> @endif
                        @foreach ($xsmts as $xsmt)
                            <?php $g6 = explode('-', $xsmt->g6) ?>
                            <td colspan="8" l="4" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmt->province->short_name)}}_prize_6_item_{{$i}}" data-id="@if(!empty($g6[$i])){{$g6[$i]}}@endif">@if(!empty($g6[$i])){{$g6[$i]}}@endif</td>
                        @endforeach
                    </tr>
                @endfor
                <tr class="odd-bg">
                    <td colspan="3" class="" data-id="G5">G5</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" l="4" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmt->province->short_name)}}_prize_5_item_0" data-id="{{$xsmt->g5}}">{{$xsmt->g5}}</td>
                    @endforeach
                </tr>
                @for($i=0;$i<7;$i++)
                    <tr>
                        @if($i==0) <td colspan="3" rowspan="7" class="" data-id="G4">G4</td> @endif
                        @foreach ($xsmts as $xsmt)
                            <?php $g4 = explode('-', $xsmt->g4) ?>
                            <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmt->province->short_name)}}_prize_4_item_{{$i}}" data-id="@if(!empty($g4[$i])){{$g4[$i]}}@endif">@if(!empty($g4[$i])){{$g4[$i]}}@endif</td>
                        @endforeach
                    </tr>
                @endfor

                @for($i=0;$i<2;$i++)
                    <tr class="odd-bg">
                        @if($i==0) <td colspan="3" rowspan="2" class="" data-id="G3">G3</td> @endif
                        @foreach ($xsmts as $xsmt)
                            <?php $g3 = explode('-', $xsmt->g3) ?>
                            <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmt->province->short_name)}}_prize_3_item_{{$i}}" data-id="@if(!empty($g3[$i])){{$g3[$i]}}@endif">@if(!empty($g3[$i])){{$g3[$i]}}@endif</td>
                        @endforeach
                    </tr>
                @endfor
                <tr>
                    <td colspan="3" class="" data-id="G2">G2</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xsmt->province->short_name)}}_prize_2_item_0" data-id="{{$xsmt->g2}}">{{$xsmt->g2}}</td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="" data-id="G1">G1</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" class="txt-normal-prize txt-giai"  id="{{strtoupper($xsmt->province->short_name)}}_prize_1_item_0" data-id="{{$xsmt->g1}}">{{$xsmt->g1}}</td>
                    @endforeach
                </tr>
                <tr>
                    <td colspan="3" class="txt-special-prize" data-id="ĐB">ĐB</td>
                    @foreach ($xsmts as $xsmt)
                        <td l="6" colspan="8" class="txt-special-prize txt-giai" id="{{strtoupper($xsmt->province->short_name)}}_prize_Db_item_0" data-id="{{$xsmt->gdb}}">{{$xsmt->gdb}}</td>
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

        @foreach ($xsmts as $xsmt)
            <?php
            $xsmtStr = $xsmt->gdb . '-' . $xsmt->g1 . '-' . $xsmt->g2 . '-' . $xsmt->g3 . '-' . $xsmt->g4 . '-' . $xsmt->g5 . '-' . $xsmt->g6 . '-' . $xsmt->g7 . '-' . $xsmt->g8;
            $xsmtLoto = getLoto($xsmtStr);
            $xsmtDau[$xsmt->province->short_name] = getDau($xsmtLoto, substr($xsmt->gdb, strlen($xsmt->gdb) - 2, 2));
            ?>
        @endforeach
        <div class="sec-tkmiennam rd shadow">
            <table class="tbl-thongkemn">
                <tbody>
                <tr class="text-center">
                    <th colspan="3" class="fw-medium">Đầu</th>
                    @foreach ($xsmts as $xsmt)
                        <th colspan="8" class="fw-medium"  id="livebangkqloto_{{strtoupper($xsmt->province->short_name)}}"><a href="{{route('xstinh.tinh',$xsmt->province->slug)}}">{{$xsmt->province->name}}</a></th>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">0</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" id="mtloto_{{strtoupper($xsmt->province->short_name)}}_0">
                            {!! $xsmtDau[$xsmt->province->short_name][0] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">1</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" id="mtloto_{{strtoupper($xsmt->province->short_name)}}_1">
                            {!! $xsmtDau[$xsmt->province->short_name][1] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">2</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" id="mtloto_{{strtoupper($xsmt->province->short_name)}}_2">
                            {!! $xsmtDau[$xsmt->province->short_name][2] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">3</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" id="mtloto_{{strtoupper($xsmt->province->short_name)}}_3">
                            {!! $xsmtDau[$xsmt->province->short_name][3] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">4</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" id="mtloto_{{strtoupper($xsmt->province->short_name)}}_4">
                            {!! $xsmtDau[$xsmt->province->short_name][4] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">5</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" id="mtloto_{{strtoupper($xsmt->province->short_name)}}_5">
                            {!! $xsmtDau[$xsmt->province->short_name][5] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">6</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" id="mtloto_{{strtoupper($xsmt->province->short_name)}}_6">
                            {!! $xsmtDau[$xsmt->province->short_name][6] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">7</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" id="mtloto_{{strtoupper($xsmt->province->short_name)}}_7">
                            {!! $xsmtDau[$xsmt->province->short_name][7] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">8</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" id="mtloto_{{strtoupper($xsmt->province->short_name)}}_8">
                            {!! $xsmtDau[$xsmt->province->short_name][8] !!}
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">9</td>
                    @foreach ($xsmts as $xsmt)
                        <td colspan="8" id="mtloto_{{strtoupper($xsmt->province->short_name)}}_9">
                            {!! $xsmtDau[$xsmt->province->short_name][9] !!}
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

        var groupId = 3;

        var headingTag = 'h1';

        var interval;

        var timeInter = 1357 * 8; //thoi gian refresh

        LiveMT(groupId, appKey, rootPath, headingTag);

        interval = setInterval("LiveMT(" + groupId + ", '" + appKey + "', '" + rootPath + "', '" + headingTag + "')", timeInter);

        intervalVariable = setInterval('getRandomTextTN()', 100);

    </script>
<script>
    $("a").click(function(ev) {
        ev.preventDefault();
        window.open($(this).attr('href'),'_blank');
    });
</script>
</body>
</html>