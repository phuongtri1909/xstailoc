@php $d = 1; @endphp

@foreach ($xsmns as $xs)
    <?php
    
    $gdb = $xs->gdb;
    
    $g1 = $xs->g1;
    
    $g2 = explode('-', $xs->g2);
    
    $g3 = explode('-', $xs->g3);
    
    $g4 = explode('-', $xs->g4);
    
    $g5 = explode('-', $xs->g5);
    
    $g6 = explode('-', $xs->g6);
    
    $g7 = explode('-', $xs->g7);
    
    $g8 = explode('-', $xs->g8);
    
    $xsStr = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
    
    $xsLoto = getLoto($xsStr);
    
    $xsDau = getDau($xsLoto, substr($xs->gdb, strlen($xs->gdb) - 2, 2));
    
    $xsDuoi = getDuoi($xsLoto, substr($xs->gdb, strlen($xs->gdb) - 2, 2));
    ?>

    @if ($xs->date == date('Y-m-d', time()))
        <div class="box" id='kqngay_{{ getNgayID($xs->date) }}'>
            <div class="tit-mien clearfix" id="provinceLiveTitle">
                <h2>XS{{ strtoupper($xs->province->short_name) }} - XS đài {{ $xs->province->name }}
                    {{ getNgay($xs->date) }}</h2>

                <div>
                    <a class="sub-title" href="{{ route('xsmn') }}" title="XSMN">XSMN</a>
                    » <a class="sub-title" href="{{ route('xstinh.tinh', $xs->province->slug) }}"
                        title="XS{{ strtoupper($xs->province->short_name) }}">XS{{ strtoupper($xs->province->short_name) }}</a>
                    {{ getThu($xs->day) }}
                    » <a class="sub-title"
                        href="{{ route('xstinh.date', [$xs->province->short_name, getNgayLink($xs->date)]) }}"
                        title="XS{{ strtoupper($xs->province->short_name) }} {{ getNgay($xs->date) }}">XS{{ strtoupper($xs->province->short_name) }}
                        {{ getNgay($xs->date) }}</a>
                </div>
            </div>
            <div id="load_kq_tinh_{{ $d }}">
                <div data-id="kq" data-zoom="0" class="one-city">
                    <table class="kqmb extendable kqtinh">
                        <tbody>
                            <tr class="g8">
                                <td class="txt-giai">G.8</td>

                                <td class="v-giai number"><span data-nc="2" class="v-g8 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_8_item_0">
                                        @if (!empty($g8[0]))
                                            {{ $g8[0] }}
                                        @endif
                                    </span>
                                </td>


                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.7</td>

                                <td class="v-giai number"><span data-nc="3" class="v-g7 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_7_item_0">
                                        @if (!empty($g7[0]))
                                            {{ $g7[0] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.6</td>
                                <td class="v-giai number">
                                    <span data-nc="4" class="v-g6-0 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_6_item_0">
                                        @if (!empty($g6[0]))
                                            {{ $g6[0] }}
                                        @endif
                                    </span><span data-nc="4" class="v-g6-1 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_6_item_1">
                                        @if (!empty($g6[1]))
                                            {{ $g6[1] }}
                                        @endif
                                    </span><span data-nc="4" class="v-g6-2 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_6_item_2">
                                        @if (!empty($g6[2]))
                                            {{ $g6[2] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.5</td>
                                <td class="v-giai number">
                                    <span data-nc="4" class="v-g5 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_5_item_0">
                                        @if (!empty($g5[0]))
                                            {{ $g5[0] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>

                            <tr class="g4">
                                <td class="titgiai">G.4</td>
                                <td class="v-giai number">
                                    <span data-nc="5" class="v-g4-0 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_4_item_0">
                                        @if (!empty($g4[0]))
                                            {{ $g4[0] }}
                                        @endif
                                    </span><!--
                                    --><span data-nc="5" class="v-g4-1 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_4_item_1">
                                        @if (!empty($g4[1]))
                                            {{ $g4[1] }}
                                        @endif
                                    </span><!--
                                    --><span data-nc="5" class="v-g4-2 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_4_item_2">
                                        @if (!empty($g4[2]))
                                            {{ $g4[2] }}
                                        @endif
                                    </span><!--
                                    --><span data-nc="5" class="v-g4-3 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_4_item_3">
                                        @if (!empty($g4[3]))
                                            {{ $g4[3] }}
                                        @endif
                                    </span><!--
                                    --><span data-nc="5" class="v-g4-4 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_4_item_4">
                                        @if (!empty($g4[4]))
                                            {{ $g4[4] }}
                                        @endif
                                    </span><!--
                                    --><span data-nc="5" class="v-g4-5 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_4_item_5">
                                        @if (!empty($g4[5]))
                                            {{ $g4[5] }}
                                        @endif
                                    </span><!--
                                    --><span data-nc="5" class="v-g4-6 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_4_item_6">
                                        @if (!empty($g4[6]))
                                            {{ $g4[6] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>

                            <tr class="bg_ef">
                                <td class="txt-giai">G.3</td>
                                <td class="v-giai number">
                                    <span data-nc="5" class="v-g3-0 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_3_item_0">
                                        @if (!empty($g3[0]))
                                            {{ $g3[0] }}
                                        @endif
                                    </span><!--
                                        --><span data-nc="5" class="v-g3-1 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_3_item_1">
                                        @if (!empty($g3[1]))
                                            {{ $g3[1] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.2</td>
                                <td class="v-giai number">
                                    <span data-nc="5" class="v-g2 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_2_item_0">
                                        @if (!empty($g2[0]))
                                            {{ $g2[0] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.1</td>
                                <td class="v-giai number"><span data-nc="5" class="v-g1 "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_1_item_0">
                                        @if (!empty($g1))
                                            {{ $g1 }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr class="gdb db">
                                <td class="txt-giai">ĐB</td>
                                <td class="v-giai number"><span data-nc="6" class="v-gdb "
                                        id="{{ strtoupper($xs->province->short_name) }}_prize_db_item_0">
                                        @if (!empty($gdb))
                                            {{ $gdb }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="control-panel">
                        <form class="digits-form"><label class="radio" data-value="0"><input type="radio"
                                    name="showed-digits" value="0"><b></b><span></span></label><label
                                class="radio" data-value="2"><input type="radio" name="showed-digits"
                                    value="2"><b></b><span></span></label><label class="radio"
                                data-value="3"><input type="radio" name="showed-digits"
                                    value="3"><b></b><span></span></label></form>
                        <div class="buttons-wrapper"><span class="capture-button"><i
                                    class="icon capture-icon"></i><span></span></span>

                            <div class="subscription-button dspnone"><input id="load_kq_tinh_1_chx" type="checkbox"
                                    class="ntf-sub cbx dspnone" sub-type-id="null"><label id="load_kq_tinh_1_chx_lbl"
                                    sub-type-id="null" class="lbl1" for="load_kq_tinh_1_chx"></label><span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="buttons-wrapper"></div>
                <div data-id="dd" class="col-firstlast"
                    id="livebangkqloto_{{ strtoupper($xs->province->short_name) }}">
                    <table class="firstlast-mb fl">
                        <tbody>
                            <tr class="header">
                                <th>Đầu</th>
                                <th>Đuôi</th>
                            </tr>
                            <tr>
                                <td class="clred">0</td>
                                <td class="v-loto-dau-0" id="loto_{{ strtoupper($xs->province->short_name) }}_0">
                                    {!! $xsDau[0] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">1</td>
                                <td class="v-loto-dau-1" id="loto_{{ strtoupper($xs->province->short_name) }}_1">
                                    {!! $xsDau[1] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">2</td>
                                <td class="v-loto-dau-2" id="loto_{{ strtoupper($xs->province->short_name) }}_2">
                                    {!! $xsDau[2] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">3</td>
                                <td class="v-loto-dau-3" id="loto_{{ strtoupper($xs->province->short_name) }}_3">
                                    {!! $xsDau[3] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">4</td>
                                <td class="v-loto-dau-4" id="loto_{{ strtoupper($xs->province->short_name) }}_4">
                                    {!! $xsDau[4] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">5</td>
                                <td class="v-loto-dau-5" id="loto_{{ strtoupper($xs->province->short_name) }}_5">
                                    {!! $xsDau[5] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">6</td>
                                <td class="v-loto-dau-6" id="loto_{{ strtoupper($xs->province->short_name) }}_6">
                                    {!! $xsDau[6] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">7</td>
                                <td class="v-loto-dau-7" id="loto_{{ strtoupper($xs->province->short_name) }}_7">
                                    {!! $xsDau[7] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">8</td>
                                <td class="v-loto-dau-8" id="loto_{{ strtoupper($xs->province->short_name) }}_8">
                                    {!! $xsDau[8] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">9</td>
                                <td class="v-loto-dau-9" id="loto_{{ strtoupper($xs->province->short_name) }}_9">
                                    {!! $xsDau[9] !!}</td>
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
                                <td class="v-loto-duoi-0" id="loto_{{ strtoupper($xs->province->short_name) }}_d0">
                                    {!! $xsDuoi[0] !!}</td>
                                <td class="clred">0</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-1" id="loto_{{ strtoupper($xs->province->short_name) }}_d1">
                                    {!! $xsDuoi[1] !!}</td>
                                <td class="clred">1</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-2" id="loto_{{ strtoupper($xs->province->short_name) }}_d2">
                                    {!! $xsDuoi[2] !!}</td>
                                <td class="clred">2</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-3" id="loto_{{ strtoupper($xs->province->short_name) }}_d3">
                                    {!! $xsDuoi[3] !!}</td>
                                <td class="clred">3</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-4" id="loto_{{ strtoupper($xs->province->short_name) }}_d4">
                                    {!! $xsDuoi[4] !!}</td>
                                <td class="clred">4</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-5" id="loto_{{ strtoupper($xs->province->short_name) }}_d5">
                                    {!! $xsDuoi[5] !!}</td>
                                <td class="clred">5</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-6" id="loto_{{ strtoupper($xs->province->short_name) }}_d6">
                                    {!! $xsDuoi[6] !!}</td>
                                <td class="clred">6</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-7" id="loto_{{ strtoupper($xs->province->short_name) }}_d7">
                                    {!! $xsDuoi[7] !!}</td>
                                <td class="clred">7</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-8" id="loto_{{ strtoupper($xs->province->short_name) }}_d8">
                                    {!! $xsDuoi[8] !!}</td>
                                <td class="clred">8</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-9" id="loto_{{ strtoupper($xs->province->short_name) }}_d9">
                                    {!! $xsDuoi[9] !!}</td>
                                <td class="clred">9</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="see-more">
                <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
                <ul class="list-html-link two-column">
                    <li>Xem thêm <a href="{{ route('tk.lo-gan', $xs->province->short_name) }}"
                            title="Thống kê lô gan {{ $xs->province->name }}">thống kê lô gan
                            {{ $xs->province->name }}</a></li>
                    <li>Mời bạn <a href="{{ route('quay_thu.mn') }}" title="quay thử Miền Nam">quay thử Miền Nam</a>
                        hôm nay để lấy hên
                    </li>
                    <li>Xem thêm <a href="{{ route('xsmn') }}" title="Kết Quả XSMN">kết quả XSMN</a></li>
                    <li>Xem bảng kết quả <a href="{{ route('xsmn.skq') }}" title="XSMN 30 ngày gần nhất">XSMN 30 ngày
                            gần nhất</a></li>
                </ul>
            </div>
        </div>
    @else
        <div class="box">
            <div class="tit-mien clearfix">
                @if ($d == 1)
                    <h2>{{ $xs->data }} {{ getNgay($xs->date) }}</h2>
                @elseif($d == 2)
                    <h2>{{ $xs->data }}
                        {{ getNgay($xs->date) }}</h2>
                @elseif($d == 3)
                    <h2>{{ $xs->data }}
                        {{ getNgay($xs->date) }}</h2>
                @elseif($d == 4)
                    <h2>{{ $xs->data }}
                        {{ getNgay($xs->date) }}</h2>
                @elseif($d == 5)
                    <h2>{{ $xs->data }}
                        {{ getNgay($xs->date) }}</h2>
                @elseif($d == 6)
                    <h2>{{ $xs->data }} {{ getNgay($xs->date) }}</h2>
                @elseif($d == 7)
                    <h2>{{ $xs->data }}
                        {{ getNgay($xs->date) }}</h2>
                @endif
                <div>
                    <a class="sub-title" href="{{ route('xsmn') }}" title="XSMN">XSMN</a>
                    » <a class="sub-title" href="{{ route('xstinh.tinh', $xs->province->slug) }}"
                        title="XS{{ strtoupper($xs->province->short_name) }}">XS{{ strtoupper($xs->province->short_name) }}</a>
                    {{ getThu($xs->day) }}
                    » <a class="sub-title"
                        href="{{ route('xstinh.date', [$xs->province->short_name, getNgayLink($xs->date)]) }}"
                        title="XS{{ strtoupper($xs->province->short_name) }} {{ getNgay($xs->date) }}">XS{{ strtoupper($xs->province->short_name) }}
                        {{ getNgay($xs->date) }}</a>
                </div>
            </div>
            <div id="load_kq_tinh_{{ $d }}">
                <div data-id="kq" data-zoom="0" class="one-city">
                    <table class="kqmb extendable kqtinh">
                        <tbody>
                            <tr class="g8">
                                <td class="txt-giai">G.8</td>

                                <td class="v-giai number"><span data-nc="2" class="v-g8 ">
                                        @if (!empty($g8[0]))
                                            {{ $g8[0] }}
                                        @endif
                                    </span>
                                </td>


                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.7</td>

                                <td class="v-giai number"><span data-nc="3" class="v-g7 ">
                                        @if (!empty($g7[0]))
                                            {{ $g7[0] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.6</td>
                                <td class="v-giai number">
                                    <span data-nc="4" class="v-g6-0 ">
                                        @if (!empty($g6[0]))
                                            {{ $g6[0] }}
                                        @endif
                                    </span><span data-nc="4" class="v-g6-1 ">
                                        @if (!empty($g6[1]))
                                            {{ $g6[1] }}
                                        @endif
                                    </span><span data-nc="4" class="v-g6-2 ">
                                        @if (!empty($g6[2]))
                                            {{ $g6[2] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.5</td>
                                <td class="v-giai number">
                                    <span data-nc="4" class="v-g5 ">
                                        @if (!empty($g5[0]))
                                            {{ $g5[0] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>

                            <tr class="g4">
                                <td class="titgiai">G.4</td>
                                <td class="v-giai number">
                                    <span data-nc="5" class="v-g4-0 ">
                                        @if (!empty($g4[0]))
                                            {{ $g4[0] }}
                                        @endif
                                    </span><span data-nc="5" class="v-g4-1 ">
                                        @if (!empty($g4[1]))
                                            {{ $g4[1] }}
                                        @endif
                                    </span><span data-nc="5" class="v-g4-2 ">
                                        @if (!empty($g4[2]))
                                            {{ $g4[2] }}
                                        @endif
                                    </span><span data-nc="5" class="v-g4-3 ">
                                        @if (!empty($g4[3]))
                                            {{ $g4[3] }}
                                        @endif
                                    </span><span data-nc="5" class="v-g4-4 ">
                                        @if (!empty($g4[4]))
                                            {{ $g4[4] }}
                                        @endif
                                    </span><span data-nc="5" class="v-g4-5 ">
                                        @if (!empty($g4[5]))
                                            {{ $g4[5] }}
                                        @endif
                                    </span><span data-nc="5" class="v-g4-6 ">
                                        @if (!empty($g4[6]))
                                            {{ $g4[6] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>

                            <tr class="bg_ef">
                                <td class="txt-giai">G.3</td>
                                <td class="v-giai number">
                                    <span data-nc="5" class="v-g3-0 ">
                                        @if (!empty($g3[0]))
                                            {{ $g3[0] }}
                                        @endif
                                    </span><span data-nc="5" class="v-g3-1 ">
                                        @if (!empty($g3[1]))
                                            {{ $g3[1] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.2</td>
                                <td class="v-giai number">
                                    <span data-nc="5" class="v-g2 ">
                                        @if (!empty($g2[0]))
                                            {{ $g2[0] }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.1</td>
                                <td class="v-giai number"><span data-nc="5" class="v-g1 ">
                                        @if (!empty($g1))
                                            {{ $g1 }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr class="gdb db">
                                <td class="txt-giai">ĐB</td>
                                <td class="v-giai number"><span data-nc="6" class="v-gdb ">
                                        @if (!empty($gdb))
                                            {{ $gdb }}
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="control-panel">
                        <form class="digits-form"><label class="radio" data-value="0"><input type="radio"
                                    name="showed-digits" value="0"><b></b><span></span></label><label
                                class="radio" data-value="2"><input type="radio" name="showed-digits"
                                    value="2"><b></b><span></span></label><label class="radio"
                                data-value="3"><input type="radio" name="showed-digits"
                                    value="3"><b></b><span></span></label></form>
                        <div class="buttons-wrapper"><span class="capture-button"><i
                                    class="icon capture-icon"></i><span></span></span>

                            <div class="subscription-button dspnone"><input id="load_kq_tinh_1_chx" type="checkbox"
                                    class="ntf-sub cbx dspnone" sub-type-id="null"><label id="load_kq_tinh_1_chx_lbl"
                                    sub-type-id="null" class="lbl1" for="load_kq_tinh_1_chx"></label><span></span>
                            </div>
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
                                <td class="v-loto-dau-0">{!! $xsDau[0] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">1</td>
                                <td class="v-loto-dau-1">{!! $xsDau[1] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">2</td>
                                <td class="v-loto-dau-2">{!! $xsDau[2] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">3</td>
                                <td class="v-loto-dau-3">{!! $xsDau[3] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">4</td>
                                <td class="v-loto-dau-4">{!! $xsDau[4] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">5</td>
                                <td class="v-loto-dau-5">{!! $xsDau[5] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">6</td>
                                <td class="v-loto-dau-6">{!! $xsDau[6] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">7</td>
                                <td class="v-loto-dau-7">{!! $xsDau[7] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">8</td>
                                <td class="v-loto-dau-8">{!! $xsDau[8] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">9</td>
                                <td class="v-loto-dau-9">{!! $xsDau[9] !!}</td>
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
                                <td class="v-loto-duoi-0">{!! $xsDuoi[0] !!}</td>
                                <td class="clred">0</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-1">{!! $xsDuoi[1] !!}</td>
                                <td class="clred">1</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-2">{!! $xsDuoi[2] !!}</td>
                                <td class="clred">2</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-3">{!! $xsDuoi[3] !!}</td>
                                <td class="clred">3</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-4">{!! $xsDuoi[4] !!}</td>
                                <td class="clred">4</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-5">{!! $xsDuoi[5] !!}</td>
                                <td class="clred">5</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-6">{!! $xsDuoi[6] !!}</td>
                                <td class="clred">6</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-7">{!! $xsDuoi[7] !!}</td>
                                <td class="clred">7</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-8">{!! $xsDuoi[8] !!}</td>
                                <td class="clred">8</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-9">{!! $xsDuoi[9] !!}</td>
                                <td class="clred">9</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if ($d == 1)
                    <div class="see-more">
                        <li><a href="{{ route('quay_thu.tinh', $xs->province->short_name) }}"
                                title="Quay thử xổ số {{ $xs->province->name }}">Quay thử xổ số
                                {{ $xs->province->name }}</a> dự đoán KQXS uy tín</li>

                        <li>Xem <a href="{{ route('dudoan.xsmn') }}" title="dự đoán XSMN">dự đoán XSMN
                            </a> chính xác nhất</li>

                        <li>Xem thống kê <a href="{{ route('tk.lo-gan', $xs->province->short_name) }}"
                                title="lô gan {{ $xs->province->name }}">lô gan
                                {{ $xs->province->name }}</a></li>
                        <li>Xem ngay kết quả <a href="{{ route('xsmn') }}" title="XSMN hôm nay">XSMN hôm nay</a>
                        </li>
                    </div>
                @elseif($d == 2 && $xs->province->short_name != 'vt')
                    <div class="see-more">
                        <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
                        <ul class="list-html-link two-column">
                            <li>Xem thêm <a href="{{ route('tk.lo-gan', $xs->province->short_name) }}"
                                    title="Thống kê lô gan {{ $xs->province->name }}">thống kê lô gan
                                    {{ $xs->province->name }}</a></li>
                            <li>Xem thêm <a href="{{ route('home') }}" title="KQXS hôm nay">KQXS hôm nay</a></li>
                            <li>Xem thêm <a href="{{ route('vietlott') }}" title="kết quả xổ số Vietlott">kết quả xổ
                                    số Vietlott</a></li>
                            <li>Xem thêm <a href="{{ route('mega645') }}" title="kết quả xổ số Mega 6/45">kết quả xổ
                                    số Mega 6/45</a></li>
                        </ul>
                    </div>
                @endif
                <div class="clearfix"></div>
            </div>
        </div>
    @endif
    @php $d ++; @endphp
@endforeach
