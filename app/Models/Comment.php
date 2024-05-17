<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'weight',
        'creation_date',
        'sub_comments',
        'supports',
    ];

    protected $casts = [
        'creation_date' => 'datetime',
        'sub_comments' => 'array',
        'supports' => 'array',
    ];
}
