<?php

namespace Database\Factories;

use Akaunting\Money\Currency;
use App\Models\Campaign;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'reference' => 'PAY'.$this->faker->unique()->randomNumber(6),
            'currency' => $this->faker->randomElement(collect(Currency::getCurrencies())->keys()),
            'amount' => $this->faker->randomFloat(2, 100, 2000),
            'provider' => $this->faker->randomElement(['stripe', 'paypal', 'safaricom']),
            'method' => $this->faker->randomElement(['credit_card', 'bank_transfer', 'paypal', 'mpesa']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
            'campaign_id' => Campaign::factory(),
        ];
    }
}
