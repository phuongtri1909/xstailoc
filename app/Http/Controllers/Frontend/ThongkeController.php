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

class ThongkeController extends Controller
{
    public function getTKLoGanMN()
    {
        $provinces = Province::where('mien', 3)->get();
        return view('frontend.thongke.lo-gan-mn', compact('provinces'));
    }
    public function getTKLoGanMT()
    {
        $provinces = Province::where('mien', 2)->get();
        return view('frontend.thongke.lo-gan-mt', compact('provinces'));
    }
    public function getTKLoGan($short_name)
    {
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
            $kqs_db = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(600)->get();

            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $province = Province::find($province_id);

        } else {
            $province = Province::where('short_name', $short_name)->first();
            if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
            $kqs_db = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take(600)->get();


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

        }
        $len_collect = count($ArrayCollect);
        $number_date = 0;

        // tạo mảng bộ số cặp
        $i = 0;
        $ArrayCollect_cap = array();
        for ($t = 0; $t <= 8; $t++) {
            for ($h = $t + 1; $h <= 9; $h++) {
                $ArrayCollect_cap[$i][0] = $t . $h;
                $ArrayCollect_cap[$i][1] = ''; // ngày về gần nhất
                $ArrayCollect_cap[$i][2] = -1; // số ngày chưa về
                $i++;
            }
        }
        for ($t = 0; $t <= 4; $t++) {
            $ArrayCollect_cap[$i][0] = $t . $t;
            $ArrayCollect_cap[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect_cap[$i][2] = -1; // số ngày chưa về
            $i++;
        }
        $len_collect_cap = count($ArrayCollect_cap);

        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);
            for ($t = 0; $t < $len_collect; $t++) {
                if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                    if ($ArrayCollect[$t][2] == -1) {
                        $ArrayCollect[$t][1] = $kq->date;
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][2] = $number_date;
                    }
                }
            }
            for ($t = 0; $t < $len_collect_cap; $t++) {
                if (in_array($ArrayCollect_cap[$t][0], $arr_kq) || in_array(lon($ArrayCollect_cap[$t][0]), $arr_kq)) {
                    if ($ArrayCollect_cap[$t][2] == -1) {
                        $ArrayCollect_cap[$t][1] = $kq->date;
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect_cap[$t][2] = $number_date;
                    }
                }
            }
            $number_date++;
        }
        $logan_arr = $ArrayCollect;
        $logan_cap_arr = $ArrayCollect_cap;
        
        for ($e = 0; $e < $len_collect - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect; $f++) {
                if ($ArrayCollect[$e][2] < $ArrayCollect[$f][2]) {
                    swap($ArrayCollect[$e][2], $ArrayCollect[$f][2]);
                    swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                    swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                }
            }
        }

        
        for ($e = 0; $e < $len_collect_cap - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect_cap; $f++) {
                if ($ArrayCollect_cap[$e][2] < $ArrayCollect_cap[$f][2]) {
                    swap($ArrayCollect_cap[$e][2], $ArrayCollect_cap[$f][2]);
                    swap($ArrayCollect_cap[$e][0], $ArrayCollect_cap[$f][0]);
                    swap($ArrayCollect_cap[$e][1], $ArrayCollect_cap[$f][1]);
                }
            }
        }
       

       
        /// thông kê giải đặc biệt
        $Array_Dau = array();
        $Array_Duoi = array();
        $Array_Tong = array();
        $Array_Boso = array();
        for ($i = 0; $i < 10; $i++) {
            $Array_Dau[$i][0] = $i;
            $Array_Dau[$i][1] = -1; // số ngày chưa về
            $Array_Dau[$i][2] = ''; // ngày vê gần nhất

        }
        
        for ($i = 0; $i < 10; $i++) {
            $Array_Duoi[$i][0] = $i;
            $Array_Duoi[$i][1] = -1; // số ngày chưa về
            $Array_Duoi[$i][2] = ''; // ngày vê gần nhất

        }

        for ($i = 0; $i < 10; $i++) {
            $Array_Tong[$i][0] = $i;
            $Array_Tong[$i][1] = -1; // số ngày chưa về
            $Array_Tong[$i][2] = ''; // ngày vê gần nhất

        }

        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $Array_Boso[$i][0] = '0' . $i;
            } else {
                $Array_Boso[$i][0] = $i;
            }
            $Array_Boso[$i][1] = -1; // số ngày chưa về
            $Array_Boso[$i][2] = ''; // khoảng ngày

        }
        $len_dau = count($Array_Dau);
        $len_duoi = count($Array_Duoi);
        $len_tong = count($Array_Tong);
        $len_boso = count($Array_Boso);


        $number_date = 0;
       
        foreach ($kqs_db as $kq) {
            for ($t = 0; $t < $len_dau; $t++) {
                if ($Array_Dau[$t][0] == substr($kq->gdb, -2, 1)) {
                    if ($Array_Dau[$t][1] == -1) {
                        $Array_Dau[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Dau[$t][1] = $number_date;
                    }
                }
            }

            for ($t = 0; $t < $len_duoi; $t++) {
                if ($Array_Duoi[$t][0] == substr($kq->gdb, -1)) {
                    if ($Array_Duoi[$t][1] == -1) {
                        $Array_Duoi[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Duoi[$t][1] = $number_date;
                    }
                }
            }

            for ($t = 0; $t < $len_tong; $t++) {
                if ($Array_Tong[$t][0] == Tong(substr($kq->gdb, -2))) { 
                    if ($Array_Tong[$t][1] == -1) {
                        $Array_Tong[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Tong[$t][1] = $number_date;
                    }
                }
            }
            
            
            for ($t = 0; $t < $len_boso; $t++) {
                if ($Array_Boso[$t][0] == substr($kq->gdb, -2)) {
                    if ($Array_Boso[$t][1] == -1) {
                        $Array_Boso[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Boso[$t][1] = $number_date;
                    }
                }
            }
            $number_date++;
            
        }
        
        $maxgan_dau = array();
        $maxgan_duoi = array();
        $maxgan_tong = array();
        $maxgan_boso = array();
        
        $kqgan_dau = GanDB::where('province_id', $province_id)->where('type', 1)->orderBy('loto')->get();
        foreach ($kqgan_dau as $item) {
            $maxgan_dau[$item->loto] = $item->max;
        }

        $kqgan_duoi = GanDB::where('province_id', $province_id)->where('type', 2)->orderBy('loto')->get();
        foreach ($kqgan_duoi as $item) {
            $maxgan_duoi[$item->loto] = $item->max;
        }

        $kqgan_tong = GanDB::where('province_id', $province_id)->where('type', 3)->orderBy('loto')->get();
        foreach ($kqgan_tong as $item) {
            $maxgan_tong[$item->loto] = $item->max;
        }

        $kqgan_boso = GanDB::where('province_id', $province_id)->where('type', 4)->orderBy('loto')->get();
        foreach ($kqgan_boso as $item) {
            $maxgan_boso[$item->loto] = $item->max;
        }
        //End giải đặc biệt


        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $maxgan = array();
        
        $kqgan = Gan::where('province_id', $province_id)->where('type', 1)->orderBy('max','DESC')->get();
        foreach ($kqgan as $item) {
            $maxgan[$item->loto] = $item->max;
        }
        

        $maxgan_cap = array();
        $kqgan_cap = Gan::where('province_id', $province_id)->where('type', 2)->orderBy('max','DESC')->get();
        foreach ($kqgan_cap as $item) {
            $maxgan_cap[$item->loto] = $item->max;
        }
        
        return view('frontend.thongke.lo-gan', compact('ArrayCollect', 'ArrayCollect_cap', 'logan_arr', 'logan_cap_arr', 'kqgan', 'kqgan_cap', 'provinces', 'province', 'province_name', 'province_id', 'province_slug', 'maxgan', 'maxgan_cap', 'short_name', 'Array_Dau', 'Array_Duoi', 'Array_Tong', 'Array_Boso', 'maxgan_dau', 'maxgan_duoi', 'maxgan_tong', 'maxgan_boso'));
    }
    public function getTKLoGan_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $count = $request->count;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
            $kqs_db = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(600)->get();

            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $province = Province::find($province_id);

        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
            $kqs_db = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take(600)->get();


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

        }
        $len_collect = count($ArrayCollect);
        $number_date = 0;

        // tạo mảng bộ số cặp
        $i = 0;
        $ArrayCollect_cap = array();
        for ($t = 0; $t <= 8; $t++) {
            for ($h = $t + 1; $h <= 9; $h++) {
                $ArrayCollect_cap[$i][0] = $t . $h;
                $ArrayCollect_cap[$i][1] = ''; // ngày về gần nhất
                $ArrayCollect_cap[$i][2] = -1; // số ngày chưa về
                $i++;
            }
        }
        for ($t = 0; $t <= 4; $t++) {
            $ArrayCollect_cap[$i][0] = $t . $t;
            $ArrayCollect_cap[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect_cap[$i][2] = -1; // số ngày chưa về
            $i++;
        }
        $len_collect_cap = count($ArrayCollect_cap);

        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);
            for ($t = 0; $t < $len_collect; $t++) {
                if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                    if ($ArrayCollect[$t][2] == -1) {
                        $ArrayCollect[$t][1] = $kq->date;
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][2] = $number_date;
                    }
                }
            }
            for ($t = 0; $t < $len_collect_cap; $t++) {
                if (in_array($ArrayCollect_cap[$t][0], $arr_kq) || in_array(lon($ArrayCollect_cap[$t][0]), $arr_kq)) {
                    if ($ArrayCollect_cap[$t][2] == -1) {
                        $ArrayCollect_cap[$t][1] = $kq->date;
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect_cap[$t][2] = $number_date;
                    }
                }
            }
            $number_date++;
        }
        $logan_arr = $ArrayCollect;
        $logan_cap_arr = $ArrayCollect_cap;

        for ($e = 0; $e < $len_collect - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect; $f++) {
                if ($ArrayCollect[$e][2] < $ArrayCollect[$f][2]) {
                    swap($ArrayCollect[$e][2], $ArrayCollect[$f][2]);
                    swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                    swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                }
            }
        }


        for ($e = 0; $e < $len_collect_cap - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect_cap; $f++) {
                if ($ArrayCollect_cap[$e][2] < $ArrayCollect_cap[$f][2]) {
                    swap($ArrayCollect_cap[$e][2], $ArrayCollect_cap[$f][2]);
                    swap($ArrayCollect_cap[$e][0], $ArrayCollect_cap[$f][0]);
                    swap($ArrayCollect_cap[$e][1], $ArrayCollect_cap[$f][1]);
                }
            }
        }



        /// thông kê giải đặc biệt
        $Array_Dau = array();
        $Array_Duoi = array();
        $Array_Tong = array();
        $Array_Boso = array();
        for ($i = 0; $i < 10; $i++) {
            $Array_Dau[$i][0] = $i;
            $Array_Dau[$i][1] = -1; // số ngày chưa về
            $Array_Dau[$i][2] = ''; // ngày vê gần nhất

        }

        for ($i = 0; $i < 10; $i++) {
            $Array_Duoi[$i][0] = $i;
            $Array_Duoi[$i][1] = -1; // số ngày chưa về
            $Array_Duoi[$i][2] = ''; // ngày vê gần nhất

        }

        for ($i = 0; $i < 10; $i++) {
            $Array_Tong[$i][0] = $i;
            $Array_Tong[$i][1] = -1; // số ngày chưa về
            $Array_Tong[$i][2] = ''; // ngày vê gần nhất

        }

        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $Array_Boso[$i][0] = '0' . $i;
            } else {
                $Array_Boso[$i][0] = $i;
            }
            $Array_Boso[$i][1] = -1; // số ngày chưa về
            $Array_Boso[$i][2] = ''; // khoảng ngày

        }
        $len_dau = count($Array_Dau);
        $len_duoi = count($Array_Duoi);
        $len_tong = count($Array_Tong);
        $len_boso = count($Array_Boso);


        $number_date = 0;
        foreach ($kqs_db as $kq) {
            for ($t = 0; $t < $len_dau; $t++) {
                if ($Array_Dau[$t][0] == substr($kq->gdb, -2, 1)) {
                    if ($Array_Dau[$t][1] == -1) {
                        $Array_Dau[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Dau[$t][1] = $number_date;
                    }
                }
            }

            for ($t = 0; $t < $len_duoi; $t++) {
                if ($Array_Duoi[$t][0] == substr($kq->gdb, -1)) {
                    if ($Array_Duoi[$t][1] == -1) {
                        $Array_Duoi[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Duoi[$t][1] = $number_date;
                    }
                }
            }

            for ($t = 0; $t < $len_tong; $t++) {
                if ($Array_Tong[$t][0] == Tong(substr($kq->gdb, -2))) {
                    if ($Array_Tong[$t][1] == -1) {
                        $Array_Tong[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Tong[$t][1] = $number_date;
                    }
                }
            }


            for ($t = 0; $t < $len_boso; $t++) {
                if ($Array_Boso[$t][0] == substr($kq->gdb, -2)) {
                    if ($Array_Boso[$t][1] == -1) {
                        $Array_Boso[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Boso[$t][1] = $number_date;
                    }
                }
            }
            $number_date++;
        }

        $maxgan_dau = array();
        $maxgan_duoi = array();
        $maxgan_tong = array();
        $maxgan_boso = array();

        $kqgan_dau = GanDB::where('province_id', $province_id)->where('type', 1)->orderBy('loto')->get();
        foreach ($kqgan_dau as $item) {
            $maxgan_dau[$item->loto] = $item->max;
        }

        $kqgan_duoi = GanDB::where('province_id', $province_id)->where('type', 2)->orderBy('loto')->get();
        foreach ($kqgan_duoi as $item) {
            $maxgan_duoi[$item->loto] = $item->max;
        }

        $kqgan_tong = GanDB::where('province_id', $province_id)->where('type', 3)->orderBy('loto')->get();
        foreach ($kqgan_tong as $item) {
            $maxgan_tong[$item->loto] = $item->max;
        }

        $kqgan_boso = GanDB::where('province_id', $province_id)->where('type', 4)->orderBy('loto')->get();
        foreach ($kqgan_boso as $item) {
            $maxgan_boso[$item->loto] = $item->max;
        }
        //End giải đặc biệt


        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $maxgan = array();
        $kqgan = Gan::where('province_id', $province_id)->where('type', 1)->orderBy('max','DESC')->get();
        foreach ($kqgan as $item) {
            $maxgan[$item->loto] = $item->max;
        }

        $maxgan_cap = array();
        $kqgan_cap = Gan::where('province_id', $province_id)->where('type', 2)->orderBy('max','DESC')->get();
        foreach ($kqgan_cap as $item) {
            $maxgan_cap[$item->loto] = $item->max;
        }
        $view = view('frontend.thongke.lo-gan-ajax', compact('ArrayCollect', 'ArrayCollect_cap', 'logan_arr', 'logan_cap_arr', 'kqgan', 'kqgan_cap', 'provinces', 'province_name', 'province_id', 'province_slug', 'maxgan', 'maxgan_cap', 'short_name', 'count', 'Array_Dau', 'Array_Duoi', 'Array_Tong', 'Array_Boso', 'maxgan_dau', 'maxgan_duoi', 'maxgan_tong', 'maxgan_boso'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKDacBiet($short_name)
    {
        if ($short_name == 'mb') {
            $kq = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            $province_name = 'Miền Bắc';
            $province_id = 46;

        } else {
            $province = Province::where('short_name', $short_name)->first();
            $province_id = $province->id;
            $province_name = $province->name;
            $kq = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->first();
        }

        //  thống kê trong ngày
        $ArrayCollect = array();
        $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
        $arr_kq = getLoto($tmp_result1);
        $vals = array_count_values($arr_kq);

        $j = 0;
        foreach ($vals as $key => $item) {
            $ArrayCollect[$j][0] = $key;
            $ArrayCollect[$j][1] = $item;
            $j++;
        }
        $len_collect = count($ArrayCollect);
        for ($e = 0; $e < $len_collect - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect; $f++) {
                if ($ArrayCollect[$e][1] < $ArrayCollect[$f][1]) {
                    swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                    swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                }
            }
        }


        // lấy ra các ngày có ngày hôm trước có giải đb trùng giải đb của ngày chọn
        $lotoDB = substr($kq->gdb, strlen($kq->gdb) - 2);
        $dateDB = $kq->date;
        $giaiDB = $kq->gdb;

        if ($short_name == 'mb') {
            $kq_like_db = Lottery::where('mien', 1)->where('status', 1)->where('gdb', 'like', '%' . $lotoDB)->where('gdb', '!=', $kq->gdb)->select('gdb', 'date')->orderBy('date', 'DESC')->get();
        } else {
            $kq_like_db = Lottery::where('province_id', $province_id)->where('status', 1)->where('gdb', 'like', '%' . $lotoDB)->where('gdb', '!=', $kq->gdb)->select('gdb', 'date')->orderBy('date', 'DESC')->get();
        }

        $arr_like_db = array();
        $arr_sau_db = array();
        $i = 0;
        foreach ($kq_like_db as $kq) {
            if ($short_name == 'mb') {
                $kq_sau = Lottery::where('mien', 1)->where('status', 1)->where('date', '>', $kq->date)->select('gdb', 'date')->orderBy('date')->first();
            } else {
                $kq_sau = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '>', $kq->date)->select('gdb', 'date')->orderBy('date')->first();
            }

            $arr_like_db[$i][0] = $kq->gdb;
            $arr_like_db[$i][1] = $kq->date;

            $arr_sau_db[$i][0] = $kq_sau->gdb;
            $arr_sau_db[$i][1] = $kq_sau->date;
            $i++;

        }

        // thống kê số lần xuất hiện của các ngày sau
        foreach ($arr_sau_db as $item) {
            $arr_kq_sau_db[] = substr($item[0], strlen($item[0]) - 2);
        }

        $vals_kq_sau_db = array_count_values($arr_kq_sau_db);
        $j = 0;
        $ArrayCollect_kq_sau_db = array();
        foreach ($vals_kq_sau_db as $key => $item) {
            $ArrayCollect_kq_sau_db[$j][0] = $key;
            $ArrayCollect_kq_sau_db[$j][1] = $item;
            $j++;
        }
        $len_kq_sau_db = count($ArrayCollect_kq_sau_db);
        for ($e = 0; $e < $len_kq_sau_db - 1; $e++) {
            for ($f = $e + 1; $f < $len_kq_sau_db; $f++) {
                if ($ArrayCollect_kq_sau_db[$e][1] < $ArrayCollect_kq_sau_db[$f][1]) {
                    swap($ArrayCollect_kq_sau_db[$e][1], $ArrayCollect_kq_sau_db[$f][1]);
                    swap($ArrayCollect_kq_sau_db[$e][0], $ArrayCollect_kq_sau_db[$f][0]);
                }
            }
        }


        // thống kê chạm của các ngày hôm sau
        $cham_dau = array();
        $cham_duoi = array();
        $cham_tong = array();
        for ($k = 0; $k <= 9; $k++) {
            $cham_dau[$k][0] = $k;
            $cham_dau[$k][1] = 0;
            $cham_duoi[$k][0] = $k;
            $cham_duoi[$k][1] = 0;
            $cham_tong[$k][0] = $k;
            $cham_tong[$k][1] = 0;
        }
        foreach ($arr_kq_sau_db as $loto) {
            $cham_dau[substr($loto, 0, 1)][1] = $cham_dau[substr($loto, 0, 1)][1] + 1;
            $cham_duoi[substr($loto, 1, 1)][1] = $cham_duoi[substr($loto, 1, 1)][1] + 1;
            $cham_tong[Tong($loto)][1] = $cham_tong[Tong($loto)][1] + 1;
        }

        for ($e = 0; $e < count($cham_dau) - 1; $e++) {
            for ($f = $e + 1; $f < count($cham_dau); $f++) {
                if ($cham_dau[$e][1] < $cham_dau[$f][1]) {
                    swap($cham_dau[$e][1], $cham_dau[$f][1]);
                    swap($cham_dau[$e][0], $cham_dau[$f][0]);
                }
            }
        }

        for ($e = 0; $e < count($cham_duoi) - 1; $e++) {
            for ($f = $e + 1; $f < count($cham_duoi); $f++) {
                if ($cham_duoi[$e][1] < $cham_duoi[$f][1]) {
                    swap($cham_duoi[$e][1], $cham_duoi[$f][1]);
                    swap($cham_duoi[$e][0], $cham_duoi[$f][0]);
                }
            }
        }

        for ($e = 0; $e < count($cham_tong) - 1; $e++) {
            for ($f = $e + 1; $f < count($cham_tong); $f++) {
                if ($cham_tong[$e][1] < $cham_tong[$f][1]) {
                    swap($cham_tong[$e][1], $cham_tong[$f][1]);
                    swap($cham_tong[$e][0], $cham_tong[$f][0]);
                }
            }
        }

        // thống kê giải đặc biệt hàng năm cùng ngày
        $dateDB_new = date('Y-m-d', strtotime(getNgayLink($dateDB) . ' +1 days'));
        if ($short_name == 'mb') {
            $kq_db_cung_ngay = Lottery::where('mien', 1)->where('status', 1)->where('date', 'like', '%' . substr($dateDB_new, 5))->where('gdb', '!=', $giaiDB)->select('gdb', 'date')->orderBy('date', 'DESC')->get();
        } else {
            $kq_db_cung_ngay = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', 'like', '%' . substr($dateDB_new, 5))->where('gdb', '!=', $giaiDB)->select('gdb', 'date')->orderBy('date', 'DESC')->get();
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongke.tk-giai-db', compact('provinces', 'province_name', 'ArrayCollect', 'len_collect', 'short_name', 'lotoDB', 'dateDB', 'giaiDB', 'arr_like_db', 'arr_sau_db', 'ArrayCollect_kq_sau_db', 'cham_dau', 'cham_duoi', 'cham_tong', 'kq_db_cung_ngay', 'dateDB_new'));
    }
    public function getTKDacBiet_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $dateTKDacBiet = getNgaycheo($request->dateTKDacBiet);

        if ($short_name == 'mb') {
            $kq = Lottery::where('mien', 1)->where('status', 1)->where('date', $dateTKDacBiet)->orderBy('date', 'DESC')->first();
            $province_name = 'Miền Bắc';
            $province_id = 46;

        } else {
            $province = Province::where('short_name', $short_name)->first();
            $province_id = $province->id;
            $province_name = $province->name;
            $kq = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', $dateTKDacBiet)->orderBy('date', 'DESC')->first();
        }

        //  thống kê trong ngày
        $ArrayCollect = array();
        $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
        $arr_kq = getLoto($tmp_result1);
        $vals = array_count_values($arr_kq);

        $j = 0;
        foreach ($vals as $key => $item) {
            $ArrayCollect[$j][0] = $key;
            $ArrayCollect[$j][1] = $item;
            $j++;
        }
        $len_collect = count($ArrayCollect);
        for ($e = 0; $e < $len_collect - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect; $f++) {
                if ($ArrayCollect[$e][1] < $ArrayCollect[$f][1]) {
                    swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                    swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                }
            }
        }


        // lấy ra các ngày có ngày hôm trước có giải đb trùng giải đb của ngày chọn
        $lotoDB = substr($kq->gdb, strlen($kq->gdb) - 2);
        $dateDB = $kq->date;
        $giaiDB = $kq->gdb;

        if ($short_name == 'mb') {
            $kq_like_db = Lottery::where('mien', 1)->where('status', 1)->where('gdb', 'like', '%' . $lotoDB)->where('gdb', '!=', $kq->gdb)->select('gdb', 'date')->orderBy('date', 'DESC')->get();
        } else {
            $kq_like_db = Lottery::where('province_id', $province_id)->where('status', 1)->where('gdb', 'like', '%' . $lotoDB)->where('gdb', '!=', $kq->gdb)->select('gdb', 'date')->orderBy('date', 'DESC')->get();
        }

        $arr_like_db = array();
        $arr_sau_db = array();
        $i = 0;
        foreach ($kq_like_db as $kq) {
            if ($short_name == 'mb') {
                $kq_sau = Lottery::where('mien', 1)->where('status', 1)->where('date', '>', $kq->date)->select('gdb', 'date')->orderBy('date')->first();
            } else {
                $kq_sau = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '>', $kq->date)->select('gdb', 'date')->orderBy('date')->first();
            }

            $arr_like_db[$i][0] = $kq->gdb;
            $arr_like_db[$i][1] = $kq->date;

            $arr_sau_db[$i][0] = $kq_sau->gdb;
            $arr_sau_db[$i][1] = $kq_sau->date;
            $i++;

        }

        // thống kê số lần xuất hiện của các ngày sau
        foreach ($arr_sau_db as $item) {
            $arr_kq_sau_db[] = substr($item[0], strlen($item[0]) - 2);
        }

        $vals_kq_sau_db = array_count_values($arr_kq_sau_db);
        $j = 0;
        $ArrayCollect_kq_sau_db = array();
        foreach ($vals_kq_sau_db as $key => $item) {
            $ArrayCollect_kq_sau_db[$j][0] = $key;
            $ArrayCollect_kq_sau_db[$j][1] = $item;
            $j++;
        }
        $len_kq_sau_db = count($ArrayCollect_kq_sau_db);
        for ($e = 0; $e < $len_kq_sau_db - 1; $e++) {
            for ($f = $e + 1; $f < $len_kq_sau_db; $f++) {
                if ($ArrayCollect_kq_sau_db[$e][1] < $ArrayCollect_kq_sau_db[$f][1]) {
                    swap($ArrayCollect_kq_sau_db[$e][1], $ArrayCollect_kq_sau_db[$f][1]);
                    swap($ArrayCollect_kq_sau_db[$e][0], $ArrayCollect_kq_sau_db[$f][0]);
                }
            }
        }


        // thống kê chạm của các ngày hôm sau
        $cham_dau = array();
        $cham_duoi = array();
        $cham_tong = array();
        for ($k = 0; $k <= 9; $k++) {
            $cham_dau[$k][0] = $k;
            $cham_dau[$k][1] = 0;
            $cham_duoi[$k][0] = $k;
            $cham_duoi[$k][1] = 0;
            $cham_tong[$k][0] = $k;
            $cham_tong[$k][1] = 0;
        }
        foreach ($arr_kq_sau_db as $loto) {
            $cham_dau[substr($loto, 0, 1)][1] = $cham_dau[substr($loto, 0, 1)][1] + 1;
            $cham_duoi[substr($loto, 1, 1)][1] = $cham_duoi[substr($loto, 1, 1)][1] + 1;
            $cham_tong[Tong($loto)][1] = $cham_tong[Tong($loto)][1] + 1;
        }

        for ($e = 0; $e < count($cham_dau) - 1; $e++) {
            for ($f = $e + 1; $f < count($cham_dau); $f++) {
                if ($cham_dau[$e][1] < $cham_dau[$f][1]) {
                    swap($cham_dau[$e][1], $cham_dau[$f][1]);
                    swap($cham_dau[$e][0], $cham_dau[$f][0]);
                }
            }
        }

        for ($e = 0; $e < count($cham_duoi) - 1; $e++) {
            for ($f = $e + 1; $f < count($cham_duoi); $f++) {
                if ($cham_duoi[$e][1] < $cham_duoi[$f][1]) {
                    swap($cham_duoi[$e][1], $cham_duoi[$f][1]);
                    swap($cham_duoi[$e][0], $cham_duoi[$f][0]);
                }
            }
        }

        for ($e = 0; $e < count($cham_tong) - 1; $e++) {
            for ($f = $e + 1; $f < count($cham_tong); $f++) {
                if ($cham_tong[$e][1] < $cham_tong[$f][1]) {
                    swap($cham_tong[$e][1], $cham_tong[$f][1]);
                    swap($cham_tong[$e][0], $cham_tong[$f][0]);
                }
            }
        }

        // thống kê giải đặc biệt hàng năm cùng ngày
        $dateDB_new = date('Y-m-d', strtotime(getNgayLink($dateDB) . ' +1 days'));
        if ($short_name == 'mb') {
            $kq_db_cung_ngay = Lottery::where('mien', 1)->where('status', 1)->where('date', 'like', '%' . substr($dateDB_new, 5))->where('gdb', '!=', $giaiDB)->select('gdb', 'date')->orderBy('date', 'DESC')->get();
        } else {
            $kq_db_cung_ngay = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', 'like', '%' . substr($dateDB_new, 5))->where('gdb', '!=', $giaiDB)->select('gdb', 'date')->orderBy('date', 'DESC')->get();
        }

        // dự đoán
        if (Cache::has('dudoanDB' . $short_name)) {
            $dudoanDB = Cache::get('dudoanDB' . $short_name);
        } else {
            $dudoanDB = array();
            $dudoanDB[] = getNumberRand();
            $dudoanDB[] = getNumberRand();
            $dudoanDB[] = getNumberRand();
            $dudoanDB[] = getNumberRand();
            $dudoanDB[] = getNumberRand();
            $dudoanDB[] = getNumberRand();
            $dudoanDB[] = getNumberRand();
            $dudoanDB[] = getNumberRand();
            Cache::put('dudoanDB' . $short_name, $dudoanDB, 60);
        }

        $view = '';
        $view .= $this->__buildTeamPlateTKDacBiet($dudoanDB, $province_name, $ArrayCollect, $len_collect, $short_name, $lotoDB, $dateDB, $giaiDB, $arr_like_db, $arr_sau_db, $ArrayCollect_kq_sau_db, $cham_dau, $cham_duoi, $cham_tong, $kq_db_cung_ngay, $dateDB_new);
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }
    private function __buildTeamPlateTKDacBiet($dudoanDB, $province_name, $ArrayCollect, $len_collect, $short_name, $lotoDB, $dateDB, $giaiDB, $arr_like_db, $arr_sau_db, $ArrayCollect_kq_sau_db, $cham_dau, $cham_duoi, $cham_tong, $kq_db_cung_ngay, $dateDB_new)
    {
        return view('frontend.thongke.tk-dac-biet-ajax', compact('dudoanDB', 'province_name', 'ArrayCollect', 'len_collect', 'short_name', 'lotoDB', 'dateDB', 'giaiDB', 'arr_like_db', 'arr_sau_db', 'ArrayCollect_kq_sau_db', 'cham_dau', 'cham_duoi', 'cham_tong', 'kq_db_cung_ngay', 'dateDB_new'));
    }

    public function getTKGiaiNhatTuan()
    {
        $date_end_dbtuan = date('Y-m-d');
        $date_start_dbtuan = date('Y-m-d', strtotime('-30 days'));
        $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '>=', $date_start_dbtuan)->where('date', '<=', $date_end_dbtuan)->select('g1', 'date', 'day')->orderBy('date', 'ASC')->get();

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongke.giai-nhat-tuan', compact('kqs', 'date_start_dbtuan', 'date_end_dbtuan', 'provinces'));
    }

    public function getTKGiaiNhatTuan_Ajax(Request $request)
    {
        $province_id = $request->province_id;
        $date_start_dbtuan = getNgaycheo($request->startDateDBT);
        $date_end_dbtuan = getNgaycheo($request->endDateDBT);

        $province_name = '';
        if ($province_id == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '>=', $date_start_dbtuan)->where('date', '<=', $date_end_dbtuan)->select('g1', 'date', 'day')->orderBy('date', 'ASC')->get();
        } else {
            $province = Province::find($province_id);
            $kqs = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '>=', $date_start_dbtuan)->where('date', '<=', $date_end_dbtuan)->select('g1', 'date', 'day')->orderBy('date', 'ASC')->get();
            $province_name = $province->name;
        }

        $dataReturn = ["template" => view('frontend.thongke.giai-nhat-tuan-ajax', compact('kqs', 'province_name'))->render()];
        return json_encode($dataReturn);
    }

    public function getTKDacBietTuan()
    {
        $date_end_dbtuan = date('Y-m-d');
        $date_start_dbtuan = date('Y-m-d', strtotime('-30 days'));
        $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '>=', $date_start_dbtuan)->where('date', '<=', $date_end_dbtuan)->select('gdb', 'date', 'day')->orderBy('date', 'ASC')->get();

        // tạo bảng dọc
        $day_start = getThuNumber($date_start_dbtuan);
        if($day_start==2) $date_start_t2 = $date_start_dbtuan;
        else $date_start_t2 = date('Y-m-d', strtotime(getNgayLink($date_start_dbtuan) . ' -'.($day_start-2).' days'));
        $first_date = strtotime($date_start_t2.' -1 days');

        $day_end = getThuNumber($date_end_dbtuan);
        if($day_end==8) $date_start_cn = $date_start_dbtuan;
        else $date_start_cn = date('Y-m-d', strtotime(getNgayLink($date_end_dbtuan) . ' +'.(8-$day_end).' days'));


        $tong_tuan = ceil(floor((abs(strtotime($date_start_cn) - strtotime($date_start_t2.' -1 days'))) /(60*60*24))/7) ;

        $kq_arr = array();
        foreach($kqs as $kq){
            $second_date = strtotime($kq->date);
            $datediff = abs($second_date - $first_date);
            $so_ngay = floor($datediff / (60*60*24));
            $tuan = ceil($so_ngay/7);
            $kq_arr[$kq->day][$tuan] = $kq;
        }
        // end tạo bảng dọc
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongke.dac-biet-tuan', compact('kqs', 'date_start_dbtuan', 'date_end_dbtuan', 'provinces', 'tong_tuan', 'kq_arr'));
    }

    public function getTKDacBietTuan_Ajax(Request $request)
    {
        $province_id = $request->province_id;
        $date_start_dbtuan = getNgaycheo($request->startDateDBT);
        $date_end_dbtuan = getNgaycheo($request->endDateDBT);

        $province_name = '';
        if ($province_id == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '>=', $date_start_dbtuan)->where('date', '<=', $date_end_dbtuan)->select('gdb', 'date', 'day')->orderBy('date', 'ASC')->get();
        } else {
            $province = Province::find($province_id);
            $kqs = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '>=', $date_start_dbtuan)->where('date', '<=', $date_end_dbtuan)->select('gdb', 'date', 'day')->orderBy('date', 'ASC')->get();
            $province_name = $province->name;
        }


        // tạo bảng dọc
        $day_start = getThuNumber($date_start_dbtuan);
        if($day_start==2) $date_start_t2 = $date_start_dbtuan;
        else $date_start_t2 = date('Y-m-d', strtotime(getNgayLink($date_start_dbtuan) . ' -'.($day_start-2).' days'));
        $first_date = strtotime($date_start_t2.' -1 days');

        $day_end = getThuNumber($date_end_dbtuan);
        if($day_end==8) $date_start_cn = $date_start_dbtuan;
        else $date_start_cn = date('Y-m-d', strtotime(getNgayLink($date_end_dbtuan) . ' +'.(8-$day_end).' days'));


        $tong_tuan = ceil(floor((abs(strtotime($date_start_cn) - strtotime($date_start_t2.' -1 days'))) /(60*60*24))/7) ;

        $kq_arr = array();
        foreach($kqs as $kq){
            $second_date = strtotime($kq->date);
            $datediff = abs($second_date - $first_date);
            $so_ngay = floor($datediff / (60*60*24));
            $tuan = ceil($so_ngay/7);
            $kq_arr[$kq->day][$tuan] = $kq;
        }
        // end tạo bảng dọc

        $dataReturn = ["template" => view('frontend.thongke.dac-biet-tuan-ajax', compact('kqs', 'province_name', 'tong_tuan', 'kq_arr'))->render()];
        return json_encode($dataReturn);
    }

    public function getTKDacBietThang()
    {
        $year_now = intval(date('Y'));
        $month_now = intval(date('m'));
        if ($month_now < 10) $month_now = '0' . $month_now; else $month_now = $month_now;
        $year_list = array();
        for ($i = $year_now; $i >= 2002; $i--) {
            $year_list[] = $i;
        }
        // tìm chạm
        $cham = array();
        for ($k = 0; $k <= 9; $k++) {
            $cham['dau'][$k] = 0;
            $cham['duoi'][$k] = 0;
            $cham['tong'][$k] = 0;
        }
        $arrkq = array();
        foreach ($year_list as $year) {
            $date_like_where = $year . '-' . $month_now . '-';
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', 'like', $date_like_where . '%')->select('gdb', 'date', 'day')->orderBy('date', 'DESC')->get();

            foreach ($kqs as $kq) {
                $date = explode('-', $kq->date);
                $y = $date[0];
                $d = $date[2];
                $arrkq[$y][$d] = $kq;

                $loto = substr($kq->gdb, strlen($kq->gdb) - 2);
                $cham['dau'][substr($loto, 0, 1)] = $cham['dau'][substr($loto, 0, 1)] + 1;
                $cham['duoi'][substr($loto, 1, 1)] = $cham['duoi'][substr($loto, 1, 1)] + 1;
                $cham['tong'][Tong($loto)] = $cham['tong'][Tong($loto)] + 1;
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongke.dac-biet-thang', compact('provinces', 'year_list', 'year_now', 'month_now', 'arrkq', 'cham'));
    }

    public function getTKDacBietThang_Ajax(Request $request)
    {
        $year = $request->nam;
        $month = $request->thang;
        $province_id = $request->province_id;
        // tìm chạm
        $cham = array();
        for ($k = 0; $k <= 9; $k++) {
            $cham['dau'][$k] = 0;
            $cham['duoi'][$k] = 0;
            $cham['tong'][$k] = 0;
        }

        $year_now = intval(date('Y'));
        $year_list = array();
        for ($i = $year_now; $i >= $year; $i--) {
            $year_list[] = $i;
        }

        $arrkq = array();
        if ($province_id == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', 'like', '%-' . $month . '-%')->where('date', '>=', $year . '-01-01')->select('gdb', 'date', 'day')->orderBy('date', 'DESC')->get();
            $province_name = 'miền Bắc';
        } else {
            $province = Province::find($province_id);
            $kqs = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', 'like', '%-' . $month . '-%')->where('date', '>=', $year . '-01-01')->select('gdb', 'date', 'day')->orderBy('date', 'DESC')->get();
            $province_name = $province->name;
        }

        foreach ($kqs as $kq) {
            $date = explode('-', $kq->date);
            $n = $date[0];
            $d = $date[2];
            $arrkq[$n][$d] = $kq;

            $loto = substr($kq->gdb, strlen($kq->gdb) - 2);
            $cham['dau'][substr($loto, 0, 1)] = $cham['dau'][substr($loto, 0, 1)] + 1;
            $cham['duoi'][substr($loto, 1, 1)] = $cham['duoi'][substr($loto, 1, 1)] + 1;
            $cham['tong'][Tong($loto)] = $cham['tong'][Tong($loto)] + 1;
        }

        $view = view('frontend.thongke.dac-biet-thang-ajax', compact('year_list', 'month', 'year', 'province_name', 'arrkq', 'cham'))->render();
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    public function getTKDacBietNam(Request $request)
    {
        $year_now = intval(date('Y'));
        $year = $year_now;
        $year_list = array();
        for ($i = $year_now; $i >= 2002; $i--) {
            $year_list[] = $i;
        }
        // tìm chạm
        $cham = array();
        for ($k = 0; $k <= 9; $k++) {
            $cham['dau'][$k] = 0;
            $cham['duoi'][$k] = 0;
            $cham['tong'][$k] = 0;
        }
        // lấy kết quả năm nay
        $arrkq = array();
        $kqs_year = Lottery::where('mien', 1)->where('status', 1)->where('date', 'like', $year . '%')->select('gdb', 'date', 'day')->orderBy('date', 'DESC')->get();
        foreach ($kqs_year as $kq) {
            $date = explode('-', $kq->date);
            $m = $date[1];
            $d = $date[2];
            $arrkq[$m][$d] = $kq;

            $loto = substr($kq->gdb, strlen($kq->gdb) - 2);

            if (!isset($cham['dau'][substr($loto, 0, 1)])) {
                $cham['dau'][substr($loto, 0, 1)] = 0;
            }
            $cham['dau'][substr($loto, 0, 1)] += 1;

            if (!isset($cham['duoi'][substr($loto, 1, 1)])) {
                $cham['duoi'][substr($loto, 1, 1)] = 0;
            }
            $cham['duoi'][substr($loto, 1, 1)] += 1;

            $tongKey = Tong($loto);
            if (!isset($cham['tong'][$tongKey])) {
                $cham['tong'][$tongKey] = 0;
            }
            $cham['tong'][$tongKey] += 1;
        }
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongke.dac-biet-nam', compact('provinces', 'year_list', 'year', 'arrkq', 'cham'));
    }

    public function getTKDacBietNam_Ajax(Request $request)
    {
        $province_id = $request->province_id;
        $year = $request->nam;
        // tìm chạm
        $cham = array();
        for ($k = 0; $k <= 9; $k++) {
            $cham['dau'][$k] = 0;
            $cham['duoi'][$k] = 0;
            $cham['tong'][$k] = 0;
        }
        // lấy kết quả năm nay
        $province_name = '';
        if ($province_id == 'mb') {
            $kqs_year = Lottery::where('mien', 1)->where('status', 1)->where('date', 'like', $year . '%')->select('gdb', 'date', 'day')->orderBy('date', 'DESC')->get();
        } else {
            $province = Province::find($province_id);
            $kqs_year = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', 'like', $year . '%')->select('gdb', 'date', 'day')->orderBy('date', 'DESC')->get();
            $province_name = $province->name;
        }

        $arrkq = array();
        foreach ($kqs_year as $kq) {
            $date = explode('-', $kq->date);
            $m = $date[1];
            $d = $date[2];
            $arrkq[$m][$d] = $kq;

            $loto = substr($kq->gdb, strlen($kq->gdb) - 2);
            $cham['dau'][substr($loto, 0, 1)] = $cham['dau'][substr($loto, 0, 1)] + 1;
            $cham['duoi'][substr($loto, 1, 1)] = $cham['duoi'][substr($loto, 1, 1)] + 1;
            $cham['tong'][Tong($loto)] = $cham['tong'][Tong($loto)] + 1;
        }

        $view = view('frontend.thongke.dac-biet-nam-ajax', compact('province_name', 'year', 'arrkq', 'cham'))->render();
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    public function getTKLoRoi($short_name)
    {
        $tkXsmb = array();
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $tkXsmb = Post::where('category_id', 1)->orderBy('date', 'DESC')->take(5)->get();

            // tạo mảng bộ số
            $arr_vitri = ['ĐB', '1', '2_1', '2_2', '3_1', '3_2', '3_3', '3_4', '3_5', '3_6', '4_1', '4_2', '4_3', '4_4', '5_1', '5_2', '5_3', '5_4', '5_5', '5_6', '6_1', '6_2', '6_3', '7_1', '7_2', '7_3', '7_4'];

            $ArrayCollect_Roi = array();
            for ($i = 0; $i < 27; $i++) {
                $ArrayCollect_Roi[$i][0] = $arr_vitri[$i]; // vị trí
                $ArrayCollect_Roi[$i][1] = ''; // ngày về gần nhất
                $ArrayCollect_Roi[$i][2] = -1; // số ngày chưa về
            }

        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();


            // tạo mảng bộ số
            $arr_vitri = ['ĐB', '1', '2', '3_1', '3_2', '4_1', '4_2', '4_3', '4_4', '4_5', '4_6', '4_7', '5', '6_1', '6_2', '6_3', '7', '8'];

            $ArrayCollect_Roi = array();
            for ($i = 0; $i < 18; $i++) {
                $ArrayCollect_Roi[$i][0] = $arr_vitri[$i]; // vị trí
                $ArrayCollect_Roi[$i][1] = ''; // ngày về gần nhất
                $ArrayCollect_Roi[$i][2] = -1; // số ngày chưa về

            }
        }
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq[] = getLoto($tmp_result1);
            $arr_date[] = $kq->date;
        }

        $len_collect = count($ArrayCollect_Roi);
        $number_date = 0;

        for ($i = 0; $i <= count($arr_kq) - 2; $i++) {
            for ($t = 0; $t < $len_collect; $t++) {
                $arr_kq_roi = $arr_kq[$i + 1];
                $arr_kq_hom_sau = $arr_kq[$i];
                if (in_array($arr_kq_roi[$t], $arr_kq_hom_sau)) {
                    if ($ArrayCollect_Roi[$t][2] == -1) {
                        $ArrayCollect_Roi[$t][1] = getNgay($arr_date[$i]);
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect_Roi[$t][2] = $number_date;
                    }
                }
            }
            $number_date++;
        }


        print_ok($ArrayCollect_Roi);
        die();

//        $provinces = array();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

//        $province_id = 46; // hà nội
        $maxgan = array();
        $kqgan = Gan::where('province_id', $province_id)->where('type', 1)->orderBy('loto')->get();
        foreach ($kqgan as $item) {
            $maxgan[$item->loto] = $item->max;
        }

        $kqgan_top5_max = Gan::where('province_id', $province_id)->where('type', 1)->orderBy('max', 'DESC')->take(5)->get();
        $kqgan_top5_min = Gan::where('province_id', $province_id)->where('type', 1)->orderBy('max')->take(5)->get();


        $maxgan_cap = array();
        $kqgan_cap = Gan::where('province_id', $province_id)->where('type', 2)->get();
        foreach ($kqgan_cap as $item) {
            $maxgan_cap[$item->loto] = $item->max;
        }

        return view('frontend.thongke.tk-lo-gan', compact('ArrayCollect', 'ArrayCollect_cap', 'provinces', 'province_name', 'arrNumber', 'province_id', 'maxgan', 'maxgan_cap', 'kqgan_top5_max', 'kqgan_top5_min', 'short_name'));
    }

    public function getTKLoGan1($short_name)
    {
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
            $province = Province::find($province_id);
            // tạo mảng bộ số
            $arr_vitri = ['ĐB', '1', '2_1', '2_2', '3_1', '3_2', '3_3', '3_4', '3_5', '3_6', '4_1', '4_2', '4_3', '4_4', '5_1', '5_2', '5_3', '5_4', '5_5', '5_6', '6_1', '6_2', '6_3', '7_1', '7_2', '7_3', '7_4'];

            $ArrayCollect_Roi = array();
            for ($i = 0; $i < 27; $i++) {
                $ArrayCollect_Roi[$i][0] = $arr_vitri[$i]; // vị trí
                $ArrayCollect_Roi[$i][1] = ''; // ngày về gần nhất
                $ArrayCollect_Roi[$i][2] = -1; // số ngày chưa về
                $ArrayCollect_Roi[$i][3] = $i; // lô rơi hôm nay
            }
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();

            // tạo mảng bộ số
            $arr_vitri = ['ĐB', '1', '2', '3_1', '3_2', '4_1', '4_2', '4_3', '4_4', '4_5', '4_6', '4_7', '5', '6_1', '6_2', '6_3', '7', '8'];

            $ArrayCollect_Roi = array();
            for ($i = 0; $i < 18; $i++) {
                $ArrayCollect_Roi[$i][0] = $arr_vitri[$i]; // vị trí
                $ArrayCollect_Roi[$i][1] = ''; // ngày về gần nhất
                $ArrayCollect_Roi[$i][2] = -1; // số ngày chưa về
                $ArrayCollect_Roi[$i][3] = $i; // lô rơi hôm nay
            }
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

        }
        $len_collect = count($ArrayCollect);
        $number_date = 0;

        // tạo mảng bộ số cặp
        $i = 0;
        $ArrayCollect_cap = array();
        for ($t = 0; $t <= 8; $t++) {
            for ($h = $t + 1; $h <= 9; $h++) {
                $ArrayCollect_cap[$i][0] = $t . $h;
                $ArrayCollect_cap[$i][1] = ''; // ngày về gần nhất
                $ArrayCollect_cap[$i][2] = -1; // số ngày chưa về
                $i++;
            }
        }
        for ($t = 0; $t <= 4; $t++) {
            $ArrayCollect_cap[$i][0] = $t . $t;
            $ArrayCollect_cap[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect_cap[$i][2] = -1; // số ngày chưa về
            $i++;
        }
        $len_collect_cap = count($ArrayCollect_cap);

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
            for ($t = 0; $t < $len_collect_cap; $t++) {
                if (in_array($ArrayCollect_cap[$t][0], $arr_kq) || in_array(lon($ArrayCollect_cap[$t][0]), $arr_kq)) {
                    if ($ArrayCollect_cap[$t][2] == -1) {
                        $ArrayCollect_cap[$t][1] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect_cap[$t][2] = $number_date;
                    }
                }
            }
            $number_date++;
        }
        $logan_arr = $ArrayCollect;
        $logan_cap_arr = $ArrayCollect_cap;

        for ($e = 0; $e < $len_collect - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect; $f++) {
                if ($ArrayCollect[$e][2] < $ArrayCollect[$f][2]) {
                    swap($ArrayCollect[$e][2], $ArrayCollect[$f][2]);
                    swap($ArrayCollect[$e][0], $ArrayCollect[$f][0]);
                    swap($ArrayCollect[$e][1], $ArrayCollect[$f][1]);
                }
            }
        }


        for ($e = 0; $e < $len_collect_cap - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect_cap; $f++) {
                if ($ArrayCollect_cap[$e][2] < $ArrayCollect_cap[$f][2]) {
                    swap($ArrayCollect_cap[$e][2], $ArrayCollect_cap[$f][2]);
                    swap($ArrayCollect_cap[$e][0], $ArrayCollect_cap[$f][0]);
                    swap($ArrayCollect_cap[$e][1], $ArrayCollect_cap[$f][1]);
                }
            }
        }


        // lô Rơi
        $arr_kq = array();
        $arr_date = array();
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq[] = getLoto($tmp_result1);
            $arr_date[] = $kq->date;
        }

        $len_collect = count($ArrayCollect_Roi);
        $number_date = 0;

        for ($i = 0; $i <= count($arr_kq) - 2; $i++) {
            for ($t = 0; $t < $len_collect; $t++) {
                $arr_kq_roi = $arr_kq[$i + 1];
                $arr_kq_hom_sau = $arr_kq[$i];
                if (in_array($arr_kq_roi[$t], $arr_kq_hom_sau)) {
                    if ($ArrayCollect_Roi[$t][2] == -1) {
                        $ArrayCollect_Roi[$t][1] = getNgay($arr_date[$i]);
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect_Roi[$t][2] = $number_date;
                    }
                }
            }
            $number_date++;
        }
        for ($t = 0; $t < $len_collect; $t++) {
            $ArrayCollect_Roi[$t][3] = $arr_kq[0][$ArrayCollect_Roi[$t][3]];
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $maxgan = array();
        $kqgan = Gan::where('province_id', $province_id)->where('type', 1)->orderBy('max','DESC')->get();
        foreach ($kqgan as $item) {
            $maxgan[$item->loto] = $item->max;
        }

        $maxgan_cap = array();
        $kqgan_cap = Gan::where('province_id', $province_id)->where('type', 2)->orderBy('max','DESC')->get();
        foreach ($kqgan_cap as $item) {
            $maxgan_cap[$item->loto] = $item->max;
        }

        $maxroi = array();
        $kqroi = LoRoi::where('province_id', $province_id)->orderBy('max','DESC')->get();
        foreach ($kqroi as $item) {
            $maxroi[$item->loto] = $item->max;
        }


        return view('frontend.thongke.lo-gan', compact('ArrayCollect', 'ArrayCollect_cap', 'ArrayCollect_Roi', 'logan_arr', 'logan_cap_arr', 'kqgan', 'kqgan_cap', 'kqroi', 'provinces', 'province', 'province_name', 'province_id', 'province_slug', 'maxgan', 'maxgan_cap', 'maxroi', 'short_name'));
    }


    public function getTKLoGan_BangKQ(Request $request)
    {
        $short_name = $request->short_name;
        $date = getNgaycheo($request->date);

        if ($short_name == 'mb') {
            $xsmb = Lottery::where('mien', 1)->where('status', 1)->where('date', $date)->first();
            return view('frontend.thongke.kqxsmb', compact('xsmb'));
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;

            $xs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', $date)->first();
            if ($province->mien == 2) return view('frontend.thongke.kqxsmt', compact('xs'));
            else return view('frontend.thongke.kqxsmn', compact('xs'));
        }
    }

    public function getTKGiaiDacBiet1($short_name)
    {
        $dateDB_new = date('Y-m-d');
        $date_start_dbtuan = date('Y-m-d', strtotime('-30 days'));
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(600)->get();
            $dbtuan_kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '>=', $date_start_dbtuan)->select('gdb', 'date', 'day')->orderBy('date', 'ASC')->get();
            $kq_db_cung_ngay = Lottery::where('mien', 1)->where('status', 1)->where('date', 'like', '%' . substr($dateDB_new, 5))->select('gdb', 'date')->orderBy('date', 'DESC')->get();

            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take(600)->get();
            $dbtuan_kqs = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '>=', $date_start_dbtuan)->select('gdb', 'date', 'day')->orderBy('date', 'ASC')->get();
            $kq_db_cung_ngay = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', 'like', '%' . substr($dateDB_new, 5))->select('gdb', 'date')->orderBy('date', 'DESC')->get();
        }

        $Array_Dau = array();
        $Array_Duoi = array();
        $Array_Tong = array();
        $Array_Boso = array();
        for ($i = 0; $i < 10; $i++) {
            $Array_Dau[$i][0] = $i;
            $Array_Dau[$i][1] = -1; // số ngày chưa về
            $Array_Dau[$i][2] = ''; // ngày vê gần nhất

        }

        for ($i = 0; $i < 10; $i++) {
            $Array_Duoi[$i][0] = $i;
            $Array_Duoi[$i][1] = -1; // số ngày chưa về
            $Array_Duoi[$i][2] = ''; // ngày vê gần nhất

        }

        for ($i = 0; $i < 10; $i++) {
            $Array_Tong[$i][0] = $i;
            $Array_Tong[$i][1] = -1; // số ngày chưa về
            $Array_Tong[$i][2] = ''; // ngày vê gần nhất

        }

        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $Array_Boso[$i][0] = '0' . $i;
            } else {
                $Array_Boso[$i][0] = $i;
            }
            $Array_Boso[$i][1] = -1; // số ngày chưa về
            $Array_Boso[$i][2] = ''; // khoảng ngày

        }
        $len_dau = count($Array_Dau);
        $len_duoi = count($Array_Duoi);
        $len_tong = count($Array_Tong);
        $len_boso = count($Array_Boso);


        $number_date = 0;
        foreach ($kqs as $kq) {
            for ($t = 0; $t < $len_dau; $t++) {
                if ($Array_Dau[$t][0] == substr($kq->gdb, -2, 1)) {
                    if ($Array_Dau[$t][1] == -1) {
                        $Array_Dau[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Dau[$t][1] = $number_date;
                    }
                }
            }

            for ($t = 0; $t < $len_duoi; $t++) {
                if ($Array_Duoi[$t][0] == substr($kq->gdb, -1)) {
                    if ($Array_Duoi[$t][1] == -1) {
                        $Array_Duoi[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Duoi[$t][1] = $number_date;
                    }
                }
            }

            for ($t = 0; $t < $len_tong; $t++) {
                if ($Array_Tong[$t][0] == Tong(substr($kq->gdb, -2))) {
                    if ($Array_Tong[$t][1] == -1) {
                        $Array_Tong[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Tong[$t][1] = $number_date;
                    }
                }
            }


            for ($t = 0; $t < $len_boso; $t++) {
                if ($Array_Boso[$t][0] == substr($kq->gdb, -2)) {
                    if ($Array_Boso[$t][1] == -1) {
                        $Array_Boso[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Boso[$t][1] = $number_date;
                    }
                }
            }


            $number_date++;
        }

//        for ($e = 0; $e < $len_boso - 1; $e++) {
//            for ($f = $e + 1; $f < $len_boso; $f++) {
//                if ($Array_Boso[$e][2] < $Array_Boso[$f][2]) {
//                    swap($Array_Boso[$e][2], $Array_Boso[$f][2]);
//                    swap($Array_Boso[$e][0], $Array_Boso[$f][0]);
//                    swap($Array_Boso[$e][1], $Array_Boso[$f][1]);
//                }
//            }
//        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $maxgan_dau = array();
        $maxgan_duoi = array();
        $maxgan_tong = array();
        $maxgan_boso = array();

        $kqgan_dau = GanDB::where('province_id', $province_id)->where('type', 1)->orderBy('loto')->get();
        foreach ($kqgan_dau as $item) {
            $maxgan_dau[$item->loto] = $item->max;
        }

        $kqgan_duoi = GanDB::where('province_id', $province_id)->where('type', 2)->orderBy('loto')->get();
        foreach ($kqgan_duoi as $item) {
            $maxgan_duoi[$item->loto] = $item->max;
        }

        $kqgan_tong = GanDB::where('province_id', $province_id)->where('type', 3)->orderBy('loto')->get();
        foreach ($kqgan_tong as $item) {
            $maxgan_tong[$item->loto] = $item->max;
        }

        $kqgan_boso = GanDB::where('province_id', $province_id)->where('type', 4)->orderBy('loto')->get();
        foreach ($kqgan_boso as $item) {
            $maxgan_boso[$item->loto] = $item->max;
        }

        return view('frontend.thongke.thong-ke-giai-dac-biet', compact('provinces', 'province_name', 'province_id', 'province_slug', 'short_name', 'Array_Dau', 'Array_Duoi', 'Array_Tong', 'Array_Boso', 'maxgan_dau', 'maxgan_duoi', 'maxgan_tong', 'maxgan_boso', 'dbtuan_kqs', 'kq_db_cung_ngay'));
    }

    public function getTKGiaiDacBiet_Ajax(Request1 $request)
    {
        $short_name = $request->short_name;
        $count = $request->count;
        $dateEnd = getNgaycheo($request->dateEnd);

        $dateDB_new = date('Y-m-d');
        $date_start_dbtuan = date('Y-m-d', strtotime(getNgayLink($dateEnd) . ' -30 days'));

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take(600)->get();
            $dbtuan_kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->where('date', '>=', $date_start_dbtuan)->select('gdb', 'date', 'day')->orderBy('date', 'ASC')->get();
            $kq_db_cung_ngay = Lottery::where('mien', 1)->where('status', 1)->where('date', 'like', '%' . substr($dateDB_new, 5))->select('gdb', 'date')->orderBy('date', 'DESC')->get();

            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take(600)->get();
            $dbtuan_kqs = Lottery::where('province_id', $province->id)->where('status', 1)->where('date', '<=', $dateEnd)->where('date', '>=', $date_start_dbtuan)->select('gdb', 'date', 'day')->orderBy('date', 'ASC')->get();
            $kq_db_cung_ngay = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', 'like', '%' . substr($dateDB_new, 5))->select('gdb', 'date')->orderBy('date', 'DESC')->get();
        }

        $Array_Dau = array();
        $Array_Duoi = array();
        $Array_Tong = array();
        $Array_Boso = array();
        for ($i = 0; $i < 10; $i++) {
            $Array_Dau[$i][0] = $i;
            $Array_Dau[$i][1] = -1; // số ngày chưa về
            $Array_Dau[$i][2] = ''; // ngày vê gần nhất

        }

        for ($i = 0; $i < 10; $i++) {
            $Array_Duoi[$i][0] = $i;
            $Array_Duoi[$i][1] = -1; // số ngày chưa về
            $Array_Duoi[$i][2] = ''; // ngày vê gần nhất

        }

        for ($i = 0; $i < 10; $i++) {
            $Array_Tong[$i][0] = $i;
            $Array_Tong[$i][1] = -1; // số ngày chưa về
            $Array_Tong[$i][2] = ''; // ngày vê gần nhất

        }

        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $Array_Boso[$i][0] = '0' . $i;
            } else {
                $Array_Boso[$i][0] = $i;
            }
            $Array_Boso[$i][1] = -1; // số ngày chưa về
            $Array_Boso[$i][2] = ''; // khoảng ngày

        }
        $len_dau = count($Array_Dau);
        $len_duoi = count($Array_Duoi);
        $len_tong = count($Array_Tong);
        $len_boso = count($Array_Boso);


        $number_date = 0;
        foreach ($kqs as $kq) {
            for ($t = 0; $t < $len_dau; $t++) {
                if ($Array_Dau[$t][0] == substr($kq->gdb, -2, 1)) {
                    if ($Array_Dau[$t][1] == -1) {
                        $Array_Dau[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Dau[$t][1] = $number_date;
                    }
                }
            }

            for ($t = 0; $t < $len_duoi; $t++) {
                if ($Array_Duoi[$t][0] == substr($kq->gdb, -1)) {
                    if ($Array_Duoi[$t][1] == -1) {
                        $Array_Duoi[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Duoi[$t][1] = $number_date;
                    }
                }
            }

            for ($t = 0; $t < $len_tong; $t++) {
                if ($Array_Tong[$t][0] == Tong(substr($kq->gdb, -2))) {
                    if ($Array_Tong[$t][1] == -1) {
                        $Array_Tong[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Tong[$t][1] = $number_date;
                    }
                }
            }


            for ($t = 0; $t < $len_boso; $t++) {
                if ($Array_Boso[$t][0] == substr($kq->gdb, -2)) {
                    if ($Array_Boso[$t][1] == -1) {
                        $Array_Boso[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Boso[$t][1] = $number_date;
                    }
                }
            }


            $number_date++;
        }

//        for ($e = 0; $e < $len_boso - 1; $e++) {
//            for ($f = $e + 1; $f < $len_boso; $f++) {
//                if ($Array_Boso[$e][2] < $Array_Boso[$f][2]) {
//                    swap($Array_Boso[$e][2], $Array_Boso[$f][2]);
//                    swap($Array_Boso[$e][0], $Array_Boso[$f][0]);
//                    swap($Array_Boso[$e][1], $Array_Boso[$f][1]);
//                }
//            }
//        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $maxgan_dau = array();
        $maxgan_duoi = array();
        $maxgan_tong = array();
        $maxgan_boso = array();

        $kqgan_dau = GanDB::where('province_id', $province_id)->where('type', 1)->orderBy('loto')->get();
        foreach ($kqgan_dau as $item) {
            $maxgan_dau[$item->loto] = $item->max;
        }

        $kqgan_duoi = GanDB::where('province_id', $province_id)->where('type', 2)->orderBy('loto')->get();
        foreach ($kqgan_duoi as $item) {
            $maxgan_duoi[$item->loto] = $item->max;
        }

        $kqgan_tong = GanDB::where('province_id', $province_id)->where('type', 3)->orderBy('loto')->get();
        foreach ($kqgan_tong as $item) {
            $maxgan_tong[$item->loto] = $item->max;
        }

        $kqgan_boso = GanDB::where('province_id', $province_id)->where('type', 4)->orderBy('loto')->get();
        foreach ($kqgan_boso as $item) {
            $maxgan_boso[$item->loto] = $item->max;
        }

        $view = view('frontend.thongke.thong-ke-giai-dac-biet-ajax', compact('provinces', 'province_name', 'province_id', 'province_slug', 'short_name', 'Array_Dau', 'Array_Duoi', 'Array_Tong', 'Array_Boso', 'maxgan_dau', 'maxgan_duoi', 'maxgan_tong', 'maxgan_boso', 'dbtuan_kqs', 'kq_db_cung_ngay', 'count', 'dateEnd'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKChuKy($short_name)
    {
        $rollingNumber = 60;
//        if (!empty($request->rollingNumber))
//            $rollingNumber = $request->rollingNumber;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
        }

        $arrayCollect[][] = array();
        $arrayCollect[0][0] = "Bộ số";
        $arrayCollect[0][$rollingNumber + 1] = "Tổng số<br>lần về";
        for ($i = 0; $i < 100; $i++) {
            $tmp = '0' . $i;
            $arrayCollect[$i + 1][0] = substr($tmp, strlen($tmp) - 2, 2);
        }
        $soboso = 100;

        $arrayValue[][] = array();
        $ngang = 1;
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);

            $arrayValue[$ngang] = $arr_kq;
            $arrayCollect[0][$ngang] = getNgay($kq->date);
            $ngang++;
        }

        for ($i = 1; $i < $soboso + 1; $i++) {
            for ($j = 1; $j < $rollingNumber + 1; $j++) {
                // tính số lần xuất hiện
                $arrayCollect[$i][$j][0] = solan_xuathien_trongngay($arrayCollect[$i][0], $arrayValue[$j]);
                if (empty($arrayCollect[$i][$rollingNumber + 1])) {
                    $arrayCollect[$i][$rollingNumber + 1] = 0;
                }
                $arrayCollect[$i][$rollingNumber + 1] += $arrayCollect[$i][$j][0];


                // check xem có về đb ko
                if ($arrayCollect[$i][0] == $arrayValue[$j][0]) {
                    $arrayCollect[$i][$j][1] = 1;
                } else {
                    $arrayCollect[$i][$j][1] = 0;
                }
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongke.tan-suat-lo-to', compact('provinces', 'soboso', 'arrayCollect', 'province_name', 'province_slug', 'short_name', 'rollingNumber'));

    }

    public function getTKChuKyFull(Request $request)
    {
        $short_name = 'mb';
        $rollingNumber = 30;
        $dateEnd = date('Y-m-d');
        $boso = '00-99';
        $type = 0;

        if (isset($request->province)) $short_name = $request->province;
        if (isset($request->count)) $rollingNumber = $request->count;
        if (isset($request->to)) $dateEnd = getNgaycheo($request->to);
        if (isset($request->boso)) $boso = $request->boso;
        if (isset($request->type)) $type = $request->type;

        $dateEnd_curent = getNgay($dateEnd);
        $dateEnd_next = date('d/m/Y', strtotime(getNgayLink($dateEnd) . ' +1 days'));;
        $dateEnd_back = date('d/m/Y', strtotime(getNgayLink($dateEnd) . ' -1 days'));;


        $view = '';
        if (preg_match('/[^0-9-\s]/', $boso)) {
            $view = '<div class="row"><div class="col-md-12" style="text-align: center;padding: 50px 0px;color: red">Lỗi: Bộ số không đúng định dạng</div></div>';
        }
        if (strpos($boso, '-') === false) {
            $view = '<div class="row"><div class="col-md-12" style="text-align: center;padding: 50px 0px;color: red">Lỗi: Bộ số không đúng định dạng</div></div>';
        } else {
            $boso_arr = explode('-', $boso);
            if ($boso_arr[0] < 0 || ($boso_arr[1] < $boso_arr[0])) {
                $view = '<div class="row"><div class="col-md-12" style="text-align: center;padding: 50px 0px;color: red">Lỗi: Bộ số không đúng định dạng</div></div>';
            }
        }
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        if(!empty($view)){
            return  view('frontend.thongke.tan-suat-lo-to-full-new', compact('provinces','province_name', 'short_name', 'rollingNumber', 'dateEnd_curent', 'dateEnd_next', 'dateEnd_back', 'boso', 'type', 'view'));
        }

        $arrayCollect[][] = array();
        $arrayCollect[0][0] = "Bộ số";
        $arrayCollect[0][$rollingNumber + 1] = "Tổng số<br>lần về";

        $boso_arr = explode('-', $boso);
        if ($boso_arr[0] < 10) $boso_arr[0] = substr($boso_arr[0], -1);
        if ($boso_arr[1] < 10) $boso_arr[1] = substr($boso_arr[1], -1);
        if ($boso_arr[1] >= 100) $boso_arr[1] = 99;


        for ($i = $boso_arr[0]; $i <= $boso_arr[1]; $i++) {
            $tmp = '0' . $i;
            $arrayCollect[$i + 1][0] = substr($tmp, strlen($tmp) - 2, 2);
        }
        $soboso = ($boso_arr[1] - $boso_arr[0]) + 1;


        $arrayValue[][] = array();
        $ngang = 1;
        foreach ($kqs as $kq) {
            if ($type == 0) {
                $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            } else {
                $tmp_result1 = $kq->gdb;
            }
            $arr_kq = getLoto($tmp_result1);

            $arrayValue[$ngang] = $arr_kq;
            $arrayCollect[0][$ngang] = $kq->date;
            $ngang++;
        }

        for ($i = $boso_arr[0] + 1; $i <= $boso_arr[1] + 1; $i++) {
            for ($j = 1; $j < $rollingNumber + 1; $j++) {
                // tính số lần xuất hiện
                $arrayCollect[$i][$j][0] = solan_xuathien_trongngay($arrayCollect[$i][0], $arrayValue[$j]);
                if (empty($arrayCollect[$i][$rollingNumber + 1])) {
                    $arrayCollect[$i][$rollingNumber + 1] = 0;
                }
                $arrayCollect[$i][$rollingNumber + 1] += $arrayCollect[$i][$j][0];


                // check xem có về đb ko
                if ($arrayCollect[$i][0] == $arrayValue[$j][0]) {
                    $arrayCollect[$i][$j][1] = 1;
                } else {
                    $arrayCollect[$i][$j][1] = 0;
                }
            }
        }
        return  view('frontend.thongke.tan-suat-lo-to-full-new', compact('provinces', 'soboso', 'boso_arr', 'arrayCollect', 'province_name', 'short_name', 'rollingNumber', 'dateEnd_curent', 'dateEnd_next', 'dateEnd_back', 'boso', 'type'));
    }

    public function getTKChuKy_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $rollingNumber = $request->rollingNumber;
        $dateEnd = getNgaycheo($request->dateEnd);

//        $rollingNumber = 30;
//        if (!empty($request->rollingNumber))
//            $rollingNumber = $request->rollingNumber;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();
        }

        $arrayCollect[][] = array();
        $arrayCollect[0][0] = "Bộ số";
        $arrayCollect[0][$rollingNumber + 1] = "Tổng số<br>lần về";
        for ($i = 0; $i < 100; $i++) {
            $tmp = '0' . $i;
            $arrayCollect[$i + 1][0] = substr($tmp, strlen($tmp) - 2, 2);
        }
        $soboso = 100;

        $arrayValue[][] = array();
        $ngang = 1;
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);

            $arrayValue[$ngang] = $arr_kq;
            $arrayCollect[0][$ngang] = getNgay($kq->date);
            $ngang++;
        }

        for ($i = 1; $i < $soboso + 1; $i++) {
            for ($j = 1; $j < $rollingNumber + 1; $j++) {
                // tính số lần xuất hiện
                $arrayCollect[$i][$j][0] = solan_xuathien_trongngay($arrayCollect[$i][0], $arrayValue[$j]);
                if (empty($arrayCollect[$i][$rollingNumber + 1])) {
                    $arrayCollect[$i][$rollingNumber + 1] = 0;
                }
                $arrayCollect[$i][$rollingNumber + 1] += $arrayCollect[$i][$j][0];


                // check xem có về đb ko
                if ($arrayCollect[$i][0] == $arrayValue[$j][0]) {
                    $arrayCollect[$i][$j][1] = 1;
                } else {
                    $arrayCollect[$i][$j][1] = 0;
                }
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        $view = view('frontend.thongke.tan-suat-lo-to-ajax', compact('provinces', 'soboso', 'arrayCollect', 'province_name', 'short_name', 'rollingNumber'))->render();
        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKChuKy_Ajax_Full(Request $request)
    {
        $short_name = $request->short_name;
        $rollingNumber = $request->rollingNumber;
        if (!empty($request->dateEnd))
            $dateEnd = getNgaycheo($request->dateEnd);
        else
            if (empty($dateEnd)) $dateEnd = date('Y-m-d');
        $type = $request->type;
        $boso = $request->boso;

        if (preg_match('/[^0-9-\s]/', $boso)) {
            $view = '<div class="row"><div class="col-md-12" style="text-align: center;padding: 50px 0px;color: red">Lỗi: Bộ số không đúng định dạng</div></div>';
            $dataReturn = [
                "template" => $view
            ];
            return json_encode($dataReturn);
        }

        if (strpos($boso, '-') === false) {
            $view = '<div class="row"><div class="col-md-12" style="text-align: center;padding: 50px 0px;color: red">Lỗi: Bộ số không đúng định dạng</div></div>';
            $dataReturn = ["template" => $view];
            return json_encode($dataReturn);
        } else {
            $boso_arr = explode('-', $boso);
            if ($boso_arr[0] < 0 || $boso_arr[1] >= 100 || ($boso_arr[1] < $boso_arr[0])) {
                $view = '<div class="row"><div class="col-md-12" style="text-align: center;padding: 50px 0px;color: red">Lỗi: Bộ số không đúng định dạng</div></div>';
                $dataReturn = ["template" => $view];
                return json_encode($dataReturn);
            }
        }


//        $rollingNumber = 30;
//        if (!empty($request->rollingNumber))
//            $rollingNumber = $request->rollingNumber;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();
        }

        $arrayCollect[][] = array();
        $arrayCollect[0][0] = "Bộ số";
        $arrayCollect[0][$rollingNumber + 1] = "Tổng số<br>lần về";

        $boso_arr = explode('-', $boso);
        if ($boso_arr[0] < 10) $boso_arr[0] = substr($boso_arr[0], -1);
        if ($boso_arr[1] < 10) $boso_arr[1] = substr($boso_arr[1], -1);
        for ($i = $boso_arr[0]; $i <= $boso_arr[1]; $i++) {
            $tmp = '0' . $i;
            $arrayCollect[$i + 1][0] = substr($tmp, strlen($tmp) - 2, 2);
        }
        $soboso = ($boso_arr[1] - $boso_arr[0]) + 1;


        $arrayValue[][] = array();
        $ngang = 1;
        foreach ($kqs as $kq) {
            if ($type == 1) {
                $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            } else {
                $tmp_result1 = $kq->gdb;
            }
            $arr_kq = getLoto($tmp_result1);

            $arrayValue[$ngang] = $arr_kq;
            $arrayCollect[0][$ngang] = ngay_thang_ts($kq->date);
            $ngang++;
        }

        for ($i = $boso_arr[0] + 1; $i <= $boso_arr[1] + 1; $i++) {
            for ($j = 1; $j < $rollingNumber + 1; $j++) {
                // tính số lần xuất hiện
                $arrayCollect[$i][$j][0] = solan_xuathien_trongngay($arrayCollect[$i][0], $arrayValue[$j]);
                if (empty($arrayCollect[$i][$rollingNumber + 1])) {
                    $arrayCollect[$i][$rollingNumber + 1] = 0;
                }
                $arrayCollect[$i][$rollingNumber + 1] += $arrayCollect[$i][$j][0];


                // check xem có về đb ko
                if ($arrayCollect[$i][0] == $arrayValue[$j][0]) {
                    $arrayCollect[$i][$j][1] = 1;
                } else {
                    $arrayCollect[$i][$j][1] = 0;
                }
            }
        }
//        print_ok($boso_arr);
//        print_ok($arrayCollect);die;

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        $view = view('frontend.thongke.tan-suat-lo-to-ajax-full', compact('provinces', 'soboso', 'boso_arr', 'arrayCollect', 'province_name', 'short_name', 'rollingNumber'))->render();
        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKChuKyDacBiet($short_name)
    {
        if ($short_name == 'mb') {
            $kq_today = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(100)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;

            $kq_today = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->first();
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take(100)->get();
        }

        $date_latest = getNgay($kq_today->date);

        $Array_Dau = array();
        $Array_Duoi = array();
        $Array_Tong = array();
        for ($i = 0; $i < 10; $i++) {
            $Array_Dau[$i][0] = $i;
            $Array_Dau[$i][1] = -1; // số ngày chưa về
            $Array_Dau[$i][2] = ''; // ngày vê gần nhất
            $Array_Dau[$i][3] = ''; // giải ĐB

        }

        for ($i = 0; $i < 10; $i++) {
            $Array_Duoi[$i][0] = $i;
            $Array_Duoi[$i][1] = -1; // số ngày chưa về
            $Array_Duoi[$i][2] = ''; // ngày vê gần nhất
            $Array_Duoi[$i][3] = ''; // giải ĐB

        }

        for ($i = 0; $i < 10; $i++) {
            $Array_Tong[$i][0] = $i;
            $Array_Tong[$i][1] = -1; // số ngày chưa về
            $Array_Tong[$i][2] = ''; // ngày vê gần nhất
            $Array_Tong[$i][3] = ''; // giải ĐB

        }
        $len_dau = count($Array_Dau);
        $len_duoi = count($Array_Duoi);
        $len_tong = count($Array_Tong);

        $number_date = 0;
        foreach ($kqs as $kq) {
            for ($t = 0; $t < $len_dau; $t++) {
                if ($Array_Dau[$t][0] == substr($kq->gdb, -2, 1)) {
                    if ($Array_Dau[$t][1] == -1) {
                        $Array_Dau[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Dau[$t][1] = $number_date;
                        $Array_Dau[$t][3] = $kq->gdb;
                    }
                }
            }

            for ($t = 0; $t < $len_duoi; $t++) {
                if ($Array_Duoi[$t][0] == substr($kq->gdb, -1)) {
                    if ($Array_Duoi[$t][1] == -1) {
                        $Array_Duoi[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Duoi[$t][1] = $number_date;
                        $Array_Duoi[$t][3] = $kq->gdb;
                    }
                }
            }

            for ($t = 0; $t < $len_tong; $t++) {
                if ($Array_Tong[$t][0] == Tong(substr($kq->gdb, -2))) {
                    if ($Array_Tong[$t][1] == -1) {
                        $Array_Tong[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Tong[$t][1] = $number_date;
                        $Array_Tong[$t][3] = $kq->gdb;
                    }
                }
            }
            $number_date++;
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $maxgan_dau = array();
        $maxgan_duoi = array();
        $maxgan_tong = array();

        $kqgan_dau = GanDB::where('province_id', $province_id)->where('type', 1)->orderBy('loto')->get();
        foreach ($kqgan_dau as $item) {
            $maxgan_dau[$item->loto] = $item->max;
        }

        $kqgan_duoi = GanDB::where('province_id', $province_id)->where('type', 2)->orderBy('loto')->get();
        foreach ($kqgan_duoi as $item) {
            $maxgan_duoi[$item->loto] = $item->max;
        }

        $kqgan_tong = GanDB::where('province_id', $province_id)->where('type', 3)->orderBy('loto')->get();
        foreach ($kqgan_tong as $item) {
            $maxgan_tong[$item->loto] = $item->max;
        }
        return abort(404);
        return view('frontend.thongke.chu-ky-dac-biet', compact('provinces', 'province_name', 'province_id', 'province_slug', 'short_name', 'Array_Dau', 'Array_Duoi', 'Array_Tong', 'maxgan_dau', 'maxgan_duoi', 'maxgan_tong', 'date_latest'));
    }

    public function getTKChuKyDacBiet_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $dateEnd = getNgaycheo($request->dateEnd);

        if ($short_name == 'mb') {
            $kq_today = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->first();
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take(100)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;

            $kq_today = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->first();
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take(100)->get();
        }

        $date_latest = getNgay($kq_today->date);

        $Array_Dau = array();
        $Array_Duoi = array();
        $Array_Tong = array();
        for ($i = 0; $i < 10; $i++) {
            $Array_Dau[$i][0] = $i;
            $Array_Dau[$i][1] = -1; // số ngày chưa về
            $Array_Dau[$i][2] = ''; // ngày vê gần nhất
            $Array_Dau[$i][3] = ''; // giải ĐB

        }

        for ($i = 0; $i < 10; $i++) {
            $Array_Duoi[$i][0] = $i;
            $Array_Duoi[$i][1] = -1; // số ngày chưa về
            $Array_Duoi[$i][2] = ''; // ngày vê gần nhất
            $Array_Duoi[$i][3] = ''; // giải ĐB

        }

        for ($i = 0; $i < 10; $i++) {
            $Array_Tong[$i][0] = $i;
            $Array_Tong[$i][1] = -1; // số ngày chưa về
            $Array_Tong[$i][2] = ''; // ngày vê gần nhất
            $Array_Tong[$i][3] = ''; // giải ĐB

        }
        $len_dau = count($Array_Dau);
        $len_duoi = count($Array_Duoi);
        $len_tong = count($Array_Tong);

        $number_date = 0;
        foreach ($kqs as $kq) {
            for ($t = 0; $t < $len_dau; $t++) {
                if ($Array_Dau[$t][0] == substr($kq->gdb, -2, 1)) {
                    if ($Array_Dau[$t][1] == -1) {
                        $Array_Dau[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Dau[$t][1] = $number_date;
                        $Array_Dau[$t][3] = $kq->gdb;
                    }
                }
            }

            for ($t = 0; $t < $len_duoi; $t++) {
                if ($Array_Duoi[$t][0] == substr($kq->gdb, -1)) {
                    if ($Array_Duoi[$t][1] == -1) {
                        $Array_Duoi[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Duoi[$t][1] = $number_date;
                        $Array_Duoi[$t][3] = $kq->gdb;
                    }
                }
            }

            for ($t = 0; $t < $len_tong; $t++) {
                if ($Array_Tong[$t][0] == Tong(substr($kq->gdb, -2))) {
                    if ($Array_Tong[$t][1] == -1) {
                        $Array_Tong[$t][2] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $Array_Tong[$t][1] = $number_date;
                        $Array_Tong[$t][3] = $kq->gdb;
                    }
                }
            }
            $number_date++;
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $maxgan_dau = array();
        $maxgan_duoi = array();
        $maxgan_tong = array();

        $kqgan_dau = GanDB::where('province_id', $province_id)->where('type', 1)->orderBy('loto')->get();
        foreach ($kqgan_dau as $item) {
            $maxgan_dau[$item->loto] = $item->max;
        }

        $kqgan_duoi = GanDB::where('province_id', $province_id)->where('type', 2)->orderBy('loto')->get();
        foreach ($kqgan_duoi as $item) {
            $maxgan_duoi[$item->loto] = $item->max;
        }

        $kqgan_tong = GanDB::where('province_id', $province_id)->where('type', 3)->orderBy('loto')->get();
        foreach ($kqgan_tong as $item) {
            $maxgan_tong[$item->loto] = $item->max;
        }

        $view = view('frontend.thongke.chu-ky-dac-biet-ajax', compact('provinces', 'province_name', 'province_id', 'province_slug', 'short_name', 'Array_Dau', 'Array_Duoi', 'Array_Tong', 'maxgan_dau', 'maxgan_duoi', 'maxgan_tong', 'date_latest'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);

    }

    public function getTKChuKyLoto($short_name)
    {
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
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

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        $kqgan = Gan::where('province_id', $province_id)->where('type', 1)->orderBy('loto')->get();
        
        return view('frontend.thongke.chu-ky-loto', compact('ArrayCollect', 'kqgan', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name'));
    }

    public function getTKChuKyLoto_Ajax(Request $request)
    {
        $short_name = $request->short_name;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take(30)->get();
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
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $kqgan = Gan::where('province_id', $province_id)->where('type', 1)->orderBy('loto')->get();

        $view = view('frontend.thongke.chu-ky-loto-ajax', compact('ArrayCollect', 'kqgan', 'provinces', 'province_name', 'province_id', 'province_slug', 'short_name'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKLoDauDuoi($short_name, Request $request)
    {
        $rollingNumber = 30;
//        if (!empty($request->rollingNumber))
//            $rollingNumber = $request->rollingNumber;

//        $loaiGiai = 1;
//        if (!empty($request->loaiGiai))
//            $loaiGiai = $request->loaiGiai;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';

        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
        }


        $ArrayCollect = array();
        $ArrayCollect_Dau_DB = array();
        $ArrayCollect_Duoi = array();
        $ArrayCollect_Duoi_DB = array();
        $ArrayCollect_Tong = array();
        for ($t = 0; $t < 10; $t++) {
            $ArrayCollect_Dau_DB[$t] = 0;
            $ArrayCollect_Duoi_DB[$t] = 0;
        }
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);

            for ($t = 0; $t < 10; $t++) {
                $ArrayCollect[$kq->date][$t] = 0;
                $ArrayCollect_Duoi[$kq->date][$t] = 0;
                $ArrayCollect_Tong[$kq->date][$t] = 0;
                foreach ($arr_kq as $loto) {
                    if ($t == substr($loto, 0, 1)) {
                        $ArrayCollect[$kq->date][$t] = $ArrayCollect[$kq->date][$t] + 1;
                    }
                    if ($t == substr($loto, 1, 1)) {
                        $ArrayCollect_Duoi[$kq->date][$t] = $ArrayCollect_Duoi[$kq->date][$t] + 1;
                    }

                    if ($t == Tong($loto)) {
                        $ArrayCollect_Tong[$kq->date][$t] = $ArrayCollect_Tong[$kq->date][$t] + 1;
                    }
                }
                if ($t == substr($kq->gdb, -2, 1)) {
                    $ArrayCollect_Dau_DB[$t] = $ArrayCollect_Dau_DB[$t] + 1;
                }
                if ($t == substr($kq->gdb, -1)) {
                    $ArrayCollect_Duoi_DB[$t] = $ArrayCollect_Duoi_DB[$t] + 1;
                }
            }
        }

        $tongDau = array();
        $tongDuoi = array();
        $tongTong = array();
        for ($i = 0; $i < 10; $i++) {
            $tongDau[$i] = 0;
            $tongDuoi[$i] = 0;
            $tongTong[$i] = 0;

        }
        foreach ($ArrayCollect as $value) {
            for ($i = 0; $i < 10; $i++) {
                $tongDau[$i] = $tongDau[$i] + $value[$i];
            }
        }
        foreach ($ArrayCollect_Duoi as $value) {
            for ($i = 0; $i < 10; $i++) {
                $tongDuoi[$i] = $tongDuoi[$i] + $value[$i];
            }
        }
        foreach ($ArrayCollect_Tong as $value) {
            for ($i = 0; $i < 10; $i++) {
                $tongTong[$i] = $tongTong[$i] + $value[$i];
            }
        }
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongke.dau-duoi-loto', compact('provinces', 'province_name', 'province_slug', 'ArrayCollect', 'tongDau', 'ArrayCollect_Duoi', 'tongDuoi', 'ArrayCollect_Tong', 'tongTong', 'short_name', 'ArrayCollect_Dau_DB', 'ArrayCollect_Duoi_DB', 'rollingNumber'));

    }

    public function getTKLoDauDuoi_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $rollingNumber = $request->count;
        $dateEnd = $request->dateEnd;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', getNgaycheo($dateEnd))->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';

        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', getNgaycheo($dateEnd))->orderBy('date', 'DESC')->take($rollingNumber)->get();
        }


        $ArrayCollect = array();
        $ArrayCollect_Dau_DB = array();
        $ArrayCollect_Duoi = array();
        $ArrayCollect_Duoi_DB = array();
        $ArrayCollect_Tong = array();
        for ($t = 0; $t < 10; $t++) {
            $ArrayCollect_Dau_DB[$t] = 0;
            $ArrayCollect_Duoi_DB[$t] = 0;
        }
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);

            for ($t = 0; $t < 10; $t++) {
                $ArrayCollect[$kq->date][$t] = 0;
                $ArrayCollect_Duoi[$kq->date][$t] = 0;
                $ArrayCollect_Tong[$kq->date][$t] = 0;
                foreach ($arr_kq as $loto) {
                    if ($t == substr($loto, 0, 1)) {
                        $ArrayCollect[$kq->date][$t] = $ArrayCollect[$kq->date][$t] + 1;
                    }
                    if ($t == substr($loto, 1, 1)) {
                        $ArrayCollect_Duoi[$kq->date][$t] = $ArrayCollect_Duoi[$kq->date][$t] + 1;
                    }

                    if ($t == Tong($loto)) {
                        $ArrayCollect_Tong[$kq->date][$t] = $ArrayCollect_Tong[$kq->date][$t] + 1;
                    }
                }
                if ($t == substr($kq->gdb, -2, 1)) {
                    $ArrayCollect_Dau_DB[$t] = $ArrayCollect_Dau_DB[$t] + 1;
                }
                if ($t == substr($kq->gdb, -1)) {
                    $ArrayCollect_Duoi_DB[$t] = $ArrayCollect_Duoi_DB[$t] + 1;
                }
            }
        }

        $tongDau = array();
        $tongDuoi = array();
        $tongTong = array();
        for ($i = 0; $i < 10; $i++) {
            $tongDau[$i] = 0;
            $tongDuoi[$i] = 0;
            $tongTong[$i] = 0;

        }
        foreach ($ArrayCollect as $value) {
            for ($i = 0; $i < 10; $i++) {
                $tongDau[$i] = $tongDau[$i] + $value[$i];
            }
        }
        foreach ($ArrayCollect_Duoi as $value) {
            for ($i = 0; $i < 10; $i++) {
                $tongDuoi[$i] = $tongDuoi[$i] + $value[$i];
            }
        }
        foreach ($ArrayCollect_Tong as $value) {
            for ($i = 0; $i < 10; $i++) {
                $tongTong[$i] = $tongTong[$i] + $value[$i];
            }
        }
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $view = view('frontend.thongke.dau-duoi-loto-ajax', compact('provinces', 'province_name', 'province_slug', 'ArrayCollect', 'tongDau', 'ArrayCollect_Duoi', 'tongDuoi', 'ArrayCollect_Tong', 'tongTong', 'short_name', 'rollingNumber', 'dateEnd', 'ArrayCollect_Dau_DB', 'ArrayCollect_Duoi_DB'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKChuKyDanLoTo($short_name)
    {
        if ($short_name == 'mb') {
            $province_name = 'Miền Bắc';
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_name = $province->name;
            $province_slug = $province->slug;
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return abort(404);
        return view('frontend.thongke.thong-ke-chu-ky-dan-loto', compact('provinces', 'province_name', 'province_slug', 'short_name'));
    }

    public function getTKChuKyDanLoTo_Ajax(Request $request)
    {
        $short_name = $request->short_name;

        $cungve = 0;
        if (!empty($request->cungve))
            $cungve = $request->cungve;

        $danLoto = $request->danLoto;
        $dateFrom = getNgaycheo($request->dateFrom);

        if (preg_match('/[^0-9,\s]/', $danLoto)) {
            $view = '<p class="red-text">Lỗi: dàn số không được chứa chữ và ký tự đặc biệt</p>';
            $dataReturn = [
                "template" => $view
            ];
            return json_encode($dataReturn);
        }


        $arrayMax = array();
        $arrayGan = array();


        $danLoto = preg_replace('/,/', ' ', $danLoto);
        $danLoto = preg_replace('/\s+/', ' ', $danLoto);
        $danLoto = explode(' ', $danLoto);
        $danLoto = array_unique($danLoto);
        foreach ($danLoto as $value) {
            if ($value < 10) $value = '0' . $value;
            $arrNumber[] = substr($value, -2);
        }
        $arrNumber = array_unique($arrNumber);

        $arrayMax[0] = $arrNumber;
        $arrayMax[1] = -1; // số ngày chưa về
        $arrayMax[2] = ''; // đến ngày
        $arrayMax[3] = ''; // từ ngày

        $arrayGan[0] = $arrNumber;
        $arrayGan[1] = -1; // số ngày chưa về
        $arrayGan[2] = ''; // khoảng ngày

        $date_end = date('Y-m-d');
        if ($short_name == 'mb') {
            $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '>=', $dateFrom)->where('date', '<=', $date_end)->orderBy('date', 'DESC')->get();
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '>=', $dateFrom)->orderBy('date', 'DESC')->get();

        }
        $tong_so_ngay = count($kqs);
        $number_date = 0;
        foreach ($kqs as $kq) {
            $tmp_result = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result);
            if ($cungve == 1) {
                if (count(array_intersect($arrNumber, $arr_kq)) == count($arrNumber)) {
                    if ($arrayMax[1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $arrayMax[1] = $number_date;
                        $arrayMax[2] = $kq->date;
                        $arrayMax[3] = $date_end;
                    }
                    if ($arrayGan[1] == -1) {
                        /*Tinh so ngay chua ve*/
                        $arrayGan[1] = $number_date;
                        $arrayGan[2] = $kq->date;
                    }

                    $date_end = $kq->date;
                    $number_date = 0;
                }
            } else {
                if (count(array_intersect($arrNumber, $arr_kq)) > 0) {
                    if ($arrayMax[1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $arrayMax[1] = $number_date;
                        $arrayMax[2] = $kq->date;
                        $arrayMax[3] = $date_end;
                    }
                    if ($arrayGan[1] == -1) {
                        /*Tinh so ngay chua ve*/
                        $arrayGan[1] = $number_date;
                        $arrayGan[2] = $kq->date;
                    }

                    $date_end = $kq->date;
                    $number_date = 0;
                }
            }
            $number_date++;
        }
        $view = view('frontend.thongke.thong-ke-chu-ky-dan-loto-ajax', compact('arrayMax', 'arrayGan', 'arrNumber', 'dateFrom', 'tong_so_ngay', 'short_name'))->render();
//        $view = view('frontend.thongke.dau-duoi-loto-ajax', compact('provinces', 'province_name', 'province_slug', 'ArrayCollect', 'tongDau', 'ArrayCollect_Duoi', 'tongDuoi', 'ArrayCollect_Tong', 'tongTong', 'short_name', 'rollingNumber', 'dateEnd'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }


    public function getTKChuKyDanDacBiet($short_name)
    {
        if ($short_name == 'mb') {
            $province_name = 'Miền Bắc';
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_name = $province->name;
            $province_slug = $province->slug;
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return abort(404);
        return view('frontend.thongke.thong-ke-chu-ky-dan-db', compact('provinces', 'province_name', 'province_slug', 'short_name'));
    }

    public function getTKChuKyDanDacBiet_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $danLoto = $request->danLoto;
        $dateFrom = getNgaycheo($request->dateFrom);

        if (preg_match('/[^0-9,\s]/', $danLoto)) {
            $view = '<p class="red-text">Lỗi: dàn số không được chứa chữ và ký tự đặc biệt</p>';
            $dataReturn = [
                "template" => $view
            ];
            return json_encode($dataReturn);
        }


        $arrayMax = array();
        $arrayGan = array();


        $danLoto = preg_replace('/,/', ' ', $danLoto);
        $danLoto = preg_replace('/\s+/', ' ', $danLoto);
        $danLoto = explode(' ', $danLoto);
        $danLoto = array_unique($danLoto);
        foreach ($danLoto as $value) {
            if ($value < 10) $value = '0' . $value;
            $arrNumber[] = substr($value, -2);
        }
        $arrNumber = array_unique($arrNumber);

        $arrayMax[0] = $arrNumber;
        $arrayMax[1] = -1; // số ngày chưa về
        $arrayMax[2] = ''; // đến ngày
        $arrayMax[3] = ''; // từ ngày
        $arrayMax[4] = ''; // giai DB ngày start
        $arrayMax[5] = ''; // giai DB ngày end

        $arrayGan[0] = $arrNumber;
        $arrayGan[1] = -1; // số ngày chưa về
        $arrayGan[2] = ''; // khoảng ngày
        $arrayGan[3] = ''; // giai DB

        $date_end = date('Y-m-d');
        if ($short_name == 'mb') {
            $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '>=', $dateFrom)->where('date', '<=', $date_end)->orderBy('date', 'DESC')->get();
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '>=', $dateFrom)->orderBy('date', 'DESC')->get();

        }
        $tong_so_ngay = count($kqs);
        $number_date = 0;
        $kqdb_end = '';
        foreach ($kqs as $kq) {
            $tmp_result = $kq->gdb;
            $arr_kq = getLoto($tmp_result);

            if (count(array_intersect($arrNumber, $arr_kq)) > 0) {
                if ($arrayMax[1] < $number_date) {
                    /*Tinh so ngay chua ve*/
                    $arrayMax[1] = $number_date;
                    $arrayMax[2] = $kq->date;
                    $arrayMax[3] = $date_end;
                    $arrayMax[4] = $kq->gdb;;
                    $arrayMax[5] = $kqdb_end;
                }
                if ($arrayGan[1] == -1) {
                    /*Tinh so ngay chua ve*/
                    $arrayGan[1] = $number_date;
                    $arrayGan[2] = $kq->date;
                    $arrayGan[3] = $kq->gdb;
                }

                $date_end = $kq->date;
                $kqdb_end = $kq->gdb;
                $number_date = 0;
            }
            $number_date++;
        }
        $view = view('frontend.thongke.thong-ke-chu-ky-dan-db-ajax', compact('arrayMax', 'arrayGan', 'arrNumber', 'dateFrom', 'tong_so_ngay', 'short_name'))->render();
//        $view = view('frontend.thongke.dau-duoi-loto-ajax', compact('provinces', 'province_name', 'province_slug', 'ArrayCollect', 'tongDau', 'ArrayCollect_Duoi', 'tongDuoi', 'ArrayCollect_Tong', 'tongTong', 'short_name', 'rollingNumber', 'dateEnd'))->render();

        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKTanSuatTheoCap($short_name)
    {
        $rollingNumber = 30;
//        if (!empty($request->rollingNumber))
//            $rollingNumber = $request->rollingNumber;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
        }

        $arrayCollect[][] = array();
        $arrayCollect[0][0] = "Bộ số";
        $arrayCollect[0][$rollingNumber + 1] = "Tổng số<br>lần về";

        $i = 1;
        for ($t = 0; $t <= 8; $t++) {
            if ($t <= 4) {
                $arrayCollect[$i][0] = $t . $t;
                $i++;
            }
            for ($h = $t + 1; $h <= 9; $h++) {
                $arrayCollect[$i][0] = $t . $h;
                $i++;
            }
        }

//        echo $arrayCollect[1][0];
//        print_ok($arrayCollect);die;
//        for ($i = 0; $i < 100; $i++) {
//            $tmp = '0' . $i;
//            $arrayCollect[$i + 1][0] = substr($tmp, strlen($tmp) - 2, 2);
//        }

        $soboso = 50;

        $arrayValue[][] = array();
        $ngang = 1;
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);

            $arrayValue[$ngang] = $arr_kq;
            $arrayCollect[0][$ngang] = ngay_thang_ts($kq->date);
            $ngang++;
        }

        for ($i = 1; $i < $soboso + 1; $i++) {
            for ($j = 1; $j < $rollingNumber + 1; $j++) {
                // tính số lần xuất hiện

                $arrayCollect[$i][$j][0] = solan_xuathien_trongngay($arrayCollect[$i][0], $arrayValue[$j]) + solan_xuathien_trongngay(lon($arrayCollect[$i][0]), $arrayValue[$j]);
                if (empty($arrayCollect[$i][$rollingNumber + 1])) {
                    $arrayCollect[$i][$rollingNumber + 1] = 0;
                }
                $arrayCollect[$i][$rollingNumber + 1] += $arrayCollect[$i][$j][0];


                // check xem có về đb ko
                if ($arrayCollect[$i][0] == $arrayValue[$j][0]) {
                    $arrayCollect[$i][$j][1] = 1;
                } else {
                    $arrayCollect[$i][$j][1] = 0;
                }
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return abort(404);
        return view('frontend.thongke.tan-suat-lo-to-theo-cap', compact('provinces', 'soboso', 'arrayCollect', 'province_name', 'province_slug', 'short_name', 'rollingNumber'));

    }

    public function getTKTanSuatTheoCap_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $rollingNumber = $request->rollingNumber;
        $dateEnd = getNgaycheo($request->dateEnd);

//        $rollingNumber = 30;
//        if (!empty($request->rollingNumber))
//            $rollingNumber = $request->rollingNumber;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();
        }

        $arrayCollect[][] = array();
        $arrayCollect[0][0] = "Bộ số";
        $arrayCollect[0][$rollingNumber + 1] = "Tổng số<br>lần về";

        $i = 1;
        for ($t = 0; $t <= 8; $t++) {
            if ($t <= 4) {
                $arrayCollect[$i][0] = $t . $t;
                $i++;
            }
            for ($h = $t + 1; $h <= 9; $h++) {
                $arrayCollect[$i][0] = $t . $h;
                $i++;
            }
        }

        $soboso = 50;

        $arrayValue[][] = array();
        $ngang = 1;
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);

            $arrayValue[$ngang] = $arr_kq;
            $arrayCollect[0][$ngang] = ngay_thang_ts($kq->date);
            $ngang++;
        }

        for ($i = 1; $i < $soboso + 1; $i++) {
            for ($j = 1; $j < $rollingNumber + 1; $j++) {
                // tính số lần xuất hiện
                $arrayCollect[$i][$j][0] = solan_xuathien_trongngay($arrayCollect[$i][0], $arrayValue[$j]) + solan_xuathien_trongngay(lon($arrayCollect[$i][0]), $arrayValue[$j]);
                if (empty($arrayCollect[$i][$rollingNumber + 1])) {
                    $arrayCollect[$i][$rollingNumber + 1] = 0;
                }
                $arrayCollect[$i][$rollingNumber + 1] += $arrayCollect[$i][$j][0];


                // check xem có về đb ko
                if ($arrayCollect[$i][0] == $arrayValue[$j][0]) {
                    $arrayCollect[$i][$j][1] = 1;
                } else {
                    $arrayCollect[$i][$j][1] = 0;
                }
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        $view = view('frontend.thongke.tan-suat-lo-to-theo-cap-ajax', compact('provinces', 'soboso', 'arrayCollect', 'province_name', 'short_name', 'rollingNumber'))->render();
        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }

    public function getTKTanSuatGiaiDB($short_name)
    {
        $rollingNumber = 30;
//        if (!empty($request->rollingNumber))
//            $rollingNumber = $request->rollingNumber;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
        }
        $arrayCollect = array();

//        $html  = str_get_html(requestvl('https://ketquade1.com/tan-suat-giai-dac-biet-tan-suat-dan-de.html'));
//        foreach($html->find('#normtable .tansuatrow') as $tr){
//            $key  = str_replace('tr_','',$tr->id);
//            $name = trim($tr->find('td.info b',0)->innertext);
//            echo '$arrayCollect["'.$key.'"]["name"] = "'.$name.'";<br/>';
//        }
//        die;

//        $cham = array();
//        $tr_00_toi_33 = '';
//        $tr_34_toi_66 = '';
//        $tr_67_toi_99 = '';
//        $tr_00_toi_24 = '';
//        $tr_25_toi_49 = '';
//        $tr_50_toi_74 = '';
//        $tr_75_toi_99 = '';
//        for ($i = 0; $i < 100; $i++) {
//            $tmp = '0' . $i;
//            $so = substr($tmp, strlen($tmp) - 2, 2);
//            if($i>=0 && $i<=33) $tr_00_toi_33 .= '"'.$so.'",';
//            if($i>=34 && $i<=66) $tr_34_toi_66 .= '"'.$so.'",';
//            if($i>=67 && $i<=99) $tr_67_toi_99 .= '"'.$so.'",';
//            if($i>=0 && $i<=24) $tr_00_toi_24 .= '"'.$so.'",';
//            if($i>=25 && $i<=49) $tr_25_toi_49 .= '"'.$so.'",';
//            if($i>=50 && $i<=74) $tr_50_toi_74 .= '"'.$so.'",';
//            if($i>=75 && $i<=99) $tr_75_toi_99 .= '"'.$so.'",';
//        }
//        echo '$arrayCollect["00_toi_33"][0] =['.substr($tr_00_toi_33,0,-1).'];<br/>';
//        echo '$arrayCollect["34_toi_66"][0] =['.substr($tr_34_toi_66,0,-1).'];<br/>';
//        echo '$arrayCollect["67_toi_99"][0] =['.substr($tr_67_toi_99,0,-1).'];<br/>';
//        echo '$arrayCollect["00_toi_24"][0] =['.substr($tr_00_toi_24,0,-1).'];<br/>';
//        echo '$arrayCollect["25_toi_49"][0] =['.substr($tr_25_toi_49,0,-1).'];<br/>';
//        echo '$arrayCollect["50_toi_74"][0] =['.substr($tr_50_toi_74,0,-1).'];<br/>';
//        echo '$arrayCollect["75_toi_99"][0] =['.substr($tr_75_toi_99,0,-1).'];<br/>';
//        die();
        $arrayCollect["5_Dau_nho"][0] = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49"];
        $arrayCollect["5_Dau_to"][0] = ["50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "80", "81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];
        $arrayCollect["Tong_chan"][0] = ["00", "02", "04", "06", "08", "11", "13", "15", "17", "19", "20", "22", "24", "26", "28", "31", "33", "35", "37", "39", "40", "42", "44", "46", "48", "51", "53", "55", "57", "59", "60", "62", "64", "66", "68", "71", "73", "75", "77", "79", "80", "82", "84", "86", "88", "91", "93", "95", "97", "99"];
        $arrayCollect["Tong_le"][0] = ["01", "03", "05", "07", "09", "10", "12", "14", "16", "18", "21", "23", "25", "27", "29", "30", "32", "34", "36", "38", "41", "43", "45", "47", "49", "50", "52", "54", "56", "58", "61", "63", "65", "67", "69", "70", "72", "74", "76", "78", "81", "83", "85", "87", "89", "90", "92", "94", "96", "98"];
        $arrayCollect["Chan_Le"][0] = ["01", "03", "05", "07", "09", "21", "23", "25", "27", "29", "41", "43", "45", "47", "49", "61", "63", "65", "67", "69", "81", "83", "85", "87", "89"];
        $arrayCollect["Le_Chan"][0] = ["10", "12", "14", "16", "18", "30", "32", "34", "36", "38", "50", "52", "54", "56", "58", "70", "72", "74", "76", "78", "90", "92", "94", "96", "98"];
        $arrayCollect["Chan_Chan"][0] = ["00", "02", "04", "06", "08", "20", "22", "24", "26", "28", "40", "42", "44", "46", "48", "60", "62", "64", "66", "68", "80", "82", "84", "86", "88"];
        $arrayCollect["Le_Le"][0] = ["11", "13", "15", "17", "19", "31", "33", "35", "37", "39", "51", "53", "55", "57", "59", "71", "73", "75", "77", "79", "91", "93", "95", "97", "99"];
        $arrayCollect["Chia_het_3"][0] = ["00", "03", "06", "09,12,15,18", "21", "24", "27", "30", "33", "36", "39", "42", "45", "48", "51", "54", "57", "60", "63", "66", "69", "72", "75", "78", "81", "84", "87", "90", "93", "96", "99"];
        $arrayCollect["Thap_Thap"][0] = ["00", "01", "02", "03", "04", "10", "11", "12", "13", "14", "20", "21", "22", "23", "24", "30", "31", "32", "33", "34. 40", "41", "42", "43", "44"];
        $arrayCollect["Cao_Cao"][0] = ["55", "56", "57", "58", "59", "65", "66", "67", "68", "69", "75", "76", "77", "78", "79", "85", "86", "87", "88", "89", "95", "96", "97", "98", "99"];
        $arrayCollect["Thap_Cao"][0] = ["05", "06", "07", "08", "09", "15", "16", "17", "18", "19", "25", "26", "27", "28", "29", "35", "36", "37", "38", "39", "45", "46", "47", "48", "49"];
        $arrayCollect["Cao_Thap"][0] = ["50", "51", "52", "53", "54", "60", "61", "62", "63", "64", "70", "71", "72", "73", "74", "80", "81", "82", "83", "84", "90", "91", "92", "93", "94"];
        $arrayCollect["Dau_0"][0] = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09"];
        $arrayCollect["Dau_1"][0] = ["10", "11", "12", "13", "14", "15", "16", "17", "18", "19"];
        $arrayCollect["Dau_2"][0] = ["20", "21", "22", "23", "24", "25", "26", "27", "28", "29"];
        $arrayCollect["Dau_3"][0] = ["30", "31", "32", "33", "34", "35", "36", "37", "38", "39"];
        $arrayCollect["Dau_4"][0] = ["40", "41", "42", "43", "44", "45", "46", "47", "48", "49"];
        $arrayCollect["Dau_5"][0] = ["50", "51", "52", "53", "54", "55", "56", "57", "58", "59"];
        $arrayCollect["Dau_6"][0] = ["60", "61", "62", "63", "64", "65", "66", "67", "68", "69"];
        $arrayCollect["Dau_7"][0] = ["70", "71", "72", "73", "74", "75", "76", "77", "78", "79"];
        $arrayCollect["Dau_8"][0] = ["80", "81", "82", "83", "84", "85", "86", "87", "88", "89"];
        $arrayCollect["Dau_9"][0] = ["90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];
        $arrayCollect["Duoi_0"][0] = ["00", "10", "20", "30", "40", "50", "60", "70", "80", "90"];
        $arrayCollect["Duoi_1"][0] = ["01", "11", "21", "31", "41", "51", "61", "71", "81", "91"];
        $arrayCollect["Duoi_2"][0] = ["02", "12", "22", "32", "42", "52", "62", "72", "82", "92"];
        $arrayCollect["Duoi_3"][0] = ["03", "13", "23", "33", "43", "53", "63", "73", "83", "93"];
        $arrayCollect["Duoi_4"][0] = ["04", "14", "24", "34", "44", "54", "64", "74", "84", "94"];
        $arrayCollect["Duoi_5"][0] = ["05", "15", "25", "35", "45", "55", "65", "75", "85", "95"];
        $arrayCollect["Duoi_6"][0] = ["06", "16", "26", "36", "46", "56", "66", "76", "86", "96"];
        $arrayCollect["Duoi_7"][0] = ["07", "17", "27", "37", "47", "57", "67", "77", "87", "97"];
        $arrayCollect["Duoi_8"][0] = ["08", "18", "28", "38", "48", "58", "68", "78", "88", "98"];
        $arrayCollect["Duoi_9"][0] = ["09", "19", "29", "39", "49", "59", "69", "79", "89", "99"];
        $arrayCollect["Cham_0"][0] = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "20", "30", "40", "50", "60", "70", "80", "90"];
        $arrayCollect["Cham_1"][0] = ["01", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "21", "31", "41", "51", "61", "71", "81", "91"];
        $arrayCollect["Cham_2"][0] = ["02", "12", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "32", "42", "52", "62", "72", "82", "92"];
        $arrayCollect["Cham_3"][0] = ["03", "13", "23", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "43", "53", "63", "73", "83", "93"];
        $arrayCollect["Cham_4"][0] = ["04", "14", "24", "34", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "54", "64", "74", "84", "94"];
        $arrayCollect["Cham_5"][0] = ["05", "15", "25", "35", "45", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "65", "75", "85", "95"];
        $arrayCollect["Cham_6"][0] = ["06", "16", "26", "36", "46", "56", "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "76", "86", "96"];
        $arrayCollect["Cham_7"][0] = ["07", "17", "27", "37", "47", "57", "67", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "87", "97"];
        $arrayCollect["Cham_8"][0] = ["08", "18", "28", "38", "48", "58", "68", "78", "80", "81", "82", "83", "84", "85", "86", "87", "88", "89", "98"];
        $arrayCollect["Cham_9"][0] = ["09", "19", "29", "39", "49", "59", "69", "79", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];
        $arrayCollect["Tong_0"][0] = ["00", "19", "28", "37", "46", "55", "64", "73", "82", "91"];
        $arrayCollect["Tong_1"][0] = ["01", "10", "29", "92", "38", "83", "47", "74", "56", "65"];
        $arrayCollect["Tong_2"][0] = ["02", "20", "39", "93", "48", "84", "57", "75", "11", "66"];
        $arrayCollect["Tong_3"][0] = ["03", "30", "12", "21", "49", "94", "58", "85", "67", "76"];
        $arrayCollect["Tong_4"][0] = ["04", "40", "13", "31", "59", "95", "68", "86", "22", "77"];
        $arrayCollect["Tong_5"][0] = ["05", "50", "14", "41", "23", "32", "69", "96", "78", "87"];
        $arrayCollect["Tong_6"][0] = ["06", "60", "15", "51", "24", "42", "79", "97", "33", "88"];
        $arrayCollect["Tong_7"][0] = ["07", "70", "16", "61", "25", "52", "34", "43", "89", "98"];
        $arrayCollect["Tong_8"][0] = ["08", "80", "17", "71", "26", "62", "35", "53", "44", "99"];
        $arrayCollect["Tong_9"][0] = ["09", "90", "18", "81", "27", "72", "36", "63", "45", "54"];
        $arrayCollect["Bo_00"][0] = ["00", "55", "05", "50"];
        $arrayCollect["Bo_11"][0] = ["11", "66", "16", "61"];
        $arrayCollect["Bo_22"][0] = ["22", "77", "27", "72"];
        $arrayCollect["Bo_33"][0] = ["33", "88", "38", "83"];
        $arrayCollect["Bo_44"][0] = ["44", "99", "49", "94"];
        $arrayCollect["Bo_01"][0] = ["01", "10", "06", "60", "51", "15", "56", "65"];
        $arrayCollect["Bo_02"][0] = ["02", "20", "07", "70", "25", "52", "57", "75"];
        $arrayCollect["Bo_03"][0] = ["03", "30", "08", "80", "35", "53", "58", "85"];
        $arrayCollect["Bo_04"][0] = ["04", "40", "09", "90", "45", "54", "59", "95"];
        $arrayCollect["Bo_12"][0] = ["12", "21", "17", "71", "26", "62", "67", "76"];
        $arrayCollect["Bo_13"][0] = ["13", "31", "18", "81", "36", "63", "68", "86"];
        $arrayCollect["Bo_14"][0] = ["14", "41", "19", "91", "46", "64", "69", "96"];
        $arrayCollect["Bo_23"][0] = ["23", "32", "28", "82", "73", "37", "78", "87"];
        $arrayCollect["Bo_24"][0] = ["24", "42", "29", "92", "74", "47", "79", "97"];
        $arrayCollect["Bo_34"][0] = ["34", "43", "39", "93", "84", "48", "89", "98"];
        $arrayCollect["00_toi_33"][0] = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33"];
        $arrayCollect["34_toi_66"][0] = ["34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", "61", "62", "63", "64", "65", "66"];
        $arrayCollect["67_toi_99"][0] = ["67", "68", "69", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "80", "81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];
        $arrayCollect["00_toi_24"][0] = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24"];
        $arrayCollect["25_toi_49"][0] = ["25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49"];
        $arrayCollect["50_toi_74"][0] = ["50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "73", "74"];
        $arrayCollect["75_toi_99"][0] = ["75", "76", "77", "78", "79", "80", "81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];
        $arrayCollect["Kep_bang"][0] = ["00", "11", "22", "33", "44", "55", "66", "77", "88", "99"];
        $arrayCollect["Kep_lech"][0] = ["05", "50", "16", "61", "27", "72", "38", "83", "49", "94"];
        $arrayCollect["Kep_am"][0] = ["07", "70", "14", "41", "29", "92", "36", "63", "58", "85"];
        $arrayCollect["Sat_kep"][0] = ["01", "10", "12", "21", "23", "32", "34", "43", "45", "54", "56", "65", "68", "87", "89", "98"];
        $arrayCollect["SkepLech"][0] = ["04", "40", "06", "60", "15", "51", "95", "59", "17", "71", "14", "41", "28", "82", "26", "62", "37", "73", "36", "63", "39", "93", "48", "84"];

        $arrayValue[][] = array();
        $ngang = 1;
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb;
            $arr_kq = getLoto($tmp_result1);

            $arrayValue[$ngang] = $arr_kq;
            $arrayCollect[0][$ngang] = ngay_thang_ts($kq->date);
            $ngang++;
        }

        foreach ($arrayCollect as $i => $array_boso) {
            for ($j = 1; $j < $rollingNumber + 1; $j++) {

                if ($i == 0) continue;
                // tính số lần xuất hiện
                $count = count(array_intersect($array_boso[0], $arrayValue[$j]));
                if ($count == 0) {
                    $arrayCollect[$i][$j][0] = 0;
                } else {
                    $arrayCollect[$i][$j][0] = 1;
                }

                if (empty($arrayCollect[$i][$rollingNumber + 1])) {
                    $arrayCollect[$i][$rollingNumber + 1] = 0;
                }
                $arrayCollect[$i][$rollingNumber + 1] += $arrayCollect[$i][$j][0];

            }
        }
        $arrayCollect[0][0] = "Bộ số";
        $arrayCollect[0][$rollingNumber + 1] = "Tổng số<br>lần về";
        $arrayCollect["5_Dau_nho"]["name"] = "5 Đầu nhỏ";
        $arrayCollect["5_Dau_to"]["name"] = "5 Đầu to";
        $arrayCollect["Tong_chan"]["name"] = "Tổng chẵn";
        $arrayCollect["Tong_le"]["name"] = "Tổng lẻ";
        $arrayCollect["Chan_Le"]["name"] = "Chẵn Lẻ";
        $arrayCollect["Le_Chan"]["name"] = "Lẻ Chẵn";
        $arrayCollect["Chan_Chan"]["name"] = "Chẵn Chẵn";
        $arrayCollect["Le_Le"]["name"] = "Lẻ Lẻ";
        $arrayCollect["Chia_het_3"]["name"] = "Chia hết 3";
        $arrayCollect["Thap_Thap"]["name"] = "Thấp Thấp";
        $arrayCollect["Cao_Cao"]["name"] = "Cao Cao";
        $arrayCollect["Thap_Cao"]["name"] = "Thấp Cao";
        $arrayCollect["Cao_Thap"]["name"] = "Cao Thấp";
        $arrayCollect["Dau_0"]["name"] = "Đầu 0";
        $arrayCollect["Dau_1"]["name"] = "Đầu 1";
        $arrayCollect["Dau_2"]["name"] = "Đầu 2";
        $arrayCollect["Dau_3"]["name"] = "Đầu 3";
        $arrayCollect["Dau_4"]["name"] = "Đầu 4";
        $arrayCollect["Dau_5"]["name"] = "Đầu 5";
        $arrayCollect["Dau_6"]["name"] = "Đầu 6";
        $arrayCollect["Dau_7"]["name"] = "Đầu 7";
        $arrayCollect["Dau_8"]["name"] = "Đầu 8";
        $arrayCollect["Dau_9"]["name"] = "Đầu 9";
        $arrayCollect["Duoi_0"]["name"] = "Đuôi 0";
        $arrayCollect["Duoi_1"]["name"] = "Đuôi 1";
        $arrayCollect["Duoi_2"]["name"] = "Đuôi 2";
        $arrayCollect["Duoi_3"]["name"] = "Đuôi 3";
        $arrayCollect["Duoi_4"]["name"] = "Đuôi 4";
        $arrayCollect["Duoi_5"]["name"] = "Đuôi 5";
        $arrayCollect["Duoi_6"]["name"] = "Đuôi 6";
        $arrayCollect["Duoi_7"]["name"] = "Đuôi 7";
        $arrayCollect["Duoi_8"]["name"] = "Đuôi 8";
        $arrayCollect["Duoi_9"]["name"] = "Đuôi 9";
        $arrayCollect["Cham_0"]["name"] = "Chạm 0";
        $arrayCollect["Cham_1"]["name"] = "Chạm 1";
        $arrayCollect["Cham_2"]["name"] = "Chạm 2";
        $arrayCollect["Cham_3"]["name"] = "Chạm 3";
        $arrayCollect["Cham_4"]["name"] = "Chạm 4";
        $arrayCollect["Cham_5"]["name"] = "Chạm 5";
        $arrayCollect["Cham_6"]["name"] = "Chạm 6";
        $arrayCollect["Cham_7"]["name"] = "Chạm 7";
        $arrayCollect["Cham_8"]["name"] = "Chạm 8";
        $arrayCollect["Cham_9"]["name"] = "Chạm 9";
        $arrayCollect["Tong_0"]["name"] = "Tổng 0";
        $arrayCollect["Tong_1"]["name"] = "Tổng 1";
        $arrayCollect["Tong_2"]["name"] = "Tổng 2";
        $arrayCollect["Tong_3"]["name"] = "Tổng 3";
        $arrayCollect["Tong_4"]["name"] = "Tổng 4";
        $arrayCollect["Tong_5"]["name"] = "Tổng 5";
        $arrayCollect["Tong_6"]["name"] = "Tổng 6";
        $arrayCollect["Tong_7"]["name"] = "Tổng 7";
        $arrayCollect["Tong_8"]["name"] = "Tổng 8";
        $arrayCollect["Tong_9"]["name"] = "Tổng 9";
        $arrayCollect["Bo_00"]["name"] = "Bộ 00";
        $arrayCollect["Bo_11"]["name"] = "Bộ 11";
        $arrayCollect["Bo_22"]["name"] = "Bộ 22";
        $arrayCollect["Bo_33"]["name"] = "Bộ 33";
        $arrayCollect["Bo_44"]["name"] = "Bộ 44";
        $arrayCollect["Bo_01"]["name"] = "Bộ 01";
        $arrayCollect["Bo_02"]["name"] = "Bộ 02";
        $arrayCollect["Bo_03"]["name"] = "Bộ 03";
        $arrayCollect["Bo_04"]["name"] = "Bộ 04";
        $arrayCollect["Bo_12"]["name"] = "Bộ 12";
        $arrayCollect["Bo_13"]["name"] = "Bộ 13";
        $arrayCollect["Bo_14"]["name"] = "Bộ 14";
        $arrayCollect["Bo_23"]["name"] = "Bộ 23";
        $arrayCollect["Bo_24"]["name"] = "Bộ 24";
        $arrayCollect["Bo_34"]["name"] = "Bộ 34";
        $arrayCollect["00_toi_33"]["name"] = "00 tới 33";
        $arrayCollect["34_toi_66"]["name"] = "34 tới 66";
        $arrayCollect["67_toi_99"]["name"] = "67 tới 99";
        $arrayCollect["00_toi_24"]["name"] = "00 tới 24";
        $arrayCollect["25_toi_49"]["name"] = "25 tới 49";
        $arrayCollect["50_toi_74"]["name"] = "50 tới 74";
        $arrayCollect["75_toi_99"]["name"] = "75 tới 99";
        $arrayCollect["Kep_bang"]["name"] = "Kép bằng";
        $arrayCollect["Kep_lech"]["name"] = "Kép lệch";
        $arrayCollect["Kep_am"]["name"] = "Kép âm";
        $arrayCollect["Sat_kep"]["name"] = "Sát kép";
        $arrayCollect["SkepLech"]["name"] = "Skép Lệch";
//        print_ok($arrayCollect);die;


        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongke.tan-suat-giai-dac-biet-tan-suat-dan-de', compact('provinces', 'arrayCollect', 'province_name', 'province_slug', 'short_name', 'rollingNumber'));

    }

    public function getTKTanSuatGiaiDB_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $rollingNumber = $request->rollingNumber;
        $dateEnd = getNgaycheo($request->dateEnd);

//        $rollingNumber = 30;
//        if (!empty($request->rollingNumber))
//            $rollingNumber = $request->rollingNumber;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();
        }
        $arrayCollect = array();

//        $html  = str_get_html(requestvl('https://ketquade1.com/tan-suat-giai-dac-biet-tan-suat-dan-de.html'));
//        foreach($html->find('#normtable .tansuatrow') as $tr){
//            $key  = str_replace('tr_','',$tr->id);
//            $name = trim($tr->find('td.info b',0)->innertext);
//            echo '$arrayCollect["'.$key.'"]["name"] = "'.$name.'";<br/>';
//        }
//        die;

//        $cham = array();
//        $tr_00_toi_33 = '';
//        $tr_34_toi_66 = '';
//        $tr_67_toi_99 = '';
//        $tr_00_toi_24 = '';
//        $tr_25_toi_49 = '';
//        $tr_50_toi_74 = '';
//        $tr_75_toi_99 = '';
//        for ($i = 0; $i < 100; $i++) {
//            $tmp = '0' . $i;
//            $so = substr($tmp, strlen($tmp) - 2, 2);
//            if($i>=0 && $i<=33) $tr_00_toi_33 .= '"'.$so.'",';
//            if($i>=34 && $i<=66) $tr_34_toi_66 .= '"'.$so.'",';
//            if($i>=67 && $i<=99) $tr_67_toi_99 .= '"'.$so.'",';
//            if($i>=0 && $i<=24) $tr_00_toi_24 .= '"'.$so.'",';
//            if($i>=25 && $i<=49) $tr_25_toi_49 .= '"'.$so.'",';
//            if($i>=50 && $i<=74) $tr_50_toi_74 .= '"'.$so.'",';
//            if($i>=75 && $i<=99) $tr_75_toi_99 .= '"'.$so.'",';
//        }
//        echo '$arrayCollect["00_toi_33"][0] =['.substr($tr_00_toi_33,0,-1).'];<br/>';
//        echo '$arrayCollect["34_toi_66"][0] =['.substr($tr_34_toi_66,0,-1).'];<br/>';
//        echo '$arrayCollect["67_toi_99"][0] =['.substr($tr_67_toi_99,0,-1).'];<br/>';
//        echo '$arrayCollect["00_toi_24"][0] =['.substr($tr_00_toi_24,0,-1).'];<br/>';
//        echo '$arrayCollect["25_toi_49"][0] =['.substr($tr_25_toi_49,0,-1).'];<br/>';
//        echo '$arrayCollect["50_toi_74"][0] =['.substr($tr_50_toi_74,0,-1).'];<br/>';
//        echo '$arrayCollect["75_toi_99"][0] =['.substr($tr_75_toi_99,0,-1).'];<br/>';
//        die();
        $arrayCollect["5_Dau_nho"][0] = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49"];
        $arrayCollect["5_Dau_to"][0] = ["50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "80", "81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];
        $arrayCollect["Tong_chan"][0] = ["00", "02", "04", "06", "08", "11", "13", "15", "17", "19", "20", "22", "24", "26", "28", "31", "33", "35", "37", "39", "40", "42", "44", "46", "48", "51", "53", "55", "57", "59", "60", "62", "64", "66", "68", "71", "73", "75", "77", "79", "80", "82", "84", "86", "88", "91", "93", "95", "97", "99"];
        $arrayCollect["Tong_le"][0] = ["01", "03", "05", "07", "09", "10", "12", "14", "16", "18", "21", "23", "25", "27", "29", "30", "32", "34", "36", "38", "41", "43", "45", "47", "49", "50", "52", "54", "56", "58", "61", "63", "65", "67", "69", "70", "72", "74", "76", "78", "81", "83", "85", "87", "89", "90", "92", "94", "96", "98"];
        $arrayCollect["Chan_Le"][0] = ["01", "03", "05", "07", "09", "21", "23", "25", "27", "29", "41", "43", "45", "47", "49", "61", "63", "65", "67", "69", "81", "83", "85", "87", "89"];
        $arrayCollect["Le_Chan"][0] = ["10", "12", "14", "16", "18", "30", "32", "34", "36", "38", "50", "52", "54", "56", "58", "70", "72", "74", "76", "78", "90", "92", "94", "96", "98"];
        $arrayCollect["Chan_Chan"][0] = ["00", "02", "04", "06", "08", "20", "22", "24", "26", "28", "40", "42", "44", "46", "48", "60", "62", "64", "66", "68", "80", "82", "84", "86", "88"];
        $arrayCollect["Le_Le"][0] = ["11", "13", "15", "17", "19", "31", "33", "35", "37", "39", "51", "53", "55", "57", "59", "71", "73", "75", "77", "79", "91", "93", "95", "97", "99"];
        $arrayCollect["Chia_het_3"][0] = ["00", "03", "06", "09,12,15,18", "21", "24", "27", "30", "33", "36", "39", "42", "45", "48", "51", "54", "57", "60", "63", "66", "69", "72", "75", "78", "81", "84", "87", "90", "93", "96", "99"];
        $arrayCollect["Thap_Thap"][0] = ["00", "01", "02", "03", "04", "10", "11", "12", "13", "14", "20", "21", "22", "23", "24", "30", "31", "32", "33", "34. 40", "41", "42", "43", "44"];
        $arrayCollect["Cao_Cao"][0] = ["55", "56", "57", "58", "59", "65", "66", "67", "68", "69", "75", "76", "77", "78", "79", "85", "86", "87", "88", "89", "95", "96", "97", "98", "99"];
        $arrayCollect["Thap_Cao"][0] = ["05", "06", "07", "08", "09", "15", "16", "17", "18", "19", "25", "26", "27", "28", "29", "35", "36", "37", "38", "39", "45", "46", "47", "48", "49"];
        $arrayCollect["Cao_Thap"][0] = ["50", "51", "52", "53", "54", "60", "61", "62", "63", "64", "70", "71", "72", "73", "74", "80", "81", "82", "83", "84", "90", "91", "92", "93", "94"];
        $arrayCollect["Dau_0"][0] = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09"];
        $arrayCollect["Dau_1"][0] = ["10", "11", "12", "13", "14", "15", "16", "17", "18", "19"];
        $arrayCollect["Dau_2"][0] = ["20", "21", "22", "23", "24", "25", "26", "27", "28", "29"];
        $arrayCollect["Dau_3"][0] = ["30", "31", "32", "33", "34", "35", "36", "37", "38", "39"];
        $arrayCollect["Dau_4"][0] = ["40", "41", "42", "43", "44", "45", "46", "47", "48", "49"];
        $arrayCollect["Dau_5"][0] = ["50", "51", "52", "53", "54", "55", "56", "57", "58", "59"];
        $arrayCollect["Dau_6"][0] = ["60", "61", "62", "63", "64", "65", "66", "67", "68", "69"];
        $arrayCollect["Dau_7"][0] = ["70", "71", "72", "73", "74", "75", "76", "77", "78", "79"];
        $arrayCollect["Dau_8"][0] = ["80", "81", "82", "83", "84", "85", "86", "87", "88", "89"];
        $arrayCollect["Dau_9"][0] = ["90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];
        $arrayCollect["Duoi_0"][0] = ["00", "10", "20", "30", "40", "50", "60", "70", "80", "90"];
        $arrayCollect["Duoi_1"][0] = ["01", "11", "21", "31", "41", "51", "61", "71", "81", "91"];
        $arrayCollect["Duoi_2"][0] = ["02", "12", "22", "32", "42", "52", "62", "72", "82", "92"];
        $arrayCollect["Duoi_3"][0] = ["03", "13", "23", "33", "43", "53", "63", "73", "83", "93"];
        $arrayCollect["Duoi_4"][0] = ["04", "14", "24", "34", "44", "54", "64", "74", "84", "94"];
        $arrayCollect["Duoi_5"][0] = ["05", "15", "25", "35", "45", "55", "65", "75", "85", "95"];
        $arrayCollect["Duoi_6"][0] = ["06", "16", "26", "36", "46", "56", "66", "76", "86", "96"];
        $arrayCollect["Duoi_7"][0] = ["07", "17", "27", "37", "47", "57", "67", "77", "87", "97"];
        $arrayCollect["Duoi_8"][0] = ["08", "18", "28", "38", "48", "58", "68", "78", "88", "98"];
        $arrayCollect["Duoi_9"][0] = ["09", "19", "29", "39", "49", "59", "69", "79", "89", "99"];
        $arrayCollect["Cham_0"][0] = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "20", "30", "40", "50", "60", "70", "80", "90"];
        $arrayCollect["Cham_1"][0] = ["01", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "21", "31", "41", "51", "61", "71", "81", "91"];
        $arrayCollect["Cham_2"][0] = ["02", "12", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "32", "42", "52", "62", "72", "82", "92"];
        $arrayCollect["Cham_3"][0] = ["03", "13", "23", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "43", "53", "63", "73", "83", "93"];
        $arrayCollect["Cham_4"][0] = ["04", "14", "24", "34", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "54", "64", "74", "84", "94"];
        $arrayCollect["Cham_5"][0] = ["05", "15", "25", "35", "45", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "65", "75", "85", "95"];
        $arrayCollect["Cham_6"][0] = ["06", "16", "26", "36", "46", "56", "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "76", "86", "96"];
        $arrayCollect["Cham_7"][0] = ["07", "17", "27", "37", "47", "57", "67", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "87", "97"];
        $arrayCollect["Cham_8"][0] = ["08", "18", "28", "38", "48", "58", "68", "78", "80", "81", "82", "83", "84", "85", "86", "87", "88", "89", "98"];
        $arrayCollect["Cham_9"][0] = ["09", "19", "29", "39", "49", "59", "69", "79", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];
        $arrayCollect["Tong_0"][0] = ["00", "19", "28", "37", "46", "55", "64", "73", "82", "91"];
        $arrayCollect["Tong_1"][0] = ["01", "10", "29", "92", "38", "83", "47", "74", "56", "65"];
        $arrayCollect["Tong_2"][0] = ["02", "20", "39", "93", "48", "84", "57", "75", "11", "66"];
        $arrayCollect["Tong_3"][0] = ["03", "30", "12", "21", "49", "94", "58", "85", "67", "76"];
        $arrayCollect["Tong_4"][0] = ["04", "40", "13", "31", "59", "95", "68", "86", "22", "77"];
        $arrayCollect["Tong_5"][0] = ["05", "50", "14", "41", "23", "32", "69", "96", "78", "87"];
        $arrayCollect["Tong_6"][0] = ["06", "60", "15", "51", "24", "42", "79", "97", "33", "88"];
        $arrayCollect["Tong_7"][0] = ["07", "70", "16", "61", "25", "52", "34", "43", "89", "98"];
        $arrayCollect["Tong_8"][0] = ["08", "80", "17", "71", "26", "62", "35", "53", "44", "99"];
        $arrayCollect["Tong_9"][0] = ["09", "90", "18", "81", "27", "72", "36", "63", "45", "54"];
        $arrayCollect["Bo_00"][0] = ["00", "55", "05", "50"];
        $arrayCollect["Bo_11"][0] = ["11", "66", "16", "61"];
        $arrayCollect["Bo_22"][0] = ["22", "77", "27", "72"];
        $arrayCollect["Bo_33"][0] = ["33", "88", "38", "83"];
        $arrayCollect["Bo_44"][0] = ["44", "99", "49", "94"];
        $arrayCollect["Bo_01"][0] = ["01", "10", "06", "60", "51", "15", "56", "65"];
        $arrayCollect["Bo_02"][0] = ["02", "20", "07", "70", "25", "52", "57", "75"];
        $arrayCollect["Bo_03"][0] = ["03", "30", "08", "80", "35", "53", "58", "85"];
        $arrayCollect["Bo_04"][0] = ["04", "40", "09", "90", "45", "54", "59", "95"];
        $arrayCollect["Bo_12"][0] = ["12", "21", "17", "71", "26", "62", "67", "76"];
        $arrayCollect["Bo_13"][0] = ["13", "31", "18", "81", "36", "63", "68", "86"];
        $arrayCollect["Bo_14"][0] = ["14", "41", "19", "91", "46", "64", "69", "96"];
        $arrayCollect["Bo_23"][0] = ["23", "32", "28", "82", "73", "37", "78", "87"];
        $arrayCollect["Bo_24"][0] = ["24", "42", "29", "92", "74", "47", "79", "97"];
        $arrayCollect["Bo_34"][0] = ["34", "43", "39", "93", "84", "48", "89", "98"];
        $arrayCollect["00_toi_33"][0] = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33"];
        $arrayCollect["34_toi_66"][0] = ["34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", "61", "62", "63", "64", "65", "66"];
        $arrayCollect["67_toi_99"][0] = ["67", "68", "69", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "80", "81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];
        $arrayCollect["00_toi_24"][0] = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24"];
        $arrayCollect["25_toi_49"][0] = ["25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45", "46", "47", "48", "49"];
        $arrayCollect["50_toi_74"][0] = ["50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", "61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "73", "74"];
        $arrayCollect["75_toi_99"][0] = ["75", "76", "77", "78", "79", "80", "81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99"];
        $arrayCollect["Kep_bang"][0] = ["00", "11", "22", "33", "44", "55", "66", "77", "88", "99"];
        $arrayCollect["Kep_lech"][0] = ["05", "50", "16", "61", "27", "72", "38", "83", "49", "94"];
        $arrayCollect["Kep_am"][0] = ["07", "70", "14", "41", "29", "92", "36", "63", "58", "85"];
        $arrayCollect["Sat_kep"][0] = ["01", "10", "12", "21", "23", "32", "34", "43", "45", "54", "56", "65", "68", "87", "89", "98"];
        $arrayCollect["SkepLech"][0] = ["04", "40", "06", "60", "15", "51", "95", "59", "17", "71", "14", "41", "28", "82", "26", "62", "37", "73", "36", "63", "39", "93", "48", "84"];

        $arrayValue[][] = array();
        $ngang = 1;
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb;
            $arr_kq = getLoto($tmp_result1);

            $arrayValue[$ngang] = $arr_kq;
            $arrayCollect[0][$ngang] = ngay_thang_ts($kq->date);
            $ngang++;
        }

        foreach ($arrayCollect as $i => $array_boso) {
            for ($j = 1; $j < $rollingNumber + 1; $j++) {

                if ($i == 0) continue;
                // tính số lần xuất hiện
                $count = count(array_intersect($array_boso[0], $arrayValue[$j]));
                if ($count == 0) {
                    $arrayCollect[$i][$j][0] = 0;
                } else {
                    $arrayCollect[$i][$j][0] = 1;
                }

                if (empty($arrayCollect[$i][$rollingNumber + 1])) {
                    $arrayCollect[$i][$rollingNumber + 1] = 0;
                }
                $arrayCollect[$i][$rollingNumber + 1] += $arrayCollect[$i][$j][0];

            }
        }
        $arrayCollect[0][0] = "Bộ số";
        $arrayCollect[0][$rollingNumber + 1] = "Tổng số<br>lần về";
        $arrayCollect["5_Dau_nho"]["name"] = "5 Đầu nhỏ";
        $arrayCollect["5_Dau_to"]["name"] = "5 Đầu to";
        $arrayCollect["Tong_chan"]["name"] = "Tổng chẵn";
        $arrayCollect["Tong_le"]["name"] = "Tổng lẻ";
        $arrayCollect["Chan_Le"]["name"] = "Chẵn Lẻ";
        $arrayCollect["Le_Chan"]["name"] = "Lẻ Chẵn";
        $arrayCollect["Chan_Chan"]["name"] = "Chẵn Chẵn";
        $arrayCollect["Le_Le"]["name"] = "Lẻ Lẻ";
        $arrayCollect["Chia_het_3"]["name"] = "Chia hết 3";
        $arrayCollect["Thap_Thap"]["name"] = "Thấp Thấp";
        $arrayCollect["Cao_Cao"]["name"] = "Cao Cao";
        $arrayCollect["Thap_Cao"]["name"] = "Thấp Cao";
        $arrayCollect["Cao_Thap"]["name"] = "Cao Thấp";
        $arrayCollect["Dau_0"]["name"] = "Đầu 0";
        $arrayCollect["Dau_1"]["name"] = "Đầu 1";
        $arrayCollect["Dau_2"]["name"] = "Đầu 2";
        $arrayCollect["Dau_3"]["name"] = "Đầu 3";
        $arrayCollect["Dau_4"]["name"] = "Đầu 4";
        $arrayCollect["Dau_5"]["name"] = "Đầu 5";
        $arrayCollect["Dau_6"]["name"] = "Đầu 6";
        $arrayCollect["Dau_7"]["name"] = "Đầu 7";
        $arrayCollect["Dau_8"]["name"] = "Đầu 8";
        $arrayCollect["Dau_9"]["name"] = "Đầu 9";
        $arrayCollect["Duoi_0"]["name"] = "Đuôi 0";
        $arrayCollect["Duoi_1"]["name"] = "Đuôi 1";
        $arrayCollect["Duoi_2"]["name"] = "Đuôi 2";
        $arrayCollect["Duoi_3"]["name"] = "Đuôi 3";
        $arrayCollect["Duoi_4"]["name"] = "Đuôi 4";
        $arrayCollect["Duoi_5"]["name"] = "Đuôi 5";
        $arrayCollect["Duoi_6"]["name"] = "Đuôi 6";
        $arrayCollect["Duoi_7"]["name"] = "Đuôi 7";
        $arrayCollect["Duoi_8"]["name"] = "Đuôi 8";
        $arrayCollect["Duoi_9"]["name"] = "Đuôi 9";
        $arrayCollect["Cham_0"]["name"] = "Chạm 0";
        $arrayCollect["Cham_1"]["name"] = "Chạm 1";
        $arrayCollect["Cham_2"]["name"] = "Chạm 2";
        $arrayCollect["Cham_3"]["name"] = "Chạm 3";
        $arrayCollect["Cham_4"]["name"] = "Chạm 4";
        $arrayCollect["Cham_5"]["name"] = "Chạm 5";
        $arrayCollect["Cham_6"]["name"] = "Chạm 6";
        $arrayCollect["Cham_7"]["name"] = "Chạm 7";
        $arrayCollect["Cham_8"]["name"] = "Chạm 8";
        $arrayCollect["Cham_9"]["name"] = "Chạm 9";
        $arrayCollect["Tong_0"]["name"] = "Tổng 0";
        $arrayCollect["Tong_1"]["name"] = "Tổng 1";
        $arrayCollect["Tong_2"]["name"] = "Tổng 2";
        $arrayCollect["Tong_3"]["name"] = "Tổng 3";
        $arrayCollect["Tong_4"]["name"] = "Tổng 4";
        $arrayCollect["Tong_5"]["name"] = "Tổng 5";
        $arrayCollect["Tong_6"]["name"] = "Tổng 6";
        $arrayCollect["Tong_7"]["name"] = "Tổng 7";
        $arrayCollect["Tong_8"]["name"] = "Tổng 8";
        $arrayCollect["Tong_9"]["name"] = "Tổng 9";
        $arrayCollect["Bo_00"]["name"] = "Bộ 00";
        $arrayCollect["Bo_11"]["name"] = "Bộ 11";
        $arrayCollect["Bo_22"]["name"] = "Bộ 22";
        $arrayCollect["Bo_33"]["name"] = "Bộ 33";
        $arrayCollect["Bo_44"]["name"] = "Bộ 44";
        $arrayCollect["Bo_01"]["name"] = "Bộ 01";
        $arrayCollect["Bo_02"]["name"] = "Bộ 02";
        $arrayCollect["Bo_03"]["name"] = "Bộ 03";
        $arrayCollect["Bo_04"]["name"] = "Bộ 04";
        $arrayCollect["Bo_12"]["name"] = "Bộ 12";
        $arrayCollect["Bo_13"]["name"] = "Bộ 13";
        $arrayCollect["Bo_14"]["name"] = "Bộ 14";
        $arrayCollect["Bo_23"]["name"] = "Bộ 23";
        $arrayCollect["Bo_24"]["name"] = "Bộ 24";
        $arrayCollect["Bo_34"]["name"] = "Bộ 34";
        $arrayCollect["00_toi_33"]["name"] = "00 tới 33";
        $arrayCollect["34_toi_66"]["name"] = "34 tới 66";
        $arrayCollect["67_toi_99"]["name"] = "67 tới 99";
        $arrayCollect["00_toi_24"]["name"] = "00 tới 24";
        $arrayCollect["25_toi_49"]["name"] = "25 tới 49";
        $arrayCollect["50_toi_74"]["name"] = "50 tới 74";
        $arrayCollect["75_toi_99"]["name"] = "75 tới 99";
        $arrayCollect["Kep_bang"]["name"] = "Kép bằng";
        $arrayCollect["Kep_lech"]["name"] = "Kép lệch";
        $arrayCollect["Kep_am"]["name"] = "Kép âm";
        $arrayCollect["Sat_kep"]["name"] = "Sát kép";
        $arrayCollect["SkepLech"]["name"] = "Skép Lệch";

        $view = view('frontend.thongke.tan-suat-giai-dac-biet-tan-suat-dan-de-ajax', compact('arrayCollect', 'rollingNumber'))->render();
        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);

    }


    public function getTKTanSuatLoRoi($short_name)
    {
        $rollingNumber = 30;
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';

            // tạo mảng bộ số
            $arr_vitri = ['ĐB', '1', '2_1', '2_2', '3_1', '3_2', '3_3', '3_4', '3_5', '3_6', '4_1', '4_2', '4_3', '4_4', '5_1', '5_2', '5_3', '5_4', '5_5', '5_6', '6_1', '6_2', '6_3', '7_1', '7_2', '7_3', '7_4'];

            $arrayCollect = array();
            for ($i = 0; $i < 27; $i++) {
                $arrayCollect[$i]['name'] = $arr_vitri[$i]; // vị trí
            }
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();


            // tạo mảng bộ số
            $arr_vitri = ['ĐB', '1', '2', '3_1', '3_2', '4_1', '4_2', '4_3', '4_4', '4_5', '4_6', '4_7', '5', '6_1', '6_2', '6_3', '7', '8'];

            $arrayCollect = array();
            for ($i = 0; $i < 18; $i++) {
                $arrayCollect[$i]['name'] = $arr_vitri[$i]; // vị trí
            }
        }
        $len_collect = count($arrayCollect);
        $soboso = $len_collect;

        $arrayValue[][] = array();
        $ngang = 0;
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);

            $arrayValue[$ngang] = $arr_kq;
            $arrayCollect[$soboso+1][$ngang] = ngay_thang_ts($kq->date);
            $ngang++;
        }


        for ($j = 0; $j < $rollingNumber - 1; $j++) {
            for ($i = 0; $i < $len_collect; $i++) {
                $arr_kq_roi = $arrayValue[$j + 1];
                $arr_kq_hom_sau = $arrayValue[$j];

                $arrayCollect[$i][$j][0] = solan_xuathien_trongngay($arr_kq_roi[$i], $arr_kq_hom_sau) + solan_xuathien_trongngay(lon($arr_kq_roi[$i]), $arr_kq_hom_sau);
                if (empty($arrayCollect[$i][$rollingNumber + 1])) {
                    $arrayCollect[$i][$rollingNumber + 1] = 0;
                }
                $arrayCollect[$i][$rollingNumber + 1] += $arrayCollect[$i][$j][0];

            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongke.tan-suat-lo-roi', compact('provinces', 'soboso', 'arrayCollect', 'province_name', 'province_slug', 'short_name', 'rollingNumber'));

    }

    public function getTKTanSuatLoRoi_Ajax(Request $request)
    {
        $short_name = $request->short_name;
        $rollingNumber = $request->rollingNumber;
        $dateEnd = getNgaycheo($request->dateEnd);

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $province_slug = '';

            // tạo mảng bộ số
            $arr_vitri = ['ĐB', '1', '2_1', '2_2', '3_1', '3_2', '3_3', '3_4', '3_5', '3_6', '4_1', '4_2', '4_3', '4_4', '5_1', '5_2', '5_3', '5_4', '5_5', '5_6', '6_1', '6_2', '6_3', '7_1', '7_2', '7_3', '7_4'];

            $arrayCollect = array();
            for ($i = 0; $i < 27; $i++) {
                $arrayCollect[$i]['name'] = $arr_vitri[$i]; // vị trí
            }
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $province_slug = $province->slug;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->where('date', '<=', $dateEnd)->orderBy('date', 'DESC')->take($rollingNumber)->get();

            // tạo mảng bộ số
            $arr_vitri = ['ĐB', '1', '2', '3_1', '3_2', '4_1', '4_2', '4_3', '4_4', '4_5', '4_6', '4_7', '5', '6_1', '6_2', '6_3', '7', '8'];

            $arrayCollect = array();
            for ($i = 0; $i < 18; $i++) {
                $arrayCollect[$i]['name'] = $arr_vitri[$i]; // vị trí
            }
        }
        $len_collect = count($arrayCollect);
        $soboso = $len_collect;

        $arrayValue[][] = array();
        $ngang = 0;
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);

            $arrayValue[$ngang] = $arr_kq;
            $arrayCollect[$soboso+1][$ngang] = ngay_thang_ts($kq->date);
            $ngang++;
        }


        for ($j = 0; $j < $rollingNumber - 1; $j++) {
            for ($i = 0; $i < $len_collect; $i++) {
                $arr_kq_roi = $arrayValue[$j + 1];
                $arr_kq_hom_sau = $arrayValue[$j];

                $arrayCollect[$i][$j][0] = solan_xuathien_trongngay($arr_kq_roi[$i], $arr_kq_hom_sau) + solan_xuathien_trongngay(lon($arr_kq_roi[$i]), $arr_kq_hom_sau);
                if (empty($arrayCollect[$i][$rollingNumber + 1])) {
                    $arrayCollect[$i][$rollingNumber + 1] = 0;
                }
                $arrayCollect[$i][$rollingNumber + 1] += $arrayCollect[$i][$j][0];

            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        $view = view('frontend.thongke.tan-suat-lo-roi-ajax', compact('provinces', 'soboso', 'arrayCollect', 'province_name', 'province_slug', 'short_name', 'rollingNumber'))->render();
        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);
    }



    public function getTKLoXien($short_name, Request $request)
    {
        set_time_limit(0);
        $rollingNumber = 10;
//        if (!empty($request->rollingNumber))
//            $rollingNumber = $request->rollingNumber;

        $loXienType = 2;
//        if (!empty($request->loXienType))
//            $loXienType = $request->loXienType;


        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();

        }

//        $province_id = $request->province;
//        if ($province_id) {
//            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
//            $province = Province::find($province_id);
//            $province_name = $province->name;
//        } else {
//            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
//            $province_name = 'Miền Bắc';
//            $province_id = 0;
//        }
        $arrXien3kq = array();
        if ($loXienType == 2) {
            if (Cache::has('TKLoXien' . $rollingNumber . $province_id)) {
                $arrXienkq = Cache::get('TKLoXien' . $rollingNumber . $province_id);
            } else {
                // tạo mảng bộ số từ 00->99
                $ArrayCollect = array();
                for ($i = 0; $i < 100; $i++) {
                    if ($i < 10) {
                        $ArrayCollect[$i][0] = '0' . $i;
                    } else {
                        $ArrayCollect[$i][0] = $i;
                    }
                    $ArrayCollect[$i][1] = ''; // ngày về gần nhất
                    $ArrayCollect[$i][2] = -1; // số ngày về

                }
                $len_collect = count($ArrayCollect);


                $arrXien = array();
                foreach ($kqs as $kq) {
                    $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                    $arr_kq = getLoto($tmp_result1);


                    for ($t = 0; $t < $len_collect - 1; $t++) {
                        for ($h = $t + 1; $h < $len_collect; $h++) {
                            $loto1 = $ArrayCollect[$t][0];
                            $loto2 = $ArrayCollect[$h][0];
                            if (in_array($loto1, $arr_kq) && in_array($loto2, $arr_kq)) {
                                $arrXien[$loto1 . '-' . $loto2][0] = $loto1 . ' - ' . $loto2;
                                if (empty($arrXien[$loto1 . '-' . $loto2][1])) {
                                    $arrXien[$loto1 . '-' . $loto2][1] = '';
                                }
                                $arrXien[$loto1 . '-' . $loto2][1] .= getNgay($kq->date) . ', ';

                                if (empty($arrXien[$loto1 . '-' . $loto2][2])) {
                                    $arrXien[$loto1 . '-' . $loto2][2] = 0;
                                }
                                $arrXien[$loto1 . '-' . $loto2][2] = $arrXien[$loto1 . '-' . $loto2][2] + 1;
                            }

                        }
                    }
                }

                $arrXienkq = array();
                foreach ($arrXien as $item) {
                    $arrXienkq[] = $item;
                }
                $len_collect = count($arrXienkq);
                for ($e = 0; $e < $len_collect - 1; $e++) {
                    for ($f = $e + 1; $f < $len_collect; $f++) {
                        if ($arrXienkq[$e][2] < $arrXienkq[$f][2]) {
                            swap($arrXienkq[$e][2], $arrXienkq[$f][2]);
                            swap($arrXienkq[$e][0], $arrXienkq[$f][0]);
                            swap($arrXienkq[$e][1], $arrXienkq[$f][1]);
                        }
                    }
                }
                Cache::put('TKLoXien' . $rollingNumber . $province_id, $arrXienkq, 30);
            }
        } else {
            if (Cache::has('TKLoXien3' . $rollingNumber . $province_id)) {
                $arrXien3kq = Cache::get('TKLoXien3' . $rollingNumber . $province_id);
            } else {
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

                $arrXien3 = array();
                foreach ($kqs as $kq) {
                    $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                    $arr_kq = getLoto($tmp_result1);


                    for ($t = 0; $t < $len_collect - 2; $t++) {
                        for ($h = $t + 1; $h < $len_collect - 1; $h++) {
                            for ($k = $h + 1; $k < $len_collect; $k++) {
                                $loto1 = $ArrayCollect[$t][0];
                                $loto2 = $ArrayCollect[$h][0];
                                $loto3 = $ArrayCollect[$k][0];
                                if (in_array($loto1, $arr_kq) && in_array($loto2, $arr_kq) && in_array($loto3, $arr_kq)) {
                                    $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][0] = $loto1 . ' - ' . $loto2 . ' - ' . $loto3;
                                    if (empty($arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][1])) {
                                        $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][1] = '';
                                    }
                                    $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][1] .= getNgay($kq->date) . ', ';

                                    if (empty($arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2])) {
                                        $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2] = 0;
                                    }
                                    $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2] = $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2] + 1;
                                }

                            }
                        }
                    }
                }


                $arrXien3kq = array();
                foreach ($arrXien3 as $item) {
                    $arrXien3kq[] = $item;
                }
                $len_collect = count($arrXien3kq);
                for ($e = 0; $e < $len_collect - 1; $e++) {
                    for ($f = $e + 1; $f < $len_collect; $f++) {
                        if ($arrXien3kq[$e][2] < $arrXien3kq[$f][2]) {
                            swap($arrXien3kq[$e][2], $arrXien3kq[$f][2]);
                            swap($arrXien3kq[$e][0], $arrXien3kq[$f][0]);
                            swap($arrXien3kq[$e][1], $arrXien3kq[$f][1]);
                        }
                    }
                }


                Cache::put('TKLoXien3' . $rollingNumber . $province_id, $arrXien3kq, 30);
            }

        }
        if (Cache::has('xien2' . $short_name)) {
            $xien2 = Cache::get('xien2' . $short_name);
        } else {
            $xien2 = array();
            $xien2[] = getNumberRand() . ' - ' . getNumberRand();
            $xien2[] = getNumberRand() . ' - ' . getNumberRand();
            $xien2[] = getNumberRand() . ' - ' . getNumberRand();
            Cache::put('xien2' . $short_name, $xien2, 60);
        }


        if (Cache::has('xien3' . $short_name)) {
            $xien3 = Cache::get('xien3' . $short_name);
        } else {
            $xien3 = array();
            $xien3[] = getNumberRand() . ' - ' . getNumberRand() . ' - ' . getNumberRand();
            $xien3[] = getNumberRand() . ' - ' . getNumberRand() . ' - ' . getNumberRand();
            $xien3[] = getNumberRand() . ' - ' . getNumberRand() . ' - ' . getNumberRand();
            Cache::put('xien3' . $short_name, $xien3, 60);
        }


        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        $arrRollingNumber = [5, 10, 15, 20, 25, 30];
        return view('frontend.thongke.tk-lo-xien', compact('provinces', 'province_name', 'arrXienkq', 'arrXien3kq', 'arrRollingNumber', 'rollingNumber', 'loXienType', 'short_name', 'xien2', 'xien3'));
    }

    public function getTKLoXien_Ajax(Request $request)
    {
        set_time_limit(0);
        $rollingNumber = 10;
        if (!empty($request->rollingNumber))
            $rollingNumber = $request->rollingNumber;

//        $loXienType = 2;
//        if (!empty($request->loXienType))
//            $loXienType = $request->loXienType;

        $short_name = $request->short_name;
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();

        }

//        $province_id = $request->province;
//        if ($province_id) {
//            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
//            $province = Province::find($province_id);
//            $province_name = $province->name;
//        } else {
//            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
//            $province_name = 'Miền Bắc';
//            $province_id = 0;
//        }
        $arrXien3kq = array();
        $arrXienkq = array();
        if (empty($request->loXienType)) {
            if (Cache::has('TKLoXien' . $rollingNumber . $province_id)) {
                $arrXienkq = Cache::get('TKLoXien' . $rollingNumber . $province_id);
            } else {
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

                $arrXien = array();
                foreach ($kqs as $kq) {
                    $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                    $arr_kq = getLoto($tmp_result1);


                    for ($t = 0; $t < $len_collect - 1; $t++) {
                        for ($h = $t + 1; $h < $len_collect; $h++) {
                            $loto1 = $ArrayCollect[$t][0];
                            $loto2 = $ArrayCollect[$h][0];
                            if (in_array($loto1, $arr_kq) && in_array($loto2, $arr_kq)) {
                                $arrXien[$loto1 . '-' . $loto2][0] = $loto1 . ' - ' . $loto2;
                                if (empty($arrXien[$loto1 . '-' . $loto2][1])) {
                                    $arrXien[$loto1 . '-' . $loto2][1] = '';
                                }
                                $arrXien[$loto1 . '-' . $loto2][1] .= getNgay($kq->date) . ', ';

                                if (empty($arrXien[$loto1 . '-' . $loto2][2])) {
                                    $arrXien[$loto1 . '-' . $loto2][2] = 0;
                                }
                                $arrXien[$loto1 . '-' . $loto2][2] = $arrXien[$loto1 . '-' . $loto2][2] + 1;
                            }

                        }
                    }
                }

                $arrXienkq = array();
                foreach ($arrXien as $item) {
                    $arrXienkq[] = $item;
                }
                $len_collect = count($arrXienkq);
                for ($e = 0; $e < $len_collect - 1; $e++) {
                    for ($f = $e + 1; $f < $len_collect; $f++) {
                        if ($arrXienkq[$e][2] < $arrXienkq[$f][2]) {
                            swap($arrXienkq[$e][2], $arrXienkq[$f][2]);
                            swap($arrXienkq[$e][0], $arrXienkq[$f][0]);
                            swap($arrXienkq[$e][1], $arrXienkq[$f][1]);
                        }
                    }
                }
                Cache::put('TKLoXien' . $rollingNumber . $province_id, $arrXienkq, 30);
            }

            if (Cache::has('TKLoXien3' . $rollingNumber . $province_id)) {
                $arrXien3kq = Cache::get('TKLoXien3' . $rollingNumber . $province_id);
            } else {
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

                $arrXien3 = array();
                foreach ($kqs as $kq) {
                    $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                    $arr_kq = getLoto($tmp_result1);


                    for ($t = 0; $t < $len_collect - 2; $t++) {
                        for ($h = $t + 1; $h < $len_collect - 1; $h++) {
                            for ($k = $h + 1; $k < $len_collect; $k++) {
                                $loto1 = $ArrayCollect[$t][0];
                                $loto2 = $ArrayCollect[$h][0];
                                $loto3 = $ArrayCollect[$k][0];
                                if (in_array($loto1, $arr_kq) && in_array($loto2, $arr_kq) && in_array($loto3, $arr_kq)) {
                                    $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][0] = $loto1 . ' - ' . $loto2 . ' - ' . $loto3;
                                    if (empty($arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][1])) {
                                        $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][1] = '';
                                    }
                                    $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][1] .= getNgay($kq->date) . ', ';

                                    if (empty($arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2])) {
                                        $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2] = 0;
                                    }
                                    $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2] = $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2] + 1;
                                }

                            }
                        }
                    }
                }
//            }

                $arrXien3kq = array();
                foreach ($arrXien3 as $item) {
                    $arrXien3kq[] = $item;
                }
                $len_collect = count($arrXien3kq);
                for ($e = 0; $e < $len_collect - 1; $e++) {
                    for ($f = $e + 1; $f < $len_collect; $f++) {
                        if ($arrXien3kq[$e][2] < $arrXien3kq[$f][2]) {
                            swap($arrXien3kq[$e][2], $arrXien3kq[$f][2]);
                            swap($arrXien3kq[$e][0], $arrXien3kq[$f][0]);
                            swap($arrXien3kq[$e][1], $arrXien3kq[$f][1]);
                        }
                    }
                }


                Cache::put('TKLoXien3' . $rollingNumber . $province_id, $arrXien3kq, 30);
            }
        } else {
            $loXienType = $request->loXienType;
            if ($loXienType == 2) {
                if (Cache::has('TKLoXien' . $rollingNumber . $province_id)) {
                    $arrXienkq = Cache::get('TKLoXien' . $rollingNumber . $province_id);
                } else {
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


                    $arrXien = array();
                    foreach ($kqs as $kq) {
                        $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                        $arr_kq = getLoto($tmp_result1);


                        for ($t = 0; $t < $len_collect - 1; $t++) {
                            for ($h = $t + 1; $h < $len_collect; $h++) {
                                $loto1 = $ArrayCollect[$t][0];
                                $loto2 = $ArrayCollect[$h][0];
                                if (in_array($loto1, $arr_kq) && in_array($loto2, $arr_kq)) {
                                    $arrXien[$loto1 . '-' . $loto2][0] = $loto1 . ' - ' . $loto2;
                                    if (empty($arrXien[$loto1 . '-' . $loto2][1])) {
                                        $arrXien[$loto1 . '-' . $loto2][1] = '';
                                    }
                                    $arrXien[$loto1 . '-' . $loto2][1] .= getNgay($kq->date) . ', ';

                                    if (empty($arrXien[$loto1 . '-' . $loto2][2])) {
                                        $arrXien[$loto1 . '-' . $loto2][2] = 0;
                                    }
                                    $arrXien[$loto1 . '-' . $loto2][2] = $arrXien[$loto1 . '-' . $loto2][2] + 1;
                                }

                            }
                        }
                    }

                    $arrXienkq = array();
                    foreach ($arrXien as $item) {
                        $arrXienkq[] = $item;
                    }
                    $len_collect = count($arrXienkq);
                    for ($e = 0; $e < $len_collect - 1; $e++) {
                        for ($f = $e + 1; $f < $len_collect; $f++) {
                            if ($arrXienkq[$e][2] < $arrXienkq[$f][2]) {
                                swap($arrXienkq[$e][2], $arrXienkq[$f][2]);
                                swap($arrXienkq[$e][0], $arrXienkq[$f][0]);
                                swap($arrXienkq[$e][1], $arrXienkq[$f][1]);
                            }
                        }
                    }
                    Cache::put('TKLoXien' . $rollingNumber . $province_id, $arrXienkq, 30);
                }
            } else {
                if (Cache::has('TKLoXien3' . $rollingNumber . $province_id)) {
                    $arrXien3kq = Cache::get('TKLoXien3' . $rollingNumber . $province_id);
                } else {
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

                    $arrXien3 = array();
                    foreach ($kqs as $kq) {
                        $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                        $arr_kq = getLoto($tmp_result1);


                        for ($t = 0; $t < $len_collect - 2; $t++) {
                            for ($h = $t + 1; $h < $len_collect - 1; $h++) {
                                for ($k = $h + 1; $k < $len_collect; $k++) {
                                    $loto1 = $ArrayCollect[$t][0];
                                    $loto2 = $ArrayCollect[$h][0];
                                    $loto3 = $ArrayCollect[$k][0];
                                    if (in_array($loto1, $arr_kq) && in_array($loto2, $arr_kq) && in_array($loto3, $arr_kq)) {
                                        $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][0] = $loto1 . ' - ' . $loto2 . ' - ' . $loto3;
                                        if (empty($arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][1])) {
                                            $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][1] = '';
                                        }
                                        $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][1] .= getNgay($kq->date) . ', ';

                                        if (empty($arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2])) {
                                            $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2] = 0;
                                        }
                                        $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2] = $arrXien3[$loto1 . '-' . $loto2 . '-' . $loto3][2] + 1;
                                    }

                                }
                            }
                        }
                    }

                    $arrXien3kq = array();
                    foreach ($arrXien3 as $item) {
                        $arrXien3kq[] = $item;
                    }
                    $len_collect = count($arrXien3kq);
                    for ($e = 0; $e < $len_collect - 1; $e++) {
                        for ($f = $e + 1; $f < $len_collect; $f++) {
                            if ($arrXien3kq[$e][2] < $arrXien3kq[$f][2]) {
                                swap($arrXien3kq[$e][2], $arrXien3kq[$f][2]);
                                swap($arrXien3kq[$e][0], $arrXien3kq[$f][0]);
                                swap($arrXien3kq[$e][1], $arrXien3kq[$f][1]);
                            }
                        }
                    }


                    Cache::put('TKLoXien3' . $rollingNumber . $province_id, $arrXien3kq, 30);
                }
            }
        }


//        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
//        $arrRollingNumber = [5, 10, 15, 20, 25, 30];

        $view = '';
        $view .= $this->__buildTeamPlateTKLoXien($arrXienkq, $arrXien3kq, $province_name, $rollingNumber);
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);


    }

    private function __buildTeamPlateTKLoXien($arrXienkq, $arrXien3kq, $province_name, $rollingNumber)
    {
        return view('frontend.thongke.tk-lo-xien-ajax', compact('arrXienkq', 'arrXien3kq', 'province_name', 'rollingNumber'));
    }

    public function getTKLoKep($short_name, Request $request)
    {
        $rollingNumber = 30;
        if (!empty($request->rollingNumber))
            $rollingNumber = $request->rollingNumber;


        $tkXsmb = array();
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $tkXsmb = Post::where('category_id', 1)->orderBy('date', 'DESC')->take(5)->get();
        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;

            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();

        }

        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 9; $i++) {
            $ArrayCollect[$i][0] = $i . $i;
            $ArrayCollect[$i][1] = '';
            $ArrayCollect[$i][2] = -1;

        }
        $len_collect = count($ArrayCollect);

        $arrXien = array();
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);


            for ($t = 0; $t < $len_collect - 1; $t++) {
                for ($h = $t + 1; $h < $len_collect; $h++) {
                    $loto1 = $ArrayCollect[$t][0];
                    $loto2 = $ArrayCollect[$h][0];
                    if (in_array($loto1, $arr_kq) && in_array($loto2, $arr_kq)) {
                        $arrXien[$loto1 . '-' . $loto2][0] = $loto1 . ' - ' . $loto2;
                        if (empty($arrXien[$loto1 . '-' . $loto2][1])) {
                            $arrXien[$loto1 . '-' . $loto2][1] = '';
                        }
                        $arrXien[$loto1 . '-' . $loto2][1] .= getNgay($kq->date) . ', ';

                        if (empty($arrXien[$loto1 . '-' . $loto2][2])) {
                            $arrXien[$loto1 . '-' . $loto2][2] = 0;
                        }
                        $arrXien[$loto1 . '-' . $loto2][2] = $arrXien[$loto1 . '-' . $loto2][2] + 1;
                    }

                }
            }
        }

        $arrXienkq = array();
        foreach ($arrXien as $item) {
            $arrXienkq[] = $item;
        }
        $len_collect = count($arrXienkq);
        for ($e = 0; $e < $len_collect - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect; $f++) {
                if ($arrXienkq[$e][2] < $arrXienkq[$f][2]) {
                    swap($arrXienkq[$e][2], $arrXienkq[$f][2]);
                    swap($arrXienkq[$e][0], $arrXienkq[$f][0]);
                    swap($arrXienkq[$e][1], $arrXienkq[$f][1]);
                }
            }
        }


        /* lô kép lẻ */
        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 9; $i++) {
            $ArrayCollect[$i][0] = $i . $i;
            $ArrayCollect[$i][1] = '';
            $ArrayCollect[$i][2] = -1;

        }
        $len_collect = count($ArrayCollect);

        $arrXien = array();
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);


            for ($t = 0; $t < $len_collect - 1; $t++) {
                $loto1 = $ArrayCollect[$t][0];
                if (in_array($loto1, $arr_kq)) {
                    $arrXien[$loto1][0] = $loto1;
                    if (empty($arrXien[$loto1][1])) {
                        $arrXien[$loto1][1] = '';
                    }
                    $arrXien[$loto1][1] .= getNgay($kq->date) . ', ';

                    if (empty($arrXien[$loto1][2])) {
                        $arrXien[$loto1][2] = 0;
                    }
                    $arrXien[$loto1][2] = $arrXien[$loto1][2] + 1;
                }
            }
        }

        $arrXienkq_1 = array();
        foreach ($arrXien as $item) {
            $arrXienkq_1[] = $item;
        }
        $len_collect = count($arrXienkq_1);
        for ($e = 0; $e < $len_collect - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect; $f++) {
                if ($arrXienkq_1[$e][2] < $arrXienkq_1[$f][2]) {
                    swap($arrXienkq_1[$e][2], $arrXienkq_1[$f][2]);
                    swap($arrXienkq_1[$e][0], $arrXienkq_1[$f][0]);
                    swap($arrXienkq_1[$e][1], $arrXienkq_1[$f][1]);
                }
            }
        }

        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        $arrRollingNumber = [5, 10, 15, 20, 25, 30];
        return view('frontend.thongke.tk-lo-kep', compact('provinces', 'province_name', 'arrXienkq', 'arrXienkq_1', 'arrRollingNumber', 'rollingNumber', 'tkXsmb', 'short_name'));
    }


    public function getTKTong($short_name)
    {
        $tong = 0;
        $dateStart = date('Y-m-d', strtotime("-30 days"));
        $dateEnd = date('Y-m-d');
        $tkXsmb = array();
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->where('status', 1)->orderBy('date', 'DESC')->get();
            $kq_new = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $tkXsmb = Post::where('category_id', 1)->orderBy('date', 'DESC')->take(5)->get();

        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $kqs = Lottery::where('province_id', $province_id)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->where('status', 1)->orderBy('date', 'DESC')->get();
            $kq_new = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->first();
        }

        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        $j = 0;
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $boso = '0' . $i;
            } else {
                $boso = $i;
            }

            if (Tong($boso) == $tong) {
                $ArrayCollect[$j][0] = $boso;
                $ArrayCollect[$j][1] = ''; // ngày về gần nhất
                $ArrayCollect[$j][2] = -1; // số ngày chưa về
                $ArrayCollect[$j][3] = 0; // số lân xuất hiện
                $j++;
            }
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
                    $vals = array_count_values($arr_kq);
                    $ArrayCollect[$t][3] = $ArrayCollect[$t][3] + $vals[$ArrayCollect[$t][0]];
                }
            }
            $number_date++;
        }


        $tmp_result_new = $kq_new->gdb . '-' . $kq_new->g1 . '-' . $kq_new->g2 . '-' . $kq_new->g3 . '-' . $kq_new->g4 . '-' . $kq_new->g5 . '-' . $kq_new->g6 . '-' . $kq_new->g7 . '-' . $kq_new->g8;
        $arr_kq_new = getLoto($tmp_result_new);

        $arr_Tong = array();
        for ($i = 0; $i < 10; $i++) {
            $arr_Tong[$i] = '';
        }
        foreach ($arr_kq_new as $loto) {
            $arr_Tong[tong($loto)] .= $loto . ', ';
        }
        for ($i = 0; $i < 10; $i++) {
            if ($arr_Tong[$i] == '') {
                $arr_Tong[$i] = 'Không về tổng ' . $i;
            } else {
                $arr_Tong[$i] = substr($arr_Tong[$i], 0, strlen($arr_Tong[$i]) - 2);
            }
        }

        $kq_new_date = getNgay($kq_new->date);

        $arrRollingNumber = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongke.tk-lo-tong', compact('provinces', 'arrRollingNumber', 'province_name', 'ArrayCollect', 'arr_Tong', 'kq_new_date', 'short_name', 'tkXsmb', 'tong'));
    }

    public function getTKTong_Ajax(Request $request)
    {
//        $tong = 0;
//        $dateStart = date('Y-m-d', strtotime("-30 days"));
//        $dateEnd = date('Y-m-d');

        $short_name = $request->short_name;
        $tong = $request->rollingNumber;
        $dateStart = getNgaycheo($request->dateStartTong);
        $dateEnd = getNgaycheo($request->dateEndTong);

        $is_special = 0;
        if (!empty($request->is_special))
            $is_special = $request->is_special;


        $tkXsmb = array();
        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->where('status', 1)->orderBy('date', 'DESC')->get();
            $kq_new = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->first();
            $province_name = 'Miền Bắc';
            $province_id = 46;
            $tkXsmb = Post::where('category_id', 1)->orderBy('date', 'DESC')->take(5)->get();

        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $kqs = Lottery::where('province_id', $province_id)->where('date', '>=', $dateStart)->where('date', '<=', $dateEnd)->where('status', 1)->orderBy('date', 'DESC')->get();
            $kq_new = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->first();
        }

        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        $j = 0;
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $boso = '0' . $i;
            } else {
                $boso = $i;
            }

            if (Tong($boso) == $tong) {
                $ArrayCollect[$j][0] = $boso;
                $ArrayCollect[$j][1] = ''; // ngày về gần nhất
                $ArrayCollect[$j][2] = -1; // số ngày chưa về
                $ArrayCollect[$j][3] = 0; // số lân xuất hiện
                $j++;
            }
        }
        $len_collect = count($ArrayCollect);
        $number_date = 0;

        if ($is_special == 0) {
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
                        $vals = array_count_values($arr_kq);
                        $ArrayCollect[$t][3] = $ArrayCollect[$t][3] + $vals[$ArrayCollect[$t][0]];
                    }
                }
                $number_date++;
            }
        } else {
            foreach ($kqs as $kq) {
                $tmp_result1 = $kq->gdb;
                $arr_kq = getLoto($tmp_result1);
                for ($t = 0; $t < $len_collect; $t++) {
                    if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                        if ($ArrayCollect[$t][2] == -1) {
                            $ArrayCollect[$t][1] = getNgay($kq->date);
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][2] = $number_date;
                        }
                        $vals = array_count_values($arr_kq);
                        $ArrayCollect[$t][3] = $ArrayCollect[$t][3] + $vals[$ArrayCollect[$t][0]];
                    }
                }
                $number_date++;
            }
        }


        $tmp_result_new = $kq_new->gdb . '-' . $kq_new->g1 . '-' . $kq_new->g2 . '-' . $kq_new->g3 . '-' . $kq_new->g4 . '-' . $kq_new->g5 . '-' . $kq_new->g6 . '-' . $kq_new->g7 . '-' . $kq_new->g8;
        $arr_kq_new = getLoto($tmp_result_new);

        $arr_Tong = array();
        for ($i = 0; $i < 10; $i++) {
            $arr_Tong[$i] = '';
        }
        foreach ($arr_kq_new as $loto) {
            $arr_Tong[tong($loto)] .= $loto . ', ';
        }
        for ($i = 0; $i < 10; $i++) {
            if ($arr_Tong[$i] == '') {
                $arr_Tong[$i] = 'Không về tổng ' . $i;
            } else {
                $arr_Tong[$i] = substr($arr_Tong[$i], 0, strlen($arr_Tong[$i]) - 2);
            }
        }

        $kq_new_date = getNgay($kq_new->date);

        $arrRollingNumber = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();

        $view = '';
        $view .= $this->__buildTeamPlateTKTong($province_name, $ArrayCollect, $arr_Tong, $kq_new_date, $tong);
        $dataReturn = ["template" => $view];
        return json_encode($dataReturn);
    }

    private function __buildTeamPlateTKTong($province_name, $ArrayCollect, $arr_Tong, $kq_new_date, $tong)
    {
        return view('frontend.thongke.tk-lo-tong-ajax', compact('province_name', 'ArrayCollect', 'arr_Tong', 'kq_new_date', 'tong'));
    }


    public function getTKChuKy2($short_name, Request $request)
    {
        $rollingNumber = 10;
//        if (!empty($request->rollingNumber))
//            $rollingNumber = $request->rollingNumber;

//        $loaiGiai = 1;
//        if (!empty($request->loaiGiai))
//            $loaiGiai = $request->loaiGiai;

        if ($short_name == 'mb') {
            $kqs = Lottery::where('mien', 1)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
            $province_name = 'Miền Bắc';
            $province_id = 46;

        } else {
            $province = Province::where('short_name', $short_name)->first(); if(empty($province)) return view('errors.404');
            $province_id = $province->id;
            $province_name = $province->name;
            $kqs = Lottery::where('province_id', $province_id)->where('status', 1)->orderBy('date', 'DESC')->take($rollingNumber)->get();
        }


        $ArrayCollect = array();
        $ArrayCollect_Duoi = array();
        $ArrayCollect_Tong = array();
        foreach ($kqs as $kq) {
            $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            $arr_kq = getLoto($tmp_result1);

            for ($t = 0; $t < 10; $t++) {
                $ArrayCollect[$kq->date][$t] = 0;
                $ArrayCollect_Duoi[$kq->date][$t] = 0;
                $ArrayCollect_Tong[$kq->date][$t] = 0;
                foreach ($arr_kq as $loto) {
                    if ($t == substr($loto, 0, 1)) {
                        $ArrayCollect[$kq->date][$t] = $ArrayCollect[$kq->date][$t] + 1;
                    }
                    if ($t == substr($loto, 1, 1)) {
                        $ArrayCollect_Duoi[$kq->date][$t] = $ArrayCollect_Duoi[$kq->date][$t] + 1;
                    }

                    if ($t == Tong($loto)) {
                        $ArrayCollect_Tong[$kq->date][$t] = $ArrayCollect_Tong[$kq->date][$t] + 1;
                    }
                }
            }
        }

        $tongDau = array();
        $tongDuoi = array();
        $tongTong = array();
        for ($i = 0; $i < 10; $i++) {
            $tongDau[$i] = 0;
            $tongDuoi[$i] = 0;
            $tongTong[$i] = 0;

        }
        foreach ($ArrayCollect as $value) {
            for ($i = 0; $i < 10; $i++) {
                $tongDau[$i] = $tongDau[$i] + $value[$i];
            }
        }
        foreach ($ArrayCollect_Duoi as $value) {
            for ($i = 0; $i < 10; $i++) {
                $tongDuoi[$i] = $tongDuoi[$i] + $value[$i];
            }
        }
        foreach ($ArrayCollect_Tong as $value) {
            for ($i = 0; $i < 10; $i++) {
                $tongTong[$i] = $tongTong[$i] + $value[$i];
            }
        }
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();
        return view('frontend.thongke.tk-chu-ky', compact('provinces', 'province_name', 'ArrayCollect', 'tongDau', 'ArrayCollect_Duoi', 'tongDuoi', 'ArrayCollect_Tong', 'tongTong', 'short_name'));

    }


    public function getTKLoRoiMAXMB()
    {
        set_time_limit(0);
        // tạo mảng bộ số từ 00->26
        $arr_vitri = ['ĐB', '1', '2_1', '2_2', '3_1', '3_2', '3_3', '3_4', '3_5', '3_6', '4_1', '4_2', '4_3', '4_4', '5_1', '5_2', '5_3', '5_4', '5_5', '5_6', '6_1', '6_2', '6_3', '7_1', '7_2', '7_3', '7_4'];

        $ArrayCollect = array();
        for ($i = 0; $i < 27; $i++) {
            $ArrayCollect[$i][0] = $arr_vitri[$i]; // vị trí
            $ArrayCollect[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect[$i][2] = -1; // số ngày chưa về

        }
        $len_collect = count($ArrayCollect);

        for ($t = 0; $t < $len_collect; $t++) {
            $date_where = date('Y-m-d');
            $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(100)->get();
            $d = 1;
            $d60 = 0;
            while (count($kqs) > 0) {
                $number_date = 0;
                $arr_kq = array();
                $arr_date = array();
                foreach ($kqs as $kq) {
                    $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                    $arr_kq[] = getLoto($tmp_result1);
                    $arr_date[] = $kq->date;
                }

                for ($i = 0; $i <= count($arr_kq) - 2; $i++) {
                    $arr_kq_roi = $arr_kq[$i + 1];
                    $arr_kq_hom_sau = $arr_kq[$i];

                    if (isset($arr_kq_roi[$t])) {
                        if (in_array($arr_kq_roi[$t], $arr_kq_hom_sau)) {
                            if ($ArrayCollect[$t][2] < $number_date) {
                                $ArrayCollect[$t][1] = $arr_date[$i];
                                /*Tinh so ngay chua ve*/
                                $ArrayCollect[$t][2] = $number_date;
                            }
                            $date_where = $arr_date[$i];
                            break;
                        }
                    }

                    $number_date++;
                }
                $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<', $date_where)->where('date', '>=', '2005-01-01')->orderBy('date', 'DESC')->take(100)->get();

                if (count($kqs) < 100 && $number_date == (count($kqs) - 1)) {
                    if ($ArrayCollect[$t][2] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][2] = $number_date;
                        $ArrayCollect[$t][1] = $arr_date[count($arr_date) - 1];
                    }
                    break;
                }

                if (count($kqs) <= $number_date) {
                    if ($ArrayCollect[$t][2] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][2] = $number_date;
                        $ArrayCollect[$t][1] = $arr_date[count($arr_date) - 1];
                    }
                    break;
                }
                if (count($kqs) <= $ArrayCollect[$t][2]) {
                    break;
                }

                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $number_date . '--' . $date_where . '(' . count($kqs) . ').......<br/>';
//                if ($d == 50) break;
            }
//            print_ok($ArrayCollect);
//            die();
//            echo $ArrayCollect[$t][1].'---';
        }
        for ($j = 0; $j < $len_collect; $j++) {
            LoRoi::firstOrCreate([
                'loto' => $ArrayCollect[$j][0],
                'province_id' => 46, // HN
                'mien' => 1,
                'type' => 1,
                'date' => $ArrayCollect[$j][1],
                'max' => $ArrayCollect[$j][2],
            ]);
        }
//        }

        die('Xog!');

    }

    public function getTKLoRoiMAXMT()
    {
        set_time_limit(0);

        $arr_vitri = ['ĐB', '1', '2', '3_1', '3_2', '4_1', '4_2', '4_3', '4_4', '4_5', '4_6', '4_7', '5', '6_1', '6_2', '6_3', '7', '8'];

        $provinces = Province::where('mien', 2)->get();
        foreach ($provinces as $pro) {
            // tạo mảng bộ số
            $ArrayCollect = array();
            for ($i = 0; $i < 18; $i++) {
                $ArrayCollect[$i][0] = $arr_vitri[$i]; // vị trí
                $ArrayCollect[$i][1] = ''; // ngày về gần nhất
                $ArrayCollect[$i][2] = -1; // số ngày chưa về

            }
            $len_collect = count($ArrayCollect);

            for ($t = 0; $t < $len_collect; $t++) {
                $date_where = date('Y-m-d');
                $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(100)->get();
                $d = 1;
                $d60 = 0;
                while (count($kqs) > 0) {
                    $number_date = 0;
                    $arr_kq = array();
                    $arr_date = array();
                    foreach ($kqs as $kq) {
                        $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                        $arr_kq[] = getLoto($tmp_result1);
                        $arr_date[] = $kq->date;
                    }

                    for ($i = 0; $i <= count($arr_kq) - 2; $i++) {
                        $arr_kq_roi = $arr_kq[$i + 1];
                        $arr_kq_hom_sau = $arr_kq[$i];
                        if (isset($arr_kq_roi[$t])) {
                            if (in_array($arr_kq_roi[$t], $arr_kq_hom_sau)) {
                                if ($ArrayCollect[$t][2] < $number_date) {
                                    $ArrayCollect[$t][1] = $arr_date[$i];
                                    /*Tinh so ngay chua ve*/
                                    $ArrayCollect[$t][2] = $number_date;
                                }
                                $date_where = $arr_date[$i];
                                break;
                            }
                        }
                        $number_date++;
                    }
                    $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(100)->get();
                    if (count($kqs) < 100 && $number_date == (count($kqs) - 1)) {
                        if ($ArrayCollect[$t][2] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][2] = $number_date;
                            $ArrayCollect[$t][1] = $arr_date[count($arr_date) - 1];
                        }
                        break;
                    }

                    if (count($kqs) <= $number_date) {
                        if ($ArrayCollect[$t][2] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][2] = $number_date;
                            $ArrayCollect[$t][1] = $arr_date[count($arr_date) - 1];
                        }
                        break;
                    }
                    if (count($kqs) <= $ArrayCollect[$t][2]) {
                        break;
                    }
//                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......';
//                if ($d == 50) break;
                }
//                print_ok($ArrayCollect);
//                die();
//            echo $ArrayCollect[$t][1].'---';
            }
            for ($j = 0; $j < $len_collect; $j++) {
                LoRoi::firstOrCreate([
                    'loto' => $ArrayCollect[$j][0],
                    'province_id' => $pro->id,
                    'mien' => $pro->mien,
                    'type' => 1,
                    'date' => $ArrayCollect[$j][1],
                    'max' => $ArrayCollect[$j][2],
                ]);
            }
        }
//        }

        die('Xog!');

    }

    public function getTKLoRoiMAXMN()
    {
        set_time_limit(0);

        $arr_vitri = ['ĐB', '1', '2', '3_1', '3_2', '4_1', '4_2', '4_3', '4_4', '4_5', '4_6', '4_7', '5', '6_1', '6_2', '6_3', '7', '8'];

        $provinces = Province::where('mien', 3)->get();
        foreach ($provinces as $pro) {
            // tạo mảng bộ số
            $ArrayCollect = array();
            for ($i = 0; $i < 18; $i++) {
                $ArrayCollect[$i][0] = $arr_vitri[$i]; // vị trí
                $ArrayCollect[$i][1] = ''; // ngày về gần nhất
                $ArrayCollect[$i][2] = -1; // số ngày chưa về

            }
            $len_collect = count($ArrayCollect);

            for ($t = 0; $t < $len_collect; $t++) {
                $date_where = date('Y-m-d');
                $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(100)->get();
                $d = 1;
                $d60 = 0;
                while (count($kqs) > 0) {
                    $number_date = 0;
                    $arr_kq = array();
                    $arr_date = array();
                    foreach ($kqs as $kq) {
                        $tmp_result1 = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                        $arr_kq[] = getLoto($tmp_result1);
                        $arr_date[] = $kq->date;
                    }

                    for ($i = 0; $i <= count($arr_kq) - 2; $i++) {
                        $arr_kq_roi = $arr_kq[$i + 1];
                        $arr_kq_hom_sau = $arr_kq[$i];
                        if (isset($arr_kq_roi[$t])) {
                            if (in_array($arr_kq_roi[$t], $arr_kq_hom_sau)) {
                                if ($ArrayCollect[$t][2] < $number_date) {
                                    $ArrayCollect[$t][1] = $arr_date[$i];
                                    /*Tinh so ngay chua ve*/
                                    $ArrayCollect[$t][2] = $number_date;
                                }
                                $date_where = $arr_date[$i];
                                break;
                            }
                        }
                        $number_date++;
                    }
                    $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(100)->get();
                    if (count($kqs) < 100 && $number_date == (count($kqs) - 1)) {
                        if ($ArrayCollect[$t][2] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][2] = $number_date;
                            $ArrayCollect[$t][1] = $arr_date[count($arr_date) - 1];
                        }
                        break;
                    }

                    if (count($kqs) <= $number_date) {
                        if ($ArrayCollect[$t][2] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][2] = $number_date;
                            $ArrayCollect[$t][1] = $arr_date[count($arr_date) - 1];
                        }
                        break;
                    }
                    if (count($kqs) <= $ArrayCollect[$t][2]) {
                        break;
                    }
//                    echo $d++ . '--' . $ArrayCollect[$t][0] . '--'  .$ArrayCollect[$t][2]. '--' .$number_date. '--' . $date_where . '(' . count($kqs) . ')...... <br/>';
//                if ($d == 50) break;
                }
//                print_ok($ArrayCollect);
//                die();
//            echo $ArrayCollect[$t][0].'-------------------------------<br/>';
            }
//            print_ok($ArrayCollect);
//            die;
            for ($j = 0; $j < $len_collect; $j++) {
                LoRoi::firstOrCreate([
                    'loto' => $ArrayCollect[$j][0],
                    'province_id' => $pro->id,
                    'mien' => $pro->mien,
                    'type' => 1,
                    'date' => $ArrayCollect[$j][1],
                    'max' => $ArrayCollect[$j][2],
                ]);
            }
        }
//        }

        die('Xog!');

    }


    public function getTKLoGanMAXMB()
    {
        set_time_limit(0);
        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = -1; // số ngày chưa về
            $ArrayCollect[$i][2] = ''; // khoảng ngày

        }
        $len_collect = count($ArrayCollect);
//        $provinces = Province::where('mien', 2)->orWhere('mien', 3)->get();
//        foreach ($provinces as $pro) {
        for ($t = 0; $t < $len_collect; $t++) {
            $date_where = date('Y-m-d');
            $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(150)->get();
            $d = 1;
            $d60 = 0;
            while (count($kqs) > 0) {
                $number_date = 0;
                foreach ($kqs as $kq) {
                    $tmp_result = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                    $arr_kq = getLoto($tmp_result);
                    if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $kq->date;
                        }
                        $date_where = $kq->date;
                        break;
                    }
                    $number_date++;
                }
                $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(150)->get();
                if (count($kqs) <= $number_date) {
                    if ($ArrayCollect[$t][1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][1] = $number_date;
                        $ArrayCollect[$t][2] = $date_where;
                    }
                    break;
                }
                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......<br/>';
//                if ($d == 50) break;
            }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
        }
        for ($j = 0; $j < $len_collect; $j++) {
            Gan::firstOrCreate([
                'loto' => $ArrayCollect[$j][0],
                'province_id' => 46, // HN
                'mien' => 1,
                'type' => 1,
                'date' => $ArrayCollect[$j][2],
                'max' => $ArrayCollect[$j][1],
            ]);
        }
//        }

        die('Xog!');

    }


    public function getTKLoGanMAXMB_CAP()
    {
        set_time_limit(0);
        // tạo mảng bộ số cặp
//        $i = 0;
//        $ArrayCollect = array();
//        for ($t = 0; $t <= 8; $t++) {
//            for ($h = $t + 1; $h <= 9; $h++) {
//                $ArrayCollect[$i][0] = $t . $h;
//                $ArrayCollect[$i][1] = -1;
//                $ArrayCollect[$i][2] = ''; // khoảng ngày
//                $i++;
//            }
//        }

        $i = 0;
        $ArrayCollect = array();
        for ($t = 0; $t <= 4; $t++) {
            $ArrayCollect[$i][0] = $t . $t;
            $ArrayCollect[$i][1] = -1;
            $ArrayCollect[$i][2] = ''; // khoảng ngày
            $i++;
        }
        $len_collect = count($ArrayCollect);
        for ($t = 0; $t < $len_collect; $t++) {
            $date_where = date('Y-m-d');
            $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(150)->get();
            $d = 1;
            $d60 = 0;
            while (count($kqs) > 0) {
                $number_date = 0;
                foreach ($kqs as $kq) {
                    $tmp_result = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                    $arr_kq = getLoto($tmp_result);
                    if (in_array($ArrayCollect[$t][0], $arr_kq) || in_array(lon($ArrayCollect[$t][0]), $arr_kq)) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $kq->date;
                        }
                        $date_where = $kq->date;
                        break;
                    }
                    $number_date++;
                }
                $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(150)->get();
                if (count($kqs) <= $number_date) {
                    if ($ArrayCollect[$t][1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][1] = $number_date;
                        $ArrayCollect[$t][2] = $date_where;
                    }
                    break;
                }
//                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......';
//                if ($d == 50) break;
            }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
        }
        for ($j = 0; $j < $len_collect; $j++) {
            Gan::firstOrCreate([
                'loto' => $ArrayCollect[$j][0],
                'province_id' => 46, // HN
                'mien' => 1,
                'type' => 2,
                'date' => $ArrayCollect[$j][2],
                'max' => $ArrayCollect[$j][1],
            ]);
        }

        die('Xog!');

    }

    public function getTKLoGanMAX()
    {
        set_time_limit(0);
        $provinces = Province::where('mien', 2)->orWhere('mien', 3)->get();
        foreach ($provinces as $pro) {
            // tạo mảng bộ số từ 00->99
            $ArrayCollect = array();
            for ($i = 0; $i < 100; $i++) {
                if ($i < 10) {
                    $ArrayCollect[$i][0] = '0' . $i;
                } else {
                    $ArrayCollect[$i][0] = $i;
                }
                $ArrayCollect[$i][1] = -1; // số ngày chưa về
                $ArrayCollect[$i][2] = ''; // khoảng ngày

            }
            $len_collect = count($ArrayCollect);

            for ($t = 0; $t < $len_collect; $t++) {
                $date_where = date('Y-m-d');
                $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(150)->get();
                $d = 1;
                $d60 = 0;
                while (count($kqs) > 0) {
                    $number_date = 0;
                    foreach ($kqs as $kq) {
                        $tmp_result = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                        $arr_kq = getLoto($tmp_result);
                        if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                            if ($ArrayCollect[$t][1] < $number_date) {
                                /*Tinh so ngay chua ve*/
                                $ArrayCollect[$t][1] = $number_date;
                                $ArrayCollect[$t][2] = $kq->date;
                            }
                            $date_where = $kq->date;
                            break;
                        }
                        $number_date++;
                    }
                    $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(150)->get();
                    if (count($kqs) <= $number_date) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $date_where;
                        }
                        break;
                    }
//                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......';
//                if ($d == 50) break;
                }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
            }
            for ($j = 0; $j < $len_collect; $j++) {
                Gan::firstOrCreate([
                    'loto' => $ArrayCollect[$j][0],
                    'province_id' => $pro->id,
                    'mien' => $pro->mien,
                    'type' => 1,
                    'date' => $ArrayCollect[$j][2],
                    'max' => $ArrayCollect[$j][1],
                ]);
            }
        }

        die('Xog!');

    }

    public function getTKLoGanMAX_CAP()
    {
        set_time_limit(0);

        $provinces = Province::where('mien', 2)->orWhere('mien', 3)->get();
        foreach ($provinces as $pro) {
            // tạo mảng bộ số cặp
            $i = 0;
            $ArrayCollect = array();
//            for ($t = 0; $t <= 8; $t++) {
//                for ($h = $t + 1; $h <= 9; $h++) {
//                    $ArrayCollect[$i][0] = $t . $h;
//                    $ArrayCollect[$i][1] = -1;
//                    $ArrayCollect[$i][2] = ''; // khoảng ngày
//                    $i++;
//                }
//            }

            for ($t = 0; $t <= 4; $t++) {
                $ArrayCollect[$i][0] = $t . $t;
                $ArrayCollect[$i][1] = -1;
                $ArrayCollect[$i][2] = ''; // khoảng ngày
                $i++;
            }
            $len_collect = count($ArrayCollect);
            for ($t = 0; $t < $len_collect; $t++) {
                $date_where = date('Y-m-d');
                $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(150)->get();
                $d = 1;
                $d60 = 0;
                while (count($kqs) > 0) {
                    $number_date = 0;
                    foreach ($kqs as $kq) {
                        $tmp_result = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
                        $arr_kq = getLoto($tmp_result);
                        if (in_array($ArrayCollect[$t][0], $arr_kq) || in_array(lon($ArrayCollect[$t][0]), $arr_kq)) {
                            if ($ArrayCollect[$t][1] < $number_date) {
                                /*Tinh so ngay chua ve*/
                                $ArrayCollect[$t][1] = $number_date;
                                $ArrayCollect[$t][2] = $kq->date;
                            }
                            $date_where = $kq->date;
                            break;
                        }
                        $number_date++;
                    }
                    $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(150)->get();
                    if (count($kqs) <= $number_date) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $date_where;
                        }
                        break;
                    }
//                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......';
//                if ($d == 50) break;
                }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
            }
            for ($j = 0; $j < $len_collect; $j++) {
                Gan::firstOrCreate([
                    'loto' => $ArrayCollect[$j][0],
                    'province_id' => $pro->id,
                    'mien' => $pro->mien,
                    'type' => 2,
                    'date' => $ArrayCollect[$j][2],
                    'max' => $ArrayCollect[$j][1],
                ]);
            }
        }

        die('Xog!');

    }

    public function getTKDauGanMAXMB()
    {
        set_time_limit(0);
        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 10; $i++) {
            $ArrayCollect[$i][0] = $i;
            $ArrayCollect[$i][1] = -1; // số ngày chưa về
            $ArrayCollect[$i][2] = ''; // khoảng ngày

        }
        $len_collect = count($ArrayCollect);
//        $provinces = Province::where('mien', 2)->orWhere('mien', 3)->get();
//        foreach ($provinces as $pro) {
        for ($t = 0; $t < $len_collect; $t++) {
            $date_where = date('Y-m-d');
            $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(150)->get();
            $d = 1;
            $d60 = 0;
            while (count($kqs) > 0) {
                $number_date = 0;
                foreach ($kqs as $kq) {
                    if ($ArrayCollect[$t][0] == substr($kq->gdb, -2, 1)) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $kq->date;
                        }
                        $date_where = $kq->date;
                        break;
                    }
                    $number_date++;
                }
                $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(150)->get();

                if (count($kqs) < 600 && $number_date == (count($kqs) - 1)) {
                    if ($ArrayCollect[$t][1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][1] = $number_date;
                        $ArrayCollect[$t][2] = $date_where;
                    }
                    break;
                }
                if (count($kqs) <= $ArrayCollect[$t][1]) {
                    break;
                }

                if (count($kqs) <= $number_date) {
                    if ($ArrayCollect[$t][1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][1] = $number_date;
                        $ArrayCollect[$t][2] = $date_where;
                    }
                    break;
                }

                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......<br/>';
//                if ($d == 50) break;
            }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
        }
        for ($j = 0; $j < $len_collect; $j++) {
            GanDB::firstOrCreate([
                'loto' => $ArrayCollect[$j][0],
                'province_id' => 46, // HN
                'mien' => 1,
                'type' => 1,
                'date' => $ArrayCollect[$j][2],
                'max' => $ArrayCollect[$j][1],
            ]);
        }
//        }

        die('Xog!');

    }

    public function getTKDauGanMAX()
    {
        set_time_limit(0);
        $provinces = Province::where('mien', 2)->orWhere('mien', 3)->get();
        foreach ($provinces as $pro) {
            // tạo mảng bộ số
            $ArrayCollect = array();
            for ($i = 0; $i < 10; $i++) {
                $ArrayCollect[$i][0] = $i;
                $ArrayCollect[$i][1] = -1; // số ngày chưa về
                $ArrayCollect[$i][2] = ''; // khoảng ngày

            }
            $len_collect = count($ArrayCollect);

            for ($t = 0; $t < $len_collect; $t++) {
                $date_where = date('Y-m-d');
                $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(150)->get();
                $d = 1;
                while (count($kqs) > 0) {
                    $number_date = 0;
                    foreach ($kqs as $kq) {
                        if ($ArrayCollect[$t][0] == substr($kq->gdb, -2, 1)) {
                            if ($ArrayCollect[$t][1] < $number_date) {
                                /*Tinh so ngay chua ve*/
                                $ArrayCollect[$t][1] = $number_date;
                                $ArrayCollect[$t][2] = $kq->date;
                            }
                            $date_where = $kq->date;
                            break;
                        }
                        $number_date++;
                    }
                    $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(150)->get();

                    if (count($kqs) < 100 && $number_date == (count($kqs) - 1)) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $date_where;
                        }
                        break;
                    }
                    if (count($kqs) <= $ArrayCollect[$t][1]) {
                        break;
                    }

                    if (count($kqs) <= $number_date) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $date_where;
                        }
                        break;
                    }
//                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......';
//                if ($d == 50) break;
                }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
            }
            for ($j = 0; $j < $len_collect; $j++) {
                GanDB::firstOrCreate([
                    'loto' => $ArrayCollect[$j][0],
                    'province_id' => $pro->id,
                    'mien' => $pro->mien,
                    'type' => 1,
                    'date' => $ArrayCollect[$j][2],
                    'max' => $ArrayCollect[$j][1],
                ]);
            }
        }

        die('Xog!');

    }

    public function getTKDuoiGanMAXMB()
    {
        set_time_limit(0);
        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 10; $i++) {
            $ArrayCollect[$i][0] = $i;
            $ArrayCollect[$i][1] = -1; // số ngày chưa về
            $ArrayCollect[$i][2] = ''; // khoảng ngày

        }
        $len_collect = count($ArrayCollect);
//        $provinces = Province::where('mien', 2)->orWhere('mien', 3)->get();
//        foreach ($provinces as $pro) {
        for ($t = 0; $t < $len_collect; $t++) {
            $date_where = date('Y-m-d');
            $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(150)->get();
            $d = 1;
            $d60 = 0;
            while (count($kqs) > 0) {
                $number_date = 0;
                foreach ($kqs as $kq) {
                    if ($ArrayCollect[$t][0] == substr($kq->gdb, -1)) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $kq->date;
                        }
                        $date_where = $kq->date;
                        break;
                    }
                    $number_date++;
                }
                $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(150)->get();

                if (count($kqs) < 600 && $number_date == (count($kqs) - 1)) {
                    if ($ArrayCollect[$t][1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][1] = $number_date;
                        $ArrayCollect[$t][2] = $date_where;
                    }
                    break;
                }
                if (count($kqs) <= $ArrayCollect[$t][1]) {
                    break;
                }

                if (count($kqs) <= $number_date) {
                    if ($ArrayCollect[$t][1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][1] = $number_date;
                        $ArrayCollect[$t][2] = $date_where;
                    }
                    break;
                }

                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......<br/>';
//                if ($d == 50) break;
            }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
        }
        for ($j = 0; $j < $len_collect; $j++) {
            GanDB::firstOrCreate([
                'loto' => $ArrayCollect[$j][0],
                'province_id' => 46, // HN
                'mien' => 1,
                'type' => 2,
                'date' => $ArrayCollect[$j][2],
                'max' => $ArrayCollect[$j][1],
            ]);
        }
//        }

        die('Xog!');

    }

    public function getTKDuoiGanMAX()
    {
        set_time_limit(0);
        $provinces = Province::where('mien', 2)->orWhere('mien', 3)->get();
        foreach ($provinces as $pro) {
            // tạo mảng bộ số
            $ArrayCollect = array();
            for ($i = 0; $i < 10; $i++) {
                $ArrayCollect[$i][0] = $i;
                $ArrayCollect[$i][1] = -1; // số ngày chưa về
                $ArrayCollect[$i][2] = ''; // khoảng ngày

            }
            $len_collect = count($ArrayCollect);

            for ($t = 0; $t < $len_collect; $t++) {
                $date_where = date('Y-m-d');
                $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(150)->get();
                $d = 1;
                while (count($kqs) > 0) {
                    $number_date = 0;
                    foreach ($kqs as $kq) {
                        if ($ArrayCollect[$t][0] == substr($kq->gdb, -1)) {
                            if ($ArrayCollect[$t][1] < $number_date) {
                                /*Tinh so ngay chua ve*/
                                $ArrayCollect[$t][1] = $number_date;
                                $ArrayCollect[$t][2] = $kq->date;
                            }
                            $date_where = $kq->date;
                            break;
                        }
                        $number_date++;
                    }
                    $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(150)->get();

                    if (count($kqs) < 100 && $number_date == (count($kqs) - 1)) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $date_where;
                        }
                        break;
                    }
                    if (count($kqs) <= $ArrayCollect[$t][1]) {
                        break;
                    }

                    if (count($kqs) <= $number_date) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $date_where;
                        }
                        break;
                    }
//                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......';
//                if ($d == 50) break;
                }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
            }
            for ($j = 0; $j < $len_collect; $j++) {
                GanDB::firstOrCreate([
                    'loto' => $ArrayCollect[$j][0],
                    'province_id' => $pro->id,
                    'mien' => $pro->mien,
                    'type' => 2,
                    'date' => $ArrayCollect[$j][2],
                    'max' => $ArrayCollect[$j][1],
                ]);
            }
        }

        die('Xog!');

    }

    public function getTKTongGanMAXMB()
    {
        set_time_limit(0);
        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 10; $i++) {
            $ArrayCollect[$i][0] = $i;
            $ArrayCollect[$i][1] = -1; // số ngày chưa về
            $ArrayCollect[$i][2] = ''; // khoảng ngày

        }
        $len_collect = count($ArrayCollect);
//        $provinces = Province::where('mien', 2)->orWhere('mien', 3)->get();
//        foreach ($provinces as $pro) {
        for ($t = 0; $t < $len_collect; $t++) {
            $date_where = date('Y-m-d');
            $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(150)->get();
            $d = 1;
            $d60 = 0;
            while (count($kqs) > 0) {
                $number_date = 0;
                foreach ($kqs as $kq) {
                    if ($ArrayCollect[$t][0] == Tong(substr($kq->gdb, -2))) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $kq->date;
                        }
                        $date_where = $kq->date;
                        break;
                    }
                    $number_date++;
                }
                $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(150)->get();

                if (count($kqs) < 600 && $number_date == (count($kqs) - 1)) {
                    if ($ArrayCollect[$t][1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][1] = $number_date;
                        $ArrayCollect[$t][2] = $date_where;
                    }
                    break;
                }
                if (count($kqs) <= $ArrayCollect[$t][1]) {
                    break;
                }

                if (count($kqs) <= $number_date) {
                    if ($ArrayCollect[$t][1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][1] = $number_date;
                        $ArrayCollect[$t][2] = $date_where;
                    }
                    break;
                }

                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......<br/>';
//                if ($d == 50) break;
            }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
        }
        for ($j = 0; $j < $len_collect; $j++) {
            GanDB::firstOrCreate([
                'loto' => $ArrayCollect[$j][0],
                'province_id' => 46, // HN
                'mien' => 1,
                'type' => 3,
                'date' => $ArrayCollect[$j][2],
                'max' => $ArrayCollect[$j][1],
            ]);
        }
//        }

        die('Xog!');

    }

    public function getTKTongGanMAX()
    {
        set_time_limit(0);
        $provinces = Province::where('mien', 2)->orWhere('mien', 3)->get();
        foreach ($provinces as $pro) {
            // tạo mảng bộ số
            $ArrayCollect = array();
            for ($i = 0; $i < 10; $i++) {
                $ArrayCollect[$i][0] = $i;
                $ArrayCollect[$i][1] = -1; // số ngày chưa về
                $ArrayCollect[$i][2] = ''; // khoảng ngày

            }
            $len_collect = count($ArrayCollect);

            for ($t = 0; $t < $len_collect; $t++) {
                $date_where = date('Y-m-d');
                $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(150)->get();
                $d = 1;
                while (count($kqs) > 0) {
                    $number_date = 0;
                    foreach ($kqs as $kq) {
                        if ($ArrayCollect[$t][0] == Tong(substr($kq->gdb, -2))) {
                            if ($ArrayCollect[$t][1] < $number_date) {
                                /*Tinh so ngay chua ve*/
                                $ArrayCollect[$t][1] = $number_date;
                                $ArrayCollect[$t][2] = $kq->date;
                            }
                            $date_where = $kq->date;
                            break;
                        }
                        $number_date++;
                    }
                    $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(150)->get();

                    if (count($kqs) < 100 && $number_date == (count($kqs) - 1)) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $date_where;
                        }
                        break;
                    }
                    if (count($kqs) <= $ArrayCollect[$t][1]) {
                        break;
                    }

                    if (count($kqs) <= $number_date) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $date_where;
                        }
                        break;
                    }
//                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......';
//                if ($d == 50) break;
                }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
            }
            for ($j = 0; $j < $len_collect; $j++) {
                GanDB::firstOrCreate([
                    'loto' => $ArrayCollect[$j][0],
                    'province_id' => $pro->id,
                    'mien' => $pro->mien,
                    'type' => 3,
                    'date' => $ArrayCollect[$j][2],
                    'max' => $ArrayCollect[$j][1],
                ]);
            }
        }

        die('Xog!');

    }

    public function getTKDBGanMAXTN()
    {
        set_time_limit(0);
        $provinces = Province::where('mien', 2)->orWhere('mien', 3)->get();
        foreach ($provinces as $pro) {
            // tạo mảng bộ số
            $ArrayCollect = array();
            for ($i = 0; $i < 100; $i++) {
                if ($i < 10) {
                    $ArrayCollect[$i][0] = '0' . $i;
                } else {
                    $ArrayCollect[$i][0] = $i;
                }
                $ArrayCollect[$i][1] = -1; // số ngày chưa về
                $ArrayCollect[$i][2] = ''; // khoảng ngày

            }
            $len_collect = count($ArrayCollect);

            for ($t = 0; $t < $len_collect; $t++) {
                $date_where = date('Y-m-d');
                $date_where_last = date('Y-m-d');
                $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(1500)->get();
                $d = 1;
                while (count($kqs) > 0) {
                    $number_date = 0;
                    foreach ($kqs as $kq) {
                        if ($ArrayCollect[$t][0] == substr($kq->gdb, -2)) {
                            if ($ArrayCollect[$t][1] < $number_date) {
                                /*Tinh so ngay chua ve*/
                                $ArrayCollect[$t][1] = $number_date;
                                $ArrayCollect[$t][2] = $kq->date;
                            }
                            $date_where = $kq->date;
                            break;
                        }
                        $number_date++;
                        $date_where_last = $kq->date;
                    }
                    $kqs = Lottery::where('status', 1)->where('province_id', $pro->id)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(1500)->get();

                    if (count($kqs) < 100 && $number_date == (count($kqs) - 1)) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $date_where;
                        }
                        break;
                    }
                    if (count($kqs) <= $ArrayCollect[$t][1]) {
                        break;
                    }

                    if (count($kqs) <= $number_date) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $date_where_last;
                        }
                        break;
                    }
//                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......';
//                if ($d == 50) break;
                }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
            }
            for ($j = 0; $j < $len_collect; $j++) {
                GanDB::firstOrCreate([
                    'loto' => $ArrayCollect[$j][0],
                    'province_id' => $pro->id,
                    'mien' => $pro->mien,
                    'type' => 4,
                    'date' => $ArrayCollect[$j][2],
                    'max' => $ArrayCollect[$j][1],
                ]);
            }
        }

        die('Xog!');

    }

    public function getTKDBGanMAXMB()
    {
        set_time_limit(0);
        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect[$i][1] = -1; // số ngày chưa về
            $ArrayCollect[$i][2] = ''; // khoảng ngày

        }
        $len_collect = count($ArrayCollect);
//        $provinces = Province::where('mien', 2)->orWhere('mien', 3)->get();
//        foreach ($provinces as $pro) {
        for ($t = 0; $t < $len_collect; $t++) {
            $date_where = date('Y-m-d');
            $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<=', $date_where)->orderBy('date', 'DESC')->take(1000)->get();
            $d = 1;
            $d60 = 0;
            while (count($kqs) > 0) {
                $number_date = 0;
                foreach ($kqs as $kq) {
                    if ($ArrayCollect[$t][0] == substr($kq->gdb, -2)) {
                        if ($ArrayCollect[$t][1] < $number_date) {
                            /*Tinh so ngay chua ve*/
                            $ArrayCollect[$t][1] = $number_date;
                            $ArrayCollect[$t][2] = $kq->date;
                        }
                        $date_where = $kq->date;
                        break;
                    }
                    $number_date++;
                }
                $kqs = Lottery::where('status', 1)->where('mien', 1)->where('date', '<', $date_where)->orderBy('date', 'DESC')->take(1000)->get();

                if (count($kqs) < 600 && $number_date == (count($kqs) - 1)) {
                    if ($ArrayCollect[$t][1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][1] = $number_date;
                        $ArrayCollect[$t][2] = $date_where;
                    }
                    break;
                }
                if (count($kqs) <= $ArrayCollect[$t][1]) {
                    break;
                }

                if (count($kqs) <= $number_date) {
                    if ($ArrayCollect[$t][1] < $number_date) {
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][1] = $number_date;
                        $ArrayCollect[$t][2] = $date_where;
                    }
                    break;
                }

                echo $d++ . '--' . $ArrayCollect[$t][0] . '--' . $date_where . '(' . count($kqs) . ')......<br/>';
//                if ($d == 50) break;
            }
//            print_ok($ArrayCollect);die();
//            echo $ArrayCollect[$t][1].'---';
        }
        for ($j = 0; $j < $len_collect; $j++) {
            GanDB::firstOrCreate([
                'loto' => $ArrayCollect[$j][0],
                'province_id' => 46, // HN
                'mien' => 1,
                'type' => 4,
                'date' => $ArrayCollect[$j][2],
                'max' => $ArrayCollect[$j][1],
            ]);
        }
//        }

        die('Xog!');

    }

    public function getTKMAXMB_DateEnd()
    {
        set_time_limit(0);
//        GanDB::where('type',4)->delete();
//        die('Xoa Xong!');
//        $gans = Gan::all();
//        foreach($gans as $gan){
//            if($gan->mien==1){
//                $date_end = date('Y-m-d', strtotime(getNgayLink($gan->date) . ' +'.$gan->max.' days'));
//            }else{
//                $kq = Lottery::where('status', 1)->where('province_id', $gan->province_id)->where('date', '>', $gan->date)->orderBy('date','ASC')->take($gan->max)->get()->toArray();
//                $date_end = $kq[count($kq)-1]['date'];
////                echo $gan->date.'----------'.$gan->max.'----------'.$gan->province_id.'-------------'.$kq[count($kq)-1]['date'].'<br/>';
//            }
//            $gan->date_end = $date_end;
//            $gan->save();
//        }

        $gans = GanDB::where('date_end', null)->get();
        foreach ($gans as $gan) {
            if ($gan->mien == 1) {
                $date_end = date('Y-m-d', strtotime(getNgayLink($gan->date) . ' +' . $gan->max . ' days'));
            } else {
                $kq = Lottery::where('status', 1)->where('province_id', $gan->province_id)->where('date', '>', $gan->date)->orderBy('date', 'ASC')->take($gan->max)->get()->toArray();
                $date_end = $kq[count($kq) - 1]['date'];
//                echo $gan->date.'----------'.$gan->max.'----------'.$gan->province_id.'-------------'.$kq[count($kq)-1]['date'].'<br/>';
            }
            $gan->date_end = $date_end;
            $gan->save();
        }


//        $gans = LoRoi::all();
//        foreach($gans as $gan){
//            if($gan->mien==1){
//                $date_end = date('Y-m-d', strtotime(getNgayLink($gan->date) . ' +'.$gan->max.' days'));
//            }else{
//                $kq = Lottery::where('status', 1)->where('province_id', $gan->province_id)->where('date', '>', $gan->date)->orderBy('date','ASC')->take($gan->max)->get()->toArray();
//                $date_end = $kq[count($kq)-1]['date'];
////                echo $gan->date.'----------'.$gan->max.'----------'.$gan->province_id.'-------------'.$kq[count($kq)-1]['date'].'<br/>';
//            }
//            $gan->date_end = $date_end;
//            $gan->save();
//        }

        die('Xong!');
    }
}
