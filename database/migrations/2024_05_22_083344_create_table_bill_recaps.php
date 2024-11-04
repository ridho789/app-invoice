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
        Schema::create('tbl_bill_recaps', function (Blueprint $table) {
            $table->id('id_bill_recap');
            $table->string('inv_no');
            $table->string('freight_type');
            $table->string('size');
            $table->string('unit_price');
            $table->string('amount');
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
        Schema::dropIfExists('tbl_bill_recaps');
    }
};
