<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        for ($i=1; $i <= 100; $i++) {
            User::create([
                'name'     => $faker->name(),
                'email'    => $faker->email(),
                'password' => Hash::make('admin123'),
            ]);
        }
    }
}
