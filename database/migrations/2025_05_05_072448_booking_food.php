<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('boongking_foods', function (Blueprint $table) {
            $table->id();
            $table->integer('id_foods');
            $table->integer('quantity');
            $table->integer('id_booking');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        //
    }
};
