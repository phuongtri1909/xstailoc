!function(n,h){"object"==typeof exports&&"undefined"!=typeof module?h(exports):"function"==typeof define&&define.amd?define(["exports"],h):h((n="undefined"!=typeof globalThis?globalThis:n||self).vn={})}(this,function(n){"use strict";var h="undefined"!=typeof window&&void 0!==window.flatpickr?window.flatpickr:{l10ns:{}},e={weekdays:{shorthand:["CN","T2","T3","T4","T5","T6","T7"],longhand:["Chủ nhật","Thứ hai","Thứ ba","Thứ tư","Thứ năm","Thứ sáu","Thứ bảy"]},months:{shorthand:["Th1","Th2","Th3","Th4","Th5","Th6","Th7","Th8","Th9","Th10","Th11","Th12"],longhand:["Tháng một","Tháng hai","Tháng ba","Tháng tư","Tháng năm","Tháng sáu","Tháng bảy","Tháng tám","Tháng chín","Tháng mười","Tháng mười một","Tháng mười hai"]},firstDayOfWeek:1,rangeSeparator:" đến "};h.l10ns.vn=e;h=h.l10ns;n.Vietnamese=e,n.default=h,Object.defineProperty(n,"__esModule",{value:!0})});
jQuery(document).ready(function($) {
    $('.sidebar-title, .toggle-title').click(function() {
        $(this).parent().toggleClass('hide');
    });

    $('.menu-btn').click(function(){
        $(this).toggleClass('active');
        var mobile_menu = $('.header-nav').html();
        $('#mobile-menu').html(mobile_menu);
        $(this).parent().toggleClass('active');
    });
    $('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = $(this).attr('href');
        $('.tabs ' + currentAttrValue).fadeIn(400).siblings().hide();
        $(this).parent('li').addClass('active').siblings().removeClass('active');
        e.preventDefault();
    });


    //$('#date-picker-xsmb, #date-picker-xsmn, #date-picker-xsmt, #mobi-picker-xsmb, #mobi-picker-xsmt, #mobi-picker-xsmn').datepicker({
    //    autoclose: true,
    //    format: "dd-mm-yyyy",
    //    immediateUpdates: true,
    //    endDate: '+2d',
    //    todayBtn: true,
    //    todayHighlight: true,
    //    startDate: new Date(2009, 0, 1),
    //    language: 'vi'
    //});
    //
    //$('#date-picker-xsmb, #mobi-picker-xsmb').on('changeDate', function (e) {
    //    var ngay = e.date.getDate('getDate');
    //    if (ngay < 10) ngay = '0' + ngay;
    //    var thang = e.date.getMonth('getMonth') + 1;
    //    if (thang < 10) thang = '0' + thang;
    //    var nam = e.date.getFullYear('getFullYear');
    //    window.location = document.location.origin + '/xsmb-' + ngay + "-" + thang + "-" + nam;
    //});
    //
    //$('#date-picker-xsmt, #mobi-picker-xsmt').on('changeDate', function (e) {
    //    var ngay = e.date.getDate('getDate');
    //    if (ngay < 10) ngay = '0' + ngay;
    //    var thang = e.date.getMonth('getMonth') + 1;
    //    if (thang < 10) thang = '0' + thang;
    //    var nam = e.date.getFullYear('getFullYear');
    //    window.location = document.location.origin + '/xsmt-' + ngay + "-" + thang + "-" + nam;
    //});
    //
    //$('#date-picker-xsmn, #mobi-picker-xsmn').on('changeDate', function (e) {
    //    var ngay = e.date.getDate('getDate');
    //    if (ngay < 10) ngay = '0' + ngay;
    //    var thang = e.date.getMonth('getMonth') + 1;
    //    if (thang < 10) thang = '0' + thang;
    //    var nam = e.date.getFullYear('getFullYear');
    //    window.location = document.location.origin + '/xsmn-' + ngay + "-" + thang + "-" + nam;
    //});
    //
    //$('#datepicker, #mb-datepicker').datepicker({
    //    autoclose: true,
    //    format: "dd/mm/yyyy",
    //    immediateUpdates: true,
    //    todayBtn: true,
    //    todayHighlight: true,
    //    language: 'vi',
    //    defaultDate:'now'
    //
    //});

    //$('input[name="start_date"], input[name="end_date"]').datepicker({
    //    autoclose: true,
    //    format: "dd/mm/yyyy",
    //    immediateUpdates: true,
    //    endDate: '+0d',
    //    todayBtn: true,
    //    todayHighlight: true,
    //    language: 'vi',
    //    defaultDate:'now'
    //
    //});

    //$('input[name="end_date"]').datepicker("setDate", new Date());


    $('.tbl-bangdb td, .bangdbn td').click(function() {
        $(this).toggleClass('active');

    });


    $('.s-form label').click(function() {
        val = $(this).data('val');
        selector = $('.'+val);
        $('.switch').on('change', function() {
            var t = $(this).find('input:checked').val();
            if(t) {
                $(selector).addClass('show');
            } else {
                $(selector).removeClass('show');

            }
        });
    });
    $('.s-form label').each(function() {
        var val = $(this).find('input:checked').parent('label').data('val');
        console.log(val);
        selector = $('.'+val);
        $(selector).addClass('show');



    });



    $('.ico-datepicker').click(function() {
        $('.dropdown-datepicker').toggleClass('active');
    });

    $('body').on('click', '.digital-num label', function () {
        var t = $(this).data('val');
        var elementNumbers = $(this).closest('.kqsx').find('.txt-giai');
        switch(t) {
            case 0:
                $(elementNumbers).each(function () {
                    var v = $(this).attr('data-id');
                    $(this).text(v);
                });
                break;

            case 2:
                $(elementNumbers).each(function () {
                    var v = $(this).attr('data-id');
                    $(this).text(v.slice(-2));
                });
                break;

            case 3:
                $(elementNumbers).each(function () {
                    var v = $(this).attr('data-id');
                    $(this).text(v.slice(-3));
                });
                break;

            default:
                break;


        }

    });


    $('#read-more').click(function() {
        var limit = 9;
        $(this).toggleClass('expanded');
        $(this).text($(this).hasClass('expanded') ? 'Thu gọn' : 'Xem thêm');
        var button = $(this);
        var select =  $(this).parent().parent().find('table tr');
        console.log(select);
        if($(button).hasClass('expanded')){
            $(select).show();
        } else {
            $(select).each(function(index) {
                if(index > limit) {
                    $(this).hide();
                }
            });
        }

        $('html, body').animate({
            scrollTop: select.offset().top
        }, 0);


    });


}); 