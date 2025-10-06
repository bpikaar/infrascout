<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Use Carbon to randomize. now() is called once per seeder run.
        $created = now()->subDays(rand(1, 30));
        $updated = (clone $created)->addDays(rand(1, 5));

        return [
            'number'     => fake()->unique()->numberBetween(10000, 99999),
            'name'       => fake()->company(),
            'client'     => fake()->name(),
            'contact_id' => \App\Models\Contact::factory(),
            'created_at' => $created,
            'updated_at' => $updated,
        ];
    }
}
