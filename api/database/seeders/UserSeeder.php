<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create()->each(function ($user) {
            $user->latitude = rand(-90, 90);
            $user->longitude = rand(-180, 180);
            $user->save();
        });
    }
}
