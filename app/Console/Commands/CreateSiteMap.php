<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use URL;
use App;
use File;
use App\Models\Province;
use App\Models\Lottery;
use App\Models\Post;
use App\Models\GiaiMaGiacMo;
use App\Models\KinhNghiemLoDe;

class CreateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sitemap = \App::make('sitemap');
// add home pages mặc định
        $sitemap->add(URL::to('/'), \Carbon\Carbon::now(), '1.0', 'daily');

// add bài viết
        $sitemap->add(route('xsmb'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.thu_2'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.thu_3'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.thu_4'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.thu_5'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.thu_6'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.thu_7'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.cn'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.ngay', 30), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.ngay', 10), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.ngay', 60), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.ngay', 90), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmb.ngay', 100), \Carbon\Carbon::now(), '0.6', 'daily');

        $sitemap->add(route('xsmn'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.thu_2'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.thu_3'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.thu_4'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.thu_5'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.thu_6'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.thu_7'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.cn'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.ngay', 30), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.ngay', 10), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.ngay', 60), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.ngay', 90), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmn.ngay', 100), \Carbon\Carbon::now(), '0.6', 'daily');

        $sitemap->add(route('xsmt'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.thu_2'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.thu_3'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.thu_4'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.thu_5'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.thu_6'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.thu_7'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.cn'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.ngay', 30), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.ngay', 10), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.ngay', 60), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.ngay', 90), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('xsmt.ngay', 100), \Carbon\Carbon::now(), '0.6', 'daily');

        $sitemap->add(route('scv.soi-cau-lo-vip'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.rong-bach-kim'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-24h'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-888'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-366'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-3-cang'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-win2888'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.rong-bach-kim-666'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.lo-top'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-666'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-7777'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-wap'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-3-mien'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.lo-dep-hom-nay'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-vip-4'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-du-doan-xsmb-chinh-xac-100'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.dan-de-bat-tu-mien-bac'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.nuoi-lo-khung-xsmb'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-doc-thu-de'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.soi-cau-song-thu-de'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.dan-de-10-so'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.nuoi-dan-de-20'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scv.dan-de-36'), \Carbon\Carbon::now(), '0.6', 'daily');

        $sitemap->add(route('schn.xsmb'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('schn.xsmn'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('schn.xsmt'), \Carbon\Carbon::now(), '0.6', 'daily');

        $sitemap->add(route('dudoan.xsmb'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('dudoan.xsmn'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('dudoan.xsmt'), \Carbon\Carbon::now(), '0.6', 'daily');

        $sitemap->add(route('scmb.cau-bach-thu'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scmb.cau-lat-lt'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scmb.cau-ca-cap'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scmb.cau-nhieu-nhay'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scmb.cau-mien-nam'), \Carbon\Carbon::now(), '0.6', 'daily');
        $sitemap->add(route('scmb.cau-mien-trung'), \Carbon\Carbon::now(), '0.6', 'daily');

//        $sitemap->add(route('tklo.lo-gan','mb'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('tklo.lo-xien','mb'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('tklo.lo-kep','mb'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('tklo.dauduoi','mb'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('tklo.tong','mb'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('tk.dac-biet','mb'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('tklo.chu-ky','mb'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('tklo.dac-biet-tuan','mb'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('tklo.dac-biet-tuan','mb'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('tklo.dac-biet-thang'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('tklo.dac-biet-nam'), \Carbon\Carbon::now(), '0.6', 'daily');

//        $sitemap->add(route('quay_thu'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('quay_thu.mb'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('quay_thu.mn'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('quay_thu.mt'), \Carbon\Carbon::now(), '0.6', 'daily');

//        $sitemap->add(route('xstinh.all-tinh'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('invedo'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('doveso'), \Carbon\Carbon::now(), '0.6', 'daily');
//        $sitemap->add(route('somo'), \Carbon\Carbon::now(), '0.6', 'daily');


        $provinces = Province::all();
        foreach ($provinces as $province) {
            $sitemap->add(route('xstinh.tinh',$province->slug), \Carbon\Carbon::now(), '0.6', 'daily');
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        foreach ($provinces as $province) {
            $sitemap->add(route('tklo.lo-gan',$province->short_name), \Carbon\Carbon::now(), '0.6', 'daily');
            $sitemap->add(route('tklo.lo-xien',$province->short_name), \Carbon\Carbon::now(), '0.6', 'daily');
            $sitemap->add(route('tklo.lo-kep',$province->short_name), \Carbon\Carbon::now(), '0.6', 'daily');
            $sitemap->add(route('tklo.dauduoi',$province->short_name), \Carbon\Carbon::now(), '0.6', 'daily');
            $sitemap->add(route('tklo.tong',$province->short_name), \Carbon\Carbon::now(), '0.6', 'daily');
            $sitemap->add(route('tk.dac-biet',$province->short_name), \Carbon\Carbon::now(), '0.6', 'daily');
            $sitemap->add(route('tklo.chu-ky',$province->short_name), \Carbon\Carbon::now(), '0.6', 'daily');
            $sitemap->add(route('tklo.dac-biet-tuan',$province->short_name), \Carbon\Carbon::now(), '0.6', 'daily');
            $sitemap->add(route('tklo.dac-biet-tuan',$province->short_name), \Carbon\Carbon::now(), '0.6', 'daily');
         }

        foreach ($provinces as $province) {
            $sitemap->add(route('scmb.sctn',$province->short_name), \Carbon\Carbon::now(), '0.6', 'daily');
        }


        $kqs = Lottery::where('mien',1)->orderBy('date', 'DESC')->get();
        foreach ($kqs as $kq) {
            $sitemap->add(route('xsmb.date',getNgayLink($kq->date)), \Carbon\Carbon::now(), '0.6', 'daily');
        }

        $kqs = Lottery::where('mien',3)->orderBy('date', 'DESC')->select('date','day')->distinct()->get();
        foreach ($kqs as $kq) {
            $sitemap->add(route('xsmn.date',getNgayLink($kq->date)), \Carbon\Carbon::now(), '0.6', 'daily');
        }

        $kqs = Lottery::where('mien',2)->orderBy('date', 'DESC')->select('date','day')->distinct()->get();
        foreach ($kqs as $kq) {
            $sitemap->add(route('xsmt.date',getNgayLink($kq->date)), \Carbon\Carbon::now(), '0.6', 'daily');
        }

        $sitemap->add(route('giaimagiacmo.list'), \Carbon\Carbon::now(), '0.6', 'daily');
        $gmgms = GiaiMaGiacMo::orderBy('id', 'DESC')->get();
        foreach ($gmgms as $item) {
            $sitemap->add(route('giaimagiacmo.post',$item->slug), \Carbon\Carbon::now(), '0.6', 'daily');
        }

        $sitemap->add(route('kinhnghiemlode.list'), \Carbon\Carbon::now(), '0.6', 'daily');
        $gmgms = KinhNghiemLoDe::orderBy('id', 'DESC')->get();
        foreach ($gmgms as $item) {
            $sitemap->add(route('kinhnghiemlode.post',$item->slug), \Carbon\Carbon::now(), '0.6', 'daily');
        }

//        $somos = SoMo::all();
//        foreach ($somos as $somo) {
//            $sitemap->add(route('somo.post',$somo->slug), \Carbon\Carbon::now(), '0.6', 'daily');
//        }

        $kqs = Post::orderBy('date', 'DESC')->get();
        foreach ($kqs as $kq) {
            $sitemap->add($kq->link, \Carbon\Carbon::now(), '0.6', 'daily');

        }


// lưu file và phân quyền
        $sitemap->store('xml', 'sitemap');
        if (File::exists(public_path() . '/sitemap.xml')) {
            chmod(public_path() . '/sitemap.xml', 0777);
        }
    }
}
