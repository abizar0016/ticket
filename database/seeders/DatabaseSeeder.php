<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@ticket.com',
            'password' => bcrypt('adminticket'),
            'provider' => 'email',
            'provider_id' => null,
            'email_verified_at' => now(),
            'remember_token' => null,
            'role' => 'admin'
        ]);
    }
}
