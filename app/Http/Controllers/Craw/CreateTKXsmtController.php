<?php

namespace App\Http\Controllers\Craw;

use App\Models\Lottery;
use App\Models\Province;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CreateTKXsmtController extends Controller
{
    public function create()
    {
//        set_time_limit(0);
//        $posts = Post::where('category_id',2)->get();
//        foreach($posts as $post){
//            $content = $post->content;
//            $content = str_replace('http://ketqua68.x','https://ketqua68.net',$content);
//            $post->content = $content;
//            $post->save();
//        }
//        die('Xong!');
        Post::where('date', '>=', '2023-10-01')->where('category_id',2)->delete();
        set_time_limit(0);
        $kqs = Lottery::where('mien',2)->where('date', '>=', '2023-10-01')->orderBy('date', 'DESC')->select('date','day')->distinct()->get();
        foreach ($kqs as $kq) {
            $title = 'Thống kê XSMT ngày ' . getNgay($kq->date) . ' - Thống kê xổ số miền Trung ' . getThu($kq->day);
            $slug = 'thong-ke-xsmt-' . getNgayLink($kq->date);
            $content = trim($this->createTKXsmt($kq->date));

//            $meta_title = 'Thống kê XSMT ngày ' . getNgay($kq->date) . ' - Thống kê xổ số miền Trung ' . getThu($kq->day);
            $meta_description = 'Thống kê XSMT ngày ' . getNgay($kq->date) . ' - Thống kê xổ số miền Trung ' . getThu($kq->day) . '.Thống kê lô gan, lô về nhiều, cầu bạch thủ XSMT những con số may mắn và đẹp nhất ngày ' . getNgay($kq->date);
//            $meta_keyword = 'thống kê xsmt ' . getNgay($kq->date) . ',thống kê xsmt ngày ' . getThu($kq->day) . ',thống kê xsmt ' . getThu($kq->day) . ',thống kê xsmt ' . getNgayThang($kq->date) . ', thống kê xsmt, thong ke xsmt,thống kê xổ số miền trung, thong ke xo so mien trung';

//            echo '$title:' . $title . '<br/>';
//            echo '$slug:' . $slug . '<br/>';
//            echo '$meta_title:' . $meta_title . '<br/>';
//            echo '$meta_description:' . $meta_description . '<br/>';
//            echo '$meta_keyword:' . $meta_keyword . '<br/>';
//            echo '$content:' . $content . '<br/>';
//            die;

            $arr_text_xsmt = ['XSMT', 'SXMT', 'XS miền trung', 'KQXS miền trung', 'Xổ số miền trung', 'Xo so mien trung', 'XSMT hôm nay', 'KQXSMT'];
            $text_xsmt = $arr_text_xsmt[array_rand($arr_text_xsmt)];

            $arr_text_xs = ['KQXS', 'Xổ số', 'Kết quả xổ số', 'Ket qua xo so', 'Kết quả xổ số hôm nay', 'Xo so', 'XS', 'KQXS hôm nay', 'XSKT'];
            $text_xs = $arr_text_xs[array_rand($arr_text_xs)];

            $check = Post::where('date',$kq->date)->where('category_id',2)->first();
            if(count($check) > 0) continue;
            Post::firstOrCreate([
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'text_xsmien' => $text_xsmt,
                'text_xs' => $text_xs,
                'date' => $kq->date,
                'category_id' => 2,
                'img' => '/frontend/img/thong-ke-xsmt-' . rand(1, 20) . '.png',
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
    public function createTKXsmt($date)
    {
        $day = getThuNumber($date);
        $thu = getThu($day);
        $ngay = getNgay($date);
        $ngay_thang = getNgayThang($date);
        $provinces = Province::where('mien', 2)->where('ngay_quay', 'like', '%' . $day . '%')->get();

//        $arr_text_xsmt = ['XSMT', 'SXMT', 'XS miền trung', 'KQXS miền trung', 'Xổ số miền trung', 'Xo so mien trung', 'XSMT hôm nay', 'KQXSMT'];
//        $text_xsmt = $arr_text_xsmt[array_rand($arr_text_xsmt)];
//
//        $arr_text_xs = ['KQXS', 'Xổ số', 'Kết quả xổ số', 'Ket qua xo so', 'Kết quả xổ số hôm nay', 'Xo so', 'XS', 'KQXS hôm nay', 'XSKT'];
//        $text_xs = $arr_text_xs[array_rand($arr_text_xs)];
//
//        $cau_bach_thu = array();
//        foreach ($provinces as $province) {
//            $cau_bach_thu[$province->id] = $this->getCauMienNam($province->id, $date);
//        }
//
//        $lo_gans = array();
//        foreach ($provinces as $province) {
//            $lo_gans[$province->id] = $this->getTKLoGanMN($province->id, $date);
//        }
//
//        $lo_ve_nhieus = array();
//        foreach ($provinces as $province) {
//            $lo_ve_nhieus[$province->id] = $this->getTKTanSuat($province->id, $date);
//        }
//
//        // xổ số miền name
//        $xsmt = Lottery::where('mien', 2)->where('date', '<', $date)->where('status', 1)->orderBy('date', 'DESC')->first();
//        $xsmts = Lottery::where('mien', 2)->where('status', 1)->where('date', $xsmt->date)->get();

        return view('frontend.create_tk.content_mt', compact('xsmts', 'text_xs', 'text_xsmt', 'date', 'lo_ve_nhieus', 'lo_gans', 'cau_bach_thu', 'day', 'thu', 'ngay', 'ngay_thang', 'provinces'));
    }


    public function getCauMienNam($province_id, $date)
    {
        $xsmns = Lottery::where('mien', 2)->where('province_id', $province_id)->where('date', '<', $date)->where('status', 1)->orderBy('date', 'DESC')->take(14)->get();

        foreach ($xsmns as $xsmn) {
            $tmp_result1 = $xsmn->gdb . '-' . $xsmn->g1 . '-' . $xsmn->g2 . '-' . $xsmn->g3 . '-' . $xsmn->g4 . '-' . $xsmn->g5 . '-' . $xsmn->g6 . '-' . $xsmn->g7 . '-' . $xsmn->g8;
            $tmp_result2 = $xsmn->gdb . $xsmn->g1 . $xsmn->g2 . $xsmn->g3 . $xsmn->g4 . $xsmn->g5 . $xsmn->g6 . $xsmn->g7 . $xsmn->g8;

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

                    if (!empty($array_chuoi[$tmp_i][$m]) && !empty($array_chuoi[$tmp_i][$n])) {
                        $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];
                        $tmp2 = $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$m];
                    } else {
                        $tmp1 = '';
                        $tmp2 = '';
                    }


                    $arr_tmp = $arr_kq[$tmp_i - 1];

                    $tmp_dem = $dem;
                    if (in_array($tmp1, $arr_tmp) || in_array($tmp2, $arr_tmp)) {
                        $dem++;
                    }

                    while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                        $tmp_i--;

                        if (!empty($array_chuoi[$tmp_i][$m]) && !empty($array_chuoi[$tmp_i][$n])) {
                            $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];
                            $tmp2 = $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$m];
                        } else {
                            $tmp1 = '';
                            $tmp2 = '';
                        }
                        if ($tmp_i > 0) {
                            $arr_tmp = $arr_kq[$tmp_i - 1];
                            $tmp_dem = $dem;
                            if (in_array($tmp1, $arr_tmp) || in_array($tmp2, $arr_tmp)) {
                                $dem++;
                            }
                        }
                    }

                    if ($dem > 0 && $tmp_i == 0 && !in_array($tmp1, $arr_cau)) {
                        $ArrayCollect[$stt][0] = $tmp1;
                        $ArrayCollect[$stt][1] = $m;
                        $ArrayCollect[$stt][2] = $n;
                        $ArrayCollect[$stt][3] = $dem;
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
                if ($k == 2) {
                    foreach ($value as $item) {
                        return $item[0];
                    }
                }
            }
        }

    }


    public function getTKLoGanMN($province_id, $date)
    {
        $kqs = Lottery::where('province_id', $province_id)->where('date', '<', $date)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
        $province = Province::find($province_id);
        $province_name = $province->name;

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


    public function getTKTanSuat($province_id, $date)
    {
        $rollingNumber = 30;
        $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take($rollingNumber)->get();

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
