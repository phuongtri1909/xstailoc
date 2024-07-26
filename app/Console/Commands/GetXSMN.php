<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\Lottery;
use App\Models\Province;
use DB;

class GetXSMN extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getXsmn:everyMinute';

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
        // lần 1
        $this->getKqXsmnKQVS();
        sleep(8);

        // lần 2
        $this->getKqXsmnKQVS();
        sleep(8);

        // lần 3
        $this->getKqXsmnKQVS();
        sleep(8);

        // lần 4
        $this->getKqXsmnKQVS();
        sleep(8);

        // lần 5
        $this->getKqXsmnKQVS();
    }

    public function getKqXsmnKQVS()
    {
        Log::info('KQMN KQVS Start:' . date('Ymd H:i:s'));
        $url = 'https://s1.ketquaveso.mobi/ttkq/json_kqmn/e60315b31ec59c3d2e1c126e3a481135';
        $kqs = requestvl($url);

        if(empty(($kqs))){
            return $this->getKqXsmn();
        }

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

            $check = Lottery::where('province_id', $province->id)->where('date', $date)->where('mien',3)->count();
            if ($check == 0) {
                Lottery::create([
                    'gdb' => preg_replace('/\s+/', '', $giai['DB']),
                    'g1' => preg_replace('/\s+/', '', $giai[1]),
                    'g2' => preg_replace('/\s+/', '', $giai[2]),
                    'g3' => preg_replace('/\s+/', '', $giai[3]),
                    'g4' => preg_replace('/\s+/', '', $giai[4]),
                    'g5' => preg_replace('/\s+/', '', $giai[5]),
                    'g6' => preg_replace('/\s+/', '', $giai[6]),
                    'g7' => preg_replace('/\s+/', '', $giai[7]),
                    'g8' => preg_replace('/\s+/', '', $giai[8]),
                    'day' => $day,
                    'mien' => 3,
                    'status' => $status,
                    'province_id' => $province->id,
                    'date' => $date,
                ]);
            } else {
                Lottery::where('province_id', $province->id)->where('date', $date)->where('mien',3)
                    ->update([
                        'gdb' => preg_replace('/\s+/', '', $giai['DB']),
                        'g1' => preg_replace('/\s+/', '', $giai[1]),
                        'g2' => preg_replace('/\s+/', '', $giai[2]),
                        'g3' => preg_replace('/\s+/', '', $giai[3]),
                        'g4' => preg_replace('/\s+/', '', $giai[4]),
                        'g5' => preg_replace('/\s+/', '', $giai[5]),
                        'g6' => preg_replace('/\s+/', '', $giai[6]),
                        'g7' => preg_replace('/\s+/', '', $giai[7]),
                        'g8' => preg_replace('/\s+/', '', $giai[8]),
                        'day' => $day,
                        'mien' => 3,
                        'status' => $status,
                        'province_id' => $province->id,
                        'date' => $date,
                    ]);
            }
        }
        Log::info('KQMN KQVS End:' . date('Ymd H:i:s'));
    }

    public function getKqXsmn()
    {
        Log::info('KQMN Start:' . date('Ymd H:i:s'));

//        $url = 'https://xosodaiphat.com';
//        $html = str_get_html(requestvl($url));
//        $rootPath = substr($html, strpos($html, 'var rootPath = '));
//        $rootPath = substr($rootPath, 16, strpos($rootPath, "';") - 16);

        $rootPath = 'https://live.xosodaiphat.com/lotteryLive/2';
        $kqs = requestvl($rootPath);
        if(empty(($kqs))){
            return $this->getKqXsmnKQVS();
        }

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

            $check = Lottery::where('province_id', $province->id)->where('date', $date)->where('mien', 3)->count();
            if ($check == 0) {
                Lottery::firstOrCreate([
                    'gdb' => preg_replace('/\s+/', '', $g[8]->Range),
                    'g1' => preg_replace('/\s+/', '', $g[7]->Range),
                    'g2' => preg_replace('/\s+/', '', $g[6]->Range),
                    'g3' => preg_replace('/\s+/', '', $g[5]->Range),
                    'g4' => preg_replace('/\s+/', '', $g[4]->Range),
                    'g5' => preg_replace('/\s+/', '', $g[3]->Range),
                    'g6' => preg_replace('/\s+/', '', $g[2]->Range),
                    'g7' => preg_replace('/\s+/', '', $g[1]->Range),
                    'g8' => preg_replace('/\s+/', '', $g[0]->Range),
                    'day' => $day,
                    'mien' => 3,
                    'status' => $kq->Status,
                    'province_id' => $province->id,
                    'date' => $date,
                ]);
            } else {
                Lottery::where('province_id', $province->id)->where('date', $date)->where('mien', 3)
                    ->update([
                        'gdb' => preg_replace('/\s+/', '', $g[8]->Range),
                        'g1' => preg_replace('/\s+/', '', $g[7]->Range),
                        'g2' => preg_replace('/\s+/', '', $g[6]->Range),
                        'g3' => preg_replace('/\s+/', '', $g[5]->Range),
                        'g4' => preg_replace('/\s+/', '', $g[4]->Range),
                        'g5' => preg_replace('/\s+/', '', $g[3]->Range),
                        'g6' => preg_replace('/\s+/', '', $g[2]->Range),
                        'g7' => preg_replace('/\s+/', '', $g[1]->Range),
                        'g8' => preg_replace('/\s+/', '', $g[0]->Range),
                        'day' => $day,
                        'mien' => 3,
                        'status' => $kq->Status,
                        'province_id' => $province->id,
                        'date' => $date,
                    ]);
            }
        }
        Log::info('KQMN End:' . date('Ymd H:i:s'));
    }



    public function getXsmnHTML()
    {
        Log::info('KQMN HTML Start:' . date('Ymd H:i:s'));
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
            $province = Province::where('slug','like','%'.$slug)->first();
//            $province = Province::where('slug', $slug)->first();
            $day = getThuNumber($ngay_quay);

            $status = 1;
            foreach ($sxmn as $item) {
                if (strpos($item, '...') !== false) {
                    $status = 0;
                    break;
                }
            }
            $check = Lottery::where('province_id', $province->id)->where('date', $ngay_quay)->where('mien', 3)->count();
            if ($check == 0) {
                Lottery::firstOrCreate([
                    'gdb' => preg_replace('/\s+/', '', $sxmn[8]),
                    'g1' => preg_replace('/\s+/', '', $sxmn[7]),
                    'g2' => preg_replace('/\s+/', '', $sxmn[6]),
                    'g3' => preg_replace('/\s+/', '', $sxmn[5]),
                    'g4' => preg_replace('/\s+/', '', $sxmn[4]),
                    'g5' => preg_replace('/\s+/', '', $sxmn[3]),
                    'g6' => preg_replace('/\s+/', '', $sxmn[2]),
                    'g7' => preg_replace('/\s+/', '', $sxmn[1]),
                    'g8' => preg_replace('/\s+/', '', $sxmn[0]),
                    'day' => $day,
                    'mien' => 3,
                    'status' => $status,
                    'province_id' => $province->id,
                    'date' => $ngay_quay,
                ]);
            } else {
                Lottery::where('province_id', $province->id)->where('date', $ngay_quay)->where('mien', 3)
                    ->update([
                        'gdb' => preg_replace('/\s+/', '', $sxmn[8]),
                        'g1' => preg_replace('/\s+/', '', $sxmn[7]),
                        'g2' => preg_replace('/\s+/', '', $sxmn[6]),
                        'g3' => preg_replace('/\s+/', '', $sxmn[5]),
                        'g4' => preg_replace('/\s+/', '', $sxmn[4]),
                        'g5' => preg_replace('/\s+/', '', $sxmn[3]),
                        'g6' => preg_replace('/\s+/', '', $sxmn[2]),
                        'g7' => preg_replace('/\s+/', '', $sxmn[1]),
                        'g8' => preg_replace('/\s+/', '', $sxmn[0]),
                        'day' => $day,
                        'mien' => 3,
                        'status' => $status,
                        'province_id' => $province->id,
                        'date' => $ngay_quay,
                    ]);
            }
        }

        Log::info('KQMN HTML End:' . date('Ymd H:i:s'));
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
        Bus::dispatchFromArray('App\Console\Commands\GetXSMN', []);
    }
}
