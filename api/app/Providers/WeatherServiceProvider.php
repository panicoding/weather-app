<?php

namespace App\Providers;

use App\Contracts\WeatherServiceContract;
use App\Services\OpenWeatherMapService;
use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(WeatherServiceContract::class, function ($app) {
            return new OpenWeatherMapService(config('weather.openweathermap.key'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
