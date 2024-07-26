<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\Mega645;
use DB;

class GetMega645 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetMega645:everyMinute';

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
        $this->getMega645();
    }

    public function getMega645()
    {
        set_time_limit(0);
        Log::info('Get getMega645 start:' . date('Ymd H:i:s'));
        $date = date('j-n-Y', strtotime("+1 days"));
        $url = 'https://xskt.com.vn/moreLr.jsp?areaCode=MG&p=MEGA645&d=' . $date . '&lrPosition=4';
        Log::info('new Mega645:'.$url);
        $html = str_get_html(requestvl($url));

        $box = str_get_html($html->find('.box-ketqua', 0)->innertext);
        $h2 = trim($box->find('h2', 0)->innertext);
        $h2 = explode(' ', $h2);
        $ngay_quay = $h2[count($h2) - 1];

        if(!empty($box->find('.result td.kmt a b'))){
            $ky_quay = $box->find('.result td.kmt a b', 0)->innertext;
            $ky_quay = intval(substr($ky_quay, 1));
        }else{
            $ky_quay = null;
        }

        if(!empty($box->find('.result td.megaresult em'))){
            $day_so = trim($box->find('.result td.megaresult em', 0)->innertext);
            $day_so = preg_replace('/\s+/', '-', $day_so);
        }else{
            $ky_quay = null;
        }

        if(!empty($box->find('.trunggiai tr', 2))){
            $jackpot_gt = str_replace(',', '', $box->find('.trunggiai tr', 2)->find('td', 3)->plaintext);
            $jackpot_sl = $box->find('.trunggiai tr', 2)->find('td', 2)->plaintext;
        }else{
            $jackpot_gt = null;
            $jackpot_sl = null;
        }

        if(!empty($box->find('.trunggiai tr', 3))){
            $g1_sl = $box->find('.trunggiai tr', 3)->find('td', 2)->plaintext;
        }else{
            $g1_sl = null;
        }

        if(!empty($box->find('.trunggiai tr', 4))){
            $g2_sl = str_replace(',', '', $box->find('.trunggiai tr', 4)->find('td', 2)->plaintext);
        }else{
            $g2_sl = null;
        }

        if(!empty($box->find('.trunggiai tr', 5))){
            $g3_sl = str_replace(',', '', $box->find('.trunggiai tr', 5)->find('td', 2)->plaintext);
        }else{
            $g3_sl = null;
        }


        $date = date('Y-m-d', strtotime($ngay_quay));
        $day = getThuNumber($date);

        $check = Mega645::where('date', $date)->count();
        if ($check == 0) {
            Mega645::firstOrCreate([
                'day_so' => $day_so,
                'jackpot_gt' => $jackpot_gt,
                'jackpot_sl' => $jackpot_sl,
                'g1_sl' => $g1_sl,
                'g2_sl' => $g2_sl,
                'g3_sl' => $g3_sl,
                'date' => $date,
                'day' => $day,
                'status' => 1,
                'ky' => $ky_quay,
            ]);
            Log::info('new Mega645');
        } else {
            Mega645::where('date', $date)
                ->update([
                    'day_so' => $day_so,
                    'jackpot_gt' => $jackpot_gt,
                    'jackpot_sl' => $jackpot_sl,
                    'g1_sl' => $g1_sl,
                    'g2_sl' => $g2_sl,
                    'g3_sl' => $g3_sl,
                    'date' => $date,
                    'day' => $day,
                    'status' => 1,
                    'ky' => $ky_quay,
                ]);
            Log::info('update Mega645');
        }
        Log::info('Get getMega645 End:' . date('Ymd H:i:s'));
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
        Bus::dispatchFromArray('App\Console\Commands\GetMega645', []);
    }
}
