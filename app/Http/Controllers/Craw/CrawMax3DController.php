<?php

namespace App\Http\Controllers\Craw;

use App\Models\Max3D;
use App\Models\Max3DPro;
use App\Models\Mega645;
use App\Models\Power655;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrawMax3DController extends Controller
{
    public function getMax3D()
    {
        set_time_limit(0);
        $date = date('j-n-Y',strtotime("+1 days"));
        $url = 'https://xskt.com.vn/moreLr.jsp?areaCode=3D&p=MAX3D&d='.$date.'&lrPosition=7';
        $html = str_get_html(requestvl($url));
        while(!empty($html)) {
            foreach($html->find('.box-ketqua') as $box){
                $h2 = trim($box->find('h2',0)->innertext);
                $h2 = explode(' ',$h2);
                $ngay_quay = $h2[count($h2)-1];

                $ky_quay = $box->find('th.kmt a b',0)->innertext;
                $ky_quay = intval(substr($ky_quay,1));

                $gdb = trim($box->find('tr',2)->find('td',1)->plaintext);
                $g1 = trim($box->find('tr',3)->find('td',1)->plaintext);
                $g2 = trim($box->find('tr',4)->find('td',1)->plaintext);
                $g3 = trim($box->find('tr',5)->find('td',1)->plaintext);

                $gdb = preg_replace('/\s+/', '-', $gdb);
                $g1 = preg_replace('/\s+/', '-', $g1);
                $g2 = preg_replace('/\s+/', '-', $g2);
                $g3 = preg_replace('/\s+/', '-', $g3);

                $gdb_sl = trim($box->find('tr',2)->find('td em',0)->plaintext);
                $g1_sl = trim($box->find('tr',3)->find('td em',0)->plaintext);
                $g2_sl = trim($box->find('tr',4)->find('td em',0)->plaintext);
                $g3_sl = str_replace(',','',trim($box->find('tr',5)->find('td em',0)->plaintext));



                $gdb_pl_sl = $box->find('tr',2)->find('td em',1)->plaintext;
                $g1_pl_sl = $box->find('tr',3)->find('td em',1)->plaintext;
                $g2_pl_sl = $box->find('tr',4)->find('td em',1)->plaintext;
                $g3_pl_sl = $box->find('tr',5)->find('td em',1)->plaintext;
                $g4_pl_sl = $box->find('tr',6)->find('td em',1)->plaintext;
                $g5_pl_sl = str_replace(',','',$box->find('tr',7)->find('td em',1)->plaintext);
                $g6_pl_sl = str_replace(',','',$box->find('tr',8)->find('td em',1)->plaintext);

                $date = date('Y-m-d', strtotime($ngay_quay));
                $day = getThuNumber($date);

//                $check = Max3D::where('date', $date)->count();
//                if ($check > 0) die('lấy xong!');

                if ($date <= date('Y-m-d',strtotime("-100 days"))){
                    echo $date.'<br/>';
                    die('lấy xong!');
                }
                Max3D::where('date',$date)->delete();

                Max3D::firstOrCreate([
                    'gdb' => $gdb,
                    'g1' => $g1,
                    'g2' => $g2,
                    'g3' => $g3,
                    'gdb_sl' => $gdb_sl,
                    'g1_sl' => $g1_sl,
                    'g2_sl' => $g2_sl,
                    'g3_sl' => $g3_sl,
                    'gdb_pl_sl' => $gdb_pl_sl,
                    'g1_pl_sl' => $g1_pl_sl,
                    'g2_pl_sl' => $g2_pl_sl,
                    'g3_pl_sl' => $g3_pl_sl,
                    'g4_pl_sl' => $g4_pl_sl,
                    'g5_pl_sl' => $g5_pl_sl,
                    'g6_pl_sl' => $g6_pl_sl,
                    'date' => $date,
                    'day' => $day,
                    'ky' => $ky_quay,
                    'status' => 1
                ]);

//                echo '$ngay_quay:'.date('Y-m-d', strtotime($ngay_quay)).'<br/>';
//                echo '$ky_quay:'.$ky_quay.'<br/>';
//
//                echo '$gdb:'.$gdb.'<br/>';
//                echo '$g1:'.$g1.'<br/>';
//                echo '$g2:'.$g2.'<br/>';
//                echo '$g3:'.$g3.'<br/>';
//
//                echo '$gdb_sl:'.$gdb_sl.'<br/>';
//                echo '$g1_sl:'.$g1_sl.'<br/>';
//                echo '$g2_sl:'.$g2_sl.'<br/>';
//                echo '$g3_sl:'.$g3_sl.'<br/>';
//
//                echo '$gdb_pl_sl:'.$gdb_pl_sl.'<br/>';
//                echo '$g1_pl_sl:'.$g1_pl_sl.'<br/>';
//                echo '$g2_pl_sl:'.$g2_pl_sl.'<br/>';
//                echo '$g3_pl_sl:'.$g3_pl_sl.'<br/>';
//                echo '$g4_pl_sl:'.$g4_pl_sl.'<br/>';
//                echo '$g5_pl_sl:'.$g5_pl_sl.'<br/>';
//                echo '$g6_pl_sl:'.$g6_pl_sl.'<br/>';
//                echo '<br/><br/><br/><br/>';

            }
            $url = 'https://xskt.com.vn/moreLr.jsp?areaCode=3D&p=MAX3D&d='.$ngay_quay.'&lrPosition=7';
            $html = str_get_html(requestvl($url));
        }
        echo 'Xong!';
    }

    public function getMax3DPro()
    {
        set_time_limit(0);
        $date = date('j-n-Y',strtotime("+1 days"));
        $url = 'https://xskt.com.vn/moreLr.jsp?areaCode=3P&p=MAX3DPRO&d='.$date.'&lrPosition=4';
        $html = str_get_html(requestvl($url));
        while(!empty($html)) {
            foreach($html->find('.box-ketqua') as $box){
                $h2 = trim($box->find('h2',0)->innertext);
                $h2 = explode(' ',$h2);
                $ngay_quay = $h2[count($h2)-1];

                $ky_quay = $box->find('th.kmt a b',0)->innertext;
                $ky_quay = intval(substr($ky_quay,1));

                if(!empty($box->find('tr', 1))){
                    $gdb = trim($box->find('tr', 1)->find('td', 1)->plaintext);
                    $gdb_sl = $box->find('tr', 1)->find('td em', 0)->plaintext;
                }else{
                    $gdb = null;
                    $gdb_sl = null;
                }

                if(!empty($box->find('tr', 2))){
                    $gdb_phu_sl = $box->find('tr', 2)->find('td em', 0)->plaintext;
                }else{
                    $gdb_phu_sl = null;
                }

                if(!empty($box->find('tr', 3))){
                    $g1 = trim($box->find('tr', 3)->find('td', 1)->plaintext);
                    $g1_sl = $box->find('tr', 3)->find('td em', 0)->plaintext;
                }else{
                    $g1 = null;
                    $g1_sl = null;
                }

                if(!empty($box->find('tr', 4))){
                    $g2 = trim($box->find('tr', 4)->find('td', 1)->plaintext);
                    $g2_sl = $box->find('tr', 4)->find('td em', 0)->plaintext;
                }else{
                    $g2 = null;
                    $g2_sl = null;
                }

                if(!empty($box->find('tr', 5))){
                    $g3 = trim($box->find('tr', 5)->find('td', 1)->plaintext);
                    $g3_sl = $box->find('tr', 5)->find('td em', 0)->plaintext;
                }else{
                    $g3 = null;
                    $g3_sl = null;
                }

                if(!empty($box->find('tr', 6))){
                    $g4_sl = $box->find('tr', 6)->find('td em', 0)->plaintext;
                }else{
                    $g4_sl = null;
                }
                if(!empty($box->find('tr', 7))){
                    $g5_sl = str_replace(',', '', $box->find('tr', 7)->find('td em', 0)->plaintext);
                }else{
                    $g5_sl = null;
                }

                if(!empty($box->find('tr', 8))){
                    $g6_sl = str_replace(',', '', $box->find('tr', 8)->find('td em', 0)->plaintext);
                }else{
                    $g6_sl = null;
                }

                $gdb = preg_replace('/\s+/', '-', $gdb);
                $g1 = preg_replace('/\s+/', '-', $g1);
                $g2 = preg_replace('/\s+/', '-', $g2);
                $g3 = preg_replace('/\s+/', '-', $g3);

                if(trim($gdb_sl)=='-') $gdb_sl= null;
                if(trim($gdb_phu_sl)=='-') $gdb_phu_sl= null;
                if(trim($g1_sl)=='-') $g1_sl= null;
                if(trim($g2_sl)=='-') $g2_sl= null;
                if(trim($g3_sl)=='-') $g3_sl= null;
                if(trim($g4_sl)=='-') $g4_sl= null;
                if(trim($g5_sl)=='-') $g5_sl= null;
                if(trim($g6_sl)=='-') $g6_sl= null;


//                $gdb = trim($box->find('tr',1)->find('td',1)->plaintext);
//                $g1 = trim($box->find('tr',3)->find('td',1)->plaintext);
//                $g2 = trim($box->find('tr',4)->find('td',1)->plaintext);
//                $g3 = trim($box->find('tr',5)->find('td',1)->plaintext);
//
//                $gdb = preg_replace('/\s+/', '-', $gdb);
//                $g1 = preg_replace('/\s+/', '-', $g1);
//                $g2 = preg_replace('/\s+/', '-', $g2);
//                $g3 = preg_replace('/\s+/', '-', $g3);
//
//                $gdb_sl = $box->find('tr',1)->find('td em',0)->plaintext;
//                $gdb_phu_sl = $box->find('tr',2)->find('td em',0)->plaintext;
//                $g1_sl = $box->find('tr',3)->find('td em',0)->plaintext;
//                $g2_sl = $box->find('tr',4)->find('td em',0)->plaintext;
//                $g3_sl = $box->find('tr',5)->find('td em',0)->plaintext;
//                $g4_sl = $box->find('tr',6)->find('td em',0)->plaintext;
//                $g5_sl = str_replace(',','',$box->find('tr',7)->find('td em',0)->plaintext);
//                $g6_sl = str_replace(',','',$box->find('tr',8)->find('td em',0)->plaintext);

                $date = date('Y-m-d', strtotime($ngay_quay));
                $day = getThuNumber($date);

//                $check = Max3DPro::where('date', $date)->count();
//                if ($check > 0) die('lấy xong!');
                if ($date <= date('Y-m-d',strtotime("-100 days"))){
                    echo $date.'<br/>';
                    die('lấy xong!');
                }
                Max3DPro::where('date',$date)->delete();

                Max3DPro::firstOrCreate([
                    'gdb' => $gdb,
                    'g1' => $g1,
                    'g2' => $g2,
                    'g3' => $g3,
                    'gdb_sl' => $gdb_sl,
                    'gdb_phu_sl' => $gdb_phu_sl,
                    'g1_sl' => $g1_sl,
                    'g2_sl' => $g2_sl,
                    'g3_sl' => $g3_sl,
                    'g4_sl' => $g4_sl,
                    'g5_sl' => $g5_sl,
                    'g6_sl' => $g6_sl,
                    'date' => $date,
                    'day' => $day,
                    'ky' => $ky_quay,
                    'status' => 1
                ]);

//                echo '$ngay_quay:'.date('Y-m-d', strtotime($ngay_quay)).'<br/>';
//                echo '$ky_quay:'.$ky_quay.'<br/>';
//
//                echo '$gdb:'.$gdb.'<br/>';
//                echo '$g1:'.$g1.'<br/>';
//                echo '$g2:'.$g2.'<br/>';
//                echo '$g3:'.$g3.'<br/>';
//
//                echo '$gdb_sl:'.$gdb_sl.'<br/>';
//                echo '$gdb_phu_sl:'.$gdb_phu_sl.'<br/>';
//                echo '$g1_sl:'.$g1_sl.'<br/>';
//                echo '$g2_sl:'.$g2_sl.'<br/>';
//                echo '$g3_sl:'.$g3_sl.'<br/>';
//                echo '$g4_sl:'.$g4_sl.'<br/>';
//                echo '$g5_sl:'.$g5_sl.'<br/>';
//                echo '$g6_sl:'.$g6_sl.'<br/>';
//                echo '<br/><br/><br/><br/>';
//                die();
            }
            $url = 'https://xskt.com.vn/moreLr.jsp?areaCode=3P&p=MAX3DPRO&d='.$ngay_quay.'&lrPosition=4';
            $html = str_get_html(requestvl($url));
        }
        echo 'Xong!';
    }

    public function getMega645()
    {
        set_time_limit(0);
        $date = date('j-n-Y',strtotime("+1 days"));
        $url = 'https://xskt.com.vn/moreLr.jsp?areaCode=MG&p=MEGA645&d='.$date.'&lrPosition=4';
        $html = str_get_html(requestvl($url));
        while(!empty($html)) {
            foreach($html->find('.box-ketqua') as $box){
                $h2 = trim($box->find('h2',0)->innertext);
                $h2 = explode(' ',$h2);
                $ngay_quay = $h2[count($h2)-1];

                $ky_quay = $box->find('.result td.kmt a b',0)->innertext;
                $ky_quay = intval(substr($ky_quay,1));

                $day_so = trim($box->find('.result td.megaresult em',0)->innertext);
                $day_so = preg_replace('/\s+/', '-', $day_so);

                $jackpot_gt = str_replace(',','',$box->find('.trunggiai tr',2)->find('td',3)->plaintext);
                $jackpot_sl = $box->find('.trunggiai tr',2)->find('td',2)->plaintext;
                $g1_sl = $box->find('.trunggiai tr',3)->find('td',2)->plaintext;
                $g2_sl = str_replace(',','',$box->find('.trunggiai tr',4)->find('td',2)->plaintext);
                $g3_sl = str_replace(',','',$box->find('.trunggiai tr',5)->find('td',2)->plaintext);

                $date = date('Y-m-d', strtotime($ngay_quay));
                $day = getThuNumber($date);

//                $check = Mega645::where('date', $date)->count();
//                if ($check > 0) die('lấy xong!');
                if ($date <= date('Y-m-d',strtotime("-100 days"))){
                    echo $date.'<br/>';
                    die('lấy xong!');
                }
                Mega645::where('date',$date)->delete();

                Mega645::firstOrCreate([
                    'day_so' => $day_so,
                    'jackpot_gt' => $jackpot_gt,
                    'jackpot_sl' => $jackpot_sl,
                    'g1_sl' => $g1_sl,
                    'g2_sl' => $g2_sl,
                    'g3_sl' => $g3_sl,
                    'date' => $date,
                    'day' => $day,
                    'status' => 1,
                    'ky' => $ky_quay,
                ]);

//                echo '$ngay_quay:'.date('Y-m-d', strtotime($ngay_quay)).'<br/>';
//                echo '$ky_quay:'.$ky_quay.'<br/>';
//                echo '$day_so:'.$day_so.'<br/>';
//
//                echo '$jackpot_gt:'.$jackpot_gt.'<br/>';
//                echo '$jackpot_sl:'.$jackpot_sl.'<br/>';
//                echo '$g1_sl:'.$g1_sl.'<br/>';
//                echo '$g2_sl:'.$g2_sl.'<br/>';
//                echo '$g3_sl:'.$g3_sl.'<br/>';
//                echo '$date:'.$date.'<br/>';
//                echo '$day:'.$day.'<br/>';
//                echo '<br/><br/><br/><br/><br/>';
//                die();
            }
            $url = 'https://xskt.com.vn/moreLr.jsp?areaCode=MG&p=MEGA645&d='.$ngay_quay.'&lrPosition=4';
            $html = str_get_html(requestvl($url));
        }
        echo 'Xong!';
    }

    public function getPower655()
    {
        set_time_limit(0);
        $date = date('j-n-Y',strtotime("+1 days"));
        $url = 'https://xskt.com.vn/moreLr.jsp?areaCode=MP&p=POWER&d='.$date.'&lrPosition=4';
        $html = str_get_html(requestvl($url));
        while(!empty($html)) {
            foreach($html->find('.box-ketqua') as $box){
                $h2 = trim($box->find('h2',0)->innertext);
                $h2 = explode(' ',$h2);
                $ngay_quay = $h2[count($h2)-1];

                $ky_quay = $box->find('.result td.kmt a b',0)->innertext;
                $ky_quay = intval(substr($ky_quay,1));

                $day_so = trim($box->find('.result td.megaresult em',0)->innertext);
                $day_so = preg_replace('/\s+/', '-', $day_so);

                $day_so_jp2 = trim($box->find('.result .jp2 .megaresult',0)->innertext);
                $day_so = $day_so.'-'.$day_so_jp2;

                $jackpot_gt_1 = str_replace(',','',$box->find('.trunggiai tr',2)->find('td',3)->plaintext);
                $jackpot_sl_1 = $box->find('.trunggiai tr',2)->find('td',2)->plaintext;

                $jackpot_gt_2 = str_replace(',','',$box->find('.trunggiai tr',3)->find('td',3)->plaintext);
                $jackpot_sl_2 = $box->find('.trunggiai tr',3)->find('td',2)->plaintext;

                $g1_sl = $box->find('.trunggiai tr',4)->find('td',2)->plaintext;
                $g2_sl = str_replace(',','',$box->find('.trunggiai tr',5)->find('td',2)->plaintext);
                $g3_sl = str_replace(',','',$box->find('.trunggiai tr',6)->find('td',2)->plaintext);

                $date = date('Y-m-d', strtotime($ngay_quay));
                $day = getThuNumber($date);

//                $check = Power655::where('date', $date)->count();
//                if ($check > 0) die('lấy xong!');
                if ($date <= date('Y-m-d',strtotime("-100 days"))){
                    echo $date.'<br/>';
                    die('lấy xong!');
                }
                Power655::where('date',$date)->delete();

                Power655::firstOrCreate([
                    'day_so' => $day_so,
                    'jackpot1_gt' => $jackpot_gt_1,
                    'jackpot1_sl' => $jackpot_sl_1,
                    'jackpot2_gt' => $jackpot_gt_2,
                    'jackpot2_sl' => $jackpot_sl_2,
                    'g1_sl' => $g1_sl,
                    'g2_sl' => $g2_sl,
                    'g3_sl' => $g3_sl,
                    'date' => $date,
                    'day' => $day,
                    'status' => 1,
                    'ky' => $ky_quay,
                ]);
            }
            $url = 'https://xskt.com.vn/moreLr.jsp?areaCode=MP&p=POWER&d='.$ngay_quay.'&lrPosition=4';
            $html = str_get_html(requestvl($url));
        }
        echo 'Xong!';
    }
}
