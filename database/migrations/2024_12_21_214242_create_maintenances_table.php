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
        // Create the maintenance table with the outstanding_balance column
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->string('expense_name');
            $table->decimal('cost', 10, 2);
            $table->decimal('outstanding_balance', 10, 2)->default(0); // Track outstanding balance
            $table->text('description')->nullable();
            $table->date('date')->default(now());
            $table->timestamps();
        });

        // Create the maintenance_payments table to track payments for maintenance
        Schema::create('maintenance_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_id')->constrained('maintenance')->onDelete('cascade'); // Links to maintenance
            $table->decimal('amount', 10, 2); // The payment amount
            $table->date('payment_date')->default(now()); // Payment date
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Drop the tables if rolling back
        Schema::dropIfExists('maintenance_payments');
        Schema::dropIfExists('maintenance');
    }
};
