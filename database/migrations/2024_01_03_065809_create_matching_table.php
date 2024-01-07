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
        Schema::create('matching', function (Blueprint $table) {
            $table->increments('matching_id');
            $table->string('away_club', 100);
            $table->unsignedInteger('stadium_id');
            $table->date('match_date');
            $table->time('match_time');
            $table->integer('goals_scored')->default(0);
            $table->integer('goals_conceded')->default(0);
            $table->char('result', 5);
            $table->string('state', 100);
            $table->integer('host')->default(0);
            $table->integer('remaining_seats')->default(0);
            $table->timestamps();
            $table->foreign('stadium_id')->references('stadium_id')->on('stadiums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matching');
    }
};
