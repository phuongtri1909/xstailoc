@php $dem=1; @endphp
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
    $arr_kq = explode('-', $xsmbStr);
    $kqStr = implode('', $arr_kq);

    $xsmbLoto = getLoto($xsmbStr);

    $date_section = getDateLienNhau($xsmb->date);

    $xsmbDau = getDau($xsmbLoto, substr($xsmb->gdb, strlen($xsmb->gdb) - 2, 2),1);
    $xsmbDuoi = getDuoi($xsmbLoto, substr($xsmb->gdb, strlen($xsmb->gdb) - 2, 2),1);
    ?>
    @if($dem==1)
        <div hidden id="cauDate">{{getDateLienNhau(date('Y-m-d', strtotime(getNgayLink($xsmb->date) . ' +1 days')))}}</div>
    @endif
    <div class="left kqxs-tables box" id="section_{{$dem}}">
        <div class="bang-kq" @if($type==2 && $dem==2) id="ketqua" @endif>
            <h2 class="tit-mien clearfix kq-title">Kết quả XSMB ngày {{getNgay($xsmb->date)}}</h2>
            <div class="one-city">
                <table id="result{{$date_section}}" class="kqmb">
                    <tbody>
                    <tr>
                        <td colspan="13" class="v-giai madb">
                            <span class="v-madb">{{str_replace('-',' - ',$xsmb->madb)}}</span>

                        </td>
                    </tr>
                    <tr class="db">
                        <td class="txt-giai">ĐB</td>
                        <td class="v-giai number "><span data-nc="5" class="v-gdb "><span onclick="setlotocolor(1)"
                                                                                          class="cau-xs"
                                                                                          id="mb_1_{{$date_section}}">{{$kqStr[0]}}</span><span
                                        onclick="setlotocolor(2)"
                                        class="cau-xs"
                                        id="mb_2_{{$date_section}}">{{$kqStr[1]}}</span><span
                                        onclick="setlotocolor(3)" class="cau-xs"
                                        id="mb_3_{{$date_section}}">{{$kqStr[2]}}</span><span onclick="setlotocolor(4)"
                                                                                              class="cau-xs"
                                                                                              id="mb_4_{{$date_section}}">{{$kqStr[3]}}</span><span
                                        onclick="setlotocolor(5)" class="cau-xs"
                                        id="mb_5_{{$date_section}}">{{$kqStr[4]}}</span></span></td>
                    </tr>
                    <tr><td class="txt-giai">G.1</td>
                        <td class="v-giai number">
                            <span data-nc="5" class="v-g1"><span onclick="setlotocolor(6)"
                                                                 class="cau-xs"
                                                                 id="mb_6_{{$date_section}}">{{$kqStr[5]}}</span><span
                                        onclick="setlotocolor(7)"
                                        class="cau-xs"
                                        id="mb_7_{{$date_section}}">{{$kqStr[6]}}</span><span
                                        onclick="setlotocolor(8)" class="cau-xs"
                                        id="mb_8_{{$date_section}}">{{$kqStr[7]}}</span><span onclick="setlotocolor(9)"
                                                                                              class="cau-xs"
                                                                                              id="mb_9_{{$date_section}}">{{$kqStr[8]}}</span><span
                                        onclick="setlotocolor(10)" class="cau-xs"
                                        id="mb_10_{{$date_section}}">{{$kqStr[9]}}</span></span>
                        </td>
                    </tr>
                    <tr class="bg_ef">
                        <td class="txt-giai">G.2</td>
                        <td class="v-giai number">
                            <span data-nc="5" class="v-g2-0 "><span onclick="setlotocolor(11)"
                                                                    class="cau-xs"
                                                                    id="mb_11_{{$date_section}}">{{$kqStr[10]}}</span><span
                                        onclick="setlotocolor(12)"
                                        class="cau-xs"
                                        id="mb_12_{{$date_section}}">{{$kqStr[11]}}</span><span
                                        onclick="setlotocolor(13)" class="cau-xs"
                                        id="mb_13_{{$date_section}}">{{$kqStr[12]}}</span><span
                                        onclick="setlotocolor(14)" class="cau-xs"
                                        id="mb_14_{{$date_section}}">{{$kqStr[13]}}</span><span
                                        onclick="setlotocolor(15)" class="cau-xs"
                                        id="mb_15_{{$date_section}}">{{$kqStr[14]}}</span></span><!--
                    --><span data-nc="5" class="v-g2-1 "><span onclick="setlotocolor(16)"
                                                               class="cau-xs"
                                                               id="mb_16_{{$date_section}}">{{$kqStr[15]}}</span><span
                                        onclick="setlotocolor(17)"
                                        class="cau-xs"
                                        id="mb_17_{{$date_section}}">{{$kqStr[16]}}</span><span
                                        onclick="setlotocolor(18)" class="cau-xs"
                                        id="mb_18_{{$date_section}}">{{$kqStr[17]}}</span><span
                                        onclick="setlotocolor(19)" class="cau-xs"
                                        id="mb_19_{{$date_section}}">{{$kqStr[18]}}</span><span
                                        onclick="setlotocolor(20)" class="cau-xs"
                                        id="mb_20_{{$date_section}}">{{$kqStr[19]}}</span></span>
                        </td>
                    </tr>
                    <tr><td class="txt-giai">G.3</td>
                        <td class="v-giai number">
                            <span data-nc="5" class="v-g3-0 "><span onclick="setlotocolor(21)"
                                                                    class="cau-xs"
                                                                    id="mb_21_{{$date_section}}">{{$kqStr[20]}}</span><span
                                        onclick="setlotocolor(22)"
                                        class="cau-xs"
                                        id="mb_22_{{$date_section}}">{{$kqStr[21]}}</span><span
                                        onclick="setlotocolor(23)" class="cau-xs"
                                        id="mb_23_{{$date_section}}">{{$kqStr[22]}}</span><span
                                        onclick="setlotocolor(24)" class="cau-xs"
                                        id="mb_24_{{$date_section}}">{{$kqStr[23]}}</span><span
                                        onclick="setlotocolor(25)" class="cau-xs"
                                        id="mb_25_{{$date_section}}">{{$kqStr[24]}}</span></span><!--
                    --><span data-nc="5" class="v-g3-1 "><span onclick="setlotocolor(26)"
                                                               class="cau-xs"
                                                               id="mb_26_{{$date_section}}">{{$kqStr[25]}}</span><span
                                        onclick="setlotocolor(27)"
                                        class="cau-xs"
                                        id="mb_27_{{$date_section}}">{{$kqStr[26]}}</span><span
                                        onclick="setlotocolor(28)" class="cau-xs"
                                        id="mb_28_{{$date_section}}">{{$kqStr[27]}}</span><span
                                        onclick="setlotocolor(29)" class="cau-xs"
                                        id="mb_29_{{$date_section}}">{{$kqStr[28]}}</span><span
                                        onclick="setlotocolor(30)" class="cau-xs"
                                        id="mb_30_{{$date_section}}">{{$kqStr[29]}}</span></span><!--
                    --><span data-nc="5" class="v-g3-2 "><span onclick="setlotocolor(31)"
                                                               class="cau-xs"
                                                               id="mb_31_{{$date_section}}">{{$kqStr[30]}}</span><span
                                        onclick="setlotocolor(32)"
                                        class="cau-xs"
                                        id="mb_32_{{$date_section}}">{{$kqStr[31]}}</span><span
                                        onclick="setlotocolor(33)" class="cau-xs"
                                        id="mb_33_{{$date_section}}">{{$kqStr[32]}}</span><span
                                        onclick="setlotocolor(34)" class="cau-xs"
                                        id="mb_34_{{$date_section}}">{{$kqStr[33]}}</span><span
                                        onclick="setlotocolor(35)" class="cau-xs"
                                        id="mb_35_{{$date_section}}">{{$kqStr[34]}}</span></span><!--
                    --><span data-nc="5" class="v-g3-3 "><span onclick="setlotocolor(36)"
                                                               class="cau-xs"
                                                               id="mb_36_{{$date_section}}">{{$kqStr[35]}}</span><span
                                        onclick="setlotocolor(37)"
                                        class="cau-xs"
                                        id="mb_37_{{$date_section}}">{{$kqStr[36]}}</span><span
                                        onclick="setlotocolor(38)" class="cau-xs"
                                        id="mb_38_{{$date_section}}">{{$kqStr[37]}}</span><span
                                        onclick="setlotocolor(39)" class="cau-xs"
                                        id="mb_39_{{$date_section}}">{{$kqStr[38]}}</span><span
                                        onclick="setlotocolor(40)" class="cau-xs"
                                        id="mb_40_{{$date_section}}">{{$kqStr[39]}}</span></span><!--
                    --><span data-nc="5" class="v-g3-4 "><span onclick="setlotocolor(41)"
                                                               class="cau-xs"
                                                               id="mb_41_{{$date_section}}">{{$kqStr[40]}}</span><span
                                        onclick="setlotocolor(42)"
                                        class="cau-xs"
                                        id="mb_42_{{$date_section}}">{{$kqStr[41]}}</span><span
                                        onclick="setlotocolor(43)" class="cau-xs"
                                        id="mb_43_{{$date_section}}">{{$kqStr[42]}}</span><span
                                        onclick="setlotocolor(44)" class="cau-xs"
                                        id="mb_44_{{$date_section}}">{{$kqStr[43]}}</span><span
                                        onclick="setlotocolor(45)" class="cau-xs"
                                        id="mb_45_{{$date_section}}">{{$kqStr[44]}}</span></span><!--
                    --><span data-nc="5" class="v-g3-5 "><span onclick="setlotocolor(46)"
                                                               class="cau-xs"
                                                               id="mb_46_{{$date_section}}">{{$kqStr[45]}}</span><span
                                        onclick="setlotocolor(47)"
                                        class="cau-xs"
                                        id="mb_47_{{$date_section}}">{{$kqStr[46]}}</span><span
                                        onclick="setlotocolor(48)" class="cau-xs"
                                        id="mb_48_{{$date_section}}">{{$kqStr[47]}}</span><span
                                        onclick="setlotocolor(49)" class="cau-xs"
                                        id="mb_49_{{$date_section}}">{{$kqStr[48]}}</span><span
                                        onclick="setlotocolor(50)" class="cau-xs"
                                        id="mb_50_{{$date_section}}">{{$kqStr[49]}}</span></span><!--
                --></td>
                    </tr>
                    <tr class="bg_ef">
                        <td class="txt-giai">G.4</td>
                        <td class="v-giai number">
                            <span data-nc="4" class="v-g4-0 "><span onclick="setlotocolor(51)"
                                                                    class="cau-xs"
                                                                    id="mb_51_{{$date_section}}">{{$kqStr[50]}}</span><span
                                        onclick="setlotocolor(52)"
                                        class="cau-xs"
                                        id="mb_52_{{$date_section}}">{{$kqStr[51]}}</span><span
                                        onclick="setlotocolor(53)" class="cau-xs"
                                        id="mb_53_{{$date_section}}">{{$kqStr[52]}}</span><span
                                        onclick="setlotocolor(54)" class="cau-xs"
                                        id="mb_54_{{$date_section}}">{{$kqStr[53]}}</span></span><!--
                    --><span data-nc="4" class="v-g4-1 "><span onclick="setlotocolor(55)"
                                                               class="cau-xs"
                                                               id="mb_55_{{$date_section}}">{{$kqStr[54]}}</span><span
                                        onclick="setlotocolor(56)"
                                        class="cau-xs"
                                        id="mb_56_{{$date_section}}">{{$kqStr[55]}}</span><span
                                        onclick="setlotocolor(57)" class="cau-xs"
                                        id="mb_57_{{$date_section}}">{{$kqStr[56]}}</span><span
                                        onclick="setlotocolor(58)" class="cau-xs"
                                        id="mb_58_{{$date_section}}">{{$kqStr[57]}}</span></span><!--
                    --><span data-nc="4" class="v-g4-2 "><span onclick="setlotocolor(59)"
                                                               class="cau-xs"
                                                               id="mb_59_{{$date_section}}">{{$kqStr[58]}}</span><span
                                        onclick="setlotocolor(60)"
                                        class="cau-xs"
                                        id="mb_60_{{$date_section}}">{{$kqStr[59]}}</span><span
                                        onclick="setlotocolor(61)" class="cau-xs"
                                        id="mb_61_{{$date_section}}">{{$kqStr[60]}}</span><span
                                        onclick="setlotocolor(62)" class="cau-xs"
                                        id="mb_62_{{$date_section}}">{{$kqStr[61]}}</span></span><!--
                    --><span data-nc="4" class="v-g4-3 "><span onclick="setlotocolor(63)"
                                                               class="cau-xs"
                                                               id="mb_63_{{$date_section}}">{{$kqStr[62]}}</span><span
                                        onclick="setlotocolor(64)"
                                        class="cau-xs"
                                        id="mb_64_{{$date_section}}">{{$kqStr[63]}}</span><span
                                        onclick="setlotocolor(65)" class="cau-xs"
                                        id="mb_65_{{$date_section}}">{{$kqStr[64]}}</span><span
                                        onclick="setlotocolor(66)" class="cau-xs"
                                        id="mb_66_{{$date_section}}">{{$kqStr[65]}}</span></span><!--
                --></td>
                    </tr>
                    <tr>
                        <td class="txt-giai">G.5</td>
                        <td class="v-giai number">
                            <span data-nc="4" class="v-g5-0 "><span onclick="setlotocolor(67)"
                                                                    class="cau-xs"
                                                                    id="mb_67_{{$date_section}}">{{$kqStr[66]}}</span><span
                                        onclick="setlotocolor(68)"
                                        class="cau-xs"
                                        id="mb_68_{{$date_section}}">{{$kqStr[67]}}</span><span
                                        onclick="setlotocolor(69)" class="cau-xs"
                                        id="mb_69_{{$date_section}}">{{$kqStr[68]}}</span><span
                                        onclick="setlotocolor(70)" class="cau-xs"
                                        id="mb_70_{{$date_section}}">{{$kqStr[69]}}</span></span><!--
                    --><span data-nc="4" class="v-g5-1 "><span onclick="setlotocolor(71)"
                                                               class="cau-xs"
                                                               id="mb_71_{{$date_section}}">{{$kqStr[70]}}</span><span
                                        onclick="setlotocolor(72)"
                                        class="cau-xs"
                                        id="mb_72_{{$date_section}}">{{$kqStr[71]}}</span><span
                                        onclick="setlotocolor(73)" class="cau-xs"
                                        id="mb_73_{{$date_section}}">{{$kqStr[72]}}</span><span
                                        onclick="setlotocolor(74)" class="cau-xs"
                                        id="mb_74_{{$date_section}}">{{$kqStr[73]}}</span></span><!--
                    --><span data-nc="4" class="v-g5-2 "><span onclick="setlotocolor(75)"
                                                               class="cau-xs"
                                                               id="mb_75_{{$date_section}}">{{$kqStr[74]}}</span><span
                                        onclick="setlotocolor(76)"
                                        class="cau-xs"
                                        id="mb_76_{{$date_section}}">{{$kqStr[75]}}</span><span
                                        onclick="setlotocolor(77)" class="cau-xs"
                                        id="mb_77_{{$date_section}}">{{$kqStr[76]}}</span><span
                                        onclick="setlotocolor(78)" class="cau-xs"
                                        id="mb_78_{{$date_section}}">{{$kqStr[77]}}</span></span><!--
                    --><span data-nc="4" class="v-g5-3 "><span onclick="setlotocolor(79)"
                                                               class="cau-xs"
                                                               id="mb_79_{{$date_section}}">{{$kqStr[78]}}</span><span
                                        onclick="setlotocolor(80)"
                                        class="cau-xs"
                                        id="mb_80_{{$date_section}}">{{$kqStr[79]}}</span><span
                                        onclick="setlotocolor(81)" class="cau-xs"
                                        id="mb_81_{{$date_section}}">{{$kqStr[80]}}</span><span
                                        onclick="setlotocolor(82)" class="cau-xs"
                                        id="mb_82_{{$date_section}}">{{$kqStr[81]}}</span></span><!--
                    --><span data-nc="4" class="v-g5-4 "><span onclick="setlotocolor(83)"
                                                               class="cau-xs"
                                                               id="mb_83_{{$date_section}}">{{$kqStr[82]}}</span><span
                                        onclick="setlotocolor(84)"
                                        class="cau-xs"
                                        id="mb_84_{{$date_section}}">{{$kqStr[83]}}</span><span
                                        onclick="setlotocolor(85)" class="cau-xs"
                                        id="mb_85_{{$date_section}}">{{$kqStr[84]}}</span><span
                                        onclick="setlotocolor(86)" class="cau-xs"
                                        id="mb_86_{{$date_section}}">{{$kqStr[85]}}</span></span><!--
                    --><span data-nc="4" class="v-g5-5 "><span onclick="setlotocolor(87)"
                                                               class="cau-xs"
                                                               id="mb_87_{{$date_section}}">{{$kqStr[86]}}</span><span
                                        onclick="setlotocolor(88)"
                                        class="cau-xs"
                                        id="mb_88_{{$date_section}}">{{$kqStr[87]}}</span><span
                                        onclick="setlotocolor(89)" class="cau-xs"
                                        id="mb_89_{{$date_section}}">{{$kqStr[88]}}</span><span
                                        onclick="setlotocolor(90)" class="cau-xs"
                                        id="mb_90_{{$date_section}}">{{$kqStr[89]}}</span></span><!--
                --></td>
                    </tr>
                    <tr class="bg_ef">
                        <td class="txt-giai">G.6</td>
                        <td class="v-giai number">
                            <span data-nc="3" class="v-g6-0 "><span onclick="setlotocolor(91)"
                                                                    class="cau-xs"
                                                                    id="mb_91_{{$date_section}}">{{$kqStr[90]}}</span><span
                                        onclick="setlotocolor(92)"
                                        class="cau-xs"
                                        id="mb_92_{{$date_section}}">{{$kqStr[91]}}</span><span
                                        onclick="setlotocolor(93)" class="cau-xs"
                                        id="mb_93_{{$date_section}}">{{$kqStr[92]}}</span></span><!--
                    --><span data-nc="3" class="v-g6-1 "><span onclick="setlotocolor(94)"
                                                               class="cau-xs"
                                                               id="mb_94_{{$date_section}}">{{$kqStr[93]}}</span><span
                                        onclick="setlotocolor(95)"
                                        class="cau-xs"
                                        id="mb_95_{{$date_section}}">{{$kqStr[94]}}</span><span
                                        onclick="setlotocolor(96)" class="cau-xs"
                                        id="mb_96_{{$date_section}}">{{$kqStr[95]}}</span></span><!--
                    --><span data-nc="3" class="v-g6-2 "><span onclick="setlotocolor(97)"
                                                               class="cau-xs"
                                                               id="mb_97_{{$date_section}}">{{$kqStr[96]}}</span><span
                                        onclick="setlotocolor(98)"
                                        class="cau-xs"
                                        id="mb_98_{{$date_section}}">{{$kqStr[97]}}</span><span
                                        onclick="setlotocolor(99)" class="cau-xs"
                                        id="mb_99_{{$date_section}}">{{$kqStr[98]}}</span></span><!--
                --></td>
                    </tr>
                    <tr class="g7"><td class="txt-giai">G.7</td>
                        <td class="v-giai number"><span onclick="setlotocolor(100)"
                                                        class="cau-xs"
                                                        id="mb_100_{{$date_section}}">{{$kqStr[99]}}</span><span
                                    onclick="setlotocolor(101)" class="cau-xs"
                                    id="mb_101_{{$date_section}}">{{$kqStr[100]}}</span></span><!--
                --><span data-nc="2" class="v-g7-1 "><span onclick="setlotocolor(102)"
                                                           class="cau-xs"
                                                           id="mb_102_{{$date_section}}">{{$kqStr[101]}}</span><span
                                        onclick="setlotocolor(103)" class="cau-xs"
                                        id="mb_103_{{$date_section}}">{{$kqStr[102]}}</span></span><!--
                    --><span data-nc="2" class="v-g7-2 "><span onclick="setlotocolor(104)"
                                                               class="cau-xs"
                                                               id="mb_104_{{$date_section}}">{{$kqStr[103]}}</span><span
                                        onclick="setlotocolor(105)" class="cau-xs"
                                        id="mb_105_{{$date_section}}">{{$kqStr[104]}}</span></span><!--
                    --><span data-nc="2" class="v-g7-3 "><span onclick="setlotocolor(106)"
                                                               class="cau-xs"
                                                               id="mb_106_{{$date_section}}">{{$kqStr[105]}}</span><span
                                        onclick="setlotocolor(107)" class="cau-xs"
                                        id="mb_107_{{$date_section}}">{{$kqStr[106]}}</span></span></td></tr>
                    </tbody></table></div>
            <div class="bang-loto s16 box-note  bold mag5">
                <div class="txt-center pad10">Bảng loto</div>
                <table>
                    <tbody>
                    <tr>
                        @php $d = 1;@endphp
                        @foreach($xsmbLoto as $loto)
                            <td class="lotob_{{$date_section}}_{{$loto}}">{{$loto}}</td>
                            @if($d%9==0) </tr>
                    <tr> @php $d=0; @endphp @endif
                        @php $d++;@endphp
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>    </div>
    @php $dem++; @endphp
@endforeach
