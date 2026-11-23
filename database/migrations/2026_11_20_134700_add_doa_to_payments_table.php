<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('payments', 'doa')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->text('doa')->nullable()->after('nominal');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('payments', 'doa')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('doa');
            });
        }
    }
};
