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
        Schema::create('tbl_histories', function (Blueprint $table) {
            $table->id('id_history');
            $table->unsignedBigInteger('id_changed_data');
            $table->string('scope');
            $table->longText('older_data')->nullable();
            $table->longText('changed_data')->nullable();
            $table->string('action');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('revcount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_histories');
    }
};
