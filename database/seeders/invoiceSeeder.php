<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class invoiceSeeder extends Seeder
{
    /**
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        DB::table('invoices')->insert([
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'date' => now(),
            'total_amount' => 100.00,
            'status' => 'unpaid',
        ]);
    }
}
