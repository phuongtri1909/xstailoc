<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
@extends('frontend.layouts.app')

@section('title',$meta_title)
@section('decription',$meta_description)
@section('h1',$meta_title)

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
                                itemprop="item" href="{{url()->current()}}" title="Quay thử xổ số {{$province->name}}" class="last"><span
                                    itemprop="name">Quay thử xổ số {{$province->name}}</span>
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
                <li><a href="{{route('quay_thu.mb')}}" title="Quay thử MB">Quay thử MB</a>
                </li>
                <li><a href="{{route('quay_thu.mn')}}" title="Quay thử MN">Quay thử MN</a>
                </li>
                <li><a href="{{route('quay_thu.mt')}}" title="Quay thử MT">Quay thử MT</a>
                </li>

            </ul>
            <div class="tit-mien clearfix">
                <h2>Quay thử xổ số {{$province->name}} ngày {{date('d/m/Y')}}</h2>
            </div>

            <div class="box" id="trial-box">
                <div class="txt-center  bg-orange">

                    <form id="trial_form" class="form-horizontal">
                        <div class="form-group">
                            <select id="ddLotteries" name="lotteryIdName" class="form-select"
                                    onchange="xsdpquaythu.LotteriesChange()">
                                <option value="{{route('quay_thu.mb')}}">Miền Bắc</option>
                                <option value="{{route('quay_thu.mt')}}">Miền Trung</option>
                                <option value="{{route('quay_thu.mn')}}">Miền Nam</option>
                                @foreach($provinces as $pro)
                                    <option value="{{route('quay_thu.tinh',$pro->short_name)}}" {{route('quay_thu.tinh',$province->short_name) == route('quay_thu.tinh',$pro->short_name)?'selected':''}}>{{$pro->name}}</option>
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
                    <div data-id="kq" data-zoom="0" class="one-city"  id="beginroll">
                        <table class="kqmb extendable kqtinh">
                            <tbody>
                            <tr class="g8">
                                <td class="txt-giai">G.8</td>

                                <td class="v-giai number"><span data-nc="2" class="v-g8 "
                                                                id="qttd_prize_0"><i class="fas fa-spinner fa-spin"></i></span>
                                </td>


                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.7</td>

                                <td class="v-giai number"><span data-nc="3" class="v-g7 "
                                                                id="qttd_prize_1"><i class="fas fa-spinner fa-spin"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.6</td>
                                <td class="v-giai number">
                                <span data-nc="4" class="v-g6-0 "
                                      id="qttd_prize_2"><i class="fas fa-spinner fa-spin"></i></span><span
                                            data-nc="4" class="v-g6-1 "
                                            id="qttd_prize_3"><i class="fas fa-spinner fa-spin"></i></span><span
                                            data-nc="4" class="v-g6-2 "
                                            id="qttd_prize_4"><i class="fas fa-spinner fa-spin"></i></span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.5</td>
                                <td class="v-giai number">
                                <span data-nc="4" class="v-g5 "
                                      id="qttd_prize_5"><i class="fas fa-spinner fa-spin"></i></span>
                                </td>
                            </tr>

                            <tr class="g4">
                                <td class="titgiai">G.4</td>
                                <td class="v-giai number">
                                <span data-nc="5" class="v-g4-0 "
                                      id="qttd_prize_6"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-1 "
                                             id="qttd_prize_7"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-2 "
                                             id="qttd_prize_8"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-3 "
                                             id="qttd_prize_9"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-4 "
                                             id="qttd_prize_10"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-5 "
                                             id="qttd_prize_11"><i class="fas fa-spinner fa-spin"></i></span><!--
                                    --><span data-nc="5" class="v-g4-6 "
                                             id="qttd_prize_12"><i class="fas fa-spinner fa-spin"></i></span>
                                </td>
                            </tr>

                            <tr class="bg_ef">
                                <td class="txt-giai">G.3</td>
                                <td class="v-giai number">
                                <span data-nc="5" class="v-g3-0 "
                                      id="qttd_prize_13"><i class="fas fa-spinner fa-spin"></i></span><!--
                                        --><span data-nc="5" class="v-g3-1 "
                                                 id="qttd_prize_14"><i class="fas fa-spinner fa-spin"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.2</td>
                                <td class="v-giai number">
                                <span data-nc="5" class="v-g2 "
                                      id="qttd_prize_15"><i class="fas fa-spinner fa-spin"></i></span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.1</td>
                                <td class="v-giai number"><span data-nc="5" class="v-g1 "
                                                                id="qttd_prize_16"><i class="fas fa-spinner fa-spin"></i></span>
                                </td>
                            </tr>
                            <tr class="gdb db">
                                <td class="txt-giai">ĐB</td>
                                <td class="v-giai number"><span data-nc="6" class="v-gdb "
                                                                id="qttd_prize_17"><i class="fas fa-spinner fa-spin"></i></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <style>
                            .control-panel{display: none!important;}
                        </style>
                        <div class="control-panel">
                            <form class="digits-form"><label class="radio" data-value="0"><input type="radio"
                                                                                                 name="showed-digits"
                                                                                                 value="0"><b></b><span></span></label><label
                                        class="radio" data-value="2"><input type="radio" name="showed-digits"
                                                                            value="2"><b></b><span></span></label><label
                                        class="radio" data-value="3"><input type="radio" name="showed-digits"
                                                                            value="3"><b></b><span></span></label></form>
                            <div class="buttons-wrapper"><span class="capture-button"><i
                                            class="icon capture-icon"></i><span></span></span>

                                <div class="subscription-button dspnone"><input id="load_kq_tinh_1_chx" type="checkbox"
                                                                                class="ntf-sub cbx dspnone"
                                                                                sub-type-id="null"><label
                                            id="load_kq_tinh_1_chx_lbl" sub-type-id="null" class="lbl1"
                                            for="load_kq_tinh_1_chx"></label><span></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="buttons-wrapper"></div>
                    <div data-id="dd" class="col-firstlast">
                        <table class="firstlast-mb fl">
                            <tbody>
                            <tr class="header">
                                <th>Đầu</th>
                                <th>Đuôi</th>
                            </tr>
                            <tr>
                                <td class="clred">0</td>
                                <td class="v-loto-dau-0" id="loto_mb_0"></td>
                            </tr>
                            <tr>
                                <td class="clred">1</td>
                                <td class="v-loto-dau-1" id="loto_mb_1"></td>
                            </tr>
                            <tr>
                                <td class="clred">2</td>
                                <td class="v-loto-dau-2" id="loto_mb_2"></td>
                            </tr>
                            <tr>
                                <td class="clred">3</td>
                                <td class="v-loto-dau-3" id="loto_mb_3"></td>
                            </tr>
                            <tr>
                                <td class="clred">4</td>
                                <td class="v-loto-dau-4" id="loto_mb_4"></td>
                            </tr>
                            <tr>
                                <td class="clred">5</td>
                                <td class="v-loto-dau-5" id="loto_mb_5"></td>
                            </tr>
                            <tr>
                                <td class="clred">6</td>
                                <td class="v-loto-dau-6" id="loto_mb_6"></td>
                            </tr>
                            <tr>
                                <td class="clred">7</td>
                                <td class="v-loto-dau-7" id="loto_mb_7"></td>
                            </tr>
                            <tr>
                                <td class="clred">8</td>
                                <td class="v-loto-dau-8" id="loto_mb_8"></td>
                            </tr>
                            <tr>
                                <td class="clred">9</td>
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
                                <td class="clred">0</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-1" id="duoi_loto_mb_1"></td>
                                <td class="clred">1</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-2" id="duoi_loto_mb_2"></td>
                                <td class="clred">2</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-3" id="duoi_loto_mb_3"></td>
                                <td class="clred">3</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-4" id="duoi_loto_mb_4"></td>
                                <td class="clred">4</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-5" id="duoi_loto_mb_5"></td>
                                <td class="clred">5</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-6" id="duoi_loto_mb_6"></td>
                                <td class="clred">6</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-7" id="duoi_loto_mb_7"></td>
                                <td class="clred">7</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-8" id="duoi_loto_mb_8"></td>
                                <td class="clred">8</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-9" id="duoi_loto_mb_9"></td>
                                <td class="clred">9</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('afterJS')
    <script src="{{url('frontend/js/QuayThu.js')}}?v={{rand(1000,100000)}}"></script>
    <script>
        var timeroll = 18 * 1000;
        function startRandom() {
            if (!isrunning) {
                //$( "#rdGroup" ).prop( "checked", true );
                xsdpquaythu.RunRandomXSTheoDai('');
                setTimeout(function () {
                    xsdpquaythu.RunRandomComplete();
                }, timeroll);
            }
        };
    </script>
@endsection
