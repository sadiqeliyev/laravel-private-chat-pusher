<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'sadig',
            'firstname' => 'Sadig',
            'lastname' => 'Aliyev',
            'email' => 'sadig.aliev99@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'filankes',
            'firstname' => 'Filankes',
            'lastname' => 'Filankesov',
            'email' => 'filankes@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'fesmankes',
            'firstname' => 'Fesmankes',
            'lastname' => 'Fesmankesov',
            'email' => 'fesmankes@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
