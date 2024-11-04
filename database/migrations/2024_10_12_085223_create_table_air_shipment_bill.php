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
        Schema::create('tbl_air_shipment_bill', function (Blueprint $table) {
            $table->id('id_air_shipment_bill');

            $table->unsignedBigInteger('id_air_shipment')->nullable();
            $table->foreign('id_air_shipment')->references('id_air_shipment')->on('tbl_air_shipment');
            
            $table->unsignedBigInteger('id_history')->nullable();
            $table->date('date')->nullable();
            $table->string('code')->nullable();
            $table->string('transport')->nullable();
            $table->string('bl')->nullable();
            $table->string('permit')->nullable();
            $table->string('insurance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_air_shipment_bill');
    }
};

