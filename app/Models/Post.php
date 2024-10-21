<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'external_post_id', // External ID from the JSONPlaceholder API
        'user_id',
        'title',
        'body',
    ];
}
