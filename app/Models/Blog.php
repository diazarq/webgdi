<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'page_type', 'url', 'slug',
        'content', 'featured_img', 'jenis', 'kategori', 'status',
        'author', 'date_publish', 'hashtag', 'user_verify',
        'admin_notes', 'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
