<h2 class="tit-mien bold">Thống kê tần suất lô tô {{$province_name}} trong vòng {{$rollingNumber}} ngày trước {{getNgay($dateEnd)}}</h2>
<div class="scoll scoll-noheight">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="colgiai tk-txloto" id="tk-txloto">
        <thead id="tk-txloto-head">
        <tr><th>Bộ số</th>
            @for ($i =1; $i < $soboso+1; $i++)
                <th class="nh {{$i-1}}"><a class="num" href="#">{!!$arrayCollect[$i][0]!!}</a></th>
            @endfor

        </tr>
        </thead>
        <tbody>
        @for ($i=1; $i < $soboso+1; $i++)
            @php $ok[$i] = true; @endphp
        @endfor
        @for ($j = 1; $j < $rollingNumber; $j++)
            <tr>
                <td>{!!$arrayCollect[0][$j]!!}</td>
                @for ($i =1; $i < $soboso+1; $i++)
                    @if($arrayCollect[$i][$j][0]!==0)
                        @php $ok[$i] = false; @endphp
                        @if($arrayCollect[$i][$j][1]==1)
                            <td class="c {{$i-1}} c1"> {!!$arrayCollect[$i][$j][0]!!} </td>
                        @else
                            <td class="c {{$i-1}} c{!!$arrayCollect[$i][$j][0] + 1!!}"> {!!$arrayCollect[$i][$j][0]!!} </td>
                        @endif
                    @else
                        @if($ok[$i])
                            <td class="c {{$i-1}} c0"></td>
                        @else
                            <td class="c {{$i-1}} c_"></td>
                        @endif
                    @endif
                @endfor
            </tr>
        @endfor
        <tr>
            <td>
                Lần
            </td>
            @for ($i =1; $i < $soboso+1; $i++)
                <td class="s rate"><span>{!!$arrayCollect[$i][$rollingNumber+1]!!}</span><span class="hrate" style="height:{!!$arrayCollect[$i][$rollingNumber+1]!!}px"></span></td>
            @endfor
        </tr>
        </tbody>
    </table>
</div>
<div class="fullscreen fullscreen-note mag10-5 clearfix">
    <ul class="box-note-table">
        <li class=" pad5"><strong class="c c2">&nbsp;1&nbsp;</strong>: Về 1 nháy</li>
        <li class=" pad5"><strong class="c c1">&nbsp;1&nbsp;</strong>: Giải đặc biệt</li>
        <li class=" pad5"><strong class="c c3">&nbsp;2&nbsp;</strong>: Về 2 nháy</li>
        <li class=" pad5"><strong class="c c4">&nbsp;3&nbsp;</strong>: Về 3 nháy</li>
        <li class=" pad5"><strong class="c c5">&nbsp;4&nbsp;</strong>: Về 4 nháy</li>
    </ul>
</div>