<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title','Quay thử XSMB hôm nay - Quay thử xổ số miền Bắc')
@section('decription','Quay thử XSMB thử vận may trước khi xem tường thuật kết quả xổ số. Bạn có thể quay thử Xổ số Miền Bắc hôm nay trước khi mua vé số kiến thiết MB.')
@section('h1','Quay thử XSMB hôm nay - Quay thử xổ số miền Bắc')

@section('breadcrumb')
    <div class="linkway">
        <div class="main">
            <div class="breadcrumb">
                <ol itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a
                                itemprop="item" href="/" title="Trang chủ"><span itemprop="name">Trang chủ</span>
                            <meta itemprop="position" content="1">
                        </a></li>
                    <li> »
                    </li>
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a
                                itemprop="item" href="{{url()->current()}}" title="Quay thử XSMB" class="last"><span
                                    itemprop="name">Quay thử XSMB</span>
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
                <li class="active"><a href="{{route('quay_thu.mb')}}" title="Quay thử MB">Quay thử MB</a>
                </li>
                <li><a href="{{route('quay_thu.mn')}}" title="Quay thử MN">Quay thử MN</a>
                </li>
                <li><a href="{{route('quay_thu.mt')}}" title="Quay thử MT">Quay thử MT</a>
                </li>

            </ul>
            <div class="tit-mien clearfix">
                <h2>Quay thử miền Bắc ngày {{date('d/m/Y')}}</h2>
            </div>

            <div class="box" id="trial-box">
                <div class="txt-center  bg-orange">

                    <form id="trial_form" class="form-horizontal">
                        <div class="form-group">
                            <select id="ddLotteries" name="lotteryIdName" class="form-select"
                                    onchange="xsdpquaythu.LotteriesChange()">
                                <option value="{{route('quay_thu.mb')}}" selected>Miền Bắc</option>
                                <option value="{{route('quay_thu.mt')}}">Miền Trung</option>
                                <option value="{{route('quay_thu.mn')}}">Miền Nam</option>
                                @foreach($provinces as $pro)
                                    <option value="{{route('quay_thu.tinh',$pro->short_name)}}">{{$pro->name}}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-danger trial-button" id="btnStartOrStop"
                                    onclick="startRandom()">Quay thử
                            </button>
                        </div>
                        {{--<div class="form-group txt-center">--}}
                        {{--Quay thử đài: <a class="item_sublink mag-l5" href="">Thừa Thiên Huế</a>--}}
                        {{--</div>--}}
                    </form>
                </div>
                <div data-id="kq" class="one-city" data-region="1" data-zoom="0" data-sub="0" data-sound="1">
                    <div data-id="kq" class="one-city" data-region="1">
                        <table class="kqmb extendable" id="beginroll">
                            <tbody>
                           <tr class="db">
                                <td class="txt-giai">ĐB</td>
                                <td class="v-giai number "><span data-nc="5" class="v-gdb " id="mb_prize_26"><i
                                                class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.1</td>
                                <td class="v-giai number"><span data-nc="5" class="v-g1 " id="mb_prize_0"><i
                                                class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.2</td>
                                <td class="v-giai number"><span data-nc="5" class="v-g2-0 " id="mb_prize_1"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g2-1 " id="mb_prize_2"><i
                                                class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.3</td>
                                <td class="v-giai number"><span data-nc="5" class="v-g3-0 " id="mb_prize_3"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g3-1 " id="mb_prize_4"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span data-nc="5"
                                                                                                 class="v-g3-2 "
                                                                                                 id="mb_prize_5"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g3-3 " id="mb_prize_6"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span data-nc="5"
                                                                                                 class="v-g3-4 "
                                                                                                 id="mb_prize_7"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g3-5 " id="mb_prize_8"><i
                                                class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.4</td>
                                <td class="v-giai number"><span data-nc="4" class="v-g4-0 " id="mb_prize_9"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g4-1 " id="mb_prize_10"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span data-nc="4"
                                                                                                 class="v-g4-2 "
                                                                                                 id="mb_prize_11"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g4-3 " id="mb_prize_12"><i
                                                class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.5</td>
                                <td class="v-giai number"><span data-nc="4" class="v-g5-0 " id="mb_prize_13"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g5-1 " id="mb_prize_14"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span data-nc="4"
                                                                                                 class="v-g5-2 "
                                                                                                 id="mb_prize_15"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g5-3 " id="mb_prize_16"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span data-nc="4"
                                                                                                 class="v-g5-4 "
                                                                                                 id="mb_prize_17"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g5-5 " id="mb_prize_18"><i
                                                class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.6</td>
                                <td class="v-giai number"><span data-nc="3" class="v-g6-0 " id="mb_prize_19"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="3" class="v-g6-1 " id="mb_prize_20"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span data-nc="3"
                                                                                                 class="v-g6-2 "
                                                                                                 id="mb_prize_21"><i
                                                class="fas fa-spinner fa-pulse"></i></span>
                                </td>
                            </tr>
                            <tr class="g7">
                                <td class="txt-giai">G.7</td>
                                <td class="v-giai number"><span data-nc="2" class="v-g7-0 " id="mb_prize_22"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="2" class="v-g7-1 " id="mb_prize_23"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span data-nc="2"
                                                                                                 class="v-g7-2 "
                                                                                                 id="mb_prize_24"><i
                                                class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="2" class="v-g7-3 " id="mb_prize_25"><i
                                                class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <style>
                            .control-panel{display: none!important;}
                        </style>
                        <div class="control-panel">
                            <form class="digits-form"><label class="radio" data-value="0"><input type="radio"
                                                                                                 name="showed-digits"
                                                                                                 value="0">
                                    <b></b><span></span></label><label class="radio" data-value="2"><input type="radio"
                                                                                                           name="showed-digits"
                                                                                                           value="2">
                                    <b></b><span></span></label><label class="radio" data-value="3"><input type="radio"
                                                                                                           name="showed-digits"
                                                                                                           value="3">
                                    <b></b><span></span></label></form>
                            <div class="buttons-wrapper"><span class="zoom-in-button"><i
                                            class="icon zoom-in-icon"></i><span></span></span></div>
                        </div>
                    </div>
                    <div data-id="dd" class="col-firstlast">
                        <table class="firstlast-mb fl">
                            <tbody>
                            <tr class="header">
                                <th>Đầu</th>
                                <th>Đuôi</th>
                            </tr>
                            <tr>
                                <td class="clnote">0</td>
                                <td class="v-loto-dau-0" id="loto_mb_0"></td>
                            </tr>
                            <tr>
                                <td class="clnote">1</td>
                                <td class="v-loto-dau-1" id="loto_mb_1"></td>
                            </tr>
                            <tr>
                                <td class="clnote">2</td>
                                <td class="v-loto-dau-2" id="loto_mb_2"></td>
                            </tr>
                            <tr>
                                <td class="clnote">3</td>
                                <td class="v-loto-dau-3" id="loto_mb_3"></td>
                            </tr>
                            <tr>
                                <td class="clnote">4</td>
                                <td class="v-loto-dau-4" id="loto_mb_4"></td>
                            </tr>
                            <tr>
                                <td class="clnote">5</td>
                                <td class="v-loto-dau-5" id="loto_mb_5"></td>
                            </tr>
                            <tr>
                                <td class="clnote">6</td>
                                <td class="v-loto-dau-6" id="loto_mb_6"></td>
                            </tr>
                            <tr>
                                <td class="clnote">7</td>
                                <td class="v-loto-dau-7" id="loto_mb_7"></td>
                            </tr>
                            <tr>
                                <td class="clnote">8</td>
                                <td class="v-loto-dau-8" id="loto_mb_8"></td>
                            </tr>
                            <tr>
                                <td class="clnote">9</td>
                                <td class="v-loto-dau-9" id="loto_mb_9"></td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="firstlast-mb fr">
                            <tbody>
                            <tr class="header">
                                <th>Đầu</th>
                                <th>Đuôi</th>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-0" id="duoi_loto_mb_0"></td>
                                <td class="clnote">0</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-1" id="duoi_loto_mb_1"></td>
                                <td class="clnote">1</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-2" id="duoi_loto_mb_2"></td>
                                <td class="clnote">2</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-3" id="duoi_loto_mb_3"></td>
                                <td class="clnote">3</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-4" id="duoi_loto_mb_4"></td>
                                <td class="clnote">4</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-5" id="duoi_loto_mb_5"></td>
                                <td class="clnote">5</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-6" id="duoi_loto_mb_6"></td>
                                <td class="clnote">6</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-7" id="duoi_loto_mb_7"></td>
                                <td class="clnote">7</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-8" id="duoi_loto_mb_8"></td>
                                <td class="clnote">8</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-9" id="duoi_loto_mb_9"></td>
                                <td class="clnote">9</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="box-content">
            <h2 style="margin-bottom:25px"><strong>Quay Thử Xổ Số Miền Bắc Hôm Nay</strong></h2>
            <p style="margin: 0"><strong>Hướng Dẫn Sử Dụng</strong></p>
            <p style="margin: 0">Bước 1: Chọn đài “Quay thử miền Bắc”.</p>
            <p style="margin: 0">Bước 2: Nhấn nút "Quay thử". Hệ thống sẽ tự động quay các bộ số ngẫu nhiên cho đài xổ số miền Bắc bạn đã chọn.</p>
            <p style="margin: 0">Bước 3: Xem bảng kết quả quay thử.</p>
            <p style="margin: 0"><Strong>Lưu Ý Quan Trọng</Strong></p>
            <p style="margin: 0">Quay thử xổ số miền Bắc hôm nay là một tính năng được xstailoc.com cung cấp. Kết quả quay thử 
                <a style="text-decoration: underline" title="XSMB" href="{{ route('xsmb') }}">XSMB</a>
                được lấy ngẫu nhiên từ những kết quả quay thưởng xổ số truyền thống của đài XSMB trong quá khứ, không theo bất kỳ quy luật hay xu hướng cụ thể nào.
            </p>
            <p style="margin: 0">Tính năng này chỉ nhằm mục đích giải trí sau những giờ làm việc căng thẳng, mang tính chất tham khảo và không có giá trị pháp lý.</p>
            <p style="margin: 0">Tính năng "Quay thử xổ số miền Bắc" là một công cụ giải trí thú vị. Hãy sử dụng nó một cách vui vẻ và có trách nhiệm. Chúng tôi hoàn toàn không chịu trách nhiệm về việc Quý vị sử dụng thông tin này.
                Chúc các bạn MAY MẮN khi tham gia mua <a style="text-decoration: underline"  title="xổ số kiến thiết" href="{{ route('home') }}">xổ số kiến thiết</a>.
            </p>
        </div>
    </div>
@endsection

@section('afterJS')
    <script src="{{url('frontend/js/QuayThu.js')}}?v={{rand(1000,100000)}}"></script>
    <script>
        var timeMB = 27 * 1000;
        function startRandom() {
            if (!isrunning) {
                //$( "#rdGroup" ).prop( "checked", true );
                xsdpquaythu.RunRandomXSMB();
                setTimeout(function () {
                    xsdpquaythu.RunRandomComplete();
                }, timeMB);
            }
        }
        ;
    </script>
@endsection
