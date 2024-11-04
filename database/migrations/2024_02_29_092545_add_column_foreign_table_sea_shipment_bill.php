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
        Schema::table('tbl_sea_shipment_bill', function (Blueprint $table) {
            $table->unsignedBigInteger('id_sea_shipment')->after('id_sea_shipment_bill');
            $table->foreign('id_sea_shipment')->references('id_sea_shipment')->on('tbl_sea_shipment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_sea_shipment_bill', function (Blueprint $table) {
            $table->dropForeign(['id_sea_shipment']);
            $table->dropColumn('id_sea_shipment');
        });
    }
};
