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
            $table->string('phoneNumber', 11)->unique(); 
            $table->string('mail')->nullable();
            $table->date('birth')->nullable();
            $table->string('password')->nullable();
            $table->string('FullName');
            $table->string('image')->nullable();
            $table->string('otp')->nullable();
            $table->integer('point')->default(0);
            $table->integer('id_rank')->default(value: 1);
            $table->boolean('isActive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
