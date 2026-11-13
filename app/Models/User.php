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
        'status_approval', 'rejection_note', 'approved_at', 'last_login'
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    public function isApproved()
    {
        return $this->status_approval === 'approved';
    }

    public function isVolunteer()
    {
        return $this->role_type === 'volunteer' || $this->level == 2;
    }

    public function isAffiliate()
    {
        return $this->role_type === 'affiliate' || $this->level == 3;
    }

    public function isAdmin()
    {
        return $this->role_type === 'admin' || $this->level == 1;
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
