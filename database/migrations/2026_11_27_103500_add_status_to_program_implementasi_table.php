<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddStatusToProgramImplementasiTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('program_implementasi') && !Schema::hasColumn('program_implementasi', 'status')) {
            Schema::table('program_implementasi', function (Blueprint $table) {
                $table->string('status', 5)->default('A')->after('url_program');
            });
            DB::table('program_implementasi')->whereNull('status')->update(['status' => 'A']);
        }
    }

    public function down()
    {
        if (Schema::hasTable('program_implementasi') && Schema::hasColumn('program_implementasi', 'status')) {
            Schema::table('program_implementasi', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
}
