<?php

namespace Database\Factories;

use App\Models\BillboardOwner;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillboardOwnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BillboardOwner::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company().' '.$this->faker->randomElement(['Signage', 'Billboards', 'Media', 'Ads', 'Advertising']),
            'bio' => $this->faker->text(),
            'website' => $this->faker->url(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'social_media_links' => '{}',
        ];
    }
}
