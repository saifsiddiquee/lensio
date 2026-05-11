<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['camera', 'lens', 'lighting', 'drone', 'audio', 'tripod', 'other'])->default('other');
            $table->enum('ownership_type', ['owned', 'rented'])->default('owned');
            $table->enum('status', ['available', 'assigned', 'maintenance'])->default('available');
            $table->decimal('purchase_cost', 10, 2)->nullable();
            $table->decimal('rental_cost_per_day', 10, 2)->nullable();
            $table->string('serial_number', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
