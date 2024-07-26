<h2 class="tit-mien bold">Bảng cầu trượt {{$province->name}} tính từ {{$count}} ngày
    trước {{getNgay($date)}}</h2>
<div id="cau-loto">
    <table class="bang-cau">
        <thead></thead>
        <tbody>
        @for($a=0;$a<10;$a++)
            <tr>
                <td class="dau bold"><span>Đầu {{$a}}</span></td>
                @for($b=0;$b<10;$b++)
                    @if($array_boso[$a.$b][1] > 0 && $array_boso[$a.$b][4] >= $count)
                        <td boso="{{$array_boso[$a.$b][0]}}" lanxh="{{$array_boso[$a.$b][1]}}"
                            @if($array_boso[$a.$b][5]==2) class="valid red number"
                            @elseif($array_boso[$a.$b][5]==1) class="valid green number" @else  class="valid number"
                            @endif onclick="setcolortoloto(this,{{$array_boso[$a.$b][2]}},{{$array_boso[$a.$b][3]}})"
                            title="Vị trí tạo cầu >>> vị trí 1: {{$array_boso[$a.$b][2]}}.vị trí 2: {{$array_boso[$a.$b][3]}}"
                            data-lifetime="{{$array_boso[$a.$b][4]}}">
                            <span class="num bold clnote">{{$array_boso[$a.$b][0]}}</span>
                            <span class="freq">{{$array_boso[$a.$b][1]}} lần</span>
                        </td>
                    @else
                        <td class="invalid"></td>
                    @endif
                @endfor
            </tr>
        @endfor
        </tbody>
    </table>
</div>
<h2 class="tit-mien bold" @if($type==1) id="ketqua" @endif>Kết quả cụ thể hàng ngày</h2>
<div class="box pad5">
    <div class="box-note pad5">
        Chi tiết cầu trượt <strong>{{$province->name}}</strong> biên độ: <span class="clnote bold">{{$count}}</span> ngày tính từ ngày <span class="clnote bold">{{getNgay($date)}}</span>.
        Cặp số: <span id="boso" class="bold clnote"></span>- xuất hiện: <span class="bold clnote"
                                                                              id="lanxh"></span>
        lần.
        Vị trí số ghép lên cầu &gt;&gt; Vị trí 1: <span id="vt1" class="bold clnote"></span> Vị trí 2: <span id="vt2" class="bold clnote"></span>
    </div>
</div>
@include('frontend.soicau_tn.block_xstn',compact('xss'))
<div id="domarow">
    @foreach($xss as $xs)
        @php $date_section = getDateLienNhau($xs->date);  @endphp
        <div class="domarow{{$date_section}}"></div>
    @endforeach
</div>
<script>
            @foreach($xss as $xs)
              <?php
                $xsStr = $xs->g8 . '-' . $xs->g7 . '-' . $xs->g6 . '-' . $xs->g5 . '-' . $xs->g4 . '-' . $xs->g3 . '-' . $xs->g2 . '-' . $xs->g1. '-' . $xs->gdb;
                $arr_kq = explode('-',$xsStr);
                $kqStr =  implode('',$arr_kq);
                $date_section = getDateLienNhau($xs->date);
                $arrstr = getStrtoArray($kqStr);
              ?>
              var A{!! $date_section !!}     = new Array({!! $arrstr !!});
            @endforeach
            var lifetime = new Array({!! $arr_js['lifetime'] !!});
    var valuelt = new Array({!! $arr_js['valuelt'] !!});
    var positionOne = new Array({!! $arr_js['positionOne'] !!});
    var positionTwo = new Array({!! $arr_js['positionTwo'] !!});
    var Aloto = new Array(1, 2, 0, 1, 2, 0, 0, 1, 2, 0, 0, 1, 2, 0, 0, 1, 2, 0, 0, 1, 2, 0, 0, 0, 1, 2, 0, 0, 0, 1, 2, 0, 0, 0, 1, 2, 0, 0, 0, 1, 2, 0, 0, 0, 1, 2, 0, 0, 0, 1, 2, 0, 0, 0, 1, 2, 0, 0, 0, 1, 2, 0, 0, 0, 1, 2, 0, 0, 0, 1, 2, 0, 0, 0, 1, 2, 0, 0, 0, 0, 1, 2);

    var pos1 = 0;
    var pos2 = 0;
    var flag = 0;
    var dates = [{!! $arr_js['arrdates'] !!}];
    var arrPos = null;
    if (typeof {{$arr_js['arrPos_first']}}     == 'object') {
        arrPos = [{!! $arr_js['arrPos'] !!}];
    }
    else {
        arrPos = [{!! $arr_js['arrPos'] !!}];
    }

    function setlotocolor(pos, lifeTime) {
        var lt1 = "10";
        var lt2 = "10";
        var cauDate = $("#cauDate").text();
        setFlag();
        setloto(pos);
        var lotteryCode = "{{strtoupper($province->short_name)}}";
        var date = new Date;
        var hour = date.getHours();
        $("div[class^='domarow']").html("");
        for (var dateindex = 0; dateindex < dates.length - 1; dateindex++) {
            var date = dates[dateindex];
            console.log({{$arr_js['arrPos_first']}})
            if ((typeof {{$arr_js['arrPos_first']}}     != 'object' && dateindex == 0)) {
                continue;
            }
            $("#" + lotteryCode + "_" + String(pos) + "_" + date).addClass("cau-selected");
            if (pos1 > 0 && dateindex + 1 < arrPos.length) lt1 = arrPos[dateindex + 1][pos1 - 1];
            else lt1 = "10";
            if (pos2 > 0 && dateindex + 1 < arrPos.length) lt2 = arrPos[dateindex + 1][pos2 - 1];
            else lt2 = "10";
            if (lt1 != "10" && lt2 != "10") {
                for (var index = 0; index < arrPos[dateindex + 1].length; index++) {
                    if (Aloto[index] == 1) {
                        if ((arrPos[dateindex][index] == lt1 && arrPos[dateindex][index + 1] == lt2) || (arrPos[dateindex][index] == lt2 && arrPos[dateindex][index + 1] == lt1)) {
                            $("#" + lotteryCode + "_" + String(index + 1) + "_" + date).addClass("cau-result");
                            $("#" + lotteryCode + "_" + String(index + 2) + "_" + date).addClass("cau-result");
                        }
                    }
                }
            }
            if (dateindex == dates.length - 2) {
                $("#" + lotteryCode + "_" + String(pos) + "_" + dates[dateindex + 1]).addClass("cau-selected");
            }
        }
        if (flag == 2 && typeof showInfo == "function") {
            showInfo();
            setDomarrow(lifeTime);
        }
    }

    function setcolortoloto(obj, mpos1, mpos2) {
        pos1 = 0;
        pos2 = 0;
        var lifeTime = $(obj).attr('data-lifetime');

        //show vị trí tạo cầu
        var boso = $(obj).attr('boso');
        var lanxh = $(obj).attr('lanxh');
        $("#boso").html(boso);
        $("#lanxh").html(lanxh);
        $("#vt1").html(mpos1);
        $("#vt2").html(mpos2);
        // End show vị trí tạo cầu

        showResultKQ();
        setlotocolor(mpos1, lifeTime);
        setlotocolor(mpos2, lifeTime);
        resetColorLoto();
        $(obj).addClass("active");
        showInfo();
        setTimeout(clickScroll('ketqua'), 200);
        setDomarrow(lifeTime);
        hideResultKQ(lifeTime);
        return;
    }

    function hideResultKQ(lifeTime) {
        for (var i = parseInt(lifeTime) + 2; i <= 16; i++) {
            $("#section_" + i).addClass("hide-result");
        }
    }
    function showResultKQ() {
        for (var i = 1; i <= 16; i++) {
            $("#section_" + i).removeClass("hide-result");
        }
    }

    function showInfo() {
        $('.cau-loto').removeClass('cau-loto');
        for (var dateindex = 0; dateindex < dates.length; dateindex++) {
            var date = dates[dateindex];
            var loto = '';
            var info = '<p><b>Thông tin cầu</b></p>';
            info += '<p>Loto cầu cho ngày hôm sau: ';
            $("#result" + date).find(".cau-selected").each(function (index, obj) {

                if (loto == '') {
                    loto = $(obj).text();
                } else {
                    info += '<b class="cau-homsau">' + loto + $(obj).text() + '</b>';
                    loto = '';
                }
            });
            info += '</p>';
            loto = '';
            info += '<p>Loto cầu hôm trước đã về: ';
            $("#result" + date).find(".cau-result").each(function (index, obj) {

                if (loto == '') {
                    loto = $(obj).text();
                } else {
                    if (index > 1)
                        info += ', ';
                    info += '<b class="cau-dave">' + loto + $(obj).text() + '</b>';
                    $(`.lotob_${dates[dateindex]}_${loto + $(obj).text()}`).addClass('cau-loto');
                    loto = '';
                }
            });
            info += '</p>';
            $("#info" + date).html(info);
        }
    }

    function clearInfo() {
        for (var dateindex = 0; dateindex < dates.length; dateindex++) {
            var date = dates[dateindex];
            $("#info" + date).html('');
        }
    }

    function setFlag() {
        flag = flag + 1;
        if (flag == 3)
            flag = 0;
        if (flag == 0) {
            flag = flag + 1;
            resetColor();
        }
        return;
    }

    function setloto(pos) {
        if (pos1 == 0)
            pos1 = pos;
        else if (pos2 == 0)
            pos2 = pos;
        else {
            pos1 = pos;
            pos2 = 0;
        }
        if (pos2 == pos1)
            pos1 = 0;
        return;
    }

    function resetColor() {
        $(".cau-selected").removeClass().addClass("cau-xs");
        $(".cau-result").removeClass().addClass("cau-xs");
        clearInfo();
    }

    function resetColorLoto() {
        $(".cauxs.active").removeClass("active");
    }

    function setDomarrow(lifetime) {
        $("div[class^='domarow']").html("");
        var lotteryCode = "{{strtoupper($province->short_name)}}";
        var count = 0;
        for (var dateindex = 0; dateindex < dates.length - 1; dateindex++) {
            var post1_id, post2_id, date1, date2;
            var cauDate = $("#cauDate").text();
            var date = dates[dateindex];
            if (cauDate == date) {
                count++;
            } else if (cauDate !== date && count > 0) {
                count++;
            }
            if (count > 0) {
                if (typeof lifetime !== "undefined" && parseInt(lifetime) + 2 < parseInt(count)) {
                    continue;
                }
            } else {
                if (typeof lifetime !== "undefined" && parseInt(lifetime) + 1 <= dateindex) {
                    continue;
                }
            }
            $("#result" + date).find(".cau-selected").each(function (index, obj) {
                if (index == 0) {
                    post1_id = obj.id.split('_');
                    if (post1_id.length > 2) {
                        var pos1 = post1_id[1];
                        date1 = "#" + lotteryCode + "_" + String(pos1) + "_" + date;
                    }
                }
                if (index == 1) {
                    post2_id = obj.id.split('_');
                    if (post2_id.length > 2) {
                        var pos2 = post2_id[1];
                        date2 = "#" + lotteryCode + "_" + String(pos2) + "_" + date;
                    }
                }
            });
            $(".domarow" + date).html('<connection from="' + date1 + '" to="' + date2 + '"></connection>')
        }
    }
</script>