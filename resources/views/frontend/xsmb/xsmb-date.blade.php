<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

?>

@extends('frontend.layouts.app')


@section('title',$meta_title)

@section('decription',$meta_decription)

@section('keyword',$meta_keyword)
@section('h1',$meta_title)


@section('content')
    <div class="col-l">
        @if(!empty($xsmb))
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
            {{--<div class="box">--}}
                {{--<div class="bg_gray">--}}
                    {{--<div class=" opt_date_full clearfix">--}}
                        {{--@if(!empty($xsmb_pre))--}}
                            {{--<a href="{{route('xsmb.date',getNgayLink($xsmb_pre->date))}}"--}}
                               {{--class="ic-pre fl" title="KQXSMB ngày {{getNgay($xsmb_pre->date)}}"></a>--}}
                        {{--@endif--}}
                        {{--<label><strong>{{getThu($xsmb->day)}}</strong> - <input--}}
                                    {{--type="text" class="nobor" value="{{getNgay($xsmb->date)}}" id="searchDateMB"/><span--}}
                                    {{--class='ic ic-calendar'></span></label>--}}
                        {{--@if(!empty($xsmb_next))--}}
                            {{--<a href="{{route('xsmb.date',getNgayLink($xsmb_next->date))}}"--}}
                               {{--class="ic-next" title="KQXSMB ngày {{getNgay($xsmb_next->date)}}"></a>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="box" id='kqngay_{{getNgayID($xsmb->date)}}'>
                <div class="tit-mien clearfix">
                    <h2>XSMB - Xổ số miền Bắc {{getNgay($xsmb->date)}}</h2>

                    <div id="MbListLink">
                        <a class="sub-title" href="{{route('xsmb')}}" title="XSMB">XSMB</a>
                        » <a class="sub-title" href="{{route(getRouteDay($xsmb->day,'xsmb'))}}"
                             title="XSMB {{getThu($xsmb->day)}}">XSMB {{getThu($xsmb->day)}}</a>
                        » <a class="sub-title" href="{{route('xsmb.date',getNgayLink($xsmb->date))}}"
                             title="XSMB ngày {{getNgay($xsmb->date)}}">XSMB ngày {{getNgay($xsmb->date)}}</a>
                    </div>
                </div>
                <div id="load_kq_mb_0">
                    <div data-id="kq" class="one-city" data-region="1">
                        <table class="kqmb extendable">
                            <tbody>
                            <tr>
                                <td colspan="13" class="v-giai madb" id="mb_prizeCode"><span class="v-madb"
                                                                                             id="mb_prizeCode_item">{{str_replace('-',' - ',$xsmb->madb)}}</span>
                                </td>
                            </tr>
                            <tr class="db">
                                <td class="txt-giai">ĐB</td>
                                <td class="v-giai number "><span data-nc="5" class="v-gdb "
                                                                 id="mb_prize_DB_item_0">@if(!empty($gdb)){{$gdb}}@endif</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.1</td>
                                <td class="v-giai number"><span data-nc="5" class="v-g1"
                                                                id="mb_prize_1_item_0">@if(!empty($g1)){{$g1}}@endif</span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.2</td>
                                <td class="v-giai number">
                                <span data-nc="5" class="v-g2-0 "
                                      id="mb_prize_2_item_0">@if(!empty($g2[0])){{$g2[0]}}@endif</span><span data-nc="5"
                                                                                                             class="v-g2-1 "
                                                                                                             id="mb_prize_2_item_1">@if(!empty($g2[1])){{$g2[1]}}@endif</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.3</td>
                                <td class="v-giai number">
                                <span data-nc="5" class="v-g3-0 "
                                      id="mb_prize_3_item_0">@if(!empty($g3[0])){{$g3[0]}}@endif</span><span data-nc="5"
                                                                                                             class="v-g3-1 "
                                                                                                             id="mb_prize_3_item_1">@if(!empty($g3[1])){{$g3[1]}}@endif</span><span
                                            data-nc="5" class="v-g3-2 "
                                            id="mb_prize_3_item_2">@if(!empty($g3[2])){{$g3[2]}}@endif</span><span
                                            data-nc="5" class="v-g3-3 "
                                            id="mb_prize_3_item_3">@if(!empty($g3[3])){{$g3[3]}}@endif</span><span
                                            data-nc="5" class="v-g3-4 "
                                            id="mb_prize_3_item_4">@if(!empty($g3[4])){{$g3[4]}}@endif</span><span
                                            data-nc="5" class="v-g3-5 "
                                            id="mb_prize_3_item_5">@if(!empty($g3[5])){{$g3[5]}}@endif</span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.4</td>
                                <td class="v-giai number">
                                <span data-nc="4" class="v-g4-0 "
                                      id="mb_prize_4_item_0">@if(!empty($g4[0])){{$g4[0]}}@endif</span><span data-nc="4"
                                                                                                             class="v-g4-1 "
                                                                                                             id="mb_prize_4_item_1">@if(!empty($g4[1])){{$g4[1]}}@endif</span><span
                                            data-nc="4" class="v-g4-2 "
                                            id="mb_prize_4_item_2">@if(!empty($g4[2])){{$g4[2]}}@endif</span><span
                                            data-nc="4" class="v-g4-3 "
                                            id="mb_prize_4_item_3">@if(!empty($g4[3])){{$g4[3]}}@endif</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.5</td>
                                <td class="v-giai number">
                                <span data-nc="4" class="v-g5-0 "
                                      id="mb_prize_5_item_0">@if(!empty($g5[0])){{$g5[0]}}@endif</span><span data-nc="4"
                                                                                                             class="v-g5-1 "
                                                                                                             id="mb_prize_5_item_1">@if(!empty($g5[1])){{$g5[1]}}@endif</span><span
                                            data-nc="4" class="v-g5-2 "
                                            id="mb_prize_5_item_2">@if(!empty($g5[2])){{$g5[2]}}@endif</span><span
                                            data-nc="4" class="v-g5-3 "
                                            id="mb_prize_5_item_3">@if(!empty($g5[3])){{$g5[3]}}@endif</span><span
                                            data-nc="4" class="v-g5-4 "
                                            id="mb_prize_5_item_4">@if(!empty($g5[4])){{$g5[4]}}@endif</span><span
                                            data-nc="4" class="v-g5-5 "
                                            id="mb_prize_5_item_5">@if(!empty($g5[5])){{$g5[5]}}@endif</span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.6</td>
                                <td class="v-giai number">
                                <span data-nc="3" class="v-g6-0 "
                                      id="mb_prize_6_item_0">@if(!empty($g6[0])){{$g6[0]}}@endif</span><span data-nc="3"
                                                                                                             class="v-g6-1 "
                                                                                                             id="mb_prize_6_item_1">@if(!empty($g6[1])){{$g6[1]}}@endif</span><span
                                            data-nc="3" class="v-g6-2 "
                                            id="mb_prize_6_item_2">@if(!empty($g6[2])){{$g6[2]}}@endif</span>
                                </td>
                            </tr>
                            <tr class="g7">
                                <td class="txt-giai">G.7</td>
                                <td class="v-giai number">
                                <span data-nc="2" class="v-g7-0 "
                                      id="mb_prize_7_item_0">@if(!empty($g7[0])){{$g7[0]}}@endif</span><span data-nc="2"
                                                                                                             class="v-g7-1 "
                                                                                                             id="mb_prize_7_item_1">@if(!empty($g7[1])){{$g7[1]}}@endif</span><span
                                            data-nc="2" class="v-g7-2 "
                                            id="mb_prize_7_item_2">@if(!empty($g7[2])){{$g7[2]}}@endif</span><span
                                            data-nc="2" class="v-g7-3 "
                                            id="mb_prize_7_item_3">@if(!empty($g7[3])){{$g7[3]}}@endif</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
                    <div data-id="dd" class="col-firstlast" id="livebangkqlotomb">
                        <table class="firstlast-mb fl">
                            <tbody>
                            <tr class="header">
                                <th>Đầu</th>
                                <th>Đuôi</th>
                            </tr>
                            <tr>
                                <td class="clnote">0</td>
                                <td class="v-loto-dau-0" id="loto_mb_0">{!! $xsmbDau[0] !!}</td>
                            </tr>
                            <tr>
                                <td class="clnote">1</td>
                                <td class="v-loto-dau-1" id="loto_mb_1">{!! $xsmbDau[1] !!}</td>
                            </tr>
                            <tr>
                                <td class="clnote">2</td>
                                <td class="v-loto-dau-2" id="loto_mb_2">{!! $xsmbDau[2] !!}</td>
                            </tr>
                            <tr>
                                <td class="clnote">3</td>
                                <td class="v-loto-dau-3" id="loto_mb_3">{!! $xsmbDau[3] !!}</td>
                            </tr>
                            <tr>
                                <td class="clnote">4</td>
                                <td class="v-loto-dau-4" id="loto_mb_4">{!! $xsmbDau[4] !!}</td>
                            </tr>
                            <tr>
                                <td class="clnote">5</td>
                                <td class="v-loto-dau-5" id="loto_mb_5">{!! $xsmbDau[5] !!}</td>
                            </tr>
                            <tr>
                                <td class="clnote">6</td>
                                <td class="v-loto-dau-6" id="loto_mb_6">{!! $xsmbDau[6] !!}</td>
                            </tr>
                            <tr>
                                <td class="clnote">7</td>
                                <td class="v-loto-dau-7" id="loto_mb_7">{!! $xsmbDau[7] !!}</td>
                            </tr>
                            <tr>
                                <td class="clnote">8</td>
                                <td class="v-loto-dau-8" id="loto_mb_8">{!! $xsmbDau[8] !!}</td>
                            </tr>
                            <tr>
                                <td class="clnote">9</td>
                                <td class="v-loto-dau-9" id="loto_mb_9">{!! $xsmbDau[9] !!}</td>
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
                                <td class="v-loto-duoi-0" id="loto_mb_d0">{!! $xsmbDuoi[0] !!}</td>
                                <td class="clnote">0</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-1" id="loto_mb_d1">{!! $xsmbDuoi[1] !!}</td>
                                <td class="clnote">1</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-2" id="loto_mb_d2">{!! $xsmbDuoi[2] !!}</td>
                                <td class="clnote">2</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-3" id="loto_mb_d3">{!! $xsmbDuoi[3] !!}</td>
                                <td class="clnote">3</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-4" id="loto_mb_d4">{!! $xsmbDuoi[4] !!}</td>
                                <td class="clnote">4</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-5" id="loto_mb_d5">{!! $xsmbDuoi[5] !!}</td>
                                <td class="clnote">5</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-6" id="loto_mb_d6">{!! $xsmbDuoi[6] !!}</td>
                                <td class="clnote">6</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-7" id="loto_mb_d7">{!! $xsmbDuoi[7] !!}</td>
                                <td class="clnote">7</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-8" id="loto_mb_d8">{!! $xsmbDuoi[8] !!}</td>
                                <td class="clnote">8</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-9" id="loto_mb_d9">{!! $xsmbDuoi[9] !!}</td>
                                <td class="clnote">9</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="see-more">
                    <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm: Xổ Số Miền Bắc</div>
                    <ul class="list-html-link two-column">
                        <li>Xem thêm kết quả <a href="{{route('tk.lo-gan','mb')}}"
                                        title="thống kê lô gan miền Bắc">thống kê lô gan miền Bắc</a></li>
                        <li>Tham gia <a href="{{route('quay_thu.mb')}}"
                                        title="quay thử miền Bắc">quay thử xổ số miền Bắc</a> để thử vận may
                        </li>
                        <li>Hãy soi <a href="{{route('scmb.cau-bach-thu')}}"
                                       title="cầu bạch thủ miền Bắc">cầu bạch thủ miền Bắc</a> để chọn bộ số ngon nhất
                        </li>
                        <li>Xem thêm bảng kết quả <a
                                    href="{{route('xsmb.skq')}}"
                                    title="XSMB 30 ngày">XSMB 30 ngày gần nhất </a></li>
                    </ul>
                         <div class="box-content">
                    
                   <p> <strong> <a href="{{route('xsmb.date',getNgayLink($date))}}" title="Xổ số miền Bắc XSMB{{getNgay($date)}}">Xổ số miền Bắc {{getNgay($date)}}</a> </li> - Kết quả xổ số miền Bắc hôm nay nhanh nhất tại xstailoc.com Xổ số miền Bắc {{getNgay($date)}}</strong>
                    </p>
                    </li>Trực tiếp xsmb {{getThu(getThuNumber($date))}} ngày <a href="{{route('xsmb.date',getNgayLink($date))}}" title="Xổ số miền Bắc {{getNgay($date)}}">Xổ số miền Bắc {{getNgay($date)}}</a> </li> nhanh, chính xác nhất.

                    xsmb <a href="{{route('xsmb.date',getNgayLink($date))}}" title="Xổ số miền Bắc {{getNgay($date)}}"><strong>Xổ số miền Bắc {{getNgay($date)}} </strong> </a> </li>  - Kết quả xổ số miền Bắc hôm nay ngày <strong> Xổ số miền Bắc {{getNgay($date)}}</strong> </li> trực tiếp lúc 16 giờ 15 phút. Xổ số hôm nay Xổ số miền Bắc {{getNgay($date)}} </li> - xsmb {{getThu(getThuNumber($date))}} hàng tuần được mở thưởng bởi công ty xổ số kiến thiết của đài hôm nay  . Kết quả xổ số miền Bắc <a href="{{route('xsmb.date',getNgayLink($date))}}" title="Xổ số miền Bắc {{getNgay($date)}}">Xổ số miền Bắc {{getNgay($date)}}</a> </li> bắt đầu quay từ giải tám cho đến giải nhất và cuối cùng là giải đặc biệt.
                    
                    Kết quả xsmb <a href="{{route('xsmb.date',getNgayLink($date))}}" title="Xổ số miền BắcXSMB {{getNgay($date)}}">Xổ số miền Bắc {{getNgay($date)}}</a> </li> - Xổ số miền Bắc hôm nay - Trực tiếp KQXS miền Bắc {{getThu(getThuNumber($date))}} ngày  Xổ số miền Bắc {{getNgay($date)}} </li> 
                    <p><h2> <strong> Các Câu Hỏi Thường Gặp Về Xổ Số Miền Bắc {{getNgay($date)}} {{getThu(getThuNumber($date))}}</strong> </h2> </p>
                    <p><h3> <strong> Làm thế nào để biết kết quả xổ số miền Bắc {{getNgay($date)}}</strong>  </h3></p>

                    <p>Kết quả xổ số miền Bắc XSMB{{getNgay($date)}} được công bố trên các trang web xstailoc.com đề hoặc trên các kênh truyền hình vào mỗi ngày. </p>

                    <p><h3> <strong>  Tôi có thể mua vé xổ số miền Bắc ngày  {{getNgay($date)}} ở đâu? </strong>  </h3></p>

                    <p>Bạn có thể mua vé xổ số miền Bắc XSMB {{getNgay($date)}}  tại các điểm bán vé hoặc trên các trang web và ứng dụng xổ số trực tuyến. </p>

                   <p><h3> <strong>  Tôi có thể chơi xổ số miền Bắc {{getNgay($date)}} trên điện thoại di động không? </strong>  </h3></p>

                   <p> Hiện nay, có rất nhiều ứng dụng cho phép bạn chơi xổ số miền Bắc  {{getNgay($date)}} trực tuyến trên điện thoại di động. </p>

                       <p><h3> <strong> Tôi có thể đổi vé xổ số miền Bắc XSMB {{getNgay($date)}} không? </strong>  </h3></p>
                    
                    <p> Không, vé xổ số miền Bắc  {{getNgay($date)}} không thể đổi hoặc hoàn lại sau khi đã mua.</p>
                    
                       <p><h3> <strong> Tôi có thể chơi xổ số miền Bắc XSMB{{getNgay($date)}}nhiều lần trong ngày không? </strong>  </h3></p>
                    
                    <p> Có, bạn có thể chơi xổ số miền Bắc XSMB {{getNgay($date)}} nhiều lần trong ngày với các kết quả xổ số khác nhau.</p>
                 </div>
                </div>
            </div>
        @else
            <div class="box">
                <div class="bg_gray">
                    <div class=" opt_date_full clearfix">
                        <label><strong>{{getThu(getThuNumber($date))}}</strong> - <input
                                    type="text" class="nobor" value="{{getNgayLink($date)}}" id="searchDateMB"/><span
                                    class='ic ic-calendar'></span></label>
                    </div>
                </div>
            </div>
            <div class="box" id='kqngay_{{date('dmY', strtotime(getNgayLink($date)))}}'>
                <h2 class="tit-mien clearfix">
                    <strong>
                        <a class="title-a" href="{{route('xsmb')}}" title="XSMB">XSMB</a>
                        » <a class="title-a" href="{{route(getRouteDay(getThuNumber($date),'xsmb'))}}"
                             title="XSMB {{getThu(getThuNumber($date))}}">XSMB {{getThu(getThuNumber($date))}}</a>
                        » <a class="title-a" href="{{route('xsmb.date',getNgayLink($date))}}"
                             title="XSMB {{getNgay($date)}}">XSMB {{getNgay($date)}}</a></strong></h2>

                <div id="load_kq_mb_0">
                    <div data-id="kq" class="one-city" data-region="1">
                        <table class="kqmb extendable">
                            <tbody>
                            <tr>
                                <td colspan="13" class="v-giai madb"><span class="v-madb"><i class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr class="db">
                                <td class="txt-giai">ĐB</td>
                                <td class="v-giai number "><span data-nc="5" class="v-gdb "><i class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.1</td>
                                <td class="v-giai number"><span data-nc="5" class="v-g1 "><i class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.2</td>
                                <td class="v-giai number"><span data-nc="5" class="v-g2-0 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g2-1 "><i class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.3</td>
                                <td class="v-giai number"><span data-nc="5" class="v-g3-0 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g3-1 "><i class="fas fa-spinner fa-pulse"></i></span><span data-nc="5"
                                                                                              class="v-g3-2 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g3-3 "><i class="fas fa-spinner fa-pulse"></i></span><span data-nc="5"
                                                                                              class="v-g3-4 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g3-5 "><i class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.4</td>
                                <td class="v-giai number"><span data-nc="4" class="v-g4-0 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g4-1 "><i class="fas fa-spinner fa-pulse"></i></span><span data-nc="4"
                                                                                              class="v-g4-2 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g4-3 "><i class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.5</td>
                                <td class="v-giai number"><span data-nc="4" class="v-g5-0 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g5-1 "><i class="fas fa-spinner fa-pulse"></i></span><span data-nc="4"
                                                                                              class="v-g5-2 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g5-3 "><i class="fas fa-spinner fa-pulse"></i></span><span data-nc="4"
                                                                                              class="v-g5-4 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g5-5 "><i class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.6</td>
                                <td class="v-giai number"><span data-nc="3" class="v-g6-0 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="3" class="v-g6-1 "><i class="fas fa-spinner fa-pulse"></i></span><span data-nc="3"
                                                                                              class="v-g6-2 "><i class="fas fa-spinner fa-pulse"></i></span>
                                </td>
                            </tr>
                            <tr class="g7">
                                <td class="txt-giai">G.7</td>
                                <td class="v-giai number"><span data-nc="2" class="v-g7-0 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="2" class="v-g7-1 "><i class="fas fa-spinner fa-pulse"></i></span><span data-nc="2"
                                                                                              class="v-g7-2 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="2" class="v-g7-3 "><i class="fas fa-spinner fa-pulse"></i></span></td>
                            </tr>
                            </tbody>
                        </table>
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
                                <td class="v-loto-dau-0"></td>
                            </tr>
                            <tr>
                                <td class="clnote">1</td>
                                <td class="v-loto-dau-1"></td>
                            </tr>
                            <tr>
                                <td class="clnote">2</td>
                                <td class="v-loto-dau-2"></td>
                            </tr>
                            <tr>
                                <td class="clnote">3</td>
                                <td class="v-loto-dau-3"></td>
                            </tr>
                            <tr>
                                <td class="clnote">4</td>
                                <td class="v-loto-dau-4"></td>
                            </tr>
                            <tr>
                                <td class="clnote">5</td>
                                <td class="v-loto-dau-5"></td>
                            </tr>
                            <tr>
                                <td class="clnote">6</td>
                                <td class="v-loto-dau-6"></td>
                            </tr>
                            <tr>
                                <td class="clnote">7</td>
                                <td class="v-loto-dau-7"></td>
                            </tr>
                            <tr>
                                <td class="clnote">8</td>
                                <td class="v-loto-dau-8"></td>
                            </tr>
                            <tr>
                                <td class="clnote">9</td>
                                <td class="v-loto-dau-9"></td>
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
                                <td class="v-loto-duoi-0"></td>
                                <td class="clnote">0</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-1"></td>
                                <td class="clnote">1</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-2"></td>
                                <td class="clnote">2</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-3"></td>
                                <td class="clnote">3</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-4"></td>
                                <td class="clnote">4</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-5"></td>
                                <td class="clnote">5</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-6"></td>
                                <td class="clnote">6</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-7"></td>
                                <td class="clnote">7</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-8"></td>
                                <td class="clnote">8</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-9"></td>
                                <td class="clnote">9</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="see-more">
                    <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
                    <ul class="list-html-link two-column">
                        <li>Xem thêm  Kết Quả <a href="{{route('tk.lo-gan','mb')}}"
                                        title="thống kê lô gan miền Bắc">thống kê lô gan miền Bắc</a></li>
                        <li>Tham gia <a href="{{route('quay_thu.mb')}}"
                                        title="quay thử miền Bắc">quay thử miền Bắc</a> để thử vận may
                        </li>
                        <li>Hãy soi <a href="{{route('scmb.cau-bach-thu')}}"
                                       title="cầu bạch thủ miền Bắc">cầu bạch thủ miền Bắc</a> để chọn bộ số ngon nhất
                        </li>
                        <li>Xem thêm bảng kết quả XSMB <a
                                    href="{{route('xsmb.skq')}}"
                                    title="XSMB 30 ngày">XSMB 30 ngày</a></li>
                    </ul>
                     <div class="box-content">
                    
                   <p> <strong> <a href="{{route('xsmb.date',getNgayLink($date))}}" title="Xổ số miền Bắc XSMB{{getNgay($date)}}">Xổ số miền Bắc {{getNgay($date)}}</a> </li> - Kết quả xổ số miền Bắc hôm nay nhanh nhất tại xstailoc.com Xổ số miền Bắc {{getNgay($date)}}</strong>
                    </p>
                    </li>Trực tiếp xsmb {{getThu(getThuNumber($date))}} ngày <a href="{{route('xsmb.date',getNgayLink($date))}}" title="Xổ số miền Bắc {{getNgay($date)}}">Xổ số miền Bắc {{getNgay($date)}}</a> </li> nhanh, chính xác nhất.

                    xsmb <a href="{{route('xsmb.date',getNgayLink($date))}}" title="Xổ số miền Bắc {{getNgay($date)}}"><strong>Xổ số miền Bắc {{getNgay($date)}} </strong> </a> </li>  - Kết quả xổ số miền Bắc hôm nay ngày <strong> Xổ số miền Bắc {{getNgay($date)}}</strong> </li> trực tiếp lúc 16 giờ 15 phút. Xổ số hôm nay Xổ số miền Bắc {{getNgay($date)}} </li> - xsmb {{getThu(getThuNumber($date))}} hàng tuần được mở thưởng bởi công ty xổ số kiến thiết của đài hôm nay  . Kết quả xổ số miền Bắc <a href="{{route('xsmb.date',getNgayLink($date))}}" title="Xổ số miền Bắc {{getNgay($date)}}">Xổ số miền Bắc {{getNgay($date)}}</a> </li> bắt đầu quay từ giải tám cho đến giải nhất và cuối cùng là giải đặc biệt.
                    
                    Kết quả xsmb <a href="{{route('xsmb.date',getNgayLink($date))}}" title="Xổ số miền BắcXSMB {{getNgay($date)}}">Xổ số miền Bắc {{getNgay($date)}}</a> </li> - Xổ số miền Bắc hôm nay - Trực tiếp KQXS miền Bắc {{getThu(getThuNumber($date))}} ngày  Xổ số miền Bắc {{getNgay($date)}} </li> 
                    <p><h2> <strong> Các Câu Hỏi Thường Gặp Về Xổ Số Miền Bắc {{getNgay($date)}} {{getThu(getThuNumber($date))}}</strong> </h2> </p>
                    <p><h3> <strong> Làm thế nào để biết kết quả xổ số miền Bắc {{getNgay($date)}}</strong>  </h3></p>

                    <p>Kết quả xổ số miền Bắc XSMB{{getNgay($date)}} được công bố trên các trang web xstailoc.com đề hoặc trên các kênh truyền hình vào mỗi ngày. </p>

                    <p><h3> <strong>  Tôi có thể mua vé xổ số miền Bắc ngày  {{getNgay($date)}} ở đâu? </strong>  </h3></p>

                    <p>Bạn có thể mua vé xổ số miền Bắc XSMB {{getNgay($date)}}  tại các điểm bán vé hoặc trên các trang web và ứng dụng xổ số trực tuyến. </p>

                   <p><h3> <strong>  Tôi có thể chơi xổ số miền Bắc {{getNgay($date)}} trên điện thoại di động không? </strong>  </h3></p>

                   <p> Hiện nay, có rất nhiều ứng dụng cho phép bạn chơi xổ số miền Bắc  {{getNgay($date)}} trực tuyến trên điện thoại di động. </p>

                       <p><h3> <strong> Tôi có thể đổi vé xổ số miền Bắc XSMB {{getNgay($date)}} không? </strong>  </h3></p>
                    
                    <p> Không, vé xổ số miền Bắc  {{getNgay($date)}} không thể đổi hoặc hoàn lại sau khi đã mua.</p>
                    
                       <p><h3> <strong> Tôi có thể chơi xổ số miền Bắc XSMB{{getNgay($date)}}nhiều lần trong ngày không? </strong>  </h3></p>
                    
                    <p> Có, bạn có thể chơi xổ số miền Bắc XSMB {{getNgay($date)}} nhiều lần trong ngày với các kết quả xổ số khác nhau.</p>
                 </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('afterJS')
    @if(!empty($xsmb) >0)
        @if($xsmb->date==date('Y-m-d',time()))
            <script src="{{url('frontend/js/lotteryLive.js')}}?v={{rand(1000,100000)}}"></script>
            <script type="text/javascript">

                var d = new Date();

                var utc = d.getTime() + (d.getTimezoneOffset() * 60000);

                var currentdate = new Date(utc + (3600000 * +7));

                var rootPath = '';

                var appKey = '';

                var headingTag = 'h1';

                var interval;

                var timeInter = 1357 * 4; //thoi gian refresh

                //                            var currentdate = new Date();

                var hours = currentdate.getHours();

                var minute = currentdate.getMinutes();


                try {

                    if ((hours == 18) && minute >= 10 && minute <= 40) {

                        LiveMB(appKey, rootPath, headingTag);

                        interval = setInterval("LiveMB('" + appKey + "', '" + rootPath + "', '" + headingTag + "')", timeInter);

                        intervalVariable = setInterval('getRandomTextMB()', 100);

                    }

                } catch (e) {

                    console.log(e.message);

                }

            </script>
        @endif
    @endif
@endsection

