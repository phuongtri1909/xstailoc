<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\Max3D;
use DB;

class GetMax3D extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetMax3D:everyMinute';

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
        $this->getMax3D();
    }

    public function getMax3D()
    {
        set_time_limit(0);
        Log::info('Get getMax3D Start:' . date('Ymd H:i:s'));
        $date = date('j-n-Y', strtotime("+1 days"));
        $url = 'https://xskt.com.vn/moreLr.jsp?areaCode=3D&p=MAX3D&d=' . $date . '&lrPosition=7';
        Log::info('new getMax3D:'.$url);
        $html = str_get_html(requestvl($url));

        $box = str_get_html($html->find('.box-ketqua', 0)->innertext);
        $h2 = trim($box->find('h2', 0)->innertext);
        $h2 = explode(' ', $h2);
        $ngay_quay = $h2[count($h2) - 1];

        $ky_quay = $box->find('th.kmt a b', 0)->innertext;
        $ky_quay = intval(substr($ky_quay, 1));

        if(!empty($box->find('tr', 2))){
            $gdb = trim($box->find('tr', 2)->find('td', 1)->plaintext);
            $gdb_sl = trim($box->find('tr', 2)->find('td em', 0)->plaintext);
            $gdb_pl_sl = $box->find('tr', 2)->find('td em', 1)->plaintext;
        } else{
            $gdb = null;
            $gdb_sl = null;
            $gdb_pl_sl = null;
        }

        if(!empty($box->find('tr', 3))){
            $g1 = trim($box->find('tr', 3)->find('td', 1)->plaintext);
            $g1_sl = trim($box->find('tr', 3)->find('td em', 0)->plaintext);
            $g1_pl_sl = $box->find('tr', 3)->find('td em', 1)->plaintext;
        } else{
            $g1 = null;
            $g1_sl = null;
            $g1_pl_sl = null;
        }

        if(!empty($box->find('tr', 4))){
            $g2 = trim($box->find('tr', 4)->find('td', 1)->plaintext);
            $g2_sl = trim($box->find('tr', 4)->find('td em', 0)->plaintext);
            $g2_pl_sl = $box->find('tr', 4)->find('td em', 1)->plaintext;
        } else{
            $g2 = null;
            $g2_sl = null;
            $g2_pl_sl = null;
        }

        if(!empty($box->find('tr', 5))){
            $g3 = trim($box->find('tr', 5)->find('td', 1)->plaintext);
            $g3_sl = str_replace(',', '', trim($box->find('tr', 5)->find('td em', 0)->plaintext));
            $g3_pl_sl = $box->find('tr', 5)->find('td em', 1)->plaintext;
        } else{
            $g3 = null;
            $g3_sl = null;
            $g3_pl_sl = null;
        }

        if(!empty($box->find('tr', 6))){
            $g4_pl_sl = $box->find('tr', 6)->find('td em', 1)->plaintext;
        }else{
            $g4_pl_sl = null;
        }

        if(!empty($box->find('tr', 7))){
            $g5_pl_sl = str_replace(',', '', $box->find('tr', 7)->find('td em', 1)->plaintext);
        }else{
            $g5_pl_sl = null;
        }

        if(!empty($box->find('tr', 8))){
            $g6_pl_sl = str_replace(',', '', $box->find('tr', 8)->find('td em', 1)->plaintext);
        }else{
            $g6_pl_sl = null;
        }

        $gdb = preg_replace('/\s+/', '-', $gdb);
        $g1 = preg_replace('/\s+/', '-', $g1);
        $g2 = preg_replace('/\s+/', '-', $g2);
        $g3 = preg_replace('/\s+/', '-', $g3);


        $date = date('Y-m-d', strtotime($ngay_quay));
        $day = getThuNumber($date);

        $check = Max3D::where('date', $date)->count();
        if ($check == 0) {
            Max3D::firstOrCreate([
                'gdb' => $gdb,
                'g1' => $g1,
                'g2' => $g2,
                'g3' => $g3,
                'gdb_sl' => $gdb_sl,
                'g1_sl' => $g1_sl,
                'g2_sl' => $g2_sl,
                'g3_sl' => $g3_sl,
                'gdb_pl_sl' => $gdb_pl_sl,
                'g1_pl_sl' => $g1_pl_sl,
                'g2_pl_sl' => $g2_pl_sl,
                'g3_pl_sl' => $g3_pl_sl,
                'g4_pl_sl' => $g4_pl_sl,
                'g5_pl_sl' => $g5_pl_sl,
                'g6_pl_sl' => $g6_pl_sl,
                'date' => $date,
                'day' => $day,
                'ky' => $ky_quay,
                'status' => 1
            ]);
            Log::info('new getMax3D');
        } else {
            Max3D::where('date', $date)
                ->update([
                    'gdb' => $gdb,
                    'g1' => $g1,
                    'g2' => $g2,
                    'g3' => $g3,
                    'gdb_sl' => $gdb_sl,
                    'g1_sl' => $g1_sl,
                    'g2_sl' => $g2_sl,
                    'g3_sl' => $g3_sl,
                    'gdb_pl_sl' => $gdb_pl_sl,
                    'g1_pl_sl' => $g1_pl_sl,
                    'g2_pl_sl' => $g2_pl_sl,
                    'g3_pl_sl' => $g3_pl_sl,
                    'g4_pl_sl' => $g4_pl_sl,
                    'g5_pl_sl' => $g5_pl_sl,
                    'g6_pl_sl' => $g6_pl_sl,
                    'date' => $date,
                    'day' => $day,
                    'ky' => $ky_quay,
                    'status' => 1
                ]);
            Log::info('update getMax3D');
        }


        Log::info('Get getMax3D End:' . date('Ymd H:i:s'));
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
        Bus::dispatchFromArray('App\Console\Commands\GetMax3D', []);
    }
}
