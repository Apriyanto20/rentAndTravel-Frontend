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
        Schema::create('detail_seat', function (Blueprint $table) {
            $table->id();
            $table->string('codeDetailTransportation');
            $table->string('seat_code')->unique();
            $table->timestamps();

            //$table->foreign('codeDetailTransportation')->references('codeDetailTransportation')->on('transportations_travel_detail')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_seat');
    }
};
