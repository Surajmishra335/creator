<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapedContent extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'headline', 'image_url'];
}
