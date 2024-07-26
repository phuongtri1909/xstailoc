<?php

namespace App\Http\Controllers\Craw;

use App\Models\Lottery;
use App\Models\Mega645;
use App\Models\Power655;
use App\Models\Max4D;
use App\Models\Post;
use App\Models\Province;
use App\Models\SoMo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CreateMapController extends Controller
{
    public function create()
    {
        set_time_limit(0);
        $dir = dirname(realpath(__FILE__));
        $path = explode(DIRECTORY_SEPARATOR, $dir);
        $data_path_root = '';
        for ($i = 0; $i < count($path); $i++) {
            $data_path_root .= $path[$i] . DIRECTORY_SEPARATOR;
        }
        $data_path_root = str_replace("\app\Http\Controllers\craw",'',$data_path_root);

        $data_path = $data_path_root . '/public/sitemap.xml';
        $myfile = fopen($data_path, 'w');

        $map_str='<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        foreach ($provinces as $province) {
            $map_str .= "<url><loc>" . route('tkcau.sctn',$province->short_name) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }
        $map_str .="</urlset>";
        fwrite($myfile,$map_str);
        fclose($myfile);
        die('Xong!');

        set_time_limit(0);
        echo "<url><loc>" . route('home') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.thu_2') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.thu_3') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.thu_4') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.thu_5') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.thu_6') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.thu_7') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.cn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.ngay', 30) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.ngay', 10) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.ngay', 60) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.ngay', 90) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmb.ngay', 100) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('xsmn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.thu_2') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.thu_3') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.thu_4') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.thu_5') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.thu_6') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.thu_7') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.cn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.ngay', 30) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.ngay', 10) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.ngay', 60) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.ngay', 90) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmn.ngay', 100) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('xsmt') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.thu_2') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.thu_3') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.thu_4') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.thu_5') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.thu_6') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.thu_7') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.cn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.ngay', 30) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.ngay', 10) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.ngay', 60) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.ngay', 90) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmt.ngay', 100) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('vietlott') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmega') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmega.thu_4') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmega.thu_6') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmega.cn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('xspower') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xspower.thu', 3) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xspower.thu', 5) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xspower.thu', 7) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('xsmax4d') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmax4d.thu', 3) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmax4d.thu', 5) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsmax4d.thu', 7) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('dientoan6x36') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('dientoan123') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('xsthantai') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('tkcau') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tkcau.scmb') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('tkcau.cau-bach-thu') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tkcau.cau-lat-lt') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tkcau.cau-ca-cap') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tkcau.cau-nhieu-nhay') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tkcau.cau-mien-nam') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tkcau.cau-mien-trung') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('tklo.lo-gan') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tklo.lo-gan-mn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tklo.lo-gan-mt') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tklo.lo-xien') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tklo.lo-kep') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tklo.lo-dau') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tklo.lo-duoi') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tklo.dac-biet') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tklo.tan-suat') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tklo.00-99') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tklo.chu-ky') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('tkxs') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tkxs.xsmb') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tkxs.xsmn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('tkxs.xsmt') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('loto.mb') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mt') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mb.thu', 'thu-2') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mb.thu', 'thu-3') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mb.thu', 'thu-4') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mb.thu', 'thu-5') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mb.thu', 'thu-6') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mb.thu', 'thu-7') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mb.thu', 'chu-nhat-cn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('loto.mn.thu', 'thu-2') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mn.thu', 'thu-3') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mn.thu', 'thu-4') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mn.thu', 'thu-5') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mn.thu', 'thu-6') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mn.thu', 'thu-7') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mn.thu', 'chu-nhat-cn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('loto.mt.thu', 'thu-2') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mt.thu', 'thu-3') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mt.thu', 'thu-4') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mt.thu', 'thu-5') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mt.thu', 'thu-6') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mt.thu', 'thu-7') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('loto.mt.thu', 'chu-nhat-cn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('quay_thu') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('quay_thu.mb') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('quay_thu.mn') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('quay_thu.mt') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        echo "<url><loc>" . route('xstinh.all-tinh') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('invedo') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('doveso') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        echo "<url><loc>" . route('somo') . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";

        $provinces = Province::all();
        foreach ($provinces as $province) {
            echo "<url><loc>" . route('xstinh.tinh',$province->slug) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        foreach ($provinces as $province) {
            echo "<url><loc>" . route('tkcau.sctn',$province->short_name) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        foreach ($provinces as $province) {
            echo "<url><loc>" . route('quay_thu.tinh',$province->short_name) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        foreach ($provinces as $province) {
            echo "<url><loc>" . route('loto.tinh',$province->slug_sc) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }
    }

    public function create1()
    {
        set_time_limit(0);
        $kqs = Lottery::where('mien',1)->orderBy('date', 'DESC')->get();
         foreach ($kqs as $kq) {
            echo "<url><loc>" . route('xsmb.date',getNgayLink($kq->date)) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }

        $kqs = Lottery::where('mien',3)->orderBy('date', 'DESC')->select('date','day')->distinct()->get();
         foreach ($kqs as $kq) {
            echo "<url><loc>" . route('xsmn.date',getNgayLink($kq->date)) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }

        $kqs = Lottery::where('mien',2)->orderBy('date', 'DESC')->select('date','day')->distinct()->get();
        foreach ($kqs as $kq) {
            echo "<url><loc>" . route('xsmt.date',getNgayLink($kq->date)) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }
    }

    public function create2()
    {
        set_time_limit(0);
        $kqs = Post::orderBy('date', 'DESC')->get();
        foreach ($kqs as $kq) {
            echo "<url><loc>http://ketqua68.x/".$kq->slug."</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }

        $somos = SoMo::all();
        foreach ($somos as $somo) {
            echo "<url><loc>" . route('somo.post',$somo->slug) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }

        $kqs = Mega645::orderBy('date', 'DESC')->get();
        foreach ($kqs as $kq) {
            echo "<url><loc>" . route('xsmega.date',getNgayLink($kq->date)) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }

        $kqs = Power655::orderBy('date', 'DESC')->get();
        foreach ($kqs as $kq) {
            echo "<url><loc>" . route('xspower.date',getNgayLink($kq->date)) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }

        $kqs = Max4D::orderBy('date', 'DESC')->get();
        foreach ($kqs as $kq) {
            echo "<url><loc>" . route('xsmax4d.date',getNgayLink($kq->date)) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
        }
    }

    public function create3()
    {
        set_time_limit(0);
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        foreach ($provinces as $province) {
            $kqs = Lottery::where('province_id',$province->id)->orderBy('date', 'DESC')->select('date','day')->distinct()->get();
            foreach ($kqs as $kq) {
                echo "<url><loc>" . route('xstinh.date',[$province->short_name,getNgayLink($kq->date)]) . "</loc><changefreq>daily</changefreq><priority>0.85</priority></url>";
            }
        }
    }
}
