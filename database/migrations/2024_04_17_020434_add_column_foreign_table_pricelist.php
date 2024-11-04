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
        Schema::table('tbl_pricelists', function (Blueprint $table) {
            $table->unsignedBigInteger('id_shipper')->nullable()->after('id_pricelist');
            $table->foreign('id_shipper')->references('id_shipper')->on('tbl_shippers');

            $table->unsignedBigInteger('id_customer')->nullable()->after('id_shipper');
            $table->foreign('id_customer')->references('id_customer')->on('tbl_customers');

            $table->unsignedBigInteger('id_origin')->nullable()->after('id_customer');
            $table->foreign('id_origin')->references('id_origin')->on('tbl_origins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_pricelists', function (Blueprint $table) {
            $table->dropForeign(['id_shipper']);
            $table->dropColumn('id_shipper');

            $table->dropForeign(['id_customer']);
            $table->dropColumn('id_customer');
        });
    }
};
