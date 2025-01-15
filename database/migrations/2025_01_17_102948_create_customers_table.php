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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('company_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->text('post_code')->nullable();
            $table->text('city')->nullable();
            $table->foreignId('country')->nullable()->constrained('countries', 'id');
            $table->string('vat_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};


