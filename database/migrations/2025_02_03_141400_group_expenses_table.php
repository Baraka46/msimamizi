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
        Schema::create('group_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_group_id')->constrained('car_groups')->onDelete('cascade');
            $table->string('name'); // E.g., "January Contributions"
            $table->decimal('amount', 10, 2); // E.g., 100000.00
            $table->date('start_date'); // Start of the timeframe
            $table->integer('collection_interval')->default(7); // End of the timeframe
            $table->timestamps();
        });
           //
           Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_expense_id')->constrained('group_expenses')->onDelete('cascade');
            $table->decimal('amount', 10, 2); // Amount contributed
            $table->date('intended_collection_date')->nullable(); // Scheduled date (optional if computed)
            $table->date('actual_collection_date'); // Actual date the money was given
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
