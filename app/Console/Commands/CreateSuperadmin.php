<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateSuperadmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:superadmin 
                            {username? : Username akun} 
                            {--email= : Email akun} 
                            {--password= : Password akun} 
                            {--promote : Jika ingin upgrade akun yang sudah ada}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat akun Superadmin baru atau meng-upgrade akun yang sudah ada menjadi Superadmin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("==========================================");
        $this->info("      PEMBUATAN AKUN SUPERADMIN GDI       ");
        $this->info("==========================================");

        $username = $this->argument('username') ?: $this->ask('Masukkan Username', 'superadmin');
        
        // Cari apakah user sudah ada
        $user = User::where('username', $username)->first();

        if ($user) {
            $this->warn("User dengan username '{$username}' sudah ditemukan di database!");
            
            if ($this->confirm("Apakah Anda ingin meng-upgrade user ini menjadi Superadmin?", true)) {
                $user->role_type = 'superadmin';
                $user->level = 99;
                $user->status = 'A';
                $user->status_approval = 'approved';

                if ($this->confirm("Apakah Anda ingin mereset password akun ini juga?", false)) {
                    $newPass = $this->secret('Masukkan Password Baru');
                    if ($newPass) {
                        $user->password = Hash::make($newPass);
                    }
                }

                $user->save();
                $this->info("✓ BERHASIL: User '{$username}' sekarang telah menjadi Superadmin!");
                $this->table(['ID', 'Nama', 'Username', 'Email', 'Role', 'Status'], [
                    [$user->id, $user->name, $user->username, $user->email, $user->role_type, $user->status]
                ]);
                return 0;
            }
        }

        // Jika membuat akun baru
        $name     = $this->ask('Nama Lengkap', 'Super Administrator');
        $email    = $this->option('email') ?: $this->ask('Email', 'superadmin@grahadhuafa.id');
        $password = $this->option('password') ?: $this->ask('Password', 'admin123');

        // Cek email duplikat
        $checkEmail = User::where('email', $email)->first();
        if ($checkEmail) {
            $this->error("Email '{$email}' sudah terdaftar pada user: {$checkEmail->username}");
            return 1;
        }

        $superadmin = User::create([
            'name'            => $name,
            'username'        => $username,
            'email'           => $email,
            'password'        => Hash::make($password),
            'role_type'       => 'superadmin',
            'level'           => 99,
            'status'          => 'A',
            'status_approval' => 'approved',
        ]);

        $this->info("✓ BERHASIL: Akun Superadmin baru telah dibuat!");
        $this->newLine();
        $this->table(['Data', 'Informasi Login'], [
            ['URL Login', url('/q/login')],
            ['Username', $superadmin->username],
            ['Email', $superadmin->email],
            ['Password', $password],
            ['Role', $superadmin->role_type],
            ['Status', 'Aktif'],
        ]);

        return 0;
    }
}
