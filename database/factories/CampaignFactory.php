<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Campaign;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'objective' => $this->faker->text(),
            'start_date' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'budget' => $this->faker->randomFloat(2, 0, 999999.99),
            'target_audience' => $this->faker->sentence(4),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}
