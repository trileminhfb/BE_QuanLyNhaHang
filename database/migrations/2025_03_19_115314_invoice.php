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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('id_table');
            $table->dateTime('timeEnd');
            $table->integer('total');
            $table->integer('id_user')->nullable();
            $table->integer('id_customer')->nullable();
            $table->integer('id_sale')->nullable();
            $table->integer('status')->default(1); // Add the status column with default value 1
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
