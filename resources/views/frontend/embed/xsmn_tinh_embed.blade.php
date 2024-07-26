<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title>Mã nhúng</title>
    @if(empty($date))
        <link rel='canonical' href="{{route('xstinh.tinh',$province->slug)}}"/>
        <link rel="alternate" href="{{route('xstinh.tinh',$province->slug)}}" hreflang="vi-vn">
        <link rel="alternate" href="{{route('xstinh.tinh',$province->slug)}}" hreflang="x-default">
    @else
        <link rel="canonical" href="{{route('xstinh.date',[$province->short_name,$date])}}">
        <link rel="alternate" href="{{route('xstinh.date',[$province->short_name,$date])}}" hreflang="vi-vn">
        <link rel="alternate" href="{{route('xstinh.date',[$province->short_name,$date])}}" hreflang="x-default">
    @endif
    <meta name="robots" content="index, follow">
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
<?php
$gdb = $xs->gdb;
$g1 = $xs->g1;
$g2 = explode('-', $xs->g2);
$g3 = explode('-', $xs->g3);
$g4 = explode('-', $xs->g4);
$g5 = explode('-', $xs->g5);
$g6 = explode('-', $xs->g6);
$g7 = explode('-', $xs->g7);
$g8 = explode('-', $xs->g8);

$xsStr = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
$xsLoto = getLoto($xsStr);
$xsDau = getDau($xsLoto, substr($xs->gdb, strlen($xs->gdb) - 2, 2));
$xsDuoi = getDuoi($xsLoto, substr($xs->gdb, strlen($xs->gdb) - 2, 2));
?>
<div class="box bg-white rd shadow" @if(empty($date)) id='kqngay_{{date('dmY',time())}}' onclick="window.open('{{route('xstinh.tinh',$province->slug)}}','_blank');return;" @else id='kqngay_{{getNgayID($xs->date)}}' onclick="window.open('{{route('xstinh.date',[$province->short_name,$date])}}','_blank');return;" @endif>
    <div class="kqmb shadow kqsx mb">
        <table class="table-kqsx">
            <thead>
            <tr>
                <th colspan="27" class="header-kqsx">
                    <h2 class="h-kqsx"  id="provinceLiveTitle">XS{{strtoupper($xs->province->short_name)}} - Kết quả Xổ số {{$xs->province->name}} - SX{{strtoupper($xs->province->short_name)}} hôm nay</h2>
                    <h3 class="breadcrumb-link">
                        <a href="{{route('xsmn')}}">XSMN</a> /
                        <a href="{{route(getRouteDay($xs->day,'xsmn'))}}">XSMN {{getThu($xs->day)}}</a> /
                        <a href="{{route('xsmn.date',getNgayLink($xs->date))}}">XSMN {{getNgay($xs->date)}}</a>
                    </h3>
                </th>
            </tr>
            <tr>
                <td colspan="27" class="txt-db">
                    <h3 class="df-title">
                        <a title="XS{{strtoupper($xs->province->short_name)}}"
                           href="{{route('xstinh.tinh',$xs->province->slug)}}">XS{{strtoupper($xs->province->short_name)}}</a> {{getThu($xs->day)}} /

                        <a title="XS{{strtoupper($xs->province->short_name)}} {{getNgay($xs->date)}}"
                           href="{{route('xstinh.date',[$xs->province->short_name,getNgayLink($xs->date)])}}">XS{{strtoupper($xs->province->short_name)}} {{getNgay($xs->date)}}</a>
                    </h3>
                </td>
            </tr>
            </thead>
            <tbody>
            <tr class="db">
                <td colspan="3" class="color-highlight font-20">G8</td>
                <td colspan="24" class="txt-special-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_8_item_0" data-id="@if(!empty($g8[0])){{$g8[0]}}@endif">@if(!empty($g8[0])){{$g8[0]}}@endif</td>
            </tr>
            <tr class="odd-bg">
                <td colspan="3" class="fw-medium">G7</td>
                <td colspan="24" class="txt-normal-prize txt-giai txt-giai"  id="{{strtoupper($xs->province->short_name)}}_prize_7_item_0" data-id="@if(!empty($g7[0])){{$g7[0]}}@endif">@if(!empty($g7[0])){{$g7[0]}}@endif</td>
            </tr>
            <tr>
                <td colspan="3" class="fw-medium g6">G6</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_6_item_0" data-id="@if(!empty($g6[0])){{$g6[0]}}@endif" l="3">@if(!empty($g6[0])){{$g6[0]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_6_item_1" data-id="@if(!empty($g6[1])){{$g6[1]}}@endif" l="3">@if(!empty($g6[1])){{$g6[1]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_6_item_2" data-id="@if(!empty($g6[2])){{$g6[2]}}@endif" l="3">@if(!empty($g6[2])){{$g6[2]}}@endif</td>
            </tr>
            <tr class="odd-bg">
                <td colspan="3" class="fw-medium">G5</td>
                <td colspan="24" class="txt-normal-prize txt-giai txt-giai"  id="{{strtoupper($xs->province->short_name)}}_prize_5_item_0" data-id="@if(!empty($g5[0])){{$g5[0]}}@endif">@if(!empty($g5[0])){{$g5[0]}}@endif</td>
            </tr>
            <tr>
                <td colspan="3" rowspan="2" class="fw-medium">G4</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_4_item_0" data-id="@if(!empty($g4[0])){{$g4[0]}}@endif" l="4">@if(!empty($g4[0])){{$g4[0]}}@endif</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_4_item_1" data-id="@if(!empty($g4[1])){{$g4[1]}}@endif" l="4">@if(!empty($g4[1])){{$g4[1]}}@endif</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_4_item_2" data-id="@if(!empty($g4[2])){{$g4[2]}}@endif" l="4">@if(!empty($g4[2])){{$g4[2]}}@endif</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_4_item_3" data-id="@if(!empty($g4[3])){{$g4[3]}}@endif" l="4">@if(!empty($g4[3])){{$g4[3]}}@endif</td>
            </tr>
            <tr>
                <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_4_item_4" data-id="@if(!empty($g4[4])){{$g4[4]}}@endif">@if(!empty($g4[4])){{$g4[4]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_4_item_5" data-id="@if(!empty($g4[5])){{$g4[5]}}@endif">@if(!empty($g4[5])){{$g4[5]}}@endif</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_4_item_6" data-id="@if(!empty($g4[6])){{$g4[6]}}@endif">@if(!empty($g4[6])){{$g4[6]}}@endif</td>
            </tr>
            <tr class="odd-bg">
                <td colspan="3" class="fw-medium g2">G3</td>
                <td colspan="12" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_3_item_0" data-id="@if(!empty($g3[0])){{$g3[0]}}@endif">@if(!empty($g3[0])){{$g3[0]}}@endif</td>
                <td colspan="12" class="txt-normal-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_3_item_1" data-id="@if(!empty($g3[1])){{$g3[1]}}@endif">@if(!empty($g3[1])){{$g3[1]}}@endif</td>
            </tr>
            <tr>
                <td colspan="3" class="fw-medium">G2</td>
                <td colspan="24" class="txt-normal-prize txt-giai txt-giai"  id="{{strtoupper($xs->province->short_name)}}_prize_2_item_0" data-id="@if(!empty($g2[0])){{$g2[0]}}@endif">@if(!empty($g2[0])){{$g2[0]}}@endif</td>
            </tr>
            <tr class="odd-bg">
                <td colspan="3" class="fw-medium">G1</td>
                <td colspan="24" class="txt-normal-prize txt-giai txt-giai"  id="{{strtoupper($xs->province->short_name)}}_prize_1_item_0" data-id="@if(!empty($g1)){{$g1}}@endif">@if(!empty($g1)){{$g1}}@endif</td>
            </tr>
            <tr class="db">
                <td colspan="3" class="color-highlight font-20">ĐB</td>
                <td colspan="24" class="txt-special-prize txt-giai" id="{{strtoupper($xs->province->short_name)}}_prize_db_item_0" data-id="@if(!empty($gdb)){{$gdb}}@endif">@if(!empty($gdb)){{$gdb}}@endif</td>
            </tr>
            </tbody>
        </table>
        <div class="digital-num">
            <label class="radio-button-container" disabled="disabled" data-val="0">Tất cả <input type="radio" checked="checked" name="radio_1">
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
    <div class="thongke-dauduoi bg-white rd shadow">
        <div class="soketqua mb">
            <span>Sổ kết quả</span>
            <a href="{{route('xsmn.skq')}}">30</a>
            <a href="{{route('xsmn.ngay',60)}}">60</a>
            <a href="{{route('xsmn.ngay',90)}}">90</a>
            <a href="{{route('xsmn.ngay',100)}}">100</a>
            <a href="{{route('xsmn.ngay',200)}}">200</a>
        </div>
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
                    <td colspan="10" class="dd-kq mb_dau_0" id="loto_{{strtoupper($xs->province->short_name)}}_0">{!! $xsDau[0] !!}</td>
                    <td colspan="3" class="text-center">0</td>
                    <td colspan="10" class="dd-kq mb_duoi_0" id="loto_{{strtoupper($xs->province->short_name)}}_d0">{!! $xsDuoi[0] !!}</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">1</td>
                    <td colspan="10" class="dd-kq mb_dau_1" id="loto_{{strtoupper($xs->province->short_name)}}_1">{!! $xsDau[1] !!}</td>
                    <td colspan="3" class="text-center">1</td>
                    <td colspan="10" class="dd-kq mb_duoi_1" id="loto_{{strtoupper($xs->province->short_name)}}_d1">{!! $xsDuoi[1] !!}</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">2</td>
                    <td colspan="10" class="dd-kq mb_dau_2" id="loto_{{strtoupper($xs->province->short_name)}}_2">{!! $xsDau[2] !!}
                    </td>
                    <td colspan="3" class="text-center">2</td>
                    <td colspan="10" class="dd-kq mb_duoi_2" id="loto_{{strtoupper($xs->province->short_name)}}_d2">{!! $xsDuoi[2] !!}</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">3</td>
                    <td colspan="10" class="dd-kq mb_dau_3" id="loto_{{strtoupper($xs->province->short_name)}}_3">{!! $xsDau[3] !!}</td>
                    <td colspan="3" class="text-center">3</td>
                    <td colspan="10" class="dd-kq mb_duoi_3" id="loto_{{strtoupper($xs->province->short_name)}}_d3">{!! $xsDuoi[3] !!}</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">4</td>
                    <td colspan="10" class="dd-kq mb_dau_4" id="loto_{{strtoupper($xs->province->short_name)}}_4">{!! $xsDau[4] !!}</td>
                    <td colspan="3" class="text-center">4</td>
                    <td colspan="10" class="dd-kq mb_duoi_4" id="loto_{{strtoupper($xs->province->short_name)}}_d4">{!! $xsDuoi[4] !!}</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">5</td>
                    <td colspan="10" class="dd-kq mb_dau_5" id="loto_{{strtoupper($xs->province->short_name)}}_5">{!! $xsDau[5] !!}</td>
                    <td colspan="3" class="text-center">5</td>
                    <td colspan="10" class="dd-kq mb_duoi_5" id="loto_{{strtoupper($xs->province->short_name)}}_d5">{!! $xsDuoi[5] !!}</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">6</td>
                    <td colspan="10" class="dd-kq mb_dau_6" id="loto_{{strtoupper($xs->province->short_name)}}_6">{!! $xsDau[6] !!}</td>
                    <td colspan="3" class="text-center">6</td>
                    <td colspan="10" class="dd-kq mb_duoi_6" id="loto_{{strtoupper($xs->province->short_name)}}_d6">{!! $xsDuoi[6] !!}</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">7</td>
                    <td colspan="10" class="dd-kq mb_dau_7" id="loto_{{strtoupper($xs->province->short_name)}}_7">{!! $xsDau[7] !!}</td>
                    <td colspan="3" class="text-center">7</td>
                    <td colspan="10" class="dd-kq mb_duoi_7" id="loto_{{strtoupper($xs->province->short_name)}}_d7">{!! $xsDuoi[7] !!}</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">8</td>
                    <td colspan="10" class="dd-kq mb_dau_8" id="loto_{{strtoupper($xs->province->short_name)}}_8">{!! $xsDau[8] !!}</td>
                    <td colspan="3" class="text-center">8</td>
                    <td colspan="10" class="dd-kq mb_duoi_8" id="loto_{{strtoupper($xs->province->short_name)}}_d8">{!! $xsDuoi[8] !!}</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">9</td>
                    <td colspan="10" class="dd-kq mb_dau_9" id="loto_{{strtoupper($xs->province->short_name)}}_9">{!! $xsDau[9] !!}</td>
                    <td colspan="3" class="text-center">9</td>
                    <td colspan="10" class="dd-kq mb_duoi_9" id="loto_{{strtoupper($xs->province->short_name)}}_d9">{!! $xsDuoi[9] !!}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@php
$day = getThuNumber(date('Y-m-d', time()));
@endphp


    @if(strpos($province->ngay_quay,$day)!==false)
        <script src="{{url('frontend/emb/js/lotteryLive.js')}}?v={{rand(1000,100000)}}"></script>
        <script type="text/javascript">

            var rootPath = '';

            l_root = rootPath.split(";");

            if (root == null)

                root = l_root[0];

            var appKey = '';

            var groupId = 2;

            var lotId = {{$province->id}};

            var fromPageView = 'KQD';

            var headingTag = 'h1';

            var interval;

            var timeInter = 1357 * 8; //thoi gian refresh

            LiveProvince(groupId, lotId, appKey, root, headingTag);

            interval = setInterval("LiveProvince(" + groupId + ", " + lotId + ", '" + appKey + "', '" + root + "', '" + headingTag + "')", timeInter);

            intervalVariable = setInterval('getRandomTextProvince()', 100);

        </script>
    @endif

<script>
    $("a").click(function (ev) {
        ev.preventDefault();
        window.open($(this).attr('href'), '_blank');
    });
</script>
</body>
</html>