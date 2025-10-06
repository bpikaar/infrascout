<?php

namespace Database\Factories;

use App\Models\Pipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pipe>
 */
class PipeFactory extends Factory
{
    protected $model = Pipe::class;

    public function definition(): array
    {
        return [
            'pipe_type' => $this->faker->randomElement(['PVC','HDPE','Steel','Copper']).' '.$this->faker->bothify('##'),
            'material' => $this->faker->randomElement(['PVC','HDPE','Steel','Copper']),
            'diameter' => $this->faker->randomFloat(2, 5, 200),
        ];
    }
}
