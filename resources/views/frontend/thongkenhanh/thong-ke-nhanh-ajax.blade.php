<h2 class="bg_red pad10-5">Thống kê nhanh xổ số {{$province_name}} từ ngày {{getNgay($dateStart)}} đến ngày {{getNgay($dateEnd)}}</h2>
<div class="scoll">
                <textarea class="textarea mb-2 mt-2" rows="2" id="numbers" name="numbers"
                          placeholder="Điền các bộ số bạn muốn xem (ngăn cách bằng dấu phẩy hoặc cách). Để trống để xem mọi bộ số"
                          onkeyup="thong_ke_nhanh_show_hide()"></textarea>

    <select id="quick_show" onchange="thong_ke_nhanh_quick_show()"
            class=" form-select mb-2">
        <option value="0">Tất Cả</option>
        <option value="1">Chẵn</option>
        <option value="2">Lẻ</option>
        <option value="3">Tổng Chẵn</option>
        <option value="4">Tổng Lẻ</option>
        <option value="5">Chẵn Chẵn</option>
        <option value="6">Lẻ Lẻ</option>
        <option value="7">Chẵn Lẻ</option>
        <option value="8">Lẻ Chẵn</option>
        <option value="9">Bộ Kép</option>
        <option value="10">Sát Kép</option>
    </select>
    <table class="tbl-chuky" id="tknhanhdata">
        <tbody>
        <tr>
            <th style="width:10%">Bộ số</th>
            <th style="width:30%">Số ngày chưa về</th>
            <th style="width:30%">Ngày về gần nhất</th>
            <th style="width:30%"><p class="mag0">Tổng số lần xuất hiện</p></th>
        </tr>
        @for($t = 0; $t< count($ArrayCollect); $t++)
            <tr data-n="{{intval($ArrayCollect[$t][0])}}">
                <td><strong class="clred s18">{{$ArrayCollect[$t][0]}}</strong></td>
                @if($ArrayCollect[$t][2]==-1)
                    <td>
                        <p>Không xuất hiện</p>
                    </td>
                @else
                    <td>
                        <p class="mag0"><strong class="s18">{{$ArrayCollect[$t][2]}}</strong></p>
                    </td>
                @endif
                @if($short_name=='mb')
                    <td class="text-center"><a target="_blank" href="{{route('xsmb.date',str_replace('/','-',$ArrayCollect[$t][1]))}}">{{$ArrayCollect[$t][1]}}</a></td>
                @else
                    <td class="text-center"><a target="_blank" href="{{route('xstinh.date',[$short_name,str_replace('/','-',$ArrayCollect[$t][1])])}}">{{$ArrayCollect[$t][1]}}</a></td>
                @endif
                <td><strong class="s18">{{$ArrayCollect[$t][3]}}</strong></td>
            </tr>
        @endfor
        </tbody>
    </table>
</div>
