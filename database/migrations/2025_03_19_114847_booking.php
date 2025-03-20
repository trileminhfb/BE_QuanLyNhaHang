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
        Schema::create("bookings", function (Blueprint $table) {
            $table->id();
            $table->integer("id_table");
            $table->dateTime("timeBooking");
            $table->integer("id_food");
            $table->integer("quantity");
            $table->integer("id_cutomer");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
