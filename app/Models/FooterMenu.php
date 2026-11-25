<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterMenu extends Model
{
    use HasFactory;

    protected $table = 'footer_menus';

    protected $fillable = [
        'title',
        'url',
        'category',
        'order',
        'status',
    ];
}
