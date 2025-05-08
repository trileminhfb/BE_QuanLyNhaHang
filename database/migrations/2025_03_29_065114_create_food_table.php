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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('id_type');
            $table->string("image")->nullable();
            $table->integer('id_category');
            $table->integer('bestSeller')->default(0);
            $table->integer('cost');
            $table->string('detail');
            $table->integer('status');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
