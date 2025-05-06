<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("ranks", function (Blueprint $table) {
            $table->id();
            $table->string("nameRank")->unique();
            $table->integer("necessaryPoint");
            $table->integer("saleRank");
            $table->string("image")->nullable(); // Thêm dòng này
            $table->timestamps();
        });
    }    
    public function down(): void
    {
        Schema::dropIfExists("ranks"); // Thêm dòng này để có thể rollback
    }
};
