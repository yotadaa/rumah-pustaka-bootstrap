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
        // Schema::table('files', function (Blueprint $table) {
        //     if (!Schema::hasColumn('files', 'score')) {
        //         $table->integer('score')->default(0);
        //     }
        //     if (!Schema::hasColumn('files', 'indikator_id')) {
        //         $table->uuid('indikator_id')->nullable();
        //     }
        // });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
