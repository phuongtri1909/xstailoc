<div class="box tbl-row-hover">

    <h2 class="tit-mien bold"><a href="{{route('tk.lo-gan',$short_name)}}" title="thống kê lô gan {{$province_name}}" class="title-a">Thống kê lô gan {{$province_name}}</a> lâu chưa về nhất tính đến ngày hôm nay
    </h2>
    <div>
        <table class="mag0">
            <tbody><tr>
                <th>Bộ số</th>
                <th>Ngày ra gần đây</th>
                <th>Số ngày gan</th>
                <th>Gan cực đại</th>
            </tr>
            @for($t = 0; $t< count($ArrayCollect); $t++)
                @if($ArrayCollect[$t][2] >= $count)
                    <tr>
                        <td><strong class="s18">{{$ArrayCollect[$t][0]}}</strong></td>
                        @if($short_name=='mb')
                            <td><a class="sub-title" href="{{route('xsmb.date',getNgayLink($ArrayCollect[$t][1]))}}" title="xổ số {{$province_name}} ngày {{getNgay($ArrayCollect[$t][1])}}">{{getNgay($ArrayCollect[$t][1])}}</a></td>
                        @else
                            <td><a class="sub-title" href="{{route('xstinh.date',[$short_name,getNgayLink($ArrayCollect[$t][1])])}}" title="xổ số {{$province_name}} ngày {{getNgay($ArrayCollect[$t][1])}}">{{getNgay($ArrayCollect[$t][1])}}</a></td>
                        @endif
                        <td class="s18 clred bold">{{$ArrayCollect[$t][2]}}</td>
                        <td class="s18 clred bold">{{$maxgan[$ArrayCollect[$t][0]]}}</td>
                    </tr>
                @endif
            @endfor
            </tbody>
        </table>
    </div>
</div>
<div class="box tbl-row-hover clearfix">

    <h2 class="tit-mien bold"><a href="{{route('tk.lo-gan',$short_name)}}" title="thống kê lô gan {{$province_name}}" class="title-a">Cặp lô gan {{$province_name}}</a> lâu chưa về nhất tính đến ngày hôm nay
    </h2>
    <div>
        <table class="mag0">
            <tbody><tr>
                <th>Cặp số</th>
                <th>Ngày ra gần đây</th>
                <th>Số ngày gan</th>
                <th>Gan cực đại</th>
            </tr>
            @for($t = 0; $t< count($ArrayCollect_cap); $t++)
                @if($ArrayCollect_cap[$t][2] >=3)
                    <tr>
                        <td class="s18 bold">{{$ArrayCollect_cap[$t][0]}}-{{lon($ArrayCollect_cap[$t][0])}}</td>
                        @if($short_name=='mb')
                            <td><a class="sub-title" href="{{route('xsmb.date',getNgayLink($ArrayCollect_cap[$t][1]))}}" title="xổ số {{$province_name}} ngày {{getNgay($ArrayCollect_cap[$t][1])}}">{{getNgay($ArrayCollect_cap[$t][1])}}</a></td>
                        @else
                            <td><a class="sub-title" href="{{route('xstinh.date',[$short_name,getNgayLink($ArrayCollect_cap[$t][1])])}}" title="xổ số {{$province_name}} ngày {{getNgay($ArrayCollect_cap[$t][1])}}">{{getNgay($ArrayCollect_cap[$t][1])}}</a></td>
                        @endif
                        <td class="s18 clred bold">{{$ArrayCollect_cap[$t][2]}}</td>
                        <td class="s18 clred bold">{{$maxgan_cap[$ArrayCollect_cap[$t][0]]}}</td>
                    </tr>
                @endif
            @endfor
            </tbody>
        </table>
    </div>
</div>
<div class="box tbl-row-hover clearfix">
    <h2 class="tit-mien bold"><a href="{{route('tk.lo-gan',$short_name)}}" title="thống kê lô gan {{$province_name}}" class="title-a">Gan cực đại {{$province_name}}</a> các số từ 00-99 từ trước đến nay
    </h2>
    <div>
        <table class="mag0">
            <tbody><tr>
                <th>Số</th>
                <th>Gan max</th>
                <th>Thời gian</th>
                <th>Ngày về gần đây</th>
            </tr>
            @php $d=0; @endphp
            @foreach($kqgan as $item)
                <tr>
                    <td class="s18 bold">{{$item->loto}}</td>
                    <td class="s18 clred bold">{{$item->max}}</td>
                    <td class="s18 bold"><b>{{getNgay($item->date)}}</b> đến <b>{{getNgay($item->date_end)}}</b></td>
                    @if(!empty($logan_arr[$d][1]))
                        @if($short_name=='mb')
                            <td><a class="sub-title" href="{{route('xsmb.date',getNgayLink($logan_arr[$d][1]))}}" title="xổ số {{$province_name}} ngày {{getNgay($logan_arr[$d][1])}}">{{getNgay($logan_arr[$d][1])}}</a></td>
                        @else
                            <td><a class="sub-title" href="{{route('xstinh.date',[$short_name,getNgayLink($logan_arr[$d][1])])}}" title="xổ số {{$province_name}} ngày {{getNgay($logan_arr[$d][1])}}">{{getNgay($logan_arr[$d][1])}}</a></td>
                        @endif
                    @endif
                </tr>
                @php $d++; @endphp
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="box tbl-row-hover clearfix">
    <h2 class="tit-mien bold"><a href="{{route('tk.lo-gan',$short_name)}}" title="thống kê lô gan {{$province_name}}" class="title-a">Gan cực đại {{$province_name}}</a> các cặp lô từ trước đến nay
    </h2>
    <div>
        <table class="mag0">
            <tbody><tr>
                <th>Cặp</th>
                <th>Gan max</th>
                <th>Thời gian</th>
                <th>Ngày về gần đây</th>
            </tr>
            @php $d=0; @endphp
            @foreach($kqgan_cap as $item)
                <tr>
                    <td class="s18 bold">{{$item->loto}}-{{lon($item->loto)}}</td>
                    <td class="s18 clred bold">{{$item->max}}</td>
                    <td class="s18 bold"><b>{{getNgay($item->date)}}</b> đến <b>{{getNgay($item->date_end)}}</b></td>
                    @if($short_name=='mb')
                        <td><a class="sub-title" href="{{route('xsmb.date',getNgayLink($logan_cap_arr[$d][1]))}}" title="xổ số {{$province_name}} ngày {{getNgay($logan_cap_arr[$d][1])}}">{{getNgay($logan_cap_arr[$d][1])}}</a></td>
                    @else
                        <td><a class="sub-title" href="{{route('xstinh.date',[$short_name,getNgayLink($logan_cap_arr[$d][1])])}}" title="xổ số {{$province_name}} ngày {{getNgay($logan_cap_arr[$d][1])}}">{{getNgay($logan_cap_arr[$d][1])}}</a></td>
                    @endif
                </tr>
                @php $d++; @endphp
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="box tbl-row-hover">
    <h2 class="tit-mien bold">Thống kê giải đặc biệt {{$province_name}} lâu chưa về nhất tính đến ngày hôm nay</h2>
    <div>
        <table class="mag0">
            <tbody>
            <tr>
                <th>Số</th>
                <th>Gan/Ngày</th>
                <th>Gan Max</th>
            </tr>
            @for($t = 0; $t< count($Array_Boso); $t++)
                @if($Array_Boso[$t][1] >=0)
                    <tr>
                        <td class="s18 bold">{{$Array_Boso[$t][0]}}</td>
                        <td class="s18 bold"><span class="clred">{{$Array_Boso[$t][1]}}</span> ngày</td>
                        <td class="s18 bold"><span class="clred">{{$maxgan_boso[$Array_Boso[$t][0]]}}</span> ngày</td>
                    </tr>
                @endif
            @endfor
            </tbody>
        </table>
    </div>
</div>
<div class="box tbl-row-hover">
    <h2 class="tit-mien bold">Thống kê đầu giải đặc biệt {{$province_name}} lâu chưa ra
    </h2>
    <div>
        <table class="mag0">
            <tbody>
            <tr>
                <th>Đầu</th>
                <th>Gan/Ngày</th>
                <th>Gan Max</th>
            </tr>
            @for($t = 0; $t< count($Array_Dau); $t++)
                @if($Array_Dau[$t][1] >=0)
                    <tr>
                        <td class="s18 bold">{{$Array_Dau[$t][0]}}</td>
                        <td class="s18 bold"><span class="clred">{{$Array_Dau[$t][1]}}</span> ngày</td>
                        <td class="s18 bold"><span class="clred">{{$maxgan_dau[$Array_Dau[$t][0]]}}</span> ngày</td>
                    </tr>
                @endif
            @endfor
            </tbody>
        </table>
    </div>
</div>
<div class="box tbl-row-hover">
    <h2 class="tit-mien bold">Thống kê đuôi giải đặc biệt {{$province_name}} lâu chưa về
    </h2>
    <div class="scoll">
        <table class="mag0">
            <tbody><tr>
                <th>Đuôi</th>
                <th>Gan/Ngày</th>
                <th>Gan Max</th>
            </tr>
            @for($t = 0; $t< count($Array_Duoi); $t++)
                @if($Array_Duoi[$t][1] >=0)
                    <tr>
                        <td class="s18 bold">{{$Array_Duoi[$t][0]}}</td>
                        <td class="s18 bold"><span class="clred">{{$Array_Duoi[$t][1]}}</span> ngày</td>
                        <td class="s18 bold"><span class="clred">{{$maxgan_dau[$Array_Duoi[$t][0]]}}</span> ngày</td>
                    </tr>
                @endif
            @endfor
            </tbody>
        </table>
    </div>
</div>
<div class="box tbl-row-hover">
    <h2 class="tit-mien bold">Thống kê tổng giải đặc biệt {{$province_name}} lâu chưa về
    </h2>
    <div class="scoll">
        <table class="mag0">
            <tbody><tr>
                <th>Tổng</th>
                <th>Gan/Ngày</th>
                <th>Gan Max</th>
            </tr>
            @for($t = 0; $t< count($Array_Tong); $t++)
                @if($Array_Tong[$t][1] >=0)
                    <tr>
                        <td class="s18 bold">{{$Array_Tong[$t][0]}}</td>
                        <td class="s18 bold"><span class="clred">{{$Array_Tong[$t][1]}}</span> ngày</td>
                        <td class="s18 bold"><span class="clred">{{$maxgan_dau[$Array_Tong[$t][0]]}}</span> ngày</td>
                    </tr>
                @endif
            @endfor
            </tbody>
        </table>
    </div>
</div>