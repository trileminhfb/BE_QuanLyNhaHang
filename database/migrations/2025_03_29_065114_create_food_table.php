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
            $table->string('name');
            $table->unsignedBigInteger('id_type');
            $table->unsignedBigInteger('id_category');
            $table->integer('bestSeller')->default(0);
            $table->integer('cost');
            $table->string('detail');
            $table->integer('status');
            $table->timestamps();

            // Thêm khóa ngoại
            $table->foreign('id_type')->references('id')->on('types')->onDelete('cascade');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }

};
