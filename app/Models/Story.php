<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'category',
        'pdf_link',
        'description',
        'published_year',
        'thumbnail',
    ];
}
