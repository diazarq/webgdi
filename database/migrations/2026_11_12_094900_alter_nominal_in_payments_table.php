<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::statement("ALTER TABLE payments MODIFY nominal DECIMAL(20, 2) NULL");
        } catch (\Throwable $e) {
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement("ALTER TABLE payments MODIFY nominal FLOAT(10, 2) NULL");
        } catch (\Throwable $e) {
        }
    }
};

