<?php

namespace Tests\Integration\Services;

use App\Services\OpenWeatherMapService;
use Tests\TestCase;

use function Spatie\PestPluginTestTime\testTime;

class OpenWeatherMapServiceTest extends TestCase
{
    /** @test */
    public function the_getWeather_method_will_return_the_weather_date_from_api()
    {
        $apiKey = config('weather.openweathermap.key');
        
        if (!$apiKey) {
            $this->markTestSkipped('OPENWEATHERMAP_API_KEY not set in environment variables.');
        }
        
        $service = new OpenWeatherMapService($apiKey);
        $weather = $service->getWeather(39.099724, -92.578331);

        $this->assertArrayHasKey('weather', $weather);
    }
}
