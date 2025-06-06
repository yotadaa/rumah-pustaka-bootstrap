<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('indikators', function (Blueprint $table) {
            // Drop columns you no longer need
            if (Schema::hasColumn('sub_aspek_id', 'sub_aspek_id')) {
                $table->uuid('sub_aspek_id')->nullable(); // make new migration to change this to nullable
            }

        });
    }

    public function down(): void
    {
    }
};
