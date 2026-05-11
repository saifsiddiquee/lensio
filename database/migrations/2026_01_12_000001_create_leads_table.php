<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 50);
            $table->string('email', 150)->nullable();
            $table->string('event_type', 100);
            $table->date('event_date')->nullable();
            $table->string('source', 100);
            $table->enum('status', ['new', 'contacted', 'quoted', 'booked', 'lost']);
            $table->foreignId('assigned_to')->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
