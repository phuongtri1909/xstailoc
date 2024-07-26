<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\Power655;
use DB;

class GetPower655 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetPower655:everyMinute';

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
        $this->getPower655();
    }

    public function getPower655()
    {
        set_time_limit(0);
        Log::info('Get getPower655 start:' . date('Ymd H:i:s'));
        $date = date('j-n-Y', strtotime("+1 days"));
        $url = 'https://xskt.com.vn/moreLr.jsp?areaCode=MP&p=POWER&d=' . $date . '&lrPosition=4';
        Log::info('new getPower655:'.$url);
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
            $day_so = null;
        }

        if(!empty($box->find('.result .jp2 .megaresult'))){
            $day_so_jp2 = trim($box->find('.result .jp2 .megaresult', 0)->innertext);
        }else{
            $day_so_jp2 = null;
        }

        $day_so = $day_so . '-' . $day_so_jp2;


        if(!empty($box->find('.trunggiai tr', 2))){
            $jackpot_gt_1 = str_replace(',', '', $box->find('.trunggiai tr', 2)->find('td', 3)->plaintext);
            $jackpot_sl_1 = $box->find('.trunggiai tr', 2)->find('td', 2)->plaintext;
        }else{
            $jackpot_gt_1 = null;
            $jackpot_sl_1 = null;
        }

        if(!empty($box->find('.trunggiai tr', 3))){
            $jackpot_gt_2 = str_replace(',', '', $box->find('.trunggiai tr', 3)->find('td', 3)->plaintext);
            $jackpot_sl_2 = $box->find('.trunggiai tr', 3)->find('td', 2)->plaintext;
        }else{
            $jackpot_gt_2 = null;
            $jackpot_sl_2 = null;
        }

        if(!empty($box->find('.trunggiai tr', 4))){
            $g1_sl = $box->find('.trunggiai tr', 4)->find('td', 2)->plaintext;
        }else{
            $g1_sl = null;
        }

        if(!empty($box->find('.trunggiai tr', 5))){
            $g2_sl = str_replace(',', '', $box->find('.trunggiai tr', 5)->find('td', 2)->plaintext);
        }else{
            $g2_sl = null;
        }

        if(!empty($box->find('.trunggiai tr', 6))){
            $g3_sl = str_replace(',', '', $box->find('.trunggiai tr', 6)->find('td', 2)->plaintext);
        }else{
            $g3_sl = null;
        }

        $date = date('Y-m-d', strtotime($ngay_quay));
        $day = getThuNumber($date);

        $check = Power655::where('date', $date)->count();
        if ($check == 0) {
            Power655::firstOrCreate([
                'day_so' => $day_so,
                'jackpot1_gt' => $jackpot_gt_1,
                'jackpot1_sl' => $jackpot_sl_1,
                'jackpot2_gt' => $jackpot_gt_2,
                'jackpot2_sl' => $jackpot_sl_2,
                'g1_sl' => $g1_sl,
                'g2_sl' => $g2_sl,
                'g3_sl' => $g3_sl,
                'date' => $date,
                'day' => $day,
                'status' => 1,
                'ky' => $ky_quay,
            ]);
            Log::info('new getPower655');
        } else {
            Power655::where('date', $date)
                ->update([
                    'day_so' => $day_so,
                    'jackpot1_gt' => $jackpot_gt_1,
                    'jackpot1_sl' => $jackpot_sl_1,
                    'jackpot2_gt' => $jackpot_gt_2,
                    'jackpot2_sl' => $jackpot_sl_2,
                    'g1_sl' => $g1_sl,
                    'g2_sl' => $g2_sl,
                    'g3_sl' => $g3_sl,
                    'date' => $date,
                    'day' => $day,
                    'status' => 1,
                    'ky' => $ky_quay,
                ]);
            Log::info('update getPower655');
        }

        Log::info('Get getPower655 End:' . date('Ymd H:i:s'));
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
        Bus::dispatchFromArray('App\Console\Commands\GetPower655', []);
    }
}
