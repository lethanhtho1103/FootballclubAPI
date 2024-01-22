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
        Schema::create('team_lineup', function (Blueprint $table) {
            $table->increments('lineup_id');
            $table->unsignedInteger('game_id');
            $table->string('user_id', 10);
            $table->string('position', 100);
            $table->boolean('is_starting_player');
            $table->string('formation', 10);
            $table->foreign('game_id')->references('game_id')->on('games')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_lineup');
    }
};
