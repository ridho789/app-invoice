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
        Schema::create('tbl_sea_shipment_other_bill', function (Blueprint $table) {
            $table->id('id_sea_shipment_other_bill');
            $table->unsignedBigInteger('id_history')->nullable();
            $table->date('date')->nullable();
            $table->string('charge')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sea_shipment_other_bill');
    }
};
