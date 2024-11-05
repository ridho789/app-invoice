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
        Schema::create('tbl_air_shipment_line', function (Blueprint $table) {
            $table->id('id_air_shipment_line');
            $table->unsignedBigInteger('id_history')->nullable();

            $table->unsignedBigInteger('id_air_shipment')->nullable();
            $table->foreign('id_air_shipment')->references('id_air_shipment')->on('tbl_air_shipment');

            $table->unsignedBigInteger('id_unit')->nullable();
            $table->foreign('id_unit')->references('id_unit')->on('tbl_units');

            $table->string('marking')->nullable();
            $table->string('koli')->nullable();
            $table->string('ctn')->nullable();
            $table->string('kg')->nullable();
            $table->string('qty')->nullable();
            $table->string('note')->nullable();
                        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_air_shipment_line');
    }
};
