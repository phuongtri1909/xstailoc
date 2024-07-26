<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\GetXSMB',
        'App\Console\Commands\GetXSMT',
        'App\Console\Commands\GetXSMN',
        'App\Console\Commands\GetMax3D',
        'App\Console\Commands\GetMax3DPro',
        'App\Console\Commands\GetPower655',
        'App\Console\Commands\GetMega645',
        'App\Console\Commands\CreateDuDoanXoSo',
        'App\Console\Commands\GenerateSitemap',
        'App\Console\Commands\GetXsmbFile',
        'App\Console\Commands\GetXsmtFile',
        'App\Console\Commands\GetXsmnFile',
        'App\Console\Commands\DienToan636',
        'App\Console\Commands\DienToan123',
        'App\Console\Commands\DienToanTT4'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//       $schedule->command('GetXsmbFile:everyMinute')->everyMinute();
//       $schedule->command('GetXsmtFile:everyMinute')->everyMinute();
//       $schedule->command('GetXsmnFile:everyMinute')->everyMinute();

        $schedule->command('GetXsmbFile:everyMinute')->timezone('Asia/Ho_Chi_Minh')->between('18:10', '18:40')->everyMinute();
        $schedule->command('GetXsmtFile:everyMinute')->timezone('Asia/Ho_Chi_Minh')->between('17:10', '17:45')->everyMinute();
        $schedule->command('GetXsmnFile:everyMinute')->timezone('Asia/Ho_Chi_Minh')->between('16:10', '16:45')->everyMinute();



//       $schedule->command('app:generate-sitemap')->everyMinute();
//        $schedule->command('app:generate-sitemap')->timezone('Asia/Ho_Chi_Minh')->between('18:47', '18:48')->everyMinute();


//       $schedule->command('getXsmb:everyMinute')->everyMinute();
//       $schedule->command('getXsmt:everyMinute')->everyMinute();
//       $schedule->command('getXsmt:everyMinute')->everyMinute();
        $schedule->command('getXsmb:everyMinute')->timezone('Asia/Ho_Chi_Minh')->between('18:10', '18:40')->everyMinute();
        $schedule->command('getXsmt:everyMinute')->timezone('Asia/Ho_Chi_Minh')->between('17:10', '17:45')->everyMinute();
        $schedule->command('getXsmn:everyMinute')->timezone('Asia/Ho_Chi_Minh')->between('16:10', '16:45')->everyMinute();

//        $schedule->command('GetMax3D:everyMinute')->everyMinute();
//        $schedule->command('GetMax3DPro:everyMinute')->everyMinute();
//        $schedule->command('GetPower655:everyMinute')->everyMinute();
//        $schedule->command('GetMega645:everyMinute')->everyMinute();

        $schedule->command('GetMega645:everyMinute')->timezone('Asia/Ho_Chi_Minh')->days([0,3,5])->between('18:00', '18:50')->everyMinute();  // thứ 4,6,cn
        $schedule->command('GetPower655:everyMinute')->timezone('Asia/Ho_Chi_Minh')->days([2,4,6])->between('18:00', '18:50')->everyMinute(); // thứ 3,5,7
//        $schedule->command('GetMax3D:everyMinute')->timezone('Asia/Ho_Chi_Minh')->days([1,3,5])->between('18:00', '18:50')->everyMinute(); // thứ 3,5,7
//        $schedule->command('GetMax3DPro:everyMinute')->timezone('Asia/Ho_Chi_Minh')->days([2,4,6])->between('18:00', '18:50')->everyMinute(); // thứ 3,5,7

//        $schedule->command('CreateDuDoanXoSo:everyMinute')->everyMinute();
         $schedule->command('CreateDuDoanXoSo:everyMinute')->timezone('Asia/Ho_Chi_Minh')->between('19:10', '19:30')->everyMinute();


//        $schedule->command('dienToan636:everyMinute')->everyMinute();
//        $schedule->command('dienToan123:everyMinute')->everyMinute();
//        $schedule->command('dienToanTT4:everyMinute')->everyMinute();
        $schedule->command('DienToan636:everyMinute')->timezone('Asia/Ho_Chi_Minh')->days([3,6])->between('18:10', '18:40')->everyMinute();
        $schedule->command('DienToan123:everyMinute')->timezone('Asia/Ho_Chi_Minh')->between('18:10', '18:40')->everyMinute();
        $schedule->command('DienToanTT4:everyMinute')->timezone('Asia/Ho_Chi_Minh')->between('18:10', '18:40')->everyMinute();

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
