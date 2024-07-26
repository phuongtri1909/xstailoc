<?php

namespace App\Http\Controllers\Frontend;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use App\Models\Gan;
use Cache;
use Illuminate\Support\Facades\Storage;

class XsmbController extends Controller

{

    public function getKQXsmbNew()

    {
        set_time_limit(0);
        $kq = Storage::get('xsmb.txt');
//        $kq = $this->getKqXsmbKQVS();
        return $kq;

    }

    public function getKqXsmbKQVS()
    {
        $url = 'https://s5.ketquaveso.mobi/ttkq/json_kqmb/db16f65591d9a302bfe855750fdeb60e';
        $kq = requestvl($url);
        $kq = \GuzzleHttp\json_decode($kq, true);


        $CrDateTime = $kq['resultDate'];
        $date = date('Y-m-d', substr($CrDateTime, 0, strlen($CrDateTime) - 3));


        $day = getThuNumber($date);


// Thứ Hai: xổ số Thủ đô Hà Nội
        if ($day == 2) $province_id = 46;
// Thứ Ba: xổ số Quảng Ninh
        if ($day == 3) $province_id = 48;
//Thứ Tư: xổ số Bắc Ninh
        if ($day == 4) $province_id = 49;
//Thứ Năm: xổ số Thủ đô Hà Nội
        if ($day == 5) $province_id = 46;
//Thứ Sáu: xổ số Hải Phòng
        if ($day == 6) $province_id = 50;
//Thứ Bảy: xổ số Nam Định
        if ($day == 7) $province_id = 6;
//Chủ Nhật: xổ số Thái Bình
        if ($day == 8) $province_id = 47;


        $g = $kq['lotData'];


        $giai = array();


        foreach ($g['DB'] as $item) {
            if ($item == '' || $item == '.') $item = '...';
            $giai['DB'] = $item;
        }


        $maDB = '';
        if (isset($g['MaDb'])) {
            foreach ($g['MaDb'] as $item) {
                if ($item == '' || $item == '.') $item = '...';
                $maDB .= $item . '-';
            }
            $giai['MaDb'] = substr($maDB, 0, strlen($maDB) - 1);
        } else {
            $giai['MaDb'] = '...-...-...';
        }


//        $maDB = '';

//        foreach ($g['MaDb'] as $item) {

//            if ($item == '' || $item == '.') $item = '...';

//            $maDB .= $item . '-';

//        }

//        $giai['MaDb'] = substr($maDB, 0, strlen($maDB) - 1);


        for ($i = 1; $i <= 7; $i++) {
            $giai[$i] = '';
            foreach ($g[$i] as $item) {
                if ($item == '' || $item == '.') $item = '...';
                $giai[$i] .= $item . '-';
            }
            $giai[$i] = substr($giai[$i], 0, strlen($giai[$i]) - 1);
        }


        $status = 1;
        foreach ($giai as $item) {
            if (strpos($item, '...') !== false) {
                $status = 0;
                break;
            }
        }


        $kqxs = array();
        $kq = array();
        $g = array();
        $g[0]['Prize'] = 'DB';
        $g[0]['Range'] = themDauCach($giai['DB']);


        $g[1]['Prize'] = 'G.1';
        $g[1]['Range'] = themDauCach($giai[1]);;


        $g[2]['Prize'] = 'G.2';
        $g[2]['Range'] = themDauCach($giai[2]);;


        $g[3]['Prize'] = 'G.3';
        $g[3]['Range'] = themDauCach($giai[3]);;


        $g[4]['Prize'] = 'G.4';
        $g[4]['Range'] = themDauCach($giai[4]);;


        $g[5]['Prize'] = 'G.5';
        $g[5]['Range'] = themDauCach($giai[5]);;


        $g[6]['Prize'] = 'G.6';
        $g[6]['Range'] = themDauCach($giai[6]);;


        $g[7]['Prize'] = 'G.7';
        $g[7]['Range'] = themDauCach($giai[7]);;


        $kq['CrDateTime'] = getThu($day) . ', ' . getNgay($date);
        $kq['LotPrizes'] = $g;


        $dau = array();
        $xsStr = $giai['DB'] . '-' . $giai[1] . '-' . $giai[2] . '-' . $giai[3] . '-' . $giai[4] . '-' . $giai[5] . '-' . $giai[6] . '-' . $giai[7];
        $xsLoto = getLoto($xsStr);

//        $xsDau = getDauLive($xsLoto);
        $xsDau = getDau($xsLoto, substr($giai['DB'], strlen($giai['DB']) - 2, 2));


        $dau[0]['Head'] = 0;
        $dau[0]['Tail'] = $xsDau[0];
        $dau[1]['Head'] = 1;
        $dau[1]['Tail'] = $xsDau[1];
        $dau[2]['Head'] = 2;
        $dau[2]['Tail'] = $xsDau[2];
        $dau[3]['Head'] = 3;
        $dau[3]['Tail'] = $xsDau[3];
        $dau[4]['Head'] = 4;
        $dau[4]['Tail'] = $xsDau[4];
        $dau[5]['Head'] = 5;
        $dau[5]['Tail'] = $xsDau[5];
        $dau[6]['Head'] = 6;
        $dau[6]['Tail'] = $xsDau[6];
        $dau[7]['Head'] = 7;
        $dau[7]['Tail'] = $xsDau[7];
        $dau[8]['Head'] = 8;
        $dau[8]['Tail'] = $xsDau[8];
        $dau[9]['Head'] = 9;
        $dau[9]['Tail'] = $xsDau[9];


//        $xsDuoi = getDuoiLive($xsLoto);
        $xsDuoi = getDuoi($xsLoto, substr($giai['DB'], strlen($giai['DB']) - 2, 2));
        $duoi[0]['Head_D'] = 0;
        $duoi[0]['Tail_D'] = $xsDuoi[0];
        $duoi[1]['Head_D'] = 1;
        $duoi[1]['Tail_D'] = $xsDuoi[1];
        $duoi[2]['Head_D'] = 2;
        $duoi[2]['Tail_D'] = $xsDuoi[2];
        $duoi[3]['Head_D'] = 3;
        $duoi[3]['Tail_D'] = $xsDuoi[3];
        $duoi[4]['Head_D'] = 4;
        $duoi[4]['Tail_D'] = $xsDuoi[4];
        $duoi[5]['Head_D'] = 5;
        $duoi[5]['Tail_D'] = $xsDuoi[5];
        $duoi[6]['Head_D'] = 6;
        $duoi[6]['Tail_D'] = $xsDuoi[6];
        $duoi[7]['Head_D'] = 7;
        $duoi[7]['Tail_D'] = $xsDuoi[7];
        $duoi[8]['Head_D'] = 8;
        $duoi[8]['Tail_D'] = $xsDuoi[8];
        $duoi[9]['Head_D'] = 9;
        $duoi[9]['Tail_D'] = $xsDuoi[9];


        $province = Province::find($province_id);
        $kq['Lotos'] = $dau;
        $kq['Lotos_D'] = $duoi;
        $kq['LotteryCode'] = strtoupper($province->short_name);
        $kq['LotteryId'] = $province_id;
        $kq['LotteryName'] = 'Miền Bắc (' . $province->name . ')';
        $kq['OpenPrizeTime'] = '18h15';
        $kq['SpecialCodes'] = themDauCach($giai['MaDb']);
        $kq['Status'] = "$status";
        $kqxs[] = $kq;


        return json_encode($kqxs);

    }


    public function getXsmb()

    {
        $lastPage = Lottery::where('mien', 1)->orderBy('date', 'DESC')->paginate(7)->lastPage();
        $xsmbs = Lottery::where('mien', 1)->orderBy('date', 'DESC')->take(7)->get();

        $kqToDay = $this->checkKQToDay();
        return view('frontend.xsmb.xsmb', compact('xsmbs', 'lastPage', 'kqToDay'));

    }
    public function getXsmbXemThem()
    {
        $xsmbs = Lottery::where('mien', 1)->orderBy('date', 'DESC')->paginate(7);
        $dataReturn = [
            "template" => view('frontend.xsmb.block_xsmb', compact('xsmbs'))->render(),
        ];
        return json_encode($dataReturn);
    }

    public function getXsmbTrucTiep()

    {
        $date = date('Y-m-d', time());
        $xsmb = Lottery::where('mien', 1)->where('date', $date)->first();
        return view('frontend.xsmb.xsmb-truc-tiep', compact('xsmb'));

    }


    // xổ số miền bắc thứ 2

    public function getXsmbThu2()

    {
        return $this->getXsmbThu(2);

    }


    public function getXsmbThu3()

    {
        return $this->getXsmbThu(3);

    }


    public function getXsmbThu4()

    {
        return $this->getXsmbThu(4);

    }


    public function getXsmbThu5()

    {
        return $this->getXsmbThu(5);

    }


    public function getXsmbThu6()

    {
        return $this->getXsmbThu(6);

    }


    public function getXsmbThu7()

    {
        return $this->getXsmbThu(7);

    }


    public function getXsmbCN()

    {
        return $this->getXsmbThu(8);

    }


    public function getXsmbThu($day)

    {
        $lastPage = Lottery::where('mien', 1)->where('day', $day)->orderBy('date', 'DESC')->paginate(7)->lastPage();
        $xsmbs = Lottery::where('mien', 1)->where('day', $day)->orderBy('date', 'DESC')->take(7)->get();


        if ($day == 8) {
            $str_day = 'Chủ nhật';
            $str_day_kd = 'Chu nhat';
            $str_day_vt = 'CN';
        } else {
            $str_day = 'Thứ ' . $day;
            $str_day_kd = 'Thu ' . $day;
            $str_day_vt = 'T' . $day;
        }
        $meta_title = 'XSMB ' . $str_day . ' - Kết quả xổ số miền Bắc thứ  ' . $str_day . ' hàng tuần ';
        $meta_decription = 'XSMB ' . $str_day_kd . ' - Xổ số miền Bắc ' . $str_day . ' - hàng tuần vào lúc 18:15, KQXSMB ' . $str_day . ' - XSMB ' . $str_day . ' - SXMB ' . $str_day_kd . ' cập nhật chính xác nhất.';
        $meta_keyword = 'XSMB ' . $str_day_kd . ', SXMB ' . $str_day_kd . ', XSMB ' . $str_day_vt . ', KQXSMB ' . $str_day_kd . ', XSMB ' . $str_day_kd . ' Hang Tuan,xổ số miền Bắc ' . $str_day;


        $title = 'XSMB ' . $str_day . ' - xổ số miền Bắc ' . $str_day . ' hàng tuần - SXMB ' . $str_day_kd;
        $kqToDay = $this->checkKQToDay();

//        $viewGan = $this->getTKLoGan();

//        $xsmb_first = Lottery::where('mien', 1)->where('day', $day)->orderBy('date', 'DESC')->first();

//        $arr_tkkqmb = $this->thongKe($xsmb_first);
        return view('frontend.xsmb.xsmb-thu', compact('xsmbs', 'lastPage', 'kqToDay', 'day', 'str_day', 'title', 'meta_title', 'meta_decription', 'meta_keyword'));

    }


    public function getXsmbXemThemTheoThu(Request $request)

    {
        $day = $request->day;
        $xsmbs = Lottery::where('mien', 1)->where('day', $day)->orderBy('date', 'DESC')->paginate(7);
        $dataReturn = [
            "template" => view('frontend.xsmb.block_xsmb_thu', compact('xsmbs'))->render(),
        ];
        return json_encode($dataReturn);

    }


    public function getXsmbDate($date)

    {
        $date_arr = explode('-',$date);
        if(!checkdate($date_arr[1],$date_arr[0],$date_arr[2])){
            return view('errors.404');
        }

        $date_1 = $date;
        $date_2 = str_replace('-', '/', $date);
        $date = getNgayLink($date);

        if ($date > date('Y-m-d',strtotime("+2 days"))){
            return view('errors.404');
        }

        $xsmb = Lottery::where('mien', 1)->where('date', $date)->first();

//        if (empty($xsmb)) return view('errors.404');

        $xsmb_next = Lottery::where('mien', 1)->where('date', '>', $date)->orderBy('date', 'ASC')->first();
        $xsmb_pre = Lottery::where('mien', 1)->where('date', '<', $date)->orderBy('date', 'DESC')->first();


        $meta_title = 'XSMB ' . $date_2 . ' - Kết quả xổ số Miền Bắc ngày ' . $date_1;
        $meta_decription = 'XSMB ' . $date_2 . ' ✅ - Xổ số Miền Bắc ngày ' . $date_1 . ' - SXMB ' . $date_2 . '.Tường thuật kết quả Xổ số Miền Bắc từ trường quay nhanh, chính xác nhất';
        $meta_keyword = 'xsmb ' . $date_2 . ', xsmb ' . $date_1 . ', xsmb' . $date_2 . ', xsmb ngay ' . $date_2 . ', xsmb' . $date_1 . ', xsmb ngay ' . $date_1 . ', xo so mien bac ' . $date_2 . ', kqxsmb ' . $date_2 . ', xổ số miền bắc ' . $date_2 . ', ket qua xo so mien bac ' . $date_2 . ', xo so mb ' . $date_2 . '';

        $gan_arr = $this->getTKLoGan($date);
        $ArrayCollect = $gan_arr['ArrayCollect'];
        $ArrayCollect_cap = $gan_arr['ArrayCollect_cap'];
        $maxgan = $gan_arr['maxgan'];
        $maxgan_cap = $gan_arr['maxgan_cap'];

//        $arr_tkkqmb = $this->thongKe($xsmb);
        return view('frontend.xsmb.xsmb-date', compact('xsmb', 'xsmb_next', 'xsmb_pre', 'meta_title', 'meta_decription', 'meta_keyword', 'date', 'date_2','ArrayCollect', 'ArrayCollect_cap', 'maxgan', 'maxgan_cap'));

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


    public function getSKQ()

    {
        $n = 30;
        $xsmbs = Lottery::where('mien', 1)->orderBy('date', 'DESC')->take($n)->get();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();


        $meta_title = "Sổ Kết Quả XSMB $n Ngày - Kết Quả Xổ Số Miền Bắc $n Ngày Gần Nhất";
        $meta_decription = "XSMB $n ngày - XSTD $n ngày gần đây ✅ -  KQXSMB $n ngày - kết quả xổ số miền Bắc $n ngày gần nhất.Cập nhật chi tiết và đầy đủ nhất kết quả xổ số kiến thiết Miền Bắc trong $n ngày trở lại đây";
        $meta_keyword = "xsmb $n ngay, xstd $n ngay, xsmb $n ngày, kqxsmb $n ngay, xstd $n ngày, xo so mien bac $n ngay";


        $title = "Sổ kết quả";
        return view('frontend.xsmb.so-ket-qua', compact('xsmbs', 'provinces', 'n', 'meta_title', 'meta_decription', 'meta_keyword', 'title'));

    }


    public function getXsmbNgay($n)

    {
        $xsmbs = Lottery::where('mien', 1)->orderBy('date', 'DESC')->take($n)->get();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();


        $meta_title = "XSMB $n Ngày - KQXSMB $n Ngày - Xổ Số Miền Bắc $n Ngày Gần Đây";
        $meta_decription = "XSMB $n ngày - XSTD $n ngày gần đây ✅ -  KQXSMB $n ngày - kết quả xổ số miền Bắc $n ngày gần nhất.Cập nhật chi tiết và đầy đủ nhất kết quả xổ số kiến thiết Miền Bắc trong $n ngày trở lại đây";
        $meta_keyword = "xsmb $n ngay, xstd $n ngay, xsmb $n ngày, kqxsmb $n ngay, xstd $n ngày, xo so mien bac $n ngay";


        $title = "XSMB $n Ngày";
        return view('frontend.xsmb.so-ket-qua', compact('xsmbs', 'provinces', 'n', 'meta_title', 'meta_decription', 'meta_keyword', 'title'));

    }


    public function postSKQ(Request $request)

    {
        $tinh = $request->tinh;
        $date = getNgaycheo($request->date);
        $n = $request->count;


        if ($tinh == route('xsmb.skq')) {
            $kqxs = Lottery::where('mien', 1)->where('date', '<=', $date)->orderBy('date', 'DESC')->take($n)->get();
            $view = view('frontend.soketqua.block_xsmb_n_ngay', compact('kqxs', 'n'))->render();
        } elseif ($tinh == route('xsmt.skq')) {
            $list_day = Lottery::where('mien', 2)->where('date', '<=', $date)->select('date')->orderBy('date', 'DESC')->distinct()->take($n)->get();
            $kqxsmts = array();
            foreach ($list_day as $item) {
                $kqxsmts[$item->date] = Lottery::where('mien', 2)->where('date', $item->date)->get();
            }
            $view = view('frontend.soketqua.block_xsmt_n_ngay', compact('kqxsmts', 'n'))->render();
        } elseif ($tinh == route('xsmn.skq')) {
            $list_day = Lottery::where('mien', 3)->where('date', '<=', $date)->select('date')->orderBy('date', 'DESC')->distinct()->take($n)->get();
            $kqxsmns = array();
            foreach ($list_day as $item) {
                $kqxsmns[$item->date] = Lottery::where('mien', 3)->where('date', $item->date)->get();
            }
            $view = view('frontend.soketqua.block_xsmn_n_ngay', compact('kqxsmns', 'n'))->render();
        } else {
            $kqxs = Lottery::where('province_id', $tinh)->where('date', '<=', $date)->orderBy('date', 'DESC')->take($n)->get();
            $province = Province::find($tinh);
            $view = view('frontend.soketqua.block_tinh_n_ngay', compact('province', 'kqxs', 'n'))->render();
        }
        $dataReturn = [
            "template" => $view
        ];
        return json_encode($dataReturn);

    }

    public function getTKLoGan($date)
    {
        $province_id = 46;
        $kqs = Lottery::where('mien', 1)->where('status', 1)->where('date','<=', $date)->orderBy('date', 'DESC')->take(30)->get();
        //tạo mảng bộ số từ 00->99
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
                $ArrayCollect_cap[$i][1] = '';// ngày về gần nhất
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
            for ($t = 0;
                 $t < $len_collect;
                 $t++) {
                if (in_array($ArrayCollect[$t][0], $arr_kq)) {
                    if ($ArrayCollect[$t][2] == -1) {
                        $ArrayCollect[$t][1] = getNgay($kq->date);                /*Tinh so ngay chua ve*/
                        $ArrayCollect[$t][2] = $number_date;
                    }
                }
            }
            for ($t = 0; $t < $len_collect_cap; $t++) {
                if (in_array($ArrayCollect_cap[$t][0], $arr_kq) || in_array(lon($ArrayCollect_cap[$t][0]), $arr_kq)) {
                    if ($ArrayCollect_cap[$t][2] == -1) {
                        $ArrayCollect_cap[$t][1] = getNgay($kq->date);                /*Tinh so ngay chua ve*/
                        $ArrayCollect_cap[$t][2] = $number_date;
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

        for ($e = 0; $e < $len_collect_cap - 1; $e++) {
            for ($f = $e + 1; $f < $len_collect_cap; $f++) {
                if ($ArrayCollect_cap[$e][2] < $ArrayCollect_cap[$f][2]) {
                    swap($ArrayCollect_cap[$e][2], $ArrayCollect_cap[$f][2]);
                    swap($ArrayCollect_cap[$e][0], $ArrayCollect_cap[$f][0]);
                    swap($ArrayCollect_cap[$e][1], $ArrayCollect_cap[$f][1]);
                }
            }
        }
        $maxgan = array();
        $kqgan = Gan::where('province_id', $province_id)->where('type', 1)->orderBy('max', 'DESC')->get();
        foreach ($kqgan as $item) {
            $maxgan[$item->loto] = $item->max;
        }
        $maxgan_cap = array();
        $kqgan_cap = Gan::where('province_id', $province_id)->where('type', 2)->orderBy('max', 'DESC')->get();
        foreach ($kqgan_cap as $item) {
            $maxgan_cap[$item->loto] = $item->max;
        }
        return [
            'ArrayCollect' => $ArrayCollect,
            'ArrayCollect_cap' => $ArrayCollect_cap,
            'maxgan' => $maxgan,
            'maxgan_cap' => $maxgan_cap
        ];
    }

}

