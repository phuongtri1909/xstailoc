<p class="text-center mb-1 d-amp-none" style="margin-bottom: 20px !important;">
    <button type="button" class="btn btn-danger trial-button" id="btnStartOrStop" style="width: 200px;"  onclick="startRandom()">Quay thử</button>
</p>
@php $d = 0; @endphp
<div data-id="kq" class="one-city" data-region="1" data-zoom="0" data-sub="0" data-sound="1">
    <div class="box" id="beginroll">
        <div id="load_kq_mn_0">
            <div data-id="kq" class="three-city" data-region="3">
                <table class="colthreecity colgiai extendable" id="table-xsmt">
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
                                <div data-nc="2" class="v-g8" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>G7</td>
                        @foreach($province_mt as $province)
                            <td>
                                <div data-nc="3" class="v-g7" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>G6</td>
                        @foreach($province_mt as $province)
                            <td>
                                <div data-nc="4" class="v-g6-0" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                                <div data-nc="4" class="v-g6-1" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                                <div data-nc="4" class="v-g6-2" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>G5</td>
                        @foreach($province_mt as $province)
                            <td>
                                <div data-nc="4" class="v-g5" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>G4</td>
                        @foreach($province_mt as $province)
                            <td>
                                <div data-nc="5" class="v-g4-0" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                                <div data-nc="5" class="v-g4-1" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                                <div data-nc="5" class="v-g4-2" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                                <div data-nc="5" class="v-g4-3" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                                <div data-nc="5" class="v-g4-4" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                                <div data-nc="5" class="v-g4-5" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                                <div data-nc="5" class="v-g4-6" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>G3</td>
                        @foreach($province_mt as $province)
                            <td>
                                <div data-nc="5" class="v-g3-0" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                                <div data-nc="5" class="v-g3-1" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>G2</td>
                        @foreach($province_mt as $province)
                            <td>
                                <div data-nc="5" class="v-g2" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>G1</td>
                        @foreach($province_mt as $province)
                            <td>
                                <div data-nc="5" class="v-g1" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                            </td>
                        @endforeach
                    </tr>
                    <tr class="gdb">
                        <td>ĐB</td>
                        @foreach($province_mt as $province)
                            <td>
                                <div data-nc="6" class="v-gdb" lotterycode="{{$province->short_name}}" id="mn_prize_{{$d++}}" ><i class="fas fa-spinner fa-pulse"></i></div>
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
                <style>
                    .control-panel{display: none!important;}
                </style>
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
                </div>
            </div>
            <div data-id="dd" class="col-firstlast colthreecity colgiai">
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
                            <td class="v-loto-dau-0" id="item_Head_{{$province->short_name}}_0"></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="clnote bold">1</td>
                        @foreach($province_mt as $province)
                            <td class="v-loto-dau-1" id="item_Head_{{$province->short_name}}_1">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="clnote bold">2</td>
                        @foreach($province_mt as $province)
                            <td class="v-loto-dau-2" id="item_Head_{{$province->short_name}}_2">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="clnote bold">3</td>
                        @foreach($province_mt as $province)
                            <td class="v-loto-dau-3" id="item_Head_{{$province->short_name}}_3">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="clnote bold">4</td>
                        @foreach($province_mt as $province)
                            <td class="v-loto-dau-4" id="item_Head_{{$province->short_name}}_4">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="clnote bold">5</td>
                        @foreach($province_mt as $province)
                            <td class="v-loto-dau-5" id="item_Head_{{$province->short_name}}_5">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="clnote bold">6</td>
                        @foreach($province_mt as $province)
                            <td class="v-loto-dau-6" id="item_Head_{{$province->short_name}}_6">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="clnote bold">7</td>
                        @foreach($province_mt as $province)
                            <td class="v-loto-dau-7" id="item_Head_{{$province->short_name}}_7">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="clnote bold">8</td>
                        @foreach($province_mt as $province)
                            <td class="v-loto-dau-8" id="item_Head_{{$province->short_name}}_8">
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="clnote bold">9</td>
                        @foreach($province_mt as $province)
                            <td class="v-loto-dau-9" id="item_Head_{{$province->short_name}}_9">
                            </td>
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
        </div>
    </div>
</div>

<script src="{{url('frontend/js/QuayThu.js')}}"></script>
<script>
    function startRandom() {
        if (!isrunning) {
            //$( "#rdGroup" ).prop( "checked", true );
            xsdpquaythu.RunRandomXSMN(3);
            setTimeout(function () {
                xsdpquaythu.RunRandomComplete();
            }, 38000);
        }
    };
</script>