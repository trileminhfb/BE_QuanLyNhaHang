<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_foods', function (Blueprint $table) {
            $table->id();
            $table->integer('id_category');
            $table->integer('id_food');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_foods');
    }
};
