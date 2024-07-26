<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use Cache;

class SoicauController extends Controller
{

    public function getSoiCau()
    {
        return view('frontend.soicau.soi-cau');
    }
    // Cầu bạch thủ
    public function getCauBachThu()
    {
        $kqToDay = $this->checkKQToDay();
        $ngay = date('d/m/Y');
        if ($kqToDay) $ngay = date('d/m/Y', strtotime('+1 days'));
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.soicau.cau-bach-thu', compact('ngay', 'provinces'));
    }
    public function getCauBachThu_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $count = $request->count;
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauBachThu_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauBachThu_' . $date . '_' . $kqToDay_type);
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
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xsmbs_result = $xsmbs;
            } else {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $type = 2;
            }

            foreach ($xsmbs_result as $xsmb) {
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
                            $ArrayCollect[$stt][1] = $m + 1;
                            $ArrayCollect[$stt][2] = $n + 1;
                            $ArrayCollect[$stt][3] = $dem;

                            // check xem lô tô có về không
                            $ArrayCollect[$stt][4] = 0; // lô tô thường
                            if (count($arr_loto_today) > 0) {
                                if (in_array($tmp1, $arr_loto_today)) {
                                    $ArrayCollect[$stt][4] = 1; // lô tô đã về
                                }
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
            for ($i = 3; $i < count($cau); $i++) {
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

            $view = view('frontend.soicau.cau-bach-thu-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date', 'count'))->render();
//            Cache::put('CauBachThu_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu Loto
    public function getCauLoto()
    {
        $kqToDay = $this->checkKQToDay();
        $ngay = date('d/m/Y');
        if ($kqToDay) $ngay = date('d/m/Y', strtotime('+1 days'));
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.soicau.cau-loto', compact('ngay', 'provinces'));
    }
    public function getCauLoto_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $count = $request->count;
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauBachThu_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauBachThu_' . $date . '_' . $kqToDay_type);
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
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
            $xsmbs_result = $xsmbs;
        } else {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(16)->get();
            $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
            $type = 2;
        }

        foreach ($xsmbs_result as $xsmb) {
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

                    if ($dem > 0 && $tmp_i == 0 && !in_array($tmp1, $arr_list_cau)) {
                        $ArrayCollect[$stt][0] = $tmp1;
                        $ArrayCollect[$stt][1] = $m + 1;
                        $ArrayCollect[$stt][2] = $n + 1;
                        $ArrayCollect[$stt][3] = $dem;

                        // check xem lô tô có về không
                        $ArrayCollect[$stt][4] = 0; // lô tô thường
                        if (count($arr_loto_today) > 0) {
                            if (in_array($tmp1, $arr_loto_today)) {
                                $ArrayCollect[$stt][4] = 1; // lô tô đã về
                            }
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
        for ($i = 3; $i < count($cau); $i++) {
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

        $view = view('frontend.soicau.cau-loto-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date', 'count'))->render();
//            Cache::put('CauBachThu_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu Loto 2 nháy
    public function getCauLoto2Nhay()
    {
        $kqToDay = $this->checkKQToDay();
        $ngay = date('d/m/Y');
        if ($kqToDay) $ngay = date('d/m/Y', strtotime('+1 days'));
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.soicau.cau-loto-2nhay', compact('ngay', 'provinces'));
    }
    public function getCauLoto2Nhay_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $count = $request->count;
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;

//        if (Cache::has('Cau2Nhay_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('Cau2Nhay_' . $date . '_' . $kqToDay_type);
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
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xsmbs_result = $xsmbs;
            } else {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $type = 2;
            }

            foreach ($xsmbs_result as $xsmb) {
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
            for ($i = $len_array_chuoi - 1; $i >= 2; $i--) {
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
                        $leng_arr_tmp = count($arr_tmp);
                        $dem_nhay = 0;
                        for ($k = 0; $k < $leng_arr_tmp; $k++) {
                            if ($arr_tmp[$k] == $tmp1 || $arr_tmp[$k] == $tmp2) {
                                $dem_nhay++;
                            }
                        }
                        if ($dem_nhay >= 2) $dem++;

                        while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                            $tmp_i--;
                            $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];
                            $tmp2 = $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$m];
                            if ($tmp_i > 0) {
                                $arr_tmp = $arr_kq[$tmp_i - 1];
                                $tmp_dem = $dem;
                                $dem_nhay = 0;
                                for ($k = 0; $k < $leng_arr_tmp; $k++) {
                                    if ($arr_tmp[$k] == $tmp1 || $arr_tmp[$k] == $tmp2) {
                                        $dem_nhay++;
                                    }
                                }
                                if ($dem_nhay >= 2) $dem++;
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
                                if (in_array($tmp1, $arr_loto_today)) {
                                    $ArrayCollect[$stt][4] = 1; // lô tô đã về
                                }
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

            $view = view('frontend.soicau.cau-loto-2nhay-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date', 'count'))->render();
//            Cache::put('Cau2Nhay_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }


    // Cầu loại bạch thủ
    public function getCauLoaiBT()
    {
        $kqToDay = $this->checkKQToDay();
        $ngay = date('d/m/Y');
        if ($kqToDay) $ngay = date('d/m/Y', strtotime('+1 days'));
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.soicau.cau-loai-bach-thu', compact('ngay', 'provinces'));
    }
    public function getCauLoaiBT_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $count = $request->count;
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauTruot_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauTruot_' . $date . '_' . $kqToDay_type);
//        } else {
            $kqToDay = $this->checkKQToDay();

            $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
            $arr_loto_today = array();
            if (!empty($xsmb_today)) {
                $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }

            $type = 1;
            $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) == $xsmb_latest->date) {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(35)->get();
                $xsmbs_result = $xsmbs;
            } else {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(35)->get();
                $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(35)->get();
                $type = 2;
            }

            foreach ($xsmbs_result as $xsmb) {
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
                        if (!in_array($tmp1, $arr_tmp)) {
                            $dem++;
                        }

                        while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                            $tmp_i--;
                            $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];

                            if ($tmp_i > 0) {
                                $arr_tmp = $arr_kq[$tmp_i - 1];
                                $tmp_dem = $dem;
                                if (!in_array($tmp1, $arr_tmp)) {
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
                                if (in_array($tmp1, $arr_loto_today)) {
                                    $ArrayCollect[$stt][4] = 1; // lô tô đã về
                                }
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
            for ($i = 3; $i < count($cau); $i++) {
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

            $view = view('frontend.soicau.cau-loai-bach-thu-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date', 'count'))->render();
//            Cache::put('CauTruot_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // cầu loại loto
    public function getCauLoaiLoto()
    {
        $kqToDay = $this->checkKQToDay();
        $ngay = date('d/m/Y');
        if ($kqToDay) $ngay = date('d/m/Y', strtotime('+1 days'));
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.soicau.cau-loai-loto', compact('ngay', 'provinces'));
    }
    public function getCauLoaiLoto_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $count = $request->count;
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauTruotCaCap_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauTruotCaCap_' . $date . '_' . $kqToDay_type);
//        } else {
            $kqToDay = $this->checkKQToDay();

            $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
            $arr_loto_today = array();
            if (!empty($xsmb_today)) {
                $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }

            $type = 1;
            $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) == $xsmb_latest->date) {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(21)->get();
                $xsmbs_result = $xsmbs;
            } else {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(21)->get();
                $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(21)->get();
                $type = 2;
            }

            foreach ($xsmbs_result as $xsmb) {
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
                        $tmp2 = $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$m];
                        $arr_tmp = $arr_kq[$tmp_i - 1];

                        $tmp_dem = $dem;
                        if (!in_array($tmp1, $arr_tmp) && !in_array($tmp2, $arr_tmp)) {
                            $dem++;
                        }

                        while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                            $tmp_i--;
                            $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];
                            $tmp2 = $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$m];

                            if ($tmp_i > 0) {
                                $arr_tmp = $arr_kq[$tmp_i - 1];
                                $tmp_dem = $dem;
                                if (!in_array($tmp1, $arr_tmp) && !in_array($tmp2, $arr_tmp)) {
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
                                if (in_array($tmp1, $arr_loto_today)) {
                                    $ArrayCollect[$stt][4] = 1; // lô tô đã về
                                }
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
            for ($i = 3; $i < count($cau); $i++) {
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

            $view = view('frontend.soicau.cau-loai-loto-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date', 'count'))->render();
//            Cache::put('CauTruotCaCap_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu theo thứ
    public function getCauTheoThu()
    {
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.soicau.cau-thu', compact('provinces'));
    }
    public function getCauTheoThu_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $thu = $request->thu;
        $count = $request->count;
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauBachThu_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauBachThu_' . $date . '_' . $kqToDay_type);
//        } else {

        // lấy list ngày
        $arr_date[2] = 'monday';
        $arr_date[3] = 'tuesday';
        $arr_date[4] = 'wednesday';
        $arr_date[5] = 'thursday';
        $arr_date[6] = 'friday';
        $arr_date[7] = 'saturday';
        $arr_date[8] = 'sunday';

        $listDate = array();
        $kq_olds = Lottery::where('mien', 1)->where('day', $thu)->where('status', 1)->select('date', 'day')->orderBy('date', 'DESC')->take(5)->get();

        foreach ($kq_olds as $kq_old) {
            $listDate[] = $kq_old->date;
        }
        // lấy ngày tiếp theo
        $c = $arr_date[$thu];
        $ngay_quay_next = date("Y-m-d", strtotime("next $c"));
        $day_next = $thu;

        if (!$kqToDay) {
            if (getThuNumber(date('Y-m-d')) == $day_next) {
                $ngay_quay_next = date('Y-m-d');
            }
        }
        $listDate[] = $ngay_quay_next;
        rsort($listDate);

        // lấy date hiển thì date thống kê
        if ($date > $listDate[1]) $date = $ngay_quay_next;

        // End lấy list ngày
        $arr_loto_today = array();
        $type = 1;
        $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->where('day', $thu)->orderBy('date', 'DESC')->first();

        if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) >= $xsmb_latest->date) {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $xsmbs_result = $xsmbs;
        } else {

            // lấy ra kết quả của ngày chọn
            $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->where('day', $thu)->orderBy('date', 'DESC')->first();
            if (!empty($xsmb_today)) {
                $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }


            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $type = 2;
        }

        foreach ($xsmbs_result as $xsmb) {
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
                        $ArrayCollect[$stt][1] = $m + 1;
                        $ArrayCollect[$stt][2] = $n + 1;
                        $ArrayCollect[$stt][3] = $dem;

                        // check xem lô tô có về không
                        $ArrayCollect[$stt][4] = 0; // lô tô thường
                        if (count($arr_loto_today) > 0) {
                            if (in_array($tmp1, $arr_loto_today)) {
                                $ArrayCollect[$stt][4] = 1; // lô tô đã về
                            }
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
        for ($i = 3; $i < count($cau); $i++) {
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

        $view = view('frontend.soicau.cau-thu-content-cau-ajax', compact('arr_js', 'listDate', 'thu', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date', 'count'))->render();
//            Cache::put('CauBachThu_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu DB
    public function getCauDB()
    {
        $kqToDay = $this->checkKQToDay();
        $ngay = date('d/m/Y');
        if ($kqToDay) $ngay = date('d/m/Y', strtotime('+1 days'));
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.soicau.cau-db', compact('ngay', 'provinces'));
    }
    public function getCauDB_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $count = $request->count;
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauBachThu_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauBachThu_' . $date . '_' . $kqToDay_type);
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
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
            $xsmbs_result = $xsmbs;
        } else {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(16)->get();
            $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
            $type = 2;
        }

        foreach ($xsmbs_result as $xsmb) {
            $tmp_result1 = $xsmb->gdb;
//            $tmp_result1 = $xsmb->gdb . '-' . $xsmb->g1 . '-' . $xsmb->g2 . '-' . $xsmb->g3 . '-' . $xsmb->g4 . '-' . $xsmb->g5 . '-' . $xsmb->g6 . '-' . $xsmb->g7;
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
                            if (in_array($tmp1, $arr_loto_today)) {
                                $ArrayCollect[$stt][4] = 1; // lô tô đã về
                            }
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
        for ($i = 3; $i < count($cau); $i++) {
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

        $view = view('frontend.soicau.cau-db-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date', 'count'))->render();
//            Cache::put('CauBachThu_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu DB theo thứ
    public function getCauDBTheoThu()
    {
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.soicau.cau-thu-db', compact('provinces'));
    }
    public function getCauDBTheoThu_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $thu = $request->thu;
        $count = $request->count;
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauBachThu_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauBachThu_' . $date . '_' . $kqToDay_type);
//        } else {

        // lấy list ngày
        $arr_date[2] = 'monday';
        $arr_date[3] = 'tuesday';
        $arr_date[4] = 'wednesday';
        $arr_date[5] = 'thursday';
        $arr_date[6] = 'friday';
        $arr_date[7] = 'saturday';
        $arr_date[8] = 'sunday';

        $listDate = array();
        $kq_olds = Lottery::where('mien', 1)->where('day', $thu)->where('status', 1)->select('date', 'day')->orderBy('date', 'DESC')->take(5)->get();

        foreach ($kq_olds as $kq_old) {
            $listDate[] = $kq_old->date;
        }
        // lấy ngày tiếp theo
        $c = $arr_date[$thu];
        $ngay_quay_next = date("Y-m-d", strtotime("next $c"));
        $day_next = $thu;

        if (!$kqToDay) {
            if (getThuNumber(date('Y-m-d')) == $day_next) {
                $ngay_quay_next = date('Y-m-d');
            }
        }
        $listDate[] = $ngay_quay_next;
        rsort($listDate);

        // lấy date hiển thì date thống kê
        if ($date > $listDate[1]) $date = $ngay_quay_next;

        // End lấy list ngày
        $arr_loto_today = array();
        $type = 1;
        $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->where('day', $thu)->orderBy('date', 'DESC')->first();

        if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) >= $xsmb_latest->date) {
            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $xsmbs_result = $xsmbs;
        } else {

            // lấy ra kết quả của ngày chọn
            $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->where('day', $thu)->orderBy('date', 'DESC')->first();
            if (!empty($xsmb_today)) {
                $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }


            $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $type = 2;
        }

        foreach ($xsmbs_result as $xsmb) {
            $tmp_result1 = $xsmb->gdb;
//            $tmp_result1 = $xsmb->gdb . '-' . $xsmb->g1 . '-' . $xsmb->g2 . '-' . $xsmb->g3 . '-' . $xsmb->g4 . '-' . $xsmb->g5 . '-' . $xsmb->g6 . '-' . $xsmb->g7;
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
                            if (in_array($tmp1, $arr_loto_today)) {
                                $ArrayCollect[$stt][4] = 1; // lô tô đã về
                            }
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
        for ($i = 3; $i < count($cau); $i++) {
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

        $view = view('frontend.soicau.cau-thu-db-content-cau-ajax', compact('arr_js', 'listDate', 'thu', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date', 'count'))->render();
//            Cache::put('CauBachThu_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }


    // Cầu trượt
    public function getCauTruot()
    {
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.soicau.cau-truot', compact('provinces'));
    }
    public function getCauTruot_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $count = $request->count;
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauTruot_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauTruot_' . $date . '_' . $kqToDay_type);
//        } else {
            $kqToDay = $this->checkKQToDay();

            $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
            $arr_loto_today = array();
            if (!empty($xsmb_today)) {
                $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }

            $type = 1;
            $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) == $xsmb_latest->date) {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(35)->get();
                $xsmbs_result = $xsmbs;
            } else {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(35)->get();
                $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(35)->get();
                $type = 2;
            }

            foreach ($xsmbs_result as $xsmb) {
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
                        if (!in_array($tmp1, $arr_tmp)) {
                            $dem++;
                        }

                        while (($tmp_dem + 1) == $dem && $tmp_i > 0) {
                            $tmp_i--;
                            $tmp1 = $array_chuoi[$tmp_i][$m] . $array_chuoi[$tmp_i][$n];

                            if ($tmp_i > 0) {
                                $arr_tmp = $arr_kq[$tmp_i - 1];
                                $tmp_dem = $dem;
                                if (!in_array($tmp1, $arr_tmp)) {
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
                                if (in_array($tmp1, $arr_loto_today)) {
                                    $ArrayCollect[$stt][4] = 1; // lô tô đã về
                                }
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
            for ($i = 3; $i < count($cau); $i++) {
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

            $view = view('frontend.soicau.cau-truot-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date', 'count'))->render();
//            Cache::put('CauTruot_' . $date . '_' . $kqToDay_type, $view, 720);
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
        if ($kqToDay) $kqToDay_type = 1;

//        if (Cache::has('CauLon_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauLon_' . $date . '_' . $kqToDay_type);
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
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xsmbs_result = $xsmbs;
            } else {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $type = 2;
            }

            foreach ($xsmbs_result as $xsmb) {
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
                                if (in_array($tmp1, $arr_loto_today)) {
                                    $ArrayCollect[$stt][4] = 1; // lô tô đã về
                                }
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
            for ($i = 3; $i < count($cau); $i++) {
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

            $view = view('frontend.soicau.cau-lon-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauLon_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }
    // cầu liền kề
    public function getCauLienKe_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;

//        if (Cache::has('CauLienKe_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauLienKe_' . $date . '_' . $kqToDay_type);
//        } else {
            $kqToDay = $this->checkKQToDay();

            $xsmb_today = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
            $arr_loto_today = array();
            if (!empty($xsmb_today)) {
                $tmp_result_today = $xsmb_today->gdb . '-' . $xsmb_today->g1 . '-' . $xsmb_today->g2 . '-' . $xsmb_today->g3 . '-' . $xsmb_today->g4 . '-' . $xsmb_today->g5 . '-' . $xsmb_today->g6 . '-' . $xsmb_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }

            $type = 1;
            $xsmb_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) == $xsmb_latest->date) {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xsmbs_result = $xsmbs;
            } else {
                $xsmbs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xsmbs_result = Lottery::where('mien', 1)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $type = 2;
            }

            foreach ($xsmbs_result as $xsmb) {
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
            for ($i = $len_array_chuoi - 1; $i >= 2; $i--) {
                $len_chuoi_con = strlen($array_chuoi[$i]);
                $ArrayCollect = array();
                $stt = 0;
                for ($m = 0; $m < $len_chuoi_con - 1; $m++) {
                    for ($n = $m + 1; $n <= $m + 1; $n++) {
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
                                if (in_array($tmp1, $arr_loto_today)) {
                                    $ArrayCollect[$stt][4] = 1; // lô tô đã về
                                }
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

            $view = view('frontend.soicau.cau-lien-ke-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauLienKe_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }
    // Cầu 3 càng lô
    public function getCau3CangLo_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;

//        if (Cache::has('Cau3CangLo_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('Cau3CangLo_' . $date . '_' . $kqToDay_type);
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
                $tmp_result1 = $xsmb->gdb . '-' . $xsmb->g1 . '-' . $xsmb->g2 . '-' . $xsmb->g3 . '-' . $xsmb->g4 . '-' . $xsmb->g5 . '-' . $xsmb->g6;
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
            for ($i = $len_array_chuoi - 1; $i >= 2; $i--) {
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
                                    if (in_array($tmp1, $arr_loto_today)) {
                                        $ArrayCollect[$stt][5] = 1; // lô tô đã về
                                    }
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
            for ($i = 2; $i < count($cau); $i++) {
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

            $view = view('frontend.soicau.cau-3cang-lo-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'kqToDay', 'date'))->render();
//            Cache::put('Cau3CangLo_' . $date . '_' . $kqToDay_type, $view, 720);
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

    public function getCau3Cang()
    {
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.soicau3cang.cau-3-cang', compact('provinces'));
    }
}
