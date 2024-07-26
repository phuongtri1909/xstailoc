<?php

namespace App\Http\Controllers\Craw;

use App\Models\Lottery;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrawXSMTController extends Controller
{
    public function getAll()
    {
        set_time_limit(0);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date_create();

        while (true) {
            $ngay_quay = date_format($date, "Y-m-d");
            $date_url = date_format($date, "j-n-Y");
            $url = 'https://xoso.mobi/xsmt-'. $date_url .'-ket-qua-xo-so-mien-trung-ngay-'. $date_url .'.html';

//            echo $ngay_quay . '<br/>';
//            echo $date_url . '<br/>';
//            echo $url . '<br/><hr/>';
            $this->getXsmt($url, $ngay_quay);
            date_modify($date, "-1 days");

            if (date_format($date, "Y-m-d") == '2023-10-10') die('Lấy Xong DL');

//            // nếu đã lấy kd thì thoát
//            $checks = Lottery::where('date', date_format($date, "Y-m-d"))->where('mien', 2)->get();
//            if (count($checks) > 0) {
//                $checkkq = true;
//                foreach ($checks as $check) {
//                    if ($check->status != 1) $checkkq = false;
//                }
//                if ($checkkq) die('Lấy Xong!');
//            }
        }
    }

    public function getXsmt($url = '', $ngay_quay = '')
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

                    if($short_name=='bt') $short_name='btr';
                    if($short_name=='qnm') $short_name='qna';
                    if($short_name=='dng') $short_name='dna';

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

            $check = Lottery::where('date', $ngay_quay)->where('province_id', $province->id)->where('mien', 2)->first();
            if (!empty($check) > 0) {
                if ($check->status != 1) {
                    $check->delete();
                }else{
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
                'mien' => 2,
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

}
