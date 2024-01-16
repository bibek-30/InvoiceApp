<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Invoice;
use Faker\Core\Number;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Customer::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Bibek Shrestha',
            'email' => 'Bibekshrestha828@gmail.com',
            'password' => 'admin'
        ]);

        \App\Models\Customer::factory()->create([
            'name' => 'John Doe',
            'address' => '123 Main St',
            'phone_number' => '123-456-7890',
            'email' => 'john@example.com'
        ]);

        \App\Models\Product::factory(10)->create();



        // \App\Models\Invoice::factory(10)->create();

        // $customer = Customer::inRandomOrder()->first();

        // \App\Models\Invoice::factory()->create([
        //     // 'invoice_no' => "123",
        //     'invoice_date' => now(),
        //     'customer_id' => $customer->id,
        //     'due_date' => now()->addDays(5),
        //     'total_amount' => 100.00,
        //     'status' => 'unpaid',
        // ]);

        // $products = \App\Models\Product::all();

        // $invoices = Invoice::all();

        // foreach ($invoices as $invoice) {
        //     $selectedProducts = $products->random(rand(1, min(3, $products->count())));

        //     foreach ($selectedProducts as $product) {
        //         $quantity = rand(1, 5);
        //         $subtotal = $quantity * $product->price;

        //         \App\Models\InvoiceItem::create([
        //             'invoice_id' => $invoice->id,
        //             'product_id' => $product->id,
        //             'quantity' => $quantity,
        //             'subtotal' => $subtotal,
        //         ]);
        //     }
        // }
    }
}
