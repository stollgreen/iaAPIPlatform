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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('post_code')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('country')->nullable()->constrained('countries', 'id');
            $table->date('hire_date')->nullable();
            $table->date('birth_date')->nullable();
            $table->foreignId('gender')->nullable()->constrained('genders', 'id');
            $table->string('position')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->float('salary')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};


