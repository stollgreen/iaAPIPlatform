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
        Schema::create('group_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('groupid'); // Verwende unsignedBigInteger, um auf die id der Groups-Tabelle zu verweisen
            $table->foreign('groupid')->references('id')->on('groups')->onDelete('cascade'); // Referenziert die `id`-Spalte der `groups`-Tabelle
            $table->unsignedBigInteger('userid'); // Beispiel für weitere Spalten wie `userid`
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_users');
    }
};


