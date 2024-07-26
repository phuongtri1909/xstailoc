<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\Lottery;
use App\Models\Province;
use DB;

class GetXSMB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getXsmb:everyMinute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(0);

//        Log::info('KQMB KQVS Start:' . date('Ymd H:i:s'));

//         lần 1
        $this->getKqXsmbKQVS();
        sleep(8);

        // lần 2
        $this->getKqXsmbKQVS();
        sleep(8);

        // lần 3
        $this->getKqXsmbKQVS();
        sleep(8);

        // lần 4
        $this->getKqXsmbKQVS();
        sleep(8);

        // lần 5
        $this->getKqXsmbKQVS();
    }

    public function getKqXsmbKQVS()
    {
        Log::info('KQMB KQVS Start:' . date('Ymd H:i:s'));
        $url = 'https://s1.ketquaveso.mobi/ttkq/json_kqmb/db16f65591d9a302bfe855750fdeb60e';
        $kq = requestvl($url);

        if(empty($kq)){
            return $this->getKqXsmbJson();
        }

        $kq = \GuzzleHttp\json_decode($kq, true);

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

        $check = Lottery::where('date', $date)->where('mien', 1)->count();
        if ($check == 0) {
            Lottery::firstOrCreate([
                'gdb' => preg_replace('/\s+/', '', $giai['DB']),
                'g1' => preg_replace('/\s+/', '', $giai[1]),
                'g2' => preg_replace('/\s+/', '', $giai[2]),
                'g3' => preg_replace('/\s+/', '', $giai[3]),
                'g4' => preg_replace('/\s+/', '', $giai[4]),
                'g5' => preg_replace('/\s+/', '', $giai[5]),
                'g6' => preg_replace('/\s+/', '', $giai[6]),
                'g7' => preg_replace('/\s+/', '', $giai[7]),
                'madb' => preg_replace('/\s+/', '', $giai['MaDb']),
                'day' => $day,
                'mien' => 1,
                'status' => $status,
                'province_id' => $province_id,
                'date' => $date,
            ]);
        } else {
            Lottery::where('date', $date)->where('mien', 1)
                ->update([
                    'gdb' => preg_replace('/\s+/', '', $giai['DB']),
                    'g1' => preg_replace('/\s+/', '', $giai[1]),
                    'g2' => preg_replace('/\s+/', '', $giai[2]),
                    'g3' => preg_replace('/\s+/', '', $giai[3]),
                    'g4' => preg_replace('/\s+/', '', $giai[4]),
                    'g5' => preg_replace('/\s+/', '', $giai[5]),
                    'g6' => preg_replace('/\s+/', '', $giai[6]),
                    'g7' => preg_replace('/\s+/', '', $giai[7]),
                    'madb' => preg_replace('/\s+/', '', $giai['MaDb']),
                    'day' => $day,
                    'mien' => 1,
                    'status' => $status,
                    'province_id' => $province_id,
                    'date' => $date,
                ]);
        }
        Log::info('KQMB KQVS End:' . date('Ymd H:i:s'));
    }

    public function getKqXsmbJson()
    {
        Log::info('KQMB Start:' . date('Ymd H:i:s'));
//        $url = 'https://xosodaiphat.com';
//        $html = str_get_html(requestvl($url));
//        $rootPath = substr($html, strpos($html, 'var rootPath = '));
//        $rootPath = substr($rootPath, 16, strpos($rootPath, "';") - 16);

        $rootPath = 'https://live.xosodaiphat.com/lotteryLive/1';
        $kq = requestvl($rootPath);

        if(empty($kq)){
            return $this->getKqXsmbKQVS();
        }

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

        $check = Lottery::where('date', $date)->where('mien', 1)->count();
        if ($check == 0) {
            Lottery::firstOrCreate([
                'gdb' => preg_replace('/\s+/', '', $g[0]->Range),
                'g1' => preg_replace('/\s+/', '', $g[1]->Range),
                'g2' => preg_replace('/\s+/', '', $g[2]->Range),
                'g3' => preg_replace('/\s+/', '', $g[3]->Range),
                'g4' => preg_replace('/\s+/', '', $g[4]->Range),
                'g5' => preg_replace('/\s+/', '', $g[5]->Range),
                'g6' => preg_replace('/\s+/', '', $g[6]->Range),
                'g7' => preg_replace('/\s+/', '', $g[7]->Range),
                'madb' => preg_replace('/\s+/', '', $kq->SpecialCodes),
                'day' => $day,
                'mien' => 1,
                'status' => $kq->Status,
                'province_id' => $province->id,
                'date' => $date,
            ]);
        } else {
            Lottery::where('date', $date)->where('mien', 1)
                ->update([
                    'gdb' => preg_replace('/\s+/', '', $g[0]->Range),
                    'g1' => preg_replace('/\s+/', '', $g[1]->Range),
                    'g2' => preg_replace('/\s+/', '', $g[2]->Range),
                    'g3' => preg_replace('/\s+/', '', $g[3]->Range),
                    'g4' => preg_replace('/\s+/', '', $g[4]->Range),
                    'g5' => preg_replace('/\s+/', '', $g[5]->Range),
                    'g6' => preg_replace('/\s+/', '', $g[6]->Range),
                    'g7' => preg_replace('/\s+/', '', $g[7]->Range),
                    'madb' => preg_replace('/\s+/', '', $kq->SpecialCodes),
                    'day' => $day,
                    'mien' => 1,
                    'status' => $kq->Status,
                    'province_id' => $province->id,
                    'date' => $date,
                ]);
        }
        Log::info('KQMB End:' . date('Ymd H:i:s'));
    }

    public function getKqXsmbHTML()
    {
        Log::info('KQMB-HTML Start:' . date('Ymd H:i:s'));
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

        $check = Lottery::where('date', $ngay_quay)->where('mien', 1)->count();
        if ($check == 0) {
            Lottery::firstOrCreate([
                'gdb' => preg_replace('/\s+/', '', $sxmb[1]),
                'g1' => preg_replace('/\s+/', '', $sxmb[2]),
                'g2' => preg_replace('/\s+/', '', $sxmb[3]),
                'g3' => preg_replace('/\s+/', '', $sxmb[4]),
                'g4' => preg_replace('/\s+/', '', $sxmb[5]),
                'g5' => preg_replace('/\s+/', '', $sxmb[6]),
                'g6' => preg_replace('/\s+/', '', $sxmb[7]),
                'g7' => preg_replace('/\s+/', '', $sxmb[8]),
                'madb' => preg_replace('/\s+/', '', $sxmb[0]),
                'day' => $day,
                'mien' => 1,
                'status' => $status,
                'province_id' => $province_id,
                'date' => $ngay_quay,
            ]);
        } else {
            Lottery::where('date', $ngay_quay)->where('mien', 1)
                ->update([
                    'gdb' => preg_replace('/\s+/', '', $sxmb[1]),
                    'g1' => preg_replace('/\s+/', '', $sxmb[2]),
                    'g2' => preg_replace('/\s+/', '', $sxmb[3]),
                    'g3' => preg_replace('/\s+/', '', $sxmb[4]),
                    'g4' => preg_replace('/\s+/', '', $sxmb[5]),
                    'g5' => preg_replace('/\s+/', '', $sxmb[6]),
                    'g6' => preg_replace('/\s+/', '', $sxmb[7]),
                    'g7' => preg_replace('/\s+/', '', $sxmb[8]),
                    'madb' => preg_replace('/\s+/', '', $sxmb[0]),
                    'day' => $day,
                    'mien' => 1,
                    'status' => $status,
                    'province_id' => $province_id,
                    'date' => $ngay_quay,
                ]);
        }
        Log::info('KQMB HTML End:' . date('Ymd H:i:s'));
    }

    /**
     * Đây là hàm chính sẽ chạy khi cron job được thực thi
     * Chúng ta sẽ viết lời gọi tới command xử lý nghiệp vụ,
     * cụ thể trong ví dụ này là App\Console\Commands\GetManga
     * @return mixed
     */
    public function fire()
    {
        //Khai báo đường dẫn tới command class
        Bus::dispatchFromArray('App\Console\Commands\GetXSMB', []);
    }
}
