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
        Schema::dropIfExists('volunteer_registrations');
        Schema::dropIfExists('volunteer_programs');

        Schema::create('volunteer_programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // 'Tanggap Bencana', 'Berbagi', 'Pendidikan', 'Media'
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('quota')->default(50);
            $table->string('status', 20)->default('open'); // 'open', 'ongoing', 'closed'
            $table->string('coordinator_name')->nullable();
            $table->string('coordinator_phone')->nullable();
            $table->string('whatsapp_group_link')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('volunteer_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('volunteer_program_id')->index();
            $table->string('name');
            $table->string('phone');
            $table->string('domisili')->nullable();
            $table->string('skills')->nullable(); // Medis, Dapur Umum, Logistik, Lapangan, dll.
            $table->text('notes')->nullable();
            $table->string('status', 30)->default('terdaftar'); // 'terdaftar', 'bergabung_grup', 'aktif', 'selesai'
            $table->timestamp('joined_group_at')->nullable();
            $table->timestamps();
        });

        // Seed data awal Program Relawan (Tanggap Bencana & Berbagi sesuai diagram)
        DB::table('volunteer_programs')->insert([
            [
                'title'               => 'Relawan Tanggap Bencana & Evakuasi Lapangan',
                'slug'                => 'relawan-tanggap-bencana-evakuasi-lapangan',
                'category'            => 'Tanggap Bencana',
                'description'         => 'Aksi siaga respon darurat bencana alam, bantuan evakuasi, penyaluran logistik darurat, dan pendirian tenda dapur umum bagi para penyintas.',
                'location'            => 'Jawa Barat & Wilayah Bencana',
                'start_date'          => now()->toDateString(),
                'end_date'            => now()->addMonths(2)->toDateString(),
                'quota'               => 50,
                'status'              => 'open',
                'coordinator_name'    => 'Kang Ridwan (Koordinator Tanggap Bencana GDI)',
                'coordinator_phone'   => '6282119998877',
                'whatsapp_group_link' => 'https://chat.whatsapp.com/invite/relawan-tanggap-bencana-gdi',
                'image'               => 'website/assets/images/resources/program-detail-img-1.jpg',
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'title'               => 'Aksi Berbagi Pangan & Sedekah Sembako Dhuafa',
                'slug'                => 'aksi-berbagi-pangan-sedekah-sembako-dhuafa',
                'category'            => 'Berbagi',
                'description'         => 'Program distribusi paket pangan pokok, makanan siap saji, dan santunan untuk keluarga dhuafa, lansia sebatang kara, serta anak-anak yatim.',
                'location'            => 'Bandung Raya & Sekitarnya',
                'start_date'          => now()->toDateString(),
                'end_date'            => now()->addMonths(3)->toDateString(),
                'quota'               => 40,
                'status'              => 'open',
                'coordinator_name'    => 'Teh Sarah (Koordinator Program Berbagi GDI)',
                'coordinator_phone'   => '6281223334455',
                'whatsapp_group_link' => 'https://chat.whatsapp.com/invite/relawan-berbagi-pangan-gdi',
                'image'               => 'website/assets/images/resources/program-detail-img-2.jpg',
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'title'               => 'Dapur Umum Berkah & Gizi Generasi Pelanjut',
                'slug'                => 'dapur-umum-berkah-gizi-generasi-pelanjut',
                'category'            => 'Berbagi',
                'description'         => 'Pengolahan dan penyaluran makanan sehat bernutrisi untuk santri penghafal Quran dan adik-adik yatim di pelosok desa.',
                'location'            => 'Wilayah Pelosok Jawa Barat',
                'start_date'          => now()->toDateString(),
                'end_date'            => now()->addMonths(1)->toDateString(),
                'quota'               => 30,
                'status'              => 'open',
                'coordinator_name'    => 'Ustadz Ahmad (Koordinator Gizi & Dapur GDI)',
                'coordinator_phone'   => '6285711223344',
                'whatsapp_group_link' => 'https://chat.whatsapp.com/invite/relawan-dapur-berkah-gdi',
                'image'               => 'website/assets/images/resources/program-detail-img-3.jpg',
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_registrations');
        Schema::dropIfExists('volunteer_programs');
    }
};
