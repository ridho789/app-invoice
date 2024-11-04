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
        Schema::create('tbl_air_bill_recaps', function (Blueprint $table) {
            $table->id('id_air_bill_recap');

            $table->unsignedBigInteger('id_air_shipment')->nullable();
            $table->foreign('id_air_shipment')->references('id_air_shipment')->on('tbl_air_shipment');
            
            $table->string('inv_no');
            $table->string('freight_type');
            $table->string('size')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('amount')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('remaining_bill')->nullable();
            $table->date('overdue_bill')->nullable();            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_air_bill_recaps');
    }
};

