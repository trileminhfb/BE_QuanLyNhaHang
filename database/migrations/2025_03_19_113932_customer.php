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
        Schema::create("customers", function (Blueprint $table) {
            $table->id();
            $table->string("phoneNumber");
            $table->string("FullName");
            $table->string("image")->nullable();
            $table->string("otp")->nullable();
            $table->integer("point")->default(0);
            $table->integer("id_rank");
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
