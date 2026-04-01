<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CarType;
use App\Models\CarModel;
use App\Models\Service;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Admin ----
        User::firstOrCreate(
            ['email' => 'admin@carcare.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // ---- Car Types & Models ----
        $sedan = CarType::firstOrCreate(['name' => 'Sedan']);
        $suv   = CarType::firstOrCreate(['name' => 'SUV']);
        $hatch = CarType::firstOrCreate(['name' => 'Hatchback']);

        CarModel::firstOrCreate(['name' => 'Corolla',   'car_type_id' => $sedan->id], ['price_modifier' => 1.0]);
        CarModel::firstOrCreate(['name' => 'Civic',     'car_type_id' => $sedan->id], ['price_modifier' => 1.1]);
        CarModel::firstOrCreate(['name' => 'Fortuner',  'car_type_id' => $suv->id],   ['price_modifier' => 1.5]);
        CarModel::firstOrCreate(['name' => 'Prado',     'car_type_id' => $suv->id],   ['price_modifier' => 1.7]);
        CarModel::firstOrCreate(['name' => 'Alto',      'car_type_id' => $hatch->id], ['price_modifier' => 0.8]);
        CarModel::firstOrCreate(['name' => 'Cultus',    'car_type_id' => $hatch->id], ['price_modifier' => 0.9]);

        // ---- Standard Services ----
        $services = [
            ['name' => 'Oil Change',         'category' => 'Maintenance', 'base_price' => 2500,  'duration_minutes' => 45],
            ['name' => 'Full Car Wash',       'category' => 'Cleaning',    'base_price' => 800,   'duration_minutes' => 30],
            ['name' => 'Interior Cleaning',   'category' => 'Cleaning',    'base_price' => 1500,  'duration_minutes' => 60],
            ['name' => 'Brake Inspection',    'category' => 'Inspection',  'base_price' => 1000,  'duration_minutes' => 30],
            ['name' => 'Tire Rotation',       'category' => 'Maintenance', 'base_price' => 1200,  'duration_minutes' => 45],
            ['name' => 'Battery Check',       'category' => 'Inspection',  'base_price' => 500,   'duration_minutes' => 20],
            ['name' => 'AC Service',          'category' => 'Maintenance', 'base_price' => 3500,  'duration_minutes' => 90],
            ['name' => 'General Inspection',  'category' => 'Inspection',  'base_price' => 1500,  'duration_minutes' => 60],
        ];

        foreach ($services as $s) {
            Service::firstOrCreate(['name' => $s['name']], $s);
        }

        $this->command->info('Database seeded: admin, car types/models, and 8 standard services.');
    }
}
