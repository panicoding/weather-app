<?php

namespace App\Contracts;

use App\Models\User;

interface WeatherServiceContract
{
    public function getWeather(float $latitude, float $longitude): array;

    public function getWeatherForUser(User $user): array;
}