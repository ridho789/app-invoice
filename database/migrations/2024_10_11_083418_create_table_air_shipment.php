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
        Schema::create('tbl_air_shipment', function (Blueprint $table) {
            $table->id('id_air_shipment');

            $table->unsignedBigInteger('id_shipper')->nullable();
            $table->foreign('id_shipper')->references('id_shipper')->on('tbl_shippers');

            $table->unsignedBigInteger('id_customer')->nullable();
            $table->foreign('id_customer')->references('id_customer')->on('tbl_customers');

            $table->unsignedBigInteger('id_history')->nullable();
            $table->string('no_inv')->nullable();

            $table->unsignedBigInteger('id_origin')->nullable();
            $table->foreign('id_origin')->references('id_origin')->on('tbl_origins');

            $table->string('vessel_sin')->nullable();
            $table->date('date')->nullable();
            $table->date('bl')->nullable();
            $table->string('pricelist')->nullable();
            $table->integer('term')->nullable();
            $table->string('file_shipment_status')->nullable();
            $table->boolean('is_printed')->default(false);
            $table->integer('printcount')->nullable();
            $table->timestamp('printdate')->nullable();
            $table->string('value_key')->nullable()->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_air_shipment');
    }
};
