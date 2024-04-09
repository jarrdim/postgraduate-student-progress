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
        Schema::create('smisinterns.bps_supervisor_student_ids', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->nullable();
            $table->integer('supervisor_id')->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('level_id');

            // Create foreign key constraint
            $table->foreign('level_id')->references('id')->on('smisinterns.bps_supervisor_assigned_levels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('smisinterns.bps_supervisor_student_ids', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['level_id']);

            // Drop the level_id column
            $table->dropColumn('level_id');
        });
        Schema::dropIfExists('smisinterns.bps_supervisor_student_ids');
    }
};
