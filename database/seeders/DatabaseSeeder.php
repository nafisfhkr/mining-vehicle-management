<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\Driver;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    
    User::create([
        'name' => 'Admin Tambang',
        'email' => 'admin@mining.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

    
    User::create([
        'name' => 'Pak Budi (Approver 1)',
        'email' => 'budi@mining.com',
        'password' => bcrypt('password'),
        'role' => 'approver',
    ]);

    User::create([
        'name' => 'Pak Joko (Approver 2)',
        'email' => 'joko@mining.com',
        'password' => bcrypt('password'),
        'role' => 'approver',
    ]);

    Driver::create(['name' => 'Supri']);
    Driver::create(['name' => 'Bambang']);
    
    Vehicle::create([
        'name' => 'Toyota Hilux 4x4',
        'type' => 'angkutan_orang',
        'license_plate' => 'B 1234 TX',
        'ownership' => 'company',
        'fuel_consumption' => 12.5,
        'service_schedule' => now()->addMonth(),
    ]);
}
}
