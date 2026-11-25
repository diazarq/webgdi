<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddCategoryToFooterMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('footer_menus')) {
            if (!Schema::hasColumn('footer_menus', 'category')) {
                Schema::table('footer_menus', function (Blueprint $table) {
                    $table->string('category', 50)->default('quick_link')->after('url');
                });
            }

            // Insert default program links if not exists
            $hasProgram = DB::table('footer_menus')->where('category', 'program_link')->exists();
            if (!$hasProgram) {
                DB::table('footer_menus')->insert([
                    ['title' => 'Budaya', 'url' => '/budaya', 'category' => 'program_link', 'order' => 1, 'status' => 'A', 'created_at' => now(), 'updated_at' => now()],
                    ['title' => 'Cinta', 'url' => '/cinta', 'category' => 'program_link', 'order' => 2, 'status' => 'A', 'created_at' => now(), 'updated_at' => now()],
                    ['title' => 'Senyum', 'url' => '/senyum', 'category' => 'program_link', 'order' => 3, 'status' => 'A', 'created_at' => now(), 'updated_at' => now()],
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('footer_menus')) {
            if (Schema::hasColumn('footer_menus', 'category')) {
                Schema::table('footer_menus', function (Blueprint $table) {
                    $table->dropColumn('category');
                });
            }
        }
    }
}
