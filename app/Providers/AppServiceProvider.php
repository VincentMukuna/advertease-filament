<?php

namespace App\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict();
        Model::unguard();
        FilamentColor::register([
            'indigo' => Color::Indigo,
            'purple' => Color::Purple,
            'pink' => Color::Pink,
            'red' => Color::Red,
            'rose' => Color::Rose,
            'orange' => Color::Orange,

        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
