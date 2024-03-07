<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->string('seat_id')->primary();
            $table->unsignedInteger('stadium_id');
            $table->integer('seat_number');
            $table->string('type', 10); // Normal VIP VVIP
            $table->decimal('price', 10, 2);
            $table->string('stand', 5); // Khán đài E, S, W, N, v.v.
            $table->string('status', 20)->default('available'); // Trạng thái mặc định là 'available'
            $table->timestamps();

            $table->foreign('stadium_id')->references('stadium_id')->on('stadiums')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
