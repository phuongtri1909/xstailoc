<?php

namespace App\Http\Controllers\Craw;

use App\Models\Lottery;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrawXSMNController extends Controller
{

    public function getAll()
    {
        set_time_limit(0);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date_create();

        while (true) {
            $ngay_quay = date_format($date, "Y-m-d");
            $date_url = date_format($date, "j-n-Y");
            $url = 'https://xoso.mobi/xsmn-' . $date_url . '-ket-qua-xo-so-mien-nam-ngay-' . $date_url . '.html';

//            echo $ngay_quay . '<br/>';
//            echo $date_url . '<br/>';
//            echo $url . '<br/><hr/>';
            $this->getXsmn($url, $ngay_quay);
            date_modify($date, "-1 days");

            if (date_format($date, "Y-m-d") == '2023-10-10') die('Lấy Xong DL');
            // nếu đã lấy kd thì thoát
//            $checks = Lottery::where('date', date_format($date, "Y-m-d"))->where('mien', 3)->get();
//            if (count($checks) > 0) {
//                $checkkq = true;
//                foreach ($checks as $check) {
//                    if ($check->status != 1) $checkkq = false;
//                }
//                if ($checkkq) die('Lấy Xong!');
//            }
        }
    }

    public function getXsmn($url = '', $ngay_quay = '')
    {
        $html = str_get_html(requestvl($url));
        if (empty($html->find('table.colgiai'))) return;
        $count = count($html->find('table.colgiai th'));
        for ($i = 1; $i < $count; $i++) {
            $k = 0;
            $sxmn = array();
            foreach ($html->find('table.colgiai tr') as $tr) {
                if ($k == 0) {
                    $link = trim($tr->find('th', $i)->find('a', 0)->href);
                    $short_name = explode('/', $link);
                    $short_name = $short_name[count($short_name) - 1];
                    $short_name = explode('-', $short_name);
                    $short_name = $short_name[0];
                    $short_name = trim(str_replace('xs', '', $short_name));

                    if ($short_name == 'bt') $short_name = 'btr';
                    if ($short_name == 'qnm') $short_name = 'qna';
                    if ($short_name == 'dng') $short_name = 'dna';

                    $k++;
                    continue;
                }

                // ngày chưa có kết quả thì thoát
                $td = $tr->find('td', $i);
                if ($td === null || empty($td->find('div', 0)->innertext)) {
                    return;
                }

                $g = '';
                foreach ($tr->find('td', $i)->find('div') as $span) {
                    $g .= trim($span->innertext) . '-';
                }
                $sxmn[] = substr($g, 0, strlen($g) - 1);
            }

            $province = Province::where('short_name', $short_name)->first();
            $day = $this->getThu($ngay_quay);

            $status = 1;
            foreach ($sxmn as $item) {
                if (strpos($item, '...') !== false) {
                    $status = 0;
                    break;
                }
            }

            $check = Lottery::where('date', $ngay_quay)->where('province_id', $province->id)->where('mien', 3)->first();
            if (!empty($check)) {
                if ($check->status != 1) {
                    $check->delete();
                } else {
                    continue;
                }
            }
            Lottery::firstOrCreate([
                'gdb' => $sxmn[8],
                'g1' => $sxmn[7],
                'g2' => $sxmn[6],
                'g3' => $sxmn[5],
                'g4' => $sxmn[4],
                'g5' => $sxmn[3],
                'g6' => $sxmn[2],
                'g7' => $sxmn[1],
                'g8' => $sxmn[0],
                'day' => $day,
                'mien' => 3,
                'status' => $status,
                'province_id' => $province->id,
                'date' => $ngay_quay,
            ]);
        }
    }

    public function getThu($date)
    {
        $arr = explode('-', $date);
        $ngay = $arr[2];
        $thang = $arr[1];
        $nam = $arr[0];
        $jd = cal_to_jd(CAL_GREGORIAN, $thang, $ngay, $nam);
        $day = jddayofweek($jd, 0);
        switch ($day) {
            case 0:
                $thu = 8;
                break;
            case 1:
                $thu = 2;
                break;
            case 2:
                $thu = 3;
                break;
            case 3:
                $thu = 4;
                break;
            case 4:
                $thu = 5;
                break;
            case 5:
                $thu = 6;
                break;
            case 6:
                $thu = 7;
                break;
        }
        return $thu;
    }


    public function checkTinh1()
    {
        $str = '<div class="col-center"><div class="content-right bullet"><ul><li><a title="Xổ số An Giang" href="/mien-nam/xsag-ket-qua-xo-so-an-giang-p2.html">An Giang</a>&nbsp;<img class="" src="https://cdn.xoso.me/images/waiting.gif" width="30" height="10" alt="image status" data-src="https://cdn.xoso.me/images/waiting.gif"> </li><li><a title="Xổ số Bình Thuận" href="/mien-nam/xsbth-ket-qua-xo-so-binh-thuan-p7.html">Bình Thuận</a>&nbsp;<img class="" src="https://cdn.xoso.me/images/waiting.gif" width="30" height="10" alt="image status" data-src="https://cdn.xoso.me/images/waiting.gif"> </li><li><a title="Xổ số Tây Ninh" href="/mien-nam/xstn-ket-qua-xo-so-tay-ninh-p18.html">Tây Ninh</a>&nbsp;<img class="" src="https://cdn.xoso.me/images/waiting.gif" width="30" height="10" alt="image status" data-src="https://cdn.xoso.me/images/waiting.gif"> </li><li><a title="Xổ số Cà Mau" href="/mien-nam/xscm-ket-qua-xo-so-ca-mau-p8.html">Cà Mau</a></li><li><a title="Xổ số Đồng Tháp" href="/mien-nam/xsdt-ket-qua-xo-so-dong-thap-p12.html">Đồng Tháp</a></li><li><a title="Xổ số Bạc Liêu" href="/mien-nam/xsbl-ket-qua-xo-so-bac-lieu-p3.html">Bạc Liêu</a></li><li><a title="Xổ số Bến Tre" href="/mien-nam/xsbt-ket-qua-xo-so-ben-tre-p4.html">Bến Tre</a></li><li><a title="Xổ số Vũng Tàu" href="/mien-nam/xsvt-ket-qua-xo-so-vung-tau-p22.html">Vũng Tàu</a></li><li><a title="Xổ số Cần Thơ" href="/mien-nam/xsct-ket-qua-xo-so-can-tho-p9.html">Cần Thơ</a></li><li><a title="Xổ số Đồng Nai" href="/mien-nam/xsdn-ket-qua-xo-so-dong-nai-p11.html">Đồng Nai</a></li><li><a title="Xổ số Sóc Trăng" href="/mien-nam/xsst-ket-qua-xo-so-soc-trang-p17.html">Sóc Trăng</a></li><li><a title="Xổ số Bình Dương" href="/mien-nam/xsbd-ket-qua-xo-so-binh-duong-p5.html">Bình Dương</a></li><li><a title="Xổ số Trà Vinh" href="/mien-nam/xstv-ket-qua-xo-so-tra-vinh-p20.html">Trà Vinh</a></li><li><a title="Xổ số Vĩnh Long" href="/mien-nam/xsvl-ket-qua-xo-so-vinh-long-p21.html">Vĩnh Long</a></li><li><a title="Xổ số Bình Phước" href="/mien-nam/xsbp-ket-qua-xo-so-binh-phuoc-p6.html">Bình Phước</a></li><li><a title="Xổ số Hậu Giang" href="/mien-nam/xshg-ket-qua-xo-so-hau-giang-p13.html">Hậu Giang</a></li><li><a title="Xổ số Long An" href="/mien-nam/xsla-ket-qua-xo-so-long-an-p16.html">Long An</a></li><li><a title="Xổ số Đà Lạt" href="/mien-nam/xsdl-ket-qua-xo-so-da-lat-p10.html">Đà Lạt</a></li><li><a title="Xổ số Kiên Giang" href="/mien-nam/xskg-ket-qua-xo-so-kien-giang-p15.html">Kiên Giang</a></li><li><a title="Xổ số Tiền Giang" href="/mien-nam/xstg-ket-qua-xo-so-tien-giang-p19.html">Tiền Giang</a></li><li><a title="Xổ số TP Hồ Chí Minh" href="/mien-nam/xshcm-ket-qua-xo-so-thanh-pho-ho-chi-minh-p14.html">TP Hồ Chí Minh</a></li></ul></div> <div class="content-right bullet"><ul><li><a title="Xổ số Bình Định" href="/mien-trung/xsbdi-ket-qua-xo-so-binh-dinh-p23.html">Bình Định</a>&nbsp;<img class="" src="https://cdn.xoso.me/images/waiting.gif" width="30" height="10" alt="image status" data-src="https://cdn.xoso.me/images/waiting.gif"> </li><li><a title="Xổ số Quảng Bình" href="/mien-trung/xsqb-ket-qua-xo-so-quang-binh-p32.html">Quảng Bình</a>&nbsp;<img class="" src="https://cdn.xoso.me/images/waiting.gif" width="30" height="10" alt="image status" data-src="https://cdn.xoso.me/images/waiting.gif"> </li><li><a title="Xổ số Quảng Trị" href="/mien-trung/xsqt-ket-qua-xo-so-quang-tri-p35.html">Quảng Trị</a>&nbsp;<img class="" src="https://cdn.xoso.me/images/waiting.gif" width="30" height="10" alt="image status" data-src="https://cdn.xoso.me/images/waiting.gif"> </li><li><a title="Xổ số Phú Yên" href="/mien-trung/xspy-ket-qua-xo-so-phu-yen-p31.html">Phú Yên</a></li><li><a title="Xổ số Đắc Lắc" href="/mien-trung/xsdlk-ket-qua-xo-so-dac-lac-p25.html">Đắc Lắc</a></li><li><a title="Xổ số Quảng Nam" href="/mien-trung/xsqnm-ket-qua-xo-so-quang-nam-p34.html">Quảng Nam</a></li><li><a title="Xổ số Gia Lai" href="/mien-trung/xsgl-ket-qua-xo-so-gia-lai-p27.html">Gia Lai</a></li><li><a title="Xổ số Ninh Thuận" href="/mien-trung/xsnt-ket-qua-xo-so-ninh-thuan-p30.html">Ninh Thuận</a></li><li><a title="Xổ số Đắc Nông" href="/mien-trung/xsdno-ket-qua-xo-so-dac-nong-p26.html">Đắc Nông</a></li><li><a title="Xổ số Quảng Ngãi" href="/mien-trung/xsqng-ket-qua-xo-so-quang-ngai-p33.html">Quảng Ngãi</a></li><li><a title="Xổ số Kon Tum" href="/mien-trung/xskt-ket-qua-xo-so-kon-tum-p29.html">Kon Tum</a></li><li><a title="Xổ số Thừa Thiên Huế" href="/mien-trung/xstth-ket-qua-xo-so-thua-thien-hue-p36.html">Thừa Thiên Huế</a></li><li><a title="Xổ số Đà Nẵng" href="/mien-trung/xsdng-ket-qua-xo-so-da-nang-p24.html">Đà Nẵng</a></li><li><a title="Xổ số Khánh Hòa" href="/mien-trung/xskh-ket-qua-xo-so-khanh-hoa-p28.html">Khánh Hòa</a></li></ul></div></div>';
        $html = str_get_html($str);
        foreach ($html->find('a') as $a) {
            $short_name = explode('/', $a->href);
            $short_name = $short_name[count($short_name) - 1];
            $short_name = explode('-', $short_name);
            $short_name = $short_name[0];
            $short_name = str_replace('xs', '', $short_name);

            if ($short_name == 'bt') $short_name = 'btr';
            if ($short_name == 'qnm') $short_name = 'qna';
            if ($short_name == 'dng') $short_name = 'dna';

            $province = Province::where('short_name', $short_name)->first();

            echo $short_name . '--' . count($province) . '---' . $a->title . '<br/>';
        }
        die();
    }

}
