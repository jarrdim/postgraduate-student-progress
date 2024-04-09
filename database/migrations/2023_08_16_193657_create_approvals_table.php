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
        Schema::create('smisinterns.approvals', function (Blueprint $table) {
            $table->id();

            $table->integer('file_id');
            $table->integer('level_id');
            $table->string('remarks')->nullable()->default(null); 
            $table->date('date_acted_upon');
            $table->integer('acted_on_by');
            $table->integer('status_id');

            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
