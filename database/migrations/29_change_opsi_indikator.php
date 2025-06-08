<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('OpsiIndikators', function (Blueprint $table) {
            if (Schema::hasColumn('OpsiIndikators', 'choosen')) {
                $table->dropColumn('choosen');
                $table->boolean('choosen')->default(false);
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
