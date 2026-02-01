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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users'); 
        $table->foreignId('vehicle_id')->constrained('vehicles');
        $table->foreignId('driver_id')->constrained('drivers');
        
        
        $table->foreignId('approver_1_id')->constrained('users'); 
        $table->foreignId('approver_2_id')->constrained('users'); 
        
        $table->dateTime('start_date');
        $table->dateTime('end_date');
        
        // Status Berjenjang
        $table->enum('status', ['pending_lvl_1', 'pending_lvl_2', 'approved', 'rejected'])
              ->default('pending_lvl_1');
              
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
