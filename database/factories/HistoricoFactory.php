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
            'pk_loss' => 0,
            'tr_min' => 2,
            'tr_max' => 2,
            'tr_med' => 2,

            'host_id' => 1,
        ];
    }
}
