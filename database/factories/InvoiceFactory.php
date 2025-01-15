<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\PaymentState;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'offer_id' => Offer::factory()->create()->id,
            'customer_id' => Customer::factory()->create()->id,
            'issue_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'total_amount' => $this->faker->numberBetween(100, 1000),
            'payment_status' => PaymentState::factory()->create()->id,
        ];
    }
}
