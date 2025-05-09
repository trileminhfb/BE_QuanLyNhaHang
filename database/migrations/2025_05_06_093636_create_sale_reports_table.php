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

        Schema::create('sale_report', function (Blueprint $table) {
            $table->id();
            $table->string('report_type');
            $table->date('report_date');
            $table->decimal('total_revenue', 15, 2);
            $table->integer('total_orders');
            $table->string('top_food_name')->nullable();
            $table->integer('top_food_quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_reports');
    }
};
