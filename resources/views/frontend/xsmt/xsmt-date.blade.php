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
        @if(count($xsmts) > 0)
            @php
            $xsmtTinh = $xsmts[0];
            $count = count($xsmts);

            if($count==3){
            $div_class = 'three-city';
            $table_class = 'colthreecity';
            }elseif($count==4){
            $div_class = 'four-city';
            $table_class = 'colfourcity';
            }elseif($count==2){
            $div_class = 'two-city';
            $table_class = 'coltwocity';
            }
            @endphp

            {{--<div class="box">--}}
                {{--<div class="bg_gray">--}}
                    {{--<div class=" opt_date_full clearfix">--}}
                        {{--@if(!empty($xsmt_pre))--}}
                            {{--<a href="{{route('xsmt.date',getNgayLink($xsmt_pre->date))}}" class="ic-pre fl" title="KQXSMB ngày {{getNgay($xsmt_pre->date)}}"></a>--}}
                        {{--@endif--}}
                        {{--<label>--}}
                            {{--<strong>{{getThu($xsmtTinh->day)}}</strong> ---}}
                            {{--<input type="text" class="nobor" value="{{getNgay($xsmtTinh->date)}}" id="searchDateMT"/>--}}
                            {{--<span class='ic ic-calendar'></span>--}}
                        {{--</label>--}}
                        {{--@if(!empty($xsmt_next))--}}
                            {{--<a href="{{route('xsmt.date',getNgayLink($xsmt_next->date))}}" class="ic-next" title="KQXSMB ngày {{getNgay($xsmt_next->date)}}"></a>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="box" id='mt_kqngay_{{getNgayID($xsmtTinh->date)}}'>
                <div class="tit-mien clearfix"><h2>XSMT - Xổ số miền Trung {{getNgay($xsmtTinh->date)}}</h2>

                    <div><a class="sub-title" href="{{route('xsmt')}}" title="XSMT">XSMT</a> »
                        <a class="sub-title" href="{{route(getRouteDay($xsmtTinh->day,'xsmt'))}}"
                           title="XSMT {{getThu($xsmtTinh->day)}}">XSMT {{getThu($xsmtTinh->day)}}</a> » <a
                                class="sub-title"
                                href="{{route('xsmt.date',getNgayLink($xsmtTinh->date))}}"
                                title="XSMT ngày {{getNgay($xsmtTinh->date)}}">XSMT
                            ngày {{getNgay($xsmtTinh->date)}}</a>
                    </div>
                </div>
                <div id="load_kq_mt_0">
                    <div data-id="kq" class="{{$div_class}}" data-region="3">
                        <table class="{{$table_class}} colgiai extendable">
                            <tbody>
                            <tr class="gr-yellow">
                                <th class="first"></th>
                                @foreach ($xsmts as $xsmt)
                                    <th data-pid="{{$xsmt->id}}"><a
                                                href="{{route('xstinh.tinh',$xsmt->province->slug)}}"
                                                title="Xổ số {{$xsmt->province->name}}"
                                                class="underline bold">{{$xsmt->province->name}}</a>
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="g8">
                                <td>G8</td>
                                @foreach ($xsmts as $xsmt)
                                    <td>
                                        <div data-nc="2" class="v-g8 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_8_item_0">{{$xsmt->g8}}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G7</td>
                                @foreach ($xsmts as $xsmt)
                                    <td>
                                        <div data-nc="3" class="v-g7 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_7_item_0">{{$xsmt->g7}}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G6</td>
                                @foreach ($xsmts as $xsmt)
                                    <?php  $g6 = explode('-', $xsmt->g6)  ?>
                                    <td>
                                        <div data-nc="4" class="v-g6-0 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_6_item_0">@if(!empty($g6[0])){{$g6[0]}}@endif</div>
                                        <div data-nc="4" class="v-g6-1 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_6_item_1">@if(!empty($g6[1])){{$g6[1]}}@endif</div>
                                        <div data-nc="4" class="v-g6-2 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_6_item_2">@if(!empty($g6[2])){{$g6[2]}}@endif</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G5</td>
                                @foreach ($xsmts as $xsmt)
                                    <td id="{{strtoupper($xsmt->province->short_name)}}_prize_5_item_0">
                                        <div data-nc="4" class="v-g5 ">{{$xsmt->g5}}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G4</td>
                                @foreach ($xsmts as $xsmt)
                                    <?php  $g4 = explode('-', $xsmt->g4) ?>
                                    <td>
                                        <div data-nc="5" class="v-g4-0 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_4_item_0">@if(!empty($g4[0])){{$g4[0]}}@endif</div>
                                        <div data-nc="5" class="v-g4-1 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_4_item_1">@if(!empty($g4[1])){{$g4[1]}}@endif</div>
                                        <div data-nc="5" class="v-g4-2 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_4_item_2">@if(!empty($g4[2])){{$g4[2]}}@endif</div>
                                        <div data-nc="5" class="v-g4-3 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_4_item_3">@if(!empty($g4[3])){{$g4[3]}}@endif</div>
                                        <div data-nc="5" class="v-g4-4 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_4_item_4">@if(!empty($g4[4])){{$g4[4]}}@endif</div>
                                        <div data-nc="5" class="v-g4-5 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_4_item_5">@if(!empty($g4[5])){{$g4[5]}}@endif</div>
                                        <div data-nc="5" class="v-g4-6 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_4_item_6">@if(!empty($g4[6])){{$g4[6]}}@endif</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G3</td>
                                @foreach ($xsmts as $xsmt)
                                    <?php $g3 = explode('-', $xsmt->g3)  ?>
                                    <td>
                                        <div data-nc="5" class="v-g3-0 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_3_item_0">@if(!empty($g3[0])){{$g3[0]}}@endif</div>
                                        <div data-nc="5" class="v-g3-1 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_3_item_1">@if(!empty($g3[1])){{$g3[1]}}@endif</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G2</td>
                                @foreach ($xsmts as $xsmt)
                                    <td>
                                        <div data-nc="5" class="v-g2 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_2_item_0">{{$xsmt->g2}}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G1</td>
                                @foreach ($xsmts as $xsmt)
                                    <td>
                                        <div data-nc="5" class="v-g1 "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_1_item_0">{{$xsmt->g1}}</div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="gdb">
                                <td>ĐB</td>
                                @foreach ($xsmts as $xsmt)
                                    <td>
                                        <div data-nc="6" class="v-gdb "
                                             id="{{strtoupper($xsmt->province->short_name)}}_prize_Db_item_0">{{$xsmt->gdb}}</div>
                                    </td>
                                @endforeach
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

                    @foreach ($xsmts as $xsmt)
                        <?php
                        $xsmtStr = $xsmt->gdb . '-' . $xsmt->g1 . '-' . $xsmt->g2 . '-' . $xsmt->g3 . '-' . $xsmt->g4 . '-' . $xsmt->g5 . '-' . $xsmt->g6 . '-' . $xsmt->g7 . '-' . $xsmt->g8;
                        $xsmtLoto = getLoto($xsmtStr);
                        $xsmtDau[$xsmt->province->short_name] = getDau($xsmtLoto, substr($xsmt->gdb, strlen($xsmt->gdb) - 2, 2));
                        ?>
                    @endforeach
                    <div data-id="dd" class="col-firstlast {{$table_class}} colgiai">
                        <table class="firstlast-mn bold">
                            <tbody>
                            <tr class="header">
                                <th class="first">Đầu</th>
                                @foreach ($xsmts as $xsmt)
                                    <th id="livebangkqloto_{{strtoupper($xsmt->province->short_name)}}">{{$xsmt->province->name}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">0</td>
                                @foreach ($xsmts as $xsmt)
                                    <td id="mtloto_{{strtoupper($xsmt->province->short_name)}}_0"
                                        class="v-loto-dau-0">{!! $xsmtDau[$xsmt->province->short_name][0] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">1</td>
                                @foreach ($xsmts as $xsmt)
                                    <td id="mtloto_{{strtoupper($xsmt->province->short_name)}}_1"
                                        class="v-loto-dau-1">{!! $xsmtDau[$xsmt->province->short_name][1] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">2</td>
                                @foreach ($xsmts as $xsmt)
                                    <td id="mtloto_{{strtoupper($xsmt->province->short_name)}}_2"
                                        class="v-loto-dau-2">{!! $xsmtDau[$xsmt->province->short_name][2] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">3</td>
                                @foreach ($xsmts as $xsmt)
                                    <td id="mtloto_{{strtoupper($xsmt->province->short_name)}}_3"
                                        class="v-loto-dau-3">{!! $xsmtDau[$xsmt->province->short_name][3] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">4</td>
                                @foreach ($xsmts as $xsmt)
                                    <td id="mtloto_{{strtoupper($xsmt->province->short_name)}}_4"
                                        class="v-loto-dau-4">{!! $xsmtDau[$xsmt->province->short_name][4] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">5</td>
                                @foreach ($xsmts as $xsmt)
                                    <td id="mtloto_{{strtoupper($xsmt->province->short_name)}}_5"
                                        class="v-loto-dau-5">{!! $xsmtDau[$xsmt->province->short_name][5] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">6</td>
                                @foreach ($xsmts as $xsmt)
                                    <td id="mtloto_{{strtoupper($xsmt->province->short_name)}}_6"
                                        class="v-loto-dau-6">{!! $xsmtDau[$xsmt->province->short_name][6] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">7</td>
                                @foreach ($xsmts as $xsmt)
                                    <td id="mtloto_{{strtoupper($xsmt->province->short_name)}}_7"
                                        class="v-loto-dau-7">{!! $xsmtDau[$xsmt->province->short_name][7] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">8</td>
                                @foreach ($xsmts as $xsmt)
                                    <td id="mtloto_{{strtoupper($xsmt->province->short_name)}}_8"
                                        class="v-loto-dau-8">{!! $xsmtDau[$xsmt->province->short_name][8] !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">9</td>
                                @foreach ($xsmts as $xsmt)
                                    <td id="mtloto_{{strtoupper($xsmt->province->short_name)}}_9"
                                        class="v-loto-dau-9">{!! $xsmtDau[$xsmt->province->short_name][9] !!}</td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="see-more">
                    <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
                    <ul class="list-html-link two-column">
                        <li>Mời bạn <a href="{{route('quay_thu.mt')}}"
                                       title="quay thử miền Trung">quay thử miền Trung</a> hôm nay để lấy hên
                        </li>
                        <li>Xem thêm <a href="{{route('xsmt')}}"
                                        title="Kết Quả XSMT">kết quả XSMT</a></li>
                        <li>Xem bảng kết quả <a
                                    href="{{route('xsmt.skq')}}"
                                    title="XSMT 30 ngày gần nhất">XSMT 30 ngày gần nhất</a></li>
                    </ul>
                    
                     <div class="box-content">
                       <p> <strong> Xổ số miền Trung {{getNgay($date)}} </li> - Kết quả xổ số miền Trung hôm nay nhanh nhất tại xosotailoc.live Xổ số miền Trung {{getNgay($date)}}</strong>
                        </p>
                        </li>Trực tiếp xsmt {{getThu(getThuNumber($date))}} ngày Xổ số miền Trung {{getNgay($date)}}</li> nhanh, chính xác nhất.
    
                        xsmt <a href="{{route('xsmt.date',getNgayLink($date))}}" title="Xổ số miền Trung {{getNgay($date)}}"><strong>Xổ số miền Trung {{getNgay($date)}} </strong> </a> </li>  - Kết quả xổ số miền Trung hôm nay ngày <strong> Xổ số miền Trung {{getNgay($date)}}</strong> </li> trực tiếp lúc 16 giờ 15 phút. Xổ số hôm nay Xổ số miền Trung {{getNgay($date)}} </li> - xsmt {{getThu(getThuNumber($date))}} hàng tuần được mở thưởng bởi công ty xổ số kiến thiết của đài hôm nay  . Kết quả xổ số miền Trung Xổ số miền Trung {{getNgay($date)}} </li> bắt đầu quay từ giải tám cho đến giải nhất và cuối cùng là giải đặc biệt.
                        
                        Kết quả xsmt Xổ số miền Trung {{getNgay($date)}}  </li> - Xổ số miền Trung XSMT hôm nay - Trực tiếp KQXS miền Trung {{getThu(getThuNumber($date))}} ngày  Xổ số miền Trung {{getNgay($date)}} </li> 
                        <p><h2> <strong> Các Câu Hỏi Thường Gặp Về Xổ Số Miền Trung XSMT {{getNgay($date)}} {{getThu(getThuNumber($date))}}</strong> </h2> </p>
                        <p><h3> <strong> Làm thế nào để biết kết quả xổ số miền Trung  XSMT{{getNgay($date)}}</strong>  </h3></p>
    
                        <p>Kết quả xổ số miền Trung  XSMT{{getNgay($date)}} được công bố trên các trang web xosotailoc.live đề hoặc trên các kênh truyền hình vào mỗi ngày. </p>
    
                        <p><h3> <strong>  Tôi có thể mua vé xổ số miền Trung ngày  {{getNgay($date)}} ở đâu? </strong>  </h3></p>
    
                        <p>Bạn có thể mua vé xổ số miền Trung  XSMT {{getNgay($date)}}  tại các điểm bán vé hoặc trên các trang web đánh lô đề trực tuyến. </p>
    
                       <p><h3> <strong>  Tôi có thể chơi xổ số miền Trung XSMT{{getNgay($date)}} trên điện thoại di động không? </strong>  </h3></p>
    
                       <p> Hiện nay, có rất nhiều ứng dụng cho phép bạn chơi xổ số miền Trung  {{getNgay($date)}} trực tuyến trên điện thoại di động. </p>
    
                           <p><h3> <strong> Tôi có thể đổi vé xổ số miền Trung XSMT {{getNgay($date)}} không? </strong>  </h3></p>
                        
                        <p> Không, vé xổ số miền Trung  {{getNgay($date)}} không thể đổi hoặc hoàn lại sau khi đã mua.</p>
                        
                           <p><h3> <strong> Tôi có thể chơi xổ số miền Trung XSMT  {{getNgay($date)}}nhiều lần trong ngày không? </strong>  </h3></p>
                        
                        <p> Có, bạn có thể chơi xổ số miền Trung  {{getNgay($date)}} nhiều lần trong ngày với các kết quả xổ số khác nhau.</p>
                 </div>
                </div>
            </div>
        @else
            @php
            if(count($province_mt)==3){
            $div_class = 'three-city';
            $table_class = 'colthreecity';
            }elseif(count($province_mt)==4){
            $div_class = 'four-city';
            $table_class = 'colfourcity';
            }elseif(count($province_mt)==2){
            $div_class = 'two-city';
            $table_class = 'coltwocity';
            }
        @endphp
            <div class="box">
                <div class="bg_gray">
                    <div class=" opt_date_full clearfix">
                        <label>
                            <strong>{{getThu(getThuNumber($date))}}</strong> -
                            <input type="text" class="nobor" value="{{getNgayLink($date)}}" id="searchDateMT"/>
                            <span class='ic ic-calendar'></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="box" id='mt_kqngay_{{date('dmY', strtotime(getNgayLink($date)))}}'>
                <h2 class="tit-mien clearfix">
                    <strong>
                        <a class="title-a" href="{{route('xsmt')}}" title="XSMT">XSMT</a>
                        » <a class="title-a" href="{{route(getRouteDay(getThuNumber($date),'xsmt'))}}" title="XSMT {{getThu(getThuNumber($date))}}">XSMT {{getThu(getThuNumber($date))}}</a>
                        » <a class="title-a"  href="{{route('xsmt.date',getNgayLink($date))}}" title="Xổ số miền Trung {{getNgay($date)}}">Xổ số miền Trung {{getNgay($date)}}</a>
                    </strong>
                </h2>
                <div id="load_kq_mt_0">
                    <div data-id="kq" class="{{$div_class}}" data-region="3">
                        <table class="{{$table_class}} colgiai extendable">
                            <tbody>
                            <tr class="gr-yellow">
                                <th class="first"></th>
                                @foreach($province_mt as $province)
                                    <th data-pid="{{$province->id}}">
                                        <a class="underline bold" href="{{route('xstinh.tinh',$province->slug)}}"
                                           title="XS{{strtoupper($province->short_name)}}">
                                            {{$province->name}}
                                        </a>
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="g8">
                                <td>G8</td>
                                @foreach($province_mt as $province)
                                    <td>
                                        <div data-nc="2" class="v-g8"><i class="fas fa-spinner fa-pulse"></i></div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G7</td>
                                @foreach($province_mt as $province)
                                    <td>
                                        <div data-nc="3" class="v-g7"><i class="fas fa-spinner fa-pulse"></i></div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G6</td>
                                @foreach($province_mt as $province)
                                    <td>
                                        <div data-nc="4" class="v-g6-0"><i class="fas fa-spinner fa-pulse"></i></div>
                                        <div data-nc="4" class="v-g6-1"><i class="fas fa-spinner fa-pulse"></i></div>
                                        <div data-nc="4" class="v-g6-2"><i class="fas fa-spinner fa-pulse"></i></div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G5</td>
                                @foreach($province_mt as $province)
                                    <td>
                                        <div data-nc="4" class="v-g5"><i class="fas fa-spinner fa-pulse"></i></div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G4</td>
                                @foreach($province_mt as $province)
                                    <td>
                                        <div data-nc="5" class="v-g4-0"><i class="fas fa-spinner fa-pulse"></i></div>
                                        <div data-nc="5" class="v-g4-1"><i class="fas fa-spinner fa-pulse"></i></div>
                                        <div data-nc="5" class="v-g4-2"><i class="fas fa-spinner fa-pulse"></i></div>
                                        <div data-nc="5" class="v-g4-3"><i class="fas fa-spinner fa-pulse"></i></div>
                                        <div data-nc="5" class="v-g4-4"><i class="fas fa-spinner fa-pulse"></i></div>
                                        <div data-nc="5" class="v-g4-5"><i class="fas fa-spinner fa-pulse"></i></div>
                                        <div data-nc="5" class="v-g4-6"><i class="fas fa-spinner fa-pulse"></i></div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G3</td>
                                @foreach($province_mt as $province)
                                    <td>
                                        <div data-nc="5" class="v-g3-0"><i class="fas fa-spinner fa-pulse"></i></div>
                                        <div data-nc="5" class="v-g3-1"><i class="fas fa-spinner fa-pulse"></i></div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G2</td>
                                @foreach($province_mt as $province)
                                    <td>
                                        <div data-nc="5" class="v-g2"><i class="fas fa-spinner fa-pulse"></i></div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>G1</td>
                                @foreach($province_mt as $province)
                                    <td>
                                        <div data-nc="5" class="v-g1"><i class="fas fa-spinner fa-pulse"></i></div>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="gdb">
                                <td>ĐB</td>
                                @foreach($province_mt as $province)
                                    <td>
                                        <div data-nc="6" class="v-gdb"><i class="fas fa-spinner fa-pulse"></i></div>
                                    </td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                        <div class="control-panel">
                            <form class="digits-form">
                                <label class="radio" data-value="0">
                                    <input type="radio" name="showed-digits" value="0">
                                    <b></b>
                                    <span></span>
                                </label>
                                <label class="radio" data-value="2">
                                    <input type="radio" name="showed-digits" value="2">
                                    <b></b><span></span>
                                </label>
                                <label class="radio" data-value="3">
                                    <input type="radio" name="showed-digits" value="3">
                                    <b></b><span></span>
                                </label>
                            </form>
                            <div class="buttons-wrapper">
        <span class="zoom-in-button"><i class="icon zoom-in-icon"></i>
            <span></span>
        </span>
                            </div>
                        </div>
                    </div>
                    <div data-id="dd" class="col-firstlast {{$table_class}} colgiai">
                        <table class="firstlast-mn bold">
                            <tbody>
                            <tr class="header">
                                <th class="first">Đầu</th>
                                @foreach($province_mt as $province)
                                    <th>{{$province->name}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">0</td>
                                @foreach($province_mt as $province)
                                    <td class="v-loto-dau-0"></td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">1</td>
                                @foreach($province_mt as $province)
                                    <td class="v-loto-dau-1">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">2</td>
                                @foreach($province_mt as $province)
                                    <td class="v-loto-dau-2">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">3</td>
                                @foreach($province_mt as $province)
                                    <td class="v-loto-dau-3">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">4</td>
                                @foreach($province_mt as $province)
                                    <td class="v-loto-dau-4">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">5</td>
                                @foreach($province_mt as $province)
                                    <td class="v-loto-dau-5">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">6</td>
                                @foreach($province_mt as $province)
                                    <td class="v-loto-dau-6">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">7</td>
                                @foreach($province_mt as $province)
                                    <td class="v-loto-dau-7">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">8</td>
                                @foreach($province_mt as $province)
                                    <td class="v-loto-dau-8">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="clnote bold">9</td>
                                <td class="v-loto-dau-9">
                                </td>
                                <td class="v-loto-dau-9">
                                </td>
                                <td class="v-loto-dau-9">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="see-more">
                    <div class="bold see-more-title">⇒ Ngoài ra bạn có thể xem thêm:</div>
                    <ul class="list-html-link two-column">
                        <li>Mời bạn <a href="{{route('quay_thu.mt')}}"
                                       title="quay thử miền Trung">quay thử miền Trung</a> hôm nay để lấy hên
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
                       <p> <strong> Xổ số miền Trung {{getNgay($date)}} </li> - Kết quả xổ số miền Trung hôm nay nhanh nhất tại xosotailoc.live Xổ số miền Trung {{getNgay($date)}}</strong>
                        </p>
                        </li>Trực tiếp xsmt {{getThu(getThuNumber($date))}} ngày Xổ số miền Trung {{getNgay($date)}}</li> nhanh, chính xác nhất.
    
                        xsmt <a href="{{route('xsmt.date',getNgayLink($date))}}" title="Xổ số miền Trung {{getNgay($date)}}"><strong>Xổ số miền Trung {{getNgay($date)}} </strong> </a> </li>  - Kết quả xổ số miền Trung hôm nay ngày <strong> Xổ số miền Trung {{getNgay($date)}}</strong> </li> trực tiếp lúc 16 giờ 15 phút. Xổ số hôm nay Xổ số miền Trung {{getNgay($date)}} </li> - xsmt {{getThu(getThuNumber($date))}} hàng tuần được mở thưởng bởi công ty xổ số kiến thiết của đài hôm nay  . Kết quả xổ số miền Trung Xổ số miền Trung {{getNgay($date)}} </li> bắt đầu quay từ giải tám cho đến giải nhất và cuối cùng là giải đặc biệt.
                        
                        Kết quả xsmt Xổ số miền Trung {{getNgay($date)}}  </li> - Xổ số miền Trung XSMT hôm nay - Trực tiếp KQXS miền Trung {{getThu(getThuNumber($date))}} ngày  Xổ số miền Trung {{getNgay($date)}} </li> 
                        <p><h2> <strong> Các Câu Hỏi Thường Gặp Về Xổ Số Miền Trung XSMT {{getNgay($date)}} {{getThu(getThuNumber($date))}}</strong> </h2> </p>
                        <p><h3> <strong> Làm thế nào để biết kết quả xổ số miền Trung  XSMT{{getNgay($date)}}</strong>  </h3></p>
    
                        <p>Kết quả xổ số miền Trung  XSMT{{getNgay($date)}} được công bố trên các trang web xosotailoc.live đề hoặc trên các kênh truyền hình vào mỗi ngày. </p>
    
                        <p><h3> <strong>  Tôi có thể mua vé xổ số miền Trung ngày  {{getNgay($date)}} ở đâu? </strong>  </h3></p>
    
                        <p>Bạn có thể mua vé xổ số miền Trung  XSMT {{getNgay($date)}}  tại các điểm bán vé hoặc trên các trang web đánh lô đề trực tuyến. </p>
    
                       <p><h3> <strong>  Tôi có thể chơi xổ số miền Trung XSMT{{getNgay($date)}} trên điện thoại di động không? </strong>  </h3></p>
    
                       <p> Hiện nay, có rất nhiều ứng dụng cho phép bạn chơi xổ số miền Trung  {{getNgay($date)}} trực tuyến trên điện thoại di động. </p>
    
                           <p><h3> <strong> Tôi có thể đổi vé xổ số miền Trung XSMT {{getNgay($date)}} không? </strong>  </h3></p>
                        
                        <p> Không, vé xổ số miền Trung  {{getNgay($date)}} không thể đổi hoặc hoàn lại sau khi đã mua.</p>
                        
                           <p><h3> <strong> Tôi có thể chơi xổ số miền Trung XSMT  {{getNgay($date)}}nhiều lần trong ngày không? </strong>  </h3></p>
                        
                        <p> Có, bạn có thể chơi xổ số miền Trung  {{getNgay($date)}} nhiều lần trong ngày với các kết quả xổ số khác nhau.</p>
                 </div>
                </div>
            </div>
        @endif

    </div>
@endsection

@section('afterJS')

    @if(count($xsmts) > 0)

        @if(getNgaycheo($date_2) ==date('Y-m-d',time()))

            <script src="{{url('frontend/js/lotteryLive.js')}}?v={{rand(1000,100000)}}"></script>

            <script type="text/javascript">

                var rootPath = '';

                var appKey = '';

                var groupId = 3;

                var headingTag = 'h1';

                var interval;

                var timeInter = 1357 * 4; //thoi gian refresh

                LiveMT(groupId, appKey, rootPath, headingTag);

                interval = setInterval("LiveMT(" + groupId + ", '" + appKey + "', '" + rootPath + "', '" + headingTag + "')", timeInter);

                intervalVariable = setInterval('getRandomTextTN()', 100);

            </script>

        @endif

    @endif

@endsection