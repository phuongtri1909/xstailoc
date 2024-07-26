<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Frontend\RSSController;
use App\Http\Controllers\Craw\CrawXSMBController;
use App\Http\Controllers\Craw\CrawXSMNController;
use App\Http\Controllers\Craw\CrawXSMTController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\SomoController;
use App\Http\Controllers\Frontend\XsmbController;
use App\Http\Controllers\Frontend\XsmnController;
use App\Http\Controllers\Frontend\XsmtController;
use App\Http\Controllers\Craw\CrawMax3DController;
use App\Http\Controllers\Frontend\EmbedController;
use App\Http\Controllers\Frontend\LotoMBController;
use App\Http\Controllers\Frontend\LotoMNController;
use App\Http\Controllers\Frontend\LotoMTController;
use App\Http\Controllers\Frontend\SoicauController;
use App\Http\Controllers\Frontend\XsTinhController;
use App\Http\Controllers\Frontend\TaoPhoiController;
use App\Http\Controllers\Frontend\ThongkeController;
use App\Http\Controllers\Craw\CrawDienToanController;
use App\Http\Controllers\Frontend\DienToanController;
use App\Http\Controllers\Frontend\SoiCauDeController;
use App\Http\Controllers\Frontend\SoicauTNController;
use App\Http\Controllers\Frontend\VietlottController;
use App\Http\Controllers\Frontend\QuayThuXSController;
use App\Http\Controllers\Frontend\SoDauDuoiController;
use App\Http\Controllers\Frontend\DuDoanXoSoController;
use App\Http\Controllers\Frontend\SoiCauDeTNController;
use App\Http\Controllers\Frontend\SoicauGiai7Controller;
use App\Http\Controllers\Frontend\ThongKeNhanhController;
use App\Http\Controllers\Frontend\EmbedVietlottController;

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('get-mega645', [CrawMax3DController::class, 'getMega645']);
Route::get('get-power655', [CrawMax3DController::class, 'getPower655']);

Route::get('get-xsmn', [CrawXSMNController::class, 'getAll']);
Route::get('get-xsmt', [CrawXSMTController::class, 'getAll']);
Route::get('get-xsmb', [CrawXSMBController::class, 'getAll']);

Route::get('get-xsmb-kq8', [CrawXSMBController::class, 'getKQKetQua8']);
Route::get('get-xsmt-kq8', [CrawXSMTController::class, 'getKQKetQua8']);
Route::get('get-xsmn-kq8', [CrawXSMNController::class, 'getKQKetQua8']);

Route::get('get-dienToan636', [CrawDienToanController::class, 'dienToan636']);
Route::get('get-dienToan123', [CrawDienToanController::class, 'dienToan123']);
Route::get('get-thanTai4', [CrawDienToanController::class, 'thanTai4']);

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    return "Cache is cleared";
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(RSSController::class)->group(function () {
	Route::get('rss','rssIndex')->name('rss.rssIndex');
    Route::get('rss/du-doan-xsmb','rssDuDoanXSMB')->name('rss.dudoanxsmb');
	Route::get('rss/du-doan-xsmn','rssDuDoanXSMN')->name('rss.dudoanxsmn');
    Route::get('rss/du-doan-xsmt','rssDuDoanXSMT')->name('rss.dudoanxsmt');
	Route::get('rss/tin-tuc-xo-so','rssNew')->name('rss.rssnew');
});

Route::controller(EmbedVietlottController::class)->group(function () {
    Route::get('embed/mega645','mega645');
    Route::get('embed/power655','power655');

    Route::get('embed/mega645/{date}','mega645_Date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$');
    Route::get('embed/power655/{date}','power655_Date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$');
});


Route::controller(EmbedController::class)->group(function () {
    Route::get('ma-nhung','getMaNhung')->name('ma-nhung');
    Route::post('ma-nhung-ajax','getMaNhung_Ajax')->name('ma-nhung-ajax');
    Route::get('ma-nhung-ajax', function () {
        return abort(404);
    })->name('ma-nhung-ajax.get');

    Route::get('embed/kq-{slug}/{date}','getXsEmbed_Tinh_Date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$')->name('embed.tinh.date');
    Route::get('embed/kq-{slug}','getXsEmbed_Tinh')->name('embed.tinh');

    Route::get('embed/xsmb','getXsmbEmbed')->name('embed.xsmb');
    Route::get('embed/xsmn','getXsmnEmbed')->name('embed.xsmn');
    Route::get('embed/xsmt','getXsmtEmbed')->name('embed.xsmt');

    Route::get('embed/xsmb/{date}','getXsmbEmbed_Date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$')->name('embed.xsmb.date');
    Route::get('embed/xsmn/{date}','getXsmnEmbed_Date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$')->name('embed.xsmn.date');
    Route::get('embed/xsmt/{date}','getXsmtEmbed_Date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$')->name('embed.xsmt.date');
});

Route::controller(VietlottController::class)->group(function () {
    Route::get('xs-vietlott-xo-so-vietlott','index')->name('vietlott');

    Route::get('xs-mega-xo-so-mega-645','getMega')->name('mega645');
    Route::post('xs-mega-xem-them','getMegaXemThem')->name('mega645.xem_them');
    Route::get('xs-power-xo-so-power-655','getPower')->name('power655');
    Route::post('xs-power-xem-them','getPowerXemThem')->name('power655.xem_them');


    Route::get('mega645-ajax','mega645_ajax')->name('mega645_ajax');
    Route::get('power655-ajax','power655_ajax')->name('power655_ajax');
});

// XSMB
Route::controller(XsmbController::class)->group(function () {
    Route::get('xsmb-xo-so-mien-bac', 'getXsmb')->name('xsmb');
    Route::post('xsmb-xem-them', 'getXsmbXemThem')->name('xsmb.xem_them');
    Route::post('xsmb-xem-them-theo-thu', 'getXsmbXemThemTheoThu')->name('xsmb.xem_them_theo_thu');
    Route::get('xsmb-truc-tiep-xo-so-mien-bac', 'xsmb.truc_tiep')->name('XsmbController@getXsmbTrucTiep');
    Route::get('xsmb-thu-2', 'getXsmbThu2')->name('xsmb.thu_2');
    Route::get('xsmb-thu-3', 'getXsmbThu3')->name('xsmb.thu_3');
    Route::get('xsmb-thu-4', 'getXsmbThu4')->name('xsmb.thu_4');
    Route::get('xsmb-thu-5', 'getXsmbThu5')->name('xsmb.thu_5');
    Route::get('xsmb-thu-6', 'getXsmbThu6')->name('xsmb.thu_6');
    Route::get('xsmb-thu-7', 'getXsmbThu7')->name('xsmb.thu_7');
    Route::get('xsmb-chu-nhat', 'getXsmbCN')->name('xsmb.cn');
    Route::get('xsmb-kq-new', 'getKQXsmbNew')->name('xsmb.kq_new');
    Route::get('so-ket-qua', 'getSKQ')->name('xsmb.skq');
    Route::get('xsmb-{n}-ngay', 'getXsmbNgay')->whereIn('n', ['60', '90', '100', '120', '200'])->name('xsmb.ngay');
    Route::post('so-ket-qua', 'postSKQ')->name('skq');
    Route::get('xsmb-{date}', 'getXsmbDate')->name('xsmb.date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$');
});

Route::controller(XsmtController::class)->group(function () {
    Route::get('xsmt-xo-so-mien-trung', 'getXsmt')->name('xsmt');
    Route::post('xsmt-xem-them', 'getXsmtXemThem')->name('xsmt.xem_them');
    Route::post('xsmt-xem-them-theo-thu', 'getXsmtXemThemTheoThu')->name('xsmt.xem_them_theo_thu');
    Route::get('xsmt-thu-2', 'getXsmtThu2')->name('xsmt.thu_2');
    Route::get('xsmt-thu-3', 'getXsmtThu3')->name('xsmt.thu_3');
    Route::get('xsmt-thu-4', 'getXsmtThu4')->name('xsmt.thu_4');
    Route::get('xsmt-thu-5', 'getXsmtThu5')->name('xsmt.thu_5');
    Route::get('xsmt-thu-6', 'getXsmtThu6')->name('xsmt.thu_6');
    Route::get('xsmt-thu-7', 'getXsmtThu7')->name('xsmt.thu_7');
    Route::get('xsmt-chu-nhat', 'getXsmtCN')->name('xsmt.cn');
    Route::get('xsmt-kq-new', 'getKQXsmtNew')->name('xsmt.kq_new');
    Route::get('so-ket-qua-mien-trung', 'getSKQ')->name('xsmt.skq');
    Route::get('xsmt-{n}-ngay', 'getXsmtNgay')->whereIn('n', ['60', '90', '100', '120', '200'])->name('xsmt.ngay');
    Route::get('xsmt-{date}', 'getXsmtDate')->name('xsmt.date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$');
});


Route::controller(XsmnController::class)->group(function () {
    Route::get('xsmn-xo-so-mien-nam', 'getXsmn')->name('xsmn');
    Route::post('xsmn-xem-them', 'getXsmnXemThem')->name('xsmn.xem_them');
    Route::post('xsmn-xem-them-theo-thu', 'getXsmnXemThemTheoThu')->name('xsmn.xem_them_theo_thu');
    Route::get('xsmn-thu-2', 'getXsmnThu2')->name('xsmn.thu_2');
    Route::get('xsmn-thu-3', 'getXsmnThu3')->name('xsmn.thu_3');
    Route::get('xsmn-thu-4', 'getXsmnThu4')->name('xsmn.thu_4');
    Route::get('xsmn-thu-5', 'getXsmnThu5')->name('xsmn.thu_5');
    Route::get('xsmn-thu-6', 'getXsmnThu6')->name('xsmn.thu_6');
    Route::get('xsmn-thu-7', 'getXsmnThu7')->name('xsmn.thu_7');
    Route::get('xsmn-chu-nhat', 'getXsmnCN')->name('xsmn.cn');
    Route::get('xsmn-kq-new', 'getKQXsmnNew')->name('xsmn.kq_new');
    Route::get('so-ket-qua-mien-nam', 'getSKQ')->name('xsmn.skq');
    Route::get('xsmn-{n}-ngay', 'getXsmnNgay')->whereIn('n', ['60', '90', '100', '120', '200'])->name('xsmn.ngay');
    Route::get('xsmn-{date}', 'getXsmnDate')->name('xsmn.date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$');
});

Route::controller(XsTinhController::class)->group(function () {
    Route::get('xs{short_name}-{date}','getXsTinhTheoNgay')->name('xstinh.date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$');
    Route::get('xs{slug}','getXsTinh')->name('xstinh.tinh');
    Route::post('xstinh-xsmb-xem_them','getXsmbXemThem')->name('xstinh.xsmb.xem_them');
    Route::post('xstinh-xsmn-xem_them','getXsmnXemThem')->name('xstinh.xsmn.xem_them');
    Route::post('xstinh-xsmt-xem_them','getXsmtXemThem')->name('xstinh.xsmt.xem_them');
});

Route::controller(LotoMBController::class)->group(function () {
    Route::get('lo-to-mien-bac','getXsmb')->name('loto.mb');
    Route::post('lo-to-mien-bac-xem-them', 'getXsmbXemThem')->name('loto.mb.xem-them');
    Route::get('lo-to-mien-bac-{thu}', 'getXsmbThu')->name('loto.mb.thu');
    Route::post('lo-to-mien-bac-theo-thu-xem-them', 'getXsmbXemThemTheoThu')->name('loto.mb.thu.xem-them');
});

Route::controller(LotoMNController::class)->group(function () {
    Route::get('lo-to-mien-nam','getXsmn')->name('loto.mn');
    Route::post('lo-to-mien-nam-xem-them','getXsmnXemThem')->name('loto.mn.xem-them');
    Route::get('lo-to-mien-nam-{thu}','getXsmnThu')->name('loto.mn.thu');
    Route::post('lo-to-mien-nam-theo-thu-xem-them','getXsmnXemThemTheoThu')->name('loto.mn.thu.xem-them');
});

Route::controller(LotoMTController::class)->group(function () {
    Route::get('lo-to-mien-trung','getXsmt')->name('loto.mt');
    Route::post('lo-to-mien-trung-xem-them','getXsmtXemThem')->name('loto.mt.xem-them');
    Route::get('lo-to-mien-trung-{thu}','getXsmtThu')->name('loto.mt.thu');
    Route::post('lo-to-mien-trung-theo-thu-xem-them','getXsmtXemThemTheoThu')->name('loto.mt.thu.xem-them');
});

Route::controller(ThongkeController::class)->group(function () {
    Route::get('bang-dac-biet-tuan','getTKDacBietTuan')->name('tk.dac-biet-tuan');
    Route::post('dac-biet-tuan-ajax','getTKDacBietTuan_Ajax')->name('tk.dac-biet-tuan-ajax');
    Route::get('dac-biet-tuan-ajax', function () {
        return abort(404);
    });
    Route::get('bang-dac-biet-thang','getTKDacBietThang')->name('tk.dac-biet-thang');
    Route::post('dac-biet-thang-ajax','getTKDacBietThang_Ajax')->name('tk.dac-biet-thang-ajax');
    Route::get('dac-biet-thang-ajax', function () {
        return abort(404);
    });
    Route::get('bang-dac-biet-nam','getTKDacBietNam')->name('tk.dac-biet-nam');
    Route::post('dac-biet-nam-ajax','getTKDacBietNam_Ajax')->name('tk.dac-biet-nam-ajax');
    Route::get('dac-biet-nam-ajax', function () {
        return abort(404);
    });

    Route::get('lo-gan-mien-nam','getTKLoGanMN')->name('tk.lo-gan-mn');
    Route::get('lo-gan-mien-trung','getTKLoGanMT')->name('tk.lo-gan-mt');
    Route::get('lo-gan-xs{short_name}','getTKLoGan')->name('tk.lo-gan');
    Route::get('get-bang-kq','getTKLoGan_BangKQ')->name('tk.bang-kq');
    Route::post('lo-gan-ajax','getTKLoGan_Ajax')->name('tk.lo-gan-ajax');
    Route::get('lo-gan-ajax', function () {
        return abort(404);
    });

    // chưa up
    Route::get('thong-ke-chu-ky-dac-biet-xs{short_name}','getTKChuKyDacBiet')->name('tk.chu-ky-dac-biet');
    Route::post('thong-ke-chu-ky-dac-biet-ajax','getTKChuKyDacBiet_Ajax')->name('tk.chu-ky-dac-biet-ajax');

    // Route::get('thong-ke-chu-ky-loto-xs{short_name}','getTKChuKyLoto')->name('tk.chu-ky-loto');
    Route::post('thong-ke-chu-ky-loto-ajax','getTKChuKyLoto_Ajax')->name('tk.chu-ky-loto-ajax');

    Route::get('thong-ke-dau-duoi-loto-xs{short_name}','getTKLoDauDuoi')->name('tk.dau-duoi-loto');
    Route::post('thong-ke-dau-duoi-loto-ajax','getTKLoDauDuoi_Ajax')->name('tk.dau-duoi-loto-ajax');
    Route::get('thong-ke-dau-duoi-loto-ajax', function () {
        return abort(404);
    });

    // Route::get('thong-ke-chu-ky-dan-loto-xs{short_name}','getTKChuKyDanLoTo')->name('tk.chu-ky-dan-loto');
    Route::post('thong-ke-chu-ky-dan-loto-ajax','getTKChuKyDanLoTo_Ajax')->name('tk.chu-ky-dan-loto-ajax');

    Route::get('thong-ke-chu-ky-dan-dac-biet-xs{short_name}','getTKChuKyDanDacBiet')->name('tk.chu-ky-dan-dac-biet');
    Route::post('thong-ke-chu-ky-dan-dac-biet-ajax','getTKChuKyDanDacBiet_Ajax')->name('tk.chu-ky-dan-dac-biet-ajax');

    Route::get('tan-suat-lo-to-theo-cap-xs{short_name}','getTKTanSuatTheoCap')->name('tk.tan-suat-lo-to-theo-cap');
    Route::post('tan-suat-lo-to-theo-cap-ajax','getTKTanSuatTheoCap_Ajax')->name('tk.tan-suat-lo-to-theo-cap-ajax');

    Route::get('tan-suat-giai-dac-biet-xs{short_name}','getTKTanSuatGiaiDB')->name('tk.tan-suat-giai-dac-biet');
    Route::post('tan-suat-giai-dac-biet-ajax','getTKTanSuatGiaiDB_Ajax')->name('tk.tan-suat-giai-dac-biet-ajax');

    Route::get('tan-suat-loto-roi-xs{short_name}','getTKTanSuatLoRoi')->name('tk.tan-suat-loto-roi');
    Route::post('tan-suat-loto-roi-ajax','getTKTanSuatLoRoi_Ajax')->name('tk.tan-suat-loto-roi-ajax');

});

Route::controller(SoicauController::class)->group(function () {
    Route::get('cau-bach-thu-xsmb','getCauBachThu')->name('scmb.cau-bach-thu');
    Route::post('cau-bach-thu-xsmb-ajax','getCauBachThu_Ajax')->name('scmb.cau-bach-thu-ajax');

    Route::get('cau-loto-xsmb','getCauLoto')->name('scmb.cau-loto');
    Route::post('cau-loto-xsmb-ajax','getCauLoto_Ajax')->name('scmb.cau-loto-ajax');

    Route::get('cau-loto-2-nhay-xsmb','getCauLoto2Nhay')->name('scmb.cau-loto-2nhay');
    Route::post('cau-loto-2nhay-xsmb-ajax','getCauLoto2Nhay_Ajax')->name('scmb.cau-loto-2nhay-ajax');
    Route::get('cau-loto-2nhay-xsmb-ajax', function () {
        return abort(404);
    })->name('scmb.cau-loto-2nhay-ajax.get');

    Route::get('soi-cau-theo-thu','getCauTheoThu')->name('scmb.cau-thu');
    Route::post('soi-cau-theo-thu-mb-ajax','getCauTheoThu_Ajax')->name('scmb.cau-thu-ajax');
    Route::get('soi-cau-theo-thu-mb-ajax', function () {
        return abort(404);
    });

    Route::get('cau-truot-xsmb','getCauTruot')->name('scmb.cau-truot');
    Route::post('cau-truot-xsmb-ajax','getCauTruot_Ajax')->name('scmb.cau-truot-ajax');
});

Route::controller(SoicauTNController::class)->group(function () {
    Route::get('cau-bach-thu-xs{short_name}','getCauBachThuTN')->name('sctn.cau-bach-thu');
    Route::post('cau-bach-thu-tn-ajax','getCauBachThuTN_Ajax')->name('sctn.cau-bach-thu-ajax');
    Route::get('cau-bach-thu-tn-ajax', function () {
        return abort(404);
    })->name('sctn.cau-bach-thu-ajax.get');

    Route::get('cau-loto-xs{short_name}','getCauLotoTN')->name('sctn.cau-loto');
    Route::post('cau-loto-tn-ajax','getCauLotoTN_Ajax')->name('sctn.cau-loto-ajax');

    Route::get('cau-loto-2-nhay-xs{short_name}','getCauLoto2NhayTN')->name('sctn.cau-loto-2nhay');
    Route::post('cau-loto-2nhay-tn-ajax','getCauLoto2NhayTN_Ajax')->name('sctn.cau-loto-2nhay-ajax');

    Route::get('cau-loai-bach-thu-xs{short_name}','getCauLoaiBTTN')->name('sctn.loai-bach-thu');
    Route::post('cau-loai-bach-thu-tn-ajax','getCauLoaiBTTN_Ajax')->name('sctn.loai-bach-thu-ajax');

    Route::get('cau-loai-loto-xs{short_name}','getCauLoaiLotoTN')->name('sctn.loai-loto');
    Route::post('cau-loai-loto-tn-ajax','getCauLoaiLotoTN_Ajax')->name('sctn.loai-loto-ajax');

    Route::get('cau-theo-thu-xs{short_name}','getCauTheoThuTN')->name('sctn.cau-thu');
    Route::post('cau-theo-thu-tn-ajax','getCauTheoThuTN_Ajax')->name('sctn.cau-thu-ajax');
    Route::get('cau-theo-thu-tn-ajax', function () {
        return abort(404);
    });

    Route::get('cau-truot-xs{short_name}','getCauTruotTN')->name('sctn.cau-truot');
    Route::post('cau-truot-tn-ajax','getCauTruotTN_Ajax')->name('sctn.cau-truot-ajax');
    Route::get('cau-truot-tn-ajax', function () {
        return abort(404);
    })->name('sctn.cau-truot-ajax.get');
});


Route::controller(ThongKeNhanhController::class)->group(function () {
    Route::get('thong-ke-nhanh','getTKNhanh')->name('tk.thong-ke-nhanh');
    Route::post('thong-ke-nhanh-ajax','getTKNhanh_Ajax')->name('tk.thong-ke-nhanh-ajax');
    Route::get('thong-ke-nhanh-ajax', function () {
        return abort(404);
    });
});

Route::controller(QuayThuXSController::class)->group(function () {
    Route::get('quay-thu-xo-so-mien-bac','getQuayThuMB')->name('quay_thu.mb');
    Route::get('quay-thu-xo-so-mien-nam','getQuayThuMN')->name('quay_thu.mn');
    Route::get('quay-thu-xo-so-mien-trung','getQuayThuMT')->name('quay_thu.mt');
    Route::get('quay-thu-xs{slug}','getQuayThuTheoTinh')->name('quay_thu.tinh');
});

Route::controller(DienToanController::class)->group(function () {
    Route::get('xo-so-dien-toan-6x36','getDienToan6x36')->name('dientoan6x36');
    Route::get('xo-so-dien-toan-123','getDienToan123')->name('dientoan123');
    Route::get('xo-so-than-tai','getXsThanTai')->name('xsthantai');
});

Route::controller(DuDoanXoSoController::class)->group(function () {
    Route::get('taodd','taodd')->name('dudoan.taodd');
    Route::get('du-doan-xsmb','getDuDoanXSMB')->name('dudoan.xsmb');
    Route::get('du-doan-xsmb-xem-them','getDuDoanXSMBXemThem')->name('dudoan.xsmb.xemthem');
    Route::get('du-doan-xsmn','getDuDoanXSMN')->name('dudoan.xsmn');
    Route::get('du-doan-xsmn-xem-them','getDuDoanXSMNXemThem')->name('dudoan.xsmn.xemthem');
    Route::get('du-doan-xsmt','getDuDoanXSMT')->name('dudoan.xsmt');
    Route::get('du-doan-xsmt-xem-them','getDuDoanXSMTXemThem')->name('dudoan.xsmt.xemthem');
    Route::get('du-doan-xsmb-{date}','getDuDoanXSMBTheoNgay')->name('dudoan.xsmb.date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$');
    Route::get('du-doan-xsmn-{date}','getDuDoanXSMNTheoNgay')->name('dudoan.xsmn.date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$');
    Route::get('du-doan-xsmt-{date}','getDuDoanXSMTTheoNgay')->name('dudoan.xsmt.date')->where('date', '^([0-9]{2}-[0-9]{2}-[0-9]{4})$');
});

Route::controller(SoDauDuoiController::class)->group(function () {
    Route::get('so-dau-duoi-xsmb','SoDauDuoiXSMB')->name('sodauduoi.xsmb');
    Route::post('so-dau-duoi-xsmb-xem-them','SoDauDuoiXSMB_XT')->name('sodauduoi.xsmb.xem_them');
    Route::get('so-dau-duoi-xsmb-xem-them', function () {
        return abort(404);
    })->name('sodauduoi.xsmb.xem_them.get');
    Route::get('so-dau-duoi-xsmt','SoDauDuoiXSMT')->name('sodauduoi.xsmt');
    Route::post('so-dau-duoi-xsmt-xem-them', 'SoDauDuoiXSMT_XT')->name('sodauduoi.xsmt.xem_them.post');
    Route::get('so-dau-duoi-xsmt-xem-them', function () {
        return abort(404);
    })->name('sodauduoi.xsmt.xem_them.get');
    Route::get('so-dau-duoi-xsmn','SoDauDuoiXSMN')->name('sodauduoi.xsmn');
    Route::post('so-dau-duoi-xsmn-xem-them','SoDauDuoiXSMN_XT')->name('sodauduoi.xsmn.xem_them');
    Route::get('so-dau-duoi-xsmn-xem-them', function () {
        return abort(404);
    })->name('sodauduoi.xsmn.xem_them.get');
});

Route::controller(SomoController::class)->group(function () {
    Route::get('so-mo','getSomo')->name('somo');
    Route::post('so-mo-ajax','getSomo_Ajax')->name('somo-ajax');
    Route::get('so-mo-ajax', function () {
        return abort(404);
    })->name('somo-ajax.get');
    Route::post('so-mo-xem-them','getSomonewXemThem')->name('somonew.xem_them');
    Route::get('/so-mo/{slug}','getDetail')->name('somonew.detail');
});


Route::controller(NewsController::class)->group(function () {
    Route::get('tin-tuc-xo-so','listNews')->name('news.list');
    Route::get('/tin-tuc/{slug}','post')->name('news.post');
});




