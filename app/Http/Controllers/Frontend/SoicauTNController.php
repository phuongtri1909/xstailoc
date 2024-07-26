<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use Cache;

class SoicauTNController extends Controller
{
    public function getSoiCauMN()
    {
        $xsmnProvinces = Province::where('mien', 3)->get();
        $xsmnProvinces_homqua = Province::where('mien', 3)->where('ngay_quay', 'like', '%' . getThuNumber(date('Y-m-d', strtotime("-1 days"))) . '%')->get();
        $xsmnProvinces_homnay = Province::where('mien', 3)->where('ngay_quay', 'like', '%' . getThuNumber(date('Y-m-d')) . '%')->get();

        return view('frontend.soicau_tn.soi-cau-mien-nam', compact('xsmnProvinces', 'xsmnProvinces_homqua', 'xsmnProvinces_homnay'));

    }

    public function getSoiCauMT()
    {
        $xsmtProvinces = Province::where('mien', 2)->get();
        $xsmtProvinces_homqua = Province::where('mien', 2)->where('ngay_quay', 'like', '%' . getThuNumber(date('Y-m-d', strtotime("-1 days"))) . '%')->get();
        $xsmtProvinces_homnay = Province::where('mien', 2)->where('ngay_quay', 'like', '%' . getThuNumber(date('Y-m-d')) . '%')->get();

        return view('frontend.soicau_tn.soi-cau-mien-trung', compact('xsmtProvinces', 'xsmtProvinces_homqua', 'xsmtProvinces_homnay'));
    }

    // Cầu bạch thủ
    public function getCauBachThuTN($short_name)
    {
        $province = Province::where('short_name', $short_name)->first();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        if(empty($province) || empty($provinces)){
            return abort(404);
        }
        return view('frontend.soicau_tn.cau-bach-thu-tn', compact('province', 'provinces'));
    }
    public function getCauBachThuTN_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $count = $request->count;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
        if (Cache::has('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
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
                $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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

            $view = view('frontend.soicau_tn.cau-bach-thu-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date','count'))->render();
            Cache::put('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu loto
    public function getCauLotoTN($short_name)
    {
        $province = Province::where('short_name', $short_name)->first();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return abort(404); 
        return view('frontend.soicau_tn.cau-loto-tn', compact('province', 'provinces'));
    }
    public function getCauLotoTN_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $count = $request->count;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
        if (Cache::has('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
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
            $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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
                    if (in_array($tmp1, $arr_tmp) || in_array($tmp1, $arr_tmp)) {
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

        $view = view('frontend.soicau_tn.cau-loto-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date','count'))->render();
            Cache::put('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }


    // Cầu loto 2 nhay
    public function getCauLoto2NhayTN($short_name)
    {
        $province = Province::where('short_name', $short_name)->first();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.soicau_tn.cau-loto-2nhay-tn', compact('province', 'provinces'));
    }
    public function getCauLoto2NhayTN_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $count = $request->count;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
        if (Cache::has('Cau2NhayTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('Cau2NhayTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
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
                $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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

            $view = view('frontend.soicau_tn.cau-loto-2nhay-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date', 'count'))->render();
            Cache::put('Cau2NhayTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu loại bạch thủ
    public function getCauLoaiBTTN($short_name)
    {
        $province = Province::where('short_name', $short_name)->first();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return abort(404); 
        return view('frontend.soicau_tn.cau-loai-bach-thu-tn', compact('province', 'provinces'));
    }
    public function getCauLoaiBTTN_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $count = $request->count;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);


        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
        if (Cache::has('CauTruotTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('CauTruotTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
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
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(45)->get();
                $xss_result = $xss;
            } else {
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(45)->get();
                $xss_result = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(45)->get();
                $type = 2;
            }

            foreach ($xss_result as $xs) {
                $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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

            $view = view('frontend.soicau_tn.cau-loai-bach-thu-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date', 'count'))->render();
            Cache::put('CauTruotTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // cầu loại loto
    public function getCauLoaiLotoTN($short_name)
    {
        $province = Province::where('short_name', $short_name)->first();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.soicau_tn.cau-loai-loto-tn', compact('province', 'provinces'));
    }
    public function getCauLoaiLotoTN_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $count = $request->count;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
        if (Cache::has('CauTruotCaCapTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('CauTruotCaCapTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
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
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(40)->get();
                $xss_result = $xss;
            } else {
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(40)->get();
                $xss_result = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(40)->get();
                $type = 2;
            }

            foreach ($xss_result as $xs) {
                $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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

            $view = view('frontend.soicau_tn.cau-loai-loto-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date', 'count'))->render();
            Cache::put('CauTruotCaCapTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

   //cầu theo thứ
    public function getCauTheoThuTN($short_name)
    {
        $province = Province::where('short_name', $short_name)->first();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.soicau_tn.cau-thu-tn', compact('province', 'provinces'));
    }
    public function getCauTheoThuTN_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $thu = $request->thu;
        $count = $request->count;

        $short_name = $request->short_name;
        $province = Province::where('short_name', $short_name)->first();

//        $province_id = $request->province_id;
//        $province = Province::find($province_id);

//        $short_name = $request->short_name;
//        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
        if (Cache::has('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
        // lấy list ngày
        $arr_date[2] = 'monday';
        $arr_date[3] = 'tuesday';
        $arr_date[4] = 'wednesday';
        $arr_date[5] = 'thursday';
        $arr_date[6] = 'friday';
        $arr_date[7] = 'saturday';
        $arr_date[8] = 'sunday';

        $listDate = array();
        $kq_olds = Lottery::where('province_id', $province->id)->where('day', $thu)->where('status', 1)->select('date', 'day')->orderBy('date', 'DESC')->take(5)->get();

        if (count($kq_olds) == 0) {
            $view = "<div class=\"row bg-white rd shadow mb pd-10 text-center\"><div class=\"col-md-12\" style=\"text-align: center;padding: 50px 0px; margin: auto;\">Dữ liệu không tồn tại!</div></div>";
            $dataReturn = ["template" => $view];
            return json_encode($dataReturn);
        }

        foreach ($kq_olds as $kq_old) {
            $listDate[] = $kq_old->date;
        }
        // lấy ngày tiếp theo
        $day_next = '';
        if (strpos($province->ngay_quay, ',') !== false) {
            $tmp_arr = explode(',', $province->ngay_quay);

            $a = $arr_date[$tmp_arr[0]];
            $b = $arr_date[$tmp_arr[1]];
            if ($b==$thu) {
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
        $arr_loto_today = array();
        $type = 1;
        $xs_latest = Lottery::where('province_id', $province->id)->where('day', $thu)->where('status', 1)->orderBy('date', 'DESC')->first();
        if (empty($xs_latest)) {
            $view = "<div class=\"row bg-white rd shadow mb pd-10 text-center\"><div class=\"col-md-12\" style=\"text-align: center;padding: 50px 0px; margin: auto;\">Dữ liệu không tồn tại!</div></div>";
            $dataReturn = ["template" => $view];
            return json_encode($dataReturn);
        }

        if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) >= $xs_latest->date) {
            $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $xss_result = $xss;
        } else {
            $xs_today = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->where('day', $thu)->orderBy('date', 'DESC')->first();
            if (!empty($xs_today)) {
                $tmp_result_today = $xs_today->gdb . '-' . $xs_today->g1 . '-' . $xs_today->g2 . '-' . $xs_today->g3 . '-' . $xs_today->g4 . '-' . $xs_today->g5 . '-' . $xs_today->g6 . '-' . $xs_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }

            $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $xss_result = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $type = 2;
        }

        if (count($xss_result) == 0) {
            $view = "<div class=\"row bg-white rd shadow mb pd-10 text-center\"><div class=\"col-md-12\" style=\"text-align: center;padding: 50px 0px; margin: auto;\">Dữ liệu không tồn tại!</div></div>";
            $dataReturn = ["template" => $view];
            return json_encode($dataReturn);
        }

        foreach ($xss_result as $xs) {
            $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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

        $view = view('frontend.soicau_tn.cau-thu-tn-content-cau-ajax', compact('province', 'listDate', 'thu', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date', 'count'))->render();
            Cache::put('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu DB
    public function getCauDBTN($short_name)
    {
        $province = Province::where('short_name', $short_name)->first();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.soicau_tn.cau-db-tn', compact('province', 'provinces'));
    }
    public function getCauDBTN_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $count = $request->count;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
        if (Cache::has('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
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
            $tmp_result1 = $xs->gdb;
//            $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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
                    $tmp2 = $array_chuoi[$tmp_i][$n] . $array_chuoi[$tmp_i][$m];
                    $arr_tmp = $arr_kq[$tmp_i - 1];

                    $tmp_dem = $dem;
                    if (in_array($tmp1, $arr_tmp) || in_array($tmp1, $arr_tmp)) {
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

        $view = view('frontend.soicau_tn.cau-db-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date','count'))->render();
            Cache::put('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    //cầu DB theo thứ
    public function getCauDBTheoThuTN($short_name)
    {
        $province = Province::where('short_name', $short_name)->first();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.soicau_tn.cau-thu-db-tn', compact('province', 'provinces'));
    }
    public function getCauDBTheoThuTN_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $thu = $request->thu;
        $count = $request->count;

        $short_name = $request->short_name;
        $province = Province::where('short_name', $short_name)->first();

//        $province_id = $request->province_id;
//        $province = Province::find($province_id);

//        $short_name = $request->short_name;
//        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
        if (Cache::has('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
        // lấy list ngày
        $arr_date[2] = 'monday';
        $arr_date[3] = 'tuesday';
        $arr_date[4] = 'wednesday';
        $arr_date[5] = 'thursday';
        $arr_date[6] = 'friday';
        $arr_date[7] = 'saturday';
        $arr_date[8] = 'sunday';

        $listDate = array();
        $kq_olds = Lottery::where('province_id', $province->id)->where('day', $thu)->where('status', 1)->select('date', 'day')->orderBy('date', 'DESC')->take(5)->get();

        if (count($kq_olds) == 0) {
            $view = "<div class=\"row bg-white rd shadow mb pd-10 text-center\"><div class=\"col-md-12\" style=\"text-align: center;padding: 50px 0px; margin: auto;\">Dữ liệu không tồn tại!</div></div>";
            $dataReturn = ["template" => $view];
            return json_encode($dataReturn);
        }

        foreach ($kq_olds as $kq_old) {
            $listDate[] = $kq_old->date;
        }
        // lấy ngày tiếp theo
        $day_next = '';
        if (strpos($province->ngay_quay, ',') !== false) {
            $tmp_arr = explode(',', $province->ngay_quay);

            $a = $arr_date[$tmp_arr[0]];
            $b = $arr_date[$tmp_arr[1]];
            if ($b==$thu) {
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
        $arr_loto_today = array();
        $type = 1;
        $xs_latest = Lottery::where('province_id', $province->id)->where('day', $thu)->where('status', 1)->orderBy('date', 'DESC')->first();
        if (empty($xs_latest)) {
            $view = "<div class=\"row bg-white rd shadow mb pd-10 text-center\"><div class=\"col-md-12\" style=\"text-align: center;padding: 50px 0px; margin: auto;\">Dữ liệu không tồn tại!</div></div>";
            $dataReturn = ["template" => $view];
            return json_encode($dataReturn);
        }

        if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) >= $xs_latest->date) {
            $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $xss_result = $xss;
        } else {
            $xs_today = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->where('day', $thu)->orderBy('date', 'DESC')->first();
            if (!empty($xs_today)) {
                $tmp_result_today = $xs_today->gdb . '-' . $xs_today->g1 . '-' . $xs_today->g2 . '-' . $xs_today->g3 . '-' . $xs_today->g4 . '-' . $xs_today->g5 . '-' . $xs_today->g6 . '-' . $xs_today->g7;
                $arr_loto_today = getLoto($tmp_result_today);
            }

            $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $xss_result = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->where('day', $thu)->orderBy('date', 'DESC')->take(16)->get();
            $type = 2;
        }

        if (count($xss_result) == 0) {
            $view = "<div class=\"row bg-white rd shadow mb pd-10 text-center\"><div class=\"col-md-12\" style=\"text-align: center;padding: 50px 0px; margin: auto;\">Dữ liệu không tồn tại!</div></div>";
            $dataReturn = ["template" => $view];
            return json_encode($dataReturn);
        }

        foreach ($xss_result as $xs) {
            $tmp_result1 = $xs->gdb;
//            $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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

        $view = view('frontend.soicau_tn.cau-thu-db-tn-content-cau-ajax', compact('province', 'listDate', 'thu', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date', 'count'))->render();
            Cache::put('CauBachThuTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu bạch thủ
    public function getCauTruotTN($short_name)
    {
        
        $province = Province::where('short_name', $short_name)->first();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        if(empty($province) || empty($provinces)){
            abort(404);
        }
        return view('frontend.soicau_tn.cau-truot-tn', compact('province', 'provinces'));
    }
    public function getCauTruotTN_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $count = $request->count;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);


        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
        if (Cache::has('CauTruotTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('CauTruotTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
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
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(45)->get();
                $xss_result = $xss;
            } else {
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(45)->get();
                $xss_result = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(45)->get();
                $type = 2;
            }

            foreach ($xss_result as $xs) {
                $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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

            $view = view('frontend.soicau_tn.cau-truot-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date', 'count'))->render();
            Cache::put('CauTruotTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu lộn
    public function getCauLon_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;

        if (Cache::has('CauLonTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('CauLonTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
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
                $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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

            $view = view('frontend.soicau_tn.cau-lon-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date'))->render();
            Cache::put('CauLonTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // cầu liền kề
    public function getCauLienKe_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;

        if (Cache::has('CauLienKeTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('CauLienKeTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
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
                $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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

            $view = view('frontend.soicau_tn.cau-lien-ke-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date'))->render();
            Cache::put('CauLienKeTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }


    // cầu trượt cả cặp
    public function getCauTruotCaCap_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;
        if (Cache::has('CauTruotCaCapTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('CauTruotCaCapTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
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
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(40)->get();
                $xss_result = $xss;
            } else {
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(40)->get();
                $xss_result = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(40)->get();
                $type = 2;
            }

            foreach ($xss_result as $xs) {
                $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
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

            $view = view('frontend.soicau_tn.cau-truot-ca-cap-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'array_boso', 'kqToDay', 'date'))->render();
            Cache::put('CauTruotCaCapTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    // Cầu 3 càng lô
    public function getCau3CangLo_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $short_name = $request->short_name;
        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;

        if (Cache::has('Cau3CangLoTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
            $view = Cache::get('Cau3CangLoTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
        } else {
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
                $arr_loto_today = getLoto3Cang($tmp_result_today);
            }

            $type = 1;
            $xs_latest = Lottery::where('province_id', $province->id)->where('status', 1)->orderBy('date', 'DESC')->first();
            if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) >= $xs_latest->date) {
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
                $xss_result = $xss;
            } else {
                $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(7)->get();
                $xss_result = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
                $type = 2;
            }

            foreach ($xss_result as $xs) {
                $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6;
                $tmp_result2 = $xs->g8 . $xs->g7 . $xs->g6 . $xs->g5 . $xs->g4 . $xs->g3 . $xs->g2 . $xs->g1 . $xs->gdb;

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

            $view = view('frontend.soicau_tn.cau-3cang-lo-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'kqToDay', 'date'))->render();
            Cache::put('Cau3CangLoTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }


    public function checkKQToDay($province_id)
    {
        $date = date('Y-m-d', time());
        $xs = Lottery::where('province_id', $province_id)->where('date', $date)->first();
        if (!empty($xs)) {
            return true;
        } else {
            return false;
        }
    }

    ///////////////////////////// cầu 3 càng /////////////////////////////
    // Cầu 3 càng lô miền nam
    public function getCau3CangLoTN_Ajax(Request $request)
    {
        $date = getNgaycheo($request->date);
        $province_id = $request->province_id;
        $province = Province::find($province_id);

//        $short_name = $request->short_name;
//        $province = Province::where('short_name', $short_name)->first();
        $kqToDay = $this->checkKQToDay($province->id);

        $kqToDay_type = 0;
        if ($kqToDay) $kqToDay_type = 1;

//        if (Cache::has('Cau3CangLoTN_' . $short_name . '_' . $date . '_' . $kqToDay_type)) {
//            $view = Cache::get('Cau3CangLoTN_' . $short_name . '_' . $date . '_' . $kqToDay_type);
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
            $arr_loto_today = getLoto3Cang($tmp_result_today);
        }

        $type = 1;
        $xs_latest = Lottery::where('province_id', $province->id)->where('status', 1)->orderBy('date', 'DESC')->first();
        if (date('Y-m-d', strtotime(getNgayLink($date) . ' -1 days')) >= $xs_latest->date) {
            $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
            $xss_result = $xss;
        } else {
            $xss = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take(7)->get();
            $xss_result = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->take(7)->get();
            $type = 2;
        }

        foreach ($xss_result as $xs) {
            $tmp_result1 = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6;
            $tmp_result2 = $xs->g8 . $xs->g7 . $xs->g6 . $xs->g5 . $xs->g4 . $xs->g3 . $xs->g2 . $xs->g1 . $xs->gdb;

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

        $view = view('frontend.soicau_tn.cau-3cang-lo-tn-content-cau-ajax', compact('province', 'listDate', 'arr_js', 'type', 'cau', 'xss', 'kqToDay', 'date'))->render();
//            Cache::put('Cau3CangLoTN_' . $short_name . '_' . $date . '_' . $kqToDay_type, $view, 720);
//        }
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }
    /////////////////////////////END cầu 3 càng /////////////////////////////


}
