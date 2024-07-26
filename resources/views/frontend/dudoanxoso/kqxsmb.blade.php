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
<div class="box">
    <div class="tit-mien clearfix">
        <h2>Kết quả xổ số miền Bắc {{getNgay($xsmb->date)}}</h2>

        <div>
            <a class="sub-title" href="{{route('xsmb')}}" title="XSMB">XSMB</a>
            » <a class="sub-title" href="{{route(getRouteDay($xsmb->day,'xsmb'))}}"
                 title="XSMB {{getThu($xsmb->day)}}">XSMB {{getThu($xsmb->day)}}</a>
            » <a class="sub-title" href="{{route('xsmb.date',getNgayLink($xsmb->date))}}"
                 title="XSMB ngày {{getNgay($xsmb->date)}}">XSMB ngày {{getNgay($xsmb->date)}}</a>
        </div>
    </div>
    <div>
        <div data-id="kq" class="one-city" data-region="1">
            <table class="kqmb extendable">
                <tbody>
                <tr>
                    <td colspan="13" class="v-giai madb"><span class="v-madb">{{str_replace('-',' - ',$xsmb->madb)}}</span>
                    </td>
                </tr>
                <tr class="db">
                    <td class="txt-giai">ĐB</td>
                    <td class="v-giai number "><span data-nc="5"
                                                     class="v-gdb ">@if(!empty($gdb)){{$gdb}}@endif</span></td>
                </tr>
                <tr>
                    <td class="txt-giai">G.1</td>
                    <td class="v-giai number"><span data-nc="5"
                                                    class="v-g1">@if(!empty($g1)){{$g1}}@endif</span></td>
                </tr>
                <tr class="bg_ef">
                    <td class="txt-giai">G.2</td>
                    <td class="v-giai number">
                        <span data-nc="5" class="v-g2-0 ">@if(!empty($g2[0])){{$g2[0]}}@endif</span><span data-nc="5" class="v-g2-1 ">@if(!empty($g2[1])){{$g2[1]}}@endif</span>
                    </td>
                </tr>
                <tr>
                    <td class="txt-giai">G.3</td>
                    <td class="v-giai number">
                        <span data-nc="5" class="v-g3-0 ">@if(!empty($g3[0])){{$g3[0]}}@endif</span><span data-nc="5" class="v-g3-1 ">@if(!empty($g3[1])){{$g3[1]}}@endif</span><span data-nc="5" class="v-g3-2 ">@if(!empty($g3[2])){{$g3[2]}}@endif</span><span data-nc="5" class="v-g3-3 ">@if(!empty($g3[3])){{$g3[3]}}@endif</span><span data-nc="5" class="v-g3-4 ">@if(!empty($g3[4])){{$g3[4]}}@endif</span><span data-nc="5" class="v-g3-5 ">@if(!empty($g3[5])){{$g3[5]}}@endif</span>
                    </td>
                </tr>
                <tr class="bg_ef">
                    <td class="txt-giai">G.4</td>
                    <td class="v-giai number">
                        <span data-nc="4" class="v-g4-0 ">@if(!empty($g4[0])){{$g4[0]}}@endif</span><span data-nc="4" class="v-g4-1 ">@if(!empty($g4[1])){{$g4[1]}}@endif</span><span data-nc="4" class="v-g4-2 ">@if(!empty($g4[2])){{$g4[2]}}@endif</span><span data-nc="4" class="v-g4-3 ">@if(!empty($g4[3])){{$g4[3]}}@endif</span>
                    </td>
                </tr>
                <tr>
                    <td class="txt-giai">G.5</td>
                    <td class="v-giai number">
                        <span data-nc="4" class="v-g5-0 ">@if(!empty($g5[0])){{$g5[0]}}@endif</span><span data-nc="4" class="v-g5-1 ">@if(!empty($g5[1])){{$g5[1]}}@endif</span><span data-nc="4" class="v-g5-2 ">@if(!empty($g5[2])){{$g5[2]}}@endif</span><span data-nc="4" class="v-g5-3 ">@if(!empty($g5[3])){{$g5[3]}}@endif</span><span data-nc="4" class="v-g5-4 ">@if(!empty($g5[4])){{$g5[4]}}@endif</span><span data-nc="4" class="v-g5-5 ">@if(!empty($g5[5])){{$g5[5]}}@endif</span>
                    </td>
                </tr>
                <tr class="bg_ef">
                    <td class="txt-giai">G.6</td>
                    <td class="v-giai number">
                        <span data-nc="3" class="v-g6-0 ">@if(!empty($g6[0])){{$g6[0]}}@endif</span><span data-nc="3" class="v-g6-1 ">@if(!empty($g6[1])){{$g6[1]}}@endif</span><span data-nc="3" class="v-g6-2 ">@if(!empty($g6[2])){{$g6[2]}}@endif</span>
                    </td>
                </tr>
                <tr class="g7">
                    <td class="txt-giai">G.7</td>
                    <td class="v-giai number">
                        <span data-nc="2" class="v-g7-0 ">@if(!empty($g7[0])){{$g7[0]}}@endif</span><span data-nc="2" class="v-g7-1 ">@if(!empty($g7[1])){{$g7[1]}}@endif</span><span data-nc="2" class="v-g7-2 ">@if(!empty($g7[2])){{$g7[2]}}@endif</span><span data-nc="2" class="v-g7-3 ">@if(!empty($g7[3])){{$g7[3]}}@endif</span>
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
        <div data-id="dd" class="col-firstlast">
            <table class="firstlast-mb fl">
                <tbody>
                <tr class="header">
                    <th>Đầu</th>
                    <th>Đuôi</th>
                </tr>
                <tr>
                    <td class="clnote">0</td>
                    <td class="v-loto-dau-0">{!! $xsmbDau[0] !!}</td>
                </tr>
                <tr>
                    <td class="clnote">1</td>
                    <td class="v-loto-dau-1">{!! $xsmbDau[1] !!}</td>
                </tr>
                <tr>
                    <td class="clnote">2</td>
                    <td class="v-loto-dau-2">{!! $xsmbDau[2] !!}</td>
                </tr>
                <tr>
                    <td class="clnote">3</td>
                    <td class="v-loto-dau-3">{!! $xsmbDau[3] !!}</td>
                </tr>
                <tr>
                    <td class="clnote">4</td>
                    <td class="v-loto-dau-4">{!! $xsmbDau[4] !!}</td>
                </tr>
                <tr>
                    <td class="clnote">5</td>
                    <td class="v-loto-dau-5">{!! $xsmbDau[5] !!}</td>
                </tr>
                <tr>
                    <td class="clnote">6</td>
                    <td class="v-loto-dau-6">{!! $xsmbDau[6] !!}</td>
                </tr>
                <tr>
                    <td class="clnote">7</td>
                    <td class="v-loto-dau-7">{!! $xsmbDau[7] !!}</td>
                </tr>
                <tr>
                    <td class="clnote">8</td>
                    <td class="v-loto-dau-8">{!! $xsmbDau[8] !!}</td>
                </tr>
                <tr>
                    <td class="clnote">9</td>
                    <td class="v-loto-dau-9">{!! $xsmbDau[9] !!}</td>
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
                    <td class="v-loto-duoi-0">{!! $xsmbDuoi[0] !!}</td>
                    <td class="clnote">0</td>
                </tr>
                <tr>
                    <td class="v-loto-duoi-1">{!! $xsmbDuoi[1] !!}</td>
                    <td class="clnote">1</td>
                </tr>
                <tr>
                    <td class="v-loto-duoi-2">{!! $xsmbDuoi[2] !!}</td>
                    <td class="clnote">2</td>
                </tr>
                <tr>
                    <td class="v-loto-duoi-3">{!! $xsmbDuoi[3] !!}</td>
                    <td class="clnote">3</td>
                </tr>
                <tr>
                    <td class="v-loto-duoi-4">{!! $xsmbDuoi[4] !!}</td>
                    <td class="clnote">4</td>
                </tr>
                <tr>
                    <td class="v-loto-duoi-5">{!! $xsmbDuoi[5] !!}</td>
                    <td class="clnote">5</td>
                </tr>
                <tr>
                    <td class="v-loto-duoi-6">{!! $xsmbDuoi[6] !!}</td>
                    <td class="clnote">6</td>
                </tr>
                <tr>
                    <td class="v-loto-duoi-7">{!! $xsmbDuoi[7] !!}</td>
                    <td class="clnote">7</td>
                </tr>
                <tr>
                    <td class="v-loto-duoi-8">{!! $xsmbDuoi[8] !!}</td>
                    <td class="clnote">8</td>
                </tr>
                <tr>
                    <td class="v-loto-duoi-9">{!! $xsmbDuoi[9] !!}</td>
                    <td class="clnote">9</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
