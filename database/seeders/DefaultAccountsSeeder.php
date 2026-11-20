<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultAccountsSeeder extends Seeder
{
    public function run()
    {
        // 1. Superadmin (Akses Penuh CMS)
        User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'name'            => 'Super Administrator',
                'email'           => 'superadmin@grahadhuafa.id',
                'password'        => Hash::make('admin123'),
                'level'           => 99,
                'role_type'       => 'superadmin',
                'status'          => 'A',
                'status_approval' => 'approved',
            ]
        );

        // 2. Admin Biasa (CMS Admin)
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name'            => 'Administrator',
                'email'           => 'admin@gmail.com',
                'password'        => Hash::make('admin'),
                'level'           => 1,
                'role_type'       => 'admin',
                'status'          => 'A',
                'status_approval' => 'approved',
            ]
        );

        // 3. Ocha (Admin Tambahan dari webgdi.sql)
        User::updateOrCreate(
            ['username' => 'ocha'],
            [
                'name'            => 'Ocha Iskandar',
                'email'           => 'ochaiskandar@gmail.com',
                'password'        => Hash::make('admin123'),
                'level'           => 1,
                'role_type'       => 'admin',
                'status'          => 'A',
                'status_approval' => 'approved',
            ]
        );

        // 4. Akun Relawan (Sahabat Baik) - Login di /z/login
        User::updateOrCreate(
            ['username' => 'relawan'],
            [
                'name'            => 'Relawan Sahabat Baik',
                'email'           => 'relawan@grahadhuafa.id',
                'phone'           => '081234567891',
                'password'        => Hash::make('relawan123'),
                'level'           => 2,
                'role_type'       => 'volunteer',
                'volunteer_type'  => 'Relawan Tanggap Bencana & Edukasi',
                'organisasi'      => 'Komunitas Sahabat Baik GDI',
                'domisili'        => 'Kota Bandung',
                'status'          => 'A',
                'status_approval' => 'approved',
            ]
        );

        // 5. Akun Mitra / Affiliate / Amil Zakat - Login di /z/login
        User::updateOrCreate(
            ['username' => 'mitra'],
            [
                'name'            => 'Mitra Amil Zakat',
                'email'           => 'mitra@grahadhuafa.id',
                'phone'           => '081234567892',
                'password'        => Hash::make('mitra123'),
                'level'           => 3,
                'role_type'       => 'affiliate',
                'instansi'        => 'Yayasan Peduli Umat',
                'organisasi'      => 'Mitra Amil GDI Jawa Barat',
                'domisili'        => 'Kota Bandung',
                'status'          => 'A',
                'status_approval' => 'approved',
            ]
        );
    }
}
