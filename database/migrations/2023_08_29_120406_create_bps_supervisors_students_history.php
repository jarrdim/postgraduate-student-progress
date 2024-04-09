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
        Schema::create('smisinterns.bps_supervisors_students_history', function (Blueprint $table) {
            $table->id();
            //$table->integer('bps_supervisor_student_id')->unsigned();
            $table->timestamps();
            $table->integer('student_id');
            $table->integer('supervisor_id');
            $table->string('remarks')->nullable()->default(null); 
            $table->string('status');
        
            // Define foreign key constraint for bps_supervisor_student_id
          // $table->foreign('bps_supervisor_student_id')
            //    ->references('id')
              //  ->on('smisinterns.bps_supervisor_student_ids');
                //->onDelete('cascade');
        });
                }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bps_supervisors_students_history');
    }
};
