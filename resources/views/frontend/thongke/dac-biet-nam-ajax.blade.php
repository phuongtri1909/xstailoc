@if(!empty($province_name))
    <h3 class="tit-mien bold">Bảng đặc biệt Xổ Số {{$province_name}} năm {{$year}}</h3>
@else
    <h3 class="tit-mien bold">Bảng đặc biệt Xổ Số miền Bắc năm {{$year}}</h3>
@endif
<div class="box tong" style="overflow: auto;" id="monthly-result">
    <table>
        <tbody>
        <tr>
            <th class="td-split">
                <div>
                    <span class="top">Tháng</span>
                    <span class="bottom">Ngày</span>
                    <div class="line"></div>
                </div>
            </th>
            <th width="70px">1/{{$year}}</th>
            <th width="70px">2/{{$year}}</th>
            <th width="70px">3/{{$year}}</th>
            <th width="70px">4/{{$year}}</th>
            <th width="70px">5/{{$year}}</th>
            <th width="70px">6/{{$year}}</th>
            <th width="70px">7/{{$year}}</th>
            <th width="70px">8/{{$year}}</th>
            <th width="70px">9/{{$year}}</th>
            <th width="70px">10/{{$year}}</th>
            <th width="70px">11/{{$year}}</th>
            <th width="70px">12/{{$year}}</th>
        </tr>
        @for($d=1;$d<=31;$d++)
            <tr>
                <?php  if ($d < 10) $day = '0' . $d; else $day = $d; ?>
                <td>{{$day}}</td>
                @for($t=1;$t<=12;$t++)
                    <?php if ($t < 10) $th = '0' . $t; else $th = $t;?>
                    @if(isset($arrkq[$th][$day]))
                        @php $kq = $arrkq[$th][$day]; @endphp
                        @if($kq->day==8)
                            <td class="light-yellow">
                                <div class="s14 bold">{{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span class="clred">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                            </td>
                        @else
                            <td class="">
                                <div class="s14 bold">{{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span class="clred">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                            </td>
                        @endif
                    @else
                        <td></td>
                    @endif
                @endfor
            </tr>
        @endfor
        </tbody>
    </table>
</div>
<div class="sticky-bottom-header">

    <div class="dsp-mobile" id="zoom-box">
        <div class="zoom-box zb-minus" data-value="-0.25" style="bottom: 80px">
            <img width="20px" src="/frontend/images/zoom_out_1.png" alt="Thu nhỏ">
        </div>
        <div class="zoom-box zb-plus" data-value="0.25" style="bottom: 130px">
            <img width="20px" src="/frontend/images/zoom_in_1.png" alt="Phóng to">
        </div>
    </div>
</div>