<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'phone', 'password', 'status', 'level',
        'role_type', 'volunteer_type', 'organisasi', 'instansi', 'domisili',
        'status_approval', 'rejection_note', 'approved_at', 'last_login', 'profile_photo'
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    public function isApproved()
    {
        return $this->status_approval === 'approved';
    }

    public function isSuperAdmin()
    {
        return strtolower($this->role_type ?? '') === 'superadmin' || $this->level == 99;
    }

    public function isAdmin()
    {
        return strtolower($this->role_type ?? '') === 'admin' || $this->level == 1;
    }

    public function isVolunteer()
    {
        return strtolower($this->role_type ?? '') === 'volunteer' || $this->level == 2;
    }

    public function isAffiliate()
    {
        return in_array(strtolower($this->role_type ?? ''), ['affiliate', 'mitra']) || $this->level == 3;
    }

    public function isMitra()
    {
        return $this->isAffiliate();
    }

    public function hasRole($roles)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (is_string($roles)) {
            $roles = [$roles];
        }

        $userRole = strtolower($this->role_type ?? '');
        return in_array($userRole, array_map('strtolower', $roles));
    }

    /**
     * Cek apakah user memiliki izin akses terhadap suatu modul (berdasarkan tabel roles di database)
     */
    public function canAccess($module, $action = 'view')
    {
        // 1. Superadmin selalu memiliki akses penuh ke seluruh modul
        if ($this->isSuperAdmin()) {
            return true;
        }

        // 2. Ambil role user dari tabel roles di database
        $userRoleName = strtolower(trim($this->role_type ?? ''));
        $roleModel = Role::whereRaw('LOWER(name) = ?', [$userRoleName])->first();

        // 3. Jika role memiliki konfigurasi permissions di database, ikuti pengaturan database 100%!
        if ($roleModel && !empty($roleModel->permissions) && is_array($roleModel->permissions)) {
            return !empty($roleModel->permissions[$module][$action]);
        }

        // 4. Default fallback jika permissions role belum pernah disimpan di database
        if ($this->isAdmin()) {
            return !in_array($module, ['kelola_user', 'kelola_role', 'kelola_tema']);
        }
        if ($this->isVolunteer()) {
            return in_array($module, ['dashboard', 'blog']);
        }
        if ($this->isMitra()) {
            return in_array($module, ['dashboard', 'program', 'donasi']);
        }

        return false;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
