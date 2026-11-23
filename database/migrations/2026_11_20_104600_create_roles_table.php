<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('slug', 100)->unique();
                $table->text('description')->nullable();
                $table->boolean('is_system')->default(false);
                $table->timestamps();
                $table->softDeletes();
            });

            // Seed 4 Role Utama Bawaan
            DB::table('roles')->insert([
                [
                    'name' => 'Superadmin',
                    'slug' => 'superadmin',
                    'description' => 'Akses penuh ke semua modul, manajemen user, role, privilege, dan pengaturan teknis yayasan.',
                    'is_system' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Admin (Pengurus)',
                    'slug' => 'admin',
                    'description' => 'Mengelola operasional harian: Blog, Program, Donasi Masuk, Zakat, dan Persetujuan Relawan/Mitra.',
                    'is_system' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Mitra',
                    'slug' => 'mitra',
                    'description' => 'Mitra penghimpun dana dan kolaborasi program LAZ dengan akses dashboard portal mitra.',
                    'is_system' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Volunteer (Relawan)',
                    'slug' => 'volunteer',
                    'description' => 'Relawan lapangan: menulis draft berita/kegiatan relawan dan mengikuti kegiatan program yayasan.',
                    'is_system' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        } else {
            Schema::table('roles', function (Blueprint $table) {
                if (!Schema::hasColumn('roles', 'deleted_at')) {
                    $table->softDeletes();
                }
                if (!Schema::hasColumn('roles', 'is_system')) {
                    $table->boolean('is_system')->default(false);
                }
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
        Schema::dropIfExists('roles');
    }
}
