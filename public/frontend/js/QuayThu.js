$(function () {
    xsdpquaythu.init();
});
var xsdpquaythuconfig = {
    rootPath: '/'
}
var isrunning = false;
var numshow = 0;
var xsdpquaythu = {
    variables: {
        lotMsgListMN: 0,
        lotMsgListMT: 0,
        currentPage: 1
    },
    init: function () {
        this.events();
    },
    events: function () {

        $("#hover-number td").mouseout(function () {
            var id = $(this).parent().attr("data");
            $('#table-' + id + ' tbody tr td span').each(function (index, element) {
                var txt = $(element).html();
                var res = txt.split('<mark>');
                $(element).html(res);
            });
        });
        $("#hover-number td").mouseover(function () {
            var value = $(this).text();
            console.log('a: ' + value);
            var id = $(this).parent().attr("data");
            $('#table-' + id + ' tbody tr td span').each(function (index, element) {
                var txt = $(element).html();
                if (txt[txt.length - 1] == value || txt[txt.length - 2] == value)
                    $(element).html(txt.slice(0, txt.length - 2) + '<mark>' + txt.slice(txt.length - 2, txt.length) + '</mark>');
            });
        });
    },
    DayOfWeekChange: function (LotteryGroupId) {
        var ddLotteries = $("#ddLotteries");
        var dayOfWeek = $("#ddlDayOfWeeks option:selected").val();
        var url = xsdpconfig.rootPath + 'Utils/GetLotteriesByDayOfWeek';
        var dataGetter = {
            'dayOfWeek': dayOfWeek
        };
        $.xsdpAjax(url, 'Get', dataGetter, function (resp) {
            var objJSON = JSON.parse(resp);
            if (LotteryGroupId == null) {
                ddLotteries.html($('<option></option>').val(xsdpquaythuconfig.rootPath + "quay-thu-xo-so-mien-bac.html").html('Miền Bắc'));
                $.each(objJSON, function (i, option) {
                    if (option.LotteryGroupId > 1) {
                        ddLotteries.append($('<option></option>').val(xsdpquaythuconfig.rootPath + "quay-thu-xs" + option.LotteryCode.toLowerCase() + ".html").html(option.LotteryName));
                    }
                });
            }else
            {
                if (LotteryGroupId == 2 || LotteryGroupId == 3) {
                    if (LotteryGroupId == 2) {
                        ddLotteries.html($('<option></option>').val(xsdpquaythuconfig.rootPath + "quay-thu-xo-so-mien-nam.html").html('Miền Nam'));
                    } else if (LotteryGroupId == 3) {
                        ddLotteries.html($('<option></option>').val(xsdpquaythuconfig.rootPath + "quay-thu-xo-so-mien-trung.html").html('Miền Trung'));
                    }
                    $.each(objJSON, function (i, option) {
                        if (option.LotteryGroupId == LotteryGroupId) {
                            ddLotteries.append($('<option></option>').val(xsdpquaythuconfig.rootPath + "quay-thu-xs" + option.LotteryCode.toLowerCase() + ".html").html(option.LotteryName));
                        }
                    });
                } else if (LotteryGroupId == 4) {
                    ddLotteries.html($('<option></option>').val(xsdpquaythuconfig.rootPath + "quay-thu-xo-so.html").html('Chọn tỉnh'));
                    ddLotteries.append($('<option></option>').val(xsdpquaythuconfig.rootPath + "quay-thu-xo-so-mien-bac.html").html('Miền Bắc'));
                    $.each(objJSON, function (i, option) {
                        if (option.LotteryGroupId > 1) {
                            ddLotteries.append($('<option></option>').val(xsdpquaythuconfig.rootPath + "quay-thu-xs" + option.LotteryCode.toLowerCase() + ".html").html(option.LotteryName));
                        }
                    });
                }
            }
        });
    },
    LotteriesChange: function () {
        var url = $("#ddLotteries option:selected").val();
        if (url) {
            window.location = url;
        }
    },
    choice: function (id, num) {
        numshow = num;
        //if (!isrunning) {
            mn_mt = "table-xsmb";
            if (id == 1)
                mn_mt = "table-xsmn";
            if (id == 2)
                mn_mt = "table-xsmt";
            if (id == 3)
                mn_mt = "table-tinh";
            $('#' + mn_mt + ' tbody tr td span').each(function (index, element) {
                var txt = $(element).attr("data");
                if (txt.indexOf("...") == -1) {
                    if (num == 2 || num == 3) {
                        if (txt.length > num)
                            txt = txt.substr(txt.length - num);
                    }
                    $(element).text(txt);
                }
                
            });
        //}
    },
    RunRandomXSMB: function () {
        isrunning = true;
        xsdpquaythu.goToByScroll('beginroll');
        $('#btnStartOrStop').html('Đang quay thử ' + '<i class="fas fa-spinner fa-spin"></i>');
        for (var i = 0; i < 10; i++) {
            $('#loto_mb_' + i).html("");
            $('#duoi_loto_mb_' + i).html("");
        }
        // $('#turn').html('ĐANG QUAY THỬ XSMB' + '<img class="btn-loading" src="' + xsdpquaythuconfig.rootPath + 'Content/images/icon-loadding.gif"/>');
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 2000;
        var arrRange = new Array();
        //add ket qua
        arrRange.push(xsdpquaythu.getRandomString(5));
        arrRange.push(xsdpquaythu.getRandomString(5));
        arrRange.push(xsdpquaythu.getRandomString(5));
        for (var i = 0; i < 6; i++) {
            arrRange.push(xsdpquaythu.getRandomString(5));
        }
        for (var i = 0; i < 4; i++) {
            arrRange.push(xsdpquaythu.getRandomString(4));
        }
        for (var i = 0; i < 6; i++) {
            arrRange.push(xsdpquaythu.getRandomString(4));
        }
        for (var i = 0; i < 3; i++) {
            arrRange.push(xsdpquaythu.getRandomString(3));
        }
        for (var i = 0; i < 4; i++) {
            arrRange.push(xsdpquaythu.getRandomString(2));
        }
        //add ket qua giai dac biet
        arrRange.push(xsdpquaythu.getRandomString(5));
        //chuyen tat ca ket qua ve anh gif
        for (var i = 0; i < arrRange.length; i++) {
            $('#mb_prize_' + i).html('<i class="fas fa-spinner fa-spin"></i>');
            $('#mb_prize_' + i).attr("data", "...");
        }
        //gan du lieu cho tung ket qua, moi ket qua cach nhau 2000
        for (var i = 0; i < arrRange.length; i++) {
            xsdpquaythu.sethtml('mb_prize_' + i, arrRange[i], 1000 * i);
        }
    },
    sethtml: function (id, value, time) {
        setTimeout(function () { xsdpquaythu.sethtmlRuning(id, value); }, time);
    },
    sethtmlRuning: function (id, value) {
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 1000;
        var minNumber = 0; // le minimum
        var maxNumber = 9; // le maximum
        
        $('#' + id).html('');
        if ((numshow == 2 || numshow == 3) && value.length > numshow) {
            for (var i = 0; i < numshow ; i++) {
                $('#' + id).append('<span class="output" id="output' + i + '"></span>');
            }
        } else {
            for (var i = 0; i < value.length ; i++) {
                $('#' + id).append('<span class="output" id="output' + i + '"></span>');
            }
        }
        animationTimer = setInterval(function () {
            if (new Date().getTime() - started < duration) {
                //so chay random truoc khi show ket qua
                if ((numshow == 2 || numshow == 3) && value.length > numshow) {
                    for (var i = 0; i < numshow; i++) {
                        $('#output' + i).text('' + Math.floor(Math.random() * (maxNumber - minNumber + 1) + minNumber));
                    }
                }else
                {
                    for (var i = 0; i < value.length; i++) {
                        $('#output' + i).text('' + Math.floor(Math.random() * (maxNumber - minNumber + 1) + minNumber));
                    }
                }
            }
            else {
                clearInterval(animationTimer); // Stop the loop
                //show ket qua
                if (numshow == 2 || numshow == 3) {
                    if (value.length > numshow) {
                        $('#' + id).html(value.substr(value.length - numshow));
                    } else {
                        $('#' + id).html(value);
                    }
                } else {
                    $('#' + id).html(value);
                }
                $('#' + id).attr("data", value);
                $('#' + id).attr("data-id", value);
            }
        }, 100);
        xsdpquaythu.addValueToTableLoto(value);
    },
    addValueToTableLoto: function (value) {
        if (value != null) {
            value = parseInt(value) % 100;

            var tail = value % 10;
            var head = value / 10;

            tail = parseInt(tail);
            head = parseInt(head);

            if(value < 10) value = '0'+value;
            // thêm cột đầu
            var strTail = $('#loto_mb_' + head).html();
            if (strTail.length > 0) {
                $('#loto_mb_' + head).html(strTail + ", " + value);
            }
            else {
                $('#loto_mb_' + head).html(value);
            }


            // thêm cột đuôi
            var strHead = $('#duoi_loto_mb_' + tail).html();
            if (strHead.length > 0) {
                $('#duoi_loto_mb_' + tail).html(strHead + ", " + value);
            }
            else {
                $('#duoi_loto_mb_' + tail).html(value);
            }
        }
    },
    getRandomString: function (len) {
        var number = '';
        for (var i = 0; i < len; i++) {
            number += Math.floor(Math.random() * (9 - 0 + 1) + 0);
        }
        return number;
    },
    // quaythu mien nam va mien trung
    RunRandomXSMN: function (lotteryGroup) {
        isrunning = true;
        xsdpquaythu.goToByScroll('beginroll');
        //xoso.goToByScroll('kqcaumb');
        $('#btnStartOrStop').html('Đang quay thử ' + '<i class="fas fa-spinner fa-spin"></i>');
        $("[id^=item_Head_]").html("");

        var conveniancecount = $("div[id*='mn_prize_']").length;
        console.log(conveniancecount);
        var numberprovince = conveniancecount / 18;
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 2000;
        var arrRange = new Array();
        //add ket qua
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdpquaythu.getRandomString(2));
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdpquaythu.getRandomString(3));
        }
        for (var index = 0; index < numberprovince; index++) {
            for (var i = 0; i < 3; i++) {
                arrRange.push(xsdpquaythu.getRandomString(4));
            }
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdpquaythu.getRandomString(4));
        }
        for (var index = 0; index < numberprovince; index++) {
            for (var i = 0; i < 7; i++) {
                arrRange.push(xsdpquaythu.getRandomString(5));
            }
        }
        for (var index = 0; index < numberprovince; index++) {
            for (var i = 0; i < 2; i++) {
                arrRange.push(xsdpquaythu.getRandomString(5));
            }
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdpquaythu.getRandomString(5));
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdpquaythu.getRandomString(5));
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdpquaythu.getRandomString(6));
        }
        //chuyen tat ca ket qua ve anh gif
        for (var i = 0; i < arrRange.length; i++) {
            $('#mn_prize_' + i).html('<i class="fas fa-spinner fa-spin"></i>');
        }
        //gan du lieu cho tung ket qua, moi ket qua cach nhau 1000
        for (var i = 0; i < arrRange.length; i++) {
            xsdpquaythu.sethtmlMN('mn_prize_' + i, arrRange[i], 1000 * i);
        }
    },
    sethtmlMN: function (id, value, time) {
        setTimeout(function () { xsdpquaythu.sethtmlMNRuning(id, value); }, time);
    },
    sethtmlMNRuning: function (id, value) {
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 1000;
        var minNumber = 0; // le minimum
        var maxNumber = 9; // le maximum
        var LotteryCode = $('#' + id).attr("LotteryCode");
        $('#' + id).html('');
        if ((numshow == 2 || numshow == 3) && value.length > numshow) {
            for (var i = 0; i < numshow ; i++) {
                $('#' + id).append('<span class="output" id="outputMN' + i + '"></span>');
            }
        } else {
            for (var i = 0; i < value.length ; i++) {
                $('#' + id).append('<span class="output" id="outputMN' + i + '"></span>');
            }
        }

        animationTimer = setInterval(function () {
            if (new Date().getTime() - started < duration) {
                //so chay random truoc khi show ket qua
                if ((numshow == 2 || numshow == 3) && value.length > numshow) {
                    for (var i = 0; i < numshow; i++) {
                        $('#outputMN' + i).text('' + Math.floor(Math.random() * (maxNumber - minNumber + 1) + minNumber));
                    }
                } else {
                    for (var i = 0; i < value.length; i++) {
                        $('#outputMN' + i).text('' + Math.floor(Math.random() * (maxNumber - minNumber + 1) + minNumber));
                    }
                }
            }
            else {
                clearInterval(animationTimer); // Stop the loop
                //show ket qua
                //$('#' + id).html(value);
                if (numshow == 2 || numshow == 3) {
                    if (value.length > numshow) {
                        $('#' + id).html(value.substr(value.length - numshow));
                    } else {
                        $('#' + id).html(value);
                    }
                } else {
                    $('#' + id).html(value);
                }
                $('#' + id).attr("data", value);
                $('#' + id).attr("data-id", value);
            }

        }, 100);
        xsdpquaythu.XSMNaddValueToTableLoto(value, LotteryCode);
    },
    XSMNaddValueToTableLoto: function (value, LotteryCode) {
        if (value != null) {
            value = parseInt(value) % 100;
            var tail = value % 10;
            var head = value / 10;
            tail = parseInt(tail);
            head = parseInt(head);

            if(value < 10) value = '0'+value;

            var strHead = $('#item_Head_' + LotteryCode + "_" + head).html();
            if (strHead.length > 0) {
                $('#item_Head_' + LotteryCode + "_" + head).html(strHead + "," + value);
            }
            else {
                $('#item_Head_' + LotteryCode + "_" + head).html(value);
            }
        }
    },
    //quay thu theo dai
    RunRandomXSTheoDai: function (lotteryName) {
        isrunning = true;
        xsdpquaythu.goToByScroll('beginroll');
        $('#btnStartOrStop').html('Đang quay thử');
        for (var i = 0; i < 10; i++) {
            $('#loto_mb_' + i).html("");
        }
        //$('#turn').html('ĐANG QUAY THỬ XS' + lotteryCode + ' <img class="btn-loading" src="' + xsdpconfig.rootPath + 'assets/images/loading.gif"/>');
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 2000;
        var arrRange = new Array();
        //add ket qua
        arrRange.push(xsdpquaythu.getRandomString(2));
        arrRange.push(xsdpquaythu.getRandomString(3));
        for (var i = 0; i < 3; i++) {
            arrRange.push(xsdpquaythu.getRandomString(4));
        }
        arrRange.push(xsdpquaythu.getRandomString(4));
        for (var i = 0; i < 7; i++) {
            arrRange.push(xsdpquaythu.getRandomString(5));
        }
        for (var i = 0; i < 2; i++) {
            arrRange.push(xsdpquaythu.getRandomString(5));
        }
        arrRange.push(xsdpquaythu.getRandomString(5));
        arrRange.push(xsdpquaythu.getRandomString(5));
        //add ket qua giai dac biet
        arrRange.push(xsdpquaythu.getRandomString(6));
        //chuyen tat ca ket qua ve anh gif
        for (var i = 0; i < arrRange.length; i++) {
            $('#qttd_prize_' + i).html('<i class="fas fa-spinner fa-spin"></i>');
        }
        //gan du lieu cho tung ket qua, moi ket qua cach nhau 2000
        for (var i = 0; i < arrRange.length; i++) {
            xsdpquaythu.sethtml('qttd_prize_' + i, arrRange[i], 1000 * i);
        }

    },
    RunRandomComplete: function (str) {
        isrunning = false;
        $('#btnStartOrStop').html('Quay thử lại');
    },
    goToByScroll: function (id) {
        id = id.replace("link", "");

        // Scroll
        $('html,body').animate({ scrollTop: $("#" + id).offset().top }, 2000);

    },
}