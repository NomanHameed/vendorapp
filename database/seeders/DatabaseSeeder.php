<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'umairakram500@gmail.com',
        //     'password' => Hash::make('Umair@32!')
        // ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Scott',
        //     'email' => 'scott@scarletbranding.co.nz',
        //     'password' => Hash::make('XhR(ZUS@)&')
        // ]);
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'umair@local.com',
            'password' => Hash::make('Umair123')
        ]);

        
    }
}
