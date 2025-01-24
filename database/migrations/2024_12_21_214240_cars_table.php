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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('plate_number')->unique();
            $table->string('model')->nullable();
            $table->string('route');
            $table->decimal('daily_hesabu_target', 10, 2);
            $table->foreignId('assigned_supervisor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('car_group_id')->nullable()->constrained('car_groups')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
