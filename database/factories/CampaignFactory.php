<?php

namespace Database\Factories;

use App\Models\Campaign;
use Database\Seeders\LocalImages;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'number' => 'CAM'.$this->faker->unique()->randomNumber(6),
            'title' => $this->faker->sentence(3),
            'objective' => $this->faker->text(),
            'start_date' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'budget' => $this->faker->randomFloat(2, 0, 999999.99),
            'target_audience' => $this->faker->sentence(2),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }

    public function configure()
    {
        $this->afterCreating(function (Campaign $campaign) {
            $campaign
                ->addMedia(LocalImages::campaign())
                ->preservingOriginal()
                ->toMediaCollection('campaign-images');
        });

    }
}
