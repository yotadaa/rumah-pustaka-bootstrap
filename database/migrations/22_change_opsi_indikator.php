<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('indikators', function (Blueprint $table) {
            $table->dropColumn(['sub']);
            if (!Schema::hasColumn('OpsiIndikators', 'choosen')) {
                $table->boolean('choosen')->nullable();
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
