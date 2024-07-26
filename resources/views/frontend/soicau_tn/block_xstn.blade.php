@php $dem=1; @endphp
@foreach($xss as $xs)
    <?php
    $gdb = $xs->gdb;
    $g1 = $xs->g1;
    $g2 = explode('-', $xs->g2);
    $g3 = explode('-', $xs->g3);
    $g4 = explode('-', $xs->g4);
    $g5 = explode('-', $xs->g5);
    $g6 = explode('-', $xs->g6);
    $g7 = $xs->g7;
    $g8 = $xs->g8;

    $xsStr = $xs->g8 . '-' . $xs->g7 . '-' . $xs->g6 . '-' . $xs->g5 . '-' . $xs->g4 . '-' . $xs->g3 . '-' . $xs->g2 . '-' . $xs->g1. '-' . $xs->gdb;
    $arr_kq = explode('-', $xsStr);
    $kqStr = implode('', $arr_kq);

    $xsLoto = getLoto($xsStr);
    $xsDau = getDau($xsLoto, substr($xs->gdb, strlen($xs->gdb) - 2, 2),1);
    $xsDuoi = getDuoi($xsLoto, substr($xs->gdb, strlen($xs->gdb) - 2, 2),1);
    $date_section = getDateLienNhau($xs->date);
    ?>
    @if($dem==1)
        <div hidden id="cauDate">{{getDateLienNhau(date('Y-m-d', strtotime(getNgayLink($xs->date) . ' +1 days')))}}</div>
    @endif
    <div class="left kqxs-tables box" id="section_{{$dem}}">
        <div class="bang-kq"  @if($type==2 && $dem==2) id="ketqua" @endif>
            <h2 class="tit-mien clearfix kq-title">Kết quả {{$xs->province->name}} ngày {{getNgay($xs->date)}}</h2>
            <div id="kq" class="one-city">
                <table class="kqmb kqtinh"  id="result{{$date_section}}">
                    <tbody>
                    <tr class="g8">
                        <td class="txt-giai">G.8</td>
                        <td class="v-giai number"><span data-nc="2" class="v-g8 "><span onclick="setlotocolor(1)" class="cau-xs" id="{{strtoupper($xs->province->short_name)}}_1_{{$date_section}}">{{$kqStr[0]}}</span><span onclick="setlotocolor(2)" class="cau-xs" id="{{strtoupper($xs->province->short_name)}}_2_{{$date_section}}">{{$kqStr[1]}}</span></span></td>

                    </tr>
                    <tr class="bg_ef">
                        <td class="txt-giai">G.7</td>

                        <td class="v-giai number"><span onclick="setlotocolor(3)" class="cau-xs" id="{{strtoupper($xs->province->short_name)}}_3_{{$date_section}}">{{$kqStr[2]}}</span><span onclick="setlotocolor(4)" class="cau-xs" id="{{strtoupper($xs->province->short_name)}}_4_{{$date_section}}">{{$kqStr[3]}}</span><span onclick="setlotocolor(5)" class="cau-xs" id="{{strtoupper($xs->province->short_name)}}_5_{{$date_section}}">{{$kqStr[4]}}</span></td>
                    </tr>
                    <tr>
                        <td class="txt-giai">G.6</td>
                        <td class="v-giai number">
                            <span data-nc="4" class="v-g6-0 "><span onclick="setlotocolor(6)" class="cau-xs"
                                                                    id="{{strtoupper($xs->province->short_name)}}_6_{{$date_section}}">{{$kqStr[5]}}</span><span
                                        onclick="setlotocolor(7)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_7_{{$date_section}}">{{$kqStr[6]}}</span><span
                                        onclick="setlotocolor(8)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_8_{{$date_section}}">{{$kqStr[7]}}</span><span
                                        onclick="setlotocolor(9)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_9_{{$date_section}}">{{$kqStr[8]}}</span></span><!--
               --><span data-nc="4" class="v-g6-1 "><span onclick="setlotocolor(10)" class="cau-xs"
                                                          id="{{strtoupper($xs->province->short_name)}}_10_{{$date_section}}">{{$kqStr[9]}}</span><span
                                        onclick="setlotocolor(11)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_11_{{$date_section}}">{{$kqStr[10]}}</span><span
                                        onclick="setlotocolor(12)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_12_{{$date_section}}">{{$kqStr[11]}}</span><span
                                        onclick="setlotocolor(13)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_13_{{$date_section}}">{{$kqStr[12]}}</span></span><!--
               --><span data-nc="4" class="v-g6-2 "><span onclick="setlotocolor(14)" class="cau-xs"
                                                          id="{{strtoupper($xs->province->short_name)}}_14_{{$date_section}}">{{$kqStr[13]}}</span><span
                                        onclick="setlotocolor(15)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_15_{{$date_section}}">{{$kqStr[14]}}</span><span
                                        onclick="setlotocolor(16)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_16_{{$date_section}}">{{$kqStr[15]}}</span><span
                                        onclick="setlotocolor(17)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_17_{{$date_section}}">{{$kqStr[16]}}</span></span>
                        </td>
                    </tr>
                    <tr class="bg_ef">
                        <td class="txt-giai">G.5</td>
                        <td class="v-giai number">
                            <span data-nc="4" class="v-g5 "><span onclick="setlotocolor(18)" class="cau-xs"
                                                                  id="{{strtoupper($xs->province->short_name)}}_18_{{$date_section}}">{{$kqStr[17]}}</span><span
                                        onclick="setlotocolor(19)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_19_{{$date_section}}">{{$kqStr[18]}}</span><span
                                        onclick="setlotocolor(20)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_20_{{$date_section}}">{{$kqStr[19]}}</span><span
                                        onclick="setlotocolor(21)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_21_{{$date_section}}">{{$kqStr[20]}}</span></span>
                        </td>
                    </tr>

                    <tr class="g4">
                        <td class="titgiai">G.4</td>
                        <td class="v-giai number">
                            <span data-nc="5" class="v-g4-0 "><span onclick="setlotocolor(22)" class="cau-xs"
                                                                    id="{{strtoupper($xs->province->short_name)}}_22_{{$date_section}}">{{$kqStr[21]}}</span><span
                                        onclick="setlotocolor(23)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_23_{{$date_section}}">{{$kqStr[22]}}</span><span
                                        onclick="setlotocolor(24)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_24_{{$date_section}}">{{$kqStr[23]}}</span><span
                                        onclick="setlotocolor(25)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_25_{{$date_section}}">{{$kqStr[24]}}</span><span
                                        onclick="setlotocolor(26)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_26_{{$date_section}}">{{$kqStr[25]}}</span></span><!--
                                    --><span data-nc="5" class="v-g4-1 "><span onclick="setlotocolor(27)" class="cau-xs"
                                                                               id="{{strtoupper($xs->province->short_name)}}_27_{{$date_section}}">{{$kqStr[26]}}</span><span
                                        onclick="setlotocolor(28)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_28_{{$date_section}}">{{$kqStr[27]}}</span><span
                                        onclick="setlotocolor(29)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_29_{{$date_section}}">{{$kqStr[28]}}</span><span
                                        onclick="setlotocolor(30)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_30_{{$date_section}}">{{$kqStr[29]}}</span><span
                                        onclick="setlotocolor(31)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_31_{{$date_section}}">{{$kqStr[30]}}</span></span><!--
                                    --><span data-nc="5" class="v-g4-2 "><span onclick="setlotocolor(32)" class="cau-xs"
                                                                               id="{{strtoupper($xs->province->short_name)}}_32_{{$date_section}}">{{$kqStr[31]}}</span><span
                                        onclick="setlotocolor(33)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_33_{{$date_section}}">{{$kqStr[32]}}</span><span
                                        onclick="setlotocolor(34)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_34_{{$date_section}}">{{$kqStr[33]}}</span><span
                                        onclick="setlotocolor(35)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_35_{{$date_section}}">{{$kqStr[34]}}</span><span
                                        onclick="setlotocolor(36)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_36_{{$date_section}}">{{$kqStr[35]}}</span></span><!--
                                    --><span data-nc="5" class="v-g4-3 "><span onclick="setlotocolor(37)" class="cau-xs"
                                                                               id="{{strtoupper($xs->province->short_name)}}_37_{{$date_section}}">{{$kqStr[36]}}</span><span
                                        onclick="setlotocolor(38)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_38_{{$date_section}}">{{$kqStr[37]}}</span><span
                                        onclick="setlotocolor(39)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_39_{{$date_section}}">{{$kqStr[38]}}</span><span
                                        onclick="setlotocolor(40)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_40_{{$date_section}}">{{$kqStr[39]}}</span><span
                                        onclick="setlotocolor(41)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_41_{{$date_section}}">{{$kqStr[40]}}</span></span><!--
                                    --><span data-nc="5" class="v-g4-4 "><span onclick="setlotocolor(42)" class="cau-xs"
                                                                               id="{{strtoupper($xs->province->short_name)}}_42_{{$date_section}}">{{$kqStr[41]}}</span><span
                                        onclick="setlotocolor(43)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_43_{{$date_section}}">{{$kqStr[42]}}</span><span
                                        onclick="setlotocolor(44)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_44_{{$date_section}}">{{$kqStr[43]}}</span><span
                                        onclick="setlotocolor(45)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_45_{{$date_section}}">{{$kqStr[44]}}</span><span
                                        onclick="setlotocolor(46)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_46_{{$date_section}}">{{$kqStr[45]}}</span></span><!--
                                    --><span data-nc="5" class="v-g4-5 "><span onclick="setlotocolor(47)" class="cau-xs"
                                                                               id="{{strtoupper($xs->province->short_name)}}_47_{{$date_section}}">{{$kqStr[46]}}</span><span
                                        onclick="setlotocolor(48)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_48_{{$date_section}}">{{$kqStr[47]}}</span><span
                                        onclick="setlotocolor(49)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_49_{{$date_section}}">{{$kqStr[48]}}</span><span
                                        onclick="setlotocolor(50)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_50_{{$date_section}}">{{$kqStr[49]}}</span><span
                                        onclick="setlotocolor(51)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_51_{{$date_section}}">{{$kqStr[50]}}</span></span><!--
                                    --><span data-nc="5" class="v-g4-6 "><span onclick="setlotocolor(52)" class="cau-xs"
                                                                               id="{{strtoupper($xs->province->short_name)}}_52_{{$date_section}}">{{$kqStr[51]}}</span><span
                                        onclick="setlotocolor(53)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_53_{{$date_section}}">{{$kqStr[52]}}</span><span
                                        onclick="setlotocolor(54)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_54_{{$date_section}}">{{$kqStr[53]}}</span><span
                                        onclick="setlotocolor(55)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_55_{{$date_section}}">{{$kqStr[54]}}</span><span
                                        onclick="setlotocolor(56)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_56_{{$date_section}}">{{$kqStr[55]}}</span></span></td>
                    </tr>

                    <tr class="bg_ef">
                        <td class="txt-giai">G.3</td>
                        <td class="v-giai number">
                            <span data-nc="5" class="v-g3-0 "><span onclick="setlotocolor(57)" class="cau-xs"
                                                                    id="{{strtoupper($xs->province->short_name)}}_57_{{$date_section}}">{{$kqStr[56]}}</span><span
                                        onclick="setlotocolor(58)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_58_{{$date_section}}">{{$kqStr[57]}}</span><span
                                        onclick="setlotocolor(59)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_59_{{$date_section}}">{{$kqStr[58]}}</span><span
                                        onclick="setlotocolor(60)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_60_{{$date_section}}">{{$kqStr[59]}}</span><span
                                        onclick="setlotocolor(61)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_61_{{$date_section}}">{{$kqStr[60]}}</span></span><!--
                                        --><span data-nc="5" class="v-g3-1 "><span onclick="setlotocolor(62)" class="cau-xs"
                                                                                   id="{{strtoupper($xs->province->short_name)}}_62_{{$date_section}}">{{$kqStr[61]}}</span><span
                                        onclick="setlotocolor(63)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_63_{{$date_section}}">{{$kqStr[62]}}</span><span
                                        onclick="setlotocolor(64)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_64_{{$date_section}}">{{$kqStr[63]}}</span><span
                                        onclick="setlotocolor(65)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_65_{{$date_section}}">{{$kqStr[64]}}</span><span
                                        onclick="setlotocolor(66)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_66_{{$date_section}}">{{$kqStr[65]}}</span></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="txt-giai">G.2</td>
                        <td class="v-giai number">
                            <span data-nc="5" class="v-g2 "><span onclick="setlotocolor(67)" class="cau-xs"
                                                                  id="{{strtoupper($xs->province->short_name)}}_67_{{$date_section}}">{{$kqStr[66]}}</span><span
                                        onclick="setlotocolor(68)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_68_{{$date_section}}">{{$kqStr[67]}}</span><span
                                        onclick="setlotocolor(69)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_69_{{$date_section}}">{{$kqStr[68]}}</span><span
                                        onclick="setlotocolor(70)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_70_{{$date_section}}">{{$kqStr[69]}}</span><span
                                        onclick="setlotocolor(71)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_71_{{$date_section}}">{{$kqStr[70]}}</span></span>
                        </td>
                    </tr>
                    <tr class="bg_ef">
                        <td class="txt-giai">G.1</td>
                        <td class="v-giai number"><span data-nc="5" class="v-g1 "><span onclick="setlotocolor(72)" class="cau-xs"
                                                                                        id="{{strtoupper($xs->province->short_name)}}_72_{{$date_section}}">{{$kqStr[71]}}</span><span
                                        onclick="setlotocolor(73)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_73_{{$date_section}}">{{$kqStr[72]}}</span><span
                                        onclick="setlotocolor(74)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_74_{{$date_section}}">{{$kqStr[73]}}</span><span
                                        onclick="setlotocolor(75)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_75_{{$date_section}}">{{$kqStr[74]}}</span><span
                                        onclick="setlotocolor(76)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_76_{{$date_section}}">{{$kqStr[75]}}</span></span></td>
                    </tr>
                    <tr class="gdb db">
                        <td class="txt-giai">ĐB</td>
                        <td class="v-giai number"><span data-nc="6" class="v-gdb "><span onclick="setlotocolor(77)" class="cau-xs"
                                                                                         id="{{strtoupper($xs->province->short_name)}}_77_{{$date_section}}">{{$kqStr[76]}}</span><span
                                        onclick="setlotocolor(78)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_78_{{$date_section}}">{{$kqStr[77]}}</span><span
                                        onclick="setlotocolor(79)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_79_{{$date_section}}">{{$kqStr[78]}}</span><span
                                        onclick="setlotocolor(80)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_80_{{$date_section}}">{{$kqStr[79]}}</span><span
                                        onclick="setlotocolor(81)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_81_{{$date_section}}">{{$kqStr[80]}}</span><span
                                        onclick="setlotocolor(82)" class="cau-xs"
                                        id="{{strtoupper($xs->province->short_name)}}_82_{{$date_section}}">{{$kqStr[81]}}</span></span></td>
                    </tr>
                    </tbody></table></div>
            <div class="bang-loto s16 box-note  bold mag5">
                <div class="txt-center pad10">Bảng loto</div>
                <table>
                    <tbody>
                    <tr>
                        @php $d = 1;@endphp
                        @foreach($xsLoto as $loto)
                            <td class="lotob_{{$date_section}}_{{$loto}}">{{$loto}}</td>
                            @if($d%9==0) </tr>
                    <tr> @php $d=0; @endphp @endif
                        @php $d++;@endphp
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @php $dem++; @endphp
@endforeach
