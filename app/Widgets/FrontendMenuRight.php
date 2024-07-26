<?php

namespace App\Widgets;

use App\Models\SoMoNew;
use Arrilot\Widgets\AbstractWidget;
use App\Models\Province;
use App\Models\Post;
use App\Models\SoMo;
use App\Models\Lottery;

class FrontendMenuRight extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $day = getThuNumber(date('Y-m-d', time()));
//        $xs_today_mb = Province::where('mien', 1)->where('ngay_quay', 'like', '%' . $day . '%')->get();
        $xs_today_mt = Province::where('mien', 2)->where('ngay_quay', 'like', '%' . $day . '%')->get();
        $xs_today_mn = Province::where('mien', 3)->where('ngay_quay', 'like', '%' . $day . '%')->get();

//        $yesterday = getThuNumber(date('Y-m-d', strtotime("-1 days")));
//        $xs_yesterday_tn = Province::where('ngay_quay', 'like', '%' . $yesterday . '%')
//            ->where(function ($query) {
//                $query->where('mien', 2)
//                    ->orWhere('mien', 3);
//            })
//            ->get();

        $mb_province = Province::where('mien', 1)->get();
        $mt_province = Province::where('mien', 2)->get();
        $mn_province = Province::where('mien', 3)->get();

        $postTK = Post::orderBy('date','DESC')->take(3)->get();
//        $somo = SoMoNew::orderBy('id', 'DESC')->take(5)->get();
//        $postGiaiMaGiacMo = GiaiMaGiacMo::orderBy('id','DESC')->take(4)->get();
//        $somo = SoMoNew::orderBy('id','DESC')->take(6)->get();


//        $getCauBachThu = $this->getCauBachThu();
        // tạo list cầu lô đẹp
//        $cauLoDep = $getCauBachThu['cau'];
//        $listCauLoDep = array();
//        foreach ($cauLoDep as $value) {
//            foreach ($value as $item) {
//                if (!in_array($item[0] . ',' . lon($item[0]), $listCauLoDep) && !in_array(lon($item[0]) . ',' . $item[0], $listCauLoDep) && substr($item[0], 0, 1) != substr($item[0], 1, 1)) {
//                    $listCauLoDep[] = $item[0] . ',' . lon($item[0]);
//                }
//
//                if (count($listCauLoDep) >= 10) break;
//            }
//            if (count($listCauLoDep) >= 10) break;
//        }

        // list đặc biệt đẹp
//        $listDBDep = array();
//        $cauDBDep = $this->getCauBachThuDB();
//        foreach ($cauDBDep as $value) {
//            foreach ($value as $item) {
//                if (!in_array($item[0] . ',' . lon($item[0]), $listDBDep) && !in_array(lon($item[0]) . ',' . $item[0], $listDBDep) && substr($item[0], 0, 1) != substr($item[0], 1, 1)) {
//                    $listDBDep[] = $item[0] . ',' . lon($item[0]);
//                }
//                if (count($listDBDep) >= 10) break;
//            }
//            if (count($listDBDep) >= 10) break;
//        }
//        $xsmb = Lottery::where('mien', 1)->orderBy('date', 'DESC')->first();
//
//        $date_new = date('d/m/Y', strtotime(getNgayLink($xsmb->date) . ' +1 days'));

        return view('widgets.frontend_menu_right', [
            'config' => $this->config,
//            'xs_today_mb' => $xs_today_mb,
            'xs_today_mt' => $xs_today_mt,
            'xs_today_mn' => $xs_today_mn,
//            'xs_yesterday_tn' => $xs_yesterday_tn,
            'day' => $day,
            'mb_province' => $mb_province,
            'mt_province' => $mt_province,
            'mn_province' => $mn_province,
//            'somo' => $somo,
            'postTK' => $postTK,
//            'postGiaiMaGiacMo' => $postGiaiMaGiacMo,
//            'listCauLoDep' => $listCauLoDep,
//            'listDBDep' => $listDBDep,
//            'date_new' => $date_new
        ]);
    }

    public function getCauBachThuDB()
    {
        $xsmbs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(6)->get();

        foreach ($xsmbs as $xsmb) {
//            $tmp_result1 = $xsmb->gdb . '-' . $xsmb->g1 . '-' . $xsmb->g2 . '-' . $xsmb->g3 . '-' . $xsmb->g4 . '-' . $xsmb->g5 . '-' . $xsmb->g6 . '-' . $xsmb->g7;
            $tmp_result2 = $xsmb->gdb . $xsmb->g1 . $xsmb->g2 . $xsmb->g3 . $xsmb->g4 . $xsmb->g5 . $xsmb->g6 . $xsmb->g7;

            $a = explode('-', $tmp_result2);
            $tmp_result3 = '';
            for ($l = 0; $l < count($a); ++$l) {
                $tmp_result3 .= $a[$l];
            }
//            $arr_kq[] = getLoto($tmp_result1);
            $arr_kq[] = [0 => substr($xsmb->gdb, strlen($xsmb->gdb) - 2)];
            $array_chuoi[] = $tmp_result3;
        }
        $len_array_chuoi = count($array_chuoi);
        $cau = array();
        $arr_cau = array();
        $arr_list_cau = array();
        for ($i = $len_array_chuoi - 1; $i >= 1; $i--) {
            $len_chuoi_con = strlen($array_chuoi[$i]);
            $ArrayCollect = array();
            $stt = 0;
            for ($m = 0; $m < $len_chuoi_con - 1; $m++) {
                for ($n = $m + 1; $n < $len_chuoi_con; $n++) {
                    $tmp_i = $i;
                    $dem = 0;
                    $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];
                    $arr_tmp = $arr_kq[$tmp_i - 1];

                    $tmp_dem = $dem;
                    if (in_array($tmp1, $arr_tmp)) {
                        $dem++;
                    }

                    while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                        $tmp_i--;
                        $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];

                        if ($tmp_i > 0) {
                            $arr_tmp = $arr_kq[$tmp_i - 1];
                            $tmp_dem = $dem;
                            if (in_array($tmp1, $arr_tmp)) {
                                $dem++;
                            }
                        }
                    }

                    if ($dem > 0 && $tmp_i == 0 && !in_array($tmp1, $arr_list_cau)) {
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
                $arr_cau[] = $item;
                $arr_list_cau[] = $item[0];
            }
            $cau[$i] = $ArrayCollect;
        }

        return $cau;
    }

    public function getCauBachThu()
    {
        $xsmbs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(14)->get();
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
        $arr_list_cau = array();
        for ($i = $len_array_chuoi - 1; $i >= 3; $i--) {
            $len_chuoi_con = strlen($array_chuoi[$i]);
            $ArrayCollect = array();
            $stt = 0;
            for ($m = 0; $m < $len_chuoi_con - 1; $m++) {
                for ($n = $m + 1; $n < $len_chuoi_con; $n++) {
                    $tmp_i = $i;
                    $dem = 0;
                    $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];
                    $arr_tmp = $arr_kq[$tmp_i - 1];

                    $tmp_dem = $dem;
                    if (in_array($tmp1, $arr_tmp)) {
                        $dem++;
                    }

                    while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                        $tmp_i--;
                        $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];

                        if ($tmp_i > 0) {
                            $arr_tmp = $arr_kq[$tmp_i - 1];
                            $tmp_dem = $dem;
                            if (in_array($tmp1, $arr_tmp)) {
                                $dem++;
                            }
                        }
                    }

                    if ($dem > 0 && $tmp_i == 0 && !in_array($tmp1, $arr_list_cau)) {
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
                $arr_cau[] = $item;
                $arr_list_cau[] = $item[0];
            }
            $cau[$i] = $ArrayCollect;
        }

        // tạo mảng bộ số từ 00->99
        $array_boso = array();
        for ($i = 0; $i < 100; $i++) {
            $key = $i;
            if ($key < 10) $key = '0' . $key;
            if ($i < 10) {
                $array_boso[$key][0] = '0' . $i;
            } else {
                $array_boso[$key][0] = $i;
            }
            $array_boso[$key][1] = 0; //so lan xuat hien
            $array_boso[$key][2] = 0; //vi trí 1
            $array_boso[$key][3] = 0; //biên độ

        }
        for ($i = 0; $i < 100; $i++) {
            $key = $i;
            if ($key < 10) $key = '0' . $key;
            for ($j = count($arr_cau) - 1; $j >= 0; $j--) {
                if ($array_boso[$key][0] == $arr_cau[$j][0]) {
                    $array_boso[$key][1] = $array_boso[$key][1] + 1;
                    $array_boso[$key][2] = $arr_cau[$j][1];
                    $array_boso[$key][3] = $arr_cau[$j][2];
                    $array_boso[$key][4] = $arr_cau[$j][3];
                }
            }
        }

        return ['array_boso' => $array_boso, 'cau' => $cau];
    }
}
