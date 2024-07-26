<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use Cache;

class SoicauGiai7Controller extends Controller
{
    public function getCauGiai7()
    {
        $kqToDay = $this->checkKQToDay();
        $ngay = date('d/m/Y');
        if ($kqToDay) $ngay = date('d/m/Y', strtotime('+1 days'));
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.soicaugiai7.cau-giai-7', compact('ngay', 'provinces'));
    }

    // cầu giải 7
    public function getCauGiai7_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauGiai7_' . $date.'_'.$kqToDay_type)) {
//            $view = Cache::get('CauGiai7_' . $date.'_'.$kqToDay_type);
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
                $tmp_result1 = $xsmb->g7;
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
                                if ($tmp1 == $arr_loto_today[0] || $tmp1 == $arr_loto_today[26] || $tmp1 == $arr_loto_today[25] || $tmp1 == $arr_loto_today[24] || $tmp1 == $arr_loto_today[23]) {
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

            $view = view('frontend.soicaugiai7.cau-giai-7-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauGiai7_' . $date.'_'.$kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // cầu giải 7 và ĐB
    public function getCauGiai7vaDB_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $kqToDay = $this->checkKQToDay();
        $kqToDay_type = 0;
        if($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauGiai7vaDB_' . $date.'_'.$kqToDay_type)) {
//            $view = Cache::get('CauGiai7vaDB_' . $date.'_'.$kqToDay_type);
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
                $tmp_result1 = $xsmb->gdb . '-' . $xsmb->g7;
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
                                if ($tmp1 == $arr_loto_today[0] || $tmp1 == $arr_loto_today[26] || $tmp1 == $arr_loto_today[25] || $tmp1 == $arr_loto_today[24] || $tmp1 == $arr_loto_today[23]) {
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

            $view = view('frontend.soicaugiai7.cau-giai-7-va-db-content-cau-ajax', compact('arr_js', 'type', 'cau', 'xsmbs', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauGiai7vaDB_' . $date.'_'.$kqToDay_type, $view, 720);
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


    public function getCauTNGiai7($short_name)
    {
        $province = Province::where('short_name', $short_name)->first();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.soicaugiai7_tn.soi-cau-giai-7-tn', compact('province', 'provinces'));
    }

    public function getCauTNGiai7_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDayTN($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauGiai7TN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauGiai7TN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
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
            $kq_olds = Lottery::where('province_id', $province->id)->where('status', 1)->select('date', 'day')->orderBy('date', 'DESC')->take(5)->get();

            foreach ($kq_olds as $kq_old) {
                $listDate[] = $kq_old->date;
            }
            // lấy ngày tiếp theo
            $day_next = '';
            if (strpos($province->ngay_quay, ',') !== false) {
                $tmp_arr = explode(',', $province->ngay_quay);

                $a = $arr_date[$tmp_arr[0]];
                $b = $arr_date[$tmp_arr[1]];
                if (date("Y-m-d", strtotime("next $a")) > date("Y-m-d", strtotime("next $b"))) {
                    $ngay_quay_next = date("Y-m-d", strtotime("next $b"));
                    $day_next = $b;
                } else {
                    $ngay_quay_next = date("Y-m-d", strtotime("next $a"));
                    $day_next = $a;
                }
            } else {
                $c = $arr_date[$province->ngay_quay];
                $ngay_quay_next = date("Y-m-d", strtotime("next $c"));
                $day_next = $province->ngay_quay;
            }

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


            $xs_today = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', $date)->first();
            $arr_loto_today = array();
            if (!empty($xs_today)) {
                $tmp_result_today = $xs_today->gdb . '-' . $xs_today->g1 . '-' . $xs_today->g2 . '-' . $xs_today->g3 . '-' . $xs_today->g4 . '-' . $xs_today->g5 . '-' . $xs_today->g6 . '-' . $xs_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }

            $type = 1;
            $xs_latest = Lottery::where('province_id', $province->id)->where('status', 1)->orderBy('date', 'DESC')->first();
            if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) >= $xs_latest->date) {
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xss_result = $xss;
            } else {
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xss_result = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $type = 2;
            }

            foreach ($xss_result as $xs) {
                $tmp_result1 = $xs->g8;
                $tmp_result2 = $xs->g8 . $xs->g7 . $xs->g6 . $xs->g5 . $xs->g4 . $xs->g3 . $xs->g2 . $xs->g1 . $xs->gdb;

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
            foreach ($xss as $xs) {
                $date_section = getDateLienNhau($xs->date);
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

            $view = view('frontend.soicaugiai7_tn.cau-giai-7-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauGiai7TN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }


    public function getCauTNGiai7vaDB_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDayTN($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
//        if (Cache::has('CauGiai7TN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('CauGiai7TN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
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
            $kq_olds = Lottery::where('province_id', $province->id)->where('status', 1)->select('date', 'day')->orderBy('date', 'DESC')->take(5)->get();

            foreach ($kq_olds as $kq_old) {
                $listDate[] = $kq_old->date;
            }
            // lấy ngày tiếp theo
            $day_next = '';
            if (strpos($province->ngay_quay, ',') !== false) {
                $tmp_arr = explode(',', $province->ngay_quay);

                $a = $arr_date[$tmp_arr[0]];
                $b = $arr_date[$tmp_arr[1]];
                if (date("Y-m-d", strtotime("next $a")) > date("Y-m-d", strtotime("next $b"))) {
                    $ngay_quay_next = date("Y-m-d", strtotime("next $b"));
                    $day_next = $b;
                } else {
                    $ngay_quay_next = date("Y-m-d", strtotime("next $a"));
                    $day_next = $a;
                }
            } else {
                $c = $arr_date[$province->ngay_quay];
                $ngay_quay_next = date("Y-m-d", strtotime("next $c"));
                $day_next = $province->ngay_quay;
            }

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


            $xs_today = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', $date)->first();
            $arr_loto_today = array();
            if (!empty($xs_today)) {
                $tmp_result_today = $xs_today->gdb . '-' . $xs_today->g1 . '-' . $xs_today->g2 . '-' . $xs_today->g3 . '-' . $xs_today->g4 . '-' . $xs_today->g5 . '-' . $xs_today->g6 . '-' . $xs_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }

            $type = 1;
            $xs_latest = Lottery::where('province_id', $province->id)->where('status', 1)->orderBy('date', 'DESC')->first();
            if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) >= $xs_latest->date) {
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xss_result = $xss;
            } else {
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(16)->get();
                $xss_result = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(16)->get();
                $type = 2;
            }

            foreach ($xss_result as $xs) {
                $tmp_result1 = $xs->gdb . '-' . $xs->g8;
                $tmp_result2 = $xs->g8 . $xs->g7 . $xs->g6 . $xs->g5 . $xs->g4 . $xs->g3 . $xs->g2 . $xs->g1 . $xs->gdb;

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
                                if ($tmp1 == $arr_loto_today[0] || $tmp1 == $arr_loto_today[17]) {
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
            foreach ($xss as $xs) {
                $date_section = getDateLienNhau($xs->date);
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

            $view = view('frontend.soicaugiai7_tn.cau-giai-7-va-db-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date'))->render();
//            Cache::put('CauGiai7TN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    public function checkKQToDayTN($province_id)
    {
        $date = date('Y-m-d', time());
        $xs = Lottery::where('province_id', $province_id)->where('date', $date)->first();
        if (!empty($xs)) {
            return true;
        } else {
            return false;
        }
    }

}
