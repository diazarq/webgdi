<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerRegistration extends Model
{
    use HasFactory;

    protected $table = 'volunteer_registrations';

    protected $fillable = [
        'user_id',
        'volunteer_program_id',
        'name',
        'phone',
        'domisili',
        'skills',
        'notes',
        'status',
        'joined_group_at',
    ];

    protected $casts = [
        'joined_group_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function program()
    {
        return $this->belongsTo(VolunteerProgram::class, 'volunteer_program_id');
    }
}

