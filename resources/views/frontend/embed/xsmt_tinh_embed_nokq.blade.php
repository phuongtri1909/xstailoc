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
<div class="box bg-white rd shadow"  id='kqngay_{{getNgayID($date)}}' onclick="window.open('{{route('xstinh.tinh',$province->slug)}}','_blank');return;">
    <div class="kqmb shadow kqsx mb">
        <table class="table-kqsx"  id="table-tinh">
            <thead>
            <tr>
                <th colspan="27" class="header-kqsx">
                    <h2 class="h-kqsx"  id="provinceLiveTitle">XS{{strtoupper($province->short_name)}} - Kết quả Xổ số {{$province->name}} - SX{{strtoupper($province->short_name)}} hôm nay</h2>
                    <h3 class="breadcrumb-link">
                        <a href="{{route('xsmt')}}">XSMT</a> /
                        <a href="{{route(getRouteDay(getThuNumber($date),'xsmt'))}}">XSMT {{getThu(getThuNumber($date))}}</a> /
                        <a href="{{route('xsmt.date',getNgayLink($date))}}">XSMT {{getNgay($date)}}</a>
                    </h3>
                </th>
            </tr>
            <tr>
                <td colspan="27" class="txt-db">
                    <h3 class="df-title">
                        <a title="XS{{strtoupper($province->short_name)}}"
                           href="{{route('xstinh.tinh',$province->slug)}}">XS{{strtoupper($province->short_name)}}</a> {{getThu(getThuNumber($date))}} /

                        <a title="XS{{strtoupper($province->short_name)}} {{getNgay($date)}}"
                           href="{{route('xstinh.date',[$province->short_name,getNgayLink($date)])}}">XS{{strtoupper($province->short_name)}} {{getNgay($date)}}</a>
                    </h3>
                </td>
            </tr>
            </thead>
            <tbody>
            <tr class="db">
                <td colspan="3" class="color-highlight font-20">G8</td>
                <td colspan="24" class="txt-special-prize txt-giai"  id="qttd_prize_0" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="odd-bg">
                <td colspan="3" class="fw-medium">G7</td>
                <td colspan="24" class="txt-normal-prize txt-giai txt-giai" id="qttd_prize_1" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr>
                <td colspan="3" class="fw-medium g6">G6</td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="qttd_prize_2" data-id="" l="3"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="qttd_prize_3" data-id="" l="3"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="qttd_prize_4" data-id="" l="3"><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="odd-bg">
                <td colspan="3" class="fw-medium">G5</td>
                <td colspan="24" class="txt-normal-prize txt-giai txt-giai" id="qttd_prize_5" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr>
                <td colspan="3" rowspan="2" class="fw-medium">G4</td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="qttd_prize_6" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="qttd_prize_7" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="qttd_prize_8" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="6" class="txt-normal-prize txt-giai" id="qttd_prize_9" data-id="" l="4"><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr>
                <td colspan="8" class="txt-normal-prize txt-giai" id="qttd_prize_10" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="qttd_prize_11" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="8" class="txt-normal-prize txt-giai" id="qttd_prize_12" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="odd-bg">
                <td colspan="3" class="fw-medium g2">G3</td>
                <td colspan="12" class="txt-normal-prize txt-giai" id="qttd_prize_13" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                <td colspan="12" class="txt-normal-prize txt-giai" id="qttd_prize_14" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr>
                <td colspan="3" class="fw-medium">G2</td>
                <td colspan="24" class="txt-normal-prize txt-giai txt-giai" id="qttd_prize_15" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="odd-bg">
                <td colspan="3" class="fw-medium">G1</td>
                <td colspan="24" class="txt-normal-prize txt-giai txt-giai" id="qttd_prize_16" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
            </tr>
            <tr class="db">
                <td colspan="3" class="color-highlight font-20">ĐB</td>
                <td colspan="24" class="txt-special-prize txt-giai" id="qttd_prize_17" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
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
                    <td colspan="10" class="dd-kq mb_dau_0" id="loto_mb_0">&nbsp;</td>
                    <td colspan="3" class="text-center">0</td>
                    <td colspan="10" class="dd-kq mb_duoi_0" id="duoi_loto_mb_0">&nbsp;</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">1</td>
                    <td colspan="10" class="dd-kq mb_dau_1" id="loto_mb_1">&nbsp;</td>
                    <td colspan="3" class="text-center">1</td>
                    <td colspan="10" class="dd-kq mb_duoi_1" id="duoi_loto_mb_1">&nbsp;</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">2</td>
                    <td colspan="10" class="dd-kq mb_dau_2" id="loto_mb_2">&nbsp;
                    </td>
                    <td colspan="3" class="text-center">2</td>
                    <td colspan="10" class="dd-kq mb_duoi_2" id="duoi_loto_mb_2">&nbsp;</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">3</td>
                    <td colspan="10" class="dd-kq mb_dau_3" id="loto_mb_3">&nbsp;</td>
                    <td colspan="3" class="text-center">3</td>
                    <td colspan="10" class="dd-kq mb_duoi_3" id="duoi_loto_mb_3">&nbsp;</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">4</td>
                    <td colspan="10" class="dd-kq mb_dau_4" id="loto_mb_4">&nbsp;</td>
                    <td colspan="3" class="text-center">4</td>
                    <td colspan="10" class="dd-kq mb_duoi_4" id="duoi_loto_mb_4">&nbsp;</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">5</td>
                    <td colspan="10" class="dd-kq mb_dau_5" id="loto_mb_5">&nbsp;</td>
                    <td colspan="3" class="text-center">5</td>
                    <td colspan="10" class="dd-kq mb_duoi_5" id="duoi_loto_mb_5">&nbsp;</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">6</td>
                    <td colspan="10" class="dd-kq mb_dau_6" id="loto_mb_6">&nbsp;</td>
                    <td colspan="3" class="text-center">6</td>
                    <td colspan="10" class="dd-kq mb_duoi_6" id="duoi_loto_mb_6">&nbsp;</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">7</td>
                    <td colspan="10" class="dd-kq mb_dau_7" id="loto_mb_7">&nbsp;</td>
                    <td colspan="3" class="text-center">7</td>
                    <td colspan="10" class="dd-kq mb_duoi_7" id="duoi_loto_mb_7">&nbsp;</td>
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="text-center">8</td>
                    <td colspan="10" class="dd-kq mb_dau_8" id="loto_mb_8">&nbsp;</td>
                    <td colspan="3" class="text-center">8</td>
                    <td colspan="10" class="dd-kq mb_duoi_8" id="duoi_loto_mb_8">&nbsp;</td>
                </tr>
                <tr class="">
                    <td colspan="3" class="text-center">9</td>
                    <td colspan="10" class="dd-kq mb_dau_9" id="loto_mb_9">&nbsp;</td>
                    <td colspan="3" class="text-center">9</td>
                    <td colspan="10" class="dd-kq mb_duoi_9" id="duoi_loto_mb_9">&nbsp;</td>
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

            var groupId = 3;

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
    $("a").click(function(ev) {
        ev.preventDefault();
        window.open($(this).attr('href'),'_blank');
    });
</script>
</body>
</html>