<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('indikators', function (Blueprint $table) {
            // Drop columns you no longer need
            $table->dropColumn(['name', 'komponen_id', 'berkas_id']);

            // Add or modify only the required columns if not present
            if (!Schema::hasColumn('indikators', 'content')) {
                $table->text('content')->nullable();
            }

            if (!Schema::hasColumn('indikators', 'sub_aspek_id')) {
                $table->uuid('sub_aspek_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('indikators', function (Blueprint $table) {
            // Reverse the changes
            $table->string('name')->nullable();
            $table->uuid('komponen_id')->nullable();
            $table->uuid('berkas_id')->nullable();

            $table->dropColumn(['content', 'sub_aspek_id']);
        });
    }
};
