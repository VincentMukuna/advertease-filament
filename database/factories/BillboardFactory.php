<?php

namespace Database\Factories;

use App\Models\Billboard;
use App\Models\BillboardOwner;
use Database\Seeders\LocalImages;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

class BillboardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Billboard::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(),
            'daily_rate' => $this->faker->randomFloat(2, 100, 100_000),
            'size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'type' => $this->faker->randomElement(['static', 'digital', 'backlit', 'mobile']),
            'is_visible' => $this->faker->boolean(),
            'booking_status' => $this->faker->randomElement(['available', 'booked']),
            'lat' => $this->faker->latitude(),
            'lng' => $this->faker->longitude(),
            'reach' => $this->faker->randomNumber(6),
            'billboard_owner_id' => BillboardOwner::factory(),
            'created_at' => $this->faker->dateTimeBetween('-6 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }

    public function withinNairobi(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'lat' => $this->faker->latitude(-1.246389, -1.292065),
                'lng' => $this->faker->longitude(36.821946, 36.928193),
            ];
        });
    }

    public function withinKenya(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'lat' => $this->faker->latitude(-4.676985, 4.676985),
                'lng' => $this->faker->longitude(33.993819, 41.899244),
            ];
        });
    }

    public function configure(): BillboardFactory
    {
        return $this->afterCreating(function (Billboard $product) {
            try {
                $product
                    ->addMedia(LocalImages::getRandomFile())
                    ->preservingOriginal()
                    ->toMediaCollection('billboard-images');
            } catch (UnreachableUrl $exception) {
                return;
            }
        });
    }
}
