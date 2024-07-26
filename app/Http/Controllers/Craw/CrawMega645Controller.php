<?php

namespace App\Http\Controllers\Craw;

use App\Models\Mega645;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Log;

class CrawMega645Controller extends Controller
{
    public function getAll()
    {
        set_time_limit(0);
        //136
        for ($i = 1; $i <= 3; $i++) {
//            echo $i.' ';
            $url = 'https://xoso.mobi/kqxs-mega-645-ket-qua-xo-so-mega-6-45-vietlott-ngay-hom-nay/' . $i . '.html';
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
                $jackpot_td = $tr[1]->find('td');
                $jackpot_gt = trim(str_replace('.', '', $jackpot_td[3]->innertext));
                $jackpot_gt = doubleval($jackpot_gt);
                $jackpot_sl = trim($jackpot_td[2]->innertext);
                $jackpot_sl = str_replace('.','',$jackpot_sl);

                // giải 1
                $g1_td = $tr[2]->find('td');
                $g1_gt = trim(str_replace('.', '', $g1_td[3]->innertext));
                $g1_gt = doubleval($g1_gt);
                $g1_sl = trim($g1_td[2]->innertext);
                $g1_sl = str_replace('.','',$g1_sl);

                // giải 2
                $g2_td = $tr[3]->find('td');
                $g2_gt = trim(str_replace('.', '', $g2_td[3]->innertext));
                $g2_gt = doubleval($g2_gt);
                $g2_sl = trim($g2_td[2]->innertext);
                $g2_sl = str_replace('.','',$g2_sl);

                // giải 2
                $g3_td = $tr[4]->find('td');
                $g3_gt = trim(str_replace('.', '', $g3_td[3]->innertext));
                $g3_gt = doubleval($g3_gt);
                $g3_sl = trim($g3_td[2]->innertext);
                $g3_sl = str_replace('.','',$g3_sl);

//                echo '$ky: ' . $ky . '<br/>';
//                echo '$date: ' . $date . '<br/>';
//                echo '$day_so: ' . $day_so . '<br/>';
//                echo '$jackpot_gt: ' . $jackpot_gt . '<br/>';
//                echo '$jackpot_sl: ' . $jackpot_sl . '<br/>';
//                echo '$g1_gt: ' . $g1_gt . '<br/>';
//                echo '$g1_sl: ' . $g1_sl . '<br/>';
//                echo '$g2_gt: ' . $g2_gt . '<br/>';
//                echo '$g2_sl: ' . $g2_sl . '<br/>';
//                echo '$g3_gt: ' . $g3_gt . '<br/>';
//                echo '$g3_sl: ' . $g3_sl . '<br/><hr/>';
//                die();

                $status = 1;
                if (strpos($day_so, '...') !== false) {
                    $status = 0;
                }

                if($jackpot_gt==0) $status = 0;

                $check = Mega645::where('date',$date)->first();
                if(count($check) >0){
                    if($check->status !=1 || $check->jackpot_gt==0){
                        $check->delete();
                    }else{
                        continue;
                    }
                }
                Mega645::firstOrCreate([
                    'day_so' => $day_so,
                    'jackpot_gt' => $jackpot_gt,
                    'jackpot_sl' => $jackpot_sl,
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

    public function getAll_Crontab()
    {
        set_time_limit(0);
        Log::info('Get Mega645 Start:' . date('Ymd H:i:s'));
        $url = 'https://xoso.mobi/kqxs-mega-645-ket-qua-xo-so-mega-6-45-vietlott-ngay-hom-nay/1.html';
        $html = str_get_html(requestvl($url));
        $block_all = $html->find('div.mega645');
        for ($k = 0; $k <= 2; $k++) {
            $block = $block_all[$k];
            $date = trim($block->find('h2.tit-mien', 0)->plaintext);
            $date = substr($date, strpos($date, 'ngày') + 5);
            $date = preg_replace('/\s+/', '', $date);
            $date = getNgayLink($date);
            $day = getThuNumber($date);

            // nếu đã lấy xong thì thoát
            $count = Mega645::where('date', $date)->where('status', 1)->count();
            if ($count > 0) continue;

            $day_so = '';
            foreach ($block->find('table.data i') as $li) {
                if (empty($li->innertext) || $li->innertext == '.') {
                    $day_so .= '...' . '-';
                } else {
                    $day_so .= trim($li->innertext) . '-';
                }
            }
            $day_so = substr($day_so, 0, strlen($day_so) - 1);

            $tr = $block->find('table.data2 tr');

            // jackpot 1
            $jackpot_td = $tr[1]->find('td');
            $jackpot_gt = trim(str_replace('.', '', $jackpot_td[3]->innertext));
            $jackpot_gt = doubleval($jackpot_gt);
            $jackpot_sl = trim($jackpot_td[2]->innertext);
            $jackpot_sl = str_replace('.', '', $jackpot_sl);

            // giải 1
            $g1_td = $tr[2]->find('td');
            $g1_gt = trim(str_replace('.', '', $g1_td[3]->innertext));
            $g1_gt = doubleval($g1_gt);
            $g1_sl = trim($g1_td[2]->innertext);
            $g1_sl = str_replace('.', '', $g1_sl);

            // giải 2
            $g2_td = $tr[3]->find('td');
            $g2_gt = trim(str_replace('.', '', $g2_td[3]->innertext));
            $g2_gt = doubleval($g2_gt);
            $g2_sl = trim($g2_td[2]->innertext);
            $g2_sl = str_replace('.', '', $g2_sl);

            // giải 2
            $g3_td = $tr[4]->find('td');
            $g3_gt = trim(str_replace('.', '', $g3_td[3]->innertext));
            $g3_gt = doubleval($g3_gt);
            $g3_sl = trim($g3_td[2]->innertext);
            $g3_sl = str_replace('.', '', $g3_sl);

            $status = 1;
            if (strpos($day_so, '...') !== false) {
                $status = 0;
            }
            if($jackpot_gt==0) $status = 0;

            $check = Mega645::where('date', $date)->count();
            if ($check == 0) {
                Mega645::firstOrCreate([
                    'day_so' => $day_so,
                    'jackpot_gt' => $jackpot_gt,
                    'jackpot_sl' => $jackpot_sl,
                    'g1_gt' => $g1_gt,
                    'g1_sl' => $g1_sl,
                    'g2_gt' => $g2_gt,
                    'g2_sl' => $g2_sl,
                    'g3_gt' => $g3_gt,
                    'g3_sl' => $g3_sl,
                    'date' => $date,
                    'day' => $day,
                    'status' => $status
                ]);
            } else {
                Mega645::where('date', $date)
                    ->update([
                        'day_so' => $day_so,
                        'jackpot_gt' => $jackpot_gt,
                        'jackpot_sl' => $jackpot_sl,
                        'g1_gt' => $g1_gt,
                        'g1_sl' => $g1_sl,
                        'g2_gt' => $g2_gt,
                        'g2_sl' => $g2_sl,
                        'g3_gt' => $g3_gt,
                        'g3_sl' => $g3_sl,
                        'date' => $date,
                        'day' => $day,
                        'status' => $status
                    ]);
            }
        }
        Log::info('Get Mega645 End:' . date('Ymd H:i:s'));
    }

    public function getAll_xosodaiphat()
    {
        set_time_limit(0);

//        $url = 'https://xosodaiphat.com/xs-mega-xo-so-mega-645.html';
        $url = 'https://xoso.net.vn/load-more-mega655-ajax.html?pageIndex=77';
        $html = str_get_html(requestvl($url));
        echo $html;
        die;
        foreach ($html->find('div.block') as $block) {
            if (count($block->find('p[class=para text-black-bold]')) == 0) break;
            $para = $block->find('p[class=para text-black-bold]', 0)->innertext;
            $para_arr = explode(':', $para);
            $ky = trim(str_replace('Kỳ', '', $para_arr[0]));
            $date_arr = explode(',', $para_arr[1]);
            $date = getNgayLink(trim($date_arr[1]));
            $day = getThuNumber($date);

            if ($date == '2019-04-21') {
                echo 'Xong';
                return;
            }

            $day_so = '';
            foreach ($block->find('.mega-detail li') as $li) {
                $day_so .= $li->innertext . '-';
            }
            $day_so = substr($day_so, 0, strlen($day_so) - 1);

            $tr = $block->find('.table tr');

            // jackpot 1
            $jackpot_td = $tr[1]->find('td');
            $jackpot_gt = trim(str_replace('.', '', $jackpot_td[3]->innertext));
            $jackpot_gt = doubleval($jackpot_gt);
            $jackpot_sl = trim($jackpot_td[2]->innertext);

            // giải 1
            $g1_td = $tr[2]->find('td');
            $g1_gt = trim(str_replace('.', '', $g1_td[3]->innertext));
            $g1_gt = doubleval($g1_gt);
            $g1_sl = trim($g1_td[2]->innertext);

            // giải 2
            $g2_td = $tr[3]->find('td');
            $g2_gt = trim(str_replace('.', '', $g2_td[3]->innertext));
            $g2_gt = doubleval($g2_gt);
            $g2_sl = trim($g2_td[2]->innertext);

            // giải 2
            $g3_td = $tr[4]->find('td');
            $g3_gt = trim(str_replace('.', '', $g3_td[3]->innertext));
            $g3_gt = doubleval($g3_gt);
            $g3_sl = trim($g3_td[2]->innertext);

//                echo '$ky: '.$ky.'<br/>';
//                echo '$date: '.$date.'<br/>';
//                echo '$day_so: '.$day_so.'<br/>';
//                echo '$jackpot_gt: '.$jackpot_gt.'<br/>';
//                echo '$jackpot_sl: '.$jackpot_sl.'<br/>';
//                echo '$g1_gt: '.$g1_gt.'<br/>';
//                echo '$g1_sl: '.$g1_sl.'<br/>';
//                echo '$g2_gt: '.$g2_gt.'<br/>';
//                echo '$g2_sl: '.$g2_sl.'<br/>';
//                echo '$g3_gt: '.$g3_gt.'<br/>';
//                echo '$g3_sl: '.$g3_sl.'<br/>';
//                die;

            Mega645::firstOrCreate([
                'day_so' => $day_so,
                'jackpot_gt' => $jackpot_gt,
                'jackpot_sl' => $jackpot_sl,
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

        for ($i = 1; $i <= 30; $i++) {
            $url = 'https://xosodaiphat.com/loadmore-doantoanmega645.html?pageIndex=' . $i;
            $html = str_get_html(requestvl($url));
            foreach ($html->find('div.block') as $block) {
                $para = $block->find('p.para', 0)->innertext;
                $para_arr = explode(':', $para);
                $ky = trim(str_replace('Kỳ', '', $para_arr[0]));
                $date_arr = explode(',', $para_arr[1]);
                $date = getNgayLink(trim($date_arr[1]));
                $day = getThuNumber($date);

                $day_so = '';
                foreach ($block->find('.mega-detail li') as $li) {
                    $day_so .= $li->innertext . '-';
                }
                $day_so = substr($day_so, 0, strlen($day_so) - 1);

                $tr = $block->find('.table tr');

                // jackpot 1
                $jackpot_td = $tr[1]->find('td');
                $jackpot_gt = trim(str_replace('.', '', $jackpot_td[3]->innertext));
                $jackpot_gt = doubleval($jackpot_gt);
                $jackpot_sl = trim($jackpot_td[2]->innertext);

                // giải 1
                $g1_td = $tr[2]->find('td');
                $g1_gt = trim(str_replace('.', '', $g1_td[3]->innertext));
                $g1_gt = doubleval($g1_gt);
                $g1_sl = trim($g1_td[2]->innertext);

                // giải 2
                $g2_td = $tr[3]->find('td');
                $g2_gt = trim(str_replace('.', '', $g2_td[3]->innertext));
                $g2_gt = doubleval($g2_gt);
                $g2_sl = trim($g2_td[2]->innertext);

                // giải 2
                $g3_td = $tr[4]->find('td');
                $g3_gt = trim(str_replace('.', '', $g3_td[3]->innertext));
                $g3_gt = doubleval($g3_gt);
                $g3_sl = trim($g3_td[2]->innertext);

//                echo '$ky: '.$ky.'<br/>';
//                echo '$date: '.$date.'<br/>';
//                echo '$day_so: '.$day_so.'<br/>';
//                echo '$jackpot_gt: '.$jackpot_gt.'<br/>';
//                echo '$jackpot_sl: '.$jackpot_sl.'<br/>';
//                echo '$g1_gt: '.$g1_gt.'<br/>';
//                echo '$g1_sl: '.$g1_sl.'<br/>';
//                echo '$g2_gt: '.$g2_gt.'<br/>';
//                echo '$g2_sl: '.$g2_sl.'<br/>';
//                echo '$g3_gt: '.$g3_gt.'<br/>';
//                echo '$g3_sl: '.$g3_sl.'<br/>';
//                die;

                Mega645::firstOrCreate([
                    'day_so' => $day_so,
                    'jackpot_gt' => $jackpot_gt,
                    'jackpot_sl' => $jackpot_sl,
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
