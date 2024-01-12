<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices',function (Blueprint $table) {

        $table->id();
        $table->string('invoice_no');
        $table->date('invoice_date');
        $table->date('due_date');
        $table->unsignedBigInteger('customer_id');
        $table->decimal('total_amount', 10, 2);
        $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
        $table->timestamps();

        $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
