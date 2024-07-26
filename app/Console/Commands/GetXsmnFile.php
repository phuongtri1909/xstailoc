<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\Lottery;
use App\Models\Province;
use Illuminate\Support\Facades\Storage;

class GetXsmnFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetXsmnFile:everyMinute';

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
        Log::info('File KQMN KQVS Start:' . date('Ymd H:i:s'));
        set_time_limit(0);
        $this->getKqXsmnKQVS();
        sleep(6);
        $this->getKqXsmnKQVS();
        sleep(6);
        $this->getKqXsmnKQVS();
        sleep(6);
        $this->getKqXsmnKQVS();
        sleep(6);
        $this->getKqXsmnKQVS();
        sleep(6);
        $this->getKqXsmnKQVS();
        sleep(6);
        $this->getKqXsmnKQVS();
        sleep(6);
        $this->getKqXsmnKQVS();
        sleep(6);
        $this->getKqXsmnKQVS();
        sleep(6);
        $this->getKqXsmnKQVS();
        sleep(6);
        $this->getKqXsmnKQVS();
        Log::info('File KQMN KQVS End:' . date('Ymd H:i:s'));
    }
    public function getKqXsmnKQVS()

    {
        $url = 'https://s1.ketquaveso.mobi/ttkq/json_kqmn/e60315b31ec59c3d2e1c126e3a481135';
        $kqs = requestvl($url);

        $kqs = \GuzzleHttp\json_decode($kqs, true);

        $kqxs = array();
        foreach ($kqs as $kq) {
            $CrDateTime = $kq['resultDate'];
            $date = date('Y-m-d', substr($CrDateTime, 0, strlen($CrDateTime) - 3));


            // nếu đã lấy xong thì thoát

//            $count = Lottery::where('mien', 3)->where('date', $date)->where('status', 1)->count();

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
            $xsDau = getDau($xsLoto, substr($giai['DB'], strlen($giai['DB']) - 2, 2));

//            $xsDau = getDauLive($xsLoto);


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
            $kq['OpenPrizeTime'] = '16h15';
            $kq['SpecialCodes'] = '';
            $kq['Status'] = "$status";
            $kqxs[] = $kq;
        }

        Storage::put('xsmn.txt',json_encode($kqxs));  
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
        Bus::dispatchFromArray('App\Console\Commands\GetXsmnFile', []);
    }
}
