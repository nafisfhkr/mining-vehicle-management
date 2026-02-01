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
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        $table->string('name'); 
        $table->enum('type', ['angkutan_orang', 'angkutan_barang']);
        $table->string('license_plate');
        $table->enum('ownership', ['company', 'rented']); 
        $table->double('fuel_consumption');
        $table->date('service_schedule')->nullable(); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
