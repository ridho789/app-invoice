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
        Schema::create('tbl_cas', function (Blueprint $table) {
            $table->id('id_cas');
            $table->unsignedBigInteger('id_history')->nullable();
            $table->string('lts');
            $table->string('desc')->nullable();
            $table->string('charge');
            $table->date('start_period')->nullable();
            $table->date('end_period')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_cas');
    }
};
