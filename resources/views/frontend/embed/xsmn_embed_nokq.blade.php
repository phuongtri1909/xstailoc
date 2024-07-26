<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title>Mã nhúng</title>
    <link rel="canonical" href="{{route('xsmn.date',getNgayLink($date))}}"/>
    <link rel="alternate" href="{{route('xsmn.date',getNgayLink($date))}}" hreflang="vi-vn">
    <link rel="alternate" href="{{route('xsmn.date',getNgayLink($date))}}" hreflang="x-default">    
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
@php $count = count($arr_province); @endphp
<div class="rd bg-white" id='mn_kqngay_{{getNgayID($date)}}' onclick="window.open('{{route('xsmn')}}','_blank');return;">
    <div class="kqsx-old-mn">
        <div class="kqsx-tinh kqsx mb">
            <table class="tbl-kqsx text-center">
                <tbody>
                <tr>
                    <th @if($count==4) colspan="35" @else colspan="27" @endif>
                        <h2 class="h-kqsx">Xổ Số miền Nam (XSMN) ngày {{getNgay($date)}}</h2>
                        <h3 class="breadcrumb-link">
                            <a href="{{route('xsmn')}}">XSMN</a> / <a href="{{route(getRouteDay(getThuNumber($date),'xsmn'))}}">XSMN {{getThu(getThuNumber($date))}}</a> / <a
                                    href="{{route('xsmn.date',getNgayLink($date))}}">XSMN {{getNgay($date)}}</a>
                        </h3>
                    </th>
                </tr>
                <tr class="odd-bg">
                    <th colspan="3" class="color-sub-brand txt-content fw-medium p-0">Tỉnh</th>
                    @foreach($arr_province as $province)
                        <th colspan="8" class="color-sub-brand txt-content fw-medium">
                            <a href="{{route('xstinh.tinh',$province->slug)}}">{{$province->name}}</a>
                        </th>
                    @endforeach
                </tr>
                <tr>
                    <td colspan="3" class="" data-id="G8">G8</td>
                    @foreach($arr_province as $province)
                        <td l="2" colspan="8" class="txt-normal-prize txt-giai" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="" data-id="G7">G7</td>
                    @foreach($arr_province as $province)
                        <td l="3" colspan="8" class="txt-normal-prize txt-giai" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                    @endforeach
                </tr>
                @for($i=0;$i<3;$i++)
                    <tr>
                        @if($i==0) <td colspan="3" rowspan="3" class="" data-id="G6">G6</td> @endif
                        @foreach($arr_province as $province)
                            <td colspan="8" l="4" class="txt-normal-prize txt-giai" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                        @endforeach
                    </tr>
                @endfor
                <tr class="odd-bg">
                    <td colspan="3" class="" data-id="G5">G5</td>
                    @foreach($arr_province as $province)
                        <td colspan="8" l="4" class="txt-normal-prize txt-giai" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                    @endforeach
                </tr>
                @for($i=0;$i<7;$i++)
                    <tr>
                        @if($i==0) <td colspan="3" rowspan="7" class="" data-id="G4">G4</td> @endif
                        @foreach($arr_province as $province)
                            <td colspan="8" class="txt-normal-prize txt-giai" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                        @endforeach
                    </tr>
                @endfor

                @for($i=0;$i<2;$i++)
                    <tr class="odd-bg">
                        @if($i==0) <td colspan="3" rowspan="2" class="" data-id="G3">G3</td> @endif
                        @foreach($arr_province as $province)
                            <td colspan="8" class="txt-normal-prize txt-giai" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                        @endforeach
                    </tr>
                @endfor
                <tr>
                    <td colspan="3" class="" data-id="G2">G2</td>
                    @foreach($arr_province as $province)
                        <td colspan="8" class="txt-normal-prize txt-giai" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3" class="" data-id="G1">G1</td>
                    @foreach($arr_province as $province)
                        <td colspan="8" class="txt-normal-prize txt-giai" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                    @endforeach
                </tr>
                <tr>
                    <td colspan="3" class="txt-special-prize" data-id="ĐB">ĐB</td>
                    @foreach($arr_province as $province)
                        <td l="6" colspan="8" class="txt-special-prize txt-giai" data-id=""><i class="fas fa-spinner fa-spin"></i></td>
                    @endforeach
                </tr>
                </tbody>
            </table>
            <div class="digital-num">
                <label class="radio-button-container" disabled="disabled" data-val="0">Tất cả <input
                            type="radio" checked="checked" name="radio">
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
        <div class="sec-tkmiennam rd shadow">
            <table class="tbl-thongkemn">
                <tbody>
                <tr class="text-center">
                    <th colspan="3" class="fw-medium">Đầu</th>
                    @foreach($arr_province as $province)
                        <th colspan="8" class="fw-medium"><a href="{{route('xstinh.tinh',$province->slug)}}">{{$province->name}}</a></th>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">0</td>
                    @foreach($arr_province as $province)
                        <td colspan="8">
                            <i class="fas fa-spinner fa-spin"></i>
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">1</td>
                    @foreach($arr_province as $province)
                        <td colspan="8">
                            <i class="fas fa-spinner fa-spin"></i>
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">2</td>
                    @foreach($arr_province as $province)
                        <td colspan="8">
                            <i class="fas fa-spinner fa-spin"></i>
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">3</td>
                    @foreach($arr_province as $province)
                        <td colspan="8">
                            <i class="fas fa-spinner fa-spin"></i>
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">4</td>
                    @foreach($arr_province as $province)
                        <td colspan="8">
                            <i class="fas fa-spinner fa-spin"></i>
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">5</td>
                    @foreach($arr_province as $province)
                        <td colspan="8">
                            <i class="fas fa-spinner fa-spin"></i>
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">6</td>
                    @foreach($arr_province as $province)
                        <td colspan="8">
                            <i class="fas fa-spinner fa-spin"></i>
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">7</td>
                    @foreach($arr_province as $province)
                        <td colspan="8">
                            <i class="fas fa-spinner fa-spin"></i>
                        </td>
                    @endforeach
                </tr>
                <tr class="odd-bg">
                    <td colspan="3">8</td>
                    @foreach($arr_province as $province)
                        <td colspan="8">
                            <i class="fas fa-spinner fa-spin"></i>
                        </td>
                    @endforeach
                </tr>
                <tr class="">
                    <td colspan="3">9</td>
                    @foreach($arr_province as $province)
                        <td colspan="8">
                            <i class="fas fa-spinner fa-spin"></i>
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
             $("a").click(function(ev) {
       ev.preventDefault();
       window.open($(this).attr('href'),'_blank');
   });
 </script>
</body>
</html>