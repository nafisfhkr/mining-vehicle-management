<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
       
        User::create(['name' => 'Admin Tambang', 'email' => 'admin@mining.com', 'password' => bcrypt('password'), 'role' => 'admin']);
        User::create(['name' => 'Pak Budi (Kepala)', 'email' => 'budi@mining.com', 'password' => bcrypt('password'), 'role' => 'approver']);
        User::create(['name' => 'Pak Joko (Manajer)', 'email' => 'joko@mining.com', 'password' => bcrypt('password'), 'role' => 'approver']);

        
        $drivers = ['Supri', 'Bambang', 'Anto', 'Dedi', 'Eko'];
        foreach ($drivers as $name) {
            Driver::create(['name' => $name]);
        }

       
        $vehicles = [
            [
                'name' => 'Toyota Hilux 4x4',
                'type' => 'angkutan_orang',
                'license_plate' => 'B 1234 TX',
                'ownership' => 'company',
                'location' => 'Kantor Pusat', 
                'fuel_consumption' => 12.5,
                'service_schedule' => now()->addMonth(),
            ],
            [
                'name' => 'Mitsubishi Triton',
                'type' => 'angkutan_orang',
                'license_plate' => 'D 5678 XY',
                'ownership' => 'rented',
                'location' => 'Tambang Site A', 
                'fuel_consumption' => 11.0,
                'service_schedule' => now()->addWeeks(2),
            ],
            [
                'name' => 'Bus Karyawan Hino',
                'type' => 'angkutan_orang',
                'license_plate' => 'AB 9999 ZZ',
                'ownership' => 'company',
                'location' => 'Kantor Cabang', 
                'fuel_consumption' => 6.5,
                'service_schedule' => now()->addMonths(3),
            ],
            [
                'name' => 'Dump Truck Hino 500',
                'type' => 'angkutan_barang',
                'license_plate' => 'F 4444 KL',
                'ownership' => 'company',
                'location' => 'Tambang Site B', 
                'fuel_consumption' => 4.0,
                'service_schedule' => now()->addMonth(),
            ],
            [
                'name' => 'Excavator Komatsu PC200',
                'type' => 'angkutan_barang',
                'license_plate' => 'E 1111 QA',
                'ownership' => 'rented',
                'location' => 'Tambang Site A',
                'fuel_consumption' => 25.0,
                'service_schedule' => now()->addWeeks(1),
            ],
        ];

        foreach ($vehicles as $v) {
            Vehicle::create($v);
        }
    }
}