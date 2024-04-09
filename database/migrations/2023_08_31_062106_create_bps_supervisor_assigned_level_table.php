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
        Schema::create('smisinterns.bps_supervisor_assigned_levels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smisinterns.bps_supervisor_assigned_levels');
    }
};
