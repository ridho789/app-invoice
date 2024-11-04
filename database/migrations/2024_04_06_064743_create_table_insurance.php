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
        Schema::create('tbl_insurances', function (Blueprint $table) {
            $table->id('id_insurance');
            $table->unsignedBigInteger('id_history')->nullable();
            $table->string('nopolis')->nullable();
            $table->string('charge')->nullable();
            $table->date('etd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_insurances');
    }
};
