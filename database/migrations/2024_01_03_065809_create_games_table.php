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
        Schema::create('games', function (Blueprint $table) {
            $table->increments('game_id');
            $table->unsignedInteger('club_id');
            $table->unsignedInteger('stadium_id');
            $table->date('game_date');
            $table->time('game_time');
            $table->integer('goals_scored')->default(0);
            $table->integer('goals_conceded')->default(0);
            $table->char('result', 5);
            $table->string('state', 100);
            $table->integer('host')->default(1);
            $table->integer('remaining_seats')->default(0);
            $table->timestamps();

            $table->foreign('club_id')->references('club_id')->on('clubs')->onDelete('cascade');
            $table->foreign('stadium_id')->references('stadium_id')->on('stadiums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
