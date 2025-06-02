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
        Schema::create('indikators', function (Blueprint $table) {
            $table->uuid();
            $table->integer('no');
            $table->string('name');
            $table->uuid(column: 'aspek_id');
            $table->uuid('komponen_id');
            $table->uuid('berkas_id');
            $table->boolean('multiple');
            $table->boolean('sub');
            $table->uuid('sub_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('indikators');

    }
};
