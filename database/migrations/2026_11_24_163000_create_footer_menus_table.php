<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFooterMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('footer_menus')) {
            Schema::create('footer_menus', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('url');
                $table->integer('order')->default(0);
                $table->enum('status', ['A', 'NA'])->default('A');
                $table->timestamps();
            });

            // Insert initial default links
            DB::table('footer_menus')->insert([
                ['title' => 'Beranda', 'url' => '/', 'order' => 1, 'status' => 'A', 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'Tentang Zakat', 'url' => '/tentang-zakat', 'order' => 2, 'status' => 'A', 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'Kalkulator Zakat', 'url' => '/kalkulator-zakat', 'order' => 3, 'status' => 'A', 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'Zakat Online', 'url' => '/zakat-online', 'order' => 4, 'status' => 'A', 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'Berita & Artikel', 'url' => '/blog', 'order' => 5, 'status' => 'A', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('footer_menus');
    }
}
