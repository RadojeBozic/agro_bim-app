<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('superadmin', 'admin', 'autor', 'korisnik') NOT NULL DEFAULT 'korisnik'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('user') NOT NULL DEFAULT 'user'");
    }
};
