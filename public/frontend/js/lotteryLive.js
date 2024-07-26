var d = new Date();
var utc = d.getTime() + (d.getTimezoneOffset() * 60000);

function LiveMB(e, t, r) {
    l_root = t.split(";"), null == root && (root = l_root[0]), headingTag = r;
    //var i = root + "lottery_ws/LotteryWCFService.svc/GetLotteryMsgLiveByGroup/1,1,21,1,4," + e + ",1";
    //isNoteJs(t) && (i = root + "1"),
    i = '/xsmb-kq-new';
    console.log("live link: " + i), start_time = (new Date(utc + (3600000 * +7))).getTime();
    var n = new Date(utc + (3600000 * +7)), a = n.getHours(), o = n.getMinutes();
    if (18 == a && o >= 10 && 40 >= o) {
        if (is_first_nodejs || "undefined" != typeof connected && "undefined" != typeof e_live_err_flag && connected && !e_live_err_flag) return is_first_nodejs = !1, console.log("mqLive is running..."), void (1 == lottery_json.length && updateMBResult(lottery_json));
        try {
            $.ajax({
                type: "GET",
                url: i,
                data: "",
                dataType: "text",
                //timeout: 5e3,
                beforeSend: LiveMBBegin,
                success: LiveMBSuccess,
                error: LiveMBError
            })
        } catch (l) {
            console.log(l)
        }
    }
}
function LiveMBBegin() {
}
function LiveMBError() {
    sucLiveUrlIndex < l_root.length - 1 ? sucLiveUrlIndex++ : sucLiveUrlIndex = 0, root = l_root[sucLiveUrlIndex]
}
function LiveMBSuccess(e) {
    console.log('LiveMBSuccess:');
    console.log(e);
    try {
        var d = new Date();
        var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
        //request_time = (new Date(utc + (3600000 * +7))).getTime() - start_time, console.log(request_time);
        var t = JSON.parse(e), r = new Date(utc + (3600000 * +7)), i = r.getHours(), n = r.getMinutes(), a = r.getDate(), o = r.getMonth() + 1, l = r.getFullYear(), s = "kqngay_" + (10 > a ? "0" + a : "" + a) + (10 > o ? "0" + o : "" + o) + l, d = document.getElementById(s);
        console.log('d: '+d);
        console.log('isEmptyObject: '+ $.isEmptyObject(t));
        d && 0 == $.isEmptyObject(t) ? 18 == i && n >= 10 && 40 >= n && (updateMBResult(t), d.style.display = "block", request_time > warringTime && (console.log("data from " + root + ": Warring speed"), sucLiveUrlIndex < l_root.length - 1 ? sucLiveUrlIndex++ : sucLiveUrlIndex = 0, root = l_root[sucLiveUrlIndex])) : (sucLiveUrlIndex < l_root.length - 1 ? sucLiveUrlIndex++ : sucLiveUrlIndex = 0, root = l_root[sucLiveUrlIndex])
        //d && 0 == $.isEmptyObject(t) ? 0 < i && n >= 0 && 60 >= n && (updateMBResult(t), d.style.display = "block", request_time > warringTime && (console.log("data from " + root + ": Warring speed"), sucLiveUrlIndex < l_root.length - 1 ? sucLiveUrlIndex++ : sucLiveUrlIndex = 0, root = l_root[sucLiveUrlIndex])) : (sucLiveUrlIndex < l_root.length - 1 ? sucLiveUrlIndex++ : sucLiveUrlIndex = 0, root = l_root[sucLiveUrlIndex])
    } catch (c) {
        console.log(c)
    }
    xsdp.init();
    xsdp.addTableCtrlPanel(function () {
        var t = document.querySelectorAll("table.extendable");
        return [].forEach.call(t, (function (t) {
            t.showedDigits = 0
        })), t
    }(), xsdp._getNumberInTable);
}
function startRandomValue() {
    for (var e, t, r = $(".output").length, i = 0; r > i; i++) e = $($(".output")[i]), t = e.attr("id"), generateNumber(t)
}
function generateNumber(e) {
    var t = 0, r = 9, i = $("#" + e);
    animationTimer = setInterval(function () {
        i.text("" + Math.floor(Math.random() * (r - t + 1) + t))
    }, 150)
}
function LiveMT(e, t, r, i) {
    l_root = r.split(";"), null == root && (root = l_root[0]), group = e, headingTag = i;
    //var n = root + "lottery_ws/LotteryWCFService.svc/GetLotteryMsgLiveByGroup/" + e + ",1,21,1,4," + t + ",1";
    //isNoteJs(r) && (n = root + "3");
    n = '/xsmt-kq-new';
    var a = new Date(utc + (3600000 * +7)), o = a.getHours(), l = a.getMinutes();
    if (console.log("live link: " + n), start_time = (new Date(utc + (3600000 * +7))).getTime(), 17 == o && l >= 10 && 40 >= l && 3 == e) {
        if (is_first_nodejs || "undefined" != typeof connected && "undefined" != typeof e_live_err_flag && connected && !e_live_err_flag) return is_first_nodejs = !1, console.log("elive is running..."), void (lottery_json.length > 1 && updateTNResult(lottery_json));
        try {
            $.ajax({
                type: "GET",
                url: n,
                data: "",
                dataType: "text",
                //timeout: 5e3,
                beforeSend: LiveMTBegin,
                success: LiveMTSuccess,
                error: LiveMTError
            })
        } catch (s) {
            console.log(s)
        }
    }
}
function LiveMTBegin() {
}
function LiveMTError() {
    sucLiveUrlIndex < l_root.length - 1 ? sucLiveUrlIndex++ : sucLiveUrlIndex = 0, root = l_root[sucLiveUrlIndex]
}
function LiveMTSuccess(e) {
    console.log('LiveMTSuccess');
    console.log(e);
    try {
        var d = new Date();
        var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
        var date = new Date(utc + (3600000 * +7)), hour = date.getHours(), minute = date.getMinutes();
        console.log(hour+':'+minute);
        if (17 == hour && minute >= 10 && 40 >= minute) {
            //    request_time = (new Date(utc + (3600000 * +7))).getTime() - start_time, console.log(request_time);
            var t = JSON.parse(e), r = new Date(utc + (3600000 * +7)), i = (r.getHours(), r.getMinutes(), r.getDate()), n = r.getMonth() + 1, a = r.getFullYear(), o = "mt_kqngay_" + (10 > i ? "0" + i : "" + i) + (10 > n ? "0" + n : "" + n) + a, l = document.getElementById(o);
            console.log('l: '+l);
            console.log('isEmptyObject: '+ $.isEmptyObject(t));
            l && 0 == $.isEmptyObject(t) ? (updateTNResult(t), l.style.display = "block", request_time > warringTime && (console.log("data from " + root + ": Warring speed"), sucLiveUrlIndex < l_root.length - 1 ? sucLiveUrlIndex++ : sucLiveUrlIndex = 0, root = l_root[sucLiveUrlIndex])) : (sucLiveUrlIndex < l_root.length - 1 ? sucLiveUrlIndex++ : sucLiveUrlIndex = 0, root = l_root[sucLiveUrlIndex])
        }
    } catch (s) {
        console.log(s)
    }
    xsdp.init();
    xsdp.addTableCtrlPanel(function () {
        var t = document.querySelectorAll("table.extendable");
        return [].forEach.call(t, (function (t) {
            t.showedDigits = 0
        })), t
    }(), xsdp._getNumberInTable);
}
function LiveMN(e, t, r, i) {
    l_root = r.split(";"), null == root && (root = l_root[0]), group = e, headingTag = i;
    //var n = root + "lottery_ws/LotteryWCFService.svc/GetLotteryMsgLiveByGroup/" + e + ",1,21,1,4," + t + ",1";
    //isNoteJs(r) && (n = root + "2");
    n = '/xsmn-kq-new';
    var a = new Date(utc + (3600000 * +7)), o = a.getHours(), l = a.getMinutes();
    if (console.log("live link: " + n), start_time = (new Date(utc + (3600000 * +7))).getTime(), 16 == o && l >= 10 && 40 >= l && 2 == e) {
        if (is_first_nodejs || "undefined" != typeof connected && "undefined" != typeof e_live_err_flag && connected && !e_live_err_flag) return is_first_nodejs = !1, console.log("elive is running..."), void (lottery_json.length > 1 && updateTNResult(lottery_json));
        try {
            $.ajax({
                type: "GET",
                url: n,
                data: "",
                dataType: "text",
                //timeout: 5e3,
                beforeSend: LiveMNBegin,
                success: LiveMNSuccess,
                error: LiveMNError
            })
        } catch (s) {
            console.log(s)
        }
    }
}
function LiveMNBegin() {
}
function LiveMNError() {
    sucLiveUrlIndex < l_root.length - 1 ? sucLiveUrlIndex++ : sucLiveUrlIndex = 0, root = l_root[sucLiveUrlIndex]
}
function LiveMNSuccess(e) {
    console.log('LiveMNSuccess');
    console.log(e);
    try {
        var d = new Date();
        var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
        var date = new Date(utc + (3600000 * +7)), hour = date.getHours(), minute = date.getMinutes();
        console.log(hour+':'+minute);
        if (16 == hour && minute >= 10 && 40 >= minute) {
            //request_time = (new Date(utc + (3600000 * +7))).getTime() - start_time, console.log(request_time);
            var t = JSON.parse(e), r = new Date(utc + (3600000 * +7)), i = (r.getHours(), r.getMinutes(), r.getDate()), n = r.getMonth() + 1, a = r.getFullYear(), o = "mn_kqngay_" + (10 > i ? "0" + i : "" + i) + (10 > n ? "0" + n : "" + n) + a, l = document.getElementById(o);
            console.log('l: '+l);
            console.log('isEmptyObject: '+ $.isEmptyObject(t));
            l && 0 == $.isEmptyObject(t) ? (updateTNResult(t), l.style.display = "block", request_time > warringTime && (console.log("data from " + root + ": Warring speed"), sucLiveUrlIndex < l_root.length - 1 ? sucLiveUrlIndex++ : sucLiveUrlIndex = 0, root = l_root[sucLiveUrlIndex])) : (sucLiveUrlIndex < l_root.length - 1 ? sucLiveUrlIndex++ : sucLiveUrlIndex = 0, root = l_root[sucLiveUrlIndex])
        }
    } catch (s) {
        console.log(s)
    }

    xsdp.init();
    xsdp.addTableCtrlPanel(function () {
        var t = document.querySelectorAll("table.extendable");
        return [].forEach.call(t, (function (t) {
            t.showedDigits = 0
        })), t
    }(), xsdp._getNumberInTable);
}
function getTemplateTN(e) {
    console.log('getTemplateTN');
    try {
        var t = "", r = "", i = "", n = "", a = "", o = "", l = "", s = "", d = "", cl = "", c = "", tg = "", g = "", m = 0, u = 0, shownumberID = '', _ = 0, h = e[0], p = h.CrDateTime.split(",");
        2 == group ? (r = "XSMN", i = "Miền Nam", o = "mn", l = "mien-nam", s = "/thong-ke-xsmn", shownumberID = 'showNumberMN') : 3 == group && (r = "XSMT", i = "Miền Trung", o = "mt", l = "mien-trung", s = "/thong-ke-xsmt", shownumberID = 'showNumberMT');
        for (var v = 0; v < e.length; v++) switch (n = e[v].Status) {
            case "0":
                m++, isLive = !0;
                break;
            case "1":
                u++;
                break;
            default:
                _++
        }
        var div_class ='',table_class ='';
        if(e.length==3){
            div_class = 'three-city';
            table_class = 'colthreecity';
        }else if(e.length==4){
            div_class = 'four-city';
            table_class = 'colfourcity';
        }else if(e.length==2){
            div_class = 'two-city';
            table_class = 'coltwocity';
        }

        headingTag = 'span class="p-title color-primary pt-3" id="' + o + 'LiveTitle"';
        m > 0 ? a = "<" + headingTag + ">" + r + " Trực Tiếp - Trực Tiếp KQXS " + i + ' <i class="fa fa-refresh fa-spin"></i></' + headingTag + ">" : u == e.length ? a = "<" + headingTag + ">KQ" + r + " " + h.CrDateTime + " " + i + "</" + headingTag + ">" : _ == e.length && (a = "<" + headingTag + ">" + r + " bắt đầu mở thưởng lúc " + h.OpenPrizeTime + "</" + headingTag + ">"),
            //t += '<div class="block-main-heading" id="' + o + 'LiveTitle">' + a + '</div><div class="list-link"><h2 class="class-title-list-link"><a href="/xs' + o + "-xo-so-" + l + '" title="Kết quả xổ số ' + i + '" class="u-line">' + r + '</a><span>»</span><a href="' + getLotteryByDayOfWeekLink(o, p[0]) + '" title="Xổ số ' + i + " " + p[0] + '" class="u-line">' + r + " " + p[0] + '</a><span>»</span><a href="' + getLotteryByDateLink(o, h.CrDateTime) + '" title="Xổ số ' + i + " ngày " + p[1] + '" class="u-line">' + r + " " + p[1] + '</a></h2></div><div class="block-main-content"><table id="liveTN" class="table table-bordered table-striped table-xsmn livetn' + e.length + '"><thead><tr><th class="text-center">Giải</th>';
            //t += '<div class="kqsx-today text-center v-card mb-3"> <H1 class="lead df-title pt-3 d-block" id="' + o + 'LiveTitle">' + r + ' - Kết Quả Xổ Số ' + i + ' - ' + r + ' Hôm Nay</h1> <h2 class="site-link"><a href="/xs' + o + '-xo-so-' + l + '" title="Kết quả xổ số ' + i + '">' + r + '</a> <a href="' + getLotteryByDayOfWeekLink(o, p[0]) + '" title="' + i + ' ' + p[0] + '">' + r + ' ' + p[0] + '</a> <a href="' + getLotteryByDateLink(o, h.CrDateTime) + '" title="' + i + ' ngày ' + p[1] + '">' + r + " " + p[1] + '</a> </h2> <table class="kqmb kqsx-mt w-100" data-zone="kqmt"> <tbody> <tr class="bg-pr"> <th class="first"></th>';
            t += '<div class="tit-mien clearfix"> <h2>' + r + ' - Kết Quả Xổ Số ' + i + ' - ' + r + ' Hôm Nay</h2> <div><a class="sub-title" href="/xs' + o + '-xo-so-' + l + '" title="Kết quả xổ số ' + i + '">' + r + '</a> » <a class="sub-title" href="' + getLotteryByDayOfWeekLink(o, p[0]) + '" title="' + i + ' ' + p[0] + '">' + r + ' ' + p[0] +'</a> » <a class="sub-title" href="' + getLotteryByDateLink(o, h.CrDateTime) + '" title="' + i + ' ngày ' + p[1] + '">' + r + p[1] + '</a> </div> </div> <div id="load_kq_tn_live"> <div data-id="kq" class="'+ div_class +'" data-region="3"> <table class="'+ table_class +' colgiai extendable"> <tbody> <tr class="gr-yellow"> <th class="first"></th>';
        //t += '<div class="page-c px-0 py-0"> <div class="py-2 px-2">' + a + '</span> <span class="p-title color-primary pt-3"><a href="' + getLotteryByDayOfWeekLink(o, p[0]) + '" title="Xổ số ' + i + " " + p[0] + '">' + r + " " + p[0] + '</a> / <a href="' + getLotteryByDateLink(o, h.CrDateTime) + '" title="Xổ số ' + i + " ngày " + p[1] + '">' + r + " " + p[1] + '</a></span></div><table class="extendable colthreecity responsive table kqsx mb-4"><tbody><tr class="gr-primary"><th class="first"></th>';

        for (var b = 0; b < e.length; b++) {
            var f = e[b];
            //t += '<th class="text-center"><a href="' + getLotteryLink(f.LotteryId, f.LotteryCode, f.LotteryName) + '" title="' + f.LotteryName + '" title="' + f.LotteryName + '">' + f.LotteryName + "</a></th>"
            //t += '<th><a href="' + getLotteryLink(f.LotteryId, f.LotteryCode, f.LotteryName) + '" title="' + f.LotteryName + '" class="colorLinkBlue bold">' + f.LotteryName + '</a></th>';
            t += '<th data-pid="' + f.LotteryId + '"> <a href="' + getLotteryLink(f.LotteryId, f.LotteryCode, f.LotteryName) + '" title="' + f.LotteryName + '">' + f.LotteryName + '</a> </th>';
        }
        t += "</tr>";
        for (var L = 0; L < h.LotPrizes.length; L++) {
            var T = h.LotPrizes[L];
            switch (L) {
                case 8:
                    cl = 'class="gdb"';
                    d = 'data-nc="6" class="v-gdb"';
                    break;
                case 1:
                    cl = '';
                    d = 'data-nc="5" class="v-g1"';
                    break;
                case 2:
                    cl = '';
                    d = 'data-nc="5" class="v-g2"';
                    break;
                case 3:
                    cl = '';
                    d = 'data-nc="5" class="v-g3-0"';
                    break;
                case 4:
                    cl = '';
                    d = 'data-nc="5" class="v-g4-0"';
                    break;
                case 5:
                    cl = '';
                    d = 'data-nc="4" class="v-g5"';
                    break;
                case 6:
                    cl = '';
                    d = 'data-nc="4" class="v-g6-0"';
                    break;
                case 7:
                    cl = '';
                    d = 'data-nc="3" class="v-g7"';
                    break;
                case 0:
                    cl = 'g8';
                    d = 'data-nc="2" class="v-g8"';
                    break;
                default:
                    cl = '';
                    d = 'data-nc="2" class="v-g8"';
            }
            t += "<tr " + cl + "><td>" + (L == h.LotPrizes.length - 1 ? "ĐB" : "G")+L+"</td>";
            for (var x = 0; x < e.length; x++) {
                var y, z = "", I = e[x];
                c = T.Prize.toLowerCase(), z = c.indexOf("db") >= 0 || c.indexOf("đb") >= 0 || c.indexOf("đặc biệt") >= 0 ? "Db" : "" + (8 - L), g = T.Range, y = g.indexOf("-") > 0 ? g.split("-") : g.split(" "),
                    t += '<td>';
                for (var k = 0; k < y.length; k++)
                    t += '<div ' + d + ' id="' + I.LotteryCode + "_prize_" + z + "_item_" + k + '" data-id=""><i class="fas fa-spinner fa-spin"></i></div>';
                t += "</td>"
            }
            t += "</tr>"
        }
        //t += '</tbody> </table> <div class="control-panel" id="' + shownumberID + '"> <form class="digits-form mt-3 mb-3 text-left" data-control="kqmt"> <label class="radio" data-value="0"> <input type="radio" name="showed-digits" value="0" checked="checked"> <b></b> <span>Tất cả</span> </label> <label class="radio" data-value="2"> <input type="radio" name="showed-digits" value="2"> <b></b> <span>2 số cuối</span> </label> <label class="radio" data-value="3"> <input type="radio" name="showed-digits" value="3"> <b></b> <span>3 số cuối</span> </label> </form> </div> </div>';
        t += '</tbody> </table> <div class="control-panel"> <form class="digits-form"><label class="radio" data-value="0"><input type="radio" name="showed-digits" value="0"> <b></b><span></span></label><label class="radio" data-value="2"><input type="radio" name="showed-digits" value="2"> <b></b><span></span></label><label class="radio" data-value="3"><input type="radio" name="showed-digits" value="3"> <b></b><span></span></label></form> <div class="buttons-wrapper"><span class="zoom-in-button"><i class="icon zoom-in-icon"></i><span></span></span></div> </div> </div>';
        //t += '</tbody></table></div><div class="list-link bg-gray"><ul><li><a href="/lo-to-' + l + '" title="Lô tô ' + i + '" class="u-line">Lô tô ' + i + '</a> <span style="color: #120CF4!important;"></span></li><li><a href="' + getLotteryByDayOfWeekLink(o, p[0]) + '" title="Lô tô ' + i + " " + p[0] + '" class="u-line">Lô tô ' + i + " " + p[0] + '</a></li></ul><span class="down-icon"><i class="fa fa-caret-down" aria-hidden="true"></i></span></div><div class="block-main-content view-loto">';

        //for (var N = 0; N < e.length; N++) {
        //    var P = e[N], M = P.Lotos;
        //    t += '<p id="' + o + "_loto_" + P.LotteryCode + '_title"> Loto ' + P.LotteryName + " " + P.CrDateTime + '</p><table class="table table-bordered table-loto" id="livebangkqloto_' + P.LotteryCode + '"><tr><th class="col-md-2" style="width: 10%;">Đầu</th><th class="col-md-4">Lô Tô</th></tr>';
        //    for (var S = 0; S < M.length; S++) t += '<tr><td class="text-center">' + S + '</td><td id="' + o + "loto_" + P.LotteryCode + "_" + S + '">-</td></tr>';
        //    t += "</table>"
        //}


        //t += '<p> Loto ' + i + " " + e[0].CrDateTime + '</p><table class="table table-bordered table-loto">';
        t += '<div data-id="dd" class="col-firstlast '+table_class+' colgiai"> <table class="firstlast-mn bold"> <tbody> <tr class="header"> <th class="first">Đầu</th>';
        //t += '<tr><th class="col-md-2" style="width: 10%;">Đầu</th>';
        for (var N = 0; N < e.length; N++) {
            t += '<th id="livebangkqloto_' + e[N].LotteryCode + '">' + e[N].LotteryName + '</th>';
        }
        t += '</tr>';
        for (var S = 0; S <= 9; S++) {
            t += '<tr><td class="clnote bold">' + S + '</td>';
            for (var N = 0; N < e.length; N++) {
                t += '<td  class="v-loto-dau-'+S+'" id="' + o + "loto_" + e[N].LotteryCode + "_" + S + '">-</td>';
            }
            t += '</tr>';
        }
        t += "</tbody></table></div></div>"


        //console.log("tạo lại giao diện"), t += '</div><div class="link-statistic"> <ul><li>Xem thống kê <a href="/soi-cau-' + o + '" title="Cầu ' + i + '">Cầu ' + i + '</a></li><li>Xem thống kê <a href="/lo-gan-' + l + '" title="Lô gan ' + i + '">Lô gan ' + i + '</a></li><li>Tham khảo <a href="' + s + '" title="Thống kê ' + r + '">Thống kê ' + r + "</a></li><li>Xem nhanh kết quả xổ sổ các tỉnh " + i + " " + p[0] + ' hôm nay:</li><table class="table table-bordered table-loto" style="width:95%;"><tbody><tr>';
        //for (var C = 0; C < e.length; C++) {
        //    var R = "";
        //    R = 3 == e.length ? "width:33%;" : "width:25%;", t += ' <td class="text-center" style="' + R + '" ><a style="text-decoration: none !important;font-size:16px;" href="' + getLotteryLink(e[C].LotteryId, e[C].LotteryCode, e[C].LotteryName) + '" title="KQXS ' + e[C].LotteryName + '">XS' + e[C].LotteryCode + "</a></td>"
        //}
        //t += "</tr></tbody></table>", t += '</ul></div><p class="text-right margin-10 hidden-xs hidden-sm"><a href="/in-ve-do" class="btn btn-danger" title="In vé dò" role="button">In Vé Dò</a></p>';
        var B = new Date(utc + (3600000 * +7)), w = B.getDate(), D = B.getMonth() + 1, $ = B.getFullYear(), O = (2 == group ? "mn" : "mt") + "_kqngay_" + (10 > w ? "0" + w : "" + w) + (10 > D ? "0" + D : "" + D) + $, X = document.getElementById(O);
        X && (X.innerHTML = t, X.style.display = "block")
    } catch (q) {
        console.log(q.message)
    }
}
function updateTNResult(e) {
    try {
        console.log('updateTNResult Json:'), console.log(e), e = orderTN(e, group), console.log('orderTN Json:'), console.log(e), newResult = !1, resultupdating = !0;
        var t = e[0];
        var r, i = 0, n = 0, a = 0, o = "", l = "", s = "", d = "", c = "", g = "", m = "", u = "", _ = "", h = t.CrDateTime.toString().split(",");
        2 == group ? (r = $("#mnLiveTitle"), c = "mien-nam", l = "XSMN", s = "Miền Nam", d = "mn") : 3 == group && (r = $("#mtLiveTitle"), c = "mien-trung", l = "XSMT", s = "Miền Trung", d = "mt");
        for (var p = 0; p < e.length; p++) switch (o = e[p].Status) {
            case "0":
                i++, isLive = !0;
                break;
            case "1":
                n++;
                break;
            default:
                a++
        }
        //headingTag = 'span class="p-title color-primary pt-3" id="' + o + 'LiveTitle"';
        //i > 0 ? _ = "<" + headingTag + ">" + l + " Trực Tiếp - Trực Tiếp KQXS " + s + ' <i class="fa fa-refresh fa-spin"></i></' + headingTag + ">" : n == e.length ? _ = "<" + headingTag + ">KQ" + l + " " + t.CrDateTime + " " + s + "</" + headingTag + ">" : a == e.length && (_ = "<" + headingTag + ">" + l + " bắt đầu mở thưởng lúc " + t.OpenPrizeTime + "</" + headingTag + ">"), i > 0 ? r.html().indexOf('<i class="fa fa-refresh fa-spin"></i>') < 0 && r.html(_) : r.html(_);
        //$("#tnListLink").length > 0 && (u = '<a href="/xs' + d + "-xo-so-" + c + ' title="Kết quả xổ số ' + s + '" class="u-line">' + l + '</a><span>»</span><a href="' + getLotteryByDayOfWeekLink(d, h[0]) + '" title="Xổ số ' + s + " " + h[0] + '" class="u-line">' + l + " " + h[0] + '</a><span>»</span><a href="' + getLotteryByDateLink(d, t.CrDateTime) + '" title="Xổ số ' + s + " ngày " + h[1] + '" class="u-line">' + l + " " + h[1] + "</a>", $("#tnListLink").html(u));
        $("#tnListLink").length > 0 && (u = '<a href="/xs' + d + "-xo-so-" + c + '" title="Kết quả xổ số ' + s + '">' + l + '</a> <a href="' + getLotteryByDayOfWeekLink(d, h[0]) + '" title="Xổ số ' + s + " " + h[0] + '">' + l + " " + h[0] + '</a> <a href="' + getLotteryByDateLink(d, t.CrDateTime) + '" title="Xổ số ' + s + " ngày " + h[1] + '">' + l + " " + h[1] + '</a>', $("#tnListLink").html(u));

        for (var v = 0; v < e.length; v++) {
            var b = e[v];
            0 == $("#livebangkqloto_" + b.LotteryCode).length && getTemplateTN(e), TNcurrentPrize[v] = "#" + b.LotteryCode + "_prize_8_item_0", TNcurrentPrizeIndex[v] = 2;
            for (var f = 0; f < b.LotPrizes.length; f++) {
                var L, T = b.LotPrizes[f];
                g = T.Prize.toLowerCase(), m = T.Range;
                var x = "";
                x = g.indexOf("db") >= 0 || g.indexOf("đb") >= 0 || g.indexOf("đặc biệt") >= 0 ? "Db" : "" + (8 - f), L = m.indexOf("-") >= 0 ? m.split("-") : m.split(" ");
                for (var y = 0; y < L.length; y++) {
                    var z = "#" + b.LotteryCode + "_prize_" + x + "_item_" + y;
                    if ($(z).html() != L[y].trim() || "..." == L[y].trim()) if (L[y].indexOf("...") < 0) {
                        var I = $(z).html().indexOf("ketquamoi");
                        if (I >= 0 || "1" == o ? ($(z).html(L[y].trim()), $(z).attr('data-id', L[y].trim())) : ($(z).html("<span class='ketquamoi'>" + L[y].trim() + "</span>").hide().fadeIn(500), $(z).attr('data-id', L[y].trim()), newResult = !0), y == L.length - 1) {
                            var k = 8 - f - 1;
                            TNcurrentPrize[v] = "#" + b.LotteryCode + "_prize_" + k + "_item_0", 0 == k && (TNcurrentPrize[v] = "#" + b.LotteryCode + "_prize_Db_item_0"), 0 == f ? TNcurrentPrizeIndex[v] = 3 : 1 == f || 2 == f ? TNcurrentPrizeIndex[v] = 4 : f >= 3 && 6 >= f ? TNcurrentPrizeIndex[v] = 5 : f >= 7 && (TNcurrentPrizeIndex[v] = 6, b.OpenPrizeTime.indexOf("17h15") >= 0 && (TNcurrentPrizeIndex[v] = 5))
                        } else {
                            var k = y + 1;
                            TNcurrentPrize[v] = "#" + b.LotteryCode + "_prize_" + x + "_item_" + k, 8 == k && (TNcurrentPrize[v] = "#" + b.LotteryCode + "_prize_Db_item_0"), "Db" == x ? (TNcurrentPrizeIndex[v] = 6, b.OpenPrizeTime.indexOf("17h15") >= 0 && (TNcurrentPrizeIndex[v] = 5)) : 0 == f ? TNcurrentPrizeIndex[v] = 2 : 1 == f ? TNcurrentPrizeIndex[v] = 3 : 2 == f || 3 == f ? TNcurrentPrizeIndex[v] = 4 : f >= 4 && 7 >= f && (TNcurrentPrizeIndex[v] = 5)
                        }
                    } else $(z).html().indexOf("output") < 0 && $(z).html('<i class="fas fa-spinner fa-spin"></i>'); else if (L[y].indexOf("...") < 0) if (y == L.length - 1) {
                        var k = 8 - f - 1;
                        TNcurrentPrize[v] = "#" + b.LotteryCode + "_prize_" + k + "_item_0", 0 == k && (TNcurrentPrize[v] = "#" + b.LotteryCode + "_prize_Db_item_0"), 0 == f ? TNcurrentPrizeIndex[v] = 3 : 1 == f || 2 == f ? TNcurrentPrizeIndex[v] = 4 : f >= 3 && 6 >= f ? TNcurrentPrizeIndex[v] = 5 : f >= 7 && (TNcurrentPrizeIndex[v] = 6)
                    } else {
                        var k = y + 1;
                        TNcurrentPrize[v] = "#" + b.LotteryCode + "_prize_" + x + "_item_" + k, 8 == k && (TNcurrentPrize[v] = "#" + b.LotteryCode + "_prize_Db_item_0"), "Db" == x ? TNcurrentPrizeIndex[v] = 6 : 0 == f ? TNcurrentPrizeIndex[v] = 2 : 1 == f ? TNcurrentPrizeIndex[v] = 3 : 2 == f || 3 == f ? TNcurrentPrizeIndex[v] = 4 : f >= 4 && 7 >= f && (TNcurrentPrizeIndex[v] = 5)
                    }
                }
            }
        }
        //var shownumber = '<form class="digits-form mt-3 mb-3 text-left" data-control="kqmb"> <label class="radio" data-value="0"> <input type="radio" name="showed-digits" value="0" checked="checked"> <b></b> <span>Tất cả</span> </label> <label class="radio" data-value="2"> <input type="radio" name="showed-digits" value="2"> <b></b> <span>2 số cuối</span> </label> <label class="radio" data-value="3"> <input type="radio" name="showed-digits" value="3"> <b></b> <span>3 số cuối</span> </label> </form>';
        //if (3 == group) $("#showNumberMT").html(shownumber)
        //if (2 == group) $("#showNumberMN").html(shownumber)
        for (var N = 0; N < e.length; N++) for (var P = e[N], M = P.Lotos, S = 0; S < M.length; S++) {
            var C = "", R = M[S].Tail, B = "-" == R ? "" : M[S].Head, w = $("#" + d + "loto_" + e[N].LotteryCode + "_" + S);
            //if (R.indexOf(",") > 0) {
            //    for (var D = R.split(","), O = 0; O < D.length; O++) C += B + D[O] + (O == D.length - 1 ? "" : ", ");
            //    w.text(C)
            //} else w.text(B + R)
            w.html(R)
        }
        n == e.length && (interval && window.clearInterval(interval), intervalVariable && window.clearInterval(intervalVariable)), resultupdating = !1
    } catch (X) {
        console.log(X)
    }
}
function updateMBResult(e) {
    console.log('updateMBResult Json:'), console.log(e)
    try {
        resultupdating = !0, newResult = !1, startDB = !1;
        var t = e[0], r = t.CrDateTime.toString().split(","), i = t.Status, n = "", a = "", o = "";
        switch (i) {
            case "1":
                n = "XSMB mở thưởng tại " + t.LotteryName.replace("Miền Bắc (", "").replace(")", "") + " " + t.CrDateTime;
                break;
            case "2":
                n = "XSMB bắt đầu mở thưởng lúc " + t.OpenPrizeTime;
                break;
            default:
                n = 'XSMB Trực Tiếp - Trực Tiếp KQ Xổ Số Miền Bắc <i class="fa fa-refresh fa-spin"></i>', isLive = !0, currentPrize = 0, currentRangeIndex = 0
        }
        if (0 == $("#livebangkqlotomb").length && getTemplateMB(e), $("#MbListLink").length > 0) {
            //var l = '<a href="/xsmb-xo-so-mien-bac" title="XSMB" class="u-line">XSMB</a><span>»</span><a href="/xsmb-' + locdau(r[0]) + '" title="XSMB ' + r[0] + '" class="u-line">XSMB ' + r[0] + '</a><span>»</span><a href="/xsmb-' + r[1].replace(/\//g, "-").replace(" ", "") + '" title="XSMB ' + r[1] + '" class="u-line">XSMB ' + r[1] + "</a>";
            //var l = '<a href="/xsmb-xo-so-mien-bac" title="XSMB">XSMB</a> <a href="/xsmb-' + locdau(r[0]) + '" title="XSMB ' + r[0] + '">XSMB ' + r[0] + '</a> <a href="/xsmb-' + r[1].replace(/\//g, "-").replace(" ", "") + '" title="XSMB ' + r[1] + '">XSMB ' + r[1] + '</a>';
            var l = '<a class="sub-title" href="/xsmb-xo-so-mien-bac" title="XSMB">XSMB</a> » <a class="sub-title" href="/xsmb-' + locdau(r[0]) + '" title="XSMB ' + r[0] + '">XSMB ' + r[0] + '</a> » <a class="sub-title" href="/xsmb-' + r[1].replace(/\//g, "-").replace(" ", "") + '" title="XSMB ' + r[1] + '">XSMB ' + r[1] + '</a>';
            $("#MbListLink").html(l)
        }
        //"1" == i || "2" == i ? $("#MbLiveTitle").html("<" + headingTag + ">" + n + "</" + headingTag + ">") : $("#MbLiveTitle").html().indexOf('<i class="fa fa-refresh fa-spin"></i>') < 0 && $("#MbLiveTitle").html("<" + headingTag + ">" + n + "</" + headingTag + ">");
        for (var s = 0; s < t.LotPrizes.length; s++) {
            var d = t.LotPrizes[s];
            o = d.Prize.toLowerCase(), a = d.Range;
            var c = a.split(" - "), g = "";
            g = o.indexOf("db") >= 0 || o.indexOf("đb") >= 0 || o.indexOf("đặc biệt") >= 0 ? "DB" : s;
            for (var m = 0; m < c.length; m++) {
                var u = c[m].trim();
                if (u.indexOf("...") < 0 && (currentPrize = s, currentRangeIndex = m), "DB" == g) {
                    var _ = $("#mb_prize_" + g + "_item_" + m);
                    _.html() != u && (u.indexOf("...") < 0 ? (_.html(u), _.attr('data-id', u), newResult = !0, finishDb = !0, intervalVariable && window.clearInterval(intervalVariable)) : !startDB && _.html().indexOf("output") < 0 && _.html('<i class="fas fa-spinner fa-spin"></i>') && _.attr('data-id', ''))
                } else {
                    var h = $("#mb_prize_" + g + "_item_" + m);
                    if (h.html() != u || "..." == u) if (u.indexOf("...") < 0) {
                        var p = h.html().indexOf("ketquamoi") + 0;
                        p >= 0 || !isLive ? (h.html(u), h.attr('data-id', u)) : (h.html('<span class="ketquamoi">' + u + "</span>").hide().fadeIn(500), h.attr('data-id', u), newResult = !0), 7 == s && 3 == m && (startDB = !0)
                    } else h.html().indexOf("output") < 0 && h.html('<i class="fas fa-spinner fa-spin"></i>') && h.attr('data-id', '')
                }
            }
        }


        //var shownumber = '<label class="radio" data-value="0"> <input type="radio" name="showed-digits" value="0" checked="checked"> <b></b> <span>Tất cả</span> </label> <label class="radio" data-value="2"> <input type="radio" name="showed-digits" value="2"> <b></b> <span>2 số cuối</span> </label> <label class="radio" data-value="3"> <input type="radio" name="showed-digits" value="3"> <b></b> <span>3 số cuối</span> </label>';
        //$("#showNumber_form").html(shownumber)
        //"" == t.SpecialCodes && (t.SpecialCodes = "... - ... - ...");
        //for (var v = t.SpecialCodes.split(" - "), b = 0; b < v.length; b++) {
        //    var f = v[b], L = $("#mb_prizeCode_item_" + b);
        //    if (L.html() != f) if (f.indexOf("...") < 0) {
        //        var T = L.html().indexOf("ketquamoi");
        //        T >= 0 ? L.html(f.trim()) : L.html("<span class='ketquamoi'>" + f.trim() + "</span>").hide().fadeIn(500), 2 == b && (startDB = !0, finishSpecialCode = !0)
        //    } else L.html('<i class="fas fa-spinner fa-spin"></i>')
        //}

        "" == t.SpecialCodes && (t.SpecialCodes = "... - ... - ...");
        //var p = t.SpecialCodes.split(" - "), _ = $("span[id^='mb_prizeCode_item_']").length;

        $("#mb_prizeCode_item").html(t.SpecialCodes);
        //if (_ != p.length && $("#mb_prizeCode").length) {
        //    var f = "madb" + (_ = p.length), v = '<div class="list-kq madb">';
        //    for (y = 0; y < p.length; y++)v += '<span id="mb_prizeCode_item_' + y + '" class="text-number"><i class="fas fa-spinner fa-spin"></i></span>';
        //    v += "</div>", $("#mb_prizeCode").html(v)
        //}
        //p = t.SpecialCodes.split(" - ");
        //for (var y = 0; y < p.length; y++) {
        //    var T = p[y], b = $("#mb_prizeCode_item_" + y);
        //    b.html() != T && (T.indexOf("...") < 0 ? b.html(T.trim()) : b.html('<i class="fas fa-spinner fa-spin"></i>'))
        //}


        for (var x = 0; x < t.Lotos.length; x++) {
            $("#loto_mb_" + x).html(t.Lotos[x].Tail);
            //var y = t.Lotos[x], z = "", I = y.Tail.trim(), k = "-" == I ? "" : y.Head, N = $("#loto_mb_" + x);
            //if (I.indexOf(",") > 0) {
            //    for (var P = I.split(","), M = 0; M < P.length; M++) z += k + P[M] + (M == P.length - 1 ? "" : ", ");
            //    N.text(z)
            //} else N.text(k + I)
        }

        //live đuôi MB
        for (var x = 0; x < t.Lotos_D.length; x++) {
            $("#loto_mb_d" + x).html(t.Lotos_D[x].Tail_D)
            //var y = t.Lotos_D[x], z = "", I = y.Tail_D.trim(), k = "-" == I ? "" : y.Head_D, N = $("#loto_mb_d" + x);
            //if (I.indexOf(",") > 0) {
            //    for (var P = I.split(","), M = 0; M < P.length; M++) z += P[M] + k + (M == P.length - 1 ? "" : ", ");
            //    N.text(z)
            //} else N.text(I + k)
        }
        "1" == i && (interval && window.clearInterval(interval), intervalVariable && window.clearInterval(intervalVariable)), resultupdating = !1
    } catch (S) {
        console.log(S.message)
    }
}
function getTemplateMB(e) {
    var t = "";
    try {
        var r = e[0], i = r.CrDateTime.toString().split(","), n = r.Status;
        "" == r.SpecialCodes && (r.SpecialCodes = "... - ... - ...");
        var a = r.SpecialCodes.split(" - "), o = "", l = "", s = "", d = "";
        //switch (n) {
        //    case "1":
        //        o = "XSMB mở thưởng tại " + r.LotteryName.replace("Miền Bắc (", "").replace(")", "") + " " + r.CrDateTime;
        //        break;
        //    case "2":
        //        o = "XSMB bắt đầu mở thưởng lúc " + r.OpenPrizeTime;
        //        break;
        //    default:
        //        o = 'XSMB Trực Tiếp - Trực Tiếp KQ Xổ Số Miền Bắc <i class="fa fa-refresh fa-spin"></i>'
        //}
        //t += '<div class="block-main-heading"><' + headingTag + ' id="MbLiveTitle">' + o + "</" + headingTag + '></div><div class="list-link"><h3 class="class-title-list-link"><a href="/xsmb-xo-so-mien-bac" title="XSMB" class="u-line">XSMB</a><span>»</span><a href="/xsmb-' + locdau(i[0]) + '" title="XSMB ' + i[0] + '" class="u-line">XSMB ' + i[0] + '</a><span>»</span><a href="/xsmb-' + i[1].replace(/\//g, "-").replace(" ", "") + '" title="XSMB ' + i[1] + '" class="u-line">XSMB ' + i[1] + '</a></h3></div><div class="block-main-content"><table class="table table-bordered table-striped table-xsmb"><tbody><tr><td style="width: 15%">Mã ĐB</td><td class="text-center">';
        //t += '<div class="page-c px-0 py-0"><div class="py-2 px-2"> <span class="p-title color-primary" id="MbLiveTitle">' + o + '</span> </div> <div class="gr-primary px-2 py-2 text-center"> <h4 class="breadcrumb-table-title"> <a href="/xsmb-' + locdau(i[0]) + '" title="' + i[0] + '">XSMB ' + i[0] + '</a> / <a href="/xsmb-' + i[1].replace(/\//g, "-").replace(" ", "") + '" title="XSMB ' + i[1] + '">XSMB ' + i[1] + '</a></h4> </div><table class="responsive table kqsx kqsx-tinh mb-4"><tbody><tr><td colspan="4" id="mb_prizeCode"><div class="list-kq madb">';
        //t += '<div class="kqsx-today text-center v-card mb-3"><h1 class="lead df-title pt-3 d-block">XSMB - Kết quả Xổ số Miền Bắc - SXMB hôm nay</h1> <h2 class="site-link"  id="MbListLink"> <a href="/xsmb-xo-so-mien-bac" title="XSMB">XSMB</a> <a href="/xsmb-' + locdau(i[0]) + '" title="' + i[0] + '">XSMB ' + i[0] + '</a> <a href="/xsmb-' + i[1].replace(/\//g, "-").replace(" ", "") + '" title="XSMB ' + i[1] + '">XSMB ' + i[1] + '</a> </h2>';
        t += '<div class="tit-mien clearfix"> <h2>XSMB - Xổ số miền Bắc hôm nay</h2> <div id="MbListLink"> <a class="sub-title" href="/xsmb-xo-so-mien-bac" title="XSMB">XSMB</a> » <a class="sub-title" href="/xsmb-' + locdau(i[0]) + '" title="XSMB ' + i[0] + '">XSMB ' + i[0] + '</a> » <a class="sub-title" href="/xsmb-' + i[1].replace(/\//g, "-").replace(" ", "") + '" title="XSMB ' + i[1] + '">XSMB ' + i[1] + '</a> </div> </div>';

        //for (var c = 0; c < a.length; c++) t += '<span id="mb_prizeCode_item_' + c + '" class="madb' + a.length + ' special-code div-horizontal"><i class="fas fa-spinner fa-spin"></i></span>';
        //t += "</div></td></tr>";

        //for (var c = 0; c < a.length; c++) t += '<span id="mb_prizeCode_item_' + c + '" class="text-number"><i class="fas fa-spinner fa-spin"></i></span>';
        //t += "</div></td></tr>";

        //for (var g = 0; g < r.LotPrizes.length; g++) {
        //    var m = r.LotPrizes[g];
        //    s = m.Prize.toLowerCase(), l = m.Range;
        //    var u = l.split(" - "), _ = "";
        //    switch (_ = s.indexOf("db") >= 0 || s.indexOf("đb") >= 0 || s.indexOf("đặc biệt") >= 0 ? "DB" : "" + g, g) {
        //        case 0:
        //            d = "special-prize-lg";
        //            break;
        //        case 1:
        //            d = "number-black-bold";
        //            break;
        //        case 2:
        //            d = "col-xs-6 number-black-bold";
        //            break;
        //        case 4:
        //            d = "col-xs-6 col-md-3 number-black-bold";
        //            break;
        //        case 7:
        //            d = "col-xs-3 special-prize-sm";
        //            break;
        //        default:
        //            d = "col-xs-4 number-black-bold"
        //    }
        //    t += "<tr><td>" + (0 == g ? "ĐB" : m.Prize) + '</td><td class="' + (2 > g ? "text-center" : "") + '">';
        //    for (var h = 0; h < u.length; h++) t += '<span class="' + d + ' div-horizontal" id="mb_prize_' + _ + "_item_" + h + '"><i class="fas fa-spinner fa-spin"></i></span>';
        //    t += "</td></tr>"
        //}
        //t += '</tbody></table></div><div class="banner-adv-small"></div><div class="block-main-content"><a href="/lo-to-mien-bac" title="Lô tô miền Bắc" class="a-link-default link-pad-left">Lô tô miền Bắc</a><table class="table table-bordered table-loto" id="livebangkqlotomb"><tr><th class="col-md-2" style="width: 10%;">Đầu</th><th class="col-md-4">Lô Tô</th><th class="col-md-2" style="width: 10%;">Đuôi</th><th class="col-md-4">Lô Tô</th></tr>';
        //for (var p = 0; p < r.Lotos.length; p++) t += '<tr><td class="text-center">' + p + '</td><td id="loto_mb_' + p + '">_</td><td class="text-center">' + p + '</td><td id="loto_mb_d' + p + '">_</td></tr>';
        //t += '</table></div><div class="link-statistic"><ul><li>Xem thống kê <a href="/soi-cau-xsmb/cau-bach-thu" title="Cầu bạch thủ miền Bắc">Cầu bạch thủ miền Bắc</a></li><li>Xem thống kê <a href="/lo-gan-mb" title="Lô gan miền Bắc">Lô gan miền Bắc</a></li><li>Xem thống kê <a href="/lo-xien" title="Lô xiên miền Bắc">Lô xiên miền Bắc</a></li><li>Tham khảo <a href="/thong-ke-xsmb" title="Dự đoán XSMB">Dự đoán XSMB</a></li></ul></div><p class="text-right margin-10 hidden-xs hidden-sm"><a href="/in-ve-do" title="In vé dò" class="btn btn-danger" role="button">In Vé Dò</a></p>';

        //t += '<table class="kqmb colgiai extendable responsive" data-zone="kqmb"> <tbody> <tr> <td colspan="13" class="v-giai madb" id="mb_prizeCode"> <span class="v-madb" id="mb_prizeCode_item"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="db"> <td class="txt-giai">ĐB</td> <td class="v-giai number "> <span id="mb_prize_DB_item_0" data-nc="5" class="v-gdb " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.1</td> <td class="v-giai number"> <span id="mb_prize_1_item_0" data-nc="5" class="v-g1" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.2</td> <td class="v-giai number"> <span id="mb_prize_2_item_0" data-nc="5" class="v-g2-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_2_item_1" data-nc="5" class="v-g2-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.3</td> <td class="v-giai number"> <span id="mb_prize_3_item_0" data-nc="5" class="v-g3-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_3_item_1" data-nc="5" class="v-g3-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_3_item_2" data-nc="5" class="v-g3-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_3_item_3" data-nc="5" class="v-g3-3 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_3_item_4" data-nc="5" class="v-g3-4 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_3_item_5" data-nc="5" class="v-g3-5 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.4</td> <td class="v-giai number"> <span id="mb_prize_4_item_0" data-nc="4" class="v-g4-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_4_item_1" data-nc="4" class="v-g4-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_4_item_2" data-nc="4" class="v-g4-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_4_item_3" data-nc="4" class="v-g4-3 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.5</td> <td class="v-giai number"> <span id="mb_prize_5_item_0" data-nc="4" class="v-g5-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_5_item_1" data-nc="4" class="v-g5-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_5_item_2" data-nc="4" class="v-g5-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_5_item_3" data-nc="4" class="v-g5-3 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_5_item_4" data-nc="4" class="v-g5-4 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_5_item_5" data-nc="4" class="v-g5-5 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.6</td> <td class="v-giai number"> <span id="mb_prize_6_item_0" data-nc="3" class="v-g6-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_6_item_1" data-nc="3" class="v-g6-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_6_item_2" data-nc="3" class="v-g6-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="g7"> <td class="txt-giai">G.7</td> <td class="v-giai number"> <span id="mb_prize_7_item_0" data-nc="2" class="v-g7-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_7_item_1" data-nc="2" class="v-g7-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_7_item_2" data-nc="2" class="v-g7-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_7_item_3" data-nc="2" class="v-g7-3 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> </tbody> </table> <div class="control-panel d-flex align-items-center justify-content-between"  id="showNumberMB"> <form class="digits-form mt-3 mb-3 text-left" data-control="kqmb"  id="showNumber_form"> <label class="radio" data-value="0"> <input type="radio" name="showed-digits" value="0" checked="checked"> <b></b> <span>Tất cả</span> </label> <label class="radio" data-value="2"> <input type="radio" name="showed-digits" value="2"> <b></b> <span>2 số cuối</span> </label> <label class="radio" data-value="3"> <input type="radio" name="showed-digits" value="3"> <b></b> <span>3 số cuối</span> </label> </form></div> <ul class="row nav__sokq d-flex w-100" id="date-kq-range"> <li class="date-w active"><a href="/so-ket-qua" title="">Sổ kết quả</a> </li> <li class="date-w "><a href="/so-ket-qua" title="">30</a> </li> <li class="date-w"><a href="/xsmb-60-ngay" title="">60</a> </li> <li class="date-w"><a href="/xsmb-90-ngay" title="">90</a> </li> <li class="date-w"><a href="/xsmb-100-ngay" title="">100</a> </li> <li class="date-w"><a href="/xsmb-120-ngay" title="">120</a> </li> <li class="date-w"><a href="/xsmb-200-ngay" title="">200</a> </li> </ul> <div class="thongke mb-3"> <div class="bcr-kqsx px-2 py-2 bg-light"> <h3 class="site-link"> <a href="/lo-to-mien-bac" title="">Bảng Lô Tô Miền Bắc</a> <a href="/lo-to-mien-bac-' + locdau(i[0]) + '" title="">Lô XSMB ' + i[0] + '</a> </h3> </div> <table class="extendable colthreecity w-100 tbl-thongke font-weight-bold layout-fixed" id="livebangkqlotomb"> <tbody> <tr class="first"> <th class="td-h">Đầu</th> <th>Lô tô</th> <th class="td-h">Đuôi</th> <th>Lô tô</th> </tr> <tr class="l"> <td class="w75">0</td> <td class="text-left" id="loto_mb_0">_</td> <td class="td-h">0</td> <td class="text-left" id="loto_mb_d0">_</td> </tr> <tr class="l"> <td class="w75">1</td> <td class="text-left" id="loto_mb_1">_</td> <td class="td-h">1</td> <td class="text-left" id="loto_mb_d1">_</td> </tr> <tr class="l"> <td class="w75">2</td> <td class="text-left" id="loto_mb_2">_</td> <td class="td-h">2</td> <td class="text-left" id="loto_mb_d2">_</td> </tr> <tr class="l"> <td class="w75">3</td> <td class="text-left" id="loto_mb_3">_</td> <td class="td-h">3</td> <td class="text-left" id="loto_mb_d3">_</td> </tr> <tr class="l"> <td class="w75">4</td> <td class="text-left" id="loto_mb_4">_</td> <td class="td-h">4</td> <td class="text-left" id="loto_mb_d4">_</td> </tr> <tr class="l"> <td class="w75">5</td> <td class="text-left" id="loto_mb_5">_</td> <td class="td-h">5</td> <td class="text-left" id="loto_mb_d5">_</td> </tr> <tr class="l"> <td class="w75">6</td> <td class="text-left" id="loto_mb_6">_</td> <td class="td-h">6</td> <td class="text-left" id="loto_mb_d6">_</td> </tr> <tr class="l"> <td class="w75">7</td> <td class="text-left" id="loto_mb_7">_</td> <td class="td-h">7</td> <td class="text-left" id="loto_mb_d7">_</td> </tr> <tr class="l"> <td class="w75">8</td> <td class="text-left" id="loto_mb_8">_</td> <td class="td-h">8</td> <td class="text-left" id="loto_mb_d8">_</td> </tr> <tr class="l"> <td class="w75">9</td> <td class="text-left" id="loto_mb_9">_</td> <td class="td-h">9</td> <td class="text-left" id="loto_mb_d9">_</td> </tr> </tbody> </table> </div>';
        t += '<div id="load_kq_mb_0"> <div data-id="kq" class="one-city" data-region="1"> <table class="kqmb extendable"> <tbody> <tr> <td colspan="13" class="v-giai madb" id="mb_prizeCode"><span class="v-madb" id="mb_prizeCode_item"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="db"> <td class="txt-giai">ĐB</td> <td class="v-giai number "><span data-nc="5" class="v-gdb " id="mb_prize_DB_item_0"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">Giải 1</td> <td class="v-giai number"><span data-nc="5" class="v-g1" id="mb_prize_1_item_0"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">Giải 2</td> <td class="v-giai number"> <span data-nc="5" class="v-g2-0 " id="mb_prize_2_item_0"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="5" class="v-g2-1 " id="mb_prize_2_item_1"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">Giải 3</td> <td class="v-giai number"> <span data-nc="5" class="v-g3-0 " id="mb_prize_3_item_0"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="5" class="v-g3-1 " id="mb_prize_3_item_1"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="5" class="v-g3-2 " id="mb_prize_3_item_2"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="5" class="v-g3-3 " id="mb_prize_3_item_3"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="5" class="v-g3-4 " id="mb_prize_3_item_4"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="5" class="v-g3-5 " id="mb_prize_3_item_5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">Giải 4</td> <td class="v-giai number"> <span data-nc="4" class="v-g4-0 " id="mb_prize_4_item_0"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="4" class="v-g4-1 " id="mb_prize_4_item_1"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="4" class="v-g4-2 " id="mb_prize_4_item_2"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="4" class="v-g4-3 " id="mb_prize_4_item_3"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">Giải 5</td> <td class="v-giai number"> <span data-nc="4" class="v-g5-0 " id="mb_prize_5_item_0"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="4" class="v-g5-1 " id="mb_prize_5_item_1"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="4" class="v-g5-2 " id="mb_prize_5_item_2"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="4" class="v-g5-3 " id="mb_prize_5_item_3"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="4" class="v-g5-4 " id="mb_prize_5_item_4"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="4" class="v-g5-5 " id="mb_prize_5_item_5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">Giải 6</td> <td class="v-giai number"> <span data-nc="3" class="v-g6-0 " id="mb_prize_6_item_0"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="3" class="v-g6-1 " id="mb_prize_6_item_1"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="3" class="v-g6-2 " id="mb_prize_6_item_2"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="g7"> <td class="txt-giai">Giải 7</td> <td class="v-giai number"> <span data-nc="2" class="v-g7-0 " id="mb_prize_7_item_0"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="2" class="v-g7-1 " id="mb_prize_7_item_1"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="2" class="v-g7-2 " id="mb_prize_7_item_2"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="2" class="v-g7-3 " id="mb_prize_7_item_3"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> </tbody> </table> <div class="control-panel"> <form class="digits-form"><label class="radio" data-value="0"><input type="radio" name="showed-digits" value="0"> <b></b><span></span></label><label class="radio" data-value="2"><input type="radio" name="showed-digits" value="2"> <b></b><span></span></label><label class="radio" data-value="3"><input type="radio" name="showed-digits" value="3"> <b></b><span></span></label></form> <div class="buttons-wrapper"><span class="zoom-in-button"><i class="icon zoom-in-icon"></i><span></span></span></div> </div> </div> <div data-id="dd" class="col-firstlast" id="livebangkqlotomb"> <table class="firstlast-mb fl"> <tbody> <tr class="header"> <th>Đầu</th> <th>Đuôi</th> </tr> <tr> <td class="clnote">0</td> <td class="v-loto-dau-0" id="loto_mb_0"></td> </tr> <tr> <td class="clnote">1</td> <td class="v-loto-dau-1" id="loto_mb_1"></td> </tr> <tr> <td class="clnote">2</td> <td class="v-loto-dau-2" id="loto_mb_2"></td> </tr> <tr> <td class="clnote">3</td> <td class="v-loto-dau-3" id="loto_mb_3"></td> </tr> <tr> <td class="clnote">4</td> <td class="v-loto-dau-4" id="loto_mb_4"></td> </tr> <tr> <td class="clnote">5</td> <td class="v-loto-dau-5" id="loto_mb_5"></td> </tr> <tr> <td class="clnote">6</td> <td class="v-loto-dau-6" id="loto_mb_6"></td> </tr> <tr> <td class="clnote">7</td> <td class="v-loto-dau-7" id="loto_mb_7"></td> </tr> <tr> <td class="clnote">8</td> <td class="v-loto-dau-8" id="loto_mb_8"></td> </tr> <tr> <td class="clnote">9</td> <td class="v-loto-dau-9" id="loto_mb_9"></td> </tr> </tbody> </table> <table class="firstlast-mb fr"> <tbody> <tr class="header"> <th>Đầu</th> <th>Đuôi</th> </tr> <tr> <td class="v-loto-duoi-0" id="loto_mb_d0"></td> <td class="clnote">0</td> </tr> <tr> <td class="v-loto-duoi-1" id="loto_mb_d1"></td> <td class="clnote">1</td> </tr> <tr> <td class="v-loto-duoi-2" id="loto_mb_d2"></td> <td class="clnote">2</td> </tr> <tr> <td class="v-loto-duoi-3" id="loto_mb_d3"></td> <td class="clnote">3</td> </tr> <tr> <td class="v-loto-duoi-4" id="loto_mb_d4"></td> <td class="clnote">4</td> </tr> <tr> <td class="v-loto-duoi-5" id="loto_mb_d5"></td> <td class="clnote">5</td> </tr> <tr> <td class="v-loto-duoi-6" id="loto_mb_d6"></td> <td class="clnote">6</td> </tr> <tr> <td class="v-loto-duoi-7" id="loto_mb_d7"></td> <td class="clnote">7</td> </tr> <tr> <td class="v-loto-duoi-8" id="loto_mb_d8"></td> <td class="clnote">8</td> </tr> <tr> <td class="v-loto-duoi-9" id="loto_mb_d9"></td> <td class="clnote">9</td> </tr> </tbody> </table> </div> <div class="clearfix"></div> </div>';

        //t += '<table class="kqmb colgiai extendable responsive" data-zone="kqmb"> <tbody> <tr> <td colspan="13" class="v-giai madb" id="mb_prizeCode"> <span class="v-madb" id="mb_prizeCode_item"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="db"> <td class="txt-giai">ĐB</td> <td class="v-giai number "> <span id="mb_prize_DB_item_0" data-nc="5" class="v-gdb " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.1</td> <td class="v-giai number"> <span id="mb_prize_1_item_0" data-nc="5" class="v-g1" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.2</td> <td class="v-giai number"> <span id="mb_prize_2_item_0" data-nc="5" class="v-g2-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_2_item_1" data-nc="5" class="v-g2-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.3</td> <td class="v-giai number"> <span id="mb_prize_3_item_0" data-nc="5" class="v-g3-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_3_item_1" data-nc="5" class="v-g3-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_3_item_2" data-nc="5" class="v-g3-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_3_item_3" data-nc="5" class="v-g3-3 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_3_item_4" data-nc="5" class="v-g3-4 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_3_item_5" data-nc="5" class="v-g3-5 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.4</td> <td class="v-giai number"> <span id="mb_prize_4_item_0" data-nc="4" class="v-g4-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_4_item_1" data-nc="4" class="v-g4-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_4_item_2" data-nc="4" class="v-g4-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_4_item_3" data-nc="4" class="v-g4-3 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.5</td> <td class="v-giai number"> <span id="mb_prize_5_item_0" data-nc="4" class="v-g5-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_5_item_1" data-nc="4" class="v-g5-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_5_item_2" data-nc="4" class="v-g5-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_5_item_3" data-nc="4" class="v-g5-3 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_5_item_4" data-nc="4" class="v-g5-4 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_5_item_5" data-nc="4" class="v-g5-5 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.6</td> <td class="v-giai number"> <span id="mb_prize_6_item_0" data-nc="3" class="v-g6-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_6_item_1" data-nc="3" class="v-g6-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_6_item_2" data-nc="3" class="v-g6-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="g7"> <td class="txt-giai">G.7</td> <td class="v-giai number"> <span id="mb_prize_7_item_0" data-nc="2" class="v-g7-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_7_item_1" data-nc="2" class="v-g7-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_7_item_2" data-nc="2" class="v-g7-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="mb_prize_7_item_3" data-nc="2" class="v-g7-3 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> </tbody> </table> <div class="control-panel d-flex align-items-center justify-content-between"  id="showNumberMB"> <form class="digits-form mt-3 mb-3 text-left" data-control="kqmb"  id="showNumber_form"> <label class="radio" data-value="0"> <input type="radio" name="showed-digits" value="0" checked="checked"> <b></b> <span>Tất cả</span> </label> <label class="radio" data-value="2"> <input type="radio" name="showed-digits" value="2"> <b></b> <span>2 số cuối</span> </label> <label class="radio" data-value="3"> <input type="radio" name="showed-digits" value="3"> <b></b> <span>3 số cuối</span> </label> </form> <div class="position-relative m-2" id="box_mute"> <div class="modalView_live" id="modalView" > <div id="modalView__closeBtn"></div> <div class="modalView__content centered"> <p>Bật âm thanh trực tiếp quay thưởng để có trải nghiệm tốt nhất!</p> </div> </div> <button class="text-white bg-btn-gradient btn p-2 lh-1 br-8" id="mute"> <i class="fas fa-volume-mute"></i> </button> </div> </div> </div> <ul class="row nav__sokq d-flex w-100" id="date-kq-range"> <li class="date-w active"><a href="/so-ket-qua" title="">Sổ kết quả</a> </li> <li class="date-w "><a href="/so-ket-qua" title="">30</a> </li> <li class="date-w"><a href="/xsmb-60-ngay" title="">60</a> </li> <li class="date-w"><a href="/xsmb-90-ngay" title="">90</a> </li> <li class="date-w"><a href="/xsmb-100-ngay" title="">100</a> </li> <li class="date-w"><a href="/xsmb-120-ngay" title="">120</a> </li> <li class="date-w"><a href="/xsmb-200-ngay" title="">200</a> </li> </ul> <div class="thongke mb-3"> <div class="bcr-kqsx px-2 py-2 bg-light"> <h3 class="site-link"> <a href="/lo-to-mien-bac" title="">Bảng Lô Tô Miền Bắc</a> <a href="/lo-to-mien-bac-' + locdau(i[0]) + '" title="">Lô XSMB ' + i[0] + '</a> </h3> </div> <table class="extendable colthreecity w-100 tbl-thongke font-weight-bold layout-fixed" id="livebangkqlotomb"> <tbody> <tr class="first"> <th class="td-h">Đầu</th> <th>Lô tô</th> <th class="td-h">Đuôi</th> <th>Lô tô</th> </tr> <tr class="l"> <td class="w75">0</td> <td class="text-left" id="loto_mb_0">_</td> <td class="td-h">0</td> <td class="text-left" id="loto_mb_d0">_</td> </tr> <tr class="l"> <td class="w75">1</td> <td class="text-left" id="loto_mb_1">_</td> <td class="td-h">1</td> <td class="text-left" id="loto_mb_d1">_</td> </tr> <tr class="l"> <td class="w75">2</td> <td class="text-left" id="loto_mb_2">_</td> <td class="td-h">2</td> <td class="text-left" id="loto_mb_d2">_</td> </tr> <tr class="l"> <td class="w75">3</td> <td class="text-left" id="loto_mb_3">_</td> <td class="td-h">3</td> <td class="text-left" id="loto_mb_d3">_</td> </tr> <tr class="l"> <td class="w75">4</td> <td class="text-left" id="loto_mb_4">_</td> <td class="td-h">4</td> <td class="text-left" id="loto_mb_d4">_</td> </tr> <tr class="l"> <td class="w75">5</td> <td class="text-left" id="loto_mb_5">_</td> <td class="td-h">5</td> <td class="text-left" id="loto_mb_d5">_</td> </tr> <tr class="l"> <td class="w75">6</td> <td class="text-left" id="loto_mb_6">_</td> <td class="td-h">6</td> <td class="text-left" id="loto_mb_d6">_</td> </tr> <tr class="l"> <td class="w75">7</td> <td class="text-left" id="loto_mb_7">_</td> <td class="td-h">7</td> <td class="text-left" id="loto_mb_d7">_</td> </tr> <tr class="l"> <td class="w75">8</td> <td class="text-left" id="loto_mb_8">_</td> <td class="td-h">8</td> <td class="text-left" id="loto_mb_d8">_</td> </tr> <tr class="l"> <td class="w75">9</td> <td class="text-left" id="loto_mb_9">_</td> <td class="td-h">9</td> <td class="text-left" id="loto_mb_d9">_</td> </tr> </tbody> </table> </div>';
        var v = new Date(utc + (3600000 * +7)), b = v.getDate(), f = v.getMonth() + 1, L = v.getFullYear(), T = "kqngay_" + (10 > b ? "0" + b : "" + b) + (10 > f ? "0" + f : "" + f) + L, x = document.getElementById(T);
        x && (x.innerHTML = t, x.style.display = "block")
    } catch (T) {
        t = "", console.log(T.message)
    }
    return t
}
function getRandomTextMB() {
    if (!(0 > currentPrize || resultupdating) && isLive) {
        var e = 5;
        if (7 == currentPrize) if (e = 5, 3 > currentRangeIndex) {
            e = 2;
            for (var t = currentRangeIndex + 1; 4 > t; t++) $("#mb_prize_7_item_" + t).html(getRandomString(e))
        } else 3 == currentRangeIndex && (e = 5, $("#mb_prize_DB_item_0").html(getRandomString(e))); else 0 == currentPrize ? newResult || $("#mb_prize_1_item_0").html(getRandomString(e)) : 1 == currentPrize ? 0 == currentRangeIndex && ($("#mb_prize_2_item_0").html(getRandomString(e)), $("#mb_prize_2_item_1").html(getRandomString(e))) : 2 == currentPrize ? 0 == currentRangeIndex ? $("#mb_prize_2_item_1").html(getRandomString(e)) : 1 == currentRangeIndex && ($("#mb_prize_3_item_0").html(getRandomString(e)), $("#mb_prize_3_item_1").html(getRandomString(e))) : 3 == currentPrize ? 5 > currentRangeIndex ? (e = 5, currentRangeIndex % 2 == 1 ? (1 == currentRangeIndex || 3 == currentRangeIndex) && ($("#mb_prize_3_item_" + (currentRangeIndex + 1)).html(getRandomString(e)), $("#mb_prize_3_item_" + (currentRangeIndex + 2)).html(getRandomString(e))) : $("#mb_prize_3_item_" + (currentRangeIndex + 1)).html(getRandomString(e))) : (e = 4, 5 == currentRangeIndex && ($("#mb_prize_4_item_0").html(getRandomString(e)), $("#mb_prize_4_item_1").html(getRandomString(e)))) : 4 == currentPrize ? (e = 4, 3 > currentRangeIndex ? currentRangeIndex % 2 == 1 ? 1 == currentRangeIndex && ($("#mb_prize_4_item_" + (currentRangeIndex + 1)).html(getRandomString(e)), $("#mb_prize_4_item_" + (currentRangeIndex + 2)).html(getRandomString(e))) : $("#mb_prize_4_item_" + (currentRangeIndex + 1)).html(getRandomString(e)) : 3 == currentRangeIndex && ($("#mb_prize_5_item_0").html(getRandomString(e)), $("#mb_prize_5_item_1").html(getRandomString(e)))) : 5 == currentPrize ? (e = 4, 5 > currentRangeIndex ? currentRangeIndex % 2 == 1 ? (1 == currentRangeIndex || 3 == currentRangeIndex) && ($("#mb_prize_5_item_" + (currentRangeIndex + 1)).html(getRandomString(e)), $("#mb_prize_5_item_" + (currentRangeIndex + 2)).html(getRandomString(e))) : $("#mb_prize_5_item_" + (currentRangeIndex + 1)).html(getRandomString(e)) : (e = 3, 5 == currentPrize && ($("#mb_prize_6_item_0").html(getRandomString(e)), $("#mb_prize_6_item_1").html(getRandomString(e)), $("#mb_prize_6_item_2").html(getRandomString(e))))) : 6 == currentPrize && (e = 3, 2 > currentRangeIndex ? 0 == currentRangeIndex ? ($("#mb_prize_6_item_1").html(getRandomString(e)), $("#mb_prize_6_item_2").html(getRandomString(e))) : $("#mb_prize_6_item_2").html(getRandomString(e)) : (e = 2, 2 == currentRangeIndex && ($("#mb_prize_7_item_0").html(getRandomString(e)), $("#mb_prize_7_item_1").html(getRandomString(e)), $("#mb_prize_7_item_2").html(getRandomString(e)), $("#mb_prize_7_item_3").html(getRandomString(e)))))
    }
}
function getRandomTextTN() {
    if (TNcurrentPrize && !resultupdating && isLive) for (var e = 0; e < TNcurrentPrize.length; e++) $(TNcurrentPrize[e]).html(getRandomString(TNcurrentPrizeIndex[e]))
}
function getRandomTextProvince() {
    TNcurrentPrize && !resultupdating && isLive && $(TNcurrentPrize[0]).html(getRandomString(TNcurrentPrizeIndex[0]))
}
function getRandomString(e) {
    for (var t = "", r = 0; e > r; r++) {
        var i = Math.floor(10 * Math.random());
        "undefined" == typeof RandomNumber[r] ? (RandomNumber[r] = i, t += '<span class="output">' + RandomNumber[r] + "</span>") : (RandomNumber[r] = RandomNumber[r] + 1, RandomNumber[r] > 9 && (RandomNumber[r] = 0), t += '<span class="output">' + RandomNumber[r] + "</span>")
    }
    return t
}
function getLotteryLink(e, t, r) {
    var i = "/xs" + t.toLowerCase() + "-xo-so-" + locdau(r);
    return i
}
function getLotteryByDateLink(e, t) {
    var r = "/xs" + e.toLowerCase() + "-" + t.split(",")[1].replace(/\//g, "-").replace(" ", "");
    return r
}
function getLotteryByDayOfWeekLink(e, t) {
    var r = locdau(t);
    "chu-nhat" == r && (r += "-cn");
    var i = "/xs" + e.toLowerCase() + "-" + r;
    return i
}
function getLotoByDayOfWeekLink(l, t) {
    var r = locdau(t);
    "chu-nhat" == r && (r += "-cn");
    var i = "/lo-to-" + l.toLowerCase() + "-" + r;
    return i
}
function locdau(e) {
    return e = e.toLowerCase(), e = e.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a"), e = e.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e"), e = e.replace(/ì|í|ị|ỉ|ĩ/g, "i"), e = e.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o"), e = e.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u"), e = e.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y"), e = e.replace(/đ/g, "d"), e = e.replace(/!|@|\$|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\:|\'| |\"|\&|\#|\[|\]|~/g, "-"), e = e.replace(/-+-/g, "-"), e = e.replace(/^\-+|\-+$|\./g, "")
}
function LiveProvince(e, t, r, i, n) {
    lotteryId = t, group = e, headingTag = n, root = i;
    var a = '';
    //var a = root + "lottery_ws/LotteryWCFService.svc/GetLotteryMsgLiveByGroup/" + e + ",1,21,1,4," + r + ",1";
    //isNoteJs(i) && (a = root + e);
    if (e == 1)  a = '/xsmb-kq-new';
    if (e == 2)  a = '/xsmn-kq-new';
    if (e == 3)  a = '/xsmt-kq-new';
    var o = new Date(utc + (3600000 * +7)), l = o.getHours(), s = o.getMinutes();
    if ((4 == l || 16 == l) && s >= 0 && 59 >= s && 2 == e || (5 == l || 17 == l) && s >= 10 && 50 >= s && 3 == e || (6 == l || 18 == l) && s >= 10 && 50 >= s && 1 == e) {
        if (is_first_nodejs || "undefined" != typeof connected && "undefined" != typeof e_live_err_flag && connected && !e_live_err_flag) return is_first_nodejs = !1, console.log("elive is running..."), void (lottery_json.length > 1 && updateProvinceResult(lottery_json));
        try {
            $.ajax({
                type: "GET",
                url: a,
                data: "",
                dataType: "text",
                //timeout: 5e3,
                beforeSend: LiveProvinceBegin,
                success: LiveProvinceSuccess,
                error: LiveProvinceError
            })
        } catch (d) {
        }
    }
}

function LiveProvinceBegin() {
}
function LiveProvinceError() {
}
function LiveProvinceSuccess(e) {
    console.log('LiveProvinceSuccess');
    console.log(e);
    try {
        var t = JSON.parse(e), r = new Date(utc + (3600000 * +7)), i = r.getDate(), n = r.getMonth() + 1, a = r.getFullYear(), o = "kqngay_" + (10 > i ? "0" + i : "" + i) + (10 > n ? "0" + n : "" + n) + a, l = document.getElementById(o);
        l && 0 == $.isEmptyObject(t) && updateProvinceResult(t)
    } catch (s) {
    }

    xsdp.init();
    xsdp.addTableCtrlPanel(function () {
        var t = document.querySelectorAll("table.extendable");
        return [].forEach.call(t, (function (t) {
            t.showedDigits = 0
        })), t
    }(), xsdp._getNumberInTable);
}
function getProvinceHTML(e) {
    var t = "";
    try {
        for (var r, i = "", n = 0; n < e.length; n++) if (e[n].LotteryId == lotteryId) {
            r = e[n];
            break
        }
        if (!r || !r.LotteryId || r.LotteryId <= 0) return void (interval && window.clearInterval(interval));

        var p = r.CrDateTime.split(",");
        2 == group ? (m = "XSMN", i = "Miền Nam", o = "mn", l = "mien-nam", s = "/thong-ke-xsmn") : 3 == group && (m = "XSMT", i = "Miền Trung", o = "mt", l = "mien-trung", s = "/thong-ke-xsmt");

        //headingTag = 'span class="p-title color-primary"';
        //i = "1" == r.Status ? "<" + headingTag + ">KQXS " + r.LotteryName.replace("Miền Bắc (", "").replace(")", "") + " " + r.CrDateTime + "</" + headingTag + ">" : "2" == r.Status ? "<" + headingTag + ">" + r.LotteryName + "</" + headingTag + ">" : "<" + headingTag + ">Trực Tiếp - Trực Tiếp KQXS " + r.LotteryName + ' <i class="fa fa-refresh fa-spin"></i></' + headingTag + ">",
        //t += '<div class="block-main-heading" id="provinceLiveTitle">' + i + '</div><div class="block-main-content"><table class="table table-bordered table-striped table-xsmb"><tbody><tr><td style="width:15%">Giải</td><td class="text-center"><a href="' + getLotteryLink(r.LotteryId, r.LotteryCode, r.LotteryName) + '"" class="u-line special-code">XS' + r.LotteryCode.toUpperCase() + " " + r.CrDateTime.toString()+ '</a></td></tr><tr><td>G.8</td><td class="text-center"><span id="' + r.LotteryCode + '_prize_8_item_0" class="special-prize-lg div-horizontal"><i class="fas fa-spinner fa-spin"></i></span></td></tr><tr><td>G.7</td><td class="text-center"><span id="' + r.LotteryCode + '_prize_7_item_0" class="number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span></td></tr><tr><td>G.6</td><td><span id="' + r.LotteryCode + '_prize_6_item_0" class="col-xs-4 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span><span id="' + r.LotteryCode + '_prize_6_item_1" class="col-xs-4 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span><span id="' + r.LotteryCode + '_prize_6_item_2" class="col-xs-4 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span></td></tr><tr><td>G.5</td><td class="text-center"><span id="' + r.LotteryCode + '_prize_5_item_0" class="number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span></td></tr><tr><td>G.4</td><td><span id="' + r.LotteryCode + '_prize_4_item_0" class="col-sm-3 col-xs-6 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span><span id="' + r.LotteryCode + '_prize_4_item_1" class="col-sm-3 col-xs-6 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span><span id="' + r.LotteryCode + '_prize_4_item_2" class="col-sm-3 col-xs-6 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span><span id="' + r.LotteryCode + '_prize_4_item_3" class="col-sm-3 col-xs-6 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span><span id="' + r.LotteryCode + '_prize_4_item_4" class="col-sm-4 col-xs-4 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span><span id="' + r.LotteryCode + '_prize_4_item_5" class="col-sm-4 col-xs-4 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span><span id="' + r.LotteryCode + '_prize_4_item_6" class="col-sm-4 col-xs-4 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span></td></tr><tr><td>G.3</td><td><span id="' + r.LotteryCode + '_prize_3_item_0" class="col-xs-6 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span><span id="' + r.LotteryCode + '_prize_3_item_1" class="col-xs-6 number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span></td></tr><tr><td>G.2</td><td class="text-center"><span id="' + r.LotteryCode + '_prize_2_item_0" class="number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span></td></tr><tr><td>G.1</td><td class="text-center"><span id="' + r.LotteryCode + '_prize_1_item_0" class="number-black-bold div-horizontal"><i class="fas fa-spinner fa-spin"></i></span></td></tr><tr><td>ĐB</td><td class="text-center"><span id="' + r.LotteryCode + '_prize_db_item_0" class="special-prize-lg div-horizontal"><i class="fas fa-spinner fa-spin"></i></span></td></tr></tbody></table></div><div class="block-main-content"><a class="a-link-default no-underline">Loto ' + r.LotteryName + " " + r.CrDateTime + '</a><table class="table table-bordered table-loto" id="livebangkqloto_' + r.LotteryCode + '"><tr><th class="col-md-2" style="width:10%;">Đầu</th><th class="col-md-4">Lô Tô</th></tr><tr><td class="text-center">0</td><td id="loto_' + r.LotteryCode + '_0">_</td></tr><tr><td class="text-center">1</td><td id="loto_' + r.LotteryCode + '_1">_</td></tr><tr><td class="text-center">2</td><td id="loto_' + r.LotteryCode + '_2">_</td></tr><tr><td class="text-center">3</td><td id="loto_' + r.LotteryCode + '_3">_</td></tr><tr><td class="text-center">4</td><td id="loto_' + r.LotteryCode + '_4">_</td></tr><tr><td class="text-center">5</td><td id="loto_' + r.LotteryCode + '_5">_</td></tr><tr><td class="text-center">6</td><td id="loto_' + r.LotteryCode + '_6">_</td></tr><tr><td class="text-center">7</td><td id="loto_' + r.LotteryCode + '_7">_</td></tr><tr><td class="text-center">8</td><td id="loto_' + r.LotteryCode + '_8">_</td></tr><tr><td class="text-center">9</td><td id="loto_' + r.LotteryCode + '_9">_</td></tr></table></div>';
        //t += '<div class="page-c px-0 py-0"> <div class="py-2 px-2" id="provinceLiveTitle">' + i + '</div> <div class="gr-primary px-2 py-2 text-center"><h4 class="breadcrumb-table-title"><a href="/xsmn-xo-so-mien-nam" title="XSMN" class="u-line">XSMN</a> / <a href="' + getLotteryLink(r.LotteryId, r.LotteryCode, r.LotteryName) + '">XS' + r.LotteryCode.toUpperCase() + ' ' + r.CrDateTime.toString()+ '</a></h4></div> <table class="responsive table kqsx kqsx-tinh mb-4"> <tbody> <tr> <td class="font-14">G8</td> <td><span id="' + r.LotteryCode + '_prize_8_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span></td> </tr> <tr> <td class="font-14">G7</td> <td><span id="' + r.LotteryCode + '_prize_7_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G6</td> <td class="list-kq" data-qty="2"> <span id="' + r.LotteryCode + '_prize_6_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_6_item_1" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_6_item_2" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G5</td> <td><span id="' + r.LotteryCode + '_prize_5_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G4</td> <td class="list-kq" data-qty="5"> <span id="' + r.LotteryCode + '_prize_4_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_1" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_2" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_3" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_4" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_5" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_6" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G3</td> <td class="list-kq" data-qty="4"><span id="' + r.LotteryCode + '_prize_3_item_0" class="text-number" nc="4"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_3_item_1" class="text-number" nc="4"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G2</td> <td><span id="' + r.LotteryCode + '_prize_2_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G1</td> <td><span id="' + r.LotteryCode + '_prize_1_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="gr-primary">ĐB</td> <td><span id="' + r.LotteryCode + '_prize_db_item_0" class="text-number db" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> </tbody> </table> <table class="extendable colthreecity responsive table kqsx thongke font-weight-bold" id="livebangkqloto_' + r.LotteryCode + '"> <tbody> <tr class="gr-primary"> <th class="first">ĐẦU</th> <th> Lô tô</th> <th> Đuôi</th> <th> Lô tô</th> </tr> <tr class="l"> <td class="text-center">0</td> <td id="loto_' + r.LotteryCode + '_0">_</td> <td class="text-center font-red bold">0</td> <td id="loto_' + r.LotteryCode + '_d0">_</td> </tr> <tr class="l"> <td class="text-center">1</td> <td id="loto_' + r.LotteryCode + '_1">_</td> <td class="text-center font-red bold">1</td> <td id="loto_' + r.LotteryCode + '_d1">_</td> </tr> <tr class="l"> <td class="text-center">2</td> <td id="loto_' + r.LotteryCode + '_2">_</td> <td class="text-center font-red bold">2</td> <td id="loto_' + r.LotteryCode + '_d2">_</td> </tr> <tr class="l"> <td class="text-center">3</td> <td id="loto_' + r.LotteryCode + '_3">_</td> <td class="text-center font-red bold">3</td> <td id="loto_' + r.LotteryCode + '_d3">_</td> </tr> <tr class="l"> <td class="text-center">4</td> <td id="loto_' + r.LotteryCode + '_4">_</td> <td class="text-center font-red bold">4</td> <td id="loto_' + r.LotteryCode + '_d4">_</td> </tr> <tr class="l"> <td class="text-center">5</td> <td id="loto_' + r.LotteryCode + '_5">_</td> <td class="text-center font-red bold">5</td> <td id="loto_' + r.LotteryCode + '_d5">_</td> </tr> <tr class="l"> <td class="text-center">6</td> <td id="loto_' + r.LotteryCode + '_6">_</td> <td class="text-center font-red bold">6</td> <td id="loto_' + r.LotteryCode + '_d6">_</td> </tr> <tr class="l"> <td class="text-center">7</td> <td id="loto_' + r.LotteryCode + '_7">_</td> <td class="text-center font-red bold">7</td> <td id="loto_' + r.LotteryCode + '_d7">_</td> </tr> <tr class="l"> <td class="text-center">8</td> <td id="loto_' + r.LotteryCode + '_8">_</td> <td class="text-center font-red bold">8</td> <td id="loto_' + r.LotteryCode + '_d8">_</td> </tr> <tr class="l"> <td class="text-center">9</td> <td id="loto_' + r.LotteryCode + '_9">_</td> <td class="text-center font-red bold">9</td> <td id="loto_' + r.LotteryCode + '_d9">_</td> </tr> </tbody> </table> </div>';
        //t += '<div class="page-c px-0 py-0"> <div class="py-2 px-2" id="provinceLiveTitle">' + i + '</div> <div class="gr-primary px-2 py-2 text-center"><h4 class="breadcrumb-table-title"><a href="/xsmn-xo-so-mien-nam" title="XSMN" class="u-line">XSMN</a> / <a href="' + getLotteryLink(r.LotteryId, r.LotteryCode, r.LotteryName) + '">XS' + r.LotteryCode.toUpperCase() + ' ' + r.CrDateTime.toString()+ '</a></h4></div> <table class="responsive table kqsx kqsx-tinh mb-4"> <tbody> <tr> <td class="font-14">G8</td> <td><span id="' + r.LotteryCode + '_prize_8_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span></td> </tr> <tr> <td class="font-14">G7</td> <td><span id="' + r.LotteryCode + '_prize_7_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G6</td> <td class="list-kq" data-qty="2"> <span id="' + r.LotteryCode + '_prize_6_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_6_item_1" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_6_item_2" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G5</td> <td><span id="' + r.LotteryCode + '_prize_5_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G4</td> <td class="list-kq g3" data-qty="5"> <span id="' + r.LotteryCode + '_prize_4_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_1" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_2" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_3" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_4" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_5" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_6" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G3</td> <td class="list-kq" data-qty="4"><span id="' + r.LotteryCode + '_prize_3_item_0" class="text-number" nc="4"><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_3_item_1" class="text-number" nc="4"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G2</td> <td><span id="' + r.LotteryCode + '_prize_2_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="font-14">G1</td> <td><span id="' + r.LotteryCode + '_prize_1_item_0" class="text-number" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="gr-primary">ĐB</td> <td><span id="' + r.LotteryCode + '_prize_db_item_0" class="text-number db" nc="5"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> </tbody> </table> <table class="extendable colthreecity responsive table kqsx thongke font-weight-bold" id="livebangkqloto_' + r.LotteryCode + '"> <tbody> <tr class="gr-primary"> <th class="first">ĐẦU</th> <th> Lô tô</th> </tr> <tr class="l"> <td class="text-center">0</td> <td id="loto_' + r.LotteryCode + '_0">_</td> </tr> <tr class="l"> <td class="text-center">1</td> <td id="loto_' + r.LotteryCode + '_1">_</td> </tr> <tr class="l"> <td class="text-center">2</td> <td id="loto_' + r.LotteryCode + '_2">_</td> </tr> <tr class="l"> <td class="text-center">3</td> <td id="loto_' + r.LotteryCode + '_3">_</td> </tr> <tr class="l"> <td class="text-center">4</td> <td id="loto_' + r.LotteryCode + '_4">_</td> </tr> <tr class="l"> <td class="text-center">5</td> <td id="loto_' + r.LotteryCode + '_5">_</td> </tr> <tr class="l"> <td class="text-center">6</td> <td id="loto_' + r.LotteryCode + '_6">_</td> </tr> <tr class="l"> <td class="text-center">7</td> <td id="loto_' + r.LotteryCode + '_7">_</td> </tr> <tr class="l"> <td class="text-center">8</td> <td id="loto_' + r.LotteryCode + '_8">_</td> </tr> <tr class="l"> <td class="text-center">9</td> <td id="loto_' + r.LotteryCode + '_9">_</td> </tr> </tbody> </table> </div>';
        //t += '<div class="kqsx-today text-center v-card mb-3"> <table class="devnul_kqmb kqmb colgiai extendable responsive" data-zone="kqmb"> <tbody> <tr> <td colspan="13" class="v-giai madb" id="provinceLiveTitle"> <h1 class="lead df-title pt-3 d-block"> XS' + r.LotteryCode.toUpperCase() + ' - Kết quả Xổ số ' + r.LotteryName + ' - SX' + r.LotteryCode.toUpperCase() + ' hôm nay </h1> <h2 class="site-link"> <a title="XS' + r.LotteryCode.toUpperCase() + '" href="' + getLotteryLink(r.LotteryId, r.LotteryCode, r.LotteryName) + '">XS' + r.LotteryCode.toUpperCase() + ' ' + r.CrDateTime.toString()+ '</a> </h2> </td> </tr> <tr style="display:none"> <td></td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.8</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_8_item_0" class="v-g8" data-nc="5" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.7</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_7_item_0" data-nc="5" class="v-g1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.6</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_6_item_0" data-nc="3" class="v-g6-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_6_item_1" data-nc="3" class="v-g6-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_6_item_2" data-nc="3" class="v-g6-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.5</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_5_item_0" data-nc="4" class="v-g1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.4</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_4_item_0" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_1" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_2" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_3" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_4" data-nc="4" class="v-g5-0 v-g1_miennam" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_5" data-nc="4" class="v-g5-1 v-g1_miennam" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_6" data-nc="4" class="v-g5-2 v-g1_miennam" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.3</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_3_item_0" data-nc="5" class="v-g2-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_3_item_1" data-nc="5" class="v-g2-1" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.2</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_2_item_0" data-nc="5" class="v-g1" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.1</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_1_item_0" data-nc="5" class="v-g1" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="db"> <td class="txt-giai">ĐB</td> <td class="v-giai number "> <span id="' + r.LotteryCode + '_prize_db_item_0" data-nc="5" class="v-gdb" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> </tbody> </table> <div class="control-panel"> <form class="digits-form mt-3 mb-3 text-left" data-control="kqmb"> <label class="radio" data-value="0"> <input type="radio" name="showed-digits" value="0" checked="checked"> <b></b> <span>Tất cả</span> </label> <label class="radio" data-value="2"> <input type="radio" name="showed-digits" value="2"> <b></b> <span>2 số cuối</span> </label> <label class="radio" data-value="3"> <input type="radio" name="showed-digits" value="3"> <b></b> <span>3 số cuối</span> </label> </form> </div> </div> <div class="thongke mb-3"> <table class="extendable colthreecity w-100 tbl-thongke font-weight-bold layout-fixed" id=livebangkqloto_' + r.LotteryCode.toUpperCase() + '> <tbody> <tr> <th class="w100">Đầu</th> <th>Lô tô</th> </tr> <tr class="l"> <td class="w100">0</td> <td class="text-center" id="loto_' + r.LotteryCode + '_0">_</td> </tr> <tr class="l"> <td class="w100">1</td> <td class="text-center" id="loto_' + r.LotteryCode + '_1">_</td> </tr> <tr class="l"> <td class="w100">2</td> <td class="text-center" id="loto_' + r.LotteryCode + '_2">_</td> </tr> <tr class="l"> <td class="w100">3</td> <td class="text-center" id="loto_' + r.LotteryCode + '_3">_</td> </tr> <tr class="l"> <td class="w100">4</td> <td class="text-center" id="loto_' + r.LotteryCode + '_4">_</td> </tr> <tr class="l"> <td class="w100">5</td> <td class="text-center" id="loto_' + r.LotteryCode + '_5">_</td> </tr> <tr class="l"> <td class="w100">6</td> <td class="text-center" id="loto_' + r.LotteryCode + '_6">_</td> </tr> <tr class="l"> <td class="w100">7</td> <td class="text-center" id="loto_' + r.LotteryCode + '_7">_</td> </tr> <tr class="l"> <td class="w100">8</td> <td class="text-center" id="loto_' + r.LotteryCode + '_8">_</td> </tr> <tr class="l"> <td class="w100">9</td> <td class="text-center" id="loto_' + r.LotteryCode + '_9">_</td> </tr> </tbody> </table> </div>';
        //t += '<div class="kqsx-today text-center v-card mb-3"> <table class="devnul_kqmb kqmb colgiai extendable responsive" data-zone="kqmb"> <tbody> <tr> <td colspan="13" class="v-giai madb" id="provinceLiveTitle"> <h1 class="lead df-title pt-3 d-block"> XS' + r.LotteryCode.toUpperCase() + ' - Kết quả Xổ số ' + r.LotteryName + ' - SX' + r.LotteryCode.toUpperCase() + ' hôm nay </h1> <h2 class="site-link"> <a title="XS' + r.LotteryCode.toUpperCase() + '" href="' + getLotteryLink(r.LotteryId, r.LotteryCode, r.LotteryName) + '">XS' + r.LotteryCode.toUpperCase() + ' ' + r.CrDateTime.toString()+ '</a> </h2> </td> </tr> <tr style="display:none"> <td></td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.8</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_8_item_0" class="v-g8" data-nc="5" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.7</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_7_item_0" data-nc="5" class="v-g1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.6</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_6_item_0" data-nc="3" class="v-g6-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_6_item_1" data-nc="3" class="v-g6-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_6_item_2" data-nc="3" class="v-g6-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.5</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_5_item_0" data-nc="4" class="v-g1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.4</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_4_item_0" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_1" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_2" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_3" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_4" data-nc="4" class="v-g5-0 v-g1_miennam" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_5" data-nc="4" class="v-g5-1 v-g1_miennam" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_6" data-nc="4" class="v-g5-2 v-g1_miennam" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.3</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_3_item_0" data-nc="5" class="v-g2-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_3_item_1" data-nc="5" class="v-g2-1" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.2</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_2_item_0" data-nc="5" class="v-g1" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.1</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_1_item_0" data-nc="5" class="v-g1" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="db"> <td class="txt-giai">ĐB</td> <td class="v-giai number "> <span id="' + r.LotteryCode + '_prize_db_item_0" data-nc="5" class="v-gdb" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> </tbody> </table> <div class="control-panel"> <form class="digits-form mt-3 mb-3 text-left" data-control="kqmb"> <label class="radio" data-value="0"> <input type="radio" name="showed-digits" value="0" checked="checked"> <b></b> <span>Tất cả</span> </label> <label class="radio" data-value="2"> <input type="radio" name="showed-digits" value="2"> <b></b> <span>2 số cuối</span> </label> <label class="radio" data-value="3"> <input type="radio" name="showed-digits" value="3"> <b></b> <span>3 số cuối</span> </label> </form> </div> </div> <div class="thongke mb-3"> <table class="extendable colthreecity w-100 tbl-thongke font-weight-bold layout-fixed" id=livebangkqloto_' + r.LotteryCode.toUpperCase() + '> <tbody> <tr class="first"> <th class="td-h">Đầu</th> <th>Lô tô</th> <th class="td-h">Đuôi</th> <th>Lô tô</th> </tr> <tr class="l"> <td class="w75">0</td> <td class="text-left" id="loto_' + r.LotteryCode + '_0">_</td> <td class="td-h">0</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d0">_</td> </tr> <tr class="l"> <td class="w75">1</td> <td class="text-left" id="loto_' + r.LotteryCode + '_1">_</td> <td class="td-h">1</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d1">_</td> </tr> <tr class="l"> <td class="w75">2</td> <td class="text-left" id="loto_' + r.LotteryCode + '_2">_</td> <td class="td-h">2</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d2">_</td> </tr> <tr class="l"> <td class="w75">3</td> <td class="text-left" id="loto_' + r.LotteryCode + '_3">_</td> <td class="td-h">3</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d3">_</td> </tr> <tr class="l"> <td class="w75">4</td> <td class="text-left" id="loto_' + r.LotteryCode + '_4">_</td> <td class="td-h">4</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d4">_</td> </tr> <tr class="l"> <td class="w75">5</td> <td class="text-left" id="loto_' + r.LotteryCode + '_5">_</td> <td class="td-h">5</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d5">_</td> </tr> <tr class="l"> <td class="w75">6</td> <td class="text-left" id="loto_' + r.LotteryCode + '_6">_</td> <td class="td-h">6</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d6">_</td> </tr> <tr class="l"> <td class="w75">7</td> <td class="text-left" id="loto_' + r.LotteryCode + '_7">_</td> <td class="td-h">7</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d7">_</td> </tr> <tr class="l"> <td class="w75">8</td> <td class="text-left" id="loto_' + r.LotteryCode + '_8">_</td> <td class="td-h">8</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d8">_</td> </tr> <tr class="l"> <td class="w75">9</td> <td class="text-left" id="loto_' + r.LotteryCode + '_9">_</td> <td class="td-h">9</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d9">_</td> </tr> </tbody> </table> </div>';
        //t += '<div class="kqsx-today text-center v-card mb-3"> <table class="devnul_kqmb kqmb colgiai extendable responsive" data-zone="kqmb"> <tbody> <tr> <td colspan="13" class="v-giai madb" id="provinceLiveTitle"> <h1 class="lead df-title pt-3 d-block"> XS' + r.LotteryCode.toUpperCase() + ' - Kết quả Xổ số ' + r.LotteryName + ' - SX' + r.LotteryCode.toUpperCase() + ' hôm nay </h1><h2 class="site-link"><a href="/xs' + o + '-xo-so-' + l + '" title="Kết quả xổ số ' + i + '">' + m + '</a> <a href="' + getLotteryByDayOfWeekLink(o, p[0]) + '" title="' + i + ' ' + p[0] + '">' + m + ' ' + p[0] + '</a> <a href="' + getLotteryByDateLink(o, r.CrDateTime) + '" title="' + i + ' ngày ' + p[1] + '">' + m + " " + p[1] + '</a></h2></td> </tr> <tr style="display:none"> <td></td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.8</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_8_item_0" class="v-g8" data-nc="5" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.7</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_7_item_0" data-nc="5" class="v-g1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.6</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_6_item_0" data-nc="3" class="v-g6-0 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_6_item_1" data-nc="3" class="v-g6-1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_6_item_2" data-nc="3" class="v-g6-2 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.5</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_5_item_0" data-nc="4" class="v-g1 " data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.4</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_4_item_0" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_1" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_2" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_3" data-nc="2" class="v-g7-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_4" data-nc="4" class="v-g5-0 v-g1_miennam" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_5" data-nc="4" class="v-g5-1 v-g1_miennam" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_4_item_6" data-nc="4" class="v-g5-2 v-g1_miennam" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.3</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_3_item_0" data-nc="5" class="v-g2-0" data-id=""><i class="fas fa-spinner fa-spin"></i></span> <span id="' + r.LotteryCode + '_prize_3_item_1" data-nc="5" class="v-g2-1" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">G.2</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_2_item_0" data-nc="5" class="v-g1" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">G.1</td> <td class="v-giai number"> <span id="' + r.LotteryCode + '_prize_1_item_0" data-nc="5" class="v-g1" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="db"> <td class="txt-giai">ĐB</td> <td class="v-giai number "> <span id="' + r.LotteryCode + '_prize_db_item_0" data-nc="5" class="v-gdb" data-id=""><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> </tbody> </table> <div class="control-panel" id="showNumberTN"> <form class="digits-form mt-3 mb-3 text-left" data-control="kqmb"> <label class="radio" data-value="0"> <input type="radio" name="showed-digits" value="0" checked="checked"> <b></b> <span>Tất cả</span> </label> <label class="radio" data-value="2"> <input type="radio" name="showed-digits" value="2"> <b></b> <span>2 số cuối</span> </label> <label class="radio" data-value="3"> <input type="radio" name="showed-digits" value="3"> <b></b> <span>3 số cuối</span> </label> </form> </div> </div> <div class="thongke mb-3"> <table class="extendable colthreecity w-100 tbl-thongke font-weight-bold layout-fixed" id=livebangkqloto_' + r.LotteryCode.toUpperCase() + '> <tbody> <tr class="first"> <th class="td-h">Đầu</th> <th>Lô tô</th> <th class="td-h">Đuôi</th> <th>Lô tô</th> </tr> <tr class="l"> <td class="w75">0</td> <td class="text-left" id="loto_' + r.LotteryCode + '_0">_</td> <td class="td-h">0</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d0">_</td> </tr> <tr class="l"> <td class="w75">1</td> <td class="text-left" id="loto_' + r.LotteryCode + '_1">_</td> <td class="td-h">1</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d1">_</td> </tr> <tr class="l"> <td class="w75">2</td> <td class="text-left" id="loto_' + r.LotteryCode + '_2">_</td> <td class="td-h">2</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d2">_</td> </tr> <tr class="l"> <td class="w75">3</td> <td class="text-left" id="loto_' + r.LotteryCode + '_3">_</td> <td class="td-h">3</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d3">_</td> </tr> <tr class="l"> <td class="w75">4</td> <td class="text-left" id="loto_' + r.LotteryCode + '_4">_</td> <td class="td-h">4</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d4">_</td> </tr> <tr class="l"> <td class="w75">5</td> <td class="text-left" id="loto_' + r.LotteryCode + '_5">_</td> <td class="td-h">5</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d5">_</td> </tr> <tr class="l"> <td class="w75">6</td> <td class="text-left" id="loto_' + r.LotteryCode + '_6">_</td> <td class="td-h">6</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d6">_</td> </tr> <tr class="l"> <td class="w75">7</td> <td class="text-left" id="loto_' + r.LotteryCode + '_7">_</td> <td class="td-h">7</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d7">_</td> </tr> <tr class="l"> <td class="w75">8</td> <td class="text-left" id="loto_' + r.LotteryCode + '_8">_</td> <td class="td-h">8</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d8">_</td> </tr> <tr class="l"> <td class="w75">9</td> <td class="text-left" id="loto_' + r.LotteryCode + '_9">_</td> <td class="td-h">9</td> <td class="text-left" id="loto_' + r.LotteryCode + '_d9">_</td> </tr> </tbody> </table> </div>';
        t += '<div class="tit-mien clearfix" id="provinceLiveTitle"> <h2>XS' + r.LotteryCode.toUpperCase() + ' - Kết quả Xổ số ' + r.LotteryName + ' - SX' + r.LotteryCode.toUpperCase() + ' hôm nay</h2> <div> <a class="sub-title" href="/xs' + o + '-xo-so-' + l + '" title="Kết quả xổ số ' + i + '">' + m + '</a> » <a class="sub-title" href="' + getLotteryByDayOfWeekLink(o, p[0]) + '" title="' + i + ' ' + p[0] + '">' + m + ' ' + p[0] + '</a> » <a class="sub-title" href="' + getLotteryLink(r.LotteryId, r.LotteryCode, r.LotteryName) + '" title="XS' + r.LotteryCode.toUpperCase() + '">XS' + r.LotteryCode.toUpperCase() + ' ' + r.CrDateTime.toString()+ '</a> </div> </div> <div id="load_kq_tinh_live"> <div data-id="kq" data-zoom="0" class="one-city"> <table class="kqmb extendable kqtinh"> <tbody> <tr class="g8"> <td class="txt-giai">Giải 8</td> <td class="v-giai number"><span data-nc="2" class="v-g8 " id="' + r.LotteryCode + '_prize_8_item_0"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">Giải 7</td> <td class="v-giai number"><span data-nc="3" class="v-g7 " id="' + r.LotteryCode + '_prize_7_item_0"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">Giải 6</td> <td class="v-giai number"> <span data-nc="4" class="v-g6-0 " id="' + r.LotteryCode + '_prize_6_item_0"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="4" class="v-g6-1 " id="' + r.LotteryCode + '_prize_6_item_1"><i class="fas fa-spinner fa-spin"></i></span><span data-nc="4" class="v-g6-2 " id="' + r.LotteryCode + '_prize_6_item_2"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">Giải 5</td> <td class="v-giai number"> <span data-nc="4" class="v-g5 " id="' + r.LotteryCode + '_prize_5_item_0"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="g4"> <td class="titgiai">Giải 4</td> <td class="v-giai number"> <span data-nc="5" class="v-g4-0 " id="' + r.LotteryCode + '_prize_4_item_0"><i class="fas fa-spinner fa-spin"></i></span><!-- --><span data-nc="5" class="v-g4-1 " id="' + r.LotteryCode + '_prize_4_item_1"><i class="fas fa-spinner fa-spin"></i></span><!-- --><span data-nc="5" class="v-g4-2 " id="' + r.LotteryCode + '_prize_4_item_2"><i class="fas fa-spinner fa-spin"></i></span><!-- --><span data-nc="5" class="v-g4-3 " id="' + r.LotteryCode + '_prize_4_item_3"><i class="fas fa-spinner fa-spin"></i></span><!-- --><span data-nc="5" class="v-g4-4 " id="' + r.LotteryCode + '_prize_4_item_4"><i class="fas fa-spinner fa-spin"></i></span><!-- --><span data-nc="5" class="v-g4-5 " id="' + r.LotteryCode + '_prize_4_item_5"><i class="fas fa-spinner fa-spin"></i></span><!-- --><span data-nc="5" class="v-g4-6 " id="' + r.LotteryCode + '_prize_4_item_6"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">Giải 3</td> <td class="v-giai number"> <span data-nc="5" class="v-g3-0 " id="' + r.LotteryCode + '_prize_3_item_0"><i class="fas fa-spinner fa-spin"></i></span><!-- --><span data-nc="5" class="v-g3-1 " id="' + r.LotteryCode + '_prize_3_item_1"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr> <td class="txt-giai">Giải 2</td> <td class="v-giai number"> <span data-nc="5" class="v-g2 " id="' + r.LotteryCode + '_prize_2_item_0"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="bg_ef"> <td class="txt-giai">Giải 1</td> <td class="v-giai number"><span data-nc="5" class="v-g1 " id="' + r.LotteryCode + '_prize_1_item_0"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> <tr class="gdb db"> <td class="txt-giai">ĐB</td> <td class="v-giai number"><span data-nc="6" class="v-gdb " id="' + r.LotteryCode + '_prize_db_item_0"><i class="fas fa-spinner fa-spin"></i></span> </td> </tr> </tbody> </table> <div class="control-panel"> <form class="digits-form"><label class="radio" data-value="0"><input type="radio" name="showed-digits" value="0"><b></b><span></span></label><label class="radio" data-value="2"><input type="radio" name="showed-digits" value="2"><b></b><span></span></label><label class="radio" data-value="3"><input type="radio" name="showed-digits" value="3"><b></b><span></span></label></form> <div class="buttons-wrapper"><span class="capture-button"><i class="icon capture-icon"></i><span></span></span> <div class="subscription-button dspnone"><input id="load_kq_tinh_1_chx" type="checkbox" class="ntf-sub cbx dspnone" sub-type-id="null"><label id="load_kq_tinh_1_chx_lbl" sub-type-id="null" class="lbl1" for="load_kq_tinh_1_chx"></label><span></span></div> </div> </div> </div> <div class="buttons-wrapper"></div> <div data-id="dd" class="col-firstlast" id="livebangkqloto_' + r.LotteryCode.toUpperCase() +'"> <table class="firstlast-mb fl"> <tbody> <tr class="header"> <th>Đầu</th> <th>Đuôi</th> </tr> <tr> <td class="clred">0</td> <td class="v-loto-dau-0" id="loto_' + r.LotteryCode + '_0"></td> </tr> <tr> <td class="clred">1</td> <td class="v-loto-dau-1" id="loto_' + r.LotteryCode + '_1"></td> </tr> <tr> <td class="clred">2</td> <td class="v-loto-dau-2" id="loto_' + r.LotteryCode + '_2"></td> </tr> <tr> <td class="clred">3</td> <td class="v-loto-dau-3" id="loto_' + r.LotteryCode + '_3"></td> </tr> <tr> <td class="clred">4</td> <td class="v-loto-dau-4" id="loto_' + r.LotteryCode + '_4"></td> </tr> <tr> <td class="clred">5</td> <td class="v-loto-dau-5" id="loto_' + r.LotteryCode + '_5"></td> </tr> <tr> <td class="clred">6</td> <td class="v-loto-dau-6" id="loto_' + r.LotteryCode + '_6"></td> </tr> <tr> <td class="clred">7</td> <td class="v-loto-dau-7" id="loto_' + r.LotteryCode + '_7"></td> </tr> <tr> <td class="clred">8</td> <td class="v-loto-dau-8" id="loto_' + r.LotteryCode + '_8"></td> </tr> <tr> <td class="clred">9</td> <td class="v-loto-dau-9" id="loto_' + r.LotteryCode + '_9"></td> </tr> </tbody> </table> <table class="firstlast-mb fr"> <tbody> <tr class="header"> <th>Đầu</th> <th>Đuôi</th> </tr> <tr> <td class="v-loto-duoi-0" id="loto_' + r.LotteryCode + '_d0"></td> <td class="clred">0</td> </tr> <tr> <td class="v-loto-duoi-1" id="loto_' + r.LotteryCode + '_d1"></td> <td class="clred">1</td> </tr> <tr> <td class="v-loto-duoi-2" id="loto_' + r.LotteryCode + '_d2"></td> <td class="clred">2</td> </tr> <tr> <td class="v-loto-duoi-3" id="loto_' + r.LotteryCode + '_d3"></td> <td class="clred">3</td> </tr> <tr> <td class="v-loto-duoi-4" id="loto_' + r.LotteryCode + '_d4"></td> <td class="clred">4</td> </tr> <tr> <td class="v-loto-duoi-5" id="loto_' + r.LotteryCode + '_d5"></td> <td class="clred">5</td> </tr> <tr> <td class="v-loto-duoi-6" id="loto_' + r.LotteryCode + '_d6"></td> <td class="clred">6</td> </tr> <tr> <td class="v-loto-duoi-7" id="loto_' + r.LotteryCode + '_d7"></td> <td class="clred">7</td> </tr> <tr> <td class="v-loto-duoi-8" id="loto_' + r.LotteryCode + '_d8"></td> <td class="clred">8</td> </tr> <tr> <td class="v-loto-duoi-9" id="loto_' + r.LotteryCode + '_d9"></td> <td class="clred">9</td> </tr> </tbody> </table> </div> <div class="clearfix"></div> </div>';
        var a = new Date(utc + (3600000 * +7)), o = a.getDate(), l = a.getMonth() + 1, s = a.getFullYear(), d = "kqngay_" + (10 > o ? "0" + o : "" + o) + (10 > l ? "0" + l : "" + l) + s, c = document.getElementById(d);
        c && (c.innerHTML = t, $("#livebangkqloto_" + r.LotteryCode).length > 0 && (c.style.display = "block"))
    } catch (g) {
        t = "", console.log(g.message)
    }
    return t
}
function updateProvinceResult(e) {
    newResult = !1, resultupdating = !0;
    try {
        for (var t, r = $("#provinceLiveTitle"), i = "", n = 0; n < e.length; n++) if (e[n].LotteryId == lotteryId) {
            t = e[n];
            break
        }
        if (!t || !t.LotteryId || t.LotteryId <= 0) return void (interval && window.clearInterval(interval));
        0 == $("#livebangkqloto_" + t.LotteryCode).length && getProvinceHTML(e);
        var a = t.Status;
        headingTag = 'span class="p-title color-primary"';
        //"1" == a ? (i = "<" + headingTag + ">KQXS " + t.LotteryName.replace("Miền Bắc (", "").replace(")", "") + " " + t.CrDateTime + "</" + headingTag + ">", isLive = !1) : (isLive = !1, "2" == a ? i = "<" + headingTag + ">KQXS " + t.LotteryName + "</" + headingTag + ">" : (i = "<" + headingTag + ">Trực Tiếp - Trực Tiếp KQXS " + t.LotteryName + ' <i class="fa fa-refresh fa-spin"></i></' + headingTag + ">", isLive = !0)), "2" == a ? r.html().indexOf('<i class="fa fa-refresh fa-spin"></i>') < 0 && r.html(i) : r.html(i), TNcurrentPrize[0] = "#" + t.LotteryCode + "_prize_8_item_0", TNcurrentPrizeIndex[0] = 2;
        "1" == a ? (i = "<" + headingTag + ">KQXS " + t.LotteryName.replace("Miền Bắc (", "").replace(")", "") + " " + t.CrDateTime + "</" + headingTag + ">", isLive = !1) : (isLive = !1, "2" == a ? i = "<" + headingTag + ">KQXS " + t.LotteryName + "</" + headingTag + ">" : (i = "<" + headingTag + ">Trực Tiếp - Trực Tiếp KQXS " + t.LotteryName + ' <i class="fa fa-refresh fa-spin"></i></' + headingTag + ">", isLive = !0)), "2" == a ? r.html().indexOf('<i class="fa fa-refresh fa-spin"></i>') < 0 && r.html(i) : TNcurrentPrize[0] = "#" + t.LotteryCode + "_prize_8_item_0", TNcurrentPrizeIndex[0] = 2;
        for (var o = 0; o < t.LotPrizes.length; o++) {
            var l = t.LotPrizes[o].Prize.toLowerCase(), s = "";
            s = l.indexOf("db") >= 0 || l.indexOf("đb") >= 0 || l.indexOf("đặc biệt") >= 0 ? "db" : "" + (t.LotPrizes.length - o - 1);
            for (var d = t.LotPrizes[o].Range.split(" - "), c = 0; c < d.length; c++) {
                var g = $("#" + t.LotteryCode + "_prize_" + s + "_item_" + c);
                if (g.html() != d[c].trim() || "..." == d[c].trim()) if (d[c].indexOf("...") < 0) {
                    var m = g.html().indexOf("ketquamoi");
                    if (m >= 0 || "1" == a ? g.html(d[c].trim(), g.attr('data-id', d[c].trim())) : (g.html("<span class='ketquamoi'>" + d[c].trim() + "</span>"), g.attr('data-id', d[c].trim()), newResult = !0), c == d.length - 1) {
                        var u = 8 - o - 1;
                        TNcurrentPrize[0] = "#" + t.LotteryCode + "_prize_" + u + "_item_0", 0 == u && (TNcurrentPrize[0] = "#" + t.LotteryCode + "_prize_db_item_0"), 0 == o ? TNcurrentPrizeIndex[0] = 3 : 1 == o || 2 == o ? TNcurrentPrizeIndex[0] = 4 : o > 3 && 6 >= o ? TNcurrentPrizeIndex[0] = 5 : o >= 7 && (t.OpenPrizeTime.indexOf("16h") >= 0 ? TNcurrentPrizeIndex[0] = 6 : TNcurrentPrizeIndex[0] = 5)
                    } else {
                        var u = c + 1;
                        TNcurrentPrize[0] = "#" + t.LotteryCode + "_prize_" + s + "_item_" + u, "db" == s ? t.OpenPrizeTime.indexOf("16h") >= 0 ? TNcurrentPrizeIndex[0] = 6 : TNcurrentPrizeIndex[0] = 5 : 0 == o ? TNcurrentPrizeIndex[0] = 2 : 1 == o ? TNcurrentPrizeIndex[0] = 3 : 2 == o || 3 == o ? TNcurrentPrizeIndex[0] = 4 : o >= 4 && 7 >= o && (TNcurrentPrizeIndex[0] = 5)
                    }
                } else $(g).html().indexOf("output") < 0 && $(g).html('<i class="fas fa-spinner fa-spin"></i>'); else if (d[c].indexOf("...") < 0) if (c == d.length - 1) {
                    var u = 8 - o - 1;
                    TNcurrentPrize[0] = "#" + t.LotteryCode + "_prize_" + u + "_item_0", 0 == u && (TNcurrentPrize[0] = "#" + t.LotteryCode + "_prize_db_item_0"), 0 == o ? TNcurrentPrizeIndex[0] = 3 : 1 == o || 2 == o ? TNcurrentPrizeIndex[0] = 4 : o >= 3 && 6 >= o ? TNcurrentPrizeIndex[0] = 5 : o >= 7 && (t.OpenPrizeTime.indexOf("16h") >= 0 ? TNcurrentPrizeIndex[0] = 6 : TNcurrentPrizeIndex[0] = 5)
                } else {
                    var u = c + 1;
                    TNcurrentPrize[0] = "#" + t.LotteryCode + "_prize_" + s + "_item_" + u, "db" == s ? t.OpenPrizeTime.indexOf("16h") >= 0 ? TNcurrentPrizeIndex[0] = 6 : TNcurrentPrizeIndex[0] = 5 : 0 == o ? TNcurrentPrizeIndex[0] = 2 : 1 == o ? TNcurrentPrizeIndex[0] = 3 : 2 == o || 3 == o ? TNcurrentPrizeIndex[0] = 4 : o >= 4 && 7 >= o && (TNcurrentPrizeIndex[0] = 5)
                }
            }
        }
        //var shownumber = '<form class="digits-form mt-3 mb-3 text-left" data-control="kqmb"> <label class="radio" data-value="0"> <input type="radio" name="showed-digits" value="0" checked="checked"> <b></b> <span>Tất cả</span> </label> <label class="radio" data-value="2"> <input type="radio" name="showed-digits" value="2"> <b></b> <span>2 số cuối</span> </label> <label class="radio" data-value="3"> <input type="radio" name="showed-digits" value="3"> <b></b> <span>3 số cuối</span> </label> </form>';
        //$("#showNumberTN").html(shownumber)
        for (var _ = t.Lotos, h = 0; h < _.length; h++) {
            $("#loto_" + t.LotteryCode + "_" + h).html(_[h].Tail);
            //var p = "", v = _[h].Tail, b = "-" == v ? "" : _[h].Head, f = $("#loto_" + t.LotteryCode + "_" + h);
            //if (v.indexOf(",") > 0) {
            //    for (var L = v.split(","), T = 0; T < L.length; T++) p += b + L[T] + (T == L.length - 1 ? "" : ", ");
            //    f.text(p)
            //} else f.text(b + v)
        }

        for (var _ = t.Lotos_D, h = 0; h < _.length; h++) {
            $("#loto_" + t.LotteryCode + "_d" + h).html(_[h].Tail_D);
            //var p = "", v = _[h].Tail, b = "-" == v ? "" : _[h].Head, f = $("#loto_" + t.LotteryCode + "_" + h);
            //if (v.indexOf(",") > 0) {
            //    for (var L = v.split(","), T = 0; T < L.length; T++) p += b + L[T] + (T == L.length - 1 ? "" : ", ");
            //    f.text(p)
            //} else f.text(b + v)
        }

        "1" == a && (interval && window.clearInterval(interval), intervalVariable && window.clearInterval(intervalVariable)), resultupdating = !1
    } catch (x) {
        console.log(x)
    }
}
function isNoteJs(e) {
    var t = e.replace("http://", "");
    return t = t.replace("https://", ""), t.indexOf(":") >= 0 ? !0 : !1
}
function orderTN(e, t) {
    var r, i = [];
    try {
        var n = ["13,14,15", "10,16,17", "11,18,19", "20,21,22", "23,24,25", "14,26,27,28", "29,30,31"];
        3 == t && (n = ["32,33", "34,35", "36,37", "38,39,40", "41,42", "37,43,44", "32,36,45"]);
        var a = new Date(utc + (3600000 * +7)), o = a.getDay();
        switch (o) {
            case 1:
                r = n[0].split(",");
                break;
            case 2:
                r = n[1].split(",");
                break;
            case 3:
                r = n[2].split(",");
                break;
            case 4:
                r = n[3].split(",");
                break;
            case 5:
                r = n[4].split(",");
                break;
            case 6:
                r = n[5].split(",");
                break;
            case 0:
                r = n[6].split(",")
        }
        for (var l = 0; l < r.length; l++) for (var s = 0; s < e.length; s++) if (e[s].LotteryId == r[l]) {
            i.push(e[s]);
            break
        }
    } catch (d) {
        console.log(d)
    }
    return i
}
function GetFullJsonObject(e) {
    for (var t = [], r = 0, i = 0; i < e.length; i++) {
        for (var n = e[i], a = [{Head: "-", Tail: "0"}, {Head: "-", Tail: "1"}, {Head: "-", Tail: "2"}, {
            Head: "-",
            Tail: "3"
        }, {Head: "-", Tail: "4"}, {Head: "-", Tail: "5"}, {Head: "-", Tail: "6"}, {Head: "-", Tail: "7"}, {
            Head: "-",
            Tail: "8"
        }, {Head: "-", Tail: "9"}], o = [{Head: "0", Tail: "-"}, {Head: "1", Tail: "-"}, {
            Head: "2",
            Tail: "-"
        }, {Head: "3", Tail: "-"}, {Head: "4", Tail: "-"}, {Head: "5", Tail: "-"}, {Head: "6", Tail: "-"}, {
            Head: "7",
            Tail: "-"
        }, {Head: "8", Tail: "-"}, {Head: "9", Tail: "-"}], l = [], s = 0; s < n.Lots.length; s++) {
            var d = {Prize: n.Lots[s].P, Range: n.Lots[s].R}, c = n.Lots[s].R, g = c.split("-");
            l[s] = d;
            for (var m = 0; m < g.length; m++) {
                var u = g[m].trim();
                if ("..." != u) {
                    var _ = parseInt(u) % 100, h = Math.floor(_ / 10), p = _ % 10;
                    "-" == a[p].Head && (a[p].Head = ""), a[p].Head.length > 0 && (a[p].Head += ","), a[p].Head += "" + h, "-" == o[h].Tail && (o[h].Tail = ""), o[h].Tail.length > 0 && (o[h].Tail += ","), o[h].Tail += "" + p
                }
            }
        }
        var v = {
            CrDateTime: n.Time,
            LotPrizes: l,
            LotoTailTable: a,
            Lotos: o,
            LotteryCode: n.Code,
            LotteryId: n.Id,
            LotteryName: n.Name,
            OpenPrizeTime: n.OTime,
            SpecialCodes: n.SCodes,
            Status: n.Status
        };
        t[r++] = v
    }
    return t
}
//function MQTTLiveXS(e) {
//    groupId = e.group_id, group = e.group_id, "undefined" != typeof fromPageView && "kqd" == fromPageView.toLowerCase() ? MQTTLiveProvince(GetFullJsonObject(e.lottery_data)) : 1 == e.group_id ? MQTTLiveMB(GetFullJsonObject(e.lottery_data)) : 2 == e.group_id ? MQTTLiveMN(GetFullJsonObject(e.lottery_data)) : 3 == e.group_id && MQTTLiveMT(GetFullJsonObject(e.lottery_data))
//}
//function MQTTLiveMB(e) {
//    lottery_json = e;
//    try {
//        var t = new Date(utc + (3600000*+7)), r = t.getHours(), i = t.getMinutes(), n = t.getDate(), a = t.getMonth() + 1, o = t.getFullYear(), l = "kqngay_" + (10 > n ? "0" + n : "" + n) + (10 > a ? "0" + a : "" + a) + o, s = document.getElementById(l);
//        s && 0 == $.isEmptyObject(e) && 18 == r && i >= 10 && 40 >= i && (updateMBResult(e), s.style.display = "block")
//    } catch (d) {
//        console.log(d)
//    }
//}
//function MQTTLiveMT(e) {
//    lottery_json = e;
//    try {
//        var t = new Date(utc + (3600000*+7)), r = (t.getHours(), t.getMinutes(), t.getDate()), i = t.getMonth() + 1, n = t.getFullYear(), a = "mt_kqngay_" + (10 > r ? "0" + r : "" + r) + (10 > i ? "0" + i : "" + i) + n, o = document.getElementById(a);
//        o && 0 == $.isEmptyObject(e) && (updateTNResult(e), o.style.display = "block")
//    } catch (l) {
//        console.log(l)
//    }
//}
//function MQTTLiveMN(e) {
//    lottery_json = e;
//    try {
//        var t = new Date(utc + (3600000*+7)), r = (t.getHours(), t.getMinutes(), t.getDate()), i = t.getMonth() + 1, n = t.getFullYear(), a = "mn_kqngay_" + (10 > r ? "0" + r : "" + r) + (10 > i ? "0" + i : "" + i) + n, o = document.getElementById(a);
//        o && 0 == $.isEmptyObject(e) && (updateTNResult(e), o.style.display = "block")
//    } catch (l) {
//        console.log(l)
//    }
//}
//function MQTTLiveProvince(e) {
//    lottery_json = e;
//    try {
//        console.log(lottery_json);
//        var t = new Date(utc + (3600000*+7)), r = t.getDate(), i = t.getMonth() + 1, n = t.getFullYear(), a = "kqngay_" + (10 > r ? "0" + r : "" + r) + (10 > i ? "0" + i : "" + i) + n, o = document.getElementById(a);
//        o && 0 == $.isEmptyObject(e) && (lotteryId = lotId, updateProvinceResult(e))
//    } catch (l) {
//        console.log(l)
//    }
//}
var dd = new Date(), utc = dd.getTime() + (dd.getTimezoneOffset() * 60000), root = null, statusLive = 2, headingTag = "h2", animationTimer, currentdate = new Date(utc + (3600000 * +7)), hours = currentdate.getHours(), minute = currentdate.getMinutes(), currentPrize = 0, currentRangeIndex = 0, isLive = !1, resultUpdating = !1, startDB = !1, newResult = !1, resultupdating = !1, finishDb = !1, finishSpecialCode = !1, currentCountDB = 0, TNcurrentPrize = [], TNcurrentPrizeIndex = [], RandomNumber = [], l_root, sucLiveUrlIndex = 0, start_time, request_time, warringTime = 1e3, lottery_json = [], is_first_nodejs = !1, group = 0, lotteryId = 0;