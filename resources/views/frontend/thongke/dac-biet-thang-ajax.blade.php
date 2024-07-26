<h3 class="tit-mien bold">Bảng Đặc Biệt Xổ Số {{$province_name}} Tháng {{$month}} từ
    năm {{$year}}</h3>
<div class="box tong" style="overflow: auto;" id="monthly-result">
    <table>
        <tbody>
        <tr>
            <th class="td-split">
                <div><span class="bottom">Năm</span>
                    <span class="top">Ngày</span>
                    <div class="line"></div>
                </div>
            </th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
            <th>13</th>
            <th>14</th>
            <th>15</th>
            <th>16</th>
            <th>17</th>
            <th>18</th>
            <th>19</th>
            <th>20</th>
            <th>21</th>
            <th>22</th>
            <th>23</th>
            <th>24</th>
            <th>25</th>
            <th>26</th>
            <th>27</th>
            <th>28</th>
            <th>29</th>
            <th>30</th>
            <th>31</th>
        </tr>
        @foreach($year_list as $year)
            <tr>
                <td>{{$year}}</td>
                @for($d=1;$d<=31;$d++)
                    <?php  if ($d < 10) $day = '0' . $d; else $day = $d; ?>
                    @if(isset($arrkq[$year][$day]))
                        @php $kq = $arrkq[$year][$day]; @endphp
                            @if($kq->day==8)
                                <td class="light-yellow">
                                    <div class="s16 bold">{{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span class="clred">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                                </td>
                            @else
                                <td>
                                    <div class="s16 bold">{{substr($kq->gdb,0,strlen($kq->gdb)-2)}}<span class="clred">{{substr($kq->gdb,strlen($kq->gdb)-2)}}</span></div>
                                </td>
                            @endif
                        @else
                        <td></td>
                    @endif
                @endfor
            </tr>
        @endforeach
        </tbody>
    </table>
</div>