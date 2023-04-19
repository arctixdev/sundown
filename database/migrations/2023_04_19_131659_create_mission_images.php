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
        Schema::create('mission_images', function (Blueprint $table) {
            $table->id();
            $table->string('camera_name');
            $table->string('rover_name');
            $table->text('rover_status');
            $table->text('img');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->bigInteger('mission_report_id')->unsigned();
            $table->foreign('mission_report_id')->references('id')->on('mission_reports');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_images');
    }
};
