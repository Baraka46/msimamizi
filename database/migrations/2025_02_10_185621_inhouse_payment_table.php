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
        Schema::create('inhouse_maintenance_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_id')->constrained('inhouse_maintenance')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('payment_date')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::dropIfExists('inhouse_maintenance_payments');
    }
};
