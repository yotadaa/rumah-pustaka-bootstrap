<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('indikators', function (Blueprint $table) {
            // Drop columns you no longer need
            if (Schema::hasColumn('sub', 'sub_aspek_id')) {

                $table->dropColumn(['sub']);
            }

        });
    }

    public function down(): void
    {
    }
};
