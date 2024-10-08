<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title', 'Quay thử XSMT hôm nay - Quay thử xổ số miền Trung')
@section('decription',
    'Quay thử XSMT thử vận may trước khi xem tường thuật kết quả xổ số. Bạn có thể quay thử Xổ số
    miền Trung hôm nay trước khi mua vé số kiến thiết MT.')
@section('h1', 'Quay thử XSMT hôm nay - Quay thử xổ số miền Trung')

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb">
                <ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item"
                            href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span>
                            <meta itemprop="position" content="1">
                        </a></li>
                    <li> »
                    </li>
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemprop="item"
                            href="{{ url()->current() }}" title="Quay thử XSMT" class="last"><span itemprop="name">Quay
                                thử XSMT</span>
                            <meta itemprop="position" content="3">
                        </a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-l">
        <div class="box quay-thu">
            <ul class="tab-panel tab-auto">
                <li><a href="{{ route('quay_thu.mb') }}" title="Quay thử MB">Quay thử MB</a>
                </li>
                <li><a href="{{ route('quay_thu.mn') }}" title="Quay thử MN">Quay thử MN</a>
                </li>
                <li class="active"><a href="{{ route('quay_thu.mt') }}" title="Quay thử MT">Quay thử MT</a>
                </li>

            </ul>
            <div class="tit-mien clearfix">
                <h2>Quay thử miền Trung ngày {{ date('d/m/Y') }}</h2>
            </div>

            <div class="box" id="trial-box">
                <div class="txt-center  bg-orange">

                    <form id="trial_form" class="form-horizontal">
                        <div class="form-group">
                            <select id="ddLotteries" name="lotteryIdName" class="form-select"
                                onchange="xsdpquaythu.LotteriesChange()">
                                <option value="{{ route('quay_thu.mb') }}">Miền Bắc</option>
                                <option value="{{ route('quay_thu.mt') }}" selected>Miền Trung</option>
                                <option value="{{ route('quay_thu.mn') }}">Miền Nam</option>
                                @foreach ($provinces as $pro)
                                    <option value="{{ route('quay_thu.tinh', $pro->short_name) }}">{{ $pro->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-danger trial-button" id="btnStartOrStop"
                                onclick="startRandom()">Quay thử
                            </button>
                        </div>
                        {{-- <div class="form-group txt-center"> --}}
                        {{-- Quay thử đài: <a class="item_sublink mag-l5" href="">Thừa Thiên Huế</a> --}}
                        {{-- </div> --}}
                    </form>
                </div>
                @php $d = 0; @endphp
                <div data-id="kq" class="one-city" data-region="1" data-zoom="0" data-sub="0" data-sound="1">
                    <div class="box" id="beginroll">
                        <div id="load_kq_mn_0">
                            <div data-id="kq" class="three-city" data-region="3">
                                <table class="colthreecity colgiai extendable" id="table-xsmt">
                                    <tbody>
                                        <tr class="gr-yellow">
                                            <th class="first"></th>
                                            @foreach ($arr_province as $province)
                                                <th data-pid="{{ $province->id }}">
                                                    <a class="underline bold"
                                                        href="{{ route('xstinh.tinh', $province->slug) }}"
                                                        title="XS{{ strtoupper($province->short_name) }}">
                                                        {{ $province->name }}
                                                    </a>
                                                </th>
                                            @endforeach
                                        </tr>
                                        <tr class="g8">
                                            <td>G8</td>
                                            @foreach ($arr_province as $province)
                                                <td>
                                                    <div data-nc="2" class="v-g8"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>G7</td>
                                            @foreach ($arr_province as $province)
                                                <td>
                                                    <div data-nc="3" class="v-g7"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>G6</td>
                                            @foreach ($arr_province as $province)
                                                <td>
                                                    <div data-nc="4" class="v-g6-0"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                    <div data-nc="4" class="v-g6-1"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                    <div data-nc="4" class="v-g6-2"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>G5</td>
                                            @foreach ($arr_province as $province)
                                                <td>
                                                    <div data-nc="4" class="v-g5"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>G4</td>
                                            @foreach ($arr_province as $province)
                                                <td>
                                                    <div data-nc="5" class="v-g4-0"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                    <div data-nc="5" class="v-g4-1"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                    <div data-nc="5" class="v-g4-2"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                    <div data-nc="5" class="v-g4-3"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                    <div data-nc="5" class="v-g4-4"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                    <div data-nc="5" class="v-g4-5"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                    <div data-nc="5" class="v-g4-6"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>G3</td>
                                            @foreach ($arr_province as $province)
                                                <td>
                                                    <div data-nc="5" class="v-g3-0"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                    <div data-nc="5" class="v-g3-1"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>G2</td>
                                            @foreach ($arr_province as $province)
                                                <td>
                                                    <div data-nc="5" class="v-g2"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>G1</td>
                                            @foreach ($arr_province as $province)
                                                <td>
                                                    <div data-nc="5" class="v-g1"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr class="gdb">
                                            <td>ĐB</td>
                                            @foreach ($arr_province as $province)
                                                <td>
                                                    <div data-nc="6" class="v-gdb"
                                                        lotterycode="{{ $province->short_name }}"
                                                        id="mn_prize_{{ $d++ }}"><i
                                                            class="fas fa-spinner fa-pulse"></i></div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                                <style>
                                    .control-panel {
                                        display: none !important;
                                    }
                                </style>
                                <div class="control-panel">
                                    <form class="digits-form">
                                        <label class="radio" data-value="0">
                                            <input type="radio" name="showed-digits" value="0">
                                            <b></b>
                                            <span></span>
                                        </label>
                                        <label class="radio" data-value="2">
                                            <input type="radio" name="showed-digits" value="2">
                                            <b></b><span></span>
                                        </label>
                                        <label class="radio" data-value="3">
                                            <input type="radio" name="showed-digits" value="3">
                                            <b></b><span></span>
                                        </label>
                                    </form>
                                </div>
                            </div>
                            <div data-id="dd" class="col-firstlast colthreecity colgiai">
                                <table class="firstlast-mn bold">
                                    <tbody>
                                        <tr class="header">
                                            <th class="first">Đầu</th>
                                            @foreach ($arr_province as $province)
                                                <th>{{ $province->name }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="clnote bold">0</td>
                                            @foreach ($arr_province as $province)
                                                <td class="v-loto-dau-0" id="item_Head_{{ $province->short_name }}_0">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="clnote bold">1</td>
                                            @foreach ($arr_province as $province)
                                                <td class="v-loto-dau-1" id="item_Head_{{ $province->short_name }}_1">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="clnote bold">2</td>
                                            @foreach ($arr_province as $province)
                                                <td class="v-loto-dau-2" id="item_Head_{{ $province->short_name }}_2">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="clnote bold">3</td>
                                            @foreach ($arr_province as $province)
                                                <td class="v-loto-dau-3" id="item_Head_{{ $province->short_name }}_3">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="clnote bold">4</td>
                                            @foreach ($arr_province as $province)
                                                <td class="v-loto-dau-4" id="item_Head_{{ $province->short_name }}_4">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="clnote bold">5</td>
                                            @foreach ($arr_province as $province)
                                                <td class="v-loto-dau-5" id="item_Head_{{ $province->short_name }}_5">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="clnote bold">6</td>
                                            @foreach ($arr_province as $province)
                                                <td class="v-loto-dau-6" id="item_Head_{{ $province->short_name }}_6">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="clnote bold">7</td>
                                            @foreach ($arr_province as $province)
                                                <td class="v-loto-dau-7" id="item_Head_{{ $province->short_name }}_7">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="clnote bold">8</td>
                                            @foreach ($arr_province as $province)
                                                <td class="v-loto-dau-8" id="item_Head_{{ $province->short_name }}_8">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td class="clnote bold">9</td>
                                            @foreach ($arr_province as $province)
                                                <td class="v-loto-dau-9" id="item_Head_{{ $province->short_name }}_9">
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="box-content">
            <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm kết quả: xổ số miền Trung</div>
            <ul class="list-html-link two-column">
                <li>Mời bạn <a href="{{ route('quay_thu.mt') }}" title="quay thử miền Trung">quay thử
                        miền Trung</a> hôm nay để lấy hên
                </li>
                <li>Xem thêm <a href="{{ route('xsmt') }}" title="Kết Quả XSMT">kết quả XSMT xổ số miền
                        Trung</a></li>
                <li>Xem bảng kết quả <a href="{{ route('xsmt.skq') }}" title="XSMT 30 ngày gần nhất">XSMT
                        30 ngày gần nhất</a></li>
            </ul>
        </div>
        <div class="box-content">
            <h2 style="margin-bottom:25px"><strong>Quay Thử Xổ Số Miền Trung Hôm Nay</strong></h2>
            <p style="margin: 0"><strong>Hướng Dẫn Sử Dụng</strong></p>
            <p style="margin: 0">Bước 1: Chọn đài “Quay thử miền Trung”.</p>
            <p style="margin: 0">Bước 2: Nhấn nút "Quay thử". Hệ thống sẽ tự động quay các bộ số ngẫu nhiên
                cho đài xổ số miền Trung bạn đã chọn.</p>
            <p style="margin: 0">Bước 3: Xem bảng kết quả quay thử.</p>
            <p style="margin: 0"><Strong>Lưu Ý Quan Trọng</Strong></p>
            <p style="margin: 0">Quay thử xổ số miền Trung hôm nay là một tính năng được xosotailoc.vip cung
                cấp. Kết quả quay thử
                <a style="text-decoration: underline" title="XSMT" href="{{ route('xsmt') }}">XSMT</a>
                được lấy ngẫu nhiên từ những kết quả quay thưởng xổ số truyền thống của đài XSMT trong quá
                khứ, không theo bất kỳ quy luật hay xu hướng cụ thể nào.
            </p>
            <p style="margin: 0">Tính năng này chỉ nhằm mục đích giải trí sau những giờ làm việc căng
                thẳng, mang tính chất tham khảo và không có giá trị pháp lý.</p>
            <p style="margin: 0">Tính năng "Quay thử xổ số miền Trung" là một công cụ giải trí thú vị. Hãy
                sử dụng nó một cách vui vẻ và có trách nhiệm. Chúng tôi hoàn toàn không chịu trách nhiệm về
                việc Quý vị sử dụng thông tin này.
                Chúc các bạn MAY MẮN khi tham gia mua
                <a style="text-decoration: underline" title="xổ số kiến thiết" href="{{ route('home') }}">xổ số kiến
                    thiết</a>.
            </p>
        </div>
    </div>
@endsection

@section('afterJS')
    <script src="{{ url('frontend/js/QuayThu.js') }}?v={{ rand(1000, 100000) }}"></script>
    <script>
        function startRandom() {
            if (!isrunning) {
                //$( "#rdGroup" ).prop( "checked", true );
                xsdpquaythu.RunRandomXSMN(3);
                setTimeout(function() {
                    xsdpquaythu.RunRandomComplete();
                }, 38000);
            }
        };
    </script>
@endsection
