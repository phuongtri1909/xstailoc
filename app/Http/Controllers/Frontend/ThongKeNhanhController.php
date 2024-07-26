<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use App\Models\Gan;
use App\Models\GanDB;
use App\Models\LoRoi;
use App\Models\Post;
use Cache;
use Validator;

class ThongKeNhanhController extends Controller
{
    public function getTKNhanh()
    {
        $short_name = 'mb';
        $dateStart = date('Y-m-d', strtotime('-365 days'));
        $dateEnd = date('Y-m-d');

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $short_name = 'mb';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $short_name = $province->short_name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->get();
        }
        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect[$i][2] = -1; // số ngày chưa về
            $ArrayCollect[$i][3] = 0; // số ngày chưa về

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
                $ArrayCollect[$t][3] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.thongkenhanh.thong-ke-nhanh', compact('ArrayCollect', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name'));
    }

    public function getTKNhanh_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $giaidb = 0;
        if (!empty($request->giaidb))
            $giaidb = $request->giaidb;
        $dateStart = getNgaycheo($request->start_date);
        $dateEnd = getNgaycheo($request->end_date);


        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $short_name = 'mb';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $short_name = $province->short_name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->get();
        }

        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect[$i][2] = -1; // số ngày chưa về
            $ArrayCollect[$i][3] = 0; // số ngày chưa về

        }
        $len_collect = count($ArrayCollect);
        $number_date = 0;


        foreach ($kqs as $kq) {
            if ($giaidb == 0) {
                $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            } else {
                $tmp_result1 = $kq->gdb;
            }
            $arr_kq = getLoto($tmp_result1);
            for ($t = 0; $t < $len_collect; $t++) {
                if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                    if ($ArrayCollect[$t][2] == -1) {
                        $ArrayCollect[$t][1] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][2] = $number_date;
                    }
                }
                $ArrayCollect[$t][3] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $view = view('frontend.thongkenhanh.thong-ke-nhanh-ajax', compact('ArrayCollect', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name', 'dateStart', 'dateEnd'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKTheoTong()
    {
        $short_name = 'mb';
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
        }
        // tạo mảng bộ số từ 00->99
        $ArrayCollect_Tong = array();
        $ArrayCollect_Tong[0][0] = ["00", "19", "28", "37", "46", "55", "64", "73", "82", "91"];
        $ArrayCollect_Tong[1][0] = ["01", "10", "29", "92", "38", "83", "47", "74", "56", "65"];
        $ArrayCollect_Tong[2][0] = ["02", "20", "39", "93", "48", "84", "57", "75", "11", "66"];
        $ArrayCollect_Tong[3][0] = ["03", "30", "12", "21", "49", "94", "58", "85", "67", "76"];
        $ArrayCollect_Tong[4][0] = ["04", "40", "13", "31", "59", "95", "68", "86", "22", "77"];
        $ArrayCollect_Tong[5][0] = ["05", "50", "14", "41", "23", "32", "69", "96", "78", "87"];
        $ArrayCollect_Tong[6][0] = ["06", "60", "15", "51", "24", "42", "79", "97", "33", "88"];
        $ArrayCollect_Tong[7][0] = ["07", "70", "16", "61", "25", "52", "34", "43", "89", "98"];
        $ArrayCollect_Tong[8][0] = ["08", "80", "17", "71", "26", "62", "35", "53", "44", "99"];
        $ArrayCollect_Tong[9][0] = ["09", "90", "18", "81", "27", "72", "36", "63", "45", "54"];

        $ArrayCollect_boso = array();
        for ($k = 0; $k <= 9; $k++) {
            for ($e = 0; $e <= 9; $e++) {
                $ArrayCollect_boso[$e][$k][0] = $ArrayCollect_Tong[$e][0][$k]; // bộ số
                $ArrayCollect_boso[$e][$k][1] = 0; // số lần xuất hiện
            }
        }


        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect[$i][2] = -1; // số ngày chưa về
            $ArrayCollect[$i][3] = 0; // số ngày chưa về

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
                $ArrayCollect[$t][3] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;

            for ($k = 0; $k <= 9; $k++) {
                foreach ($ArrayCollect_Tong[$k][0] as $key => $value) {
                    if ($key == 'tong') continue;
                    $ArrayCollect_boso[$k][$key][1] += solan_xuathien_trongngay($value, $arr_kq);

                    if (!isset($ArrayCollect_Tong[$k]['tong'])) $ArrayCollect_Tong[$k]['tong'] = 0;
                    $ArrayCollect_Tong[$k]['tong'] += solan_xuathien_trongngay($value, $arr_kq);
                }
            }
        }

        for ($e = 0; $e <= 8; $e++) {
            for ($f = $e + 1; $f <= 9; $f++) {

                for ($k = 0; $k <= 9; $k++) {
                    if ($ArrayCollect_boso[$k][$e][1] < $ArrayCollect_boso[$k][$f][1]) {
                        swap($ArrayCollect_boso[$k][$e][0], $ArrayCollect_boso[$k][$f][0]);
                        swap($ArrayCollect_boso[$k][$e][1], $ArrayCollect_boso[$k][$f][1]);
                    }
                }


            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.thongkenhanh.thong-ke-theo-tong', compact('ArrayCollect', 'ArrayCollect_boso', 'ArrayCollect_Tong', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name'));
    }

    public function getTKTheoTong_Ajax(Request $request)
    {
        $short_name = $request->short_name;

        $giaidb = 0;
        if (!empty($request->giaidb))
            $giaidb = $request->giaidb;

        $dateStart = getNgaycheo($request->start_date);
        $dateEnd = getNgaycheo($request->end_date);


        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $short_name = 'mb';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $short_name = $province->short_name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->get();
        }

        // tạo mảng bộ số từ 00->99
        $ArrayCollect_Tong = array();
        $ArrayCollect_Tong[0][0] = ["00", "19", "28", "37", "46", "55", "64", "73", "82", "91"];
        $ArrayCollect_Tong[1][0] = ["01", "10", "29", "92", "38", "83", "47", "74", "56", "65"];
        $ArrayCollect_Tong[2][0] = ["02", "20", "39", "93", "48", "84", "57", "75", "11", "66"];
        $ArrayCollect_Tong[3][0] = ["03", "30", "12", "21", "49", "94", "58", "85", "67", "76"];
        $ArrayCollect_Tong[4][0] = ["04", "40", "13", "31", "59", "95", "68", "86", "22", "77"];
        $ArrayCollect_Tong[5][0] = ["05", "50", "14", "41", "23", "32", "69", "96", "78", "87"];
        $ArrayCollect_Tong[6][0] = ["06", "60", "15", "51", "24", "42", "79", "97", "33", "88"];
        $ArrayCollect_Tong[7][0] = ["07", "70", "16", "61", "25", "52", "34", "43", "89", "98"];
        $ArrayCollect_Tong[8][0] = ["08", "80", "17", "71", "26", "62", "35", "53", "44", "99"];
        $ArrayCollect_Tong[9][0] = ["09", "90", "18", "81", "27", "72", "36", "63", "45", "54"];

        $ArrayCollect_boso = array();
        for ($k = 0; $k <= 9; $k++) {
            for ($e = 0; $e <= 9; $e++) {
                $ArrayCollect_boso[$e][$k][0] = $ArrayCollect_Tong[$e][0][$k]; // bộ số
                $ArrayCollect_boso[$e][$k][1] = 0; // số lần xuất hiện
            }
        }


        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect[$i][2] = -1; // số ngày chưa về
            $ArrayCollect[$i][3] = 0; // số ngày chưa về

        }
        $len_collect = count($ArrayCollect);
        $number_date = 0;


        foreach ($kqs as $kq) {
            if ($giaidb == 0) {
                $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            } else {
                $tmp_result1 = $kq->gdb;
            }
            $arr_kq = getLoto($tmp_result1);
            for ($t = 0; $t < $len_collect; $t++) {
                if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                    if ($ArrayCollect[$t][2] == -1) {
                        $ArrayCollect[$t][1] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][2] = $number_date;
                    }
                }
                $ArrayCollect[$t][3] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;

            for ($k = 0; $k <= 9; $k++) {
                foreach ($ArrayCollect_Tong[$k][0] as $key => $value) {
                    if ($key == 'tong') continue;
                    $ArrayCollect_boso[$k][$key][1] += solan_xuathien_trongngay($value, $arr_kq);

                    if (!isset($ArrayCollect_Tong[$k]['tong'])) $ArrayCollect_Tong[$k]['tong'] = 0;
                    $ArrayCollect_Tong[$k]['tong'] += solan_xuathien_trongngay($value, $arr_kq);
                }
            }
        }

        for ($e = 0; $e <= 8; $e++) {
            for ($f = $e + 1; $f <= 9; $f++) {

                for ($k = 0; $k <= 9; $k++) {
                    if ($ArrayCollect_boso[$k][$e][1] < $ArrayCollect_boso[$k][$f][1]) {
                        swap($ArrayCollect_boso[$k][$e][0], $ArrayCollect_boso[$k][$f][0]);
                        swap($ArrayCollect_boso[$k][$e][1], $ArrayCollect_boso[$k][$f][1]);
                    }
                }


            }
        }

        $view = view('frontend.thongkenhanh.thong-ke-theo-tong-ajax', compact('ArrayCollect', 'ArrayCollect_boso', 'ArrayCollect_Tong', 'province_name', 'province_id', 'province_slug', 'short_name', 'dateStart', 'dateEnd'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKTSBoSo()
    {
        $short_name = 'mb';
        $count = 500;
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($count)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($count)->get();
        }

        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = 0; // Tổng số ngày về
            $ArrayCollect[$i][2] = 0; // Tổng số lần xuất hiện
            $ArrayCollect[$i][3] = 0; // Ngày về trung bình

        }


        $len_collect = count($ArrayCollect);
        $number_date = 0;


        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);
            for ($t = 0; $t < $len_collect; $t++) {
                if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                    $ArrayCollect[$t][1] += 1;
                }
                $ArrayCollect[$t][2] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;
        }

        for ($i = 0; $i < 100; $i++) {
            if ($ArrayCollect[$i][1] == 0) $ArrayCollect[$i][3] = 'Không xuất hiện';
            else $ArrayCollect[$i][3] = round($count / $ArrayCollect[$i][1], 2); // Ngày về trung bình
        }
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.thongkenhanh.thong-ke-tan-suat-bo-so', compact('count', 'ArrayCollect', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name'));
    }

    public function getTKTSBoSo_Ajax(Request $request)
    {
        $short_name = $request->short_name;

        $giaidb = 0;
        if (!empty($request->giaidb))
            $giaidb = $request->giaidb;

        $count = $request->count;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($count)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $short_name = 'mb';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $short_name = $province->short_name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($count)->get();
        }
        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = 0; // Tổng số ngày về
            $ArrayCollect[$i][2] = 0; // Tổng số lần xuất hiện
            $ArrayCollect[$i][3] = 0; // Ngày về trung bình

        }


        $len_collect = count($ArrayCollect);
        $number_date = 0;


        foreach ($kqs as $kq) {
            if ($giaidb == 0) {
                $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            } else {
                $tmp_result1 = $kq->gdb;
            }
            $arr_kq = getLoto($tmp_result1);
            for ($t = 0; $t < $len_collect; $t++) {
                if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                    $ArrayCollect[$t][1] += 1;
                }
                $ArrayCollect[$t][2] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;
        }

        for ($i = 0; $i < 100; $i++) {
            if ($ArrayCollect[$i][1] == 0) $ArrayCollect[$i][3] = 'Không xuất hiện';
            else $ArrayCollect[$i][3] = round($count / $ArrayCollect[$i][1], 2); // Ngày về trung bình
        }

        $view = view('frontend.thongkenhanh.thong-ke-tan-suat-bo-so-ajax', compact('count', 'ArrayCollect', 'province_name', 'province_id', 'province_slug', 'short_name'))->render();
        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKTienNuoiLo()
    {
        $soTienLaiNgay = 50000;
        $gia1Diem = 23000;
        $an1Diem = 80000;
        $soNgayNuoi = 20;
        $soLuongNuoi = 1;

        $ArrayCollect = array();
        for ($i = 0; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = 0; // Số điểm đánh
            $ArrayCollect[$i][1] = 0; // Tiền bỏ ra
            $ArrayCollect[$i][2] = 0; // Nếu lãi
            $ArrayCollect[$i][3] = 0; // Tổng tiền bỏ ra
        }
        $ArrayCollect[0][0] = ceil($soTienLaiNgay / ($an1Diem - $soLuongNuoi * $gia1Diem));
        $ArrayCollect[0][1] = $ArrayCollect[0][0] * $gia1Diem * $soLuongNuoi;
        $ArrayCollect[0][2] = $ArrayCollect[0][0] * $an1Diem - $ArrayCollect[0][1];

        $ArrayCollect[0][3] = $ArrayCollect[0][1];
        for ($i = 1; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = ceil(($soTienLaiNgay * ($i + 1) + $ArrayCollect[$i - 1][3]) / ($an1Diem - $soLuongNuoi * $gia1Diem));
            $ArrayCollect[$i][1] = $ArrayCollect[$i][0] * $gia1Diem * $soLuongNuoi;
            $ArrayCollect[$i][2] = $ArrayCollect[$i][0] * $an1Diem - $ArrayCollect[$i][1] - $ArrayCollect[$i - 1][3];

            $ArrayCollect[$i][3] = $ArrayCollect[$i - 1][3] + $ArrayCollect[$i][1];
        }

        return view('frontend.thongkenhanh.tinh-tien-nuoi-lo', compact('soNgayNuoi', 'soTienLaiNgay', 'soLuongNuoi', 'ArrayCollect'));
    }

    public function getTKTienNuoiLo_Ajax(Request $request)
    {
        $soTienLaiNgay = $request->soTienLaiNgay;
        $gia1Diem = $request->gia1Diem;
        $an1Diem = $request->an1Diem;
        $soNgayNuoi = $request->soNgayNuoi;
        $soLuongNuoi = $request->soLuongNuoi;

        if ($soLuongNuoi == 1 && $soNgayNuoi >= 50) $soNgayNuoi = 50;
        if ($soLuongNuoi == 2 && $soNgayNuoi >= 30) $soNgayNuoi = 30;

        $ArrayCollect = array();
        for ($i = 0; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = 0; // Số điểm đánh
            $ArrayCollect[$i][1] = 0; // Tiền bỏ ra
            $ArrayCollect[$i][2] = 0; // Nếu lãi
            $ArrayCollect[$i][3] = 0; // Tổng tiền bỏ ra
        }
        $ArrayCollect[0][0] = ceil($soTienLaiNgay / ($an1Diem - $soLuongNuoi * $gia1Diem));
        $ArrayCollect[0][1] = $ArrayCollect[0][0] * $gia1Diem * $soLuongNuoi;
        $ArrayCollect[0][2] = $ArrayCollect[0][0] * $an1Diem - $ArrayCollect[0][1];

        $ArrayCollect[0][3] = $ArrayCollect[0][1];
        for ($i = 1; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = ceil(($soTienLaiNgay * ($i + 1) + $ArrayCollect[$i - 1][3]) / ($an1Diem - $soLuongNuoi * $gia1Diem));
            $ArrayCollect[$i][1] = $ArrayCollect[$i][0] * $gia1Diem * $soLuongNuoi;
            $ArrayCollect[$i][2] = $ArrayCollect[$i][0] * $an1Diem - $ArrayCollect[$i][1] - $ArrayCollect[$i - 1][3];

            $ArrayCollect[$i][3] = $ArrayCollect[$i - 1][3] + $ArrayCollect[$i][1];
        }

        $view = view('frontend.thongkenhanh.tinh-tien-nuoi-lo-ajax', compact('soNgayNuoi', 'soTienLaiNgay', 'soLuongNuoi', 'ArrayCollect'))->render();
        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKTienNuoiLoXien()
    {
        $soTienLaiNgay = 100000;
        $gia1Diem = 10000;
        $an1Diem = 100000;
        $soNgayNuoi = 20;
        $soLuongNuoi = 1;

        $ArrayCollect = array();
        for ($i = 0; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = 0; // Số điểm đánh
            $ArrayCollect[$i][1] = 0; // Tiền bỏ ra
            $ArrayCollect[$i][2] = 0; // Nếu lãi
            $ArrayCollect[$i][3] = 0; // Tổng tiền bỏ ra
        }
        $ArrayCollect[0][0] = ceil($soTienLaiNgay / ($an1Diem - $soLuongNuoi * $gia1Diem));
        $ArrayCollect[0][1] = $ArrayCollect[0][0] * $gia1Diem * $soLuongNuoi;
        $ArrayCollect[0][2] = $ArrayCollect[0][0] * $an1Diem - $ArrayCollect[0][1];

        $ArrayCollect[0][3] = $ArrayCollect[0][1];
        for ($i = 1; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = ceil(($soTienLaiNgay * ($i + 1) + $ArrayCollect[$i - 1][3]) / ($an1Diem - $soLuongNuoi * $gia1Diem));
            $ArrayCollect[$i][1] = $ArrayCollect[$i][0] * $gia1Diem * $soLuongNuoi;
            $ArrayCollect[$i][2] = $ArrayCollect[$i][0] * $an1Diem - $ArrayCollect[$i][1] - $ArrayCollect[$i - 1][3];

            $ArrayCollect[$i][3] = $ArrayCollect[$i - 1][3] + $ArrayCollect[$i][1];
        }

        return view('frontend.thongkenhanh.tinh-tien-nuoi-lo-xien', compact('soNgayNuoi', 'soTienLaiNgay', 'soLuongNuoi', 'ArrayCollect'));
    }

    public function getTKTienNuoiLoXien_Ajax(Request $request)
    {
        $xien = $request->xien;
        $soTienLaiNgay = $request->soTienLaiNgay;
        $gia1Diem = $request->gia1Diem;
        $an1Diem = $request->an1Diem;
        $soNgayNuoi = $request->soNgayNuoi;
        $soLuongNuoi = $request->soLuongNuoi;

        if ($xien == 2) {
            if ($soLuongNuoi >= 1 && $soNgayNuoi >= 100) $soNgayNuoi = 100;
            if ($soLuongNuoi >= 3 && $soNgayNuoi >= 50) $soNgayNuoi = 50;
            if ($soLuongNuoi >= 5 && $soNgayNuoi >= 20) $soNgayNuoi = 20;
            if ($soLuongNuoi >= 8 && $soNgayNuoi >= 15) $soNgayNuoi = 15;
        } else {
            if ($soNgayNuoi >= 100) $soNgayNuoi = 100;
        }


        $ArrayCollect = array();
        for ($i = 0; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = 0; // Số điểm đánh
            $ArrayCollect[$i][1] = 0; // Tiền bỏ ra
            $ArrayCollect[$i][2] = 0; // Nếu lãi
            $ArrayCollect[$i][3] = 0; // Tổng tiền bỏ ra
        }
        $ArrayCollect[0][0] = ceil($soTienLaiNgay / ($an1Diem - $soLuongNuoi * $gia1Diem));
        $ArrayCollect[0][1] = $ArrayCollect[0][0] * $gia1Diem * $soLuongNuoi;
        $ArrayCollect[0][2] = $ArrayCollect[0][0] * $an1Diem - $ArrayCollect[0][1];

        $ArrayCollect[0][3] = $ArrayCollect[0][1];
        for ($i = 1; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = ceil(($soTienLaiNgay * ($i + 1) + $ArrayCollect[$i - 1][3]) / ($an1Diem - $soLuongNuoi * $gia1Diem));
            $ArrayCollect[$i][1] = $ArrayCollect[$i][0] * $gia1Diem * $soLuongNuoi;
            $ArrayCollect[$i][2] = $ArrayCollect[$i][0] * $an1Diem - $ArrayCollect[$i][1] - $ArrayCollect[$i - 1][3];

            $ArrayCollect[$i][3] = $ArrayCollect[$i - 1][3] + $ArrayCollect[$i][1];
        }

        $view = view('frontend.thongkenhanh.tinh-tien-nuoi-lo-xien-ajax', compact('xien', 'soNgayNuoi', 'soTienLaiNgay', 'soLuongNuoi', 'ArrayCollect'))->render();
        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKTienNuoiDB()
    {
        $soTienLaiNgay = 50000;
        $gia1Diem = 1000;
        $an1Diem = 80000;
        $soNgayNuoi = 20;
        $soLuongNuoi = 20;

        $ArrayCollect = array();
        for ($i = 0; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = 0; // Số điểm đánh
            $ArrayCollect[$i][1] = 0; // Tiền bỏ ra
            $ArrayCollect[$i][2] = 0; // Nếu lãi
            $ArrayCollect[$i][3] = 0; // Tổng tiền bỏ ra
        }
        $ArrayCollect[0][0] = ceil($soTienLaiNgay / ($an1Diem - $soLuongNuoi * $gia1Diem));
        $ArrayCollect[0][1] = $ArrayCollect[0][0] * $gia1Diem * $soLuongNuoi;
        $ArrayCollect[0][2] = $ArrayCollect[0][0] * $an1Diem - $ArrayCollect[0][1];

        $ArrayCollect[0][3] = $ArrayCollect[0][1];
        for ($i = 1; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = ceil(($soTienLaiNgay * ($i + 1) + $ArrayCollect[$i - 1][3]) / ($an1Diem - $soLuongNuoi * $gia1Diem));
            $ArrayCollect[$i][1] = $ArrayCollect[$i][0] * $gia1Diem * $soLuongNuoi;
            $ArrayCollect[$i][2] = $ArrayCollect[$i][0] * $an1Diem - $ArrayCollect[$i][1] - $ArrayCollect[$i - 1][3];

            $ArrayCollect[$i][3] = $ArrayCollect[$i - 1][3] + $ArrayCollect[$i][1];
        }

        return view('frontend.thongkenhanh.tinh-tien-nuoi-db', compact('soNgayNuoi', 'soTienLaiNgay', 'soLuongNuoi', 'ArrayCollect'));
    }

    public function getTKTienNuoiDB_Ajax(Request $request)
    {
        $soTienLaiNgay = $request->soTienLaiNgay;
        $gia1Diem = 1000;
        $an1Diem = $request->an1Diem;
        $soNgayNuoi = $request->soNgayNuoi;
        $soLuongNuoi = $request->soLuongNuoi;

        if ($soLuongNuoi >= 65 && $soNgayNuoi >= 10) $soNgayNuoi = 10;
        if ($soLuongNuoi >= 50 && $soNgayNuoi >= 25) $soNgayNuoi = 25;
        if ($soLuongNuoi >= 25 && $soNgayNuoi >= 30) $soNgayNuoi = 30;
        if ($soLuongNuoi >= 21 && $soNgayNuoi >= 50) $soNgayNuoi = 50;
        if ($soLuongNuoi >= 11 && $soNgayNuoi >= 100) $soNgayNuoi = 100;
        if ($soLuongNuoi >= 5 && $soNgayNuoi >= 200) $soNgayNuoi = 200;
        if ($soLuongNuoi >= 1 && $soNgayNuoi >= 500) $soNgayNuoi = 500;


        if ($an1Diem - $soLuongNuoi * $gia1Diem <= 0) {
            $view = "<div class=\"row\"><div class=\"col-md-12\" style=\"text-align: center;padding: 50px 0px\">Dữ liệu không tồn tại!</div></div>";
            $dataReturn = ["template" => $view];
            return json_encode($dataReturn);
        }
        $ArrayCollect = array();
        for ($i = 0; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = 0; // Số điểm đánh
            $ArrayCollect[$i][1] = 0; // Tiền bỏ ra
            $ArrayCollect[$i][2] = 0; // Nếu lãi
            $ArrayCollect[$i][3] = 0; // Tổng tiền bỏ ra
        }
        $ArrayCollect[0][0] = ceil($soTienLaiNgay / ($an1Diem - $soLuongNuoi * $gia1Diem));
        $ArrayCollect[0][1] = $ArrayCollect[0][0] * $gia1Diem * $soLuongNuoi;
        $ArrayCollect[0][2] = $ArrayCollect[0][0] * $an1Diem - $ArrayCollect[0][1];

        $ArrayCollect[0][3] = $ArrayCollect[0][1];
        for ($i = 1; $i < $soNgayNuoi; $i++) {
            $ArrayCollect[$i][0] = ceil(($soTienLaiNgay * ($i + 1) + $ArrayCollect[$i - 1][3]) / ($an1Diem - $soLuongNuoi * $gia1Diem));
            $ArrayCollect[$i][1] = $ArrayCollect[$i][0] * $gia1Diem * $soLuongNuoi;
            $ArrayCollect[$i][2] = $ArrayCollect[$i][0] * $an1Diem - $ArrayCollect[$i][1] - $ArrayCollect[$i - 1][3];

            $ArrayCollect[$i][3] = $ArrayCollect[$i - 1][3] + $ArrayCollect[$i][1];
        }

        $view = view('frontend.thongkenhanh.tinh-tien-nuoi-db-ajax', compact('soNgayNuoi', 'soTienLaiNgay', 'soLuongNuoi', 'ArrayCollect'))->render();
        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getGopSo()
    {
        return view('frontend.thongkenhanh.gop-so');
    }

    public function getTachSo()
    {
        return view('frontend.thongkenhanh.tach-so');
    }

    public function getGhepLoXien()
    {
        return view('frontend.thongkenhanh.ghep-lo-xien');
    }

    public function getTaoDanDB()
    {
        return view('frontend.thongkenhanh.tao-dan-db');
    }

    public function getLocGhepDan()
    {
        return view('frontend.thongkenhanh.loc-ghep-dan');
    }

    public function getLoaiDanDB()
    {
        return view('frontend.thongkenhanh.loai-dan-db');
    }

    public function getTKTheoNgay()
    {
        $short_name = 'mb';
        $count = 28;
        $day = getThuNumber(date('Y-m-d', time()));

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('day', $day)->orderBy('date', 'DESC')->take($count)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $short_name = 'mb';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $short_name = $province->short_name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('day', $day)->orderBy('date', 'DESC')->take($count)->get();
        }
        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = 0; // Tổng số lần xuất hiện

        }
        $number_date = 0;

        foreach ($kqs as $kq) {
            $tmp_result = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result);
            for ($t = 0; $t < 100; $t++) {
                // đếm tổng số lần xuất hiện
                $ArrayCollect[$t][1] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;
        }

        // thống kê tần suất
        for ($e = 0; $e < 99; $e++) {
            for ($f = $e + 1; $f < 100; $f++) {
                if ($ArrayCollect[$e][1] < $ArrayCollect[$f][1]) {
                    swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                    swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                }
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongkenhanh.thong-ke-theo-ngay', compact('ArrayCollect', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name', 'day'));
    }

    public function getTKTheoNgay_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $day_method = $request->day_method;
        $count = $day_method * 7;
        $day = $request->thu;
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('day', $day)->orderBy('date', 'DESC')->take($count)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $short_name = 'mb';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $short_name = $province->short_name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('day', $day)->orderBy('date', 'DESC')->take($count)->get();
        }

        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = 0; // Tổng số lần xuất hiện

        }
        $number_date = 0;

        foreach ($kqs as $kq) {
            $tmp_result = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result);
            for ($t = 0; $t < 100; $t++) {
                // đếm tổng số lần xuất hiện
                $ArrayCollect[$t][1] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;
        }

        // thống kê tần suất
        for ($e = 0; $e < 99; $e++) {
            for ($f = $e + 1; $f < 100; $f++) {
                if ($ArrayCollect[$e][1] < $ArrayCollect[$f][1]) {
                    swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                    swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                }
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $count_kqs = count($kqs);
        $view = view('frontend.thongkenhanh.thong-ke-theo-ngay-ajax', compact('ArrayCollect', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name', 'day', 'day_method', 'count_kqs'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKTongHop()
    {
        $short_name = 'mb';
        $dateStart = date('Y-m-d', strtotime('-365 days'));
        $dateEnd = date('Y-m-d');

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $short_name = 'mb';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $short_name = $province->short_name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->get();
        }

        // tạo mảng đầu đuôi
        $ArrayCollect_Dau = array();
        $ArrayCollect_Duoi = array();
        for ($t = 0; $t < 10; $t++) {
            $ArrayCollect_Dau[$t][0] = $t;
            $ArrayCollect_Dau[$t][1] = 0;

            $ArrayCollect_Duoi[$t][0] = $t;
            $ArrayCollect_Duoi[$t][1] = 0;
        }

        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect[$i][2] = -1; // số ngày chưa về
            $ArrayCollect[$i][3] = 0; // số ngày chưa về

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
                $ArrayCollect[$t][3] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;

            for ($t = 0; $t < 10; $t++) {
                foreach ($arr_kq as $loto) {
                    if ($t == substr($loto, 0, 1)) {
                        $ArrayCollect_Dau[$t][1] = $ArrayCollect_Dau[$t][1] + 1;
                    }
                    if ($t == substr($loto, 1, 1)) {
                        $ArrayCollect_Duoi[$t][1] = $ArrayCollect_Duoi[$t][1] + 1;
                    }
                }
            }
        }

        $ArrayCollect_ts = $ArrayCollect;
        for ($e = 0; $e < 99; $e++) {
            for ($f = $e + 1; $f < 100; $f++) {
                if ($ArrayCollect_ts[$e][3] < $ArrayCollect_ts[$f][3]) {
                    swap($ArrayCollect_ts[$e][2], $ArrayCollect_ts[$f][2]);
                    swap($ArrayCollect_ts[$e][0], $ArrayCollect_ts[$f][0]);
                    swap($ArrayCollect_ts[$e][1], $ArrayCollect_ts[$f][1]);
                    swap($ArrayCollect_ts[$e][3], $ArrayCollect_ts[$f][3]);
                }
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.thongkenhanh.thong-ke-tong-hop', compact('ArrayCollect', 'ArrayCollect_ts', 'ArrayCollect_Dau', 'ArrayCollect_Duoi', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name'));
    }

    public function getTKTongHop_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $giaidb = 0;
        if (!empty($request->giaidb))
            $giaidb = $request->giaidb;
        $dateStart = getNgaycheo($request->start_date);
        $dateEnd = getNgaycheo($request->end_date);


        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $short_name = 'mb';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $short_name = $province->short_name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->get();
        }

        // tạo mảng đầu đuôi
        $ArrayCollect_Dau = array();
        $ArrayCollect_Duoi = array();
        for ($t = 0; $t < 10; $t++) {
            $ArrayCollect_Dau[$t][0] = $t;
            $ArrayCollect_Dau[$t][1] = 0;

            $ArrayCollect_Duoi[$t][0] = $t;
            $ArrayCollect_Duoi[$t][1] = 0;
        }

        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect[$i][2] = -1; // số ngày chưa về
            $ArrayCollect[$i][3] = 0; // số ngày chưa về

        }
        $len_collect = count($ArrayCollect);
        $number_date = 0;


        foreach ($kqs as $kq) {
            if ($giaidb == 0) {
                $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            } else {
                $tmp_result1 = $kq->gdb;
            }
            $arr_kq = getLoto($tmp_result1);
            for ($t = 0; $t < $len_collect; $t++) {
                if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                    if ($ArrayCollect[$t][2] == -1) {
                        $ArrayCollect[$t][1] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][2] = $number_date;
                    }
                }
                $ArrayCollect[$t][3] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;

            for ($t = 0; $t < 10; $t++) {
                foreach ($arr_kq as $loto) {
                    if ($t == substr($loto, 0, 1)) {
                        $ArrayCollect_Dau[$t][1] = $ArrayCollect_Dau[$t][1] + 1;
                    }
                    if ($t == substr($loto, 1, 1)) {
                        $ArrayCollect_Duoi[$t][1] = $ArrayCollect_Duoi[$t][1] + 1;
                    }
                }
            }
        }

        $ArrayCollect_ts = $ArrayCollect;
        for ($e = 0; $e < 99; $e++) {
            for ($f = $e + 1; $f < 100; $f++) {
                if ($ArrayCollect_ts[$e][3] < $ArrayCollect_ts[$f][3]) {
                    swap($ArrayCollect_ts[$e][2], $ArrayCollect_ts[$f][2]);
                    swap($ArrayCollect_ts[$e][0], $ArrayCollect_ts[$f][0]);
                    swap($ArrayCollect_ts[$e][1], $ArrayCollect_ts[$f][1]);
                    swap($ArrayCollect_ts[$e][3], $ArrayCollect_ts[$f][3]);
                }
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        $view = view('frontend.thongkenhanh.thong-ke-tong-hop-ajax', compact('ArrayCollect', 'ArrayCollect_ts', 'ArrayCollect_Dau', 'ArrayCollect_Duoi', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKQuanTrong()
    {
        $short_name = 'mb';
        $dateEnd = date('Y-m-d');

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->take(30)->orderBy('date', 'DESC')->get()->toArray();
            $kq_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $short_name = 'mb';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $short_name = $province->short_name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', $dateEnd)->take(30)->orderBy('date', 'DESC')->get()->toArray();
            $kq_latest = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->first();
        }
        $ArrayCollect_lt = $this->getTKLienTiepMAXMB($kqs);

        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect[$i][2] = -1; // số ngày chưa về
            $ArrayCollect[$i][3] = 0; // số ngày chưa về

        }

        $len_collect = count($ArrayCollect);
        $number_date = 0;


        for ($k = 0; $k <= 29; $k++) {
            $kq = $kqs[$k];
            $tmp_result = $kq['gdb'] . '-' . $kq['g1'] . '-' . $kq['g2'] . '-' . $kq['g3'] . '-' . $kq['g4'] . '-' . $kq['g5'] . '-' . $kq['g6'] . '-' . $kq['g7'] . '-' . $kq['g8'];
            $arr_kq = getLoto($tmp_result);
            for ($t = 0; $t < $len_collect; $t++) {
                if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                    if ($ArrayCollect[$t][2] == -1) {
                        $ArrayCollect[$t][1] = getNgay($kq['date']);
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][2] = $number_date;
                    }
                }
                $ArrayCollect[$t][3] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;
        }

        for ($e = 0; $e < 99; $e++) {
            for ($f = $e + 1; $f < 100; $f++) {
                if ($ArrayCollect[$e][2] < $ArrayCollect[$f][2]) {
                    swap($ArrayCollect[$e][2], $ArrayCollect[$f][2]);
                    swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                    swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                    swap($ArrayCollect[$e][3], $ArrayCollect[$f][3]);
                }
            }
        }

        $ArrayCollect_ts = $ArrayCollect;
        for ($e = 0; $e < 99; $e++) {
            for ($f = $e + 1; $f < 100; $f++) {
                if ($ArrayCollect_ts[$e][3] < $ArrayCollect_ts[$f][3]) {
                    swap($ArrayCollect_ts[$e][2], $ArrayCollect_ts[$f][2]);
                    swap($ArrayCollect_ts[$e][0], $ArrayCollect_ts[$f][0]);
                    swap($ArrayCollect_ts[$e][1], $ArrayCollect_ts[$f][1]);
                    swap($ArrayCollect_ts[$e][3], $ArrayCollect_ts[$f][3]);
                }
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        return view('frontend.thongkenhanh.thong-ke-quan-trong', compact('ArrayCollect', 'ArrayCollect_ts', 'ArrayCollect_lt', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name', 'kq_latest'));
    }

    public function getTKQuanTrong_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $dateEnd = date('Y-m-d');

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->take(30)->orderBy('date', 'DESC')->get()->toArray();
            $kq_latest = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $short_name = 'mb';
        } else {
            $province = Province::where('short_name', $short_name)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $short_name = $province->short_name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', $dateEnd)->take(30)->orderBy('date', 'DESC')->get()->toArray();
            $kq_latest = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->first();
        }
        $ArrayCollect_lt = $this->getTKLienTiepMAXMB($kqs);

        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect[$i][2] = -1; // số ngày chưa về
            $ArrayCollect[$i][3] = 0; // số ngày chưa về

        }

        $len_collect = count($ArrayCollect);
        $number_date = 0;


        for ($k = 0; $k <= 29; $k++) {
            $kq = $kqs[$k];
            $tmp_result = $kq['gdb'] . '-' . $kq['g1'] . '-' . $kq['g2'] . '-' . $kq['g3'] . '-' . $kq['g4'] . '-' . $kq['g5'] . '-' . $kq['g6'] . '-' . $kq['g7'] . '-' . $kq['g8'];
            $arr_kq = getLoto($tmp_result);
            for ($t = 0; $t < $len_collect; $t++) {
                if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                    if ($ArrayCollect[$t][2] == -1) {
                        $ArrayCollect[$t][1] = getNgay($kq['date']);
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][2] = $number_date;
                    }
                }
                $ArrayCollect[$t][3] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;
        }

        for ($e = 0; $e < 99; $e++) {
            for ($f = $e + 1; $f < 100; $f++) {
                if ($ArrayCollect[$e][2] < $ArrayCollect[$f][2]) {
                    swap($ArrayCollect[$e][2], $ArrayCollect[$f][2]);
                    swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                    swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                    swap($ArrayCollect[$e][3], $ArrayCollect[$f][3]);
                }
            }
        }

        $ArrayCollect_ts = $ArrayCollect;
        for ($e = 0; $e < 99; $e++) {
            for ($f = $e + 1; $f < 100; $f++) {
                if ($ArrayCollect_ts[$e][3] < $ArrayCollect_ts[$f][3]) {
                    swap($ArrayCollect_ts[$e][2], $ArrayCollect_ts[$f][2]);
                    swap($ArrayCollect_ts[$e][0], $ArrayCollect_ts[$f][0]);
                    swap($ArrayCollect_ts[$e][1], $ArrayCollect_ts[$f][1]);
                    swap($ArrayCollect_ts[$e][3], $ArrayCollect_ts[$f][3]);
                }
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $view = view('frontend.thongkenhanh.thong-ke-quan-trong-ajax', compact('ArrayCollect', 'ArrayCollect_ts', 'ArrayCollect_lt', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name', 'kq_latest'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKLienTiepMAXMB($kqs)
    {
        set_time_limit(0);
        // tạo mảng bộ số từ 00->99
        $ArrayCollect_lt = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect_lt[$i][0] = '0' . $i;
            } else {
                $ArrayCollect_lt[$i][0] = $i;
            }
            $ArrayCollect_lt[$i][1] = -1; // số ngày về liên tiếp
            $ArrayCollect_lt[$i][2] = ''; // ngày về gần nhất
            $ArrayCollect_lt[$i][3] = ''; // ngày về gần nhất trong chuỗi liên tiếp
            $ArrayCollect_lt[$i][4] = 0; // tổng số lần về
        }
        $len_collect = count($ArrayCollect_lt);
        for ($t = 0; $t < $len_collect; $t++) {
            $number_date = 0;
            for ($k = 29; $k >= 0; $k--) {
                $kq = $kqs[$k];
                $tmp_result = $kq['gdb'] . '-' . $kq['g1'] . '-' . $kq['g2'] . '-' . $kq['g3'] . '-' . $kq['g4'] . '-' . $kq['g5'] . '-' . $kq['g6'] . '-' . $kq['g7'] . '-' . $kq['g8'];
                $arr_kq = getLoto($tmp_result);
                if (!in_array($ArrayCollect_lt[$t][0], $arr_kq)) {
                    if ($ArrayCollect_lt[$t][1] <= $number_date) {
                        /*Tinh so ngay về liên tiếp*/
                        $ArrayCollect_lt[$t][1] = $number_date;
                        $ArrayCollect_lt[$t][3] = $ArrayCollect_lt[$t][2];
                    }
                    $number_date = 0;
                } else {
                    $ArrayCollect_lt[$t][2] = $kq['date'];
                    $number_date++;
                }
                $ArrayCollect_lt[$t][4] += solan_xuathien_trongngay($ArrayCollect_lt[$t][0], $arr_kq);
            }
            if ($ArrayCollect_lt[$t][1] <= $number_date) {
                /*Tinh so ngay về liên tiếp*/
                $ArrayCollect_lt[$t][1] = $number_date;
                $ArrayCollect_lt[$t][3] = $ArrayCollect_lt[$t][2];
            }
        }
        for ($e = 0; $e < 99; $e++) {
            for ($f = $e + 1; $f < 100; $f++) {
                if ($ArrayCollect_lt[$e][1] < $ArrayCollect_lt[$f][1]) {
                    swap($ArrayCollect_lt[$e][2], $ArrayCollect_lt[$f][2]);
                    swap($ArrayCollect_lt[$e][0], $ArrayCollect_lt[$f][0]);
                    swap($ArrayCollect_lt[$e][1], $ArrayCollect_lt[$f][1]);
                    swap($ArrayCollect_lt[$e][3], $ArrayCollect_lt[$f][3]);
                    swap($ArrayCollect_lt[$e][4], $ArrayCollect_lt[$f][4]);
                }
            }
        }
//        for ($t = 0; $t < $len_collect; $t++) {
//            if($ArrayCollect_lt[$t][3] == $kq_latest->date){
//                echo $ArrayCollect_lt[$t][0].'-'.$ArrayCollect_lt[$t][1].'<br/>';
//            }
//        }


        return $ArrayCollect_lt;

    }

    public function getTaoDanDe()
    {
        return view('frontend.thongkenhanh.tao-dan-de');
    }

    public function getLichQuayThuong()
    {
        return view('frontend.thongkenhanh.lich-quay-thuong');
    }

    public function getDoXoSo()
    {
        $province_id = 'mb';
//        $date = $request->date;
        $veso = '88888';
        if ($province_id == 'mb') {
            $kq = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            $province_name = 'Miền Bắc';
            // tạo mảng bộ số
            $arr_vitri = ['Đặc Biệt', '1', '2(1)', '2(2)', '3(1)', '3(2)', '3(3)', '3(4)', '3(5)', '3(6)', '4(1)', '4(2)', '4(3)', '4(4)', '5(1)', '5(2)', '5(3)', '5(4)', '5(5)', '5(6)', '6(1)', '6(2)', '6(3)', '7(1)', '7(2)', '7(3)', '7(4)'];
        } else {
            $province = Province::where('id', $province_id)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;

            $kq = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->first();

            // tạo mảng bộ số
            $arr_vitri = ['Đặc Biệt', '1', '2', '3(1)', '3(2)', '4(1)', '4(2)', '4(3)', '4(4)', '4(5)', '4(6)', '4(7)', '5', '6(1)', '6(2)', '6(3)', '7', '8'];
        }
        $arr_veso[] = $veso;
        $arr_veso_loto[] = substr($veso, -2);
        $tmp_result = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
        $arr_kq = explode('-', $tmp_result);
        $arr_kq_loto = getLoto($tmp_result);

        $arr_check_veso = array_intersect($arr_kq, $arr_veso);
        $arr_check_veso_loto = array_intersect($arr_kq_loto, $arr_veso_loto);

        $str_trung_giai = '';
        $str_trung_giai_loto = '';
        if(count($arr_check_veso) > 0){
            foreach($arr_check_veso as $key=>$value){
                $str_trung_giai .= 'Giải '.$arr_vitri[$key].', ';
            }
        }
        if(count($arr_check_veso_loto) > 0){
            foreach($arr_check_veso_loto as $key=>$value){
                $str_trung_giai_loto .= 'Giải '.$arr_vitri[$key].', ';
            }
        }
        if(!empty($str_trung_giai)){
            $str_trung_giai  = substr($str_trung_giai,0,-2);
        }
        if(!empty($str_trung_giai_loto)){
            $str_trung_giai_loto  = substr($str_trung_giai_loto,0,-2);
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongkenhanh.do-xo-so', compact('provinces','province_id','kq','veso','province_name','str_trung_giai','str_trung_giai_loto'));

    }

    public function getDoXoSo_Ajax(Request $request)
    {
        $province_id = $request->province_id;
        $date = getNgaycheo($request->date);;
        $veso = $request->veso;
        if(empty($veso)) $veso = '88888';
        if ($province_id == 'mb') {
            $kq = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->orderBy('date', 'DESC')->first();
            $province_name = 'Miền Bắc';
            // tạo mảng bộ số
            $arr_vitri = ['Đặc Biệt', '1', '2(1)', '2(2)', '3(1)', '3(2)', '3(3)', '3(4)', '3(5)', '3(6)', '4(1)', '4(2)', '4(3)', '4(4)', '5(1)', '5(2)', '5(3)', '5(4)', '5(5)', '5(6)', '6(1)', '6(2)', '6(3)', '7(1)', '7(2)', '7(3)', '7(4)'];
        } else {
            $province = Province::where('id', $province_id)->first();
            if (empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;

            $kq = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', $date)->orderBy('date', 'DESC')->first();

            // tạo mảng bộ số
            $arr_vitri = ['Đặc Biệt', '1', '2', '3(1)', '3(2)', '4(1)', '4(2)', '4(3)', '4(4)', '4(5)', '4(6)', '4(7)', '5', '6(1)', '6(2)', '6(3)', '7', '8'];
        }

        $str_trung_giai = '';
        $str_trung_giai_loto = '';
        if(!empty($kq)){
            $arr_veso[] = $veso;
            $arr_veso_loto[] = substr($veso, -2);
            $tmp_result = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = explode('-', $tmp_result);
            $arr_kq_loto = getLoto($tmp_result);

            $arr_check_veso = array_intersect($arr_kq, $arr_veso);
            $arr_check_veso_loto = array_intersect($arr_kq_loto, $arr_veso_loto);

            if(count($arr_check_veso) > 0){
                foreach($arr_check_veso as $key=>$value){
                    $str_trung_giai .= 'Giải '.$arr_vitri[$key].', ';
                }
            }
            if(count($arr_check_veso_loto) > 0){
                foreach($arr_check_veso_loto as $key=>$value){
                    $str_trung_giai_loto .= 'Giải '.$arr_vitri[$key].', ';
                }
            }
            if(!empty($str_trung_giai)){
                $str_trung_giai  = substr($str_trung_giai,0,-2);
            }
            if(!empty($str_trung_giai_loto)){
                $str_trung_giai_loto  = substr($str_trung_giai_loto,0,-2);
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $view = view('frontend.thongkenhanh.do-xo-so-ajax', compact('date','provinces','province_id','kq','veso','province_name','str_trung_giai','str_trung_giai_loto'))->render();
        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
     }
}
