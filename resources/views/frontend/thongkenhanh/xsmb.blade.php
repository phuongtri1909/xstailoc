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
<div class="box border-red" id='kqngay_{{date('dmY',time())}}'>
    <div class="tit-mien clearfix">
        <h2> XSMB - Xổ số miền Bắc ngày {{getNgay($xsmb->date)}}</h2>
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
                <tr class="db bg_ef">
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
                                      id="mb_prize_2_item_0">@if(!empty($g2[0])){{$g2[0]}}@endif</span><span data-nc="5" class="v-g2-1 "
                                                                                                             id="mb_prize_2_item_1">@if(!empty($g2[1])){{$g2[1]}}@endif</span>
                    </td>
                </tr>
                <tr>
                    <td class="txt-giai">G.3</td>
                    <td class="v-giai number">
                                <span data-nc="5" class="v-g3-0 "
                                      id="mb_prize_3_item_0">@if(!empty($g3[0])){{$g3[0]}}@endif</span><span data-nc="5" class="v-g3-1 "
                                                                                                             id="mb_prize_3_item_1">@if(!empty($g3[1])){{$g3[1]}}@endif</span><span data-nc="5" class="v-g3-2 "
                                                                                                                                                                                    id="mb_prize_3_item_2">@if(!empty($g3[2])){{$g3[2]}}@endif</span><span data-nc="5" class="v-g3-3 "
                                                                                                                                                                                                                                                           id="mb_prize_3_item_3">@if(!empty($g3[3])){{$g3[3]}}@endif</span><span data-nc="5" class="v-g3-4 "
                                                                                                                                                                                                                                                                                                                                  id="mb_prize_3_item_4">@if(!empty($g3[4])){{$g3[4]}}@endif</span><span data-nc="5" class="v-g3-5 "
                                                                                                                                                                                                                                                                                                                                                                                                         id="mb_prize_3_item_5">@if(!empty($g3[5])){{$g3[5]}}@endif</span>
                    </td>
                </tr>
                <tr class="bg_ef">
                    <td class="txt-giai">G.4</td>
                    <td class="v-giai number">
                                <span data-nc="4" class="v-g4-0 "
                                      id="mb_prize_4_item_0">@if(!empty($g4[0])){{$g4[0]}}@endif</span><span data-nc="4" class="v-g4-1 "
                                                                                                             id="mb_prize_4_item_1">@if(!empty($g4[1])){{$g4[1]}}@endif</span><span data-nc="4" class="v-g4-2 "
                                                                                                                                                                                    id="mb_prize_4_item_2">@if(!empty($g4[2])){{$g4[2]}}@endif</span><span data-nc="4" class="v-g4-3 "
                                                                                                                                                                                                                                                           id="mb_prize_4_item_3">@if(!empty($g4[3])){{$g4[3]}}@endif</span>
                    </td>
                </tr>
                <tr>
                    <td class="txt-giai">G.5</td>
                    <td class="v-giai number">
                                <span data-nc="4" class="v-g5-0 "
                                      id="mb_prize_5_item_0">@if(!empty($g5[0])){{$g5[0]}}@endif</span><span data-nc="4" class="v-g5-1 "
                                                                                                             id="mb_prize_5_item_1">@if(!empty($g5[1])){{$g5[1]}}@endif</span><span data-nc="4" class="v-g5-2 "
                                                                                                                                                                                    id="mb_prize_5_item_2">@if(!empty($g5[2])){{$g5[2]}}@endif</span><span data-nc="4" class="v-g5-3 "
                                                                                                                                                                                                                                                           id="mb_prize_5_item_3">@if(!empty($g5[3])){{$g5[3]}}@endif</span><span data-nc="4" class="v-g5-4 "
                                                                                                                                                                                                                                                                                                                                  id="mb_prize_5_item_4">@if(!empty($g5[4])){{$g5[4]}}@endif</span><span data-nc="4" class="v-g5-5 "
                                                                                                                                                                                                                                                                                                                                                                                                         id="mb_prize_5_item_5">@if(!empty($g5[5])){{$g5[5]}}@endif</span>
                    </td>
                </tr>
                <tr class="bg_ef">
                    <td class="txt-giai">G.6</td>
                    <td class="v-giai number">
                                <span data-nc="3" class="v-g6-0 "
                                      id="mb_prize_6_item_0">@if(!empty($g6[0])){{$g6[0]}}@endif</span><span data-nc="3" class="v-g6-1 "
                                                                                                             id="mb_prize_6_item_1">@if(!empty($g6[1])){{$g6[1]}}@endif</span><span data-nc="3" class="v-g6-2 "
                                                                                                                                                                                    id="mb_prize_6_item_2">@if(!empty($g6[2])){{$g6[2]}}@endif</span>
                    </td>
                </tr>
                <tr class="g7">
                    <td class="txt-giai">G.7</td>
                    <td class="v-giai number">
                                <span data-nc="2" class="v-g7-0 "
                                      id="mb_prize_7_item_0">@if(!empty($g7[0])){{$g7[0]}}@endif</span><span data-nc="2" class="v-g7-1 "
                                                                                                             id="mb_prize_7_item_1">@if(!empty($g7[1])){{$g7[1]}}@endif</span><span data-nc="2" class="v-g7-2 "
                                                                                                                                                                                    id="mb_prize_7_item_2">@if(!empty($g7[2])){{$g7[2]}}@endif</span><span data-nc="2" class="v-g7-3 "
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
    </div>
</div>

<div class="box-option">
    <div data-id="dd" class="col-firstlast" id="livebangkqlotomb">
        <table class="firstlast-mb fl">
            <tbody>
            <tr class="header">
                <th class="w-50px">Đầu</th>
                <th>Lô tô</th>
            </tr>
            <tr class="bg_ef">
                <td class="clnote">0</td>
                <td class="v-loto-dau-0 text-left" id="loto_mb_0">{!! $xsmbDau[0] !!}</td>
            </tr>
            <tr>
                <td class="clnote">1</td>
                <td class="v-loto-dau-1 text-left" id="loto_mb_1">{!! $xsmbDau[1] !!}</td>
            </tr>
            <tr class="bg_ef">
                <td class="clnote">2</td>
                <td class="v-loto-dau-2 text-left" id="loto_mb_2">{!! $xsmbDau[2] !!}</td>
            </tr>
            <tr>
                <td class="clnote">3</td>
                <td class="v-loto-dau-3 text-left" id="loto_mb_3">{!! $xsmbDau[3] !!}</td>
            </tr>
            <tr class="bg_ef">
                <td class="clnote">4</td>
                <td class="v-loto-dau-4 text-left" id="loto_mb_4">{!! $xsmbDau[4] !!}</td>
            </tr>
            <tr>
                <td class="clnote">5</td>
                <td class="v-loto-dau-5 text-left" id="loto_mb_5">{!! $xsmbDau[5] !!}</td>
            </tr>
            <tr class="bg_ef">
                <td class="clnote">6</td>
                <td class="v-loto-dau-6 text-left" id="loto_mb_6">{!! $xsmbDau[6] !!}</td>
            </tr>
            <tr>
                <td class="clnote">7</td>
                <td class="v-loto-dau-7 text-left" id="loto_mb_7">{!! $xsmbDau[7] !!}</td>
            </tr>
            <tr class="bg_ef">
                <td class="clnote">8</td>
                <td class="v-loto-dau-8 text-left" id="loto_mb_8">{!! $xsmbDau[8] !!}</td>
            </tr>
            <tr>
                <td class="clnote">9</td>
                <td class="v-loto-dau-9 text-left" id="loto_mb_9">{!! $xsmbDau[9] !!}</td>
            </tr>
            </tbody>
        </table>
        <table class="firstlast-mb fr">
            <tbody>
            <tr class="header">
                <th class="w-50px">Đuôi</th>
                <th>Lô tô</th>
            </tr>
            <tr class="bg_ef">
                <td class="clnote">0</td>
                <td class="v-loto-duoi-0" id="loto_mb_d0">{!! $xsmbDuoi[0] !!}</td>
            </tr>
            <tr>
                <td class="clnote">1</td>
                <td class="v-loto-duoi-1" id="loto_mb_d1">{!! $xsmbDuoi[1] !!}</td>
            </tr>
            <tr class="bg_ef">
                <td class="clnote">2</td>
                <td class="v-loto-duoi-2" id="loto_mb_d2">{!! $xsmbDuoi[2] !!}</td>
            </tr>
            <tr>
                <td class="clnote">3</td>
                <td class="v-loto-duoi-3" id="loto_mb_d3">{!! $xsmbDuoi[3] !!}</td>
            </tr>
            <tr class="bg_ef">
                <td class="clnote">4</td>
                <td class="v-loto-duoi-4" id="loto_mb_d4">{!! $xsmbDuoi[4] !!}</td>
            </tr>
            <tr>
                <td class="clnote">5</td>
                <td class="v-loto-duoi-5" id="loto_mb_d5">{!! $xsmbDuoi[5] !!}</td>
            </tr>
            <tr class="bg_ef">
                <td class="clnote">6</td>
                <td class="v-loto-duoi-6" id="loto_mb_d6">{!! $xsmbDuoi[6] !!}</td>
            </tr>
            <tr>
                <td class="clnote">7</td>
                <td class="v-loto-duoi-7" id="loto_mb_d7">{!! $xsmbDuoi[7] !!}</td>
            </tr>
            <tr class="bg_ef">
                <td class="clnote">8</td>
                <td class="v-loto-duoi-8" id="loto_mb_d8">{!! $xsmbDuoi[8] !!}</td>
            </tr>
            <tr>
                <td class="clnote">9</td>
                <td class="v-loto-duoi-9" id="loto_mb_d9">{!! $xsmbDuoi[9] !!}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
</div>
<div class="box-option p-10px m-y-20px">
    <div class="see-more">
        <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
        <ul class="list-html-link two-column">
            <li>Xem thêm <a href="{{route('tk.lo-gan','mb')}}"
                            title="thống kê lô gan miền Bắc">thống kê lô gan miền Bắc XSMB </a></li>
            <li>Tham gia <a href="{{route('quay_thu.mb')}}"
                            title="quay thử miền Bắc">quay thử miền Bắc</a> để thử vận may
            </li>
            <li>Hãy soi <a href="{{route('scmb.cau-bach-thu')}}"
                        title="cầu bạch thủ miền Bắc">cầu bạch thủ miền Bắc XSMB</a> để chọn bộ số ngon nhất
            </li>
            <li>Xem thêm bảng kết quả
                <a href="{{route('xsmb.skq')}}" title="XSMB 30 ngày">XSMB Xổ Số Miefn Bắc 30 ngày</a>
            </li>
        </ul>
    </div>
</div>
