<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('indikators', function (Blueprint $table) {
            if (!Schema::hasColumn('indikators', 'choosen')) {
                $table->dropColumn('chooscolumn: en');
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('OpsiIndikators');

    }
};
