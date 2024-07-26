<?php

namespace App\Http\Controllers\Craw;

use App\Models\Lottery;
use App\Models\Province;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CreateTKController extends Controller
{
    public function create()
    {
        set_time_limit(0);
        Post::where('date', '>=', '2023-10-01')->where('category_id',1)->delete();
        $kqs = Lottery::where('mien',1)->where('date', '>=', '2023-10-01')->orderBy('date', 'DESC')->get();
        foreach ($kqs as $kq) {
            $title = 'Thống kê XSMB ngày ' . getNgay($kq->date) . ' - Thống kê xổ số miền Bắc ' . getThu($kq->day);
            $slug = 'thong-ke-xsmb-' . getNgayLink($kq->date);
            $content = trim($this->createTKXsmb($kq->date));

//            $meta_title = 'Thống kê XSMB ngày ' . getNgay($kq->date) . ' - Thống kê xổ số miền Bắc ' . getThu($kq->day);
            $meta_description = 'Thống kê XSMB ngày ' . getNgay($kq->date) . ' - Thống kê xổ số miền Bắc ' . getThu($kq->day).'.Thống kê lô gan, lô về nhiều, cầu bạch thủ XSMB những con số may mắn và đẹp nhất ngày '. getNgay($kq->date);
//            $meta_keyword = 'thống kê xsmb '.getNgay($kq->date).', thống kê xsmb ngày '.getNgay($kq->date).',thống kê xsmb '.getThu($kq->day).',thống kê xsmb '.getNgayThang($kq->date).', thống kê xsmb, thong ke xsmb,thống kê xổ số miền bắc, thong ke xo so mien bac';

//            echo '$title:'.$title.'<br/>';
//            echo '$slug:'.$slug.'<br/>';
//            echo '$meta_title:'.$meta_title.'<br/>';
//            echo '$meta_description:'.$meta_description.'<br/>';
//            echo '$meta_keyword:'.$meta_keyword.'<br/>';
//            echo '$content:'.$content.'<br/>';
//            die();
            $arr_text_xsmb = ['XSMB', 'SXMB', 'Xổ số miền bắc', 'XS miền bắc', 'KQXS Mien Bac', 'Xo so mien bac', 'Kết Quả xổ số miền bắc', 'XSMB hôm nay', 'KQXSMB', 'Xổ số miền bắc hôm nay', 'XSTD', 'XSHN', 'Kết quả XSMB'];
            $text_xsmb = $arr_text_xsmb[array_rand($arr_text_xsmb)];

            $arr_text_xs = ['KQXS', 'Xổ số', 'Kết quả xổ số', 'Ket qua xo so', 'Kết quả xổ số hôm nay', 'Xo so', 'XS', 'KQXS hôm nay', 'XSKT'];
            $text_xs = $arr_text_xs[array_rand($arr_text_xs)];

            $check = Post::where('date',$kq->date)->where('category_id',1)->first();
            if(count($check) > 0) continue;
            Post::firstOrCreate([
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'text_xsmien' => $text_xsmb,
                'text_xs' => $text_xs,
                'date' => $kq->date,
                'category_id' => 1,
                'img' => '/frontend/img/thong-ke-xsmb-'.rand(1,20).'.png',
//                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
//                'meta_keyword' => $meta_keyword,
            ]);
        }
        echo 'Xong!';
    }

    /**
     * Tạo thống kê xsmb
     *
     * @param $date Định dạng:dd/mm/YYYY
     */
    public function createTKXsmb($date)
    {
        $day = getThuNumber($date);
        $thu = getThu($day);
        $ngay = getNgay($date);
        $ngay_thang = getNgayThang($date);
        $province = Province::where('mien', 1)->where('ngay_quay', 'like', '%' . $day . '%')->first();

//        $arr_text_xsmb = ['XSMB', 'SXMB', 'Xổ số miền bắc', 'XS miền bắc', 'KQXS Mien Bac', 'Xo so mien bac', 'Kết Quả xổ số miền bắc', 'XSMB hôm nay', 'KQXSMB', 'Xổ số miền bắc hôm nay', 'XSTD', 'XSHN', 'Kết quả XSMB'];
//        $text_xsmb = $arr_text_xsmb[array_rand($arr_text_xsmb)];
//
//        $arr_text_xs = ['KQXS', 'Xổ số', 'Kết quả xổ số', 'Ket qua xo so', 'Kết quả xổ số hôm nay', 'Xo so', 'XS', 'KQXS hôm nay', 'XSKT'];
//        $text_xs = $arr_text_xs[array_rand($arr_text_xs)];

//        $cau_bach_thu = $this->getCauMienBac($date);
//        $lo_gan = $this->getTKLoGan($date);
//        $lo_ve_nhieu = $this->getTKTanSuat($date);

//        $xsmb = Lottery::where('mien', 1)->where('date', '<', $date)->where('status', 1)->orderBy('date', 'DESC')->first();

        return view('frontend.create_tk.content_mb', compact('xsmb', 'text_xs', 'text_xsmb', 'date', 'lo_ve_nhieu', 'lo_gan', 'cau_bach_thu', 'day', 'thu', 'ngay', 'ngay_thang', 'province'));
    }

    /*
    * Cầu bạch thủ miền bắc
    */
    public function getCauMienBac($date)
    {
        $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(14)->get();

        foreach ($xsmbs as $xsmb) {
            $tmp_result1 = $xsmb->gdb . '-' . $xsmb->g1 . '-' . $xsmb->g2 . '-' . $xsmb->g3 . '-' . $xsmb->g4 . '-' . $xsmb->g5 . '-' . $xsmb->g6 . '-' . $xsmb->g7;
            $tmp_result2 = $xsmb->gdb . $xsmb->g1 . $xsmb->g2 . $xsmb->g3 . $xsmb->g4 . $xsmb->g5 . $xsmb->g6 . $xsmb->g7;

            $a = explode('-', $tmp_result2);
            $tmp_result3 = '';
            for ($l = 0; $l < count($a); ++$l) {
                $tmp_result3 .= $a[$l];
            }
            $arr_kq[] = getLoto($tmp_result1);
            $array_chuoi[] = $tmp_result3;
        }
        $len_array_chuoi = count($array_chuoi);
        $cau = array();
        $arr_cau = array();
        for ($i = $len_array_chuoi - 1; $i >= 3; $i--) {
            $len_chuoi_con = strlen($array_chuoi[$i]);
            $ArrayCollect = array();
            $stt = 0;
            for ($m = 0; $m < $len_chuoi_con - 1; $m++) {
                for ($n = $m + 1; $n < $len_chuoi_con; $n++) {
                    $tmp_i = $i;
                    $dem = 0;
                    $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];
                    $tmp2 = $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$m];
                    $arr_tmp = $arr_kq[$tmp_i - 1];

                    $tmp_dem = $dem;
                    if (in_array($tmp1, $arr_tmp) || in_array($tmp2, $arr_tmp)) {
                        $dem++;
                    }

                    while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                        $tmp_i--;
                        $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];
                        $tmp2 = $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$m];
                        if ($tmp_i > 0) {
                            $arr_tmp = $arr_kq[$tmp_i - 1];
                            $tmp_dem = $dem;
                            if (in_array($tmp1, $arr_tmp) || in_array($tmp2, $arr_tmp)) {
                                $dem++;
                            }
                        }
                    }

                    if ($dem > 0 && $tmp_i == 0 && !in_array($tmp1, $arr_cau)) {
                        //$tmp1 =  $array_chuoi[$tmp_i][$m].$array_chuoi[$tmp_i][$n];
                        $ArrayCollect[$stt][0] = $tmp1;
                        $ArrayCollect[$stt][1] = $m;
                        $ArrayCollect[$stt][2] = $n;
                        $ArrayCollect[$stt][3] = $dem;
                        //$ArrayCollect[$stt][4] =  $arr_tmp[count( $arr_tmp)-1];;
                        $stt++;
                    }
                }
            }

            if (count($ArrayCollect) > 0) {
                for ($e = 0; $e < $stt - 1; $e++) {
                    for ($f = $e + 1; $f < $stt; $f++) {
                        if ($ArrayCollect[$e][0] < $ArrayCollect[$f][0]) {
                            swap($ArrayCollect[$e][2], $ArrayCollect[$f][2]);
                            swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                            swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                            swap($ArrayCollect[$e][3], $ArrayCollect[$f][3]);
                        }
                    }
                }
            }
            foreach ($ArrayCollect as $item) {
                $arr_cau[] = $item[0];
            }
            $cau[$i] = $ArrayCollect;
        }

        $k = 0;
        foreach ($cau as $key => $value) {
            if (count($value) > 0) {
                $k++;
                if ($k == 3) {
                    foreach ($value as $item) {
                        return $item[0];
                    }

                }
            }
        }
    }


    /*
     * Lô gan miền bắc
     */
    public function getTKLoGan($date)
    {
        $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(30)->get();
        $province_name = 'Miền Bắc';
        $province_id = 0;

        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = '';
            $ArrayCollect[$i][2] = -1;

        }
        $len_collect = count($ArrayCollect);
        $number_date = 0;

        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);
            for ($t = 0; $t < $len_collect; $t++) {
                if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                    if ($ArrayCollect[$t][2] == -1) {
                        $ArrayCollect[$t][1] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][2] = $number_date;
                    }
                }
            }
            $number_date++;
        }

        for ($e = 0; $e < $len_collect - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect; $f++) {
                if ($ArrayCollect[$e][2] < $ArrayCollect[$f][2]) {
                    swap($ArrayCollect[$e][2], $ArrayCollect[$f][2]);
                    swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                    swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                }
            }
        }
        return $ArrayCollect;
    }

    /*
     * thống kê tần xuất
     */
    public function getTKTanSuat($date)
    {
        $rollingNumber = 30;
        $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take($rollingNumber)->get();

        // tạo mảng bộ số từ 00->99
        $arrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $arrayCollect[$i][0] = '0' . $i;
            } else {
                $arrayCollect[$i][0] = $i;
            }
            $arrayCollect[$i][1] = 0; //so lan xuat hien
            $arrayCollect[$i][2] = 0; //so ngay ve

        }
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);

            $len_array = count($arr_kq);
            for ($i = 0; $i < 100; $i++) {
                if (in_array($arrayCollect[$i][0], $arr_kq)) {
                    $arrayCollect[$i][2] = $arrayCollect[$i][2] + 1;
                }
                for ($j = 0; $j < $len_array; $j++) {
                    if ($arrayCollect[$i][0] == $arr_kq[$j]) {
                        $arrayCollect[$i][1] = $arrayCollect[$i][1] + 1;
                    }
                }
            }
        }

        $len_collect = count($arrayCollect);
        for ($e = 0; $e < $len_collect - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect; $f++) {
                if ($arrayCollect[$e][1] < $arrayCollect[$f][1]) {
                    swap($arrayCollect[$e][2], $arrayCollect[$f][2]);
                    swap($arrayCollect[$e][0], $arrayCollect[$f][0]);
                    swap($arrayCollect[$e][1], $arrayCollect[$f][1]);
                }
            }
        }
        return $arrayCollect;
    }
}
