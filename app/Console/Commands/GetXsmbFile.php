<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\Lottery;
use App\Models\Province;
use Illuminate\Support\Facades\Storage;

class GetXsmbFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetXsmbFile:everyMinute';

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
        Log::info('File KQMB KQVS Start:' . date('Ymd H:i:s'));
        set_time_limit(0);
        $this->getKqXsmbKQVS();
        sleep(6);
        $this->getKqXsmbKQVS();
        sleep(6);
        $this->getKqXsmbKQVS();
        sleep(6);
        $this->getKqXsmbKQVS();
        sleep(6);
        $this->getKqXsmbKQVS();
        sleep(6);
        $this->getKqXsmbKQVS();
        sleep(6);
        $this->getKqXsmbKQVS();
        sleep(6);
        $this->getKqXsmbKQVS();
        sleep(6);
        $this->getKqXsmbKQVS();
        sleep(6);
        $this->getKqXsmbKQVS();
        Log::info('File KQMB KQVS End:' . date('Ymd H:i:s'));
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

        Storage::put('xsmb.txt',json_encode($kqxs));
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
        Bus::dispatchFromArray('App\Console\Commands\GetXsmbFile', []);
    }
}
