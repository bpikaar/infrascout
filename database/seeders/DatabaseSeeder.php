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
            'name' => 'Bob Pikaar',
            'email' => 'b.pikaar@hr.nl',
            'password' => bcrypt('test1234')
        ]);

        $this->call(ProjectSeeder::class);
    }
}
