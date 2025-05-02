<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouse__invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ingredient');
            $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouse__invoices');
    }
};
