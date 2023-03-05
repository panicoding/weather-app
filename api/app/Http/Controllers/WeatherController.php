<?php

namespace App\Http\Controllers;

use App\Contracts\WeatherServiceContract;
use App\Models\User;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(protected WeatherServiceContract $weatherService)
    {
        
    }

    public function show(User $user)
    {
        return $this->weatherService->getWeatherForUser($user);
    }
}
