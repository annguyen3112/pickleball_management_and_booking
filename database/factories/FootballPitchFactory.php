<?php

namespace Database\Factories;

use App\Models\FootballPitch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FootballPitch>
 */
class FootballPitchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = FootballPitch::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Pitch',
            'description' => $this->faker->sentence,
            'time_start' => '07:00',
            'time_end' => '21:00',
            'price_per_hour' => $this->faker->numberBetween(100000, 200000),
            'price_per_peak_hour' => $this->faker->numberBetween(200000, 300000),
            'is_maintenance' => false,
            'pitch_type_id' => PitchType::factory(),
            'from_football_pitch_id' => null,
            'to_football_pitch_id' => null,
        ];
    }
}
