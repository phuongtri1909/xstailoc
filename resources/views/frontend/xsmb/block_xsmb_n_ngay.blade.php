@foreach($xsmbs as $xsmb)
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

    $xsmbDau = getDau($xsmbLoto,substr($xsmb->gdb, strlen($xsmb->gdb) - 2, 2));

    $xsmbDuoi = getDuoi($xsmbLoto,substr($xsmb->gdb, strlen($xsmb->gdb) - 2, 2));

    ?>
    <div class="three-city clearfix">

        <div data-id="kq" class="sub-col-l">
            <table class="kqmb">
                <tbody>
                <tr>
                    <th colspan="13">
                        <h2 class="bold">
                            <a class="title-a" href="{{route('xsmb.date',getNgayLink($xsmb->date))}}"
                               title="XSMB ngày {{getNgay($xsmb->date)}}">XSMB ngày {{getNgay($xsmb->date)}}</a>
                        </h2>
                    </th>
                </tr>
                <tr class="db">
                    <td class="txt-giai">ĐB</td>
                    <td colspan="12" class="number"><strong>@if(!empty($gdb)){{$gdb}}@endif</strong></td>
                </tr>
                <tr>
                    <td class="txt-giai">G1</td>
                    <td colspan="12" class="number"><strong>@if(!empty($g1)){{$g1}}@endif</strong></td>
                </tr>
                <tr>
                    <td class="txt-giai">G2</td>
                    <td colspan="6" class="number"><strong>@if(!empty($g2[0])){{$g2[0]}}@endif</strong></td>
                    <td colspan="6" class="number"><strong class="">@if(!empty($g2[1])){{$g2[1]}}@endif</strong></td>
                </tr>
                <tr class="giai3 ">
                    <td class="txt-giai" rowspan="2">G3</td>
                    <td class="number" colspan="4"><strong>@if(!empty($g3[0])){{$g3[0]}}@endif</strong></td>
                    <td class="number" colspan="4"><strong class="">@if(!empty($g3[1])){{$g3[1]}}@endif</strong></td>
                    <td class="number" colspan="4"><strong class="">@if(!empty($g3[2])){{$g3[2]}}@endif</strong></td>
                </tr>
                <tr>
                    <td class="number" colspan="4"><strong>@if(!empty($g3[3])){{$g3[3]}}@endif</strong></td>
                    <td class="number" colspan="4"><strong>@if(!empty($g3[4])){{$g3[4]}}@endif</strong></td>
                    <td class="number" colspan="4"><strong>@if(!empty($g3[5])){{$g3[5]}}@endif</strong></td>
                </tr>
                <tr>
                    <td class="txt-giai">G4</td>
                    <td colspan="3" class="number"><strong>@if(!empty($g4[0])){{$g4[0]}}@endif</strong></td>
                    <td colspan="3" class="number"><strong>@if(!empty($g4[1])){{$g4[1]}}@endif</strong></td>
                    <td colspan="3" class="number"><strong>@if(!empty($g4[2])){{$g4[2]}}@endif</strong></td>
                    <td colspan="3" class="number"><strong>@if(!empty($g4[3])){{$g4[3]}}@endif</strong></td>
                </tr>
                <tr class="giai5 ">
                    <td class="txt-giai" rowspan="2">G5</td>
                    <td class="number" colspan="4"><strong>@if(!empty($g5[0])){{$g5[0]}}@endif</strong></td>
                    <td class="number" colspan="4"><strong>@if(!empty($g5[1])){{$g5[1]}}@endif</strong></td>
                    <td class="number" colspan="4"><strong>@if(!empty($g5[2])){{$g5[2]}}@endif</strong></td>
                </tr>
                <tr>
                    <td class="number" colspan="4"><strong>@if(!empty($g5[3])){{$g5[3]}}@endif</strong></td>
                    <td class="number" colspan="4"><strong>@if(!empty($g5[4])){{$g5[4]}}@endif</strong></td>
                    <td class="number" colspan="4"><strong>@if(!empty($g5[5])){{$g5[5]}}@endif</strong></td>
                </tr>
                <tr>
                    <td class="txt-giai">G6</td>
                    <td colspan="4" class="number"><strong>@if(!empty($g6[0])){{$g6[0]}}@endif</strong></td>
                    <td colspan="4" class="number"><strong>@if(!empty($g6[1])){{$g6[1]}}@endif</strong></td>
                    <td colspan="4" class="number"><strong>@if(!empty($g6[2])){{$g6[2]}}@endif</strong></td>
                </tr>
                <tr class=" g7">
                    <td class="txt-giai">G7</td>
                    <td colspan="3" class="number"><strong>@if(!empty($g7[0])){{$g7[0]}}@endif</strong></td>
                    <td colspan="3" class="number"><strong>@if(!empty($g7[1])){{$g7[1]}}@endif</strong></td>
                    <td colspan="3" class="number"><strong>@if(!empty($g7[2])){{$g7[2]}}@endif</strong></td>
                    <td colspan="3" class="number"><strong>@if(!empty($g7[3])){{$g7[3]}}@endif</strong></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div data-id="dd" class="sub-col-r">
            <table class="firstlast-mb fl">
                <tbody>
                <tr class="header">
                    <th>Đầu</th>
                    <th>Đuôi</th>
                </tr>
                <tr>
                    <td><strong class="clnote">0</strong></td>
                    <td>{!! $xsmbDau[0] !!}</td>
                </tr>
                <tr>
                    <td><strong class="clnote">1</strong></td>
                    <td>{!! $xsmbDau[1] !!}</td>
                </tr>
                <tr>
                    <td><strong class="clnote">2</strong></td>
                    <td>{!! $xsmbDau[2] !!}</td>
                </tr>
                <tr>
                    <td><strong class="clnote">3</strong></td>
                    <td>{!! $xsmbDau[3] !!}</td>
                </tr>
                <tr>
                    <td><strong class="clnote">4</strong></td>
                    <td>{!! $xsmbDau[4] !!}</td>
                </tr>
                <tr>
                    <td><strong class="clnote">5</strong></td>
                    <td>{!! $xsmbDau[5] !!}</td>
                </tr>
                <tr>
                    <td><strong class="clnote">6</strong></td>
                    <td>{!! $xsmbDau[6] !!}</td>
                </tr>
                <tr>
                    <td><strong class="clnote">7</strong></td>
                    <td>{!! $xsmbDau[7] !!}</td>
                </tr>
                <tr>
                    <td><strong class="clnote">8</strong></td>
                    <td>{!! $xsmbDau[8] !!}</td>
                </tr>
                <tr>
                    <td><strong class="clnote">9</strong></td>
                    <td>{!! $xsmbDau[9] !!}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
    </div>
@endforeach