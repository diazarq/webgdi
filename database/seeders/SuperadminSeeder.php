<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::firstOrNew(['username' => 'superadmin']);
        $superadmin->name            = 'Super Administrator';
        $superadmin->email           = 'superadmin@grahadhuafa.id';
        $superadmin->password        = Hash::make('admin123');
        $superadmin->role_type       = 'superadmin';
        $superadmin->level           = 99;
        $superadmin->status          = 'A';
        $superadmin->status_approval = 'approved';
        $superadmin->save();

        $this->command->info("Akun Superadmin siap digunakan! Username: superadmin | Password: admin123");
    }
}
