<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customer::inRandomOrder()->first();
        return [
            // 'invoice_no'=>$this->faker->numberBetween(11111,99999),
            'invoice_date' => $this->faker->date,
            'due_date' => $this->faker->date,
            'customer_id' => $customer->id,
            'total_amount' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(['paid', 'unpaid']),
        ];
    }
}
