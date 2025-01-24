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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers');
            $table->foreignId('customer_id')->constrained('customers');
            $table->date('issue_date');
            $table->date('due_date');
            $table->float('total_amount');
            $table->foreignId('payment_status')->constrained('payment_states');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};


