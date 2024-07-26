<?php

namespace App\Http\Controllers\Craw;

use App\Models\Lottery;
use App\Models\Province;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrawAllController extends Controller
{
    public function checkMaTinh()
    {
        $str = '<tr class="gr-yellow">

    <th><a href="/mien-nam/kqxshcm-sxhcm-ket-qua-xo-so-thanh-pho-ho-chi-minh-p14.html" title="XSHCM"><b
                    class="underline">TP Hồ Chí Minh</b></a><br><span class="s12">Mã: HCM</span></th>
    <th><a href="/mien-nam/kqxsdt-sxdt-ket-qua-xo-so-dong-thap-p12.html" title="XSDT"><b class="underline">Đồng Tháp</b></a><br><span
                class="s12">Mã: DT</span></th>
    <th><a href="/mien-nam/kqxscm-sxcm-ket-qua-xo-so-ca-mau-p8.html" title="XSCM"><b class="underline">Cà
                Mau</b></a><br><span class="s12">Mã: CM</span></th>
</tr>
<tr class="gr-yellow"><th><a href="/mien-nam/kqxsbt-sxbt-ket-qua-xo-so-ben-tre-p4.html" title="XSBT"><b class="underline">Bến Tre</b></a><br><span class="s12">Mã: BT</span></th><th><a href="/mien-nam/kqxsvt-sxvt-ket-qua-xo-so-vung-tau-p22.html" title="XSVT"><b class="underline">Vũng Tàu</b></a><br><span class="s12">Mã: VT</span></th><th><a href="/mien-nam/kqxsbl-sxbl-ket-qua-xo-so-bac-lieu-p3.html" title="XSBL"><b class="underline">Bạc Liêu</b></a><br><span class="s12">Mã: BL</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-nam/kqxsdn-sxdn-ket-qua-xo-so-dong-nai-p11.html" title="XSDN"><b class="underline">Đồng Nai</b></a><br><span class="s12">Mã: DN</span></th><th><a href="/mien-nam/kqxsct-sxct-ket-qua-xo-so-can-tho-p9.html" title="XSCT"><b class="underline">Cần Thơ</b></a><br><span class="s12">Mã: CT</span></th><th><a href="/mien-nam/kqxsst-sxst-ket-qua-xo-so-soc-trang-p17.html" title="XSST"><b class="underline">Sóc Trăng</b></a><br><span class="s12">Mã: ST</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-nam/kqxstn-sxtn-ket-qua-xo-so-tay-ninh-p18.html" title="XSTN"><b class="underline">Tây Ninh</b></a><br><span class="s12">Mã: TN</span></th><th><a href="/mien-nam/kqxsag-sxag-ket-qua-xo-so-an-giang-p2.html" title="XSAG"><b class="underline">An Giang</b></a><br><span class="s12">Mã: AG</span></th><th><a href="/mien-nam/kqxsbth-sxbth-ket-qua-xo-so-binh-thuan-p7.html" title="XSBTH"><b class="underline">Bình Thuận</b></a><br><span class="s12">Mã: BTH</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-nam/kqxsvl-sxvl-ket-qua-xo-so-vinh-long-p21.html" title="XSVL"><b class="underline">Vĩnh Long</b></a><br><span class="s12">Mã: VL</span></th><th><a href="/mien-nam/kqxsbd-sxbd-ket-qua-xo-so-binh-duong-p5.html" title="XSBD"><b class="underline">Bình Dương</b></a><br><span class="s12">Mã: BD</span></th><th><a href="/mien-nam/kqxstv-sxtv-ket-qua-xo-so-tra-vinh-p20.html" title="XSTV"><b class="underline">Trà Vinh</b></a><br><span class="s12">Mã: TV</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-nam/kqxshcm-sxhcm-ket-qua-xo-so-thanh-pho-ho-chi-minh-p14.html" title="XSHCM"><b class="underline">TP Hồ Chí Minh</b></a><br><span class="s12">Mã: HCM</span></th><th><a href="/mien-nam/kqxsla-sxla-ket-qua-xo-so-long-an-p16.html" title="XSLA"><b class="underline">Long An</b></a><br><span class="s12">Mã: LA</span></th><th><a href="/mien-nam/kqxsbp-sxbp-ket-qua-xo-so-binh-phuoc-p6.html" title="XSBP"><b class="underline">Bình Phước</b></a><br><span class="s12">Mã: BP</span></th><th><a href="/mien-nam/kqxshg-sxhg-ket-qua-xo-so-hau-giang-p13.html" title="XSHG"><b class="underline">Hậu Giang</b></a><br><span class="s12">Mã: HG</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-nam/kqxstg-sxtg-ket-qua-xo-so-tien-giang-p19.html" title="XSTG"><b class="underline">Tiền Giang</b></a><br><span class="s12">Mã: TG</span></th><th><a href="/mien-nam/kqxskg-sxkg-ket-qua-xo-so-kien-giang-p15.html" title="XSKG"><b class="underline">Kiên Giang</b></a><br><span class="s12">Mã: KG</span></th><th><a href="/mien-nam/kqxsdl-sxdl-ket-qua-xo-so-da-lat-p10.html" title="XSDL"><b class="underline">Đà Lạt</b></a><br><span class="s12">Mã: DL</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-trung/kqxstth-sxtth-ket-qua-xo-so-thua-thien-hue-p36.html" title="XSTTH"><b class="underline">Thừa Thiên Huế</b></a><br><span class="s12">Mã: TTH</span></th><th><a href="/mien-trung/kqxspy-sxpy-ket-qua-xo-so-phu-yen-p31.html" title="XSPY"><b class="underline">Phú Yên</b></a><br><span class="s12">Mã: PY</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-trung/kqxsdlk-sxdlk-ket-qua-xo-so-dac-lac-p25.html" title="XSDLK"><b class="underline">Đắc Lắc</b></a><br><span class="s12">Mã: DLK</span></th><th><a href="/mien-trung/kqxsqnm-sxqnm-ket-qua-xo-so-quang-nam-p34.html" title="XSQNM"><b class="underline">Quảng Nam</b></a><br><span class="s12">Mã: QNM</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-trung/kqxsdng-sxdng-ket-qua-xo-so-da-nang-p24.html" title="XSDNG"><b class="underline">Đà Nẵng</b></a><br><span class="s12">Mã: DNG</span></th><th><a href="/mien-trung/kqxskh-sxkh-ket-qua-xo-so-khanh-hoa-p28.html" title="XSKH"><b class="underline">Khánh Hòa</b></a><br><span class="s12">Mã: KH</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-trung/kqxsbdi-sxbdi-ket-qua-xo-so-binh-dinh-p23.html" title="XSBDI"><b class="underline">Bình Định</b></a><br><span class="s12">Mã: BDI</span></th><th><a href="/mien-trung/kqxsqt-sxqt-ket-qua-xo-so-quang-tri-p35.html" title="XSQT"><b class="underline">Quảng Trị</b></a><br><span class="s12">Mã: QT</span></th><th><a href="/mien-trung/kqxsqb-sxqb-ket-qua-xo-so-quang-binh-p32.html" title="XSQB"><b class="underline">Quảng Bình</b></a><br><span class="s12">Mã: QB</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-trung/kqxsgl-sxgl-ket-qua-xo-so-gia-lai-p27.html" title="XSGL"><b class="underline">Gia Lai</b></a><br><span class="s12">Mã: GL</span></th><th><a href="/mien-trung/kqxsnt-sxnt-ket-qua-xo-so-ninh-thuan-p30.html" title="XSNT"><b class="underline">Ninh Thuận</b></a><br><span class="s12">Mã: NT</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-trung/kqxsdng-sxdng-ket-qua-xo-so-da-nang-p24.html" title="XSDNG"><b class="underline">Đà Nẵng</b></a><br><span class="s12">Mã: DNG</span></th><th><a href="/mien-trung/kqxsqng-sxqng-ket-qua-xo-so-quang-ngai-p33.html" title="XSQNG"><b class="underline">Quảng Ngãi</b></a><br><span class="s12">Mã: QNG</span></th><th><a href="/mien-trung/kqxsdno-sxdno-ket-qua-xo-so-dac-nong-p26.html" title="XSDNO"><b class="underline">Đắc Nông</b></a><br><span class="s12">Mã: DNO</span></th></tr>
<tr class="gr-yellow"><th><a href="/mien-trung/kqxskh-sxkh-ket-qua-xo-so-khanh-hoa-p28.html" title="XSKH"><b class="underline">Khánh Hòa</b></a><br><span class="s12">Mã: KH</span></th><th><a href="/mien-trung/kqxskt-sxkt-ket-qua-xo-so-kon-tum-p29.html" title="XSKT"><b class="underline">Kon Tum</b></a><br><span class="s12">Mã: KT</span></th></tr>';

        $html = str_get_html($str);
        foreach ($html->find('th') as $item) {
            $short_name = $item->find('.s12',0)->innertext;
            $short_name = strtolower(trim(str_replace('Mã:', '', $short_name)));

            if($short_name=='bt') $short_name='btr';
            if($short_name=='qnm') $short_name='qna';
            if($short_name=='dng') $short_name='dna';

            $name = $item->find('.underline',0)->innertext;
            $province = Province::where('short_name', $short_name)->first();
            if (count($province) > 0)
                echo  $short_name . ':' . $province->id . '<br/>';
            else
                echo  $short_name . ': khong tim thay' . '<br/>';
        }
    }

    public function getKqXsmtKQVS()
    {
        $url = 'https://s4.ketquaveso.mobi/ttkq/json_kqmt/0fb41e71bc903b627e9842ff5e6f2901';
        $kqs = requestvl($url);
        $kqs = \GuzzleHttp\json_decode($kqs, true);

        foreach ($kqs as $kq) {
            $CrDateTime = $kq['resultDate'];
            $date = date('Y-m-d', substr($CrDateTime, 0, strlen($CrDateTime) - 3));

            // nếu đã lấy xong thì thoát
            $count = Lottery::where('mien', 2)->where('date', $date)->where('status', 1)->count();
            if ($count == count($kqs)) return;

            $day = getThuNumber($date);

            $short_name = strtolower($kq['provinceCode']);
            if($short_name=='bt') $short_name='btr';
            if($short_name=='qnm') $short_name='qna';
            if($short_name=='dng') $short_name='dna';
            $province = Province::where('short_name', $short_name)->first();

            $g = $kq['lotData'];

            $giai = array();

            foreach ($g['DB'] as $item) {
                if ($item == '') $item = '...';
                $giai['DB'] = $item;
            }

            for ($i = 1; $i <= 8; $i++) {
                $giai[$i] = '';
                foreach ($g[$i] as $item) {
                    if ($item == '') $item = '...';
                    $giai[$i] .= $item . '-';
                }
                $giai[$i] = substr($giai[$i], 0, strlen($giai[$i]) - 1);
            }

            $a = [
                'gdb' => $giai['DB'],
                'g1' => $giai[1],
                'g2' => $giai[2],
                'g3' => $giai[3],
                'g4' => $giai[4],
                'g5' => $giai[5],
                'g6' => $giai[6],
                'g7' => $giai[7],
                'g8' => $giai[8],
                'day' => $day,
                'mien' => 2,
                'status' => $kq['isRolling'],
                'province_id' => $province->id,
                'date' => $date,
            ];
            print_ok($a);
//        Lottery::firstOrCreate([
//            'gdb' => $giai['DB'],
//            'g1' => $giai[1],
//            'g2' => $giai[2],
//            'g3' => $giai[3],
//            'g4' => $giai[4],
//            'g5' => $giai[5],
//            'g6' => $giai[6],
//            'g7' => $giai[7],
//            'madb' => $giai['MaDb'],
//            'day' => $day,
//            'mien' => 1,
//            'status' => $status,
//            'province_id' => $province_id,
//            'date' => $date,
//        ]);
        }
        echo 'xong!';
    }

    public function getKqXsmnKQVS()
    {
        $url = 'https://s1.ketquaveso.mobi/ttkq/json_kqmn/e60315b31ec59c3d2e1c126e3a481135';
        $kqs = requestvl($url);
        $kqs = \GuzzleHttp\json_decode($kqs, true);
        foreach ($kqs as $kq) {
            $CrDateTime = $kq['resultDate'];
            $date = date('Y-m-d', substr($CrDateTime, 0, strlen($CrDateTime) - 3));

            // nếu đã lấy xong thì thoát
            $count = Lottery::where('mien', 3)->where('date', $date)->where('status', 1)->count();
            if ($count == count($kqs)) return;

            $day = getThuNumber($date);

            $short_name = strtolower($kq['provinceCode']);
            if($short_name=='bt') $short_name='btr';
            if($short_name=='qnm') $short_name='qna';
            if($short_name=='dng') $short_name='dna';
            $province = Province::where('short_name', $short_name)->first();

            $g = $kq['lotData'];

            $giai = array();

            foreach ($g['DB'] as $item) {
                if ($item == '') $item = '...';
                $giai['DB'] = $item;
            }

            for ($i = 1; $i <= 8; $i++) {
                $giai[$i] = '';
                foreach ($g[$i] as $item) {
                    if ($item == '') $item = '...';
                    $giai[$i] .= $item . '-';
                }
                $giai[$i] = substr($giai[$i], 0, strlen($giai[$i]) - 1);
            }

            $a = [
                'gdb' => $giai['DB'],
                'g1' => $giai[1],
                'g2' => $giai[2],
                'g3' => $giai[3],
                'g4' => $giai[4],
                'g5' => $giai[5],
                'g6' => $giai[6],
                'g7' => $giai[7],
                'g8' => $giai[8],
                'day' => $day,
                'mien' => 3,
                'status' =>  $kq['isRolling'],
                'province_id' => $province->id,
                'date' => $date,
            ];
            print_ok($a);
//        Lottery::firstOrCreate([
//            'gdb' => $giai['DB'],
//            'g1' => $giai[1],
//            'g2' => $giai[2],
//            'g3' => $giai[3],
//            'g4' => $giai[4],
//            'g5' => $giai[5],
//            'g6' => $giai[6],
//            'g7' => $giai[7],
//            'madb' => $giai['MaDb'],
//            'day' => $day,
//            'mien' => 1,
//            'status' => $status,
//            'province_id' => $province_id,
//            'date' => $date,
//        ]);
        }
        echo 'xong!';
    }

    public function getKqXsmbKQVS()
    {
        $url = 'https://s5.ketquaveso.mobi/ttkq/json_kqmb/db16f65591d9a302bfe855750fdeb60e';
        $kq = requestvl($url);
        $kq = \GuzzleHttp\json_decode($kq, true);
//        print_ok($kq);die;

        $CrDateTime = $kq['resultDate'];
        $date = date('Y-m-d', substr($CrDateTime, 0, strlen($CrDateTime) - 3));

        // nếu đã lấy xong thì thoát
        $count = Lottery::where('mien', 1)->where('date', $date)->where('status', 1)->count();
        if ($count > 0) return;

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
            if ($item == '') $item = '...';
            $giai['DB'] = $item;
        }

        $maDB = '';
        foreach ($g['MaDb'] as $item) {
            if ($item == '') $item = '...';
            $maDB .= $item . '-';
        }
        $giai['MaDb'] = substr($maDB, 0, strlen($maDB) - 1);


        for ($i = 1; $i <= 7; $i++) {
            $giai[$i] = '';
            foreach ($g[$i] as $item) {
                if ($item == '') $item = '...';
                $giai[$i] .= $item . '-';
            }
            $giai[$i] = substr($giai[$i], 0, strlen($giai[$i]) - 1);
        }

        $a = [
            'gdb' => $giai['DB'],
            'g1' => $giai[1],
            'g2' => $giai[2],
            'g3' => $giai[3],
            'g4' => $giai[4],
            'g5' => $giai[5],
            'g6' => $giai[6],
            'g7' => $giai[7],
            'madb' => $giai['MaDb'],
            'day' => $day,
            'mien' => 1,
            'status' => $kq['isRolling'],
            'province_id' => $province_id,
            'date' => $date,
        ];
        print_ok($a);
        die;
        Lottery::firstOrCreate([
            'gdb' => $giai['DB'],
            'g1' => $giai[1],
            'g2' => $giai[2],
            'g3' => $giai[3],
            'g4' => $giai[4],
            'g5' => $giai[5],
            'g6' => $giai[6],
            'g7' => $giai[7],
            'madb' => $giai['MaDb'],
            'day' => $day,
            'mien' => 1,
            'status' => $status,
            'province_id' => $province_id,
            'date' => $date,
        ]);
        echo 'xong!';
    }

    public function getXsmt()
    {

        set_time_limit(0);
        $ngay_quay = date('Y-m-d');
        $date_url = date('d-m-Y');

        $url = 'https://xosodaiphat.com/xsmt-' . $date_url . '.html';
        $html = str_get_html(requestvl($url));
        if (count($html->find('.table-xsmn')) == 0) return;
        $count = count($html->find('.table-xsmn th'));

        // nếu đã lấy xong thì thoát
//        $count_day = Lottery::where('mien', 2)->where('date', $ngay_quay)->where('status', 1)->count();
//        if ($count_day == ($count-1)) return;

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

            Lottery::firstOrCreate([
                'gdb' => $sxmn[8],
                'g1' => $sxmn[7],
                'g2' => $sxmn[6],
                'g3' => $sxmn[5],
                'g4' => $sxmn[4],
                'g5' => $sxmn[3],
                'g6' => $sxmn[2],
                'g7' => $sxmn[1],
                'g8' => $sxmn[0],
                'day' => $day,
                'mien' => 3,
                'status' => $status,
                'province_id' => $province->id,
                'date' => $ngay_quay,
            ]);
        }
    }

    public function getXsmn()
    {
        set_time_limit(0);
        $ngay_quay = date('Y-m-d');
        $date_url = date('d-m-Y');

        $url = 'https://xosodaiphat.com/xsmn-' . $date_url . '.html';
        $html = str_get_html(requestvl($url));
        if (count($html->find('.table-xsmn')) == 0) return;
        $count = count($html->find('.table-xsmn th'));

        // nếu đã lấy xong thì thoát
        $count_day = Lottery::where('mien', 3)->where('date', $ngay_quay)->where('status', 1)->count();
        if ($count_day == ($count - 1)) return;

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
            Lottery::firstOrCreate([
                'gdb' => $sxmn[8],
                'g1' => $sxmn[7],
                'g2' => $sxmn[6],
                'g3' => $sxmn[5],
                'g4' => $sxmn[4],
                'g5' => $sxmn[3],
                'g6' => $sxmn[2],
                'g7' => $sxmn[1],
                'g8' => $sxmn[0],
                'day' => $day,
                'mien' => 3,
                'status' => $status,
                'province_id' => $province->id,
                'date' => $ngay_quay,
            ]);
        }
    }

    public function getXsmb()
    {
        set_time_limit(0);
        $ngay_quay = date('Y-m-d');
        $date_url = date('d-m-Y');

        // nếu đã lấy xong thì thoát
        $count = Lottery::where('mien', 1)->where('date', $ngay_quay)->where('status', 1)->count();
        if ($count > 0) return;

        $url = 'https://xosodaiphat.com/xsmb-' . $date_url . '.html';
        $html = str_get_html(requestvl($url));
        $sxmb = array();
        if (count($html->find('.table-xsmb')) == 0) return;
        foreach ($html->find('.table-xsmb tr') as $tr) {
            $g = '';
            foreach ($tr->find('span') as $span) {
                $g .= trim($span->innertext) . '-';
            }
            $sxmb[] = substr($g, 0, strlen($g) - 1);
        }

        $day = getThuNumber($ngay_quay);

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

        $status = 1;
        foreach ($sxmb as $item) {
            if (strpos($item, '...') !== false) {
                $status = 0;
                break;
            }
        }
        Lottery::firstOrCreate([
            'gdb' => $sxmb[1],
            'g1' => $sxmb[2],
            'g2' => $sxmb[3],
            'g3' => $sxmb[4],
            'g4' => $sxmb[5],
            'g5' => $sxmb[6],
            'g6' => $sxmb[7],
            'g7' => $sxmb[8],
            'madb' => $sxmb[0],
            'day' => $day,
            'mien' => 1,
            'status' => $status,
            'province_id' => $province_id,
            'date' => $ngay_quay,
        ]);
    }

    public function getKqXsmb()
    {
        $url = 'https://live.xosodaiphat.com/lotteryLive/1';
        $kq = requestvl($url);
        $kq = \GuzzleHttp\json_decode($kq);
        $kq = $kq[0];

        $CrDateTime = $kq->CrDateTime;
        $date_arr = explode(',', $CrDateTime);
        $date = getNgaycheo(trim($date_arr[1]));

        // nếu đã lấy xong thì thoát
        $count = Lottery::where('mien', 1)->where('date', $date)->where('status', 1)->count();
        if ($count > 0) return;

        $short_name = strtolower($kq->LotteryCode);
        $province = Province::where('short_name', $short_name)->first();

        $day = getThuNumber($date);

        $g = $kq->LotPrizes;

        Lottery::firstOrCreate([
            'gdb' => $g[0]->Range,
            'g1' => $g[1]->Range,
            'g2' => $g[2]->Range,
            'g3' => $g[3]->Range,
            'g4' => $g[4]->Range,
            'g5' => $g[5]->Range,
            'g6' => $g[6]->Range,
            'g7' => $g[7]->Range,
            'madb' => $kq->SpecialCodes,
            'day' => $day,
            'mien' => 1,
            'status' => $kq->Status,
            'province_id' => $province->id,
            'date' => $date,
        ]);
        echo 'xong!';
    }

    public function getKqXsmn()
    {
        $url = 'https://live.xosodaiphat.com/lotteryLive/2';
        $kqs = requestvl($url);
        $kqs = \GuzzleHttp\json_decode($kqs);

        foreach ($kqs as $kq) {
            $CrDateTime = $kq->CrDateTime;
            $date_arr = explode(',', $CrDateTime);
            $date = getNgaycheo(trim($date_arr[1]));

            // nếu đã lấy xong thì thoát
            $count = Lottery::where('mien', 3)->where('date', $date)->where('status', 1)->count();
            if ($count == count($kqs)) return;

            $short_name = strtolower($kq->LotteryCode);
            $province = Province::where('short_name', $short_name)->first();

            $day = getThuNumber($date);

            $g = $kq->LotPrizes;


            Lottery::firstOrCreate([
                'gdb' => $g[8]->Range,
                'g1' => $g[7]->Range,
                'g2' => $g[6]->Range,
                'g3' => $g[5]->Range,
                'g4' => $g[4]->Range,
                'g5' => $g[3]->Range,
                'g6' => $g[2]->Range,
                'g7' => $g[1]->Range,
                'g8' => $g[0]->Range,
                'day' => $day,
                'mien' => 3,
                'status' => $kq->Status,
                'province_id' => $province->id,
                'date' => $date,
            ]);
        }
        echo 'xong!';
    }

    public function getKqXsmt()
    {
        $url = 'https://live.xosodaiphat.com/lotteryLive/3';
        $kqs = requestvl($url);
        $kqs = \GuzzleHttp\json_decode($kqs);

        foreach ($kqs as $kq) {
            $CrDateTime = $kq->CrDateTime;
            $date_arr = explode(',', $CrDateTime);
            $date = getNgaycheo(trim($date_arr[1]));

            // nếu đã lấy xong thì thoát
            $count = Lottery::where('mien', 2)->where('date', $date)->where('status', 1)->count();
            if ($count == count($kqs)) return;

            $short_name = strtolower($kq->LotteryCode);
            $province = Province::where('short_name', $short_name)->first();

            $day = getThuNumber($date);

            $g = $kq->LotPrizes;


            Lottery::firstOrCreate([
                'gdb' => $g[8]->Range,
                'g1' => $g[7]->Range,
                'g2' => $g[6]->Range,
                'g3' => $g[5]->Range,
                'g4' => $g[4]->Range,
                'g5' => $g[3]->Range,
                'g6' => $g[2]->Range,
                'g7' => $g[1]->Range,
                'g8' => $g[0]->Range,
                'day' => $day,
                'mien' => 2,
                'status' => $kq->Status,
                'province_id' => $province->id,
                'date' => $date,
            ]);
        }
        echo 'xong!';
    }

    public function changeID()
    {
        $str_ok = '';
        for ($i = 2; $i <= 8; $i++) {
            $pro = Province::where('ngay_quay', 'like', '%' . $i . '%')->where('mien', 2)->get();
            $str = '';
            foreach ($pro as $item) {
                $str .= $item->id . ',';
            }
            $str = substr($str, 0, strlen($str) - 1);
            $str = '"' . $str . '",';
            $str_ok .= $str;
        }
        echo $str_ok;
        die();

//        $i = 100;
//        foreach (Province::all() as $pro) {
//            $pro->id = $i++;
//            $pro->save();
//        }
//        die('Xong!');

//        foreach (Province::all() as $pro) {
//            $url = 'https://xosodaiphat.com/xs' . $pro->slug . '.html';
//            $html = str_get_html(requestvl($url));
//            $id_html = substr($html, strpos($html, 'var lotId ='));
//            $id = intval(substr($id_html, 12, 2));
//            $pro->id = $id;
//            $pro->save();
//        }
//        die('Xong!');
    }

    public function changeTitle()
    {
        foreach (Province::all() as $pro) {
//            $name = $pro->name;
//            $name_kd = chuyenChuoi($pro->name);
//            $short_name = strtoupper($pro->short_name);
//            $pro->meta_title = 'XS'.$short_name.' - SX'.$short_name.' Hôm Nay - Xo So '.$name_kd.' - Kết Quả Xổ Số '.$name;
//            $pro->meta_description = 'XS'.$short_name.' - SX'.$short_name.' Hôm Nay - Xo So '.$name_kd.' - Kết quả xổ số '.$name.' '.getListThu($pro->ngay_quay).' hàng tuần trực tiếp nhanh chóng, chính xác. XS '.$name.', xổ số '.$name.', XS'.$short_name.' hom nay';
//            $pro->meta_keyword ='XS'.$short_name.', SX'.$short_name.', Xo So '.$name_kd.', Xổ Số '.$name.', Kết Quả Xổ Số '.$name.', XS '.$name.', XS '.$name.' hôm nay, ket qua '.$name_kd;
//            $pro->title = "XS$short_name  - SX$short_name - Kết quả xổ số $name";
            $pro->slug = "$pro->short_name-sx$pro->short_name-xo-so-$pro->slug_sc";
            $pro->save();
        }
        die('Xong!');
    }

    public function changeSlug()
    {
        foreach (Province::all() as $pro) {
            $pro->slug = substr($pro->slug, 2);
            $pro->slug_sc = chanetitle($pro->name);
            $pro->save();
        }
        die('Xong!');
    }

    public function getNgayQuay()
    {
        set_time_limit(0);
        $str = '';

        $html = str_get_html($str);
        $d = 2;
        foreach ($html->find('tr') as $tr) {
            foreach ($tr->find('a') as $a) {
                $province_name = trim($a->innertext);
                $province = Province::where('name', $province_name)->first();
                if (empty($province->ngay_quay)) {
                    $province->ngay_quay = $d;
                } else {
                    $province->ngay_quay = $province->ngay_quay . ',' . $d;
                }
                $province->save();
            }
            $d++;
        }
        die('xong!');


        set_time_limit(0);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date_create("05-04-2019");

        $date_url = '05-04-2019';
        while ($date_url != '31-03-2019') {
            $ngay_quay = date_format($date, "Y-m-d");
            $date_url = date_format($date, "d-m-Y");
            $url = 'https://xosodaiphat.com/xsmb-' . $date_url . '.html';
            $this->getXsmb($url, $ngay_quay);
            date_modify($date, "-1 days");
        }
    }
}
