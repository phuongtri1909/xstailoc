<?php

namespace App\Http\Controllers\Craw;

use App\Models\Max4D;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrawMax4DController extends Controller
{
    public function getAll()
    {
        set_time_limit(0);
        for ($i = 0; $i <= 26; $i++) {
            $url = 'https://xosodaiphat.com/loadmore-lottery-max4d.html?pageIndex=' . $i;
            $html = str_get_html(requestvl($url));
            foreach ($html->find('div.block') as $block) {
                $date = $block->find('.class-title-list-link a', 2)->innertext;
                $date = str_replace('Max 4D', '', $date);
                $date = getNgayLink(trim($date));
                $day = getThuNumber($date);
                if($date=='2019-04-23'){
                    echo 'Xong';
                    return;
                }

                $tr = $block->find('.table tr');

                $g1 = $tr[0]->find('td span',0)->innertext;

                $g2 = '';
                foreach($tr[1]->find('td span') as $span){
                    $g2 .= $span->innertext.'-';
                }
                $g2 = trim(substr($g2,0,strlen($g2)-1));

                $g3 = '';
                foreach($tr[2]->find('td span') as $span){
                    $g3 .= $span->innertext.'-';
                }
                $g3 = trim(substr($g3,0,strlen($g3)-1));

                $kh = $block->find('.table-sign .number-black-bold');
                $a = trim($kh[0]->innertext);
                $b = trim($kh[1]->innertext);
                $c = trim($kh[2]->innertext);
                $d = trim($kh[3]->innertext);
                $e = trim($kh[4]->innertext);
                $g = trim($kh[5]->innertext);

//                echo '$date: ' . $date . '<br/>';
//                echo '$day: ' . $day . '<br/>';
//                echo '$g1: ' . $g1 . '<br/>';
//                echo '$g2: ' . $g2 . '<br/>';
//                echo '$g3: ' . $g3 . '<br/>';
//                echo '$a: ' . $a . '<br/>';
//                echo '$b: ' . $b . '<br/>';
//                echo '$c: ' . $c . '<br/>';
//                echo '$d: ' . $d . '<br/>';
//                echo '$e: ' . $e . '<br/>';
//                echo '$g: ' . $g . '<br/>';
//                die;

                Max4D::firstOrCreate([
                    'g1' => $g1,
                    'g2' => $g2,
                    'g3' => $g3,
                    'a' => $a,
                    'b' => $b,
                    'c' => $c,
                    'd' => $d,
                    'e' => $e,
                    'g' => $g,
                    'date' => $date,
                    'day' => $day,
                    'status' => 1
                ]);
            }
        }
        echo 'Xong!';
    }
}
