<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        \Carbon\Carbon::setLocale(config('app.locale'));
        
        Blade::directive('cachebust', function ($expression) {
            return "<?php echo asset($expression) . '?v=' . filemtime(custom_public_path($expression)); ?>";
        });
        
        Blade::directive('tanggalIndo', function ($expression) {
            return "<?php echo \Carbon\Carbon::parse($expression)->translatedFormat('d F Y'); ?>";
        });
        Blade::directive('tanggalWaktuIndo', function ($expression) {
            return "<?php echo \Carbon\Carbon::parse($expression)->translatedFormat('d F Y') . ' - ' . \Carbon\Carbon::parse($expression)->format('H:i') . ' WIT'; ?>";
        });
    }
}
