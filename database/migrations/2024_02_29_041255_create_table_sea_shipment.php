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
        Schema::create('tbl_sea_shipment', function (Blueprint $table) {
            $table->id('id_sea_shipment');
            $table->unsignedBigInteger('id_history')->nullable();
            $table->string('no_aju')->nullable();
            $table->string('no_inv')->nullable();
            $table->string('pricelist')->nullable();
            $table->string('bill_diff')->nullable();
            $table->date('date')->nullable();
            $table->date('etd')->nullable();
            $table->date('eta')->nullable();
            $table->integer('term')->nullable();
            $table->string('file_shipment_status')->nullable();
            $table->boolean('is_weight')->default(false);
            $table->string('value_key')->nullable()->unique();
            $table->boolean('is_printed')->default(false);
            $table->integer('printcount')->nullable();
            $table->timestamp('printdate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sea_shipment');
    }
};
