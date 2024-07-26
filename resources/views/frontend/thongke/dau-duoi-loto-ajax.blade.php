<h2 class="bg_red pad10-5">
    Thống kê đầu loto {{$province_name}} trong vòng {{$rollingNumber}} ngày trước {{$dateEnd}}
</h2>
<div class="scoll">
    <table class="mag0">
        <tbody><tr>
            <th class="pad0"><div class="ic ic-img2"></div></th>
            <th>0</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
        </tr>
        @foreach($ArrayCollect as $key=>$value)
            <tr>
                @if($short_name=='mb')
                    <td style="width:68px" class="s12"><a target="_blank" href="{{route('xsmb.date',str_replace('/','-',getNgay($key)))}}">{{getNgay($key)}}</a></td>
                @else
                    <td style="width:68px" class="s12"><a target="_blank" href="{{route('xstinh.date',[$short_name,str_replace('/','-',getNgay($key))])}}">{{getNgay($key)}}</a></td>
                @endif
                @for ($t = 0; $t < 10; $t++)
                    <td class="tt_dau_lt"><div class="w40">{{$value[$t]}}</div></td>
                @endfor
            </tr>
        @endforeach
        <tr class="row-rate">
            <td><strong>Tổng</strong></td>
            @for ($t = 0; $t < 10; $t++)
                <td>
                    <strong>{{$tongDau[$t]}}</strong>
                    <div class="rate txt-center">
                        <span style="height:{{$tongDau[$t]}}px" class="hrate"></span>
                    </div>
                </td>
            @endfor
        </tr>
        </tbody>
    </table>

</div>
<h2 class="bg_red pad10-5">
    <h2>Thống kê theo Đuôi loto {{$province_name}} trong vòng {{$rollingNumber}} ngày trước {{$dateEnd}}</h2>
</h2>
<div class="scoll">
    <table class="mag0">
        <tbody><tr>
            <th class="pad0"><div class="ic ic-img5"></div></th>
            <th><div class="w40">0</div></th>
            <th><div class="w40">1</div></th>
            <th><div class="w40">2</div></th>
            <th><div class="w40">3</div></th>
            <th><div class="w40">4</div></th>
            <th><div class="w40">5</div></th>
            <th><div class="w40">6</div></th>
            <th><div class="w40">7</div></th>
            <th><div class="w40">8</div></th>
            <th><div class="w40">9</div></th>
        </tr>
        @foreach($ArrayCollect_Duoi as $key=>$value)
            <tr>
                @if($short_name=='mb')
                    <td style="width:68px" class="s12"><a target="_blank" href="{{route('xsmb.date',str_replace('/','-',getNgay($key)))}}">{{getNgay($key)}}</a></td>
                @else
                    <td style="width:68px" class="s12"><a target="_blank" href="{{route('xstinh.date',[$short_name,str_replace('/','-',getNgay($key))])}}">{{getNgay($key)}}</a></td>
                @endif
                @for ($t = 0; $t < 10; $t++)
                    <td class="tt_dau_lt"><div class="w40">{{$value[$t]}}</div></td>
                @endfor
            </tr>
        @endforeach
        <tr class="row-rate">
            <td><strong>Tổng</strong></td>
            @for ($t = 0; $t < 10; $t++)
                <td>
                    <strong>{{$tongDuoi[$t]}}</strong>
                    <div class="rate txt-center">
                        <span style="height:{{$tongDuoi[$t]}}px" class="hrate"></span>
                    </div>
                </td>
            @endfor
        </tr>
        </tbody>
    </table>
</div>
<h2 class="bg_red pad10-5">
    Thống kê theo Tổng loto {{$province_name}} trong vòng {{$rollingNumber}} ngày trước {{$dateEnd}}
</h2>
<div class="scoll">
    <table class="mag0">
        <tbody><tr>
            <th class="pad0"><div class="ic ic-img5"></div></th>
            <th><div class="w40">0</div></th>
            <th><div class="w40">1</div></th>
            <th><div class="w40">2</div></th>
            <th><div class="w40">3</div></th>
            <th><div class="w40">4</div></th>
            <th><div class="w40">5</div></th>
            <th><div class="w40">6</div></th>
            <th><div class="w40">7</div></th>
            <th><div class="w40">8</div></th>
            <th><div class="w40">9</div></th>
        </tr>
        @foreach($ArrayCollect_Tong as $key=>$value)
            <tr>
                @if($short_name=='mb')
                    <td style="width:68px" class="s12"><a target="_blank" href="{{route('xsmb.date',str_replace('/','-',getNgay($key)))}}">{{getNgay($key)}}</a></td>
                @else
                    <td style="width:68px" class="s12"><a target="_blank" href="{{route('xstinh.date',[$short_name,str_replace('/','-',getNgay($key))])}}">{{getNgay($key)}}</a></td>
                @endif
                @for ($t = 0; $t < 10; $t++)
                    <td class="tt_dau_lt"><div class="w40">{{$value[$t]}}</div></td>
                @endfor
            </tr>
        @endforeach
        <tr class="row-rate">
            <td><strong>Tổng</strong></td>
            @for ($t = 0; $t < 10; $t++)
                <td>
                    <strong>{{$tongTong[$t]}}</strong>
                    <div class="rate txt-center">
                        <span style="height:{{$tongTong[$t]}}px" class="hrate"></span>
                    </div>
                </td>
            @endfor
        </tr>
        </tbody>
    </table>
</div>
<div class="see-more">
    <ul class="list-html-link two-column">
        <li>Xem thống kê <a href="{{route('tk.lo-gan','mb')}}" title="lô gan miền Bắc">lô gan miền Bắc</a>        </li>
        <li>Xem thêm <a href="#" title="thống kê 2 số cuối giải đặc biệt miền Bắc">thống kê 2 số cuối giải đặc biệt miền Bắc</a></li>
        <li>Mời bạn <a href="{{route('quay_thu.mb')}}" title="quay thử miền Bắc">quay thử miền Bắc</a></li>
        <li>Xem thêm <a href="#" title="Thống kê tần suất lô tô">thống kê tần suất lô tô</a></li>
    </ul>
</div>