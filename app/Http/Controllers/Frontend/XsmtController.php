<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Province;
use Cache;
use Illuminate\Support\Facades\Storage;
class XsmtController extends Controller
{
    public function getKQXsmtNew()
    {
        set_time_limit(0);
        $kq = Storage::get('xsmt.txt');
//        $kq = $this->getKqXsmtKQVS();
        return $kq;
    }

    public function getKqXsmtKQVS()

    {
        $url = 'https://s4.ketquaveso.mobi/ttkq/json_kqmt/0fb41e71bc903b627e9842ff5e6f2901';
        $kqs = requestvl($url);


        if (empty($kqs)) {
            $rootPath = 'https://live.xosodaiphat.com/lotteryLive/3';
            $kqs = requestvl($rootPath);
            return $kqs;
        }


        $kqs = \GuzzleHttp\json_decode($kqs, true);


        $kqxs = array();
        foreach ($kqs as $kq) {
            $CrDateTime = $kq['resultDate'];
            $date = date('Y-m-d', substr($CrDateTime, 0, strlen($CrDateTime) - 3));


            // nếu đã lấy xong thì thoát

//            $count = Lottery::where('mien', 2)->where('date', $date)->where('status', 1)->count();

//            if ($count == count($kqs)) return;


            $day = getThuNumber($date);


            $short_name = strtolower($kq['provinceCode']);
            if ($short_name == 'bt') $short_name = 'btr';
            if ($short_name == 'qnm') $short_name = 'qna';
            if ($short_name == 'dng') $short_name = 'dna';
            $province = Province::where('short_name', $short_name)->first();


            $g = $kq['lotData'];


            $giai = array();


            foreach ($g['DB'] as $item) {
                if ($item == '' || $item == '.') $item = '...';
                $giai['DB'] = $item;
            }


            for ($i = 1; $i <= 8; $i++) {
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


            $kq = array();
            $g = array();
            $g[0]['Prize'] = 'G.8';
            $g[0]['Range'] = themDauCach($giai[8]);


            $g[1]['Prize'] = 'G.7';
            $g[1]['Range'] = themDauCach($giai[7]);


            $g[2]['Prize'] = 'G.6';
            $g[2]['Range'] = themDauCach($giai[6]);


            $g[3]['Prize'] = 'G.5';
            $g[3]['Range'] = themDauCach($giai[5]);


            $g[4]['Prize'] = 'G.4';
            $g[4]['Range'] = themDauCach($giai[4]);


            $g[5]['Prize'] = 'G.3';
            $g[5]['Range'] = themDauCach($giai[3]);


            $g[6]['Prize'] = 'G.2';
            $g[6]['Range'] = themDauCach($giai[2]);


            $g[7]['Prize'] = 'G.1';
            $g[7]['Range'] = themDauCach($giai[1]);


            $g[8]['Prize'] = 'DB6';
            $g[8]['Range'] = themDauCach($giai['DB']);


            $kq['CrDateTime'] = getThu($day) . ', ' . getNgay($date);
            $kq['LotPrizes'] = $g;


            $dau = array();
            $xsStr = $giai['DB'] . '-' . $giai[1] . '-' . $giai[2] . '-' . $giai[3] . '-' . $giai[4] . '-' . $giai[5] . '-' . $giai[6] . '-' . $giai[7] . '-' . $giai[8];
            $xsLoto = getLoto($xsStr);

//            $xsDau = getDauLive($xsLoto);
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


            $kq['Lotos'] = $dau;
            $kq['Lotos_D'] = $duoi;
            $kq['LotteryCode'] = strtoupper($province->short_name);
            $kq['LotteryId'] = $province->id;
            $kq['LotteryName'] = $province->name;
            $kq['OpenPrizeTime'] = '17h15';
            $kq['SpecialCodes'] = '';
            $kq['Status'] = "$status";
            $kqxs[] = $kq;
        }
        return json_encode($kqxs);

    }


    public function getKQXsmtDB()

    {
// xổ số miền name
        $xsmt = Lottery::where('mien', 2)->orderBy('date', 'DESC')->first();
        $xsmts = Lottery::where('mien', 2)->where('date', $xsmt->date)->get();
        $kqxs = array();
        foreach ($xsmts as $xs) {
            $kq = array();
            $g = array();
            $g[0]['Prize'] = 'G.8';
            $g[0]['Range'] = themDauCach($xs->g8);


            $g[1]['Prize'] = 'G.7';
            $g[1]['Range'] = themDauCach($xs->g7);


            $g[2]['Prize'] = 'G.6';
            $g[2]['Range'] = themDauCach($xs->g6);


            $g[3]['Prize'] = 'G.5';
            $g[3]['Range'] = themDauCach($xs->g5);


            $g[4]['Prize'] = 'G.4';
            $g[4]['Range'] = themDauCach($xs->g4);


            $g[5]['Prize'] = 'G.3';
            $g[5]['Range'] = themDauCach($xs->g3);


            $g[6]['Prize'] = 'G.2';
            $g[6]['Range'] = themDauCach($xs->g2);


            $g[7]['Prize'] = 'G.1';
            $g[7]['Range'] = themDauCach($xs->g1);


            $g[8]['Prize'] = 'DB6';
            $g[8]['Range'] = themDauCach($xs->gdb);


            $kq['CrDateTime'] = getThu($xs->day) . ', ' . getNgay($xs->date);
            $kq['LotPrizes'] = $g;


            $dau = array();
            $xsStr = $xs->gdb . '-' . $xs->g1 . '-' . $xs->g2 . '-' . $xs->g3 . '-' . $xs->g4 . '-' . $xs->g5 . '-' . $xs->g6 . '-' . $xs->g7 . '-' . $xs->g8;
            $xsLoto = getLoto($xsStr);
            $xsDau = getDauLive($xsLoto);


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


            $kq['Lotos'] = $dau;
            $kq['LotteryCode'] = strtoupper($xs->province->short_name);
            $kq['LotteryId'] = $xs->province_id;
            $kq['LotteryName'] = $xs->province->name;
            $kq['OpenPrizeTime'] = '17h15';
            $kq['SpecialCodes'] = '';
            $kq['Status'] = "$xs->status";
            $kqxs[] = $kq;
        }


        print_ok($kqxs);
        die();
        return json_encode($kqxs);

    }


    public function getKQXsmtHTML()

    {
        set_time_limit(0);
        $ngay_quay = date('Y-m-d');
        $date_url = date('d-m-Y');


        $url = 'https://xosodaiphat.com/xsmt-' . $date_url . '.html';
        $html = str_get_html(requestvl($url));
        if (count($html->find('.table-xsmn')) == 0) return;
        $count = count($html->find('.table-xsmn th'));


        $kqxs = array();
        for ($i = 1; $i < $count; $i++) {
            $k = 0;
            $sxmn = array();
            $slug = '';
            foreach ($html->find('.table-xsmn tr') as $tr) {
                if ($k == 0) {
                    $link = trim($tr->find('th', $i)->find('a', 0)->href);
                    $slug = trim(substr($link, 3, strlen($link) - 8));
                    $k++;
                    continue;
                }
                $g = '';
                foreach ($tr->find('td', $i)->find('span') as $span) {
                    $g .= trim($span->innertext) . '-';
                }
                $sxmn[] = substr($g, 0, strlen($g) - 1);


            }
            $province = Province::where('slug', $slug)->first();
            $day = getThuNumber($ngay_quay);


            $status = 1;
            foreach ($sxmn as $item) {
                if (strpos($item, '...') !== false) {
                    $status = 0;
                    break;
                }
            }


            $kq = array();
            $g = array();
            $g[0]['Prize'] = 'G.8';
            $g[0]['Range'] = themDauCach($sxmn[0]);


            $g[1]['Prize'] = 'G.7';
            $g[1]['Range'] = themDauCach($sxmn[1]);


            $g[2]['Prize'] = 'G.6';
            $g[2]['Range'] = themDauCach($sxmn[2]);


            $g[3]['Prize'] = 'G.5';
            $g[3]['Range'] = themDauCach($sxmn[3]);


            $g[4]['Prize'] = 'G.4';
            $g[4]['Range'] = themDauCach($sxmn[4]);


            $g[5]['Prize'] = 'G.3';
            $g[5]['Range'] = themDauCach($sxmn[5]);


            $g[6]['Prize'] = 'G.2';
            $g[6]['Range'] = themDauCach($sxmn[6]);


            $g[7]['Prize'] = 'G.1';
            $g[7]['Range'] = themDauCach($sxmn[7]);


            $g[8]['Prize'] = 'DB6';
            $g[8]['Range'] = themDauCach($sxmn[8]);


            $kq['CrDateTime'] = getThu($day) . ', ' . getNgay($ngay_quay);
            $kq['LotPrizes'] = $g;


            $dau = array();
            $xsStr = $sxmn[8] . '-' . $sxmn[7] . '-' . $sxmn[6] . '-' . $sxmn[5] . '-' . $sxmn[4] . '-' . $sxmn[3] . '-' . $sxmn[2] . '-' . $sxmn[1] . '-' . $sxmn[0];
            $xsLoto = getLoto($xsStr);
            $xsDau = getDauLive($xsLoto);


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


            $kq['Lotos'] = $dau;
            $kq['LotteryCode'] = strtoupper($province->short_name);
            $kq['LotteryId'] = $province->id;
            $kq['LotteryName'] = $province->name;
            $kq['OpenPrizeTime'] = '17h15';
            $kq['SpecialCodes'] = '';
            $kq['Status'] = "$status";
            $kqxs[] = $kq;
        }
        return json_encode($kqxs);

    }


    public function getXsmt()

    {
// lấy tổng số page
        $total = Lottery::where('mien', 2)->select('date')->orderBy('date', 'DESC')->distinct()->get()->toArray();
        $lastPage = floor(count($total) / 7);


// lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 2)->select('date')->orderBy('date', 'DESC')->distinct()->take(7)->get();


        $kqxsmts = array();
        foreach ($list_7day as $item) {
            $kqxsmts[$item->date] = Lottery::where('mien', 2)->where('date', $item->date)->orderBy('province_id')->get();
        }


        $kqToDay = $this->checkKQToDay();


        $day = getThuNumber(date('Y-m-d'));
        $arr_province = Province::where('mien', 2)->where('ngay_quay', 'like', '%' . $day . '%')->get();
        return view('frontend.xsmt.xsmt', compact('kqxsmts', 'lastPage', 'kqToDay', 'arr_province'));

    }


    public function getXsmtXemThem(Request $request)
    {
        $skip = $request->skip;

// lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 2)->select('date')->orderBy('date', 'DESC')->distinct()->skip($skip)->take(7)->get();

        $kqxsmts = array();
        foreach ($list_7day as $item) {
            $kqxsmts[$item->date] = Lottery::where('mien', 2)->where('date', $item->date)->orderBy('province_id')->get();
        }
        $dataReturn = [
            "template" => view('frontend.xsmt.block_xsmt', compact('kqxsmts'))->render(),
        ];
        return json_encode($dataReturn);

    }

    // xổ số miền bắc thứ 2

    public function getXsmtThu2()

    {
        return $this->getXsmtThu(2);

    }


    public function getXsmtThu3()

    {
        return $this->getXsmtThu(3);

    }


    public function getXsmtThu4()

    {
        return $this->getXsmtThu(4);

    }


    public function getXsmtThu5()

    {
        return $this->getXsmtThu(5);

    }


    public function getXsmtThu6()

    {
        return $this->getXsmtThu(6);

    }


    public function getXsmtThu7()

    {
        return $this->getXsmtThu(7);

    }


    public function getXsmtCN()

    {
        return $this->getXsmtThu(8);

    }


    public function getXsmtThu($day)
    {
        // lấy tổng số page
        $total = Lottery::where('mien', 2)->where('day', $day)->select('date')->orderBy('date', 'DESC')->distinct()->get()->toArray();
        $lastPage = floor(count($total) / 7);


        // lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 2)->where('day', $day)->select('date')->orderBy('date', 'DESC')->distinct()->take(7)->get();


        $kqxsmts = array();
        foreach ($list_7day as $item) {
            $kqxsmts[$item->date] = Lottery::where('mien', 2)->where('day', $day)->where('date', $item->date)->orderBy('province_id')->get();
        }
        $kqToDay = $this->checkKQToDay();
        if ($day == 8) {
            $str_day = 'Chủ nhật';
            $str_day_kd = 'Chu nhat';
            $str_day_vt = 'CN';
        } else {
            $str_day = 'Thứ ' . $day;
            $str_day_kd = 'Thu ' . $day;
            $str_day_vt = 'T' . $day;
        }
        $meta_title = 'XSMT ' . $str_day . ' - Kết quả xổ số miền Trung ' . $str_day . ' hàng Tuần';
        $meta_decription = 'XSMT ' . $str_day_kd . ' - Xổ số miền Trung ' . $str_day . ' hàng tuần vào lúc 17:15, KQXSMT ' . $str_day . ' - XSMT ' . $str_day_kd . ' - SXMT ' . $str_day_kd . ' cập nhật chính xác nhất.';
        $meta_keyword = 'XSMT ' . $str_day_kd . ', SXMT ' . $str_day_kd . ', XSMT ' . $str_day_vt . ', KQXSMT ' . $str_day_kd . ', XSMT ' . $str_day_kd . ' Hang Tuan,xổ số miền Trung ' . $str_day;

        $title = 'XSMT ' . $str_day . ' - Xổ số miền Trung ' . $str_day . ' hàng tuần - SXMT ' . $str_day_kd;

        $province_mt = Province::where('mien',2)->where('ngay_quay', 'like', '%' . $day . '%')->get();
        return view('frontend.xsmt.xsmt-thu', compact('kqxsmts', 'lastPage', 'kqToDay', 'day', 'str_day', 'province_mt', 'title', 'meta_title', 'meta_decription', 'meta_keyword'));
    }


    public function getXsmtXemThemTheoThu(Request $request)

    {
        $skip = $request->skip;
        $day = $request->day;

        // lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 2)->where('day', $day)->select('date')->orderBy('date', 'DESC')->distinct()->skip($skip)->take(7)->get();

        $kqxsmts = array();
        foreach ($list_7day as $item) {
            $kqxsmts[$item->date] = Lottery::where('mien', 2)->where('day', $day)->where('date', $item->date)->orderBy('province_id')->get();
        }
        $dataReturn = [
            "template" => view('frontend.xsmt.block_xsmt', compact('kqxsmts'))->render(),
        ];
        return json_encode($dataReturn);

    }


    public function getXsmtDate($date)

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
        $xsmt_next = Lottery::where('mien', 2)->where('date', '>', $date)->orderBy('date', 'ASC')->first();
        $xsmt_pre = Lottery::where('mien', 2)->where('date', '<', $date)->orderBy('date', 'DESC')->first();
        $xsmts = Lottery::where('mien', 2)->where('date', $date)->orderBy('province_id')->get();


        $meta_title = 'XSMT ' . $date_2 . ' - Kết quả xổ số Miền Trung ngày ' . $date_1;
        $meta_decription = 'XSMT ' . $date_2 . ' ✅ - Xổ số Miền Trung ngày ' . $date_1 . ' - SXMT ' . $date_2 . '.Tường thuật kết quả Xổ số Miền Trung từ trường quay nhanh, chính xác nhất';
        $meta_keyword = 'xsmt ' . $date_2 . ', xsmt ' . $date_1 . ', xsmt' . $date_2 . ', xsmt ngay ' . $date_2 . ', xsmt' . $date_1 . ', xsmt ngay ' . $date_1 . ', xo so mien trung ' . $date_2 . ', kqxsmt ' . $date_2 . ', xổ số miền trung ' . $date_2 . ', ket qua xo so mien trung ' . $date_2 . ', xo so mt ' . $date_2 . '';

        $tkGan = array();
        $tkLoto = array();
        $tkDB = array();
        $tkVitri = array();

        // list xs miền nam
        $day = getThuNumber($date);
        $province_mt = Province::where('mien', 2)->where('ngay_quay', 'like', '%' . $day . '%')->get();
        foreach ($province_mt as $pro) {
            $kqs = Lottery::where('province_id', $pro->id)->where('status', 1)->where('date','<=',$date)->orderBy('date', 'DESC')->take(30)->get();

            $tk_arr = $this->getTKLoto($kqs);
            $tkdb_arr = $this->getTKLoto($kqs,2);
            $tkGan[$pro->short_name] = $tk_arr['gan'];
            $tkLoto[$pro->short_name] = $tk_arr['tan_suat'];
            $tkDB[$pro->short_name] = $tkdb_arr['tan_suat'];
            //$tkVitri[$pro->short_name] = $this->getCauBachThu($pro->id,$date);

        }

        return view('frontend.xsmt.xsmt-date', compact('xsmts', 'meta_title', 'meta_decription', 'meta_keyword', 'date', 'date_2','tkGan','tkLoto','tkDB','tkVitri','province_mt','xsmt_next','xsmt_pre'));
    }


    public function checkKQToDay()

    {
        $date = date('Y-m-d', time());
        $xsmts = Lottery::where('mien', 2)->where('date', $date)->get();
        if (count($xsmts) > 0) {
            return true;
        } else {
            return false;
        }

    }


    public function getXsmtNgay($n)

    {
// lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 2)->select('date')->orderBy('date', 'DESC')->distinct()->take($n)->get();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();


        $kqxsmts = array();
        foreach ($list_7day as $item) {
            $kqxsmts[$item->date] = Lottery::where('mien', 2)->where('date', $item->date)->orderBy('province_id')->get();
        }


        $meta_title = "XSMT $n Ngày - KQXSMT $n Ngày - Xổ Số Miền Trung $n Ngày Gần Đây";
        $meta_decription = "XSMT $n ngày ✅ -  KQXSMT $n ngày - kết quả xổ số miền Trung $n ngày gần nhất.Cập nhật chi tiết và đầy đủ nhất kết quả xổ số kiến thiết Miền Trung trong $n ngày trở lại đây";
        $meta_keyword = "xsmt $n ngay, xsmt $n ngày, kqxsmt $n ngay, xo so mien trung $n ngay";


        $title = "XSMT $n Ngày";
        return view('frontend.xsmt.so-ket-qua', compact('kqxsmts', 'provinces', 'n', 'meta_title', 'meta_decription', 'meta_keyword', 'title'));

    }


    public function getSKQ()

    {
        $n = 30;
// lấy mảng kết quả 7 ngày
        $list_7day = Lottery::where('mien', 2)->select('date')->orderBy('date', 'DESC')->distinct()->take($n)->get();
        $provinces = Province::where('mien', 3)->orWhere('mien', 2)->get();


        $kqxsmts = array();
        foreach ($list_7day as $item) {
            $kqxsmts[$item->date] = Lottery::where('mien', 2)->where('date', $item->date)->orderBy('province_id')->get();
        }


        $meta_title = "XSMT $n Ngày - KQXSMT $n Ngày - Xổ Số Miền Trung $n Ngày Gần Đây";
        $meta_decription = "XSMT $n ngày ✅ -  KQXSMT $n ngày - kết quả xổ số miền Trung $n ngày gần nhất.Cập nhật chi tiết và đầy đủ nhất kết quả xổ số kiến thiết Miền Trung trong $n ngày trở lại đây";
        $meta_keyword = "xsmt $n ngay, xsmt $n ngày, kqxsmt $n ngay, xo so mien trung $n ngay";


        $title = "Sổ kết quả";
        return view('frontend.xsmt.so-ket-qua', compact('kqxsmts', 'provinces', 'n', 'meta_title', 'meta_decription', 'meta_keyword', 'title'));

    }


    public function getTKLoto($kqs, $type = 1)
    {
        // tạo mảng bộ số từ 00->99
        $ArrayCollect = array();
        $ArrayCollect_Gan = array();
        for ($i = 0; $i < 100; $i++) {
            if ($i < 10) {
                $ArrayCollect_Gan[$i][0] = '0' . $i;
                $ArrayCollect[$i][0] = '0' . $i;
            } else {
                $ArrayCollect_Gan[$i][0] = $i;
                $ArrayCollect[$i][0] = $i;
            }
            $ArrayCollect_Gan[$i][1] = ''; // ngày về gần nhất
            $ArrayCollect_Gan[$i][2] = -1; // số ngày chưa về

            $ArrayCollect[$i][1] = 0; // Tổng số lần xuất hiện

        }
        $number_date = 0;

        foreach ($kqs as $kq) {
            if ($type == 1) {
                $tmp_result = $kq->gdb . '-' . $kq->g1 . '-' . $kq->g2 . '-' . $kq->g3 . '-' . $kq->g4 . '-' . $kq->g5 . '-' . $kq->g6 . '-' . $kq->g7 . '-' . $kq->g8;
            } else {
                $tmp_result = $kq->gdb;
            }
            $arr_kq = getLoto($tmp_result);
            for ($t = 0; $t < 100; $t++) {
                if (in_array($ArrayCollect_Gan[$t][0], $arr_kq)) {
                    if ($ArrayCollect_Gan[$t][2] == -1) {
                        $ArrayCollect_Gan[$t][1] = getNgay($kq->date);
                        /*Tinh so ngay chua ve*/
                        $ArrayCollect_Gan[$t][2] = $number_date;
                    }
                }
                // đếm tổng số lần xuất hiện
                $ArrayCollect[$t][1] += solan_xuathien_trongngay($ArrayCollect[$t][0], $arr_kq);

            }
            $number_date++;
        }

        for ($e = 0; $e < 99; $e++) {
            for ($f = $e + 1; $f < 100; $f++) {
                if ($ArrayCollect_Gan[$e][2] < $ArrayCollect_Gan[$f][2]) {
                    swap($ArrayCollect_Gan[$e][2], $ArrayCollect_Gan[$f][2]);
                    swap($ArrayCollect_Gan[$e][0], $ArrayCollect_Gan[$f][0]);
                    swap($ArrayCollect_Gan[$e][1], $ArrayCollect_Gan[$f][1]);
                }
            }
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

        return [
            'gan' => $ArrayCollect_Gan,
            'tan_suat' => $ArrayCollect
        ];
    }

    public function getCauBachThu($province_id,$date)
    {
        $province = Province::find($province_id);

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

        $cau_list = array();
        foreach($cau as $key=>$value){
            if(count($value) >0 && $key >= 2){
                foreach($value as $item){
                    $cau_list[]=$item;
                }
            }
        }

        return $cau_list;
    }

}

