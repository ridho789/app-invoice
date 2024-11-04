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
        Schema::create('tbl_sea_shipment_line', function (Blueprint $table) {
            $table->id('id_sea_shipment_line');
            $table->unsignedBigInteger('id_history')->nullable();
            $table->date('date');
            $table->string('code')->nullable();
            $table->string('marking')->nullable();
            $table->string('qty_pkgs')->nullable();
            $table->string('qty_loose')->nullable();
            $table->string('weight')->nullable();
            $table->string('dimension_p')->nullable();
            $table->string('dimension_l')->nullable();
            $table->string('dimension_t')->nullable();
            $table->string('tot_cbm_1')->nullable();
            $table->string('tot_cbm_2')->nullable();
            $table->string('lts')->nullable();
            $table->string('qty')->nullable();
            $table->string('desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sea_shipment_line');
    }
};
