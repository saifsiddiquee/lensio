<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employee_monthly_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('salary_month'); // First day of the month
            $table->decimal('payable_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamps();

            // Unique constraint: one salary record per employee per month
            $table->unique(['employee_id', 'salary_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_monthly_salaries');
    }
};
