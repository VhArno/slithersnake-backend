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
        Schema::create('users_matches', function (Blueprint $table) {
            $table->foreignId('users_id')->constrained();
            $table->foreignId('matches_id')->constrained();
            $table->primary(['users_id', 'matches_id']);
            $table->integer('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_matches');
    }
};
