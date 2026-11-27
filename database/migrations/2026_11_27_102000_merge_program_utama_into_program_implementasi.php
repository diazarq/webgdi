<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MergeProgramUtamaIntoProgramImplementasi extends Migration
{
    public function up()
    {
        // 1. Tambah kolom slug di program_implementasi jika belum ada
        if (Schema::hasTable('program_implementasi') && !Schema::hasColumn('program_implementasi', 'slug')) {
            Schema::table('program_implementasi', function (Blueprint $table) {
                $table->string('slug', 150)->nullable()->after('nama_program');
            });
        }

        // 2. Pindahkan semua data dari program_utama ke program_implementasi
        if (Schema::hasTable('program_utama') && Schema::hasTable('program_implementasi')) {
            $utamaRows = DB::table('program_utama')->orderBy('id')->get();
            foreach ($utamaRows as $row) {
                $slug = $row->slug ?: Str::slug($row->nama_program);
                $exists = DB::table('program_implementasi')
                    ->where('slug', $slug)
                    ->orWhereRaw('LOWER(nama_program) = ?', [strtolower($row->nama_program)])
                    ->exists();

                if (!$exists) {
                    DB::table('program_implementasi')->insert([
                        'nama_program' => $row->nama_program,
                        'slug'         => $slug,
                        'logo_image'   => $row->logo_image,
                        'url_program'  => '/' . $slug,
                        'create_user'  => $row->create_user ?: 'Administrator',
                        'update_user'  => $row->update_user,
                        'create_date'  => $row->create_date ?: now(),
                        'update_date'  => $row->update_date,
                    ]);
                }
            }
        }

        // 3. Pastikan semua baris di program_implementasi punya slug
        if (Schema::hasTable('program_implementasi')) {
            foreach (DB::table('program_implementasi')->whereNull('slug')->get() as $row) {
                DB::table('program_implementasi')
                    ->where('id', $row->id)
                    ->update(['slug' => Str::slug($row->nama_program)]);
            }

            // Jika masih kosong total, masukkan 3 program default
            if (DB::table('program_implementasi')->count() === 0) {
                $defaults = [
                    ['nama_program' => 'Budaya', 'slug' => 'budaya', 'logo_image' => 'website/assets/images/custom/budaya.png', 'url_program' => '/budaya'],
                    ['nama_program' => 'Cinta',  'slug' => 'cinta',  'logo_image' => 'website/assets/images/custom/cinta.png',  'url_program' => '/cinta'],
                    ['nama_program' => 'Senyum', 'slug' => 'senyum', 'logo_image' => 'website/assets/images/custom/senyum.png', 'url_program' => '/senyum'],
                ];
                foreach ($defaults as $d) {
                    DB::table('program_implementasi')->insert(array_merge($d, [
                        'create_user' => 'Administrator',
                        'create_date' => now(),
                    ]));
                }
            }

            // 4. Sinkronkan program_implementasi_id di tabel konten program
            $slugToId = DB::table('program_implementasi')->pluck('id', 'slug')->toArray();
            $contentTables = [
                'program_dokumentasi' => 'program',
                'program_statistik'   => 'program',
                'program_faq'         => 'program',
                'program_manfaat'     => 'program',
                'program_galeri'      => 'program',
                'program_landing'     => 'slug',
            ];
            foreach ($contentTables as $tbl => $col) {
                if (Schema::hasTable($tbl) && Schema::hasColumn($tbl, 'program_implementasi_id') && Schema::hasColumn($tbl, $col)) {
                    foreach ($slugToId as $slug => $pid) {
                        DB::table($tbl)
                            ->where($col, $slug)
                            ->whereNull('program_implementasi_id')
                            ->update(['program_implementasi_id' => $pid]);
                    }
                }
            }
        }

        // 5. Hapus tabel program_utama karena sudah digabung ke program_implementasi
        Schema::dropIfExists('program_utama');
    }

    public function down()
    {
        if (!Schema::hasTable('program_utama')) {
            Schema::create('program_utama', function (Blueprint $table) {
                $table->id();
                $table->string('nama_program', 150);
                $table->string('slug', 150)->unique();
                $table->string('logo_image', 255)->nullable();
                $table->string('create_user', 100)->nullable();
                $table->string('update_user', 100)->nullable();
                $table->timestamp('create_date')->nullable();
                $table->timestamp('update_date')->nullable();
            });
        }
    }
}
