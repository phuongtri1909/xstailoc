<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title>Mã nhúng</title>
    <link rel="canonical" href="{{route('xstinh.date',[$province->short_name,getNgayLink($date)])}}"/>
    <link rel="alternate" href="{{route('xstinh.date',[$province->short_name,getNgayLink($date)])}}" hreflang="vi-vn">
    <link rel="alternate" href="{{route('xstinh.date',[$province->short_name,getNgayLink($date)])}}" hreflang="x-default">
    <meta name="robots" content="index, follow">
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
<div class="box bg-white rd shadow" id='kqngay_{{getNgayID($date)}}' onclick="window.open('{{route('xstinh.tinh',$province->slug)}}','_blank');return;">
    <div class="kqmb shadow kqsx mb">
        <table class="table-kqsx">
            <thead>
            <tr>
                <th colspan="27" class="header-kqsx">
                    <h2 class="h-kqsx">Kết quả Xổ số {{$province->name}} {{getNgay($date)}}</h2>
                    <h3 class="breadcrumb-link">
                        <a href="{{route('xsmb')}}">XSMB</a> /
                        <a href="{{route(getRouteDay(getThuNumber($date),'xsmb'))}}">XSMB {{getThu(getThuNumber($date))}}</a> /
                        <a href="{{route('xsmb.date',getNgayLink($date))}}">XSMB {{getNgay($date)}}</a>
                    </h3>
                </th>
            </tr>
            <tr>
                <td colspan="27" class="txt-db" id="mb_prizeCode_item"><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            </thead>
            <tbody>
            <tr class="db">
                <td colspan="3" class="color-highlight font-20">ĐB</td>
                <td colspan="24" class="txt-special-prize txt-giai" id="mb_prize_DB_item_0" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="odd-bg g1">
                <td colspan="3" class="fw-medium">G1</td>
                <td colspan="24" class="txt-normal-prize txt-giai txt-giai"  id="mb_prize_1_item_0" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr>
                <td colspan="3" class="fw-medium g2">G2</td>
                <td colspan="12" class="txt-normal-prize txt-giai" id="mb_prize_2_item_0" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="12" class="txt-normal-prize txt-giai" id="mb_prize_2_item_1" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="odd-bg g3">
                <td colspan="3" rowspan="2" class="fw-medium">G3</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_0" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_1" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_2" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="odd-bg">
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_3" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_4" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_3_item_5" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr>
                <td colspan="3" class="fw-medium">G4</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_4_item_0" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_4_item_1" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_4_item_2" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_4_item_3" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="odd-bg g5">
                <td colspan="3" rowspan="2" class="fw-medium">G5</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_0" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_1" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_2" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="odd-bg g5">
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_3" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_4" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_5_item_5" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr>
                <td colspan="3" class="fw-medium g6">G6</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_6_item_0" data-id="" l="3"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_6_item_1" data-id="" l="3"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="mb_prize_6_item_2" data-id="" l="3"><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="odd-bg g7">
                <td colspan="3" class="fw-medium">G7</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_7_item_0" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_7_item_1" data-id="" l="2"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_7_item_2" data-id="" l="2"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="mb_prize_7_item_3" data-id="" l="2"><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            </tbody>
        </table>
        <div class="digital-num">
            <label class="radio-button-container" disabled="disabled" data-val="0">Tất cả <input type="radio" checked="checked" name="radio">
                <span class="checkmark"></span>
            </label>
            <label class="radio-button-container" data-val="2">2 Số cuối <input type="radio" name="radio">
                <span class="checkmark"></span>
            </label>
            <label class="radio-button-container" data-val="3">3 Số cuối <input type="radio" name="radio">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>

    <div class="thongke-dauduoi bg-white rd shadow">
        <div class="tk-dau-duoi">
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
                    <td colspan="10" class="dd-kq mb_dau_0"><i class="fas fa-spinner fa-spin"></i></td>
                    <td colspan="3" class="text-center">0</td>
                    <td colspan="10" class="dd-kq mb_duoi_0"><i class="fas fa-spinner fa-spin"></i></td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">1</td>
                    <td colspan="10" class="dd-kq mb_dau_1"><i class="fas fa-spinner fa-spin"></i></td>
                    <td colspan="3" class="text-center">1</td>
                    <td colspan="10" class="dd-kq mb_duoi_1"><i class="fas fa-spinner fa-spin"></i></td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">2</td>
                    <td colspan="10" class="dd-kq mb_dau_2"><i class="fas fa-spinner fa-spin"></i>
                    </td>
                    <td colspan="3" class="text-center">2</td>
                    <td colspan="10" class="dd-kq mb_duoi_2"><i class="fas fa-spinner fa-spin"></i></td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">3</td>
                    <td colspan="10" class="dd-kq mb_dau_3"><i class="fas fa-spinner fa-spin"></i></td>
                    <td colspan="3" class="text-center">3</td>
                    <td colspan="10" class="dd-kq mb_duoi_3"><i class="fas fa-spinner fa-spin"></i></td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">4</td>
                    <td colspan="10" class="dd-kq mb_dau_4"><i class="fas fa-spinner fa-spin"></i></td>
                    <td colspan="3" class="text-center">4</td>
                    <td colspan="10" class="dd-kq mb_duoi_4"><i class="fas fa-spinner fa-spin"></i></td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">5</td>
                    <td colspan="10" class="dd-kq mb_dau_5"><i class="fas fa-spinner fa-spin"></i></td>
                    <td colspan="3" class="text-center">5</td>
                    <td colspan="10" class="dd-kq mb_duoi_5"><i class="fas fa-spinner fa-spin"></i></td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">6</td>
                    <td colspan="10" class="dd-kq mb_dau_6"><i class="fas fa-spinner fa-spin"></i></td>
                    <td colspan="3" class="text-center">6</td>
                    <td colspan="10" class="dd-kq mb_duoi_6"><i class="fas fa-spinner fa-spin"></i></td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">7</td>
                    <td colspan="10" class="dd-kq mb_dau_7"><i class="fas fa-spinner fa-spin"></i></td>
                    <td colspan="3" class="text-center">7</td>
                    <td colspan="10" class="dd-kq mb_duoi_7"><i class="fas fa-spinner fa-spin"></i></td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">8</td>
                    <td colspan="10" class="dd-kq mb_dau_8"><i class="fas fa-spinner fa-spin"></i></td>
                    <td colspan="3" class="text-center">8</td>
                    <td colspan="10" class="dd-kq mb_duoi_8"><i class="fas fa-spinner fa-spin"></i></td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">9</td>
                    <td colspan="10" class="dd-kq mb_dau_9"><i class="fas fa-spinner fa-spin"></i></td>
                    <td colspan="3" class="text-center">9</td>
                    <td colspan="10" class="dd-kq mb_duoi_9"><i class="fas fa-spinner fa-spin"></i></td>
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
        var d = new Date();
        var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
        var currentdate = new Date(utc + (3600000 * +7));
        var rootPath = '';
        var appKey = '';
        var headingTag = 'h1';
        var interval;
        var timeInter = 1357 * 8;
        var hours = currentdate.getHours();
        var minute = currentdate.getMinutes();
        LiveMB(appKey, rootPath, headingTag);
        interval = setInterval("LiveMB('" + appKey + "', '" + rootPath + "', '" + headingTag + "')", timeInter);
        intervalVariable = setInterval('getRandomTextMB()', 100);
    </script>
@endif
</body>
</html>