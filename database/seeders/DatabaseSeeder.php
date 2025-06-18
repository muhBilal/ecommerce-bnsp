<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

         DB::table('users')->insert([
            [
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'), 
                'birthdate' => '1990-01-01',
                'gender' => 'male',
                'address' => 'Jl. Admin No. 1',
                'city' => 'Surabaya',
                'phone_number' => '081234567890',
                'paypal_id' => 'admin@paypal.com',
                'role' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'user1',
                'email' => 'bilal@gmail.com',
                'password' => Hash::make('password'),
                'birthdate' => '2000-05-15',
                'gender' => 'female',
                'address' => 'Jl. Pengguna No. 2',
                'city' => 'Jakarta',
                'phone_number' => '081298765432',
                'paypal_id' => 'user1@paypal.com',
                'role' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        
        DB::table('device_types')->insert([
            ['name' => 'Diagnostic'],
            ['name' => 'Therapeutic'],
            ['name' => 'Monitoring'],
            ['name' => 'Surgical'],
            ['name' => 'Other'],
        ]);


        DB::table('medical_devices')->insert([
            [
                'name' => 'Tensimeter Digital',
                'brand' => 'Omron',
                'type' => 3, 
                'quantity' => 5,
                'price' => 250000.00,
                'description' => 'Untuk mengukur tekanan darah otomatis.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Termometer Inframerah',
                'brand' => 'Microlife',
                'type' => 1, 
                'quantity' => 10,
                'price' => 150000.00,
                'description' => 'Suhu tubuh non-kontak.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('carts')->insert([
            [
                'user_id' => 2, // user1
                'device_id' => 1, // Tensimeter Digital
                'quantity' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2, // user1
                'device_id' => 2, // Termometer Inframerah
                'quantity' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
