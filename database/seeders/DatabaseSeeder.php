<?php

namespace Database\Seeders;

use App\Models\Contact;
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

        $passwordBob = env('PASSWORD_BOB');
        $passwordRene = env('PASSWORD_RENE');

        User::factory()->create([
            'name' => 'Bob Pikaar',
            'email' => 'b.pikaar@hr.nl',
            'password' => bcrypt($passwordBob)
        ]);
        User::factory()->create([
            'name' => 'Rene Rolfes',
            'email' => 'rene.rolfes@infrascout.nl',
            'password' => bcrypt($passwordRene)
        ]);

        Contact::factory(10)->create();

        $this->call(MethodDescriptionsSeeder::class);
        $this->call(ProjectSeeder::class);
    }
}
