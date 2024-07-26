@if(!empty($province_name))
    <h2 class="tit-mien bold">Bảng đặc biệt {{$province_name}} theo tuần</h2>
@else
    <h2 class="tit-mien bold">Bảng đặc biệt miền Bắc theo tuần</h2>
@endif
<div class="title-c2 pad10 txt-center">
    <div class="toogle-buttons">
                        <span class="toggle-button">
                            <input type="checkbox" id="dau-toggle-input" data-class="dau" class="cbx dspnone">
                            <label class="lbl1" for="dau-toggle-input"></label><span>Đầu</span>
                        </span>
                        <span class="toggle-button">
                            <input type="checkbox" id="duoi-toggle-input" data-class="duoi" class="cbx dspnone">
                            <label class="lbl1" for="duoi-toggle-input"></label><span>Đuôi</span>
                        </span>
                        <span class="toggle-button">
                            <input type="checkbox" id="loto-toggle-input" data-class="loto" class="cbx dspnone">
                            <label class="lbl1" for="loto-toggle-input"></label><span>Loto</span>
                        </span>
                        <span class="toggle-button">
                            <input type="checkbox" id="tong-toggle-input" data-class="tong" class="cbx dspnone">
                            <label class="lbl1" for="tong-toggle-input"></label><span>Tổng</span>
                        </span>
    </div>

</div>
<div class="tk-tong-db tk-db">
    <table>
        <tbody>
        <tr>
            <th>Thứ 2</th>
            <th>Thứ 3</th>
            <th>Thứ 4</th>
            <th>Thứ 5</th>
            <th>Thứ 6</th>
            <th>Thứ 7</th>
            <th>CN</th>
        </tr>
        <tr>
            @for($i=2;$i<$kqs[0]->day;$i++)
                <td>
                    <span></span>
                </td>
            @endfor
            @php $d = $kqs[0]->day;@endphp
            @foreach($kqs as $kq)
                @if($d==$kq->day)
                    <td>
                        <div> {{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span
                                    class="clblue">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                        <div class="ngay-quay">{{getNgayThangNam2So($kq->date)}}</div>
                        <div class="clnote dau ">{{Tong(substr($kq->gdb,strlen($kq->gdb)-2))}}</div>
                        <div class="clnote duoi ">{{substr($kq->gdb,strlen($kq->gdb)-2,1)}}</div>
                        <div class="clnote loto ">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</div>
                        <div class="clnote tong ">{{substr($kq->gdb,strlen($kq->gdb)-1,1)}}</div>

                        <span></span>
                    </td>
                @else
                    @while ($d!=$kq->day)
                        <td>
                            <span></span>
                        </td>
                        @if($d%8==0) </tr>
        <tr> @php $d=1; @endphp @endif
            @php $d++; @endphp
            @if($d==$kq->day)
                <td>
                    <div> {{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span
                                class="clblue">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                    <div class="ngay-quay">{{getNgayThangNam2So($kq->date)}}</div>
                    <div class="clnote dau ">{{Tong(substr($kq->gdb,strlen($kq->gdb)-2))}}</div>
                    <div class="clnote duoi ">{{substr($kq->gdb,strlen($kq->gdb)-2,1)}}</div>
                    <div class="clnote loto ">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</div>
                    <div class="clnote tong ">{{substr($kq->gdb,strlen($kq->gdb)-1,1)}}</div>

                    <span></span>
                </td>
            @endif
            @endwhile
            @endif
            @if($d%8==0) </tr>
        <tr> @php $d=1; @endphp @endif
            @php $d++; @endphp
            @endforeach
            @for($j=$kqs[count($kqs)-1]->day + 1;$j<=8;$j++)
                <td>
                    <span></span>
                </td>
            @endfor
        </tr>
        </tbody>
    </table>
</div>