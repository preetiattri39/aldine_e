<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // ✅ Import View
use App\Models\ConfigSetting; // ✅ Import your ConfigSetting model

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
        // Get key-value config settings
        $configDetail = ConfigSetting::where('type', 'config')->pluck('value', 'key');

        // Share static or dynamic values globally
        View::share('instagram', $configDetail['instagram'] ?? 'https://instagram.com/yourpage');
        View::share('reddit', $configDetail['reddit'] ?? 'https://reddit.com/yourpage');
        View::share('tiktok', $configDetail['tiktok'] ?? 'https://tiktok.com/@yourpage');
        View::share('supportEmail', $configDetail['support_email'] ?? 'info@yourdomain.com');
        View::share('siteName', config('app.name'));
    }
}
