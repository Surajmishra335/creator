<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramChannel extends Model
{
    use HasFactory;
    protected $table = 'youtube_channels';
    protected $fillable = ['creator_id','profile_url', 'subscribers'];
}

