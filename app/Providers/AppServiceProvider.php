<?php

namespace App\Providers;

use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Repositories\InferenceRepository;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(InferenceRepository::class, function (Application $app) {
            return new InferenceRepository();
        });

        $this->app->bind(BaseRepositoryInterface::class, InferenceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            // Warna Dongker (Background dan Gradient)
            'raisaDongker1' => Color::hex('#18265C'), // Background
            'raisaDongker2' => Color::hex('#2a3f8c'), // Gradient second color
            
            // Warna Gradient Light
            'gradientLight1' => Color::hex('#d9d9d9'), // Gradient light start
            'gradientLight2' => Color::hex('#ffffff'), // Gradient light end
        
            // Warna Gradient Dark
            'gradientDark0' => Color::hex('#121212'), // Gradient dark start
            'gradientDark1' => Color::hex('#242424'), // Gradient dark middle
            'gradientDark2' => Color::hex('#3a3a3a'), // Gradient dark end
        
            // Warna utama dan sekunder
            'primary' => Color::hex('#2a3f8c'), // Cocokkan dengan primary dari Filament
            'secondary' => Color::hex('#18265C'), // Cocokkan dengan secondary dari Filament
        ]);        
    }
}
