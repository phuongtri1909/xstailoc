<?php

namespace App\Http\Controllers\Craw;

use App\Models\DienToan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrawDienToanController extends Controller
{

    public function dienToan636()
    {
        set_time_limit(0);
        $url = 'https://xoso.mobi/kq-xsdt-6-36-ket-qua-xo-so-dien-toan-6-36-truc-tiep-hom-nay.html';
        $html = str_get_html(requestvl($url));
        $block_all = $html->find('.dientoan-ball .box');
        $block_count = count($html->find('.dientoan-ball .box'));
        for ($k = 0; $k <= $block_count - 1; $k++) {
            $block = $block_all[$k];
            $date = trim($block->find('h2.tit-mien', 0)->plaintext);
            $date = substr($date, strpos($date, 'ngày') + 5);
            $date = preg_replace('/\s+/', '', $date);
            $date = getNgaycheo($date);
            $day = getThuNumber($date);
            if ($date == '2023-08-10') die('Lấy Xong DL');

            $day_so = '';
            foreach ($block->find('li span') as $item) {
                $day_so .= trim($item->innertext) . '-';
            }
            $day_so = substr($day_so, 0, strlen($day_so) - 1);

//                echo '$date:' . $date . '<br/>';
//                echo '$day:' . $day . '<br/>';
//                echo '$day_so:' . $day_so . '<br/>';
//                die;

            $check = DienToan::where('date', $date)->where('type', 1)->first();
            if (!empty($check)) {
                if ($check->status != 1) {
                    $check->delete();
                } else {
                    continue;
                }
            }
            DienToan::firstOrCreate([
                'day_so' => $day_so,
                'date' => $date,
                'day' => $day,
                'status' => 1,
                'type' => 1,
            ]);
        }
        echo 'Xong!';
    }

    public function dienToan123()
    {
        set_time_limit(0);
        $url = 'https://xoso.mobi/kq-xsdt-123-ket-qua-xo-so-dien-toan-123-truc-tiep-hom-nay.html';
        $html = str_get_html(requestvl($url));
        $block_all = $html->find('.dientoan-ball .box');
        $block_count = count($html->find('.dientoan-ball .box'));
        for ($k = 0; $k <= $block_count - 1; $k++) {
            $block = $block_all[$k];
            $date = trim($block->find('h2.tit-mien', 0)->plaintext);
            $date = substr($date, strpos($date, 'ngày') + 5);
            $date = preg_replace('/\s+/', '', $date);
            $date = getNgaycheo($date);
            $day = getThuNumber($date);
            if ($date == '2023-08-10') die('Lấy Xong DL');
            $day_so = '';
            foreach ($block->find('li span') as $item) {
                $day_so .= trim($item->innertext) . '-';
            }
            $day_so = substr($day_so, 0, strlen($day_so) - 1);

//                echo '$date:' . $date . '<br/>';
//                echo '$day:' . $day . '<br/>';
//                echo '$day_so:' . $day_so . '<br/>';
//                die;
            $check = DienToan::where('date', $date)->where('type', 2)->first();
            if (!empty($check)) {
                if ($check->status != 1) {
                    $check->delete();
                } else {
                    continue;
                }
            }
            DienToan::firstOrCreate([
                'day_so' => $day_so,
                'date' => $date,
                'day' => $day,
                'status' => 1,
                'type' => 2,
            ]);
        }
        echo 'Xong!';
    }

    public function thanTai4()
    {
        set_time_limit(0);
        $url = 'https://xoso.mobi/xo-so-dien-toan-than-tai-hom-nay.html';
        $html = str_get_html(requestvl($url));
        $block_all = $html->find('.dientoan-ball .box');
        $block_count = count($html->find('.dientoan-ball .box'));
        for ($k = 0; $k <= $block_count - 1; $k++) {
            $block = $block_all[$k];
            $date = trim($block->find('h2.tit-mien', 0)->plaintext);
            $date = substr($date, strpos($date, 'ngày') + 5);
            $date = preg_replace('/\s+/', '', $date);
            $date = getNgaycheo($date);
            $day = getThuNumber($date);
            if ($date == '2023-08-10') die('Lấy Xong DL');
            $day_so = '';
            foreach ($block->find('li span') as $item) {
                $day_so .= trim($item->innertext) . '-';
            }
            $day_so = substr($day_so, 0, strlen($day_so) - 1);

//                echo '$date:' . $date . '<br/>';
//                echo '$day:' . $day . '<br/>';
//                echo '$day_so:' . $day_so . '<br/>';
//                die;

            $check = DienToan::where('date', $date)->where('type', 3)->first();
            if (!empty($check)) {
                if ($check->status != 1) {
                    $check->delete();
                } else {
                    continue;
                }
            }
            DienToan::firstOrCreate([
                'day_so' => $day_so,
                'date' => $date,
                'day' => $day,
                'status' => 1,
                'type' => 3,
            ]);
        }
        echo 'Xong!';
    } 
}
