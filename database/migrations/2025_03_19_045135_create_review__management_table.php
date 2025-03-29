<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review__management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_rate')->constrained('rate')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('user')->onDelete('cascade');
            $table->text('comment');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review__management');
    }
};
