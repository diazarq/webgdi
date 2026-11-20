<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'description',
        'is_system',
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    /**
     * Helper menghitung jumlah user yang menggunakan role ini
     */
    public function getUserCountAttribute()
    {
        $name = strtolower($this->name);
        
        if (str_contains($name, 'superadmin')) {
            return User::where('role_type', 'like', '%superadmin%')->orWhere('level', 99)->count();
        }
        if (str_contains($name, 'admin')) {
            return User::where('role_type', 'like', '%admin%')->orWhere('level', 1)->count();
        }
        if (str_contains($name, 'mitra') || str_contains($name, 'affiliate')) {
            return User::whereIn('role_type', ['mitra', 'affiliate'])->orWhere('level', 3)->count();
        }
        if (str_contains($name, 'volunteer') || str_contains($name, 'relawan')) {
            return User::where('role_type', 'like', '%volunteer%')->orWhere('level', 2)->count();
        }

        return User::where('role_type', $this->name)->orWhere('role_type', strtolower($this->name))->count();
    }
}
