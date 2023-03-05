<?php

namespace App\Services;

use App\Contracts\WeatherServiceContract;
use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OpenWeatherMapService implements WeatherServiceContract
{
    protected $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getWeather(float $latitude, float $longitude): array
    {
        $cacheKey = "weather_data_{$latitude}_{$longitude}";
        $weatherData = Cache::get($cacheKey);

        if ($weatherData) {
            return $weatherData;
        }

        try {
            $response = Http::timeout(0.5)
                ->get(config('weather.openweathermap.base_url') . 'weather', [
                'lat' => $latitude,
                'lon' => $longitude,
                'appid' => $this->apiKey,
            ]);

            if ($response->failed()) {
                return ['error' => 'Could not connect to OpenWeatherMap API'];
            }

        } catch (ConnectionException $e) {
            return ['error' => 'Could not connect to OpenWeatherMap API'];
        } catch (RequestException $e) {
            return ['error' => 'Could not connect to OpenWeatherMap API'];
        }

        $weatherData = $response->json();
        Cache::put($cacheKey, $weatherData, now()->addMinutes(10));

        return $weatherData;
    }

    public function getWeatherForUser(User $user): array
    {
        return $this->getWeather($user->latitude, $user->longitude);
    }
}
