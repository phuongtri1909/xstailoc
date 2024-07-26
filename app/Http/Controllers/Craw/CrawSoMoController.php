<?php

namespace App\Http\Controllers\Craw;

use App\Models\SoMo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrawSoMoController extends Controller
{
    public function getSM()
    {
        set_time_limit(0);
        $somo = SoMo::all();
        foreach($somo as $item){
            $item->slug = 'mo-thay-'.$item->slug.'-danh-con-gi';
            $item->save();
        }
        die('xong!');
        set_time_limit(0);
        for ($k = 0; $k <= 88; $k++) {
            $url = 'https://atrungroi.com/so-mo-lo-de-mien-bac.html?paged=' . $k;
            $html = str_get_html(requestvl($url));
            $somo_table = str_get_html($html->find('#somo_table .js-table-somo-lists', 0)->innertext);

            foreach ($somo_table->find('tr') as $tr) {
                $link = $tr->find('td', 0)->find('a', 0)->href;
                $mo = $tr->find('td', 0)->plaintext;
                $so = '';
                foreach ($tr->find('td', 1)->find('span') as $span) {
                    $so .= $span->innertext . ', ';
                }
                $so = substr($so, 0, strlen($so) - 2);

                $slug = chanetitle($mo);

                $van = strtolower(substr($slug, 0, 1));
                $straz = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                if (strpos($straz, strtoupper($van)) === false) {
                    $van = '#';
                }
                $content = trim($this->getContent($link));
                SoMo::firstOrCreate([
                    'mo' => $mo,
                    'slug' => $slug,
                    'so' => $so,
                    'van' => $van,
                    'content' => $content,
                ]);
            }
        }
        echo 'Xong!';
    }

    public function getContent($url)
    {
        $html = str_get_html(requestvl($url));
        if (count($html->find('.somo_content')) == 0) return '';
        $content = str_get_html($html->find('.somo_content', 0)->innertext);
        foreach ($content->find('a') as $a) {
            $a->outertext = $a->innertext;
        }
        foreach ($content->find('img') as $img) {
            $img->outertext = '';
        }
        $content = str_replace('A TRÚNG RỒI', '', $content);
        $content = str_replace('ATRÚNGRỒI.com', '', $content);
        $content = str_replace('ATRÚNGRỒI', '', $content);
        $content = str_replace('ATrúngRồi.com', '', $content);
        $content = str_replace('ATrúngRồi', '', $content);
        $content = str_replace('A Trúng Rồi', '', $content);
        $content = str_replace('atrungroi.com', '', $content);
        $content = str_replace('atrungroi', '', $content);
        $content = str_replace('ATrungRoi', '', $content);
        if (strpos($content, '<p>Cùng tham khảo thêm') !== false) {
            $content = substr($content, 0, strpos($content, '<p>Cùng tham khảo thêm'));
        }
        return $content;
    }
}
