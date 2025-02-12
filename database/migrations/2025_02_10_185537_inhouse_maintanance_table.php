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
        Schema::create('inhouse_maintenance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->decimal('total_cost', 10, 2);
            $table->decimal('outstanding_balance', 10, 2)->default(0);
            $table->date('date')->default(now());
            $table->timestamps();
        });

        // Create the inhouse_maintenance_payments table
       
    }

    public function down(): void
    {
      
        Schema::dropIfExists('inhouse_maintenance');
    }
};
