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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // 一小时执行一次`活跃用户`数据生成命令
        $schedule->command('larabbs:calculate-active-user')->hourly();
        /*
        我们还需要在每天零时00:00自动对数据进行同步. Laravel 任务调度可以轻松帮我们实现此功能. 在前面开发活跃用户章节中我们已经做了`Cron`设置, 此处我们只需在Kernel.php的schedule()方法中新增任务调度即可
        */
        // 每日0时执行一次
        $schedule->command('larabbs:sync-user-actived-at')->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
