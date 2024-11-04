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
        Schema::create('tbl_customers', function (Blueprint $table) {
            $table->id('id_customer');
            $table->unsignedBigInteger('id_history')->nullable();
            $table->string('name');
            $table->string('discount')->nullable();
            $table->string('shipper_ids')->nullable();
            $table->string('bill_diff')->nullable();
            $table->string('inv_type')->nullable();
            $table->boolean('is_bill_weight')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_customers');
    }
};
