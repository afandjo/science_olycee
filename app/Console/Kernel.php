<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Les commandes Artisan fournies par ton application.
     *
     * @var array<int, class-string<\Illuminate\Console\Command>>
     */
    protected $commands = [
        //
    ];

    /**
     * Définir la planification des commandes.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Exemple :
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Enregistrer les commandes Artisan de l’application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
