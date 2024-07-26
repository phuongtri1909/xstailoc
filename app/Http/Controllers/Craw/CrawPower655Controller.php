<?php

namespace App\Http\Controllers\Craw;

use App\Models\Power655;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Log;

class CrawPower655Controller extends Controller
{
    public function getAll()
    {
        set_time_limit(0);
        //113
        for ($i = 1; $i <= 3; $i++) {
//            echo $i.' ';
            $url = 'https://xoso.mobi/kqxs-power-6-55-ket-qua-xo-so-power-6-55-vietlott-ngay-hom-nay/'.$i.'.html';
            $html = str_get_html(requestvl($url));
            $block_all = $html->find('div.mega645');
            $block_count = count($html->find('div.mega645'));
            for ($k = 0; $k <= $block_count - 1; $k++) {
                $block = $block_all[$k];
                $date = trim($block->find('h2.tit-mien', 0)->plaintext);
                $date = substr($date, strpos($date, 'ngày') + 5);
                $date = preg_replace('/\s+/', '', $date);
                $date = getNgayLink($date);
                $day = getThuNumber($date);

                if ($date == '2023-01-05') die('Lấy Xong DL');

                $day_so = '';
                foreach ($block->find('table.data i') as $item) {
                    $day_so .= trim($item->innertext) . '-';
                }
                $day_so = substr($day_so, 0, strlen($day_so) - 1);


                $tr = $block->find('table.data2 tr');

                // jackpot 1
                $jackpot1_td = $tr[1]->find('td');
                $jackpot1_gt = trim(str_replace('.','',$jackpot1_td[3]->innertext));
                $jackpot1_gt = doubleval($jackpot1_gt);
                $jackpot1_sl = trim($jackpot1_td[2]->innertext);
                $jackpot1_sl = str_replace('.','',$jackpot1_sl);

                // jackpot 2
                $jackpot2_td = $tr[2]->find('td');
                $jackpot2_gt = trim(str_replace('.','',$jackpot2_td[3]->innertext));
                $jackpot2_gt = doubleval($jackpot2_gt);
                $jackpot2_sl = trim($jackpot2_td[2]->innertext);
                $jackpot2_sl = str_replace('.','',$jackpot2_sl);

                // giải 1
                $g1_td = $tr[3]->find('td');
                $g1_gt = trim(str_replace('.','',$g1_td[3]->innertext));
                $g1_gt = doubleval($g1_gt);
                $g1_sl = trim($g1_td[2]->innertext);
                $g1_sl = str_replace('.','',$g1_sl);

                // giải 2
                $g2_td = $tr[4]->find('td');
                $g2_gt = trim(str_replace('.','',$g2_td[3]->innertext));
                $g2_gt = doubleval($g2_gt);
                $g2_sl = trim($g2_td[2]->innertext);
                $g2_sl = str_replace('.','',$g2_sl);

                // giải 2
                $g3_td = $tr[5]->find('td');
                $g3_gt = trim(str_replace('.','',$g3_td[3]->innertext));
                $g3_gt = doubleval($g3_gt);
                $g3_sl = trim($g3_td[2]->innertext);
                $g3_sl = str_replace('.','',$g3_sl);

//                echo '$ky: '.$ky.'<br/>';
//                echo '$date: '.$date.'<br/>';
//                echo '$day_so: '.$day_so.'<br/>';
//                echo '$jackpot1_gt: '.$jackpot1_gt.'<br/>';
//                echo '$jackpot1_sl: '.$jackpot1_sl.'<br/>';
//                echo '$jackpot2_gt: '.$jackpot2_gt.'<br/>';
//                echo '$jackpot2_sl: '.$jackpot2_sl.'<br/>';
//                echo '$g1_gt: '.$g1_gt.'<br/>';
//                echo '$g1_sl: '.$g1_sl.'<br/>';
//                echo '$g2_gt: '.$g2_gt.'<br/>';
//                echo '$g2_sl: '.$g2_sl.'<br/>';
//                echo '$g3_gt: '.$g3_gt.'<br/>';
//                echo '$g3_sl: '.$g3_sl.'<br/>';
//                die;

                $status = 1;
                if (strpos($day_so, '...') !== false) {
                    $status = 0;
                }
                if($jackpot1_gt==0) $status = 0;
                if($jackpot2_gt==0) $status = 0;

                $check = Power655::where('date',$date)->first();
                if(count($check) >0){
                    if($check->status !=1 || $check->jackpot1_gt==0 || $check->jackpot2_gt==0){
                        $check->delete();
                    }else{
                        continue;
                    }
                }

                Power655::firstOrCreate([
                    'day_so' => $day_so,
                    'jackpot1_gt' => $jackpot1_gt,
                    'jackpot1_sl' => $jackpot1_sl,
                    'jackpot2_gt' => $jackpot2_gt,
                    'jackpot2_sl' => $jackpot2_sl,
                    'g1_gt' => $g1_gt,
                    'g1_sl' => $g1_sl,
                    'g2_gt' => $g2_gt,
                    'g2_sl' => $g2_sl,
                    'g3_gt' => $g3_gt,
                    'g3_sl' => $g3_sl,
                    'date' => $date,
                    'day' => $day,
                    'status' => $status,
//                    'ky' => $ky,
                ]);
            }
        }
        echo 'Xong!';
    }
    public function getAll_xosodaiphat()
    {
        set_time_limit(0);
        for($i=0;$i<=19;$i++){
            $url = 'https://xosodaiphat.com/XSDPDienToan/LotteryMega655GetMore?pageIndex='.$i;
            $html = str_get_html(requestvl($url));
            foreach($html->find('div.block') as $block){
                $para = $block->find('p.para',0)->innertext;
                $para_arr = explode(':',$para);
                $ky = trim(str_replace('Kỳ','',$para_arr[0]));
                $date_arr = explode(',',$para_arr[1]);
                $date = getNgayLink(trim($date_arr[1]));
                $day = getThuNumber($date);
                if($date=='2019-04-23'){
                    echo 'Xong';
                    return;
                }

                $day_so = '';
                foreach($block->find('.power-detail li') as $li){
                    $day_so .=$li->innertext.'-';
                }
                $day_so = substr($day_so,0,strlen($day_so)-1);

                $tr = $block->find('.table tr');

                // jackpot 1
                $jackpot1_td = $tr[1]->find('td');
                $jackpot1_gt = trim(str_replace('.','',$jackpot1_td[3]->innertext));
                $jackpot1_gt = doubleval($jackpot1_gt);
                $jackpot1_sl = trim($jackpot1_td[2]->innertext);

                // jackpot 2
                $jackpot2_td = $tr[2]->find('td');
                $jackpot2_gt = trim(str_replace('.','',$jackpot2_td[3]->innertext));
                $jackpot2_gt = doubleval($jackpot2_gt);
                $jackpot2_sl = trim($jackpot2_td[2]->innertext);

                // giải 1
                $g1_td = $tr[3]->find('td');
                $g1_gt = trim(str_replace('.','',$g1_td[3]->innertext));
                $g1_gt = doubleval($g1_gt);
                $g1_sl = trim($g1_td[2]->innertext);

                // giải 2
                $g2_td = $tr[4]->find('td');
                $g2_gt = trim(str_replace('.','',$g2_td[3]->innertext));
                $g2_gt = doubleval($g2_gt);
                $g2_sl = trim($g2_td[2]->innertext);

                // giải 2
                $g3_td = $tr[5]->find('td');
                $g3_gt = trim(str_replace('.','',$g3_td[3]->innertext));
                $g3_gt = doubleval($g3_gt);
                $g3_sl = trim($g3_td[2]->innertext);

//                echo '$ky: '.$ky.'<br/>';
//                echo '$date: '.$date.'<br/>';
//                echo '$day_so: '.$day_so.'<br/>';
//                echo '$jackpot1_gt: '.$jackpot1_gt.'<br/>';
//                echo '$jackpot1_sl: '.$jackpot1_sl.'<br/>';
//                echo '$jackpot2_gt: '.$jackpot2_gt.'<br/>';
//                echo '$jackpot2_sl: '.$jackpot2_sl.'<br/>';
//                echo '$g1_gt: '.$g1_gt.'<br/>';
//                echo '$g1_sl: '.$g1_sl.'<br/>';
//                echo '$g2_gt: '.$g2_gt.'<br/>';
//                echo '$g2_sl: '.$g2_sl.'<br/>';
//                echo '$g3_gt: '.$g3_gt.'<br/>';
//                echo '$g3_sl: '.$g3_sl.'<br/>';
//                die;

                Power655::firstOrCreate([
                    'day_so' => $day_so,
                    'jackpot1_gt' => $jackpot1_gt,
                    'jackpot1_sl' => $jackpot1_sl,
                    'jackpot2_gt' => $jackpot2_gt,
                    'jackpot2_sl' => $jackpot2_sl,
                    'g1_gt' => $g1_gt,
                    'g1_sl' => $g1_sl,
                    'g2_gt' => $g2_gt,
                    'g2_sl' => $g2_sl,
                    'g3_gt' => $g3_gt,
                    'g3_sl' => $g3_sl,
                    'date' => $date,
                    'day' => $day,
                    'status' => 1,
                    'ky' => $ky,
                ]);
            }
        }
        echo 'Xong!';
    }
}
