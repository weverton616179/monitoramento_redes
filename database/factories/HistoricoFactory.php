<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Historico>
 */
class HistoricoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->name(),
            'pk_loss' => 1,
            'tr_min' => 3,
            'tr_max' => 3,
            'tr_med' => 3,

            'host_id' => 2,
        ];
    }
}
