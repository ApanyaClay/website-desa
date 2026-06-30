<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share village profile with all views, with fallback to avoid breaking during migrations
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('profiles')) {
                $profile = \App\Models\Profile::first() ?? new \App\Models\Profile([
                    'nama_desa' => 'Desa Mekar Jaya',
                ]);
                \Illuminate\Support\Facades\View::share('villageProfile', $profile);
            } else {
                \Illuminate\Support\Facades\View::share('villageProfile', new \App\Models\Profile(['nama_desa' => 'Desa Mekar Jaya']));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\View::share('villageProfile', new \App\Models\Profile(['nama_desa' => 'Desa Mekar Jaya']));
        }
    }
}
