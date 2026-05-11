<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('equipment_event', function (Blueprint $table) {
            // Add assigned_to for tracking which employee has the equipment
            $table->foreignId('assigned_to')->nullable()->after('event_id')
                ->constrained('employees')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('equipment_event', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn('assigned_to');
        });
    }
};
