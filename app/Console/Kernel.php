<?php

namespace App\Console;

use App\Console\Commands\ImportLocations;
use App\Console\Commands\RestoreDeletedUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Warning;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\PaveIt::class,
        Commands\CreateAdmin::class,
        Commands\SendExpirationAlerts::class,
        Commands\SendInventoryAlerts::class,
        Commands\SendExpectedCheckinAlerts::class,
        Commands\ObjectImportCommand::class,
        Commands\Version::class,
        Commands\SystemBackup::class,
        Commands\DisableLDAP::class,
        Commands\Purge::class,
        Commands\LdapSync::class,
        Commands\FixDoubleEscape::class,
        Commands\RecryptFromMcrypt::class,
        Commands\ResetDemoSettings::class,
        Commands\SyncAssetLocations::class,
        Commands\RegenerateAssetTags::class,
        Commands\SyncAssetCounters::class,
        Commands\RestoreDeletedUsers::class,
        Commands\SendUpcomingAuditReport::class,
        Commands\ImportLocations::class,
        Commands\ReEncodeCustomFieldNames::class,
        Commands\SendEmail::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('snipeit:inventory-alerts')->daily();
        $schedule->command('snipeit:expiring-alerts')->daily();
        $schedule->command('snipeit:expected-checkin')->daily();
        $schedule->command('snipeit:backup')->weekly();
        $schedule->command('backup:clean')->daily();
        $schedule->command('snipeit:upcoming-audits')->daily();

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $warnings = Warning::get();
        foreach($warnings as $warning)
        {
            $schedule->command('warning:sendmail')->dailyAt($warning->hour_warning)->timezone('Asia/Ho_Chi_Minh');
            if(\Carbon::now()->format('H:i') == $warning->hour_warning)
            {
                \Session::put('id', $warning->id);
            } 
        }
    }

    protected function commands()
    {
        require base_path('routes/console.php');
        $this->load(__DIR__.'/Commands');
    }
}
