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
        Schema::create('sale_report_foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sale_report')->constrained('sale_reports')->onDelete('cascade'); // Khóa ngoại và cascade
            $table->foreignId('id_food')->constrained('foods')->onDelete('cascade'); // Khóa ngoại và cascade
            $table->integer('quantity');
            $table->decimal('total_price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_report_foods');
    }
};
