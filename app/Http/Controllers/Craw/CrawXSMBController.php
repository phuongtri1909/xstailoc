<?php

namespace App\Http\Controllers\Craw;

use App\Models\Lottery;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrawXSMBController extends Controller
{
    public function getReKQ()
    {
        set_time_limit(0);
        $kqs = Lottery::where('mien',1)->where('status',0)->get();
//        $kqs = $products = DB::table('lotteries')
//            ->distinct()
//            ->select('date')
//            ->where('mien', '=', 2)
//            ->where('status', '=', 0)
//            ->groupBy('date')->get();

//        $kqs = DB::table('lotteries')
//            ->distinct()
//            ->select('date','status','mien')
//            ->where('mien',2)
//            ->where('status',0)
//            ->get();
        print_ok($kqs);
        die('Xong!');
    }

    public function getAll()
    {
        set_time_limit(0);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date_create();

        while (true) {
            $ngay_quay = date_format($date, "Y-m-d");
            $date_url = date_format($date, "j-n-Y");
            $url = 'https://xoso.mobi/xsmb-' . $date_url . '-ket-qua-xo-so-mien-bac-ngay-' . $date_url . '.html';

//            echo $ngay_quay.'<br/>';
//            echo $date_url.'<br/>';
//            echo $url.'<br/><hr/>';
            $this->getXsmb($url, $ngay_quay);
            date_modify($date, "-1 days");

            if (date_format($date, "Y-m-d") == '2023-10-10') die('Lấy Xong DL');
            // nếu đã lấy kd thì thoát
//            $check = Lottery::where('date',date_format($date, "Y-m-d"))->where('mien',1)->where('status',1)->first();
//            if(count($check) > 0)  die('Lấy Xong!');
        }
    }

    public function getXsmb($url = '', $ngay_quay = '')
    {
        $html = str_get_html(requestvl($url));


        $sxmb = array();
        if (empty($html->find('table.kqmb'))) return;
        foreach ($html->find('table.kqmb tr') as $tr) {
            $g = '';
            foreach ($tr->find('span') as $span) {
                $g .= trim($span->innertext) . '-';
            }
            $sxmb[] = preg_replace('/\s+/', '', substr($g, 0, strlen($g) - 1));
        }

        if (empty($sxmb[1])) return;

        $day = $this->getThu($ngay_quay);
        // Thứ Hai: xổ số Thủ đô Hà Nội
        if ($day == 2) $province_id = 46;
        // Thứ Ba: xổ số Quảng Ninh
        if ($day == 3) $province_id = 48;
        //Thứ Tư: xổ số Bắc Ninh
        if ($day == 4) $province_id = 49;
        //Thứ Năm: xổ số Thủ đô Hà Nội
        if ($day == 5) $province_id = 46;
        //Thứ Sáu: xổ số Hải Phòng
        if ($day == 6) $province_id = 50;
        //Thứ Bảy: xổ số Nam Định
        if ($day == 7) $province_id = 6;
        //Chủ Nhật: xổ số Thái Bình
        if ($day == 8) $province_id = 47;

//        print_ok([
//            'gdb' => $sxmb[1],
//            'g1' => $sxmb[2],
//            'g2' => $sxmb[3],
//            'g3' => $sxmb[4],
//            'g4' => $sxmb[5],
//            'g5' => $sxmb[6],
//            'g6' => $sxmb[7],
//            'g7' => $sxmb[8],
//            'madb' => $sxmb[0],
//            'day' => $day,
//            'mien' => 1,
//            'status' => 1,
//            'province_id' => $province_id,
//            'date' => $ngay_quay,
//        ]);
//        die();

        $status = 1;
        foreach ($sxmb as $item) {
            if (strpos($item, '...') !== false) {
                $status = 0;
                break;
            }
        }

        $check = Lottery::where('date', $ngay_quay)->where('province_id', $province_id)->where('mien', 1)->first();
        if (!empty($check)) {
            if ($check->status != 1) {
                $check->delete();
            } else {
                return;
            }
        }

        Lottery::firstOrCreate([
            'gdb' => $sxmb[1],
            'g1' => $sxmb[2],
            'g2' => $sxmb[3],
            'g3' => $sxmb[4],
            'g4' => $sxmb[5],
            'g5' => $sxmb[6],
            'g6' => $sxmb[7],
            'g7' => $sxmb[8],
            'madb' => $sxmb[0],
            'day' => $day,
            'mien' => 1,
            'status' => $status,
            'province_id' => $province_id,
            'date' => $ngay_quay,
        ]);
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

    public function getAll2()
    {

        set_time_limit(0);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date_create();

        while (true) {
            $ngay_quay = date_format($date, "Y-m-d");
            $date_url = date_format($date, "j-n-Y");
            $url = 'https://www.minhngoc.net.vn/ket-qua-xo-so/mien-bac/' . $date_url.'.html';

//            echo $ngay_quay.'<br/>';
//            echo $date_url.'<br/>';
//            echo $url.'<br/><hr/>';
            $this->getXsmb($url, $ngay_quay);
            date_modify($date, "-1 days");

            if (date_format($date, "Y-m-d") == '2023-04-01') die('Lấy Xong DL');
            // nếu đã lấy kd thì thoát
//            $check = Lottery::where('date',date_format($date, "Y-m-d"))->where('mien',1)->where('status',1)->first();
//            if(count($check) > 0)  die('Lấy Xong!');
        }
    }

    public function getXsmb2($url = '', $ngay_quay = '')
    {
         $html = str_get_html(requestvl($url));

        $sxmb = array();
        if (count($html->find('table.bkqtinhmienbac')) == 0) return;

        $count_tr = count($html->find('table.bkqtinhmienbac',0)->find('tr'));
        $tr = $html->find('table.bkqtinhmienbac',0)->find('tr');

        for($i=1;$i<$count_tr;$i++){
            $g = '';
            foreach ($tr[$i]->find('td',1)->find('div') as $div) {
                $g .= trim($div->innertext) . '-';
            }

            $sxmb[] = preg_replace('/\s+/', '', substr($g, 0, strlen($g) - 1));
        }
        $sxmb_madb = $html->find('table.bkqtinhmienbac',0)->find('.loaive_content',0)->innertext;

        $day = $this->getThu($ngay_quay);
        // Thứ Hai: xổ số Thủ đô Hà Nội
        if ($day == 2) $province_id = 46;
        // Thứ Ba: xổ số Quảng Ninh
        if ($day == 3) $province_id = 48;
        //Thứ Tư: xổ số Bắc Ninh
        if ($day == 4) $province_id = 49;
        //Thứ Năm: xổ số Thủ đô Hà Nội
        if ($day == 5) $province_id = 46;
        //Thứ Sáu: xổ số Hải Phòng
        if ($day == 6) $province_id = 50;
        //Thứ Bảy: xổ số Nam Định
        if ($day == 7) $province_id = 6;
        //Chủ Nhật: xổ số Thái Bình
        if ($day == 8) $province_id = 47;

//        print_ok([
//            'gdb' => $sxmb[1],
//            'g1' => $sxmb[2],
//            'g2' => $sxmb[3],
//            'g3' => $sxmb[4],
//            'g4' => $sxmb[5],
//            'g5' => $sxmb[6],
//            'g6' => $sxmb[7],
//            'g7' => $sxmb[8],
//            'madb' => $sxmb[0],
//            'day' => $day,
//            'mien' => 1,
//            'status' => 1,
//            'province_id' => $province_id,
//            'date' => $ngay_quay,
//        ]);
//        die();

        $status = 1;
        foreach ($sxmb as $item) {
            if (strpos($item, '...') !== false) {
                $status = 0;
                break;
            }
        }

        $check = Lottery::where('date', $ngay_quay)->where('province_id', $province_id)->where('mien', 1)->first();
        if (count($check) > 0) {
            if ($check->status != 1) {
                $check->delete();
            } else {
                return;
            }
        }

        Lottery::firstOrCreate([
            'gdb' => $sxmb[0],
            'g1' => $sxmb[1],
            'g2' => $sxmb[2],
            'g3' => $sxmb[3],
            'g4' => $sxmb[4],
            'g5' => $sxmb[5],
            'g6' => $sxmb[6],
            'g7' => $sxmb[7],
            'madb' => $sxmb_madb,
            'day' => $day,
            'mien' => 1,
            'status' => $status,
            'province_id' => $province_id,
            'date' => $ngay_quay,
        ]);
    }





    public function getAll_xosodaiphat()
    {
        set_time_limit(0);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date_create("07-08-2022");

        $date_url = '07-08-2022';
        while ($date_url != '09-08-2022') {
            $ngay_quay = date_format($date, "Y-m-d");
            $date_url = date_format($date, "d-m-Y");
            $url = 'https://xosodaiphat.com/xsmb-' . $date_url . '.html';
            $this->getXsmb($url, $ngay_quay);
            date_modify($date, "+1 days");
        }
        die('Xong!');
    }

    public function getXsmb_xosodaiphat($url = '', $ngay_quay = '')
    {
        $html = str_get_html(requestvl($url));
        $sxmb = array();
        if (count($html->find('.table-xsmb')) == 0) return;
        foreach ($html->find('.table-xsmb tr') as $tr) {
            $g = '';
            foreach ($tr->find('span') as $span) {
                $g .= trim($span->innertext) . '-';
            }
            $sxmb[] = substr($g, 0, strlen($g) - 1);
        }

        $day = $this->getThu($ngay_quay);
        // Thứ Hai: xổ số Thủ đô Hà Nội
        if ($day == 2) $province_id = 46;
        // Thứ Ba: xổ số Quảng Ninh
        if ($day == 3) $province_id = 48;
        //Thứ Tư: xổ số Bắc Ninh
        if ($day == 4) $province_id = 49;
        //Thứ Năm: xổ số Thủ đô Hà Nội
        if ($day == 5) $province_id = 46;
        //Thứ Sáu: xổ số Hải Phòng
        if ($day == 6) $province_id = 50;
        //Thứ Bảy: xổ số Nam Định
        if ($day == 7) $province_id = 6;
        //Chủ Nhật: xổ số Thái Bình
        if ($day == 8) $province_id = 47;
//        print_ok([
//            'gdb' => $sxmb[1],
//            'g1' => $sxmb[2],
//            'g2' => $sxmb[3],
//            'g3' => $sxmb[4],
//            'g4' => $sxmb[5],
//            'g5' => $sxmb[6],
//            'g6' => $sxmb[7],
//            'g7' => $sxmb[8],
//            'madb' => $sxmb[0],
//            'day' => $day,
//            'mien' => 1,
//            'status' => 1,
//            'province_id' => $province_id,
//            'date' => $ngay_quay,
//        ]);
//        die();
        $check = Lottery::where('date', $ngay_quay)->where('province_id', $province_id)->where('mien', 1)->first();
        if (count($check) > 0) {
            if ($check->status != 1) {
                $check->delete();
            }
        }

        Lottery::firstOrCreate([
            'gdb' => $sxmb[1],
            'g1' => $sxmb[2],
            'g2' => $sxmb[3],
            'g3' => $sxmb[4],
            'g4' => $sxmb[5],
            'g5' => $sxmb[6],
            'g6' => $sxmb[7],
            'g7' => $sxmb[8],
            'madb' => $sxmb[0],
            'day' => $day,
            'mien' => 1,
            'status' => 1,
            'province_id' => $province_id,
            'date' => $ngay_quay,
        ]);
    }

    public function getThu_xosodaiphat($date)
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

    public function getProvince()
    {
        $str1 = '';
        $str2 = '';
        $str3 = '';
        $html = str_get_html($str3);

        foreach ($html->find('a') as $a) {
            $name = $a->innertext;
            $link = 'https://xosodaiphat.com' . $a->href;
            $slug = trim(substr($a->href, 1, strlen($a->href) - 6));
            $short_name = trim(substr($slug, 0, strpos($slug, '-')));
            $short_name = str_replace('xs', '', $short_name);
            $content = str_get_html(requestvl($link));
            $meta_title = trim($content->find('title', 0)->innertext);
            $meta_description = trim($content->find('meta[name=description]', 0)->content);
            $meta_keyword = trim($content->find('meta[name=keywords]', 0)->content);
            $title = trim($content->find('h1', 0)->innertext);

            Province::firstOrCreate([
                'name' => $name,
                'short_name' => $short_name,
                'slug' => $slug,
                'title' => $title,
                'mien' => 3,
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'meta_keyword' => $meta_keyword,
            ]);
        }
        die('xong!');
    }
}
