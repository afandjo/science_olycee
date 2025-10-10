<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Paiement;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Partager les nombres de paiements validés par chapitre
        View::composer('admin.login.nav', function ($view) {
            $counts = Paiement::selectRaw('chapter_id, COUNT(*) as total')
                ->where('statut', 'valide')
                ->groupBy('chapter_id')
                ->pluck('total', 'chapter_id');

            $view->with('counts', $counts);
        });
    }
}
