<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin','manager','sales','photographer','editor'))");
        } else {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','manager','sales','photographer','editor') NOT NULL");
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement("UPDATE users SET role = 'sales' WHERE role = 'manager'");
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin','sales','photographer','editor'))");
        } else {
            DB::statement("UPDATE users SET role = 'sales' WHERE role = 'manager'");
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','sales','photographer','editor') NOT NULL");
        }
    }
};
