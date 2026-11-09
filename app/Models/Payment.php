<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'transcode',
        'name',
        'pronoun',
        'anonim',
        'notelp',
        'email',
        'nominal',
        'payment_method',
        'bank_type',
        'bank_id',
        'digit',
        'status',
        'snap_token',
        'exp_at',
        'deleted_at'
    ];
}
