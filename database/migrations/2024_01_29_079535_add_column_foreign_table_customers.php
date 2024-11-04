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
        Schema::table('tbl_customers', function (Blueprint $table) {
            $table->unsignedBigInteger('id_company')->nullable()->after('id_customer');
            $table->foreign('id_company')->references('id_company')->on('tbl_companies');

            $table->unsignedBigInteger('id_banker')->nullable()->after('id_company');
            $table->foreign('id_banker')->references('id_banker')->on('tbl_bankers');

            $table->unsignedBigInteger('id_account')->nullable()->after('id_banker');
            $table->foreign('id_account')->references('id_account')->on('tbl_accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_customers', function (Blueprint $table) {
            $table->dropForeign(['id_company']);
            $table->dropColumn('id_company');

            $table->dropForeign(['id_banker']);
            $table->dropColumn('id_banker');

            $table->dropForeign(['id_account']);
            $table->dropColumn('id_account');
        });
    }
};
