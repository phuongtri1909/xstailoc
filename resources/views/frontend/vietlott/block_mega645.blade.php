@foreach($kqs as $kq_mega645)
    <div class="box mega645">
        <h2 class="tit-mien clearfix">
            <strong> <a class="title-a" href="{{route('mega645')}}" title="Xổ số Mega">Xổ số
                    Mega</a> {{getThu($kq_mega645->day)}} ngày {{getNgay($kq_mega645->date)}}</strong>
        </h2>
        <ul class="results">
            <li id="load_kq_mega_0">
                <div class="box">
                    <div class="clearfix">
                        <table class="data">
                            <tbody>
                            <tr>
                                @php $daySo = explode('-', $kq_mega645->day_so); $d=1; @endphp
                                @foreach($daySo as $value)
                                    <td><i>{{$value}}</i></td>
                                @endforeach
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <p class="txt-center">Giá trị Jackpot:
                                        <strong>{{number_format($kq_mega645->jackpot_gt)}} đồng</strong></p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="data2">
                        <tbody>
                        <tr>
                            <td>Giải thưởng</td>
                            <td>Trùng khớp</td>
                            <td>Số lượng giải</td>
                            <td>Giá trị giải (đồng)</td>
                        </tr>
                        <tr>
                            <td class="clnote">Jackpot</td>
                            <td><i></i> <i></i> <i></i> <i></i> <i></i> <i></i></td>
                            <td>{{$kq_mega645->jackpot_sl}}</td>
                            <td class="clnote">{{number_format($kq_mega645->jackpot_gt)}}</td>
                        </tr>
                        <tr>
                            <td class="clnote">Giải nhất</td>
                            <td><i></i> <i></i> <i></i> <i></i> <i></i></td>
                            <td>{{number_format($kq_mega645->g1_sl)}}</td>
                            <td>10.000.000</td>
                        </tr>
                        <tr>
                            <td class="clnote">Giải nhì</td>
                            <td><i></i> <i></i> <i></i> <i></i></td>
                            <td>{{number_format($kq_mega645->g2_sl)}}</td>
                            <td>300.000</td>
                        </tr>
                        <tr>
                            <td class="clnote">Giải ba</td>
                            <td><i></i> <i></i> <i></i></td>
                            <td>{{number_format($kq_mega645->g3_sl)}}</td>
                            <td>30.000</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </li>
        </ul>
    </div>
@endforeach