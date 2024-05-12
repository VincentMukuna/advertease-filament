<?php

namespace App\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            'indigo' => Color::Indigo,
            'purple' => Color::Purple,
            'pink' => Color::Pink,
            'red' => Color::Red,
            'rose' => Color::Rose,
            'orange' => Color::Orange,

        ]);
    }
}
