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
        Schema::create('landpoints', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->double('latitude', 30, 4);
            $table->double('longitude', 30 ,4);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landpoints');
    }
};
