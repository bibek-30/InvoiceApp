<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invoiceId = Invoice::inRandomOrder()->first()->id;

        $productIds = Product::inRandomOrder()->limit(2)->pluck('id')->toArray();

        return [
            'invoice_id' => $invoiceId,
            'product_id' => $this->faker->randomElement($productIds),
            'quantity' => $this->faker->numberBetween(1, 5),
            'subtotal' => 0,
        ];
    }
}
