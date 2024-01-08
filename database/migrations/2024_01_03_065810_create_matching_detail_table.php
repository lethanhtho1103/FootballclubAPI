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
        Schema::create('matching_detail', function (Blueprint $table) {
            $table->unsignedInteger('matching_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('player_name', 50);
            $table->integer('jersey_number');
            $table->boolean('is_away')->default(0);
            $table->string('type', 100);
            $table->timestamp('time')->useCurrent();

            $table->foreign('user_id')->references('uer_id')->on('users')->onDelete('cascade')->nullable();
            $table->foreign('matching_id')->references('matching_id')->on('matching')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matching_detail');
    }
};
