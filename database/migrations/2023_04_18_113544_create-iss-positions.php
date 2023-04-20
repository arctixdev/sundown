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
        Schema::create('iss_positions', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('timestamp');
            $table->decimal('longitude', 30, 4);
            $table->decimal('latitude', 30, 4);
            $table->double('distance');
            $table->bigInteger('landpoint_id')->unsigned();
            $table->foreign('landpoint_id')->references('id')->on('landpoints');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iss_positions');
    }
};
