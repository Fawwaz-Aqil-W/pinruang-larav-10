<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notifikasi;

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
        View::composer('*', function ($view) {
            $notifikasi = [];
            if (auth()->check()) {
                $notifikasi = Notifikasi::where('user_id', auth()->id())->latest()->get();
            }
            $view->with('notifikasi', $notifikasi);
        });
    }
}
