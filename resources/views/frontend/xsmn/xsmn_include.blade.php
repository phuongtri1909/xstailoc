@php $d = 1; @endphp

@foreach ($kqxsmns as $xsmns)
    @php

        $xsmnTinh = $xsmns[0];

        $count = count($xsmns);

        if ($count == 3) {
            $div_class = 'three-city';
            $table_class = 'colthreecity';
        } elseif ($count == 4) {
            $div_class = 'four-city';
            $table_class = 'colfourcity';
        }

    @endphp

    @if ($xsmnTinh->date == date('Y-m-d', time()))
        <div class="box" id='mn_kqngay_{{ getNgayID($xsmnTinh->date) }}'>
            <div class="tit-mien clearfix">
                <h2>XSMN - Kết quả xổ số miền Nam hôm nay {{ getNgay($xsmnTinh->date) }}</h2>

                <div><a class="sub-title" href="{{ route('xsmn') }}" title="XSMN">XSMN</a> »
                    <a class="sub-title" href="{{ route(getRouteDay($xsmnTinh->day, 'xsmn')) }}"
                        title="XSMN {{ getThu($xsmnTinh->day) }}">XSMN {{ getThu($xsmnTinh->day) }}</a> » <a
                        class="sub-title" href="{{ route('xsmn.date', getNgayLink($xsmnTinh->date)) }}"
                        title="XSMN ngày {{ getNgay($xsmnTinh->date) }}">XSMN ngày {{ getNgay($xsmnTinh->date) }}</a>
                </div>
            </div>
            <div id="load_kq_mn_0">
                <div data-id="kq" class="{{ $div_class }}" data-region="3">
                    <table class="{{ $table_class }} colgiai extendable">
                        <tbody>
                            <tr class="gr-yellow">
                                <th class="first"></th>
                                @foreach ($xsmns as $xsmn)
                                    <th data-pid="{{ $xsmn->id }}"><a
                                            href="{{ route('xstinh.tinh', $xsmn->province->slug) }}"
                                            title="Xổ số {{ $xsmn->province->name }}"
                                            class="underline bold">{{ $xsmn->province->name }}</a>
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="g8">
                                <td>G8</td>
                                @foreach ($xsmns as $xsmn)
                                    <td>
                                        <div data-nc="2" class="v-g8 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_8_item_0">
                                            {{ $xsmn->g8 }}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G7</td>
                                @foreach ($xsmns as $xsmn)
                                    <td>
                                        <div data-nc="3" class="v-g7 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_7_item_0">
                                            {{ $xsmn->g7 }}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G6</td>
                                @foreach ($xsmns as $xsmn)
                                    <?php $g6 = explode('-', $xsmn->g6); ?>
                                    <td>
                                        <div data-nc="4" class="v-g6-0 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_6_item_0">
                                            @if (!empty($g6[0]))
                                                {{ $g6[0] }}
                                            @endif
                                        </div>
                                        <div data-nc="4" class="v-g6-1 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_6_item_1">
                                            @if (!empty($g6[1]))
                                                {{ $g6[1] }}
                                            @endif
                                        </div>
                                        <div data-nc="4" class="v-g6-2 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_6_item_2">
                                            @if (!empty($g6[2]))
                                                {{ $g6[2] }}
                                            @endif
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G5</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="{{ strtoupper($xsmn->province->short_name) }}_prize_5_item_0">
                                        <div data-nc="4" class="v-g5 ">{{ $xsmn->g5 }}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G4</td>
                                @foreach ($xsmns as $xsmn)
                                    <?php $g4 = explode('-', $xsmn->g4); ?>
                                    <td>
                                        <div data-nc="5" class="v-g4-0 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_4_item_0">
                                            @if (!empty($g4[0]))
                                                {{ $g4[0] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-1 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_4_item_1">
                                            @if (!empty($g4[1]))
                                                {{ $g4[1] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-2 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_4_item_2">
                                            @if (!empty($g4[2]))
                                                {{ $g4[2] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-3 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_4_item_3">
                                            @if (!empty($g4[3]))
                                                {{ $g4[3] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-4 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_4_item_4">
                                            @if (!empty($g4[4]))
                                                {{ $g4[4] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-5 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_4_item_5">
                                            @if (!empty($g4[5]))
                                                {{ $g4[5] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-6 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_4_item_6">
                                            @if (!empty($g4[6]))
                                                {{ $g4[6] }}
                                            @endif
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G3</td>
                                @foreach ($xsmns as $xsmn)
                                    <?php $g3 = explode('-', $xsmn->g3); ?>
                                    <td>
                                        <div data-nc="5" class="v-g3-0 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_3_item_0">
                                            @if (!empty($g3[0]))
                                                {{ $g3[0] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g3-1 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_3_item_1">
                                            @if (!empty($g3[1]))
                                                {{ $g3[1] }}
                                            @endif
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G2</td>
                                @foreach ($xsmns as $xsmn)
                                    <td>
                                        <div data-nc="5" class="v-g2 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_2_item_0">
                                            {{ $xsmn->g2 }}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G1</td>
                                @foreach ($xsmns as $xsmn)
                                    <td>
                                        <div data-nc="5" class="v-g1 "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_1_item_0">
                                            {{ $xsmn->g1 }}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="gdb">
                                <td>ĐB</td>
                                @foreach ($xsmns as $xsmn)
                                    <td>
                                        <div data-nc="6" class="v-gdb "
                                            id="{{ strtoupper($xsmn->province->short_name) }}_prize_Db_item_0">
                                            {{ $xsmn->gdb }}</div>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                    <div class="control-panel">
                        <form class="digits-form"><label class="radio" data-value="0"><input type="radio"
                                    name="showed-digits" value="0">
                                <b></b><span></span></label><label class="radio" data-value="2"><input type="radio"
                                    name="showed-digits" value="2">
                                <b></b><span></span></label><label class="radio" data-value="3"><input type="radio"
                                    name="showed-digits" value="3">
                                <b></b><span></span></label></form>
                        <div class="buttons-wrapper"><span class="zoom-in-button"><i
                                    class="icon zoom-in-icon"></i><span></span></span></div>
                    </div>
                </div>

                @foreach ($xsmns as $xsmn)
                    <?php
                    $xsmnStr = $xsmn->gdb . '-' . $xsmn->g1 . '-' . $xsmn->g2 . '-' . $xsmn->g3 . '-' . $xsmn->g4 . '-' . $xsmn->g5 . '-' . $xsmn->g6 . '-' . $xsmn->g7 . '-' . $xsmn->g8;
                    $xsmnLoto = getLoto($xsmnStr);
                    $xsmnDau[$xsmn->province->short_name] = getDau($xsmnLoto, substr($xsmn->gdb, strlen($xsmn->gdb) - 2, 2));
                    ?>
                @endforeach
                <div data-id="dd" class="col-firstlast {{ $table_class }} colgiai">
                    <table class="firstlast-mn bold">
                        <tbody>
                            <tr class="header">
                                <th class="first">Đầu</th>
                                @foreach ($xsmns as $xsmn)
                                    <th id="livebangkqloto_{{ strtoupper($xsmn->province->short_name) }}">
                                        {{ $xsmn->province->name }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">0</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="mnloto_{{ strtoupper($xsmn->province->short_name) }}_0"
                                        class="v-loto-dau-0">{!! $xsmnDau[$xsmn->province->short_name][0] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">1</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="mnloto_{{ strtoupper($xsmn->province->short_name) }}_1"
                                        class="v-loto-dau-1">{!! $xsmnDau[$xsmn->province->short_name][1] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">2</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="mnloto_{{ strtoupper($xsmn->province->short_name) }}_2"
                                        class="v-loto-dau-2">{!! $xsmnDau[$xsmn->province->short_name][2] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">3</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="mnloto_{{ strtoupper($xsmn->province->short_name) }}_3"
                                        class="v-loto-dau-3">{!! $xsmnDau[$xsmn->province->short_name][3] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">4</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="mnloto_{{ strtoupper($xsmn->province->short_name) }}_4"
                                        class="v-loto-dau-4">{!! $xsmnDau[$xsmn->province->short_name][4] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">5</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="mnloto_{{ strtoupper($xsmn->province->short_name) }}_5"
                                        class="v-loto-dau-5">{!! $xsmnDau[$xsmn->province->short_name][5] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">6</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="mnloto_{{ strtoupper($xsmn->province->short_name) }}_6"
                                        class="v-loto-dau-6">{!! $xsmnDau[$xsmn->province->short_name][6] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">7</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="mnloto_{{ strtoupper($xsmn->province->short_name) }}_7"
                                        class="v-loto-dau-7">{!! $xsmnDau[$xsmn->province->short_name][7] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">8</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="mnloto_{{ strtoupper($xsmn->province->short_name) }}_8"
                                        class="v-loto-dau-8">{!! $xsmnDau[$xsmn->province->short_name][8] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">9</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="mnloto_{{ strtoupper($xsmn->province->short_name) }}_9"
                                        class="v-loto-dau-9">{!! $xsmnDau[$xsmn->province->short_name][9] !!}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="see-more">
                {{-- <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div> --}}
                <ul class="list-html-link two-column">
                    <li>Xem ngay <a href="{{ route('dudoan.xsmn') }}" title="Dự đoán XSMN">Dự đoán XSMN</a> chính xác
                        nhất hôm nay
                    </li>
                    <li>Trải nghiệm <a href="{{ route('quay_thu.mn') }}" title="quay thử XSMN">quay thử XSMN</a> hôm
                        nay có độ chính xác cao</li>
                    <li>Xem bảng kết quả <a href="{{ route('xsmn.skq') }}" title="XSMN 30 ngày gần nhất">XSMN 30
                            ngày</a> gần nhất</li>
                </ul>
            </div>
        </div>
    @else
        <div class="box">
            <div class="tit-mien clearfix">
                @if ($d == 1)
                    <h2>XSMN - Xổ số miền Nam {{ getNgay($xsmnTinh->date) }}</h2>
                @elseif($d == 2)
                    <h2>XSMN - Xổ số miền Nam hôm nay {{ getNgay($xsmnTinh->date) }}</h2>
                @elseif($d == 3)
                    <h2>SXMN - Xổ số kiến thiết miền Nam {{ getNgay($xsmnTinh->date) }}</h2>
                @elseif($d == 4)
                    <h2>KQXSMN - Kết quả xổ số miền Nam {{ getNgay($xsmnTinh->date) }}</h2>
                @elseif($d == 5)
                    <h2>Xo So MN - Xem kqxs miền Nam {{ getNgay($xsmnTinh->date) }}</h2>
                @elseif($d == 6)
                    <h2>Ket qua xo so mien Nam {{ getNgay($xsmnTinh->date) }}</h2>
                @elseif($d == 7)
                    <h2>Kết quả XSNM - Xổ số miền Nam {{ getNgay($xsmnTinh->date) }}</h2>
                @endif

                <div><a class="sub-title" href="{{ route('xsmn') }}" title="XSMN">XSMN</a> »
                    <a class="sub-title" href="{{ route(getRouteDay($xsmnTinh->day, 'xsmn')) }}"
                        title="XSMN {{ getThu($xsmnTinh->day) }}">XSMN {{ getThu($xsmnTinh->day) }}</a> » <a
                        class="sub-title" href="{{ route('xsmn.date', getNgayLink($xsmnTinh->date)) }}"
                        title="XSMN ngày {{ getNgay($xsmnTinh->date) }}">XSMN ngày {{ getNgay($xsmnTinh->date) }}</a>
                </div>
            </div>
            <div>
                <div data-id="kq" class="{{ $div_class }}" data-region="3">
                    <table class="{{ $table_class }} colgiai extendable">
                        <tbody>
                            <tr class="gr-yellow">
                                <th class="first"></th>
                                @foreach ($xsmns as $xsmn)
                                    <th data-pid="{{ $xsmn->id }}"><a
                                            href="{{ route('xstinh.tinh', $xsmn->province->slug) }}"
                                            title="Xổ số {{ $xsmn->province->name }}"
                                            class="underline bold">{{ $xsmn->province->name }}</a>
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="g8">
                                <td>G8</td>
                                @foreach ($xsmns as $xsmn)
                                    <td>
                                        <div data-nc="2" class="v-g8 ">{{ $xsmn->g8 }}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G7</td>
                                @foreach ($xsmns as $xsmn)
                                    <td>
                                        <div data-nc="3" class="v-g7 ">{{ $xsmn->g7 }}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G6</td>
                                @foreach ($xsmns as $xsmn)
                                    <?php $g6 = explode('-', $xsmn->g6); ?>
                                    <td>
                                        <div data-nc="4" class="v-g6-0 ">
                                            @if (!empty($g6[0]))
                                                {{ $g6[0] }}
                                            @endif
                                        </div>
                                        <div data-nc="4" class="v-g6-1 ">
                                            @if (!empty($g6[1]))
                                                {{ $g6[1] }}
                                            @endif
                                        </div>
                                        <div data-nc="4" class="v-g6-2 ">
                                            @if (!empty($g6[2]))
                                                {{ $g6[2] }}
                                            @endif
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G5</td>
                                @foreach ($xsmns as $xsmn)
                                    <td>
                                        <div data-nc="4" class="v-g5 ">{{ $xsmn->g5 }}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G4</td>
                                @foreach ($xsmns as $xsmn)
                                    <?php $g4 = explode('-', $xsmn->g4); ?>
                                    <td>
                                        <div data-nc="5" class="v-g4-0 ">
                                            @if (!empty($g4[0]))
                                                {{ $g4[0] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-1 ">
                                            @if (!empty($g4[1]))
                                                {{ $g4[1] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-2 ">
                                            @if (!empty($g4[2]))
                                                {{ $g4[2] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-3 ">
                                            @if (!empty($g4[3]))
                                                {{ $g4[3] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-4 ">
                                            @if (!empty($g4[4]))
                                                {{ $g4[4] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-5 ">
                                            @if (!empty($g4[5]))
                                                {{ $g4[5] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g4-6 ">
                                            @if (!empty($g4[6]))
                                                {{ $g4[6] }}
                                            @endif
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G3</td>
                                @foreach ($xsmns as $xsmn)
                                    <?php $g3 = explode('-', $xsmn->g3); ?>
                                    <td>
                                        <div data-nc="5" class="v-g3-0 ">
                                            @if (!empty($g3[0]))
                                                {{ $g3[0] }}
                                            @endif
                                        </div>
                                        <div data-nc="5" class="v-g3-1 ">
                                            @if (!empty($g3[1]))
                                                {{ $g3[1] }}
                                            @endif
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G2</td>
                                @foreach ($xsmns as $xsmn)
                                    <td>
                                        <div data-nc="5" class="v-g2 ">{{ $xsmn->g2 }}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G1</td>
                                @foreach ($xsmns as $xsmn)
                                    <td>
                                        <div data-nc="5" class="v-g1 ">{{ $xsmn->g1 }}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="gdb">
                                <td>ĐB</td>
                                @foreach ($xsmns as $xsmn)
                                    <td>
                                        <div data-nc="6" class="v-gdb ">{{ $xsmn->gdb }}</div>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                    <div class="control-panel">
                        <form class="digits-form"><label class="radio" data-value="0"><input type="radio"
                                    name="showed-digits" value="0">
                                <b></b><span></span></label><label class="radio" data-value="2"><input
                                    type="radio" name="showed-digits" value="2">
                                <b></b><span></span></label><label class="radio" data-value="3"><input
                                    type="radio" name="showed-digits" value="3">
                                <b></b><span></span></label></form>
                        <div class="buttons-wrapper"><span class="zoom-in-button"><i
                                    class="icon zoom-in-icon"></i><span></span></span></div>
                    </div>
                </div>

                @foreach ($xsmns as $xsmn)
                    <?php
                    $xsmnStr = $xsmn->gdb . '-' . $xsmn->g1 . '-' . $xsmn->g2 . '-' . $xsmn->g3 . '-' . $xsmn->g4 . '-' . $xsmn->g5 . '-' . $xsmn->g6 . '-' . $xsmn->g7 . '-' . $xsmn->g8;
                    $xsmnLoto = getLoto($xsmnStr);
                    $xsmnDau[$xsmn->province->short_name] = getDau($xsmnLoto, substr($xsmn->gdb, strlen($xsmn->gdb) - 2, 2));
                    ?>
                @endforeach
                <div data-id="dd" class="col-firstlast {{ $table_class }} colgiai">
                    <table class="firstlast-mn bold">
                        <tbody>
                            <tr class="header">
                                <th class="first">Đầu</th>
                                @foreach ($xsmns as $xsmn)
                                    <th>{{ $xsmn->province->name }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">0</td>
                                @foreach ($xsmns as $xsmn)
                                    <td class="v-loto-dau-0">{!! $xsmnDau[$xsmn->province->short_name][0] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">1</td>
                                @foreach ($xsmns as $xsmn)
                                    <td class="v-loto-dau-1">{!! $xsmnDau[$xsmn->province->short_name][1] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">2</td>
                                @foreach ($xsmns as $xsmn)
                                    <td class="v-loto-dau-2">{!! $xsmnDau[$xsmn->province->short_name][2] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">3</td>
                                @foreach ($xsmns as $xsmn)
                                    <td class="v-loto-dau-3">{!! $xsmnDau[$xsmn->province->short_name][3] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">4</td>
                                @foreach ($xsmns as $xsmn)
                                    <td class="v-loto-dau-4">{!! $xsmnDau[$xsmn->province->short_name][4] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">5</td>
                                @foreach ($xsmns as $xsmn)
                                    <td class="v-loto-dau-5">{!! $xsmnDau[$xsmn->province->short_name][5] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">6</td>
                                @foreach ($xsmns as $xsmn)
                                    <td id="mnloto_{{ strtoupper($xsmn->province->short_name) }}_6"
                                        class="v-loto-dau-6">{!! $xsmnDau[$xsmn->province->short_name][6] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">7</td>
                                @foreach ($xsmns as $xsmn)
                                    <td class="v-loto-dau-7">{!! $xsmnDau[$xsmn->province->short_name][7] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">8</td>
                                @foreach ($xsmns as $xsmn)
                                    <td class="v-loto-dau-8">{!! $xsmnDau[$xsmn->province->short_name][8] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">9</td>
                                @foreach ($xsmns as $xsmn)
                                    <td class="v-loto-dau-9">{!! $xsmnDau[$xsmn->province->short_name][9] !!}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($d == 1)
                <div class="see-more">
                    <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm XSMN</div>
                    <ul class="list-html-link two-column">
                        <li>Mời bạn <a href="{{ route('quay_thu.mn') }}" title="quay thử miền Nam">quay thử miền
                                Nam</a> hôm nay để lấy hên
                        </li>
                        <li>Xem thêm <a href="{{ route('xsmn') }}" title="Kết Quả XSMN">kết quả XSMN</a></li>
                        <li>Xem bảng kết quả <a href="{{ route('xsmn.skq') }}" title="XSMN 30 ngày gần nhất">XSMN 30
                                ngày gần nhất</a></li>
                    </ul>
                </div>
            @elseif($d == 2)
                <div class="see-more">
                    <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
                    <ul class="list-html-link two-column">
                        <li>Xem thêm <a href="{{ route('home') }}" title="KQXS hôm nay">KQXS hôm nay</a></li>
                        <li>Xem thêm <a href="{{ route('vietlott') }}" title="kết quả xổ số Vietlott">kết quả xổ số
                                Vietlott</a></li>
                        <li>Xem thêm <a href="{{ route('mega645') }}" title="kết quả xổ số Mega 6/45">kết quả xổ số
                                Mega 6/45</a></li>
                    </ul>
                </div>
            @endif

        </div>
    @endif

    @php $d++; @endphp
@endforeach
