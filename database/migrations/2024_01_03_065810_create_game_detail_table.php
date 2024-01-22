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
        Schema::create('game_detail', function (Blueprint $table) {
            $table->unsignedInteger('game_id');
            $table->string('user_id')->nullable();
            $table->string('player_name', 50);
            $table->integer('jersey_number');
            $table->boolean('is_away')->default(0);
            $table->string('type', 100);
            $table->timestamp('time')->useCurrent();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->nullable();
            $table->foreign('game_id')->references('game_id')->on('games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_detail');
    }
};
