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
        Schema::create('medical_devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('brand')->nullable();
            $table->unsignedBigInteger('type')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2)->default(0.00); 
            $table->text('description')->nullable(); 
            $table->timestamps();

            $table->foreign('type')->references('id')->on('device_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_devices');
    }
};
