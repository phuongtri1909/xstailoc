<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>

@extends('frontend.layouts.app')
@section('h1',$meta_title)
@section('title',$meta_title)
@section('decription',$meta_description)
@section('keyword',$meta_keyword)

@section('content')
    <div class="col-l" style="height: auto !important;">
        @if(!empty($xsmt))
            <?php

            $gdb = $xsmt->gdb;

            $g1 = $xsmt->g1;

            $g2 = explode('-', $xsmt->g2);

            $g3 = explode('-', $xsmt->g3);

            $g4 = explode('-', $xsmt->g4);

            $g5 = explode('-', $xsmt->g5);

            $g6 = explode('-', $xsmt->g6);

            $g7 = explode('-', $xsmt->g7);

            $g8 = explode('-', $xsmt->g8);



            $xsmtStr = $xsmt->gdb . '-' . $xsmt->g1 . '-' . $xsmt->g2 . '-' . $xsmt->g3 . '-' . $xsmt->g4 . '-' . $xsmt->g5 . '-' . $xsmt->g6 . '-' . $xsmt->g7 . '-' . $xsmt->g8;

            $xsmtLoto = getLoto($xsmtStr);

            $xsDau = getDau($xsmtLoto, substr($xsmt->gdb, strlen($xsmt->gdb) - 2, 2));

            $xsDuoi = getDuoi($xsmtLoto, substr($xsmt->gdb, strlen($xsmt->gdb) - 2, 2));

            ?>
            <div class="box" id='kqngay_{{getNgayID($xsmt->date)}}'>
                <div class="tit-mien clearfix">
                    <h2>XS{{strtoupper($province->short_name)}} - XS
                        đài {{$province->name}} {{getNgay($xsmt->date)}}</h2>

                    <div>
                        <a class="sub-title" href="{{route('xsmt')}}" title="XSMT">XSMT</a>
                        » <a class="sub-title" href="{{route('xstinh.tinh',$province->slug)}}"
                             title="XS{{strtoupper($province->short_name)}}">XS{{strtoupper($province->short_name)}}</a> {{getThu($xsmt->day)}}
                        » <a class="sub-title"
                             href="{{route('xstinh.date',[$province->short_name,getNgayLink($xsmt->date)])}}"
                             title="XS{{strtoupper($province->short_name)}} {{getNgay($xsmt->date)}}">XS{{strtoupper($province->short_name)}} {{getNgay($xsmt->date)}}</a>
                    </div>
                </div>
                <div id="load_kq_tinh_0">
                    <div data-id="kq" data-zoom="0" class="one-city">
                        <table class="kqmb extendable kqtinh">
                            <tbody>
                            <tr class="g8">
                                <td class="txt-giai">G.8</td>

                                <td class="v-giai number"><span data-nc="2" class="v-g8 "
                                                                id="{{strtoupper($province->short_name)}}_prize_8_item_0">@if(!empty($g8[0])){{$g8[0]}}@endif</span>
                                </td>


                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.7</td>

                                <td class="v-giai number"><span data-nc="3" class="v-g7 "
                                                                id="{{strtoupper($province->short_name)}}_prize_7_item_0">@if(!empty($g7[0])){{$g7[0]}}@endif</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.6</td>
                                <td class="v-giai number">
                                <span data-nc="4" class="v-g6-0 "
                                      id="{{strtoupper($province->short_name)}}_prize_6_item_0">@if(!empty($g6[0])){{$g6[0]}}@endif</span><span
                                            data-nc="4" class="v-g6-1 "
                                            id="{{strtoupper($province->short_name)}}_prize_6_item_1">@if(!empty($g6[1])){{$g6[1]}}@endif</span><span
                                            data-nc="4" class="v-g6-2 "
                                            id="{{strtoupper($province->short_name)}}_prize_6_item_2">@if(!empty($g6[2])){{$g6[2]}}@endif</span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.5</td>
                                <td class="v-giai number">
                                <span data-nc="4" class="v-g5 "
                                      id="{{strtoupper($province->short_name)}}_prize_5_item_0">@if(!empty($g5[0])){{$g5[0]}}@endif</span>
                                </td>
                            </tr>

                            <tr class="g4">
                                <td class="titgiai">G.4</td>
                                <td class="v-giai number">
                                <span data-nc="5" class="v-g4-0 "
                                      id="{{strtoupper($province->short_name)}}_prize_4_item_0">@if(!empty($g4[0])){{$g4[0]}}@endif</span><!--
                                    --><span data-nc="5" class="v-g4-1 "
                                             id="{{strtoupper($province->short_name)}}_prize_4_item_1">@if(!empty($g4[1])){{$g4[1]}}@endif</span><!--
                                    --><span data-nc="5" class="v-g4-2 "
                                             id="{{strtoupper($province->short_name)}}_prize_4_item_2">@if(!empty($g4[2])){{$g4[2]}}@endif</span><!--
                                    --><span data-nc="5" class="v-g4-3 "
                                             id="{{strtoupper($province->short_name)}}_prize_4_item_3">@if(!empty($g4[3])){{$g4[3]}}@endif</span><!--
                                    --><span data-nc="5" class="v-g4-4 "
                                             id="{{strtoupper($province->short_name)}}_prize_4_item_4">@if(!empty($g4[4])){{$g4[4]}}@endif</span><!--
                                    --><span data-nc="5" class="v-g4-5 "
                                             id="{{strtoupper($province->short_name)}}_prize_4_item_5">@if(!empty($g4[5])){{$g4[5]}}@endif</span><!--
                                    --><span data-nc="5" class="v-g4-6 "
                                             id="{{strtoupper($province->short_name)}}_prize_4_item_6">@if(!empty($g4[6])){{$g4[6]}}@endif</span>
                                </td>
                            </tr>

                            <tr class="bg_ef">
                                <td class="txt-giai">G.3</td>
                                <td class="v-giai number">
                                <span data-nc="5" class="v-g3-0 "
                                      id="{{strtoupper($province->short_name)}}_prize_3_item_0">@if(!empty($g3[0])){{$g3[0]}}@endif</span><!--
                                        --><span data-nc="5" class="v-g3-1 "
                                                 id="{{strtoupper($province->short_name)}}_prize_3_item_1">@if(!empty($g3[1])){{$g3[1]}}@endif</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.2</td>
                                <td class="v-giai number">
                                <span data-nc="5" class="v-g2 "
                                      id="{{strtoupper($province->short_name)}}_prize_2_item_0">@if(!empty($g2[0])){{$g2[0]}}@endif</span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.1</td>
                                <td class="v-giai number"><span data-nc="5" class="v-g1 "
                                                                id="{{strtoupper($province->short_name)}}_prize_1_item_0">@if(!empty($g1)){{$g1}}@endif</span>
                                </td>
                            </tr>
                            <tr class="gdb db">
                                <td class="txt-giai">ĐB</td>
                                <td class="v-giai number"><span data-nc="6" class="v-gdb "
                                                                id="{{strtoupper($province->short_name)}}_prize_db_item_0">@if(!empty($gdb)){{$gdb}}@endif</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="control-panel">
                            <form class="digits-form"><label class="radio" data-value="0"><input type="radio"
                                                                                                 name="showed-digits"
                                                                                                 value="0"><b></b><span></span></label><label
                                        class="radio" data-value="2"><input type="radio" name="showed-digits"
                                                                            value="2"><b></b><span></span></label><label
                                        class="radio" data-value="3"><input type="radio" name="showed-digits"
                                                                            value="3"><b></b><span></span></label>
                            </form>
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
                                <td class="v-loto-dau-0"
                                    id="loto_{{strtoupper($province->short_name)}}_0">{!! $xsDau[0] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">1</td>
                                <td class="v-loto-dau-1"
                                    id="loto_{{strtoupper($province->short_name)}}_1">{!! $xsDau[1] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">2</td>
                                <td class="v-loto-dau-2"
                                    id="loto_{{strtoupper($province->short_name)}}_2">{!! $xsDau[2] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">3</td>
                                <td class="v-loto-dau-3"
                                    id="loto_{{strtoupper($province->short_name)}}_3">{!! $xsDau[3] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">4</td>
                                <td class="v-loto-dau-4"
                                    id="loto_{{strtoupper($province->short_name)}}_4">{!! $xsDau[4] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">5</td>
                                <td class="v-loto-dau-5"
                                    id="loto_{{strtoupper($province->short_name)}}_5">{!! $xsDau[5] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">6</td>
                                <td class="v-loto-dau-6"
                                    id="loto_{{strtoupper($province->short_name)}}_6">{!! $xsDau[6] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">7</td>
                                <td class="v-loto-dau-7"
                                    id="loto_{{strtoupper($province->short_name)}}_7">{!! $xsDau[7] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">8</td>
                                <td class="v-loto-dau-8"
                                    id="loto_{{strtoupper($province->short_name)}}_8">{!! $xsDau[8] !!}</td>
                            </tr>
                            <tr>
                                <td class="clred">9</td>
                                <td class="v-loto-dau-9"
                                    id="loto_{{strtoupper($province->short_name)}}_9">{!! $xsDau[9] !!}</td>
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
                                <td class="v-loto-duoi-0"
                                    id="loto_{{strtoupper($province->short_name)}}_d0">{!! $xsDuoi[0] !!}</td>
                                <td class="clred">0</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-1"
                                    id="loto_{{strtoupper($province->short_name)}}_d1">{!! $xsDuoi[1] !!}</td>
                                <td class="clred">1</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-2"
                                    id="loto_{{strtoupper($province->short_name)}}_d2">{!! $xsDuoi[2] !!}</td>
                                <td class="clred">2</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-3"
                                    id="loto_{{strtoupper($province->short_name)}}_d3">{!! $xsDuoi[3] !!}</td>
                                <td class="clred">3</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-4"
                                    id="loto_{{strtoupper($province->short_name)}}_d4">{!! $xsDuoi[4] !!}</td>
                                <td class="clred">4</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-5"
                                    id="loto_{{strtoupper($province->short_name)}}_d5">{!! $xsDuoi[5] !!}</td>
                                <td class="clred">5</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-6"
                                    id="loto_{{strtoupper($province->short_name)}}_d6">{!! $xsDuoi[6] !!}</td>
                                <td class="clred">6</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-7"
                                    id="loto_{{strtoupper($province->short_name)}}_d7">{!! $xsDuoi[7] !!}</td>
                                <td class="clred">7</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-8"
                                    id="loto_{{strtoupper($province->short_name)}}_d8">{!! $xsDuoi[8] !!}</td>
                                <td class="clred">8</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-9"
                                    id="loto_{{strtoupper($province->short_name)}}_d9">{!! $xsDuoi[9] !!}</td>
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
                        <li>Xem thêm <a href="{{route('tk.lo-gan',$province->short_name)}}"
                                        title="Thống kê lô gan {{$province->name}}">thống kê lô
                                gan {{$province->name}}</a></li>
                        <li>Mời bạn <a href="{{route('quay_thu.mt')}}"
                                       title="quay thử Miền Trung">quay thử Miền Trung</a> hôm nay để lấy hên
                        </li>
                        <li>Xem thêm <a href="{{route('xsmt')}}"
                                        title="Kết Quả XSMT">kết quả XSMT</a></li>
                        <li>Xem bảng kết quả <a
                                    href="{{route('xsmt.skq')}}"
                                    title="XSMT 30 ngày gần nhất">XSMT 30 ngày gần nhất</a></li>
                    </ul>  
                </div>
                <div>
                    
                    
                      <div class="box-content">
                    
                   <p> <strong> XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} - Kết quả xổ số {{$province->name}} hôm nay nhanh nhất tại xosotailoc.vip Xổ số {{getNgay($date)}}</strong>
                    </p>
                    </li>Trực tiếp {{strtoupper($province->short_name)}} ngày hôm nay nhanh XS{{strtoupper($province->short_name)}} {{getNgay($date)}} , chính xác nhất.</li>

                    XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} - Kết quả xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}    <strong> Xổ số XS{{strtoupper($province->short_name)}} {{$province->name}} {{getNgay($date)}}</strong> </li> trực tiếp lúc 17  giờ 15 phút. Xổ số hôm nay XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}  hàng tuần được mở thưởng bởi công ty xổ số kiến thiết của đài hôm nay. Kết quả xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}  </li> bắt đầu quay từ giải tám cho đến giải nhất và cuối cùng là giải đặc biệt.
                    
                    Kết quả XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}- Xổ số miền XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}

                    <p><h2> <strong> Các Câu Hỏi Thường Gặp Về Xổ Số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}</strong> </h2> </p>
                    <p><h3> <strong> Làm thế nào để biết kết quả xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}</strong>  </h3></p>

                    <p>Kết quả xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} được công bố trên các trang web xosotailoc.vip đề hoặc trên các kênh truyền hình vào mỗi ngày {{getNgay($date)}}. </p>

                    <p><h3> <strong>  Tôi có thể mua vé xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} ở đâu? </strong>  </h3></p>

                    <p>Bạn có thể mua vé xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} tại các điểm bán vé hoặc trên các trang web và ứng dụng xổ số trực tuyến. </p>

                   <p><h3> <strong>  Tôi có thể chơi xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} trên điện thoại di động không? </strong>  </h3></p>

                   <p> Hiện nay, có rất nhiều ứng dụng cho phép bạn chơi xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} trực tuyến trên điện thoại di động. </p>

                       <p><h3> <strong> Tôi có thể đổi vé xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} không? </strong>  </h3></p>
                    
                    <p> Không, vé xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} không thể đổi hoặc hoàn lại sau khi đã mua.</p>
                    
                       <p><h3> <strong> Tôi có thể chơi xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} nhiều lần trong ngày không? </strong>  </h3></p>
                    
                    <p> Có, bạn có thể chơi xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} nhiều lần trong ngày với các kết quả xổ số khác nhau.</p>
                 </div>
                </div>
            </div>
        @else
            <div class="box" id='kqngay_{{getNgayID($date)}}'>
                <div class="tit-mien clearfix">
                        <h2>XS{{strtoupper($province->short_name)}} - XS
                            đài {{$province->name}} {{$date_2}}</h2>
                    <div>
                        <a class="sub-title" href="{{route('xsmt')}}" title="XSMT">XSMT</a>
                        » <a class="sub-title" href="{{route('xstinh.tinh',$province->slug)}}"
                             title="XS{{strtoupper($province->short_name)}}">XS{{strtoupper($province->short_name)}}</a> {{getThu(getThuNumber($date))}}
                        » <a class="sub-title"
                             href="{{route('xstinh.date',[$province->short_name,getNgayLink($date)])}}"
                             title="XS{{strtoupper($province->short_name)}} {{getNgay($date)}}">XS{{strtoupper($province->short_name)}} {{getNgay($date)}}</a>
                    </div>
                </div>
                <div id="load_kq_tinh_1">
                    <div data-id="kq" data-zoom="0" class="one-city">
                        <table class="kqmb extendable kqtinh">
                            <tbody>
                            <tr class="g8">
                                <td class="txt-giai">G.8</td>

                                <td class="v-giai number"><span data-nc="2"
                                                                class="v-g8 "><i class="fas fa-spinner fa-pulse"></i></span>
                                </td>


                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.7</td>

                                <td class="v-giai number"><span data-nc="3"
                                                                class="v-g7 "><i class="fas fa-spinner fa-pulse"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.6</td>
                                <td class="v-giai number">
                                    <span data-nc="4" class="v-g6-0 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g6-1 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="4" class="v-g6-2 "><i class="fas fa-spinner fa-pulse"></i></span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.5</td>
                                <td class="v-giai number">
                                    <span data-nc="4" class="v-g5 "><i class="fas fa-spinner fa-pulse"></i></span>
                                </td>
                            </tr>

                            <tr class="g4">
                                <td class="titgiai">G.4</td>
                                <td class="v-giai number">
                                    <span data-nc="5" class="v-g4-0 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g4-1 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g4-2 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g4-3 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g4-4 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g4-5 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g4-6 "><i class="fas fa-spinner fa-pulse"></i></span>
                                </td>
                            </tr>

                            <tr class="bg_ef">
                                <td class="txt-giai">G.3</td>
                                <td class="v-giai number">
                                    <span data-nc="5" class="v-g3-0 "><i class="fas fa-spinner fa-pulse"></i></span><span
                                            data-nc="5" class="v-g3-1 "><i class="fas fa-spinner fa-pulse"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="txt-giai">G.2</td>
                                <td class="v-giai number">
                                    <span data-nc="5" class="v-g2 "><i class="fas fa-spinner fa-pulse"></i></span>
                                </td>
                            </tr>
                            <tr class="bg_ef">
                                <td class="txt-giai">G.1</td>
                                <td class="v-giai number"><span data-nc="5"
                                                                class="v-g1 "><i class="fas fa-spinner fa-pulse"></i></span>
                                </td>
                            </tr>
                            <tr class="gdb db">
                                <td class="txt-giai">ĐB</td>
                                <td class="v-giai number"><span data-nc="6"
                                                                class="v-gdb "><i class="fas fa-spinner fa-pulse"></i></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="control-panel">
                            <form class="digits-form"><label class="radio" data-value="0"><input type="radio"
                                                                                                 name="showed-digits"
                                                                                                 value="0"><b></b><span></span></label><label
                                        class="radio" data-value="2"><input type="radio" name="showed-digits"
                                                                            value="2"><b></b><span></span></label><label
                                        class="radio" data-value="3"><input type="radio" name="showed-digits"
                                                                            value="3"><b></b><span></span></label>
                            </form>
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
                                <td class="v-loto-dau-0"></td>
                            </tr>
                            <tr>
                                <td class="clred">1</td>
                                <td class="v-loto-dau-1"></td>
                            </tr>
                            <tr>
                                <td class="clred">2</td>
                                <td class="v-loto-dau-2"></td>
                            </tr>
                            <tr>
                                <td class="clred">3</td>
                                <td class="v-loto-dau-3"></td>
                            </tr>
                            <tr>
                                <td class="clred">4</td>
                                <td class="v-loto-dau-4"></td>
                            </tr>
                            <tr>
                                <td class="clred">5</td>
                                <td class="v-loto-dau-5"></td>
                            </tr>
                            <tr>
                                <td class="clred">6</td>
                                <td class="v-loto-dau-6"></td>
                            </tr>
                            <tr>
                                <td class="clred">7</td>
                                <td class="v-loto-dau-7"></td>
                            </tr>
                            <tr>
                                <td class="clred">8</td>
                                <td class="v-loto-dau-8"></td>
                            </tr>
                            <tr>
                                <td class="clred">9</td>
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
                                <td class="clred">0</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-1"></td>
                                <td class="clred">1</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-2"></td>
                                <td class="clred">2</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-3"></td>
                                <td class="clred">3</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-4"></td>
                                <td class="clred">4</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-5"></td>
                                <td class="clred">5</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-6"></td>
                                <td class="clred">6</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-7"></td>
                                <td class="clred">7</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-8"></td>
                                <td class="clred">8</td>
                            </tr>
                            <tr>
                                <td class="v-loto-duoi-9"></td>
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
                        <li>Xem thêm <a href="{{route('tk.lo-gan',$province->short_name)}}"
                                        title="Thống kê lô gan {{$province->name}}">thống kê lô
                                gan {{$province->name}}</a></li>
                        <li>Mời bạn <a href="{{route('quay_thu.mt')}}"
                                       title="quay thử Miền Trung">quay thử Miền Trung</a> hôm nay để lấy hên
                        </li>
                        <li>Xem thêm <a href="{{route('xsmt')}}"
                                        title="Kết Quả XSMT">kết quả XSMT</a></li>
                        <li>Xem bảng kết quả <a
                                    href="{{route('xsmt.skq')}}"
                                    title="XSMT 30 ngày gần nhất">XSMT 30 ngày gần nhất</a></li>
                    </ul>
                </div>
                <div> 
                <div class="box-content">
                    
                   <p> <strong> XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} - Kết quả xổ số {{$province->name}} hôm nay {{getNgay($date)}} nhanh nhất tại xosotailoc.vip Xổ số {{getNgay($date)}}</strong>
                    </p>
                    </li>Trực tiếp {{strtoupper($province->short_name)}} ngày hôm nay {{getNgay($date)}} nhanh, chính xác nhất.</li>

                    XS{{strtoupper($province->short_name)}} {{$province->name}} {{getNgay($date)}} - Kết quả xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}  <strong> Xổ số XS{{strtoupper($province->short_name)}} {{$province->name}} {{getNgay($date)}}</strong> </li> trực tiếp lúc 17  giờ 15 phút. Xổ số hôm nay XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}  hàng tuần được mở thưởng bởi công ty xổ số kiến thiết của đài hôm nay  . Kết quả xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}  </li> bắt đầu quay từ giải tám cho đến giải nhất và cuối cùng là giải đặc biệt.
                    
                    Kết quả XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}- Xổ số miền XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}

                    <p><h2> <strong> Các Câu Hỏi Thường Gặp Về Xổ Số XS {{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}</strong> </h2> </p>
                    <p><h3> <strong> Làm thế nào để biết kết quả xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}}</strong>  </h3></p>

                    <p>Kết quả xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} được công bố trên các trang web xosotailoc.vip đề hoặc trên các kênh truyền hình vào mỗi ngày. </p>

                    <p><h3> <strong>  Tôi có thể mua vé xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} ở đâu? </strong>  </h3></p>

                    <p>Bạn có thể mua vé xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} tại các điểm bán vé hoặc trên các trang và ứng dụng xổ số trực tuyến. </p>

                   <p><h3> <strong>  Tôi có thể chơi xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} trên điện thoại di động không? </strong>  </h3></p>

                   <p> Hiện nay, có rất nhiều ứng dụng cho phép bạn chơi xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} trực tuyến trên điện thoại di động. </p>

                       <p><h3> <strong> Tôi có thể đổi vé xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} không? </strong>  </h3></p>
                    
                    <p> Không, vé xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} không thể đổi hoặc hoàn lại sau khi đã mua.</p>
                    
                       <p><h3> <strong> Tôi có thể chơi xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} nhiều lần trong ngày không? </strong>  </h3></p>
                    
                    <p> Có, bạn có thể chơi xổ số XS{{strtoupper($province->short_name)}} {{$province->name}}  {{getNgay($date)}} nhiều lần trong ngày với các kết quả xổ số khác nhau.</p>
                 </div>
                </div>
            </div>
        @endif
    </div>
    @php
    $day = getThuNumber(date('Y-m-d', time()));
    @endphp
@endsection

@section('afterJS')
    @if(strpos($province->ngay_quay,$day)!==false)
        <script src="{{url('frontend/js/lotteryLive.js')}}?v={{rand(1000,100000)}}"></script>
        <script type="text/javascript">

            var rootPath = '';

            l_root = rootPath.split(";");

            if (root == null)

                root = l_root[0];

            var appKey = '';

            var groupId = 2;

            var lotId = {{$province->id}};

            var fromPageView = 'KQD';

            var headingTag = 'h1';

            var interval;

            var timeInter = 1357 * 4; //thoi gian refresh

            LiveProvince(groupId, lotId, appKey, root, headingTag);

            interval = setInterval("LiveProvince(" + groupId + ", " + lotId + ", '" + appKey + "', '" + root + "', '" + headingTag + "')", timeInter);

            intervalVariable = setInterval('getRandomTextProvince()', 100);

        </script>
    @endif
@endsection
