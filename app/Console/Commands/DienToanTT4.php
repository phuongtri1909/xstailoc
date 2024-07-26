<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\DienToan;
use DB;

class DienToanTT4 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DienToanTT4:everyMinute';

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
        $this->thanTai4();
    }

    public function thanTai4()
    {
        set_time_limit(0);
        Log::info('Get Dien toan TT4 Start:' . date('Ymd H:i:s'));
        $url = 'https://xoso.mobi/xo-so-dien-toan-than-tai-hom-nay.html';
        $html = str_get_html(requestvl($url));
        $block_all = $html->find('.dientoan-ball .box');
        for ($k = 0; $k <= 2; $k++) {
            $block = $block_all[$k];
            $date = trim($block->find('h2.tit-mien', 0)->plaintext);
            $date = substr($date, strpos($date, 'ngày') + 5);
            $date = preg_replace('/\s+/', '', $date);
            $date = getNgaycheo($date);
            $day = getThuNumber($date);

            // nếu đã lấy xong thì thoát
            $count = DienToan::where('date', $date)->where('type', 3)->where('status', 1)->count();
            if ($count > 0) continue;

            $day_so = '';
            foreach ($block->find('li span') as $li) {
                if (!isset($li->innertext) || $li->innertext == '.' || $li->innertext == '') {
                    $day_so = '...';
                } else {
                    $day_so = trim($li->innertext);
                }
            }

            $status = 1;
            if (strpos($day_so, '...') !== false) {
                $status = 0;
            }

            $check = DienToan::where('date', $date)->where('type', 3)->count();
            if ($check == 0) {
                DienToan::firstOrCreate([
                    'day_so' => $day_so,
                    'date' => $date,
                    'day' => $day,
                    'status' => $status,
                    'type' => 3,
                ]);
            } else {
                DienToan::where('date', $date)
                    ->update([
                        'day_so' => $day_so,
                        'date' => $date,
                        'day' => $day,
                        'status' => $status,
                        'type' => 3,
                    ]);
            }
            Log::info('Get Dien toan TT4 End:' . date('Ymd H:i:s'));
        }
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
        Bus::dispatchFromArray('App\Console\Commands\DienToanTT4', []);
    }
}
