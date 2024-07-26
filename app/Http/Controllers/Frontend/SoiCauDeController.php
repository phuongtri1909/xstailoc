<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use Cache;

class SoiCauDeController extends Controller
{
    public function getSoiCauDe()
    {
        $kqToDay = $this->checkKQToDay();
        $ngay = date('d/m/Y');
        if ($kqToDay) $ngay = date('d/m/Y', strtotime('+1 days'));
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.soicaude.soi-cau-de', compact('ngay', 'provinces'));
    }

    // Cầu bạch thủ
    public function getCauBachThu_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauBachThu_' . $date.'_'.$kqToDay_type)) {
//            $view = Cache::get('CauBachThu_' . $date.'_'.$kqToDay_type);
//        } else {
            $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
            $arr_loto_today = array();
            if (!empty($xsmb_today)) {
                $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }

            $type = 1;
            $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) == $xsmb_latest->date) {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
                $xsmbs_result = $xsmbs;
            } else {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(7)->get();
                $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
                $type = 2;
            }

            foreach ($xsmbs_result as $xsmb) {
                $tmp_result1 = $xsmb->gdb;
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
                            $ArrayCollect[$stt][1] = $m + 1;
                            $ArrayCollect[$stt][2] = $n + 1;
                            $ArrayCollect[$stt][3] = $dem;

                            // check xem lô tô có về không
                            $ArrayCollect[$stt][4] = 0; // lô tô thường
                            if (count($arr_loto_today) > 0) {
//                                if (in_array($tmp1, $arr_loto_today)) {
//                                    $ArrayCollect[$stt][4] = 1; // lô tô đã về
//                                }
                                if ($tmp1 == $arr_loto_today[0]) {
                                    $ArrayCollect[$stt][4] = 2; // về DB
                                }
                            }


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
                                swap($ArrayCollect[$e][4], $ArrayCollect[$f][4]);
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
                $array_boso[$key][3] = 0; //vi trí 2
                $array_boso[$key][4] = 0; //số ngày cầu chạy
                $array_boso[$key][5] = 0; //// check xem lô tô có về không

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
                        $array_boso[$key][5] = $arr_cau[$j][4];
                    }
                }
            }

            $arrdates = '';
            $arrPos = '';
            $arrPos_first = '';
            foreach ($xsmbs as $xsmb) {
                $date_section = getDateLienNhau($xsmb->date);
                $arrdates .= "'" . $date_section . "',";
                $arrPos .= "A" . $date_section . ",";
                if (empty($arrPos_first)) {
                    $arrPos_first = "A" . $date_section;
                }
            }
            $arrdates = substr($arrdates, 0, -1);
            $arrPos = substr($arrPos, 0, -1);

            $lifetime = '';
            $valuelt = '';
            $positionOne = '';
            $positionTwo = '';
            for ($i = 1; $i < count($cau); $i++) {
                if (count($cau[$i]) > 0) {
                    foreach ($cau[$i] as $item) {
                        $lifetime .= $i . ',';
                        $positionOne .= $item[1] . ',';
                        $positionTwo .= $item[2] . ',';
                        $valuelt .= "'" . $item[0] . "',";
                    }
                }
            }
            $lifetime = substr($lifetime, 0, -1);
            $positionOne = substr($positionOne, 0, -1);
            $positionTwo = substr($positionTwo, 0, -1);
            $valuelt = substr($valuelt, 0, -1);

            $arr_js['arrdates'] = $arrdates;
            $arr_js['arrPos'] = $arrPos;
            $arr_js['lifetime'] = $lifetime;
            $arr_js['positionOne'] = $positionOne;
            $arr_js['positionTwo'] = $positionTwo;
            $arr_js['valuelt'] = $valuelt;
            $arr_js['arrPos_first'] = $arrPos_first;

            $view = view('frontend.soicaude.cau-bach-thu-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauBachThu_' . $date.'_'.$kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu lộn
    public function getCauLon_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if($kqToDay) $kqToDay_type = 1;
        
//        if (Cache::has('CauLon_' . $date.'_'.$kqToDay_type)) {
//            $view = Cache::get('CauLon_' . $date.'_'.$kqToDay_type);
//        } else {
            $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
            $arr_loto_today = array();
            if (!empty($xsmb_today)) {
                $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }

            $type = 1;
            $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) == $xsmb_latest->date) {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
                $xsmbs_result = $xsmbs;
            } else {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(7)->get();
                $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
                $type = 2;
            }

            foreach ($xsmbs_result as $xsmb) {
                $tmp_result1 = $xsmb->gdb;
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
            for ($i = $len_array_chuoi - 1; $i >= 1; $i--) {
                $len_chuoi_con = strlen($array_chuoi[$i]);
                $ArrayCollect = array();
                $stt = 0;
                for ($m = 0; $m < $len_chuoi_con - 1; $m++) {
                    for ($n = $m + 1; $n < $len_chuoi_con; $n++) {
                        $tmp_i = $i;
                        $dem = 0;
                        $tmp1 = $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$m];
                        $arr_tmp = $arr_kq[$tmp_i - 1];

                        $tmp_dem = $dem;
                        if (in_array($tmp1, $arr_tmp)) {
                            $dem++;
                        }

                        while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                            $tmp_i--;
                            $tmp1 = $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$m];

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
                            $ArrayCollect[$stt][1] = $m + 1;
                            $ArrayCollect[$stt][2] = $n + 1;
                            $ArrayCollect[$stt][3] = $dem;

                            // check xem lô tô có về không
                            $ArrayCollect[$stt][4] = 0; // lô tô thường
                            if (count($arr_loto_today) > 0) {
//                                if (in_array($tmp1, $arr_loto_today)) {
//                                    $ArrayCollect[$stt][4] = 1; // lô tô đã về
//                                }
                                if ($tmp1 == $arr_loto_today[0]) {
                                    $ArrayCollect[$stt][4] = 2; // về DB
                                }
                            }


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
                                swap($ArrayCollect[$e][4], $ArrayCollect[$f][4]);
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
                $array_boso[$key][3] = 0; //vi trí 2
                $array_boso[$key][4] = 0; //số ngày cầu chạy
                $array_boso[$key][5] = 0; //// check xem lô tô có về không

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
                        $array_boso[$key][5] = $arr_cau[$j][4];
                    }
                }
            }

            $arrdates = '';
            $arrPos = '';
            $arrPos_first = '';
            foreach ($xsmbs as $xsmb) {
                $date_section = getDateLienNhau($xsmb->date);
                $arrdates .= "'" . $date_section . "',";
                $arrPos .= "A" . $date_section . ",";
                if (empty($arrPos_first)) {
                    $arrPos_first = "A" . $date_section;
                }
            }
            $arrdates = substr($arrdates, 0, -1);
            $arrPos = substr($arrPos, 0, -1);

            $lifetime = '';
            $valuelt = '';
            $positionOne = '';
            $positionTwo = '';
            for ($i = 1; $i < count($cau); $i++) {
                if (count($cau[$i]) > 0) {
                    foreach ($cau[$i] as $item) {
                        $lifetime .= $i . ',';
                        $positionOne .= $item[1] . ',';
                        $positionTwo .= $item[2] . ',';
                        $valuelt .= "'" . $item[0] . "',";
                    }
                }
            }
            $lifetime = substr($lifetime, 0, -1);
            $positionOne = substr($positionOne, 0, -1);
            $positionTwo = substr($positionTwo, 0, -1);
            $valuelt = substr($valuelt, 0, -1);

            $arr_js['arrdates'] = $arrdates;
            $arr_js['arrPos'] = $arrPos;
            $arr_js['lifetime'] = $lifetime;
            $arr_js['positionOne'] = $positionOne;
            $arr_js['positionTwo'] = $positionTwo;
            $arr_js['valuelt'] = $valuelt;
            $arr_js['arrPos_first'] = $arrPos_first;

            $view = view('frontend.soicaude.cau-lon-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauLon_' . $date.'_'.$kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu 3 càng lô
    public function getCau3CangDe_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if($kqToDay) $kqToDay_type = 1;
        
//        if (Cache::has('Cau3CangLo_' . $date.'_'.$kqToDay_type)) {
//            $view = Cache::get('Cau3CangLo_' . $date.'_'.$kqToDay_type);
//        } else {
            $kqToDay = $this->checkKQToDay();

            $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
            $arr_loto_today = array();
            if (!empty($xsmb_today)) {
                $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6;
                $arr_loto_today = getLoto3Cang($tmp_result_today);
            }

            $type = 1;
            $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) == $xsmb_latest->date) {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
                $xsmbs_result = $xsmbs;
            } else {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(7)->get();
                $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
                $type = 2;
            }

            foreach ($xsmbs_result as $xsmb) {
                $tmp_result1 = $xsmb->gdb;
                $tmp_result2 = $xsmb->gdb . $xsmb->g1 . $xsmb->g2 . $xsmb->g3 . $xsmb->g4 . $xsmb->g5 . $xsmb->g6 . $xsmb->g7;

                $a = explode('-', $tmp_result2);
                $tmp_result3 = '';
                for ($l = 0; $l < count($a); ++$l) {
                    $tmp_result3 .= $a[$l];
                }
                $arr_kq[] = getLoto3Cang($tmp_result1);
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
                for ($m = 0; $m < $len_chuoi_con - 2; $m++) {
                    for ($n = $m + 1; $n < $len_chuoi_con - 1; $n++) {
                        for ($t = $n + 1; $t < $len_chuoi_con; $t++) {
                            $tmp_i = $i;
                            $dem = 0;
                            $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$t];
                            $arr_tmp = $arr_kq[$tmp_i - 1];

                            $tmp_dem = $dem;
                            if (in_array($tmp1, $arr_tmp)) {
                                $dem++;
                            }

                            while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                                $tmp_i--;
                                $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$t];

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
                                $ArrayCollect[$stt][1] = $m + 1;
                                $ArrayCollect[$stt][2] = $n + 1;
                                $ArrayCollect[$stt][3] = $t + 1;
                                $ArrayCollect[$stt][4] = $dem;

                                // check xem lô tô có về không
                                $ArrayCollect[$stt][5] = 0; // lô tô thường
                                if (count($arr_loto_today) > 0) {
//                                    if (in_array($tmp1, $arr_loto_today)) {
//                                        $ArrayCollect[$stt][5] = 1; // lô tô đã về
//                                    }
                                    if ($tmp1 == $arr_loto_today[0]) {
                                        $ArrayCollect[$stt][5] = 2; // về DB
                                    }
                                }


                                $stt++;
                            }
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
                                swap($ArrayCollect[$e][4], $ArrayCollect[$f][4]);
                                swap($ArrayCollect[$e][5], $ArrayCollect[$f][5]);
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
//        $array_boso = array();
//        for ($i = 0; $i < 100; $i++) {
//            $key = $i;
//            if ($key < 10) $key = '0' . $key;
//            if ($i < 10) {
//                $array_boso[$key][0] = '0' . $i;
//            } else {
//                $array_boso[$key][0] = $i;
//            }
//            $array_boso[$key][1] = 0; //so lan xuat hien
//            $array_boso[$key][2] = 0; //vi trí 1
//            $array_boso[$key][3] = 0; //vi trí 2
//            $array_boso[$key][4] = 0; //vi trí 3
//            $array_boso[$key][5] = 0; //số ngày cầu chạy
//            $array_boso[$key][6] = 0; //// check xem lô tô có về không
//
//        }
//        for ($i = 0; $i < 100; $i++) {
//            $key = $i;
//            if ($key < 10) $key = '0' . $key;
//            for ($j = count($arr_cau) - 1; $j >= 0; $j--) {
//                if ($array_boso[$key][0] == $arr_cau[$j][0]) {
//                    $array_boso[$key][1] = $array_boso[$key][1] + 1;
//                    $array_boso[$key][2] = $arr_cau[$j][1];
//                    $array_boso[$key][3] = $arr_cau[$j][2];
//                    $array_boso[$key][4] = $arr_cau[$j][3];
//                    $array_boso[$key][5] = $arr_cau[$j][4];
//                    $array_boso[$key][6] = $arr_cau[$j][5];
//                }
//            }
//        }

            $arrdates = '';
            $arrPos = '';
            $arrPos_first = '';
            foreach ($xsmbs as $xsmb) {
                $date_section = getDateLienNhau($xsmb->date);
                $arrdates .= "'" . $date_section . "',";
                $arrPos .= "A" . $date_section . ",";
                if (empty($arrPos_first)) {
                    $arrPos_first = "A" . $date_section;
                }
            }
            $arrdates = substr($arrdates, 0, -1);
            $arrPos = substr($arrPos, 0, -1);

            $lifetime = '';
            $valuelt = '';
            $positionOne = '';
            $positionTwo = '';
            $positionThree = '';
            for ($i = 1; $i < count($cau); $i++) {
                if (count($cau[$i]) > 0) {
                    foreach ($cau[$i] as $item) {
                        $lifetime .= $i . ',';
                        $positionOne .= $item[1] . ',';
                        $positionTwo .= $item[2] . ',';
                        $positionThree .= $item[3] . ',';
                        $valuelt .= "'" . $item[0] . "',";
                    }
                }
            }
            $lifetime = substr($lifetime, 0, -1);
            $positionOne = substr($positionOne, 0, -1);
            $positionTwo = substr($positionTwo, 0, -1);
            $positionThree = substr($positionThree, 0, -1);
            $valuelt = substr($valuelt, 0, -1);

            $arr_js['arrdates'] = $arrdates;
            $arr_js['arrPos'] = $arrPos;
            $arr_js['lifetime'] = $lifetime;
            $arr_js['positionOne'] = $positionOne;
            $arr_js['positionTwo'] = $positionTwo;
            $arr_js['positionThree'] = $positionThree;
            $arr_js['valuelt'] = $valuelt;
            $arr_js['arrPos_first'] = $arrPos_first;

            $view = view('frontend.soicaude.cau-3cang-de-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'kqToDay', 'date'))->render();
//            Cache::put('Cau3CangLo_' . $date.'_'.$kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu chạm đầu
    public function getCauChamDau_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauBachThu_' . $date.'_'.$kqToDay_type)) {
//            $view = Cache::get('CauBachThu_' . $date.'_'.$kqToDay_type);
//        } else {
        $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
        $dau_db_today = '';
        if (!empty($xsmb_today)) {
            $dau_db_today = substr($xsmb_today->gdb,-2,1);
        }
//        $arr_loto_today = array();
//        if (!empty($xsmb_today)) {
//            $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
//            $arr_loto_today = getLoto($tmp_result_today);
//        }

        $type = 1;
        $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
        if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) == $xsmb_latest->date) {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
            $xsmbs_result = $xsmbs;
        } else {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(7)->get();
            $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
            $type = 2;
        }

        foreach ($xsmbs_result as $xsmb) {
            $tmp_result1 = $xsmb->gdb;
            $tmp_result2 = $xsmb->gdb . $xsmb->g1 . $xsmb->g2 . $xsmb->g3 . $xsmb->g4 . $xsmb->g5 . $xsmb->g6 . $xsmb->g7;

            $a = explode('-', $tmp_result2);
            $tmp_result3 = '';
            for ($l = 0; $l < count($a); ++$l) {
                $tmp_result3 .= $a[$l];
            }
//            $arr_kq[] = getLoto($tmp_result1);
            $arr_kq[] = substr($tmp_result1,-2);
            $array_chuoi[] = $tmp_result3;
        }

        $len_array_chuoi = count($array_chuoi);
        $cau = array();
        $arr_cau = array();
        $arr_list_cau = array();
        for ($i = $len_array_chuoi - 1; $i >= 2; $i--) {
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
                    if ($array_chuoi[$tmp_i][$m]==$arr_tmp[0] || $array_chuoi[$tmp_i][$n]==$arr_tmp[0]) {
                        $dem++;
                    }

//                    if (in_array($tmp1, $arr_tmp)) {
//                        $dem++;
//                    }

                    while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                        $tmp_i--;
                        $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];

                        if ($tmp_i > 0) {
                            $arr_tmp = $arr_kq[$tmp_i - 1];
                            $tmp_dem = $dem;
                            if ($array_chuoi[$tmp_i][$m]==$arr_tmp[0] || $array_chuoi[$tmp_i][$n]==$arr_tmp[0]) {
                                $dem++;
                            }

//                            if (in_array($tmp1, $arr_tmp)) {
//                                $dem++;
//                            }
                        }
                    }

                    if ($dem > 0 && $tmp_i == 0 && !in_array($tmp1, $arr_list_cau)) {
                        $ArrayCollect[$stt][0] = $tmp1;
                        $ArrayCollect[$stt][1] = $m + 1;
                        $ArrayCollect[$stt][2] = $n + 1;
                        $ArrayCollect[$stt][3] = $dem;

                        // check xem lô tô có về không
                        $ArrayCollect[$stt][4] = 0; // lô tô thường
                        if (!empty($dau_db_today)) {
                            if ($tmp1[0]==$dau_db_today || $tmp1[1]==$dau_db_today) {
                                $ArrayCollect[$stt][4] = 2; // về DB
                            }
                        }


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
                            swap($ArrayCollect[$e][4], $ArrayCollect[$f][4]);
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
            $array_boso[$key][3] = 0; //vi trí 2
            $array_boso[$key][4] = 0; //số ngày cầu chạy
            $array_boso[$key][5] = 0; //// check xem lô tô có về không

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
                    $array_boso[$key][5] = $arr_cau[$j][4];
                }
            }
        }

        $arrdates = '';
        $arrPos = '';
        $arrPos_first = '';
        foreach ($xsmbs as $xsmb) {
            $date_section = getDateLienNhau($xsmb->date);
            $arrdates .= "'" . $date_section . "',";
            $arrPos .= "A" . $date_section . ",";
            if (empty($arrPos_first)) {
                $arrPos_first = "A" . $date_section;
            }
        }
        $arrdates = substr($arrdates, 0, -1);
        $arrPos = substr($arrPos, 0, -1);

        $lifetime = '';
        $valuelt = '';
        $positionOne = '';
        $positionTwo = '';
        for ($i = 2; $i < count($cau); $i++) {
            if (count($cau[$i]) > 0) {
                foreach ($cau[$i] as $item) {
                    $lifetime .= $i . ',';
                    $positionOne .= $item[1] . ',';
                    $positionTwo .= $item[2] . ',';
                    $valuelt .= "'" . $item[0] . "',";
                }
            }
        }
        $lifetime = substr($lifetime, 0, -1);
        $positionOne = substr($positionOne, 0, -1);
        $positionTwo = substr($positionTwo, 0, -1);
        $valuelt = substr($valuelt, 0, -1);

        $arr_js['arrdates'] = $arrdates;
        $arr_js['arrPos'] = $arrPos;
        $arr_js['lifetime'] = $lifetime;
        $arr_js['positionOne'] = $positionOne;
        $arr_js['positionTwo'] = $positionTwo;
        $arr_js['valuelt'] = $valuelt;
        $arr_js['arrPos_first'] = $arrPos_first;

        $view = view('frontend.soicaude.cau-cham-dau-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauBachThu_' . $date.'_'.$kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu chạm tổng 1s
    public function getCauChamTong1s_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauBachThu_' . $date.'_'.$kqToDay_type)) {
//            $view = Cache::get('CauBachThu_' . $date.'_'.$kqToDay_type);
//        } else {
        $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
        $tong_db_today = '';
        if (!empty($xsmb_today)) {
            $tong_db_today = Tong(substr($xsmb_today->gdb,-2));
        }
//        $arr_loto_today = array();
//        if (!empty($xsmb_today)) {
//            $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
//            $arr_loto_today = getLoto($tmp_result_today);
//        }

        $type = 1;
        $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
        if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) == $xsmb_latest->date) {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
            $xsmbs_result = $xsmbs;
        } else {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(7)->get();
            $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
            $type = 2;
        }

        foreach ($xsmbs_result as $xsmb) {
            $tmp_result1 = $xsmb->gdb;
            $tmp_result2 = $xsmb->gdb . $xsmb->g1 . $xsmb->g2 . $xsmb->g3 . $xsmb->g4 . $xsmb->g5 . $xsmb->g6 . $xsmb->g7;

            $a = explode('-', $tmp_result2);
            $tmp_result3 = '';
            for ($l = 0; $l < count($a); ++$l) {
                $tmp_result3 .= $a[$l];
            }
//            $arr_kq[] = getLoto($tmp_result1);
            $arr_kq[] = substr($tmp_result1,-2);
            $array_chuoi[] = $tmp_result3;
        }

//        print_ok($arr_kq);die;

        $len_array_chuoi = count($array_chuoi);
        $cau = array();
        $arr_cau = array();
        $arr_list_cau = array();
        for ($i = $len_array_chuoi - 1; $i >= 1; $i--) {
            $len_chuoi_con = strlen($array_chuoi[$i]);
            $ArrayCollect = array();
            $stt = 0;
            for ($m = 0; $m < $len_chuoi_con ; $m++) {
                    $tmp_i = $i;
                    $dem = 0;
                    $tmp1 = $array_chuoi[$tmp_i][$m].$array_chuoi[$tmp_i][$m];
                    $arr_tmp = $arr_kq[$tmp_i - 1];

                    $tmp_dem = $dem;
                    if ($array_chuoi[$tmp_i][$m] == Tong($arr_tmp)) {
                        $dem++;
                    }

                    while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                        $tmp_i--;
                        $tmp1 = $array_chuoi[$tmp_i][$m].$array_chuoi[$tmp_i][$m];

                        if ($tmp_i > 0) {
                            $arr_tmp = $arr_kq[$tmp_i - 1];
                            $tmp_dem = $dem;
                            if ($array_chuoi[$tmp_i][$m] == Tong($arr_tmp)) {
                                $dem++;
                            }

//                            if (in_array($tmp1, $arr_tmp)) {
//                                $dem++;
//                            }
                        }
                    }

                    if ($dem > 0 && $tmp_i == 0 && !in_array($tmp1, $arr_list_cau)) {
                        $ArrayCollect[$stt][0] = $tmp1;
                        $ArrayCollect[$stt][1] = $m + 1;
                        $ArrayCollect[$stt][2] = $m + 1;
                        $ArrayCollect[$stt][3] = $dem;

                        // check xem lô tô có về không
                        $ArrayCollect[$stt][4] = 0; // lô tô thường
                        if (!empty($tong_db_today)) {
                            if ($tmp1[0] == $tong_db_today) {
                                $ArrayCollect[$stt][4] = 2; // về DB
                            }
                        }


                        $stt++;
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
                            swap($ArrayCollect[$e][4], $ArrayCollect[$f][4]);
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
            $array_boso[$key][3] = 0; //vi trí 2
            $array_boso[$key][4] = 0; //số ngày cầu chạy
            $array_boso[$key][5] = 0; //// check xem lô tô có về không

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
                    $array_boso[$key][5] = $arr_cau[$j][4];
                }
            }
        }

        $arrdates = '';
        $arrPos = '';
        $arrPos_first = '';
        foreach ($xsmbs as $xsmb) {
            $date_section = getDateLienNhau($xsmb->date);
            $arrdates .= "'" . $date_section . "',";
            $arrPos .= "A" . $date_section . ",";
            if (empty($arrPos_first)) {
                $arrPos_first = "A" . $date_section;
            }
        }
        $arrdates = substr($arrdates, 0, -1);
        $arrPos = substr($arrPos, 0, -1);

        $lifetime = '';
        $valuelt = '';
        $positionOne = '';
        $positionTwo = '';
        for ($i = 1; $i < count($cau); $i++) {
            if (count($cau[$i]) > 0) {
                foreach ($cau[$i] as $item) {
                    $lifetime .= $i . ',';
                    $positionOne .= $item[1] . ',';
                    $positionTwo .= $item[2] . ',';
                    $valuelt .= "'" . $item[0] . "',";
                }
            }
        }
        $lifetime = substr($lifetime, 0, -1);
        $positionOne = substr($positionOne, 0, -1);
        $positionTwo = substr($positionTwo, 0, -1);
        $valuelt = substr($valuelt, 0, -1);

        $arr_js['arrdates'] = $arrdates;
        $arr_js['arrPos'] = $arrPos;
        $arr_js['lifetime'] = $lifetime;
        $arr_js['positionOne'] = $positionOne;
        $arr_js['positionTwo'] = $positionTwo;
        $arr_js['valuelt'] = $valuelt;
        $arr_js['arrPos_first'] = $arrPos_first;

        $view = view('frontend.soicaude.cau-cham-tong1s-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauBachThu_' . $date.'_'.$kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu chạm đầu
    public function getCauChamTong2s_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauBachThu_' . $date.'_'.$kqToDay_type)) {
//            $view = Cache::get('CauBachThu_' . $date.'_'.$kqToDay_type);
//        } else {
        $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
        $tong_db_today = '';
        if (!empty($xsmb_today)) {
            $tong_db_today = Tong(substr($xsmb_today->gdb,-2));
        }
//        $arr_loto_today = array();
//        if (!empty($xsmb_today)) {
//            $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
//            $arr_loto_today = getLoto($tmp_result_today);
//        }

        $type = 1;
        $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
        if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) == $xsmb_latest->date) {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
            $xsmbs_result = $xsmbs;
        } else {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(7)->get();
            $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
            $type = 2;
        }

        foreach ($xsmbs_result as $xsmb) {
            $tmp_result1 = $xsmb->gdb;
            $tmp_result2 = $xsmb->gdb . $xsmb->g1 . $xsmb->g2 . $xsmb->g3 . $xsmb->g4 . $xsmb->g5 . $xsmb->g6 . $xsmb->g7;

            $a = explode('-', $tmp_result2);
            $tmp_result3 = '';
            for ($l = 0; $l < count($a); ++$l) {
                $tmp_result3 .= $a[$l];
            }
//            $arr_kq[] = getLoto($tmp_result1);
            $arr_kq[] = substr($tmp_result1,-2);
            $array_chuoi[] = $tmp_result3;
        }

        $len_array_chuoi = count($array_chuoi);
        $cau = array();
        $arr_cau = array();
        $arr_list_cau = array();
        for ($i = $len_array_chuoi - 1; $i >= 2; $i--) {
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
                    if ($array_chuoi[$tmp_i][$m]==Tong($arr_tmp) || $array_chuoi[$tmp_i][$n]==Tong($arr_tmp)) {
                        $dem++;
                    }

//                    if (in_array($tmp1, $arr_tmp)) {
//                        $dem++;
//                    }

                    while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                        $tmp_i--;
                        $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];

                        if ($tmp_i > 0) {
                            $arr_tmp = $arr_kq[$tmp_i - 1];
                            $tmp_dem = $dem;
                            if ($array_chuoi[$tmp_i][$m]==Tong($arr_tmp) || $array_chuoi[$tmp_i][$n]==Tong($arr_tmp)) {
                                $dem++;
                            }

//                            if (in_array($tmp1, $arr_tmp)) {
//                                $dem++;
//                            }
                        }
                    }

                    if ($dem > 0 && $tmp_i == 0 && !in_array($tmp1, $arr_list_cau)) {
                        $ArrayCollect[$stt][0] = $tmp1;
                        $ArrayCollect[$stt][1] = $m + 1;
                        $ArrayCollect[$stt][2] = $n + 1;
                        $ArrayCollect[$stt][3] = $dem;

                        // check xem lô tô có về không
                        $ArrayCollect[$stt][4] = 0; // lô tô thường
                        if (!empty($tong_db_today)) {
                            if ($tmp1[0]==$tong_db_today || $tmp1[1]==$tong_db_today) {
                                $ArrayCollect[$stt][4] = 2; // về DB
                            }
                        }


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
                            swap($ArrayCollect[$e][4], $ArrayCollect[$f][4]);
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
            $array_boso[$key][3] = 0; //vi trí 2
            $array_boso[$key][4] = 0; //số ngày cầu chạy
            $array_boso[$key][5] = 0; //// check xem lô tô có về không

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
                    $array_boso[$key][5] = $arr_cau[$j][4];
                }
            }
        }

        $arrdates = '';
        $arrPos = '';
        $arrPos_first = '';
        foreach ($xsmbs as $xsmb) {
            $date_section = getDateLienNhau($xsmb->date);
            $arrdates .= "'" . $date_section . "',";
            $arrPos .= "A" . $date_section . ",";
            if (empty($arrPos_first)) {
                $arrPos_first = "A" . $date_section;
            }
        }
        $arrdates = substr($arrdates, 0, -1);
        $arrPos = substr($arrPos, 0, -1);

        $lifetime = '';
        $valuelt = '';
        $positionOne = '';
        $positionTwo = '';
        for ($i = 2; $i < count($cau); $i++) {
            if (count($cau[$i]) > 0) {
                foreach ($cau[$i] as $item) {
                    $lifetime .= $i . ',';
                    $positionOne .= $item[1] . ',';
                    $positionTwo .= $item[2] . ',';
                    $valuelt .= "'" . $item[0] . "',";
                }
            }
        }
        $lifetime = substr($lifetime, 0, -1);
        $positionOne = substr($positionOne, 0, -1);
        $positionTwo = substr($positionTwo, 0, -1);
        $valuelt = substr($valuelt, 0, -1);

        $arr_js['arrdates'] = $arrdates;
        $arr_js['arrPos'] = $arrPos;
        $arr_js['lifetime'] = $lifetime;
        $arr_js['positionOne'] = $positionOne;
        $arr_js['positionTwo'] = $positionTwo;
        $arr_js['valuelt'] = $valuelt;
        $arr_js['arrPos_first'] = $arrPos_first;

        $view = view('frontend.soicaude.cau-cham-tong2s-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauBachThu_' . $date.'_'.$kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu theo bộ
    public function getCauTheoBo_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauBachThu_' . $date.'_'.$kqToDay_type)) {
//            $view = Cache::get('CauBachThu_' . $date.'_'.$kqToDay_type);
//        } else {
        $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
        $arr_loto_today = array();
        if (!empty($xsmb_today)) {
            $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
            $arr_loto_today = getLoto($tmp_result_today);
        }

        $type = 1;
        $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
        if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) == $xsmb_latest->date) {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
            $xsmbs_result = $xsmbs;
        } else {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(7)->get();
            $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
            $type = 2;
        }

        foreach ($xsmbs_result as $xsmb) {
            $tmp_result1 = $xsmb->gdb;
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
        for ($i = $len_array_chuoi - 1; $i >= 2; $i--) {
            $len_chuoi_con = strlen($array_chuoi[$i]);
            $ArrayCollect = array();
            $stt = 0;
            for ($m = 0; $m < $len_chuoi_con - 1; $m++) {
                for ($n = $m + 1; $n < $len_chuoi_con; $n++) {
                    $tmp_i = $i;
                    $dem = 0;
                    $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];
                    $arr_tmp = $arr_kq[$tmp_i - 1];

                    // tạo bộ 8 số
                    $a1 = $array_chuoi[$tmp_i][$m];
                    $b1 = $array_chuoi[$tmp_i][$n];

                    if($a1 < 5) $a2= $a1 + 5;
                    else $a2= $a1 - 5;

                    if($b1 < 5) $b2= $b1 + 5;
                    else $b2= $b1 - 5;

                    $arr_boso = [$a1.$b1,$a1.$b2,$b1.$a1,$b2.$a1,$a2.$b1,$b1.$a2,$a2.$b2,$b2.$a2];
                    $arr_boso = array_unique($arr_boso);
                    // End tạo bộ 8 số

                    $tmp_dem = $dem;
                    if (count(array_intersect($arr_tmp,$arr_boso)) > 0) {
                        $dem++;
                    }

                    while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                        $tmp_i--;
                        $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];
                        // tạo bộ 8 số
                        $a1 = $array_chuoi[$tmp_i][$m];
                        $b1 = $array_chuoi[$tmp_i][$n];

                        if($a1 < 5) $a2= $a1 + 5;
                        else $a2= $a1 - 5;

                        if($b1 < 5) $b2= $b1 + 5;
                        else $b2= $b1 - 5;

                        $arr_boso = [$a1.$b1,$a1.$b2,$b1.$a1,$b2.$a1,$a2.$b1,$b1.$a2,$a2.$b2,$b2.$a2];
                        $arr_boso = array_unique($arr_boso);
                        // End tạo bộ 8 số
                        if ($tmp_i > 0) {
                            $arr_tmp = $arr_kq[$tmp_i - 1];
                            $tmp_dem = $dem;
                            if (count(array_intersect($arr_tmp,$arr_boso)) > 0) {
                                $dem++;
                            }
                        }
                    }

                    if ($dem > 0 && $tmp_i == 0 && !in_array($tmp1, $arr_list_cau)) {
                        $ArrayCollect[$stt][0] = $tmp1;
                        $ArrayCollect[$stt][1] = $m + 1;
                        $ArrayCollect[$stt][2] = $n + 1;
                        $ArrayCollect[$stt][3] = $dem;

                        // check xem lô tô có về không
                        $ArrayCollect[$stt][4] = 0; // lô tô thường
                        if (count($arr_loto_today) > 0) {
//                            if (count(array_intersect($arr_boso, $arr_loto_today)) > 0) {
//                                $ArrayCollect[$stt][4] = 1; // lô tô đã về
//                            }
                            if (in_array($arr_loto_today[0], $arr_boso)) {
                                $ArrayCollect[$stt][4] = 2; // về DB
                            }
                        }


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
                            swap($ArrayCollect[$e][4], $ArrayCollect[$f][4]);
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
            $array_boso[$key][3] = 0; //vi trí 2
            $array_boso[$key][4] = 0; //số ngày cầu chạy
            $array_boso[$key][5] = 0; //// check xem lô tô có về không

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
                    $array_boso[$key][5] = $arr_cau[$j][4];
                }
            }
        }

        $arrdates = '';
        $arrPos = '';
        $arrPos_first = '';
        foreach ($xsmbs as $xsmb) {
            $date_section = getDateLienNhau($xsmb->date);
            $arrdates .= "'" . $date_section . "',";
            $arrPos .= "A" . $date_section . ",";
            if (empty($arrPos_first)) {
                $arrPos_first = "A" . $date_section;
            }
        }
        $arrdates = substr($arrdates, 0, -1);
        $arrPos = substr($arrPos, 0, -1);

        $lifetime = '';
        $valuelt = '';
        $positionOne = '';
        $positionTwo = '';
        for ($i =2; $i < count($cau); $i++) {
            if (count($cau[$i]) > 0) {
                foreach ($cau[$i] as $item) {
                    $lifetime .= $i . ',';
                    $positionOne .= $item[1] . ',';
                    $positionTwo .= $item[2] . ',';
                    $valuelt .= "'" . $item[0] . "',";
                }
            }
        }
        $lifetime = substr($lifetime, 0, -1);
        $positionOne = substr($positionOne, 0, -1);
        $positionTwo = substr($positionTwo, 0, -1);
        $valuelt = substr($valuelt, 0, -1);

        $arr_js['arrdates'] = $arrdates;
        $arr_js['arrPos'] = $arrPos;
        $arr_js['lifetime'] = $lifetime;
        $arr_js['positionOne'] = $positionOne;
        $arr_js['positionTwo'] = $positionTwo;
        $arr_js['valuelt'] = $valuelt;
        $arr_js['arrPos_first'] = $arrPos_first;

        $view = view('frontend.soicaude.cau-bo-so-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauBachThu_' . $date.'_'.$kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }


    public function checkKQToDay()
    {
        $date = date('Y-m-d', time());
        $xsmb = Lottery::where('mien', 1)->where('date', $date)->get();
        if (count($xsmb) > 0) {
            return true;
        } else {
            return false;
        }
    }

}
