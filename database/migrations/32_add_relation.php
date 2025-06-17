<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('choosen_indikators', function (Blueprint $table) {
            $table->foreign('berkas_id')->references('id')->on('berkas')->onDelete('cascade');
            $table->foreign('indikator_id')->references('id')->on('indikators')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('choosen_indikators', function (Blueprint $table) {
            $table->dropForeign(['komponen_id']);
            $table->dropForeign(['berkas_id']);
        });
    }
};
