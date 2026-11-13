<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerProgram extends Model
{
    use HasFactory;

    protected $table = 'volunteer_programs';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'location',
        'start_date',
        'end_date',
        'quota',
        'status',
        'coordinator_name',
        'coordinator_phone',
        'whatsapp_group_link',
        'image',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function registrations()
    {
        return $this->hasMany(VolunteerRegistration::class, 'volunteer_program_id');
    }

    public function getRegisteredCountAttribute()
    {
        return $this->registrations()->count();
    }
}

