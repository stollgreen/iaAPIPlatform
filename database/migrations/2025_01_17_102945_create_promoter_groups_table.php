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
        Schema::create('promoter_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('skills');
            $table->string('description');
            $table->integer('max_members');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promoter_groups');
    }
};


