var d = new Date();
var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
var currentdate = new Date(utc + (3600000 * +7));
var hours = currentdate.getHours();
var minute = currentdate.getMinutes();

// miền bắc
if (hours < 18) {
    $('.live_mb .icon').hide();
    $('.live_mb .icon_w').show();
} else if (hours == 18) {
    if (minute >= 10 && minute <= 40) {
        $('.live_mb .icon').hide();
        $('.live_mb .icon_live').show();
    } else if (minute > 40) {
        $('.live_mb .icon').hide();
        $('.live_mb .icon_done').show();
    } else {
        $('.live_mb .icon').hide();
        $('.live_mb .icon_w').show();
    }
} else if (hours > 18) {
    $('.live_mb .icon').hide();
    $('.live_mb .icon_done').show();
}

// miền trung
if (hours < 17) {
    $('.live_mt .icon').hide();
    $('.live_mt .icon_w').show();
} else if (hours == 17) {
    if (minute >= 10 && minute <= 40) {
        $('.live_mt .icon').hide();
        $('.live_mt .icon_live').show();
    } else if (minute > 40) {
        $('.live_mt .icon').hide();
        $('.live_mt .icon_done').show();
    } else {
        $('.live_mt .icon').hide();
        $('.live_mt .icon_w').show();
    }
} else if (hours > 17) {
    $('.live_mt .icon').hide();
    $('.live_mt .icon_done').show();
}

//  miền nam
if (hours < 16) {
    $('.live_mn .icon').hide();
    $('.live_mn .icon_w').show();
} else if (hours == 16) {
    if (minute >= 10 && minute <= 40) {
        $('.live_mn .icon').hide();
        $('.live_mn .icon_live').show();
    } else if (minute > 40) {
        $('.live_mn .icon').hide();
        $('.live_mn .icon_done').show();
    } else {
        $('.live_mn .icon').hide();
        $('.live_mn .icon_w').show();
    }

} else if (hours > 16) {
    $('.live_mn .icon').hide();
    $('.live_mn .icon_done').show();
}
