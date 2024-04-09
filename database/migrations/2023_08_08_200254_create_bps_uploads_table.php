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
        
        Schema::create('smisinterns.bps_document_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->integer('student_id');
            //$table->integer("receiver_id");
            //$table->integer("disabled")->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bps_uploads');
    }
};
