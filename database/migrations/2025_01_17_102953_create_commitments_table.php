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
        Schema::create('commitments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promoter_id')->constrained('promoters');
            $table->foreignId('event_id')->constrained('events');
            $table->string('role');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->foreignId('status')->nullable()->constrained('commitment_states');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commitments');
    }
};


