<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\OpenWeatherMapService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

use function Spatie\PestPluginTestTime\testTime;

class OpenWeatherMapServiceTest extends TestCase
{
    /** @test */
    public function the_getWeather_method_will_return_the_weather_data_from_api()
    {
        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                'weather' => [
                    [
                        'main' => 'Rain',
                        'description' => 'light rain'
                    ],
                ],
            ], 200),
        ]);

        $service = new OpenWeatherMapService('api_key');
        $weather = $service->getWeather(38.8951, -77.0364);

        $this->assertEquals([
            'weather' => [
                [
                    'main' => 'Rain',
                    'description' => 'light rain',
                ],
            ],
        ], $weather);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.openweathermap.org/data/2.5/weather?lat=38.8951&lon=-77.0364&appid=api_key'
                && $request['lat'] === 38.8951
                && $request['lon'] === -77.0364
                && $request['appid'] === 'api_key';
        });
    }

    /** @test */
    public function the_getWeather_method_will_return_error_on_api_timeout()
    {
        Http::fake([
            'api.openweathermap.org/*' => Http::response(null, 500), 
        ]);

        $service = new OpenWeatherMapService('api_key');
        $weather = $service->getWeather(38.8951, -77.0364);

        $this->assertEquals(['error' => 'Could not connect to OpenWeatherMap API'], $weather);
    }

    /** @test */
    public function the_getWeather_method_will_cache_weather_data_for_10_minutes()
    {
        $apiKey = 'api_key';

        $latitude = 39.099724;
        $longitude = -92.578331;

        $cacheKey = "weather_data_{$latitude}_{$longitude}";
        Cache::delete($cacheKey);

        $responseJson = [
            'main' => [
                'temp' => 100,
                'humidity' => 150,
            ],
        ];

        $responseJson2 = [
            'main' => [
                'temp' => 80,
                'humidity' => 250,
            ],
        ];

        Http::fake([
            'https://api.openweathermap.org/*' => Http::sequence()
                ->push($responseJson, 200)
                ->push($responseJson2, 200)
        ]);

        $this->assertNull(Cache::get($cacheKey));

        $weatherService = new OpenWeatherMapService($apiKey);

        $weatherService->getWeather($latitude, $longitude);

        $this->assertNotNull(Cache::get($cacheKey));
        $this->assertEquals($responseJson, Cache::get($cacheKey));

        testTime()->addMinutes(10)->addSecond();

        $weatherService = new OpenWeatherMapService($apiKey);

        $weatherService->getWeather($latitude, $longitude);

        $this->assertNotNull(Cache::get($cacheKey));
        $this->assertEquals($responseJson2, Cache::get($cacheKey));

        Http::assertSent(function ($request) {
            return strpos($request->url(), config('weather.openweathermap.base_url') . 'weather') === 0;
        });

        Http::assertSentCount(2);
    }

    /** @test */
    public function the_getWeather_method_will_return_cached_weather_data()
    {
        $latitude = 39.099724;
        $longitude = -92.578331;

        $cacheKey = "weather_data_{$latitude}_{$longitude}";
        Cache::delete($cacheKey);

        $responseJson = [
            'main' => [
                'temp' => 100,
                'humidity' => 150,
            ],
        ];

        Http::fake([
            'https://api.openweathermap.org/*' => Http::sequence()
                ->push($responseJson, 200)
        ]);

        $weatherService = new OpenWeatherMapService('api_key');

        $weatherService->getWeather($latitude, $longitude);

        $this->assertNotNull(Cache::get($cacheKey));
        $this->assertEquals($responseJson, Cache::get($cacheKey));
    }

    /** @test */
    public function the_getWeatherForUser_method_will_return_weather_for_a_given_user()
    {
        $users = User::factory()->count(10)->create();

        $responseJson = [
            'main' => [
                'temp' => 100,
                'humidity' => 150,
            ],
        ];

        Http::fake([
            'https://api.openweathermap.org/*' => Http::response($responseJson, 200)
        ]);

        $weatherService = new OpenWeatherMapService('api_key');

        $users->each(function ($user) use ($weatherService) {
            $response = $weatherService->getWeatherForUser($user);

            $this->assertNotNull($response);
            $this->assertArrayHasKey('main', $response);
            $this->assertArrayHasKey('humidity', $response['main']);
        });
    }
}
