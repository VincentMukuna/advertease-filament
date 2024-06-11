<?php

namespace Database\Factories;

use App\Models\Campaign;
use Carbon\Carbon;
use Database\Seeders\LocalImages;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

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
            'start_date' => Carbon::make($this->faker->dateTimeBetween('-1 year', '-6 month'))->toDateString(),
            'end_date' => Carbon::make($this->faker->dateTimeBetween('now', '+1 year'))->toDateString(),
            'budget' => $this->faker->randomFloat(2, 1_000_000, 9_999_999.99),
            'target_audience' => $this->faker->sentence(2),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Campaign $campaign) {
            try {
                $campaign
                    ->addMedia(LocalImages::campaign())
                    ->preservingOriginal()
                    ->toMediaCollection('campaign-images');
            } catch (UnreachableUrl $exception) {
                return;
            }
        });

    }
}
