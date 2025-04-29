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
        //
        Schema::create('aspeks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('no');
            $table->uuid('komponen_id');
            $table->uuid('berkas_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('aspeks');

    }
};
