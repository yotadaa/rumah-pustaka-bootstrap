<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // === FILES TABLE ===
        Schema::table('files', function (Blueprint $table) {
            $table->foreign('komponen_id')->references('id')->on('komponen');
            $table->foreign('berkas_id')->references('id')->on('berkas');
            $table->foreign('indikator_id')->references('id')->on('indikators');
        });

        // === ASPEK TABLE ===
        Schema::table('aspeks', function (Blueprint $table) {
            $table->foreign('komponen_id')->references('id')->on('komponen');
        });

        // === SUB_ASPEK TABLE ===
        Schema::table('sub_aspeks', function (Blueprint $table) {
            $table->foreign('aspek_id')->references('id')->on('aspek');
        });

        // === INDIKATOR TABLE ===
        Schema::table('indikators', function (Blueprint $table) {
            $table->foreign('sub_aspek_id')->references('id')->on('sub_aspek');
        });

        // === OPSI_INDIKATOR TABLE ===
        Schema::table('OpsiIndikators', function (Blueprint $table) {
            $table->foreign('indikator_id')->references('id')->on('indikators');
        });
    }

    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropForeign(['komponen_id']);
            $table->dropForeign(['berkas_id']);
            $table->dropForeign(['indikator_id']);
        });

        Schema::table('aspeks', function (Blueprint $table) {
            $table->dropForeign(['komponen_id']);
        });

        Schema::table('sub_aspeks', function (Blueprint $table) {
            $table->dropForeign(['aspek_id']);
        });

        Schema::table('indikators', function (Blueprint $table) {
            $table->dropForeign(['sub_aspek_id']);
        });

        Schema::table('opsi_indikator', function (Blueprint $table) {
            $table->dropForeign(['indikator_id']);
        });
    }
};
