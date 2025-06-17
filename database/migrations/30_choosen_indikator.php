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
        Schema::create('choosen_indikators', function (Blueprint $table) {
            $table->uuid("id");
            $table->string('option');
            $table->uuid(column: 'indikator_id');
            $table->uuid(column: 'berkas_id');
            $table->integer('score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('choosen_indikators');

    }
};
